"use strict";

const contenedorInformacion = document.getElementById("informacion-filtrada");
const buscador = document.getElementById("buscador");
const filtroTipo = document.getElementById("filtrar-tipo");

async function buscadorGeneral(){
    const response = await fetch(`/api/laboratorios?texto=${buscador.value}&tipo=${filtroTipo.value}`);
    const data = await response.json();
    
    contenedorInformacion.innerHTML = generarRegistro(data);
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

function generarRegistro(data){
    // obtener token
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = meta ? meta.content : '';


    let fila = '';

    //console.log(data);

    data.forEach(laboratorio =>{
        fila += `
            <tr>
                <td>${laboratorio.nombre}</td>
                <td>${laboratorio.tipo}</td>
                <td>${laboratorio.cantidad_computadoras ?? ' '}</td>
                <td>
                    <button class="abrir-modal-edit" data-id="${laboratorio.id}">Editar</button>
                </td>
                <td>
                    <form action="/admin/laboratorios/${laboratorio.id}" method="post">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el laboratorio ??')">
                    </form>
                </td>
            </tr>
        `;
    });

    return fila;
}

filtroTipo.addEventListener("change", ()=>{
    buscadorGeneral();
});