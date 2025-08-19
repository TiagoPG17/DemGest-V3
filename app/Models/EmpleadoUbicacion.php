<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoUbicacion extends Model
{
    protected $table = 'empleado_pais_ubicacion';
    protected $primaryKey = 'id_empleado_pais_ubicacion'; // Asegúrate de que coincida con la tabla
    protected $keyType = 'int'; // Define el tipo de la clave primaria como entero
    public $incrementing = true; // Indica que es auto-incremental
    protected $fillable = ['empleado_id', 'tipo_ubicacion', 'pais_id', 'departamento_id', 'municipio_id', 'barrio_id', 'created_at', 'updated_at'];

    protected $casts = [
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }
}