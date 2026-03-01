"use strict";

const contenedorInformacion = document.getElementById("informacion-filtrada");
const buscador = document.getElementById("buscador");
const filtroTipo = document.getElementById("filtro-tipo");

async function buscadorGeneral(){
    const response = await fetch(`/api/materiales?texto=${buscador.value}&filtro=${filtroTipo.value}`);
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

filtroTipo.addEventListener("change", ()=>{
    buscadorGeneral();
});

function generarRegistro(informacion){

    contenedorInformacion.innerHTML = '';

    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = meta ? meta.content : '';

    let filas = '';

    for (const material of informacion){
        filas += `
            <tr>
                <td>${material.Nombre}</td>
                <td>${material.Descripcion}</td>
                <td>${material.Tipo}</td>
                <td>
                    <button class="abrir-modal-edit" data-id="${material.id}">Editar</button>
                </td>
                <td>
                    <form action="/Admin/Materiales/${material.id}" method="post">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el material ??')">
                    </form>
                </td>
            </tr>
        `;
    }

    contenedorInformacion.innerHTML = filas;

}
