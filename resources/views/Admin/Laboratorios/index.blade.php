<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laboratorios</title>
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
        <!-- Alertas -->
        <x-admin.alertas-usuarios />
        <x-admin.alertas-carga-masiva />
        
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <x-admin.sidebar-admin :admin="$admin" />

            <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-4">
                        <button id="abrir-sidebar" class="md:hidden text-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h2 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Laboratorios</h1>
                            <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Administración de Laboratorios
                            </p>
                        </div>
                    </div>

                    <button id="borrar-algunos">Borrar Algunos</button>

                    <!-- Boton con Opciones (Nuevo Laboratorio y Carga Masiva) -->
                    <div class="relative flex gap-2 text-left" id="dropdown-container">
                        <button id="btn-dropdown" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>

                        <x-admin.boton-exportar-excel route="admin.laboratorios.exportarLaboratorios" title="Exportar Laboratorios" />

                        <div id="dropdown-menu" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-2xl opacity-0 scale-95 pointer-events-none transition-all duration-200 z-50 overflow-hidden">
                            <div class="py-2">
                                <!-- Nuevo Laboratorio -->
                                <button id="abrir-modal" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#7B1FA3] transition-colors group">
                                    <div class="p-2 bg-purple-50 rounded-lg">
                                        <svg class="w-4 h-4 text-[#7B1FA3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold block">Nuevo Laboratorio</p>
                                    </div>
                                </button>

                                <div class="h-px bg-gray-50 mx-4 my-1"></div>

                                <!-- Carga Masiva -->
                                <button id="abrir-carga-masiva" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#7B1FA3] transition-colors group">
                                    <div class="p-2 bg-purple-50 rounded-lg">
                                        <svg class="w-4 h-4 text-[#7B1FA3]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold block">Carga Masiva</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="flex-1 overflow-y-auto p-6 no-scrollbar space-y-6">
                    <div id="opciones-borrado" class="hidden flex bg-white p-[5px]">
                        <p id="mostrar-cantidad-elementos">0 elemento(s) seleccionado(s)</p>
                        <button id="seleccionar-todo" class="ml-[30px] mr-[30px]">Seleccionar Todo</button>
                        <button id="limpiar-todo" class="ml-[30px] mr-[30px]">Limpiar Todo</button>
                        <button id="borrar-elementos" class="ml-[30px] mr-[30px]">Borrar</button>
                        <button id="anular-borrado" class="bg-red-500 p-[5px] ml-[30px] mr-[30px]">X</button>
                    </div>

                    <!-- Filtros -->
                    <x-admin.filtro-laboratorios />

                    <!-- Tabla Laboratorios -->
                    <x-admin.tabla-laboratorios :laboratorios="$laboratorios" />
                </div>
            </main>
        </div>

        <!-- Modal para crear  -->
        <x-admin.modal-nuevo titulo="Registrar Laboratorio" :action="route('admin.laboratorios.store')">
            @include('Admin.Laboratorios.form')
        </x-admin.modal-nuevo>

        <!-- Modal Editar Laboratorios -->
        <x-admin.modal-editar titulo="Editar Laboratorio">
            @include('Admin.Laboratorios.form_editar')
        </x-admin.modal-editar>

        <!-- Modal de Carga Masiva -->
        <x-admin.modal-carga-masiva subtitulo="Importar Laboratorios" action="/carga-laboratorio">
            @include('Admin.Laboratorios.carga_masiva_laboratorios')
        </x-admin.modal-carga-masiva>
        
        <input type="hidden" id="nombre-tabla" value="laboratorios">

        @vite(['resources/js/Admin/modal.js', 'resources/js/Admin/alertas.js', 'resources/js/Admin/crud_laboratorios.js', 'resources/js/Admin/buscador_laboratorios.js', 'resources/js/Admin/boton_modales.js', 'resources/js/Admin/borrado_masivo.js'])
    </body>
</html>