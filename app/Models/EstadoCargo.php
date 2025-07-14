<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCargo extends Model
{
    use HasFactory;

    protected $table = 'estado_cargo'; // Nombre de la tabla

    public $timestamps = true; 

    protected $fillable = [
        'estado_id',
        'cargo_id',
        'centro_costo_id',
    ];

    // Relaciones
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }

    public function cargo()
    {
        return $this->belongsTo(\App\Models\Cargo::class, 'cargo_id', 'id_cargo');
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costo_id', 'codigo');
    }
}
