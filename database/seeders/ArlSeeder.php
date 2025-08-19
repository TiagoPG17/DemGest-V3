<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('arl')->insert([
            ['nombre' => 'Colmena', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Colpatria', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'La Equidad', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Positiva', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sura', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Bolívar', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
