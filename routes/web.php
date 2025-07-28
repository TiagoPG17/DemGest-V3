<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ContratoReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta raíz
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Empleados
Route::resource('empleados', EmpleadoController::class);
Route::get('/empleados/report', [EmpleadoController::class, 'generateContractReport'])->name('empleados.report');
Route::get('/empleados/reporte/pdf', [EmpleadoController::class, 'descargarReporteContratos'])->name('empleados.report.pdf');

// Reportes
Route::get('/reportes/contratos', [ContratoReporteController::class, 'index'])->name('contratos.index');
Route::get('/reportes/contratos/pdf', [ContratoReporteController::class, 'generarPDF'])->name('reportes.contratos.pdf');

// API Ubicaciones y Barrios
Route::get('/api/departamentos/{paisId}', [UbicacionController::class, 'departamentos']);
Route::get('/api/municipios/{departamentoId}', [UbicacionController::class, 'municipios']);
Route::get('/barrios', [BarrioController::class, 'index']);

// Info de php
Route::get('/info', function () {
    phpinfo();
});
Route::get('/test', function () {
    return 'OK';
});
