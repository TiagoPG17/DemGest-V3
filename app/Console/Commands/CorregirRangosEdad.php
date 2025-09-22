<?php

namespace App\Console\Commands;

use App\Models\Empleado;
use App\Models\RangoEdad;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CorregirRangosEdad extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'empleados:corregir-rangos-edad {--empleado-id= : ID específico del empleado a corregir}';

    /**
     * The console command description.
     */
    protected $description = 'Corrige los rangos de edad de los empleados basado en su fecha de nacimiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $empleadoId = $this->option('empleado-id');
        
        if ($empleadoId) {
            $this->corregirEmpleadoEspecifico($empleadoId);
        } else {
            $this->corregirTodosLosEmpleados();
        }
    }

    /**
     * Corrige un empleado específico
     */
    private function corregirEmpleadoEspecifico($empleadoId)
    {
        $empleado = Empleado::find($empleadoId);
        
        if (!$empleado) {
            $this->error("Empleado con ID {$empleadoId} no encontrado.");
            return;
        }

        $this->info("Procesando empleado ID {$empleadoId}: {$empleado->nombre_completo}");
        $this->corregirRangoEdad($empleado);
    }

    /**
     * Corrige todos los empleados
     */
    private function corregirTodosLosEmpleados()
    {
        $this->info('Iniciando corrección de rangos de edad para todos los empleados...');
        
        $empleados = Empleado::whereNotNull('fecha_nacimiento')->get();
        $totalEmpleados = $empleados->count();
        $corregidos = 0;
        $sinCambios = 0;
        $errores = 0;

        $this->line("Total de empleados con fecha de nacimiento: {$totalEmpleados}");
        
        $bar = $this->output->createProgressBar($totalEmpleados);
        $bar->start();

        foreach ($empleados as $empleado) {
            try {
                $resultado = $this->corregirRangoEdad($empleado);
                if ($resultado) {
                    $corregidos++;
                } else {
                    $sinCambios++;
                }
            } catch (\Exception $e) {
                $this->error("\nError procesando empleado ID {$empleado->id}: " . $e->getMessage());
                $errores++;
            }
            
            $bar->advance();
        }

        $bar->finish();

        $this->line("\n");
        $this->info('Proceso completado:');
        $this->line("  - Empleados corregidos: {$corregidos}");
        $this->line("  - Empleados sin cambios: {$sinCambios}");
        $this->line("  - Errores: {$errores}");
    }

    /**
     * Corrige el rango de edad de un empleado específico
     */
    private function corregirRangoEdad(Empleado $empleado): bool
    {
        if (!$empleado->fecha_nacimiento) {
            $this->warn("  - Empleado ID {$empleado->id} sin fecha de nacimiento");
            return false;
        }

        try {
            $fechaNacimiento = Carbon::parse($empleado->fecha_nacimiento);
        } catch (\Exception $e) {
            $this->warn("  - Empleado ID {$empleado->id} con fecha de nacimiento inválida: {$empleado->fecha_nacimiento}");
            return false;
        }

        $edad = $fechaNacimiento->age;
        
        if ($edad < 0 || $edad > 150) {
            $this->warn("  - Empleado ID {$empleado->id} con edad fuera de rango: {$edad} años");
            return false;
        }

        // Buscar todos los rangos que correspondan a la edad del empleado
        $rangosPosibles = RangoEdad::where('edad_minima', '<=', $edad)
            ->where('edad_maxima', '>=', $edad)
            ->orderBy('edad_minima')
            ->get();
            
        // Seleccionar el rango más específico (el de menor rango)
        $rangoCorrecto = $rangosPosibles->first();

        if (!$rangoCorrecto) {
            $this->warn("  - Empleado ID {$empleado->id} ({$edad} años): No se encontró rango de edad");
            return false;
        }

        $rangoActual = $empleado->rango_edad_id;
        
        if ($rangoActual == $rangoCorrecto->id_rango) {
            // Ya tiene el rango correcto
            return false;
        }

        // Obtener información para mostrar
        $rangoActualNombre = $empleado->rangoEdad ? "{$empleado->rangoEdad->edad_minima}-{$empleado->rangoEdad->edad_maxima}" : 'Sin asignar';
        $rangoCorrectoNombre = "{$rangoCorrecto->edad_minima}-{$rangoCorrecto->edad_maxima}";

        // Actualizar el rango
        $empleado->rango_edad_id = $rangoCorrecto->id_rango;
        $empleado->saveQuietly();

        $this->line("  - Empleado ID {$empleado->id} ({$edad} años): {$rangoActualNombre} → {$rangoCorrectoNombre}");

        // Registrar en log
        Log::info('Rango de edad corregido', [
            'empleado_id' => $empleado->id,
            'nombre' => $empleado->nombre_completo,
            'edad' => $edad,
            'rango_anterior' => $rangoActual,
            'rango_nuevo' => $rangoCorrecto->id_rango,
            'rango_anterior_nombre' => $rangoActualNombre,
            'rango_nuevo_nombre' => $rangoCorrectoNombre
        ]);

        return true;
    }
}
