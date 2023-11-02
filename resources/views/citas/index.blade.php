@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="consultaMedicaModal" tabindex="-1" aria-labelledby="consultaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header">
                    <button type="button" class="btn-close fw-bold top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 pt-2">
                    <h5 class="text-center mb-4">{{ __('Modalidad de la cita') }}</h5>
                    <div class="d-flex justify-content-around align-items-center mb-3">
                        <a href="{{route('citas.listaPacientes')}}" class="btn border py-0 px-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <p class="text-start fs--2 fw-bold mb-0">{{ __('Cita') }} <br> {{ __('presencial') }}</p>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                    <img src="{{ asset('assets/img/svg/consulta_presencial.svg') }}" class="ms-2" alt="consulta prensecial" width="50">
                                </div>
                            </div>
                        </a>
                        <a href="{{route('citas.listaPacientes')}}" class="btn border py-0 px-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <p class="text-start fs--2 fw-bold mb-0">{{ __('Cita virtual') }}</p>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                    <img src="{{ asset('assets/img/svg/consulta_virtual.svg') }}" class="ms-2" alt="consulta virtual" width="50">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Citas') }}</h5>
    <section class="p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">{{ __('Servicios') }}</h5>
        </div>
        <div class="row mb-3">
            <div class="col-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#consultaMedicaModal">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Consulta médica') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/estetoscopio.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Laboratorio') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/microscopio.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Imágenes y procedimientos') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Terapia física') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/muletas.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Recetas médicas') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/recetas.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Orden externa') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/orden_externa.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">{{ __('Mis citas') }}</h5>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Citas pasadas') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/clock.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body py-0">
                        <a href="#">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="fw-bold fs--1 mb-0">{{ __('Próximas citas') }}</h6>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                    <img src="{{ asset('assets/img/svg/calendario.svg') }}" class="ms-2" alt="" width="40">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
</script>
@endpush