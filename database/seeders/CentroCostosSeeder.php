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
                'descripcion' => 'Departamento de Administración',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20000',
                'nombre' => 'Ventas',
                'descripcion' => 'Departamento de Ventas',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20001',
                'nombre' => 'Comercial (Vendedores)',
                'descripcion' => 'Equipo de ventas comerciales',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20002',
                'nombre' => 'Despachos y bodega',
                'descripcion' => 'Área de logística y almacén',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30000',
                'nombre' => 'Producción',
                'descripcion' => 'Área de producción',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30001',
                'nombre' => 'Impresora NP1',
                'descripcion' => 'Máquina de impresión NP1',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30002',
                'nombre' => 'Impresora NP2',
                'descripcion' => 'Máquina de impresión NP2',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('centro_costos')->insert($centros);
        $this->command->info('Se han insertado ' . count($centros) . ' centros de costo en la base de datos.');
    }
}
