<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reportes</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="bg-[#F7F6F8] h-full overflow-hidden">
        <div class="flex h-full">
            <!-- Header -->
            <x-sidebar-general />

            <!-- Contenedor -->
            <main class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-4">
                        <button id="abrir-sidebar" class="md:hidden p-2 rounded-xl bg-gray-50 text-[#7B1FA3] hover:bg-purple-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h1 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Reportes</h1>
                            <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Administración de Reportes
                            </p>
                        </div>
                    </div>
                </header>

                <div class="flex-1 overflow-y-auto p-8 no-scrollbar space-y-8">
                    <!-- Filtro de Reportes -->

                    <!-- Tabla de Solicitudes -->
                    <x-encargado-mantenimiento.tabla-reportes />
                </div>
            </main>
        </div>
    </body>
</html>