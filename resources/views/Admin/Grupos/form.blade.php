<div class="space-y-4">
    <div>
        <label for="nombre" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all" autocomplete="off">
    </div>
    <div>
        <label for="grado" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Grado</label>
        <input type="text" id="grado" name="grado" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all" autocomplete="off">
    </div>
    <div>
        <label for="grupo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Grupo</label>
        <input type="text" id="grupo" name="grupo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all" autocomplete="off">
    </div>

    <div>
        <label for="laboratorios" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Laboratorios</label>
        <div class="flex gap-2">
            <select id="laboratorios"
                class="flex-1 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
                @foreach ($laboratorios as $laboratorio)
                    <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                @endforeach 
            </select>

            <button type="button" id="agregar-laboratorio"
                class="px-4 py-2 bg-[#7B1FA3] text-white font-bold rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98] whitespace-nowrap">
                Agregar
            </button>
        </div>
    </div>

    <div id="laboratorios-agregados" class="max-h-[120px] overflow-y-auto pr-1"></div>
    
    <div class="pt-2">
        <button type="submit" value="Crear Grupo"
                class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                Agregar Grupo
        </button>
    </div>
</div>


<input type="hidden" id="inf-laboratorios" name="laboratorios">
<input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">