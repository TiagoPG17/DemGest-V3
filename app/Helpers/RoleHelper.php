<?php

if (!function_exists('hasRole')) {
    /**
     * Check if current authenticated user has a specific role.
     */
    function hasRole($role): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        return auth()->user()->hasRole($role);
    }
}

if (!function_exists('hasAnyRole')) {
    /**
     * Check if current authenticated user has any of the given roles.
     */
    function hasAnyRole($roles): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        return auth()->user()->hasAnyRole($roles);
    }
}

if (!function_exists('userRoles')) {
    /**
     * Get all roles of the current authenticated user.
     */
    function userRoles(): array
    {
        if (!auth()->check()) {
            return [];
        }
        
        return auth()->user()->roles->pluck('name')->toArray();
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is admin.
     */
    function is_admin(): bool
    {
        return hasRole('admin');
    }
}

if (!function_exists('is_gestion_humana')) {
    /**
     * Check if current user is from gestion humana.
     */
    function is_gestion_humana(): bool
    {
        return hasRole('gestion_humana');
    }
}

if (!function_exists('is_jefe')) {
    /**
     * Check if current user is jefe.
     */
    function is_jefe(): bool
    {
        return hasRole('jefe');
    }
}

if (!function_exists('is_empleado')) {
    /**
     * Check if current user is empleado.
     */
    function is_empleado(): bool
    {
        return hasRole('empleado');
    }
}

if (!function_exists('formatRoleName')) {
    /**
     * Format role name to be more readable and professional.
     */
    function formatRoleName($role): string
    {
        $roleNames = [
            'admin' => 'Administrador',
            'gestion_humana' => 'Gestión Humana',
            'jefe' => 'Jefe',
            'empleado' => 'Empleado'
        ];
        
        return $roleNames[$role] ?? ucfirst(str_replace('_', ' ', $role));
    }
}

if (!function_exists('getUserRoleNames')) {
    /**
     * Get formatted role names for the current authenticated user.
     */
    function getUserRoleNames(): array
    {
        if (!auth()->check()) {
            return [];
        }
        
        $roles = auth()->user()->roles->pluck('name')->toArray();
        return array_map('formatRoleName', $roles);
    }
}
