<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamento')->insert([
            // Colombia
            ['id_departamento' => 1, 'nombre_departamento' => 'Antioquia', 'pais_id' => 1],
            ['id_departamento' => 2, 'nombre_departamento' => 'Cundinamarca', 'pais_id' => 1],
            ['id_departamento' => 3, 'nombre_departamento' => 'Valle del Cauca', 'pais_id' => 1],
            ['id_departamento' => 4, 'nombre_departamento' => 'Atlántico', 'pais_id' => 1],
            ['id_departamento' => 5, 'nombre_departamento' => 'Santander', 'pais_id' => 1],
            // España
            ['id_departamento' => 6, 'nombre_departamento' => 'Madrid', 'pais_id' => 2],
            ['id_departamento' => 7, 'nombre_departamento' => 'Cataluña', 'pais_id' => 2],
            ['id_departamento' => 8, 'nombre_departamento' => 'Andalucía', 'pais_id' => 2],
            ['id_departamento' => 9, 'nombre_departamento' => 'Galicia', 'pais_id' => 2],
            ['id_departamento' => 10, 'nombre_departamento' => 'Valencia', 'pais_id' => 2],
            // Venezuela
            ['id_departamento' => 11, 'nombre_departamento' => 'Distrito Capital', 'pais_id' => 3],
            ['id_departamento' => 12, 'nombre_departamento' => 'Miranda', 'pais_id' => 3],
            ['id_departamento' => 13, 'nombre_departamento' => 'Zulia', 'pais_id' => 3],
            ['id_departamento' => 14, 'nombre_departamento' => 'Lara', 'pais_id' => 3],
            ['id_departamento' => 15, 'nombre_departamento' => 'Carabobo', 'pais_id' => 3],
        ]);
    }
}
