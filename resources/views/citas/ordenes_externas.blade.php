@extends('template.app-template-veris')
@section('title')
Mi Veris - Órdenes externas
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="nuevaOrdenExternaModal" tabindex="-1" aria-labelledby="nuevaOrdenExternaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <p class="fw-bold">María</p>
                    <p class="fs--1 mb-0">{{ __('¿Deseas el servicio a domicilio?') }}</p>
                </div>
                <div class="modal-footer justify-content-center px-3 pt-0 pb-3">
                    <a href="{{route('citas.listaPacientes')}}" class="btn btn-primary-veris">{{ __('NO') }}</a>
                    <a href="{{route('citas.listaPacientes')}}" class="btn btn-primary-veris">{{ __('SI') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroOrdenesExternas" aria-labelledby="filtroOrdenesExternasLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroOrdenesExternasLabel">Filtros</h5>
            <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atras</b></button>
        </div>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <form action="">
                <h6 class="fw-light">Selecciona la especialidad</h6>
                <div class="list-group gap-2 mb-3">
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked>
                        <span class="text-veris fw-bold">
                            Mary Samaniego Loor
                            <small class="fs--2 d-block fw-normal text-body-secondary">Madre</small>
                        </span>
                    </label>
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios2" value="">
                        <span class="text-veris fw-bold">
                            John Donoso Salgado
                            <small class="fs--2 d-block fw-normal text-body-secondary">Padre</small>
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

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Órdenes externas') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="text-center my-3">
                <button type="button" class="btn btn-primary-veris px-lg-4" data-bs-toggle="modal" data-bs-target="#nuevaOrdenExternaModal">
                    {{ __('Nueva orden externa') }}
                </button>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroOrdenesExternas" aria-controls="filtroOrdenesExternas"><i class="bi bi-sliders me-1"></i> María Donoso</button>
            </div>
            <div class="row gy-3 justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="row g-3">
                        <!-- items -->
                        <div class="col-12 col-md-6">
                            <div class="card rounded-3" style="border-left: 0.5rem solid #80BC00;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-0">Orden externa laboratorio / 834822</h6>
                                    <p class="fs--1 mb-0">María Donoso Samaniego</p>
                                    <p class="fs--1 mb-0">Valor: <b class="fw-normal">$45.84</b></p>
                                    <p class="text-dark fw-bold fs--1 mb-2">AGO 09, 2021 <b class="fw-bold me-2">10:20 AM</b></p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-lime-veris fs--1"><i class="fa-solid fa-circle me-2"></i>Aprobada</span>
                                        <a href="#" class="btn btn-sm btn-primary-veris fs--1">Solicitar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- items -->
                        <div class="col-12 col-md-6">
                            <div class="card rounded-3" style="border-left: 0.5rem solid #80BC00;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-0">Orden externa laboratorio / 834822</h6>
                                    <p class="fs--1 mb-0">María Donoso Samaniego</p>
                                    <p class="fs--1 mb-0">Valor: <b class="fw-normal">$45.84</b></p>
                                    <p class="text-dark fw-bold fs--1 mb-2">AGO 09, 2021 <b class="fw-bold me-2">10:20 AM</b></p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-lime-veris fs--1"><i class="fa-solid fa-circle me-2"></i>Aprobada</span>
                                        <a href="#" class="btn btn-sm btn-primary-veris fs--1">Solicitar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- items -->
                        <div class="col-12 col-md-6">
                            <div class="card rounded-3" style="border-left: 0.5rem solid #80BC00;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-0">Orden externa laboratorio / 834822</h6>
                                    <p class="fs--1 mb-0">María Donoso Samaniego</p>
                                    <p class="fs--1 mb-0">Valor: <b class="fw-normal">$45.84</b></p>
                                    <p class="text-dark fw-bold fs--1 mb-2">AGO 09, 2021 <b class="fw-bold me-2">10:20 AM</b></p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-lime-veris fs--1"><i class="fa-solid fa-circle me-2"></i>Aprobada</span>
                                        <a href="#" class="btn btn-sm btn-primary-veris fs--1">Solicitar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje El paciente seleccionado no tiene órdenes disponibles. -->
                <div class="col-12 d-flex justify-content-center d-none">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                <h5>El paciente seleccionado no tiene <br> órdenes disponibles.</h5>
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