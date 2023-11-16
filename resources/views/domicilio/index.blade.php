@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Servicios a domicilio
@endsection
@push('css')
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModal" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3 pb-2">Solicitud exitosa</h1>
                    <p class="fs--1 fw-normal">Un asesor de farmacia te contactará pronto</p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Servicios a domicilio') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label cursor-pointer fw-bold" for="inlineRadio1">Laboratorio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label class="form-check-label cursor-pointer fw-bold" for="inlineRadio2">Farmacia</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Selecciona el paciente</label>
                                <select class="form-select bg-neutral" name="paciente" id="paciente" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="">...</option>
                                    <option value="">...</option>
                                </select>
                                <div class="invalid-feedback">
                                    Elegir un paciente
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Selecciona la ciudad</label>
                                <select class="form-select bg-neutral" name="ciudad" id="ciudad" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="">...</option>
                                    <option value="">...</option>
                                </select>
                                <div class="invalid-feedback">
                                    Elegir una ciudad
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="number" class="form-control bg-neutral"  name="telefono" id="telefono" value="" placeholder="Teléfono móvil" required />
                                <div class="invalid-feedback">
                                    Ingrese un numero de telefono
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control bg-neutral"  name="direccion"id="direccion" value="" placeholder="Dirección" required />
                                <div class="invalid-feedback">
                                    Ingrese una direccion
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-lg btn-primary-veris w-100" type="submit"><i class="bi bi-telephone-fill me-2"></i> Solicitar llamada</button>
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
<script></script>
@endpush