<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $tiposDocumento = [
            [
                'tipo_documento' => 'CC',
                'nombre_tipo_documento' => 'Cédula de Ciudadanía'
            ],
            [
                'tipo_documento' => 'TI',
                'nombre_tipo_documento' => 'Tarjeta de Identidad'
            ],
            [
                'tipo_documento' => 'CE',
                'nombre_tipo_documento' => 'Cédula de Extranjería'
            ],
            [
                'tipo_documento' => 'PA',
                'nombre_tipo_documento' => 'Pasaporte'
            ],
            [
                'tipo_documento' => 'NI',
                'nombre_tipo_documento' => 'NIT'
            ],
            [
                'tipo_documento' => 'PEP',
                'nombre_tipo_documento' => 'Permiso Especial de Permanencia (PEP)'
            ],
            [
                'tipo_documento' => 'PPT',
                'nombre_tipo_documento' => 'Permiso por Protección Temporal (PPT)'
            ],
            [
                'tipo_documento' => 'LC',
                'nombre_tipo_documento' => 'Licencia de Conducción'
            ],
            [
                'tipo_documento' => 'RC',
                'nombre_tipo_documento' => 'Registro Civil de Nacimiento'
            ],
        ];

        DB::table('tipo_documento')->insert($tiposDocumento);
    }
}