@props(['admin'])
<aside class="w-64 bg-white h-screen flex flex-col border-r border-gray-100 shrink-0">
    <div class="p-6 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#7B1FA3] rounded-xl flex items-center justify-center shadow-lg shadow-purple-100"></div>
            <a href="{{ url('/seleccionar-tipo-usuario') }}">
                <h1 class="text-sm font-extrabold text-[#7B1FA3] leading-none">GAMMA</h1>
            </a>
        </div>

        <button id="cerrar-sidebar" class="md:hidden p-1 text-gray-400 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        @if (request()->is('*encargado*'))
            <!-- Encargado de Area (Solicitudes) -->
            <p class="font-bold text-sm"> Prestamos </p>
            <a href="{{ url('/usuario/encargado/solicitudes-pendientes') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('usuario/encargado/solicitudes-pendientes') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="w-5 h-5 {{ request()->is('usuario/encargado/solicitudes-pendientes') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold">Solicitudes Pendientes</span>
            </a>

            <a href="{{ url('/usuario/encargado/solicitudes-aceptadas') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('usuario/encargado/solicitudes-aceptadas') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <svg class="w-5 h-5 {{ request()->is('usuario/encargado/solicitudes-aceptadas') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">Solicitudes Aceptadas</span>
            </a>

            <p class="font-bold text-sm"> Computo </p>
            <a href="{{ url('/usuario/encargado/solicitudes-pendientes-computo') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('usuario/encargado/solicitudes-pendientes-computo') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="w-5 h-5 {{ request()->is('solicitudes-pendientes-computo') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold">Solicitudes Pendientes</span>
            </a>

            <a href="{{ url('/usuario/encargado/solicitudes-aceptadas-computo') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('usuario/encargado/solicitudes-aceptadas-computo') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <svg class="w-5 h-5 {{ request()->is('usuario/encargado/solicitudes-aceptadas-computo') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">Solicitudes Aceptadas</span>
            </a>

            <p class="font-bold text-sm"> Reportes </p>
            <a href="{{ url('/usuario/encargado/reportes-materiales') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('usuario/encargado/reportes-materiales') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="w-5 h-5 {{ request()->is('usuario/encargado/reportes-materiales') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold">Reportes</span>
            </a>
        @endif
        
        @if (request()->is('*mantenimiento*'))
            <!-- Encargado de Mantenimiento (Reportes) -->
            <p class="font-bold text-sm"> Reportes </p>
            <a href="{{ url('/usuario/mantenimiento/reportes-computo') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('/usuario/mantenimiento/reportes-computo') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <svg class="w-5 h-5 {{ request()->is('/usuario/mantenimiento/reportes-computo') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-sm font-semibold">Reportes de Computo</span>
            </a>

            <a href="{{ url('/usuario/mantenimiento/reportes-materiales') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('/usuario/mantenimiento/reportes-materiales') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <svg class="w-5 h-5 {{ request()->is('/usuario/mantenimiento/reportes-materiales') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-sm font-semibold">Reportes de Materiales</span>
            </a>
        @endif
        
    </nav>

    <!-- Nombre de Usuario y Correo -->
    <div class="p-2 border-t border-gray-100">
        <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition-colors group">
            <a href="{{ url('/perfil') }}" class="flex flex-col items-start gap-0.5">
                <p class="text-xs font-bold text-gray-800 break-words">Encargado {{ (request()->is('*encargado*'))?'Area':'Mantenimiento' }}</p>
                <p class="text-[10px] text-gray-400 truncate">{{ session('email') }}</p>
            </a>
            <!-- Cerrar Sesion -->
            <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100">
                @csrf
                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aside = document.querySelector('aside');
        const overlay = document.getElementById('sidebar-overlay');
        const btnAbrir = document.getElementById('abrir-sidebar');
        const btnCerrar = document.getElementById('cerrar-sidebar');

        const clasesResponsivas = [
            'fixed', 'inset-y-0', 'left-0', 'z-50', 
            'transform', '-translate-x-full', 'transition-transform', 
            'duration-300', 'ease-in-out', 'md:relative', 'md:translate-x-0'
        ];
        aside.classList.add(...clasesResponsivas);

        function toggleSidebar() {
            const estaEscondido = aside.classList.contains('-translate-x-full');
            
            if (estaEscondido) {
                aside.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                btnAbrir.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            } else {
                aside.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                btnAbrir.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }
        }

        btnAbrir.addEventListener('click', toggleSidebar);
        btnCerrar.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    });
</script>