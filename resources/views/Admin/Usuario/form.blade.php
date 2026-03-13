<div class="space-y-4">
    <div>
        <label for="nombre-usuario" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre de Usuario</label>
        <input type="text" id="nombre-usuario" name="Nombre_Usuario" 
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="Jonathan Orozco">
    </div>

    <div>
        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</label>
        <input type="email" id="email" name="Email" 
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="correo@ejemplo.com">
    </div>

    <div>
        <label for="nombre-completo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre Completo</label>
        <input type="text" id="nombre-completo" name="Nombre" 
                class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                placeholder="Nombre y Apellidos">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="tipo-usuario" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipo Usuario</label>
            <select id="tipo-usuario" name="Tipo_Usuario" 
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
                <option value="Normal">Normal</option>
                <option value="Encargado de Area">Encargado de Area</option>
                <option value="Encargado de Mantenimiento">Encargado de Mantenimiento</option>
            </select>
        </div>

        <div id="contenedor-grupo">
            <label for="grupo" id="label-grupo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Grupo</label>
            <select id="grupo" name="ID_Grupo" 
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->Grado }}°{{ $grupo->Grupo }} - {{ $grupo->Nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <input type="hidden" name="ID_Institucion" value="{{ session('id_institucion') }}">
    
    <div class="pt-2">
        <button type="submit" 
                class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
            Crear Usuario
        </button>
    </div>
</div>