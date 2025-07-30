<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seeders básicos (sin dependencias)
        $this->call([
            // Seeders para tablas de referencia básicas
            TipoDocumentoSeeder::class,
            PaisSeeder::class,
            DepartamentoSeeder::class,
            MunicipioSeeder::class,
            BarrioSeeder::class,
            
            // Seeders para entidades del sistema
            AfcSeeder::class,
            AfpSeeder::class,
            ArlSeeder::class,
            BancosSeeder::class,
            CajasCompensacionSeeder::class,
            CcfSeeder::class,
            DiscapacidadSeeder::class,
            EpsSeeder::class,
            EtniaSeeder::class,
            PatologiaSeeder::class,
            RangoEdadSeeder::class,
            
            // Seeders que dependen de los anteriores
            CargoSeeder::class,
            EmpresaSeeder::class,
            CentroCostosSeeder::class,
            
            // Seeders de datos principales
            EmpleadoSeeder::class,  // Asegúrate de que este seeder exista
            
            // Seeders de relaciones
            EmpleadoPatologiaSeeder::class,
            EmpleadoDiscapacidadSeeder::class,
            BeneficiarioSeeder::class,
            ArchivosAdjuntosSeeder::class,
        ]);

        // Crear usuario administrador si no existe
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $this->command->info('Usuario administrador creado con éxito.');
        } else {
            $this->command->info('El usuario administrador ya existe.');
        }
        
        $this->command->info('¡Base de datos sembrada exitosamente!');
    }
}
