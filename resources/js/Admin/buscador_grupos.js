"use strict";

const contenedorInformacion = document.getElementById("informacion-filtrada");
const buscador = document.getElementById("buscador");

async function buscadorGeneral(){
    const response = await fetch(`/api/grupos?texto=${buscador.value}`);
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

    data.forEach(grupo =>{
        fila += `
            <tr>
                <td>${grupo.nombre}</td>
                <td>${grupo.grado}</td>
                <td>${grupo.grupo}</td>
                <td>
                    <button data-laboratorios="${grupo.laboratorios}" class="ver">Ver</button>
                </td>
                <td>
                    <button class="abrir-modal-edit" data-id="${grupo.id}">Editar</button>
                </td>
                <td>
                    <form action="/admin/grupos/${grupo.id}" method="post">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Borrar" onclick="return confirm('Deseas borra el grupo ??')">
                    </form>
                </td>
            </tr>
        `;
    });

    return fila;
}