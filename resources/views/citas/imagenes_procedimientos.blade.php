@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Imágenes y procedimientos
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroImagenesProcedimientos" aria-labelledby="filtroImagenesProcedimientosLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroImagenesProcedimientosLabel">Filtros</h5>
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
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Imágenes y procedimientos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-pendientes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Realizados</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroImagenesProcedimientos" aria-controls="filtroImagenesProcedimientos"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
                    </div>
                    <!-- Card header items -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body py-2 px-3">
                                <p class="fs--3 text-primary-veris mb-0">Tratamiento</p>
                                <h5 class="text-primary-veris fw-bold mb-0">Cardiología</h5>
                                <p class="fs--2 fw-bold mb-0">María Yanina Donoso Samaniego</p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">DIC 09, 2022</b></p>
                                <p class="fw-normal fs--2 mb-0">SALUDSA-234557 PLANSMART-VERIS-SA</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Procedimiento</h6>
                                                <span class="fs--2 text-warning-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> Por comprar</span>
                                            </div>
                                            <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar me-2">
                                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-blue">
                                                </div>
                                                <div>
                                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1">Agendar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Procedimiento</h6>
                                                <span class="fs--2 text-warning-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> Por comprar</span>
                                            </div>
                                            <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar me-2">
                                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-blue">
                                                </div>
                                                <div>
                                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1">Agendar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card header items -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body py-2 px-3">
                                <p class="fs--3 text-primary-veris mb-0">Neurología</p>
                                <h5 class="text-primary-veris fw-bold mb-0">Medicina General</h5>
                                <p class="fs--2 fw-bold mb-0">María Yanina Donoso Samaniego</p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">DIC 09, 2022</b></p>
                                <p class="fw-normal fs--2 mb-0">SALUDSA-234557 PLANSMART-VERIS-SA</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Procedimiento</h6>
                                                <span class="fs--2 text-warning-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> Por comprar</span>
                                            </div>
                                            <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar me-2">
                                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-blue">
                                                </div>
                                                <div>
                                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1">Agendar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Procedimiento</h6>
                                                <span class="fs--2 text-warning-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> Por comprar</span>
                                            </div>
                                            <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar me-2">
                                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-blue">
                                                </div>
                                                <div>
                                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1">Agendar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje No tienes imágenes o procedimientos -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes imágenes o procedimientos</h5>
                                    <p>En esta sección podrás revisar tus imágenes o procedimientos</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagen" class="rounded-circle">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->

                    <!-- Mensaje No tienes permisos de administrador -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes permisos de administrador</h5>
                                    <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                    <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->
                </div>
                <div class="tab-pane fade" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroImagenesProcedimientos" aria-controls="filtroImagenesProcedimientos"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
                    </div>
                    <!-- Card header items -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body py-2 px-3">
                                <p class="fs--3 text-primary-veris mb-0">Tratamiento</p>
                                <h5 class="text-primary-veris fw-bold mb-0">Cardiología</h5>
                                <p class="fs--2 fw-bold mb-0">María Yanina Donoso Samaniego</p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">DIC 09, 2022</b></p>
                                <p class="fw-normal fs--2 mb-0">SALUDSA-234557 PLANSMART-VERIS-SA</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Procedimiento</h6>
                                                <span class="fs--2 text-lime-veris fw-bold"><i class="bi bi-check2"></i> Atendida</span>
                                            </div>
                                            <p class="fs--2 fw-bold mb-0">Veris - Alborada</p>
                                            <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="fw-normal text-primary-veris">10:20 AM</b></p>
                                            <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                            <p class="fw-normal fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar me-2">
                                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-blue">
                                                </div>
                                                <div>
                                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                                    <a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1">Ver resultados</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card header items -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body py-2 px-3">
                                <p class="fs--3 text-primary-veris mb-0">Tratamiento</p>
                                <h5 class="text-primary-veris fw-bold mb-0">Traumatología</h5>
                                <p class="fs--2 fw-bold mb-0">María Yanina Donoso Samaniego</p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">DIC 09, 2022</b></p>
                                <p class="fw-normal fs--2 mb-0">SALUDSA-234557 PLANSMART-VERIS-SA</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">Procedimiento</h6>
                                                <span class="fs--2 text-lime-veris fw-bold"><i class="bi bi-check2"></i> Atendida</span>
                                            </div>
                                            <p class="fs--2 fw-bold mb-0">Veris - Alborada</p>
                                            <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="fw-normal text-primary-veris">10:20 AM</b></p>
                                            <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                            <p class="fw-normal fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar me-2">
                                                    <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-blue">
                                                </div>
                                                <div>
                                                    <a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                                                    <a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1">Ver resultados</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje No tienes imágenes o procedimientos realizadas -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes imágenes o procedimientos realizadas</h5>
                                    <p>En esta sección podrás revisar tus ordenes de laboratorio realizadas</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/imagen.svg') }}" alt="imagen" class="rounded-circle">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->

                    <!-- Mensaje No tienes permisos de administrador -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes permisos de administrador</h5>
                                    <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                    <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->
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