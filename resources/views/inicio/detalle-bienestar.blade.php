@extends('template.app-template-veris')
@section('title')
Mi Veris - Bienestar
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script> --}}
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24 label-bienestar text-capitalize"></h5>
    </div>
    <section class="p-0">
        <div class="row g-0 justify-content-center mb-3 d-none">
            <div class="col-auto p-3 d-flex justify-content-between align-items-center" style="min-width: 375px; max-width: 407px;background: #D4E1FC;">
                <div class="box-meta">
                    <div class="w-100 mb-2">
                        Mi meta es: <span class="text-veris-ai">--</span>
                    </div>
                    <div class="btn btn-sm fw-normal fs--1 px-3 py-2 btn-outline-veris-ai text-primary-veris shadow-none bg-white">Registrar</div>
                </div>
                <img src="{{asset('assets/img/svg/sueno.svg')}}" alt="">
            </div>
        </div>
        <div class="row g-0 justify-content-center mt-3">
            <div class="col-auto ps-3 pe-3" style="min-width: 375px; max-width: 407px;">
                <ul class="nav nav-pills justify-content-between bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist" style="border: 1px solid #E7E9EC">
                    
                </ul>
                <div class="my-4 mx-auto calendario text-center d-flex justify-content-center align-items-center">
                    <div class="left-box" type="button">
                        <i class="fa-solid fa-chevron-left text-slver-calendar fs--2"></i>
                    </div>
                    <div class="info-rango text-center mx-2 px-1 fs--1 line-height-16">
                        
                    </div>
                    <div class="right-box" type="button">
                        <i class="fa-solid fa-chevron-right text-slver-calendar fs--2"></i>
                    </div>
                </div>
                <div class="box-graph my-2 text-center">
                    <div class="mx-auto leyend-x-top d-none">
                        <span class="fs--3 line-height-12 fw-normal title-leyend-x-top" style="color:#717C8C;"></span>
                        <p class="fs--1 line-height-16 mb-3 value-leyend-x-top"></p>
                    </div>
                    <canvas id="chBar"></canvas>
                    <div class="mx-auto text-center d-none x-bottom-legend">
                        <i class="fa-solid fa-circle text-veris-ai me-2"></i><span class="fs--1 line-height-16" style="color: #425065">Duración del sueño</span>
                    </div>
                </div>
                <div class="leyenda fs--1 line-height-16" style="color: #425065">
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<style>
    .h-174{
        height: 174px;
    }
    .h-341{
        height: 341px;
    }
    .border-veris-ai{
        border: 1px solid #296BEF;
    }
    .border-silver-ai{
        border: 1px solid #D4E1FC;
    }
    .progress-circle .progress-bar{
        border-color: #FE8360 !important;
        border-width: 10px;
    }
    .progress-circle{
        width: 100px;
        height: 100px;
    }
    .progress-circle:after {
        border: 10px solid #eee;
    }
    .text-slver-calendar{
        color: #A1A7B2;
    }
</style>
<script>
    let local = localStorage.getItem('beneficio-{{ $params }}');
    let datosBienestar = JSON.parse(local);
    var colors = ['#296BEF','#25D02A','#333333','#c3e6cb','#dc3545','#6c757d'];
    let counterRange = 0;
    let chart;
    let diasSemanaArr = ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"];

    document.addEventListener("DOMContentLoaded", async function () {
        $('.label-bienestar').html(datosBienestar.nombre.toLowerCase())
        if(datosBienestar.nemonico == "PASOS"){
            $('#pills-tab').html(`<li class="nav-item flex-fill waves-effect" role="presentation">
                    <button class="nav-link px-8 px-md-5 item-rango active" rango-rel="diario" id="pills-diario-tab" data-bs-toggle="pill" data-bs-target="#pills-diario" type="button" role="tab" aria-controls="pills-diario" aria-selected="true">Diario</button>
                </li>
                <li class="nav-item flex-fill waves-effect" role="presentation">
                    <button class="nav-link px-8 px-md-5 item-rango" rango-rel="mensual" id="pills-mensual-tab" data-bs-toggle="pill" data-bs-target="#pills-mensual" type="button" role="tab" aria-controls="pills-mensual" aria-selected="false">Mensual</button>
                </li>`);
            newRango = obtenerDiaFormateado(counterRange);
            $('.info-rango').html(newRango)
            $('.leyenda').html(`Los pasos son una medición de cuánto te mueves, y pueden ayudarte a identificar cambios en los niveles de actividad.`);
        }else{
            $('#pills-tab').html(`<li class="nav-item flex-fill waves-effect" role="presentation">
                    <button class="nav-link px-8 px-md-5 item-rango active" rango-rel="semanal" id="pills-semanal-tab" data-bs-toggle="pill" data-bs-target="#pills-semanal" type="button" role="tab" aria-controls="pills-semanal" aria-selected="true">Semanal</button>
                </li>
                <li class="nav-item flex-fill waves-effect" role="presentation">
                    <button class="nav-link px-8 px-md-5 item-rango" rango-rel="mensual" id="pills-mensual-tab" data-bs-toggle="pill" data-bs-target="#pills-mensual" type="button" role="tab" aria-controls="pills-mensual" aria-selected="false">Mensual</button>
                </li>`);
            newRango = obtenerSemanaFormateada(counterRange);
            $('.info-rango').html(newRango)
            if(datosBienestar.nemonico == "SUEÑO"){
                $('.leyenda').html(`Los sueños son una medida de cuánto descansas y pueden ayudarte a identificar cambios en tus niveles de energía.`);
            }else if(datosBienestar.nemonico == "FRECUENCIA_CARDIACA"){
                $('.leyenda').html(`Tu corazón late unas 100,000 veces al día, ajustando su ritmo al reposo y al esfuerzo. La frecuencia cardíaca, que mide los latidos por minuto, es un indicador clave de tu salud cardiovascular.`);
            }else if(datosBienestar.nemonico == "CALORIAS_GASTADAS"){
                $('.leyenda').html(`El cuerpo no solo usa energía para los entrenamientos. Verás un estimativo del total de las calorías que quemas, tanto cuando estás en actividad como en reposo.`);
            }
        }
        await cargarDatos();

        $(document).on('click', '.item-rango', async function(){
            let rango = $('.item-rango.active').attr('rango-rel');
            counterRange = 0;
            if(rango == "semanal"){
                newRango = obtenerSemanaFormateada(counterRange);
            }else if(rango == "mensual"){
                newRango = obtenerMesFormateado(counterRange);
            }else{
                newRango = obtenerDiaFormateado(counterRange);
            }

            $('.info-rango').html(newRango)
            await cargarDatos();
        });

        $(document).on('click', '.left-box', async function(){
            let rango = $('.item-rango.active').attr('rango-rel');
            let newRango;
            counterRange--;
            if(rango == "semanal"){
                newRango = obtenerSemanaFormateada(counterRange);
            }else if(rango == "mensual"){
                newRango = obtenerMesFormateado(counterRange);
            }else{
                newRango = obtenerDiaFormateado(counterRange);
            }

            $('.info-rango').html(newRango)
            await cargarDatos();
        });

        $(document).on('click', '.right-box', async function(){
            let rango = $('.item-rango.active').attr('rango-rel');
            let newRango;
            counterRange++;
            if(rango == "semanal"){
                newRango = obtenerSemanaFormateada(counterRange);
            }else if(rango == "mensual"){
                newRango = obtenerMesFormateado(counterRange);
            }else{
                newRango = obtenerDiaFormateado(counterRange);
            }

            $('.info-rango').html(newRango)
            await cargarDatos();
        });

    });

    function getDayRange(){
        const hoy = new Date();
        // Ajustamos la fecha en base a counterRange
        hoy.setDate(hoy.getDate() + counterRange);

        const dia = String(hoy.getDate()).padStart(2, '0');
        const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // +1 porque enero es 0
        const anio = hoy.getFullYear();

        const fechaFormateada = `${dia}/${mes}/${anio}`;
        return fechaFormateada;
    }

    function getWeekRange() {
        const hoy = new Date();

        // Encontrar el lunes de la semana actual
        const dia = hoy.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado
        const diferenciaALunes = (dia === 0 ? -6 : 1) - dia;

        const lunes = new Date(hoy);
        lunes.setDate(hoy.getDate() + diferenciaALunes + (counterRange * 7));

        // Formato dd/mm/yyyy
        const diaStr = String(lunes.getDate()).padStart(2, '0');
        const mesStr = String(lunes.getMonth() + 1).padStart(2, '0');
        const anio = lunes.getFullYear();

        return `${diaStr}/${mesStr}/${anio}`;
    }


    function getMonthRange() {
        const hoy = new Date();

        // Ajustamos el mes en base a counterRange
        hoy.setMonth(hoy.getMonth() + counterRange);

        // Establecer al primer día del mes
        hoy.setDate(1);

        const dia = String(hoy.getDate()).padStart(2, '0');
        const mes = String(hoy.getMonth() + 1).padStart(2, '0');
        const anio = hoy.getFullYear();

        return `${dia}/${mes}/${anio}`; // dd/mm/yyyy
    }


    function obtenerSemanaActualFormateada(fechaReferencia = new Date()) {
        const diasSemana = ['dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb'];
        const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

        // Ajusta la fecha para que el lunes sea el primer día de la semana
        const dia = fechaReferencia.getDay();
        const diff = fechaReferencia.getDate() - dia + (dia === 0 ? -6 : 1); // Lunes
        const lunes = new Date(fechaReferencia.setDate(diff));
        const domingo = new Date(lunes);
        domingo.setDate(lunes.getDate() + 6);

        const diaInicio = lunes.getDate();
        const mesInicio = meses[lunes.getMonth()];
        const diaFin = domingo.getDate();
        const mesFin = meses[domingo.getMonth()];
        const anio = lunes.getFullYear();

        return `${diaInicio} de ${mesInicio} - ${diaFin} ${mesFin} del ${anio}`;
    }

    function obtenerSemanaFormateada(offsetSemanas = 0) {
        const hoy = new Date();
        hoy.setDate(hoy.getDate() + offsetSemanas * 7);
        return obtenerSemanaActualFormateada(hoy);
    }

    function obtenerMesFormateado(offsetMeses = 0) {
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        const fecha = new Date();
        fecha.setMonth(fecha.getMonth() + offsetMeses);

        const anio = fecha.getFullYear();
        const mes = fecha.getMonth();

        // Primer día del mes
        const primerDia = new Date(anio, mes, 1);
        // Último día del mes
        const ultimoDia = new Date(anio, mes + 1, 0);

        const diaInicio = primerDia.getDate();
        const mesInicio = meses[mes];
        const diaFin = ultimoDia.getDate();
        const mesFin = meses[mes];

        return `${mesInicio}, ${anio}`;
    }

    function obtenerDiaFormateado() {
        const hoy = new Date();

        // Ajustamos la fecha en base a counterRange
        hoy.setDate(hoy.getDate() + counterRange);

        const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        const mesesCortos = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

        const diaSemana = diasSemana[hoy.getDay()];
        const dia = hoy.getDate(); // sin padStart porque no necesitas 0 delante
        const mes = mesesCortos[hoy.getMonth()];
        const anio = hoy.getFullYear();

        return `${diaSemana}, ${dia} de ${mes} de ${anio}`;
    }

    async function cargarDatos(){
        if(chart !== undefined){
            chart.destroy();
        }
        
        // https://api.phantomx.com.ec/digitales/v1/fit/indicadores/3/paciente/1400780076/diario?fecha=21/07/2025
        let fecha;
        let rango = $('.item-rango.active').attr('rango-rel');
        if(rango == "semanal"){
            fecha = getWeekRange();
        }else if(rango == "mensual"){
            fecha = getMonthRange();
        }else{
            fecha = getDayRange();
        }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/fit/indicadores/${datosBienestar.id}/paciente/{{ Session::get('userData')->numeroIdentificacion }}/${rango}?fecha=${fecha}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            drawChart(data.data, rango);
        }
    }

    function getLabelYTop(){
        if(datosBienestar.nemonico == "PASOS"){
            return {
                label: 'Pasos',
                unit: ''
            };
        }else if(datosBienestar.nemonico == "SUEÑO"){
            return {
                label: 'Duración del sueño',
                unit: 'h'
            };
        }else if(datosBienestar.nemonico == "FRECUENCIA_CARDIACA"){
            return {
                label: '',
                unit: ''
            };
        }else if(datosBienestar.nemonico == "CALORIAS_GASTADAS"){
            return {
                label: '',
                unit: 'h'
            };
        }
    }

    async function drawChart(data, rango){
        let labels = [];
        let dataSet = [];
        let colorsBar = [];
        let optX;
        let labelYTop = getLabelYTop();

        if(rango == "semanal"){
            $('.x-bottom-legend').addClass('d-none')
            labels = diasSemanaArr;
            $.each(data.valores, function(key,value){
                dataSet.push(value.valorNumerico);
                let color = colors[0];
                if(value.metaAlcanzada){
                    color = colors[1];
                }
                colorsBar.push(color);
            })
            optX = {
                grid: { display: false },
            }
        }else if(rango == "mensual"){
            if(datosBienestar.nemonico == "SUEÑO"){
                $('.x-bottom-legend').removeClass('d-none')
            }
            $.each(data.valores, function(key,value){
                labels.push(value.fecha)
                dataSet.push(value.valorNumerico);
                let color = colors[0];
                if(value.metaAlcanzada){
                    color = colors[1];
                }
                colorsBar.push(color);
            })
            optX = {
                grid: { display: false },
                title: { display: false },
                ticks: { display: false },
            }
        }else{
            $.each(data.valores, function(key,value){
                labels.push(value.hora)
                dataSet.push(value.valorNumerico);
                let color = colors[0];
                if(value.metaAlcanzada){
                    color = colors[1];
                }
                colorsBar.push(color);
            })
            optX = {
                grid: { display: false },
            }
        }

        console.log(data.valores)
        console.log(dataSet)

        var todosCero = dataSet.every(valor => valor === 0);
        var yMax = todosCero ? 8 : undefined;

        var chBar = document.getElementById("chBar");
        chart = new Chart(chBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: dataSet,
                    backgroundColor: colorsBar,
                    barThickness: 5
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: labelYTop.label,
                        align: 'start', // Alineado a la izquierda
                        padding: {
                            top: 10,
                            bottom: 20
                        },
                        font: {
                            size: 12,
                            weight: 'normal'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: optX,
                    y: {
                        min: 0,
                        max: yMax,
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return value + labelYTop.unit;
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush