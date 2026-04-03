"use strict";

import { generarTarjetas } from "./buscador_computadora.js";
import { computadoras } from "./buscador_computadora.js";

const contenedorReportes = document.getElementById('contenedor-reportes');
const idLaboratorio = document.getElementById('id-laboratorio').value;
const crear = document.getElementById('enviar');
const buscador = document.getElementById('buscador');
let idComputadora;

document.addEventListener("click", function(e){
    const tarjeta =  e.target.closest('.tarjeta');

    if (tarjeta){
        const id = tarjeta.dataset.numerocomputadora;
        idComputadora = id;

        obtenerReportes(id);
    }
});

function generarTarjetasReportes(informacion){
    contenedorReportes.innerHTML = '';

    document.getElementById("encabezado").innerHTML = `Solicitudes de Reportes - PC-${idComputadora}`;

    let tarjetas = ``;

    informacion.forEach(r =>{
        tarjetas += `
            <div class="p-4 bg-[#F7F6F8] rounded-2xl border-2 border-red-200 relative group hover:shadow-md hover:border-red-600 transition-all cursor-default">
                <p class="text-[11px] text-gray-700 font-bold leading-relaxed line-clamp-3">
                    ${r.descripcion}
                </p>
            </div>
        `;
    });

    contenedorReportes.innerHTML = tarjetas;
}

async function obtenerReportes(id){
    const response = await fetch(`/usuario/normal/laboratorios/obtener-reportes-computo?id=${id}&idLaboratorio=${idLaboratorio}`);
    const data = await response.json();

    generarTarjetasReportes(data);
}

crear.addEventListener("click", function(){
    if (document.getElementById('descripcion-reporte').value.trim() === ''){
        alert('No se puede hacer un reporte sin descripcion');
        return;
    }
    
    if (document.getElementById('descripcion-reporte').value.trim().length > 255){
        alert('La descripcion no puede exceder los 255 caracteres');
        return;
    }

    if (!idComputadora){
        alert('Debes seleccionar un computadora donde realizar el reporte');
        return;
    }

    if (confirm('Deseas realizar el reporte ??')){
        console.log(computadoras);
        crearSolicitud();
        document.getElementById('descripcion-reporte').value = '';
        document.getElementById("encabezado").innerHTML = `Solicitudes de Reportes`;
        contenedorReportes.innerHTML = '';
        computadoras[idComputadora-1].cantidad_reportes += 1;
        idComputadora = null;
        console.log(computadoras);
        buscador.value = '';
        generarTarjetas(computadoras);
    }
});

async function crearSolicitud(){
    const datos = {
        'id_laboratorio': idLaboratorio,
        'numero_computadora': idComputadora,
        'descripcion': document.getElementById('descripcion-reporte').value.trim()
    };

    try{
        const respuesta = await fetch('/usuario/normal/laboratorios/solicitud-computo',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();

        if (respuesta.ok){
            alert("¡Reporte realizado con éxito!");
            
        }else{
            alert(resultado.error);
        }
    }catch (error){
        console.error("Error de conexión:", error);
    }
}