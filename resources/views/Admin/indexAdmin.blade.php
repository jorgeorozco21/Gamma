<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="h-full bg-[#F7F6F8]">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-admin.sidebar-admin :admin="$admin" />
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-4">
                    <button id="abrir-sidebar" class="md:hidden text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">------</h1>
                        <p class="hidden sm:block text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            -------
                        </p>
                    </div>
                </div>
            </header>

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
            <div>
                <div class="flex-1 p-6 no-scrollbar space-y-6">
                    <p>Porcentaje de computadoras activas: {{ $porcentajeFormateado }}%</p>
                </div>
                <div id="grafica-pastel">
                </div>
            </div>
            <div>
                <div>
                    <p>Cantidad de reportes de computo en las ultimas 24h: {{ $cantidadMenos24 }}</p>
                    <p>Cantidad de reportes de computo con mas de 24h: {{ $cantidadMas24 }}</p>
                </div>
                <div>
                    <h3>Materiales con menos stock</h3>
                    <table>
                        <thead>
                            <th>Nombre del Material</th>
                            <th>Cantidad</th>
                            <th>Laboratorio</th>
                        </thead>
                        <tbody>
                            @foreach ($inventarios as $i)
                                <tr>
                                    <td>{{ $i->nombre }}</td>
                                    <td>{{ $i->cantidad_disponible }}</td>
                                    <td>{{ $i->nombreLaboratorio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        let graficaPastel;

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
                    width: 700,
                    height: 400,
                    toolbar: {
                        show: false
                    }
                },
                series: datos.series, 
                labels: datos.labels, 
                
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                title: {
                    text: 'Computadoras en Funcionamiento',
                    align: 'center'
                },
                legend: {
                    position: 'bottom' 
                }
            };

            if (graficaPastel) {
                graficaPastel.updateOptions(opciones);
            } else {
                graficaPastel = new ApexCharts(document.getElementById("grafica-pastel"), opciones);
                graficaPastel.render();
            }
        }
    </script>
</body>
</html>