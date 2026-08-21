import{f as s,i as l}from"./borrado_masivo-Bka9kyio.js";const u=document.getElementById("informacion-filtrada"),a=document.getElementById("buscador"),i=document.getElementById("filtrar-tipo");async function c(){const t=await(await fetch(`/api/laboratorios?texto=${a.value}&tipo=${i.value}`)).json();u.innerHTML=m(t.data)}let r;const p=300;a.addEventListener("input",()=>{clearTimeout(r),r=setTimeout(()=>{c()},p)});function m(n){const t=document.querySelector('meta[name="csrf-token"]'),d=t?t.content:"";let o="";return n.forEach(e=>{o+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${e.nombre}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-lg bg-blue-50 text-blue-600 border-blue-100">${e.tipo}</span>
                </td>
                <td class="px-6 py-4 text-sm text-black font-medium text-center">${e.cantidad_computadoras??" "}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <div class="seleccionar-registro ${s?"":"hidden"}">
                            <input type="checkbox" value="${e.id}" class="check-borrar" ${l.includes(String(e.id))?"checked":""}>
                        </div>
                        <div class="acciones ${s?"hidden":""} flex items-center justify-center gap-2">
                            <button class="abrir-modal-edit p-2 text-gray-400 hover:text-blue-500 transition-colors" data-id="${e.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <form action="/admin/laboratorios/${e.id}" method="post" class="inline">
                                <input type="hidden" name="_token" value="${d}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" value="Borrar" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Deseas borra el laboratorio ??')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        `}),o}i.addEventListener("change",()=>{c()});
