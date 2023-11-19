@extends('template.app-template-veris')
@section('title')
Mi Veris - Buscar doctor
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroSearchDoctors" aria-labelledby="filtroSearchDoctorsLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroSearchDoctorsLabel">Filtros</h5>
            <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atras</b></button>
        </div>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <form action="">
                <h6 class="fw-light">Selecciona la especialidad</h6>
                <div class="list-group gap-2 mb-3">
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked>
                        <span class="text-veris fw-bold">
                            Optometria
                            <small class="fs--2 d-block fw-normal text-body-secondary">Veris - Kennedy</small>
                        </span>
                    </label>
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios2" value="">
                        <span class="text-veris fw-bold">
                            Medicina general
                            <small class="fs--2 d-block fw-normal text-body-secondary">Veris Online</small>
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

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Buscar doctor') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-md-4 my-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0" id="search"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control bg-transparent border-0" name="search" id="search" placeholder="Buscar" aria-describedby="search" />
                </div>
            </div>
        </form>
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroSearchDoctors" aria-controls="filtroSearchDoctors"><i class="bi bi-sliders me-1"></i> Filtros</button>
            </div>
            <div class="col-auto col-lg-10">
                <div class="row gy-3">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" alt="centro medico">
                                    </div>
                                    <div class="col-7">
                                        <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                        <p class="text-primary-veris fw-bold fs--2 mb-0">Veris - Alborada</p>
                                        <p class="fs--2 mb-0">Cardiología</p>
                                    </div>
                                    <div class="col-2 text-center">
                                        <a href="#!" class="btn rounded-pill btn-icon btn-primary-veris"><i class="bi bi-plus-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" alt="centro medico">
                                    </div>
                                    <div class="col-7">
                                        <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                        <p class="text-primary-veris fw-bold fs--2 mb-0">Veris - Alborada</p>
                                        <p class="fs--2 mb-0">Optometría</p>
                                    </div>
                                    <div class="col-2 text-center">
                                        <a href="#!" class="btn rounded-pill btn-icon btn-primary-veris"><i class="bi bi-plus-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje No hay doctores disponibles -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/svg/doctors_search.svg') }}" class="img-fluid mb-3" alt="">
                                    <h5>No hay doctores disponibles</h5>
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