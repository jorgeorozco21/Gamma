"use strict";

const contenedorSolicitudes = document.getElementById('contenedor-solicitudes');
const buscador = document.getElementById('buscador');
const filtro = document.getElementById('filtro');
const usuario = {
    'id': document.getElementById('id_usuario').value,
    'nombre': document.getElementById('nombre').value,
    'email': document.getElementById('email').value
};

document.addEventListener('click', function(e){
    const btnCambiar = e.target.closest('.cambiar');

    if (btnCambiar){
        const id = btnCambiar.dataset.id;
        const estado = btnCambiar.dataset.estado;

        if (confirm(`Deseas cambiar el estado de la solicitud ??`)){
            cambiarEstadoSolicitud(id, estado);
            buscador.value = '';
            filtro.selectedIndex = 0;
            buscadorGeneral();
        }
    }

});

async function cambiarEstadoSolicitud(id, estado){
    const datos = {
        'id_solicitud': id,
        'info_usuario': usuario,
        'estado': estado
    };

    try{
        const respuesta = await fetch('/usuario/encargado/actualizar-solicitudes',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();

        if (respuesta.ok){
            alert("Solicitud actualizada correctamente");
        }else{
            alert(resultado.error);
        }
    }catch (error){
        console.error("Error de conexión:", error);
    }
}

function generarRegistro(informacion){
    contenedorSolicitudes.innerHTML = '';

    let registros = '';

    informacion.forEach(s =>{

        const infoUsuario = JSON.parse(s.info_usuario);
        const infoMateriales = JSON.parse(s.info_material);
        const materialesString = JSON.stringify(infoMateriales).replace(/"/g, '&quot;');
        const fechaObj = new Date(s.fecha);
        const fechaFormateada = fechaObj.toLocaleDateString('es-ES', {
            day: '2-digit', month: '2-digit', year: 'numeric'
        });

        registros += `
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4">
                    <!-- Nombre, Correo y Grado/Grupo -->
                    <div class="flex items-center gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate">${infoUsuario.nombre}</p>
                            <p class="text-[10px] text-gray-400 font-medium">${infoUsuario.email}</p>
                            <p class="text-[10px] text-gray-400 font-medium">${infoUsuario.grado} ${infoUsuario.grupo} ${infoUsuario.nombreGrupo}</p>
                        </div>
                    </div>
                </td>

                <!-- ID de la Solicitud -->
                <td class="px-6 py-4 text-sm font-mono text-gray-500">
                    ${s.id}
                </td>

                <!-- Laboratorio -->
                <td class="px-6 py-4">
                    <span class="py-1 rounded-lg text-black text-xs font-bold tracking-tight">
                        ${infoUsuario.nombreLaboratorio}
                    </span>
                </td>

                <!-- Lista de Materiales-->
                <td class="px-6 py-4">
                    <button type="button" onclick="openMaterialModal(${s.id},${materialesString})" 
                        class="flex items-center gap-2 text-[#7B1FA3] group/btn">
                        <div class="p-1.5 bg-purple-100 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </button>
                </td>

                <!-- Fecha -->
                <td class="px-6 py-4 text-sm text-gray-500">
                    ${fechaFormateada}
                </td>

                <td class="px-6 py-4">
                    <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                        ${s.estado}
                    </span>
                </td>

                <!-- Estado de la Solicitud -->
                <td class="px-6 py-4 text-center">
                    <!-- Select de Estados -->
                    <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                        ${ (s.estado == 'aceptada') ? 'En Prestamo' : 'Recibido' }
                    </span>

                    <!-- Boton de Guardar -->
                    <button type="submit" data-estado="${ (s.estado == 'aceptada') ? 'en prestamo' : 'recibido' }" data-id="${s.id}"
                        class="cambiar p-2 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-green-100 active:scale-[0.98]"
                        title="Guardar cambio">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </td>
            </tr>
        `;
    });

    contenedorSolicitudes.innerHTML = registros;
}

async function buscadorGeneral(){
    const response = await fetch(`/api/usuario/encargado/solicitudes-aceptadas?texto=${buscador.value}&filtro=${filtro.value}`);
    const data = await response.json();

    generarRegistro(data);
}

// donde se almacena el temporizador
let typingTimer;
// este delay es para que despues de 300 milisegundos detecte si el usuario sigue escribiendo
const delay = 300;

// funcion para dectectar si el usuario sigue escribiendo
buscador.addEventListener("input", ()=>{
    clearTimeout(typingTimer);
    typingTimer = setTimeout(()=>{
        buscadorGeneral();
    }, delay);
});

filtro.addEventListener("change", ()=>{
    buscadorGeneral();
});