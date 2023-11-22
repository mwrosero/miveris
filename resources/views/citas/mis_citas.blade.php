@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis citas
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroMisCitas" aria-labelledby="filtroMisCitasLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroMisCitasLabel">Filtros</h5>
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
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Mis citas') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-actuales-tab" data-bs-toggle="pill" data-bs-target="#pills-actuales" type="button" role="tab" aria-controls="pills-actuales" aria-selected="true">Actuales</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-historial-tab" data-bs-toggle="pill" data-bs-target="#pills-historial" type="button" role="tab" aria-controls="pills-historial" aria-selected="false">Historial</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-actuales" role="tabpanel" aria-labelledby="pills-actuales-tab" tabindex="0">
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroMisCitas" aria-controls="filtroMisCitas"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                                <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                            <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                                    AM</b></p>
                                            <p class="fw-normal fs--2 mb-0">Dr(a) Villon Asencio Abel Armando</p>
                                            <p class="fw-normal fs--2 mb-0">Jane Doe</p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <a href="#" class="btn btn-sm btn-primary-veris ms-auto">Cambiar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                                <span class="fs--2 text-warning-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> No atendida</span>
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                            <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                                    AM</b></p>
                                            <p class="fw-normal fs--2 mb-0">Dr(a) Villon Asencio Abel Armando</p>
                                            <p class="fw-normal fs--2 mb-0">Jane Doe</p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <a href="#" class="btn btn-sm btn-primary-veris ms-auto">Cambiar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                                <span class="fs--2 text-danger-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> Pago pendiente</span>
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                            <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                                    AM</b></p>
                                            <p class="fw-normal fs--2 mb-0">Dr(a) Villon Asencio Abel Armando</p>
                                            <p class="fw-normal fs--2 mb-0">Jane Doe</p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                                <div>
                                                    <a href="#" class="btn btn-sm btn-outline-primary-veris">Cambiar</a>
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Pagar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje No tiene cita -->
                    <div class="d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                    <h5 class="mb-0">No tienes citas disponibles aún</h5>
                                    <p class="fs--1">Agende una nueva cita pulsando el botón de abajo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->

                    <!-- botn de agendar -->
                    <div class="text-center">
                        <a href="#" class="btn btn-primary-veris px-lg-5">Agendar cita</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-historial" role="tabpanel" aria-labelledby="pills-historial-tab" tabindex="0">
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroMisCitas" aria-controls="filtroMisCitas"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                                <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                            <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                                    AM</b></p>
                                            <p class="fw-normal fs--2 mb-0">Dr(a) Villon Asencio Abel Armando</p>
                                            <p class="fw-normal fs--2 mb-0">Jane Doe</p>
                                            <div class="d-flex justify-content-end align-items-center mt-3">
                                                <div>
                                                    <a href="#" class="btn btn-sm btn-outline-primary-veris">Calificar</a>
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Reagendar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje No tiene tratamiento -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes tratamientos historial</h5>
                                    <p>En esta sección podrás ver los tratamientos terminados</p>
                                    <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- botn de agendar -->
                    <div class="text-center">
                        <a href="#" class="btn btn-primary-veris px-lg-5">Agendar cita</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#fechaDesde", {
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
        // maxDate: "today"
    });
</script>
@endpush