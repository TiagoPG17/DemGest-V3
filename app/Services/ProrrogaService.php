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

        // Reiniciar valores si cambia la fecha de ingreso o está vacía la fecha de prórroga
        $informacionLaboral->cantidad_prorroga = 1;
        $informacionLaboral->duracion_prorrogas = 3;
        $informacionLaboral->fecha_prorroga = $fechaIngreso->copy()->addDays(52); // 1 mes y 3 semanas

        $fechaProrrogaTemp = $informacionLaboral->fecha_prorroga->copy();

        while ($hoy->greaterThanOrEqualTo($fechaProrrogaTemp) && !$informacionLaboral->fecha_salida) {
            switch ($informacionLaboral->cantidad_prorroga) {
                case 1:
                    $informacionLaboral->cantidad_prorroga = 2;
                    $informacionLaboral->duracion_prorrogas = 3;
                    $fechaProrrogaTemp->addMonths(3);
                    break;
                case 2:
                    $informacionLaboral->cantidad_prorroga = 3;
                    $informacionLaboral->duracion_prorrogas = 3;
                    $fechaProrrogaTemp->addMonths(3);
                    break;
                case 3:
                    $informacionLaboral->cantidad_prorroga = 4;
                    $informacionLaboral->duracion_prorrogas = 3;
                    $fechaProrrogaTemp->addMonths(3);
                    break;
                case 4:
                    $informacionLaboral->cantidad_prorroga = 5;
                    $informacionLaboral->duracion_prorrogas = 12; 
                    $fechaProrrogaTemp->addMonths(12);
                    break;
                default:
                    // Después de la 5ta prórroga, mantenemos el valor y salimos
                    break 2;
            }
        }

        $informacionLaboral->fecha_prorroga = $fechaProrrogaTemp->startOfDay();
        $informacionLaboral->save(); 
    }

    public function calcularDesdeIngreso($fechaIngreso, $fechaSalida = null): array
    {
        $fechaIngreso = Carbon::parse($fechaIngreso)->startOfDay();
        $hoy = Carbon::now()->startOfDay();

        $contador = 1;
        $duracion_meses = 1;

        // Primera prórroga: 52 días (1 mes y 3 semanas)
        $fechaProrrogaTemp = $fechaIngreso->copy()->addDays(52);

        while ($hoy->greaterThanOrEqualTo($fechaProrrogaTemp) && !$fechaSalida) {
            $contador++;

            if ($contador <= 4) {
                $duracion_meses = 3;
                $fechaProrrogaTemp->addMonthsNoOverflow(3);
            } elseif ($contador == 5) {
                $duracion_meses = 12;
                $fechaProrrogaTemp->addMonthsNoOverflow(12);
            } else {
                // A partir del 6to, solo se actualiza por año pero el contador se congela
                $duracion_meses = 12;
                $fechaProrrogaTemp->addMonthsNoOverflow(12);
            }
        }

        // Si aún no ha llegado ni al contador 5, la fecha de finalización es la última prórroga que se calculó
        if ($contador < 5) {
            $fecha_finalizacion = $fechaProrrogaTemp->copy()->startOfDay();
        } else {
            // Si ya está en la quinta o más, ajustar al aniversario más próximo del ingreso
            $años_transcurridos = $fechaIngreso->diffInYears($fechaProrrogaTemp);
            $fecha_finalizacion = $fechaIngreso->copy()->addYears($años_transcurridos)->startOfDay();

            if ($fecha_finalizacion->lessThanOrEqualTo($hoy)) {
                $fecha_finalizacion->addYear();
            }
        }

        // Fecha de aviso de prórroga (1 mes y 1 semana antes)
        $fecha_prorroga = (clone $fecha_finalizacion)->subMonth()->subWeek();

        $duracion = $contador < 5 ? 3 : 12;

        return [
    'fecha_prorroga' => $fechaProrrogaTemp->copy(),
    'duracion' => $duracion,
    'contador' => $contador,
    'fecha_finalizacion' => $fechaProrrogaTemp->copy()->addWeek()->addMonth(), // 🔥 esta es la clave
];

    }
}

