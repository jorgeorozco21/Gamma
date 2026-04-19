"use strict";

const tipoLaboratorio = document.getElementById('tipo');
const cerrarModal = document.getElementById('cerrar-modal');

cerrarModal.addEventListener('click', ()=>{
    document.getElementById('nombre').value = '';
    document.getElementById('tipo').selectedIndex = 0;
    document.getElementById('label-cantidad').style.display = "none";
    document.getElementById('cantidad').style.display = 'none';
});

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
    document.getElementById("cantidad-edit").innerHTML = `${informacion.cantidad_computadoras}`;

    document.getElementById('tipo-edit').innerHTML =  `${informacion.tipo}`;
}

const contendorModalEdit = document.getElementById("modal-edit");
const cerrarModalEdit = document.getElementById("cerrar-modal-edit"); 

document.addEventListener("click", function(e){ 
    const editar = e.target.closest(".abrir-modal-edit");
    if(editar){ 

        contendorModalEdit.style.display = "flex"; 

        let id = editar.dataset.id;
        
        informacionEditar(id);
    } 
});

cerrarModalEdit.addEventListener("click",()=>{
    document.getElementById('nombre-edit').value = '';
    document.getElementById('tipo-edit').innerHTML = '';
    document.getElementById('cantidad-edit').innerHTML = '';

    contendorModalEdit.style.display = "none";
});