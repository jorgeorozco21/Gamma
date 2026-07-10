@props(['datos'])
<div class="max-w-6xl mx-auto bg-white rounded-[30px] p-8 md:p-10 shadow-sm border border-gray-50">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#7B1FA3] mb-2">Perfil de Usuario</h1>
            <p class="text-gray-500 text-sm font-medium">Gestiona tu información personal</p>
        </div>
    </div>

    <!-- Inputs -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
        <!-- Input Nombre -->
        <div class="space-y-2">
            <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Nombre Completo
            </label>
            <input type="text" value="{{ $datos['usuario']->nombre }}" disabled
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>
        <!-- Input Nombre de Usuario -->
        <div class="space-y-2">
            <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Nombre de Usuario
            </label>
            <input type="text" value="{{ $datos['usuario']->nombre_usuario }}" disabled
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>
        <!-- Input Correo Electrinico -->
        <div class="space-y-2">
            <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Correo Electrónico
            </label>
            <input type="email" value="{{ $datos['usuario']->email }}" disabled
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>
        <!-- Input Escuela -->
        <div class="space-y-2">
            <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Escuela
            </label>
            <input type="text" value="{{ $datos['usuario']->nombreInstitucion }}" disabled
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>

        @if (isset($datos['grupo']) && $datos['grupo'])
            <!-- Input Grado/Grupo -->
            <div class="space-y-2">
                <label for="" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Grado / Grupo
                </label>
                <input type="text" value="{{ $datos['grupo']->grado }} {{ $datos['grupo']->grupo }}" disabled
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>  

            <!-- Input Especialidad -->
            <div class="space-y-2">
                <label for="specialty" class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                    Especialidad / Turno
                </label>
                <input type="text" value="{{ $datos['grupo']->nombre }} - {{ $datos['grupo']->turno }}" disabled
                    class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm text-gray-700 font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
            </div>
        @endif
    </div>

    <!-- Inputs de Contraseña -->
    <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cambiar la contraseña?')" action="{{ url('/perfil/cambiar-contrasena') }}" class="mt-10 border-t pt-8 grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8">
        @csrf
        
        <div class="space-y-2">
            <label class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Contraseña Actual
            </label>
            <input type="password" name="contrasenaActual"
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>

        <div class="space-y-2">
            <label class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Nueva Contraseña
            </label>
            <input type="password" name="nuevaContrasena"
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>

        <div class="space-y-2">
            <label class="block text-[10px] font-extrabold text-[#7B1FA3] uppercase tracking-[0.10em] ml-1">
                Repetir Nueva Contraseña
            </label>
            <input type="password" name="validarContrasena"
                class="w-full bg-gray-100 px-5 py-3 rounded-lg text-sm font-bold border-b-2 border-gray-200 focus:border-[#7B1FA3] focus:outline-none transition-colors">
        </div>
        
        <div class="flex justify-center items-center md:col-span-3 w-full">
            <button type="submit" class="flex items-center gap-2 bg-purple-50 text-[#7B1FA3] hover:bg-[#7B1FA3] hover:text-white px-8 py-3 rounded-xl font-bold text-[10px] uppercase tracking-[0.15em] transition-all active:scale-[0.98] border border-purple-100 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Cambiar Contraseña
            </button>
        </div>
    </form>
</div>