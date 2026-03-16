<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="h-full overflow-hidden">

    <div class="flex h-full">
        <!-- Sidebar -->
        <x-admin.sidebar-admin />

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-4">
                    <button id="abrir-sidebar" class="md:hidden p-2 rounded-xl bg-gray-50 text-[#7B1FA3] hover:bg-purple-50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Usuarios</h1>
                        <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            Administración de Usuarios
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button id="abrir-modal" class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-4 md:px-5 py-2 rounded-xl text-xs md:text-sm font-bold transition-all shadow-lg shadow-purple-100 flex items-center gap-2 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden xs:block">Nuevo Usuario</span>
                        <span class="xs:hidden">Nuevo</span>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 pt-0 no-scrollbar space-y-8">
            
                <!-- Alertas -->
                <x-admin.alertas-usuarios />

                <!-- Filtros -->
                <x-admin.filtro-usuarios :grupos="$grupos" />

                <!-- Tabla de Usuarios -->
                <x-admin.tabla-usuarios :usuarios="$usuarios" />

                <!-- Boton de Carga Masiva -->
                <x-admin.carga-masiva-usuarios />

            </div>
        </main>
    </div>

    <div id="modal" style="display: none;" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-lg relative overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-extrabold text-gray-800">Registrar Usuario</h3>
                <button id="cerrar-modal" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">✕</button>
            </div>
            <div class="p-8 pt-0 max-h-[80vh] overflow-y-auto">
                <form action="{{ route('admin.usuarios.store') }}" method="post" class="space-y-4">
                    @csrf
                    @include('Admin.Usuario.form')
                </form>
            </div>
        </div>
    </div>

    <div id="modal-edit" style="display: none;" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-lg relative overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-extrabold text-gray-800">Editar Usuario</h3>
                <button id="cerrar-modal-edit" class="text-gray-400 hover:text-red-500 font-bold text-xl transition-colors">✕</button>
            </div>
            <div class="p-8 pt-0 max-h-[80vh] overflow-y-auto">
                <form method="post" id="formulario-editar" class="space-y-4">
                    @csrf
                    {{ method_field('PATCH') }}
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre de Usuario</label>
                        <input type="text" id="nombre-usuario-edit" name="nombre_usuario" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]" autocomplete="off">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</label>
                        <input type="email" id="email-edit" name="email" readonly class="w-full px-4 py-2 bg-gray-100 border border-gray-100 rounded-xl text-gray-400" autocomplete="off">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre Completo</label>
                        <input type="text" id="nombre-completo-edit" name="nombre" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-[#7B1FA3]" autocomplete="off">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipos Usuario</label>
                        <div class="flex">
                            <label class="">
                                <input type="hidden" name="normal" value="0">
                                <input type="checkbox" id="tipo-normal-edit" name="normal"> Normal
                            </label>
                            <label class="">
                                <input type="hidden" name="encargado" value="0">
                                <input type="checkbox" id="tipo-encargado-edit" name="encargado"> Encargado de Area
                            </label>
                            <label class="">
                                <input type="hidden" name="mantenimiento" value="0">
                                <input type="checkbox" id="tipo-mantenimiento-edit" name="mantenimiento"> Encargado de Mantenimiento
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1" id="label-grupo-edit">Grupo</label>
                        <select id="grupo-edit" name="id_grupo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3]">
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->grado }} {{ $grupo->grupo }} {{ $grupo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="id_institucion" value="{{ session('id_institucion') }}">
                    <button type="submit" class="w-full bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl mt-4 hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">Actualizar Usuario</button>
                </form>
            </div>
        </div>
    </div>

    @vite(['resources/js/Admin/crud_usuarios.js', 'resources/js/Admin/buscador_usuarios.js', 'resources/js/Admin/alertas.js', 'resources/js/Admin/modal.js'])
</body>
</html>