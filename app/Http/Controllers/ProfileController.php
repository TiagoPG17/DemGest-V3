<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        
        $validated = $request->validated();

        $user->update($validated);

        Log::info('Perfil de usuario actualizado', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
            'timestamp' => now()->toISOString()
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        Log::info('Contraseña de usuario actualizada', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
            'timestamp' => now()->toISOString()
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}
