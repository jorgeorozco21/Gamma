<div class="space-y-4">
    <div>
        <label for="nombre-usuario" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre de Usuario</label>
        <input type="text" id="nombre-usuario" name="nombre_usuario" 
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="Jonathan Orozco" autocomplete="off">
    </div>

    <div>
        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</label>
        <input type="text" id="email" name="email" 
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="correo@ejemplo.com" autocomplete="off">
    </div>

    <div>
        <label for="nombre-completo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre Completo</label>
        <input type="text" id="nombre-completo" name="nombre" 
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="Nombre y Apellidos" autocomplete="off">
    </div>

    <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipos Usuario</label>
        <div class="flex">
            <label class="">
                <input type="hidden" name="normal" value="0">
                <input type="checkbox" id="tipo-normal" name="normal"> Normal
            </label>
            <label class="">
                <input type="hidden" name="encargado" value="0">
                <input type="checkbox" id="tipo-encargado" name="encargado"> Encargado de Area
            </label>
            <label class="">
                <input type="hidden" name="mantenimiento" value="0">
                <input type="checkbox" id="tipo-mantenimiento" name="mantenimiento"> Encargado de Mantenimiento
            </label>
        </div>
    </div>

    <div id="contenedor-grupo">
        <label for="grupo" id="label-grupo" class="hidden text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Grupo</label>
        <select id="grupo" name="id_grupo" 
                class="hidden w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
            @foreach ($grupos as $grupo)
                <option value="{{ $grupo->id }}">{{ $grupo->grado }}°{{ $grupo->grupo }} - {{ $grupo->nombre }}</option>
            @endforeach
        </select>
    </div>

    <input type="hidden" name="id_institucion" value="{{ session('id_institucion') }}">
    
    <div class="pt-2">
        <button type="submit" 
                class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
            Crear Usuario
        </button>
    </div>
</div>