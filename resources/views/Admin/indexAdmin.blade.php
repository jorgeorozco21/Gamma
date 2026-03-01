<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
    </head>
    <body>
        <div>
            <ul>
                <li><a href="{{ url('/Admin/Usuarios') }}">Usuarios</a></li>
                <li><a href="{{ url('/Admin/Grupos') }}">Grupos</a></li>
                <li><a href="{{ url('/Admin/Laboratorios') }}">Laboratorios</a></li>
                <li><a href="{{ url('/Admin/Materiales') }}">Materiales</a></li>
                <li><a href="{{ url('/Admin/Inventario') }}">Inventario</a></li>
            </ul>
        </div>
        <div>
            Bienvenida
        </div>
    </body>
</html>