<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangoEdad extends Model
{
    use HasFactory;

    protected $table = 'rango_edad';
    protected $primaryKey = 'id_rango';
    protected $fillable = [
        'nombre_rango',
        'edad_minima',
        'edad_maxima',
    ];
    public $timestamps = false;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'rango_edad_id', 'id_rango');
    }
}
