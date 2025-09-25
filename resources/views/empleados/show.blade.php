
@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="max-w-4xl mx-auto p-4 space-y-6">
        <!-- Encabezado: Navegación y Acciones -->
        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 sm:p-6 rounded-2xl shadow-2xl border-4 border-grey-500">
            <div class="flex items-center gap-2">
                <a href="{{ route('empleados.index') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-gray-300 bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m11 17-5-5 5-5" />
                        <path d="M6 12h14" />
                    </svg>
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detalles del Empleado</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                <!-- Botón Editar (solo para admin y gestión humana) -->
                @if(is_admin() || is_gestion_humana())
                    <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="inline-flex items-center px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                            <path d="m15 5 4 4" />
                        </svg>
                        Editar
                    </a>
                @endif
                
                <!-- Botón Eliminar (solo para admin y gestión humana) -->
                @if(is_admin() || is_gestion_humana())
                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este empleado?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-2 py-2 sm:px-4 sm:py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                            Eliminar
                        </button>
                    </form>
                @endif
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
        <div class="bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden">
            <!-- Encabezado con información básica -->
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                    <!-- Foto de perfil -->
                    <div class="flex-shrink-0 mx-auto sm:mx-0">
                        <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                            @if($empleado->fotoPerfilActual)
                                <img src="{{ $empleado->fotoPerfilActual->url }}" 
                                    alt="Foto de perfil de {{ $empleado->nombre_completo }}" 
                                    class="w-full h-full object-cover"
                                    loading="lazy">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400" aria-label="Sin foto de perfil">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-16 sm:w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 min-w-0 text-left">
                    <?php
                        $infoLaboral = $empleado->informacionLaboralActual;
                    ?>
                        <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2 sm:mb-4">{{ $empleado->nombre_completo }}</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Cargo -->
                            <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6a4 4 0 100 8 4 4 0 000-8zm0 14l-3.5-3.5m7 0L12 20m0-14V2" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Cargo:</span>
                                    <p class="text-sm font-medium text-gray-900">{{ optional($infoLaboral?->estadoCargo?->cargo)->nombre_cargo ?? 'Sin cargo asignado' }}</p>
                                </div>
                            </div>
                            
                            <!-- Empresa -->
                            <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M6 21V4a1 1 0 011-1h10a1 1 0 011 1v17M9 9h6m-6 4h6" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Empresa:</span>
                                    <p class="text-sm font-medium text-gray-900">{{ optional($infoLaboral?->empresa)->nombre_empresa ?? 'Sin empresa asignada' }}</p>
                                </div>
                            </div>
                            
                            <!-- Fecha de ingreso -->
                            <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Ingresó:</span>
                                    <p class="text-sm font-medium text-gray-900">{{ $infoLaboral?->fecha_ingreso?->format('d/m/Y') ?? 'No registrada' }}</p>
                                </div>
                            </div>
                            
                            <!-- Estado activo -->
                            <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center @if($empleado->estaActivo()) bg-green-100 @else bg-yellow-100 @endif">
                                    <svg class="w-4 h-4 @if($empleado->estaActivo()) text-green-600 @else text-yellow-600 @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($empleado->estaActivo())
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-.01-10a9 9 0 100 18 9 9 0 000-18z" />
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Estado:</span>
                                    <p class="text-sm font-medium text-gray-900">{{ $empleado->estaActivo() ? 'Activo' : 'Inactivo' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs de información -->
            <div x-data="{ activeTab: 'personal' }">
                <!-- Navegación de tabs -->
                <div class="border-b border-gray-200">
                    <!-- Tabs para desktop -->
                    <nav class="hidden sm:flex -mb-px justify-center">
                        <div class="flex space-x-1">
                            <button type="button" @click="activeTab = 'personal'" class="py-3 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200 rounded-t-lg" :class="{ 'border-slate-800 text-slate-800 bg-slate-50 shadow-sm': activeTab === 'personal', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'personal' }">
                                Información Personal
                            </button>
                            <button type="button" @click="activeTab = 'laboral'" class="py-3 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200 rounded-t-lg" :class="{ 'border-slate-800 text-slate-800 bg-slate-50 shadow-sm': activeTab === 'laboral', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'laboral' }">
                                Información Laboral
                            </button>
                            <button type="button" @click="activeTab = 'beneficiario'" class="py-3 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200 rounded-t-lg" :class="{ 'border-slate-800 text-slate-800 bg-slate-50 shadow-sm': activeTab === 'beneficiario', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'beneficiario' }">
                                Beneficiarios
                            </button>
                            <button type="button" @click="activeTab = 'extra'" class="py-3 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200 rounded-t-lg" :class="{ 'border-slate-800 text-slate-800 bg-slate-50 shadow-sm': activeTab === 'extra', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'extra' }">
                                Datos Adicionales
                            </button>
                            <button type="button" @click="activeTab = 'ubicacion'" class="py-3 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200 rounded-t-lg" :class="{ 'border-slate-800 text-slate-800 bg-slate-50 shadow-sm': activeTab === 'ubicacion', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'ubicacion' }">
                                Salud
                            </button>
                        </div>
                    </nav>
                    
                    <!-- Selector para móvil -->
                    <div class="sm:hidden p-3">
                        <select x-model="activeTab" @change="activeTab = $event.target.value" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 font-medium focus:ring-2 focus:ring-slate-500 focus:border-slate-500">
                            <option value="personal">Información Personal</option>
                            <option value="laboral">Información Laboral</option>
                            <option value="beneficiario">Beneficiarios</option>
                            <option value="extra">Datos Adicionales</option>
                            <option value="ubicacion">Salud</option>
                        </select>
                    </div>
                </div>

                <!-- Contenido de los tabs -->
                <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                    <!-- Tab: Información Personal -->
                    <div x-show="activeTab === 'personal'" class="space-y-6">
                        <div>
                        <section aria-label="Datos personales del empleado" class="bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">
                        <!-- Barra superior con gradiente -->
                        <div class="p-3 sm:p-4 flex items-center gap-3 bg-gradient-to-r from-yellow-400 to-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                        </svg>
                        <h3 class="text-lg font-medium text-white">Datos Personales</h3>
                    </div>
                        <div class="p-2 sm:p-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-yellow-50 border border-yellow-200 rounded-lg p-4 relative">
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                                        </svg>
                                        Tipo de Documento
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->tipoDocumento->nombre_tipo_documento ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        Número de Documento
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->numero_documento ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M8 7h8M8 7l-4 9h16l-4-9" />
                                        </svg>
                                        Fecha de Nacimiento
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->fecha_nacimiento ? $empleado->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Edad
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->edad ?? 'No calculada' }} años</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Rango de Edad
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">
                                        {{ $empleado->rangoEdad ? $empleado->rangoEdad->edad_minima . ' a ' . $empleado->rangoEdad->edad_maxima . ' años' : 'No especificado' }}
                                    </dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        País
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->nacimiento->pais->nombre_pais ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Departamento
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->nacimiento->departamento->nombre_departamento ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Municipio
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->nacimiento->municipio->nombre_municipio ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Género
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->sexo ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Grupo Sanguíneo
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->grupoSanguineo->nombre ?? 'No especificado' }}</dd>
                                </div>
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        </svg>
                                        Nivel Educativo
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->nivel_educativo ?? 'No especificado' }}</dd>
                                </div>
                                
                                <div class="p-2 rounded-lg">
                                    <dt class="font-semibold text-yellow-800 text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Estado Civil
                                    </dt>
                                    <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->estado_civil ?? 'No especificado' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </section>
                        </div>
                        <div>
                            <section aria-label="Información de Comunicación" class="bg-white rounded-lg shadow-xl border border-indigo-200">
                                <header class="bg-gradient-to-r from-purple-700 to-indigo-700 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path d="M21 10c0-5.5-4.5-10-10-10S1 4.5 1 10c0 7 10 13 10 13s10-6 10-13Z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-white">Información de Contacto</h3>
                                </header>
                                <div class="p-4 sm:p-6">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-indigo-50 border border-indigo-300 rounded-lg p-4 relative">
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Dirección
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->direccion ?? 'No especificada' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                Teléfono
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->telefono ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                Teléfono fijo
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->telefono_fijo ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Correo Electrónico
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->email ?? 'No especificado' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </section>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                            <section aria-label="Lugar de Residencia del empleado" class="bg-white rounded-lg shadow-xl border border-gray-200">
                                <header class="bg-cyan-600 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-white">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-white">Lugar de Residencia</h3>
                                </header>
                                <div class="p-4 sm:p-6">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700 bg-sky-50 border border-sky-300 rounded-lg p-4 relative">
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                País
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->residencia->pais->nombre_pais ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Departamento
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->residencia->departamento->nombre_departamento ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                Municipio
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->residencia->municipio->nombre_municipio ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                Barrio
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->residencia->barrio->nombre_barrio ?? 'No especificado' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </section>
                        </div>
                    </div>
                    
                    <!-- Tab: Ubicación -->
                    <div x-show="activeTab === 'ubicacion'" class="space-y-6">
                            <!-- Sección: Patologias -->

                            <div class="mt-6 bg-white rounded-lg shadow-xl border border-emerald-200">
                                <header class="bg-emerald-500 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Patologías</h3>
                            </header>
                            <div class="p-4 sm:p-6">
                                @if ($empleado->patologias->count() > 0)
                                    <div class="space-y-6">
                                        @foreach ($empleado->patologias as $patologia)
                                            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 sm:p-4">
                                                <div class=" flex items-center justify-between mb-2">
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
                                                            <dt class="font-semibold text-emerald-800 text-base flex items-center gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                Fecha de Diagnóstico
                                                            </dt>
                                                            <dd class="mt-2 text-gray-600 text-sm">{{ $patologia->fecha_diagnostico ? \Carbon\Carbon::parse($patologia->fecha_diagnostico)->format('d/m/Y') : 'No especificada' }}</dd>
                                                        </div>
                                                    @endif
                                                    <div class="@if(isset($patologia->fecha_diagnostico)) col-span-1 @else col-span-2 @endif">
                                                        <dt class="font-semibold text-emerald-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            Descripción
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $patologia->descripcion_patologia ?? 'No especificada' }}</dd>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <dt class="font-semibold text-emerald-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                            </svg>
                                                            Tratamiento Actual
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $patologia->tratamiento_actual_patologia ?? 'No especificado' }}</dd>
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
                        <div class="bg-white rounded-lg shadow-xl border border-gray-200">
                            <header class="bg-sky-600 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
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
                            <div class="p-4 sm:p-6">
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
                                            <div class="w-full bg-blue-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $porcentaje }}%;"></div>
                                            </div>
                                            <p class="text-sm text-gray-900 mt-1">{{ $duracion['texto'] }}</p>
                                        </div>
                                    </div>
                                    <!-- Columnas Derechas: Detalles Laborales -->
                                    <dl class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm text-gray-700">
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Cargo
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->informacionLaboralActual->estadoCargo->cargo->nombre_cargo ?? 'Sin cargo asignado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Fecha de Ingreso
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->informacionLaboralActual->fecha_ingreso->format('d/m/Y') }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Fecha de Salida
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">
                                                {{ optional($empleado->informacionLaboralActual->fecha_salida)->format('d/m/Y') ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                                                </svg>
                                                Tipo de Contrato
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->informacionLaboralActual->tipo_contrato ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Tipo de Vinculacion
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->informacionLaboralActual->tipo_vinculacion ?? 'No especificado' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Ciudad Laboral
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">
                                                {{ $empleado->informacionLaboralActual->ciudadLaboral->nombre ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                ¿Aplica Dotación?
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">
                                                {{ $empleado->informacionLaboralActual->aplica_dotacion ? 'Sí' : 'No' }}
                                            </dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Talla de Camisa
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">
                                                {{ $empleado->informacionLaboralActual->talla_camisa ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Talla de Pantalón
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">
                                                {{ $empleado->informacionLaboralActual->talla_pantalon ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Talla de Zapatos
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">
                                                {{ $empleado->informacionLaboralActual->talla_zapatos ?? 'No especificada' }}
                                            </dd>
                                        </div>
                                        @php
                                            $informacion = $empleado->informacionLaboral->first();
                                        @endphp
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Relación Laboral
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $informacion?->relacion_laboral ?? 'No especificada' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-sky-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Relación Sindical
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $informacion?->relacion_sindical ? 'Sí' : 'No' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <!-- Archivos Adjuntos -->
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Archivos Adjuntos</h3>
                                <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
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

                                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-4 sm:px-5 sm:py-5 flex flex-col items-center justify-between hover:shadow-md transition-all duration-200 min-h-[120px] sm:min-h-[140px] w-full">
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
                        <section aria-label="Beneficiarios del empleado" class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Beneficiarios</h3>
                            </div>
                            <div class="p-4 sm:p-6">
                                @if($empleado->beneficiarios->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($empleado->beneficiarios as $beneficiario)
                                            <div class="bg-pink-50 rounded-lg p-3 sm:p-4 border border-pink-200 relative">
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
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            Fecha de Nacimiento
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $beneficiario->fecha_nacimiento ? \Carbon\Carbon::parse($beneficiario->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}</dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            Tipo de Documento
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $beneficiario->tipoDocumento->nombre_tipo_documento ?? 'No especificado' }}</dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                            </svg>
                                                            Número de Documento
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $beneficiario->numero_documento ?? 'No especificado' }}</dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                                            </svg>
                                                            Nivel Educativo
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $beneficiario->nivel_educativo ?? 'No especificado' }}</dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                                            </svg>
                                                            Edad
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">{{ $beneficiario->edad }} años</dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                            ¿Reside con el empleado?
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">
                                                            {{ $beneficiario->reside_con_empleado ? 'Sí' : 'No' }}
                                                        </dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            ¿Depende económicamente?
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">
                                                            {{ $beneficiario->depende_economicamente ? 'Sí' : 'No' }}
                                                        </dd>
                                                    </div>
                                                    <div class="p-2 rounded-lg">
                                                        <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                            </svg>
                                                            Contacto de emergencia
                                                        </dt>
                                                        <dd class="mt-2 text-gray-600 text-sm">
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
                        <section aria-label="Información adicional del empleado" class="bg-white rounded-lg shadow-xl border border-gray-200">
                            <header class="bg-gradient-to-r from-indigo-600 to-blue-700 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M12 11c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm0 0v8m0 0H4m8 0h8m0 0v-8m0 0c0-1.105-.895-2-2-2s-2 .895-2 2" />
                                </svg>
                                <h3 class="text-lg font-medium text-white">Información Adicional</h3>
                            </header>
                            <div class="p-4 sm:p-6">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-12 text-sm text-gray-700 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Etnia
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->etnia->nombre ?? 'No especificado' }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            ¿Es padre o madre?
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->padre_o_madre ? 'Sí' : 'No' }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Tipo de Vivienda
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->tipo_vivienda }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Estrato
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->estrato }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            ¿Vehículo propio?
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->vehiculo_propio ? 'Sí' : 'No' }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            Tipo de Vehículo
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->tipo_vehiculo }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            Medio de Movilidad
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->movilidad }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                            Institución Educativa
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->institucion_educativa }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                            </svg>
                                            Idiomas
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm whitespace-pre-line">{{ $empleado->idiomas }}</dd>
                                    </div>
                                    <div class="p-2 rounded-lg">
                                        <dt class="font-semibold text-blue-800 text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Intereses Personales
                                        </dt>
                                        <dd class="mt-2 text-gray-600 text-sm whitespace-pre-line">{{ $empleado->intereses_personales }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </section>

                        <div class="grid grid-cols-1">
                            <section aria-label="Seguridad Social" class="bg-white rounded-lg shadow-xl border border-rose-200">
                                <header class="bg-gradient-to-r from-pink-600 to-rose-600 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 21V8a4 4 0 0 1 8 0v13" />
                                        <path d="M5 21V12a4 4 0 0 1 8 0v9" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-white">Afiliaciones a Seguridad Social</h3>
                                </header>
                                <div class="p-4 sm:p-6">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-12 text-sm text-gray-700 bg-rose-50 border border-rose-300 rounded-lg p-4 sm:p-6 relative">
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                EPS
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->eps->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                ARL
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->arl->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                AFP
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->afp->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                AFC
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->afc->nombre ?? 'No especificada' }}</dd>
                                        </div>
                                        <div class="p-2 rounded-lg">
                                            <dt class="font-semibold text-rose-800 text-base flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                Caja de Compensación
                                            </dt>
                                            <dd class="mt-2 text-gray-600 text-sm">{{ $empleado->ccf->nombre ?? 'No especificada' }}</dd>
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
