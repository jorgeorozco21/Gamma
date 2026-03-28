"use strict";

const buscador = document.getElementById('buscador');
const idLaboratorio = document.getElementById('id-laboratorio').value;
const contenedorTarjetas = document.getElementById('contenedor-materiales');

async function buscadorGeneral(){
    const response = await fetch(`/usuario/normal/materiales?texto=${buscador.value}&idLab=${idLaboratorio}`);
    const data = await response.json();

    generarTarjetas(data);
}

export function generarTarjetas(informacion){
    contenedorTarjetas.innerHTML = '';

    let tarjetas = '';

    informacion.forEach(m =>{
        let color = "";
        let colorLetra = "";
        let band = true;
        let porcentaje = Math.round((m.cantidad_disponible * 100) / m.cantidad_total);

        if (m.cantidad_disponible == 0) band = false;
        else{
            if (porcentaje <= 40){
                color = "#FFEDD5";
                colorLetra = "#C2410C";
            }else{
                color = "#DCFCE7";
                colorLetra = "#15803D";
            }
        }

        if (band){
            tarjetas += `
                <div class="flex flex-col gap-2">
                    <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md hover:border-[#7B1FA3] hover:border-2 transition-all h-full">
                        <div class="mb-4">
                            <span class="bg-[${color}] text-[${colorLetra}] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                                ${m.cantidad_disponible} Disponibles
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 h-10 text-base">${m.nombre}</h3>
                        <p class="text-xs text-gray-500 line-clamp-3 flex-grow leading-relaxed">${m.descripcion}</p>

                        <button data-id="${m.id}" data-nombre="${m.nombre}" data-tipo="${m.tipo}" data-cantidaddisponible="${m.cantidad_disponible}" class="tarjeta-material mt-6 w-full py-2 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors bg-[#facc15] hover:bg-[#eab308] text-gray-900">
                            <span class="text-lg">+</span> Añadir
                        </button>
                    </div>
                </div>
            `;
        }else{
            tarjetas += `
                <div class="flex flex-col gap-2">
                    <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col opacity-60 grayscale-[0.5] h-full">
                        <div class="mb-4">
                            <span class="bg-[#FEE9E9] text-[#CA5555] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                                0 Disponibles
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 h-10 text-base">${m.nombre}</h3>
                        <p class="text-xs text-gray-500 line-clamp-3 flex-grow leading-relaxed">${m.descripcion}</p>

                        <button disabled class="mt-6 w-full py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors bg-gray-100 text-gray-400 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12"/>
                                <circle cx="12" cy="12" r="9" stroke-width="2"/>
                            </svg>
                            No Disponible
                        </button>
                    </div>
                </div>
            `;
        }
    });

    contenedorTarjetas.innerHTML = tarjetas;
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