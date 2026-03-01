"use strict";

const contenedorInformacion = document.getElementById("informacion-filtrada");
const buscador = document.getElementById("buscador");
const filtroTipo = document.getElementById("filtrar-tipo");
const filtroGrupo = document.getElementById("filtrar-grupo");

async function buscadorGeneral(){
    const response = await fetch(`/api/usuarios?texto=${buscador.value}&tipoUsuario=${filtroTipo.value}&grupo=${filtroGrupo.value}`);
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

    data.forEach(usuario =>{
        fila += `
            <tr>
                <td>${usuario.Nombre_Usuario}</td>
                <td>${usuario.Email}</td>
                <td>${usuario.Nombre}</td>
                <td>${usuario.Tipo_Usuario}</td>
                <td>${(usuario.nombreGrupo)?`${usuario.Grado} ${usuario.Grupo} ${usuario.nombreGrupo}`:''}</td>
                <td>
                    <button class="btn-cambiar-contrasena" data-id="${usuario.id}" data-url="/Admin/Usuarios/${usuario.id}/cambiar-contrasena">Cambiar Contraseña</button>
                </td>
                <td>
                    <button class="abrir-modal-edit" data-id="${usuario.id}">Editar</button>
                </td>
                <td>
                    <form method="post" action="/Admin/Usuarios/${usuario.id}">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Borrar"
                            onclick="return confirm('Deseas borrar el usuario?')">
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

filtroGrupo.addEventListener("change", ()=>{
    buscadorGeneral();
});