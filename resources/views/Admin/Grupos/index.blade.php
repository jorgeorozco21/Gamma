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
            <button id="abrir-modal">Crear</button>
        </div>

        <!-- Modal para crear  -->
        <div id="modal" style="display: none;">
            <button id="cerrar-modal"> X </button>
            <div id="contenido-modal">
                <form action="{{ route('admin.grupos.store') }}" method="post">
                    @csrf
                    @include('Admin.Grupos.form')
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
                    <label for="nombre-edit">Nombre</label>
                    <input type="text" id="nombre-edit" name="nombre">
                    <label for="grado-edit">Grado</label>
                    <input type="text" id="grado-edit" name="grado">
                    <label for="grupo-edit">Grupo</label>
                    <input type="text" id="grupo-edit" name="grupo">
                    <select id="laboratorios-edit">
                        @foreach ($laboratorios as $laboratorio)
                            <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                        @endforeach 
                    </select>
                    <button type="button" id="agregar-laboratorio-edit">Agregar</button>
                    <div id="laboratorios-agregados-edit">
                    </div>
                    <input type="hidden" id="inf-laboratorios-edit" name="laboratorios">
                    <input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">
                    <input type="submit" value="Editar Grupo">
                </form>
            </div>
        </div>

        
        <div>
            <!-- El id del input del buscador siempre tiene que ser buscador -->
            <label for="buscador">Buscar: </label>
            <input type="text" id="buscador">
        </div>
        
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Laboratorios</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <!-- En todos los archivos que se va a mostar la informacion la parte del tbody tiene que tener ese id para que funcione el filtro de informacion -->
                <tbody id="informacion-filtrada">
                    @foreach ($grupos as $grupo)
                        <tr>
                            <td>{{ $grupo->nombre }}</td>
                            <td>{{ $grupo->grado }}</td>
                            <td>{{ $grupo->grupo }}</td>
                            <td>
                                <button data-laboratorios="{{ $grupo->laboratorios }}" class="ver">Ver</button>
                            </td>
                            <td>
                                <button class="abrir-modal-edit" data-id="{{ $grupo->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ url('/admin/grupos/'.$grupo->id) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el grupo ??')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="modal-laboratorios" style="display: none;">
            <button id="cerrar-modal-laboratorios"> X </button>
            <div id="contenido-modal-laboratorios">
            </div>
        </div>

        @vite('resources/js/Admin/modal.js')
        @vite('resources/js/Admin/crud_grupos.js')
        @vite('resources/js/Admin/alertas.js')
        @vite('resources/js/Admin/buscador_grupos.js')
    </body>
</html>