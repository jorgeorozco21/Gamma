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

async function informacionEditar(id){
    const response = await fetch(`/api/materiales/editar?id=${id}`);
    const data = await response.json();

    asignarInformacionFormularioEditar(data);
}

function asignarInformacionFormularioEditar(informacion){

    document.getElementById("formulario-editar").action = `/Admin/Materiales/${informacion.id}`;
    document.getElementById("nombre-edit").value = informacion.Nombre;
    document.getElementById("descripcion-edit").value = informacion.Descripcion;
    document.getElementById("tipo-edit").innerHTML = `
        <option value="Prestamos por Unidad" ${ (informacion.Tipo == "Prestamos por Unidad")?"selected":"" }>Prestamos por Unidad</option>
        <option value="Prestamos por Cantidad" ${ (informacion.Tipo == "Prestamos por Cantidad")?"selected":"" }>Prestamos por Cantidad</option>
    `;

}