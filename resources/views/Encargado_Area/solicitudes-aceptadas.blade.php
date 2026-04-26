<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Solicitudes Aceptadas</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="h-full">
        <div class="flex min-h-screen">
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

                <div class="flex items-center gap-3">
                    <button id="abrir-modal" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden xs:block">Nueva Solicitud</span>
                        <span class="xs:hidden">Nuevo</span>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-6 no-scrollbar space-y-6">
                <!-- Filtro de Solicitudes -->
                <x-encargado-area.filtro-solicitudes :laboratorios="$laboratorios"/>
                
                <!-- Tabla de Solicitudes Aceptadas -->
                <x-encargado-area.tabla-solicitudes-aceptadas :solicitudes="$solicitudes" />
            </div>

            <div id="material-modal-reporte" class="fixed inset-0 z-[100] hidden overflow-y-auto">
                <div id="fondo-reporte" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
                
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-[20px] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                        <!-- Encabezado -->
                        <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-extrabold text-black tracking-wider uppercase">Reportar Material</h3>
                            <button type="button" id="cerrar-modal-reporte" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">    
                                ✕
                            </button>
                        </div>

                        <div class="px-6 py-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ID de Solicitud</label>
                            <div class="flex gap-1">
                                <select id="opciones-solicitudes" class="w-full px-2 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
                                </select>
                                <button id="boton-buscar" class="w-1/3 text-xs bg-[#7B1FA3] text-white font-bold px-2 py-2 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        <div class="px-6 py-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Seleccionar Material</label>
                            <div class="flex gap-1">
                                <select id="opciones-materiales-reportar" class="w-full px-2 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all" disabled>
                                </select>
                                <button id="boton-seleccionar" class="w-1/3 text-xs bg-[#7B1FA3] text-white font-bold px-2 py-2 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                                    Seleccionar
                                </button>
                            </div>
                        </div>

                        <div class="px-6 py-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Cantidad</label>
                            <div id="cantidad" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"></div>
                        </div>

                        <div class="px-6 py-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Descripcion del Problema</label>
                            <textarea id="descripcion" class="w-full max-h-32 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all"
                                placeholder="Descripcion del problema..." disabled></textarea>
                        </div>

                        <div class="px-6 py-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Cantidad a Reparar</label>
                            <div class="flex items-center justify-center gap-3">
                            <button id="menos" class="hidden w-1/3 text-xs bg-[#7B1FA3] text-white font-bold px-2 py-2 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                                -
                            </button>
                            <div id="cantidad-reportar" class="w-1/3 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3] transition-all text-center font-semibold">
                            </div>
                            <button id="mas" class="hidden w-1/3 text-xs bg-[#7B1FA3] text-white font-bold px-2 py-2 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
                                +
                            </button>
                        </div>

                        <div class="py-4 flex justify-center mt-2">
                            <button id="enviar-reporte" class="px-10 py-2 bg-[#7B1FA3] text-white text-xs font-bold rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]" disabled>Reportar</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <input type="hidden" id="id_usuario" value="{{ $usuario->id }}">
    <input type="hidden" id="nombre" value="{{ $usuario->nombre }}">
    <input type="hidden" id="email" value="{{ $usuario->email }}">

    @vite(['resources/js/Encargado/solicitudes_aceptadas.js'])
</html>