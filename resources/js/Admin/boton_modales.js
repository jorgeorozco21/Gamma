// BOTON CON OPCIONES
const btn = document.getElementById('btn-dropdown');
const menu = document.getElementById('dropdown-menu');
const arrow = document.getElementById('arrow-icon');

// Validamos que el botón y el menú existan antes de asignar eventos
if (btn && menu) {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // Evita que window cierre el dropdown inmediatamente
        const isOpened = !menu.classList.contains('opacity-0');
        
        if (isOpened) {
            closeDropdown();
        } else {
            openDropdown();
        }
    });
}

function openDropdown() {
    if (!menu) return;
    menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
    menu.classList.add('opacity-100', 'scale-100');
    if (arrow) arrow.classList.add('rotate-180'); // Validación
}

function closeDropdown() {
    if (!menu) return;
    menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    menu.classList.remove('opacity-100', 'scale-100');
    if (arrow) arrow.classList.remove('rotate-180'); // Validación
}

// Cerrar dropdown al hacer clic fuera
window.addEventListener('click', () => closeDropdown());


// MODAL DE CARGA MASIVA
const btnCargaMasiva = document.getElementById('abrir-carga-masiva');
const modalCarga = document.getElementById('modal-carga');
const cerrarCarga = document.getElementById('cerrar-modal-carga');

// Función Abrir
if (btnCargaMasiva && modalCarga) {
    btnCargaMasiva.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation(); // <--- CRÍTICO: Evita que el click suba a 'window' y rompa el flujo
        
        // Cerramos el dropdown
        closeDropdown();
        
        // Mostrar modal
        modalCarga.style.display = 'flex';
    });
    
    // Evitar que hacer click DENTRO del modal lo cierre a través de window
    modalCarga.addEventListener('click', (e) => {
        e.stopPropagation();
    });
}

// Función Cerrar
function closeCargaModal() {
    if (modalCarga) modalCarga.style.display = 'none';
}

if (cerrarCarga) {
    cerrarCarga.addEventListener('click', (e) => {
        e.preventDefault();
        closeCargaModal();
    });
}