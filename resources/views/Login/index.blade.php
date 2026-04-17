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