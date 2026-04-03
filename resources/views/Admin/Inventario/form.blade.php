<div class="space-y-4">
    <div>
        <label for="material" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Material</label>
        <select id="material" name="id_material" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
            @foreach ($materiales as $material)
                <option value="{{ $material->id }}">{{ $material->nombre }}</option>
            @endforeach
        </select>
        <input type="hidden" name="cantidad_disponible" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all">
    </div>
    <div>
        <label for="cantidad" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad_total" min="1" value="1" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all" autocomplete="off">
    </div>
    <div>
        <label for="laboratorio" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Laboratorio</label>
        <select id="laboratorio" name="id_laboratorio" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
            @foreach ($laboratorios as $laboratorio)
                <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="pt-2">
        <button type="submit" value="Agregar Inventario"
                class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                Agregar Inventario
        </button>
    </div>
</div>
