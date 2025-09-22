<?php

namespace App\Observers;

use App\Models\Empleado;
use App\Models\RangoEdad;
use Carbon\Carbon;

class EmpleadoObserver
{
    /**
     * Handle the Empleado "created" event.
     */
    public function created(Empleado $empleado): void
    {
        $this->actualizarRangoEdad($empleado);
    }

    /**
     * Handle the Empleado "updated" event.
     */
    public function updated(Empleado $empleado): void
    {
        // Si se actualizó la fecha de nacimiento, actualizar el rango de edad
        if ($empleado->isDirty('fecha_nacimiento')) {
            $this->actualizarRangoEdad($empleado);
        }
    }
    
    /**
     * Actualiza el rango de edad del empleado basado en su fecha de nacimiento
     */
    protected function actualizarRangoEdad(Empleado $empleado): void
    {
        try {
            // Validar que el empleado tenga fecha de nacimiento
            if (!$empleado->fecha_nacimiento) {
                \Log::info('Empleado sin fecha de nacimiento, no se puede calcular rango de edad', [
                    'empleado_id' => $empleado->id
                ]);
                return;
            }
            
            // Validar formato de fecha
            try {
                $fechaNacimiento = Carbon::parse($empleado->fecha_nacimiento);
            } catch (\Exception $e) {
                \Log::error('Formato de fecha de nacimiento inválido', [
                    'empleado_id' => $empleado->id,
                    'fecha_nacimiento' => $empleado->fecha_nacimiento,
                    'error' => $e->getMessage()
                ]);
                return;
            }
            
            $edad = $fechaNacimiento->age;
            
            // Validar que la edad sea razonable
            if ($edad < 0 || $edad > 150) {
                \Log::warning('Edad fuera de rango razonable', [
                    'empleado_id' => $empleado->id,
                    'edad_calculada' => $edad,
                    'fecha_nacimiento' => $empleado->fecha_nacimiento
                ]);
                return;
            }
            
            // Buscar todos los rangos que correspondan a la edad del empleado
            $rangosPosibles = RangoEdad::where('edad_minima', '<=', $edad)
                ->where('edad_maxima', '>=', $edad)
                ->orderBy('edad_minima')
                ->get();
                
            // Seleccionar el rango más específico (el de menor rango)
            $rango = $rangosPosibles->first();
            
            // Registrar información para depuración
            \Log::info('Búsqueda de rango de edad', [
                'empleado_id' => $empleado->id,
                'edad_calculada' => $edad,
                'fecha_nacimiento' => $empleado->fecha_nacimiento,
                'rangos_encontrados' => $rangosPosibles->count(),
                'rangos_detalle' => $rangosPosibles->map(function($r) {
                    return [
                        'id' => $r->id_rango,
                        'min' => $r->edad_minima,
                        'max' => $r->edad_maxima
                    ];
                })->toArray()
            ]);
            
            // Si hay múltiples rangos, registrar para depuración
            if ($rangosPosibles->count() > 1) {
                \Log::warning('Múltiples rangos de edad encontrados', [
                    'empleado_id' => $empleado->id,
                    'edad' => $edad,
                    'rangos_encontrados' => $rangosPosibles->pluck('id_rango'),
                    'rango_seleccionado' => $rango ? $rango->id_rango : null
                ]);
            }
                
            if ($rango) {
                $rangoEdadAnterior = $empleado->rango_edad_id;
                $empleado->rango_edad_id = $rango->id_rango;
                
                // Evitar bucle infinito al guardar solo si realmente cambió
                if ($empleado->isDirty('rango_edad_id')) {
                    $empleado->saveQuietly();
                    
                    \Log::info('Rango de edad actualizado exitosamente', [
                        'empleado_id' => $empleado->id,
                        'edad' => $edad,
                        'rango_anterior' => $rangoEdadAnterior,
                        'rango_nuevo' => $rango->id_rango
                    ]);
                }
            } else {
                \Log::warning('No se encontró rango de edad para la edad calculada', [
                    'empleado_id' => $empleado->id,
                    'edad' => $edad,
                    'fecha_nacimiento' => $empleado->fecha_nacimiento
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar rango de edad', [
                'empleado_id' => $empleado->id,
                'fecha_nacimiento' => $empleado->fecha_nacimiento,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle the Empleado "deleted" event.
     */
    public function deleted(Empleado $empleado): void
    {
        //
    }

    /**
     * Handle the Empleado "restored" event.
     */
    public function restored(Empleado $empleado): void
    {
        //
    }

    /**
     * Handle the Empleado "force deleted" event.
     */
    public function forceDeleted(Empleado $empleado): void
    {
        //
    }
}
