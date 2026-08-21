const u=document.getElementById("contenedor-solicitudes"),c=document.getElementById("buscador"),l=document.getElementById("filtro"),g={id:document.getElementById("id_usuario").value,nombre:document.getElementById("nombre").value,email:document.getElementById("email").value};document.addEventListener("click",function(o){const n=o.target.closest(".cambiar");if(n){const t=n.dataset.id,e=n.dataset.estado;confirm("Deseas cambiar el estado de la solicitud ??")&&(h(t,e),c.value="",l.selectedIndex=0,s())}});async function h(o,n){const t={id_solicitud:o,info_usuario:g,estado:n};try{const e=await fetch("/usuario/encargado/actualizar-solicitudes",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(t)}),a=await e.json();e.ok?alert("Solicitud actualizada correctamente"):alert(a.error)}catch(e){console.error("Error de conexión:",e)}}function x(o){u.innerHTML="";let n="";o.forEach(t=>{const e=JSON.parse(t.info_usuario),a=JSON.parse(t.info_material),E=JSON.stringify(a).replace(/"/g,"&quot;"),v=new Date(t.fecha).toLocaleDateString("es-ES",{day:"2-digit",month:"2-digit",year:"numeric"});n+=`
            <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-6 py-4">
                    <!-- Nombre, Correo y Grado/Grupo -->
                    <div class="flex items-center gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate">${e.nombre}</p>
                            <p class="text-[10px] text-gray-400 font-medium">${e.email}</p>
                            <p class="text-[10px] text-gray-400 font-medium">${e.grado}° ${e.grupo} - ${e.nombreGrupo} - ${e.turno}</p>
                        </div>
                    </div>
                </td>

                <!-- ID de la Solicitud -->
                <td class="px-6 py-4 text-sm text-black text-center font-medium">
                    ${t.id}
                </td>

                <!-- Laboratorio -->
                <td class="px-6 py-4 text-center text-black text-sm font-medium tracking-tight">
                    ${e.nombreLaboratorio}
                </td>

                <!-- Lista de Materiales-->
                <td class="px-6 py-4">
                    <div class="flex justify-center">
                        <button type="button" onclick="openMaterialModal(${t.id},${E})" 
                            class="flex items-center gap-2 text-[#7B1FA3] hover:text-white">
                            <div class="p-1.5 bg-purple-100 hover:bg-[#7B1FA3] rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </td>

                <!-- Fecha -->
                <td class="px-6 py-4 text-sm text-gray-500 text-center">
                    ${v}
                </td>

                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center">
                        <span class="px-3 py-1 text-[10px] bg-green-50 text-green-600 font-bold rounded-lg border border-green-100 uppercase">
                            ${t.estado}
                        </span>
                    </div>
                </td>

                <!-- Estado de la Solicitud -->
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center">
                        <!-- Select de Estados -->
                        <span class="px-3 py-1 text-[10px] bg-orange-50 text-orange-600 font-bold rounded-lg border border-orange-100 uppercase">
                            ${t.estado=="aceptada"?"En Prestamo":"Recibido"}
                        </span>

                        <!-- Boton de Guardar -->
                        <button type="submit" data-estado="${t.estado=="aceptada"?"en prestamo":"recibido"}" data-id="${t.id}"
                            class="cambiar px-3 py-1 bg-[#7B1FA3] text-white rounded-xl hover:bg-[#6A1B8E] transition-all shadow-lg shadow-purple-100 active:scale-[0.98] ml-2"
                            title="Guardar cambio">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `}),u.innerHTML=n}async function s(){const n=await(await fetch(`/api/usuario/encargado/solicitudes-aceptadas?texto=${c.value}&filtro=${l.value}`)).json();x(n)}let p;const B=300;c.addEventListener("input",()=>{clearTimeout(p),p=setTimeout(()=>{s()},B)});l.addEventListener("change",()=>{s()});const I=document.getElementById("abrir-modal"),L=document.getElementById("cerrar-modal-reporte"),M=document.getElementById("boton-buscar"),$=document.getElementById("boton-seleccionar"),m=document.getElementById("enviar-reporte");let i,d=1,r,y,f;I.addEventListener("click",function(){k()});async function k(){const n=await(await fetch("/api/solicitudes-en-prestamo")).json(),t=document.getElementById("opciones-solicitudes");t.innerHTML="",n.forEach(a=>{t.innerHTML+=`
            <option value="${a.id}">${a.id}</option>
        `}),document.getElementById("material-modal-reporte").classList.remove("hidden"),document.body.classList.add("overflow-hidden")}function b(){d=1,document.getElementById("mas").classList.add("hidden"),document.getElementById("menos").classList.add("hidden"),document.getElementById("cantidad").innerHTML="",document.getElementById("cantidad-reportar").innerHTML="",document.getElementById("descripcion").value="",document.getElementById("descripcion").disabled=!0,document.getElementById("opciones-solicitudes").innerHTML="",document.getElementById("opciones-materiales-reportar").disabled=!0,document.getElementById("opciones-materiales-reportar").innerHTML="",m.disabled=!0,document.getElementById("material-modal-reporte").classList.add("hidden"),document.body.classList.remove("overflow-hidden")}L.addEventListener("click",function(){b()});M.addEventListener("click",function(){w(document.getElementById("opciones-solicitudes").value)});async function w(o){const t=await(await fetch(`/api/info-materiales-solicitud-prestamo?id=${o}`)).json();y=o,i=JSON.parse(t.info_material);const e=document.getElementById("opciones-materiales-reportar");e.innerHTML="",i.forEach(a=>{e.innerHTML+=`
            <option value="${a.nombre}">${a.nombre}</option>
        `}),e.disabled=!1}$.addEventListener("click",function(){const o=i.find(n=>n.nombre==document.getElementById("opciones-materiales-reportar").value);r=o.cantidad,f=o.id,r==1?(document.getElementById("mas").classList.add("hidden"),document.getElementById("menos").classList.add("hidden")):(document.getElementById("mas").classList.remove("hidden"),document.getElementById("menos").classList.remove("hidden")),document.getElementById("cantidad-reportar").innerHTML=" 1 ",d=1,document.getElementById("cantidad").innerHTML=` ${r} `,document.getElementById("descripcion").disabled=!1,document.getElementById("descripcion").value="",m.disabled=!1});document.getElementById("mas").addEventListener("click",function(){d<r&&(d++,document.getElementById("cantidad-reportar").innerHTML=` ${d} `)});document.getElementById("menos").addEventListener("click",function(){d>1&&(d--,document.getElementById("cantidad-reportar").innerHTML=` ${d} `)});m.addEventListener("click",function(){document.getElementById("descripcion").value==""?alert("No puedes generar un reporte sin descripcion"):confirm("Deseas generar el reporte ??")&&(S(),c.value="",l.selectedIndex=0,s(),b())});async function S(){const o=document.getElementById("opciones-materiales-reportar").value,n=i.findIndex(e=>e.nombre==o);i[n].cantidad=r-d,i=i.filter(e=>e.cantidad>0);const t={id:y,info_usuario:g,info_material:i,id_inventario:f,descripcion:document.getElementById("descripcion").value,cantidad:d};try{const e=await fetch("/creacion-reporte-material",{method:"POST",headers:{"Content-Type":"application/json",Accept:"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(t)}),a=await e.json();e.ok?alert("Reporte generado correctamente"):alert(a.error)}catch(e){console.error("Error de conexión:",e)}}setInterval(()=>{s()},5e3);
