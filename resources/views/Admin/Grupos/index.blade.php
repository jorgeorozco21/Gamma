<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Grupos</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="h-full overflow-hidden">
        <!-- Alertas -->
        <x-admin.alertas-usuarios />
        <div class="flex h-full">
            <!-- Sidebar -->

            <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-4">
                        <button id="abrir-sidebar" class="md:hidden p-2 rounded-xl bg-gray-50 text-[#7B1FA3] hover:bg-purple-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h1 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Grupos</h1>
                            <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Administración de Grupos
                            </p>
                        </div>
                    </div>

                    <!-- Boton con Opciones (Nuevo Grupo) -->
                    <div class="relative inline-block text-left" id="dropdown-container">
                        <button id="btn-dropdown" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                            <span>Nuevo</span>
                            <svg class="w-3 h-3 ml-1 opacity-60 transition-transform duration-200" id="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div id="dropdown-menu" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-2xl opacity-0 scale-95 pointer-events-none transition-all duration-200 z-50 overflow-hidden">
                            <div class="py-2">
                                <!-- Nuevo Grupo -->
                                <button id="abrir-modal" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#7B1FA3] transition-colors group">
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
                <div>
                    @if ($errors->any())
                        <div class="alerta errores">
                            <h2>Errores</h2>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alerta success">
                            <ul>
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Filtros -->
                <x-admin.filtro-grupos />

                <!-- Tabla Grupos -->
                <x-admin.tabla-grupos :grupos="$grupos" />
            </main>
        </div>

        <!-- Modal para crear  -->
        <div id="modal" style="display: none;" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-lg relative overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-extrabold text-gray-800">Registrar Grupo</h3>
                    <button id="cerrar-modal" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">✕</button>
                </div>
                <div id="contenido-modal" class="p-8 pt-0 max-h-[80vh] overflow-y-auto">
                    <form action="{{ route('admin.grupos.store') }}" method="post" class="space-y-4">
                        @csrf
                        @include('Admin.Grupos.form')
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para editar -->
        <div id="modal-edit" style="display: none;" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-lg relative overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-extrabold text-gray-800">Editar Grupo</h3>
                    <button id="cerrar-modal-edit" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">✕</button>
                </div>
                <div id="contenido-modal-edit" class="p-8 pt-0 max-h-[80vh] overflow-y-auto">
                    <form method="post" id="formulario-editar" class="space-y-4">
                        @csrf
                        {{ method_field('PATCH') }}
                        @include('Admin.Grupos.form_editar')
                    </form>
                </div>
            </div>
        </div>

        <div id="modal-laboratorios" style="display: none;">
            <button id="cerrar-modal-laboratorios"> X </button>
            <div id="contenido-modal-laboratorios">
            </div>
        </div>

        @vite(['resources/js/Admin/modal.js', 'resources/js/Admin/alertas.js', 'resources/js/Admin/crud_inventario.js', 'resources/js/Admin/buscador_inventario.js', 'resources/js/Admin/boton_modales.js'])
    </body>
</html>