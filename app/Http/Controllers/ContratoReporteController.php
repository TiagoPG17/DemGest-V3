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
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $sort = $request->input('sort', 'fecha_corte');
        $direction = $request->input('direction', 'asc');

        // Si no hay fechas de filtro, mostrar página vacía con mensaje
        if (!$fechaInicio || !$fechaFin) {
            return view('contratos.index', [
                'empleados' => collect(),
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'sort' => $sort,
                'direction' => $direction,
                'mensaje' => 'Por favor selecciona un rango de fechas para ver el reporte.'
            ]);
        }

        // Optimización: Solo actualizar prórrogas si es necesario (cada 6 horas)
        $this->actualizarProrrogasSiEsNecesario();
        
        // Consulta optimizada - filtrar en la base de datos primero
        $query = Empleado::with(['informacionLaboralActual.estadoCargo.cargo', 'empresa'])
            ->whereHas('informacionLaboralActual', function($query) {
                $query->whereNull('fecha_salida'); // Solo empleados activos
            });

        // Obtener todos los empleados activos (pero con paginación si son muchos)
        $todosEmpleados = $query->get();
        
        // Filtrar en memoria solo los que cumplen con el rango de fechas
        $empleadosFiltrados = $todosEmpleados->filter(function ($empleado) use ($fechaInicio, $fechaFin) {
            $estado = $empleado->informacionLaboralActual;
            if (!$estado || !$estado->fecha_ingreso) return false;

            $datos = app(ProrrogaService::class)->calcularDesdeIngreso(
                $estado->fecha_ingreso,
                $estado->fecha_salida
            );

            $fechaLimitePreaviso = $datos['fecha_prorroga'];
            $hoy = Carbon::now()->startOfDay();
            
            return $fechaLimitePreaviso >= $fechaInicio &&
                   $fechaLimitePreaviso <= $fechaFin &&
                   $fechaLimitePreaviso >= $hoy->subDays(7);
        })
        ->map(function ($empleado) {
            $info = $empleado->informacionLaboralActual;
            if ($info && $info->fecha_ingreso) {
                $datos = app(ProrrogaService::class)->calcularDesdeIngreso($info->fecha_ingreso, $info->fecha_salida);
                $empleado->fecha_corte = $datos['fecha_prorroga'];
            }
            return $empleado;
        });

        // Ordenar los resultados
        $empleados = $empleadosFiltrados->sortBy(function ($empleado) use ($sort) {
            return $sort === 'nombre' ? $empleado->nombre_completo : $empleado->fecha_corte;
        }, SORT_REGULAR, $direction === 'desc');

        return view('contratos.index', [
            'empleados' => $empleados,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
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

                $fechaLimitePreaviso = $datos['fecha_prorroga']; // ? Fecha límite para enviar preaviso
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
     * Actualiza las fechas de prórroga solo si es necesario (cada 6 horas)
     * Esto evita recalcular en cada carga de página
     */
    private function actualizarProrrogasSiEsNecesario()
    {
        $cacheKey = 'ultima_actualizacion_prorrogas';
        $ultimaActualizacion = cache()->get($cacheKey);
        
        // Solo actualizar si han pasado más de 6 horas desde la última actualización
        if (!$ultimaActualizacion || $ultimaActualizacion < now()->subHours(6)) {
            $prorrogaService = app(ProrrogaService::class);
            
            // Procesar en lotes para evitar sobrecargar la memoria
            Empleado::with(['informacionLaboralActual'])
                ->whereHas('informacionLaboralActual', function($query) {
                    $query->whereNull('fecha_salida');
                })
                ->chunk(100, function ($empleadosChunk) use ($prorrogaService) {
                    foreach ($empleadosChunk as $empleado) {
                        $infoLaboral = $empleado->informacionLaboralActual;
                        
                        if ($infoLaboral && $infoLaboral->fecha_ingreso) {
                            try {
                                $prorrogaService->calcular($infoLaboral);
                            } catch (\Exception $e) {
                                // Continuar silenciosamente
                            }
                        }
                    }
                });
            
            // Guardar la hora de la última actualización
            cache()->put($cacheKey, now(), now()->addHours(6));
        }
    }

}
