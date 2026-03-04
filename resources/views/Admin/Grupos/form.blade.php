<label for="nombre">Nombre</label>
<input type="text" id="nombre" name="Nombre">
<label for="grado">Grado</label>
<input type="text" id="grado" name="Grado">
<label for="grupo">Grupo</label>
<input type="text" id="grupo" name="Grupo">
<select id="laboratorios">
    @foreach ($laboratorios as $laboratorio)
        <option value="{{ $laboratorio->id }}">{{ $laboratorio->Nombre }}</option>
    @endforeach 
</select>
<button type="button" id="agregar-laboratorio">Agregar</button>
<div id="laboratorios-agregados">
</div>
<input type="hidden" id="inf-laboratorios" name="Laboratorios">
<input type="hidden" name="ID_Institucion" value="{{ session("id_institucion") }}">
<input type="submit" value="Crear Grupo">