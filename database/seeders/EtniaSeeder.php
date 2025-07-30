<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etnias')->insert([
            ['nombre' => 'Indígena', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Afrocolombiano(a)', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Raizal del archipiélago', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Palenquero(a) de San Basilio', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gitano(a) (Rrom)', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sin pertenencia étnica', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
