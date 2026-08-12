"use strict";

const buscador = document.getElementById('buscador');
const idLaboratorio = document.getElementById('id-laboratorio').value;
const contenedor = document.getElementById('contenedor-tarjetas');

export async function buscadorGeneral(){
    const response = await fetch(`/api/usuario/normal/laboratorios/buscador-computadora?texto=${buscador.value}&id=${idLaboratorio}`);
    const data = await response.json();

    generarTarjetas(data);
}

function generarTarjetas(informacion){
    contenedor.innerHTML = '';

    let tarjetas = '';

    informacion.forEach(s =>{
        tarjetas += `
            <div data-id="${s.id}" data-numerocomputadora="${s.numero_computadora}" class="tarjeta bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md transition-all duration-300 h-full cursor-pointer">
                <!-- Cantidad de Reportes -->
                <div class="mb-4">
                    <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                        ${s.cantidad_reportes} Reportes
                    </span>
                </div>

                <!-- Nombre de Computadora -->
                <h3 class="font-bold text-gray-900 text-base leading-tight">
                    ${s.numero_computadora}
                </h3>
            </div>
        `;
    });

    contenedor.innerHTML = tarjetas;
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

setInterval(() => {
    buscadorGeneral();
}, 5000);