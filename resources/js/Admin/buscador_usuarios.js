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
        document.getElementById("label-filtrar-tipo").style.display = "none";
        filtroTipo.style.display = "none";
        filtroGrupo.style.display = "none";
        filtroGrupo.value = "Sin Filtro";
        filtroTipo.value = "Sin Filtro";
        buscadorGeneral();

        if (buscador.value == ""){
            document.getElementById("label-filtrar-tipo").style.display = "flex";
            filtroTipo.style.display = "flex";
            filtroGrupo.style.display = "flex";
        }
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
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-[#7B1FA3] font-bold text-xs">
                            ${usuario.Nombre_Usuario ? usuario.Nombre_Usuario.substring(0, 2).toUpperCase() : '??'}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">${usuario.Nombre_Usuario}</p>
                            <p class="text-xs text-gray-400">${usuario.Email}</p>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                    ${usuario.Nombre}
                </td>

                <td class="flex flex-col px-6 py-4">
                    ${ (usuario.Normal == "1")?'<span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg">Normal</span>':'' }
                    ${ (usuario.Encargado == "1")?'<span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg">Encargado de Area</span>':'' }
                    ${ (usuario.Mantenimiento == "1")?'<span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg">Encargado de Mantenimiento</span>':'' }
                </td>

                <td class="px-6 py-4 text-sm text-gray-500">
                    ${(usuario.nombreGrupo) ? `${usuario.Grado}°${usuario.Grupo} - ${usuario.nombreGrupo}` : 'Sin Grupo'}
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <button title="Cambiar Contraseña" class="btn-cambiar-contrasena p-2 text-gray-400 hover:text-amber-500 transition-colors" 
                                data-id="${usuario.id}" data-url="/Admin/Usuarios/${usuario.id}/cambiar-contrasena">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </button>

                        <button title="Editar" class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${usuario.id}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>

                        <form action="/Admin/Usuarios/${usuario.id}" method="post" class="inline">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" title="Eliminar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Deseas borrar el usuario?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
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