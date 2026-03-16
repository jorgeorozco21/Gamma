<label for="nombre">Nombre</label>
<input type="text" id="nombre" name="nombre">
<label for="descripcion">Descripcion</label>
<textarea id="descripcion" name="descripcion"></textarea>
<label for="tipo">Tipo de Prestamos</label>
<select id="tipo" name="tipo">
    <option value="prestamos por unidad">Prestamos por Unidad</option>
    <option value="prestamos por cantidad">Prestamos por Cantidad</option>
</select>
<input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">
<input type="submit" value="Crear Material">