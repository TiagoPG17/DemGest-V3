<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';
    protected $primaryKey = 'id_cargo';
    protected $fillable = [
        'nombre_cargo',
        'id_dependencia',
        'empresa_id'
    ];
    public $timestamps = false;

    /**
     * Relación con estados (empleados que tienen o han tenido este cargo)
     */
    public function estados()
    {
        return $this->hasMany(Estado::class, 'cargo_id', 'id_cargo');
    }

    /**
     * Relación con empresas a través de estados (empresas donde ha existido este cargo)
     */
    public function empresas()
    {
        return $this->hasManyThrough(
            Empresa::class,
            Estado::class,
            'cargo_id',      // Foreign key on Estado
            'id_empresa',    // Foreign key on Empresa
            'id_cargo',      // Local key on Cargo
            'empresa_id'     // Local key on Estado
        )->distinct();
    }

    /**
     * Relación con departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id_departamento');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id_empresa');
    }

}