@extends('template.app-template-veris')
@section('title')
Mi Veris - Bienestar
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
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
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Bienestar') }}</h5>
    </div>
    <section class="p-3 mb-3 bg-white">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-6">
                                {{-- row-cols-1 row-cols-md-2 row-cols-lg-3  --}}
                                <div class="row g-3">
                                    <!-- Water Intake Card -->
                                    <div class="col-12 h-174 d-none">
                                        <div class="card h-100">
                                            <div class="card-header d-flex align-items-center">
                                                <div class="icon-circle bg-water me-3">
                                                    <i class="bi bi-droplet-fill text-primary"></i>
                                                </div>
                                                Water Intake
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title">1.5L / 2L</h3>
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <p class="card-text mt-2">75% of daily goal</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Steps Card -->
                                    <div type="button" class="col-12 h-174 bienestar-item" tipo-rel="PASOS">
                                        <div class="card h-100 waves-effect border-silver-ai bg-veris-ai">
                                            <div class="card-header d-flex align-items-center text-white fs-18 line-height-24 fw-medium p-3">
                                                Pasos
                                            </div>
                                            <div class="card-body px-3" id="infoPasos">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sleep Card -->
                                    <div type="button" class="col-12 h-174 bienestar-item" tipo-rel="SUEÑO">
                                        <div class="card h-100 waves-effect border-veris-ai" style="background: url({{asset('assets/img/svg/zzz.svg')}}) no-repeat top right;background-size: 40%;background-position: 102% -5px;">
                                            <div class="card-header d-flex align-items-center text-veris-ai fs-18 line-height-24 fw-medium p-3">
                                                Sueño
                                            </div>
                                            <div class="card-body p-3 mt-auto d-flex align-items-end">
                                                <div>
                                                    <h3 class="fs--20 fw-medium line-height-32 text-veris-ai mb-0 label_horas"></h3>
                                                    <p class="fs--1 line-height-16 mb-0 fw-normal label_horas_abreviatura"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row g-3">
                                    <!-- Calories Burned Card -->
                                    <div type="button" class="col-12 h-174 bienestar-item" tipo-rel="CALORIAS_GASTADAS">
                                        <div class="card h-100 waves-effect border-silver-ai" style="background: #296BEF url({{asset('assets/img/svg/calorias.svg')}}) no-repeat bottom right;background-size: 40%;">
                                            <div class="card-header d-flex align-items-center text-white fs-18 line-height-24 fw-medium p-3">
                                                Calorías
                                            </div>
                                            <div class="card-body p-3 mt-auto d-flex align-items-end">
                                                <div class="mt-5">
                                                    <h3 class="fs--20 fw-medium line-height-32 mb-0 text-white label_calorias">--</h3>
                                                    <p class="fs--1 line-height-16 mb-0 fw-normal text-white label_calorias_abreviatura"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Heart Rate Card -->
                                    <div type="button" class="col-12 h-174 bienestar-item" tipo-rel="FRECUENCIA_CARDIACA">
                                        <div class="card h-100 waves-effect border-veris-ai" style="background: url({{asset('assets/img/svg/bg-latido-fliped.png')}}) no-repeat bottom center;background-size: cover;    background-position-y: 30px;">
                                            <div class="card-header d-flex align-items-center text-veris-ai fs-18 line-height-24 fw-medium p-3">
                                                Latidos
                                            </div>
                                            <div class="card-body p-3 mt-auto d-flex align-items-end">
                                                <div>
                                                    <h3 class="fs--20 fw-medium line-height-32 text-veris-ai mb-0 label_frecuencia"></h3>
                                                    <p class="fs--1 line-height-16 mb-0 fw-normal label_frecuencia_abreviatura"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
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
</style>
<script>
    let dataCita = {};
    let datosBienestar;

    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerInfoIndicadores();


        $(document).on('click', '.bienestar-item', async function(){
            let tipo = $(this).attr('tipo-rel');
            let beneficioSeleccionado = $.grep(datosBienestar, function(item) {
                return item.nemonico === tipo;
            });
            console.log(beneficioSeleccionado[0]);
            
            localStorage.setItem('beneficio-{{ $tokenCita }}', JSON.stringify(beneficioSeleccionado[0]));
            location.href = '/detalle-bienestar/{{ $tokenCita }}';
        });

    });

    
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
                        let porcentaje = 0;
                        if(value.meta !== null){
                            let meta = parseInt(value.meta.valor);
                            let valor = value.valorTotal;
                            porcentaje = (valor / meta) * 100;
                        }

                        // Redondeo al múltiplo de 10 más cercano
                        let porcentajeFinal = Math.round(porcentaje / 10) * 10;
                        $('#infoPasos').html(`<div class="progress-circle my-auto mx-auto" data-percentage="${porcentajeFinal}">
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