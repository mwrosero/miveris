@extends('template.app-template-veris')
@section('title')
Mi Veris - Resultados
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Resultados') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18 mb-4">{{ __('¿Qué resultados deseas ver?') }}</h5>
        </div>
        <div class="row g-3 g-lg-4 justify-content-center">
            <div class="col-6 col-lg-4">
                <div class="card card-border">
                    <a href="{{route('resultados.laboratorio')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Laboratorio') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/microscopio.svg') }}" class="card-img-top rounded-2" alt="{{ __('Laboratorio') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-6 col-lg-4">
                <div class="card card-border">
                    <a href="{{ route('resultados.ImagenesProcedimientos') }}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Imágenes y procedimientos') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto">
                                <img src="{{ asset('assets/img/card/svg/imagen.svg') }}" class="card-img-top rounded-2" alt="{{ __('Imágenes y procedimientos') }}">
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Mensaje No tienes resultados -->
            <div class="col-12 d-flex justify-content-center d-none">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <h5>No tienes resultados</h5>
                            <p class="my-4">En esta sección podrás revisar los <br> resultados de tus exámenes</p>
                            <img src="{{ asset('assets/img/svg/resultado_1.svg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->

            <!-- Mensaje No tienes permisos de administrador -->
            <div class="col-12 d-flex justify-content-center d-none">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <h5>No tienes permisos de administrador</h5>
                            <p class="my-4">Pídele a esta persona que te otorgue los <br> permisos en la sección <b>Familia y amigos.</b></p>
                            <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->

        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->
@endpush