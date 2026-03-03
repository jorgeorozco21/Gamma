<nav class="bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center relative z-40">
    
    <!-- Logo -->
    <div class="text-[#7B1FA3] font-extrabold text-xl tracking-tight">
        Gamma
    </div>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center gap-8 text-sm font-semibold">
        <a href="#" class="text-[#7B1FA3] border-b-2 border-[#7B1FA3] pb-1">Materiales</a>
        <a href="#" class="text-gray-400 hover:text-[#7B1FA3] transition">Solicitudes</a>
    </div>

    <!-- Desktop User -->
    <div class="hidden md:flex items-center gap-4">
        <div class="flex flex-col leading-tight text-right">
            <span class="font-extrabold text-black text-sm">
                Jonathan Orozco
            </span>
            <span class="text-xs text-gray-400">
                Alumno
            </span>
        </div>

        <button class="text-gray-400 hover:text-red-500 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </button>
    </div>

    <!-- Hamburger -->
    <button id="openMenu" class="md:hidden text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</nav>

<!-- Overlay -->
<div id="menuOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>

<!-- Mobile Side Menu -->
<div id="sideMenu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl 
        transform translate-x-full transition-transform duration-300 ease-in-out z-50 p-6 flex flex-col">

    <!-- Close Button -->
    <button id="closeMenu" class="self-end text-gray-400 hover:text-gray-700 mb-8">
        ✕
    </button>

    <!-- Links -->
    <div class="flex flex-col gap-6 text-sm font-semibold">
        <a href="#" class="text-[#7B1FA3]">Materiales</a>
        <a href="#" class="text-gray-600">Solicitudes</a>
    </div>

    <!-- User Section -->
    <div class="mt-auto border-t pt-6">
        <div class="flex flex-col leading-tight mb-4">
            <span class="font-extrabold text-black text-sm">
                Jonathan Orozco
            </span>
            <span class="text-xs text-gray-400">
                Alumno
            </span>
        </div>

        <button class="flex items-center gap-2 text-gray-500 hover:text-red-500 transition font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Cerrar sesión
        </button>
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