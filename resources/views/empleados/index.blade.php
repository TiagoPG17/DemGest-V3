@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-6">
            <div class="flex flex-col md:flex-row md:items-center gap-4 w-full md:w-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-2 md:mb-0">Empleados</h1>
                <form action="{{ route('empleados.index') }}" method="GET" class="flex flex-row items-center gap-2 w-full md:w-auto">
                    <select name="empresa" onchange="this.form.submit()"
                        class="px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 hover:bg-white transition">
                        <option value="todos" {{ request()->get('empresa', 'todos') === 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="formacol" {{ request()->get('empresa') === 'formacol' ? 'selected' : '' }}>Formacol</option>
                        <option value="contiflex" {{ request()->get('empresa') === 'contiflex' ? 'selected' : '' }}>Contiflex</option>
                    </select>
                    <div class="relative w-full md:w-80">
                        <input type="text" name="buscar" value="{{ request('buscar') }}" class="w-full pl-4 pr-12 py-2.5 bg-slate-100 border border-gray-500 rounded-lg shadow-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base transition" placeholder="Buscar por nombre o documento..." autocomplete="off" style="min-width: 250px;">
                        @if(request('buscar'))
                            <a 
                                href="{{ route('empleados.index', array_merge(request()->except('buscar'), ['page' => 1])) }}" 
                                class="group absolute right-2 top-1/2 mt-1 -translate-y-1/2 inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100/80 text-gray-900 hover:text-black hover:bg-gray-100 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300 transition" 
                                title="Limpiar búsqueda"
                                aria-label="Limpiar búsqueda"
                            >
                                <svg class="w-5 h-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                    <a href="{{ route('empleados.create') }}"class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest shadow hover:bg-slate-700 transition ml-0 md:ml-8 whitespace-nowrap">
                        Nuevo Empleado
                    </a>
                </form>
            </div>
        </div>
        <br>
        <!-- Tabla de empleados -->
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        @php
                            $currentSort = request()->get('sort', 'nombre_completo');
                            $currentDirection = request()->get('direction', 'asc');
                            $oppositeDirection = $currentDirection === 'asc' ? 'desc' : 'asc'; 
                        @endphp
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>

                        <!-- Nombre -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('empleados.index', array_merge(request()->all(), ['sort' => 'nombre_completo', 'direction' => $currentSort === 'nombre_completo' ? $oppositeDirection : 'asc'])) }}"
                                    class="hover:underline flex items-center gap-1">
                                    Nombre
                                    @if ($currentSort === 'nombre_completo')
                                        <span>{{ $currentDirection === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>

                        <!-- Documento -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('empleados.index', array_merge(request()->all(), ['sort' => 'numero_documento', 'direction' => $currentSort === 'numero_documento' ? $oppositeDirection : 'asc'])) }}"
                                    class="hover:underline flex items-center gap-1">
                                    Documento
                                    @if ($currentSort === 'numero_documento')
                                        <span>{{ $currentDirection === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($empleados as $empleado)
                            <tr>
                            <!-- Número de fila con borde según empresa -->
                                <td class="py-4 pr-6 whitespace-nowrap
                                @php $empresaNombre = $empleado->informacionLaboralActual?->empresa?->nombre_empresa; @endphp
                                    @if($empresaNombre == 'Contiflex')
                                        border-l-4 border-sky-500 pl-4
                                    @elseif($empresaNombre == 'Formacol')
                                        border-l-4 border-red-500 pl-4
                                    @else
                                        pl-6
                                    @endif ">
                                    {{ $loop->iteration + ($empleados->currentPage() - 1) * $empleados->perPage() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $empleado->nombre_completo }}
                                </td>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
                                <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->numero_documento }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->informacionLaboralActual?->empresa?->nombre_empresa ?? 'No especificada' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 align-middle">                          
                                    <span class="px-2 py-2 inline-flex text-xs leading-none font-semibold rounded-full
                                        @if($empleado->estaActivo())
                                            bg-green-100 text-grS0
                                        @else
                                            bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ $empleado->estaActivo() ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="flex justify-end items-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('empleados.show', $empleado) }}"
                                        class="inline-flex items-center px-3 py-3 text-xs font-medium rounded-md shadow-sm text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-400"
                                        title="Ver Detalles">
                                            <i class="fas fa-file-alt text-white text-base"></i>
                                        </a>

                                        <a href="{{ route('empleados.edit', $empleado) }}"
                                        class="inline-flex items-center px-3 py-3 text-xs font-medium rounded-md shadow-sm text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400"
                                        title="Editar Empleado">
                                            <i class="fas fa-edit text-white text-base"></i>
                                        </a>

                                        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-3 text-xs font-medium rounded-md shadow-sm text-white bg-rose-500 hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-400" onclick="return confirm('¿Seguro que deseas eliminar este empleado?');" title="Eliminar Empleado">
                                                <i class="fas fa-times-circle text-white text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay empleados registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <br>
            <div class="flex flex-col items-center justify-center mt-6 space-y-2">
        <div class="text-sm text-gray-600">
            Mostrando {{ $empleados->firstItem() }} a {{ $empleados->lastItem() }} de {{ $empleados->total() }} resultados
        </div>
        <div class="flex justify-center">
            {{ $empleados->onEachSide(1)->links() }}
         </div>
     </div>

    <style>
        /* Botón de paginación genérico */
        .relative.inline-flex.items-center.px-4.py-2 {
            background-color: #1e293b !important; /* slate-800 */
            color: #f1f5f9 !important;            /* slate-100 */
            border: 1px solid #334155 !important; /* slate-700 */
            font-weight: 500;
            border-radius: 0.375rem; /* rounded-md */
            transition: all 0.2s ease-in-out;
        }

        /* Hover en cualquier botón */
        .relative.inline-flex.items-center.px-4.py-2:hover {
            background-color: #0f172a !important; /* slate-900 */
            color: #e0f2fe !important;            /* sky-100 */
            border-color: #0f172a !important;
        }

        /* Página actual (inactiva visual pero activa funcionalmente) */
        .relative.inline-flex.items-center.px-4.py-2.text-gray-500.bg-white.border.border-gray-300.cursor-default {
            background-color: #e2e8f0 !important; /* slate-200 */
            color: #1e293b !important;           /* slate-800 */
            border-color: #cbd5e1 !important;     /* slate-300 */
            font-weight: bold;
            cursor: default;
            border-radius: 0.375rem;
        }

        /* Botón flechas Anterior/Siguiente */
        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #1e293b !important;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
        }

        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:hover {
            background-color: #0f172a !important;
        }

        /* Separación entre flechas y números */
        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:first-child {
            margin-right: 12px;
        }

        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:last-child {
            margin-left: 12px;
        }

        /* Iconos */
        .fas.fa-chevron-left,
        .fas.fa-chevron-right {
            font-size: 0.8rem;
            color: inherit;
        }

        /* Mejora visual para el input de búsqueda */
        input[name="buscar"]:focus {
            box-shadow: 0 0 0 3px #6366f133;
            background: #fff;
        }
        .group:focus-within svg {
            color: #6366f1;
        }
    </style>


@endsection
