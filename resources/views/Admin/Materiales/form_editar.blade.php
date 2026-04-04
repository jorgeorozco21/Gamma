<!-- Nombre del material -->
<div>
    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1" for="nombre-edit">Nombre del Material</label>
    <input type="text" id="nombre-edit" name="nombre" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]" autocomplete="off">
</div>
<!-- Descripcion del Material -->
<div>
    <label for="descripcion-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Descripcion</label>
    <textarea id="descripcion-edit" name="descripcion" class="w-full max-h-32 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all" autocomplete="off"></textarea>
</div>
<!-- Tipo de Prestamo -->
<div>
    <label for="tipo-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo de Prestamos</label>
    <select id="tipo-edit" name="tipo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3]">
        <option value="prestamos por unidad">Prestamos por Unidad</option>
        <option value="prestamos por cantidad">Prestamos por Cantidad</option>
    </select>
</div>

<input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">

<!-- Boton de Actualizar -->
<button type="submit" value="Editar Material" class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl mt-4 hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]"> Actualizar Material </button>