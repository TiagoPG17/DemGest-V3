@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de paginación" class="flex items-center justify-center mt-6 space-x-1">

        {{-- Botón Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-400 bg-slate-200 rounded cursor-default select-none">
                Anterior
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-3 py-2 text-sm text-white bg-slate-700 hover:bg-slate-900 rounded transition">
                Anterior
            </a>
        @endif

        {{-- Números y puntos suspensivos --}}
        @foreach ($elements as $element)
            {{-- Separador --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-400 select-none">
                    {{ $element }}
                </span>
            @endif

            {{-- Links numerados --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                              class="px-3 py-2 text-sm font-bold text-white bg-slate-800 rounded shadow select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-2 text-sm text-white bg-slate-600 hover:bg-slate-900 rounded transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botón Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-3 py-2 text-sm text-white bg-slate-700 hover:bg-slate-900 rounded transition">
                Siguiente
            </a>
        @else
            <span class="px-3 py-2 text-sm text-gray-400 bg-slate-200 rounded cursor-default select-none">
                Siguiente
            </span>
        @endif

    </nav>
@endif
