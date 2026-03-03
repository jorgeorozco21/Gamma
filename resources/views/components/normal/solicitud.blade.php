<!-- Overlay (solo móvil) -->
<div id="overlay"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 md:hidden">
</div>

<aside id="cart" class="fixed md:static bottom-0 right-0 w-full md:w-[380px] h-[75vh] md:h-screen bg-white border-t md:border-t-0 md:border-l
    border-gray-100 p-6 flex flex-col shadow-2xl rounded-t-3xl md:rounded-none translate-y-full md:translate-y-0 transition-transform duration-300 ease-out">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-[#7B1FA3]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 8h14l-1 12H6L5 8zm3 0V6a4 4 0 118 0v2"/>
                </svg>
            </span>
            <h2 class="text-xl font-extrabold text-gray-800">Solicitud</h2>
        </div>

        <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-[#7B1FA3] w-full"></div>
        </div>

        <p class="text-[10px] text-gray-400 mt-2">
            Agrega todos los materiales para finalizar la solicitud
        </p>
    </div>

    <!-- Contenido -->
    <div class="flex-1 overflow-y-auto space-y-4 pr-2">
        <!-- items aquí -->
    </div>

    <!-- Footer -->
    <div class="mt-6 pt-6 border-t border-gray-100">
        <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500 font-medium">Total Items</span>
            <span class="text-xl font-black text-gray-900">4</span>
        </div>

        <button class="w-full mt-4 bg-purple-700 hover:bg-[#7B1FA3] text-white py-4 rounded-2xl font-bold transition-all">
            Enviar Solicitud
        </button>
    </div>

</aside>

<button id="openCart" class="fixed bottom-6 right-6 md:hidden bg-purple-700 text-white p-4 rounded-full shadow-xl transition-opacity duration-300">
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

        // 👇 ocultar botón flotante
        openBtn.classList.add('opacity-0', 'pointer-events-none');
    }

    function closeCart() {
        cart.classList.add('translate-y-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');

        // 👇 volver a mostrar botón
        openBtn.classList.remove('opacity-0', 'pointer-events-none');
    }

    openBtn.addEventListener('click', openCart);
    overlay.addEventListener('click', closeCart);
</script>