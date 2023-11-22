@extends('template.app-template-veris')
@section('title')
Mi Veris - Doctores favoritos
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="eliminarDoctorModal" tabindex="-1" aria-labelledby="eliminarDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="mb-0">Eliminar doctor</h5>
                    <p class="mb-0">¿Estás seguro de eliminar este doctor de su lista de favoritos?</p>
                </div>
                <div class="modal-footer flex-nowrap justify-content-center pt-0 px-0">
                    <button type="button" class="btn btn-link text-primary-veris shadow-none" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#!" class="btn btn-link text-primary-veris shadow-none">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Doctores favoritos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row gx-2">
                            <div class="col-3">
                                <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" alt="centro medico">
                            </div>
                            <div class="col-9">
                                <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-0">Veris - Alborada</p>
                                <p class="fs--2 mb-0">Cardiología</p>
                                <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">Do/Lu/Ma/Mi/Ju/Vi/Sa</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end p-3">
                        <button type="button" class="btn btn-outline-primary-veris btn-sm me-2" data-bs-toggle="modal" data-bs-target="#eliminarDoctorModal">Descartar</button>
                        <a href="#!" class="btn btn-sm btn-primary-veris">Reservar Cita</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row gx-2">
                            <div class="col-3">
                                <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" alt="centro medico">
                            </div>
                            <div class="col-9">
                                <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                <p class="text-primary-veris fw-bold fs--2 mb-0">Veris - Alborada</p>
                                <p class="fs--2 mb-0">Cardiología</p>
                                <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">Do/Lu/Ma/Mi/Ju/Vi/Sa</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end p-3">
                        <button type="button" class="btn btn-outline-primary-veris btn-sm me-2" data-bs-toggle="modal" data-bs-target="#eliminarDoctorModal">Descartar</button>
                        <a href="#!" class="btn btn-sm btn-primary-veris">Reservar Cita</a>
                    </div>
                </div>
            </div>

            <!-- Mensaje Aún no tienes doctores favoritos -->
            <div class="col-12 d-flex justify-content-center d-none">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/svg/doctors_favoritos.svg') }}" class="img-fluid" alt="">
                            <h5>Aún no tienes doctores favoritos</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->
            <div class="col-12 col-md-6 text-center mt-5">
                <a href="{{route('doctoresFavoritos.buscarDoctor')}}" class="btn btn-primary-veris w-50">Buscar doctor</a>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->
@endpush