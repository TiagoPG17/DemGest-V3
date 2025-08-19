<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\TipoDocumento;
use App\Models\RangoEdad;
use App\Models\Pais;
use App\Models\Discapacidad;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Barrio;
use App\Models\Empresa;
use App\Models\Cargo;
use App\Models\Patologia;
use App\Models\Beneficiario;
use App\Models\InformacionLaboral;
use App\Models\EstadoCargo;
use App\Models\EmpleadoDiscapacidad;
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
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Services\ProrrogaService;
use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;

class EmpleadoController extends Controller
{
    /**
     * Mostrar listado de empleados
     */
    public function index(Request $request)
    {
        $query = Empleado::with([
            'empresa',
            'cargo',
            'tipoDocumento',
            'nacimiento.pais',
            'nacimiento.departamento',
            'nacimiento.municipio',
            'barrioResidencia',
            'rangoEdad',
            'informacionLaboral',
        ]);

        // Filtros existentes
        if ($request->filled('estado')) {
            $query->whereHas('informacionLaboral', function ($q) use ($request) {
                $q->where('estado', $request->input('estado'));
            });
        }

        if ($request->filled('empresa_id')) {
            $query->whereHas('informacionLaboral', function ($q) use ($request) {
                $q->where('empresa_id', $request->input('empresa_id'));
            });
        }

        $filtroEmpresa = $request->get('empresa', 'todos');
        if ($filtroEmpresa !== 'todos') {
            $query->whereHas('empresa', function ($q) use ($filtroEmpresa) {
                $q->where('nombre_empresa', 'like', '%' . $filtroEmpresa . '%');
            });
        }

        //  Lógica de ordenamiento dinámico
        $sortField = $request->get('sort', 'nombre_completo');
        $sortDirection = $request->get('direction', 'asc');

        $allowedSorts = ['nombre_completo', 'numero_documento'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        // Paginación con filtros y ordenamiento
        $empleados = $query->paginate(10)->appends($request->all());

        // Cargar relación para cada empleado
        foreach ($empleados as $empleado) {
            $empleado->load('informacionLaboral');
            $empleado->alerta_contrato = $empleado->necesitaAlerta();
        }

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

    //Mostrar Formulario

    public function create()
    {
        $paises = DB::table('pais')->get();
        $tiposDocumento = DB::table('tipo_documento')->get();
        $rangosEdad = DB::table('rango_edad')->get();
        $cargos = DB::table('cargo')->get();
        $empresas = DB::table('empresa')->get();
        $barrios = DB::table('barrio')->get();
        $departamentos = DB::table('departamento')->get();
        $municipios = DB::table('municipio')->get();
        $eps = Eps::all();
        $afp = Afp::all();
        $arl = Arl::all();
        $ccf = Ccf::all();
        $afcs = Afc::all();
        $ciudades = DB::table('ciudades_laborales')->get();
        $etnias = Etnia::all();
        $gruposSanguineos = GrupoSanguineo::all();

        return view('empleados.create', compact(
            'paises', 'tiposDocumento', 'rangosEdad', 'cargos', 'empresas', 'barrios',
            'departamentos', 'municipios', 'eps', 'afp', 'arl', 'ccf', 'afcs', 'ciudades', 'etnias', 'gruposSanguineos'
        ));
    }

    //Almacenar Nuevo Empleado

    public function store(StoreEmpleadoRequest $request)
{
    Log::info('Datos recibidos en store:', $request->all());
    Log::info('Conexión a DB: ' . DB::connection()->getDatabaseName());

    $validated = $request->validated();

    DB::beginTransaction();

    try {
        // Crear el empleado
        $empleado = Empleado::create([
            'tipo_documento_id' => $validated['tipo_documento_id'],
            'numero_documento' => $validated['numero_documento'],
            'nombre_completo' => $validated['nombre_completo'],
            'sexo' => $validated['sexo'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'estado_civil' => $validated['estado_civil'],
            'nivel_educativo' => $validated['nivel_educativo'],
            'rango_edad_id' => $validated['rango_edad_id'],
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

    	$documentosGenerales = [
	
    'cedula_ampliada' => 'Cédula ampliada',
    'libreta_militar' => 'Libreta militar',
    'diplomas_certificados' => 'Diplomas y certificados',
    'tarjeta_profesional' => 'Tarjeta profesional',
    'certificado_ultimo_empleo' => 'Certificado último empleo',
    'certificado_eps' => 'Certificado EPS',
    'certificado_afp' => 'Certificado AFP',
    'certificado_cesantias' => 'Certificado cesantías',
    'certificado_alturas' => 'Certificado alturas',
    'foto_digital' => 'Foto digital',
    'certificacion_bancaria' => 'Certificación bancaria'
];

//Guardar archivos adjuntos
foreach($documentosGenerales as $campo => $nombre) {
    if ($request->hasFile($campo)) {
        $archivo = $request->file($campo);
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $directorio = "empleados/{$empleado->id_empleado}/documentos";
        
        // Crear directorio si no existe
        if (!Storage::disk('public')->exists($directorio)) {
            Storage::disk('public')->makeDirectory($directorio, 0775, true);
        }

        // Guardar el archivo con permisos explícitos
        $ruta = $archivo->storeAs($directorio, $nombreArchivo, 'public');
        
        // Asegurar permisos
        $rutaCompleta = storage_path('app/public/' . $ruta);
        chmod($rutaCompleta, 0664);
        chmod(dirname($rutaCompleta), 0775);

        // Guardar en la base de datos
        ArchivoAdjunto::create([
            'empleado_id' => $empleado->id_empleado,
            'beneficiario_id' => null,
            'nombre' => $nombre,  // Usamos el nombre descriptivo en lugar del nombre del archivo
            'nombre_archivo' => $nombreArchivo,  // Guardamos el nombre del archivo
            'ruta' => $ruta,
            'tipo' => $archivo->getClientOriginalExtension(),
            'tipo_documento' => $campo,  // Guardamos el tipo de documento
            'fecha_subida' => now()  // Añadimos la fecha de subida
        ]);

        Log::info("Archivo {$campo} guardado y registrado en base de datos para el empleado {$empleado->id_empleado}");
    } else {
        Log::info("No se encontró archivo para el campo: {$campo}");
    }
}

            // Guardar ubicación de nacimiento
            EmpleadoUbicacion::create([
                'empleado_id' => $empleado->id_empleado,
                'tipo_ubicacion' => 'NACIMIENTO',
                'pais_id' => $validated['pais_id_nacimiento'],
                'departamento_id' => $validated['departamento_id_nacimiento'],
                'municipio_id' => $validated['municipio_id_nacimiento'],
                'barrio_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Guardar ubicación de residencia actual
            EmpleadoUbicacion::create([
                'empleado_id' => $empleado->id_empleado,
                'tipo_ubicacion' => 'RESIDENCIA',
                'pais_id' => $validated['pais_id_residencia'],
                'departamento_id' => $validated['departamento_id_residencia'],
                'municipio_id' => $validated['municipio_id_residencia'],
                'barrio_id' => $validated['barrio_id_residencia'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Crear información laboral
            Log::info('Intentando crear InformacionLaboral con datos:', $validated);
            Log::info('Conexión a DB antes de crear InformacionLaboral: ' . DB::connection()->getDatabaseName());

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
                'created_at' => now(),
                'updated_at' => now(),
                'relacion_sindical' => $request->boolean('informacion_laboral.relacion_sindical'),
                'relacion_laboral' => implode(',', $request->input('informacion_laboral.relacion_laboral', [])),
            ]);

            Log::info('InformacionLaboral creada con ID: ' . $informacionLaboral->id_estado);
            app(ProrrogaService::class)->calcular($informacionLaboral);
            Log::info('Prórrogas calculadas y guardadas');
            Log::info('Datos guardados en InformacionLaboral:', $informacionLaboral->toArray());

            // Asignar cargo a través de EstadoCargo
            $cargo = Cargo::findOrFail($validated['cargo_id']);
            EstadoCargo::create([
                'estado_id' => $informacionLaboral->id_estado,
                'cargo_id' => $cargo->id_cargo,
                'centro_costo_id' => $cargo->centro_costo_id,
            ]);
            Log::info('Estado cargo creado para estado ID: ' . $informacionLaboral->id_estado);

            // Sincronizar discapacidades
            if ($request->has('discapacidades') && is_array($request->discapacidades)) {
                $discapacidadIdsToSync = [];
                foreach ($validated['discapacidades'] as $index => $discapacidadData) {
                    Log::info("Procesando discapacidad #{$index}:", $discapacidadData);
                    if (!empty($discapacidadData['tipo_discapacidad']) && !empty($discapacidadData['grado_discapacidad'])) {
                        $discapacidad = Discapacidad::firstOrCreate(
                            [
                                'tipo_discapacidad' => $discapacidadData['tipo_discapacidad'],
                                'grado_discapacidad' => $discapacidadData['grado_discapacidad'],
                            ],
                            [
                                'fecha_diagnostico_discapacidad' => $discapacidadData['fecha_diagnostico_discapacidad'],
                                'enfermedad_base' => $discapacidadData['enfermedad_base'] ?? null,
                            ]
                        );
                        Log::info("Discapacidad creada/Encontrada con ID: {$discapacidad->id_discapacidad}");
                        $discapacidadIdsToSync[] = $discapacidad->id_discapacidad;
                    } else {
                        Log::warning("Discapacidad #{$index} no válida: tipo o grado vacío", $discapacidadData);
                    }
                }
                Log::info('Discapacidades a sincronizar:', $discapacidadIdsToSync);
                $empleado->discapacidades()->sync($discapacidadIdsToSync);
            } else {
                Log::info('No se recibieron discapacidades para sincronizar.');
                $empleado->discapacidades()->sync([]);
            }

            // Sincronizar patologías
            if ($request->has('patologias') && is_array($request->patologias)) {
                $empleado->patologias()->detach();
                $patologiaIdsToAttach = [];

                foreach ($validated['patologias'] as $index => $patologiaData) {
                    Log::info("Procesando patología #{$index}:", $patologiaData);
                    if (!empty($patologiaData['nombre_patologia'])) {
                        $patologia = Patologia::create([
                            'nombre_patologia' => $patologiaData['nombre_patologia'],
                            'fecha_diagnostico' => $patologiaData['fecha_diagnostico'],
                            'gravedad_patologia' => $patologiaData['gravedad_patologia'],
                            'descripcion_patologia' => $patologiaData['descripcion_patologia'],
                            'tratamiento_actual_patologia' => $patologiaData['tratamiento_actual_patologia'],
                        ]);
                        Log::info("Patología creada con ID: {$patologia->id_patologia}");
                        $patologiaIdsToAttach[] = $patologia->id_patologia;
                    } else {
                        Log::warning("Patología #{$index} no válida: nombre vacío", $patologiaData);
                    }
                }
                $empleado->patologias()->attach($patologiaIdsToAttach);
                Log::info('Patologías asociadas al empleado:', $patologiaIdsToAttach);
            } else {
                Log::info('No se recibieron patologías para sincronizar.');
                $empleado->patologias()->detach();
            }

            // Guardar beneficiarios
            if ($request->has('beneficiarios') && is_array($request->beneficiarios)) {
                foreach ($request->input('beneficiarios', []) as $index => $beneficiarioData) {
                    Log::info("Procesando beneficiario #{$index}:", $beneficiarioData);
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
                        Log::info("Beneficiario creado para empleado ID: {$empleado->id_empleado}");
                    } else {
                        Log::warning("Beneficiario #{$index} no válido: nombre o parentesco vacío", $beneficiarioData);
                    }
                    Log::info("Valor reside_con_empleado:", [$beneficiarioData['reside_con_empleado'] ?? 'NO DEFINIDO']);
                    Log::info("Valor depende_economicamente:", [$beneficiarioData['depende_economicamente'] ?? 'NO DEFINIDO']);
                }
            } else {
                Log::info('No se recibieron beneficiarios para guardar.');
            }

            DB::commit();
            return redirect()->route('empleados.show', $empleado->id_empleado)
                ->with('success', 'Empleado creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear el empleado: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Error al crear el empleado: ' . $e->getMessage());
        }
    }

    //Mostrar fomulario

    public function show(Empleado $empleado)
    {
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
            'discapacidades',
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
            'rangoEdad',
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
            'discapacidades',
            'patologias',
            'beneficiarios.tipoDocumento',
            'eps',
            'arl',
            'afp',
            'ccf',
        ]);

        $tiposDocumento = TipoDocumento::all();
        $rangosEdad = RangoEdad::all();
        $paises = Pais::all();
        $departamentos = Departamento::all();
        $municipios = Municipio::all();
        $barrios = Barrio::all();
        $empresas = Empresa::all();
        $cargos = Cargo::all();
        $eps = Eps::all();
        $arl = Arl::all();
        $afp = Afp::all();
        $ccf = Ccf::all();
        $ciudades = CiudadLaboral::all();
        $etnias = Etnia::all();
        $gruposSanguineos = GrupoSanguineo::all();

        $epsEmpleado = $empleado->eps_id;
        $afpEmpleado = $empleado->afp_id;
        $arlEmpleado = $empleado->arl_id;
        $ccfEmpleado = $empleado->ccf_id;
        $cargoSeleccionado = optional($empleado->informacionLaboralActual?->estadoCargo)->cargo_id;

        $informacionLaboral = $empleado->informacionLaboralActual;

        $beneficiarios = $empleado->beneficiarios->map(function ($item) {
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
        })->toArray();

        $discapacidades = $empleado->discapacidades->map(function ($item) {
            return [
                'tipo_discapacidad' => $item->tipo_discapacidad,
                'grado_discapacidad' => $item->grado_discapacidad,
                'fecha_diagnostico_discapacidad' => optional($item->fecha_diagnostico_discapacidad)->format('Y-m-d'),
                'enfermedad_base' => $item->enfermedad_base,
                'entidad_certificadora_discapacidad' => $item->entidad_certificadora_discapacidad,
            ];
        })->toArray();
        
        $patologias = $empleado->patologias->map(function ($item) {
            return [
                'nombre_patologia' => $item->nombre_patologia,
                'fecha_diagnostico' => optional($item->fecha_diagnostico)->format('Y-m-d'),
                'gravedad_patologia' => $item->gravedad_patologia,
                'descripcion_patologia' => $item->descripcion_patologia,
                'tratamiento_actual_patologia' => $item->tratamiento_actual_patologia,
            ];
        })->toArray();

        return view('empleados.edit', compact(
            'empleado',
            'informacionLaboral',
            'tiposDocumento',
            'rangosEdad',
            'paises',
            'departamentos',
            'municipios',
            'barrios',
            'empresas',
            'cargos',
            'beneficiarios',
            'discapacidades',
            'patologias',
            'eps',
            'arl',
            'afp',
            'ccf',
            'ciudades',
            'etnias',
            'gruposSanguineos',
            'epsEmpleado',
            'afpEmpleado',
            'arlEmpleado',
            'ccfEmpleado',
            'cargoSeleccionado'
        ));
    }

    
    //Actualizar empleado
    
    public function update(UpdateEmpleadoRequest $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        Log::info('Entró al método update del empleado con ID: ' . $empleado->id_empleado);
        Log::info('Validaciones pasadas, intentando actualizar...');

        DB::beginTransaction();

        try {
            $empleado->update($request->only([
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

            Log::info('Empleado actualizado con ID: ' . $empleado->id_empleado);

            // Actualizar ubicación de nacimiento
            DB::table('empleado_pais_ubicacion')
                ->where('empleado_id', $empleado->id_empleado)
                ->where('tipo_ubicacion', 'NACIMIENTO')
                ->delete();

            DB::table('empleado_pais_ubicacion')->insert([
                'empleado_id' => $empleado->id_empleado,
                'pais_id' => $request->pais_id_nacimiento,
                'departamento_id' => $request->departamento_id_nacimiento,
                'municipio_id' => $request->municipio_id_nacimiento,
                'tipo_ubicacion' => 'NACIMIENTO',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Actualizar ubicación de residencia
            DB::table('empleado_pais_ubicacion')
                ->where('empleado_id', $empleado->id_empleado)
                ->where('tipo_ubicacion', 'RESIDENCIA')
                ->delete();

            DB::table('empleado_pais_ubicacion')->insert([
                'empleado_id' => $empleado->id_empleado,
                'pais_id' => $request->pais_id_residencia,
                'departamento_id' => $request->departamento_id_residencia,
                'municipio_id' => $request->municipio_id_residencia,
                'barrio_id' => $request->barrio_id_residencia,
                'tipo_ubicacion' => 'RESIDENCIA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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

            // Obtener centro de costo desde el cargo
            $cargo = Cargo::find($request->cargo_id);
            $centroCostoId = $cargo?->centro_costo_id;

            if (!$centroCostoId) {
                Log::warning("El cargo con ID {$request->cargo_id} no tiene centro_costo_id definido.");
            }

            // Actualizar o crear EstadoCargo
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

            // Sincronizar discapacidades
            if ($request->has('discapacidades') && is_array($request->discapacidades)) {
                $discapacidadIdsToSync = [];
                foreach ($request->discapacidades as $index => $discapacidadData) {
                    Log::info("Procesando discapacidad #{$index}:", $discapacidadData);
                    if (!empty($discapacidadData['tipo_discapacidad']) && !empty($discapacidadData['grado_discapacidad'])) {
                        $discapacidad = Discapacidad::create([
                            'tipo_discapacidad' => $discapacidadData['tipo_discapacidad'],
                            'grado_discapacidad' => $discapacidadData['grado_discapacidad'] ?? null,
                            'fecha_diagnostico_discapacidad' => $discapacidadData['fecha_diagnostico_discapacidad'] ?? null,
                            'enfermedad_base' => $discapacidadData['enfermedad_base'] ?? null,

                        ]);
                        Log::info("Discapacidad creada con ID: {$discapacidad->id_discapacidad}");
                        $discapacidadIdsToSync[] = $discapacidad->id_discapacidad;
                    } else {
                        Log::warning("Discapacidad #{$index} no válida: tipo o grado vacío", $discapacidadData);
                    }
                }
                Log::info('Discapacidades a sincronizar:', $discapacidadIdsToSync);
                $empleado->discapacidades()->sync($discapacidadIdsToSync);
            } else {
                Log::info('No se recibieron discapacidades para sincronizar.');
                $empleado->discapacidades()->sync([]);
            }

            // Sincronizar patologías
            if ($request->has('patologias') && is_array($request->patologias)) {
                $patologiaIdsToSync = [];
                foreach ($request->patologias as $patologiaData) {
                    if (!empty($patologiaData['nombre_patologia'])) {
                        $patologia = Patologia::create([
                            'nombre_patologia' => $patologiaData['nombre_patologia'],
                            'fecha_diagnostico' => $patologiaData['fecha_diagnostico'] ?? null,
                            'gravedad_patologia' => $patologiaData['gravedad_patologia'] ?? null,
                            'descripcion_patologia' => $patologiaData['descripcion_patologia'] ?? null,
                            'tratamiento_actual_patologia' => $patologiaData['tratamiento_actual_patologia'] ?? null,
                        ]);
                        $patologiaIdsToSync[] = $patologia->id_patologia;
                    }
                }
                $empleado->patologias()->sync($patologiaIdsToSync);
            } else {
                $empleado->patologias()->sync([]);
            }

            Log::info('Beneficiarios recibidos:', $request->input('beneficiarios', []));
            if ($request->has('beneficiarios') && is_array($request->beneficiarios)) {
                $empleado->beneficiarios()->delete();

                foreach ($request->input('beneficiarios', []) as $index => $beneficiarioData) {
                    if (!empty($beneficiarioData['nombre_beneficiario']) && !empty($beneficiarioData['parentesco'])) {
                        $beneficiario = $empleado->beneficiarios()->create([
                            'nombre_beneficiario' => $beneficiarioData['nombre_beneficiario'],
                            'parentesco' => $beneficiarioData['parentesco'],
                            'fecha_nacimiento' => $beneficiarioData['fecha_nacimiento'],
                            'tipo_documento_id' => $beneficiarioData['tipo_documento_id'],
                            'numero_documento' => $beneficiarioData['numero_documento'],
                            'nivel_educativo' => $beneficiarioData['nivel_educativo'],
                            'reside_con_empleado' => $beneficiarioData['reside_con_empleado'] ?? null,
                            'depende_economicamente' => $beneficiarioData['depende_economicamente'] ?? null,
                            'contacto_emergencia' => $beneficiarioData['contacto_emergencia'] ?? null,
                        ]);
                        Log::info("Beneficiario creado/actualizado con ID: {$beneficiario->id_beneficiario} para empleado ID: {$empleado->id_empleado}");
                    } else {
                        Log::warning("Beneficiario #{$index} no válido: nombre o parentesco vacío", $beneficiarioData);
                    }
                }
            } else {
                Log::info('No se recibieron beneficiarios para actualizar.');
                $empleado->beneficiarios()->delete();
            }

            Log::info('Datos recibidos del request:', $request->all());
            DB::commit();
            Log::info('Empleado actualizado exitosamente');

            return redirect()->route('empleados.show', $empleado->id_empleado)
                ->with('success', 'Empleado actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar el empleado: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar empleado
     */
    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->discapacidades()->detach();
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
}
