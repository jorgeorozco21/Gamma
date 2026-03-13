<button id="abrir-sidebar" class="md:hidden fixed top-4 left-4 z-[60] bg-white p-2.5 rounded-xl border border-gray-100 shadow-lg text-[#7B1FA3] transition-all duration-300">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

<aside class="w-64 bg-white h-screen flex flex-col border-r border-gray-100 shrink-0">
    <div class="p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#7B1FA3] rounded-xl flex items-center justify-center shadow-lg shadow-purple-100">
                </div>
            <div>
                <h1 class="text-sm font-extrabold text-[#7B1FA3] leading-none">GAMMA</h1>
            </div>
        </div>

        <button id="cerrar-sidebar" class="md:hidden p-1 text-gray-400 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <a href="{{ url('/Admin/Dashboard') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('Admin/Dashboard') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-5 h-5 {{ request()->is('Admin/Dashboard') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 12 2-2m0 0 7-7 7 7M5 10v10a1 1 0 0 0 1 1h3m10-11 2 2m-2-2v10a1 1 0 0 1-1 1h-3m-6 0a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1m-6 0v-7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7" />
            </svg>
            <span class="text-sm font-semibold">Dashboard</span>
        </a>

        <a href="{{ url('/Admin/Usuarios') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('Admin/Usuarios') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-5 h-5 {{ request()->is('Admin/Usuarios') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-sm font-semibold">Usuarios</span>
        </a>

        <a href="{{ url('/Admin/Grupos') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('Admin/Grupos') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-5 h-5 {{ request()->is('Admin/Grupos') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" />
            </svg>
            <span class="text-sm font-semibold">Grupos</span>
        </a>

        <a href="{{ url('/Admin/Laboratorios') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('Admin/Laboratorios') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-5 h-5 {{ request()->is('Admin/Laboratorios') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" />
            </svg>
            <span class="text-sm font-semibold">Laboratorios</span>
        </a>

        <a href="{{ url('/Admin/Materiales') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('Admin/Materiales') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-5 h-5 {{ request()->is('Admin/Materiales') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span class="text-sm font-semibold">Materiales</span>
        </a>

        <a href="{{ url('/Admin/Inventario') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('Admin/Inventario') ? 'bg-[#F5F3FF] text-[#7B1FA3]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-5 h-5 {{ request()->is('Admin/Inventario') ? 'text-[#7B1FA3]' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="text-sm font-semibold">Inventario</span>
        </a>
    </nav>
    
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer group">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=6B7280&color=fff" class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" alt="User">
                <div class="leading-tight">
                    <p class="text-xs font-bold text-gray-800">Admin User</p>
                    <p class="text-[10px] text-gray-400">admin@system.com</p>
                </div>
            </div>
            <form action="{{ url('/Logout') }}" method="POST" class="border-l pl-4 border-gray-100">
                @csrf
                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
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
                // ABRIR
                aside.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                btnAbrir.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            } else {
                // CERRAR
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