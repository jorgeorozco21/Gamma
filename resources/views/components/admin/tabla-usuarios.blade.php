@props(['usuarios'])

<div class="bg-white rounded-[20px] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto no-scrollbar">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Usuario</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nombre Completo</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tipos de Usuario</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Grupo</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Acciones</th>
                </tr>
            </thead>
            
            <tbody id="informacion-filtrada" class="divide-y divide-gray-50">
                @foreach ($usuarios as $usuario)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <!-- Nombre Abreviado -->
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-[#7B1FA3] font-bold text-xs uppercase shrink-0">
                                    {{ strtoupper(substr($usuario->Nombre_Usuario, 0, 2)) }}
                                </div>
                                <!-- Nombre de Usuario y Correo -->
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ $usuario->Nombre_Usuario }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $usuario->Email }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Nombre -->
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                            {{ $usuario->Nombre }}
                        </td>

                        <!-- Tipo de Usuario -->
                        <td class="flex flex-col px-6 py-4">
                            @if ($usuario->Normal == "1") <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg">Normal</span>@endif
                            @if ($usuario->Encargado == "1") <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg">Encargado de Area</span>@endif
                            @if ($usuario->Mantenimiento == "1") <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg">Encargado de Mantenimiento</span>@endif
                        </td>

                        <!-- Grado / Grupo -->
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($usuario->nombreGrupo)
                                {{ $usuario->Grado }}°{{ $usuario->Grupo }} - {{ $usuario->nombreGrupo }}
                            @else
                                <span class="text-gray-300">Sin Grupo</span>
                            @endif
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Cambiar Contraseña -->
                                <button title="Cambiar Contraseña" class="btn-cambiar-contrasena p-2 text-gray-400 hover:text-amber-500 transition-colors" 
                                        data-id="{{ $usuario->id }}" data-url="{{ route('admin.usuarios.cambiarContrasena', $usuario->id) }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                </button>

                                <!-- Editar -->
                                <button title="Editar" class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="{{ $usuario->id }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>

                                <!-- Eliminar -->
                                <form action="{{ url('/Admin/Usuarios/'.$usuario->id) }}" method="post" class="inline">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit" title="Eliminar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Deseas borrar el usuario?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>