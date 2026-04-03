// BOTON CON OPCIONES
const btn = document.getElementById('btn-dropdown');
const menu = document.getElementById('dropdown-menu');
const arrow = document.getElementById('arrow-icon');

btn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpened = !menu.classList.contains('opacity-0');
    
    if (isOpened) {
        closeDropdown();
    } else {
        openDropdown();
    }
});

function openDropdown() {
    menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
    menu.classList.add('opacity-100', 'scale-100');
    arrow.classList.add('rotate-180');
}

function closeDropdown() {
    menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    menu.classList.remove('opacity-100', 'scale-100');
    arrow.classList.remove('rotate-180');
}

// Cerrar al hacer clic fuera
window.addEventListener('click', () => closeDropdown());

// MODAL DE CARGA MASIVA
const btnCargaMasiva = document.getElementById('abrir-carga-masiva');
const modalCarga = document.getElementById('modal-carga');
const cerrarCarga = document.getElementById('cerrar-modal-carga');

// Función Abrir
if (btnCargaMasiva) {
    btnCargaMasiva.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Cerramos el dropdown si existe la función
        if (typeof closeDropdown === 'function') closeDropdown();
        
        // Mostrar modal
        modalCarga.style.display = 'flex';
    });
}

// Función Cerrar
function closeCargaModal() {
    modalCarga.style.display = 'none';
}

if (cerrarCarga) cerrarCarga.addEventListener('click', closeCargaModal);
