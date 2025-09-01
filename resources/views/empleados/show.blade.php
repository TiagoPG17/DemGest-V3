@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4 space-y-6">
        <!-- Encabezado: Navegación y Acciones -->
        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center gap-2">
                <a href="{{ route('empleados.index') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-gray-300 bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m11 17-5-5 5-5" />
                        <path d="M6 12h14" />
                    </svg>
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detalles del Empleado</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                        <path d="m15 5 4 4" />
                    </svg>
                    Editar
                </a>
                <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este empleado?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </header>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Tarjeta principal con información del empleado -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Encabezado con información básica -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <?php
                        // Calcular las iniciales del nombre completo (solo las dos primeras palabras)
                        $iniciales = '';
                        if ($empleado->nombre_completo) {
                            $palabras = explode(' ', trim($empleado->nombre_completo));
                            $primerasDosPalabras = array_slice($palabras, 0, 2);
                            foreach ($primerasDosPalabras as $palabra) {
                                if (!empty($palabra)) {
                                    $iniciales .= strtoupper(substr($palabra, 0, 1));
                                }
                            }
                        }
                        
                        $infoLaboral = $empleado->informacionLaboralActual;
                    ?>
                    <div class="flex-shrink-0 w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-white text-2xl font-bold"
                         @class([
                             'bg-blue-500' => $infoLaboral?->empresa?->nombre_empresa && stripos(strtolower($infoLaboral->empresa->nombre_empresa), 'contiflex') !== false,
                             'bg-red-500' => $infoLaboral?->empresa?->nombre_empresa && stripos(strtolower($infoLaboral->empresa->nombre_empresa), 'formacol') !== false,
                         ])>
                        {{ $iniciales }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $empleado->nombre_completo }}</h2>
                        <div class="mt-2 flex flex-col sm:flex-row sm:flex-wrap sm:space-x-6 gap-2">
                            <!-- Cargo -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6a4 4 0 100 8 4 4 0 000-8zm0 14l-3.5-3.5m7 0L12 20m0-14V2" />
                                </svg>
                                {{ optional($infoLaboral?->estadoCargo?->cargo)->nombre_cargo ?? 'Sin cargo asignado' }}
                            </div>
                            <!-- Empresa -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M6 21V4a1 1 0 011-1h10a1 1 0 011 1v17M9 9h6m-6 4h6" />
                                </svg>
                                {{ optional($infoLaboral?->empresa)->nombre_empresa ?? 'Sin empresa asignada' }}
                            </div>
                            <!-- Fecha de ingreso -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Ingresó el {{ $infoLaboral?->fecha_ingreso?->format('d/m/Y') ?? 'No registrada' }}
                            </div>
                            <!-- Estado activo -->
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-{{ $empleado->estaActivo() ? 'green' : 'yellow' }}-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    @if($empleado->estaActivo())
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-.01-10a9 9 0 100 18 9 9 0 000-18z" />
                                    @endif
                                </svg>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold 
                                    {{ $empleado->estaActivo() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $empleado->estaActivo() ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs de información -->
            <div x-data="{ activeTab: 'personal' }">
                <!-- Navegación de tabs -->
                <nav class="border-b border-gray-200 flex -mb-px overflow-x-auto">
                    <button type="button" @click="activeTab = 'personal'" class="py-4 px-6 border-b-2 font-medium text-sm" :class="{ 'border-slate-800 text-slate-800': activeTab === 'personal', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-500': activeTab !== 'personal' }">
                        Información Personal
                    </button>
                    <button type="button" @click="activeTab = 'laboral'" class="py-4 px-6 border-b-2 font-medium text-sm" :class="{ 'border-slate-800 text-slate-800': activeTab === 'laboral', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'laboral' }">
                        Información Laboral
                    </button>
                    <button type="button" @click="activeTab = 'beneficiario'" class="py-4 px-6 border-b-2 font-medium text-sm" :class="{ 'border-slate-800 text-slate-800': activeTab === 'beneficiario', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'beneficiario' }">
                        Beneficiarios
                    </button>
                    <button type="button" @click="activeTab = 'extra'" class="py-4 px-6 border-b-2 font-medium text-sm" :class="{ 'border-slate-800 text-slate-800': activeTab === 'extra', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'extra' }">
                        Datos Adicionales
                    </button>
                    <button type="button" @click="activeTab = 'ubicacion'" class="py-4 px-6 border-b-2 font-medium text-sm" :class="{ 'border-slate-800 text-slate-800': activeTab === 'ubicacion', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'ubicacion' }">
                        Salud
                    </button>
                </nav>

                <!-- Contenido de los tabs -->
                <div class="p-6 space-y-6">
                    <!-- Tab: Información Personal -->
                    <div x-show="activeTab === 'personal'" class="space-y-6">
                        <div>
                        <section aria-label="Datos personales del empleado" class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Barra superior con color solido para verificar el funcionamiento -->
                        <div class="p-4 flex items-center gap-3" style="background:linear-gradient(90deg,#fde047,#f59e0b);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                        </svg>
                        <h3 class="text-lg font-medium text-white">Datos Personales</h3>
                    </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-yellow-100 border border-orange-200 rounded-lg p-4 relative">
                                <div>
                                    <dt class="font-medium text-gray-800">Tipo de Documento</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->tipoDocumento->nombre_tipo_documento ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Número de Documento</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->numero_documento ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Fecha de Nacimiento</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->fecha_nacimiento ? $empleado->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Edad</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->edad ?? 'No calculada' }} años</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Rango de Edad</dt>
                                    <dd class="mt-1 text-gray-900">
                                        {{ $empleado->rangoEdad ? $empleado->rangoEdad->edad_minima . ' a ' . $empleado->rangoEdad->edad_maxima . ' años' : 'No especificado' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">País</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->nacimiento->pais->nombre_pais ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Departamento</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->nacimiento->departamento->nombre_departamento ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Municipio</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->nacimiento->municipio->nombre_municipio ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Género</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->sexo ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Grupo Sanguíneo</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->grupoSanguineo->nombre ?? 'No especificado' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800">Nivel Educativo</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->nivel_educativo ?? 'No especificado' }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="font-medium text-gray-800">Estado Civil</dt>
                                    <dd class="mt-1 text-gray-900">{{ $empleado->estado_civil ?? 'No especificado' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </section>
                        </div>
                        <div>
                            <section aria-label="Información de Comunicación" class="bg-white rounded-lg shadow-sm border border-indigo-200">
                                <header class="bg-gradient-to-r from-purple-700 to-indigo-700 p-4 flex items-center gap-3 rounded-t-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path d="M21 10c0-5.5-4.5-10-10-10S1 4.5 1 10c0 7 10 13 10 13s10-6 10-13Z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-white">Información de Contacto</h3>
                                </header>
                                <div class="p-6">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-indigo-50 border border-indigo-300 rounded-lg p-4 relative">
                                        <div>
                                            <dt class="font-medium text-gray-800">Dirección</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->direccion ?? 'No especificada' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Teléfono</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->telefono ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Teléfono fijo</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->telefono_fijo ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Correo Electrónico</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->email ?? 'No especificado' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </section>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                            <section aria-label="Lugar de Residencia del empleado" class="bg-white rounded-lg shadow-sm border border-gray-200">
                                <header class="bg-cyan-600 p-4 flex items-center gap-3 rounded-t-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-white">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-white">Lugar de Residencia</h3>
                                </header>
                                <div class="p-6">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-sky-50 border border-sky-300 rounded-lg p-4 relative">
                                        <div>
                                            <dt class="font-medium text-gray-800">País</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->residencia->pais->nombre_pais ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Departamento</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->residencia->departamento->nombre_departamento ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Municipio</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->residencia->municipio->nombre_municipio ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Barrio</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->residencia->barrio->nombre_barrio ?? 'No especificado' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </section>
                        </div>
                    </div>
                    
                    <!-- Tab: Ubicación -->
                    <div x-show="activeTab === 'ubicacion'" class="space-y-6">
                            <!-- Sección: Discapacidades -->

                            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
                            <header class="bg-emerald-500 p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Patologías</h3>
                            </header>
                            <div class="p-6">
                                @if ($empleado->patologias->count() > 0)
                                    <div class="space-y-6">
                                        @foreach ($empleado->patologias as $patologia)
                                            <div class="bg-white border border-emerald-300 p-4 border border-emerald-200 rounded-lg bg-emerald-500 p-2">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="text-md font-semibold text-gray-900 flex items-center gap-2 p-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                                        </svg>
                                                        {{ $patologia->nombre_patologia }}
                                                    </h4>
                                                    @if ($patologia->gravedad_patologia)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if(strtolower($patologia->gravedad_patologia) == 'leve') bg-green-100 text-green-800 
                                                            @elseif(strtolower($patologia->gravedad_patologia) == 'moderada') bg-yellow-100 text-yellow-800 
                                                            @elseif(strtolower($patologia->gravedad_patologia) == 'severa') bg-red-100 text-red-800 
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            {{ $patologia->gravedad_patologia }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                                                    @if (isset($patologia->fecha_diagnostico))
                                                        <div class="col-span-1">
                                                            <dt class="font-medium text-gray-800">Fecha de Diagnóstico</dt>
                                                            <dd class="mt-1 text-gray-900">{{ $patologia->fecha_diagnostico ? \Carbon\Carbon::parse($patologia->fecha_diagnostico)->format('d/m/Y') : 'No especificada' }}</dd>
                                                        </div>
                                                    @endif
                                                    <div class="@if(isset($patologia->fecha_diagnostico)) col-span-1 @else col-span-2 @endif">
                                                        <dt class="font-medium text-gray-800">Descripción</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $patologia->descripcion_patologia ?? 'No especificada' }}</dd>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <dt class="font-medium text-gray-800">Tratamiento Actual</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $patologia->tratamiento_actual_patologia ?? 'No especificado' }}</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                            <path d="M12 17h.01" />
                                        </svg>
                                        <p class="mt-2 text-sm">No se han registrado patologías.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    



                    </div>

                    <!-- Tab: Información Laboral -->
                    <div x-show="activeTab === 'laboral'" class="space-y-6">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <header class="bg-sky-600 p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <rect x="2" y="7" width="20" height="15" rx="2" ry="2" />
                                    <path d="M12 22V7" />
                                    <path d="M7 2h10" />
                                    <path d="M12 7V2" />
                                    <path d="M12 22h-2" />
                                    <path d="M12 22h2" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Información Laboral</h3>
                            </header>
                            <div class="p-6">
                                @if ($empleado->informacionLaboralActual)
                                    @php
                                        $fechaIngreso = $empleado->informacionLaboralActual->fecha_ingreso;
                                        $fechaSalida = $empleado->informacionLaboralActual->fecha_salida;

                                        $duracion = [
                                            'diasTotales' => 0,
                                            'diasActuales' => 0,
                                            'texto' => 'Sin datos'
                                        ];

                                        $porcentaje = 0;

                                        if ($fechaIngreso) {
                                            $inicio = \Carbon\Carbon::parse($fechaIngreso);
                                            $hoy = \Carbon\Carbon::now();
                                            $fin = $fechaSalida ? \Carbon\Carbon::parse($fechaSalida) : $hoy;

                                            $diasTotales = $inicio->diffInDays($fin);

                                            if ($inicio->isFuture()) {
                                                $diasActuales = $hoy->diffInDays($inicio);
                                                $duracion['texto'] = "Comienza en " . intval($diasActuales) . " días";
                                                $porcentaje = 0;
                                            } else {
                                                $diasActuales = $inicio->diffInDays($hoy);

                                                $diff = $inicio->diff($hoy);
                                                $años = $diff->y;
                                                $meses = $diff->m;
                                                $días = $diff->d;

                                                $duracion['texto'] = "{$años} años, {$meses} meses y {$días} días";
                                                $porcentaje = $diasTotales > 0 ? min(100, round(($diasActuales / $diasTotales) * 100)) : 0;
                                            }

                                            $duracion['diasTotales'] = $diasTotales;
                                            $duracion['diasActuales'] = $diasActuales;
                                        }
                                    @endphp
                                @endif
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Columna Izquierda: Tiempo en la Empresa -->
                                    <div class="lg:col-span-1 bg-blue-50 p-4 rounded-lg flex flex-col items-center justify-center text-center shadow-inner">
                                        <div class="w-20 h-20 rounded-full bg-blue-200 flex items-center justify-center text-blue-800 text-3xl font-bold mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-700">
                                                <rect width="16" height="20" x="4" y="2" rx="2" ry="2" />
                                                <path d="M9 22v-4h6v4" />
                                                <path d="M8 6h.01" />
                                                <path d="M16 6h.01" />
                                                <path d="M8 10h.01" />
                                                <path d="M16 10h.01" />
                                                <path d="M8 14h.01" />
                                                <path d="M16 14h.01" />
                                                <path d="M12 6h.01" />
                                                <path d="M12 10h.01" />
                                                <path d="M12 14h.01" />
                                            </svg>
                                        </div>
                                        <div class="w-full">
                                            <p class="text-sm text-gray-500 mb-1">Tiempo en la empresa</p>
                                            <div class="w-full bg-blue-200 rounded-full h-2.5 dark:bg-blue-700">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $porcentaje }}%;"></div>
                                            </div>
                                            <p class="text-sm text-gray-900 mt-1">{{ $duracion['texto'] }}</p>
                                        </div>
                                    </div>
                                    <!-- Columnas Derechas: Detalles Laborales -->
                                    <dl class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700">
                                        <div>
                                            <dt class="font-medium text-gray-800">Cargo</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->informacionLaboralActual->estadoCargo->cargo->nombre_cargo ?? 'Sin cargo asignado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Fecha de Ingreso</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->informacionLaboralActual->fecha_ingreso->format('d/m/Y') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Fecha de Salida</dt>
                                            <dd class="mt-1 text-gray-900">
                                                {{ optional($empleado->informacionLaboralActual->fecha_salida)->format('d/m/Y') ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Tipo de Contrato</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->informacionLaboralActual->tipo_contrato ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Tipo de Vinculacion</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->informacionLaboralActual->tipo_vinculacion ?? 'No especificado' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Ciudad Laboral</dt>
                                            <dd class="mt-1 text-gray-900">
                                                {{ $empleado->informacionLaboralActual->ciudadLaboral->nombre ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">¿Aplica Dotación?</dt>
                                            <dd class="mt-1 text-gray-900">
                                                {{ $empleado->informacionLaboralActual->aplica_dotacion ? 'Sí' : 'No' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Talla de Camisa</dt>
                                            <dd class="mt-1 text-gray-900">
                                                {{ $empleado->informacionLaboralActual->talla_camisa ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Talla de Pantalón</dt>
                                            <dd class="mt-1 text-gray-900">
                                                {{ $empleado->informacionLaboralActual->talla_pantalon ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Talla de Zapatos</dt>
                                            <dd class="mt-1 text-gray-900">
                                                {{ $empleado->informacionLaboralActual->talla_zapatos ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        @php
                                            $informacion = $empleado->informacionLaboral->first();
                                        @endphp
                                        <div>
                                            <dt class="font-medium text-gray-800">Relación Laboral</dt>
                                            <dd class="mt-1 text-gray-900">{{ $informacion?->relacion_laboral ?? 'No especificada' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Relación Sindical</dt>
                                            <dd class="mt-1 text-gray-900">{{ $informacion?->relacion_sindical ? 'Sí' : 'No' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <!-- Archivos Adjuntos -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Archivos Adjuntos</h3>
                                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 space-y-6">
                                    @php
                                        $nombresArchivos = [
                                            'adjunto1' => 'Ver contrato',
                                            'adjunto2' => 'Ver cédula',
                                            'adjunto3' => 'Ver hoja de vida',
                                            'adjunto4' => 'Ver certificado',
                                        ];
                                    @endphp

                                    @forelse($empleado->archivosAdjuntos as $archivo)
                                        @php
                                            $campo = basename(dirname($archivo->ruta));
                                            $nombreMostrar = $nombresArchivos[$campo] ?? 'Documentos Iniciales';
                                        @endphp

                                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-6 py-6 flex flex-col items-center justify-between hover:shadow-md transition-all duration-200 min-h-[140px] w-full">
                                            <div class="flex flex-col items-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="font-semibold text-gray-800 text-sm text-center break-words">
                                                    {{ $nombreMostrar }}
                                                </span>
                                            </div>
                                            <a href="{{ Storage::url($archivo->ruta) }}" target="_blank" class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Ver archivo
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-sm italic">No hay archivos adjuntos disponibles.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Beneficiarios -->
                    <div x-show="activeTab === 'beneficiario'" class="space-y-6">
                        <section aria-label="Beneficiarios del empleado" class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Beneficiarios</h3>
                            </div>
                            <div class="p-6">
                                @if($empleado->beneficiarios->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($empleado->beneficiarios as $beneficiario)
                                            <div class="bg-pink-50 rounded-lg p-4 border border-pink-200 relative">
                                                <h4 class="text-md font-semibold text-gray-900 flex items-center gap-2 mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                                    </svg>
                                                    {{ $beneficiario->nombre_beneficiario }}
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-auto">
                                                        {{ $beneficiario->parentesco }}
                                                    </span>
                                                </h4>
                                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                                                    <div>
                                                        <dt class="font-medium text-gray-800">Fecha de Nacimiento</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $beneficiario->fecha_nacimiento ? \Carbon\Carbon::parse($beneficiario->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">Tipo de Documento</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $beneficiario->tipoDocumento->nombre_tipo_documento ?? 'No especificado' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">Número de Documento</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $beneficiario->numero_documento ?? 'No especificado' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">Nivel Educativo</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $beneficiario->nivel_educativo ?? 'No especificado' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">Edad</dt>
                                                        <dd class="mt-1 text-gray-900">{{ $beneficiario->edad }} años</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">¿Reside con el empleado?</dt>
                                                        <dd class="mt-1 text-gray-900">
                                                            {{ $beneficiario->reside_con_empleado ? 'Sí' : 'No' }}
                                                        </dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">¿Depende económicamente?</dt>
                                                        <dd class="mt-1 text-gray-900">
                                                            {{ $beneficiario->depende_economicamente ? 'Sí' : 'No' }}
                                                        </dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-medium text-gray-800">Contacto de emergencia</dt>
                                                        <dd class="mt-1 text-gray-900">
                                                            {{ $beneficiario->contacto_emergencia ?? 'No especificado' }}
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 17H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2z"></path>
                                            <path d="M10 10h4"></path>
                                            <path d="M10 14h4"></path>
                                            <path d="M10 18h4"></path>
                                        </svg>
                                        <p class="mt-2 text-sm">No se han registrado beneficiarios.</p>
                                    </div>
                                @endif
                            </div>
                        </section>
                        <hr class="my-6 border-gray-200">
                    </div>

                    <!-- Tab: Datos Adicionales -->
                    <div x-show="activeTab === 'extra'" class="space-y-6">
                        <section aria-label="Información adicional del empleado" class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <header class="bg-gradient-to-r from-indigo-600 to-blue-700 p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M12 11c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm0 0v8m0 0H4m8 0h8m0 0v-8m0 0c0-1.105-.895-2-2-2s-2 .895-2 2" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Información Adicional</h3>
                            </header>
                            <div class="p-6">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 text-sm text-gray-700 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div>
                                        <dt class="font-medium text-gray-800">Etnia</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->etnia->nombre ?? 'No especificado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">¿Es padre o madre?</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->padre_o_madre ? 'Sí' : 'No' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Tipo de Vivienda</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->tipo_vivienda }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Estrato</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->estrato }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">¿Vehículo propio?</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->vehiculo_propio ? 'Sí' : 'No' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Tipo de Vehículo</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->tipo_vehiculo }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Medio de Movilidad</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->movilidad }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Institución Educativa</dt>
                                        <dd class="mt-1 text-gray-900">{{ $empleado->institucion_educativa }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Idiomas</dt>
                                        <dd class="mt-1 text-gray-900 whitespace-pre-line">{{ $empleado->idiomas }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-800">Intereses Personales</dt>
                                        <dd class="mt-1 text-gray-900 whitespace-pre-line">{{ $empleado->intereses_personales }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </section>

                        <div class="grid grid-cols-1">
                            <section aria-label="Seguridad Social" class="bg-white rounded-lg shadow-sm border border-rose-200">
                                <header class="bg-gradient-to-r from-pink-600 to-rose-600 p-4 flex items-center gap-3 rounded-t-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 21V8a4 4 0 0 1 8 0v13" />
                                        <path d="M5 21V12a4 4 0 0 1 8 0v9" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-white">Afiliaciones a Seguridad Social</h3>
                                </header>
                                <div class="p-6">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-rose-50 border border-rose-300 rounded-lg p-4 relative">
                                        <div>
                                            <dt class="font-medium text-gray-800">EPS</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->eps->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">ARL</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->arl->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">AFP</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->afp->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">AFC</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->afc->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-gray-800">Caja de Compensación</dt>
                                            <dd class="mt-1 text-gray-900">{{ $empleado->ccf->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection