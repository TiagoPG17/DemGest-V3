@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto p-4 lg:p-8">
        <!-- Título -->
        <div class="mb-6">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900">Empleados</h1>
        </div>
        
        <!-- Barra de búsqueda y filtros -->
        <div class="mb-8">
            <form action="{{ route('empleados.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <!-- Campo de búsqueda -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="buscar" value="{{ request('buscar') }}" 
                            class="w-full pl-4 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 placeholder-gray-400 transition-all duration-200 bg-white shadow-sm hover:shadow-md" 
                            placeholder="Buscar empleado..." 
                            autocomplete="off">
                        @if(request('buscar'))
                            <button type="button" onclick="window.location.href='{{ route('empleados.index', array_merge(request()->except('buscar'), ['page' => 1])) }}'" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none focus:ring-0">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @else
                            <button type="submit" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-800 transition-colors focus:outline-none focus:ring-0">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- Filtro de empresa -->
                <div class="sm:w-48">
                    <select name="empresa" onchange="this.form.submit()" 
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 bg-white transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                        <option value="todos" {{ request()->get('empresa', 'todos') === 'todos' ? 'selected' : '' }}>Todas</option>
                        <option value="formacol" {{ request()->get('empresa') === 'formacol' ? 'selected' : '' }}>Formacol</option>
                        <option value="contiflex" {{ request()->get('empresa') === 'contiflex' ? 'selected' : '' }}>Contiflex</option>
                    </select>
                </div>
                
                <!-- Botón de nuevo empleado (solo para admin y gestión humana) -->
                @if(is_admin() || is_gestion_humana())
                    <div class="sm:w-48">
                        <a href="{{ route('empleados.create') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-[rgb(60,66,80)] hover:bg-[rgb(70,76,90)] border border-white/20 rounded-xl font-semibold text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 whitespace-nowrap">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nuevo Empleado
                        </a>
                    </div>
                @endif
            </form>
        </div>
        <!-- Lista de empleados - Cards para móvil, tabla para desktop -->
        <div class="space-y-4">
            <!-- Versión Desktop: Tabla tradicional -->
            <div class="hidden lg:block bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            @php
                                $currentSort = request()->get('sort', 'nombre_completo');
                                $currentDirection = request()->get('direction', 'asc');
                                $oppositeDirection = $currentDirection === 'asc' ? 'desc' : 'asc'; 
                            @endphp
                            <tr class="bg-gray-50">
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('empleados.index', array_merge(request()->all(), ['sort' => 'nombre_completo', 'direction' => $currentSort === 'nombre_completo' ? $oppositeDirection : 'asc'])) }}"
                                        class="hover:underline flex items-center gap-1 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-0">
                                        Nombre
                                        @if ($currentSort === 'nombre_completo')
                                            <span class="text-blue-600">{{ $currentDirection === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('empleados.index', array_merge(request()->all(), ['sort' => 'numero_documento', 'direction' => $currentSort === 'numero_documento' ? $oppositeDirection : 'asc'])) }}"
                                        class="hover:underline flex items-center gap-1 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-0">
                                        Documento
                                        @if ($currentSort === 'numero_documento')
                                            <span class="text-blue-600">{{ $currentDirection === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($empleados as $empleado)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Número de fila con borde según empresa -->
                                    <td class="py-4 pr-4 whitespace-nowrap pl-4
                                    @php $empresaNombre = $empleado->informacionLaboralActual?->empresa?->nombre_empresa; @endphp
                                        @if($empresaNombre == 'Contiflex')
                                            border-l-4 border-sky-500
                                        @elseif($empresaNombre == 'Formacol')
                                            border-l-4 border-red-500
                                        @endif ">
                                        <span class="text-sm text-gray-600">{{ $loop->iteration + ($empleados->currentPage() - 1) * $empleados->perPage() }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $empleado->nombre_completo }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $empleado->numero_documento }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $empleado->informacionLaboralActual?->empresa?->nombre_empresa ?? 'No especificada' }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-none font-semibold rounded-full
                                            @if($empleado->estaActivo())
                                                bg-green-100 text-green-800
                                            @else
                                                bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ $empleado->estaActivo() ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Botón Ver (para todos los roles que tienen acceso) -->
                                            <a href="{{ route('empleados.show', $empleado) }}"
                                            class="inline-flex items-center px-4 py-3 text-xs font-medium rounded-md shadow-sm text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-400 transition-colors"
                                            title="Ver detalles completos del empleado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- Botón Editar (solo para admin y gestión humana) -->
                                            @if(is_admin() || is_gestion_humana())
                                                <a href="{{ route('empleados.edit', $empleado) }}"
                                                class="inline-flex items-center px-4 py-3 text-xs font-medium rounded-md shadow-sm text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 transition-colors"
                                                title="Editar información del empleado">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                            
                                            <!-- Botón Eliminar (solo para admin y gestión humana) -->
                                            @if(is_admin() || is_gestion_humana())
                                                <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-3 text-xs font-medium rounded-md shadow-sm text-white bg-rose-500 hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-400 transition-colors" onclick="return confirm('¿Seguro que deseas eliminar este empleado?');" title="Eliminar empleado permanentemente">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <div class="text-lg font-medium">No hay empleados registrados.</div>
                                        <div class="text-sm mt-1">Comienza agregando un nuevo empleado.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Versión Móvil: Cards -->
            <div class="lg:hidden space-y-4">
                @forelse($empleados as $empleado)
                    @php
                        $empresaNombre = $empleado->informacionLaboralActual?->empresa?->nombre_empresa;
                        $borderColor = $empresaNombre == 'Contiflex' ? 'border-sky-500' : ($empresaNombre == 'Formacol' ? 'border-red-500' : 'border-gray-300');
                    @endphp
                    <div class="bg-white rounded-lg shadow-sm border-l-4 {{ $borderColor }} hover:shadow-md transition-shadow">
                        <div class="p-4">
                            <!-- Encabezado con número y estado -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
                                        {{ $loop->iteration + ($empleados->currentPage() - 1) * $empleados->perPage() }}
                                    </span>
                                    <span class="px-2 py-1 inline-flex text-xs leading-none font-semibold rounded-full
                                        @if($empleado->estaActivo())
                                            bg-green-100 text-green-800
                                        @else
                                            bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ $empleado->estaActivo() ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <!-- Botón Ver (para todos los roles que tienen acceso) -->
                                    <a href="{{ route('empleados.show', $empleado) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-sky-500 hover:bg-sky-600 text-white transition-colors"
                                    title="Ver detalles completos del empleado">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Botón Editar (solo para admin y gestión humana) -->
                                    @if(is_admin() || is_gestion_humana())
                                        <a href="{{ route('empleados.edit', $empleado) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-amber-500 hover:bg-amber-600 text-white transition-colors"
                                        title="Editar información del empleado">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    <!-- Botón Eliminar (solo para admin y gestión humana) -->
                                    @if(is_admin() || is_gestion_humana())
                                        <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-rose-500 hover:bg-rose-600 text-white transition-colors" onclick="return confirm('¿Seguro que deseas eliminar este empleado?');" title="Eliminar empleado permanentemente">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Información principal -->
                            <div class="space-y-2">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Nombre</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $empleado->nombre_completo }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Documento</div>
                                    <div class="text-sm text-gray-900">{{ $empleado->numero_documento }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Empresa</div>
                                    <div class="text-sm text-gray-900">{{ $empresaNombre ?? 'No especificada' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                        <div class="text-lg font-medium text-gray-900">No hay empleados registrados.</div>
                        <div class="text-sm text-gray-500 mt-1">Comienza agregando un nuevo empleado.</div>
                    </div>
                @endforelse
            </div>
        </div>
        <br>
        <div class="flex flex-col items-center justify-center mt-6 space-y-2">
            <div class="text-sm text-gray-600">
                Mostrando {{ $empleados->firstItem() }} a {{ $empleados->lastItem() }} de {{ $empleados->total() }} resultados
            </div>
            <div class="flex justify-center">
                {{ $empleados->links() }}
            </div>
        </div>

    <style>
        /* =============================================
           ESTILOS RESPONSIVE PARA PAGINACIÓN
           ============================================= */
        
        /* Botón de paginación genérico - Desktop */
        .relative.inline-flex.items-center.px-4.py-2 {
            background-color: #1e293b !important; /* slate-800 */
            color: #f1f5f9 !important;            /* slate-100 */
            border: 1px solid #334155 !important; /* slate-700 */
            font-weight: 600;
            border-radius: 0.5rem; /* rounded-lg */
            transition: all 0.2s ease-in-out;
            min-width: 48px; /* Más grande para mejor visibilidad */
            min-height: 48px; /* Altura consistente */
            justify-content: center;
            font-size: 0.95rem;
            margin: 0 2px;
        }

        /* Hover en cualquier botón */
        .relative.inline-flex.items-center.px-4.py-2:hover {
            background-color: #0f172a !important; /* slate-900 */
            color: #e0f2fe !important;            /* sky-100 */
            border-color: #0f172a !important;
            transform: translateY(-1px);
        }
        
        /* Página actual (inactiva visual pero activa funcionalmente) */
        .relative.inline-flex.items-center.px-4.py-2.text-gray-500.bg-white.border.border-gray-300.cursor-default {
            background-color: #3b82f6 !important; /* blue-500 */
            color: #ffffff !important;           /* white */
            border-color: #3b82f6 !important;     /* blue-500 */
            font-weight: 700;
            cursor: default;
            border-radius: 0.5rem;
            transform: none !important;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        /* Botón flechas Anterior/Siguiente */
        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #1e293b !important;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            min-width: 48px;
            min-height: 48px;
            justify-content: center;
            font-weight: 600;
            margin: 0 4px;
        }

        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:hover {
            background-color: #0f172a !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        /* Separación entre flechas y números */
        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:first-child {
            margin-right: 8px;
        }

        .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:last-child {
            margin-left: 8px;
        }

        /* Iconos */
        .fas.fa-chevron-left,
        .fas.fa-chevron-right {
            font-size: 1rem;
            color: inherit;
            font-weight: 900;
        }

        /* =============================================
           ESTILOS RESPONSIVE PARA MÓVIL
           ============================================= */
        
        /* Responsive para botones de paginación */
        @media (max-width: 640px) {
            /* Hacer botones adaptados para móvil */
            .relative.inline-flex.items-center.px-4.py-2 {
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
                min-width: 44px;
                min-height: 44px;
                margin: 0 1px;
            }
            
            .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium {
                padding: 0.75rem !important;
                font-size: 0.875rem !important;
                min-width: 44px;
                min-height: 44px;
                margin: 0 2px;
            }
            
            /* Reducir márgenes en móvil */
            .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:first-child {
                margin-right: 6px;
            }
            
            .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium:last-child {
                margin-left: 6px;
            }
            
            /* Iconos más grandes en móvil */
            .fas.fa-chevron-left,
            .fas.fa-chevron-right {
                font-size: 1.1rem;
            }
            
            /* Contenedor de paginación */
            .flex justify-center {
                flex-wrap: wrap;
                gap: 2px;
                padding: 0 8px;
            }
        }
        
        /* =============================================
           ESTILOS PARA CARDS MÓVILES
           ============================================= */
        
        /* Mejoras para cards en móvil */

        @media (max-width: 1024px) {
            /* Efectos hover para cards */
            .bg-white.rounded-lg.shadow-sm.border-l-4:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            }
            
            /* Botones de acción en cards */
            .inline-flex.items-center.justify-center.w-8.h-8 {
                transition: all 0.2s ease-in-out;
            }
            
            .inline-flex.items-center.justify-center.w-8.h-8:hover {
                transform: scale(1.1);
            }
            
            /* Badge de estado */
            .px-2.py-1.inline-flex.text-xs.leading-none.font-semibold.rounded-full {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
        }
        
        /* =============================================
           ESTILOS PARA BÚSQUEDA Y FILTROS
           ============================================= */
        
        /* Mejora visual para el input de búsqueda */
        input[name="buscar"]:focus {
            box-shadow: 0 0 0 3px #6366f133;
            background: #fff;
        }
        
        /* Select de empresa */
        select[name="empresa"]:focus {
            box-shadow: 0 0 0 3px #6366f133;
            background: #fff;
        }
        
        /* =============================================
           ESTILOS PARA TABLA DESKTOP
           ============================================= */
        
        /* Mejoras para tabla desktop */
        @media (min-width: 1024px) {
            /* Efectos hover para filas */
            tr.hover\:bg-gray-50:hover {
                background-color: #f8fafc !important;
            }
            
            /* Botones de acción en tabla */
            .inline-flex.items-center.px-2.py-2.text-xs.font-medium {
                transition: all 0.2s ease-in-out;
            }
            
            .inline-flex.items-center.px-2.py-2.text-xs.font-medium:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }
        }
        
        /* =============================================
           ESTILOS GENERALES
           ============================================= */
        
        /* Transiciones suaves */
        * {
            transition-duration: 0.2s;
        }
        
        /* Scroll suave */
        html {
            scroll-behavior: smooth;
        }
        
        /* Mejora de accesibilidad */
        button:focus,
        a:focus,
        input:focus,
        select:focus {
            outline: 2px solid #6366f1;
            outline-offset: 2px;
        }
        
        /* Placeholder personalizado */
        input::placeholder {
            color: #9ca3af;
            opacity: 0.8;
        }
        
        /* Animación para carga */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .bg-white.rounded-lg.shadow-sm {
            animation: fadeIn 0.3s ease-out;
        }
    </style>


@endsection