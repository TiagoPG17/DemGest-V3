<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CcfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ccf')->insert([
            [
                'nombre' => 'Comfama',
                'nit' => '8909006086',
                'direccion' => 'Carrera 48 #18-62, Medellín',
                'telefono' => '6044488111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comfenalco Antioquia',
                'nit' => '8909800404',
                'direccion' => 'Carrera 50 #53-43, Medellín',
                'telefono' => '6045112121',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comfamiliar de Nariño',
                'nit' => '8002222222',
                'direccion' => 'Calle 18 #29-15, Pasto',
                'telefono' => '6027313131',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comfamiliar de Risaralda',
                'nit' => '8003333333',
                'direccion' => 'Carrera 7 #23-20, Pereira',
                'telefono' => '6063401010',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
