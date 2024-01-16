@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Selecciona tu tarjeta
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal noExisteTarjeta-->
    <div class="modal fade" id="noExisteTarjeta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noExisteTarjetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3 py-4">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-info fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">No existen tarjetas guardadas</h1>
                        <p class="fs--1 mb-3 mx-3" style="line-height: 16px;">Para realizar el pago debes ingresar una tarjeta</p>
                    </div>
                    <a href="{{route('citas.citaInformacionPago')}}" class="btn btn-lg btn-primary-veris w-100 mb-2">Ingresar tarjeta</a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Selecciona tu tarjeta') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <form class="row g-3">
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp1">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp1">
                                        <span class="custom-option-header w-100">
                                            <div>
                                                <img src="{{ asset('assets/img/svg/amex.svg')}}" class="me-3" alt="amex">
                                                <span class="fs--2 mb-0">****3466</span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp2">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp2" disabled>
                                        <span class="custom-option-header w-100">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/img/svg/diners.svg')}}" class="me-3" alt="diners">
                                                <span class="fs--2 mb-0">
                                                    ****3466
                                                    <br>
                                                    <b class="fw-normal text-danger-veris">Tarjeta vencida.</b>
                                                </span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp3">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp3">
                                        <span class="custom-option-header w-100">
                                            <div>
                                                <img src="{{ asset('assets/img/svg/discover.svg')}}" class="me-3" alt="discover">
                                                <span class="fs--2 mb-0">****3466</span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp4">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp4">
                                        <span class="custom-option-header w-100">
                                            <div>
                                                <img src="{{ asset('assets/img/svg/mastecard.svg')}}" class="me-3" alt="mastecard">
                                                <span class="fs--2 mb-0">****3466</span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp5">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp5">
                                        <span class="custom-option-header w-100">
                                            <div>
                                                <img src="{{ asset('assets/img/card/visa.png')}}" class="me-3" width="25" height="20" alt="visa">
                                                <span class="fs--2 mb-0">****3466</span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp6">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp6">
                                        <span class="custom-option-header w-100">
                                            <div>
                                                <img src="{{ asset('assets/img/svg/maestro.svg')}}" class="me-3" alt="maestro">
                                                <span class="fs--2 mb-0">****3466</span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="btn-master w-100 mx-auto">
                                    <a href="{{route('citas.agendada')}}" class="btn text-white shadow-none">{{ __('Pagar') }}</a>
                                    |
                                    <p class="btn text-white mb-0 shadow-none cursor-inherit" id="total">$134.00</p>
                                </div>
                            </div>
                        </form>
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