<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    use HasFactory;
    protected $table = 'patologia';
    protected $primaryKey = 'id_patologia';


    protected $fillable = [
        'nombre_patologia',
        'fecha_diagnostico',
        'descripcion_patologia',
        'gravedad_patologia',
        'tratamiento_actual_patologia',
    ];


    protected $casts = [
        'fecha_diagnostico' => 'date',
    ];


    public $timestamps = false;
     function empleados()
    {
        return $this->belongsToMany(Empleado::class ,'empleado_patologia','patologia_id','empleado_id','id_patologia','id_empleado');
    }
}
