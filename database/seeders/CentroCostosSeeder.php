<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCostosSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivar restricciones
        DB::table('centro_costos')->truncate();     // Vaciar tabla
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Reactivar restricciones

        DB::table('centro_costos')->insert([
            [
                'codigo' => 10000,
                'nombre' => 'Administración',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10001,
                'nombre' => 'Gerencia General',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10002,
                'nombre' => 'Gestion Humana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10003,
                'nombre' => 'Gerencia Financiera',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10004,
                'nombre' => 'Dirección Contable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10005,
                'nombre' => 'Dirección Sistemas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10006,
                'nombre' => 'Nómina',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 10007,
                'nombre' => 'Dirección de compras',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 20000,
                'nombre' => 'Ventas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 20001,
                'nombre' => 'Comercial (Vendedores)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 20002,
                'nombre' => 'Despachos y bodega',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 30001,
                'nombre' => 'Impresora NP1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 30002,
                'nombre' => 'Impresora NP2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 30003,
                'nombre' => 'Impresora NP3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 30004,
                'nombre' => 'Impresora Kopack',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 30005,
                'nombre' => 'Mano de obra directa operarios (aux)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 30006,
                'nombre' => 'Mano de obra directa rebobinado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40000,
                'nombre' => 'APOYO PRODUCCION',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40001,
                'nombre' => 'Gerencia de planta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40003,
                'nombre' => 'Mantenimiento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40004,
                'nombre' => 'Laboratorio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40005,
                'nombre' => 'Preprensa digital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40006,
                'nombre' => 'Calidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40007,
                'nombre' => 'Programacion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 40009,
                'nombre' => 'Tintas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
