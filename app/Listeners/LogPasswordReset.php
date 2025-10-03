<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

class LogPasswordReset
{
    public function handle(PasswordReset $event)
    {
        Log::info('Contraseña restablecida', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'timestamp' => now()->toISOString()
        ]);
    }
}
