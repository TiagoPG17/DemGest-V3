<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivoAdjunto extends Model
{
    protected $table = 'archivos_adjuntos';

    protected $fillable = [
        'empleado_id',
        'beneficiario_id',
        'nombre',
        'ruta',
        'tipo',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class, 'beneficiario_id', 'id_beneficiario');
    }
}
