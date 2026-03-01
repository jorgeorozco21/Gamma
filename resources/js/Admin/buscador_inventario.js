"use strict";

const contenedorInformacion = document.getElementById("informacion-filtrada");
const buscador = document.getElementById("buscador");
const filtroLab = document.getElementById("filtro-lab");

async function buscadorGeneral(){
    const response = await fetch(`/api/inventario?texto=${buscador.value}&filtro=${filtroLab.value}`);
    const data = await response.json();

    crearRegistro(data);
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

function crearRegistro(informacion){
    // obtener token
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = meta ? meta.content : '';

    contenedorInformacion.innerHTML = "";

    let filas = "";

    informacion.forEach(inventario => {
        filas += `
            <tr>
                <td>${inventario.nombreMaterial}</td>
                <td>${inventario.nombreLaboratorio}</td>
                <td>${inventario.Cantidad_Total}</td>
                <td>
                    <button class="abrir-modal-edit" data-id="${inventario.id}">Editar</button>
                </td>
                <td>
                    <form action="/Admin/Inventario/${inventario.id}" method="post">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el inventario ??')">
                    </form>
                </td>
            </tr>
        `;
    });

    contenedorInformacion.innerHTML = filas;
}

filtroLab.addEventListener("change", ()=>{
    buscadorGeneral();
})