"use strict";

const contendorModalEdit = document.getElementById("modal-edit");
const cerrarModalEdit = document.getElementById("cerrar-modal-edit"); 

document.addEventListener("click", function(e){ 
    if(e.target.closest(".abrir-modal-edit")){ 

        contendorModalEdit.style.display = "flex"; 

        let id = e.target.dataset.id;
        
        informacionEditar(id);
    } 
});

async function informacionEditar(id){
    const response = await fetch(`/api/inventario/editar?id=${id}`);
    const data = await response.json();

    asignarInformacionFormularioEditar(data);
}

function asignarInformacionFormularioEditar(informacion){

    document.getElementById("formulario-editar").action = `/admin/inventario/${informacion.inventario.id}`;
    
    const materiales = document.getElementById("material-edit");

    let opciones = '';
    for (const m of informacion.materiales){
        opciones += `<option value="${m.id}" ${ (informacion.inventario.id_material == m.id)?"selected":"" }>${m.nombre}</option>`;
    }

    materiales.innerHTML = opciones;

    document.getElementById("cantidad-disponible-edit").value = informacion.inventario.cantidad_disponible;
    document.getElementById("cantidad-total-anterior-edit").value = informacion.inventario.cantidad_total;

    if (informacion.inventario.cantidad_total == informacion.inventario.cantidad_disponible){
        document.getElementById("cantidad-edit").value = informacion.inventario.cantidad_total;
    }else{
        document.getElementById("cantidad-edit").value = informacion.inventario.cantidad_total;
        document.getElementById("cantidad-edit").min = informacion.inventario.cantidad_total;
    }

    const laboratorios = document.getElementById("laboratorio-edit");

    opciones  = '';

    for (const l of informacion.laboratorios){
        opciones += `<option value="${l.id}" ${ (informacion.inventario.id_laboratorio == l.id)?"selected":"" }>${l.nombre}</option>`;
    }

    laboratorios.innerHTML = opciones;

}

cerrarModalEdit.addEventListener("click",()=>{
    contendorModalEdit.style.display = "none";
});