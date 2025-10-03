<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
{
    public function handle(Failed $event)
    {
        Log::warning('Intento de login fallido', [
            'email' => $event->credentials['email'] ?? 'unknown',
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString()
        ]);
    }
}
