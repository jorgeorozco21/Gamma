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
                <form action="{{ route('admin.materiales.store') }}" method="post">
                    @csrf
                    @include('Admin.Materiales.form')
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
                    <input type="text" id="nombre-edit" name="Nombre">
                    <label for="descripcion-edit">Descripcion</label>
                    <textarea id="descripcion-edit" name="Descripcion"></textarea>
                    <label for="tipo-edit">Tipo de Prestamos</label>
                    <select id="tipo-edit" name="Tipo">
                        <option value="Prestamos por Unidad">Prestamos por Unidad</option>
                        <option value="Prestamos por Cantidad">Prestamos por Cantidad</option>
                    </select>
                    <input type="hidden" name="ID_Institucion" value="1">
                    <input type="submit" value="Editar Material">
                </form>
            </div>
        </div>

        <div>
            <!-- El id del input del buscador siempre tiene que ser buscador -->
            <label for="buscador">Buscar: </label>
            <input type="text" id="buscador">
            <label for="filtro-tipo">Filtro por Tipo</label>
            <select id="filtro-tipo">
                <option value="Sin Filtro"></option>
                <option value="Prestamos por Unidad">Prestamos por Unidad</option>
                <option value="Prestamos por Cantidad">Prestamos por Cantidad</option>
            </select>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Tipo de Prestamo</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <!-- En todos los archivos que se va a mostar la informacion la parte del tbody tiene que tener ese id para que funcione el filtro de informacion -->
                <tbody id="informacion-filtrada">
                    @foreach ($materiales as $material)
                        <tr>
                            <td>{{ $material->Nombre }}</td>
                            <td>{{ $material->Descripcion }}</td>
                            <td>{{ $material->Tipo }}</td>
                            <td>
                                <button class="abrir-modal-edit" data-id="{{ $material->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ url('/Admin/Materiales/'.$material->id) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el material ??')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @vite('resources/js/Admin/modal.js')
        @vite('resources/js/Admin/alertas.js')
        @vite('resources/js/Admin/crud_materiales.js')
        @vite('resources/js/Admin/buscador_materiales.js')
    </body>
</html>