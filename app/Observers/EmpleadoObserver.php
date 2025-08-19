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
    protected function actualizarRangoEdad(Empleado $empleado)
    {
        if (!$empleado->fecha_nacimiento) {
            return;
        }
        
        $edad = Carbon::parse($empleado->fecha_nacimiento)->age;
        
        // Buscar el rango que corresponda a la edad del empleado
        $rango = RangoEdad::where('edad_minima', '<=', $edad)
            ->where('edad_maxima', '>=', $edad)
            ->first();
            
        if ($rango) {
            $empleado->rango_edad_id = $rango->id_rango;
            
            // Evitar bucle infinito al guardar
            if ($empleado->isDirty('rango_edad_id')) {
                $empleado->saveQuietly();
            }
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
