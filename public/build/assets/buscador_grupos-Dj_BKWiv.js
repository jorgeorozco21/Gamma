import{f as r,i as l}from"./borrado_masivo-Bka9kyio.js";const m=document.getElementById("informacion-filtrada"),a=document.getElementById("buscador"),i=document.getElementById("filtrar-turno");async function c(){const e=await(await fetch(`/api/grupos?texto=${a.value}&filtro=${i.value}`)).json();m.innerHTML=v(e.data)}let s;const u=300;a.addEventListener("input",()=>{clearTimeout(s),s=setTimeout(()=>{c()},u)});function v(n){const e=document.querySelector('meta[name="csrf-token"]'),d=e?e.content:"";let o="";return n.forEach(t=>{o+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.grado}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.grupo}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.nombre}</td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${t.turno}</td>
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button data-laboratorios="${t.id}" class="ver flex items-center gap-2 text-[#7B1FA3] hover:text-white transition-colors">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <div class="seleccionar-registro ${r?"":"hidden"}">
                            <input type="checkbox" value="${t.id}" class="check-borrar" ${l.includes(String(t.id))?"checked":""}>
                        </div>
                        <div class="acciones ${r?"hidden":""} flex items-center justify-center gap-2">
                            <button class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${t.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <form action="/admin/grupos/${t.id}" method="post" class="inline">
                                <input type="hidden" name="_token" value="${d}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" value="Borrar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Deseas borra el grupo ??')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        `}),o}i.addEventListener("change",()=>{c()});
