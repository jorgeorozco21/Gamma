<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Analisis de Datos</title>
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
                    <button id="abrir-sidebar" class="md:hidden text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h2 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Analisis de Datos</h1>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-6 no-scrollbar space-y-6">
                <x-admin.filtro-analisis-datos />

                <x-admin.graficas-analisis-datps />
            </div>
        </main>
    </div>

    @vite(['resources/js/Admin/analisis_de_datos.js'])
</body>
</html>