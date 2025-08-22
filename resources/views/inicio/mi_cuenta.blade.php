@extends('template.app-template-veris')
@section('title')
Mi Veris - Cuenta
@endsection
@section('content')
@php
// $data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData')->numeroIdentificacion);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
   

    <!-- Modal eliminar tarjeta -->
    <div class="modal fade" id="modalEliminarTarjeta" tabindex="-1" aria-labelledby="modalEliminarTarjetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Eliminar tarjeta</h1>
                    <p class="fs--1 fw-normal text-veris" id="mensajeError">¿Estás seguro(a) de eliminar esta tarjeta?</p>
                    <input type="hidden" id="idTarjetaEliminar">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</div>
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center btn-confirmar-eliminar-tarjeta">Eliminar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Cuenta') }}</h5>
    </div>
    <section class="p-3 mb-3 px-md-0">
        <div class="row mx-md-0">
            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div class="card bg-veris-ai shadow-none text-white">
                    <div class="card-header p-0">
                        <div class="avatar-xl avatar-online mt-4 mb-3 mx-auto">
                            <img src="{{ asset('assets/img/avatars/avatar.svg') }}" width="74px" alt class="h-auto rounded-circle" />
                        </div>
                        <h2 class="text-white text-center fs--16 line-height-20 mb-2 text-capitalize">{{ strtolower(Session::get('userData')->primerNombre) }} {{ strtolower(Session::get('userData')->segundoNombre) }} {{ strtolower(Session::get('userData')->primerApellido) }}  {{ strtolower(Session::get('userData')->segundoApellido) }}</h2>
                        <h2 class="text-white text-center fs--1 line-height-16">
                            <span class="text-lowercase">{{ strtolower(Session::get('userData')->edad) }}</span> |
                            {{ Session::get('userData')->codigoTipoIdentificacion == 2 ? 'C.I.' : 'PAS.' }} 
                            <span class="text-white numeroIdentificacionUsuario"></span> 
                        </h2>
                    </div>
                    <div class="card-body p-0 bg-white rounded-top-xl p-3">
                        <div class="row text-veris-ai mb-3 d-flex justify-content-between align-items-center g-3">
                            <div class="col-4">
                                <a href="/mis-datos" class="w-100 waves-effect p-2 text-decoration-none d-block text-center bg-silver-light rounded-lg">
                                    <i class="fa-solid fa-user mb-2 fs-32 text-veris-ai"></i>
                                    <p class="fs--1 fw-medium mb-0 text-veris-ai">Mis datos</p>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="/mis-tarjetas" class="w-100 waves-effect p-2 text-decoration-none d-block text-center bg-silver-light rounded-lg">
                                    <i class="fa-solid fa-credit-card mb-2 fs-32 text-veris-ai"></i>
                                    <p class="fs--1 fw-medium mb-0 text-veris-ai">Mis tarjetas</p>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="/bienestar" class="w-100 waves-effect p-2 text-decoration-none d-block text-center bg-silver-light rounded-lg">
                                    <img src="{{ asset('assets/img/svg/watch-smart.svg') }}" class="mb-2" />
                                    <p class="fs--1 fw-medium mb-0 text-veris-ai">Bienestar</p>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <img src="{{ asset('assets/img/svg/E-Wallet-amico.svg') }}" class="w-100" />
                        </div> -->
                        <div class="row mb-3 px-3">
                            <a href="/familia-amigos-lista" class="col-12 d-flex justify-content-between align-items-center py-3 px-0 waves-effect text-decoration-none border-silver-1">
                                <img src="{{ asset('assets/img/svg/familia-amigos.svg') }}" class="mx-3" />
                                <div class="context-list flex-grow-1">
                                    <p class="label-status-detalle fw-medium fs--1 line-height-16 mb-2">Familia y amigos</p>
                                    <p class="fw-light label-status-detalle fs--2 line-height-16 mb-0">Agrega usuarios y administra sus citas.</p>
                                </div>
                                <i class="fa-solid fa-angle-right mx-3"></i>
                            </a>
                            {{-- <a href="/mis-facturas" class="col-12 d-flex justify-content-between align-items-center py-3 px-0 waves-effect text-decoration-none border-silver-1">
                                <img src="{{ asset('assets/img/svg/mis-facturas.svg') }}" class="mx-3" />
                                <div class="context-list flex-grow-1">
                                    <p class="label-status-detalle fw-medium fs--1 line-height-16 mb-2">Mis facturas</p>
                                    <p class="fw-light label-status-detalle fs--2 line-height-16 mb-0">Consulta tu historial de facturas.</p>
                                </div>
                                <i class="fa-solid fa-angle-right mx-3"></i>
                            </a> --}}
                            <a href="/mis-convenios" class="col-12 d-flex justify-content-between align-items-center waves-effect py-3 px-0 text-decoration-none border-silver-1">
                                <img src="{{ asset('assets/img/svg/hands-shake.svg') }}" class="mx-3" />
                                <div class="context-list flex-grow-1">
                                    <p class="label-status-detalle fw-medium fs--1 line-height-16 mb-2">¿Tienes seguro médico privado?</p>
                                    <p class="fw-light label-status-detalle fs--2 line-height-16 mb-0">Agrega/elimina tu seguro médico.</p>
                                </div>
                                <i class="fa-solid fa-angle-right mx-3"></i>
                            </a>
                            <a href="/faq" class="col-12 d-flex justify-content-between align-items-center waves-effect py-3 px-0 text-decoration-none border-silver-1 mb--32">
                                <img src="{{ asset('assets/img/svg/question-icon.svg') }}" class="mx-3" />
                                <div class="context-list flex-grow-1">
                                    <p class="label-status-detalle fw-medium fs--1 line-height-16 mb-2">Preguntas frecuentes</p>
                                    <p class="fw-light label-status-detalle fs--2 line-height-16 mb-0">Encuentra respuestas aquí.</p>
                                </div>
                                <i class="fa-solid fa-angle-right mx-3"></i>
                            </a>                            
                            <div class="col-12 text-center">
                                <div type="button" class="text-danger-veris m-3 fs--18 line-height-24" data-bs-toggle="modal" data-bs-target="#logoutModal">Cerrar sesión</div>
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
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        $('.numeroIdentificacionUsuario').html(`{{ Session::get('userData')->numeroIdentificacion }}`);
    });
</script>
<style>
    .rounded-lg{
        border-radius: 16px;
    }
    .rounded-top-xl{
        border-top-left-radius: 24px;
        border-top-right-radius: 24px;
    }
    .bg-silver-light{
        background: #EAF0FD;
    }
    .border-silver-1{
        border-bottom: 1px solid #E7E9EC;
    }

    @media screen and (max-width: 992px) {
        .px-md-0{
            padding-left: 0px !important;
            padding-right: 0px !important;
            overflow-x: hidden;
        }
    }
</style>
@endpush