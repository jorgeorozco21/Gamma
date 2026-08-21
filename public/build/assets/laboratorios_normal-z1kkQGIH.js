const d=document.getElementById("info-buscador").value,a=document.getElementById("buscador"),n=JSON.parse(d),r=document.getElementById("contenedor-tarjetas");function i(){let t="";a.value!=""?t=n.filter(o=>{const e=o.nombre.toLowerCase(),l=a.value.toLowerCase();return e.includes(l)}):t=n,c(t)}function c(t){r.innerHTML="";let o="";t.forEach(e=>{o+=`
            <a href="${e.tipo=="prestamos"?`/usuario/normal/laboratorios/${e.id}-laboratorio-normal`:`/usuario/normal/laboratorios/${e.id}-laboratorio-computo`}" class="flex flex-col gap-2 cursor-pointer">
                <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md transition-all h-full">
                    <div class="mb-4">
                        <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                            ${e.tipo}
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-900 text-base leading-tight">
                        ${e.nombre}
                    </h3>
                </div>
            </a>
        `}),r.innerHTML=o}let s;const u=300;a.addEventListener("input",()=>{clearTimeout(s),s=setTimeout(()=>{i()},u)});
