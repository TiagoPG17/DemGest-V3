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
        )->whereNull('informacion_laboral.fecha_salida'); // ✅ Solo empleados realmente activos
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
     * Considera ambas relaciones: directa y a través de estado_cargo
     */
    public function getEmpleadosActivosCountAttribute()
    {
        return $this->getEmpleadosActivosQuery()->count();
    }

    /**
     * Obtiene la consulta base para empleados activos considerando ambas relaciones
     */
    public function getEmpleadosActivosQuery()
    {
        // Subconsulta para obtener empleados activos con relación directa
        $directos = DB::table('informacion_laboral as il')
            ->join('empleados as e', 'il.empleado_id', '=', 'e.id_empleado')
            ->where('il.centro_costo_id', $this->id)
            ->whereNull('il.fecha_salida') // ✅ Solo empleados realmente activos
            ->select('e.id_empleado');

        // Subconsulta para obtener empleados activos con relación a través de estado_cargo
        $aTravesEstadoCargo = DB::table('estado_cargo as ec')
            ->join('informacion_laboral as il', 'ec.estado_id', '=', 'il.id_estado')
            ->join('empleados as e', 'il.empleado_id', '=', 'e.id_empleado')
            ->where('ec.centro_costo_id', $this->id)
            ->whereNull('il.fecha_salida') // ✅ Solo empleados realmente activos
            ->select('e.id_empleado');

        // Unir ambas consultas y eliminar duplicados usando UNION
        return DB::table(DB::raw("({$directos->toSql()} UNION {$aTravesEstadoCargo->toSql()}) as empleados_unicos"))
            ->mergeBindings($directos)
            ->mergeBindings($aTravesEstadoCargo);
    }

    /**
     * Obtiene los centros de costo agrupados por empresa con conteo robusto de empleados
     */
    public static function getPorEmpresa($empresaId)
    {
        return self::select('centro_costos.*', 
                DB::raw('(
                    SELECT COUNT(DISTINCT e.id_empleado) 
                    FROM (
                        -- Empleados con relación directa
                        SELECT e.id_empleado
                        FROM informacion_laboral il
                        JOIN empleados e ON il.empleado_id = e.id_empleado
                        WHERE il.centro_costo_id = centro_costos.id
                        AND il.empresa_id = ' . $empresaId . '
                        AND il.fecha_salida IS NULL -- ✅ Solo empleados realmente activos
                        
                        UNION
                        
                        -- Empleados con relación a través de estado_cargo
                        SELECT e.id_empleado
                        FROM estado_cargo ec
                        JOIN informacion_laboral il ON ec.estado_id = il.id_estado
                        JOIN empleados e ON il.empleado_id = e.id_empleado
                        WHERE ec.centro_costo_id = centro_costos.id
                        AND il.empresa_id = ' . $empresaId . '
                        AND il.fecha_salida IS NULL -- ✅ Solo empleados realmente activos
                    ) as empleados_combinados
                ) as total_empleados'))
            ->where(function($query) use ($empresaId) {
                if ($empresaId == 1) {
                    $query->where('centro_costos.codigo', 'LIKE', 'CX_%');
                } elseif ($empresaId == 2) {
                    $query->where('centro_costos.codigo', 'LIKE', 'FC_%');
                }
            })
            ->orderBy('centro_costos.codigo')
            ->get();
    }

    /**
     * Obtiene todos los centros de costo con conteo robusto de empleados
     * Versión simplificada y confiable
     */
    public static function getTodosConConteoRobusto()
    {
        // Obtener todos los centros de costo
        $centros = self::orderBy('codigo')->get();
        
        // Para cada centro, contar los empleados activos
        foreach ($centros as $centro) {
            $centro->empleados_count = self::contarEmpleadosPorCentro($centro->id);
        }
        
        return $centros;
    }
    
    /**
     * Obtiene solo los centros de costo que tienen al menos 1 empleado
     * Filtra los centros con conteo de empleados mayor a 0
     */
    public static function getCentrosConEmpleados()
    {
        // Obtener todos los centros con conteo
        $centros = self::getTodosConConteoRobusto();
        
        // Filtrar solo los que tienen empleados
        return $centros->filter(function($centro) {
            return $centro->empleados_count > 0;
        });
    }
    
    /**
     * Cuenta empleados activos para un centro de costo específico
     * Método simplificado que funciona con la estructura actual
     */
    private static function contarEmpleadosPorCentro($centroCostoId)
    {
        // Contar empleados con relación a través de estado_cargo (esta es la relación correcta)
        $empleadosEstadoCargo = DB::table('estado_cargo as ec')
            ->join('informacion_laboral as il', 'ec.estado_id', '=', 'il.id_estado')
            ->join('empleados as e', 'il.empleado_id', '=', 'e.id_empleado')
            ->where('ec.centro_costo_id', $centroCostoId)
            ->whereNull('il.fecha_salida') // ✅ Solo empleados realmente activos
            ->count();
            
        return $empleadosEstadoCargo;
    }

    /**
     * Obtiene los totales por empresa (Contiflex y Formacol)
     * Versión simplificada y confiable
     */
    public static function getTotalesPorEmpresa()
    {
        // Obtener todos los centros con conteo
        $centros = self::getTodosConConteoRobusto();
        
        // Sumar por empresa
        $contiflexTotal = $centros->filter(function($centro) {
            return str_starts_with($centro->codigo, 'CX_');
        })->sum('empleados_count');
        
        $formacolTotal = $centros->filter(function($centro) {
            return str_starts_with($centro->codigo, 'FC_');
        })->sum('empleados_count');
        
        return [
            'contiflex' => $contiflexTotal,
            'formacol' => $formacolTotal
        ];
    }
}
