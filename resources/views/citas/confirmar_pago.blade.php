@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Confirmar pago
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData')->numeroIdentificacion);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="codeinvalid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="codeinvalidLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Código inválido</h1>
                        <p class="fs--1 mb-3" style="line-height: 16px;">Código erróneo, inténtalo nuevamente</p>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal intento fallido -->
    <div class="modal fade" id="intentoFallido" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="intentoFallidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">No se permiten más intentos</h1>
                        <p class="fs--1 mx-3 mb-3" style="line-height: 16px;">Haz alcanzado el número máximo de intentos con este código</p>
                    </div>
                    <a href="#" id="btn-intentos-fallidos" class="btn btn-lg btn-primary-veris w-100">Entiendo</a>
                    {{-- javascript:history.back() --}}
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Confirmar pago') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-transparent shadow-none mt-3">
                    <div class="card-body p-0">
                        <form class="row g-3">
                            <div class="text-center">
                                <div class="avatar avatar-lg mx-auto mb-3">
                                    <span class="avatar-initial rounded-circle bg-primary">
                                        <i class="fa-regular fa-credit-card fs-2"></i>
                                    </span>
                                </div>
                                <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Confirmar pago</h1>
                            </div>
                            <p class="fs--1 mb-3" style="line-height: 16px;"><b class="text-primary">Para continuar con la transacción</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="text" class="form-control" name="codePagar" id="codePagar" placeholder="Código de seguridad (OTP)" required />
                            </div>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                            </div>
                            <div class="col-12 mt-5 pt-md-5">
                                <button type="button" id="btn-pagar-otp" class="btn btn-lg btn-primary-veris w-100 mb-2">Confirmar pago</button>
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
        $('body').on('click', '#btn-pagar-otp', async function(){
            $('#btn-pagar-otp').addClass('disabled');
            let codeOTP = $('#codePagar').val();
            autenticarOTP(codeOTP,'pago');
        });
    });

    async function autenticarOTP(codeOTP,type){
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
            //"datosTarjetaSuscrita": dataCita.tarjeta
        });
        const data = await call(args);
        
        if(data.code == 200){
            if(data.data.estado == "APPROVED"){
                guardarData();
                let ruta = `/cita-agendada/{{ $params }}`;
                window.location.href = ruta;
            }else if(data.data.estado == "PENDING"){
                if(type == "pago"){
                    $('#btn-pagar-otp').removeClass('disabled');
                    $('#confirmarPago .invalid-feedback').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${data.data.mensajeNuvei}`).show();
                }else{
                    $('#btn-autenticar-otp').removeClass('disabled');
                    $('#autenticarPago .invalid-feedback').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${data.data.mensajeNuvei}`).show();
                }
            }else{
                let ruta = `/citas-informacion-pago/{{ $params }}`;
                $('#btn-intentos-fallidos').attr("href",ruta);
                var myModal = new bootstrap.Modal(document.getElementById('intentoFallido'));
                myModal.show();
            }
        }else{
            $('#btn-autenticar-otp').removeClass('disabled');
            $('#btn-pagar-otp').removeClass('disabled');
            alert(data.message)
        }
    }

    async function pagarCita(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/registrar_pago_nuvei?canalOrigen=${_canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "tipoIdentificacion": parseInt(dataCita.facturacion.datosFactura.codigoTipoIdentificacion),
            "numeroIdentificacion": dataCita.facturacion.datosFactura.codigoUsuario,
            "codigoTransaccion": dataCita.transaccionVirtual.codigoTransaccion,
            "canalOrigenDigital": _canalOrigen,
            "tokenNuvei": dataCita.tarjeta.token
        });
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            console.log(data.data);
            if(data.data.estado.toUpperCase() == "APPROVED"){
                dataCita.registroPago = data.data;
                guardarData();
                let ruta = `/cita-agendada/{{ $params }}`;
                window.location.href = ruta;
            }else if(data.data.estado.toUpperCase() == "PENDING"){
                //36417002140808
                await solicitarOTP('confirmarPago');
            }
        }        
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
@endpush