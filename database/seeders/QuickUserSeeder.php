<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class QuickUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ejemplo de cómo crear usuarios con contraseñas hasheadas automáticamente
        $users = [
            [
                'name' => 'Empleado Ejemplo 1',
                'email' => 'empleado1@empresa.com',
                'password' => 'password123', // Laravel lo hashea automáticamente
            ],
            [
                'name' => 'Empleado Ejemplo 2', 
                'email' => 'empleado2@empresa.com',
                'password' => 'password123',
            ],
            // Agrega más usuarios aquí...
        ];

        foreach ($users as $userData) {
            User::create($userData);
            $this->command->info("Usuario creado: {$userData['email']}");
        }
    }
}
