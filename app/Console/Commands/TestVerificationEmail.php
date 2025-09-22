<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Auth\Notifications\VerifyEmail;

class TestVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-verification-email {email? : Email address to send test verification email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test verification email with the new DemGest design';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@demgest.com';
        
        $this->info('Enviando correo de verificación de prueba a: ' . $email);
        
        // Crear un usuario de prueba
        $user = User::create([
            'name' => 'Usuario de Prueba',
            'email' => $email,
            'password' => bcrypt('password123'),
        ]);
        
        // Enviar la notificación de verificación
        $user->notify(new VerifyEmail());
        
        $this->info('¡Correo de verificación enviado con éxito!');
        $this->info('Revisa tu archivo de log en: storage/logs/laravel.log');
        $this->info('El correo usa el nuevo diseño de DemGest con branding personalizado.');
        
        // Opcional: eliminar el usuario de prueba
        if ($this->confirm('¿Deseas eliminar el usuario de prueba creado?', true)) {
            $user->delete();
            $this->info('Usuario de prueba eliminado.');
        }
    }
}
