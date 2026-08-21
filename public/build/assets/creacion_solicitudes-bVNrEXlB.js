import{b as u}from"./buscador_materiales-CuP23CSm.js";const n=document.getElementById("contenedor-materiales-solicitar"),m=document.getElementById("enviar"),d=document.getElementById("buscador"),s=document.getElementById("id-laboratorio").value,e={},b={id:document.getElementById("id_usuario").value,nombre:document.getElementById("nombre_usuario").value,email:document.getElementById("email").value,grado:document.getElementById("grado").value,grupo:document.getElementById("grupo").value,nombreGrupo:document.getElementById("nombreGrupo").value,turno:document.getElementById("turno").value,idLaboratorio:s,nombreLaboratorio:document.getElementById("nombreLaboratorio").value};document.addEventListener("click",function(a){if(a.target.closest(".tarjeta-material")){if(a.target.dataset.id==null)return;let t=a.target.dataset.id,r=a.target.dataset.nombre,l=a.target.dataset.tipo,c=a.target.dataset.cantidaddisponible;e[t]={id:t,nombre:r,tipo:l,cantidad:1,cantidad_maxima:c},i(e),window.innerWidth<1024&&setTimeout(()=>{openCart()},150)}const o=a.target.closest(".eliminar-material");if(o){const t=o.dataset.ideliminar;console.log("ID a eliminar:",t),delete e[t],i(e)}if(a.target.closest(".operacion")){let t=a.target.dataset.idsum;a.target.dataset.op=="sum"?e[t].cantidad<e[t].cantidad_maxima&&e[t].cantidad++:e[t].cantidad>1&&e[t].cantidad--,i(e)}});function i(a){n.innerHTML="";let o="";for(let t in a)e[t].tipo=="prestamos por unidad"?o+=`
                <div class="p-4 bg-[#F7F6F8] rounded-2xl border border-gray-100 relative group hover:shadow-md hover:border-gray-200 transition-all cursor-default">
                    <button data-ideliminar="${e[t].id}" class="eliminar-material absolute top-3 right-3 text-gray-300 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <p class="text-sm font-bold text-gray-800 pr-6 mb-3">${e[t].nombre}</p>
                    <div class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-xl shadow-sm">
                        <span class="text-sm font-bold text-gray-700">${e[t].cantidad}</span>
                    </div>
                </div>
            `:o+=`
                <div class="p-4 bg-[#F7F6F8] rounded-2xl border border-gray-100 relative group hover:shadow-md hover:border-gray-200 transition-all cursor-default">
                    <button data-ideliminar="${e[t].id}" class="eliminar-material absolute top-3 right-3 text-gray-300 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <p class="text-sm font-bold text-gray-800 pr-6 mb-3">${e[t].nombre}</p>
                    <div class="flex items-center bg-white border border-gray-200 rounded-xl w-fit shadow-sm overflow-hidden">
                        <button data-idsum="${e[t].id}" data-op="res" class="operacion px-3 py-1.5 text-gray-400 hover:bg-gray-50 border-r transition-colors">-</button>
                        <span class="px-5 py-1.5 text-sm font-bold text-gray-700">${e[t].cantidad}</span>
                        <button data-idsum="${e[t].id}" data-op="sum" class="operacion px-3 py-1.5 text-gray-400 hover:bg-gray-50 border-l transition-colors">+</button>
                    </div>
                </div>
            `;n.innerHTML=o}m.addEventListener("click",a=>{if(a.preventDefault(),Object.keys(e).length==0)alert("No puedes realizar una solicitud vacia");else if(confirm("Deseas hacer la solicitud ??")){const t=Object.values(e).map(r=>({id:r.id,nombre:r.nombre,cantidad:r.cantidad}));g(t),n.innerHTML="";for(let r in e)delete e[r];d.value="",u(d.value,s)}});async function g(a){const o={info_usuario:b,info_material:a,fecha:new Date().toISOString().slice(0,19).replace("T"," ")};try{const t=await fetch("/usuario/normal/crear-solicitud",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify(o)}),r=await t.json();t.ok?alert("¡Solicitud guardada con éxito!"):alert(r.error)}catch(t){console.error("Error de conexión:",t)}}async function p(){(await(await fetch(`/usuario/normal/materiales?texto=${d.value}&idLab=${s}`)).json()).forEach(t=>{t.id in e&&(e[t.id]={id:t.id,nombre:t.nombre,tipo:t.tipo,cantidad:Math.min(e[t.id].cantidad,t.cantidad_disponible),cantidad_maxima:t.cantidad_disponible})}),i(e)}setInterval(()=>{p()},5e3);
