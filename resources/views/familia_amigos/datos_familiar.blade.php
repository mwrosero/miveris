@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white" id="nombreFamiliar">{{ __('Juana Donoso') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-4">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-3 py-2">
                        <div class="mx-auto">
                            <p class="fs--2 mb-0">¿Deseas asignar a esta persona como administrador de tu cuenta?</p>
                        </div>
                        <div class="form-check form-switch">
                            <input form="formFamiliarAdmin" class="form-check-input fs-3" type="checkbox" role="switch" name="administrador"id="administrador" />
                        </div>
                    </li>
                </ul>
                <div class="card mb-4">
                    <div class="card-body py-3">
                        <form class="row g-3" id="formFamiliarAdmin">
                            <div class="col-md-12">
                                <p class="fs--1 mb-0">Cédula: <b class="fw-normal" id="numeroIdentificacion">0951716280</b></p>
                            </div>
                            <div class="col-md-12">
                                <label for="tipoParentesco" class="form-label">{{ __('Selecciona el tipo de relación que tienes con esta persona') }} *</label>
                                <select class="form-select form-filter" id="tipoParentesco" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="">Abuelo(a) Mat</option>
                                    <option value="">Abuelo(a) Pat</option>
                                    <option value="">Amigo(a)</option>
                                </select>
                                <div class="invalid-feedback">
                                    Elegir el tipo de parentesco.
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mx-auto mx-lg-3">
                    <button class="btn btn-primary-veris w-100" type="submit" form="formFamiliarAdmin">Guardar</button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script></script>
@endpush