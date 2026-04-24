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
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${inventario.nombreMaterial}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${inventario.nombreLaboratorio}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${inventario.cantidad_disponible}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${inventario.cantidad_total}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <button class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${inventario.id}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <form action="/admin/inventario/${inventario.id}" method="post" class="inline">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" value="Borrar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Deseas borra el inventario ??')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        `;
    });

    contenedorInformacion.innerHTML = filas;
}

filtroLab.addEventListener("change", ()=>{
    buscadorGeneral();
})