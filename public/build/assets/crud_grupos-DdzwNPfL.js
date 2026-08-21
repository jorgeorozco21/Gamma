const v=document.getElementById("agregar-laboratorio"),i=document.getElementById("laboratorios"),I=document.getElementById("cerrar-modal");let a={};v.addEventListener("click",()=>{const e=i.options[i.selectedIndex].text,t=i.value;a[e]=t,d(document.getElementById("laboratorios-agregados"),document.getElementById("inf-laboratorios"),a)});function d(e,t,o){e.innerHTML="";let r="",y=Object.keys(o).length,m=0;for(let n in o)m<y-1?r+=o[n].toString()+",":r+=o[n].toString(),e.innerHTML+=`
            <div class="group flex items-center justify-between p-1 mb-2.5 bg-white hover:bg-[#F5F3FF] border-l-4 border-[#7B1FA3] rounded-r-xl border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-[#7B1FA3] transition-colors truncate">
                            ${n}
                        </p>
                    </div>
                </div>
                <button type="button" class="eliminar-laboratorio shrink-0 p-1.5 ml-2 text-gray-400 hover:text-red-600 transition-all active:scale-95" 
                        data-clave="${n}" title="Eliminar">
                    ✕
                </button>
            </div>
        `,m++;t.value=r,document.querySelectorAll(".eliminar-laboratorio").forEach(n=>{n.addEventListener("click",()=>{const E=n.dataset.clave;delete a[E],d(e,t,a)})})}function c(){a={}}I.addEventListener("click",()=>{document.getElementById("nombre").value="",document.getElementById("grado").value="",document.getElementById("grupo").value="",document.getElementById("truno").selectedIndex=0,document.getElementById("laboratorios").selectedIndex=0,document.getElementById("laboratorios-agregados").innerHTML="",c()});const u=document.getElementById("modal-laboratorios"),B=document.getElementById("cerrar-modal-laboratorios"),l=document.getElementById("contenido-modal-laboratorios");document.addEventListener("click",function(e){const t=e.target.closest(".ver");if(t){u.classList.remove("hidden");let o=t.dataset.laboratorios;p(o)}});async function g(e){return await(await fetch(`/api/grupos/laboratorio?id=${e}`)).json()}async function p(e){if(l.innerHTML="",!e){l.innerHTML="Sin laboratorios";return}const t=await g(e);let o="<ul>";t.forEach(r=>{o+=`
            <li class="group flex items-center justify-between p-3.5 mb-2.5 bg-white hover:bg-[#F5F3FF] border-l-4 border-[#7B1FA3] rounded-r-xl border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-[#7B1FA3] transition-colors truncate">
                            ${r.nombre}
                        </p>
                    </div>
                </div>
            </li>
        `}),o+="</ul>",l.innerHTML=o}B.addEventListener("click",()=>{u.classList.add("hidden")});const b=document.getElementById("modal-edit"),f=document.getElementById("cerrar-modal-edit");document.addEventListener("click",function(e){const t=e.target.closest(".abrir-modal-edit");if(t){b.style.display="flex";let o=t.dataset.id;c(),x(o)}});f.addEventListener("click",()=>{b.style.display="none",document.getElementById("formulario-editar").action="",document.getElementById("nombre-edit").value="",document.getElementById("grado-edit").value="",document.getElementById("grupo-edit").value="",document.getElementById("turno-edit").selectedIndex=0,document.getElementById("inf-laboratorios-edit").value="",document.getElementById("laboratorios-edit").selectedIndex=0,document.getElementById("laboratorios-agregados-edit").innerHTML="",c()});const L=document.getElementById("agregar-laboratorio-edit"),s=document.getElementById("laboratorios-edit");L.addEventListener("click",()=>{const e=s.options[s.selectedIndex].text,t=s.value;a[e]=t,d(document.getElementById("laboratorios-agregados-edit"),document.getElementById("inf-laboratorios-edit"),a)});async function x(e){const t=await fetch(`/api/grupos/editar?id=${e}`),o=await t.json(t);h(o)}async function h(e){document.getElementById("formulario-editar").action=`/admin/grupos/${e.id}`,document.getElementById("nombre-edit").value=e.nombre,document.getElementById("grado-edit").value=e.grado,document.getElementById("grupo-edit").value=e.grupo,document.getElementById("inf-laboratorios-edit").value=e.laboratorios,e.turno==="Matutino"?document.getElementById("turno-edit").selectedIndex=0:e.turno==="Vespertino"&&(document.getElementById("turno-edit").selectedIndex=1),(await g(e.id)).forEach(o=>{a[o.nombre]=o.id_laboratorio}),d(document.getElementById("laboratorios-agregados-edit"),document.getElementById("inf-laboratorios-edit"),a)}
