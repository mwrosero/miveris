<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme-veris pe-3" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none p-2 px-3 bg-dark-blue-veris">
        <a class="nav-item nav-link px-0 me-xl-4 mb-1" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm text-white"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center d-none">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <i class="ti ti-search ti-md me-2"></i>
                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                </a>
            </div>
        </div>
        <!-- /Search -->
        <!-- Logo veris -->
        <a class="navbar-brand mx-auto" href="#">
            <img src="{{ asset('assets/img/veris/logo-veris.svg') }}" alt="Bootstrap" width="84">
        </a>


        <ul class="navbar-nav flex-row align-items-center">
            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0 d-none">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="fi fi-us fis rounded-circle me-1 fs-3"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="en">
                            <i class="fi fi-us fis rounded-circle me-1 fs-3"></i>
                            <span class="align-middle">English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="fr">
                            <i class="fi fi-fr fis rounded-circle me-1 fs-3"></i>
                            <span class="align-middle">French</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="de">
                            <i class="fi fi-de fis rounded-circle me-1 fs-3"></i>
                            <span class="align-middle">German</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="pt">
                            <i class="fi fi-pt fis rounded-circle me-1 fs-3"></i>
                            <span class="align-middle">Portuguese</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ Language -->

            <!-- Style Switcher -->
            <li class="nav-item me-2 me-xl-0 d-none">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class="ti ti-md"></i>
                </a>
            </li>
            <!--/ Style Switcher -->

            <!-- Quick links  -->
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0 d-none">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="ti ti-layout-grid-add ti-md"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="ti ti-sm ti-apps"></i></a>
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-calendar fs-4"></i>
                                </span>
                                <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                <small class="text-muted mb-0">Appointments</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-file-invoice fs-4"></i>
                                </span>
                                <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                <small class="text-muted mb-0">Manage Accounts</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-users fs-4"></i>
                                </span>
                                <a href="app-user-list.html" class="stretched-link">User App</a>
                                <small class="text-muted mb-0">Manage Users</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-lock fs-4"></i>
                                </span>
                                <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                <small class="text-muted mb-0">Permission</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-chart-bar fs-4"></i>
                                </span>
                                <a href="index.html" class="stretched-link">Dashboard</a>
                                <small class="text-muted mb-0">User Profile</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-settings fs-4"></i>
                                </span>
                                <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                                <small class="text-muted mb-0">Account Settings</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-help fs-4"></i>
                                </span>
                                <a href="pages-help-center-landing.html" class="stretched-link">Help Center</a>
                                <small class="text-muted mb-0">FAQs & Articles</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                    <i class="ti ti-square fs-4"></i>
                                </span>
                                <a href="modal-examples.html" class="stretched-link">Modals</a>
                                <small class="text-muted mb-0">Useful Popups</small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!-- Quick links -->

            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications d-none" id="badgeNotificaciones"></span>
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
        <div class="border-300" id= "notificaciones">
            
            <!-- Notificaciones dinamicas -->
            
        </div>
        
    </div>
</div>

<script>
    

    // llamada al dom

    document.addEventListener("DOMContentLoaded", async function () {
        await getNotificaciones();
        await cantidadNotificaciones();

    } );

    // funciones asincronas
    // notificaciones
    async function getNotificaciones() {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}";

        console.log(codigoUsuario);
        args["endpoint"] = api_url + `/digitalestest/v1/notificaciones/bandeja?canalOrigen= ${canalOrigen}&codigoUsuario=${codigoUsuario}`;
        args["method"] = "GET";
        args["showLoader"] = false;

        const data = await call(args);
        console.log('notificaciones', data);
        let htmlContent = '';

        if (data.data.length > 0) {
            console.log('notificaciones');

            let notificaciones = data.data;
            notificaciones.forEach(notificacion => {
                htmlContent += `<div class="py-3 border-bottom px-3 bg-light-grayish-cyan">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="fs--2 text-primary-veris"><i class="fa-solid fa-circle fs--3 me-2"></i> ${determinarCategoria(notificacion.categoria)}</h4>
                                        <span class="fs--3">Ahora</span>
                                    </div>
                                    <div class="flex-1 ms-4">
                                        <p class="fs--2 text-1000 mb-2 mb-sm-3 fw-normal">
                                            ${notificacion.mensajeNotificacion}
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        ${determinarBotonNotificacion(notificacion.categoria)}
                                        
                                    </div>
                                </div>`;
            });

            // Agregar paginación al final
            htmlContent += `<div class="px-3 mt-5">
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
                            </div>`;
        } else {
            // Caso de no notificaciones
            htmlContent = `<div><p class="fs--2 text-1000 mb-2 mb-sm-3 fw-normal">No tienes notificaciones</p></div>`;
        }

        $('#notificaciones').html(htmlContent);
        return data;
    }


    // cantidad de notificaciones

    async function cantidadNotificaciones(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}"
        args["endpoint"] = api_url + `/digitales/v1/notificaciones/cantidad?codigoUsuario=${codigoUsuario}`;
        
        args["method"] = "GET";
        args["showLoader"] = false;
        console.log(2,args["endpoint"]);
        
        const data = await call(args);
        console.log('cantidad notificaciones', data);
        if (data.code == 200) {
            let cantidadNotificaciones = data.data.cantidadNotificaciones;
            if (cantidadNotificaciones > 0) {
                $('#badgeNotificaciones').html(cantidadNotificaciones);
                $('#badgeNotificaciones').removeClass('d-none');
            } else {
                $('#badgeNotificaciones').addClass('d-none');
            }
        }
    }


    

    // funciones js
    // salir de la sesion
    $('#logout').click(function(){
        localStorage.clear();
        window.location.href = "{{ route('logout') }}";
    });

    // determinar categoria

    function determinarCategoria(categoria){
        let categoriaNotificacion = '';
        switch (categoria) {
            case 'PENDIENTE_PAGO':
                categoriaNotificacion = 'Pago pendiente';
                break;
        }
        return categoriaNotificacion;
    }

    //determinar boton notificacion
    function determinarBotonNotificacion(categoria){
        let botonNotificacion = '';
        switch (categoria) {
            case 'PENDIENTE_PAGO':
                botonNotificacion = ``;
                break;
            case 'CITA_MEDICA':
                botonNotificacion = `<a href="#!" class="btn btn-sm btn-outline-primary-veris">Agendar cita</a>`;
                break;
        }

        return botonNotificacion;
    }

</script>