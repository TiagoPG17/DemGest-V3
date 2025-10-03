<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
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
    'foto',
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

    // Accessor para obtener la URL completa de la foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            $url = Storage::url($this->foto);
            
            // Solo modificar URLs en entorno de desarrollo local
            if (config('app.env') === 'local' && config('mobile.enable_url_replacement', true)) {
                // Detectar automáticamente si estamos en desarrollo local
                $appUrl = config('app.url');
                
                // Si la URL contiene localhost o 127.0.0.1, reemplazar con IP de red
                if (strpos($url, 'localhost') !== false || strpos($url, '127.0.0.1') !== false) {
                    $serverIp = config('mobile.server_ip');
                    $protocol = config('mobile.protocol', 'http');
                    $port = config('mobile.server_port');
                    
                    if ($serverIp) {
                        // Reemplazar dominio local con IP de red
                        $url = str_replace(['localhost', '127.0.0.1'], $serverIp, $url);
                        
                        // Asegurar protocolo
                        $url = preg_replace('/^https?:\/\//', $protocol . '://', $url);
                        
                        // Añadir puerto si es necesario
                        if ($port && $port != '80' && strpos($url, ':' . $port) === false) {
                            $url = preg_replace('/(https?:\/\/[^\/]+)/', '$1:' . $port, $url);
                        }
                    }
                }
            }
            
            return $url;
        }
        return null;
    }

    // Método para verificar si el empleado tiene foto
    public function getTieneFotoAttribute()
    {
        return !empty($this->foto) && Storage::disk('public')->exists($this->foto);
    }

    // Método para compatibilidad con la vista show.blade.php
    public function getFotoPerfilActualAttribute()
    {
        if ($this->tieneFoto) {
            return (object)[
                'url' => $this->fotoUrl
            ];
        }
        return null;
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

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'empleado_id', 'id_empleado');
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

    /**
     * Obtener el estado actual del empleado considerando eventos activos
     */
    public function getEstadoActualAttribute()
    {
        $hoy = Carbon::today();
        
        // Buscar eventos activos (vacaciones o incapacidad) que estén en progreso hoy
        $eventoActivo = $this->eventos()
            ->whereIn('tipo_evento', ['vacaciones', 'incapacidad'])
            ->where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->first();
        
        if ($eventoActivo) {
            return match($eventoActivo->tipo_evento) {
                'vacaciones' => 'En vacaciones',
                'incapacidad' => 'En incapacidad',
                default => 'Activo'
            };
        }
        
        // Si no hay eventos activos, verificar estado normal
        return $this->estaActivo() ? 'Activo' : 'Inactivo';
    }

    /**
     * Obtener las clases CSS para el estado actual
     */
    public function getEstadoClasesAttribute()
    {
        return match($this->estado_actual) {
            'En vacaciones' => 'bg-blue-100 text-blue-800',
            'En incapacidad' => 'bg-red-100 text-red-800',
            'Activo' => 'bg-green-100 text-green-800',
            'Inactivo' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}

