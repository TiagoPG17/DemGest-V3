<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InformacionLaboral extends Model
{
    use HasFactory;

    protected $table = 'informacion_laboral';
    protected $primaryKey = 'id_estado';
    public $timestamps = true;

    protected $fillable = [
        'empleado_id',
        'empresa_id',
        'fecha_ingreso',
        'fecha_salida',
        'tipo_contrato',
        'observaciones',
        'ubicacion_fisica',
        'ciudad_laboral_id',
        'aplica_dotacion',
        'talla_camisa',
        'talla_pantalon',
        'talla_zapatos',
        'relacion_laboral',
        'relacion_sindical',
        'tipo_vinculacion',
    ];


    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_salida' => 'date',
        'aplica_dotacion' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id_empresa');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'id_cargo');
    }

    public function estadoCargo()
    {
        return $this->hasOne(\App\Models\EstadoCargo::class, 'estado_id', 'id_estado');
    }


    public function ciudadLaboral()
    {
        return $this->belongsTo(CiudadLaboral::class, 'ciudad_laboral_id');
    }


    // Utilidad para calcular duración
    public function getDuracionDiasAttribute()
    {
        $fechaInicio = $this->fecha_ingreso ? Carbon::parse($this->fecha_ingreso) : null;
        if (!$fechaInicio) {
            return ['diasTotales' => 0.0, 'texto' => 'Sin duración'];
        }

        $fin = $this->fecha_salida ? Carbon::parse($this->fecha_salida) : Carbon::now();
        $dias = $fechaInicio->diffInDays($fin);
        $texto = $this->getDuracionTexto($dias);
        return ['diasTotales' => (float) $dias, 'texto' => $texto];
    }

    private function getDuracionTexto($dias)
    {
        if ($dias >= 365) {
            $anos = floor($dias / 365);
            return $anos . ' año' . ($anos > 1 ? 's' : '');
        } elseif ($dias >= 30) {
            $meses = floor($dias / 30);
            return $meses . ' mes' . ($meses > 1 ? 'es' : '');
        } else {
            return $dias . ' día' . ($dias > 1 ? 's' : '');
        }
    }
}