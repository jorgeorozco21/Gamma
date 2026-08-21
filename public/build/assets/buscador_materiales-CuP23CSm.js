const s=document.getElementById("buscador"),d=document.getElementById("id-laboratorio").value,i=document.getElementById("contenedor-materiales");async function c(o,t){const a=await(await fetch(`/usuario/normal/materiales?texto=${o}&idLab=${t}`)).json();b(a)}function b(o){i.innerHTML="";let t="";o.forEach(e=>{let a="",l="",n=!0,p=Math.round(e.cantidad_disponible*100/e.cantidad_total);e.cantidad_disponible==0?n=!1:p<=40?(a="#FFEDD5",l="#C2410C"):(a="#DCFCE7",l="#15803D"),n?t+=`
                <div class="flex flex-col gap-2">
                    <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col hover:shadow-md transition-all h-full">
                        <div class="mb-4">
                            <span class="bg-[${a}] text-[${l}] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                                ${e.cantidad_disponible} Disponibles
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 h-10 text-base">${e.nombre}</h3>
                        <p class="text-xs text-gray-500 line-clamp-3 flex-grow leading-relaxed">${e.descripcion}</p>

                        <button data-id="${e.id}" data-nombre="${e.nombre}" data-tipo="${e.tipo}" data-cantidaddisponible="${e.cantidad_disponible}" class="tarjeta-material mt-6 w-full py-2 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors bg-[#7B1FA3] hover:bg-[#6A1B8E] text-white">
                            <span class="text-lg">+</span> Añadir
                        </button>
                    </div>
                </div>
            `:t+=`
                <div class="flex flex-col gap-2">
                    <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm flex flex-col opacity-60 grayscale-[0.5] h-full">
                        <div class="mb-4">
                            <span class="bg-[#FEE9E9] text-[#CA5555] text-[10px] font-bold px-3 py-1 rounded-full tracking-wider">
                                0 Disponibles
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-gray-900 leading-tight mb-2 h-10 text-base">${e.nombre}</h3>
                        <p class="text-xs text-gray-500 line-clamp-3 flex-grow leading-relaxed">${e.descripcion}</p>

                        <button disabled class="mt-6 w-full py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-colors bg-gray-100 text-gray-400 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12"/>
                                <circle cx="12" cy="12" r="9" stroke-width="2"/>
                            </svg>
                            No Disponible
                        </button>
                    </div>
                </div>
            `}),i.innerHTML=t}let r;const x=300;s.addEventListener("input",()=>{clearTimeout(r),r=setTimeout(()=>{c(s.value,d)},x)});setInterval(()=>{c(s.value,d)},5e3);export{c as b};
