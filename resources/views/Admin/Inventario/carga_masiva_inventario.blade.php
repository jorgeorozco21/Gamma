<div class="space-y-6">
    <!-- Descripcion y Plantilla -->
    <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
        <p class="text-xs text-gray-500 leading-relaxed">
            Sube un archivo <strong class="text-gray-700">.xlsx</strong> con el formato establecido. Si no tienes la plantilla, descárgala aquí:
        </p>
        <a href="{{ url('/archivo-inventario') }}" class="inline-flex items-center gap-2 mt-3 text-[#7B1FA3] text-xs font-bold hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Descargar Plantilla
        </a>
    </div>
    <form action="{{ url('/carga-inventario') }}" method="post" enctype="multipart/form-data" class="space-y-4">
        <!-- Cargar Archivo -->
        @csrf
        <div class="relative group">
            <input type="file" name="archivo"required class="w-full text-xs text-gray-400 file:mr-4 file:py-3 file:px-5 
                file:rounded-2xl file:border-0 file:text-[11px] file:font-bold file:bg-[#7B1FA3] file:text-white 
                hover:file:bg-[#6A1B8E] file:transition-all cursor-pointer bg-white border border-gray-100 rounded-2xl shadow-sm">
        </div>
        <!-- Boton Subir Archivo -->
        <button type="submit" class="w-full bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-purple-100 active:scale-95 text-center">
            Subir Archivo
        </button>
    </form>
</div>