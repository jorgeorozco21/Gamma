<!DOCTYPE html>
<html lang="en" class="h-full"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Informacion Computadoras</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/webp" href="{{ asset('images/logos/labores_icono_morado.webp') }}">
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            /* Scroll personalizado */
            .scroll-rojo::-webkit-scrollbar { width: 8px; }
            .scroll-rojo::-webkit-scrollbar-track { background: #fee2e2; border-radius: 10px;}
            .scroll-rojo::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 10px;}
            .scroll-rojo::-webkit-scrollbar-thumb:hover { background: #b91c1c; }
        </style>
    </head>
    <body class="h-full bg-[#F7F6F8]">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <x-admin.sidebar-admin :admin="$admin" />
            <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-4">
                        <button id="abrir-sidebar" class="md:hidden p-2 rounded-xl bg-gray-50 text-[#7B1FA3] hover:bg-purple-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h2 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Informes</h1>
                            <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Administración de Informes - {{ $laboratorio->nombre }}
                            </p>
                        </div>
                    </div>

                    <div class="relative inline-block text-left" id="dropdown-container">
                        <button id="nueva-computadora" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                </header>

                <div class="flex-1 overflow-y-auto p-6 no-scrollbar space-y-6">
                    <x-admin.filtro-computadoras />
                    <x-admin.tabla-computadoras :computadoras="$computadoras" />
                </div>
            </main>
        </div>

        <input type="hidden" id='id-lab' value="{{ $laboratorio->id }}">

        @vite(['resources/js/Admin/computadoras.js'])
    </body>
</html>