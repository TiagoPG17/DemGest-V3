<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivar claves foráneas
        DB::table('cargo')->truncate();             // Eliminar todo
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Reactivar claves

        DB::table('cargo')->insert([
            [
                'nombre_cargo' => 'ASESOR',
                'centro_costo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR ADMINISTRATIVA',
                'centro_costo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'SECRETARIO GENERAL',
                'centro_costo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'DIRECTOR DE PLANEACION FINANCIERA',
                'centro_costo_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'GERENTE',
                'centro_costo_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'GERENTE CORPORATIVA',
                'centro_costo_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'LIDER DE INVESTIGACIÓN DE MERCADOS',
                'centro_costo_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ANALISTA DE FORMACION Y DESARROLLO',
                'centro_costo_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'COORD SEGURIDAD Y SALUD EN EL TRABAJO',
                'centro_costo_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ASISTENTE FINANCIERO',
                'centro_costo_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR CARTERA Y COBRANZAS',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE COSTOS',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'CONTADOR (A)',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'COORDINADOR DE COSTOS',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'DIRECTOR DE CONTABILIDAD',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'LIDER DE COSTOS E INVENTARIOS',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'SUPERNUMERARIA',
                'centro_costo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ARQUITECTO DE SOFTWARE',
                'centro_costo_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ASISTENTE DE COMPRAS',
                'centro_costo_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ASESOR TECNICO DE NEGOCIOS',
                'centro_costo_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ASISTENTE COMERCIAL',
                'centro_costo_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'EJECUTIVO DE CUENTA',
                'centro_costo_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'SERVICIO AL CLIENTE',
                'centro_costo_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE ALMACENAMIENTO Y DESPACHO',
                'centro_costo_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE BODEGA (ALMACENISTA)',
                'centro_costo_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE FACTURACION Y DESPACHOS',
                'centro_costo_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'IMPRESOR NP1',
                'centro_costo_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'IMPRESOR NP2',
                'centro_costo_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'IMPRESOR NP3',
                'centro_costo_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'IMPRESORA KOPACK',
                'centro_costo_id' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE IMPRESION',
                'centro_costo_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'REBOBINADOR (A)',
                'centro_costo_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'COORDINADOR DE IMPRESION',
                'centro_costo_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR ADMINISTRATIVA',
                'centro_costo_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'OFICIOS VARIOS',
                'centro_costo_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'SERVICIOS GENERALES',
                'centro_costo_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'OPERARIO DE PRODUCCION',
                'centro_costo_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'COORDINADOR DE PRODUCCION',
                'centro_costo_id' => 19,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ELECTROMECANICO',
                'centro_costo_id' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'MECANICO DE MANTENIMIENTO',
                'centro_costo_id' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'OPERARIO MANUAL PREPRENSA',
                'centro_costo_id' => 21,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'COORDINADOR PREPENSA',
                'centro_costo_id' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'MONTAJISTA DIGITAL',
                'centro_costo_id' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'ANALISTA DE CALIDAD',
                'centro_costo_id' => 23,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE CALIDAD',
                'centro_costo_id' => 23,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'COORDINADOR DE PROGRAMACIÓN',
                'centro_costo_id' => 24,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_cargo' => 'AUXILIAR DE TINTAS',
                'centro_costo_id' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
