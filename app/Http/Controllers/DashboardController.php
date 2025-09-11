<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Activar el log de consultas SQL
            DB::enableQueryLog();
            Log::info('=== INICIO DASHBOARD ===');
            Log::info('Hora del servidor: ' . now());

            // Obtener total de empleados activos por empresa
            // ID 1: Contiflex, ID 2: Formacol
            // Contar empleados activos de Contiflex
            $contiflexCount = DB::table('informacion_laboral')
                ->where('empresa_id', 1) // Contiflex
                ->where(function($query) {
                    $query->whereNull('fecha_salida')
                          ->orWhere('fecha_salida', '>', now());
                })
                ->count();

            // Contar empleados activos de Formacol
            $formacolCount = DB::table('informacion_laboral')
                ->where('empresa_id', 2) // Formacol
                ->where(function($query) {
                    $query->whereNull('fecha_salida')
                          ->orWhere('fecha_salida', '>', now());
                })
                ->count();

            // Total general de empleados activos
            $totalEmpleados = $contiflexCount + $formacolCount;

            // Obtener empleados nuevos del mes actual por empresa
            $nuevosContiflexMes = DB::table('informacion_laboral')
                ->where('empresa_id', 1) // Contiflex
                ->whereMonth('fecha_ingreso', now()->month)
                ->whereYear('fecha_ingreso', now()->year)
                ->count();

            $nuevosFormacolMes = DB::table('informacion_laboral')
                ->where('empresa_id', 2) // Formacol
                ->whereMonth('fecha_ingreso', now()->month)
                ->whereYear('fecha_ingreso', now()->year)
                ->count();

            // Obtener empleados inactivos del mes actual
            $inactivosContiflexMes = DB::table('informacion_laboral')
                ->where('empresa_id', 1) // Contiflex
                ->whereMonth('fecha_salida', now()->month)
                ->whereYear('fecha_salida', now()->year)
                ->where('fecha_salida', '<=', now())
                ->count();

            $inactivosFormacolMes = DB::table('informacion_laboral')
                ->where('empresa_id', 2) // Formacol
                ->whereMonth('fecha_salida', now()->month)
                ->whereYear('fecha_salida', now()->year)
                ->where('fecha_salida', '<=', now())
                ->count();

            // Obtener empleados con contratos próximos a vencer (próximos 30 días)
            $proximosContratosContiflex = DB::table('informacion_laboral')
                ->where('empresa_id', 1) // Contiflex
                ->whereNull('fecha_salida')
                ->whereBetween('fecha_prorroga', [now(), now()->addDays(30)])
                ->count();

            $proximosContratosFormacol = DB::table('informacion_laboral')
                ->where('empresa_id', 2) // Formacol
                ->whereNull('fecha_salida')
                ->whereBetween('fecha_prorroga', [now(), now()->addDays(30)])
                ->count();

            // Obtener el log de consultas
            $queries = DB::getQueryLog();
            Log::info('=== CONSULTAS EJECUTADAS ===');
            foreach ($queries as $query) {
                Log::info($query['query']);
                Log::info('Bindings: ' . json_encode($query['bindings']));
                Log::info('Tiempo: ' . $query['time'] . 'ms');
            }
            
            // Verificar datos
            Log::info('=== RESUMEN DE DATOS ===');
            Log::info('Total empleados: ' . $totalEmpleados);
            Log::info('Contiflex: ' . $contiflexCount);
            Log::info('Formacol: ' . $formacolCount);
            Log::info('Nuevos Contiflex: ' . $nuevosContiflexMes);
            Log::info('Nuevos Formacol: ' . $nuevosFormacolMes);
            Log::info('Inactivos Contiflex: ' . $inactivosContiflexMes);
            Log::info('Inactivos Formacol: ' . $inactivosFormacolMes);
            Log::info('Próximos Contiflex: ' . $proximosContratosContiflex);
            Log::info('Próximos Formacol: ' . $proximosContratosFormacol);

            // Inicializar variables
            $centrosCostos = collect();
            $totalContiflex = 0;
            $totalFormacol = 0;
            
            try {
                // Consulta compatible con MySQL 5.7 para contar solo un centro de costo por empleado
                $centrosCostos = DB::table('centro_costos as cc')
                    ->leftJoin('estado_cargo as ec', 'cc.id', '=', 'ec.centro_costo_id')
                    ->leftJoin('informacion_laboral as il', function($join) {
                        $join->on('ec.estado_id', '=', 'il.id_estado')
                              ->whereNull('il.fecha_salida')
                              ->orWhere('il.fecha_salida', '>', DB::raw('NOW()'));
                    })
                    ->leftJoin('empleados as e', 'il.empleado_id', '=', 'e.id_empleado')
                    ->whereRaw('il.id_estado = (
                        SELECT il2.id_estado 
                        FROM informacion_laboral il2 
                        WHERE il2.empleado_id = il.empleado_id 
                        AND (il2.fecha_salida IS NULL OR il2.fecha_salida > NOW())
                        ORDER BY il2.fecha_ingreso DESC, il2.id_estado DESC 
                        LIMIT 1
                    )')
                    ->select([
                        'cc.id',
                        'cc.codigo',
                        'cc.nombre',
                        DB::raw('COUNT(DISTINCT e.id_empleado) as empleados_count')
                    ])
                    ->groupBy('cc.id', 'cc.codigo', 'cc.nombre')
                    ->orderBy('cc.codigo')
                    ->get();
                
                // Calcular totales por empresa
                foreach ($centrosCostos as $centro) {
                    if (str_starts_with($centro->codigo, 'CX_')) {
                        $totalContiflex += $centro->empleados_count;
                    } elseif (str_starts_with($centro->codigo, 'FC_')) {
                        $totalFormacol += $centro->empleados_count;
                    }
                }

                // Depuración: Ver empleados en Administración
                $empleadosAdmin = DB::table('empleados as e')
                    ->join('informacion_laboral as il', 'e.id_empleado', '=', 'il.empleado_id')
                    ->join('estado_cargo as ec', 'il.id_estado', '=', 'ec.estado_id')
                    ->join('centro_costos as cc', 'ec.centro_costo_id', '=', 'cc.id')
                    ->where('cc.codigo', 'CX_10000') // Código de Administración
                    ->where(function($query) {
                        $query->whereNull('il.fecha_salida')
                              ->orWhere('il.fecha_salida', '>', now());
                    })
                    ->select('e.id_empleado', 'e.nombre_completo', 'il.fecha_ingreso', 'il.fecha_salida')
                    ->orderBy('e.nombre_completo')
                    ->get();

                Log::info('\n=== EMPLEADOS EN ADMINISTRACIÓN ===');
                foreach ($empleadosAdmin as $empleado) {
                    $estado = $empleado->fecha_salida ? 'INACTIVO' : 'ACTIVO';
                    Log::info("ID: {$empleado->id_empleado}, Nombre: {$empleado->nombre_completo}, Ingreso: {$empleado->fecha_ingreso}, Estado: {$estado}");
                }
                
                // Registrar información detallada para depuración
                Log::info('=== DETALLE DE EMPLEADOS POR CENTRO DE COSTO ===');
                foreach ($centrosCostos as $centro) {
                    if ($centro->empleados_count > 0) {
                        $empleados = DB::table('empleados as e')
                            ->join('informacion_laboral as il', 'e.id_empleado', '=', 'il.empleado_id')
                            ->join('estado_cargo as ec', 'il.id_estado', '=', 'ec.estado_id')
                            ->where('ec.centro_costo_id', $centro->id)
                            ->where(function($query) {
                                $query->whereNull('il.fecha_salida')
                                      ->orWhere('il.fecha_salida', '>', now());
                            })
                            ->select('e.id_empleado', 'e.numero_documento', 'e.nombre_completo', 'il.fecha_ingreso', 'il.fecha_salida')
                            ->get();
                        
                        Log::info("\nCentro: {$centro->codigo} - {$centro->nombre} ({$centro->empleados_count} empleados)");
                        foreach ($empleados as $empleado) {
                            $estado = $empleado->fecha_salida ? 'INACTIVO' : 'ACTIVO';
                            Log::info("- {$empleado->nombre_completo} (ID: {$empleado->id_empleado}, Doc: {$empleado->numero_documento}, Ingreso: {$empleado->fecha_ingreso}, Estado: {$estado})");
                        }
                    }
                }
                
                Log::info('\n=== RESUMEN ===');
                Log::info('Total centros: ' . $centrosCostos->count());
                Log::info('Total empleados Contiflex: ' . $totalContiflex);
                Log::info('Total empleados Formacol: ' . $totalFormacol);
                Log::info('=========================');
                
            } catch (\Exception $e) {
                Log::error('Error en DashboardController: ' . $e->getMessage());
                
                // En caso de error, devolver centros de costos sin conteo
                $centrosCostos = $centrosCostos->isEmpty() ? collect() : $centrosCostos->map(function($item) {
                    $item->empleados_count = 0;
                    return $item;
                });
            }

            return view('dashboard.dashboard', [
                'contiflexCount' => $contiflexCount,
                'formacolCount' => $formacolCount,
                'totalEmpleados' => $totalEmpleados,
                'nuevosContiflexMes' => $nuevosContiflexMes,
                'nuevosFormacolMes' => $nuevosFormacolMes,
                'inactivosContiflexMes' => $inactivosContiflexMes,
                'inactivosFormacolMes' => $inactivosFormacolMes,
                'proximosContratosContiflex' => $proximosContratosContiflex,
                'proximosContratosFormacol' => $proximosContratosFormacol,
                'centrosCostos' => $centrosCostos,
                'totalContiflex' => $totalContiflex,
                'totalFormacol' => $totalFormacol
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en DashboardController: ' . $e->getMessage());
            return view('dashboard.dashboard', [
                'totalEmpleados' => 0,
                'contiflexCount' => 0,
                'formacolCount' => 0,
                'centrosCostos' => collect([]),
                'error' => 'Error al cargar los datos del dashboard'
            ]);
        }
    }
}
