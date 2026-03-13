<section class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-[#7B1FA3] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-800">Carga Masiva</h2>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">Importa un archivo (.csv, .xlsx)</p>
            </div>
        </div>

        <form action="{{ url('/cargaUsuario') }}" method="post" enctype="multipart/form-data" 
                class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            @csrf
            
            <div class="relative flex-1">
                <input type="file" name="archivo" id="archivo" class="w-full text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-4 
                    file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-gray-100 file:text-gray-600 
                    hover:file:bg-gray-200 transition-all cursor-pointer focus:outline-none active:scale-[0.98]">
            </div>

            <button type="submit" 
                class="bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-purple-100 active:scale-95 text-center">
                Subir Archivo
            </button>
        </form>
    </div>
</section>