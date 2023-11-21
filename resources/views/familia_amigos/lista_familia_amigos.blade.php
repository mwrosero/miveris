@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">

    <!-- Modal -->
    <div class="modal fade" id="eliminarFamiliarModal" tabindex="-1" aria-labelledby="eliminarFamiliarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <form action="" id="formEliminarFamiliar">
                        <div class="text-center">
                            <i class="bi bi-exclamation-triangle-fill fs-2 text-danger"></i>
                            <h5 class="mb-3">Eliminar familiar</h5>
                            <p class="fs--2 mb-0">¿Deseas eliminar a <b class="fw-bold" id="nombreFamiliar">Gabriela Alarcón</b> de tu lista?</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center px-3 pt-0">
                    <button type="button" class="btn text-danger" form="formEliminarFamiliar">Eliminar</button>
                    <button type="button" class="btn text-primary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaEliminadaModal" tabindex="-1" aria-labelledby="mensajePersonaEliminadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Persona eliminada de tu grupo</p>
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
                <div class="card bg-transparent shadow-none mb-4">
                    <div class="card-body p-3">
                        <div class="text-center d-none" id="noPeopleAdded">
                            <i class="bi bi-person" style="font-size: 128px;"></i>
                            <p class="fw-bold">Aún no tiene personas agregadas</p>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-4 align-items-center justify-content-center">
                            <div class="list-group list-group-radio d-grid gap-2 border-0 w-100">
                                <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 bg-white px-2">
                                    <div class="col-auto">
                                        <p class="fs--2 fw-bold mb-0">Juan Donoso Samaniego</p>
                                        <p class="fs--3 mb-0">Hermano(a)</p>
                                    </div>
                                    <div class="d-flex">
                                        <button type="button" class="btn px-1 text-danger shadow-none" data-bs-toggle="modal" data-bs-target="#eliminarFamiliarModal">
                                           <i class="bi bi-trash"></i>
                                        </button>
                                        <a href="{{route('familia.datosFamiliar')}}" class="btn px-1 text-primary"><i class="bi bi-chevron-right"></i></a>
                                    </div>
                                </label>

                                <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 bg-white px-2">
                                    <div class="col-auto">
                                        <p class="fs--2 fw-bold mb-0">Juana Donoso Samaniego</p>
                                        <p class="fs--3 mb-0">Hermano(a)</p>
                                    </div>
                                    <div class="d-flex">
                                        <button type="button" class="btn px-1 text-danger shadow-none" data-bs-toggle="modal" data-bs-target="#eliminarFamiliarModal">
                                           <i class="bi bi-trash"></i>
                                        </button>
                                        <a href="{{route('familia.datosFamiliar')}}" class="btn px-1 text-primary"><i class="bi bi-chevron-right"></i></a>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                        <a href="{{route('familia')}}" class="btn btn-primary-veris m-0 w-100">Agregar</a>
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