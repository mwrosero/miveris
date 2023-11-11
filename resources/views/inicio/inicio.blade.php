@extends('template.app-template-veris')
@section('title')
Mi Veris - Inicio
@endsection
@section('content')
<div class="flex-grow-1 container-p-y">
    <!-- Modal -->
    <div class="modal modal-top fade" id="agendarCitaMedicaModal" tabindex="-1" aria-labelledby="agendarCitaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header">
                    <button type="button" class="btn-close fw-bold top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 pt-2">
                    <h5 class="text-center mb-4">¿Qué quieres agendar?</h5>
                    <div class="d-flex justify-content-around align-items-center mb-3">
                        <a href="#" class="btn border py-0 px-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <p class="text-start fs--2 fw-bold mb-0">Lo que envió <br> mi doctor</p>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                    <img src="{{ asset('assets/img/svg/paste.svg') }}" class="ms-2" alt="paste" width="35">
                                </div>
                            </div>
                        </a>
                        <a href="#" class="btn border py-0 px-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <p class="text-start fs--2 fw-bold mb-0">Una nueva <br> cita médica</p>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                    <img src="{{ asset('assets/img/svg/doctor.svg') }}" class="ms-2" alt="doctor" width="35">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">Acceso rápido</h5>
        </div>
        <div id="respuestaSolicitud"></div>
        <div class="position-relative mb-3">
            <div class="swiper swiper-acceso-rapidos pt-3 pb-4 px-2 mx-n2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body py-0">
                                <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#agendarCitaMedicaModal">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <h6 class="fw-bold mb-0">Agendar cita médica</h6>
                                        </div>
                                        <div class="col-auto border-0 border-start rounded-circle pt-3 ps-2 pe-0">
                                            <img src="{{ asset('assets/img/svg/doctora.svg') }}" class="ms-2" alt="" width="55">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body py-0">
                                <a href="#">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <h6 class="fw-bold mb-0">Comprar promociones</h6>
                                        </div>
                                        <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                            <img src="{{ asset('assets/img/svg/comprar.svg') }}" class="ms-2" alt="" width="55">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body py-0">
                                <a href="#">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <h6 class="fw-bold mb-0">Solicitar servicios <br> a domicilio</h6>
                                        </div>
                                        <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                            <img src="{{ asset('assets/img/svg/motociclista.svg') }}" class="ms-2" alt="" width="55">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="prevProperties" class="d-none mt-n4 btn btn-prev"></button>
            <button type="button" id="nextProperties" class="d-none mt-n4 btn btn-next"></button>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">Mis tratamientos</h5>
            <a href="#!" class="fs--2">Ver todos</a>
        </div>
        <div class="position-relative mb-3">
            <div class="text-center d-none">
                <img src="{{ asset('assets/img/svg/rheumatology.svg') }}" alt="">
                <h6 class="fw-normal">Agenda una cita y revisa tus <b>tratamientos</b> aquí</h6>
            </div>
            <div class="swiper swiper-mis-tratamientos pt-3 pb-4 px-2 mx-n2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-9">
                                        <h6 class="card-title text-primary-veris mb-0">Traumatología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-3">
                                        <div id="chart-progress" data-porcentaje="10" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                    </div>
                                </div>
                                <div class="list-group list-group-checkable d-grid gap-2 border-0 mb-3">
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/receta.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Receta medica</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-blue">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/muletas.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Terapia fisica 1</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-9">
                                        <h6 class="card-title text-primary-veris mb-0">Otrorrinolaringología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-3">
                                        <div id="chart-progress" data-porcentaje="50" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                    </div>
                                </div>
                                <div class="list-group list-group-checkable d-grid gap-2 border-0 mb-3">
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/receta.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Receta medica</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-light-grayish-green">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/microscope.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Terapia fisica 1</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-9">
                                        <h6 class="card-title text-primary-veris mb-0">Dermatología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-3">
                                        <div id="chart-progress" data-porcentaje="30" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                    </div>
                                </div>
                                <div class="list-group list-group-checkable d-grid gap-2 border-0 mb-3">
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/receta.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Receta medica</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-light-grayish-green">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/microscope.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Terapia fisica 1</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-9">
                                        <h6 class="card-title text-primary-veris mb-0">Traumatología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-3">
                                        <div id="chart-progress" data-porcentaje="20" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                    </div>
                                </div>
                                <div class="list-group list-group-checkable d-grid gap-2 border-0 mb-3">
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/receta.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Receta medica</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-3" for="">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-blue">
                                                <img class="rounded-circle" src="{{ asset('assets/img/svg/muletas.svg') }}" width="26" alt="receta medica">
                                            </div>
                                            <p class="fw-bold fs--2 mb-0">Terapia fisica 1</p>
                                        </div>
                                        <a href="#" class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-3"></i></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="prevProperties" class="mt-n4 btn btn-prev"></button>
            <button type="button" id="nextProperties" class="mt-n4 btn btn-next"></button>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">Próximas citas</h5>
            <a href="#!" class="fs--2">Ver todos</a>
        </div>
        <div class="position-relative mb-3">
            <div class="swiper swiper-proximas-citas pt-3 pb-4 px-2 mx-n2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20 AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Cardiologia</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris - Alborada</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="prevProperties" class="mt-n4 btn btn-prev"></button>
            <button type="button" id="nextProperties" class="mt-n4 btn btn-next"></button>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">Urgencias ambulatorias</h5>
            <a href="#!" class="fs--2">Ver todos</a>
        </div>
        <div class="position-relative mb-3">
            <div class="swiper swiper-urgencias-ambulatorias pt-3 pb-4 px-2 mx-n2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Módulo 5</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Reservado</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris Urgencias Ambulatorias</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Módulo 5</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Reservado</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris Urgencias Ambulatorias</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Módulo 5</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Reservado</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris Urgencias Ambulatorias</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-bold mb-0">Módulo 5</h6>
                                    <span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Reservado</span>
                                </div>
                                <p class="fw-bold fs--2 mb-0">Veris Urgencias Ambulatorias</p>
                                <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20
                                        AM</b></p>
                                <p class="fw-normal fs--2 mb-0">Dr(a) Moreno Obando Jaime Roberto</p>
                                <p class="fw-normal fs--2 mb-0">Fernanda Alarcon Tapia</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                    <a href="#" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="prevProperties" class="mt-n4 btn btn-prev"></button>
            <button type="button" id="nextProperties" class="mt-n4 btn btn-next"></button>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPPD();
    });

    //metodos jquery
    //aceptar politicas
    $('#aceptarPDP').click(async function(){
            console.log("clicks");
            const response = await aceptarPoliticas();
            console.log("sisi",response);
            if(response.code == 200){
                localStorage.setItem('estadoPoliticas', response.data.estadoPoliticas);
                $('#modalPPD').modal('hide');
            }
            
        });
    //cerrar el modal de politicas reuerdame
    $(document).on('click', '#modalRecuerdame', function(){
        console.log('click');
        localStorage.setItem('politicaspoliticasAbiertas', true);
        $('#modalPPD').modal('hide');
    });



    //  ---Funciones asyncronas
    //obtener las politicas
    let _ppd;
    async function obtenerPPD(){
        let args = [];
        args["endpoint"] = api_url + "/digitales/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1";
        args["method"] = "GET";
        args["showLoader"] = false;

        const data = await call(args);
        _ppd = data.data;
        if(data.code == 200){
            console.log(data.data)

            if(localStorage.getItem('politicasAbiertas') == null){
                console.log('emtro');
                let politicas = JSON.parse(localStorage.getItem('politicas'));
                if((data.data.estadoPoliticas == "N" || data.data.estadoPoliticas == "R") && (data.data.isPoliticasAceptadas == null || data.data.isPoliticasAceptadas == false)){
                    localStorage.setItem('politicasAbiertas', true);
                    $('#modalPPD').modal('show');
                    $('#politicasPPD').attr('href',politicas.linkPoliticaPrivacidad);
                }
                else {
                    // localStorage.setItem('estadoPoliticas', data.data.estadoPoliticas);
                    // localStorage.setItem('isPoliticasAceptadas', data.data.isPoliticasAceptadas);
                    $('#modalPPD').modal('hide');
                }
            }
            else {
                $('#modalPPD').modal('hide');
            }
        }
    }
    //aceptar las politicas
    async function aceptarPoliticas(){
        let args = [];
        args["endpoint"] = api_url + "/digitales/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}";
        args["method"] = "POST";
        args["showLoader"] = false;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            
            "aceptaPoliticas": true,
            "versionPoliticas": _ppd.ultimaVersionPoliticas,
            "codigoEmpresa": 1,
            "plataforma": "WEB",
            "versionPlataforma": "7.0.1",
            "identificacion": "{{ Session::get('userData')->numeroIdentificacion }}",
            "tipoIdentificacion": {{ Session::get('userData')->codigoTipoIdentificacion }},
            "tipoEvento": "CR",
            "canalOrigen": _canalOrigen

        });
        const data = await call(args);
        return data;
    }

</script>

@endpush