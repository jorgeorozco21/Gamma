<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laboratorios</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <body class="h-full overflow-hidden">
        <!-- Alertas -->
        <x-admin.alertas-usuarios />
        <x-admin.alertas-carga-masiva />
        
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
                            <h1 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Laboratorios</h1>
                            <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Administración de Laboratorios
                            </p>
                        </div>
                    </div>

                    <!-- Boton con Opciones (Nuevo Laboratorio y Carga Masiva) -->
                    <div class="relative inline-block text-left" id="dropdown-container">
                        <button id="btn-dropdown" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                            <span>Nuevo</span>
                            <svg class="w-3 h-3 ml-1 opacity-60 transition-transform duration-200" id="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div id="dropdown-menu" class="absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-2xl opacity-0 scale-95 pointer-events-none transition-all duration-200 z-50 overflow-hidden">
                            <div class="py-2">
                                <!-- Nuevo Laboratorio -->
                                <button id="abrir-modal" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#7B1FA3] transition-colors group">
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
                                <button id="abrir-carga-masiva" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#7B1FA3] transition-colors group">
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
                <div>
                    @if ($errors->errores_excel->any())
                        <div>
                            <h2>Errores Carga Masiva</h2>
                            <ul>
                                @foreach ($errors->errores_excel->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                <x-admin.filtro-laboratorios />

                <!-- Tabla Laboratorios -->
                <x-admin.tabla-laboratorios :laboratorios="$laboratorios" />
            </main>
        </div>

        <!-- Modal para crear  -->
        <div id="modal" style="display: none;" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-lg relative overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-extrabold text-gray-800">Nuevo Laboratorio</h3>
                    <button id="cerrar-modal" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">✕</button>
                </div>
                <div id="contenido-modal" class="p-8 pt-0 max-h-[80vh] overflow-y-auto">
                    <form action="{{ route('admin.laboratorios.store') }}" method="post" class="space-y-4">
                        @csrf
                        @include('Admin.Laboratorios.form')
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para editar -->
        <div id="modal-edit" style="display: none;" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-lg relative overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-extrabold text-gray-800">Editar Laboratorio</h3>
                    <button id="cerrar-modal-edit" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">✕</button>
                </div>
                <!-- Form de Editar Laboratorios -->
                <div id="contenido-modal-edit" class="p-8 pt-0 max-h-[80vh] overflow-y-auto">
                    <form method="post" id="formulario-editar" class="space-y-4">
                        @csrf
                        {{ method_field('PATCH') }}
                        @include('Admin.Laboratorios.form_editar')
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Carga Masiva -->
        <div id="modal-carga" style="display: none;" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div id="content-carga" class="relative bg-white w-full max-w-md p-8 rounded-[30px] shadow-2xl transform transition-all duration-300 overflow-hidden">
                <button id="cerrar-modal-carga" class="absolute top-6 right-6 text-gray-400 hover:text-red-500 transition-colors font-bold text-xl">✕</button>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-[#7B1FA3] shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Carga Masiva</h2>
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Importar Laboratorios</p>
                    </div>
                </div>
                <!-- Descripcion Carga Masiva -->
                <div class="mb-2 bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                    <p class="text-[11px] text-gray-500 leading-relaxed">
                        La <strong class="text-gray-700">Carga Masiva</strong> es una herramienta diseñada para importar grandes volúmenes de datos mediante un solo archivo. 
                        En lugar de registrar cada cuenta manualmente, puedes subir una plantilla en formato <strong class="text-gray-700">.xlsx</strong> o <strong class="text-gray-700">.csv</strong> con toda la información y el sistema la procesará automáticamente.
                    </p>
                </div>
                <!-- Form Carga Masiva -->
                <div class="max-h-[80vh] overflow-y-auto">
                    <form action="{{ url('/carga-laboratorio') }}" method="post" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @include('Admin.Laboratorios.carga_masiva_laboratorios')
                    </form>
                </div>
            </div>
        </div>

        @vite(['resources/js/Admin/modal.js', 'resources/js/Admin/alertas.js', 'resources/js/Admin/crud_inventario.js', 'resources/js/Admin/buscador_inventario.js', 'resources/js/Admin/boton_modales.js'])
    </body>
</html>