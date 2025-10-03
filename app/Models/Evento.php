<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id';
    
    // Usar la PK personalizada para route model binding
    public function getRouteKeyName()
    {
        return 'id';
    }
    
    protected $fillable = [
        'empleado_id',
        'tipo_evento',
        'dias',
        'fecha_inicio',
        'fecha_fin',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'dias' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Tipos de eventos permitidos
    const TIPOS_EVENTO = [
        'vacaciones' => 'Vacaciones',
        'incapacidad' => 'Incapacidad',
        'permiso' => 'Permiso',
        'otro' => 'Otro'
    ];


    /**
     * Relación con el empleado
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }

    /**
     * Relación con el usuario que creó el evento
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Relación con el usuario que actualizó el evento
     */
    public function actualizador()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Restar días de vacaciones automáticamente
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($evento) {
            if ($evento->tipo_evento === 'vacaciones') {
                $info = $evento->empleado->informacionLaboralActual;
                
                // Validar que haya suficientes días disponibles
                if ($info->dias_vacaciones_acumulados < $evento->dias) {
                    throw new \Exception("No hay suficientes días de vacaciones disponibles. Disponibles: {$info->dias_vacaciones_acumulados}, Solicitados: {$evento->dias}");
                }
                
                // Restar los días
                $info->dias_vacaciones_acumulados -= $evento->dias;
                $info->save();
                
                // Registrar en log
                \Log::info("Días de vacaciones restados automáticamente", [
                    'empleado_id' => $evento->empleado_id,
                    'evento_id' => $evento->id,
                    'dias_restantes' => $evento->dias,
                    'dias_acumulados_restantes' => $info->dias_vacaciones_acumulados
                ]);
            }
        });
        
        static::deleted(function ($evento) {
            if ($evento->tipo_evento === 'vacaciones') {
                $info = $evento->empleado->informacionLaboralActual;
                
                // Devolver los días
                $info->dias_vacaciones_acumulados += $evento->dias;
                $info->save();
                
                // Registrar en log
                \Log::info("Días de vacaciones devueltos automáticamente", [
                    'empleado_id' => $evento->empleado_id,
                    'evento_id' => $evento->id,
                    'dias_devueltos' => $evento->dias,
                    'dias_acumulados_restantes' => $info->dias_vacaciones_acumulados
                ]);
            }
        });
    }

    /**
     * Scope para obtener eventos de un tipo específico
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo_evento', $tipo);
    }

    /**
     * Scope para obtener eventos en un rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->where(function($q) use ($fechaInicio, $fechaFin) {
            $q->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
              ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
              ->orWhere(function($q) use ($fechaInicio, $fechaFin) {
                  $q->where('fecha_inicio', '<=', $fechaInicio)
                    ->where('fecha_fin', '>=', $fechaFin);
              });
        });
    }

    /**
     * Scope para obtener eventos activos
     */
    public function scopeActivos($query)
    {
        return $query->whereIn('estado', ['aprobado', 'en_progreso']);
    }

    /**
     * Scope para obtener eventos de vacaciones
     */
    public function scopeVacaciones($query)
    {
        return $query->where('tipo_evento', 'vacaciones');
    }

    /**
     * Scope para obtener eventos de incapacidades
     */
    public function scopeIncapacidades($query)
    {
        return $query->where('tipo_evento', 'incapacidad');
    }

    /**
     * Verificar si el evento está actualmente en progreso
     */
    public function getEstaEnProgresoAttribute()
    {
        $hoy = Carbon::today();
        return $this->fecha_inicio <= $hoy && $this->fecha_fin >= $hoy;
    }

    /**
     * Verificar si el evento es futuro
     */
    public function getEsFuturoAttribute()
    {
        return $this->fecha_inicio > Carbon::today();
    }

    /**
     * Verificar si el evento ha finalizado
     */
    public function getHaFinalizadoAttribute()
    {
        return $this->fecha_fin < Carbon::today();
    }

    /**
     * Obtener la duración en días (ya calculada)
     */
    public function getDuracionAttribute()
    {
        return $this->dias;
    }

    /**
     * Obtener el nombre formateado del tipo de evento
     */
    public function getTipoEventoFormateadoAttribute()
    {
        return self::TIPOS_EVENTO[$this->tipo_evento] ?? ucfirst($this->tipo_evento);
    }

    /**
     * Obtener el nombre formateado del estado
     */
    public function getEstadoFormateadoAttribute()
    {
        return self::ESTADOS[$this->estado] ?? ucfirst($this->estado);
    }

    /**
     * Obtener el color según el tipo de evento
     */
    public function getColorTipoAttribute()
    {
        return match($this->tipo_evento) {
            'vacaciones' => 'blue',
            'incapacidad' => 'red',
            'permiso' => 'green',
            default => 'gray'
        };
    }

    /**
     * Obtener el icono según el tipo de evento
     */
    public function getIconoTipoAttribute()
    {
        return match($this->tipo_evento) {
            'vacaciones' => '🏖️',
            'incapacidad' => '🏥',
            'permiso' => '📋',
            default => '📅'
        };
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($evento) {
            // Solo procesar eventos de vacaciones aprobados
            if ($evento->tipo_evento === 'vacaciones' && $evento->estado === 'aprobado') {
                return $evento->restarDiasVacaciones();
            }
            return true;
        });

        static::updating(function ($evento) {
            // Procesar cambios en eventos de vacaciones
            if ($evento->tipo_evento === 'vacaciones') {
                // Si el estado cambió a aprobado, restar días
                if ($evento->isDirty('estado') && $evento->estado === 'aprobado') {
                    return $evento->restarDiasVacaciones();
                }
                
                // Si el estado cambió de aprobado a otro, devolver días
                if ($evento->isDirty('estado') && $evento->getOriginal('estado') === 'aprobado' && $evento->estado !== 'aprobado') {
                    return $evento->devolverDiasVacaciones();
                }
                
                // Si los días cambiaron y está aprobado, ajustar
                if ($evento->isDirty('dias') && $evento->estado === 'aprobado') {
                    return $evento->ajustarDiasVacaciones();
                }
            }
            return true;
        });

        static::deleting(function ($evento) {
            // Si se elimina un evento de vacaciones aprobado, devolver días
            if ($evento->tipo_evento === 'vacaciones' && $evento->estado === 'aprobado') {
                return $evento->devolverDiasVacaciones();
            }
            return true;
        });
    }

    /**
     * Restar días de vacaciones cuando se crea/aprueba un evento
     */
    public function restarDiasVacaciones()
    {
        try {
            $empleado = $this->empleado;
            $infoLaboral = $empleado->informacionLaboralActual;
            
            if (!$infoLaboral) {
                throw new \Exception('El empleado no tiene información laboral');
            }
            
            // Verificar si hay suficientes días disponibles
            $diasDisponibles = $infoLaboral->dias_vacaciones_acumulados;
            
            if ($diasDisponibles < $this->dias) {
                throw new \Exception("No hay suficientes días disponibles. Disponibles: {$diasDisponibles}, Solicitados: {$this->dias}");
            }
            
            // Restar los días solicitados
            $infoLaboral->dias_vacaciones_acumulados -= $this->dias;
            $infoLaboral->save();
            
            Log::info("Días de vacaciones restados para empleado {$empleado->nombre_completo} (ID: {$empleado->id_empleado}): -{$this->dias} días. Restante: {$infoLaboral->dias_vacaciones_acumulados}");
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error al restar días de vacaciones: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Devolver días de vacaciones cuando se cancela/rechaza un evento
     */
    public function devolverDiasVacaciones()
    {
        try {
            $empleado = $this->empleado;
            $infoLaboral = $empleado->informacionLaboralActual;
            
            if (!$infoLaboral) {
                throw new \Exception('El empleado no tiene información laboral');
            }
            
            // Devolver los días
            $infoLaboral->dias_vacaciones_acumulados += $this->dias;
            $infoLaboral->save();
            
            Log::info("Días de vacaciones devueltos para empleado {$empleado->nombre_completo} (ID: {$empleado->id_empleado}): +{$this->dias} días. Total: {$infoLaboral->dias_vacaciones_acumulados}");
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error al devolver días de vacaciones: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Ajustar días cuando se modifica la cantidad de días
     */
    public function ajustarDiasVacaciones()
    {
        try {
            $empleado = $this->empleado;
            $infoLaboral = $empleado->informacionLaboralActual;
            
            if (!$infoLaboral) {
                throw new \Exception('El empleado no tiene información laboral');
            }
            
            $diasAnterior = $this->getOriginal('dias');
            $diasNuevo = $this->dias;
            $diferencia = $diasNuevo - $diasAnterior;
            
            // Si se aumentaron los días, verificar disponibilidad
            if ($diferencia > 0) {
                $diasDisponibles = $infoLaboral->dias_vacaciones_acumulados;
                if ($diasDisponibles < $diferencia) {
                    throw new \Exception("No hay suficientes días disponibles para el ajuste. Disponibles: {$diasDisponibles}, Necesarios: {$diferencia}");
                }
            }
            
            // Ajustar los días
            $infoLaboral->dias_vacaciones_acumulados -= $diferencia;
            $infoLaboral->save();
            
            Log::info("Días de vacaciones ajustados para empleado {$empleado->nombre_completo} (ID: {$empleado->id_empleado}): {$diferencia} días. Total: {$infoLaboral->dias_vacaciones_acumulados}");
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error al ajustar días de vacaciones: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener días de vacaciones disponibles para un empleado
     */
    public static function getDiasVacacionesDisponibles($empleado)
    {
        $infoLaboral = $empleado->informacionLaboralActual;
        
        if (!$infoLaboral) {
            return 0;
        }
        
        return max(0, $infoLaboral->dias_vacaciones_acumulados);
    }

}
