"use strict";

const buscador = document.getElementById('buscador');
const filtro = document.getElementById('filtro');
const contenedorReportes =  document.getElementById('contenedor-reportes');
const usuario = {
    'id': document.getElementById('id_usuario').value,
    'nombre': document.getElementById('nombre').value,
    'email': document.getElementById('email').value
};

async function buscadorGeneral(){
    const response = await fetch(`/api/usuario/encargado/reportes-materiales?texto=${buscador.value}&filtro=${filtro.value}`);
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

function generarRegistros(informacion){
    contenedorReportes.innerHTML = '';

    let registros = '';

    informacion.forEach(r =>{
        const fechaObj = new Date(r.fecha);
        const fechaFormateada = fechaObj.toLocaleDateString('es-ES', {
            day: '2-digit', month: '2-digit', year: 'numeric'
        });

        registros += `
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <!-- ID del Reporte -->
                <td class="px-6 py-4">
                    ${r.id}
                </td>

                <!-- Nombre del material -->
                <td class="px-6 py-4 text-sm font-mono text-gray-500">
                    ${r.nombre}
                </td>

                <!-- Cantidad -->
                <td class="px-6 py-4">
                    ${r.cantidad}
                </td>

                <td class="px-6 py-4">
                    <span class="py-1 rounded-lg text-black text-xs font-bold tracking-tight">
                        ${ r.nombreLaboratorio }
                    </span>
                </td>

                <!-- Descripcion -->
                <td class="px-6 py-4 justify-center">
                    <button type="button" 
                        onclick="openMaterialModal('${r.id}', '${r.descripcion}')" 
                        class="flex items-center gap-2 text-[#7B1FA3]"
                        title="Ver motivo">
                        <div class="p-1.5 bg-purple-100 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                    </button>
                </td>

                <!-- Fecha -->
                <td class="px-6 py-4 text-sm text-gray-500">
                    ${fechaFormateada}
                </td>
        `;

        if (r.estado == null || r.estado == 'en proceso'){
            registros += `
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                            ${ (r.estado == null)?'Espera':r.estado }
                        </span>
                    </td>
                    <td>
                    </td>
                </tr>
            `;
        }

        if (r.estado == 'reparado'){
            registros += `
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                            ${r.estado}
                        </span>

                        <button data-id='{{ $reporte->id }}' data-estado='completado'
                            class="completar p-2 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-green-100 active:scale-[0.98]"
                            title="Guardar cambio">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8H7v8"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v4h8"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `;
        }
    });

    contenedorReportes.innerHTML = registros;
}

document.addEventListener('click', (e)=>{
    const completar = e.target.closest('.completar');

    if (completar){
        if (confirm('El reporte ha sido completado ??')){
            const id = completar.dataset.id;
            const estado = completar.dataset.estado;
            const idInventario = completar.dataset.inventario;
            const cantidad = completar.dataset.cantidad;

            cambiarEstado(id, estado, idInventario, cantidad);
            buscador.value = '';
            filtro.selectedIndex = 0;
            buscadorGeneral();
        }
    }
});

async function cambiarEstado(id, estado, idInventario, cantidad){
    const datos = {
        'id_reporte': id,
        'estado': estado,
        'info_usuario': usuario,
        'id_inventario': idInventario,
        'cantidad': cantidad
    };

    try{
        const respuesta = await fetch('/usuario/encargado/actualizar-reportes-materiales',{
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
            console.log(resultado);
            alert("Reporte actualizado correctamente");
        }else{
            alert(resultado.error);
        }
    }catch (error){
        console.error("Error de conexión:", error);
    }
}

setInterval(() => {
    buscadorGeneral();
}, 5000);