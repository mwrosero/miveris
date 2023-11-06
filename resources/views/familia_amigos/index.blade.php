@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="parentescoFamiliarModal" tabindex="-1" aria-labelledby="parentescoFamiliarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-header justify-content-center align-items-center pt-3 px-3">
                    <h1 class="modal-title fs-6" id="parentescoFamiliarModalLabel">Tipo de relación</h1>
                </div>
                <div class="modal-body p-3">
                    <!-- option 1 -->
                    <div class="list-group list-group-flush text-center fs--1">
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action active" aria-current="true">Abuelo(a) Mat</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Abuelo(a) Pat</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Amigo(a)</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Cónyuge</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Hermano(a)</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Hijo(a)</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Madre</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Otro pariente</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Padre</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Primo(a) Mat</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Primo(a) Pat</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Tío(a) Mat</a>
                        <a href="{{route('familia.lista')}}" class="list-group-item list-group-item-action">Tío(a) Pat</a>
                    </div>
                    <!-- option 2 -->
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-center d-none">
                        <div class="list-group list-group-flush text-center fs--1 w-100">
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco1" value="" checked>
                            <label class="list-group-item" for="listGroupCParentesco1">
                                Abuelo(a) Mat
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco2" value="">
                            <label class="list-group-item" for="listGroupCParentesco2">
                                Abuelo(a) Pat
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco3" value="">
                            <label class="list-group-item" for="listGroupCParentesco3">
                                Amigo(a)
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco4" value="">
                            <label class="list-group-item" for="listGroupCParentesco4">
                                Cónyuge
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco5" value="" checked>
                            <label class="list-group-item" for="listGroupCParentesco5">
                                Hermano(a)
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco6" value="">
                            <label class="list-group-item" for="listGroupCParentesco6">
                                Hijo(a)
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco7" value="">
                            <label class="list-group-item" for="listGroupCParentesco7">
                                Madre
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco8" value="">
                            <label class="list-group-item" for="listGroupCParentesco8">
                                Otro pariente
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco9" value="" checked>
                            <label class="list-group-item" for="listGroupCParentesco9">
                                Padre
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco10" value="">
                            <label class="list-group-item" for="listGroupCParentesco10">
                                Primo(a) Mat
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco11" value="">
                            <label class="list-group-item" for="listGroupCParentesco11">
                                Primo(a) Pat
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco12" value="">
                            <label class="list-group-item" for="listGroupCParentesco12">
                                Tío(a) Mat
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupParentesco" id="listGroupCParentesco13" value="">
                            <label class="list-group-item" for="listGroupCParentesco13">
                                Tío(a) Pat
                            </label>

                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn w-100 text-primary-veris m-0" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaAgregadaModal" tabindex="-1" aria-labelledby="mensajePersonaAgregadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Persona agregada exitosamente</p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Familia y amigos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-4">
                <ul class="list-group bg-white">
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-3 py-2">
                        <div class="mx-auto">
                            <div class="fw-bold h6 mb-0">Hola <b class="user-auth">María</b></div>
                            <p class="fs--2 mb-0">Agrega personas a tu lista de familiares y amigos</p>
                        </div>
                    </li>
                </ul>
                <div class="card bg-transparent shadow-none mb-4">
                    <div class="card-body py-3">
                        <form class="row g-3">
                            <div class="col-md-12">
                                <label for="tipoIdentificacion" class="form-label fw-bold">{{ __('Tipo de identificación') }} *</label>
                                <select class="form-select form-filter" name="tipoIdentificacion" id="tipoIdentificacion" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="">Cédula</option>
                                    <option value="">Pasaporte</option>
                                </select>
                                <div class="invalid-feedback">
                                    Elegir el tipo de identificación.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-bold">{{ __('Número de identificación') }} *</label>
                                <input type="text" class="form-control" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="Ingresa tu número de identificación" required />
                                <div class="invalid-feedback">
                                    Ingresar número de identificación.
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-outline-primary-veris bg-white w-100" type="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <ul class="list-group bg-white mb-3">
                    <li class="list-group-item border-0 d-flex justify-content-start align-items-center px-3 py-2">
                        <div class="me-auto">
                            <div class="fw-bold h6 mb-0">Personas</div>
                        </div>
                    </li>
                </ul>
                <div class="card mx-auto mx-lg-3">
                    <div class="card-body p-2">
                        <p class="fw-bold h6 mb-0">Juana Julia Donoso Samaniego</p>
                        <p class="text-secondary fs--1 mb-0">Cédula: <b class="hora-cita text-veris fw-bold">0999999999</b></p>
                        <p class="text-secondary fs--1 mb-0">Ciudad: <b class="hora-cita text-veris fw-bold">Guayas - Guayaquil</b></p>
                        <p class="text-secondary fs--1 mb-0">Fecha de nacimiento: <b class="hora-cita text-veris fw-bold">1976-08-27</b></p>
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#parentescoFamiliarModal">
                                Agregar
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