<label for="nombre">Nombre</label>
<input type="text" id="nombre" name="nombre">
<label for="tipo">Tipo de laboratorio</label>
<select id="tipo" name="tipo">
    <option value="prestamos">Laboratorio de Prestamos</option>
    <option value="computo">Laboratorio de Computo</option>
</select>
<label for="cantidad" id="label-cantidad" style="display: none;">Cantidad de Computadoras</label>
<input type="number" min="1" value="1" id="cantidad" name="cantidad_computadoras" style="display: none;">
<input type="hidden" name="id_institucion" value="{{ session("id_institucion") }}">
<input type="submit" value="Crear Laboratorio">