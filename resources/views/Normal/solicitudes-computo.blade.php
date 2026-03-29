<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Solicitudes de Computo</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#F7F6F8]">
        <!-- Header -->
        <!-- Contenedor -->
        <main class="flex flex-1 overflow-hidden">
            <div class="flex-1 p-8 overflow-y-auto">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Solicitudes</h1>
                        <p class="text-gray-500 text-sm">Revisa las solicitudes de computo realizadas</p>
                    </div>
                </div>
                <!-- Componente Card Solicitud Computo -->
                <x-normal.card-solicitud-computo />
            </div>
            <!-- Componente Solicitud de Materiales-->
            <x-normal.solicitud-computo />
        </main>

        

        @vite(['resources/js/Normal/solicitudes.js'])
    </body>
</html>