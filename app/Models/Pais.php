<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'pais';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_pais';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_pais',
    ];

    /**
     * Indica si el modelo debe tener marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con departamentos
     */
    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'pais_id', 'id_pais');
    }

    /**
     * Relación con empleados (lugar de nacimiento)
     */
    public function empleadosNacidos()
    {
        return $this->hasMany(Empleado::class, 'pais_id_nacimiento', 'id_pais');
    }
}

