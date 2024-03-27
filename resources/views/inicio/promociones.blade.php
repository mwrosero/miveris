@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Promociones
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Promociones') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18">{{ __('¿Qué deseas ver?') }}</h5>
        </div>
        <div class="row g-3 g-lg-4">
            <!-- Promociones compradas -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <a href="/mis-promociones">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-8 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Mis promociones compradas') }}</h6>
                                </div>
                            </div>
                            <div class="col-4 col-md-auto text-end">
                                <img src="{{ asset('assets/img/card/svg/promociones-compradas.svg') }}" class="img-fluid rounded-2" alt="{{ __('Mis promociones compradas') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Comprar promociones -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <a href="/comprar-promociones">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-8 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Comprar promociones') }}</h6>
                                </div>
                            </div>
                            <div class="col-4 col-md-auto text-end">
                                <img src="{{ asset('assets/img/card/svg/comprar-promociones.svg') }}" class="img-fluid rounded-2" alt="{{ __('Comprar promociones') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection