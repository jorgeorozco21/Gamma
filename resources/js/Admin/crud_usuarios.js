"use strict";

const tipoUsuario = document.getElementById("tipo-usuario");

tipoUsuario.addEventListener("change", ()=>{
    if (tipoUsuario.value != "Normal"){
        document.getElementById("label-grupo").style.display = "none";
        document.getElementById("grupo").style.display = "none";
    }else{
        document.getElementById("label-grupo").style.display = "flex";
        document.getElementById("grupo").style.display = "flex";
    }
});

const tipoUsuarioEdit = document.getElementById("tipo-usuario-edit");

tipoUsuarioEdit.addEventListener("change", ()=>{
    if (tipoUsuarioEdit.value != "Normal"){
        document.getElementById("label-grupo-edit").style.display = "none";
        document.getElementById("grupo-edit").style.display = "none";
    }else{
        document.getElementById("label-grupo-edit").style.display = "flex";
        document.getElementById("grupo-edit").style.display = "flex";
    }
});

async function informacionEditar(id){
    const response = await fetch(`/api/usuarios/editar?id=${id}`);
    const data = await response.json();

    asignarInformacionFormularioEditar(data);
}

function asignarInformacionFormularioEditar(informacion){

    document.getElementById('formulario-editar').action = `/Admin/Usuarios/${informacion.usuario.id}`;
    document.getElementById('nombre-usuario-edit').value = informacion.usuario.Nombre_Usuario;
    document.getElementById('email-edit').value = informacion.usuario.Email;
    document.getElementById('nombre-completo-edit').value = informacion.usuario.Nombre;
    document.getElementById('tipo-usuario-edit').innerHTML = `
        <option value="Normal" ${ (informacion.usuario.Tipo_Usuario == "Normal")?"selected":"" }>Normal</option>
        <option value="Encargado de Area" ${ (informacion.usuario.Tipo_Usuario == "Encargado de Area")?"selected":"" }>Encargado de Area</option>
        <option value="Encargado de Mantenimiento" ${ (informacion.usuario.Tipo_Usuario == "Encargado de Mantenimiento")?"selected":"" }>Encargado de Mantenimiento</option>
    `;
    

    if (document.getElementById("tipo-usuario-edit").value != "Normal"){
        document.getElementById("label-grupo-edit").style.display = "none";
        document.getElementById("grupo-edit").style.display = "none";
    }else{
        document.getElementById("label-grupo-edit").style.display = "flex";
        document.getElementById("grupo-edit").style.display = "flex";
        
        const gruposEditar = document.getElementById("grupo-edit");

        let opciones  = '';

        for (const grupo of informacion.grupos){
            opciones += `
                <option value="${grupo.id}" ${ (informacion.usuario.ID_Grupo == grupo.id)?"selected":"" }>${grupo.Grado} ${grupo.Grupo} ${grupo.Nombre}</option>
            `;
        }

        gruposEditar.innerHTML = opciones;
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

document.addEventListener("click", async function(e){

    if(e.target.classList.contains("btn-cambiar-contrasena")){

        if (!confirm("Seguro que deseas cambiar la contraseña?")) return;

        const url = e.target.dataset.url;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        try {

            const respuesta = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-Type": "application/json"
                }
            });

            const data = await respuesta.json();
            alert(data.message);

        } catch(error) {
            alert("Error al cambiar contraseña");
        }
    }
});

const filtroTipo = document.getElementById("filtrar-tipo");

filtroTipo.addEventListener("change", ()=>{
    if (filtroTipo.value != "Normal" && filtroTipo.value != "Sin Filtro"){
        document.getElementById("filtrar-grupo-label").style.display = "none";
        document.getElementById("filtrar-grupo").style.display = "none";
        document.getElementById("filtrar-grupo").value = "Sin Filtro";
    }else{
        document.getElementById("filtrar-grupo-label").style.display = "inline-block";
        document.getElementById("filtrar-grupo").style.display = "inline-block";
        document.getElementById("filtrar-grupo").value = "Sin Filtro";
    }
});

const filtroGrupo = document.getElementById("filtrar-grupo");

filtroGrupo.addEventListener("change", ()=>{
    if (filtroGrupo.value != "Sin Filtro"){
        filtroTipo.value = "Normal";
    }
});