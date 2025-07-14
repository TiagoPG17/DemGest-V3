<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Barrio;

class BarriosMedellinSeeder extends Seeder
{
    public function run()
    {
        $url = 'https://www.medellin.gov.co/servidormapas/rest/services/mapas_nacionales/VC_Limite_Politico_Admtivo/MapServer/0/query?where=1%3D1&outFields=nombre&f=json';

        try {
            $response = Http::withoutVerifying()->get($url);

            if (!$response->successful()) {
                $this->command->error('❌ Error al obtener datos de la API.');
                return;
            }

            $data = $response->json();

            if (!isset($data['features'])) {
                $this->command->error('❌ No se encontraron barrios en la respuesta.');
                return;
            }

            $barrios = collect($data['features'])
                ->pluck('attributes.nombre')
                ->filter()
                ->unique()
                ->sort();

            foreach ($barrios as $nombre) {
                Barrio::create([
                    'nombre_barrio' => $nombre,
                    'municipio_id' => 1 
                ]);
            }

            $this->command->info('✅ Barrios insertados correctamente en la base de datos.');

        } catch (\Exception $e) {
            $this->command->error('❌ Excepción al procesar la API: ' . $e->getMessage());
        }
    }
}
