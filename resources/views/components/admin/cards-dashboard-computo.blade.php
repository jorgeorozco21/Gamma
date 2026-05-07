@props(['computadoras','solicitudesMenos24','solicitudesMas24'])

@php
    $activas = $computadoras->where('estado', 'activo')->first()->cantidad ?? 0;
    $total = $computadoras->sum('cantidad');
    $porcentajeActivas = ($total > 0) ? ($activas * 100) / $total : 0;
    $porcentajeFormateado = round($porcentajeActivas, 2);
@endphp
@php
    $cantidadMenos24 = $solicitudesMenos24->count();
    $cantidadMas24 = $solicitudesMas24->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between group hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase">Computadoras Activas</p>
                <h2 class="text-3xl font-bold text-black mt-1">{{ $porcentajeFormateado }}%</h2>
            </div>
            <div class="p-3 bg-purple-50 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#7B1FA3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <button onclick="toggleGrafica()" class="mt-4 text-sm font-bold text-[#7B1FA3] hover:underline flex items-center gap-1 transition-colors">
            Ver gráfica
        </button>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-start hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase">Reportes (Últimas 24 horas)</p>
            <h2 class="text-3xl font-bold text-black mt-1">{{ $cantidadMenos24 }}</h2>
        </div>
        <div class="p-3 bg-purple-50 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#7B1FA3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
    </div>  

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-start hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase">Reportes (Despues de 24 horas)</p>
            <h2 class="text-3xl font-bold text-black mt-1">{{ $cantidadMas24 }}</h2>
        </div>
        <div class="p-3 bg-purple-50 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#7B1FA3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="modal-grafica" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <!-- Contenedor -->
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-xl border border-gray-100 relative w-[95%] max-w-3xl">
        <!-- Botón cerrar -->
        <button onclick="toggleGrafica()" class="absolute top-3 right-4 hover:text-red-600 text-xl">✕</button>
        <!-- Gráfica -->
        <div class="w-full">
            <div id="grafica-pastel" class="w-full h-[250px] sm:h-[320px] md:h-[400px] lg:h-[450px]">
            </div>
        </div>

    </div>
</div>

<script>
    let graficaPastel;

    function toggleGrafica() {
    const modal = document.getElementById('modal-grafica');

    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');

    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 200);
}

    document.addEventListener("DOMContentLoaded", function() {
        const datosParaGrafico = {
            series: @json($computadoras->pluck('cantidad')),
            labels: @json($computadoras->pluck('estado'))
        };

        generarGrafico(datosParaGrafico);
    });

    function generarGrafico(datos){
        const opciones = {
            chart: {
                type: 'pie',
                height: '100%', // 🔥 clave para responsive
                toolbar: {
                    show: false
                }
            },

            series: datos.series,
            labels: datos.labels,

            colors: ['#16a34a', '#dc2626'],

            title: {
                text: 'Computadoras en Funcionamiento',
                align: 'center'
            },

            legend: {
                position: 'bottom'
            },

            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            ]
        };

        if (graficaPastel) {
            graficaPastel.updateOptions(opciones);
        } else {
            graficaPastel = new ApexCharts(
                document.getElementById("grafica-pastel"),
                opciones
            );
            graficaPastel.render();
        }
    }
</script>