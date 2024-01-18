@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Información de pago
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
//dd(Session::get('userData'));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal confirmar Pago-->
    <div class="modal fade" id="confirmarPago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmarPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-regular fa-credit-card fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">Confirmar pago</h1>
                    </div>
                    <p class="fs--1 mb-3" style="line-height: 16px;"><b class="text-primary">Para continuar con la transacción</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="text" class="form-control" name="code" id="code" placeholder="Código de seguridad (OTP)" required />
                    </div>
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal informacion-->
    <div class="modal fade" id="informacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="informacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3 py-4">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-info fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">Información</h1>
                        <p class="fs--1 mb-3" style="line-height: 16px;">Esta tarjeta ya está agregada</p>
                    </div>
                    <a href="#" class="btn btn-lg btn-primary-veris w-100 mb-2">Ver tarjeta agregada</a>
                    <button type="button" class="btn btn-lg btn-outline-primary-veris w-100" data-bs-dismiss="modal">Ingresar nueva tarjeta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tarjeta rechazada-->
    <div class="modal fade" id="tarjetaRechazada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tarjetaRechazadaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="tarjetaRechazadaLabel">Tarjeta rechazada</h1>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
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
                                <span class="badge text-primary-veris">$27.00</span>
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