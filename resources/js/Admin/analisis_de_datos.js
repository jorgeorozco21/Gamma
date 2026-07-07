"use strict";

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

const opcionesAnalisis = document.getElementById('opciones-analisis');
const opcionesExtra = document.getElementById('opciones-extra');
const seleccionar = document.getElementById('seleccionar');
let datos = {};
let grafica;
let graficaExtra;
let graficaPastel;
let graficaDona;

opcionesAnalisis.addEventListener('change', ()=>{
    if (opcionesAnalisis.value === 'Sin Filtro' || opcionesAnalisis.value === '/admin/analisis-datos/computadoras-inactivas' || opcionesAnalisis.value === '/admin/analisis-datos/distribucion-tipos-usuario' || opcionesAnalisis.value === '/admin/analisis-datos/distribucion-tipos-laboratorios' || opcionesAnalisis.value === '/admin/analisis-datos/distribucion-equipos-computo' || opcionesAnalisis.value === '/admin/analisis-datos/laboratorios-mas-menos-solicitudes' || opcionesAnalisis.value === '/admin/analisis-datos/laboratorios-mas-menos-reportes' || opcionesAnalisis.value === '/admin/analisis-datos/materiales-mas-menos-solicitados'){
        opcionesExtra.classList.add('hidden');
    }else{
        opcionesExtra.innerHTML = "";
        if (opcionesAnalisis.value === '/admin/analisis-datos/errores-computo' || opcionesAnalisis.value === '/admin/analisis-datos/estados-computadoras' || opcionesAnalisis.value === '/admin/analisis-datos/computadoras-mas-fallas') mostrarLaboratoriosComputo();
        else if (opcionesAnalisis.value === '/admin/analisis-datos/distribucion-materiales' || opcionesAnalisis.value === '/admin/analisis-datos/materiales-mas-reportes' || opcionesAnalisis.value === '/admin/analisis-datos/materiales-mas-menos-solicitados-laboratorio') mostrarLaboratoriosPrestamos();
        opcionesExtra.classList.remove('hidden');
    }
});

seleccionar.addEventListener('click', ()=>{
    if (opcionesAnalisis.value === '/admin/analisis-datos/errores-computo'){
        datos = {};

        datos['id'] = opcionesExtra.value;
        datos['url'] = '/admin/analisis-datos/errores-computo';

        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/computadoras-inactivas'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/computadoras-inactivas';

        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/estados-computadoras'){
        datos = {};

        datos['id'] = opcionesExtra.value;
        datos['url'] = '/admin/analisis-datos/estados-computadoras';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/distribucion-materiales'){
        datos = {};

        datos['id'] = opcionesExtra.value;
        datos['url'] = '/admin/analisis-datos/distribucion-materiales';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/materiales-mas-reportes'){
        datos = {};

        datos['id'] = opcionesExtra.value;
        datos['url'] = '/admin/analisis-datos/materiales-mas-reportes';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/distribucion-tipos-usuario'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/distribucion-tipos-usuario';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/distribucion-tipos-laboratorios'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/distribucion-tipos-laboratorios';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/distribucion-equipos-computo'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/distribucion-equipos-computo';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/laboratorios-mas-menos-solicitudes'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/laboratorios-mas-menos-solicitudes';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/laboratorios-mas-menos-reportes'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/laboratorios-mas-menos-reportes';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/materiales-mas-menos-solicitados'){
        datos = {};

        datos['url'] = '/admin/analisis-datos/materiales-mas-menos-solicitados';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/materiales-mas-menos-solicitados-laboratorio'){
        datos = {};

        datos['id'] = opcionesExtra.value;
        datos['url'] = '/admin/analisis-datos/materiales-mas-menos-solicitados-laboratorio';
        obtenerDatosAnalizados();
    }else if (opcionesAnalisis.value === '/admin/analisis-datos/computadoras-mas-fallas'){
        datos = {};

        datos['id'] = opcionesExtra.value;
        datos['url'] = '/admin/analisis-datos/computadoras-mas-fallas';
        obtenerDatosAnalizados();
    }
});

async function mostrarLaboratoriosComputo(){
    const response = await fetch('/admin/analisis-datos/laboratorios-computo');
    const data = await response.json();

    opcionesExtra.innerHTML = '';
    let opciones = '';
    data.forEach(l => {
        opciones += `<option value="${l.id}">${l.nombre}</option>`;
    });

    opcionesExtra.innerHTML = opciones;
}

async function mostrarLaboratoriosPrestamos(){
    const response = await fetch('/admin/analisis-datos/laboratorios-prestamos');
    const data = await response.json();

    opcionesExtra.innerHTML = '';
    let opciones = '';
    data.forEach(l => {
        opciones += `<option value="${l.id}">${l.nombre}</option>`;
    });

    opcionesExtra.innerHTML = opciones;
}

async function obtenerDatosAnalizados(){
    try{
        const respuesta = await fetch(datos['url'],{
            method: 'POST',
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();


        if (grafica){ 
            grafica.destroy(); 
            grafica = null; 
        }
        if (graficaExtra){ 
            graficaExtra.destroy(); 
            graficaExtra = null; 
        }
        if (graficaPastel){ 
            graficaPastel.destroy(); 
            graficaPastel = null; 
        }
        if (graficaDona){ 
            graficaDona.destroy(); 
            graficaDona = null; 
        }

        const contenedores = ['grafica-barras','grafica-pastel','grafica-dona','grafica-barras-extra'];
        contenedores.forEach(id =>{
            const el = document.getElementById(id);
            el.innerHTML = '';
            el.classList.add('hidden');
        });

        if ('dosGraficos' in resultado){
            crearGraficaBarras(resultado.menos);
            crearGraficaBarrasExtra(resultado.mas);
        }else if (resultado.graficos){ 
            if ('barras' in resultado.graficos) crearGraficaBarras(resultado);
            if ('pastel' in resultado.graficos) generarGraficaPastel(resultado);
            if ('dona' in resultado.graficos) generarGraficaDona(resultado);
        }
    }catch (error){
        console.error("Error de conexión o renderizado:", error);
    }
}
function crearGraficaBarras(datos){
    const contenedor = document.getElementById("grafica-barras");
    contenedor.classList.remove('hidden');
    
    const opciones = {
        chart: {
            type: 'bar',
            width: '100%',
            height: 350,
            toolbar: {
                show: true 
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false, 
            }
        },
        series: [{
            name: 'Cantidades',
            data: datos.series
        }],
        xaxis: {
            categories: datos.labels
        },
        colors: [datos.color || '#4A90E2'],
        title: {
            text: datos.graficos.barras,
            align: 'center'
        }
    };

    if (grafica) {
        grafica.updateOptions(opciones);
    } else {
        grafica = new ApexCharts(document.getElementById("grafica-barras"), opciones);
        grafica.render();
    }
}

function crearGraficaBarrasExtra(datos){
    const contenedor = document.getElementById("grafica-barras-extra");
    contenedor.classList.remove('hidden');

    const opciones = {
        chart: {
            type: 'bar',
            width: '100%',
            height: 350,
            toolbar: {
                show: true 
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false, 
            }
        },
        series: [{
            name: 'Cantidades',
            data: datos.series
        }],
        xaxis: {
            categories: datos.labels
        },
        colors: [datos.color || '#4A90E2'],
        title: {
            text: datos.graficos.barras,
            align: 'center'
        }
    };

    if (graficaExtra) {
        graficaExtra.updateOptions(opciones);
    } else {
        graficaExtra = new ApexCharts(document.getElementById("grafica-barras-extra"), opciones);
        graficaExtra.render();
    }
}

function generarGraficaPastel(datos){
    const contenedor = document.getElementById("grafica-pastel");
    contenedor.classList.remove('hidden');

    const opciones = {
        chart: {
            type: 'pie',
            width: '100%',
            height: 350,
            toolbar: {
                show: true 
            }
        },
        series: datos.series, 
        labels: datos.labels, 
        
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        title: {
            text: datos.graficos.pastel,
            align: 'center'
        },
        legend: {
            position: 'bottom' 
        }
    };

    if (graficaPastel) {
        graficaPastel.updateOptions(opciones);
    } else {
        graficaPastel = new ApexCharts(document.getElementById("grafica-pastel"), opciones);
        graficaPastel.render();
    }
}

function generarGraficaDona(datos){
    const contenedor = document.getElementById("grafica-dona");
    contenedor.classList.remove('hidden');

    const opciones = {
        chart: {
            type: 'donut',
            width: '100%',
            height: 350
        },
        series: datos.series,
        labels: datos.labels,
        colors: datos.colors,
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '18px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            offsetY: -10,
                            color: '#373d3f',
                            formatter: function () {
                                return "Total Usuarios"; 
                            }
                        },
                        value: {
                            show: true,
                            fontSize: '24px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 'bold',
                            offsetY: 10,
                            formatter: function () {
                                return datos.total; 
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total Usuarios',
                            color: '#373d3f',
                            fontSize: '16px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            formatter: function () {
                                return datos.total;
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(1) + "%";
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                opacity: 0.45
            }
        },
        legend: {
            position: 'bottom'
        }
    };

    if (graficaDona) {
        graficaDona.updateOptions(opciones);
    } else {
        graficaDona = new ApexCharts(document.getElementById("grafica-dona"), opciones);
        graficaDona.render();
    }
}