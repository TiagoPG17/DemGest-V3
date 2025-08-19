<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeneficiarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos empleados para asociar los beneficiarios
        $empleados = Empleado::take(3)->get();
        
        if ($empleados->isEmpty()) {
            $this->command->info('No hay empleados disponibles. Por favor, ejecuta primero el seeder de empleados.');
            return;
        }

        $beneficiarios = [];
        $parentescos = ['Hijo(a)', 'Cónyuge', 'Padre', 'Madre', 'Hermano(a)'];
        
        foreach ($empleados as $empleado) {
            // Crear 2 beneficiarios por empleado
            for ($i = 0; $i < 2; $i++) {
                $beneficiarios[] = [
                    'empleado_id' => $empleado->id_empleado,
                    'nombre_completo' => 'Beneficiario ' . ($i + 1) . ' de ' . $empleado->nombres,
                    'tipo_documento' => 'CC',
                    'numero_documento' => '10' . rand(1000000, 9999999),
                    'fecha_nacimiento' => now()->subYears(rand(5, 50))->format('Y-m-d'),
                    'parentesco' => $parentescos[array_rand($parentescos)],
                    'porcentaje' => 50, // Porcentaje de beneficiario
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('beneficiarios')->insert($beneficiarios);
    }
}
