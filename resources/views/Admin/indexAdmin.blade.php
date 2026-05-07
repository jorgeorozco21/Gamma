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
                        <h2 class="text-lg md:text-xl font-extrabold text-gray-800 leading-tight">Dashboard</h1>
                    </div>
                </div>
            </header>

            <div class="p-6 space-y-6">
                <x-admin.cards-dashboard-computo :computadoras="$computadoras" :solicitudesMenos24="$solicitudesMenos24" :solicitudesMas24="$solicitudesMas24" />
            </div>


            <div>
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

</body>
</html>