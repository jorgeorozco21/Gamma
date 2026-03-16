"use strict";

const tipoLaboratorio = document.getElementById('tipo');

tipoLaboratorio.addEventListener("change", ()=>{
    if (tipoLaboratorio.value == "prestamos"){
        document.getElementById("label-cantidad").style.display = "none";
        document.getElementById("cantidad").style.display = "none";
        document.getElementById('cantidad').value = null;
    }else{
        document.getElementById("label-cantidad").style.display = "flex";
        document.getElementById("cantidad").style.display = "flex";
        document.getElementById('cantidad').value = 1;
    }
});

const tipoLaboratorioEdit = document.getElementById('tipo-edit');

tipoLaboratorioEdit.addEventListener("change", ()=>{
    if (tipoLaboratorioEdit.value == "prestamos"){
        document.getElementById("label-cantidad-edit").style.display = "none";
        document.getElementById("cantidad-edit").style.display = "none";
        document.getElementById('cantidad-edit').value = null;
    }else{
        document.getElementById("label-cantidad-edit").style.display = "flex";
        document.getElementById("cantidad-edit").style.display = "flex";
        document.getElementById('cantidad-edit').value = 1;
    }
});

async function informacionEditar(id){
    const response = await fetch(`/api/laboratorios/editar?id=${id}`);
    const data = await response.json();

    asignarInformacionFormularioEditar(data);
}

function asignarInformacionFormularioEditar(informacion){

    document.getElementById("formulario-editar").action = `/admin/laboratorios/${informacion.id}`;
    document.getElementById("nombre-edit").value = informacion.nombre;
    document.getElementById("tipo-edit").innerHTML = `
        <option value="prestamos" ${ (informacion.tipo == "prestamos")?"selected":"" }>Laboratorio de Prestamos</option>
        <option value="computo" ${ (informacion.tipo == "computo")?"selected":"" }>Laboratorio de Computo</option>`
    ;
    document.getElementById("cantidad-edit").value = informacion.cantidad_computadoras;

    if (document.getElementById("tipo-edit").value != "computo"){
        document.getElementById("label-cantidad-edit").style.display = "none";
        document.getElementById("cantidad-edit").style.display = "none";
        document.getElementById("cantidad-edit").value = null;
    }else{
        document.getElementById("label-cantidad-edit").style.display = "flex";
        document.getElementById("cantidad-edit").style.display = "flex";
    }
}

const contendorModalEdit = document.getElementById("modal-edit");
const cerrarModalEdit = document.getElementById("cerrar-modal-edit"); 

document.addEventListener("click", function(e){ 
    if(e.target.closest(".abrir-modal-edit")){ 

        contendorModalEdit.style.display = "flex"; 

        let id = e.target.dataset.id;
        
        informacionEditar(id);
    } 
});

cerrarModalEdit.addEventListener("click",()=>{
    contendorModalEdit.style.display = "none";
});