@props(["laboratorios"])
<div class="overflow-y-auto max-h-[calc(100dvh-300px)] px-2 no-scrollbar">
    <div id="contenedor-tarjetas" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 max-w-8xl mx-auto">
        @foreach ($laboratorios as $laboratorio)
        @for($i=0;$i<=20;$i++)
            <!-- Card de Laboratorio -->
            @if ($laboratorio->tipo == 'prestamos')<a href="{{ url('/admin/informes/laboratorios/'.$laboratorio->id.'-laboratorio-normal') }}" class="flex flex-col gap-2 cursor-pointer">@endif
            @if ($laboratorio->tipo == 'computo')<a href="{{ url('/admin/informes/laboratorios/'.$laboratorio->id.'-laboratorio-computo/computadoras') }}" class="flex flex-col gap-2 cursor-pointer">@endif
                <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 h-full">
                    <!-- Tipo de laboratorio -->
                    <div class="mb-4">
                        <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider uppercase">
                            {{ $laboratorio->tipo }}
                        </span>
                    </div>

                    <!-- Nombre -->
                    <h3 class="font-bold text-gray-900 text-base leading-tight">
                        {{ $laboratorio->nombre }}
                    </h3>
                </div>
            </a>
            @endfor
        @endforeach
    </div>
</div>