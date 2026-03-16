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
                <form action="{{ route('admin.inventario.store') }}" method="post">
                    @csrf
                    @include('Admin.Inventario.form')
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
                    <label for="material-edit">Material</label>
                    <select id="material-edit" name="id_material">
                    </select>
                    <input type="hidden" id="cantidad-disponible-edit" name="cantidad_disponible">
                    <input type="hidden" id="cantidad-total-anterior-edit" name="cantidad_total_anterior">
                    <label for="cantidad-edit">Cantidad</label>
                    <input type="number" id="cantidad-edit" name="cantidad_total" min="1">
                    <label for="laboratorio-edit">Laboratorio</label>
                    <select id="laboratorio-edit" name="id_laboratorio">
                    </select>
                    <input type="submit" value="Editar Informacion">
                </form>
            </div>
        </div>

        <div>
            <!-- El id del input del buscador siempre tiene que ser buscador -->
            <label for="buscador">Buscar: </label>
            <input type="text" id="buscador">
            <label for="filtro-lab">Filtro por Laboratorio</label>
            <select id="filtro-lab">
                <option value="Sin Filtro"></option>
                @foreach ($laboratorios as $laboratorio)
                    <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Laboratorio</th>
                        <th>Cantidad</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <!-- En todos los archivos que se va a mostar la informacion la parte del tbody tiene que tener ese id para que funcione el filtro de informacion -->
                <tbody id="informacion-filtrada">
                    @foreach ($inventarios as $inventario)
                        <tr>
                            <td>{{ $inventario->nombreMaterial }}</td>
                            <td>{{ $inventario->nombreLaboratorio }}</td>
                            <td>{{ $inventario->cantidad_total }}</td>
                            <td>
                                <button class="abrir-modal-edit" data-id="{{ $inventario->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ url('/admin/inventario/'.$inventario->id) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el inventario ??')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @vite('resources/js/Admin/modal.js')
        @vite('resources/js/Admin/alertas.js')
        @vite('resources/js/Admin/crud_inventario.js')
        @vite('resources/js/Admin/buscador_inventario.js')
    </body>
</html>