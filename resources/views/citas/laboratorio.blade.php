@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Laboratorio
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
    // dd($tokenCita);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">Veris</h1>
                    <p class="fs--1 fw-normal" id="mensajeError"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal información -->
    <div class="modal fade" id="modalInformacion" tabindex="-1" aria-labelledby="modalInformacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">Información</h1>
                    <p class="fs--1 fw-normal" id="mensajeInformacion" >
                </p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Laboratorio') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5 active" id="pills-pendientes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Realizados</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
                <!-- Filtro -->
                @include('components.barraFiltro')
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade mt-3 show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenes" class="px-2 px-md-0">
                    </div>
                    <!-- Mensaje No tienes órdenes de laboratorio -->
                    <div class="col-12 d-flex justify-content-center mt-3 d-none" id="mensajeNoTienesImagenesProcedimientos">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes órdenes de laboratorio</h5>
                                    <p>En esta sección podrás revisar tus órdenes de laboratorio</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-green">
                                            <img src="{{ asset('assets/img/svg/microscopio.svg') }}" alt="microscopio" class="rounded-circle">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->

                    <!-- Mensaje No tienes permisos de administrador -->
                    <div class="col-12 d-flex justify-content-center mt-3 d-none" id="mensajeNoTienesPermisosAdministrador">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes permisos de administrador</h5>
                                    <p>Pídele a esta persona que te otorgue los permisos en la sección Familia y amigos.</p>
                                    <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->
                </div>
                <div class="tab-pane fade mt-3" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenesRealizados" class="px-2 px-md-0">
                    </div>
                    <!-- Mensaje No tienes órdenes de laboratorio realizadas -->
                    <div class="col-12 d-flex justify-content-center mt-3 d-none" id="mensajeNoTienesImagenesProcedimientosRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes órdenes de laboratorio realizadas</h5>
                                    <p>En esta sección podrás revisar tus órdenes de laboratorio realizadas</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-green">
                                            <img src="{{ asset('assets/img/svg/microscopio.svg') }}" alt="microscopio" class="rounded-circle">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->

                    <!-- Mensaje No tienes permisos de administrador -->
                    <div class="col-12 d-flex justify-content-center mt-3 d-none" id="mensajeNoTienesPermisosAdministradorRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes permisos de administrador</h5>
                                    <p>Pídele a esta persona que te otorgue los permisos en la sección Familia y amigos.</p>
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
    let fechaDesdePicker = flatpickr("#fechaDesde", {
        maxDate: new Date().fp_incr(0),
        onChange: function(selectedDates, dateStr, instance) {
            if (!document.getElementById('fechaHasta').disabled) {
                fechaHastaPicker.set('minDate', dateStr);
            } else {
                document.getElementById('fechaHasta').disabled = false;
                fechaHastaPicker = flatpickr("#fechaHasta", {
                    minDate: dateStr,
                    maxDate: new Date().fp_incr(0)
                });
            }
        }
    });
    let fechaHastaPicker = flatpickr("#fechaHasta", {
        maxDate: new Date().fp_incr(0),
        minDate: new Date(), 
        onChange: function(selectedDates, dateStr, instance) {
        }
    });
    document.getElementById('fechaHasta').disabled = true;
    // quitar el readonly
    $("#fechaDesde").removeAttr("readonly");
    $("#fechaHasta").removeAttr("readonly");
    // no permitir autocomplete
    $("#fechaDesde").attr("autocomplete", "off");
    $("#fechaHasta").attr("autocomplete", "off");
</script>

<script>
    
    // variables globales
    let datosLaboratorio = [];
    let identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
    let datosConvenios = [];
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
        
        let args = [];
        let canalOrigen = 'APP_CMV';
                
        let numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";
        if (pacienteSeleccionado) {
            numeroPaciente = pacienteSeleccionado;
        }
        let admin = esAdmin;
        if (admin == undefined || admin == null) {
            admin = 'S';
        }
        let plataforma = _plataforma;
        let version = _version;
        let servicio = 'LABORATORIO';
        if (isNaN(fechaDesde) || isNaN(fechaHasta)) {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
       
        } else {
            if (estado == 'PENDIENTE') {
                args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
            } else if (estado == 'REALIZADO') {
                args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=S&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
            }
        }
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(args["endpoint"]);
        const data = await call(args);

        if (data.code == 200){

        

            if(estado == 'PENDIENTE'){
                console.log('entrando a pendiente');
                if (data.code == 200) {
                    if(data.data.items.length == 0){
                        console.log('entrando a pendiente vacio', admin);
                        if (admin === 'S') {
                            let html = $('#contenedorTratamientosImagenes');
                            html.empty();
                            $('#mensajeNoTienesImagenesProcedimientos').removeClass('d-none');
                            $('#mensajeNoTienesPermisosAdministrador').addClass('d-none');
                        } else if (admin === 'N') {
                            let html = $('#contenedorTratamientosImagenes');
                            html.empty();
                            $('#mensajeNoTienesPermisosAdministrador').removeClass('d-none');
                            $('#mensajeNoTienesImagenesProcedimientos').addClass('d-none');
                        }
                        
                        
                    }else{
                        if (admin === 'S') {
                            datosLaboratorio = data.data.items;
                            console.log('datosLaboratorio',datosLaboratorio);
                            let html = $('#contenedorTratamientosImagenes');
                            $('#mensajeNoTienesImagenesProcedimientos').addClass('d-none');
                            $('#mensajeNoTienesPermisosAdministrador').addClass('d-none');
                            html.empty();

                            let elementos = ''; // Definir la variable fuera del bucle

                            data.data.items.forEach((laboratorio) => {
                                elementos += `<div class="col-12 mb-4">
                                                <div class="card">
                                                    <div class="card-body py-2 px-3">
                                                        <p class="fs--3 text-primary-veris mb-0">Tratamiento</p>
                                                        <h5 class="text-primary-veris fw-medium mb-0">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                                                        <p class="fs--2 fw-medium mb-0">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                                                        <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                                                        <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                                                        <p class="fw-normal fs--2 mb-0">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="col-12 col-md-10 col-lg-8">
                                                <div class="row g-0 g-md-3" id="cardTratamientoLaboratorio">
                                                    <!-- items -->
                                                    `;
                        
                            laboratorio.detallesTratamiento.forEach((detalles) =>{
                                elementos += `<div class="col-12 col-md-6">
                                                <div class="card">
                                                    <div class="card-body p--2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="text-primary-veris fw-medium mb-0">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                            <span class="fs--2 text-warning-veris fw-medium">${determinarEstado(detalles.esPagada , estado)}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            ${determinarFechaCaducidadEncabezado(detalles, laboratorio)}
                                                        </div>

                                                       <div class="d-flex justify-content-between align-items-center mt-2">
                                                            <div class="avatar me-2">
                                                                <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                            </div>
                                                            ${determinarFechasCaducadas(detalles, laboratorio)}
                                                                
                                                            <div>
                                                                ${determinarCondicionesBotones(detalles, estado)}
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>`;                        
                                });
                                elementos += `
                                                </div>
                                            </div>
                                        </div>`;
                            });
                            html.append(elementos); // Agregar todos los elementos después del bucle

                        } else if (admin === 'N') {
                            let html = $('#contenedorTratamientosImagenes');
                            html.empty();
                            $('#mensajeNoTienesPermisosAdministrador').removeClass('d-none');

                        }
                        return data;
                    } 
                }
            }
            else if(estado == 'REALIZADO'){
                console.log('entrando a realizado');
                
                
                if (data.code == 200) {
                    if(data.data.items.length == 0){
                        console.log('entrando a realizado vacio');
                        if (admin === 'S') {
                            let html = $('#contenedorTratamientosImagenesRealizados');
                            html.empty();
                            $('#mensajeNoTienesImagenesProcedimientosRealizados').removeClass('d-none');
                            $('#mensajeNoTienesPermisosAdministradorRealizados').addClass('d-none');
                        } else if (admin === 'N') {
                            let html = $('#contenedorTratamientosImagenesRealizados');
                            html.empty();
                            $('#mensajeNoTienesPermisosAdministradorRealizados').removeClass('d-none');
                            $('#mensajeNoTienesImagenesProcedimientosRealizados').addClass('d-none');
                        }
                        
                    }else{
                        if (admin === 'S'){
                            console.log('entrando a realizado lleno');
                            datosLaboratorio = data.data.items;
                            console.log('datosLaboratorio',datosLaboratorio);
                            let html = $('#contenedorTratamientosImagenesRealizados');
                            html.empty();
                            console.log('datosLaboratorioR',datosLaboratorio);

                            let elementos = ''; 

                            datosLaboratorio.forEach((laboratorio) => {
                                elementos += `<div class="col-12 mb-4">
                                                <div class="card">
                                                    <div class="card-body py-2 px-3">
                                                        <p class="fs--3 text-primary-veris mb-0">Tratamiento</p>
                                                        <h5 class="text-primary-veris fw-medium mb-0">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                                                        <p class="fs--2 fw-medium mb-0">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                                                        <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                                                        <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                                                        <p class="fw-normal fs--2 mb-0">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="col-12 col-md-10 col-lg-8">
                                                    <div class="row g-3" id="cardTratamientoLaboratorio">
                                                        <!-- items -->
                                                        `;
                            
                                laboratorio.detallesTratamiento.forEach((detalles) =>{
                                    elementos += `<div class="col-12 col-md-6">
                                                    <div class="card">
                                                        <div class="card-body p--2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="text-primary-veris fw-medium mb-0">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                                <span class="fs--2 text-warning-veris fw-medium">${determinarEstado(detalles.esPagada, estado)}</span>

                                                            </div>

                                                            ${determinarFechasCaducadas(detalles, laboratorio)}
                                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <div class="avatar me-2">
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
                        } else if (admin === 'N') {
                            let html = $('#contenedorTratamientosImagenesRealizados');
                            html.empty();
                            $('#mensajeNoTienesPermisosAdministradorRealizados').removeClass('d-none');

                        }

                    } 
                    return data;
                } 
            }
            
        }

        if (data.code != 200) {
            // mostrar mensaje de error
            $('#mensajeSolicitudLlamadaModalError').modal('show');
            $('#mensajeError').text(data.message);

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

    // consultar convenios
    async function consultarConvenios(datosPaciente) { 
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}"
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}"
        if (datosPaciente) {
            tipoIdentificacion = datosPaciente.tipoIdentificacion;
            numeroIdentificacion = datosPaciente.numeroIdentificacion;
        }
        
        let codigoEmpresa = 1
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/comercial/paciente/convenios?canalOrigen=APP_CMV&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEmpresa=${codigoEmpresa}&tipoCredito=CREDITO_SERVICIOS`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const dataConvenio = await call(args);
        console.log('dataConvenio', dataConvenio);
        if(dataConvenio.code == 200){
            datosConvenios = dataConvenio.data;
        }
       
        return dataConvenio;
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

    // funciones js 
    // determinar fechas caducadas
    function determinarFechasCaducadas(datos, datosTratamiento){ 

        let dataFechas = ``;

        if (Object.keys(datosTratamiento.datosConvenio).length > 0) {

            
            if (datos.estado == "PENDIENTE_AGENDAR") {
                    
                
            }
            if (datos.estado == "AGENDADO" || datos.estado == "ATENDIDO") {

                dataFechas = `<h6 class="card-title fw-medium fs--2 text-dark-primary mb-0">${capitalizarElemento(datos.nombreSucursal)}</h6>
                                <p class="fw-normal fs--2 mb-0">${capitalizarElemento(datos.fechaOrden)}</p>
                                <p class="fs--2 mb-0">Dr(a): ${capitalizarElemento(datos.nombreMedicoAtencion)}</p>
                                <p class="fs--2 mb-0">${capitalizarCadaPalabra(datos.nombrePaciente)}</p> `;
            }
        }
        else{
            if (datos.estado == "PENDIENTE_AGENDAR") {
                    if (datos.esCaducado == "S") {
                        dataFechas = `<p class="fs--2 fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                    } else {
                        dataFechas = `` ;
                    }
            }
        }
        return dataFechas;
    }

    // determinar fecha de caducidad encabezado
    const determinarFechaCaducidadEncabezado = (datos, datosTratamiento) => {
        let dataFechas;
        
        if (Object.keys(datosTratamiento.datosConvenio).length > 0) {
            if (datos.estado == "PENDIENTE_AGENDAR" || datos.estado == null){
                if (datos.esCaducado == "S") {
                    dataFechas = `<p class="fs--2 fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                } else {
                    // orden valida
                    dataFechas = `<p class="fs--2 fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-success me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                }
            }
        }
        return dataFechas;
    }


    // determinar si es comprar o por comprar
    function determinarEstado(estado , estadoTratamiento){

        if (estadoTratamiento == 'REALIZADO') {
            return `<i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">Atendida</span>`;
        } else {
            if(estado == "S"){
                return `<i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprada</span>`;
            }else{
                return `<i class="fa-solid fa-circle me-2"></i>Por comprar`;
            }
        }
        
    }

    

    // determinar si es receta medica o no botones
    function determinarbotonesRecetaMedica(detalles) {
        let botonVer = `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver ${detalles.tipoServicio === "LABORATORIO" ? "orden" : "receta"}</a>`;
        let botonSolicitar;

        if(detalles.esPagada === "N"){
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1 m-0 line-height-16">Pagar</a>`;
            
        }else  if (detalles.tipoServicio === "FARMACIA") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1 m-0 line-height-16 ${detalles.aplicaSolicitud !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (detalles.tipoServicio === "LABORATORIO") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1 m-0 line-height-16 ${detalles.esAgendable !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1 m-0 line-height-16 ${detalles.esAgendable !== 'S' ? ' disabled' : ''}"> Agendar</a>`;
        }

        return botonVer + botonSolicitar;
    }


    // determinar condiciones de los botones 

    function determinarCondicionesBotones(datosServicio, estado) {
        let services = datosServicio;

        if (datosServicio.length == 0) {
            return `<div></div>`;
        }
        else{

            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                    let respuestaAgenda = "";
                    // Agregar ver orden 
                    respuestaAgenda += ` <button type="button" class="btn text-primary-veris fw-normal fs--1 line-height-16 m-0" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;

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
                            respuestaAgenda += `<a href="/citas-elegir-central-medica/${urlParams}" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0">Agendar</a>`;
                        } else {
                            respuestaAgenda += `<a href="#" class="btn btn-sm  fw-normal fs--1 line-height-16 m-0 disabled" style="background-color: #F3F0F0 !important; color: darkgrey !important;">
                                                    Agendar
                                                </a>
                                                `;

                        }

                    }else if (datosServicio.estado == 'ATENDIDO'){
                        respuestaAgenda = "";
                        // mostrar boton de ver orden
                        respuestaAgenda += `<button type="button" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 btnVerOrden " data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;

                    }else if (datosServicio.estado == 'AGENDADO'){
                        // mostrar boton de ver orden
                        respuestaAgenda = "";
                        if (estado == 'REALIZADO') {
                            // clear respuesta
                            respuestaAgenda = "";
                            respuestaAgenda += `<button type="button" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }
                        else{
                            respuestaAgenda += `<button type="button" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;

                            if (datosServicio.permitePago == 'S'){
                                // mostrar boton de pagar
                                respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0">Pagar</a>`;
                            } 
                            if  (datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                                
                                respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            } 
                            
                            if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                                // mostrar boton de informacion
                                respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0" onclick="mostrarInformacion(${datosServicio.detalleReserva.mensajeInformacion})">Información</a>`;
                            } 

                        }
                    }

                    return respuestaAgenda;
                    break;

                case "LAB":
                    let respuesta = "";
                    respuesta += ` <button type="button" class="btn text-primary-veris fw-normal fs--1 line-height-16 m-0" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    if(estado == 'REALIZADO'){
                        // clear respuesta
                        respuesta = "";
                        respuesta += `<button type="button" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    } 
                    else{

                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-veris fw-normal fs--1 line-height-16 m-0">Ver resultados</a>`;
                        } else {
                            respuesta += ``;
                        }
                        if (datosServicio.esPagada == "S") {
                            //ver informacion
                            respuesta += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 btnInformacionLaboratorio" data-rel='${JSON.stringify(datosServicio)}'>Información</a>`;
                        } else {
                            //condición para 'aplicaSolicitud'
                            if (datosServicio.aplicaSolicitud == "S") {
                                respuesta += `<a href="/laboratorio-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
                            } else if (datosServicio.permitePago == "S"){
                                let params = {};
                                params.idPaciente = datosServicio.pacPacNumero;
                                params.numeroOrden = datosServicio.idOrden;
                                params.codigoEmpresa = datosServicio.codigoEmpresa;
                                let ulrParams = btoa(JSON.stringify(params));
                                let ruta = `/citas-laboratorio/` + "{{$tokenCita}}";
                                respuesta += `<a href="${ruta}" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 btn-Pagar" data-rel='${JSON.stringify(datosServicio)}'>Pagar</a>`;
                            }
                        }
                    }
                    
                    return respuesta;
                    break;

                case "RECETAS" :

                    let respuestaRecetas = "";
                    respuestaRecetas += ` <button type="button" class="btn text-primary-veris fw-normal fs--1 line-height-16 m-0" data-rel='${JSON.stringify(datosServicio)}'>Ver receta</button>`;
                    if(estado == 'REALIZADO'){
                        respuestaRecetas = "";
                        respuestaRecetas += `<button type="button" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    }
                    if(datosServicio.aplicaSolicitud == "S"){
                        return `<a href="/farmacia-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
                    }
                    else{
                        // return boton ver receta
                        return `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0">Ver receta</a>`;
                    }
                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    respuestaOdontologia += ` <button type="button" class="btn text-primary-veris fw-normal fs--1 line-height-16 m-0" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    if (datosServicio.esAgendable == "N") {
                        respuestaOdontologia += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0 disabled">Agendar</a>`;
                    } else {
                        respuestaOdontologia += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 line-height-16 m-0">Agendar</a>`;
                    }

                    return respuestaOdontologia;
                    break;
            }

        }
    }

    // mostrar informacion btnInformacionLaboratorio
    $(document).on('click', '.btnInformacionLaboratorio', function(){
        let datos = $(this).data('rel');
        console.log('datos', datos);
        $('#modalInformacion').modal('show');
        $('#mensajeInformacion').text(datos.mensaje);
    });

    // mostrar lista de pacientes en el filtro
    function mostrarListaPacientesFiltro(){

        let data = familiar;

        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let isFirstElement = true; // Variable para identificar el primer elemento

        data.forEach((Pacientes) => {
            let checkedAttribute = isFirstElement ? 'checked' : 'unchecked'; // Establecer 'checked' para el primer elemento
            isFirstElement = false; // Asegurar que solo el primer elemento sea 'checked'

            let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} ${checkedAttribute}>
                                <span class="text-veris fw-medium">
                                    
                                    ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                                </span>
                            </label>`;
            divContenedor.append(elemento);
        });
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', async function() {
        const contexto = $(this).data('context');
        aplicarFiltros(contexto);



        // Obtener el texto completo de la opción seleccionada data-rel
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');
        await consultarConvenios(texto);

        identificacionSeleccionada = texto.numeroPaciente;

        // colocar el nombre del filtro
        const elemento = document.getElementById('nombreFiltro');
        if (texto == 'YO') {
            elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
        } else{
            elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
        }

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
        descargarDocumentoPdf(datos);
    });

    // boton ver orden  realizado
    $(document).on('click', '.btnVerOrden', function(){
        let datos = $(this).data('rel');
        descargarDocumentoPdf(datos);
    });


    // boton btn-Pagar
    $(document).on('click', '.btn-Pagar', function(){
        let datosServicio = $(this).data('rel');
        // capturar datarel del filtro
        let dataPaciente = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log('datospaciente', dataPaciente);

        let modalidad;
        if (datosServicio.modalidad === 'ONLINE') {
            modalidad = 'S';
        } else if (datosServicio.modalidad === 'PRESENCIAL') {
            modalidad = 'N';
        }
        let dataCita = {};
        dataCita.online = modalidad;
        dataCita.paciente = dataPaciente;
        dataCita.especialidad = {
            codigoEspecialidad: datosServicio.codigoEspecialidad,
            nombre : datosServicio.nombreServicio,
            imagen : datosServicio.urlImagenTipoServicio,
            esOnline : modalidad,
            codigoServicio : datosServicio.codigoServicio,
            codigoPrestacion : datosServicio.codigoPrestacion,
            codigoTipoAtencion : datosServicio.codigoTipoAtencion,
            codigoSucursal : datosServicio.codigoSucursal,
           
        };
        dataCita.convenio = datosConvenios;
        dataCita.datosTratamiento = datosServicio;
        dataCita.datosTratamiento.numeroPaciente = datosServicio.pacPacNumero;
        dataCita.origen = 'LABORATORIO';

        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
    });
</script>
@endpush