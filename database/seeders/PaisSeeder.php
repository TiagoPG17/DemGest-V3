<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pais')->insert([
            ['id_pais' => 1, 'nombre_pais' => 'Colombia'],
            ['id_pais' => 2, 'nombre_pais' => 'España'],
            ['id_pais' => 3, 'nombre_pais' => 'Venezuela'],
        ]);
    }
}