"use strict";

const contendorModal = document.getElementById("modal");
const abrirModal = document.getElementById("abrir-modal");
const cerrarModal = document.getElementById("cerrar-modal");

abrirModal.addEventListener("click",()=>{
    contendorModal.style.display = "flex";
});

cerrarModal.addEventListener("click",()=>{
    contendorModal.style.display = "none";
});
