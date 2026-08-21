import{f as r,i as u}from"./borrado_masivo-Bka9kyio.js";const s=document.getElementById("informacion-filtrada"),a=document.getElementById("buscador"),c=document.getElementById("filtro-tipo");async function l(){const t=await(await fetch(`/api/materiales?texto=${a.value}&filtro=${c.value}`)).json();m(t.data)}let i;const p=300;a.addEventListener("input",()=>{clearTimeout(i),i=setTimeout(()=>{l()},p)});c.addEventListener("change",()=>{l()});function m(o){s.innerHTML="";const t=document.querySelector('meta[name="csrf-token"]'),d=t?t.content:"";let n="";for(const e of o)n+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4 text-sm text-black font-medium text-center">
                    ${e.nombre}
                </td>
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button type="button"
                            onclick="openMaterialModal('${e.descripcion}')"
                            class="flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                            title="Ver Descripcion">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg bg-blue-50 text-blue-600 border border-blue-100">
                        ${e.tipo}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <div class="seleccionar-registro ${r?"":"hidden"}">
                            <input type="checkbox" value="${e.id}" class="check-borrar" ${u.includes(String(e.id))?"checked":""}>
                        </div>
                        <div class="acciones ${r?"hidden":""} flex items-center justify-center gap-2">
                            <button class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${e.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            <form action="/admin/materiales/${e.id}" method="post" class="inline">
                                <input type="hidden" name="_token" value="${d}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" value="Borrar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Deseas borra el material ??')"> 
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        `;s.innerHTML=n}
