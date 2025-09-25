<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Empleado;
use App\Models\InformacionLaboral;
use App\Services\ProrrogaService;

class ActualizarProrrogasCommand extends Command
{
    protected $signature = 'prorrogas:actualizar';
    protected $description = 'Actualiza las fechas de prórroga para todos los empleados activos';

    public function handle()
    {
        $this->info('Iniciando actualización de fechas de prórroga...');
        
        $prorrogaService = app(ProrrogaService::class);
        $empleadosActualizados = 0;
        $totalEmpleados = 0;

        // Obtener todos los empleados con información laboral activa
        $empleados = Empleado::with(['informacionLaboralActual'])
            ->whereHas('informacionLaboralActual', function($query) {
                $query->whereNull('fecha_salida'); // Solo empleados activos
            })
            ->get();

        $totalEmpleados = $empleados->count();
        $this->info("Total de empleados activos encontrados: {$totalEmpleados}");

        if ($totalEmpleados === 0) {
            $this->warn('No se encontraron empleados activos para actualizar.');
            return 0;
        }

        $bar = $this->output->createProgressBar($totalEmpleados);
        $bar->start();

        foreach ($empleados as $empleado) {
            $infoLaboral = $empleado->informacionLaboralActual;
            
            if ($infoLaboral && $infoLaboral->fecha_ingreso) {
                try {
                    // Actualizar usando el método que sí guarda en BD
                    $prorrogaService->calcular($infoLaboral);
                    $empleadosActualizados++;
                    
                    $this->line("Empleado: {$empleado->nombre_completo} - Nueva fecha prórroga: {$infoLaboral->fecha_prorroga->format('d/m/Y')}");
                } catch (\Exception $e) {
                    $this->error("Error al actualizar empleado {$empleado->nombre_completo}: {$e->getMessage()}");
                }
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->line('');

        $this->info("Proceso completado:");
        $this->info("- Total empleados procesados: {$totalEmpleados}");
        $this->info("- Empleados actualizados correctamente: {$empleadosActualizados}");
        $this->info("- Empleados con errores: " . ($totalEmpleados - $empleadosActualizados));

        return 0;
    }
}
