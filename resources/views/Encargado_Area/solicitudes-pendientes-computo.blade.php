<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Solicitudes Pendientes de Computo</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="h-full overflow-hidden">
        <div class="flex h-full">
        <!-- Sidebar -->
        <x-sidebar-general />

        <!-- Contenedor -->
        <main class="flex-1 flex flex-col overflow-hidden bg-[#F9FAFB]">
            <!-- Header -->
            <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-4">
                    <button id="abrir-sidebar" class="md:hidden text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Solicitudes</h1>
                        <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            Administración de Solicitudes
                        </p>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 no-scrollbar space-y-8">
                <!-- Filtro de Solicitudes -->
                <x-encargado-area.filtro-solicitudes :laboratorios="$laboratorios" />

                <!-- Tabla de Solicitudes -->
                <x-encargado-area.tabla-solicitudes-computo :reportes="$reportes" />
            </div>
        </main>
        </div>
    </body>

    <input type="hidden" id="id_usuario" value="{{ $usuario->id }}">
    <input type="hidden" id="nombre" value="{{ $usuario->nombre }}">
    <input type="hidden" id="email" value="{{ $usuario->email }}">

    @vite(['resources/js/Encargado/solicitudes_pendientes_computo.js'])
</html>