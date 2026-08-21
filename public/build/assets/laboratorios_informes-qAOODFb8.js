const i=document.getElementById("contenedor-tarjetas"),n=document.getElementById("buscador"),r=document.getElementById("filtrar-tipo");async function s(){const e=await(await fetch(`/api/laboratorios?texto=${n.value}&tipo=${r.value}`)).json();i.innerHTML=l(e)}let a;const d=300;n.addEventListener("input",()=>{clearTimeout(a),a=setTimeout(()=>{s()},d)});function l(o){let e="";return o.forEach(t=>{e+=`
            <a href="/admin/informes/laboratorios/${t.id}-${t.tipo=="prestamos"?"laboratorio-normal":"laboratorio-computo/computadoras"}" class="flex flex-col gap-2 cursor-pointer">
                <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md transition-all h-full">
                    <!-- Tipo de laboratorio -->
                    <div class="mb-4">
                        <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider uppercase">
                            ${t.tipo}
                        </span>
                    </div>

                    <!-- Nombre -->
                    <h3 class="font-bold text-gray-900 text-base leading-tight">
                        ${t.nombre}
                    </h3>
                </div>
            </a>
        `}),e}r.addEventListener("change",()=>{s()});
