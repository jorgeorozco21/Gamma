<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitudes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/labores_icono_morado.webp') }}">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>    
</head>
<body class="bg-[#F7F6F8] h-full">
    <!-- Header -->
    <x-normal.navbar :laboratorio="$laboratorio" />
    <!-- Contenedor -->
    <main class="flex flex-1 overflow-x-hidden">
        <div class="flex-1 p-8 overflow-y-auto min-w-0">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Solicitudes</h1>
                    <p class="text-gray-500 text-sm">Revisa las solicitudes realizadas</p>
                </div>
            </div>
            <!-- Componente Card Estado de la Solicitud-->
            <x-normal.card-estado-solicitud :solicitudes="$solicitudes" :solicitudes_eliminadas="$solicitudes_eliminadas" />
        </div>
        <!-- Componente Solicitud de Materiales-->
        <x-normal.solicitud />
    </main>

    <input type="hidden" id="idLaboratorio" value="{{ $laboratorio->id }}">

    @vite(['resources/js/Normal/solicitudes.js'])
</body>
</html>