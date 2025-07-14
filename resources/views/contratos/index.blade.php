@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 bg-white shadow-md rounded-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Reportes de Contratos</h1>
        <div class="flex flex-wrap space-x-2">
            <form action="{{ route('contratos.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="border rounded px-3 py-2 text-sm">
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="border rounded px-3 py-2 text-sm">
                <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Filtrar</button>
            </form>

            <form action="{{ route('reportes.contratos.pdf') }}" method="GET" target="_blank">
                <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">Generar PDF</button>
            </form>
        </div>
    </div>

    @if($empleados->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
            <p class="font-semibold">No se encontraron empleados</p>
            <p class="text-sm">Asegúrate de que el rango de fechas sea correcto.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    @php
                        $opposite = $direction === 'asc' ? 'desc' : 'asc';
                    @endphp
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">
                            <a href="{{ route('contratos.index', array_merge(request()->all(), ['sort' => 'nombre', 'direction' => $sort === 'nombre' ? $opposite : 'asc'])) }}"
                                class="hover:underline flex items-center gap-1">
                                Nombre
                                @if($sort === 'nombre')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 border">Documento</th>
                        <th class="px-4 py-2 border">Cargo</th>
                        <th class="px-4 py-2 border">Empresa</th>
                        <th class="px-4 py-2 border">Fecha Ingreso</th>
                        <th class="px-4 py-2 border">
                            <a href="{{ route('contratos.index', array_merge(request()->all(), ['sort' => 'fecha_corte', 'direction' => $sort === 'fecha_corte' ? $opposite : 'asc'])) }}"
                                class="hover:underline flex items-center gap-1">
                                Fecha de corte
                                @if($sort === 'fecha_corte')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados as $empleado)
                        @php
                            $info = $empleado->informacionLaboralActual;
                            $estado = $info?->estadoCargo;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $empleado->nombre_completo }}</td>
                            <td class="px-4 py-2 border">{{ $empleado->numero_documento }}</td>
                            <td class="px-4 py-2 border">{{ $estado?->cargo?->nombre_cargo ?? 'Sin cargo' }}</td>
                            <td class="px-4 py-2 border">{{ $empleado->empresa?->nombre_empresa ?? 'Sin empresa' }}</td>
                            <td class="px-4 py-2 border">{{ optional($info?->fecha_ingreso)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 border">{{ $empleado->fecha_corte?->format('Y-m-d') ?? 'Sin fecha' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
