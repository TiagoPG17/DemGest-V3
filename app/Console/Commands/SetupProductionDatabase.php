<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PDOException;

class SetupProductionDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:setup-production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configura la base de datos en producción con migraciones y seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando configuración de la base de datos en producción...');

        // Verificar conexión a la base de datos
        try {
            DB::connection()->getPdo();
            $this->info('✓ Conexión a la base de datos establecida correctamente.');
        } catch (PDOException $e) {
            $this->error('✗ No se pudo conectar a la base de datos. Verifica la configuración en .env');
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        // Ejecutar migraciones
        $this->info('\nEjecutando migraciones...');
        try {
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✓ Migraciones ejecutadas correctamente.');
        } catch (\Exception $e) {
            $this->error('✗ Error al ejecutar migraciones: ' . $e->getMessage());
            return 1;
        }

        // Ejecutar seeders
        $this->info('\nEjecutando seeders...');
        try {
            Artisan::call('db:seed', ['--force' => true, '--class' => 'DatabaseSeeder']);
            $this->info('✓ Seeders ejecutados correctamente.');
        } catch (\Exception $e) {
            $this->error('✗ Error al ejecutar seeders: ' . $e->getMessage());
            return 1;
        }

        // Limpiar caché
        $this->info('\nLimpiando caché...');
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            $this->info('✓ Caché limpiada correctamente.');
        } catch (\Exception $e) {
            $this->warn('⚠ No se pudo limpiar la caché: ' . $e->getMessage());
        }

        $this->info('\n¡Configuración de la base de datos completada con éxito! 🎉');
        $this->info('Usuario administrador creado:');
        $this->info('📧 Email: admin@example.com');
        $this->info('🔑 Contraseña: password');
        $this->warn('\n¡IMPORTANTE! Cambia la contraseña del administrador después del primer inicio de sesión.');

        return 0;
    }
}
