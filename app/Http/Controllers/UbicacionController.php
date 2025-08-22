<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barrio; // ajusta si tu modelo tiene otro namespace
use App\Models\Cargo; // Asegúrate de tener este use para el modelo Cargo

class UbicacionController extends Controller
{
    public function departamentos($paisId)
    {
        return DB::table('departamento')
            ->where('pais_id', $paisId)
            ->select('id_departamento', 'nombre_departamento')
            ->get();
    }

    public function municipios($departamentoId)
    {
        return DB::table('municipio')
            ->where('departamento_id', $departamentoId)
            ->select('id_municipio', 'nombre_municipio')
            ->get();
    }

    public function barrios($municipioId)
    {
        try {
            $barrios = Barrio::where('municipio_id', $municipioId)
                ->select('id_barrio', 'nombre_barrio')
                ->orderBy('nombre_barrio')
                ->get();

            return response()->json($barrios);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar los barrios'], 500);
        }
    }
}