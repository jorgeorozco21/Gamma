const contendorModalEdit = document.getElementById("modal-edit");
const cerrarModalEdit = document.getElementById("cerrar-modal-edit");
const cerrarModal = document.getElementById('cerrar-modal'); 

cerrarModal.addEventListener('click', ()=>{
    document.getElementById('nombre').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('tipo').selectedIndex = 0;
})

document.addEventListener("click", function(e){ 
    const boton = e.target.closest(".abrir-modal-edit");

    if(boton){ 
        contendorModalEdit.style.display = "flex"; 

        let id = boton.dataset.id;
        
        informacionEditar(id);
    } 
});

cerrarModalEdit.addEventListener("click",()=>{
    document.getElementById('nombre-edit').value = '';
    document.getElementById('descripcion-edit').value = '';
    document.getElementById('tipo-edit').selectedIndex = 0;
    contendorModalEdit.style.display = "none";
});

async function informacionEditar(id){
    const response = await fetch(`/api/materiales/editar?id=${id}`);
    const data = await response.json();

    asignarInformacionFormularioEditar(data);
}

function asignarInformacionFormularioEditar(informacion){

    document.getElementById("formulario-editar").action = `/admin/materiales/${informacion.id}`;
    document.getElementById("nombre-edit").value = informacion.nombre;
    document.getElementById("descripcion-edit").value = informacion.descripcion;
    document.getElementById("tipo-edit").innerHTML = `
        <option value="prestamos por unidad" ${ (informacion.tipo == "prestamos por unidad")?"selected":"" }>Prestamos por Unidad</option>
        <option value="prestamos por cantidad" ${ (informacion.tipo == "prestamos por cantidad")?"selected":"" }>Prestamos por Cantidad</option>
    `;

}