<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ActualizarVacacionesMensualesJob;

class EjecutarActualizacionVacaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacaciones:ejecutar-actualizacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta manualmente el job de actualización de vacaciones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ejecutando job de actualización de vacaciones...');
        
        try {
            // Ejecutar el job directamente sin usar colas
            $job = new ActualizarVacacionesMensualesJob();
            $job->handle();
            
            $this->info('Job ejecutado correctamente.');
            $this->info('Revisa los logs para ver detalles: storage/logs/laravel.log');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error al ejecutar el job: ' . $e->getMessage());
            return 1;
        }
    }
}
