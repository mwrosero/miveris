@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Información de pago
@endsection
@section('content')
@php
// $data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData'));
// dd($data);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Información de pago') }}</h5>
    </div>
    <section class="p-3 pt-5 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center">
                        <ul class="list-group mb-3" style="background: #E9EFF4;">
                            <li class="list-group-item border-0 text-primary-veris d-flex justify-content-between align-items-center">
                                <img src="{{ asset('assets/img/card/p2p-cards.svg') }}" class="img-fluid mt-1" alt="{{ __('tarjeta de pago') }}">
                                <button class="btn btn-label-primary-veris cursor-pointer" id="btn-pago-p2p">Click aquí</button>
                            </li>
                        </ul>
                        <!-- content-pago -->
                        <div class="card card-body bg-transparent shadow-none pt-1">
                            <div class="row g-3">
                                @if (session()->has('mensaje'))
                                    <div class="alert alert-warning mb-3">
                                        {{ session('mensaje') }}
                                    </div>
                                @endif
                            	<form class="kushki-pay-form col-12" id="kushki-pay-form" action="/citas-procesar-pago-kushki" method="POST">
                                    @csrf
                                </form>
                                <input type="hidden" name="tokenCita" id="tokenCita" form="kushki-pay-form">
                                <input type="hidden" name="dataCita" id="dataCita" form="kushki-pay-form">
                            </div>
                        </div>
                        {{-- <div class="my-3">
                            <p class="fs--3 mb-0">*Guardaremos tu tarjeta para futuras compras, podrás eliminarla después si lo deseas.</p>
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="fw-bold fs--2 mb-0 me-3">Transacción protegida por</p>
                                <img src="{{asset('assets/img/card/pci.png')}}" class="img-fluid" alt="{{ __('pci') }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between border-top p-2">
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
<script src="https://cdn.kushkipagos.com/kushki-checkout.js" charset="utf-8"></script>
{{-- <script src="https://cdn-uat.kushkipagos.com/kushki-checkout.js" charset="utf-8"></script> --}}

<script>
	let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    document.addEventListener("DOMContentLoaded", async function () {
        $('#dataCita').val(btoa(JSON.stringify(dataCita)));
        $('#tokenCita').val("{{ $params }}");

        $('body').on('click', '#btn-pago-p2p', async function(){
            await pagarPtp();
        })
        
		kushki = new KushkiCheckout({
	        form: "kushki-pay-form",
	        merchant_id: "{{ \App\Models\Veris::KUSHKI_MERCHANT_ID }}",
	        amount: dataCita.facturacion.totales.total,//valoresPago.valorCanalVirtual , // Monto total
	        currency: "USD", // Codigo de moneda, por defecto "USD"
	        inTestEnvironment:Boolean({{ \App\Models\Veris::TEST_ENVIRONMENT_KUSHKI }}),
	        isDeferred: true,
	        is_subscription: false // true si se trata de una suscripcion (pago recurrente); false, si no.
	    });
    });

    async function pagarPtp(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/crear_transaccion_virtual?idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST"; 
        args["showLoader"] = true; 
        args["bodyType"] = "json"; 
        args["data"] = JSON.stringify({            
            "codigoUsuario": "{{ Session::get('userData')->numeroIdentificacion }}",
            "codigoTipoIdentificacion": parseInt(dataCita.datosIngresadosFactura.codigoTipoIdentificacion),
            "numeroIdentificacion": dataCita.datosIngresadosFactura.numeroIdentificacion,
            "nombreFactura": dataCita.datosIngresadosFactura.nombreFactura,
            "primerNombre": dataCita.datosIngresadosFactura.primerNombre,
            "primerApellido": dataCita.datosIngresadosFactura.primerApellido,
            "segundoApellido": dataCita.datosIngresadosFactura.segundoApellido,
            "direccionFactura": dataCita.datosIngresadosFactura.direccionFactura,
            "telefonoFactura": dataCita.datosIngresadosFactura.telefonoFactura,
            "mailFactura": dataCita.datosIngresadosFactura.mailFactura,
            "emailFactura": dataCita.datosIngresadosFactura.emailFactura,
            "direccionIP": "",
            "modeloDispositivo": "",
            "versionSO": "",
            "plataformaOrigen": "WEB",
            "tipoBoton": "PTP",
            "sistemaOperativo": "",
            "idNavegador": "",
            "idiomaNavegador": "",
            "navegadorUA": "",
            "canalOrigenDigital": _canalOrigen//"VER_CMV"
        });
        const data = await call(args);
        window.removeEventListener("beforeunload", beforeUnloadHandler);
        if (data.code == 200){
            dataCita.transaccionVirtual = data.data;
            guardarData();
            location.href = data.data.linkPagoPTP;
        }else{
            alert(data.message);
        }
    }
    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
<style>
    iframe {
        width: 100% !important;!i;!;
        max-width: 100% !important;!i;!;
    }
</style>
@endpush