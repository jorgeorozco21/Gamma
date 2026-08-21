import{f as l,i as p}from"./borrado_masivo-Bka9kyio.js";const m=document.getElementById("informacion-filtrada"),d=document.getElementById("buscador"),a=document.getElementById("filtrar-tipo"),t=document.getElementById("filtrar-grupo");async function r(){const n=await(await fetch(`/api/usuarios?texto=${d.value}&tipoUsuario=${a.value}&grupo=${t.value}`)).json();m.innerHTML=g(n.data)}let i;const u=300;d.addEventListener("input",()=>{clearTimeout(i),i=setTimeout(()=>{r()},u)});function g(o){const n=document.querySelector('meta[name="csrf-token"]'),c=n?n.content:"";let s="";return o.forEach(e=>{s+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800">${e.nombre_usuario}</p>
                            <p class="text-xs text-gray-400">${e.email}</p>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                    ${e.nombre}
                </td>

                <td class="px-6 py-4">
                    <div class="flex flex-col h-full justify-center gap-2"> 
                        <div class="flex flex-row flex-wrap gap-2">
                            ${e.normal=="1"?'<span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg bg-blue-50 text-blue-600 border border-blue-100 w-fit">Normal</span>':""}
                            ${e.encargado=="1"?'<span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg bg-purple-50 text-[#7B1FA3] border border-purple-100 w-fit">Encargado de Area</span>':""}
                        </div>
                            ${e.mantenimiento=="1"?'<span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg bg-amber-50 text-amber-600 border border-amber-100 w-fit">Encargado de Mantenimiento</span>':""}
                    </div>
                </td>

                <td class="px-6 py-4 text-sm text-gray-500">
                    ${e.nombreGrupo?`${e.grado}°${e.grupo} - ${e.nombreGrupo} - ${e.turno}`:"Sin Grupo"}
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <div class="seleccionar-registro ${l?"":"hidden"}">
                            <input type="checkbox" value="${e.id}" class="check-borrar" ${p.includes(String(e.id))?"checked":""}>
                        </div>
                        <div class="acciones ${l?"hidden":""} flex items-center justify-center gap-2">
                            <button title="Cambiar Contraseña" class="btn-cambiar-contrasena p-2 text-gray-400 hover:text-amber-500 transition-colors" 
                                    data-id="${e.id}" data-url="/admin/usuarios/${e.id}/cambiar-contrasena">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            </button>

                            <button title="Editar" class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${e.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            <form action="/admin/usuarios/${e.id}" method="post" class="inline">
                                <input type="hidden" name="_token" value="${c}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" title="Eliminar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Deseas borrar el usuario?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        `}),s}a.addEventListener("change",()=>{a.value=="encargado"||a.value=="mantenimiento"?(t.selectedIndex=0,t.style.display="none",document.getElementById("filtrar-grupo-label").style.display="none"):(t.style.display="flex",document.getElementById("filtrar-grupo-label").style.display="flex"),r()});t.addEventListener("change",()=>{r()});
