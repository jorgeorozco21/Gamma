const n=document.getElementById("buscador"),s=document.getElementById("id-laboratorio").value,o=document.getElementById("contenedor-tarjetas");async function d(){const t=await(await fetch(`/api/usuario/normal/laboratorios/buscador-computadora?texto=${n.value}&id=${s}`)).json();i(t)}function i(a){o.innerHTML="";let t="";a.forEach(e=>{t+=`
            <div data-id="${e.id}" data-numerocomputadora="${e.numero_computadora}" class="tarjeta bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md transition-all duration-300 h-full cursor-pointer">
                <!-- Cantidad de Reportes -->
                <div class="mb-4">
                    <span class="bg-[#E0E7FF] text-[#3730A3] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                        ${e.cantidad_reportes} Reportes
                    </span>
                </div>

                <!-- Nombre de Computadora -->
                <h3 class="font-bold text-gray-900 text-base leading-tight">
                    ${e.numero_computadora}
                </h3>
            </div>
        `}),o.innerHTML=t}let r;const c=300;n.addEventListener("input",()=>{clearTimeout(r),r=setTimeout(()=>{d()},c)});setInterval(()=>{d()},5e3);export{d as b};
