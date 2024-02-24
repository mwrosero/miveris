@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Receta médica
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- offcanva detalle Receta médica -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detalleRecetaMedica" aria-labelledby="detalleRecetaMedicaLabel">
        <div class="offcanvas-header justify-content-between align-items-center py-2">
            <h5 class="offcanvas-title" id="detalleRecetaMedicaLabel">Detalle de receta</h5>
            <button type="button" class="btn d-block d-md-none" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-arrow-left"></i><b class="fw-medium">Atrás</b>
            </button>
        </div>
        
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <small class="d-none">Activa los recordatorios para notificarte el horario del que debes tomar tus medicinas</small>
            <div>
                <div class="list-group gap-2 mb-3 verPdf">
                    <label class="list-group-item d-flex align-items-center gap--2 border rounded-3 py-3">
                        <div class="d-flex flex-column">
                            <small class="text-veris fw-medium denominacion">
                                RECOMENDACIONES
                            </small>
                            <small class="text-veris fw-light concentracion">
                                concentracion
                            </small>
                            <small class="text-veris fw-light indicaciones">
                                indicaciones
                            </small>
                        </div>
                        <i class="fa-solid fa-bell ms-auto"></i>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="offcanvas-footer px-4">
            <div class="col-md-12">
                <button class="btn btn-primary-veris w-100 py-3 my-3 verPdfReceta" type="button"  data-context="contextoAplicarFiltros">Ver PDF</button>
            </div>
        </div>
    </div>
    <!-- Modal Receta médica -->
    <div class="modal fade" id="recetaMedicaModal" tabindex="-1" aria-labelledby="recetaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <h5 class="fw-medium text-center">{{ __('Receta médica') }}</h5>
                    <p class="text-center lh-1 fs--1 my-3">{{ __('¿Compraste esta receta en otra farmacia distinta a la de Veris y/o tomaste el medicamento?') }}</p>
                    <a href="#" id="btnRecetaMedicaSi" class="btn btn-primary-veris m-0 w-100 px-4 py-3">{{ __('Sí, lo hice') }}</a>
                    <a href="#" class="btn btn m-0 w-100 px-4 py-3" data-bs-dismiss="modal">No lo he hecho</a>
                </div>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Receta médica') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5 active" id="pills-pendientes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Compradas</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
                <!-- Filtro -->
                @include('components.barraFiltro')
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                
                <div class="tab-pane fade mt-3 show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenes" class="px-0">
                    </div>
                    <!-- Mensaje No tienes ordenes de terapia -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientos">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes recetas médicas</h5>
                                    <p class="fs--16 line-height-20 mb-4">En esta sección podrás revisar tus recetas médicas</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/recetas.svg') }}" alt="recetas" class="rounded-circle">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje No tienes permisos de administrador -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministrador">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes permisos de administrador</h5>
                                    <p class="fs--16 line-height-20 mb-4">Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                    <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->
                </div>
                <div class="tab-pane fade mt-3" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenesRealizados" class="px-0">
                    </div>
                    <!-- Mensaje No tienes ordenes de terapia realizadas -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientosRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes ordenes de recetas realizadas</h5>
                                    <p class="fs--16 line-height-20 mb-4">En esta sección podrás revisar tus ordenes de recetas realizadas</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/recetas.svg') }}" alt="recetas" class="rounded-circle">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje No tienes permisos de administrador -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministradorRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes permisos de administrador</h5>
                                    <p class="fs--16 line-height-20 mb-4">Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                    <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->
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

    // variables globales
    let datosLaboratorio = [];
    let identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerTratamientosId();
        await consultarGrupoFamiliar();
    });

    // funciones asyncronas
    // Consultar los tratamientos de un paciente imagen y procedimientos
    async function obtenerTratamientosId(pacienteSeleccionado='', fechaDesde='', fechaHasta='', estado='PENDIENTE', esAdmin='S') {
        console.log('obtenerTratamientosImagenProcedimientos');
        console.log('pacienteSeleccionado', pacienteSeleccionado);
        let args = [];
        let canalOrigen = 'APP_CMV';
                
        let numeroPaciente = '';
        if (pacienteSeleccionado && numeroPaciente != {{ Session::get('userData')->numeroPaciente }}) {
            numeroPaciente = pacienteSeleccionado;
        } else if (pacienteSeleccionado == '' || pacienteSeleccionado == null || pacienteSeleccionado == undefined) {
            numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";
        }
        let admin = esAdmin;
        if (admin == undefined || admin == null) {
            admin = 'S';
        }
        let plataforma = _plataforma;
        let version = _version;
        let servicio = 'FARMACIA';
        fechaDesde = $('#fechaDesde').val() || '';
        fechaHasta = $('#fechaHasta').val() || '';
        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);
        if (estado == 'PENDIENTE') {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
        } else if (estado == 'REALIZADO') {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=TODOS&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=S&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
        }
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(args["endpoint"]);
        const data = await call(args);
        if (!pacienteSeleccionado) {
            data.data.tienePermisoAdmin = true;
        }
        if(estado == 'PENDIENTE'){
            if (data.code == 200) {
                esAdmin = data.data.tienePermisoAdmin;   
                if (numeroPaciente == "{{ Session::get('userData')->numeroPaciente }}") {
                    esAdmin = true;
                }

                if(data.data.items.length == 0){
                    console.log('entrando a pendiente vacio', admin);
                    if (data.data.tienePermisoAdmin) {
                        let html = $('#contenedorTratamientosImagenes');
                        html.empty();
                        $('#mensajeNoTienesImagenesProcedimientos').removeClass('d-none');
                        $('#mensajeNoTienesPermisosAdministrador').addClass('d-none');
                    } else if (!data.data.tienePermisoAdmin) {
                        let html = $('#contenedorTratamientosImagenes');
                        html.empty();
                        $('#mensajeNoTienesPermisosAdministrador').removeClass('d-none');
                        $('#mensajeNoTienesImagenesProcedimientos').addClass('d-none');
                    }                    
                }else{
                    if (data.data.tienePermisoAdmin) {
                        datosLaboratorio = data.data.items;
                        console.log('datosLaboratorio',datosLaboratorio);
                        let html = $('#contenedorTratamientosImagenes');
                        $('#mensajeNoTienesImagenesProcedimientos').addClass('d-none');
                        $('#mensajeNoTienesPermisosAdministrador').addClass('d-none');
                        html.empty();

                        let elementos = ''; // Definir la variable fuera del bucle

                        data.data.items.forEach((laboratorio) => {
                            elementos += `
                                        <div class="col-12 mb-4">
                                            <div class="card rounded-0">
                                                <div class="card-body py-2 px-3">
                                                    <p class="fs--3 line-height-12 text-primary-veris mb-1">Tratamiento</p>
                                                    <h5 class="text-primary-veris fs--18 line-height-24 fw-medium mb-1">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                                                    <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3 px-3">
                                            <div class="col-12 col-md-10 col-lg-9">
                                                <div class="row g-3" id="cardTratamientoLaboratorio">`;
                            laboratorio.detallesTratamiento.forEach((detalles) =>{
                            elementos += `
                                                    <!-- items -->
                                                    <div class="col-12 col-md-6">
                                                        <div class="card">
                                                            <div class="card-body p--2">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                                    <span class="text-warning-veris fs--2 line-height-16 mb-1">${determinarEstado(detalles.esPagada)}</span>
                                                                </div>
                                                                ${determinarFechasCaducadas(detalles, laboratorio)}
                                                                <div class="recetaMedicaMensaje">
                                                                    ${determinarMensajeRecetaMedica(detalles)}
                                                                </div>  
                                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                                    </div>
                                                                    <div>
                                                                        ${determinarCondicionesBotones(detalles, estado)}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            `;                        
                            });
                            elementos += `
                                                </div>
                                            </div>
                                        </div>`;
                        });
                        html.append(elementos); // Agregar todos los elementos después del bucle

                    } else if (!data.data.tienePermisoAdmin) {
                        let html = $('#contenedorTratamientosImagenes');
                        html.empty();
                        $('#mensajeNoTienesPermisosAdministrador').removeClass('d-none');
                    }
                    return data;
                } 
            }
        } else if(estado == 'REALIZADO'){
            console.log('entrando a realizado');
            if (data.code == 200) {
                if(data.data.items.length == 0){
                    console.log('entrando a realizado vacio');
                    if (data.data.tienePermisoAdmin) {
                        let html = $('#contenedorTratamientosImagenesRealizados');
                        html.empty();
                        $('#mensajeNoTienesImagenesProcedimientosRealizados').removeClass('d-none');
                        $('#mensajeNoTienesPermisosAdministradorRealizados').addClass('d-none');
                    } else if (!data.data.tienePermisoAdmin) {
                        let html = $('#contenedorTratamientosImagenesRealizados');
                        html.empty();
                        $('#mensajeNoTienesPermisosAdministradorRealizados').removeClass('d-none');
                        $('#mensajeNoTienesImagenesProcedimientosRealizados').addClass('d-none');
                    }
                } else {
                    if (data.data.tienePermisoAdmin) {
                        console.log('entrando a realizado lleno');
                        datosLaboratorio = data.data.items;
                        console.log('datosLaboratorio',datosLaboratorio);
                        let html = $('#contenedorTratamientosImagenesRealizados');
                        html.empty();
                        console.log('datosLaboratorioR',datosLaboratorio);

                        let elementos = ''; 
                        datosLaboratorio.forEach((laboratorio) => {
                            elementos += `
                                        <div class="col-12 mb-4">
                                            <div class="card rounded-0">
                                                <div class="card-body py-2 px-3">
                                                    <p class="fs--3 line-height-12 text-primary-veris mb-1">Tratamiento</p>
                                                    <h5 class="text-primary-veris fs--18 line-height-24 fw-medium mb-1">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                                                    <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3 px-3">
                                            <div class="col-12 col-md-10 col-lg-9">
                                                <div class="row g-3" id="cardTratamientoLaboratorio">`;
                        
                            laboratorio.detallesTratamiento.forEach((detalles) =>{
                                elementos += `
                                                    <!-- items -->
                                                    <div class="col-12 col-md-6">
                                                        <div class="card">
                                                            <div class="card-body p--2">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                                    <span class="text-warning-veris fs--2 line-height-16 mb-1">${determinarEstado(detalles.esPagada)}</span>
                                                                </div>
                                                                ${determinarFechasCaducadas(detalles, laboratorio)}
                                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                                    </div>
                                                                    <div>
                                                                        ${determinarCondicionesBotones(detalles, estado)} 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`;                        
                            });
                            elementos +=        `</div>
                                            </div>
                                        </div>`;
                        });
                        html.append(elementos); // Agregar todos los elementos después del bucle
                    } else if (!data.data.tienePermisoAdmin) {
                        let html = $('#contenedorTratamientosImagenesRealizados');
                        html.empty();
                        $('#mensajeNoTienesPermisosAdministradorRealizados').removeClass('d-none');
                    }
                } 
                return data;
            } 
        }
    }

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientesFiltro();

        }
        return data;
    }

    // descargar documento pdf
     
    async function descargarDocumentoPdf(datos){
        console.log('datosPdf', datos);
        console.log('dataSecuenciaAtencion', datos.secuenciaAtenciones);
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/hc/archivos/generarDocumento?secuenciaAtencion=${datos.secuenciaAtencion}&tipoServicio=ORDEN&numeroOrden=${datos.idOrden}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);

            window.open(pdfUrl, '_blank');

            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);

        } catch (error) {
            console.error('Error al obtener el PDF:', error);
        }
    }

    //Consultar el detalle de una receta específica.
    async function consultarDetalleReceta(datos){
        console.log('datosDetta', datos);
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/recetas/detallereceta?canalOrigen=${canalOrigen}&codigoReceta=${datos.secuenciaReceta}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        const data = await call(args);
        console.log('data', data);
        if(data.code == 200){
            let html = $('.verPdf');
            html.empty();
            let elementos = '';
            data.data.forEach((receta) => {
                elementos += `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3 py-3">
                                <div class="d-flex flex-column">
                                    <small class="text-veris fw-medium denominacion">
                                        ${agregarEspacios(receta.denominacion)}
                                    </small>
                                    <small class="text-veris fw-light concentracion" style="color: #3D4E66;">
                                        ${receta.concentracion} ${receta.formaFarmaceutica}
                                    </small>
                                    <small class="text-veris fw-light indicaciones style="color: #3D4E66;"">
                                        ${receta.indicaciones}
                                    </small>
                                </div>
                                <i class="fa-solid fa-bell ms-auto"></i>
                            </label>`;
            });
            html.append(elementos);
        }
        return data;
    }

    // obtener la receta en formato pdf
    async function obtenerRecetaPdf(datos){
        console.log('datosPdfff', datos);
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/recetas/archivoreceta?codigoReceta=${datos.secuenciaReceta}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);

            window.open(pdfUrl, '_blank');

            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);

        } catch (error) {
            console.error('Error al obtener el PDF:', error);
        }
    }

    // cambiar el estado del tratamiento a realizada
    async function detalleTratamientoRealizado(datos){
        console.log('datosJson', datos);
        let datosExterna;
        if (datos.esExterna == 'S') {
            datosExterna = true;
        } else {
            datosExterna = false;
        }
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detalle_tratamiento_realizado?origenTransaccion=${canalOrigen}`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify(
            {
                "codigoTratamiento": datos.codigoTratamiento,
                "lineaDetalleTratamiento": datos.lineaDetalleTratamiento,
                "recetas": [
                    {
                        "secuenciaReceta": datos.secuenciaReceta,
                        "esCompraExterna": datosExterna,
                        "fechaRealizado": obtenerFechaActual()
                    }
                ],
                "generarSolicitud": false,
                "fechaRealizado": obtenerFechaActual()
            }
        );

        console.log('args', args["data"]);

        const data = await call(args);
        if (data.code == 200) {
            console.log('datos', data.data);
            // cerrar modal
            $('#recetaMedicaModal').modal('hide');
            // actualizar la lista de tratamientos
            await obtenerTratamientosId();

        } else if (data.code != 200) {
            console.log('errorza');
            // mostrar modal de error
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
    }

    // funciones js 
    // determinar fechas caducadas
    function determinarFechasCaducadas(datos, datosTratamiento){ 
        let dataFechas = ``;
        if (Object.keys(datosTratamiento.datosConvenio).length > 0) {
            if (datos.estado == "PENDIENTE_AGENDAR") {
                if (datos.esCaducado == "S") {
                    dataFechas = `<p class="fw-light fs--2 line-height-16 mb-1">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                } else {
                    dataFechas = `` ;
                }
            }
            if (datos.estado == "AGENDADO" || datos.estado == "ATENDIDO") {
                dataFechas = `<h6 class="card-title fw-medium fs--2 text-dark-primary mb-0">${capitalizarElemento(datos.nombreSucursal)}</h6>
                                <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(datos.fechaOrden)}</p>
                                <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(datos.nombreMedicoAtencion)}</p>
                                <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarCadaPalabra(datos.nombrePaciente)}</p> `;
            }
        } else {
            if (datos.estado == "PENDIENTE_AGENDAR") {
                if (datos.esCaducado == "S") {
                    dataFechas = `<p class="fw-light fs--2 line-height-16 mb-1">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                } else {
                    dataFechas = `` ;
                }
            }
        }
        return dataFechas;
    }

    // determinar si es comprar o por comprar
    function determinarEstado(estado){
        if(estado == "S"){
            return `<i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprada</span>`;
        }else{
            return `<i class="fa-solid fa-circle me-2"></i><span class="">Por comprar</span>`;
        }
    }

    // // determinar fechas caducadas
    // function determinarFechasCaducadas(datos){
    //     // si es receta medica no mostrar fechas
    //     console.log('datos: ', datos.tipoServicio);
    //     if (datos.tipoServicio == "FARMACIA") {
    //         return `<a href="" class="fs--2" data-bs-toggle="modal" data-bs-target="#recetaMedicaModal">¿Ya compraste esta receta?</a> `;
    //     } else{
    //         if (datos.esCaducado == "S") {
    //             return `<p class="fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
    //         } else {
    //             return `<p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
    //         }
    //     }
    // }

    // determinar si es receta medica o no botones
    function determinarbotonesRecetaMedica(detalles) {
        let botonVer = `<a href="#" class="btn text-primary-veris fw-normal fs--1 line-height-16 px-3 py-2 ">Ver ${detalles.tipoServicio === "LABORATORIO" ? "orden" : "receta"}</a>`;
        let botonSolicitar;

        if(detalles.esPagada === "N"){
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-medium fs--1 line-height-16 px-3 py-2 "><i class="bi  me-2"></i> Pagar</a>`;
        }else if (detalles.tipoServicio === "FARMACIA") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-medium fs--1 line-height-16 px-3 py-2 ${detalles.aplicaSolicitud !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
        } else if (detalles.tipoServicio === "LABORATORIO") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-medium fs--1 line-height-16 px-3 py-2 ${detalles.esAgendable !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
        } else {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-medium fs--1 line-height-16 px-3 py-2 ${detalles.esAgendable !== 'S' ? ' disabled' : ''}">Agendar</a>`;
        }
        return botonVer + botonSolicitar;
    }


    // determinar condiciones de los botones 

    function determinarCondicionesBotones(datosServicio, estado) {
        let services = datosServicio;
        console.log('services', services);

        if (datosServicio.length == 0) {
            return `<div></div>`;
        } else {
            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                    let respuestaAgenda = "";
                    // Agregar ver orden 
                    respuestaAgenda += ` <button type="button" class="btn text-primary-veris fw-normal fs--1 line-height-16 px-3 py-2" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;

                    if(datosServicio.estado == 'PENDIENTE_AGENDAR'){
                        if (datosServicio.habilitaBotonAgendar == 'S') {
                            let modalidad;
                            if (datosServicio.modalidad === 'online') {
                                modalidad = 'S';
                            } else if (datosServicio.modalidad === 'presencial') {
                                modalidad = 'N';
                            }

                            let params = {};
                            params.especialidad = {
                                codigoEspecialidad: datosServicio.codigoEspecialidad
                            };
                            params.esOnline = modalidad;
                            let urlParams = btoa(JSON.stringify(params));
                            respuestaAgenda += `<a href="/citas-elegir-central-medica/${urlParams}" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 px-3 py-2">Agendar</a>`;
                        } else {
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 px-3 py-2 disabled">Agendar</a>`;
                        }
                    } else if (datosServicio.estado == 'ATENDIDO'){
                        // mostrar boton de ver orden
                        respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2">Ver orden</a>`;
                    } else if (datosServicio.estado == 'AGENDADO'){
                        // mostrar boton de ver orden
                        respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2">Ver orden</a>`;
                        if (datosServicio.permitePago == 'S'){
                            // mostrar boton de pagar
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2">Pagar</a>`;
                        } 
                        if  (datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2"> ${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                        } 
                        if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                            // mostrar boton de informacion
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2" onclick="mostrarInformacion(${datosServicio.detalleReserva.mensajeInformacion})">Información</a>`;
                        } 
                    }
                    return respuestaAgenda;
                    break;
                case "LAB":
                    let respuesta = "";
                    respuesta += ` <button type="button" class="btn btn-sm text-primary-veris fw-normal fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    if(estado == 'REALIZADO'){
                        // clear respuesta
                        respuesta = "";
                        respuesta += `<button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    } else {
                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-veris fw-normal fs--1 line-height-16 px-3 py-2">Ver resultados</a>`;
                        } else {
                            respuesta += ``;
                        }
                        //condición para 'aplicaSolicitud'
                        if (datosServicio.aplicaSolicitud == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
                        } else if (datosServicio.permitePago == "S"){
                            let params = {};
                            params.idPaciente = datosServicio.pacPacNumero;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            respuesta += `<a href="/citas-laboratorio/${ulrParams}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2">Pagar</a>`;
                        }
                    }
                    return respuesta;
                    break;
                case "RECETAS" :
                    let respuestaRecetas = "";
                    respuestaRecetas += ` <button type="button" class="btn btn-sm text-primary-veris fw-normal fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;

                    if(estado == 'REALIZADO'){
                        //respuestaRecetas = "";
                        // abrir offcanvas
                        respuestaRecetas += `<button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 btnVerOrden" data-bs-toggle="offcanvas" data-bs-target="#detalleRecetaMedica" aria-controls="detalleRecetaMedica" data-rel='${JSON.stringify(datosServicio)}'>Ver receta</button>`;
                    } else {
                        if(datosServicio.aplicaSolicitud == "S"){
                            respuestaRecetas += `<a href="/farmacia-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
                        } else {
                            // return boton ver receta
                            respuestaRecetas += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2">Ver receta</a>`;
                        }
                    }
                    return respuestaRecetas;
                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    respuestaOdontologia += ` <button type="button" class="btn text-primary-veris fw-normal fs--1 line-height-16 px-3 py-2" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    if (datosServicio.esAgendable == "N") {
                        respuestaOdontologia += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 px-3 py-2 disabled">Agendar</a>`;
                      
                    } else {
                        respuestaOdontologia += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 px-3 py-2"> Agendar</a>`;
                    }
                    return respuestaOdontologia;
                    break;
            }
        }
    }

    // determinar si es receta medica o no mensaje 
    function determinarMensajeRecetaMedica(servicio){
        if(servicio.nombreServicio == "RECETA MÉDICA" || servicio.esExterna == "S"){
            let servicioStr = JSON.stringify(servicio);
            let msg_pregunta = "¿Ya compraste esta receta?";
            let tipoModal = "recetaMedicaModal";
            if(servicio.esExterna == "S"){
                msg_pregunta = "¿Ya realizaste esta interconsulta?"
                tipoModal = "interconsultaMedicaModal";
            }
            return `<a href="" class="fs--2 btn-compraste-receta" data-bs-toggle="modal" data-bs-target="#${tipoModal}" data-rel='${servicioStr}'>${msg_pregunta}</a>`;
        } else {
            return ``;
        }
    }

    // asignacion de datos al modal receta medica
    $('#recetaMedicaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var datos = JSON.parse(button.attr('data-rel'));
        $('#btnRecetaMedicaSi').data('rel', datos);
    });

    // boton receta medica si lo hice
    $('#btnRecetaMedicaSi').click(async function(){
        let datos = $(this).data('rel');
        await detalleTratamientoRealizado(datos);
    });


    // recibir fechas y horas actuales
    function obtenerFechaActual(){
        let fechaActual = new Date();

        let dia = String(fechaActual.getDate()).padStart(2, '0');
        let mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Enero es 0
        let anio = fechaActual.getFullYear();

        let horas = String(fechaActual.getHours()).padStart(2, '0');
        let minutos = String(fechaActual.getMinutes()).padStart(2, '0');
        let segundos = String(fechaActual.getSeconds()).padStart(2, '0');

        return `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
    }




    // mostrar lista de pacientes en el filtro
    function mostrarListaPacientesFiltro(){
        let data = familiar;
        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let isFirstElement = true; // Variable para identificar el primer elemento
        data.forEach((Pacientes) => {
            let checkedAttribute = isFirstElement ? 'checked' : ''; // Establecer 'checked' para el primer elemento
            isFirstElement = false; // Asegurar que solo el primer elemento sea 'checked'
            let elemento = `<div class="position-relative">
                                <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="listGroupRadios-${Pacientes.numeroPaciente}" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} ${checkedAttribute}>
                                <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="listGroupRadios-${Pacientes.numeroPaciente}">
                                    <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}</p>
                                    <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</span>
                                </label>
                            </div>`;
            divContenedor.append(elemento);
        });
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', async function() {
        const contexto = $(this).data('context');
        aplicarFiltros(contexto);

        // Obtener el texto completo de la opción seleccionada data-rel
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');

        identificacionSeleccionada = texto.numeroPaciente;

        // colocar el nombre del filtro
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
        
    });


    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        limpiarFiltros(contexto);
        identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
    });

    // boton tratamiento realizado
    $('#pills-realizados-tab').on('click', async function(){
        const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
        await obtenerTratamientosId(identificacionSeleccionada, '', '', 'REALIZADO', esAdmin);
    });

    // boton tratamiento pendientes
    $('#pills-pendientes-tab').on('click', async function(){
        console.log('pendientes');
        const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
        await obtenerTratamientosId(identificacionSeleccionada, '', '', 'PENDIENTE', esAdmin);
    });


    // boton ver orden
    $(document).on('click', '.btn.text-primary-veris.fw-normal.fs--1', function(){
        let datos = $(this).data('rel');
        obtenerRecetaPdf(datos);
        // descargarDocumentoPdf(datos);
    });

    // boton ver orden  realizado
    $(document).on('click', '.btnVerOrden', function(){
        // llamar al servicio de detalle de receta
        let datos = $(this).data('rel');
        console.log('datos', datos);
        consultarDetalleReceta(datos);

        // pasar data rel a modal
        $('#detalleRecetaMedica').attr('data-rel', JSON.stringify(datos));
    });

    // boton ver pdf receta
    $(document).on('click', '.verPdfReceta', function(){
        let datos = $('#detalleRecetaMedica').attr('data-rel');
        datos = JSON.parse(datos);

        obtenerRecetaPdf(datos);
    });
</script>
@endpush