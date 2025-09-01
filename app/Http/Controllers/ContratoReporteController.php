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

        $empleados = Empleado::with(['informacionLaboral.estadoCargo', 'empresa'])
            ->whereHas('informacionLaboralActual', function($query) {
                // Filtra por empleados que no tienen fecha de salida (activos)
                $query->whereNull('fecha_salida');
            })
            ->get()
            ->filter(function ($empleado) use ($fechaInicio, $fechaFin) {
                $estado = $empleado->informacionLaboralActual;
                if (!$estado) return false;

                $fechaProrroga = app(ProrrogaService::class)->calcularDesdeIngreso(
                    $estado->fecha_ingreso,
                    $estado->fecha_salida
                )['fecha_prorroga'];

                return $fechaInicio && $fechaFin &&
                    $fechaProrroga >= $fechaInicio &&
                    $fechaProrroga <= $fechaFin;
            })
            ->map(function ($empleado) {
                $info = $empleado->informacionLaboralActual;
                $datos = app(ProrrogaService::class)->calcularDesdeIngreso($info?->fecha_ingreso, $info?->fecha_salida);
                $empleado->fecha_corte = $datos['fecha_finalizacion'];
                return $empleado;
            })
            ->sortBy(function ($empleado) use ($sort) {
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

    public function generarPDF(Request $request, ProrrogaService $prorrogaService)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin    = $request->input('fecha_fin');

        $empleados = Empleado::with(['informacionLaboralActual.estadoCargo.cargo', 'empresa'])
            ->whereHas('informacionLaboralActual', function ($q) {
                $q->where('tipo_contrato', 'Fijo');
            })
            ->get()
            ->filter(function ($empleado) use ($prorrogaService, $fechaInicio, $fechaFin) {
                $estado = $empleado->informacionLaboralActual;
                if (!$estado) return false;

                $fechaProrroga = $prorrogaService
                    ->calcularDesdeIngreso($estado->fecha_ingreso, $estado->fecha_salida)['fecha_prorroga'];

                return $fechaInicio && $fechaFin &&
                    $fechaProrroga >= $fechaInicio &&
                    $fechaProrroga <= $fechaFin;
            });

        $logoPath = public_path('images/logo_formacol.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return Pdf::loadView('contratos.pdf', [
            'empleados' => $empleados,
            'logoBase64' => $logoBase64,
        ])->setPaper('a4')->download('cartas_no_prorroga.pdf');
    }


}
