<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InformacionLaboral;
use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActualizarSaldosVacaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacaciones:actualizar-saldos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los saldos acumulados de vacaciones para todos los empleados activos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando actualización de saldos de vacaciones...');
        
        $contador = 0;
        $errores = 0;
        
        try {
            // Obtener todos los empleados con información laboral activa
            $informacionLaboral = InformacionLaboral::with(['empleado'])
                ->whereNotNull('fecha_ingreso')
                ->whereNull('fecha_salida') // Solo empleados activos
                ->get();
            
            if ($informacionLaboral->isEmpty()) {
                $this->warn('No se encontraron empleados activos con fecha de ingreso.');
                return 0;
            }
            
            $this->info('Procesando ' . $informacionLaboral->count() . ' empleados...');
            
            // Iniciar transacción para seguridad
            DB::beginTransaction();
            
            foreach ($informacionLaboral as $info) {
                try {
                    // Calcular meses trabajados desde la fecha de ingreso
                    $fechaIngreso = Carbon::parse($info->fecha_ingreso);
                    $fechaActual = Carbon::now();
                    $mesesTrabajados = $fechaIngreso->diffInMonths($fechaActual);
                    
                    // Calcular días acumulados (1.25 días por mes)
                    $diasAcumulados = $mesesTrabajados * 1.25;
                    
                    // Actualizar el campo en la base de datos
                    $info->dias_vacaciones_acumulados = $diasAcumulados;
                    $info->save();
                    
                    $contador++;
                    
                    $this->line("Empleado ID {$info->empleado_id}: {$diasAcumulados} días acumulados");
                    
                } catch (\Exception $e) {
                    $errores++;
                    $this->error("Error procesando empleado ID {$info->empleado_id}: " . $e->getMessage());
                }
            }
            
            // Confirmar transacción
            DB::commit();
            
            $this->info('');
            $this->info('✅ Actualización completada:');
            $this->info("   - Empleados actualizados: {$contador}");
            $this->info("   - Errores: {$errores}");
            
            return $contador;
            
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            DB::rollBack();
            $this->error('❌ Error crítico: ' . $e->getMessage());
            return 0;
        }
    }
}
