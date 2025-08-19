<?php
use App\Http\Controllers\UbicacionApiController;

Route::get('/departamentos/{pais}', [UbicacionApiController::class, 'departamentosPorPais']);
Route::get('/municipios/{departamento}', [UbicacionApiController::class, 'municipiosPorDepartamento']);
Route::get('/barrios/{municipio}', [UbicacionApiController::class, 'barriosPorMunicipio']);