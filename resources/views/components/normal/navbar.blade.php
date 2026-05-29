@props(['laboratorio'])
<nav class="bg-white border-b border-gray-100 px-6 py-0 flex justify-between items-center relative z-40">
    
    <div class="flex items-center">
        <a href="{{ url('/seleccionar-tipo-usuario') }}" class="flex items-center">
            <img src="{{ asset('images/logos/labores_logo_horizontal_morado.webp') }}" alt="Logo Labpres" class="h-14 w-auto object-contain transition-transform duration-300 hover:scale-105">
        </a>
    </div>

    @if(!request()->routeIs('laboratorios'))
        <div class="hidden md:flex justify-center gap-8 text-sm font-semibold self-stretch items-center">
            <a href="{{ route('laboratorios') }}" class="transition-all {{ request()->routeIs('laboratorios') ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                Laboratorios
            </a>

            @if (!request()->routeIs('solicitudes-computo'))
                <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-laboratorio-normal') }}" class="transition-all {{ request()->is('*/laboratorio-normal') ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                    Materiales
                </a>
                <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-solicitudes') }}" class="transition-all {{ request()->is('*/solicitudes') ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                    Solicitudes
                </a>
            @endif
        </div>
    @endif

    <div class="hidden md:flex items-center gap-4 py-4 self-stretch">
        <a href="{{ url('/perfil') }}" class="flex flex-col leading-tight text-right">
            <span class="font-extrabold text-black text-sm">
                {{ session('nombre_usuario') }}
            </span>
            <span class="text-xs text-gray-400">
                {{ session('email') }}
            </span>
        </a>

        <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100 flex items-center h-full">
            @csrf
            <button class="text-gray-400 hover:text-red-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>

    <button id="openMenu" class="md:hidden text-gray-700 py-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</nav>

<div id="menuOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>

<div id="sideMenu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl 
        transform translate-x-full transition-transform duration-300 ease-in-out z-50 p-6 flex flex-col">

    <button id="closeMenu" class="self-end text-gray-400 hover:text-gray-700 mb-8">
        ✕
    </button>

    @if(!request()->routeIs('laboratorios'))
        <div class="flex flex-col gap-6 text-sm font-semibold">
            <a href="{{ route('laboratorios') }}" class="transition-all {{ request()->routeIs('laboratorios') 
                    ? 'text-[#7B1FA3] flex items-center gap-2' : 'text-gray-600 hover:text-[#7B1FA3]' }}">
                Laboratorios
            </a>
            @if (!request()->routeIs('solicitudes-computo'))
                <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-laboratorio-normal') }}" class="transition-all {{ request()->is('*/laboratorio-normal') ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                    Materiales
                </a>
                <a href="{{ url('/usuario/normal/laboratorios/'.$laboratorio->id.'-solicitudes') }}" class="transition-all {{ request()->is('*/solicitudes') ? 'text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1' : 'text-gray-400 hover:text-[#7B1FA3] pb-[6px]' }}">
                    Solicitudes
                </a>
            @endif
        </div>
    @endif

    <div class="mt-auto border-t pt-4 flex items-center justify-between">
        <a href="{{ url('/perfil') }}" class="flex flex-col leading-tight">
            <span class="font-extrabold text-black text-sm">
                {{ session('nombre_usuario') }}
            </span>
            <span class="text-xs text-gray-400">
                {{ session('email') }}
            </span>
        </a>

        <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100">
            @csrf
            <button class="flex items-center gap-2 text-gray-500 hover:text-red-500 transition font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
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