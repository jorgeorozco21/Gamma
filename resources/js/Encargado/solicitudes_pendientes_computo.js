"use strict";

const contenedorReportes = document.getElementById('contenedor-reportes');
const contenedorSolicitudes = document.getElementById('contenedor-solicitudes');
const buscador = document.getElementById('buscador');
const filtroTipo = document.getElementById('filtro-tipo');
buscador.placeholder = "ID de Solicitud o No Computadora";
const filtro = document.getElementById('filtro');
const usuario = {
    'id': document.getElementById('id_usuario').value,
    'nombre': document.getElementById('nombre').value,
    'email': document.getElementById('email').value
};

document.addEventListener("click", function(e){
    const butonReporte = e.target.closest(".ver-reportes");

    if(butonReporte){
        const idSolicitud = butonReporte.getAttribute("data-idSolicitud");
        const idComputadora = butonReporte.getAttribute("data-id");
        
        informacionReportes(idSolicitud, idComputadora);

        return;
    }

    const aceptada = e.target.closest(".aceptada");

    if (aceptada){
        if (confirm('Deseas aprobar este reporte ??')){
            const id = aceptada.dataset.id;
            aprobarSolicitud(id);
            buscador.value = '';
            filtro.selectedIndex = 0;
            buscadorGeneral();
        }
    }

    const rechazada = e.target.closest(".rechazada");

    if (rechazada){
        if (confirm('Deseas rechazar este reporte ??')){
            const id = rechazada.dataset.id;
            rechazarSolicitud(id);
            buscador.value = '';
            filtro.selectedIndex = 0;
            buscadorGeneral();
        }
    }
});
async function informacionReportes(idSolicitud, idComputadora){
    const response = await fetch(`/usuario/encargado/reportes-computo?id=${idComputadora}&idSolicitud=${idSolicitud}`);
    const data = await response.json();

    openReportesModal(idSolicitud, data);
}

function openReportesModal(requestId, informacion){
    contenedorReportes.innerHTML = '';

    if (informacion.length === 0) {
        contenedorReportes.innerHTML = `
            <div class="mb-4 p-4 bg-[#F7F6F8] rounded-2xl relative group transition-all cursor-default">
                <p class="text-[11px] text-gray-700 font-bold leading-relaxed line-clamp-3">
                    No hay reportes.
                </p>
            </div>
        `;
    }else{
        let resportes = '';
    
        informacion.forEach(r => {
            resportes += `
                <div class="mb-4 p-4 bg-[#F7F6F8] rounded-2xl border-2 border-red-200 relative group hover:shadow-md hover:border-red-600 transition-all cursor-default">
                    <p class="text-[11px] text-gray-700 font-bold leading-relaxed line-clamp-3 uppercase">
                        ${r.tipo}
                    </p>
                    <p class="text-[11px] text-gray-500 font-bold leading-relaxed line-clamp-3">
                        ${r.descripcion}
                    </p>
                </div>
            `;
        });
    
        contenedorReportes.innerHTML = resportes;
    }


    const modal = document.getElementById('reportes-Modal');
    const idLabel = document.getElementById('id-solicitud-reportes');

    idLabel.innerText = '#' + requestId;

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeReportesModal() {
    const modal = document.getElementById('reportes-Modal');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

document.getElementById('cerrar-modal').addEventListener('click', closeReportesModal);
document.querySelector('.pared-modal').addEventListener('click', closeReportesModal);

async function aprobarSolicitud(idSolicitud){
    const datos = {
        'id_solicitud': idSolicitud,
        'estado': 'aceptada',
        'info_usuario': usuario
    };

    try{
        const respuesta = await fetch('/usuario/encargado/actualizar-solicitudes-computo',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();

        if (respuesta.ok){
            alert("Reporte generado correctamente");
        }else{
            alert(resultado.error);
        }
    }catch (error){
        console.error("Error de conexión:", error);
    }
}

async function rechazarSolicitud(idSolicitud){
    try{
        const respuesta = await fetch(`/usuario/encargado/rechazar-solicitud-computo/${idSolicitud}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
        });

        const resultado = await respuesta.json();

        if (respuesta.ok){
            alert("Reporte rechazado.");
        }else{
            alert("Error: " + resultado.message);
        }
    }catch (error){
        console.error("Error en la conexión:", error);
    }
}

function generarRegistros(informacion){
    contenedorSolicitudes.innerHTML = '';

    let solicitudes = '';

    informacion.forEach(r =>{
        const fechaObj = new Date(r.fecha);
        const fechaFormateada = fechaObj.toLocaleDateString('es-ES', {
            day: '2-digit', month: '2-digit', year: 'numeric'
        });

        solicitudes += `
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <!-- ID Solicitud -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${r.id}
                </td>
                <!-- Numero de computadora -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${r.numero_computadora}
                </td>

                <!-- Laboratorio -->
                <td class="px-6 py-4 text-center text-black text-sm font-medium tracking-tight">
                    ${r.nombre}
                </td>

                <td class="px-6 py-4 text-black text-sm font-medium text-center uppercase">
                    ${r.tipo}
                </td>

                <!-- Descripcion -->
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button type="button" 
                            onclick="openMaterialModal('${r.id}','${r.descripcion}')" 
                            class="flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                            title="Ver Descripcion">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>
                
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button data-id="${r.id_computadora}" data-idSolicitud="${r.id}"
                            class="ver-reportes flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                            title="Ver Descripcion">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>

                <!-- Fecha -->
                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                    ${fechaFormateada}
                </td>

                <!-- Acciones -->
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-3">
                        <!-- Aprobar Solicitud -->
                        <button data-id="${r.id}" class="aceptada flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Aprobar
                        </button>

                        <!-- Rechazar Solicitud -->
                        <button data-id="${r.id}" class="rechazada flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Rechazar
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    contenedorSolicitudes.innerHTML = solicitudes;
}

async function buscadorGeneral(){
    const response = await fetch(`/api/usuario/encargado/solicitudes-pendientes-computo?texto=${buscador.value}&filtro=${filtro.value}&filtrotipo=${filtroTipo.value}`);
    const data = await response.json();

    generarRegistros(data);
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

filtroTipo.addEventListener('change', ()=>{
    buscadorGeneral();
});