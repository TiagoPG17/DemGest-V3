<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado; 

class Eps extends Model
{
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'eps_id'); 
    }
}
