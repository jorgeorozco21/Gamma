<label for="nombre">Nombre</label>
<input type="text" id="nombre" name="Nombre">
<label for="tipo">Tipo de laboratorio</label>
<select id="tipo" name="Tipo">
    <option value="Prestamos">Laboratorio de Prestamos</option>
    <option value="Computo">Laboratorio de Computo</option>
</select>
<label for="cantidad" id="label-cantidad" style="display: none;">Cantidad de Computadoras</label>
<input type="number" min="1" value="1" id="cantidad" name="Cantidad_Computadoras" style="display: none;">
<input type="hidden" name="ID_Institucion" value="1">
<input type="submit" value="Crear Laboratorio">