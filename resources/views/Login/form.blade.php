<div class="space-y-2 mb-6">
    <label for="nombre-usuario" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre de Usuario</label>
    <input type="text" id="nombre-usuario" name="nombre_usuario" value="{{ old('nombre_usuario') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all">
</div>
<div class="space-y-2 mb-6">
    <label for="contrasena" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contraseña</label>
    <input type="password" id="contrasena" name="contrasena" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all">
</div>
<input type="submit" value="Inicia Sesion" class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98] cursor-pointer">