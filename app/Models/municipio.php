<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'municipio';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_municipio';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_municipio',
        'ciudad_id',
    ];

    /**
     * Indica si el modelo debe tener marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con ciudad
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id_ciudad');
    }

    /**
     * Relación con barrios
     */
    public function barrios()
    {
        return $this->hasMany(Barrio::class, 'municipio_id', 'id_municipio');
    }

    /**
     * Relación con empleados (lugar de nacimiento)
     */
    public function empleadosNacidos()
    {
        return $this->hasMany(Empleado::class, 'municipio_id_nacimiento', 'id_municipio');
    }
}
