<?php

namespace App\Console\Commands;

use App\Models\Empleado;
use App\Models\RangoEdad;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestEmpleadoObserver extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:empleado-observer {empleado_id?}';

    /**
     * The console command description.
     */
    protected $description = 'Test the EmpleadoObserver functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $empleadoId = $this->argument('empleado_id');
        
        if ($empleadoId) {
            // Test specific employee
            $empleado = Empleado::find($empleadoId);
            if (!$empleado) {
                $this->error("Empleado con ID {$empleadoId} no encontrado.");
                return 1;
            }
            
            $this->info("Probando observador para empleado: {$empleado->nombre_completo} (ID: {$empleado->id})");
            $this->info("Fecha de nacimiento: {$empleado->fecha_nacimiento}");
            $this->info("Rango de edad actual: {$empleado->rango_edad_id}");
            
            // Trigger the observer manually
            $empleado->save();
            
            $empleado->refresh();
            $this->info("Rango de edad después de guardar: {$empleado->rango_edad_id}");
            
        } else {
            // Test all employees without birth date
            $this->info('Buscando empleados sin fecha de nacimiento...');
            $empleadosSinFecha = Empleado::whereNull('fecha_nacimiento')->count();
            $this->info("Empleados sin fecha de nacimiento: {$empleadosSinFecha}");
            
            // Test all employees without age range
            $this->info('Buscando empleados sin rango de edad...');
            $empleadosSinRango = Empleado::whereNull('rango_edad_id')->count();
            $this->info("Empleados sin rango de edad: {$empleadosSinRango}");
            
            // Show available age ranges
            $this->info('Rangos de edad disponibles:');
            $rangos = RangoEdad::all();
            foreach ($rangos as $rango) {
                $this->line("  ID: {$rango->id_rango}, Min: {$rango->edad_minima}, Max: {$rango->edad_maxima}");
            }
            
            // Test updating employees with birth date but no age range
            $empleadosParaActualizar = Empleado::whereNotNull('fecha_nacimiento')
                ->whereNull('rango_edad_id')
                ->limit(5)
                ->get();
                
            if ($empleadosParaActualizar->count() > 0) {
                $this->info("Actualizando {$empleadosParaActualizar->count()} empleados de prueba...");
                foreach ($empleadosParaActualizar as $empleado) {
                    $this->line("  - {$empleado->nombre_completo} (ID: {$empleado->id}) - Fecha: {$empleado->fecha_nacimiento}");
                    $empleado->save(); // This should trigger the observer
                    $empleado->refresh();
                    $this->line("    Rango asignado: {$empleado->rango_edad_id}");
                }
            } else {
                $this->info('No hay empleados con fecha de nacimiento pero sin rango de edad para probar.');
            }
        }
        
        $this->info('Prueba completada. Revisa los logs para más detalles.');
        
        return 0;
    }
}
