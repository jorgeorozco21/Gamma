@props(['inventarios'])
<h3 class="text-[16px] font-bold text-gray-800 leading-tight">Materiales con Menos Stock</h3>
<div class="bg-white rounded-[20px] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto overflow-y-auto max-h-[calc(100dvh-150px)] no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead class="sticky top-0 z-10 bg-gray-50">
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Nombre del Material</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Cantidad Disponible</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Cantidad Total</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Laboratorio</th>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($inventarios as $i)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-sm text-black text-center font-medium">{{ $i->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-black text-center font-medium">{{ $i->cantidad_disponible }}</td>
                        <td class="px-6 py-4 text-sm text-black text-center font-medium">{{ $i->cantidad_total }}</td>
                        <td class="px-6 py-4 text-sm text-black text-center font-medium">{{ $i->nombreLaboratorio }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>