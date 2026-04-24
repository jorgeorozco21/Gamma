@props(['solicitudes','solicitudes_eliminadas'])
<div id="contenedor-solicitudes" class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-7xl mx-auto max-h-[calc(100dvh-250px)] overflow-y-auto no-scrollbar">

    @foreach ($solicitudes_eliminadas as $solicitud)
        @for($i=0;$i<=20;$i++)
        <div data-id="{{ $solicitud->id }}" class="solicitud-eliminada bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm flex w-full hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 cursor-pointer">
            <div class="space-y-2 w-full">
                <div class="flex justify-between w-full">
                    <h2 class="text-lg font-extrabold text-[#1e293b] tracking-tight">
                        Solicitud de Materiales
                    </h2>
                </div>
                <div class="space-y-1 flex justify-between items-center">
                    <div>
                        <!-- ID de la Solicitud -->
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <span class="text-gray-600">ID:</span> {{ $solicitud->id_solicitud }}
                        </p>
                        <!-- Fecha de la Solicitud -->
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <span class="text-gray-600">Fecha:</span> {{ $solicitud->fecha }}
                        </p>
                    </div>
                    <div>
                        <div class="w-12 h-12 flex items-center justify-center bg-red-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    @endforeach

    @foreach ($solicitudes as $solicitud)
    @for($i=0;$i<=20;$i++)
        <!-- Card de la Solicitud -->
        <div data-id="{{ $solicitud->id }}" data-estado="{{ $solicitud->estado }}" class="solicitud bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm flex w-full hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 cursor-pointer">
            <div class="space-y-2 w-full">
                <div class="flex justify-between w-full">
                    <h2 class="text-lg font-extrabold text-[#1e293b] tracking-tight">
                        Solicitud de Materiales
                    </h2>
                </div>
                <div class="space-y-1 flex justify-between items-center">
                    <div>
                        <!-- ID de la Solicitud -->
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <span class="text-gray-600">ID:</span> {{ $solicitud->id }}
                        </p>
                        <!-- Fecha de la Solicitud -->
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            <span class="text-gray-600">Fecha:</span> {{ $solicitud->fecha }}
                        </p>
                    </div>
                    <div>
                        <!-- Icono de Estado de la Solicitud (Aceptada) -->
                        @if ($solicitud->estado == null)
                            <div class="w-12 h-12 flex items-center justify-center bg-amber-50 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                        @if ($solicitud->estado == 'aceptada')
                            <div class="w-12 h-12 flex items-center justify-center bg-green-50 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        @endif
                        @if ($solicitud->estado == 'en prestamo')
                            <div class="w-12 h-12 flex items-center justify-center bg-green-50 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endfor
    @endforeach
</div>