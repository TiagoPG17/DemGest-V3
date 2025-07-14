<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\BarrioController;
Use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ContratoReporteController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas de autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
//Route::middleware(['auth'])->group(function () {

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
// Empleados
Route::resource('empleados', EmpleadoController::class);
Route::get('/empleados/report', [EmpleadoController::class, 'generateContractReport'])->name('empleados.report');
Route::get('/empleados/reporte/pdf', [EmpleadoController::class, 'descargarReporteContratos'])->name('empleados.report.pdf');

// Contratos PDF
Route::get('/generar-contrato/{id}', [ContratoController::class, 'generarContrato'])->name('contrato.generar');
Route::get('/reporte/centros-costos', [ContratoController::class, 'generateCostCenterReport'])->name('reporte.centros-costos');


// Reportes
Route::get('/reportes/contratos', [ContratoReporteController::class, 'index'])->name('contratos.index');
Route::get('/reportes/contratos/pdf', [ContratoReporteController::class, 'generarPDF'])->name('reportes.contratos.pdf');


// Perfil de usuario
Route::get('/perfil', [AuthController::class, 'perfil'])->name('perfil');

// API Ubicaciones
Route::get('/barrios', [BarrioController::class, 'index']);
Route::get('/api/departamentos/{paisId}', [UbicacionController::class, 'departamentos']);
Route::get('/api/municipios/{departamentoId}', [UbicacionController::class, 'municipios']);

Route::get('/info', function () {
    phpinfo();

// API BARRIOS
Route::get('/barrios', function () {$file = 'public/barrios.json';

    if (!Storage::exists($file)) {
        return response()->json(['error' => 'Archivo de barrios no encontrado.'], 404);
    }

    $barrios = json_decode(Storage::get($file), true);
    return response()->json($barrios);
});
});

