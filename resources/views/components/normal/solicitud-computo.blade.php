<!-- Overlay (Movil) -->
<div id="overlay"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden">
</div>

<aside id="cart" class="fixed lg:static bottom-0 right-0 w-full lg:w-[380px] h-[75vh] lg:h-[90vh] bg-white border-t lg:border-t-0 lg:border-l
    border-gray-100 p-6 flex flex-col shadow-[-10px_0_20px_-5px_rgba(0,0,0,0.1)] rounded-t-3xl lg:rounded-none translate-y-full lg:translate-y-0 transition-transform duration-300 ease-out">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <h2 id="encabezado" class="text-xl font-extrabold text-gray-800">Solicitudes de Reportes</h2>
        </div>

        <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-[#7B1FA3] w-full"></div>
        </div>

        <p class="text-[10px] text-gray-400 mt-2">
            Revisa las solicitudes realizadas de una computadora
        </p>
    </div>

    <!-- Cards de Items -->
    <div id="contenedor-reportes" class="flex-1 overflow-y-auto space-y-4 pr-2">
    </div>

    <!-- Footer -->
    <div class="mt-6 pt-6 border-t border-gray-100">
        <!-- Reporte -->
        <div class="mb-4">
            <divc class="mb-4">
                <label for="tipo" class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                    Tipo de Problema
                </label>

                <select id="tipo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-[#7B1FA3] transition-all">
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option>
                    <option value="red">Red</option>
                </select>
            </div>

            <div>
                <label for="descripcion-reporte" class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                    Descripción del Problema
                </label>
                <!-- Descripcion del Reporte -->
                <textarea id="descripcion-reporte" name="descripcion"
                    class="w-full p-4 max-h-32 bg-gray-50 border border-gray-100 rounded-[20px] text-sm text-gray-600 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-100 focus:border-[#7B1FA3] transition-all resize-y shadow-inner"
                    placeholder="Ej: Hay algunas fallas en el monitor"></textarea>
            </div>
        </div>
        
        <!-- Boton de Enviar Reporte -->
        <button id="enviar" class="w-full mt-4 bg-purple-700 hover:bg-[#7B1FA3] text-white py-3 rounded-2xl font-bold transition-all">
            Enviar Reporte
        </button>
    </div>
</aside>

<!-- Boton de Ver Reporte (Movil) -->
<button id="openCart" class="fixed bottom-6 right-6 lg:hidden bg-purple-700 text-white p-4 rounded-full shadow-xl transition-opacity duration-300">
    <span class="text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M5 8h14l-1 12H6L5 8zm3 0V6a4 4 0 118 0v2"/>
        </svg>
    </span>
</button>

<script>
    const cart = document.getElementById('cart');
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openCart');

    function openCart() {
        cart.classList.remove('translate-y-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');

        openBtn.classList.add('opacity-0', 'pointer-events-none');
    }

    function closeCart() {
        cart.classList.add('translate-y-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        openBtn.classList.remove('opacity-0', 'pointer-events-none');
    }

    openBtn.addEventListener('click', openCart);
    overlay.addEventListener('click', closeCart);
</script>