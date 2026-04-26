@props(['computadoras'])
<div class="bg-white rounded-[20px] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto overflow-y-auto max-h-[calc(100dvh-300px)] no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead class="sticky top-0 z-10 bg-gray-50">
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">No. Computadora</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Estado</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Reportes </th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Cambiar Estado</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Reemplazar Equipo</th>
                </tr>
            </thead>
            <!-- En todos los archivos que se va a mostar la informacion la parte del tbody tiene que tener ese id para que funcione el filtro de informacion -->
            <tbody id="informacion-filtrada" class="divide-y divide-gray-50">
                @foreach ($computadoras as $computadora)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-sm text-black font-medium text-center">{{ $computadora->numero_computadora }}</td>
                        <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg {{ ($computadora->estado == 'activo')?'bg-green-50 text-green-600 border border-green-100':'bg-red-50 text-red-600 border border-red-100' }} w-fit">
                                {{ $computadora->estado }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <button data-id="{{ $computadora->id }}" data-computadora="{{ $computadora->numero_computadora }}"
                                    class="reportes flex items-center gap-2 text-[#7B1FA3] hover:text-white">
                                    <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <button data-id="{{ $computadora->id }}" class="cambiar-estado flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-black hover:text-[#7B1FA3] hover:bg-purple-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-9M20 7l-3-3M20 7l-3 3M4 17h9M4 17l3 3M4 17l3-3" />
                                    </svg>
                                    <span class="font-medium">Cambiar estado</span>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <button data-id="{{ $computadora->id }}" class="reemplazar flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-black hover:text-[#7B1FA3] hover:bg-purple-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 4v6h-6M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                                    </svg>
                                    <span class="font-medium">Reemplazar equipo</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Descripcion -->
<div id="reportes-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeMaterialModal()"></div>
    
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative w-full max-w-md bg-white rounded-[20px] shadow-2xl overflow-hidden transition-all duration-300">
            <!-- Encabezado -->
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-black tracking-wider uppercase">Reportes</h3>
                <p class="text-[14px] font-mono text-gray-400 bg-gray-50 px-2 py-1 rounded-md" id="numero-computadora"></p>
            </div>

            <div id="contenedor-reportes" class="p-4">
            </div>

            <!-- Boton de Cerrar -->
            <div class="bg-gray-50 px-6 py-5 flex justify-center">
                <button type="button" onclick="closeMaterialModal()" 
                    class="cerrar-modal-reportes px-10 py-2 bg-[#7B1FA3] text-white text-xs font-bold rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="auditoria-modal" class="fixed inset-0 z-[150] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeAuditoriaModal()"></div>
    
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[20px] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[750px]" >
            <!-- Encabezado -->
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-black tracking-wider uppercase">Auditoria</h3>
                <p class="text-[14px] font-mono text-gray-400 bg-gray-50 px-2 py-1 rounded-md" id="id-auditoria">#</p>
            </div>

            <div id="contenedor-auditorias" class="p-4 w-full overflow-x-auto no-scrollbar">
            </div>

            <!-- Boton de Cerrar -->
            <div class="bg-gray-50 px-6 py-5 flex justify-center">
                <button type="button" onclick="closeAuditoriaModal()" 
                    class="cerrar-modal-auditoria px-10 py-2 bg-[#7B1FA3] text-white text-xs font-bold rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeMaterialModal() {
        document.getElementById('contenedor-reportes').innerHTML = '';
        document.getElementById('numero-computadora').innerHTML = '';
        const modal = document.getElementById('reportes-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function closeAuditoriaModal() {
        document.getElementById('contenedor-auditorias').innerHTML = '';
        document.getElementById('id-auditoria').innerHTML = '';
        const modal = document.getElementById('auditoria-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>