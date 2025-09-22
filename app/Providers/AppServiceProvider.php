<?php

namespace App\Providers;

use App\Models\Empleado;
use App\Models\User;
use App\Observers\EmpleadoObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useTailwind();
        
        // Registrar el EmpleadoObserver
        Empleado::observe(EmpleadoObserver::class);
        
        // Registrar el UserObserver para manejar el hashing de contraseñas
        User::observe(UserObserver::class);
    }

}


