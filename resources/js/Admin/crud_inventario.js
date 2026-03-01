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

    document.getElementById("formulario-editar").action = `/Admin/Inventario/${informacion.inventario.id}`;
    
    const materiales = document.getElementById("material-edit");

    let opciones = '';
    for (const m of informacion.materiales){
        opciones += `<option value="${m.id}" ${ (informacion.inventario.ID_Material == m.id)?"selected":"" }>${m.Nombre}</option>`;
    }

    materiales.innerHTML = opciones;

    document.getElementById("cantidad-disponible-edit").value = informacion.inventario.Cantidad_Disponible;
    document.getElementById("cantidad-total-anterior-edit").value = informacion.inventario.Cantidad_Total;

    if (informacion.inventario.Cantidad_Total == informacion.inventario.Cantidad_Disponible){
        document.getElementById("cantidad-edit").value = informacion.inventario.Cantidad_Total;
    }else{
        document.getElementById("cantidad-edit").value = informacion.inventario.Cantidad_Total;
        document.getElementById("cantidad-edit").min = informacion.inventario.Cantidad_Total;
    }

    const laboratorios = document.getElementById("laboratorio-edit");

    opciones  = '';

    for (const l of informacion.laboratorios){
        opciones += `<option value="${l.id}" ${ (informacion.inventario.ID_Laboratorio == l.id)?"selected":"" }>${l.Nombre}</option>`;
    }

    laboratorios.innerHTML = opciones;

}

cerrarModalEdit.addEventListener("click",()=>{
    contendorModalEdit.style.display = "none";
});