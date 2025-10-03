<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Empleado;
use App\Models\Evento;
use App\Models\TipoDocumento;
use App\Models\RangoEdad;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Barrio;
use App\Models\Empresa;
use App\Models\Cargo;
use App\Models\Patologia;
use App\Models\Beneficiario;
use App\Models\InformacionLaboral;
use App\Models\EstadoCargo;
use App\Models\EmpleadoPatologia;
use App\Models\EmpleadoUbicacion;
use App\Models\GrupoSanguineo;
use App\Models\Etnia;
use App\Models\Eps;
use App\Models\Afp;
use App\Models\Arl;
use App\Models\Ccf;
use App\Models\Afc;
use App\Models\CiudadLaboral;
use App\Models\ArchivoAdjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Services\ProrrogaService;
use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;
use App\Helpers\AlertHelper;

class EmpleadoController extends Controller
{
    /**
     * Mostrar listado de empleados
     */
    public function index(Request $request)
    {
        // Manejar parámetros de error en la URL
        if ($request->has('error')) {
            $errorMessage = urldecode($request->query('error'));
            return redirect()->route('empleados.index')->with('error', $errorMessage);
        }
        
        // Manejar parámetros de éxito en la URL
        if ($request->has('success')) {
            $successMessage = urldecode($request->query('success'));
            return redirect()->route('empleados.index')->with('success', $successMessage);
        }
        
        $query = Empleado::with([
            'empresa',
            'cargo',
            'tipoDocumento',
            'nacimiento.pais',
            'nacimiento.departamento',
            'nacimiento.municipio',
            'barrioResidencia',
            'rangoEdad',
            'informacionLaboral.empresa',
        ]);

        // Filtros existentes
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('empresa_id')) {
            $query->whereHas('informacionLaboral', function ($q) use ($request) {
                $q->where('empresa_id', $request->empresa_id);
            });
        }

        if ($request->filled('cargo_id')) {
            $query->whereHas('informacionLaboral', function ($q) use ($request) {
                $q->where('cargo_id', $request->cargo_id);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre_completo', 'like', '%' . $searchTerm . '%')
                  ->orWhere('numero_documento', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('tipoDocumento', function ($q) use ($searchTerm) {
                      $q->where('nombre', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Paginación con filtros y ordenamiento
        $empleados = $query->paginate(10)->appends($request->all());

        $departamentos = Departamento::all();
        $empresas = Empresa::all();

        return view('empleados.index', compact('empleados', 'departamentos', 'empresas'));
    }

    /**
     * Descargar reporte de contratos por vencer
     */
    public function descargarReporteContratos()
    {
        try {
            $hoy = Carbon::now()->timezone('America/Bogota')->startOfDay();
            $fechaMinima = $hoy->copy()->addDays(28);
            $fechaMaxima = $hoy->copy()->addDays(41);

            $empleados = Empleado::with(['informacionLaboral' => function ($query) {
                $query->orderByDesc('updated_at')->limit(1);
            }])->get();

            Log::info("Total empleados recuperados: " . $empleados->count());

            $empleadosFiltrados = $empleados->map(function ($empleado) use ($hoy, $fechaMinima, $fechaMaxima) {
                $informacionLaboral = $empleado->informacionLaboral->first();

                if (!$informacionLaboral || !$informacionLaboral->fecha_prorroga || $informacionLaboral->fecha_salida !== null) {
                    return null;
                }

                $fechaProrroga = Carbon::parse($informacionLaboral->fecha_prorroga)->startOfDay();
                Log::debug("Empleado: {$empleado->nombre_completo}, Fecha prorroga: {$fechaProrroga}, Rango: {$fechaMinima} - {$fechaMaxima}");

                if ($fechaProrroga->between($fechaMinima, $fechaMaxima)) {
                    return [
                        'nombre_completo' => $empleado->nombre_completo,
                        'numero_documento' => $empleado->numero_documento,
                        'fecha_terminacion' => $fechaProrroga,
                        'dias_restantes' => $hoy->diffInDays($fechaProrroga, false),
                    ];
                }

                return null;
            })->filter();

            if ($empleadosFiltrados->isEmpty()) {
                return back()->with('info', 'No hay contratos por vencer en el rango de fechas establecido.');
            }

            $pdf = Pdf::loadView('contratos.reporte_pdf', ['empleados' => $empleadosFiltrados]);
            return $pdf->download('reporte_contratos.pdf');
        } catch (\Exception $e) {
            Log::error("Error generando el reporte de contratos: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al generar el reporte.');
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $datos = $this->cargarDatosComunes();
        return view('empleados.create', $datos);
    }

    /**
     * Almacenar nuevo empleado
     */
    public function store(StoreEmpleadoRequest $request)
    {
        $validated = $request->validated();

        try {
            return $this->ejecutarEnTransaccion(function() use ($validated, $request) {
                // Crear el empleado
                $empleado = Empleado::create([
                    'tipo_documento_id' => $validated['tipo_documento_id'],
                    'numero_documento' => $validated['numero_documento'],
                    'nombre_completo' => $validated['nombre_completo'],
                    'sexo' => $validated['sexo'],
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                    'estado_civil' => $validated['estado_civil'],
                    'nivel_educativo' => $validated['nivel_educativo'],
                    'email' => $validated['email'] ?? null,
                    'telefono' => $validated['telefono'] ?? null,
                    'telefono_fijo' => $request->input('telefono_fijo'),
                    'direccion' => $validated['direccion'] ?? null,
                    'grupo_sanguineo_id' => $validated['grupo_sanguineo_id'] ?? null,
                    'padre_o_madre' => $validated['padre_o_madre'] ?? null,
                    'tipo_vivienda' => $validated['tipo_vivienda'] ?? null,
                    'estrato' => $validated['estrato'] ?? null,
                    'vehiculo_propio' => $validated['vehiculo_propio'] ?? null,
                    'tipo_vehiculo' => $validated['tipo_vehiculo'] ?? null,
                    'movilidad' => $validated['movilidad'] ?? null,
                    'institucion_educativa' => $validated['institucion_educativa'] ?? null,
                    'intereses_personales' => $validated['intereses_personales'] ?? null,
                    'etnia_id' => $validated['etnia_id'] ?? null,
                    'idiomas' => $validated['idiomas'] ?? null,
                    'eps_id' => $validated['eps_id'] ?? null,
                    'afp_id' => $validated['afp_id'] ?? null,
                    'arl_id' => $validated['arl_id'] ?? null,
                    'ccf_id' => $validated['ccf_id'] ?? null,
                    'afc_id' => $validated['afc_id'] ?? null,
                ]);

                // Manejar archivos
                $this->manejarArchivoPrincipal($request, $empleado);
                $this->manejarFoto($request, $empleado);

                // Manejar ubicaciones
                $this->manejarUbicacion($empleado, $validated, 'NACIMIENTO');
                $this->manejarUbicacion($empleado, $validated, 'RESIDENCIA');

                // Crear información laboral
                $informacionLaboral = InformacionLaboral::create([
                    'empleado_id' => $empleado->id_empleado,
                    'empresa_id' => $validated['empresa_id'],
                    'fecha_ingreso' => $validated['fecha_ingreso'],
                    'fecha_salida' => $validated['fecha_salida'],
                    'tipo_contrato' => $validated['tipo_contrato'],
                    'observaciones' => $validated['observaciones'],
                    'ubicacion_fisica' => $validated['ubicacion_fisica'] ?? null,
                    'ciudad_laboral_id' => $request->input('ciudad_laboral_id'),
                    'tipo_vinculacion' => $request->input('tipo_vinculacion'),
                    'aplica_dotacion' => $request->has('aplica_dotacion') ? 1 : 0,
                    'talla_camisa' => $validated['talla_camisa'] ?? null,
                    'talla_pantalon' => $validated['talla_pantalon'] ?? null,
                    'talla_zapatos' => $validated['talla_zapatos'] ?? null,
                    'relacion_sindical' => $request->boolean('informacion_laboral.relacion_sindical'),
                    'relacion_laboral' => implode(',', $request->input('informacion_laboral.relacion_laboral', [])),
                ]);

                // Calcular prórrogas
                app(ProrrogaService::class)->calcular($informacionLaboral);

                // Asignar cargo
                $cargo = Cargo::findOrFail($validated['cargo_id']);
                EstadoCargo::create([
                    'estado_id' => $informacionLaboral->id_estado,
                    'cargo_id' => $cargo->id_cargo,
                    'centro_costo_id' => $cargo->centro_costo_id,
                ]);

                // Procesar relaciones
                $this->procesarPatologias($request, $empleado);
                $this->procesarBeneficiarios($request, $empleado);

                // Guardar eventos si se proporcionaron
                if ($request->has('eventos') && !empty($request->eventos['tipo_evento'])) {
                    $eventoData = $request->eventos;
                    if (!empty($eventoData['tipo_evento']) && !empty($eventoData['dias']) && !empty($eventoData['fecha_inicio'])) {
                        
                        // Validar días de vacaciones si el evento es de tipo vacaciones
                        if ($eventoData['tipo_evento'] === 'vacaciones') {
                            $validacion = $this->validarDiasVacacionesDisponibles($empleado, $eventoData['dias']);
                            
                            if (!$validacion['valido']) {
                                // Lanzar excepción para que la transacción haga rollback
                                throw new \Exception($validacion['mensaje']);
                            }
                        }
                        
                        Evento::create([
                            'empleado_id' => $empleado->id_empleado,
                            'tipo_evento' => $eventoData['tipo_evento'],
                            'dias' => $eventoData['dias'],
                            'fecha_inicio' => $eventoData['fecha_inicio'],
                            'fecha_fin' => $eventoData['fecha_fin'] ?? null,
                        ]);
                    }
                }

                return AlertHelper::success('empleados.show', 'Empleado creado exitosamente', ['empleado' => $empleado->id_empleado]);
            }, 'Empleado creado exitosamente', 'Error al crear el empleado');
        } catch (\Exception $e) {
            return AlertHelper::backWithError('Error al crear el empleado: ' . $e->getMessage());
        }
    }

    //Mostrar fomulario

    public function show(Empleado $empleado)
    {
        // Manejar parámetros de error en la URL
        if (request()->has('error')) {
            $errorMessage = urldecode(request()->query('error'));
            return redirect()->route('empleados.show', $empleado->id_empleado)->with('error', $errorMessage);
        }
        
        // Manejar parámetros de éxito en la URL
        if (request()->has('success')) {
            $successMessage = urldecode(request()->query('success'));
            return redirect()->route('empleados.show', $empleado->id_empleado)->with('success', $successMessage);
        }
        
        $empleado->load([
            'nacimiento.pais',
            'nacimiento.departamento',
            'nacimiento.municipio',
            'residencia.pais',
            'residencia.departamento',
            'residencia.municipio',
            'residencia.barrio',
            'barrioResidencia',
            'informacionLaboral.empresa',
            'patologias',
            'beneficiarios.tipoDocumento',
            'beneficiarios',
            'empresa',
            'informacionLaboral.estadoCargo.cargo',
            'rangoEdad',
            'archivosAdjuntos',
        ]);

        return view('empleados.show', compact('empleado'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Empleado $empleado)
    {
        $empleado->load([
            'tipoDocumento',
            'nacimiento.pais',
            'nacimiento.departamento',
            'nacimiento.municipio',
            'residencia.pais',
            'residencia.departamento',
            'residencia.municipio',
            'residencia.barrio',
            'barrioResidencia',
            'informacionLaboral.empresa',
            'informacionLaboral.estadoCargo.cargo',
            'informacionLaboral.ciudadLaboral',
            'patologias',
            'beneficiarios.tipoDocumento',
            'eps',
            'arl',
            'afp',
            'ccf',
        ]);

        $datosComunes = $this->cargarDatosComunes();
        
        $datosAdicionales = [
            'empleado' => $empleado,
            'informacionLaboral' => $empleado->informacionLaboralActual,
            'epsEmpleado' => $empleado->eps_id,
            'afpEmpleado' => $empleado->afp_id,
            'arlEmpleado' => $empleado->arl_id,
            'ccfEmpleado' => $empleado->ccf_id,
            'cargoSeleccionado' => optional($empleado->informacionLaboralActual?->estadoCargo)->cargo_id,
            'beneficiarios' => $empleado->beneficiarios->map(function ($item) {
                return [
                    'nombre_beneficiario' => $item->nombre_beneficiario,
                    'parentesco' => $item->parentesco,
                    'fecha_nacimiento' => optional($item->fecha_nacimiento)->format('Y-m-d'),
                    'tipo_documento_id' => $item->tipo_documento_id,
                    'numero_documento' => $item->numero_documento,
                    'nivel_educativo' => $item->nivel_educativo,
                    'reside_con_empleado' => $item->reside_con_empleado,
                    'depende_economicamente' => $item->depende_economicamente,
                    'contacto_emergencia' => $item->contacto_emergencia,
                ];
            })->toArray(),
            'patologias' => $empleado->patologias->map(function ($item) {
                return [
                    'nombre_patologia' => $item->nombre_patologia,
                    'fecha_diagnostico' => optional($item->fecha_diagnostico)->format('Y-m-d'),
                    'gravedad_patologia' => $item->gravedad_patologia,
                    'descripcion_patologia' => $item->descripcion_patologia,
                    'tratamiento_actual_patologia' => $item->tratamiento_actual_patologia,
                ];
            })->toArray(),
        ];

        return view('empleados.edit', array_merge($datosComunes, $datosAdicionales));
    }

    
    //Actualizar empleado
    
    public function update(UpdateEmpleadoRequest $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        
        return $this->ejecutarEnTransaccion(
            function() use ($request, $empleado) {
                // Actualizar datos básicos del empleado
                $empleado->update($request->only([
                    'tipo_documento_id',
                    'numero_documento',
                    'nombre_completo',
                    'sexo',
                    'fecha_nacimiento',
                    'estado_civil',
                    'nivel_educativo',
                    'email',
                    'telefono',
                    'direccion',
                    'pais_nacimiento_id',
                    'departamento_nacimiento_id', 
                    'municipio_nacimiento_id',
                    'tipo_vivienda',
                    'estrato',  
                    'vehiculo_propio',
                    'tipo_vehiculo',
                    'movilidad',
                    'institucion_educativa',
                    'intereses_personales',
                    'idiomas',
                    'grupo_sanguineo_id',
                    'etnia_id',
                    'padre_o_madre',
                    'eps_id',
                    'afp_id',
                    'arl_id',
                    'ccf_id',
                ]));

                // Actualizar ubicaciones
                $this->manejarUbicacion($empleado, $request->all(), 'NACIMIENTO');
                $this->manejarUbicacion($empleado, $request->all(), 'RESIDENCIA');

                // Actualizar información laboral
                $informacionLaboral = $empleado->informacionLaboral()->first();
                $informacionLaboral->update([
                    'empresa_id' => $request->empresa_id,
                    'fecha_ingreso' => $request->fecha_ingreso,
                    'fecha_salida' => $request->fecha_salida,
                    'tipo_contrato' => $request->tipo_contrato,
                    'observaciones' => $request->observaciones,
                    'ubicacion_fisica' => $request->ubicacion_fisica,
                    'ciudad_laboral_id' => $request->ciudad_laboral_id,
                    'tipo_vinculacion' => $request->tipo_vinculacion,
                    'proceso_gerencia' => $request->proceso_gerencia,
                    'relacion_laboral' => $request->relacion_laboral,
                    'relacion_sindical' => $request->relacion_sindical,
                    'aplica_dotacion' => $request->aplica_dotacion,
                    'talla_camisa' => $request->talla_camisa,
                    'talla_pantalon' => $request->talla_pantalon,
                    'talla_zapatos' => $request->talla_zapatos,
                ]);

                // Actualizar estado del cargo
                $cargo = Cargo::find($request->cargo_id);
                $centroCostoId = $cargo?->centro_costo_id;

                if (!$centroCostoId) {
                    Log::warning("El cargo con ID {$request->cargo_id} no tiene centro_costo_id definido.");
                }

                $estadoCargo = EstadoCargo::where('estado_id', $informacionLaboral->id_estado)->first();
                if ($estadoCargo) {
                    $estadoCargo->cargo_id = $request->cargo_id;
                    $estadoCargo->centro_costo_id = $centroCostoId;
                    $estadoCargo->save();
                } else {
                    EstadoCargo::create([
                        'estado_id' => $informacionLaboral->id_estado,
                        'cargo_id' => $request->cargo_id,
                        'centro_costo_id' => $centroCostoId,
                    ]);
                }

                // Calcular prórrogas
                $prorrogaService = new ProrrogaService();
                $prorrogaService->calcular($informacionLaboral);
                $informacionLaboral->save();

                // Procesar relaciones
                $this->procesarPatologias($request, $empleado);
                $this->procesarBeneficiarios($request, $empleado);

                // Manejar archivos
                $this->manejarArchivoPrincipal($request, $empleado, true);
                $this->manejarFoto($request, $empleado, true);

                // Guardar eventos si se proporcionaron
                if ($request->has('eventos') && !empty($request->eventos['tipo_evento'])) {
                    $eventoData = $request->eventos;
                    
                    if (!empty($eventoData['tipo_evento']) && !empty($eventoData['dias']) && !empty($eventoData['fecha_inicio'])) {
                        
                        // Validar días de vacaciones si el evento es de tipo vacaciones
                        if ($eventoData['tipo_evento'] === 'vacaciones') {
                            $validacion = $this->validarDiasVacacionesDisponibles($empleado, $eventoData['dias']);
                            
                            if (!$validacion['valido']) {
                                // Lanzar excepción para que la transacción haga rollback
                                throw new \Exception($validacion['mensaje']);
                            }
                        }
                        
                        Evento::create([
                            'empleado_id' => $empleado->id_empleado,
                            'tipo_evento' => $eventoData['tipo_evento'],
                            'dias' => $eventoData['dias'],
                            'fecha_inicio' => $eventoData['fecha_inicio'],
                            'fecha_fin' => $eventoData['fecha_fin'] ?? null,
                        ]);
                    }
                }
                
                // Retornar respuesta de éxito
                return AlertHelper::success('empleados.show', 'Empleado actualizado exitosamente', ['empleado' => $empleado->id_empleado]);
            },
            'Empleado actualizado exitosamente',
            'Error al actualizar el empleado'
        );
    }

    /**
     * Verificar si empleado tiene incapacidades activas (AJAX)
     */
    public function verificarIncapacidadActiva($id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            
            $incapacidadActiva = $empleado->eventos()
                ->where('tipo_evento', 'incapacidad')
                ->where('fecha_inicio', '<=', now())
                ->where('fecha_fin', '>=', now())
                ->exists();
            
            return response()->json([
                'tiene_incapacidad' => $incapacidadActiva,
                'mensaje' => $incapacidadActiva ? 
                    '⚠️ PROTECCIÓN LABORAL: Este empleado tiene una incapacidad médica activa.\n\nNo se puede despedir según la legislación laboral colombiana.' : 
                    null
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al verificar incapacidades: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar empleado
     */
    public function destroy(Empleado $empleado)
    {
        try {
            // Validar si el empleado tiene incapacidades activas
            $incapacidadActiva = $empleado->eventos()
                ->where('tipo_evento', 'incapacidad')
                ->where('fecha_inicio', '<=', now())
                ->where('fecha_fin', '>=', now())
                ->exists();
            
            if ($incapacidadActiva) {
                return redirect()->back()
                    ->with('error', '⚠️ PROTECCIÓN LABORAL: No se puede despedir a este empleado.\n\nEl empleado tiene una incapacidad médica activa que le otorga estabilidad laboral reforzada según la legislación colombiana.\n\nArtículo 24 del Código Sustantivo del Trabajo y Ley 100 de 1993.')
                    ->with('alerta_tipo', 'proteccion_laboral');
            }
            
            $empleado->patologias()->detach();
            $empleado->beneficiarios()->delete();
            $empleado->informacionLaboral()->delete();
            $empleado->delete();

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')
                ->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Manejar el archivo principal de documentación
     */
    private function manejarArchivoPrincipal($request, $empleado, $eliminarExistente = false)
    {
        if (!$request->hasFile('documento_principal')) {
            return;
        }

        // Eliminar archivo existente si se solicita
        if ($eliminarExistente) {
            $archivoExistente = ArchivoAdjunto::where('empleado_id', $empleado->id_empleado)
                ->where('nombre', 'Documentación General')
                ->first();

            if ($archivoExistente) {
                if (Storage::disk('public')->exists($archivoExistente->ruta)) {
                    Storage::disk('public')->delete($archivoExistente->ruta);
                }
                $archivoExistente->delete();
            }
        }

        $archivo = $request->file('documento_principal');
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $directorio = "empleados/{$empleado->id_empleado}/documentos";

        // Crear directorio si no existe
        if (!Storage::disk('public')->exists($directorio)) {
            Storage::disk('public')->makeDirectory($directorio, 0775, true);
        }

        // Guardar el archivo
        $ruta = $archivo->storeAs($directorio, $nombreArchivo, 'public');

        // Registrar en BD
        ArchivoAdjunto::create([
            'empleado_id'      => $empleado->id_empleado,
            'beneficiario_id'  => null,
            'nombre'           => 'Documentación General',
            'nombre_archivo'   => $nombreArchivo,
            'ruta'             => $ruta,
            'tipo'             => $archivo->getClientOriginalExtension(),
            'tipo_documento'   => 'documento_principal',
            'fecha_subida'     => now()
        ]);

        Log::info("Archivo de documentación general guardado para el empleado {$empleado->id_empleado}");
    }

    /**
     * Manejar la foto del empleado
     */
    private function manejarFoto($request, $empleado, $eliminarExistente = false)
    {
        // Eliminar foto si se solicita
        if ($request->has('delete_photo') && $request->delete_photo == '1') {
            if ($empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
                Log::info("Foto eliminada para el empleado {$empleado->id_empleado}");
            }
            $empleado->foto = null;
            $empleado->save();
        }

        if (!$request->hasFile('foto')) {
            return;
        }

        try {
            $foto = $request->file('foto');
            
            // Validar que sea una imagen
            if (!$foto->isValid() || !str_starts_with($foto->getMimeType(), 'image/')) {
                Log::warning('El archivo subido no es una imagen válida para el empleado ' . $empleado->id_empleado);
                throw new \Exception('El archivo debe ser una imagen válida');
            }
            
            // Eliminar foto anterior si existe
            if ($eliminarExistente && $empleado->foto && Storage::disk('public')->exists($empleado->foto)) {
                Storage::disk('public')->delete($empleado->foto);
                Log::info("Foto anterior eliminada para el empleado {$empleado->id_empleado}");
            }
            
            $ruta = "empleados/{$empleado->id_empleado}/foto";
            $nombre = 'foto_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            
            // Crear directorio si no existe
            if (!Storage::disk('public')->exists($ruta)) {
                Storage::disk('public')->makeDirectory($ruta, 0775, true);
            }
            
            // Guardar la foto
            $rutaCompleta = $foto->storeAs($ruta, $nombre, 'public');
            
            // Actualizar el empleado
            $empleado->foto = $rutaCompleta;
            $empleado->save();
            
            Log::info("Foto guardada exitosamente para el empleado {$empleado->id_empleado}: {$rutaCompleta}");
            
        } catch (\Exception $e) {
            Log::error("Error al guardar la foto del empleado {$empleado->id_empleado}: " . $e->getMessage());
            // No lanzamos la excepción para no interrumpir el proceso
        }
    }

    /**
     * Crear o actualizar ubicación de empleado
     */
    private function manejarUbicacion($empleado, $data, $tipo)
    {
        $ubicacionData = [
            'empleado_id' => $empleado->id_empleado,
            'tipo_ubicacion' => $tipo,
            'pais_id' => $data["pais_id_" . strtolower($tipo)] ?? null,
            'departamento_id' => $data["departamento_id_" . strtolower($tipo)] ?? null,
            'municipio_id' => $data["municipio_id_" . strtolower($tipo)] ?? null,
            'barrio_id' => $tipo === 'NACIMIENTO' ? null : ($data["barrio_id_" . strtolower($tipo)] ?? null),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Delete existing record for this location type to avoid duplicate entries
        DB::table('empleado_pais_ubicacion')
            ->where('empleado_id', $empleado->id_empleado)
            ->where('tipo_ubicacion', $tipo)
            ->delete();

        EmpleadoUbicacion::create($ubicacionData);
    }

    /**
     * Procesar patologías del empleado
     */
    private function procesarPatologias($request, $empleado)
    {
        if (!$request->has('patologias') || !is_array($request->patologias)) {
            $empleado->patologias()->detach();
            return;
        }

        $patologiaIdsToAttach = [];
        $patologiasData = $request->patologias;

        if (isset($patologiasData[0]) && is_array($patologiasData[0])) {
            // Formato de array de patologías
            foreach ($patologiasData as $index => $patologiaData) {
                if (!empty($patologiaData['nombre_patologia'])) {
                    $patologia = Patologia::create([
                        'nombre_patologia' => $patologiaData['nombre_patologia'],
                        'fecha_diagnostico' => $patologiaData['fecha_diagnostico'],
                        'gravedad_patologia' => $patologiaData['gravedad_patologia'],
                        'descripcion_patologia' => $patologiaData['descripcion_patologia'],
                        'tratamiento_actual_patologia' => $patologiaData['tratamiento_actual_patologia'],
                    ]);
                    $patologiaIdsToAttach[] = $patologia->id_patologia;
                }
            }
        }

        $empleado->patologias()->sync($patologiaIdsToAttach);
    }

    /**
     * Procesar beneficiarios del empleado
     */
    private function procesarBeneficiarios($request, $empleado)
    {
        if (!$request->has('beneficiarios') || !is_array($request->beneficiarios)) {
            $empleado->beneficiarios()->delete();
            return;
        }

        $empleado->beneficiarios()->delete();

        foreach ($request->input('beneficiarios', []) as $index => $beneficiarioData) {
            if (!empty($beneficiarioData['nombre_beneficiario']) && !empty($beneficiarioData['parentesco'])) {
                $empleado->beneficiarios()->create([
                    'nombre_beneficiario' => $beneficiarioData['nombre_beneficiario'],
                    'parentesco' => $beneficiarioData['parentesco'],
                    'fecha_nacimiento' => $beneficiarioData['fecha_nacimiento'],
                    'tipo_documento_id' => $beneficiarioData['tipo_documento_id'],
                    'numero_documento' => $beneficiarioData['numero_documento'],
                    'nivel_educativo' => $beneficiarioData['nivel_educativo'],
                    'reside_con_empleado' => array_key_exists('reside_con_empleado', $beneficiarioData) ? (int) $beneficiarioData['reside_con_empleado'] : null,
                    'depende_economicamente' => array_key_exists('depende_economicamente', $beneficiarioData) ? (int) $beneficiarioData['depende_economicamente'] : null,
                    'contacto_emergencia' => $beneficiarioData['contacto_emergencia'] ?? null,
                ]);
            }
        }
    }

    /**
     * Validar si un empleado tiene días de vacaciones disponibles
     * 
     * @param Empleado $empleado
     * @param int $diasSolicitados
     * @return array
     */
    private function validarDiasVacacionesDisponibles($empleado, $diasSolicitados = 0)
    {
        try {
            // Obtener información laboral actual
            $infoLaboral = $empleado->informacionLaboralActual;
            
            if (!$infoLaboral || !$infoLaboral->fecha_ingreso) {
                return [
                    'valido' => false,
                    'mensaje' => 'El empleado no tiene fecha de ingreso registrada',
                    'dias_disponibles' => 0
                ];
            }
            
            // Calcular días acumulados (1.25 días por mes trabajado)
            $fechaIngreso = \Carbon\Carbon::parse($infoLaboral->fecha_ingreso);
            $fechaActual = \Carbon\Carbon::now();
            $mesesTrabajados = $fechaIngreso->diffInMonths($fechaActual);
            $diasVacacionesAcumulados = $mesesTrabajados * 1.25;
            
            // Obtener días tomados de vacaciones
            $diasVacacionesTomados = $empleado->eventos()
                ->where('tipo_evento', 'vacaciones')
                ->sum('dias');
            
            // Calcular días pendientes
            $diasVacacionesPendientes = max(0, $diasVacacionesAcumulados - $diasVacacionesTomados);
            
            // Validar si hay suficientes días disponibles
            $valido = $diasVacacionesPendientes >= $diasSolicitados;
            
            return [
                'valido' => $valido,
                'mensaje' => $valido 
                    ? 'Días disponibles suficientes' 
                    : "El empleado solo tiene {$diasVacacionesPendientes} días de vacaciones disponibles. No puede solicitar {$diasSolicitados} días.",
                'dias_disponibles' => $diasVacacionesPendientes,
                'dias_acumulados' => $diasVacacionesAcumulados,
                'dias_tomados' => $diasVacacionesTomados
            ];
            
        } catch (\Exception $e) {
            Log::error('Error al validar días de vacaciones: ' . $e->getMessage());
            return [
                'valido' => false,
                'mensaje' => 'Error al calcular los días de vacaciones disponibles',
                'dias_disponibles' => 0
            ];
        }
    }

    /**
     * Cargar datos comunes para formularios
     */
    private function cargarDatosComunes()
    {
        return [
            'paises' => DB::table('pais')->get(),
            'tiposDocumento' => TipoDocumento::all(),
            'cargos' => DB::table('cargo')->get(),
            'empresas' => DB::table('empresa')->get(),
            'barrios' => DB::table('barrio')->get(),
            'departamentos' => Departamento::all(),
            'municipios' => Municipio::all(),
            'eps' => Eps::all(),
            'afp' => Afp::all(),
            'arl' => Arl::all(),
            'ccf' => Ccf::all(),
            'afcs' => Afc::all(),
            'ciudades' => DB::table('ciudades_laborales')->get(),
            'etnias' => Etnia::all(),
            'gruposSanguineos' => GrupoSanguineo::all(),
        ];
    }

    /**
     * Ejecutar operación dentro de una transacción con manejo de errores
     */
    private function ejecutarEnTransaccion($callback, $successMessage, $errorMessage)
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($errorMessage . ': ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Eliminar un evento de un empleado (route-model binding)
     */
    public function eliminarEvento(Empleado $empleado, Evento $evento)
    {
        try {
            // Verificar que el evento pertenece al empleado
            if ((int) $evento->empleado_id !== (int) $empleado->id_empleado) {
                return AlertHelper::backError('Evento no pertenece al empleado.');
            }

            $evento->delete();

            return AlertHelper::backSuccess('Evento eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar evento: ' . $e->getMessage());
            return AlertHelper::backError('Error al eliminar el evento.');
        }
    }
}
