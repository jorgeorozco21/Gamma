"use strict";

const iniciarFuncion = document.getElementById("borrar-algunos");
const finFuncion = document.getElementById("anular-borrado");
const tabla = document.getElementById("informacion-filtrada");
const seleccionarTodo = document.getElementById("seleccionar-todo");
const limpiarTodo = document.getElementById("limpiar-todo");
const borrarElementos = document.getElementById("borrar-elementos");
const nombreTabla = document.getElementById("nombre-tabla").value;

export let funcionActiva = false;
export let ids = [];

function limpiarElementos(){
    funcionActiva = false;
    ids = [];
    document.getElementById("opciones-borrado").classList.add("hidden");

    document.getElementById("mostrar-cantidad-elementos").innerHTML = `${ids.length} elemento(s) seleccionado(s)`;
    
    document.querySelectorAll(".seleccionar-registro").forEach(e =>{
        e.classList.add("hidden");
    });

    document.querySelectorAll(".acciones").forEach(e =>{
        e.classList.remove("hidden");
    });

    document.querySelectorAll(".check-borrar").forEach(e =>{
        e.checked = false;
    });
}

iniciarFuncion.addEventListener('click', ()=>{
    funcionActiva = true;
    document.getElementById("opciones-borrado").classList.remove("hidden");

    document.querySelectorAll(".acciones").forEach(e =>{
        e.classList.add("hidden");
    });

    document.querySelectorAll(".seleccionar-registro").forEach(e =>{
        e.classList.remove("hidden");
    });
});

tabla.addEventListener('change', (e)=>{
    if (e.target.type == 'checkbox'){

        e.stopImmediatePropagation();

        if (e.target.checked) ids.push(e.target.value);
        else ids.splice(ids.indexOf(e.target.value),1);

        document.getElementById("mostrar-cantidad-elementos").innerHTML = `${ids.length} elemento(s) seleccionado(s)`; 
    }
});

seleccionarTodo.addEventListener('click', ()=>{
    ids = [];
    document.querySelectorAll(".check-borrar").forEach(e =>{
        e.checked = true;
        ids.push(e.value);

        document.getElementById("mostrar-cantidad-elementos").innerHTML = `${ids.length} elemento(s) seleccionado(s)`; 
    });
});

limpiarTodo.addEventListener('click', ()=>{
    ids = [];
    document.getElementById("mostrar-cantidad-elementos").innerHTML = `${ids.length} elemento(s) seleccionado(s)`; 
    document.querySelectorAll(".check-borrar").forEach(e =>{
        e.checked = false;
    });
});

finFuncion.addEventListener('click', ()=>{
    limpiarElementos();
});

borrarElementos.addEventListener('click', (e)=>{
    e.stopImmediatePropagation();

    if (ids.length == 0) alert('Tienes que seleccionar minimo un registro');
    else{
        if (confirm('Deseas borrar los elementos seleccionados ??')){
            borrarRegistros(ids);
        }
    }
});

function borrarRegistros(ids){
    fetch(`/admin/registros/borrar-multiples`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            ids: ids, 
            tabla: nombreTabla 
        })
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
        if (datos.success) {

            location.reload(); 
        } else {
            alert("Error: " + datos.message);
        }
    })
    .catch(error => {
        console.error("Error en la petición:", error);
        alert("No se pudo conectar con el servidor.");
    });
}
