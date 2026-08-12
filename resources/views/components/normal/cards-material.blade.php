@props(['materiales'])
<div id="contenedor-materiales" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 max-w-7xl mx-auto max-h-[calc(100dvh-250px)] overflow-y-auto no-scrollbar">
    @foreach ($materiales as $material)
        @php
            $color = "";
            $colorLetra = "";
            $band = true;
            $porcentaje = round(($material->cantidad_disponible * 100) / $material->cantidad_total);

            if ($material->cantidad_disponible == 0) $band = false;
            else{
                if ($porcentaje <= 40){
                    $color = "#FFEDD5";
                    $colorLetra = "#C2410C";
                }else{
                    $color = "#DCFCE7";
                    $colorLetra = "#15803D";
                }
            }
        @endphp

        @if ($band)    
            <div class="flex flex-col gap-2">
                <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 h-full">
                    <div class="mb-4">
                        <span class="bg-[{{ $color }}] text-[{{ $colorLetra }}] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                            {{ $material->cantidad_disponible }} Disponibles
                        </span>
                    </div>
                    
                    <h3 class="font-bold text-gray-900 leading-tight mb-2 h-10 text-base">{{ $material->nombre }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-3 flex-grow leading-relaxed">{{ $material->descripcion }}</p>

                    <button data-id="{{ $material->id }}" data-nombre="{{ $material->nombre }}" data-tipo="{{ $material->tipo }}" data-cantidaddisponible="{{ $material->cantidad_disponible }}" class="tarjeta-material mt-6 w-full py-2 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white">
                        <span class="text-lg">+</span> Añadir
                    </button>
                </div>
            </div>
        @endif

        @if (!$band)
            <div class="flex flex-col gap-2">
                <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col opacity-60 grayscale-[0.5] h-full">
                    <div class="mb-4">
                        <span class="bg-[#FEE9E9] text-[#CA5555] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                            0 Disponibles
                        </span>
                    </div>
                    
                    <h3 class="font-bold text-gray-900 leading-tight mb-2 h-10 text-base">{{ $material->nombre }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-3 flex-grow leading-relaxed">{{ $material->descripcion }}</p>

                    <button disabled class="mt-6 w-full py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors bg-gray-100 text-gray-400 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12"/>
                            <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        </svg>
                        No Disponible
                    </button>
                </div>
            </div>
        @endif
    @endforeach
</div>