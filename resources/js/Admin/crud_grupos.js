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
            <div class="group flex items-center justify-between p-1 mb-2.5 bg-white hover:bg-[#F5F3FF] border-l-4 border-[#7B1FA3] rounded-r-xl border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-[#7B1FA3] transition-colors truncate">
                            ${lab}
                        </p>
                    </div>
                </div>
                <button type="button" class="eliminar-laboratorio shrink-0 p-1.5 ml-2 text-gray-400 hover:text-red-600 transition-all active:scale-95" 
                        data-clave="${lab}" title="Eliminar">
                    ✕
                </button>
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
    document.getElementById("nombre").value = '';
    document.getElementById("grado").value = '';
    document.getElementById("grupo").value = '';
    document.getElementById("truno").selectedIndex = 0;
    document.getElementById("laboratorios").selectedIndex = 0;
    document.getElementById('laboratorios-agregados').innerHTML = '';
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

    const info = await obtenerInformacionLaboratorio(informacion);

    let lista = '<ul>';

    info.forEach(lab =>{
        lista += `
            <li class="group flex items-center justify-between p-3.5 mb-2.5 bg-white hover:bg-[#F5F3FF] border-l-4 border-[#7B1FA3] rounded-r-xl border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-[#7B1FA3] transition-colors truncate">
                            ${lab.nombre}
                        </p>
                    </div>
                </div>
            </li>
        `;
    });

    lista += '</ul>';

    contenidoModalLaboratorios.innerHTML = lista;
}

cerrarModalLaboratorios.addEventListener("click",()=>{
    contendorModal.classList.add("hidden");
});

const contendorModalEdit = document.getElementById("modal-edit");
const cerrarModalEdit = document.getElementById("cerrar-modal-edit"); 

document.addEventListener("click", function(e){ 
    const editar = e.target.closest(".abrir-modal-edit");

    if(editar){ 

        contendorModalEdit.style.display = "flex"; 

        let id = editar.dataset.id;

        vaciar();
        
        informacionEditar(id);
    } 
});

cerrarModalEdit.addEventListener("click",()=>{
    contendorModalEdit.style.display = "none";
    document.getElementById("formulario-editar").action = '';
    document.getElementById("nombre-edit").value = '';
    document.getElementById("grado-edit").value = '';
    document.getElementById("grupo-edit").value = '';
    document.getElementById("turno-edit").selectedIndex = 0;
    document.getElementById("inf-laboratorios-edit").value = '';
    document.getElementById("laboratorios-edit").selectedIndex = 0;
    document.getElementById('laboratorios-agregados-edit').innerHTML = '';
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

    if (informacion.turno === 'Matutino') document.getElementById("turno-edit").selectedIndex = 0;
    else if (informacion.turno === 'Vespertino') document.getElementById("turno-edit").selectedIndex = 1

    const info = await obtenerInformacionLaboratorio(informacion.id);
    info.forEach(lab =>{
        laboratorios[lab.nombre] = lab.id_laboratorio;
    });

    crearTarjetas(document.getElementById("laboratorios-agregados-edit"), document.getElementById("inf-laboratorios-edit"), laboratorios);
}