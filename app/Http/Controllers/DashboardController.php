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
        
            // Obtener total de empleados activos por empresa usando lógica robusta
            // Primero obtenemos los totales robustos de centros de costo
            try {
                $totalesRobustos = \App\Models\CentroCosto::getTotalesPorEmpresa();
                $contiflexCount = $totalesRobustos['contiflex'];
                $formacolCount = $totalesRobustos['formacol'];
                $totalEmpleados = $contiflexCount + $formacolCount;
                
                // Validación adicional: contar directamente por empresa_id como respaldo
                $contiflexDirecto = DB::table('informacion_laboral')
                    ->where('empresa_id', 1) // Contiflex
                    ->whereNull('fecha_salida') // ✅ Solo empleados realmente activos
                    ->count();

                $formacolDirecto = DB::table('informacion_laboral')
                    ->where('empresa_id', 2) // Formacol
                    ->whereNull('fecha_salida') // ✅ Solo empleados realmente activos
                    ->count();
                
                // Si hay diferencias significativas, registrar advertencia
                if (abs($contiflexCount - $contiflexDirecto) > 5) {
                    Log::warning('Diferencia significativa en conteo Contiflex', [
                        'conteo_robusto' => $contiflexCount,
                        'conteo_directo' => $contiflexDirecto
                    ]);
                }
                
                if (abs($formacolCount - $formacolDirecto) > 5) {
                    Log::warning('Diferencia significativa en conteo Formacol', [
                        'conteo_robusto' => $formacolCount,
                        'conteo_directo' => $formacolDirecto
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error('Error en conteo robusto, usando método directo: ' . $e->getMessage());
                
                // Fallback al método directo
                $contiflexCount = DB::table('informacion_laboral')
                    ->where('empresa_id', 1) // Contiflex
                    ->whereNull('fecha_salida') // ✅ Solo empleados realmente activos
                    ->count();

                $formacolCount = DB::table('informacion_laboral')
                    ->where('empresa_id', 2) // Formacol
                    ->whereNull('fecha_salida') // ✅ Solo empleados realmente activos
                    ->count();

                $totalEmpleados = $contiflexCount + $formacolCount;
            }

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
                ->whereNull('fecha_salida') // ✅ Solo empleados realmente activos
                ->whereBetween('fecha_prorroga', [now(), now()->addDays(30)])
                ->count();

            $proximosContratosFormacol = DB::table('informacion_laboral')
                ->where('empresa_id', 2) // Formacol
                ->whereNull('fecha_salida') // ✅ Solo empleados realmente activos
                ->whereBetween('fecha_prorroga', [now(), now()->addDays(30)])
                ->count();

            // Obtener el log de consultas
            $queries = DB::getQueryLog();
        

            // Obtener centros de costo con conteo robusto usando el modelo
            $centrosCostos = collect();
            $totalContiflex = 0;
            $totalFormacol = 0;
            
            try {
                // Usar el método que filtra solo centros con empleados
                $centrosCostos = \App\Models\CentroCosto::getCentrosConEmpleados();
                
                // Obtener totales por empresa usando el método especializado
                $totalesPorEmpresa = \App\Models\CentroCosto::getTotalesPorEmpresa();
                $totalContiflex = $totalesPorEmpresa['contiflex'];
                $totalFormacol = $totalesPorEmpresa['formacol'];
                
                // Depuración: mostrar totales
                Log::info('TOTALES POR EMPRESA:', [
                    'contiflex' => $totalContiflex,
                    'formacol' => $totalFormacol,
                    'total_general' => $totalEmpleados
                ]);
                
                // Validar coherencia de datos
                $sumaCentrosContiflex = $centrosCostos->where('codigo', 'LIKE', 'CX_%')->sum('empleados_count');
                $sumaCentrosFormacol = $centrosCostos->where('codigo', 'LIKE', 'FC_%')->sum('empleados_count');
                
                // Si hay diferencias, usar la suma de centros como fuente de verdad
                if ($sumaCentrosContiflex != $totalContiflex) {
                    $totalContiflex = $sumaCentrosContiflex;
                    Log::warning('Coherencia de datos: Diferencia en total Contiflex', [
                        'total_metodo' => $totalesPorEmpresa['contiflex'],
                        'suma_centros' => $sumaCentrosContiflex
                    ]);
                }
                
                if ($sumaCentrosFormacol != $totalFormacol) {
                    $totalFormacol = $sumaCentrosFormacol;
                    Log::warning('Coherencia de datos: Diferencia en total Formacol', [
                        'total_metodo' => $totalesPorEmpresa['formacol'],
                        'suma_centros' => $sumaCentrosFormacol
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error('Error en DashboardController al obtener centros de costo: ' . $e->getMessage());
                
                // En caso de error, devolver centros de costos sin conteo
                $centrosCostos = \App\Models\CentroCosto::orderBy('codigo')->get()->map(function($item) {
                    $item->empleados_count = 0;
                    return $item;
                });
            }

            // Validación final de coherencia de datos
            $this->validarCoherenciaFinal($contiflexCount, $formacolCount, $totalContiflex, $totalFormacol, $centrosCostos);
            
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

    /**
     * Valida la coherencia final de los datos del dashboard
     * 
     * @param int $contiflexCount Conteo principal de Contiflex
     * @param int $formacolCount Conteo principal de Formacol
     * @param int $totalContiflex Total de Contiflex desde centros de costo
     * @param int $totalFormacol Total de Formacol desde centros de costo
     * @param Collection $centrosCostos Colección de centros de costo
     */
    private function validarCoherenciaFinal($contiflexCount, $formacolCount, $totalContiflex, $totalFormacol, $centrosCostos)
    {
        try {
            // Validar coherencia entre conteo principal y totales de centros
            if ($contiflexCount != $totalContiflex) {
                Log::warning('Incoherencia en datos de Contiflex', [
                    'conteo_principal' => $contiflexCount,
                    'total_centros' => $totalContiflex,
                    'diferencia' => abs($contiflexCount - $totalContiflex)
                ]);
            }

            if ($formacolCount != $totalFormacol) {
                Log::warning('Incoherencia en datos de Formacol', [
                    'conteo_principal' => $formacolCount,
                    'total_centros' => $totalFormacol,
                    'diferencia' => abs($formacolCount - $totalFormacol)
                ]);
            }

            // Validar que la suma de centros coincida con los totales
            $sumaCentrosContiflex = $centrosCostos->where('codigo', 'LIKE', 'CX_%')->sum('empleados_count');
            $sumaCentrosFormacol = $centrosCostos->where('codigo', 'LIKE', 'FC_%')->sum('empleados_count');

            if ($totalContiflex != $sumaCentrosContiflex) {
                Log::error('Error crítico: Total Contiflex no coincide con suma de centros', [
                    'total_contiflex' => $totalContiflex,
                    'suma_centros' => $sumaCentrosContiflex
                ]);
            }

            if ($totalFormacol != $sumaCentrosFormacol) {
                Log::error('Error crítico: Total Formacol no coincide con suma de centros', [
                    'total_formacol' => $totalFormacol,
                    'suma_centros' => $sumaCentrosFormacol
                ]);
            }

            // Validar que no haya centros con conteos negativos
            $centrosNegativos = $centrosCostos->where('empleados_count', '<', 0);
            if ($centrosNegativos->count() > 0) {
                Log::error('Centros de costo con conteos negativos', [
                    'centros' => $centrosNegativos->pluck('codigo')->toArray()
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error en validación de coherencia final: ' . $e->getMessage());
        }
    }
}
