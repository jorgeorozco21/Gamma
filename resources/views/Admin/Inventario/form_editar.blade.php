<div>
    <label for="material-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Material</label>
    <select id="material-edit" name="id_material" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3]">
    </select>
    <input type="hidden" id="cantidad-disponible-edit" name="cantidad_disponible" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]">
    <input type="hidden" id="cantidad-total-anterior-edit" name="cantidad_total_anterior" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]">
</div>
<div>
    <label for="cantidad-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Cantidad</label>
    <input type="number" id="cantidad-edit" name="cantidad_total" min="1" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]">
</div>
<div>
    <label for="laboratorio-edit" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Laboratorio</label>
    <select id="laboratorio-edit" name="id_laboratorio" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3]">
    </select>
</div>
<button type="submit" value="Editar Informacion" class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl mt-4 hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">Actualizar Inventario</button>