<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArchivosAdjuntosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos empleados para asociar los archivos
        $empleados = Empleado::take(5)->get();
        
        if ($empleados->isEmpty()) {
            $this->command->info('No hay empleados disponibles. Por favor, ejecuta primero el seeder de empleados.');
            return;
        }

        $archivos = [];
        $tipos = ['contrato', 'hoja_de_vida', 'certificacion', 'otro_documento'];
        
        foreach ($empleados as $empleado) {
            $archivos[] = [
                'empleado_id' => $empleado->id_empleado,
                'nombre_archivo' => 'documento_' . uniqid() . '.pdf',
                'ruta_archivo' => 'archivos/empleados/' . $empleado->id_empleado . '/documentos/' . uniqid() . '.pdf',
                'tipo_archivo' => $tipos[array_rand($tipos)],
                'fecha_subida' => now(),
                'tamano' => rand(100, 5000), // Tamaño en KB
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('archivos_adjuntos')->insert($archivos);
    }
}
