<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de empleados
        $totalEmpleados = Empleado::count();

        // Empleados activos
        $empleadosActivos = DB::table('informacion_laboral')
            ->whereNull('fecha_salida')
            ->distinct('empleado_id')
            ->count('empleado_id');

        // Nuevos empleados este mes
        $nuevosEmpleados = DB::table('informacion_laboral')
            ->whereYear('fecha_ingreso', now()->year)
            ->whereMonth('fecha_ingreso', now()->month)
            ->distinct('empleado_id')
            ->count('empleado_id');

        // Inactivos este mes
        $empleadosInactivosMes = DB::table('informacion_laboral')
            ->whereNotNull('fecha_salida')
            ->whereYear('fecha_salida', now()->year)
            ->whereMonth('fecha_salida', now()->month)
            ->distinct('empleado_id')
            ->count('empleado_id');

        // Distribución por centro de costos
        $centrosCosto = DB::table('informacion_laboral')
            ->join('estado_cargo', 'informacion_laboral.id_estado', '=', 'estado_cargo.estado_id')
            ->join('centro_costos', 'estado_cargo.centro_costo_id', '=', 'centro_costos.id')
            ->select(
                'centro_costos.nombre as nombre',
                DB::raw('COUNT(DISTINCT informacion_laboral.empleado_id) as cantidad')
            )
            ->groupBy('centro_costos.nombre')
            ->get();

        $totalCentros = $centrosCosto->sum('cantidad');

        // Mostrar alerta solo una vez por semana (lunes o martes)
        $hoy = Carbon::now();
        $semanaActual = $hoy->format('o-W');
        $ultimaAlerta = session('ultima_alerta');
        $mostrarAlerta = false;

        if (($hoy->isMonday() || $hoy->isTuesday()) && $ultimaAlerta !== $semanaActual) {
            $mostrarAlerta = true;
            session(['ultima_alerta' => $semanaActual]);
        }

        return view('dashboard.dashboard', compact(
            'totalEmpleados',
            'empleadosActivos',
            'nuevosEmpleados',
            'empleadosInactivosMes',
            'centrosCosto',
            'totalCentros',
            'mostrarAlerta'
        ));
    }
}
