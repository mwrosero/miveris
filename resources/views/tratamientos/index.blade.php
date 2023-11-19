@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis tratamientos
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroTratamientos" aria-labelledby="filtroTratamientosLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroTratamientosLabel">Filtros</h5>
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
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Mis tratamientos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
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
                        <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroTratamientos" aria-controls="filtroTratamientos"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="row gx-0 justify-content-between align-items-center mb-2">
                                                <div class="col-9">
                                                    <h6 class="card-title text-primary-veris mb-0">Traumatología</h6>
                                                    <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                                    <p class="card-text fs--2 mb-0">Dr(a): Magdalena Caroline Hernandez...</p>
                                                    <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="fecha-enviado fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                                </div>
                                                <div class="col-3">
                                                    <div id="chart-progress" data-porcentaje="10" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Empezar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="row gx-0 justify-content-between align-items-center mb-2">
                                                <div class="col-9">
                                                    <h6 class="card-title text-primary-veris mb-0">Otorrinolaringología</h6>
                                                    <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                                    <p class="card-text fs--2 mb-0">Dr(a): Magdalena Caroline Hernandez...</p>
                                                    <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="fecha-enviado fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                                </div>
                                                <div class="col-3">
                                                    <div id="chart-progress" data-porcentaje="80" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a href="{{route('tratamientos.lista')}}" class="btn btn-sm btn-primary-veris">Continuar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="row gx-0 justify-content-between align-items-center mb-2">
                                                <div class="col-9">
                                                    <h6 class="card-title text-primary-veris mb-0">Dermatología</h6>
                                                    <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                                    <p class="card-text fs--2 mb-0">Dr(a): Magdalena Caroline Hernandez...</p>
                                                    <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="fecha-enviado fw-normal text-primary-veris">AGO 09, 2022</b></p>
                                                </div>
                                                <div class="col-3">
                                                    <div id="chart-progress" data-porcentaje="20" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a href="{{route('tratamientos.lista')}}" class="btn btn-sm btn-primary-veris">Continuar</a>
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
                                                <h5>No tienes tratamientos</h5>
                                                <p>En esta sección podrás revisar tus tratamientos</p>
                                                <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Mensaje END -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroTratamientos" aria-controls="filtroTratamientos"><i class="bi bi-sliders me-1"></i> Maria Donoso</button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3">
                                <!-- items -->
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body position-relative p-3">
                                            <div class="position-absolute end-0">
                                                <img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3" alt="golden">
                                            </div>
                                            <div class="text-center">
                                                <div class="col-auto">
                                                    <div id="chart-progress" data-porcentaje="10" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <h6 class="card-title mb-2">Traumatología</h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <p class="fw-bold fs--2 mb-0">¡Tratamiento terminado!</p>
                                                    <p class="fw-normal fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                                    <p class="fw-light fs--2 mb-0">Terminado el: <b class="text-primary-veris fw-light fs--2" id="fechaTratamiento">SEP 09,2022</b></p>
                                                </div>
                                                <div>
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Ver todo</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body position-relative p-3">
                                            <div class="position-absolute end-0">
                                                <img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3" alt="golden">
                                            </div>
                                            <div class="text-center">
                                                <div class="col-auto">
                                                    <div id="chart-progress" data-porcentaje="10" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <h6 class="card-title mb-2">Traumatología</h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <p class="fw-bold fs--2 mb-0">¡Tratamiento terminado!</p>
                                                    <p class="fw-normal fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                                    <p class="fw-light fs--2 mb-0">Terminado el: <b class="text-primary-veris fw-light fs--2" id="fechaTratamiento">SEP 09,2022</b></p>
                                                </div>
                                                <div>
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Ver todo</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body position-relative p-3">
                                            <div class="position-absolute end-0">
                                                <img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3" alt="golden">
                                            </div>
                                            <div class="text-center">
                                                <div class="col-auto">
                                                    <div id="chart-progress" data-porcentaje="10" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <h6 class="card-title mb-2">Traumatología</h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <p class="fw-bold fs--2 mb-0">¡Tratamiento terminado!</p>
                                                    <p class="fw-normal fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                                    <p class="fw-light fs--2 mb-0">Terminado el: <b class="text-primary-veris fw-light fs--2" id="fechaTratamiento">SEP 09,2022</b></p>
                                                </div>
                                                <div>
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Ver todo</a>
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
                                                <h5>No tienes tratamientos realizados</h5>
                                                <p>En esta sección podrás ver los tratamientos terminados</p>
                                                <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
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