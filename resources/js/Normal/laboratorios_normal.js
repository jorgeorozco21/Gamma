"use strict";

const info = document.getElementById('info-buscador').value;
const buscador = document.getElementById('buscador');
const laboratorios = JSON.parse(info);
const contenedorTarjetas = document.getElementById('contenedor-tarjetas');

function buscadorGeneral(){
    let infoFiltrada = '';
    if (buscador.value != ''){
        infoFiltrada = laboratorios.filter(lab => {
            const nombreLab = lab.nombre.toLowerCase();
            const textoBuscado = buscador.value.toLowerCase();

            return nombreLab.includes(textoBuscado);
        });
    }else{
        infoFiltrada =  laboratorios;
    }

    generarTarjetas(infoFiltrada);
}

function generarTarjetas(informacion){
    contenedorTarjetas.innerHTML = "";

    let tarjetas = "";
    informacion.forEach(laboratorio =>{
        tarjetas += `
            <a href="${ (laboratorio.tipo == 'prestamos')?`/usuario/normal/laboratorios/${laboratorio.id}-laboratorio-normal`:`/usuario/normal/laboratorios/${laboratorio.id}-laboratorio-computo` }" class="flex flex-col gap-2 cursor-pointer">
                <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md hover:border-[#7B1FA3] hover:border-2 transition-all h-full">
                    <div class="mb-4">
                        <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                            ${laboratorio.tipo}
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-900 text-base leading-tight">
                        ${laboratorio.nombre}
                    </h3>
                </div>
            </a>
        `;
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