@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Confirmar pago
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="codeinvalid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="codeinvalidLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto">
                            <span class="avatar-initial rounded-circle bg-transparent">
                                <i class="bi bi-exclamation-triangle-fill fs-2 text-danger-veris"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Código inválido</h1>
                        <p class="fs--1 mb-3" style="line-height: 16px;">Código erróneo, inténtalo nuevamente</p>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Confirmar pago') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-transparent shadow-none mt-3">
                    <div class="card-body p-0">
                        <form class="row g-3">
                            <div class="text-center">
                                <div class="avatar avatar-lg mx-auto mb-3">
                                    <span class="avatar-initial rounded-circle bg-primary">
                                        <i class="fa-regular fa-credit-card fs-2"></i>
                                    </span>
                                </div>
                                <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Confirmar pago</h1>
                            </div>
                            <p class="fs--1 mb-3" style="line-height: 16px;"><b class="text-primary">Para continuar con la transacción</b> ingresa el <b>código de seguridad</b> enviado a tu teléfono y/o correo electrónico.</p>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="text" class="form-control" name="code" id="code" placeholder="Código de seguridad (OTP)" required />
                            </div>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Código inválido
                            </div>
                            <div class="col-12 mt-5 pt-md-5">
                                <button type="submit" class="btn btn-lg btn-primary-veris w-100">Confirmar pago</button>
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