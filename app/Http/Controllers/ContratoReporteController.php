<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InformacionLaboral;
use App\Services\ProrrogaService;
use App\Models\Estado;
use Carbon\Carbon;

class ContratoReporteController extends Controller
{
  public function index(Request $request)
    {
        // Actualizar fechas de prórroga automáticamente antes de mostrar el reporte
        $this->actualizarProrrogasAutomaticamente();
        
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $sort = $request->input('sort', 'fecha_corte');
        $direction = $request->input('direction', 'asc');

        $empleados = Empleado::with(['informacionLaboral.estadoCargo', 'empresa'])
            ->whereHas('informacionLaboralActual', function($query) {
                // Filtra por empleados que no tienen fecha de salida (activos)
                $query->whereNull('fecha_salida');
            })
            ->get()
            ->filter(function ($empleado) use ($fechaInicio, $fechaFin) {
                $estado = $empleado->informacionLaboralActual;
                if (!$estado) return false;

                $datos = app(ProrrogaService::class)->calcularDesdeIngreso(
                    $estado->fecha_ingreso,
                    $estado->fecha_salida
                );

                $fechaLimitePreaviso = $datos['fecha_prorroga']; // ✅ Fecha límite para enviar preaviso
                $hoy = Carbon::now()->startOfDay();
                
                // Solo mostrar si la fecha límite está en el rango Y es relevante (futura o recientemente vencida)
                return $fechaInicio && $fechaFin &&
                    $fechaLimitePreaviso >= $fechaInicio &&
                    $fechaLimitePreaviso <= $fechaFin &&
                    $fechaLimitePreaviso >= $hoy->subDays(7); // Permitir hasta 7 días después de vencido
            })
            ->map(function ($empleado) {
                $info = $empleado->informacionLaboralActual;
                $datos = app(ProrrogaService::class)->calcularDesdeIngreso($info?->fecha_ingreso, $info?->fecha_salida);
                $empleado->fecha_corte = $datos['fecha_prorroga']; // ✅ Mostrar fecha límite preaviso
                return $empleado;
            })
            ->sortBy(function ($empleado) use ($sort) {
                return $sort === 'nombre' ? $empleado->nombre_completo : $empleado->fecha_corte;
            }, SORT_REGULAR, $direction === 'desc');

        return view('contratos.index', [
            'empleados' => $empleados,
            'fechaInicio' => $fechaInicio,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function generarPDF(Request $request)
    {
        $prorrogaService = app(ProrrogaService::class);
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin    = $request->input('fecha_fin');
        
        // Log para depuración - verificar que los filtros se están recibiendo correctamente
        \Log::info('Generando PDF con filtros:', [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'todos_los_parametros' => $request->all()
        ]);

        $empleados = Empleado::with(['informacionLaboralActual.estadoCargo.cargo', 'empresa'])
            ->whereHas('informacionLaboralActual', function ($q) {
                $q->where('tipo_contrato', 'Fijo');
            })
            ->get()
            ->filter(function ($empleado) use ($prorrogaService, $fechaInicio, $fechaFin) {
                $estado = $empleado->informacionLaboralActual;
                if (!$estado) return false;

                $datos = $prorrogaService
                    ->calcularDesdeIngreso($estado->fecha_ingreso, $estado->fecha_salida);

                $fechaLimitePreaviso = $datos['fecha_prorroga']; // ✅ Fecha límite para enviar preaviso
                $hoy = Carbon::now()->startOfDay();
                
                // Solo mostrar si la fecha límite está en el rango Y es relevante (futura o recientemente vencida)
                return $fechaInicio && $fechaFin &&
                    $fechaLimitePreaviso >= $fechaInicio &&
                    $fechaLimitePreaviso <= $fechaFin &&
                    $fechaLimitePreaviso >= $hoy->subDays(7); // Permitir hasta 7 días después de vencido
            });

        $logoPath = public_path('images/logo_formacol.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return Pdf::loadView('contratos.pdf', [
            'empleados' => $empleados,
            'logoBase64' => $logoBase64,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ])->setPaper('a4')->download('cartas_no_prorroga.pdf');
    }

    /**
     * Actualiza las fechas de prórroga para todos los empleados activos
     * Esto asegura que los datos del reporte siempre estén actualizados
     */
    private function actualizarProrrogasAutomaticamente()
    {
        $prorrogaService = app(ProrrogaService::class);
        
        $empleados = Empleado::with(['informacionLaboralActual'])
            ->whereHas('informacionLaboralActual', function($query) {
                $query->whereNull('fecha_salida'); // Solo empleados activos
            })
            ->get();

        foreach ($empleados as $empleado) {
            $infoLaboral = $empleado->informacionLaboralActual;
            
            if ($infoLaboral && $infoLaboral->fecha_ingreso) {
                try {
                    $prorrogaService->calcular($infoLaboral);
                } catch (\Exception $e) {
                    // Silenciosamente continuar si hay error con un empleado
                    // Puedes agregar logging aquí si lo necesitas
                }
            }
        }
    }

}
