"use strict";

const agregarLaboratorio = document.getElementById("agregar-laboratorio");
const inputLaboratorios = document.getElementById("laboratorios");
const cerrarModal = document.getElementById("cerrar-modal");
let laboratorios = {};

agregarLaboratorio.addEventListener("click",()=>{
    const llave = inputLaboratorios.options[inputLaboratorios.selectedIndex].text;
    const valor = inputLaboratorios.value;

    laboratorios[llave] = valor;

    crearTarjetas(document.getElementById("laboratorios-agregados"), document.getElementById("inf-laboratorios"), laboratorios);
});

function crearTarjetas(contenedor, infLaboratorios, informacion){
    contenedor.innerHTML = '';

    let cadena = '';
    let n = Object.keys(informacion).length;
    let i = 0;

    for (let lab in informacion){
        if (i < n - 1) cadena += informacion[lab].toString() + ",";
        else cadena += informacion[lab].toString();

        contenedor.innerHTML += `
            <div>
                ${lab} <button type="button" class="eliminar-laboratorio" data-clave="${lab}"> X </button>
            </div>
        `;

        i++;
    }

    infLaboratorios.value = cadena;

    const tarjetasLaboratorios = document.querySelectorAll(".eliminar-laboratorio");
    tarjetasLaboratorios.forEach(tarjeta =>{
        tarjeta.addEventListener("click",()=>{
            const eliminar = tarjeta.dataset.clave;
            delete laboratorios[eliminar];
            crearTarjetas(contenedor, infLaboratorios, laboratorios);
        });
    });
}

function vaciar(){
    laboratorios = {};
}

cerrarModal.addEventListener("click",()=>{
    vaciar();
})

const contendorModal = document.getElementById("modal-laboratorios");
const cerrarModalLaboratorios = document.getElementById("cerrar-modal-laboratorios");
const contenidoModalLaboratorios = document.getElementById("contenido-modal-laboratorios");

document.addEventListener("click", function(e){ 
    const boton = e.target.closest(".ver");

    if(boton){ 
        contendorModal.classList.remove("hidden");

        let informacion = boton.dataset.laboratorios;
        
        mostrarLaboratorios(informacion);
    }
});

async function obtenerInformacionLaboratorio(id){
    const response = await fetch(`/api/grupos/laboratorio?id=${id}`);
    const data = await response.json();

    return data;
}

async function mostrarLaboratorios(informacion){
    contenidoModalLaboratorios.innerHTML = '';

    if(!informacion){
        contenidoModalLaboratorios.innerHTML = 'Sin laboratorios';
        return;
    }

    const idLaboratorios = informacion.split(',');
    let lista = '<ul>';

    for (const id of idLaboratorios){
        const inf = await obtenerInformacionLaboratorio(id.trim());

        lista += `<li class="flex items-center justify-between p-3 bg-gray-50/50 border-l-4 border-[#7B1FA3] rounded-r-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-700 font-medium">
                        ${inf.nombre}
                    </span>
                </div>
            </li>
        `;
    }

    lista += '</ul>';

    contenidoModalLaboratorios.innerHTML = lista;
}

cerrarModalLaboratorios.addEventListener("click",()=>{
    contendorModal.classList.add("hidden");
});

const contendorModalEdit = document.getElementById("modal-edit");
const cerrarModalEdit = document.getElementById("cerrar-modal-edit"); 

document.addEventListener("click", function(e){ 
    if(e.target.closest(".abrir-modal-edit")){ 

        contendorModalEdit.style.display = "flex"; 

        let id = e.target.dataset.id;

        vaciar();
        
        informacionEditar(id);
    } 
});

cerrarModalEdit.addEventListener("click",()=>{
    contendorModalEdit.style.display = "none";
    vaciar();
});

const agregarLaboratorioEdit = document.getElementById("agregar-laboratorio-edit");
const inputLaboratoriosEdit = document.getElementById("laboratorios-edit");

agregarLaboratorioEdit.addEventListener("click", ()=>{
    const llave = inputLaboratoriosEdit.options[inputLaboratoriosEdit.selectedIndex].text;
    const valor = inputLaboratoriosEdit.value;

    laboratorios[llave] = valor;

    crearTarjetas(document.getElementById("laboratorios-agregados-edit"), document.getElementById("inf-laboratorios-edit"), laboratorios);
});

async function informacionEditar(id){
    const response = await fetch(`/api/grupos/editar?id=${id}`);
    const data = await response.json(response);

    asignarInformacionFormularioEditar(data);
}

async function asignarInformacionFormularioEditar(informacion){
    document.getElementById("formulario-editar").action = `/admin/grupos/${informacion.id}`;
    document.getElementById("nombre-edit").value = informacion.nombre;
    document.getElementById("grado-edit").value = informacion.grado;
    document.getElementById("grupo-edit").value = informacion.grupo;
    document.getElementById("inf-laboratorios-edit").value = informacion.laboratorios;

    const idLaboratorios = informacion.laboratorios.split(",");

    for (const id of idLaboratorios){
        const clave = await obtenerInformacionLaboratorio(id);

        laboratorios[clave.nombre] = id;
    }

    crearTarjetas(document.getElementById("laboratorios-agregados-edit"), document.getElementById("inf-laboratorios-edit"), laboratorios);
}