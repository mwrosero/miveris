@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Información de pago
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal Autenticar tarjeta-->
    <div class="modal fade" id="autenticarPago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="autenticarPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="bi bi-lock fs-2"></i>
                            </span>
                        </div>
                        {{-- <h1 class="modal-title fs-5 mb-3" id="autenticarPagoLabel">Confirmar pago</h1> --}}
                    </div>
                    <p class="fs--1 mb-3" style="line-height: 16px;"><b class="text-primary">Para autenticar tu tarjeta</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                    <div class="input-group input-group-merge mb-3">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="number" class="form-control code-otp" name="codeAutenticar" id="codeAutenticar" placeholder="Código de seguridad (OTP)" required />
                    </div>
                    <div class="invalid-feedback mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                    </div>
                    <button type="button" id="btn-autenticar-otp" class="btn btn-action-otp btn-lg btn-primary-veris w-100 px-4 py-3 m-0 mb-3">Autenticar</button>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 m-0 btn-close-modal d-none" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal confirmar Pago-->
    <div class="modal fade" id="confirmarPago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmarPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-regular fa-credit-card fs-2"></i>
                            </span>
                        </div>
                        {{-- <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">Confirmar pago</h1> --}}
                    </div>
                    <p class="fs--1 mb-3" style="line-height: 16px;"><b class="text-primary">Para continuar con la transacción</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                    <div class="input-group input-group-merge mb-3">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="number" class="form-control code-otp" name="codePagar" id="codePagar" placeholder="Código de seguridad (OTP)" required />
                    </div>
                    <div class="invalid-feedback mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                    </div>
                    <button type="button" id="btn-pagar-otp" class="btn btn-action-otp btn-lg btn-primary-veris w-100 px-4 py-3 m-0">Confirmar pago</button>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 m-0 btn-close-modal d-none" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal informacion-->
    <div class="modal fade" id="informacion" tabindex="-1" aria-labelledby="informacionLabel">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-info fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">Información</h1>
                        <p class="fs--1 mb-3" style="line-height: 16px;">Esta tarjeta ya está agregada</p>
                    </div>
                    <a href="/citas-seleccionar-tarjeta/{{ $params }}" class="btn btn-lg btn-primary-veris w-100 m-0 mb-3 px-4 py-3">Ver tarjeta agregada</a>
                    <button type="button" class="btn btn-lg btn-outline-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal">Ingresar nueva tarjeta</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal tarjeta rechazada-->
    <div class="modal fade" id="tarjetaRechazada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tarjetaRechazadaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="tarjetaRechazadaLabel">Tarjeta rechazada</h1>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Información de pago') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/img/card/tarjeta_pago.png') }}" class="img-fluid mb-3" alt="{{ __('tarjeta de pago') }}">
                        <ul class="list-group bg-white mb-3" style="border-radius: 16px;background: var(--Neutral-Blanco-00, #FFF);box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.10);">
                            <li class="list-group-item border-0 text-primary-veris fs--1 fw-medium line-height-16 d-flex justify-content-between align-items-center">
                                Total a pagar:
                                <span class="badge text-primary-veris fs--1 fw-medium line-height-16" id="totalInfo"></span>
                            </li>
                        </ul>
                        <!-- content-pago -->
                        <div class="card card-body p-3" style="border-radius: 16px !important;background: #FFF;box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.10);">
                            <form id="add-card-form" class="row g-0 d-none">
                                <div class="col-12">
                                    <div class="payment-form mb-3" id="my-card" data-capture-name="true"></div>
                                    <button id="btn-pagar" class="btn btn-primary-veris fs--18 fw-medium line-height-24 w-100 m-0 px-4 py-3">Pagar</button>
                                    <br/>
                                    <div id="messages"></div>
                                </div>
                            </form>
                        </div>
                        <div class="my-3">
                            <p class="fs--3 mb-0">*Guardaremos tu tarjeta para futuras compras, podrás eliminarla después si lo deseas.</p>
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="fw-medium fs--2 mb-0 me-3">Transacción protegida por</p>
                                <img src="{{asset('assets/img/card/pci.png')}}" class="img-fluid" alt="{{ __('pci') }}">
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-between border-top p-2">
                            <div class="text-start mx-1">
                                <p class="fs--2 mb-0 fw-medium">{{ __('¿Alguien más pagará esta cita?') }}</p>
                                <p class="fs--2 mb-0">{{ __('Genera tu link de pago') }}</p>
                            </div>
                            <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 mx-1">{{ __('Enviar link') }}</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<link href="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.js" charset="UTF-8"></script>
<script>
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    document.addEventListener("DOMContentLoaded", async function () {
        if(dataCita.reserva){
            if (dataCita.reserva.aplicaProntoPago == "S") {
                window.addEventListener("beforeunload", beforeUnloadHandler);
            }
        }
        $('#totalInfo').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);
        //https://api-phantomx.veris.com.ec/${api_war}/v1/seguridad/parametrosNuvei?codigoAplicacion=MI_VERIS_WEB
        let credenciales = await obtenerCredenciales();
        console.log(credenciales)
        Payment.init('{{ \App\Models\Veris::ENVIRONMENT_NUVEI }}', dataCita.transaccionVirtual.applicationCode, dataCita.transaccionVirtual.applicationKey);
        // Payment.init('{{ \App\Models\Veris::ENVIRONMENT_NUVEI }}', 'NUVEISTG-EC-CLIENT', 'rvpKAv2tc49x6YL38fvtv5jJxRRiPs');
        // Payment.init('{{ \App\Models\Veris::ENVIRONMENT_NUVEI }}', credenciales.applicationCode, credenciales.applicationKey);

        setTimeout(function(){
            $('.expiry').val('');
            $('.cvc').val('');
            $('#add-card-form').removeClass('d-none');
        },1000);

        let form = $("#add-card-form");
        let submitButton = form.find("button");
        let submitInitialText = submitButton.text();

        $("#add-card-form").submit(function (e) {
            let myCard = $('#my-card');
            $('#messages').text("");
            let cardToSave = myCard.PaymentForm('card');
            //console.log(cardToSave);
            if (cardToSave == null) {
                $('#messages').text("Invalid Card Data");
            }else{
                submitButton.attr("disabled", "disabled").text("Procesando pago...");
                let uid = "{{ Session::get('userData')->numeroIdentificacion }}";
                let email = "{{ Session::get('userData')->mail }}";
                Payment.addCard(uid, email, cardToSave, successHandler, errorHandler);
            }

            e.preventDefault();
        });

        $('#btn-pagar').removeClass('disabled');

        let successHandler = async function (cardResponse) {
            console.log(cardResponse.card);
            if (cardResponse.card.status === 'valid') {
                dataCita.tarjeta = cardResponse.card;
                $('#btn-pagar').addClass('disabled');
                await registrarTarjeta();
            }else if(cardResponse.card.status === 'review' || cardResponse.card.status === 'pending') {
                dataCita.tarjeta = cardResponse.card;
                let ruta = `/citas-autenticacion-registro-tarjeta/{{ $params }}`;
                guardarData();
                window.location.href = ruta;
                // $('#btn-pagar').addClass('disabled');
                // await solicitarOTP('autenticarPago');
            }else{
                $('#messages').html('Error<br>' +
                    'status: ' + cardResponse.card.status + '<br>' +
                    "message Token: " + cardResponse.card.message + "<br>"
                );
            }
            submitButton.removeAttr("disabled");
            submitButton.text(submitInitialText);
        };

        let errorHandler = function (err) {
            window.removeEventListener("beforeunload", beforeUnloadHandler);
            console.log(err.error);
            // $('#messages').html(err.error.type);
            if(err.error.help == "If you want to update the card, first delete it"){
                $('#informacion').modal('show');
            }else{
                $('#messages').html(err.error.type);
            }
            $('#btn-pagar').removeClass('disabled');
            submitButton.removeAttr("disabled");
            submitButton.text(submitInitialText);
        };

        $('body').on('click', '#btn-autenticar-otp', async function(){
            $('#btn-autenticar-otp').addClass('disabled');
            let codeOTP = $('#codeAutenticar').val();
            autenticarOTP(codeOTP,'registro');
        });

        $('body').on('click', '#btn-pagar-otp', async function(){
            $('#btn-pagar-otp').addClass('disabled');
            let codeOTP = $('#codePagar').val();
            autenticarOTP(codeOTP,'pago');
        });

        $('body').on('click', '.btn-close-modal', function(){
            $('.btn-close-modal').addClass('d-none');
            $('.btn-action-otp').removeClass('disabled');
            $('#btn-pagar').removeClass('disabled');
            $('#btn-pagar').attr("disabled", "disabled").text("Pagar");
        })

    });

    async function obtenerCredenciales(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/seguridad/parametrosNuvei?codigoAplicacion=MI_VERIS_WEB`;
        args["method"] = "GET";
        args["bodyType"] = "json";
        args["showLoader"] = false;
        const data = await call(args);
        return data;
    }


    async function autenticarOTP(codeOTP,type){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/tarjetas/verificacion`;
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
                if(type == "pago"){
                    let ruta = `/cita-agendada/{{ $params }}`;
                    guardarData();
                    window.location.href = ruta;
                }else{
                    await pagarCita();
                }
            }else if(data.data.estado == "PENDING"){
                if(type == "pago"){
                    $('#btn-pagar-otp').removeClass('disabled');
                    $('#confirmarPago .invalid-feedback').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${data.data.mensajeNuvei}`).show();
                }else{
                    $('#btn-autenticar-otp').removeClass('disabled');
                    $('#autenticarPago .invalid-feedback').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${data.data.mensajeNuvei}`).show();
                }
            }else{
                $('.btn-close-modal').removeClass('d-none');
                if(type == "pago"){
                    $('#confirmarPago .invalid-feedback').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${data.data.mensajeNuvei}`).show();
                }else{
                    $('#autenticarPago .invalid-feedback').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${data.data.mensajeNuvei}`).show();
                }
            }
        }else{
            $('#btn-autenticar-otp').removeClass('disabled');
            $('#btn-pagar-otp').removeClass('disabled');
        }
    }

    async function registrarTarjeta(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/tarjetas`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "virusu": "{{ Session::get('userData')->numeroIdentificacion }}",
            "canalOrigenDigital": _canalOrigen,
            "card": dataCita.tarjeta
        });
        const data = await call(args);
        
        if(data.code == 200){
            await pagarCita();
        }
    }

    async function pagarCita(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/registrar_pago_nuvei?canalOrigen=${_canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
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
                let ruta = `/cita-agendada/{{ $params }}`;
                guardarData();
                window.location.href = ruta;
            }else if(data.data.estado.toUpperCase() == "PENDING"){
                //36417002140808
                await solicitarOTP('confirmarPago');
            }
        }        
    }

    async function solicitarOTP(idModal){
        var myModal = new bootstrap.Modal(document.getElementById(idModal));
        myModal.show();
    }

    function guardarData(){
        window.removeEventListener("beforeunload", beforeUnloadHandler);
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
@endpush