<div class="flex flex-col md:flex-row items-end gap-4 mb-6 bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm w-full">
    
    <div class="flex flex-col flex-1 w-full">
        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">
            Escoger Analisis
        </label>
        <select id="opciones-analisis" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] appearance-none cursor-pointer">
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
    </div>

    <select id="opciones-extra" class="hidden w-full md:w-72 px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] appearance-none cursor-pointer">
    </select>

    <button id="seleccionar" class="w-full md:w-44 flex-shrink-0 bg-[#7B1FA3] text-white font-bold py-3 rounded-2xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]">
        Analisis
    </button>
</div>