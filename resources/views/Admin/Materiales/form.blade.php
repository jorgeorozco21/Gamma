<div class="space-y-4">
    <!-- Nombre del Material -->
    <div>
        <label for="nombre" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre del Material</label>
        <input type="text" id="nombre" name="nombre"
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="Arduino" autocomplete="off">
    </div>
    <!-- Descripcion del Material -->
    <div>
        <label for="descripcion" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Descripcion</label>
        <textarea id="descripcion" name="descripcion"
                class="w-full max-h-32 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="Arduino" autocomplete="off"></textarea>
    </div>
    <!-- Tipo de Prestamo -->
    <label for="tipo" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo de Prestamos</label>
    <select id="tipo" name="tipo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
        <option value="prestamos por unidad">Prestamos por Unidad</option>
        <option value="prestamos por cantidad">Prestamos por Cantidad</option>
    </select>

    <input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">

    <!-- Boton de Crear Material -->
    <div class="pt-2">
        <button type="submit" value="Crear Material" 
            class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
            Crear Material
        </button>
    </div>
</div>