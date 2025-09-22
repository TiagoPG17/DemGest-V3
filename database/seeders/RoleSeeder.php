<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles básicos
        $roles = [
            ['name' => 'admin', 'description' => 'Acceso total al sistema'],
            ['name' => 'gestion_humana', 'description' => 'Gestión completa de empleados'],
            ['name' => 'jefe', 'description' => 'Acceso de supervisión'],
            ['name' => 'empleado', 'description' => 'Acceso básico'],
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role['name'], 'guard_name' => 'web']);
        }

        // Asignar rol admin al primer usuario (ID 1)
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $adminUser->assignRole('admin');
            }
        }

        $this->command->info('Roles creados exitosamente!');
        $this->command->info('Rol admin asignado al usuario ID 1');
    }
}
