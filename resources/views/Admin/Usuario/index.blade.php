<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin</title>
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

        <form action="{{ url('/Logout') }}" method="POST">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
        
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
            <button id="abrir-modal">Crear</button>
        </div>

        <!-- Modal para crear  -->
        <div id="modal" style="display: none;">
            <button id="cerrar-modal"> X </button>
            <div id="contenido-modal">
                <form action="{{ route('admin.usuarios.store') }}" method="post">
                    @csrf
                    @include('Admin.Usuario.form')
                </form>
            </div>
        </div>

        <!-- Modal para editar -->
        <div id="modal-edit" style="display: none;">
            <button id="cerrar-modal-edit"> X </button>
            <div id="contenido-modal-edit">
                <form method="post" id="formulario-editar">
                    @csrf
                    {{ method_field('PATCH') }}
                    <label for="nombre-usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre-usuario-edit" name="Nombre_Usuario">
                    <label for="email-edit">Email</label>
                    <input type="email" id="email-edit" name="Email" readonly>
                    <label for="nombre-completo-edit">Nombre Completo</label>
                    <input type="text" id="nombre-completo-edit" name="Nombre">
                    <label for="tipo-usuario">Tipo Usuario</label>
                    <select id="tipo-usuario-edit" name="Tipo_Usuario">
                    </select>
                    <label for="grupo" id="label-grupo-edit">Grupo</label>
                    <select id="grupo-edit" name="ID_Grupo">
                        @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->Grado }} {{ $grupo->Grupo }} {{ $grupo->Nombre }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="ID_Institucion" value="{{ session('id_institucion') }}">
                    <input type="submit" value="Editar Usuario">
                </form>
            </div>
        </div>

        <div>
            <!-- El id del input del buscador siempre tiene que ser buscador -->
            <label for="buscador">Buscar: </label>
            <input type="text" id="buscador">
            <label for="filtrar-tipo">Filtrar por tipo</label>
            <select id="filtrar-tipo">
                <option value="Sin Filtro"></option>
                <option value="Normal">Normal</option>
                <option value="Encargado de Area">Encargado de Area</option>
                <option value="Encargado de Mantenimiento">Encargado de Mantenimiento</option>
            </select>
            <label for="filtrar-grupo" id="filtrar-grupo-label">Filtrar por grupo</label>
            <select id="filtrar-grupo">
                <option value="Sin Filtro"></option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->Grado }} {{ $grupo->Grupo }} {{ $grupo->Nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Tipo de Usuario</th>
                        <th>Grupo</th>
                        <th>Contraseña</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <!-- En todos los archivos que se va a mostar la informacion la parte del tbody tiene que tener ese id para que funcione el filtro de informacion -->
                <tbody id="informacion-filtrada">
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->Nombre_Usuario }}</td>
                            <td>{{ $usuario->Email }}
                            <td>{{ $usuario->Nombre }}</td>
                            <td>{{ $usuario->Tipo_Usuario }}</td>
                            <td>{{ $usuario->Grado }} {{ $usuario->Grupo }} {{ $usuario->nombreGrupo }}</td>
                            <td>
                                <button class="btn-cambiar-contrasena" data-id="{{ $usuario->id }}" data-url="{{ route('admin.usuarios.cambiarContrasena', $usuario->id) }}">Cambiar Contraseña</button>
                            </td>
                            <td>
                                <button class="abrir-modal-edit" data-id="{{ $usuario->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ url('/Admin/Usuarios/'.$usuario->id) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el usuario ??')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @vite('resources/js/Admin/crud_usuarios.js')
        @vite('resources/js/Admin/buscador_usuarios.js')
        @vite('resources/js/Admin/alertas.js')
        @vite('resources/js/Admin/modal.js')
    </body>
</html>