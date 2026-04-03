"use strict";

export const computadoras = [];
const reportes = JSON.parse(document.getElementById('reportes').value);
const cantidadComputadoras = document.getElementById('cantidad-computadoras').value;
const buscador = document.getElementById('buscador');
const contenedor = document.getElementById('contenedor-tarjetas');

generarInformacion(cantidadComputadoras, reportes);

function generarInformacion(cantidad, solicitudes){
    for (let i=1;i<=cantidad;i++){
        const c = solicitudes[i] || 0;

        computadoras.push({
            'nombre': `pc-${i}`,
            'id': i,
            'cantidad_reportes': c
        });
    }
}

function buscadorGeneral(){
    const texto = buscador.value.toLowerCase();
    const data = computadoras.filter(computadora => computadora.nombre.includes(texto));

    generarTarjetas(data);
}

export function generarTarjetas(informacion){
    contenedor.innerHTML = '';

    let tarjetas = '';

    informacion.forEach(s =>{
        tarjetas += `
            <div data-numerocomputadora="${s.id}" class="tarjeta bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md hover:border-[#7B1FA3] hover:border-2 transition-all h-full cursor-pointer">
                <!-- Cantidad de Reportes -->
                <div class="mb-4">
                    <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                        ${s.cantidad_reportes} Reportes
                    </span>
                </div>

                <!-- Nombre de Computadora -->
                <h3 class="font-bold text-gray-900 text-base leading-tight">
                    PC-${s.id}
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