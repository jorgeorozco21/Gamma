<nav class="bg-white flex items-center justify-between px-6 h-16 w-full shadow-sm">
    <!-- Logo -->
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-[#7B1FA3] rounded-lg flex items-center justify-center"></div>
        <span class="font-extrabold text-lg tracking-tight text-[#7B1FA3]">GAMMA</span>
    </div>

    <!-- Usuario -->
    <div class="hidden md:flex items-center gap-4">
        @if(Route::is('pagina-principal'))
        <a href="{{ url('/login') }}" class="group flex items-center gap-2 bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-5 py-2 rounded-xl transition-all shadow-md active:scale-[0.98]">
            <span class="text-[14px] font-bold">Login</span>
        </a>

        @elseif(Route::is('seleccionar-perfil'))
            <a href="{{ url('/perfil') }}" class="flex flex-col leading-tight text-right">
                <span class="font-extrabold text-black text-sm">
                    {{ session('nombre_usuario') }}
                </span>
                <span class="text-xs text-gray-400 font-medium">
                    {{ session('email') }}
                </span>
            </a>

            <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100">
                @csrf
                <button class="text-gray-400 hover:text-red-500 transition-colors p-1 active:scale-90">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        @endif
    </div>
</nav>