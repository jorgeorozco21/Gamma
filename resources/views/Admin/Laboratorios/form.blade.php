<div class="space-y-4">
    <div>
        <label for="nombre" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all autocomplete="off"">
    </div>
    <div>
        <label for="tipo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo de laboratorio</label>
        <select id="tipo" name="tipo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
            <option value="prestamos">Laboratorio de Prestamos</option>
            <option value="computo">Laboratorio de Computo</option>
        </select>
    </div>
    <div>
        <label for="cantidad" id="label-cantidad" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Cantidad de Computadoras</label>
        <input type="number" min="1" value="1" id="cantidad" name="cantidad_computadoras" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all" autocomplete="off">
    </div>

    <input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">
    
    <div class="pt-2">
        <button type="submit" value="Crear Laboratorio"
                class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                Crear Laboratorio
        </button>
    </div>
</div>

