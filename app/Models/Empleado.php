<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
    'tipo_documento_id',
    'numero_documento',
    'nombre_completo',
    'sexo',
    'fecha_nacimiento',
    'estado_civil',
    'nivel_educativo',
    'rango_edad_id',
    'email',
    'telefono',
    'direccion',
    'grupo_sanguineo_id',
    'padre_o_madre',
    'tipo_vivienda',
    'estrato',
    'vehiculo_propio',
    'tipo_vehiculo',
    'movilidad',
    'institucion_educativa',
    'intereses_personales',
    'etnia_id',
    'idiomas',
    'eps_id', 
    'afp_id', 
    'arl_id', 
    'ccf_id',
    'afc_id',
    'telefono_fijo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'id_tipo_documento');
    }

    public function rangoEdad()
    {
        return $this->belongsTo(RangoEdad::class, 'rango_edad_id'); // ✅
    }


    public function barrioResidencia()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id_residencia', 'id_barrio');
    }

    public function informacionLaboral()
    {
        return $this->hasMany(\App\Models\InformacionLaboral::class, 'empleado_id', 'id_empleado');
    }

    public function informacionLaboralActual()
    {
        return $this->hasOne(\App\Models\InformacionLaboral::class, 'empleado_id', 'id_empleado')->latestOfMany('fecha_ingreso');
    }

    public function empresa()
    {
        return $this->hasOneThrough(
            Empresa::class,
            \App\Models\InformacionLaboral::class,
            'empleado_id',
            'id_empresa',
            'id_empleado',
            'empresa_id'
        );
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function eps()
    {
        return $this->belongsTo(\App\Models\Eps::class, 'eps_id');
    }

    public function afp()
    {
        return $this->belongsTo(\App\Models\Afp::class, 'afp_id');
    }

    public function arl()
    {
        return $this->belongsTo(\App\Models\Arl::class, 'arl_id');
    }

    public function ccf()
    {
        return $this->belongsTo(\App\Models\Ccf::class, 'ccf_id');
    }

    public function afc()
    {
        return $this->belongsTo(\App\Models\Afc::class);
    }


    public function patologias()
    {
        return $this->belongsToMany(Patologia::class, 'empleado_patologia', 'empleado_id', 'patologia_id')->using(\App\Models\EmpleadoPatologia::class);
    }

    public function beneficiarios()
    {
        return $this->hasMany(Beneficiario::class, 'empleado_id', 'id_empleado');
    }

    public function nacimiento()
    {
        return $this->hasOne(EmpleadoUbicacion::class, 'empleado_id')->where('tipo_ubicacion', 'NACIMIENTO');
    }

    public function residencia()
    {
        return $this->hasOne(EmpleadoUbicacion::class, 'empleado_id')->where('tipo_ubicacion', 'RESIDENCIA');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id_pais');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id_departamento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio');
    }

    public function departamentoNacimiento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id_nacimiento', 'id_departamento');
    }

    public function etnia()
    {
        return $this->belongsTo(Etnia::class);
    }

    public function archivosAdjuntos()
    {
        return $this->hasMany(\App\Models\ArchivoAdjunto::class, 'empleado_id', 'id_empleado');
    }

    public function grupoSanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'grupo_sanguineo_id');
    }

    public function necesitaAlerta()
    {
        $estado = $this->informacionLaboralActual;

        if (!$estado || !$estado->fecha_salida) {
            return false;
        }

        $fechaSalida = Carbon::parse($estado->fecha_salida);
        $hoy = Carbon::today();
        $duracion = $estado->duracion_prorrogas ?? 3;

        $fechaAlerta = $fechaSalida->copy()->subMonths($duracion - 1)->subWeek();

        return $hoy->between($fechaAlerta, $fechaSalida);
    }

    public function estaActivo()
    {
        $estado = $this->informacionLaboralActual;

        if (!$estado) {
            return false;
        }

        if (is_null($estado->fecha_salida)) {
            return true;
        }

        $fechaSalida = Carbon::parse($estado->fecha_salida);
        $hoy = Carbon::today();

        return $fechaSalida->greaterThanOrEqualTo($hoy);
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    public function setNombreCompletoAttribute($value)
    {
        $this->attributes['nombre_completo'] = mb_strtoupper($value, 'UTF-8');
    }
}

