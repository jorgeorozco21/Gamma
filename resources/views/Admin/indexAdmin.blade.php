<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
    </head>
    <body>
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
        <div>
            <ul>
                <li><a href="{{ url('/admin/usuarios') }}">Usuarios</a></li>
                <li><a href="{{ url('/admin/grupos') }}">Grupos</a></li>
                <li><a href="{{ url('/admin/laboratorios') }}">Laboratorios</a></li>
                <li><a href="{{ url('/admin/materiales') }}">Materiales</a></li>
                <li><a href="{{ url('/admin/inventario') }}">Inventario</a></li>
            </ul>
        </div>
        <div>
            Bienvenida
        </div>
    </body>
</html>