<nav class="bg-white border-b border-gray-100 px-6 py-0 flex justify-between items-center relative z-40 h-16 w-full shadow-sm">
    <div class="flex items-center">
        @if(Route::is('pagina-principal'))
            <div class="flex items-center">
                <img src="{{ asset('images/logos/labores_logo_horizontal_morado.webp') }}" alt="Logo Labores" class="h-14 w-auto object-contain">
            </div>
        @else
            <a href="{{ url('/seleccionar-tipo-usuario') }}" class="flex items-center">
                <img src="{{ asset('images/logos/labores_logo_horizontal_morado.webp') }}" alt="Logo Labores" class="h-14 w-auto object-contain transition-transform duration-300 hover:scale-105">
            </a>
        @endif
    </div>
    <div class="flex items-center gap-4 py-4">
        @if(Route::is('pagina-principal'))
            <a href="{{ url('/login') }}" class="group flex items-center gap-2.5 bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-5 py-2.5 rounded-xl transition-all shadow-md active:scale-[0.98]">
                <svg class="w-4 h-4 text-white/90 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>

                <span class="text-xs font-bold tracking-wide">Iniciar Sesión</span>
            </a>

        @elseif(Route::is('seleccionar-perfil'))
            <div class="flex items-center gap-4 self-stretch">
                <div class="hidden md:flex items-center gap-4 self-stretch">
                    <a href="{{ url('/perfil') }}" class="flex flex-col leading-tight text-right group justify-center">
                        <span class="font-extrabold text-black text-sm transition-colors">
                            {{ session('nombre_usuario') }}
                        </span>
                        <span class="text-xs text-gray-400 font-medium">
                            {{ session('email') }}
                        </span>
                    </a>

                    <form action="{{ url('/logout') }}" method="POST" class="border-l pl-4 border-gray-100 flex items-center h-full">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1 active:scale-90 outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="relative md:hidden group flex items-center">
                    <button class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center border-2 border-transparent active:border-[#7B1FA3] transition-all outline-none overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-[#7B1FA3]">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>

                    <div class="absolute right-0 mt-2 top-full w-52 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-2xl z-50 overflow-hidden opacity-0 scale-95 pointer-events-none transition-all duration-200 group-focus-within:opacity-100 group-focus-within:scale-100 group-focus-within:pointer-events-auto">
                        <div class="py-2">
                            <div class="px-4 py-3 border-b border-gray-50 mb-1">
                                <p class="text-xs font-bold text-gray-900 truncate">{{ session('nombre_usuario') }}</p>
                                <p class="text-[10px] text-gray-400 truncate">{{ session('email') }}</p>
                            </div>

                            <a href="{{ url('/perfil') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 active:bg-purple-50 active:text-[#7B1FA3] transition-colors">
                                <div class="p-2 bg-purple-50 rounded-lg">
                                    <svg class="w-4 h-4 text-[#7B1FA3]" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-black font-bold">Mi Perfil</span>
                            </a>

                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 active:bg-red-50 transition-colors text-left">
                                    <div class="p-2 bg-red-50 rounded-lg">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="font-bold">Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</nav>