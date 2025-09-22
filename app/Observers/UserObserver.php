<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        $this->hashPassword($user);
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        // Only hash password if it has been changed
        if ($user->isDirty('password')) {
            $this->hashPassword($user);
        }
    }

    /**
     * Hash the user's password if it's not already hashed
     */
    private function hashPassword(User $user): void
    {
        if ($user->password && !str_starts_with($user->password, '$2y$')) {
            $user->password = Hash::make($user->password);
        }
    }
}
