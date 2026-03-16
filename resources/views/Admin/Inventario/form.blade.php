<label for="material">Material</label>
<select id="material" name="id_material">
    @foreach ($materiales as $material)
        <option value="{{ $material->id }}">{{ $material->nombre }}</option>
    @endforeach
</select>
<input type="hidden" name="cantidad_disponible">
<label for="cantidad">Cantidad</label>
<input type="number" id="cantidad" name="cantidad_total" min="1" value="1">
<label for="laboratorio">Laboratorio</label>
<select id="laboratorio" name="id_laboratorio">
    @foreach ($laboratorios as $laboratorio)
        <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
    @endforeach
</select>
<input type="submit" value="Agregar Inventario">