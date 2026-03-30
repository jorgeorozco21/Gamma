@props(['solicitudes'])
<div class="bg-white rounded-[20px] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <!-- Encabezado de la Tabla -->
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Alumno</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID Solicitud</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Laboratorio</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Materiales</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Fecha</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estado Actual</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Proximo Estado</th>
                </tr>
            </thead>
            
            <tbody id="contenedor-solicitudes" class="divide-y divide-gray-50">
                @foreach ($solicitudes as $solicitud)

                    @php
                        
                        $info = json_decode($solicitud->info_usuario)

                    @endphp

                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <!-- Nombre, Correo y Grado/Grupo -->
                            <div class="flex items-center gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ $info->nombre }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">{{ $info->email }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">{{ $info->grado }} {{ $info->grupo }} {{ $info->nombreGrupo }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- ID de la Solicitud -->
                        <td class="px-6 py-4 text-sm font-mono text-gray-500">
                            {{ $solicitud->id }}
                        </td>

                        <!-- Laboratorio -->
                        <td class="px-6 py-4">
                            <span class="py-1 rounded-lg text-black text-xs font-bold tracking-tight">
                                {{ $info->nombreLaboratorio }}
                            </span>
                        </td>

                        <!-- Lista de Materiales-->
                        <td class="px-6 py-4">
                            <button type="button" onclick="openMaterialModal({{ $solicitud->id }}, {{ $solicitud->info_material }})" 
                                class="flex items-center gap-2 text-[#7B1FA3] group/btn">
                                <div class="p-1.5 bg-purple-100 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </div>
                            </button>
                        </td>

                        <!-- Fecha -->
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($solicitud->fecha)->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                                {{ $solicitud->estado }}
                            </span>
                        </td>

                        <!-- Estado de la Solicitud -->
                        <td class="px-6 py-4 text-center">
                            <!-- Select de Estados -->
                            @if ($solicitud->estado == 'aceptada')
                                <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                                    En prestamo
                                </span>
                            @elseif ($solicitud->estado == 'en prestamo')
                                <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                                    Recibido
                                </span>
                            @endif

                            <!-- Boton de Guardar -->
                            <button data-estado="{{ ($solicitud->estado == 'aceptada')?'en prestamo':'recibido' }}" data-id="{{ $solicitud->id }}"
                                class="cambiar p-2 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-green-100 active:scale-[0.98]"
                                title="Guardar cambio">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Lista de Materiales -->
<div id="material-Modal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeMaterialModal()"></div>
    
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[20px] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
            <!-- Encabezado -->
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-black tracking-wider uppercase">Materiales Solicitados</h3>
                <p class="text-[14px] font-mono text-gray-400 bg-gray-50 px-2 py-1 rounded-md" id="id-solicitud">#123456</p>
            </div>

            <!-- Lista de Materiales -->
            <div class="px-6 py-6">
                <ul id="material-Lista" class="space-y-3"></ul>
            </div>

            <!-- Cerrar Material -->
            <div class="bg-gray-50 px-6 py-4 flex justify-center">
                <button type="button" onclick="closeMaterialModal()" 
                    class="px-10 py-2 bg-[#7B1FA3] text-white text-xs font-bold rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openMaterialModal(requestId, materials) {
        const modal = document.getElementById('material-Modal');
        const listContainer = document.getElementById('material-Lista');
        const idLabel = document.getElementById('id-solicitud');

        listContainer.innerHTML = '';
        idLabel.innerText = '#' + requestId;

        // Lista
        materials.forEach(item => {
            const li = document.createElement('li');
            li.className = "flex items-center justify-between p-3 bg-gray-50/50 border-l-4 border-[#7B1FA3] rounded-r-xl shadow-sm";
            li.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-700 font-medium">${item.nombre}</span>
                </div>
                <span class="px-2 py-1 bg-purple-50 text-[#7B1FA3] text-xs font-bold rounded-lg border border-purple-100">
                    ${item.cantidad}
                </span>
            `;
            listContainer.appendChild(li);
        });

        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMaterialModal() {
        const modal = document.getElementById('material-Modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>