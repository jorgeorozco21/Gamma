@props(['materiales'])
<div class="bg-white rounded-[20px] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto overflow-y-auto max-h-[calc(100dvh-300px)] no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead class="sticky top-0 z-10 bg-gray-50">
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Nombre</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Descripcion</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Tipo de Prestamo</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="informacion-filtrada" class="divide-y divide-gray-50">
                @foreach ($materiales as $material)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <!-- Nombre del Material -->
                        <td class="px-6 py-4 text-sm text-black font-medium text-center">
                            {{ $material->nombre }}
                        </td>
                        <!-- Descripcion del Material -->
                        <td class="px-6 py-4 justify-center">
                            <div class="flex justify-center">
                                <button type="button" 
                                    onclick="openMaterialModal('{{ $material->descripcion }}')" 
                                    class="flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                                    title="Ver Descripcion">
                                    <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </td>
                        <!-- Tipo de Prestamo -->
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $material->tipo }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="seleccionar-registro hidden">
                                <input type="checkbox" value="{{ $material->id }}" class="check-borrar">
                            </div>
                            <div class="acciones flex items-center justify-center gap-2">
                                <!-- Editar -->
                                <button title="Editar" class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="{{ $material->id }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <!-- Eliminar -->
                                <form action="{{ url('/admin/materiales/'.$material->id) }}" method="post" class="inline">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit" title="Borrar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Deseas borrar el material?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Descripcion -->
<div id="descripcion-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeMaterialModal()"></div>
    
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative w-full max-w-md bg-white rounded-[20px] shadow-2xl overflow-hidden transition-all duration-300">
            <!-- Encabezado -->
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-black tracking-wider uppercase">Material</h3>
            </div>

            <div class="px-6 py-8">
                <div class="relative group">
                    <!-- Descripcion -->
                    <p class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Descripcion del Material</p>
                    <div class="relative">
                        <textarea id="descripcion-material" readonly 
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
    function openMaterialModal(description) {
        const modal = document.getElementById('descripcion-modal');
        const descField = document.getElementById('descripcion-material');

        descField.value = description;

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