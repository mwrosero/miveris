@extends('template.app-template-veris')
@section('title')
Mi Veris - Registrar Meta
@endsection
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>

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
        <div class="row g-0 justify-content-center mt-3">
            <div class="col-auto ps-3 pe-3" style="min-width: 375px; max-width: 407px;">
                <img class="img-banner-indicador" src="" alt="">
                <div class="w-100 py-2 px-3 fw-medium fs-18 line-height-24" style="background: #E9EFF4;color: #0A2240;">
                    Registrar meta
                </div>
                <div class="w-100 mt-3">
                    <label for="valorMeta" class="form-label fw-medium fs--1">Meta de pasos *</label>
                    <select class="form-select fs--1 p-3" name="valorMeta" id="valorMeta" required>
                    </select>
                </div>
                <button class="btn btn-primary-veris rounded-3 fs--18 line-height-24 w-100 px-4 py-3 text-white w-100 mt-5" id="btnGuardar">Guardar</button>
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
    let local = localStorage.getItem('beneficio-{{ $params }}');
    let datosBienestar = JSON.parse(local);

    document.addEventListener("DOMContentLoaded", async function () {
        if(datosBienestar.nemonico == "PASOS" || datosBienestar.nemonico == "SUEÑO"){
            let imgUrl = "{{asset('assets/img/svg/sueno.svg')}}";
            if(datosBienestar.nemonico == "PASOS"){
                imgUrl = "{{asset('assets/img/svg/banner-pasos.svg')}}";
            }
            $('.img-banner-indicador').attr('src', imgUrl);
        }
        await getMetas();

        $(document).on('click', '#btnGuardar', async function(){
            await guardarMeta();
        });

    });

    async function guardarMeta(){
        let valor = $('#valorMeta option:selected').val();
        let valorStr = $('#valorMeta option:selected').html();
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/fit/pacientes/{{ Session::get('userData')->numeroIdentificacion }}/meta`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            idMetaIndicador: valor
        });

        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            datosBienestar.meta = {
                "id": valor,
                "descripcion": null,
                "valor": valorStr
            }
            localStorage.setItem('beneficio-{{ $params }}', JSON.stringify(datosBienestar));
            showMessage('success','Atención','Meta registrada exitosamente')
        }else{
            showMessage('success','Atención',data.message)
        }
    }

    async function getMetas(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/fit/indicadores/${datosBienestar.id}/metas`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            let elem = ``;
            $.each(data.data, function(key, value){
                let esSelected = (value.id == datosBienestar.meta.id) ? 'selected' : '';
                elem += `<option ${esSelected} value="${value.id}">${value.valor}</option>`;
            })
            $('#valorMeta').html(elem);
        }
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