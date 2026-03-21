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
                <form action="{{ route('admin.laboratorios.store') }}" method="post">
                    @csrf
                    @include('Admin.Laboratorios.form')
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
                    <label for="tipo-edit">Tipo de Laboratorio</label>
                    <select id="tipo-edit" name="tipo">
                    </select>
                    <label for="cantidad-edit" id="label-cantidad-edit">Cantidad de Computadoras</label>
                    <input type="number" min="1" id="cantidad-edit" name="cantidad_computadoras">
                    <input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">
                    <input type="submit" value="Editar Laboratorio">
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
                <option value="prestamos">Laboratorio de Prestamos</option>
                <option value="computo">Laboratorio de Computo</option>`
            </select>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo de Laboratorio</th>
                        <th>Cantidad de Computadoras</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <!-- En todos los archivos que se va a mostar la informacion la parte del tbody tiene que tener ese id para que funcione el filtro de informacion -->
                <tbody id="informacion-filtrada">
                    @foreach ($laboratorios as $laboratorio)
                        <tr>
                            <td>{{ $laboratorio->nombre }}</td>
                            <td>{{ $laboratorio->tipo }}</td>
                            <td>{{ $laboratorio->cantidad_computadoras }}</td>
                            <td>
                                <button class="abrir-modal-edit" data-id="{{ $laboratorio->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ url('/admin/laboratorios/'.$laboratorio->id) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el laboratorio ??')">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ url('/archivo-laboratorios') }}">Archivo para carga masiva</a>

        <div>
            <form  action="{{ url('/carga-laboratorio') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="archivo">
                <button type="submit">
                    Cargar
                </button>
            </form>
        </div>

        @vite('resources/js/Admin/modal.js')
        @vite('resources/js/Admin/crud_laboratorios.js')
        @vite('resources/js/Admin/buscador_laboratorios.js')
        @vite('resources/js/Admin/alertas.js')
    </body>
</html>