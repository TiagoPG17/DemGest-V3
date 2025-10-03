<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\ContratoReporteController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas para invitados (sin autenticaciÃ³n)
Route::middleware('guest')->group(function () {
    // Redirigir la raÃ­z al login para usuarios no autenticados
    Route::get('/', function () {
        return redirect()->route('login');
    });
});



// Rutas para invitados (sin autenticaciÃ³n)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Rutas que requieren autenticaciÃ³n
Route::middleware('auth')->group(function () {
    // Dashboard para usuarios autenticados
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas de empleados - PROTEGIDAS POR ROL
    
    // Rutas de escritura (solo admin y gestiÃ³n humana)
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create')
        ->middleware('role:admin,gestion_humana');
    
    // Rutas de lectura (admin, gestiÃ³n humana, jefes)
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index')
        ->middleware('role:admin,gestion_humana,jefe');
    
    Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show'])->name('empleados.show')
        ->middleware('role:admin,gestion_humana,jefe');
    
    
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store')
        ->middleware('role:admin,gestion_humana');
    
    Route::get('/empleados/{empleado}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit')
        ->middleware('role:admin,gestion_humana');
    
    Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update'])->name('empleados.update')
        ->middleware('role:admin,gestion_humana');
    
    Route::delete('/empleados/{empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy')
        ->middleware('role:admin,gestion_humana');
    
    // Ruta para eliminar eventos de empleado
    Route::delete('/empleados/{empleado}/eventos/{evento}', [EmpleadoController::class, 'eliminarEvento'])->name('empleados.eventos.destroy')
        ->middleware('role:admin,gestion_humana');
    
    // Ruta AJAX para verificar incapacidades activas
    Route::get('/empleados/{empleado}/verificar-incapacidad', [EmpleadoController::class, 'verificarIncapacidadActiva'])
        ->name('empleados.verificar-incapacidad')
        ->middleware('role:admin,gestion_humana');
    
    // Rutas de reportes (solo admin y gestiÃ³n humana)
    Route::get('/empleados/report', [EmpleadoController::class, 'generateContractReport'])->name('empleados.report')
        ->middleware('role:admin,gestion_humana');
    
    Route::get('/empleados/reporte/pdf', [EmpleadoController::class, 'descargarReporteContratos'])->name('empleados.report.pdf')
        ->middleware('role:admin,gestion_humana');
    
    // Rutas de reportes (solo admin y gestiÃ³n humana)
    Route::get('/reportes/contratos', [ContratoReporteController::class, 'index'])->name('contratos.index')
        ->middleware('role:admin,gestion_humana');
    
    Route::get('/reportes/contratos/pdf', [ContratoReporteController::class, 'generarPDF'])->name('reportes.contratos.pdf')
        ->middleware('role:admin,gestion_humana');

    // Rutas para todos los usuarios autenticados
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    Route::get('/api/departamentos/{paisId}', [UbicacionController::class, 'departamentos']);
    Route::get('/api/municipios/{departamentoId}', [UbicacionController::class, 'municipios']);
    Route::get('/api/barrios/{municipio}', [UbicacionController::class, 'barrios']);
    Route::get('/barrios', [BarrioController::class, 'index']);
    Route::get('/empresas/{empresa}/cargos', [CargoController::class, 'cargosPorEmpresa'])->name('empresas.cargos');
    
    // Rutas de autenticaciÃ³n
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});