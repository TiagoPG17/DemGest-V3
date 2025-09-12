@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Encabezado con contador de empleados -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Resumen</h1>
                <p class="mt-1 text-sm text-gray-600">Información general</p>
            </div>
            <!-- Contador de empleados en la esquina superior derecha -->
            <div class="bg-white rounded-lg shadow-sm px-4 py-2 border border-gray-200 flex items-center">
                <div class="flex-shrink-0 h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Total empleados:</span>
                <span class="ml-2 bg-gray-100 text-gray-800 text-sm font-semibold px-2 py-0.5 rounded-full">{{ $totalEmpleados ?? 0 }}</span>
            </div>
        </div>

        <!-- Contenedor principal para ambas empresas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <!-- Pestañas de navegación -->
            <div class="flex border-b border-gray-200">
                <button onclick="mostrarEmpresa('contiflex')" id="tab-contiflex" class="px-6 py-4 font-medium text-sm border-b-2 border-blue-600 text-blue-600 focus:outline-none flex items-center">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    Contiflex
                    <span class="ml-2 bg-blue-100 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $contiflexCount ?? 0 }}</span>
                </button>
                <button onclick="mostrarEmpresa('formacol')" id="tab-formacol" class="px-6 py-4 font-medium text-sm text-gray-500 hover:text-gray-700 focus:outline-none flex items-center">
                    <div class="flex-shrink-0 h-5 w-5 rounded-full bg-red-100 flex items-center justify-center mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m-1-6.5h4m-4 3h4m0 0h4m-8-6.5h.01M9 16.5h.01M9 13.5h.01M9 10.5h.01"></path>
                        </svg>
                    </div>
                    Formacol
                    <span class="ml-2 bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $formacolCount ?? 0 }}</span>
                </button>
            </div>  

            <!-- Contenido de Contiflex -->
            <div id="contenido-contiflex" class="p-6">
                <!-- Contadores de Empleados Contiflex -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Total Empleados -->
                    <div class="bg-sky-50 rounded-lg p-4 border-l-4 border-sky-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Total Empleados</h3>
                                <p class="text-2xl font-semibold text-blue-600">{{ $contiflexCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nuevos en Contiflex (Mes) -->
                    <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Nuevos (Mes)</h3>
                                <p class="text-2xl font-semibold text-green-600">{{ $nuevosContiflexMes ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inactivos en Contiflex (Mes) -->
                    <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Inactivos (Mes)</h3>
                                <p class="text-2xl font-semibold text-yellow-600">{{ $inactivosContiflexMes ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Próximos Contratos Contiflex -->
                    <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Próximos Contratos a Vencer (30 días)</h3>
                                <p class="text-2xl font-semibold text-purple-600">{{ $proximosContratosContiflex ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Centros de Costos Contiflex -->
                <div class="mt-8">
                    <div class="bg-white rounded-lg shadow-2xl border border-gray-300">
                        <!-- Encabezado -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Centros de Costos - Contiflex</h2>
                            <p class="text-sm text-gray-600 mt-1">Distribución de empleados por centro de costos</p>
                        </div>
                        
                        <!-- Contenido -->
                        <div class="p-4">
                            @if(isset($centrosCostos) && $centrosCostos->count() > 0)
                                @php
                                    $centrosContiflex = $centrosCostos->filter(function($centro) {
                                        return str_starts_with($centro->codigo, 'CX_');
                                    });
                                @endphp
                                
                                @if($centrosContiflex->count() > 0)
                                    <!-- Lista compacta -->
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                            @foreach($centrosContiflex as $centro)
                                                <div class="group bg-gray-50 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                                                    <div class="p-3">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center space-x-3 flex-1 min-w-0">
                                                                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-md text-xs font-bold text-blue-700 bg-blue-100 border border-blue-200">
                                                                    {{ $centro->codigo }}
                                                                </span>
                                                                <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $centro->nombre }}</h4>
                                                            </div>
                                                            <div class="flex-shrink-0 ml-2">
                                                                <div class="text-lg font-bold text-blue-600">{{ $centro->empleados_count ?? 0 }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        No hay centros de costos para Contiflex
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay centros de costos registrados</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido de Formacol -->
            <div id="contenido-formacol" class="p-6 hidden">
                <!-- Contadores de Empleados Formacol -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Total Empleados -->
                    <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Total Empleados</h3>
                                <p class="text-2xl font-semibold text-red-600">{{ $formacolCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nuevos en Formacol (Mes) -->
                    <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Nuevos (Mes)</h3>
                                <p class="text-2xl font-semibold text-green-600">{{ $nuevosFormacolMes ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inactivos en Formacol (Mes) -->
                    <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Inactivos (Mes)</h3>
                                <p class="text-2xl font-semibold text-yellow-600">{{ $inactivosFormacolMes ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                
                    <!-- Próximos Contratos Formacol -->
                    <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-600">Próximos Contratos a Vencer (30 días)</h3>
                                <p class="text-2xl font-semibold text-purple-600">{{ $proximosContratosFormacol ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Centros de Costos Formacol -->
                <div class="mt-8">
                    <div class="bg-white rounded-lg shadow-2xl border border-gray-300">
                        <!-- Encabezado -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Centros de Costos - Formacol</h2>
                            <p class="text-sm text-gray-600 mt-1">Distribución de empleados por centro de costos</p>
                        </div>
                        
                        <!-- Contenido -->
                        <div class="p-4">
                            @if(isset($centrosCostos) && $centrosCostos->count() > 0)
                                @php
                                    $centrosFormacol = $centrosCostos->filter(function($centro) {
                                        return str_starts_with($centro->codigo, 'FC_');
                                    });
                                @endphp
                                
                                @if($centrosFormacol->count() > 0)
                                    <!-- Lista compacta -->
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                            @foreach($centrosFormacol as $centro)
                                                <div class="group bg-gray-50 border border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition-all duration-200">
                                                    <div class="p-3">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center space-x-3 flex-1 min-w-0">
                                                                <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-md text-xs font-bold text-red-700 bg-red-100 border border-red-200">
                                                                    {{ $centro->codigo }}
                                                                </span>
                                                                <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $centro->nombre }}</h4>
                                                            </div>
                                                            <div class="flex-shrink-0 ml-2">
                                                                <div class="text-lg font-bold text-red-600">{{ $centro->empleados_count ?? 0 }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        No hay centros de costos para Formacol
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay centros de costos registrados</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function mostrarEmpresa(empresa) {
            // Ocultar todos los contenidos principales
            document.querySelectorAll('[id^="contenido-"]').forEach(contenido => {
                contenido.classList.add('hidden');
            });
            
            // Desactivar todas las pestañas principales
            document.querySelectorAll('button[id^="tab-"]:not([id^="tab-centros-"])').forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600', 'border-red-600', 'text-red-600');
                tab.classList.add('text-gray-500', 'hover:text-gray-700', 'border-transparent');
            });
            
            // Mostrar el contenido seleccionado
            document.getElementById(`contenido-${empresa}`).classList.remove('hidden');
            
            // Activar la pestaña seleccionada
            const tab = document.getElementById(`tab-${empresa}`);
            tab.classList.remove('text-gray-500', 'hover:text-gray-700', 'border-transparent');
            
            // Aplicar estilos según la empresa
            if (empresa === 'contiflex') {
                tab.classList.add('border-blue-600', 'text-blue-600');
            } else if (empresa === 'formacol') {
                tab.classList.add('border-red-600', 'text-red-600');
            }
        }
    </script>
    @endpush
@endsection