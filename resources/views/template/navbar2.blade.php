<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme-veris pe-3" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none p-2 px-3 bg-dark-blue-veris">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" style="margin-bottom: 0.225rem;">
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
                <a class="nav-link dropdown-toggle hide-arrow fs-3" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd" id="dropdownNotifications" >
                    <i class="fa-solid fa-bell"></i>
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
                            <span class="align-middle">Mis datos</span>
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
                <a class="btn btn-lg btn-primary-veris w-100" id="logout">Si, cerrar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal PPD -->
<div class="modal fade" id="modalPPD" tabindex="-1" aria-labelledby="modalPPDLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            
            <div class="modal-body p-4 text-center">
                <h1 class="modal-title fs-5 fw-bold mb-3"  id="tituloInformacionCita"
                    >{{ __('Información') }}</h1>
                <p class="mb-0">Como en Veris cuidarte es tan fácil, hemos creado nuevas <a href="https://www.veris.com.ec/politicas/" id="politicasPPD" target="_blank">políticas de privacidad de datos</a> 
            </div>
            <div class="modal-footer flex-nowrap p-0 align-items-center justify-content-center">
                <button type="button" id="aceptarPDP"  class="btn btn-primary-veris btn-lg btn-outline-primary-veris w-100">Aceptar</button>
            </div>
            <div class="">
                <button type="button" class="btn  w-100" id="modalRecuerdame">Recuérdame más tarde </button>
            </div>
        </div>
    </div>
</div>

<!-- Notificaciones -->
<div class="offcanvas offcanvas-end" style="margin-top: 62px;" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header justify-content-end pb-0">
        <button type="button" class="btn btn-sm shadow-none text-decoration-underline" data-bs-dismiss="offcanvas" aria-label="Close">Cerrar</button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 py-0 px-0">
        <h5 id="offcanvasEndLabel" class="offcanvas-title px-3 mb-3 bg-white">Notificaciones</h5>
        <div class="d-flex flex-column border-300" id= "notificaciones" style="min-height: 75vh;">
            <!-- Notificaciones dinamicas -->
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center py-5 d-none" id="noNotificaciones">
            <img src="{{ asset('assets/img/svg/bellNotificacion.svg') }}" alt="" width="50px" class="mb-3">
            <h5 class="fs-0 text-300">No tienes notificaciones</h5>
            <div> En esta sección podrás revisar tus notificaciones</div>
            <img src="{{ asset('assets/img/svg/amico.svg') }}" alt="" class="img-fluid w-50">
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
    } );

    // funciones asincronas
    // notificaciones
    async function getNotificaciones( pagina = 1 ) {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}";

        console.log(codigoUsuario);
        args["endpoint"] = api_url + `/digitalestest/v1/notificaciones/bandeja?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`;
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

            return;
        }
        else {
            $('#noNotificaciones').addClass('d-none');
            $('#notificaciones').removeClass('d-none');
        
            notificaciones.slice(inicio, fin).forEach(notificacion => {
                const bgClass = notificacion.estado !== "LEIDO" ? "bg-light-grayish-cyan" : "";
                htmlContent += `<div class="py-3 border-bottom px-3 ${bgClass}">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="fs--2 text-primary-veris"><i class="fa-solid fa-circle fs--3 me-2"></i> ${determinarCategoria(notificacion.categoria)}</h4>
                                        <span class="fs--3">${notificacion.valorTiempo}</span>
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
            let totalPaginas = Math.ceil(notificaciones.length / notificacionesPorPagina);


            // Agregar paginación al final
            htmlContent += `<div class="px-3 mt-auto">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                                        <a class="page-link bg-transparent" href="#" onclick="cambiarPagina(paginaActual - 1)" aria-label="Previous">
                                            <span aria-hidden="true">&lt;</span>
                                        </a>
                                    </li>
                                    <li class="page-item disabled"><span class="page-link bg-transparent">${pagina} de ${totalPaginas}</span></li>
                                    <li class="page-item ${pagina === totalPaginas ? 'disabled' : ''}">
                                        <a class="page-link bg-transparent" href="#" onclick="cambiarPagina(paginaActual + 1)" aria-label="Next">
                                            <span aria-hidden="true">&gt;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>`;
            
            $('#notificaciones').html(htmlContent);
        }
        
    }


    // cantidad de notificaciones

    async function cantidadNotificaciones(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = "{{Session::get('userData')->numeroIdentificacion}}"
        args["endpoint"] = api_url + `/digitalestest/v1/notificaciones/cantidad?codigoUsuario=${codigoUsuario}`;
        
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

        console.log(codigoUsuario);
        args["endpoint"] = api_url + `/digitalestest/v1/notificaciones/cantidad?codigoUsuario=${codigoUsuario}`;        
        args["method"] = "GET";
        args["showLoader"] = false;
        console.log('no',args["endpoint"] );
        const data = await call(args);
        console.log('numero notificaciones',data);
        if (data.code == 200 ){
            if (data.data.cantidadNotificaciones > 0){
                $('#numeroNotificaciones').removeClass('d-none');
                $('#numeroNotificaciones').html(data.data.cantidadNotificaciones);
                // agregar clase danger
                $('#numeroNotificaciones').addClass('badge-danger');
            } else {
                console.log('no hay notificaciones dsd');
                $('#numeroNotificaciones').addClass('d-none');
                // clear numero notificaciones
                $('#numeroNotificaciones').html('');

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
        }
        return categoriaNotificacion;
    }

    //determinar boton notificacion
    function determinarBotonNotificacion(categoria){
        console.log(2,categoria)
        let botonNotificacion = '';
        switch (categoria) {
            case 'PENDIENTE_PAGO':
                botonNotificacion = ``;
                break;
            case 'CITA_MEDICA':
                botonNotificacion = `<a href="/citas" class="btn btn-sm btn-outline-primary-veris">Agendar cita</a>`;
                break;
            case 'ORDEN_HC':
                botonNotificacion = `<a href="/mis-tratamientos" class="btn btn-sm btn-outline-primary-veris">Ver</a>`;
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
        console.log('activar notificacion ');
        activarNotificacion();
        $('#numeroNotificaciones').addClass('d-none');
        // clear numero notificaciones
        numeroNotificaciones();



    });

    // enviar codigo de notificacion 

    function activarNotificacion(){
        let notificacionesPaginaActual = todasNotificaciones.slice((paginaActual - 1) * notificacionesPorPagina, paginaActual * notificacionesPorPagina);
        console.log('notificaciones pagina actual', notificacionesPaginaActual);
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
        args["endpoint"] = api_url + `/digitalestest/v1/notificaciones/bandeja/leido/${codigoNotificacion}`;
        
        args["method"] = "PUT";
        args["showLoader"] = true;
        console.log(2,args["endpoint"]);
        
        const data = await call(args);
        console.log('cambiar estado notificacion', data);
        if (data.code == 200) {
            cantidadNotificaciones();
        }
    }

    // llamar a la funcion getNotificaciones cuando se de click en la campana
    $('#dropdownNotifications').click(function(){
        getNotificaciones();
    });


</script>
<style>
    .fa-solid.fa-bell {
        position: relative;
        font-size: 24px; /* ajusta el tamaño según sea necesario */
    }

    #numeroNotificaciones {
        position: absolute;
        bottom: 0;
        right: 0;
        transform: translate(50%, 50%);
        font-size: 12px; /* ajusta el tamaño del texto según sea necesario */
    }


</style>