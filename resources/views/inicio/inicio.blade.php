@extends('template.app-template-veris')
@section('title')
Mi Veris - Inicio
@endsection
@section('content')
<div class="flex-grow-1 container-p-y">

    <!-- Modal -->
    <div class="modal modal-top fade" id="agendarCitaMedicaModal" tabindex="-1" aria-labelledby="agendarCitaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered px-1 mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header">
                    <button type="button" class="btn-close fw-bold top-50" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body px-2 pt-2">
                    <h5 class="text-center mb-4">¿Qué quieres agendar?</h5>
                    <div class="d-flex justify-content-around align-items-center mb-3">
                        <a href="#!" class="btn border py-0 px-2">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <p class="text-start fs--2 fw-bold mb-0">Lo que envió <br> mi doctor</p>
                                </div>
                                <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
                                    <img src="{{ asset('assets/img/svg/paste.svg') }}" class="ms-2" alt="paste" width="35">
                                </div>
                            </div>
                        </a>
                        <a href="!#" class="btn border py-0 px-2">
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
            <h5 class="fw-bold border-start-veris ps-3">Acceso rápidos</h5>
        </div>
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
                                        <div class="col-auto border-0 border-start rounded-circle pt-3 px-2">
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
            <button type="button" id="prevProperties" class="d-none d-xxl-block mt-n4 btn btn-prev"></button>
            <button type="button" id="nextProperties" class="d-none d-xxl-block mt-n4 btn btn-next"></button>
        </div>
    </section>
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold border-start-veris ps-3">Mis tratamientos</h5>
            <a href="/" class="fs--2">Ver todos</a>
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
                            <div class="card-body">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-auto">
                                        <h6 class="card-title text-primary-veris mb-0">Traumatología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="progress-circle">
                                            <div class="progress-circle-inner">
                                                <div class="progress-circle-fill"></div>
                                            </div>
                                            <i class="bi bi-check2 mb-5"></i>
                                            <span class="progress-text">1/7</span>
                                        </div>
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
                            <div class="card-body">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-auto">
                                        <h6 class="card-title text-primary-veris mb-0">Otrorrinolaringología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="progress-circle">
                                            <div class="progress-circle-inner">
                                                <div class="progress-circle-fill"></div>
                                            </div>
                                            <i class="bi bi-check2 mb-5"></i>
                                            <span class="progress-text">1/7</span>
                                        </div>
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
                            <div class="card-body">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-auto">
                                        <h6 class="card-title text-primary-veris mb-0">Dermatología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="progress-circle">
                                            <div class="progress-circle-inner">
                                                <div class="progress-circle-fill"></div>
                                            </div>
                                            <i class="bi bi-check2 mb-5"></i>
                                            <span class="progress-text">1/7</span>
                                        </div>
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
                            <div class="card-body">
                                <div class="row gx-0 justify-content-between align-items-center mb-3">
                                    <div class="col-auto">
                                        <h6 class="card-title text-primary-veris mb-0">Traumatología</h6>
                                        <p class="fw-bold fs--2 mb-0">María Yanina Donoso Samaniego</p>
                                        <p class="card-text fs--2">Dr(a): Magdalena Caroline Hernandez...</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="progress-circle">
                                            <div class="progress-circle-inner">
                                                <div class="progress-circle-fill"></div>
                                            </div>
                                            <i class="bi bi-check2 mb-5"></i>
                                            <span class="progress-text">1/7</span>
                                        </div>
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
            <a href="/" class="fs--2">Ver todos</a>
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
            <a href="/" class="fs--2">Ver todos</a>
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