<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Grupos</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/webp" href="{{ asset('images/logos/labores_icono_morado.webp') }}">
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="h-full bg-[#F7F6F8]">
        <!-- Alertas -->
        <x-admin.alertas-usuarios />
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
                            <h2 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Grupos</h1>
                            <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Administración de Grupos
                            </p>
                        </div>
                    </div>

                    <button id="borrar-algunos">Borrar Algunos</button>

                    <!-- Boton con Opciones (Nuevo Grupo) -->
                    <div class="relative flex gap-2 text-left" id="dropdown-container">
                        <button id="btn-dropdown" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>

                        <x-admin.boton-exportar-excel route="admin.grupos.exportarGrupos" title="Exportar Grupos" />

                        <div id="dropdown-menu" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-2xl opacity-0 scale-95 pointer-events-none transition-all duration-200 z-50 overflow-hidden">
                            <div class="py-2">
                                <!-- Nuevo Grupo -->
                                <button id="abrir-modal" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#7B1FA3] transition-colors group">
                                    <div class="p-2 bg-purple-50 rounded-lg">
                                        <svg class="w-4 h-4 text-[#7B1FA3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold block">Nuevo Grupo</p>
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
                    <x-admin.filtro-grupos />

                    <!-- Tabla Grupos -->
                    <x-admin.tabla-grupos :grupos="$grupos" />
                </div>
            </main>
        </div>

        <!-- Modal Crear Grupo  -->
        <x-admin.modal-nuevo titulo="Registrar Grupo" :action="route('admin.grupos.store')">
            @include('Admin.Grupos.form')
        </x-admin.modal-nuevo>

        <!-- Modal Editar Grupo -->
        <x-admin.modal-editar titulo="Editar Grupo">
            @include('Admin.Grupos.form_editar')
        </x-admin.modal-editar>

        <div id="modal-laboratorios" style="display: none;">
            <button id="cerrar-modal-laboratorios">✕</button>
            <div id="contenido-modal-laboratorios">
            </div>
        </div>

        <input type="hidden" id="nombre-tabla" value="grupos">

        @vite(['resources/js/Admin/modal.js', 'resources/js/Admin/alertas.js','resources/js/Admin/crud_grupos.js', 'resources/js/Admin/buscador_grupos.js' , 'resources/js/Admin/boton_modales.js', 'resources/js/Admin/borrado_masivo.js'])
    </body>
</html>