@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Citas Laboratorio
@endsection
@push('css')
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Citas / Laboratorio') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0 justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-start">
                    <h5 class="mb-0">Orden de laboratorio / 17575261</h5>
                    <p class="fw-light">Paciente: <b id="paciente">Franklin Rosero</b> </p>
                </div>
            </div>
            <div class="col-auto">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="overflow-auto" style="min-height:256px; max-height: 256px">
                            <!-- items -->
                            <div class="row g-0 justify-content-between">
                                <div class="col-9 d-flex align-items-center">
                                    <i class="bi bi-check-square-fill fs-5 text-primary me-2"></i>
                                    <p class="text-900 fw-semi-bold fs--2 mb-0">Pcr para coronavirus 2019-ncov (Covid-19)</p>
                                </div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <p class="text-1100 fw-semi-bold fs--2 mb-0">$ 32.40</p>
                                    <i class="bi bi-check-square-fill fs-5 text-success ms-2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="row g-0 justify-content-between">
                                <div class="col-9"><p class="fw-bold text-end text-opcaity mb-0">Subtotal</p></div>
                                <div class="col-3"><p class="fw-light text-end mb-0" id="total">$ 32.40</p></div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-square-fill fs-5 text-success me-2"></i>
                                <p class="text-900 fw-normal fs--2 mb-0"> Pago permitido por este canal</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-dash-square-fill fs-5 text-warning-veris me-2"></i>
                                <p class="text-900 fw-normal fs--2 mb-0"> Pago no permitido por este canal</p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-master w-100">
                                <a href="{{route('citas.citaInformacionPago')}}" class="btn text-white shadow-none">{{ __('Pagar') }}</a>
                                |
                                <p class="btn text-white mb-0 shadow-none cursor-inherit" id="total">$32.40</p>
                            </div>
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