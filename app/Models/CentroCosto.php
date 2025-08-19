<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_centro',
        'descripcion',
    ];

    public function estados()
    {
        return $this->hasMany(Estado::class, 'centro_costo_id');
    }
}
