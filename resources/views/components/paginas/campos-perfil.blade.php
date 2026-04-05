<div class="max-w-6xl mx-auto bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-gray-50">
    <!-- Form -->
    <form action="#" method="POST">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-[#7B1FA3] mb-2">Perfil de Usuario</h1>
                <p class="text-gray-500 text-sm font-medium">Gestiona tu información personal</p>
            </div>
            <!-- Boton de Guardar -->
            <button type="submit" class="flex items-center gap-2 bg-[#facc15] hover:bg-[#eab308] text-[#7B1FA3] px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm active:scale-95">
                Guardar Cambios
            </button>
        </div>

        <!-- Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            <!-- Input Nombre -->
            <div class="space-y-2">
                <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Nombre Completo
                </label>
                <input type="text" 
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
            <!-- Input Nombre de Usuario -->
            <div class="space-y-2">
                <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Nombre de Usuario
                </label>
                <input type="text"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
            <!-- Input Correo Electrinico -->
            <div class="space-y-2">
                <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Correo Electrónico
                </label>
                <input type="email"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
            <!-- Input Escuela -->
            <div class="space-y-2">
                <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Escuela
                </label>
                <input type="text"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
            <!-- Input Grado/Grupo -->
            <div class="space-y-2">
                <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Grado / Grupo
                </label>
                <input type="text" 
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
            <!-- Input Especialidad -->
            <div class="space-y-2">
                <label for="specialty" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Especialidad
                </label>
                <input type="text"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
        </div>

        <!-- Inputs de Contraseña -->
        <div id="camposContrasena" class="hidden mt-10 border-t pt-8 grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8">
            <!-- Contraseña Actual -->
            <div class="space-y-2">
                <label class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Contraseña Actual
                </label>
                <input type="password"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none">
            </div>
            <!-- Nueva Contraseña -->
            <div class="space-y-2">
                <label class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Nueva Contraseña
                </label>
                <input type="password"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none">
            </div>
            <!-- Repetir Contraseña -->
            <div class="space-y-2">
                <label class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Repetir Nueva Contraseña
                </label>
                <input type="password"
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none">
            </div>
        </div>

        <!-- Botones -->
        <div class="pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-center items-center gap-4">
            <!-- Cambiar Contraseña -->
            <button id="botonContrasena" type="button" class="flex items-center gap-2 bg-purple-50 text-[#7B1FA3] hover:bg-purple-600 hover:text-white px-6 py-3 rounded-lg font-bold text-[10px] uppercase tracking-[0.15em] transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                Cambiar Contraseña
            </button>

            <!-- Boton Cerrar Sesion -->
            <button type="button" class="flex items-center gap-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-8 py-3 rounded-lg font-bold text-[10px] uppercase tracking-[0.15em] transition-all active:scale-95 shadow-sm shadow-red-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar Sesión
            </button>
        </div>
    </form>
</div>

<script>
    const btn = document.getElementById('botonContrasena');
    const campos = document.getElementById('camposContrasena');

    btn.addEventListener('click', () => {
        campos.classList.toggle('hidden');
    });
</script>