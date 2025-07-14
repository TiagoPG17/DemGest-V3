@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Alerta -->
        @if ($mostrarAlerta)
            <div class="w-full bg-yellow-100 border-l-4 border-yellow-500 text-yellow-900 p-4 rounded-md shadow mb-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.681-1.36 3.446 0l6.518 11.597c.75 1.337-.213 2.999-1.723 2.999H3.462c-1.51 0-2.473-1.662-1.723-2.999L8.257 3.1zM9 8a1 1 0 012 0v3a1 1 0 11-2 0V8zm1 6a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Aviso semanal:</span>
                    <span>Recuerda revisar el Reporte de los empleados esta semana.</span>
                </div>
            </div>
        @endif

        <!-- Encabezado -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Resumen</h1>
            <p class="mt-1 text-sm text-gray-600">Información general</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <line x1="18" y1="6" x2="22" y2="10"></line>
                            <line x1="18" y1="10" x2="22" y2="6"></line>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Inactivos (Mes)</h3>
                        <p class="text-3xl font-semibold text-red-500 pl-4">{{ $empleadosInactivosMes ?? 1 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <polyline points="16 11 18 13 22 9"></polyline>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Empleados Activos</h3>
                        <p class="text-3xl font-semibold text-green-600 pl-4">{{ $empleadosActivos }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-purple-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <line x1="19" y1="8" x2="19" y2="14"></line>
                            <line x1="22" y1="11" x2="16" y2="11"></line>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Nuevos (Mes)</h3>
                        <p class="text-3xl font-semibold text-purple-600 pl-4">{{ $nuevosEmpleados ?? 5 }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Distribución por Centro de Costos -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Distribución por Centro de Costos</h2>
            <div class="space-y-4">
                @php
                    $colores = ['bg-indigo-500', 'bg-green-500', 'bg-blue-500', 'bg-yellow-500', 'bg-purple-500', 'bg-pink-500', 'bg-red-500'];
                    $maximoReferencial = 50;
                @endphp
                @forelse ($centrosCosto as $index => $centro)
                    @php
                        $porcentaje = min(100, round(($centro->cantidad / $maximoReferencial) * 100, 2));
                        $color = $colores[$index % count($colores)];
                    @endphp
                    <div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ $color }} mr-2"></div>
                                <span class="text-sm font-medium">{{ $centro->nombre }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $centro->cantidad }} empleados</span>
                        </div>
                        <div class="mt-2 relative w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-2 {{ $color }} rounded-full" style="width: {{ $porcentaje }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No hay centros de costos registrados.</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-5">
            <h2 class="text-lg font-medium text-gray-900 mb-6">Descargar Documentos</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Botón: Descargar Reporte PDF -->
                <a href="{{ route('empleados.report.pdf') }}" target="_blank" class="flex w-full items-center bg-blue-50 hover:bg-blue-100 transition-colors rounded-lg shadow p-6">
                    <div class="flex-shrink-0 h-14 w-14 rounded-full bg-blue-100 flex items-center justify-center">
                        <!-- Ícono PDF -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-600" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-base font-semibold text-gray-900">Descargar Reporte</h3>
                        <p class="text-sm text-gray-500">Reporte mensual en PDF</p>
                    </div>
                </a>
                <a href="{{ route('reporte.centros-costos') }}" target="_blank" class="flex w-full items-center bg-green-50 hover:bg-green-100 transition-colors rounded-lg shadow p-6">
                    <div class="flex-shrink-0 h-14 w-14 rounded-full bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#38c172" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-base font-semibold text-gray-900">Centros de Costos</h3>
                        <p class="text-sm text-gray-500">Exportar estructura organizacional</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
