<div>
    <label for="nombre-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre</label>
    <input type="text" id="nombre-edit" name="nombre" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]" autocomplete="off">
</div>
<div>
    <label for="tipo-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo de Laboratorio</label>
    <select id="tipo-edit" name="tipo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3]">
    </select>
</div>
<div>
    <label for="cantidad-edit" id="label-cantidad-edit" class="hidden block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Cantidad de Computadoras</label>
    <input type="number" min="1" id="cantidad-edit" name="cantidad_computadoras" class="hidden w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]" autocomplete="off">
</div>

<input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">

<button type="submit" value="Editar Laboratorio" class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl mt-4 hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">Actualizar Laboratorio</button>