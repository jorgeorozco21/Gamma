import{f as a,i as m}from"./borrado_masivo-Bka9kyio.js";const s=document.getElementById("informacion-filtrada"),i=document.getElementById("buscador"),c=document.getElementById("filtro-lab");async function d(){const e=await(await fetch(`/api/inventario?texto=${i.value}&filtro=${c.value}`)).json();p(e.data)}let r;const u=300;i.addEventListener("input",()=>{clearTimeout(r),r=setTimeout(()=>{d()},u)});function p(n){const e=document.querySelector('meta[name="csrf-token"]'),l=e?e.content:"";s.innerHTML="";let o="";n.forEach(t=>{o+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.nombreMaterial}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.nombreLaboratorio}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.cantidad_disponible}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.cantidad_total}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <div class="seleccionar-registro ${a?"":"hidden"}">
                            <input type="checkbox" value="${t.id}" class="check-borrar" ${m.includes(String(t.id))?"checked":""}>
                        </div>
                        <div class="acciones ${a?"hidden":""} flex items-center justify-center gap-2">
                            <button class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${t.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <form action="/admin/inventario/${t.id}" method="post" class="inline">
                                <input type="hidden" name="_token" value="${l}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" value="Borrar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Deseas borra el inventario ??')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        `}),s.innerHTML=o}c.addEventListener("change",()=>{d()});
