@extends('template.app-template-veris')
@section('title')
Mi Veris - Historia clínica
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroHistoriaClinica" aria-labelledby="filtroHistoriaClinicaLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroHistoriaClinicaLabel">Filtros</h5>
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

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Historia clínica') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroHistoriaClinica" aria-controls="filtroHistoriaClinica"><i class="bi bi-sliders me-1"></i> María Donoso</button>
            </div>
            <div class="col-auto col-lg-10">
            </div>
            <div class="row gy-3 justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="d-flex flex-column flex-md-row gap-4 py-md-5 align-items-center justify-content-center">
                        <div class="list-group gap-2 w-100">
                            <!-- Items -->
                            <a href="{{route('historiaClinica.listaDoctores')}}" class="list-group-item list-group-item-action d-flex gap-3 p-3 border-0 rounded bg-white shadow-sm" aria-current="true">
                                <img src="{{ asset('assets/img/svg/especialidades/optometria.svg') }}" alt="especialidad" width="40" height="40" class="rounded-circle flex-shrink-0">
                                <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Optometría</h6>
                                    </div>
                                </div>
                            </a>
                            <!-- Items -->
                            <a href="{{route('historiaClinica.listaDoctores')}}" class="list-group-item list-group-item-action d-flex gap-3 p-3 border-0 rounded bg-white shadow-sm" aria-current="true">
                                <img src="{{ asset('assets/img/svg/especialidades/cardiologia.svg') }}" alt="especialidad" width="40" height="40" class="rounded-circle flex-shrink-0">
                                <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Cardiología</h6>
                                    </div>
                                </div>
                            </a>
                            <!-- Items -->
                            <a href="{{route('historiaClinica.listaDoctores')}}" class="list-group-item list-group-item-action d-flex gap-3 p-3 border-0 rounded bg-white shadow-sm" aria-current="true">
                                <img src="{{ asset('assets/img/svg/especialidades/medicina_general.svg') }}" alt="especialidad" width="40" height="40" class="rounded-circle flex-shrink-0">
                                <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Medicina general</h6>
                                    </div>
                                </div>
                            </a>
                            <!-- Items -->
                            <a href="{{route('historiaClinica.listaDoctores')}}" class="list-group-item list-group-item-action d-flex gap-3 p-3 border-0 rounded bg-white shadow-sm" aria-current="true">
                                <img src="{{ asset('assets/img/svg/especialidades/ginecologia.svg') }}" alt="especialidad" width="40" height="40" class="rounded-circle flex-shrink-0">
                                <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Ginecología</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mensaje El paciente seleccionado no tiene especialidades disponibles. -->
                <div class="col-12 d-flex justify-content-center d-none">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                <h5>El paciente seleccionado no tiene <br> especialidades disponibles.</h5>
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