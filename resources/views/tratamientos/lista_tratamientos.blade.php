@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal Receta médica -->
    <div class="modal fade" id="recetaMedicaModal" tabindex="-1" aria-labelledby="recetaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="fw-bold text-center">{{ __('Receta médica') }}</h5>
                    <p class="text-center lh-1 fs--1 my-3">{{ __('¿Compraste esta receta en otra farmacia distinta a la de Veris y/o tomaste el medicamento?') }}</p>
                    <a href="#" class="btn btn-primary-veris w-100">{{ __('Sí, lo hice') }}</a>
                    <a href="#" class="btn btn w-100">No lo he hecho</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Examenes presencial -->
    <div class="modal fade" id="mensajeLaboratorioPresencialModal" tabindex="-1" aria-labelledby="mensajeLaboratorioPresencialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal">{{ __('Para realizarte este examen acercate a una central médica') }}</p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal VideoConsulta -->
    <div class="modal fade" id="mensajeVideoConsultaModal" tabindex="-1" aria-labelledby="mensajeVideoConsultaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal">{{ __('Para agendar esta videoconsulta llama al') }} <b>{{ __('6009600') }}</b></p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <a href="tel:+59346009600" class="btn btn-primary-veris w-100"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
                    <button type="button" class="btn text-primary-veris w-100" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Tratamiento') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0">
            <div class="col-md-12">
                <div class="card rounded-0 border-0">
                    <div class="card-body p-3 pb-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-9 col-md-10">
                                <h5 class="card-title text-primary mb-0">Traumatología</h5>
                                <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                <p class="fs--2 mb-0">Dr(a): Magdalena Caroline Hernandez...</p>
                                <p class="fs--2 mb-0">Tratamiento enviado: <b class="fw-light text-primary-veris ms-2" id="fechaTratamiento">DIC 09, 2022</b></p>
                                <p class="fs--2 mb-0">SALUDSA-234557 PLANSMART-VERISSA</p>
                            </div>
                            <div class="col-3 col-md-2 col-lg-1">
                                <div id="chart-progress" data-porcentaje="10" data-color="success"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end rounded-0 pb-2">
                        <a href="#" class="btn btn-sm btn-label-primary-veris px-3 mb-2">Ver PDF</a>
                    </div>
                </div>  
                <div class="card rounded-0 border-0">
                    <div class="card-body p-3 position-relative px-lg-5"
                        style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                        <h4 class="fw-bold text-white mb-0">Compra y gestiona</h4>
                        <h6 class=" fw-light text-white mb-0">tu <b>tratamiento</b> sin <b>filas</b></h6>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{route('tratamientos.detalle')}}" class="btn btn-sm btn-primary-veris px-4">Ver tratamiento</a>
                        </div>
                    </div>
                    <div class="position-absolute end-7 bottom-40">
                        <img src="{{ asset('/assets/img/card/carrito_promocion.png') }}" class="img-fluid" width="96" alt="carrito_promocion" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0 px-md-3">
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue">{{ __('Pendientes') }}</h5>
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-3">
                    <!-- items -->
                    <div class="card mb-3">
                        <div class="card-body fs--2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-primary-veris fw-bold mb-0">Receta médica</h6>
                                <span class="text-warning-veris" id="estado"><i class="fa-solid fa-circle me-2"></i>Por comprar</span>
                            </div>
                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary me-2">DIC 09, 2022</b></p>
                            <a href="" class="fs--2" data-bs-toggle="modal" data-bs-target="#recetaMedicaModal">¿Ya compraste esta receta?</a>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                    <img class="rounded-circle" src="{{ asset('assets/img/svg/receta.svg') }}" width="26" alt="receta medica">
                                </div>
                                <div>
                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver receta</a>
                                    <a href="{{route('tratamientos.farmaciaDomicilio')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- items -->
                    <div class="card mb-3">
                        <div class="card-body fs--2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-primary-veris fw-bold mb-0">Cita médica - Traumatología</h6>
                                <span class="text-warning-veris" id="estado"><i class="fa-solid fa-circle me-2"></i>Por comprar</span>
                            </div>
                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary ms-2">DIC 09, 2022</b></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-tratamiento border rounded-circle bg-very-pale-blue">
                                    <img class="rounded-circle" src="{{ asset('assets/img/svg/estetoscopio.svg') }}" width="26" alt="receta medica">
                                </div>
                                <div>
                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1"> Agendar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- items -->
                    <div class="card mb-3">
                        <div class="card-body fs--2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-primary-veris fw-bold mb-0">Interconsulta Fisioterapia</h6>
                                <span class="text-warning-veris" id="estado"><i class="fa-solid fa-circle me-2"></i>Por comprar</span>
                            </div>
                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary ms-2">DIC 09, 2022</b></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-tratamiento border rounded-circle bg-very-pale-blue">
                                    <img class="rounded-circle" src="{{ asset('assets/img/svg/estetoscopio.svg') }}" width="26" alt="receta medica">
                                </div>
                                <div>
                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1"> Agendar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- items -->
                    <div class="card mb-3">
                        <div class="card-body fs--2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-primary-veris fw-bold mb-0">Laboratorio - <b id="codigo">2925136</b></h6>
                                <span class="text-warning-veris" id="estado"><i class="fa-solid fa-circle me-2"></i>Por comprar</span>
                            </div>
                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary ms-2">DIC 09, 2022</b></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-tratamiento border rounded-circle bg-light-grayish-green">
                                    <img class="rounded-circle" src="{{ asset('assets/img/svg/microscopio.svg') }}" width="26" alt="receta medica">
                                </div>
                                <div>
                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                    <a href="{{route('tratamientos.laboratorioDomicilio')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- items -->
                    <div class="card mb-3">
                        <div class="card-body fs--2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-primary-veris fw-bold mb-0">Terapia física 2 - <b id="codigo">2925136</b></h6>
                                <span class="text-warning-veris" id="estado"><i class="fa-solid fa-circle me-2"></i>Por comprar</span>
                            </div>
                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary ms-2">DIC 09, 2022</b></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-tratamiento border rounded-circle bg-very-pale-blue">
                                    <img class="rounded-circle" src="{{ asset('assets/img/svg/muletas.svg') }}" width="26" alt="receta medica">
                                </div>
                                <div>
                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                    <a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"> Agendar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue">{{ __('Realizados') }}</h5>
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-3">
                    <div class="card mb-3">
                        <div class="card-body fs--2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-primary-veris fw-bold mb-0">Terapia física 3 - <b id="codigo">2925136</b></h6>
                                <span class="text-warning-veris" id="estado"><i class="fa-solid fa-circle me-2"></i>Por comprar</span>
                            </div>
                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary ms-2">DIC 09, 2022</b></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-tratamiento border rounded-circle bg-very-pale-blue">
                                    <img class="rounded-circle" src="{{ asset('assets/img/svg/muletas.svg') }}" width="26" alt="receta medica">
                                </div>
                                <div>
                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                    <a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"> Agendar</a>
                                </div>
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