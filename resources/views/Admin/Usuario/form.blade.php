<label for="nombre-usuario">Nombre de Usuario</label>
<input type="text" id="nombre-usuario" name="Nombre_Usuario">
<label for="email">Email</label>
<input type="email" id="email" name="Email">
<label for="nombre-completo">Nombre Completo</label>
<input type="text" id="nombre-completo" name="Nombre">
<label for="tipo-usuario">Tipo Usuario</label>
<select id="tipo-usuario" name="Tipo_Usuario">
    <option value="Normal">Normal</option>
    <option value="Encargado de Area">Encargado de Area</option>
    <option value="Encargado de Mantenimiento">Encargado de Mantenimiento</option>
</select>
<label for="grupo" id="label-grupo">Grupo</label>
<select id="grupo" name="ID_Grupo">
    @foreach ($grupos as $grupo)
        <option value="{{ $grupo->id }}">{{ $grupo->Grado }} {{ $grupo->Grupo }} {{ $grupo->Nombre }}</option>
    @endforeach
</select>
<input type="hidden" name="ID_Institucion" value="1">
<input type="submit" value="Crear Usuario">