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
<body class="h-full overflow-hidden bg-[#F7F6F8]">
    <div class="flex h-full">
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

                <a href="{{ url('/admin/solicitudes/exportar-solicitudes-'.$laboratorio->id) }}">Exportar Excel</a>

                <div>
                    <a href="{{ url('/admin/informes-reportes/laboratorios/'.$laboratorio->id.'-laboratorio-normal') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-white bg-[#7B1FA3] hover:bg-[#6A1B8E] active:scale-95 transition-colors">Reportes</a>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 no-scrollbar space-y-8">
                <x-admin.filtro-informes-materiales :materiales="$materiales" />
                <x-admin.tabla-informes-materiales :solicitudes="$solicitudes" />
            </div>
        </main>
    </div>

    <input type="hidden" id="id-lab" value="{{ $laboratorio->id }}">

    @vite(['resources/js/Admin/materiales.js'])
</body>
</html>