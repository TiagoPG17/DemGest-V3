<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoDiscapacidad extends Model
{
    use HasFactory;

    protected $table = 'empleado_discapacidad';
    protected $primaryKey = null; // No tiene clave primaria propia
    public $incrementing = false; // No es autoincremental
    protected $fillable = ['empleado_id', 'discapacidad_id'];
    public $timestamps = true;

    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_discapacidad', 'discapacidad_id', 'empleado_id');
    }


    public function discapacidad()
    {
        return $this->belongsTo(Discapacidad::class, 'discapacidad_id', 'id_discapacidad');
    }
}