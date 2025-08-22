<?php

use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\CargoController;

Route::get('/departamentos/{pais}', [UbicacionController::class, 'departamentos']);
Route::get('/municipios/{departamento}', [UbicacionController::class, 'municipios']);
Route::get('/barrios/{municipio}', [UbicacionController::class, 'barrios']);
Route::get('/cargos/{empresaId}', [CargoController::class, 'cargosPorEmpresa']);