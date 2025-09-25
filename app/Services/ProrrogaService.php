<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\informacionLaboral;

class ProrrogaService
{
    public function calcular(InformacionLaboral $informacionLaboral): void
    {
        $fechaIngreso = Carbon::parse($informacionLaboral->fecha_ingreso)->startOfDay();
        $hoy = Carbon::now()->startOfDay();

        // Reiniciar contador
        $contador = 1;
        
        // Comenzar desde la fecha de ingreso
        $fechaFinContrato = $fechaIngreso->copy();
        
        // Calcular todas las prórrogas hasta llegar a una fecha futura
        while ($fechaFinContrato->lessThanOrEqualTo($hoy) && !$informacionLaboral->fecha_salida) {
            // Determinar duración según el contador
            if ($contador <= 4) {
                // Primeros 4 contratos: 3 meses cada uno
                $duracion = 3;
            } else {
                // A partir del 5to contrato: 12 meses
                $duracion = 12;
            }
            
            // Avanzar a la siguiente fecha de finalización
            $fechaFinContrato->addMonths($duracion);
            
            // Incrementar contador, pero congelar en 5 si ya pasó la fase de 3 meses
            if ($contador < 5) {
                $contador++;
            }
        }
        
        // La fecha de prórroga es cuando se debe enviar el preaviso (1 mes y 1 semana antes del fin)
        $fechaPreaviso = $fechaFinContrato->copy()->subMonth()->subWeek();
        
        // Actualizar los campos en la base de datos
        $informacionLaboral->cantidad_prorroga = $contador; // El contador actual de prórrogas (se congela en 5)
        $informacionLaboral->duracion_prorrogas = $contador <= 4 ? 3 : 12;
        $informacionLaboral->fecha_prorroga = $fechaPreaviso->startOfDay();
        $informacionLaboral->save(); 
    }

    public function calcularDesdeIngreso($fechaIngreso, $fechaSalida = null): array
    {
        $fechaIngreso = Carbon::parse($fechaIngreso)->startOfDay();
        $hoy = Carbon::now()->startOfDay();

        $contador = 1;
        
        // Comenzar desde la fecha de ingreso
        $fechaFinContrato = $fechaIngreso->copy();
        
        // Calcular todas las prórrogas hasta llegar a una fecha futura
        while ($fechaFinContrato->lessThanOrEqualTo($hoy) && !$fechaSalida) {
            // Determinar duración según el contador
            if ($contador <= 4) {
                // Primeros 4 contratos: 3 meses cada uno
                $duracion = 3;
            } else {
                // A partir del 5to contrato: 12 meses
                $duracion = 12;
            }
            
            // Avanzar a la siguiente fecha de finalización
            $fechaFinContrato->addMonths($duracion);
            
            // Incrementar contador, pero congelar en 5 si ya pasó la fase de 3 meses
            if ($contador < 5) {
                $contador++;
            }
        }
        
        // Fecha de preaviso (1 mes y 1 semana antes del fin del contrato)
        $fechaPreaviso = $fechaFinContrato->copy()->subMonth()->subWeek();
        
        // Determinar la duración actual del contrato
        $duracionActual = $contador <= 4 ? 3 : 12;

        return [
            'fecha_prorroga' => $fechaPreaviso,           // ✅ Fecha límite para enviar preaviso
            'fecha_finalizacion' => $fechaFinContrato->copy(), // ✅ Fecha fin de contrato
            'duracion' => $duracionActual,
            'contador' => $contador,
        ];
    }
}

