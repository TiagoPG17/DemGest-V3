@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <!-- Header limpio -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Reportes de Contratos</h1>
                <p class="text-gray-600">Gestion de prorrogas y preavisos</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0 ml-auto">
                <form action="{{ route('contratos.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-32">
                    <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-32">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-filter"></i>
                        Filtrar
                    </button>
                </form>

                <form action="{{ route('reportes.contratos.pdf') }}" method="GET" target="_blank">
                    <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                    <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap" style="background-color: #6b7280 !important; color: white !important;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fas fa-file-pdf"></i>
                        Generar PDF
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filtros rÃ¡pidos -->
    <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
        <div class="flex flex-wrap justify-center gap-2">
            
            <button onclick="setDateRange('week')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                <i class="fas fa-calendar-week"></i>
                Esta semana
            </button>
            <button onclick="setDateRange('month')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i>
                Este mes
            </button>
            <button onclick="setDateRange('next_month')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                <i class="fas fa-calendar-plus"></i>
                Proximo mes
            </button>
        </div>
    </div>

    @if($empleados->isEmpty())
        <div class="bg-white rounded-lg shadow-sm border p-8 text-center">
            <div class="text-4xl mb-3"></div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No se encontraron empleados</h3>
            <p class="text-gray-600">AsegÃºrate de que el rango de fechas sea correcto.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        @php
                            $opposite = $direction === 'asc' ? 'desc' : 'asc';
                        @endphp
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-80">
                                <a href="{{ route('contratos.index', array_merge(request()->all(), ['sort' => 'nombre', 'direction' => $sort === 'nombre' ? $opposite : 'asc'])) }}"
                                    class="text-gray-700 hover:text-gray-900 flex items-center gap-1">
                                    Nombre
                                    @if($sort === 'nombre')
                                        <span>{{ $direction === 'asc' ? 'â†‘' : 'â†“' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Documento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-64">Cargo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-64">Empresa</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Ingreso</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($empleados as $empleado)
                            @php
                                $info = $empleado->informacionLaboralActual;
                                $estado = $info?->estadoCargo;
                                $hoy = \Carbon\Carbon::now();
                                $diasRestantes = $empleado->fecha_corte ? $empleado->fecha_corte->diffInDays($hoy, false) : null;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900 text-center font-medium border-r border-gray-100">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 border-r border-gray-100">
                                    <div class="text-sm font-medium text-gray-900">{{ $empleado->nombre_completo }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-mono border-r border-gray-100">{{ $empleado->numero_documento }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 border-r border-gray-100">{{ $estado?->cargo?->nombre_cargo ?? 'Sin cargo' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 border-r border-gray-100">{{ $empleado->empresa?->nombre_empresa ?? 'Sin empresa' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ optional($info?->fecha_ingreso)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function setDateRange(range) {
    const hoy = new Date();
    let fechaInicio, fechaFin;
    
    switch(range) {
        case 'week':
            const inicioSemana = new Date(hoy);
            inicioSemana.setDate(hoy.getDate() - hoy.getDay());
            const finSemana = new Date(inicioSemana);
            finSemana.setDate(inicioSemana.getDate() + 6);
            fechaInicio = inicioSemana.toISOString().split('T')[0];
            fechaFin = finSemana.toISOString().split('T')[0];
            break;
        case 'month':
            fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1).toISOString().split('T')[0];
            fechaFin = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0).toISOString().split('T')[0];
            break;
        case 'next_month':
            fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 1).toISOString().split('T')[0];
            fechaFin = new Date(hoy.getFullYear(), hoy.getMonth() + 2, 0).toISOString().split('T')[0];
            break;
    }
    
    const url = new URL(window.location.href);
    url.searchParams.set('fecha_inicio', fechaInicio);
    url.searchParams.set('fecha_fin', fechaFin);
    window.location.href = url.toString();
}
</script>
@endpush
@endsection
