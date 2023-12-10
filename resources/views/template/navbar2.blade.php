<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme-veris pe-3" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none p-2 px-3 bg-dark-blue-veris">
        <a class="nav-item nav-link px-0 me-xl-4 mb-1" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm text-white"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Logo veris -->
        <a class="navbar-brand mx-auto" href="#">
            <img src="{{ asset('assets/img/veris/logo-veris.svg') }}" alt="Bootstrap" width="84">
        </a>
        <ul class="navbar-nav flex-row align-items-center">
            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications d-none">5</span>
                </a>
            </li>
            <!--/ Notification -->
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar-sm avatar-online">
                        <img src="{{ asset('assets/img/avatars/avatar.svg') }}" alt class="h-auto rounded-circle" />
                    </div>
                    <span class="fs--1 ms-2 d-none d-lg-block">{{ Session::get('userData')->nombre }}</span>
                    <i class="fa-solid fa-angle-down d-none d-lg-block ms-2"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end rounded-3 mt-2 py-1">
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0" href="{{route('misDatos')}}">
                            <i class="fa-solid fa-user text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Mi datos</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0" href="{{route('politicaPrivacidadDatos')}}">
                            <i class="fa-solid fa-shield-halved text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Política de privacidad </span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0 cursor-pointer" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa-solid fa-arrow-right-to-bracket text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <h4 class="mb-0">Cerrar sesión</h4>
                <p class="mb-0">¿Estás seguro que deseas cerrar sesión?.</p>
            </div>
            <div class="modal-footer flex-nowrap p-0 align-items-center justify-content-center">
                <button type="button" class="btn btn-lg btn-outline-primary-veris w-100" data-bs-dismiss="modal">No</button>
                <a class="btn btn-lg btn-primary-veris w-100" id= "logout">Si, cerrar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal PPD -->
<div class="modal fade" id="modalPPD" tabindex="-1" aria-labelledby="modalPPDLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <p class="mb-0">Como en Veris cuidarte es tan fácil, hemos creado nuevas <a href="#" id="politicasPPD" target="_blank">políticas de privacidad de datos</a> 
            </div>
            <div class="modal-footer flex-nowrap p-0 align-items-center justify-content-center">
                <button type="button" id="aceptarPDP"  class="btn btn-primary-veris btn-lg btn-outline-primary-veris w-100">Aceptar</button>
            </div>
            <div class="">
                <button type="button" class="btn  w-100" id="modalRecuerdame">Recuerdame más tarde </button>
            </div>
        </div>
    </div>
</div>

<!-- Notificaciones -->
<div class="offcanvas offcanvas-end" style="margin-top: 62px;" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header justify-content-end pb-0">
        <button type="button" class="btn btn-sm shadow-none text-decoration-underline" data-bs-dismiss="offcanvas" aria-label="Close">cerrar</button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 py-0 px-0">
        <h5 id="offcanvasEndLabel" class="offcanvas-title px-3 mb-3">Notificaciones</h5>
        <div class="border-300">
            <div class="py-3 border-bottom px-3 bg-light-grayish-cyan">
                <div class="d-flex justify-content-between">
                    <h4 class="fs--2 text-primary-veris"><i class="fa-solid fa-circle fs--3 me-2"></i> Cita de control.</h4>
                    <span class="fs--3">Ahora</span>
                </div>
                <div class="flex-1 ms-4">
                    <p class="fs--2 text-1000 mb-2 mb-sm-3 fw-normal">
                        <b class="nombre-paciente"> Magdalena</b>, recuerda que tu especialista de <b class="nombre-especialidad"> [especialidad]</b> te envió una cita de control el <b class="fecha"> 00/00/0000</b>
                    </p>
                </div>
                <div class="text-end">
                    <a href="#!" class="text-primary-veris fs--1 fw-bold">Agendar cita</a>
                </div>
            </div>

            <div class="py-3 border-bottom px-3">
                <div class="d-flex justify-content-between">
                    <h4 class="fs--2 text-primary-veris"><i class="fa-solid fa-circle fs--3 me-2"></i> Cita de control.</h4>
                    <span class="fs--3">Ahora</span>
                </div>
                <div class="flex-1 ms-4">
                    <p class="fs--2 text-1000 mb-2 mb-sm-3 fw-normal">
                        <b class="nombre-paciente"> Magdalena</b>, recuerda que tu especialista de <b class="nombre-especialidad"> [especialidad]</b> te envió una cita de control el <b class="fecha"> 00/00/0000</b>
                    </p>
                </div>
                <div class="text-end">
                    <a href="#!" class="text-primary-veris fs--1 fw-bold">Agendar cita</a>
                </div>
            </div>

            <div class="py-3 border-bottom px-3 bg-light-grayish-cyan">
                <div class="d-flex justify-content-between">
                    <h4 class="fs--2 text-primary-veris"><i class="fa-solid fa-circle fs--3 me-2"></i> Cita de control.</h4>
                    <span class="fs--3">Ahora</span>
                </div>
                <div class="flex-1 ms-4">
                    <p class="fs--2 text-1000 mb-2 mb-sm-3 fw-normal">
                        <b class="nombre-paciente"> Magdalena</b>, recuerda que tu especialista de <b class="nombre-especialidad"> [especialidad]</b> te envió una cita de control el <b class="fecha"> 00/00/0000</b>
                    </p>
                </div>
                <div class="text-end">
                    <a href="#!" class="text-primary-veris fs--1 fw-bold">Agendar cita</a>
                </div>
            </div>
        </div>
        <div class="px-3 mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link bg-transparent" href="#" aria-label="Previous">
                            <span aria-hidden="true">&lt;</span>
                        </a>
                    </li>
                    <li class="page-item disabled"><span class="page-link bg-transparent">1 de 2</span></li>
                    <li class="page-item">
                        <a class="page-link bg-transparent" href="#" aria-label="Next">
                            <span aria-hidden="true">&gt;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    

    $('#logout').click(function(){
        localStorage.clear();
        window.location.href = "{{ route('logout') }}";
    });

</script>