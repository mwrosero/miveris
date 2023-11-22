@extends('template.app-template-veris')
@section('title')
Mi Veris - Resultados
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- modal -->
    <div class="modal fade" id="resultadImagenesProcedimientosModal" tabindex="-1" aria-labelledby="resultadImagenesProcedimientosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="text-center fw-bold fs-5">Resultados</h1>
                    <!-- items -->
                    <div class="my-3">
                        <p class="text-center fs-normal my-3">EXÁMEN RADIOLÓGICO DEL TORAX, UNA PROYECCIÓN, FRONTAL.</p>
                        <a href="#" class="btn btn-outline-primary-veris w-100">Ver imagen</a>
                    </div>
                    <!-- items -->
                    <div class="my-3">
                        <p class="text-center fs-normal my-3">ECOGRAFÍA - OSTEOMUSCULAR.</p>
                        <a href="#" class="btn btn-outline-primary-veris w-100">Ver imagen</a>
                    </div>
                    <div class="border-top">
                        <a href="#" class="btn btn-primary-veris w-100 mt-3">Ver informe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroResultadosLaboratorio" aria-labelledby="filtroResultadosLaboratorioLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroResultadosLaboratorioLabel">Filtros</h5>
            <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atras</b></button>
        </div>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <form action="">
                <h6 class="fw-light">Selecciona el paciente</h6>
                <div class="list-group gap-2 mb-3">
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked>
                        <span class="text-veris fw-bold">
                            Mary Samaniego Loor
                            <small class="fs--3 d-block fw-normal text-body-secondary">Madre</small>
                        </span>
                    </label>
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios2" value="">
                        <span class="text-veris fw-bold">
                            John Donoso Salgado
                            <small class="fs--3 d-block fw-normal text-body-secondary">Padre</small>
                        </span>
                    </label>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="fechaDesde" class="form-label">{{ __('Elige el rango de fechas') }} *</label>
                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                </div>
                <div class="col-md-12 mb-5">
                    <input type="text" class="form-control bg-neutral" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary-veris w-100 mt-5 mb-3 mx-0" type="submit">Aplicar filtros</button>
                    <button class="btn text-primary w-100 mb-3 mx-0" type="submit"><i class="bi bi-trash me-2"></i> Limpiar filtros</button>
                </div>
            </form>
        </div>
    </div>
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Resultados') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroResultadosLaboratorio" aria-controls="filtroResultadosLaboratorio"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
            </div>
            <div class="col-auto col-lg-10">
                <div class="row gy-3">
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <h6 class="text-primary-veris fw-bold fs--1 mb-1">Imágenes - Ecografía</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-1" id="nombreResultadoLab">Tratamiento traumatología</p>
                                <p class="fw-bold fs--2 mb-1" id="ubicacion">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">AGO 09, 2022</b></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                        Ver resultados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <h6 class="text-primary-veris fw-bold fs--1 mb-1">Procedimiento - Ginecología</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-1" id="nombreResultadoLab">Orden externa</p>
                                <p class="fw-bold fs--2 mb-1" id="ubicacion">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">AGO 09, 2022</b></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                        Ver resultados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <h6 class="text-primary-veris fw-bold fs--1 mb-1">Imágenes - Ecografía</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-1" id="nombreResultadoLab">Veris Urgencias</p>
                                <p class="fw-bold fs--2 mb-1" id="ubicacion">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">AGO 09, 2022</b></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                        Ver resultados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <h6 class="text-primary-veris fw-bold fs--1 mb-1">Procedimiento - Cardiología</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-1" id="nombreResultadoLab">Promoción - Semaforo completo: adultos 20 a 40 años - laboratorio completo</p>
                                <p class="fw-bold fs--2 mb-1" id="ubicacion">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">AGO 09, 2022</b></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                        Ver resultados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <h6 class="text-primary-veris fw-bold fs--1 mb-1">Procedimiento</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-1" id="nombreResultadoLab">Tratamiento traumatología / Orden externa / Promoción</p>
                                <p class="fw-bold fs--2 mb-1" id="ubicacion">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">AGO 09, 2022</b></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                        Ver resultados
                                    </button>
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
<!-- script -->
@endpush