<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/webp" href="{{ asset('images/logos/labores_icono_morado.webp') }}">
</head>
<body class="bg-[#F7F6F8]">
    <x-admin.alertas-usuarios />
    <div class="flex flex-col min-h-screen">
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <x-paginas.navbar-paginas />
        </header>

        <main class="flex-1 p-6 md:p-12 space-y-20 max-w-7xl mx-auto w-full">
            <x-paginas.funcionamiento-plataforma />

            <x-paginas.roles-sistema />

            <x-paginas.beneficios-sistema />
        </main>
    </div>
</body>
</html>