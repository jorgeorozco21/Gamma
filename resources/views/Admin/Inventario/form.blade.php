<label for="material">Material</label>
<select id="material" name="ID_Material">
    @foreach ($materiales as $material)
        <option value="{{ $material->id }}">{{ $material->Nombre }}</option>
    @endforeach
</select>
<input type="hidden" name="Cantidad_Disponible">
<label for="cantidad">Cantidad</label>
<input type="number" id="cantidad" name="Cantidad_Total" min="1" value="1">
<label for="laboratorio">Laboratorio</label>
<select id="laboratorio" name="ID_Laboratorio">
    @foreach ($laboratorios as $laboratorio)
        <option value="{{ $laboratorio->id }}">{{ $laboratorio->Nombre }}</option>
    @endforeach
</select>
<input type="submit" value="Agregar Inventario">