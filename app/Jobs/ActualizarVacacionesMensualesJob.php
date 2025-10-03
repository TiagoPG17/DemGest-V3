<?php

namespace App\Jobs;

use App\Models\InformacionLaboral;
use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActualizarVacacionesMensualesJob
{
    use Dispatchable;

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('Iniciando job de actualización mensual de vacaciones...');
        
        $contadorActualizados = 0;
        $contadorProcesados = 0;
        
        try {
            $hoy = Carbon::now();
            
            // Obtener empleados activos que cumplen exactamente un mes desde su fecha de ingreso
            $informacionLaboral = InformacionLaboral::with(['empleado'])
                ->whereNotNull('fecha_ingreso')
                ->whereNull('fecha_salida') // Solo empleados activos
                ->whereRaw('DATE_ADD(fecha_ingreso, INTERVAL 1 MONTH) = CURDATE()')
                ->get();
            
            if ($informacionLaboral->isEmpty()) {
                Log::info('No se encontraron empleados que cumplan un mes de antigüedad hoy.');
                return;
            }
            
            Log::info("Procesando {$informacionLaboral->count()} empleados que cumplen un mes de antigüedad hoy...");
            
            foreach ($informacionLaboral as $info) {
                $contadorProcesados++;
                
                try {
                    // Verificar que el empleado exista y tenga fecha de ingreso
                    if ($info->empleado && $info->fecha_ingreso) {
                        $fechaIngreso = Carbon::parse($info->fecha_ingreso);
                        
                        // Sumar 1.25 días por cumplir un mes más
                        $valorAnterior = $info->dias_vacaciones_acumulados;
                        $info->dias_vacaciones_acumulados += 1.25;
                        $info->save();
                        
                        $contadorActualizados++;
                        
                        // Calcular cuántos meses lleva el empleado
                        $mesesTrabajados = $fechaIngreso->diffInMonths($hoy);
                        
                        Log::info("Empleado {$info->empleado->nombre_completo} (ID: {$info->empleado_id}): " .
                                 "¡Cumple un mes más! Ingreso: {$fechaIngreso->format('Y-m-d')}. " .
                                 "+1.25 días agregados. Total acumulados: {$info->dias_vacaciones_acumulados} " .
                                 "(Meses trabajados: {$mesesTrabajados})");
                    } else {
                        Log::info("Empleado ID {$info->empleado_id}: No tiene información completa");
                    }
                    
                } catch (\Exception $e) {
                    Log::error("Error procesando empleado ID {$info->empleado_id}: " . $e->getMessage());
                    continue;
                }
            }
            
            Log::info("Job completado. Empleados que cumplen mes: {$contadorProcesados}, Actualizados: {$contadorActualizados}");
            
        } catch (\Exception $e) {
            Log::error("Error en el job de actualización de vacaciones: " . $e->getMessage());
            throw $e;
        }
    }
}
