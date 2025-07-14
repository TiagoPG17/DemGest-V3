<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoSanguineo extends Model
{
    protected $table = 'grupo_sanguineo'; 

    protected $fillable = ['nombre'];

    public $timestamps = false;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'grupo_sanguineo_id');
    }
}
