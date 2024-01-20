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
    <!-- Modal confirmar Pago-->
    <div class="modal fade" id="confirmarPago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmarPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-regular fa-credit-card fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">Confirmar pago</h1>
                    </div>
                    <p class="fs--1 mb-3" style="line-height: 16px;"><b class="text-primary">Para continuar con la transacción</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="text" class="form-control" name="code" id="code" placeholder="Código de seguridad (OTP)" required />
                    </div>
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal informacion-->
    <div class="modal fade" id="informacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="informacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3 py-4">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-info fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">Información</h1>
                        <p class="fs--1 mb-3" style="line-height: 16px;">Esta tarjeta ya está agregada</p>
                    </div>
                    <a href="#" class="btn btn-lg btn-primary-veris w-100 mb-2">Ver tarjeta agregada</a>
                    <button type="button" class="btn btn-lg btn-outline-primary-veris w-100" data-bs-dismiss="modal">Ingresar nueva tarjeta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tarjeta rechazada-->
    <div class="modal fade" id="tarjetaRechazada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tarjetaRechazadaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="tarjetaRechazadaLabel">Tarjeta rechazada</h1>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Información de pago') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/img/card/tarjeta_pago.png') }}" class="img-fluid mb-3" alt="{{ __('tarjeta de pago') }}">
                        <ul class="list-group bg-white mb-3">
                            <li class="list-group-item border-0 text-primary-veris d-flex justify-content-between align-items-center">
                                Total a pagar:
                                <span class="badge text-primary-veris">$27.00</span>
                            </li>
                        </ul>
                        <!-- content-pago -->
                        <div class="card card-body">
                            <form id="add-card-form" class="row g-3">
                                <div class="col-12">
                                    <div class="payment-form" id="my-card" data-capture-name="true"></div>
                                    <button id="btn-pagar" class="btn btn-primary-veris w-100 m-0 waves-effect waves-light">PAGAR</button>
                                    <br/>
                                    <div id="messages"></div>
                                </div>
                            </form>
                        </div>
                        <div class="my-3">
                            <p class="fs--3 mb-0">*Guardaremos tu tarjeta para futuras compras, podrás eliminarla después si lo deseas.</p>
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="fw-bold fs--2 mb-0 me-3">Transacción protegida por</p>
                                <img src="{{asset('assets/img/card/pci.png')}}" class="img-fluid" alt="{{ __('pci') }}">
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-between border-top p-2">
                            <div class="text-start mx-1">
                                <p class="fs--2 mb-0 fw-bold">{{ __('¿Alguien más pagará esta cita?') }}</p>
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
    let dataCita = @json($data);
    document.addEventListener("DOMContentLoaded", async function () {
        //https://api-phantomx.veris.com.ec/digitalestest/v1/seguridad/parametrosNuvei?codigoAplicacion=MI_VERIS_WEB
        Payment.init('{{ \App\Models\Veris::ENVIRONMENT_NUVEI }}', 'NUVEISTG-EC-CLIENT', 'rvpKAv2tc49x6YL38fvtv5jJxRRiPs');

        let form = $("#add-card-form");
        let submitButton = form.find("button");
        let submitInitialText = submitButton.text();

        $("#add-card-form").submit(function (e) {
            let myCard = $('#my-card');
            $('#messages').text("");
            let cardToSave = myCard.PaymentForm('card');
            if (cardToSave == null) {
                $('#messages').text("Invalid Card Data");
            }else{
                submitButton.attr("disabled", "disabled").text("Procesando pago...");
                let uid = "0923796304";
                let email = "mwrosero@gmail.com";
                Payment.addCard(uid, email, cardToSave, successHandler, errorHandler);
            }
            console.log(0)
            e.preventDefault();
            console.log(1)
        });

        let successHandler = async function (cardResponse) {
            console.log(cardResponse.card);
            if (cardResponse.card.status === 'valid') {
                $('#btn-pagar').addClass('disabled');
                await registrarTarjeta(cardResponse);
                /*$('#messages').html('Card Successfully Added<br>' +
                'status: ' + cardResponse.card.status + '<br>' +
                "Card Token: " + cardResponse.card.token + "<br>" +
                "transaction_reference: " + cardResponse.card.transaction_reference
                );*/
            }else if(cardResponse.card.status === 'review') {
                $('#messages').html('Card Under Review<br>' +
                'status: ' + cardResponse.card.status + '<br>' +
                "Card Token: " + cardResponse.card.token + "<br>" +
                "transaction_reference: " + cardResponse.card.transaction_reference
                );
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
            console.log(err.error);
            $('#messages').html(err.error.type);
            submitButton.removeAttr("disabled");
            submitButton.text(submitInitialText);
        };

    });

    async function registrarTarjeta(cardResponse){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/tarjetas`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "virusu": "{{ Session::get('userData')->numeroIdentificacion }}",
            "canalOrigenDigital": _canalOrigen,
            "card": cardResponse.card
        });
        const data = await call(args);
        
        if(data.code == 200){
            dataCita.tarjeta = cardResponse.card;
            await pagarCita();
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
                let ulrParams = btoa(JSON.stringify(dataCita));
                let ruta = `/cita-agendada/${ulrParams.replace(/\//g, '|')}`;
                //window.location.href = ruta;
            }
        }
        
    }
</script>
@endpush