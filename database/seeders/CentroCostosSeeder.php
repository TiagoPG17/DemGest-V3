<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCostosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero, verificar si ya existen registros para no duplicar
        if (DB::table('centro_costos')->count() > 0) {
            $this->command->info('La tabla centro_costos ya tiene datos. No se agregarán nuevos registros.');
            return;
        }

        $centros = [
            [
                'codigo' => '10000',
                'nombre' => 'Administración',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20000',
                'nombre' => 'Ventas',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20001',
                'nombre' => 'Comercial (Vendedores)',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20002',
                'nombre' => 'Despachos y bodega',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30000',
                'nombre' => 'Producción',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30001',
                'nombre' => 'Impresora NP1',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30002',
                'nombre' => 'Impresora NP2',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('centro_costos')->insert($centros);
        $this->command->info('Se han insertado ' . count($centros) . ' centros de costo en la base de datos.');
    }
}
