<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'empresa';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_empresa';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_empresa',
        'nit_empresa',
        'direccion_empresa',
    ];

    /**
     * Indica si el modelo debe tener marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relación con estados (empleados que trabajan o han trabajado en la empresa)
     */
    public function estados()
    {
        return $this->hasMany(Estado::class, 'empresa_id', 'id_empresa');
    }

    /**
     * Obtener empleados activos de la empresa
     */
    public function empleadosActivos()
    {
        return $this->estados()
            ->whereNull('fecha_salida')
            ->with('empleado')
            ->get()
            ->pluck('empleado');
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class, 'empresa_id', 'id_empresa');
    }


    /**
     * Contar empleados activos
     */
    public function contarEmpleadosActivos()
    {
        return $this->estados()
            ->whereNull('fecha_salida')
            ->count();
    }

    /**
     * Obtener el color asociado a la empresa
     */
    public function getColorAttribute()
    {
        // Asignar colores según el nombre de la empresa
        if ($this->nombre_empresa === 'Formacol') {
            return 'red';
        } elseif ($this->nombre_empresa === 'Contiflex') {
            return 'blue';
        }
        
        return 'gray'; // Color por defecto
    }

    /**
     * Obtener las iniciales de la empresa
     */
    public function getInicialesAttribute()
    {
        if ($this->nombre_empresa === 'Formacol') {
            return 'FC';
        } elseif ($this->nombre_empresa === 'Contiflex') {
            return 'CF';
        }
        
        // Generar iniciales a partir del nombre
        $palabras = explode(' ', $this->nombre_empresa);
        $iniciales = '';
        
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $iniciales .= strtoupper(substr($palabra, 0, 1));
            }
        }
        
        return $iniciales;
    }
}
