@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Revisa tus datos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Revisa tus datos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-grayish-blue p-2">
                        <h5 class="text-primary-veris fw-bold m-1">{{ __('Precio') }} </h5>
                    </div>
                    <div class="card-body p-2 my-3">
                        <div class="row gx-0 justify-content-evenly align-items-center">
                            <div class="col-5">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/card/convenio.png') }}" width="86" alt="convenio">
                                </div>
                            </div>
                            <div class="col-5 text-end">
                                <p class="text-danger fs--3 mb-0" id="content-precioBase">{{ __('Precio normal') }} <del id="precioBase">$30.00</del></p>
                                <h3 class="text-primary-veris fw-bold mb-0" id="precioTotal">$7.00</h3>
                            </div>
                            <p class="text-center text-primary-veris fs--2 mb-0" id="infoDescuento">{{ __('*Se aplicó un 5% de descuento por pago en app') }}</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between border-top p-2" id="contentLinkPago">
                        <div class="mx-1">
                            <p class="fs--2 mb-0 fw-bold">{{ __('¿Alguien más pagará esta cita?') }}</p>
                            <p class="fs--2 mb-0">{{ __('Genera tu link de pago') }}</p>
                        </div>
                        <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 mx-1">{{ __('Enviar link') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-grayish-blue p-2">
                        <h5 class="text-primary-veris fw-bold m-1">{{ __('Detalles de la cita') }}</h5>
                    </div>
                    <div class="card-body px-2">
                        <div class="mx-1 mt-3">
                            <p class="text-primary-veris fw-bold mb-0">{{ __('Cardiología') }}</p>
                            <p class="fw-bold fs--1 mb-0">{{ __('Veris - Alborada') }}</p>
                            <p class="fs--2 mb-0">{{ __('13/04/2023') }} <b class="text-normal text-primary-veris fw-normal">{{ __('10:20 AM') }}</b></p>
                            <p class="fs--2 mb-0">{{ __('Dr(a): Magdalena Caroline Hernandez Casas') }}</p>
                            <p class="fs--2 mb-0">{{ __('María Yanina Donoso Samaniego') }}</p>
                            <p class="fs--2 mb-0">{{ __('Veris s.a. Veris s.a. 872364592834678o2845768723') }}</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-start align-items-center border-top py-3 px-2">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Puedes <b>reagendar</b> tu cita las veces que necesites.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-5">
                <a href="{{route('citas.datosFacturacion')}}" class="btn btn-primary-veris w-25 px-3">{{ __('Pagar') }}</a>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>

</script>
@endpush