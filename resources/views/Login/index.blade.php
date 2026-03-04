<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio Sesion</title>
    </head>
    <body>
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
        @if (session('error'))
            <div class="alerta success">
                <ul>
                    <li>{{ session('error') }}</li>
                </ul>
            </div>
        @endif
        <div>
            <h2>Inicia Sesion</h2>
            <form method="post" action="{{ route('login.login') }}">
                @csrf
                @include('Login.form')
            </form>
        </div>

        @vite('resources/js/Admin/alertas.js')
    </body>
</html>