@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas
@endsection
@section('content')
@php
    $paramsPresencial = base64_encode(json_encode(["online" => "N"])); 
    $paramsOnline = base64_encode(json_encode(["online" => "S"]));
    
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="consultaMedicaModal" tabindex="-1" aria-labelledby="consultaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header">
                    <button type="button" class="btn-close fw-bold bg-transparent me-1 top-50 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 pt-2">
                    <h5 class="text-center mb-4">{{ __('Modalidad de la cita') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col-6 col-lg-6 mb-3">
                            <div class="card mb-3">
                                <a href="{{route('citas.listaPacientes',['params' => $paramsPresencial])}}">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-9 col-md-auto">
                                            <div class="card-body py-0 px-2">
                                                <h6 class="fw-bold fs--2 mb-0">{{ __('Cita') }} {{ __('presencial') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-3 col-md-auto border-0 border-start rounded-start-circle d-flex justify-content-center align-items-center cita-presencial" style="background: #D0EBFA; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                            <img src="{{ asset('assets/img/svg/consulta_presencial.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Cita presencial') }}" width="40">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-6 col-lg-6 mb-3">
                            <div class="card mb-3">
                                <a href="{{route('citas.listaPacientes',['params' => $paramsOnline])}}">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-9 col-md-auto">
                                            <div class="card-body py-0 px-2">
                                                <h6 class="fw-bold fs--2 mb-0">{{ __('Cita virtual') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-3 col-md-auto border-0 border-start rounded-start-circle d-flex justify-content-center align-items-center" style="background: #D0EBFA; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                            <img src="{{ asset('assets/img/svg/consulta_virtual.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Cita virtual') }}" width="40">
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
            <h5 class="fw-bold border-start-veris ps-3 fs-18">{{ __('Servicios') }}</h5>
        </div>
        <div class="row g-4">
            <!-- consulta medica -->
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#consultaMedicaModal">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Consulta médica') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #F0FAFF; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                <img src="{{ asset('assets/img/svg/estetoscopio.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Imágenes y procedimientos') }}" width="52">
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
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Laboratorio') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #F1F8E2; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                <img src="{{ asset('assets/img/svg/microscopio.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Laboratorio') }}" width="52">
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
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Imágenes y procedimientos') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #DEDAF0; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                <img src="{{ asset('assets/img/svg/imagen.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Imágenes y procedimientos') }}" width="52">
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
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Terapia física') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #D6F3FF; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                <img src="{{ asset('assets/img/svg/muletas.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Terapia física') }}" width="52">
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
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Recetas médicas') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #FFE0E4; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                <img src="{{ asset('assets/img/svg/recetas.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Recetas médicas') }}" width="52">
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
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Orden externa') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #F0F0F0; border-top-right-radius: 7.375rem; border-bottom-right-radius: 7.375rem;">
                                <img src="{{ asset('assets/img/svg/orden_externa.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Orden externa') }}" width="52">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3 fs-18">{{ __('Mis citas') }}</h5>
        </div>
        <div class="row g-4">
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.misCitas')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Citas pasadas') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto border-0 border-start rounded-start-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/clock.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Citas pasadas') }}" width="52">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card">
                    <a href="{{route('citas.misCitas')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Próximas citas') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto border-0 border-start rounded-start-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/calendario.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Próximas citas') }}" width="52">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPPD();
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
</script>
@endpush