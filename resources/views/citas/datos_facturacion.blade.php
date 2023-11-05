@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Datos de facturación
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Datos de facturación') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="tipoIdentificacion" class="form-label fw-bold fs--2">{{ __('Elige tu documento') }} *</label>
                                        <select class="form-select" name="tipoIdentificacion" id="tipoIdentificacion" disabled readonly required>
                                            <option selected disabled value="">Seleccionar...</option>
                                            <option value="">Cédula de identidad</option>
                                            <option value="">RUC</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Elegir el tipo de documento.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="numeroIdentificacion" class="form-label fw-bold fs--2">{{ __('Número de documento') }} *</label>
                                        <input type="text" class="form-control" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0975375835" disabled readonly required />
                                        <div class="valid-feedback">
                                            Ingrese un numero de identificacion.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="nombre" class="form-label fw-bold fs--2">{{ __('Nombres y Apellidos') }} *</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="María Yanina Donoso Samaniego" required />
                                        <div class="valid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="direccion" class="form-label fw-bold fs--2">{{ __('Dirección') }} *</label>
                                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Colinas de los ceibos, 318" disabled readonly required />
                                        <div class="invalid-feedback">
                                            Ingrese una direccion.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="telefono" class="form-label fw-bold fs--2">{{ __('Teléfono') }} *</label>
                                        <input type="numbre" class="form-control" name="telefono" id="telefono" placeholder="+593 097 989 3554" required />
                                        <div class="valid-feedback">
                                            Ingrese un telefono.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="mail" class="form-label fw-bold fs--2">{{ __('Email') }} *</label>
                                        <input type="email" class="form-control" name="mail" id="mail" placeholder="micorreo@gmail.com" required />
                                        <div class="valid-feedback">
                                            Ingrese un correo electronico.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group fs--1" style="border-radius: 8px;background: #E7E9EC !important;">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-bold">
                                                {{ __('Detalle de factura') }}
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('Subtotal') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">$36.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('Crédito/convenio') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">-$32.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('Descuento aplicado') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">-$1.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('IVA') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">+$4.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-bold">
                                                {{ __('Total') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">7.00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-5">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input terminos-input me-2" type="checkbox" value="" id="checkTerminosCondicion" required>
                                    <label class="form-check-label fs--1" for="checkTerminosCondicion">
                                        {{ __('Acepto los Términos y condiciones') }}
                                    </label>
                                    <div class="invalid-feedback">
                                        Debes aceptar antes de enviar
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="btn-master w-lg-50 mx-auto">
                                    <a href="{{route('citas.citaInformacionPago')}}" class="btn text-white shadow-none">{{ __('Continuar') }}</a>
                                    |
                                    <p class="btn text-white mb-0 shadow-none cursor-inherit" id="total">$7.00</p>
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