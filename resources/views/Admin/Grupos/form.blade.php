<label for="nombre">Nombre</label>
<input type="text" id="nombre" name="nombre">
<label for="grado">Grado</label>
<input type="text" id="grado" name="grado">
<label for="grupo">Grupo</label>
<input type="text" id="grupo" name="grupo">
<select id="laboratorios">
    @foreach ($laboratorios as $laboratorio)
        <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
    @endforeach 
</select>
<button type="button" id="agregar-laboratorio">Agregar</button>
<div id="laboratorios-agregados">
</div>
<input type="hidden" id="inf-laboratorios" name="laboratorios">
<input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">
<input type="submit" value="Crear Grupo">