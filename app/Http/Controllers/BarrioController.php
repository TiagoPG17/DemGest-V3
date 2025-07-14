<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barrio;

class BarrioController extends Controller
{
    public function index()
    {
        $barrios = Barrio::with('municipio')->get();
        return response()->json([
            'status' => 'success',
            'data' => $barrios
        ], 200);
    }
}