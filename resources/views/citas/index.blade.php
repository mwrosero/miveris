@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
    // dd($tokenCita);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="consultaMedicaModal" tabindex="-1" aria-labelledby="consultaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header">
                    <button type="button" class="btn-close fw-medium bg-transparent me-2 top-50 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-3 pt-2">
                    <h5 class="text-center mb-4">{{ __('Modalidad de la cita') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col-6 col-lg-6">
                            <div class="card mb-3">
                                
                                <a class="cursor-pointer" id="cita-presencial" >
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-7 col-md-7">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Cita') }} <br> {{ __('presencial') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-4 cita-presencial">
                                            <img src="{{ asset('assets/img/card/svg/consulta_presencial.svg') }}" class="card-img-top rounded-2" alt="{{ __('Cita presencial') }}">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-6 col-lg-6">
                            <div class="card mb-3">
                                <a class="cursor-pointer" id="cita-virtual">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-7 col-md-7">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Cita virtual') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-4">
                                            <img src="{{ asset('assets/img/card/svg/consulta_virtual.svg') }}" class="card-img-top rounded-2" alt="{{ __('Cita virtual') }}">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Citas') }}</h5>
    </div>
    <section class="p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18">{{ __('Servicios') }}</h5>
        </div>
        <div class="row g-3 g-lg-4">
            <!-- consulta medica -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#consultaMedicaModal">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Consulta médica') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/estetoscopio.svg') }}" class="card-img-top rounded-2" alt="{{ __('Imágenes y procedimientos') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- laboratorio -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.laboratorio')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Laboratorio') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/microscopio.svg') }}" class="card-img-top rounded-2" alt="{{ __('Laboratorio') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- imagenes y procedimiento -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.imagenesProcedimientos')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Imágenes y procedimientos') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/imagen.svg') }}" class="card-img-top rounded-2" alt="{{ __('Imágenes y procedimientos') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- terapia fisica -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.terapiaFisica')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Terapia física') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/muletas.svg') }}" class="card-img-top rounded-2" alt="{{ __('Terapia física') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- receta medica -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.recetaMedica')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Recetas médicas') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/recetas.svg') }}" class="card-img-top rounded-2" alt="{{ __('Recetas médicas') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- orden externa -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.ordenesExternas')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Orden externa') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/orden_externa.svg') }}" class="card-img-top rounded-2" alt="{{ __('Orden externa') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18">{{ __('Mis citas') }}</h5>
        </div>
        <div class="row g-3 g-lg-4">
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.misCitas')}}" id= btnMisCitas>
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-8 col-md-7">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Próximas ') }} <br> {{ __('citas') }}</h6>
                                </div>
                            </div>
                            <div class="col-4 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/calendario.svg') }}" class="card-img-top rounded-2" alt="{{ __('Próximas citas') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.misCitas')}}" id= btnHistorialCitas>
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-8 col-md-7">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Historial de ') }} <br>{{ __('citas') }}</h6>
                                </div>
                            </div>
                            <div class="col-4 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/clock.svg') }}" class="card-img-top rounded-2" alt="{{ __('Historial de citas') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
</script>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPPD();

        $('body').on('click', '.nextStep', function(){
            let url = $(this).attr('url-rel');
            let data = $(this).attr('data-rel');
            localStorage.setItem('cita-{{ $tokenCita }}', data);
            location.href = url + "{{ $tokenCita }}";
        })
    });

    async function obtenerPPD(){
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1";
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            
                localStorage.setItem('politicas', JSON.stringify(data.data));
                if(localStorage.getItem('politicas') == null){
                    let politicas = JSON.parse(localStorage.getItem('politicas'));
                    if(politicas.estadoPoliticas == "N" && (politicas.isPoliticasAceptadas == null || politicas.isPoliticasAceptadas == false)){
                        $('#politicasPPD').attr('href',politicas.linkPoliticaPrivacidad);
                        $('#modalPPD').modal('show');
                    }
                    else {
                        $('#modalPPD').modal('hide');
                    }
                }
                else {
                    return false;
                }
            }
        /*if(data.code == 200){
            $('#provincia').empty();
            $.each(data.data, function(key, value){
                $('#provincia').append(`<option value="${value.codigoProvincia}" codigoRegion-rel="${value.codigoRegion}">${value.nombreProvincia}</option>`);
            })
        }*/
    }

    // setear los parametros de la cita presencial
    $('#cita-presencial').on('click', function(){

        let params = {}
        params.online = 'N';

        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

        // redireccionar a la pagina de citas
        window.location.href = "/citas-elegir-paciente/" + "{{ $tokenCita }}";
    });


    // setear los parametros de la cita virtual

    $('#cita-virtual').on('click', function(){

        let params = {}
        params.online = 'S';

        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

        // redireccionar a la pagina de citas
        window.location.href = "/citas-elegir-paciente/" + "{{ $tokenCita }}";
    });


    // btn mis citas
    $('#btnMisCitas').on('click', function(){
        localStorage.setItem('miscitas', 'proximas');
    });

    // btn historial citas
    $('#btnHistorialCitas').on('click', function(){
        localStorage.setItem('miscitas', 'historial');
    });

</script>
@endpush