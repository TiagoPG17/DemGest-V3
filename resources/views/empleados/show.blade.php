
@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;

// Calcular información de vacaciones al principio para que esté disponible en toda la vista
$infoLaboral = $empleado->informacionLaboralActual;
$diasVacacionesAcumulados = 0;
$diasVacacionesTomados = 0;
$diasVacacionesPendientes = 0;

if ($infoLaboral && $infoLaboral->fecha_ingreso) {
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
}
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
                    @php
                        $tituloBoton = $diasVacacionesPendientes <= 0 
                            ? 'Editar empleado - Advertencia: No hay días de vacaciones disponibles' 
                            : 'Editar empleado';
                        $claseBoton = $diasVacacionesPendientes <= 0
                            ? 'inline-flex items-center px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-md text-gray-500 bg-gray-100 cursor-not-allowed opacity-75'
                            : 'inline-flex items-center px-2 py-2 sm:px-4 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors';
                    @endphp
                    <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="{{ $claseBoton }}" title="{{ $tituloBoton }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                            <path d="m15 5 4 4" />
                        </svg>
                        Editar
                        @if ($diasVacacionesPendientes <= 0)
                            <svg class="w-4 h-4 ml-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        @endif
                    </a>
                @endif
                
                <!-- Botón Eliminar (solo para admin y gestión humana) -->
                @if(is_admin() || is_gestion_humana())
                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro que deseas eliminar al empleado \'{{ $empleado->nombre_completo }}\'? Esta acción no se puede deshacer.');">
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
                            
                            <!-- Estado actual -->
                            <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $empleado->estado_clases }}">
                                    <svg class="w-4 h-4 {{ $empleado->estado_actual == 'En vacaciones' ? 'text-blue-600' : ($empleado->estado_actual == 'En incapacidad' ? 'text-red-600' : ($empleado->estado_actual == 'Activo' ? 'text-green-600' : 'text-yellow-600')) }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($empleado->estado_actual == 'En vacaciones')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3v5h5" />
                                        @elseif($empleado->estado_actual == 'En incapacidad')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-.01-10a9 9 0 100 18 9 9 0 000-18z" />
                                        @elseif($empleado->estado_actual == 'Activo')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-.01-10a9 9 0 100 18 9 9 0 000-18z" />
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Estado:</span>
                                    <p class="text-sm font-medium text-gray-900">{{ $empleado->estado_actual }}</p>
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
                    <nav class="hidden sm:flex -mb-px justify-center overflow-x-auto">
                        <div class="flex space-x-1">
                            <button type="button" @click="activeTab = 'personal'" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200" :class="{ 'border-blue-600 text-blue-600 bg-blue-50': activeTab === 'personal', 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'personal' }">
                                Informacion Personal
                            </button>
                            <button type="button" @click="activeTab = 'laboral'" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200" :class="{ 'border-blue-600 text-blue-600 bg-blue-50': activeTab === 'laboral', 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'laboral' }">
                                Informacion Laboral
                            </button>
                            <button type="button" @click="activeTab = 'eventos'" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200" :class="{ 'border-blue-600 text-blue-600 bg-blue-50': activeTab === 'eventos', 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'eventos' }">
                                Eventos
                            </button>
                            <button type="button" @click="activeTab = 'beneficiario'" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200" :class="{ 'border-blue-600 text-blue-600 bg-blue-50': activeTab === 'beneficiario', 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'beneficiario' }">
                                Beneficiarios
                            </button>
                            <button type="button" @click="activeTab = 'extra'" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200" :class="{ 'border-blue-600 text-blue-600 bg-blue-50': activeTab === 'extra', 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'extra' }">
                                Datos Adicionales
                            </button>
                            <button type="button" @click="activeTab = 'ubicacion'" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap transition-all duration-200" :class="{ 'border-blue-600 text-blue-600 bg-blue-50': activeTab === 'ubicacion', 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 hover:bg-gray-50': activeTab !== 'ubicacion' }">
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
                            <option value="eventos">Eventos</option>
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
                                                            @php
                                                                $gravedad = strtolower($patologia->gravedad_patologia);
                                                                $severityClasses = match($gravedad) {
                                                                    'leve' => 'bg-green-100 text-green-800',
                                                                    'moderada' => 'bg-yellow-100 text-yellow-800',
                                                                    'severa' => 'bg-red-100 text-red-800',
                                                                    default => 'bg-gray-100 text-gray-800'
                                                                };
                                                            @endphp
                                                            {{ $severityClasses }}">
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
                                                    <div class="{{ isset($patologia->fecha_diagnostico) ? 'col-span-1' : 'col-span-2' }}">
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

                    <!-- Tab: Eventos y Vacaciones -->
                    <div x-show="activeTab === 'eventos'" class="space-y-6">
                        @php
                            // Obtener todos los eventos para agrupar por año
                            $todosEventos = $empleado->eventos()
                                ->orderBy('fecha_inicio', 'desc')
                                ->get();
                            
                            // Agrupar eventos por año
                            $eventosPorAnio = $todosEventos->groupBy(function($evento) {
                                return \Carbon\Carbon::parse($evento->fecha_inicio)->format('Y');
                            });
                        @endphp
                        
                        <!-- Resumen de Vacaciones -->
                        <div class="bg-white rounded-lg shadow-xl border border-blue-200">
                            <header class="bg-blue-600 p-3 sm:p-4 flex items-center gap-3 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                                    <path d="M3 3v5h5"/>
                                    <path d="M12 7v5l4 2"/>
                                </svg>
                                <h3 class="text-lg font-medium text-white">Resumen de Vacaciones</h3>
                            </header>
                            <div class="p-4 sm:p-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Días Acumulados -->
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ number_format($diasVacacionesAcumulados, 1) }}</div>
                                        <div class="text-sm text-green-700">Días Acumulados</div>
                                        <div class="text-xs text-green-600 mt-1">1.25 días/mes</div>
                                    </div>
                                    
                                    <!-- Días Tomados -->
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-red-600">{{ $diasVacacionesTomados }}</div>
                                        <div class="text-sm text-red-700">Días Tomados</div>
                                        <div class="text-xs text-red-600 mt-1">Vacaciones disfrutadas</div>
                                    </div>
                                    
                                    <!-- Días Pendientes -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ number_format($diasVacacionesPendientes, 1) }}</div>
                                        <div class="text-sm text-blue-700">Días Pendientes</div>
                                        <div class="text-xs text-blue-600 mt-1">Disponibles para tomar</div>
                                    </div>
                                </div>
                                
                                @if ($infoLaboral && $infoLaboral->fecha_ingreso)
                                    <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="text-sm text-gray-600">
                                            <strong>Fecha de ingreso:</strong> {{ $infoLaboral->fecha_ingreso->format('d/m/Y') }}<br>
                                            <strong>Meses trabajados:</strong> {{ round($mesesTrabajados) }} meses<br>
                                            <strong>Próximas vacaciones:</strong> {{ round($diasVacacionesPendientes) }} días disponibles
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                        <div class="text-sm text-yellow-700">
                                            <strong>Nota:</strong> No se puede calcular el tiempo de vacaciones porque no hay fecha de ingreso registrada.
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Advertencia de días de vacaciones no disponibles -->
                        @if ($diasVacacionesPendientes <= 0)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <div>
                                        <h4 class="text-red-800 font-medium">Días de vacaciones no disponibles</h4>
                                        <p class="text-red-700 text-sm mt-1">Este empleado no tiene días de vacaciones disponibles. No se pueden registrar nuevas vacaciones hasta que acumule más días.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Mensaje indicando seleccionar filtro -->
                        <div id="mensaje-seleccionar-filtro" class="relative bg-gradient-to-br from-white via-indigo-50 to-white rounded-xl shadow-lg border border-indigo-100 overflow-hidden mb-6">
                            <div class="p-8 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Selecciona un tipo de evento</h3>
                                <p class="text-gray-500">Para ver el historial, por favor selecciona una opción en el filtro above.</p>
                            </div>
                        </div>
                        
                        <!-- Historial de Vacaciones por Año -->
                        <div id="contenedor-historial-vacaciones" class="relative bg-gradient-to-br from-white via-indigo-50 to-white rounded-xl shadow-lg border border-indigo-100 overflow-hidden mb-6" style="display: none;">
                            <!-- Fondo animado con partículas -->
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute -top-6 -left-6 w-12 h-12 bg-indigo-200 rounded-full mix-blend-multiply filter blur-lg opacity-10 animate-pulse-slow"></div>
                                <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-purple-200 rounded-full mix-blend-multiply filter blur-lg opacity-10 animate-pulse-slow animation-delay-2000"></div>
                            </div>
                            
                            <!-- Header -->
                            <header class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-purple-700 p-3 sm:p-4 flex items-center gap-3 backdrop-blur-sm bg-opacity-95">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-white bg-opacity-20 rounded-lg animate-ping-slow"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white relative z-10 drop-shadow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight truncate">Historial de Vacaciones</h3>
                                    <p class="text-indigo-200 text-xs sm:text-sm mt-0.5 opacity-90 hidden sm:block">Vacaciones agrupadas por año</p>
                                </div>
                            </header>
                            
                            <div class="relative p-3 sm:p-4">
                                @if ($eventosPorAnio->count() > 0)
                                    <!-- Acordeón de años -->
                                    <div class="space-y-3">
                                        @foreach ($eventosPorAnio as $anio => $eventosDelAnio)
                                            @php
                                                $eventosVacaciones = $eventosDelAnio->where('tipo_evento', 'vacaciones');
                                                $totalDiasAnio = $eventosVacaciones->sum('dias');
                                                $totalEventosAnio = $eventosVacaciones->count();
                                            @endphp
                                            
                                            <!-- Acordeón por año -->
                                            <div class="border border-indigo-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                                <!-- Header del año (siempre visible) -->
                                                <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100 cursor-pointer hover:from-indigo-100 hover:to-purple-100 transition-all duration-200" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.accordion-icon').classList.toggle('rotate-180')">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white shadow-md">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h4 class="text-lg font-bold text-gray-900">{{ $anio }}</h4>
                                                                <p class="text-sm text-gray-600">
                                                                    <span class="contador-eventos" data-total-eventos="{{ $totalEventosAnio }}" data-total-dias="{{ $totalDiasAnio }}">
                                                                        {{ $totalEventosAnio }} {{ $totalEventosAnio == 1 ? 'evento' : 'eventos' }} • {{ $totalDiasAnio }} días totales
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                
                                                <!-- Contenido del año (inicialmente oculto) -->
                                                <div class="hidden p-4 bg-white">
                                                    <div class="grid gap-3">
                                                        @foreach ($eventosVacaciones as $evento)
                                                            @php
                                                                $gradient = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'from-indigo-500 to-purple-400',
                                                                    'incapacidad' => 'from-red-500 to-pink-400',
                                                                    'permiso' => 'from-green-500 to-emerald-400',
                                                                    default => 'from-purple-500 to-indigo-400'
                                                                };
                                                                $borderColor = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'border-indigo-300',
                                                                    'incapacidad' => 'border-red-300',
                                                                    'permiso' => 'border-green-300',
                                                                    default => 'border-purple-300'
                                                                };
                                                                $bgColor = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'bg-indigo-50',
                                                                    'incapacidad' => 'bg-red-50',
                                                                    'permiso' => 'bg-green-50',
                                                                    default => 'bg-purple-50'
                                                                };
                                                                $textColor = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'text-indigo-600',
                                                                    'incapacidad' => 'text-red-600',
                                                                    'permiso' => 'text-green-600',
                                                                    default => 'text-purple-600'
                                                                };
                                                                $iconoSvg = match($evento->tipo_evento) {
                                                                    'vacaciones' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                                        <polyline points="14 2 14 8 20 8"/>
                                                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                                                        <polyline points="10 9 9 9 8 9"/>
                                                                    </svg>',
                                                                    'incapacidad' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                                                        <circle cx="12" cy="12" r="10"/>
                                                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                                                                    </svg>',
                                                                    'permiso' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                                                        <path d="M12 8v4l3 3"/>
                                                                    </svg>',
                                                                    default => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                                                    </svg>'
                                                                };
                                                            @endphp
                                                            
                                                            <!-- Evento individual -->
                                                            <div class="border-l-4 {{ $borderColor }} {{ $bgColor }} rounded-lg p-3 shadow-sm evento-item" data-tipo="{{ $evento->tipo_evento }}" data-dias="{{ $evento->dias }}">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center space-x-3">
                                                                        <div class="w-8 h-8 bg-gradient-to-r {{ $gradient }} rounded-lg flex items-center justify-center text-white">
                                                                            {!! $iconoSvg !!}
                                                                        </div>
                                                                        <div>
                                                                            <div class="font-semibold text-gray-900">{{ ucfirst($evento->tipo_evento) }} - {{ $evento->dias }} días</div>
                                                                            <div class="text-sm text-gray-600">{{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2">
                                                                        <div class="text-right">
                                                                            <div class="text-lg font-bold {{ $textColor }}">{{ $evento->dias }}d</div>
                                                                            <div class="text-xs text-gray-500">Duración</div>
                                                                        </div>
                                                                        @if(is_admin() || is_gestion_humana())
                                                                            @if($evento->getKey())
                                                                                <form action="{{ route('empleados.eventos.destroy', [$empleado->id_empleado, $evento->getKey()]) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro que deseas eliminar este evento de {{ ucfirst($evento->tipo_evento) }} de {{ $evento->dias }} días?\n\nEsta acción no se puede deshacer.');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors" title="Eliminar evento">
                                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <!-- Evento sin ID válido -->
                                                                                <span class="text-xs text-gray-400" title="ID: {{ $evento->id_evento ?? 'null' }}">No eliminable (ID: {{ $evento->id_evento ?? 'null' }})</span>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Sin eventos -->
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <p class="text-lg font-medium">No hay eventos registrados</p>
                                        <p class="text-sm">Este empleado no tiene eventos en el historial.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Filtro de Tipo de Eventos -->
                        <div class="mb-6 filtro-barra-estable">
                            <div class="flex flex-wrap gap-2 p-4 bg-white rounded-lg shadow-md border border-gray-200">
                                <button onclick="filtrarEventos('todos')" id="filtro-todos" class="filtro-btn active px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-indigo-600 text-white shadow-md">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    Todos
                                </button>
                                <button onclick="filtrarEventos('vacaciones')" id="filtro-vacaciones" class="filtro-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                    Vacaciones
                                </button>
                                <button onclick="filtrarEventos('incapacidad')" id="filtro-incapacidad" class="filtro-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                                    </svg>
                                    Incapacidades
                                </button>
                                <button onclick="filtrarEventos('permiso')" id="filtro-permiso" class="filtro-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                        <path d="M12 8v4l3 3"/>
                                    </svg>
                                        Permisos
                                </button>
                            </div>
                        </div>
                        
                        <!-- Historial de Eventos por Año -->
                        <div id="contenedor-historial-eventos" class="relative bg-gradient-to-br from-white via-indigo-50 to-white rounded-xl shadow-lg border border-indigo-100 overflow-hidden" style="display: none;">
                            <!-- Fondo animado con partículas -->
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute -top-6 -left-6 w-12 h-12 bg-indigo-200 rounded-full mix-blend-multiply filter blur-lg opacity-10 animate-pulse-slow"></div>
                                <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-purple-200 rounded-full mix-blend-multiply filter blur-lg opacity-10 animate-pulse-slow animation-delay-2000"></div>
                            </div>
                            
                            <!-- Header -->
                            <header class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-purple-700 p-3 sm:p-4 flex items-center gap-3 backdrop-blur-sm bg-opacity-95">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-white bg-opacity-20 rounded-lg animate-ping-slow"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white relative z-10 drop-shadow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight truncate">Historial de Eventos</h3>
                                    <p class="text-indigo-200 text-xs sm:text-sm mt-0.5 opacity-90 hidden sm:block">Eventos agrupados por año y tipo</p>
                                </div>
                            </header>
                            
                            <div class="relative p-3 sm:p-4">
                                @if ($eventosPorAnio->count() > 0)
                                    <!-- Acordeón de años -->
                                    <div class="space-y-3">
                                        @foreach ($eventosPorAnio as $anio => $eventosDelAnio)
                                            @php
                                                // Para el contenedor de eventos, mostrar todos los eventos
                                                $eventosParaMostrar = $eventosDelAnio;
                                                $totalDiasAnio = $eventosParaMostrar->sum('dias');
                                                $totalEventosAnio = $eventosParaMostrar->count();
                                            @endphp
                                            
                                            <!-- Acordeón por año -->
                                            <div class="border border-indigo-200 rounded-lg overflow-hidden bg-white shadow-sm evento-anio" data-anio="{{ $anio }}">
                                                <!-- Header del año (siempre visible) -->
                                                <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100 cursor-pointer hover:from-indigo-100 hover:to-purple-100 transition-all duration-200" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.accordion-icon').classList.toggle('rotate-180')">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white shadow-md">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h4 class="text-lg font-bold text-gray-900">{{ $anio }}</h4>
                                                                <p class="text-sm text-gray-600">
                                                                    <span class="contador-eventos" data-total-eventos="{{ $totalEventosAnio }}" data-total-dias="{{ $totalDiasAnio }}">
                                                                        {{ $totalEventosAnio }} {{ $totalEventosAnio == 1 ? 'evento' : 'eventos' }} • {{ $totalDiasAnio }} días totales
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200 accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                
                                                <!-- Contenido del año (inicialmente oculto) -->
                                                <div class="hidden p-4 bg-white">
                                                    <div class="grid gap-3">
                                                        @foreach ($eventosParaMostrar as $evento)
                                                            @php
                                                                $gradient = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'from-indigo-500 to-purple-400',
                                                                    'incapacidad' => 'from-red-500 to-pink-400',
                                                                    'permiso' => 'from-green-500 to-emerald-400',
                                                                    default => 'from-purple-500 to-indigo-400'
                                                                };
                                                                $borderColor = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'border-indigo-300',
                                                                    'incapacidad' => 'border-red-300',
                                                                    'permiso' => 'border-green-300',
                                                                    default => 'border-purple-300'
                                                                };
                                                                $bgColor = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'bg-indigo-50',
                                                                    'incapacidad' => 'bg-red-50',
                                                                    'permiso' => 'bg-green-50',
                                                                    default => 'bg-purple-50'
                                                                };
                                                                $textColor = match($evento->tipo_evento) {
                                                                    'vacaciones' => 'text-indigo-600',
                                                                    'incapacidad' => 'text-red-600',
                                                                    'permiso' => 'text-green-600',
                                                                    default => 'text-purple-600'
                                                                };
                                                                $iconoSvg = match($evento->tipo_evento) {
                                                                    'vacaciones' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                                        <polyline points="14 2 14 8 20 8"/>
                                                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                                                        <polyline points="10 9 9 9 8 9"/>
                                                                    </svg>',
                                                                    'incapacidad' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                                                        <circle cx="12" cy="12" r="10"/>
                                                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                                                                    </svg>',
                                                                    'permiso' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                                                        <path d="M12 8v4l3 3"/>
                                                                    </svg>',
                                                                    default => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                                                    </svg>'
                                                                };
                                                            @endphp
                                                            
                                                            <!-- Evento individual -->
                                                            <div class="border-l-4 {{ $borderColor }} {{ $bgColor }} rounded-lg p-3 shadow-sm evento-item" data-tipo="{{ $evento->tipo_evento }}" data-dias="{{ $evento->dias }}">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center space-x-3">
                                                                        <div class="w-8 h-8 bg-gradient-to-r {{ $gradient }} rounded-lg flex items-center justify-center text-white">
                                                                            {!! $iconoSvg !!}
                                                                        </div>
                                                                        <div>
                                                                            <div class="font-semibold text-gray-900">{{ ucfirst($evento->tipo_evento) }} - {{ $evento->dias }} días</div>
                                                                            <div class="text-sm text-gray-600">{{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2">
                                                                        <div class="text-right">
                                                                            <div class="text-lg font-bold {{ $textColor }}">{{ $evento->dias }}d</div>
                                                                            <div class="text-xs text-gray-500">Duración</div>
                                                                        </div>
                                                                        @if(is_admin() || is_gestion_humana())
                                                                            @if($evento->getKey())
                                                                                <form action="{{ route('empleados.eventos.destroy', [$empleado->id_empleado, $evento->getKey()]) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro que deseas eliminar este evento de {{ ucfirst($evento->tipo_evento) }} de {{ $evento->dias }} días?\n\nEsta acción no se puede deshacer.');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors" title="Eliminar evento">
                                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <!-- Evento sin ID válido -->
                                                                                <span class="text-xs text-gray-400" title="ID: {{ $evento->getKey() }}">No eliminable (ID: {{ $evento->getKey() }})</span>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Sin eventos -->
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <p class="text-lg font-medium">No hay eventos registrados</p>
                                        <p class="text-sm">Este empleado no tiene eventos en el historial.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Estilos CSS para las animaciones personalizadas -->
                        <style>
                        @keyframes pulse-slow {
                            0%, 100% { opacity: 0.2; transform: scale(1); }
                            50% { opacity: 0.4; transform: scale(1.05); }
                        }
                        @keyframes ping-slow {
                            75%, 100% { transform: scale(2); opacity: 0; }
                        }
                        @keyframes spin-slow {
                            from { transform: rotate(0deg); }
                            to { transform: rotate(360deg); }
                        }
                        @keyframes float {
                            0%, 100% { transform: translateY(0px); }
                            50% { transform: translateY(-20px); }
                        }
                        .animate-pulse-slow { animation: pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
                        .animate-ping-slow { animation: ping-slow 3s cubic-bezier(0, 0, 0.2, 1) infinite; }
                        .animate-spin-slow { animation: spin-slow 8s linear infinite; }
                        .animate-float { animation: float 6s ease-in-out infinite; }
                        .animation-delay-2000 { animation-delay: 2s; }
                        .animation-delay-4000 { animation-delay: 4s; }
                        .filtro-barra-estable { margin-bottom: 1.5rem !important; position: relative; }
                        </style>
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
                            <div class="mt-10 mx-4 sm:mx-6 lg:mx-8 mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">Archivos Adjuntos</h3>
                                <div class="grid gap-6 sm:gap-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 justify-items-center">
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

                                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-4 sm:px-5 sm:py-5 flex flex-col items-center justify-between hover:shadow-lg transition-all duration-300 min-h-[100px] sm:min-h-[120px] w-full max-w-xs mx-auto">
                                            <div class="flex flex-col items-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="font-semibold text-gray-800 text-base text-center break-words">
                                                    {{ $nombreMostrar }}
                                                </span>
                                            </div>
                                            <a href="{{ Storage::url($archivo->ruta) }}" target="_blank" class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                                Ver archivo
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 text-sm text-gray-700 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
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
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6 text-sm text-gray-700 bg-rose-50 border border-rose-300 rounded-lg p-4 sm:p-6 relative">
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
    
    <!-- Script para funcionalidad de filtrado de eventos -->
    <script>
    function actualizarContadores(contenedor, tipoFiltro) {
        // Obtener todos los años dentro del contenedor
        const aniosEnContenedor = contenedor.querySelectorAll('.evento-anio');
        
        aniosEnContenedor.forEach(anioDiv => {
            // Obtener todos los eventos individuales dentro de este año
            const eventosEnAnio = anioDiv.querySelectorAll('.evento-item');
            
            // Filtrar eventos según el tipo
            let eventosFiltrados = [];
            let totalDias = 0;
            
            eventosEnAnio.forEach(evento => {
                const eventoTipo = evento.dataset.tipo;
                if (tipoFiltro === 'todos' || eventoTipo === tipoFiltro) {
                    eventosFiltrados.push(evento);
                    const dias = parseInt(evento.dataset.dias) || 0;
                    totalDias += dias;
                }
            });
            
            // Actualizar el contador en el header del año
            const contadorSpan = anioDiv.querySelector('.contador-eventos');
            if (contadorSpan) {
                const totalEventos = eventosFiltrados.length;
                const texto = `${totalEventos} ${totalEventos === 1 ? 'evento' : 'eventos'} • ${totalDias} días totales`;
                contadorSpan.textContent = texto;
            }
        });
    }
    
    function filtrarEventos(tipo) {
        // Obtener los contenedores y el mensaje
        const contenedorEventos = document.getElementById('contenedor-historial-eventos');
        const contenedorVacaciones = document.getElementById('contenedor-historial-vacaciones');
        const mensajeSeleccionar = document.getElementById('mensaje-seleccionar-filtro');
        
        // Ocultar el mensaje de selección
        if (mensajeSeleccionar) {
            mensajeSeleccionar.style.display = 'none';
        }
        
        // Determinar qué contenedor mostrar según el tipo
        let contenedorActivo;
        if (tipo === 'todos') {
            // Mostrar solo el contenedor de eventos (que ahora contiene todos los eventos)
            contenedorActivo = contenedorEventos;
            if (contenedorVacaciones) contenedorVacaciones.style.display = 'none';
        } else if (tipo === 'vacaciones') {
            contenedorActivo = contenedorVacaciones;
            if (contenedorEventos) contenedorEventos.style.display = 'none';
        } else {
            contenedorActivo = contenedorEventos;
            if (contenedorVacaciones) contenedorVacaciones.style.display = 'none';
        }
        
        // Mostrar el contenedor activo
        if (contenedorActivo) {
            contenedorActivo.style.display = 'block';
        }
        
        // Obtener todos los botones de filtro
        const botonesFiltro = document.querySelectorAll('.filtro-btn');
        
        // Obtener todos los años de eventos
        const aniosEventos = document.querySelectorAll('.evento-anio');
        
        // Obtener todos los eventos individuales
        const eventosIndividuales = document.querySelectorAll('.evento-item');
        
        // Actualizar estado de los botones
        botonesFiltro.forEach(boton => {
            boton.classList.remove('active', 'bg-indigo-600', 'text-white', 'shadow-md');
            boton.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });
        
        // Activar el botón seleccionado
        const botonActivo = document.getElementById(`filtro-${tipo}`);
        botonActivo.classList.add('active', 'bg-indigo-600', 'text-white', 'shadow-md');
        botonActivo.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        
        // Filtrar eventos
        if (tipo === 'todos') {
            // Mostrar todos los años y eventos en ambos contenedores
            aniosEventos.forEach(anio => {
                anio.style.display = 'block';
            });
            eventosIndividuales.forEach(evento => {
                evento.style.display = 'block';
            });
        } else {
            // Filtrar por tipo específico
            let hayEventosVisibles = false;
            
            aniosEventos.forEach(anio => {
                const eventosDelAnio = anio.querySelectorAll('.evento-item');
                let hayEventosDelTipo = false;
                
                eventosDelAnio.forEach(evento => {
                    if (evento.dataset.tipo === tipo) {
                        evento.style.display = 'block';
                        hayEventosDelTipo = true;
                        hayEventosVisibles = true;
                    } else {
                        evento.style.display = 'none';
                    }
                });
                
                // Mostrar/ocultar el año según si tiene eventos del tipo seleccionado
                anio.style.display = hayEventosDelTipo ? 'block' : 'none';
            });
            
            // Si no hay eventos visibles, mostrar mensaje
            if (!hayEventosVisibles) {
                // Aquí podrías agregar un mensaje de "No hay eventos de este tipo"
                console.log('No hay eventos del tipo:', tipo);
            }
        }
        
        // No hacer scroll automático para evitar el desplazamiento brusco
    }
    
    // No inicializar automáticamente - esperar a que el usuario seleccione un filtro
    document.addEventListener('DOMContentLoaded', function() {
        // Asegurar que el mensaje de selección esté visible y los contenedores ocultos
        const mensajeSeleccionar = document.getElementById('mensaje-seleccionar-filtro');
        const contenedorVacaciones = document.getElementById('contenedor-historial-vacaciones');
        const contenedorEventos = document.getElementById('contenedor-historial-eventos');
        
        if (mensajeSeleccionar) {
            mensajeSeleccionar.style.display = 'block';
        }
        if (contenedorVacaciones) {
            contenedorVacaciones.style.display = 'none';
        }
        if (contenedorEventos) {
            contenedorEventos.style.display = 'none';
        }
    });
    
    </script>


    <script>
        // Interceptar errores de AJAX y redirigir con mensaje de error
        const originalFetch = window.fetch;
        window.fetch = function() {
            return originalFetch.apply(this, arguments)
                .then(response => {
                    if (!response.ok && response.status === 500) {
                        return response.clone().text().then(text => {
                            // Buscar si el error es de vacaciones
                            if (text.includes('días de vacaciones disponibles')) {
                                // Extraer el mensaje de error
                                const errorMessage = text.match(/El empleado solo tiene [\d.]+ días de vacaciones disponibles\. No puede solicitar [\d]+ días\./)?.[0] || 'No tiene suficientes días de vacaciones disponibles.';
                                
                                // Guardar el mensaje en sessionStorage y recargar la página
                                sessionStorage.setItem('error_message', errorMessage);
                                window.location.reload();
                                return Promise.reject(text);
                            }
                            return Promise.reject(text);
                        });
                    }
                    return response;
                })
                .catch(error => {
                    // Si ya fue manejado por el bloque anterior, no hacer nada
                    if (typeof error === 'string' && error.includes('días de vacaciones disponibles')) {
                        return Promise.reject(error);
                    }
                    
                    // Manejar otros errores
                    console.error('Error en la petición:', error);
                    return Promise.reject(error);
                });
        };
        
        // Verificar si hay un mensaje de error en sessionStorage y mostrarlo
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = sessionStorage.getItem('error_message');
            if (errorMessage) {
                sessionStorage.removeItem('error_message');
                // El mensaje se mostrará automáticamente a través del sistema de alertas de Laravel
                // pero necesitamos recargar la página con el parámetro de error
                const url = new URL(window.location);
                url.searchParams.set('error', encodeURIComponent(errorMessage));
                window.location.href = url.toString();
            }
        });
    </script>
@endsection
