<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Actualizar saldos de vacaciones diariamente a las 2:00 AM
        // El Job revisará qué empleados necesitan acumular vacaciones según su fecha de ingreso
        $schedule->job(new \App\Jobs\ActualizarVacacionesMensualesJob())
                 ->dailyAt('02:00')
                 ->timezone('America/Bogota')
                 ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
