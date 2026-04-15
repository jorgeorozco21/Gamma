@props(['infoLaboratorio','reportes'])
<div id="contenedor-tarjetas" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 max-w-8xl mx-auto">
    @foreach ($infoLaboratorio as $com)

        <div data-id="{{ $com->id }}" data-numerocomputadora="{{ $com->numero_computadora }}" class="tarjeta bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md hover:border-[#7B1FA3] hover:border-2 transition-all h-full cursor-pointer">
            <!-- Cantidad de Reportes -->
            <div class="mb-4">
                <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                    {{ $com->cantidad_reportes }} Reportes
                </span>
            </div>

            <!-- Nombre de Computadora -->
            <h3 class="font-bold text-gray-900 text-base leading-tight">
                {{ $com->numero_computadora }}
            </h3>
        </div>
    @endforeach
</div>