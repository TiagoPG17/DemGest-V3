<?php
require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Role;

// Conectar a la base de datos
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Buscar tu usuario (cambia estos datos)
$email = 'tu@email.com';  // <-- CAMBIA ESTO por tu email
$userId = 1;              // <-- O cambia el ID de tu usuario

try {
    // Buscar usuario por email o ID
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        // Si no encuentra por email, buscar por ID
        $user = User::find($userId);
    }
    
    if (!$user) {
        echo "Usuario no encontrado. Verifica el email o ID.\n";
        exit(1);
    }
    
    echo "Usuario encontrado: " . $user->name . " (ID: " . $user->id . ")\n";
    
    // Asignar rol de admin
    $adminRole = Role::where('name', 'admin')->first();
    
    if (!$adminRole) {
        echo "Rol 'admin' no encontrado. Ejecuta primero el seeder.\n";
        exit(1);
    }
    
    // Verificar si ya tiene el rol
    if ($user->hasRole('admin')) {
        echo "El usuario ya tiene el rol de admin.\n";
    } else {
        $user->roles()->attach($adminRole->id);
        echo "Rol de admin asignado exitosamente.\n";
    }
    
    // Mostrar roles del usuario
    echo "Roles del usuario: ";
    foreach ($user->roles as $role) {
        echo $role->name . " ";
    }
    echo "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
