<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipiosParaInsertar = [];
        $id_municipio = 1;

        $datosMunicipios = [
            // Departamentos de Colombia (ID's 1-5 como en tu DepartamentoSeeder)
            1 => [ // Antioquia
                ['nombre_municipio' => 'Medellín'],
                ['nombre_municipio' => 'Bello'],
                ['nombre_municipio' => 'Itagüí'],
                ['nombre_municipio' => 'Envigado'],
                ['nombre_municipio' => 'Apartadó'],
            ],
            2 => [ // Cundinamarca
                ['nombre_municipio' => 'Soacha'],
                ['nombre_municipio' => 'Zipaquirá'],
                ['nombre_municipio' => 'Chía'],
                ['nombre_municipio' => 'Facatativá'],
                ['nombre_municipio' => 'Fusagasugá'],
            ],
            3 => [ // Valle del Cauca
                ['nombre_municipio' => 'Cali'],
                ['nombre_municipio' => 'Palmira'],
                ['nombre_municipio' => 'Buenaventura'],
                ['nombre_municipio' => 'Tuluá'],
                ['nombre_municipio' => 'Jamundí'],
            ],
            4 => [ // Atlántico
                ['nombre_municipio' => 'Barranquilla'],
                ['nombre_municipio' => 'Soledad'],
                ['nombre_municipio' => 'Malambo'],
                ['nombre_municipio' => 'Sabanalarga'],
                ['nombre_municipio' => 'Baranoa'],
            ],
            5 => [ // Santander
                ['nombre_municipio' => 'Bucaramanga'],
                ['nombre_municipio' => 'Floridablanca'],
                ['nombre_municipio' => 'Barrancabermeja'],
                ['nombre_municipio' => 'Girón'],
                ['nombre_municipio' => 'Piedecuesta'],
            ],

            // Departamentos de España (ID's 6-10 según tu DepartamentoSeeder)
            6 => [ // Madrid
                ['nombre_municipio' => 'Madrid'],
                ['nombre_municipio' => 'Móstoles'],
                ['nombre_municipio' => 'Alcalá de Henares'],
                ['nombre_municipio' => 'Fuenlabrada'],
                ['nombre_municipio' => 'Leganés'],
            ],
            7 => [ // Cataluña
                ['nombre_municipio' => 'Barcelona'],
                ['nombre_municipio' => 'L\'Hospitalet de Llobregat'],
                ['nombre_municipio' => 'Badalona'],
                ['nombre_municipio' => 'Terrassa'],
                ['nombre_municipio' => 'Sabadell'],
            ],
            8 => [ // Andalucía
                ['nombre_municipio' => 'Sevilla'],
                ['nombre_municipio' => 'Málaga'],
                ['nombre_municipio' => 'Córdoba'],
                ['nombre_municipio' => 'Granada'],
                ['nombre_municipio' => 'Jerez de la Frontera'],
            ],
            9 => [ // Galicia
                ['nombre_municipio' => 'Vigo'],
                ['nombre_municipio' => 'A Coruña'],
                ['nombre_municipio' => 'Ourense'],
                ['nombre_municipio' => 'Lugo'],
                ['nombre_municipio' => 'Santiago de Compostela'],
            ],
            10 => [ // Valencia
                ['nombre_municipio' => 'València'],
                ['nombre_municipio' => 'Alicante'],
                ['nombre_municipio' => 'Elche'],
                ['nombre_municipio' => 'Castelló de la Plana'],
                ['nombre_municipio' => 'Torrevieja'],
            ],

            // Departamentos de Venezuela (ID's 11-15 según tu DepartamentoSeeder)
            11 => [ // Distrito Capital
                ['nombre_municipio' => 'Caracas (Municipio Libertador)'],
                ['nombre_municipio' => 'Petare (Municipio Sucre)'], // Aunque de Miranda, es parte del área metropolitana
                ['nombre_municipio' => 'Chacao'], // Aunque de Miranda, es parte del área metropolitana
                ['nombre_municipio' => 'Baruta'], // Aunque de Miranda, es parte del área metropolitana
                ['nombre_municipio' => 'El Hatillo'], // Aunque de Miranda, es parte del área metropolitana
            ],
            12 => [ // Miranda
                ['nombre_municipio' => 'Los Teques'],
                ['nombre_municipio' => 'Guatire'],
                ['nombre_municipio' => 'Ocumare del Tuy'],
                ['nombre_municipio' => 'Santa Teresa del Tuy'],
                ['nombre_municipio' => 'Caucagua'],
            ],
            13 => [ // Zulia
                ['nombre_municipio' => 'Maracaibo'],
                ['nombre_municipio' => 'Cabimas'],
                ['nombre_municipio' => 'San Francisco'],
                ['nombre_municipio' => 'Ciudad Ojeda'],
                ['nombre_municipio' => 'Lagunillas'],
            ],
            14 => [ // Lara
                ['nombre_municipio' => 'Barquisimeto'],
                ['nombre_municipio' => 'Cabudare'],
                ['nombre_municipio' => 'Carora'],
                ['nombre_municipio' => 'El Tocuyo'],
                ['nombre_municipio' => 'Quíbor'],
            ],
            15 => [ // Carabobo
                ['nombre_municipio' => 'Valencia'],
                ['nombre_municipio' => 'Guacara'],
                ['nombre_municipio' => 'Puerto Cabello'],
                ['nombre_municipio' => 'Mariara'],
                ['nombre_municipio' => 'Naguanagua'],
            ],
        ];

        foreach ($datosMunicipios as $departamento_id => $municipiosEnDepartamento) {
            foreach ($municipiosEnDepartamento as $municipio) {
                $municipiosParaInsertar[] = [
                    'id_municipio' => $id_municipio,
                    'nombre_municipio' => $municipio['nombre_municipio'],
                    'departamento_id' => $departamento_id,
                ];
                $id_municipio++;
            }
        }

        DB::table('municipio')->insert($municipiosParaInsertar);
    }
}