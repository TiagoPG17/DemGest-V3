<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;

class LimpiarEventosInvalidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:limpiar-eventos-invalidos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina eventos que no tienen id_evento válido';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando eventos inválidos...');
        
        // Contar eventos con id_evento nulo o 0
        $eventosInvalidos = Evento::whereNull('id_evento')
            ->orWhere('id_evento', 0)
            ->orWhere('id_evento', '')
            ->get();
            
        $count = $eventosInvalidos->count();
        
        if ($count === 0) {
            $this->info('No se encontraron eventos inválidos.');
            return 0;
        }
        
        $this->warn("Se encontraron {$count} eventos inválidos:");
        
        foreach ($eventosInvalidos as $evento) {
            $this->line("ID: {$evento->id_evento}, Empleado: {$evento->empleado_id}, Tipo: {$evento->tipo_evento}, Días: {$evento->dias}");
        }
        
        if ($this->confirm('¿Desea eliminar estos eventos inválidos?')) {
            $deleted = Evento::whereNull('id_evento')
                ->orWhere('id_evento', 0)
                ->orWhere('id_evento', '')
                ->delete();
                
            $this->info("Se eliminaron {$deleted} eventos inválidos.");
        } else {
            $this->info('Operación cancelada.');
        }
        
        return 0;
    }
}
