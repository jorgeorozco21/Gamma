<div class="bg-white rounded-[20px] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <!-- Encabezado de la Tabla -->
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Materiales Dañados</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Descripcion</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Fecha</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Estado del Mantenimiento</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Acciones</th>
                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <!-- Material Dañado -->
                    <td class="px-6 py-4">
                        <span class="py-1 rounded-lg text-black text-xs font-bold tracking-tight">
                            Laboratorio C
                        </span>
                    </td>

                    <!-- Descripcion -->
                    <td class="px-6 py-4 justify-center">
                        <button type="button" 
                            onclick="openMaterialModal('123456', 'Necesito la computadora para realizar la práctica de C++.')" 
                            class="flex items-center gap-2 text-[#7B1FA3]"
                            title="Ver Reporte">
                            <div class="p-1.5 bg-purple-100 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </button>
                    </td>

                    <!-- Fecha -->
                    <td class="px-6 py-4 text-sm text-gray-500">
                        21/03/2026
                    </td>

                    <!-- Estado del Reporte -->
                    <td class="px-6 py-4 text-center">
                        <form class="flex items-center justify-center gap-2">
                            <!-- Select de Estados -->
                            <select class="text-[11px] font-bold uppercase tracking-wide bg-white border border-gray-200 rounded-xl px-3 py-1.5 text-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-100 focus:border-[#7B1FA3] cursor-pointer transition-all">
                                <option value="proceso">En Proceso</option>
                                <option value="recibido">Terminado</option>
                            </select>
                            
                            <!-- Boton de Guardar -->
                            <button type="submit" 
                                class="p-2 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-green-100 active:scale-[0.98]"
                                title="Guardar cambio">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8H7v8"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v4h8"/>
                                </svg>
                            </button>
                        </form>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                            <button class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all text-xs font-bold">
                                Reportar
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Descripcion -->
<div id="descripcion-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeMaterialModal()"></div>
    
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[20px] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
            <!-- Encabezado -->
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-black tracking-wider uppercase">Motivo del Mantenimiento</h3>
            </div>

            <!-- Descripcion -->
            <div class="px-6 py-8">
                <div class="relative group">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Descripción del Reporte</p>
                    <div class="relative">
                        <textarea id="descripcion-solicitud" readonly 
                            class="w-full p-5 bg-gray-50 border border-gray-100 rounded-[20px] text-sm text-gray-600 focus:outline-none resize-none h-40 leading-relaxed shadow-inner"
                            placeholder="Descripcion">
                        </textarea>
                    </div>
                </div>
            </div>

            <!-- Boton de Cerrar -->
            <div class="bg-gray-50 px-6 py-5 flex justify-center">
                <button type="button" onclick="closeMaterialModal()" 
                    class="px-10 py-2 bg-[#7B1FA3] text-white text-xs font-bold rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openMaterialModal(requestId, description) {
        const modal = document.getElementById('descripcion-modal');
        const descField = document.getElementById('descripcion-solicitud');

        descField.value = description || "El alumno no proporcionó una descripción adicional para esta solicitud.";

        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMaterialModal() {
        const modal = document.getElementById('descripcion-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>