<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'discapacidad';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_discapacidad';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
    'tipo_discapacidad',
    'grado_discapacidad',
    'fecha_diagnostico_discapacidad',
    'enfermedad_base',
];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_diagnostico_discapacidad' => 'date',
    ];

    /**
     * Indica si el modelo debe tener marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con empleados
     */
    public function empleados()
    {
         return $this->belongsToMany(Empleado::class, 'empleado_discapacidad', 'discapacidad_id', 'empleado_id');
    }

}
