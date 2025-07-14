<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado; 

class Arl extends Model
{
    protected $table = 'arl';
    protected $fillable = ['nombre'];
    public $timestamps = true;

    public function empleados()
    {
        return $this->hasMany(Empleado::class , 'arl_id');
    }
}
