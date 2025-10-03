<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Log;

class LogAuthenticated
{
    public function handle(Authenticated $event)
    {
        // Actualizar información de auditoría del usuario
        $event->user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
        
        Log::info('Usuario autenticado', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString()
        ]);
    }
}
