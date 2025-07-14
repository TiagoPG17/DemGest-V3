<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class GenerateContractExpirationReport extends Command
{
    protected $signature = 'report:contract-expiration';
    protected $description = 'Generate a monthly report of employees with contracts expiring in one month';

    public function handle()
    {
        $hoy = Carbon::today();
        $fechaAlerta = $hoy->copy()->addMonth()->subWeek(); // Un mes y una semana desde hoy

        $empleados = Empleado::with('estadoActual.empresa')
            ->whereHas('estadoActual', function ($q) use ($fechaAlerta) {
                $q->whereNotNull('fecha_salida')
                  ->where('fecha_salida', '>=', $fechaAlerta->toDateString())
                  ->where('fecha_salida', '<=', $fechaAlerta->copy()->endOfMonth()->toDateString());
            })
            ->get();

        if ($empleados->isEmpty()) {
            $this->info('No hay empleados con contratos a punto de vencer.');
            return;
        }

        // Generar el contenido del reporte
        $html = view('reports.contract-expiration', compact('empleados', 'fechaAlerta'))->render();

        // Guardar el PDF (usando una librería como laravel-dompdf)
        $pdf = PDF::loadHTML($html);
        $fileName = 'reporte_finalizaciones_' . $hoy->format('Y_m_d') . '.pdf';
        Storage::put('public/reports/' . $fileName, $pdf->output());

        $this->info('Reporte generado exitosamente en: storage/app/public/reports/' . $fileName);
    }
}