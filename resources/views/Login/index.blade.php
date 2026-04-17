<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio Sesion</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#7B1FA2] min-h-screen flex flex-col items-center justify-center p-6">
    
    <x-admin.alertas-usuarios />

    <a href="{{ route('pagina-principal') }}" class="absolute top-6 left-6 flex items-center gap-2 text-white hover:opacity-80 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span class="text-sm font-semibold">Volver</span>
    </a>

    <!-- Logo -->
    <a href="{{ route('pagina-principal') }}" class="mb-6">
        <h1 class="text-white text-3xl font-extrabold tracking-wide">
            GAMMA
        </h1>
    </a>

    <div class="w-full max-w-[440px] bg-white rounded-[32px] p-10 md:p-12 shadow-2xl shadow-black/20">
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Inicia Sesión</h2>
            <p class="text-gray-400 text-sm font-medium">Ingresa tus credenciales para acceder.</p>
        </div>

        <form method="post" action="{{ route('login.login') }}">
            @csrf
            @include('Login.form')
        </form>
    </div>

    @vite('resources/js/Admin/alertas.js')
</body>
</html>