<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado; 

class Ccf extends Model
{
    protected $table = 'ccf';
    protected $fillable = ['nombre'];
    public $timestamps = true;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'Ccf_id');
    }
}
