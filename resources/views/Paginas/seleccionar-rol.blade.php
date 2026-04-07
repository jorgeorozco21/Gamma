<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F7F6F8]">
    <x-admin.alertas-usuarios />
    <!-- Header -->
    <x-paginas.navbar-paginas />
    <main class="max-w-7xl mx-auto px-4 pt-12 pb-20">
        <div class="text-center mb-16 max-w-6xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1A1A1A] mb-6">Selecciona tu Perfil</h1>
            <p class="text-gray-500 max-w-5xl mx-auto text-sm md:text-base leading-relaxed">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis architecto aliquam tempora laboriosam saepe magnam, consequuntur ipsa magni hic libero culpa ducimus accusantium, consectetur aut nulla numquam reiciendis excepturi error.
            </p>
        </div>
        <!-- Cards de Roles -->
        <x-paginas.cards-roles />
    </main>
</body>
</html>