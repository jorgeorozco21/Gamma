@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">

        {{-- Vista para Pantallas Pequeñas (Móvil) --}}
        <div class="flex gap-2 items-center justify-between w-full sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-xs font-bold text-gray-300 bg-gray-50 border border-gray-100 cursor-not-allowed rounded-xl">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-xs font-bold text-[#7B1FA3] bg-purple-50 border border-purple-100 rounded-xl hover:bg-purple-100 active:scale-95 transition-all">
                    Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-xs font-bold text-[#7B1FA3] bg-purple-50 border border-purple-100 rounded-xl hover:bg-purple-100 active:scale-95 transition-all">
                    Siguiente
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-xs font-bold text-gray-300 bg-gray-50 border border-gray-100 cursor-not-allowed rounded-xl">
                    Siguiente
                </span>
            @endif
        </div>

        {{-- Vista para Pantallas Medianas y Grandes (Escritorio) --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">

            <!-- Texto Informativo -->
            <div>
                <p class="text-xs text-gray-500">
                    Mostrando
                    @if ($paginator->firstItem())
                        <span class="font-bold text-gray-800">{{ $paginator->firstItem() }}</span>
                        al
                        <span class="font-bold text-gray-800">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    de
                    <span class="font-bold text-gray-800">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>

            <!-- Botones de Paginación -->
            <div>
                <span class="inline-flex shadow-xs rounded-xl overflow-hidden border border-gray-100 gap-0.5 bg-gray-50/50 p-0.5">

                    {{-- Botón Anterior --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold text-gray-300 bg-gray-50/50 cursor-not-allowed rounded-lg" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold text-gray-600 bg-white rounded-lg hover:bg-purple-50 hover:text-[#7B1FA3] transition-colors" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Elementos de Paginación --}}
                    @foreach ($elements as $element)
                        {{-- Separador "..." --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-gray-400 bg-white rounded-lg cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Arreglo de Enlaces --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-white bg-[#7B1FA3] rounded-lg cursor-default shadow-xs">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-gray-600 bg-white rounded-lg hover:bg-purple-50 hover:text-[#7B1FA3] transition-colors" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Botón Siguiente --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold text-gray-600 bg-white rounded-lg hover:bg-purple-50 hover:text-[#7B1FA3] transition-colors" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold text-gray-300 bg-gray-50/50 cursor-not-allowed rounded-lg" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif

                </span>
            </div>
        </div>
    </nav>
@endif