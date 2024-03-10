<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme-veris pe-3" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none p-2 px-3 bg-dark-blue-veris">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" style="margin-bottom: 0.10rem;">
            <i class="ti ti-menu-2 ti-sm text-white"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Logo veris -->
        <a class="navbar-brand mx-auto" href="/">
            <img src="{{ asset('assets/img/veris/logo-veris.svg') }}" class="ml-lg-10" alt="veris" width="84">
        </a>
        <ul class="navbar-nav flex-row align-items-center">
            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1" id="dropdownNotifications">
                <a class="nav-link dropdown-toggle hide-arrow fs-3 position-relative" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd" id="dropdownNotifications" >
                    <i class="fa-solid fa-bell"></i>
                    {{-- <span class="badge rounded-pill badge-notification bg-danger campana-notificaciones">9</span> --}}
                    <span class="icon-button__badge d-none" id="numeroNotificaciones"></span>
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
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0" href="{{route('home.misDatos')}}">
                            <i class="fa-solid fa-user text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Mis datos</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0" href="{{route('home.politicaPrivacidadDatos')}}">
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
</nav>

<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <h5 class="fs-24 line-height-28 my-3">Cerrar sesión</h5>
                <p class="fs--16 line-height-20 text-veris mb-0">¿Estás seguro que deseas cerrar sesión?.</p>
                <div class="d-flex">
                    <button type="button" class="btn btn-lg btn-outline-primary-veris fs--18 col me-1 mt-3 m-0 px-4 py-3" data-bs-dismiss="modal">No</button>
                    <a class="btn btn-lg btn-primary-veris fs--18 col ms-1 mt-3 m-0 px-4 py-3" id="logout">Si, cerrar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal PPD -->
<div class="modal fade" id="modalPPD" tabindex="-1" aria-labelledby="modalPPDLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <h5 class="fs-24 line-height-28 my-3"  id="tituloInformacionCita">{{ __('Información') }}</h5>
                <p class="fs--1 line-height-16 mb-0">Como en Veris cuidarte es tan fácil, hemos creado nuevas <a href="https://www.veris.com.ec/politicas/" id="politicasPPD" target="_blank">políticas de privacidad de datos</a></p>
                <div class="d-flex flex-column">
                    <button type="button" id="aceptarPDP" class="btn btn-lg btn-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3">Aceptar</button>
                    <button type="button" class="btn btn-lg shadow-none text-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3" id="modalRecuerdame">Recuérdame más tarde </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notificaciones -->
<div class="offcanvas offcanvas-end" style="margin-top: 62px;" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header flex-column align-items-start p-0">
        <div class="w-100 px-4 py-2 text-end" style="background: #F3F4F5;">
            <button type="button" class="btn btn-sm fs--1 text-primary-veris fw-normal line-height-16 shadow-none text-decoration-underline p-2" data-bs-dismiss="offcanvas" aria-label="Close">Cerrar</button>
        </div>
        <h5 class="offcanvas-title fs-20 line-height-24 w-100 px-4 py-3 bg-white" id="offcanvasEndLabel">Notificaciones</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 py-0 px-0" style="background: #F3F4F5 !important;">
        <div class="d-flex flex-column border-300" id="notificaciones" style="min-height: 75vh;">
            <!-- Notificaciones dinamicas -->
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center py-5 d-none" id="noNotificaciones">
            <img src="{{ asset('assets/img/svg/bellNotificacion.svg') }}" alt="" width="50px" class="mb-3">
            <h5 class="fs-24 line-height-28 fw-medium mb-4">No tienes notificaciones</h5>
            <p class="fs--16 line-height-20 text-veris fw-normal mb-4 w-75 text-center"> En esta sección podrás revisar tus notificaciones</p>
            <img src="{{ asset('assets/img/svg/amico.svg') }}" alt="" class="img-fluid w-50">
        </div>
    </div>
    <div class="offcanvas-footer" style="background: #F3F4F5;">
        <div class="" id="paginationContainer">
            <!-- Paginación aquí -->
        </div>
    </div>
</div>

<script>
    // variables globales
    let paginaActual = 1;
    const notificacionesPorPagina = 5;
    let todasNotificaciones = [];

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        // await cantidadNotificaciones();
        await numeroNotificaciones();
    });

    // funciones asincronas
    // notificaciones
    async function getNotificaciones( pagina = 1 ) {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}";

        console.log(codigoUsuario);
        args["endpoint"] = api_url + `/${api_war}/v1/notificaciones/bandeja?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`;
        args["method"] = "GET";
        args["showLoader"] = true;

        console.log(1,args["endpoint"]);
        const data = await call(args);
        if (data.code == 200) {
            todasNotificaciones = data.data;    
            mostrarNotificaciones(pagina);
        } else if (data.code != 200) {
            console.log('error', data);
        }
        return data;
    }

    function mostrarNotificaciones(pagina) {
        let htmlContent = '';
        const notificaciones = todasNotificaciones;
        // Calcular el rango de notificaciones a mostrar
        const inicio = (pagina - 1) * notificacionesPorPagina;
        const fin = inicio + notificacionesPorPagina;

        if (notificaciones.length === 0) {
            $('#noNotificaciones').removeClass('d-none');
            $('#notificaciones').addClass('d-none');
            $('#paginationContainer').addClass('d-none'); // Ocultar la paginación cuando no hay notificaciones
            return;
        } else {
            $('#noNotificaciones').addClass('d-none');
            $('#notificaciones').removeClass('d-none');
            $('#paginationContainer').removeClass('d-none'); // Mostrar la paginación cuando hay notificaciones

            notificaciones.slice(inicio, fin).forEach(notificacion => {
                const bgClass = notificacion.estado !== "LEIDO" ? "bg-light-grayish-cyan" : "bg-white";
                htmlContent += `
                                <div class="py-3 border-bottom px-3 ${bgClass}">
                                    <div class="d-flex justify-content-between">
                                        <p class="fs--2 text-primary-veris line-height-16 fw-medium mb-0"><i class="fa-solid fa-circle fs--3 me-2"></i> ${determinarCategoria(notificacion.categoria)}</p>
                                        <span class="fs--3">${notificacion.valorTiempo}</span>
                                    </div>
                                    <div class="flex-1 ms-4">
                                        <p class="fs--2 text-1000 mb-2 mb-sm-3 fw-normal">
                                            ${notificacion.mensajeNotificacion}
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        ${determinarBotonNotificacion(notificacion.categoria, notificacion.codigoNotificacion)}
                                    </div>
                                </div>
                `;
            });
            let totalPaginas = Math.ceil(notificaciones.length / notificacionesPorPagina);
            $('#notificaciones').html(htmlContent);
            // Agregar paginación al final
            let paginationHtml  = `
                        <div class="p-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mb-0">
                                    <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                                        <a class="page-link bg-transparent" href="#" onclick="cambiarPagina(paginaActual - 1)" aria-label="Previous">
                                            <i class="bi bi-chevron-left fs-20"></i>
                                        </a>
                                    </li>
                                    <li class="page-item my-auto disabled"><span class="page-link bg-transparent line-heigth-16 d-flex">${pagina} <div class="mx-2"> de </div> ${totalPaginas}</span></li>
                                    <li class="page-item ${pagina === totalPaginas ? 'disabled' : ''}">
                                        <a class="page-link bg-transparent" href="#" onclick="cambiarPagina(paginaActual + 1)" aria-label="Next">
                                            <i class="bi bi-chevron-right fs-20"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
            `;
            
            $('#paginationContainer').html(paginationHtml);
        }
        
    }

    // cantidad de notificaciones
    async function cantidadNotificaciones(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}"
        args["endpoint"] = api_url + `/${api_war}/v1/notificaciones/cantidad?codigoUsuario=${codigoUsuario}`;
        
        args["method"] = "GET";
        args["showLoader"] = false;
        console.log(2,args["endpoint"]);
        
        const data = await call(args);
        console.log('cantidad notificaciones', data);
        if (data.code == 200) {
            let cantidadNotificaciones = data.data.cantidadNotificaciones;
            console.log('iii',cantidadNotificaciones);
            if (cantidadNotificaciones > 0) {
                $('#badgeNotificaciones').html(cantidadNotificaciones);
                $('#badgeNotificaciones').removeClass('d-none');
            } else {
                $('#badgeNotificaciones').html(cantidadNotificaciones);
                
                $('#badgeNotificaciones').removeClass('d-none');
                // $('#badgeNotificaciones').addClass('d-none');
            }
        }
    }

    // recibir numero de notificaciones
    async function numeroNotificaciones(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}"

        // console.log(codigoUsuario);
        args["endpoint"] = api_url + `/${api_war}/v1/notificaciones/cantidad?codigoUsuario=${codigoUsuario}`;        
        args["method"] = "GET";
        args["showLoader"] = false;
        // console.log('no',args["endpoint"] );
        const data = await call(args);
        // console.log('numero notificaciones',data);
        if (data.code == 200 ){
            if (data.data.cantidadNotificaciones > 0){
                $('#numeroNotificaciones').removeClass('d-none');
                $('#numeroNotificaciones').html(data.data.cantidadNotificaciones);
            }            
        return data;
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
            case 'ORDEN_HC':
                categoriaNotificacion = 'Revisa tus ordenes';
                break;
            case 'CITA_MEDICA':
                categoriaNotificacion = 'Agenda tu cita';
                break;
            case 'REAGENDAR_CITA' :
                categoriaNotificacion = 'Recordatorio';
                break;
            case 'PROXIMA_CITA' :
                categoriaNotificacion = 'Agendaste una cita';
                break;
        }
        return categoriaNotificacion;
    }

    //determinar boton notificacion
    function determinarBotonNotificacion(categoria, codigoNotificacion){
        // console.log(2,categoria)
        let botonNotificacion = '';
        switch (categoria) {
            case 'PENDIENTE_PAGO':
                botonNotificacion = ``;
                break;
            case 'CITA_MEDICA':
                botonNotificacion = `<div onclick="actualizarEstadoNotificacion(${codigoNotificacion}, '/citas"')" class="btn text-primary-veris fw-medium fs--2 p-0" href="/citas" class="fs--1 text-primary-veris">Agendar cita</div>`;
                break;
            case 'ORDEN_HC':
                botonNotificacion = `<div onclick="actualizarEstadoNotificacion(${codigoNotificacion}, '/mis-tratamientos')" class="btn text-primary-veris fw-medium fs--2 p-0" href="/mis-tratamientos" class="fs--1 text-primary-veris">Ver</div>`;
                break;
            case 'REAGENDAR_CITA' :
                botonNotificacion = `<div onclick="actualizarEstadoNotificacion(${codigoNotificacion}, '/mis-citas')" class="btn text-primary-veris fw-medium fs--2 p-0" href="/mis-citas" class="fs--1 text-primary-veris">Reagendar</div>`;
                break;
            case 'PROXIMA_CITA' :
                botonNotificacion = `<div onclick="actualizarEstadoNotificacion(${codigoNotificacion}, '/mis-citas')" class="btn text-primary-veris fw-medium fs--2 p-0" href="/mis-citas" class="fs--1 text-primary-veris">Ver</div>`;
                break;
        }
        return botonNotificacion;
    }

    function cambiarPagina(nuevaPagina) {
        if (nuevaPagina < 1 || nuevaPagina > Math.ceil(todasNotificaciones.length / notificacionesPorPagina)) {
            return;
        }
        paginaActual = nuevaPagina; // Actualizar la variable paginaActual
        mostrarNotificaciones(paginaActual);
        activarNotificacion();
    }

    // cambiar estado de notificacion
    $('#dropdownNotifications').click(function(){
        // enviar el id de la notificacion de las notificaciones que estan en la pagina actual
        // console.log('activar notificacion ');
        activarNotificacion();
        $('#numeroNotificaciones').addClass('d-none');
        // clear numero notificaciones
        numeroNotificaciones();
    });

    // enviar codigo de notificacion 
    function activarNotificacion(){
        let notificacionesPaginaActual = todasNotificaciones.slice((paginaActual - 1) * notificacionesPorPagina, paginaActual * notificacionesPorPagina);
        // console.log('notificaciones pagina actual', notificacionesPaginaActual);
        notificacionesPaginaActual.forEach(notificacion => {
            if (notificacion.estado !== "LEIDO") {
                cambiarEstadoNotificacion(notificacion.codigoNotificacion);
            }
        });
    }

    // cambia estado de notificacion a leido
    async function cambiarEstadoNotificacion(codigoNotificacion){
        let args = [];
        let canalOrigen = _canalOrigen;
        args["endpoint"] = api_url + `/${api_war}/v1/notificaciones/bandeja/leido/${codigoNotificacion}`;
        
        args["method"] = "PUT";
        args["showLoader"] = true;
        // console.log(2,args["endpoint"]);
        
        const data = await call(args);
        // console.log('cambiar estado notificacion', data);
        if (data.code == 200) {
            cantidadNotificaciones();
        }
    }

    // llamar a la funcion getNotificaciones cuando se de click en la campana
    $('#dropdownNotifications').click(function(){
        getNotificaciones();
    });

    async function actualizarEstadoNotificacion(codigoNotificacion, url){
        let args = [];
        let canalOrigen = _canalOrigen;
        args["endpoint"] = api_url + `/${api_war}/v1/notificaciones/bandeja/leido/${codigoNotificacion}`;
        
        args["method"] = "PUT";
        args["showLoader"] = true;
        // console.log(2,args["endpoint"]);
        
        const data = await call(args);
        // console.log('cambiar estado notificacion', data);
        if (data.code == 200) {
            location.href = url;
        }
    }
</script>
<style>
    .fa-solid.fa-bell {
        position: relative;
        font-size: 24px; /* ajusta el tamaño según sea necesario */
    }

    /*#numeroNotificaciones {
        position: absolute;
        bottom: 0;
        right: 0;
        transform: translate(50%, 50%);
        font-size: 12px;
    }*/

    .verisNotificacion {
        font-family: Gotham Rounded;
        font-size: 14px;
        font-weight: 350;
        line-height: 16px;
        letter-spacing: 0em;
        text-align: left;
        color: #0071CE;
    }

    .icon-button__badge {
        position: absolute;
        top: 13px;
        right: -10px;
        width: 12px;
        height: 12px;
        background: #ef4f62;
        color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 40%;
        padding: 9px;
    }

    .layout-navbar {
        height: 3.74rem !important;
    }
</style>