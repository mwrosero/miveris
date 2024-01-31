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
                                <span class="badge text-primary-veris" id="totalInfo"></span>
                            </li>
                        </ul>
                        <!-- content-pago -->
                        <div class="card card-body">
                            <div class="row g-3">
                            	<input type="hidden" class="form-control form-control-sm animated-input" name="data" id="data" form="kushki-pay-form"/>
                            	<form class="kushki-pay-form col-12" id="kushki-pay-form" action="/citas-procesar-pago-kushki/" method="POST"></form>
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
        $('#totalInfo').html(`$${dataCita.facturacion.totales.total}`);
		kushki = new KushkiCheckout({
	        form: "kushki-pay-form",
	        merchant_id: {{ \App\Models\Veris::KUSHKI_MERCHANT_ID }},
	        amount: dataCita.facturacion.totales.total,//valoresPago.valorCanalVirtual , // Monto total
	        currency: "USD", // Codigo de moneda, por defecto "USD"
	        inTestEnvironment:Boolean({{ \App\Models\Veris::TEST_ENVIRONMENT_KUSHKI }}),
	        isDeferred: true,
	        is_subscription: false // true si se trata de una suscripcion (pago recurrente); false, si no.
	    });
	    let ulrParams = btoa(JSON.stringify(dataCita));
	    $('#data').val(ulrParams);
    });
</script>
@endpush