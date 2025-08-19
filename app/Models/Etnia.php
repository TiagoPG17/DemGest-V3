<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etnia extends Model
{
    protected $table = 'etnias';

    protected $fillable = ['nombre'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'etnia_id');
    }

}
