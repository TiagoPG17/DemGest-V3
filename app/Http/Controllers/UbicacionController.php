<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return DB::table('barrio')
            ->where('municipio_id', $municipioId)
            ->select('id_barrio', 'nombre_barrio')
            ->get();
    }
}