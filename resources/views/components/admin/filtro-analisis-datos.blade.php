<div class="flex flex-col items-center gap-4">
    <div>
        <select id="opciones-analisis">
            <option value="Sin Filtro"></option>
            <optgroup label="Infraestructura y Estado">
                <option value="/admin/analisis-datos/distribucion-tipos-usuario">Distribucion de Tipos de Usuarios</option>
                <option value="/admin/analisis-datos/distribucion-tipos-laboratorios">Distribucion de Tipos de Laboratorios</option>
                <option value="/admin/analisis-datos/distribucion-equipos-computo">Laboratorios con mas / menos Equipos de Computo</option>
            </optgroup>
            <optgroup label="Inventario y Materiales">
                <option value="/admin/analisis-datos/distribucion-materiales">Materiales en un Laboratorio</option>
                <option value="/admin/analisis-datos/materiales-mas-reportes">Materiales con mas reportes de fallas</option>
                <option value="/admin/analisis-datos/estados-computadoras">Estados de las Computadoras</option>
                <option value="/admin/analisis-datos/computadoras-inactivas">Laboratorios con mayor cantidad de computadoras inactivas</option>
                <option value="/admin/analisis-datos/errores-computo">Errores mas Comunes en Equipos de Computo</option>
            </optgroup>
            <optgroup label="Solicitudes y Reportes">
                <option value="/admin/analisis-datos/laboratorios-mas-menos-solicitudes">Laboratorios de Prestamos con mas / menos Solicitudes</option>
                <option value="/admin/analisis-datos/laboratorios-mas-menos-reportes">Laboratorios de Computo con mas / menos Reportes</option>
                <option value="/admin/analisis-datos/materiales-mas-menos-solicitados">Materiales mas / menos solicitados en toda la institucion</option>
                <option value="/admin/analisis-datos/materiales-mas-menos-solicitados-laboratorio">Materiales mas / menos solicitados en un Laboratorio</option>
                <option value="/admin/analisis-datos/computadoras-mas-fallas">Cantidad de Fallas en los Equipos de Computo</option>
            </optgroup>
        </select>
        <select id="opciones-extra" class="hidden">
        </select>
        <button id="seleccionar">Analisis</button>
    </div>
    <div id="grafica-barras" style="min-height: 400px; width: 700px;">
    </div>
    <div id="grafica-barras-extra" style="min-height: 400px; width: 700px;">
    </div>
    <div id="grafica-pastel" style="min-height: 400px; width: 700px;">
    </div>
    <div id="grafica-dona" style="min-height: 400px; width: 700px;">
    </div>
</div>

