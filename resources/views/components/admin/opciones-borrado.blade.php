@props(['id' => null])
<div id="{{ $id }}"class="hidden absolute bottom-6 left-1/2 -translate-x-1/2 z-50 bg-white px-6 py-3 rounded-2xl shadow-2xl border border-gray-100 flex flex-col sm:flex-col items-center gap-4 whitespace-nowrap transition-all duration-300">
    <div class="flex justify-center">
        <p id="mostrar-cantidad-elementos" class="text-xs font-bold text-gray-800">0 elemento(s) seleccionado(s)</p>
    </div>
    <div class="flex justify-center items-center gap-4">
        <button id="seleccionar-todo" type="button" class="p-2 rounded-lg bg-[#6A1B8E] text-xs font-bold text-white hover:bg-[#521370] transition-colors active:scale-95">
            Seleccionar Todo
        </button>
        <button id="limpiar-todo" type="button" class="p-2 rounded-lg bg-[#6A1B8E] text-xs font-bold text-white hover:bg-[#521370] transition-colors active:scale-95">
            Limpiar Todo
        </button>
        <button id="borrar-elementos" type="button" class="p-2 rounded-lg bg-red-600 text-xs font-bold text-white hover:bg-red-700 transition-colors active:scale-95">
            Borrar
        </button>
        <button id="anular-borrado" type="button" class="p-2 text-black font-bold text-lg rounded-lg hover:text-red-600 transition-colors">
            ✕
        </button>
    </div>
</div>