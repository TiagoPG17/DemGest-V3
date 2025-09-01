<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;

class CentroCosto extends Model
{
    use HasFactory;

    protected $table = 'centro_costos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'codigo',
        'nombre',
    ];

    /**
     * Obtiene los empleados asignados a este centro de costos
     */
    public function empleados()
    {
        return $this->belongsToMany(
            'App\Models\Empleado',
            'informacion_laboral',
            'centro_costo_id',
            'empleado_id'
        )->where(function($query) {
            $query->whereNull('informacion_laboral.fecha_salida')
                  ->orWhere('informacion_laboral.fecha_salida', '>', now());
        });
    }

    /**
     * Obtiene la información laboral relacionada con este centro de costos
     */
    public function informacionLaboral()
    {
        return $this->hasMany('App\Models\InformacionLaboral', 'centro_costo_id');
    }

    /**
     * Obtiene el conteo de empleados activos por centro de costo
     */
    public function getEmpleadosActivosCountAttribute()
    {
        return $this->informacionLaboral()
            ->where(function($query) {
                $query->whereNull('fecha_salida')
                      ->orWhere('fecha_salida', '>', now());
            })
            ->count();
    }

    /**
     * Obtiene los centros de costo agrupados por empresa
     */
    public static function getPorEmpresa($empresaId)
    {
        return self::select('centro_costos.*', 
                DB::raw('COUNT(DISTINCT il.empleado_id) as total_empleados'))
            ->leftJoin('informacion_laboral as il', function($join) {
                $join->on('centro_costos.id', '=', 'il.centro_costo_id')
                    ->where(function($query) {
                        $query->whereNull('il.fecha_salida')
                              ->orWhere('il.fecha_salida', '>', now());
                    });
            })
            ->where('centro_costos.empresa_id', $empresaId)
            ->groupBy('centro_costos.id', 'centro_costos.codigo', 'centro_costos.nombre')
            ->orderBy('centro_costos.codigo')
            ->get();
    }
}
