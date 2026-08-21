const d=document.getElementById("buscador");d.placeholder="ID de Solicitud o No Computadora";const s=document.getElementById("filtro"),p=document.getElementById("filtro-tipo"),c=document.getElementById("contenedor-reportes"),u={id:document.getElementById("id_usuario").value,nombre:document.getElementById("nombre").value,email:document.getElementById("email").value};async function n(){const e=await(await fetch(`/api/usuario/encargado/solicitudes-aceptadas-computo?texto=${d.value}&filtro=${s.value}&filtrotipo=${p.value}`)).json();g(e)}let i;const m=300;d.addEventListener("input",()=>{clearTimeout(i),i=setTimeout(()=>{n()},m)});s.addEventListener("change",()=>{n()});p.addEventListener("change",()=>{n()});function g(a){c.innerHTML="";let e="";a.forEach(t=>{const r=new Date(t.fecha).toLocaleDateString("es-ES",{day:"2-digit",month:"2-digit",year:"numeric"});e+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <!-- ID de la Solicitud -->
                <td class="px-6 py-4 text-black text-center font-medium">
                    ${t.id}
                </td>

                <!-- Numero de computadora -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${t.numero_computadora}
                </td>

                <!-- Laboratorio -->
                <td class="px-6 py-4 text-center text-black text-sm font-medium tracking-tight">
                        ${t.nombre}
                </td>

                <td class="px-6 py-4 text-black text-sm font-medium text-center uppercase">
                    ${t.tipo}
                </td>

                <!-- Descripcion -->
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button type="button" 
                            onclick="openMaterialModal('${t.id}', '${t.descripcion}')" 
                            class="flex items-center gap-2 text-[#7B1FA3] hover:text-white"
                            title="Ver motivo">
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
        `,(t.estado=="aceptada"||t.estado=="en proceso"||t.estado=="reprogramado")&&(e+=`
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-[10px] bg-orange-50 text-orange-600 font-bold rounded-lg border border-orange-100 uppercase">
                            ${t.estado}
                        </span>
                    </td>
                    <td>
                    </td>
                </tr>
            `),t.estado=="reparado"&&(e+=`
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                            ${t.estado}
                        </span>

                        <button data-id='{{ $reporte->id }}' data-estado='completado'
                            class="completar p-2 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]"
                            title="Guardar cambio">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-8H7v8"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v4h8"/>
                            </svg>
                        </button>
                    </td>

                    <td>
                        <div class="flex justify-center">
                            <button data-id='${t.id}' data-estado='reprogramado' class="reportar flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all text-xs font-bold">
                                Reportar
                            </button>
                        </div>
                    </td>
                </tr>
            `)}),c.innerHTML=e}document.addEventListener("click",a=>{const e=a.target.closest(".completar");if(e&&confirm("El reporte ha sido completado ??")){const o=e.dataset.id,r=e.dataset.estado;l(o,r),d.value="",s.selectedIndex=0,n()}const t=a.target.closest(".reportar");if(t&&confirm("El reporte no ha sido completado aun ??")){const o=t.dataset.id,r=t.dataset.estado;l(o,r),d.value="",s.selectedIndex=0,n()}});async function l(a,e){const t={id_solicitud:a,estado:e,info_usuario:u};try{const o=await fetch("/usuario/encargado/actualizar-solicitudes-computo",{method:"POST",headers:{"Content-Type":"application/json",Accept:"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(t)}),r=await o.json();o.ok?alert("Reporte actualizado correctamente"):alert(r.error)}catch(o){console.error("Error de conexión:",o)}}setInterval(()=>{n()},5e3);
