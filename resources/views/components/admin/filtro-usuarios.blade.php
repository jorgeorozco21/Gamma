@props(['grupos'])
<div class="flex flex-col md:flex-row items-end gap-4 mb-6 bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm">
    <!-- Buscador -->
    <div class="flex-1 w-full">
        <label for="buscador" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Buscar Usuario</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" id="buscador" placeholder="Nombre, email o usuario..." autocomplete="off"
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#7B1FA3]/10 focus:border-[#7B1FA3] transition-all">
        </div>
    </div>

    <!-- Tipos de Usuario -->
    <div class="w-full md:w-64">
        <label id="label-filtrar-tipo" for="filtrar-tipo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Tipos de Usuario</label>
        <select id="filtrar-tipo" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] appearance-none cursor-pointer">
            <option value="Sin Filtro">Todos los tipos</option>
            <option value="normal">Normal</option>
            <option value="encargado">Encargado de Área</option>
            <option value="mantenimiento">Encargado de Mantenimiento</option>
        </select>
    </div>

    <!-- Grado / Grupo -->
    <div class="w-full md:w-64">
        <label for="filtrar-grupo" id="filtrar-grupo-label" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Grado / Grupo</label>
        <select id="filtrar-grupo" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] appearance-none cursor-pointer">
            <option value="Sin Filtro">Todos los grupos</option>
            @foreach ($grupos as $grupo)
                <option value="{{ $grupo->id }}">{{ $grupo->grado }}°{{ $grupo->grupo }} - {{ $grupo->nombre }} - {{ $grupo->turno }}</option>
            @endforeach
        </select>
    </div>
</div>