@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="plaPreventivoModal" tabindex="-1" aria-labelledby="plaPreventivoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>¿Quién va a utilizar el plan preventivo?</h6>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <!-- Opcion 1 -->
                        <div class="list-group list-group-checkable d-grid gap-2 border-0">
                            <a href="#" class="list-group-item list-group-item-action border rounded-3 py-2" aria-current="true">
                                <p class="fs--2 mb-0">Fernanda Alarcon Tapia</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border rounded-3 py-2" aria-current="true">
                                <p class="fs--2 mb-0">Julia Tapia Lopez</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border rounded-3 py-2" aria-current="true">
                                <p class="fs--2 mb-0">Gabriela Alarcon Tapia</p>
                            </a>
                        </div>

                        <!-- opcion 2 -->
                        <div class="list-group list-group-checkable d-grid gap-2 border-0 d-none">
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios1" value="" checked>
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios1">
                                Fernanda Alarcon Tapia
                            </label>
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios2">
                                Julia Tapia Lopez
                            </label>
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios3" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios3">
                                Gabriela Alarcon Tapia
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Detalle') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="{{ asset('assets/img/veris/veris-v.svg') }}" class="img-fluid mb-3" alt="{{ __('veris') }}">
                            <h4 class="">{{ __('Plan preventivo') }}</h4>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <p class="fs--1 fw-normal">Vitamina C X2</p>
                            <div class="col-auto text-end lh-1">
                                <h5 class="text-primary-veris mb-0">$ 54.19</h5>
                                <p class="text-veris fs--1 fw-semibold mb-0">-30% OFF</p>
                                <p class="fs--1 mb-0" style="color: #6E7A8C !important;"><del>$ 54.19</del></p>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="fs--2">
                                    Mantente sano y protegido con la aplicación de 2 dosis de vitamina C.
                                    Importante: El paciente deberá presentar la orden médica que prescriba la aplicación de esta prestación.
                                    *Aplica para mayores de 18 años
                                </p>
                                <h6 class="text-start">DETALLES DE PAQUETE</h6>
                                <ul class="fs--2">
                                    <li class="mb-2">2 Biomolec Vitamina C,</li>
                                    <li class="mb-2">2 infusión intravenosa para tratamiento/diagnóstico, administrado por el médico, o bajo sus directa supervisión, hasta una hora.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Button trigger modal -->
                        <div class="text-center">
                            <button type="button" class="btn btn-primary-veris w-100 py-3" data-bs-toggle="modal" data-bs-target="#plaPreventivoModal">
                                Continuar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script></script>
@endpush