@props(['laboratorio'])
<nav class="bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center relative z-40">
    <!-- Logo -->
    <div class="text-[#7B1FA3] font-extrabold text-xl tracking-tight">
        Gamma
    </div>

    <!-- Header Menu (Computadora) -->
    @if(!request()->routeIs('laboratorios'))
        <div class="hidden md:flex justify-center gap-8 text-sm font-semibold">
            <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-laboratorio-normal') }}" class="transition-all {{ request()->routeIs('/usuario/normal/laboratorios/'.$laboratorio->id.'-laboratorio-normal') 
                    ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                Materiales
            </a>
            <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-solicitudes') }}" class="transition-all {{ request()->routeIs('/usuario/normal/laboratorios/'.$laboratorio->id.'-solicitudes') 
                    ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                Solicitudes
            </a>
        </div>
    @endif

    <!-- Usuario (Computadora) -->
    <div class="hidden md:flex items-center gap-4">
        <div class="flex flex-col leading-tight text-right">
            <span class="font-extrabold text-black text-sm">
                {{ session('nombre_usuario') }}
            </span>
            <span class="text-xs text-gray-400">
                {{ session('nombre') }}
            </span>
        </div>

        <!-- Boton Cerrar Sesion -->
        <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100">
            @csrf
            <button class="text-gray-400 hover:text-red-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Menu de Hamburguesa (Movil) -->
    <button id="openMenu" class="md:hidden text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</nav>

<!-- Overlay (Movil) -->
<div id="menuOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>

<!-- Menu Lateral (Movil) -->
<div id="sideMenu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl 
        transform translate-x-full transition-transform duration-300 ease-in-out z-50 p-6 flex flex-col">

    <!-- Boton Cerrar Menu (Movil) -->
    <button id="closeMenu" class="self-end text-gray-400 hover:text-gray-700 mb-8">
        ✕
    </button>

    <!-- Links (Movil) -->
    @if(!request()->routeIs('laboratorios'))
        <div class="flex flex-col gap-6 text-sm font-semibold">
            <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-laboratorio-normal') }}" class="transition-colors {{ request()->routeIs('/usuario/normal/laboratorios/'.$laboratorio->id.'-laboratorio-normal') 
                    ? 'text-[#7B1FA3] flex items-center gap-2' : 'text-gray-600 hover:text-[#7B1FA3]' }}">
                Materiales
            </a>

            <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-solicitudes') }}" class="transition-colors {{ request()->routeIs('/usuario/normal/laboratorios/'.$laboratorio->id.'-solicitudes') 
                    ? 'text-[#7B1FA3] flex items-center gap-2' : 'text-gray-600 hover:text-[#7B1FA3]' }}">
                Solicitudes
            </a>
        </div>
    @endif

    <!-- Usuario (Movil) -->
    <div class="mt-auto border-t pt-6">
        <div class="flex flex-col leading-tight mb-4">
            <span class="font-extrabold text-black text-sm">
                {{ session('nombre_usuario') }}
            </span>
            <span class="text-xs text-gray-400">
                {{ session('nombre') }}
            </span>
        </div>

        <!-- Boton Cerrar Sesion (Movil)-->
        <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100">
            @csrf
            <button class="flex items-center gap-2 text-gray-500 hover:text-red-500 transition font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

<script>
    const openBtnMenu = document.getElementById("openMenu");
    const closeBtn = document.getElementById("closeMenu");
    const sideMenu = document.getElementById("sideMenu");
    const menuOverlay = document.getElementById("menuOverlay");

    function openMenu() {
        sideMenu.classList.remove("translate-x-full");
        menuOverlay.classList.remove("opacity-0", "pointer-events-none");
    }

    function closeMenu() {
        sideMenu.classList.add("translate-x-full");
        menuOverlay.classList.add("opacity-0", "pointer-events-none");
    }

    openBtnMenu.addEventListener("click", openMenu);
    closeBtn.addEventListener("click", closeMenu);
    menuOverlay.addEventListener("click", closeMenu);
</script>