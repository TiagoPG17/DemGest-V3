<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles): bool
    {
        return $this->roles()->whereIn('name', (array)$roles)->exists();
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($role)
    {
        return $this->roles()->syncWithoutDetaching([$role]);
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * Mutator para asegurar que la contraseña siempre esté hasheada
     */
    public function setPasswordAttribute($value)
    {
        // Si la contraseña no está vacía y no empieza con el prefijo de Bcrypt
        if ($value && !str_starts_with($value, '$2y$')) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
