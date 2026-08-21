const c=document.getElementById("contenedor-reportes"),l=document.getElementById("contenedor-solicitudes"),s=document.getElementById("buscador"),p=document.getElementById("filtro-tipo");s.placeholder="ID de Solicitud o No Computadora";const i=document.getElementById("filtro"),g={id:document.getElementById("id_usuario").value,nombre:document.getElementById("nombre").value,email:document.getElementById("email").value};document.addEventListener("click",function(o){const t=o.target.closest(".ver-reportes");if(t){const r=t.getAttribute("data-idSolicitud"),d=t.getAttribute("data-id");h(r,d);return}const e=o.target.closest(".aceptada");if(e&&confirm("Deseas aprobar este reporte ??")){const r=e.dataset.id;f(r),s.value="",i.selectedIndex=0,n()}const a=o.target.closest(".rechazada");if(a&&confirm("Deseas rechazar este reporte ??")){const r=a.dataset.id;v(r),s.value="",i.selectedIndex=0,n()}});async function h(o,t){const a=await(await fetch(`/usuario/encargado/reportes-computo?id=${t}&idSolicitud=${o}`)).json();x(o,a)}function x(o,t){if(c.innerHTML="",t.length===0)c.innerHTML=`
            <div class="mb-4 p-4 bg-[#F7F6F8] rounded-2xl relative group transition-all cursor-default">
                <p class="text-[11px] text-gray-700 font-bold leading-relaxed line-clamp-3">
                    No hay reportes.
                </p>
            </div>
        `;else{let r="";t.forEach(d=>{r+=`
                <div class="mb-4 p-4 bg-[#F7F6F8] rounded-2xl border-2 border-red-200 relative group hover:shadow-md hover:border-red-600 transition-all cursor-default">
                    <p class="text-[11px] text-gray-700 font-bold leading-relaxed line-clamp-3 uppercase">
                        ${d.tipo}
                    </p>
                    <p class="text-[11px] text-gray-500 font-bold leading-relaxed line-clamp-3">
                        ${d.descripcion}
                    </p>
                </div>
            `}),c.innerHTML=r}const e=document.getElementById("reportes-Modal"),a=document.getElementById("id-solicitud-reportes");a.innerText="#"+o,e.classList.remove("hidden"),document.body.classList.add("overflow-hidden")}function m(){document.getElementById("reportes-Modal").classList.add("hidden"),document.body.classList.remove("overflow-hidden")}document.getElementById("cerrar-modal").addEventListener("click",m);document.querySelector(".pared-modal").addEventListener("click",m);async function f(o){const t={id_solicitud:o,estado:"aceptada",info_usuario:g};try{const e=await fetch("/usuario/encargado/actualizar-solicitudes-computo",{method:"POST",headers:{"Content-Type":"application/json",Accept:"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(t)}),a=await e.json();e.ok?alert("Reporte generado correctamente"):alert(a.error)}catch(e){console.error("Error de conexión:",e)}}async function v(o){try{const t=await fetch(`/usuario/encargado/rechazar-solicitud-computo/${o}`,{method:"DELETE",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content"),Accept:"application/json"}}),e=await t.json();t.ok?alert("Reporte rechazado."):alert("Error: "+e.message)}catch(t){console.error("Error en la conexión:",t)}}function b(o){l.innerHTML="";let t="";o.forEach(e=>{const r=new Date(e.fecha).toLocaleDateString("es-ES",{day:"2-digit",month:"2-digit",year:"numeric"});t+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <!-- ID Solicitud -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${e.id}
                </td>
                <!-- Numero de computadora -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${e.numero_computadora}
                </td>

                <!-- Laboratorio -->
                <td class="px-6 py-4 text-center text-black text-sm font-medium tracking-tight">
                    ${e.nombre}
                </td>

                <td class="px-6 py-4 text-black text-sm font-medium text-center uppercase">
                    ${e.tipo}
                </td>

                <!-- Descripcion -->
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button type="button" 
                            onclick="openMaterialModal('${e.id}','${e.descripcion}')" 
                            class="flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                            title="Ver Descripcion">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>
                
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button data-id="${e.id_computadora}" data-idSolicitud="${e.id}"
                            class="ver-reportes flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                            title="Ver Descripcion">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>

                <!-- Fecha -->
                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                    ${r}
                </td>

                <!-- Acciones -->
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-3">
                        <!-- Aprobar Solicitud -->
                        <button data-id="${e.id}" class="aceptada flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Aprobar
                        </button>

                        <!-- Rechazar Solicitud -->
                        <button data-id="${e.id}" class="rechazada flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Rechazar
                        </button>
                    </div>
                </td>
            </tr>
        `}),l.innerHTML=t}async function n(){const t=await(await fetch(`/api/usuario/encargado/solicitudes-pendientes-computo?texto=${s.value}&filtro=${i.value}&filtrotipo=${p.value}`)).json();b(t)}let u;const y=300;s.addEventListener("input",()=>{clearTimeout(u),u=setTimeout(()=>{n()},y)});i.addEventListener("change",()=>{n()});p.addEventListener("change",()=>{n()});setInterval(()=>{n()},5e3);
