<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'tipo_documento';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_tipo_documento';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_tipo_documento',
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
        return $this->hasMany(Empleado::class, 'tipo_documento_id', 'id_tipo_documento');
    }

    /**
     * Relación con beneficiarios
     */
    public function beneficiarios()
    {
        return $this->hasMany(Beneficiario::class, 'tipo_documento_id', 'id_tipo_documento');
    }
}
