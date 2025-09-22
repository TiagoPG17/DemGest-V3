<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Depuración: Ver qué roles estamos verificando
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        $hasAnyRole = false;
        
        foreach ($roles as $role) {
            if (Auth::user()->hasRole($role)) {
                $hasAnyRole = true;
                break;
            }
        }

        if (!$hasAnyRole) {
            abort(403, 'No tienes permiso para acceder a esta página. Roles requeridos: ' . implode(', ', $roles) . ', Tus roles: ' . implode(', ', $userRoles));
        }

        return $next($request);
    }
}
