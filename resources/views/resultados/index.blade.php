@extends('template.app-template-veris')
@section('title')
Mi Veris - Resultados
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Resultados') }}</h5>
    <section class="p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">{{ __('¿Qué resultados deseas ver?') }}</h5>
        </div>
        <div class="row justify-content-center">
            <div class="col-6 col-lg-4 mb-3">
                <div class="card mb-3">
                    <a href="{{route('resultados.laboratorio')}}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Laboratorio') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #F1F8E2;">
                                <img src="{{ asset('assets/img/svg/microscopio.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Laboratorio') }}" width="40">
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-6 col-lg-4 mb-3">
                <div class="card mb-3">
                    <a href="{{ route('resultados.ImagenesProcedimientos') }}">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-auto">
                                <div class="card-body py-0 px-2">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Imágenes y procedimientos') }}</h6>
                                </div>
                            </div>
                            <div class="col-3 col-md-auto rounded-start-circle d-flex justify-content-center align-items-center" style="background: #DEDAF0;">
                                <img src="{{ asset('assets/img/svg/imagen.svg') }}" class="img-fluid my-3 me-1 pe-1 ms-3" alt="{{ __('Imágenes y procedimientos') }}" width="40">
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