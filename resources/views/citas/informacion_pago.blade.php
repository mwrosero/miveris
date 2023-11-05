@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Información de pago
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Información de pago') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/img/card/tarjeta_pago.png') }}" class="img-fluid mb-3" alt="{{ __('tarjeta de pago') }}">
                        <ul class="list-group bg-white mb-3">
                            <li class="list-group-item border-0 text-primary-veris d-flex justify-content-between align-items-center">
                                Total a pagar:
                                <span class="badge text-primary-veris">$7.00</span>
                            </li>
                        </ul>

                        <!-- content-pago -->
                        <div class="card card-body">
                            <form class="row g-3">
                                <div class="col-md-12">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text border-end-0" id="titularTarjeta"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control border-start-0" id="titularTarjeta" placeholder="Nombre del titular de la tarjeta" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text border-end-0" id="numeroTarjeta"><i class="bi bi-credit-card"></i></span>
                                        <input type="text" class="form-control border-start-0" id="numeroTarjeta" placeholder="Número de tarjeta" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text border-end-0" id="fecha"><i class="bi bi-calendar2"></i></span>
                                        <input type="text" class="form-control border-start-0" id="fecha" placeholder="MM/AA" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text border-end-0" id="ccv"><i class="bi bi-lock"></i></span>
                                        <input type="text" class="form-control border-start-0" id="ccv" placeholder="CCV" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary-veris w-100" type="submit">Pagar</button>
                                </div>
                            </form>
                        </div>
                        <div class="my-3">
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
                        </div>
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