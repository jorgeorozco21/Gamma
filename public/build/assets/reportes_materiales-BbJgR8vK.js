const d=document.getElementById("buscador"),i=document.getElementById("filtro"),l=document.getElementById("contenedor-reportes"),u={id:document.getElementById("id_usuario").value,nombre:document.getElementById("nombre").value,email:document.getElementById("email").value};async function s(){const t=await(await fetch(`/api/usuario/encargado/reportes-materiales?texto=${d.value}&filtro=${i.value}`)).json();g(t)}let p;const m=300;d.addEventListener("input",()=>{clearTimeout(p),p=setTimeout(()=>{s()},m)});i.addEventListener("change",()=>{s()});function g(a){l.innerHTML="";let t="";a.forEach(e=>{const r=new Date(e.fecha).toLocaleDateString("es-ES",{day:"2-digit",month:"2-digit",year:"numeric"});t+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <!-- ID del Reporte -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${e.id}
                </td>

                <!-- Nombre del material -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${e.nombre}
                </td>

                <!-- Cantidad -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${e.cantidad}
                </td>

                <td class="px-6 py-4 text-center text-black text-sm tracking-tight font-medium">
                    ${e.nombreLaboratorio}
                </td>

                <!-- Descripcion -->
                <td class="px-6 py-4 justify-center">
                    <div class="flex justify-center">
                        <button type="button" 
                            onclick="openMaterialModal('${e.id}', '${e.descripcion}')" 
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
        `,(e.estado==null||e.estado=="en proceso"||e.estado=="reprogramado")&&(t+=`
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-bold rounded-lg border border-orange-100 uppercase">
                            ${e.estado==null?"Espera":e.estado}
                        </span>
                    </td>
                    <td>
                    </td>
                </tr>
            `),e.estado=="reparado"&&(t+=`
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-green-100 uppercase">
                            ${e.estado}
                        </span>

                        <button data-id='${e.id}' data-estado='recibido' data-inventario='${e.id_inventario}' data-cantidad='${e.cantidad}'
                            class="completar p-2 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98]"
                            title="Guardar cambio">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </td>
                    <td>
                        <div class="flex justify-center">
                            <button data-id='${e.id}' data-estado='reprogramado' class="reportar flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all text-xs font-bold">
                                Reportar
                            </button>
                        </div>
                    </td>
                </tr>
            `)}),l.innerHTML=t}document.addEventListener("click",a=>{const t=a.target.closest(".completar");if(t&&confirm("El reporte ha sido completado ??")){const o=t.dataset.id,r=t.dataset.estado,n=t.dataset.inventario,c=t.dataset.cantidad;x(o,r,n,c),d.value="",i.selectedIndex=0,s()}const e=a.target.closest(".reportar");if(e&&(console.log(e.dataset.id),confirm("El reporte no ha sido completado aun ??"))){const o=e.dataset.id,r=e.dataset.estado;f(o,r),d.value="",i.selectedIndex=0,s()}});async function x(a,t,e,o){const r={id_reporte:a,estado:t,info_usuario:u,id_inventario:e,cantidad:o};try{const n=await fetch(t=="recibido"?"/usuario/encargado/reporte-completado":"/usuario/encargado/actualizar-reportes-materiales",{method:"POST",headers:{"Content-Type":"application/json",Accept:"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(r)}),c=await n.json();n.ok?alert("Reporte actualizado correctamente"):alert(c.error)}catch(n){console.error("Error de conexión:",n)}}async function f(a,t){const e={id_reporte:a,estado:t,info_usuario:u};try{const o=await fetch("/usuario/encargado/actualizar-reportes-materiales",{method:"POST",headers:{"Content-Type":"application/json",Accept:"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(e)}),r=await o.json();o.ok?alert("Reporte actualizado correctamente"):alert(r.error)}catch(o){console.error("Error de conexión:",o)}}setInterval(()=>{s()},5e3);
