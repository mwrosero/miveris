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
        <div class="row g-0 justify-content-center mb-3">
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
        <div class="row g-0 justify-content-center">
            <div class="col-auto ps-3 pe-3" style="min-width: 375px; max-width: 407px;">
                <ul class="nav nav-pills justify-content-between bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist" style="border: 1px solid #E7E9EC">
                    <li class="nav-item flex-fill waves-effect" role="presentation">
                        <button class="nav-link px-8 px-md-5 active" id="pills-semanal-tab" data-bs-toggle="pill" data-bs-target="#pills-semanal" type="button" role="tab" aria-controls="pills-semanal" aria-selected="true">Semanal</button>
                    </li>
                    <li class="nav-item flex-fill waves-effect" role="presentation">
                        <button class="nav-link px-8 px-md-5" id="pills-mensual-tab" data-bs-toggle="pill" data-bs-target="#pills-mensual" type="button" role="tab" aria-controls="pills-mensual" aria-selected="false">Mensual</button>
                    </li>
                </ul>
                <div class="my-4 mx-auto calendario text-center d-flex justify-content-center align-items-center">
                    <div class="left-box" type="button">
                        <i class="fa-solid fa-chevron-left text-slver-calendar fs--2"></i>
                    </div>
                    <div class="info-rango text-center mx-2 px-1 fs--1 line-height-16">
                        30 de ene - 6 feb del 2025
                    </div>
                    <div class="right-box" type="button">
                        <i class="fa-solid fa-chevron-right text-slver-calendar fs--2"></i>
                    </div>
                </div>
                <div class="box-graph my-2 text-center">
                    <div class="mx-auto">
                        <span class="fs--3 line-height-12 fw-normal" style="color:#717C8C;">Promedio</span>
                        <p class="fs--1 line-height-16 mb-3">831 kcal</p>
                    </div>
                    <canvas id="chBar"></canvas>
                </div>
                <div class="leyenda fs--1 line-height-16" style="color: #425065">
                    Los sueños son una medida de cuánto descansas y pueden ayudarte a identificar cambios en tus niveles de energía.
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
    var colors = ['#007bff','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];

    document.addEventListener("DOMContentLoaded", async function () {
        await cargarDatos();
        var chBar = document.getElementById("chBar");
        new Chart(chBar, {
            type: 'bar',
            data: {
                labels: ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                datasets: [{
                    data: [59, 45, 83, 53, 69, 92, 34],
                    backgroundColor: colors[0],
                    barThickness: 5
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Quita las líneas verticales
                        }
                    }
                }
            }
        });

        $('.label-bienestar').html(datosBienestar.nombre.toLowerCase())

        $(document).on('click', '.bienestar-item', function(){
            let tipo = $(this).attr('tipo-rel');
            let beneficioSeleccionado = $.grep(datosBienestar, function(item) {
                return item.nemonico === tipo;
            });
            console.log(beneficioSeleccionado[0]);
            
            localStorage.setItem('beneficio-{{ $tokenCita }}', JSON.stringify(beneficioSeleccionado[0]));
            location.href = '/detalle-bienestar/{{ $tokenCita }}';
        });

    });

    function getCurrentDate(){
        const hoy = new Date();
        const dia = String(hoy.getDate()).padStart(2, '0');
        const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // +1 porque enero es 0
        const anio = hoy.getFullYear();
        const fechaFormateada = `${dia}/${mes}/${anio}`;
        return fechaFormateada;
    }

    async function cargarDatos(){
        // https://api.phantomx.com.ec/digitales/v1/fit/indicadores/3/paciente/1400780076/diario?fecha=21/07/2025
        let rango = 'semanal';
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/fit/indicadores/${datosBienestar.id}/paciente/{{ Session::get('userData')->numeroIdentificacion }}/${rango}?fecha=${getCurrentDate()}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
    }
    
    async function obtenerInfoIndicadores() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/fit/indicadores/paciente/{{ Session::get('userData')->numeroIdentificacion }}`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data);
        let elem = ``
        if (data.code == 200) {
            datosBienestar = data.data;
            $.each(data.data, function(key, value){
                switch(value.nemonico){
                    case "PASOS":
                        $('#infoPasos').html(`<div class="progress-circle my-auto mx-auto" data-percentage="${value.valorTotal}">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div class="text-white">
                                    <span class="fs--1 line-height-16 label_pasos"></span>
                                    <p class="fw-medium fs--3 mb-0 label_pasos_abreviatura"></p>
                                </div>
                            </div>
                        </div>`);
                        setTimeout(function(){
                            $('.label_pasos').html(value.valorTotal);
                            $('.label_pasos_abreviatura').html(value.abreviaturaMedida);
                        }, 500);
                        //$('.').html()
                    break;
                    case "FRECUENCIA_CARDIACA":
                        $('.label_frecuencia').html(value.valorTotal);
                        $('.label_frecuencia_abreviatura').html(value.abreviaturaMedida);
                    break;
                    case "CALORIAS_GASTADAS":
                        $('.label_calorias').html(value.valorTotal);
                        $('.label_calorias_abreviatura').html(value.abreviaturaMedida);
                    break;
                    case "SUEÑO":
                        $('.label_horas').html(value.valorTotal);
                        $('.label_horas_abreviatura').html(value.abreviaturaMedida);
                    break;
                }
            })
        }
            
        return data;
    }

</script>
@endpush