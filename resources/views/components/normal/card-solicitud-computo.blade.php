@props(['infoLaboratorio','reportes'])
<div id="contenedor-tarjetas" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 max-w-8xl mx-auto">
    @for ($i=1;$i<=$infoLaboratorio->cantidad_computadoras;$i++)
        @php
            $cantidad = $reportes[$i] ?? 0;
        @endphp

        <div data-numerocomputadora="{{ $i }}" class="tarjeta bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md hover:border-[#7B1FA3] hover:border-2 transition-all h-full cursor-pointer">
            <!-- Cantidad de Reportes -->
            <div class="mb-4">
                <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                    {{ $cantidad }} Reportes
                </span>
            </div>

            <!-- Nombre de Computadora -->
            <h3 class="font-bold text-gray-900 text-base leading-tight">
                PC-{{ $i }}
            </h3>
        </div>
    @endfor
</div>