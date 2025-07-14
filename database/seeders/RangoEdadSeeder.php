<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RangoEdadSeeder extends Seeder
{
    public function run()
    {
        // 🔒 Desactiva claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 🧹 Elimina todo y resetea el ID
        DB::table('rango_edad')->truncate();

        // 🔓 Reactiva claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 📌 Rellenar tabla con nuevos rangos
        $rangos = [
            ['min' => 18, 'max' => 25],
            ['min' => 25, 'max' => 30],
            ['min' => 30, 'max' => 35],
            ['min' => 35, 'max' => 40],
            ['min' => 40, 'max' => 45],
            ['min' => 45, 'max' => 50],
            ['min' => 50, 'max' => 55],
            ['min' => 55, 'max' => 60],
            ['min' => 60, 'max' => 65],
            ['min' => 65, 'max' => 70],
        ];

        foreach ($rangos as $rango) {
            DB::table('rango_edad')->insert([
                'edad_minima' => $rango['min'],
                'edad_maxima' => $rango['max'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
