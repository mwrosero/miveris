@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Autenticación y registro de tarjeta
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal codeigo incorrecto -->
    <div class="modal fade" id="codeinvalid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="codeinvalidLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Código inválido</h1>
                        <p class="fs--1 mb-3" style="line-height: 16px;">Código erróneo, inténtalo nuevamente</p>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 m-0" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal intento fallido -->
    <div class="modal fade" id="intentoFallido" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="intentoFallidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">No se permiten más intentos</h1>
                        <p class="fs--1 mx-3 mb-3" style="line-height: 16px;">Haz alcanzado el número máximo de intentos con este código</p>
                    </div>
                    <a href="{{ url()->previous() }}" class="btn btn-lg btn-primary-veris m-0 w-100 px-4 py-3">Entiendo</a>
                    {{-- javascript:history.back() --}}
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Autenticación y registro de tarjeta') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-transparent shadow-none mt-3">
                    <div class="card-body p-0">
                        <form class="row g-3">
                            <div class="text-center mb-3">
                                <div class="avatar avatar-lg mx-auto">
                                    <span class="avatar-initial rounded-circle bg-primary">
                                        <i class="bi bi-lock fs-2"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fs--1 mt-0 mb-3" style="line-height: 16px;"><b class="text-primary">Para autenticar tu tarjeta</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="number" class="form-control" name="codeAutenticar" id="codeAutenticar" placeholder="Código de seguridad (OTP)" required />
                            </div>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                            </div>
                            <div class="col-12 mt-5 pt-md-5">
                                <button type="button" id="btn-autenticar-otp" class="btn btn-lg btn-primary-veris w-100">Autenticar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    
    document.addEventListener("DOMContentLoaded", async function () {

        $('body').on('click', '#btn-autenticar-otp', async function(){
            $('#btn-autenticar-otp').addClass('disabled');
            let codeOTP = $('#codeAutenticar').val();
            autenticarOTP(codeOTP);
        });

        if(dataCita.reserva){
            if (dataCita.reserva.aplicaProntoPago == "S") {
                window.addEventListener("beforeunload", beforeUnloadHandler);
            }
        }

    });
    async function autenticarOTP(codeOTP){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/tarjetas/verificacion`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "virusu": "{{ Session::get('userData')->numeroIdentificacion }}",
            "canalOrigenDigital": _canalOrigen,
            "codigoTransaccion": dataCita.transaccionVirtual.codigoTransaccion,
            "valorOTP": codeOTP,
            "datosTarjetaSuscrita": dataCita.tarjeta
        });
        const data = await call(args);
        
        if(data.code == 200){
            if(data.data.estado == "APPROVED"){
                window.removeEventListener("beforeunload", beforeUnloadHandler);
                let ruta = `/citas-autenticacion-exitosa/{{ $params }}`;
                window.location.href = ruta;
            }else if(data.data.estado == "PENDING"){
                $('#btn-autenticar-otp').removeClass('disabled');
                //$('#label').html(data.data.mensajeNuvei);
                var myModal = new bootstrap.Modal(document.getElementById('codeinvalid'));
                myModal.show();
            }else{
                var myModal = new bootstrap.Modal(document.getElementById('intentoFallido'));
                myModal.show();
            }
        }else{
            $('#btn-autenticar-otp').removeClass('disabled');
            alert(data.message);
        }
    }

</script>
@endpush