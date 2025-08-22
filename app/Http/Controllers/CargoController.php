<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Support\Facades\Log;

class CargoController extends Controller
{
    public function cargosPorEmpresa($empresaId)
    {
        try {
            $cargos = Cargo::query()
                ->where('empresa_id', $empresaId)
                ->select(['id_cargo','nombre_cargo'])
                ->orderBy('nombre_cargo')
                ->get();

            return response()->json($cargos);
        } catch (\Throwable $e) {
            Log::error('cargosPorEmpresa error', [
                'empresaId' => $empresaId,
                'msg' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }

}
