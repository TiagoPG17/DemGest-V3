<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;

class Afp extends Model
{
    protected $table = 'afp';
    protected $fillable = ['nombre'];
    public $timestamps = true;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'Afp_id');
    }
}
