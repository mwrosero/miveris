@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Laboratorio
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Filtro -->
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Laboratorio') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-md-5 active" id="pills-pendientes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-md-5" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Realizados</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    @include('components.barraFiltro')
                    @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenes">
                    </div>
                    <!-- Mensaje No tienes ordenes de laboratorio -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientos">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes ordenes de laboratorio</h5>
                                    <p>En esta sección podrás revisar tus ordenes de laboratorio</p>
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
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministrador">
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
                <div class="tab-pane fade" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenesRealizados">
                    </div>
                    <!-- Mensaje No tienes ordenes de laboratorio realizadas -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientosRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes ordenes de laboratorio realizadas</h5>
                                    <p>En esta sección podrás revisar tus ordenes de laboratorio realizadas</p>
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
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministradorRealizados">
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
                
        let numeroPaciente = {{ Session::get('userData')->numeroPaciente }};
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
        console.log('datalabor', data);
        console.log('estado', estado);
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
                                                    <h5 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                                                    <p class="fs--2 fw-bold mb-0">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
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
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                            <span class="fs--2 text-warning-veris fw-bold">${determinarEstado(detalles.esPagada)}</span>
                                                        </div>
                                                        ${determinarFechasCaducadas(detalles)}
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
                                                    <h5 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h5>
                                                    <p class="fs--2 fw-bold mb-0">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
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
                                                    <div class="col-12 col-md-6">`;
                        
                            laboratorio.detallesTratamiento.forEach((detalles) =>{
                                elementos += `<div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                                     </div>
                                                        <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">${detalles.fechaCaducidad}</b></p>
                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                            <div class="avatar me-2">
                                                                <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                            </div>
                                                            <div>
                                                                ${determinarCondicionesBotones(detalles, estado)} 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;                        
                            });
                            elementos += `</div>
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
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
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




    // funciones js 

    // determinar fechas caducadas
    function determinarFechasCaducadas(datos){

        if (datos.tipoServicio == "FARMACIA") {
            return ``;
        } else{
            if (datos.esCaducado == "S") {
                return `<p class="fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
            } else {
                return `<p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
            }

        }


    }

    // determinar si es comprar o por comprar
    function determinarEstado(estado){
        if(estado == "S"){
            return `<i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprada</span>`;
        }else{
            return `<i class="fa-solid fa-circle me-2"></i>Por comprar`;
        }
    }

    // determinar fechas caducadas
    function determinarFechasCaducadas(datos){

        
        // si es receta medica no mostrar fechas
        console.log('datos: ', datos.tipoServicio);
        if (datos.tipoServicio == "FARMACIA") {
            return `<a href="" class="fs--2" data-bs-toggle="modal" data-bs-target="#recetaMedicaModal">¿Ya compraste esta receta?</a> `;
        } else{
            if (datos.esCaducado == "S") {
                return `<p class="fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
            } else {
                return `<p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
            }

        }


    }

    // determinar si es receta medica o no botones
    function determinarbotonesRecetaMedica(detalles) {
        let botonVer = `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver ${detalles.tipoServicio === "LABORATORIO" ? "orden" : "receta"}</a>`;
        let botonSolicitar;

        if(detalles.esPagada === "N"){
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1"><i class="bi  me-2"></i> Pagar</a>`;
            
        }else  if (detalles.tipoServicio === "FARMACIA") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1${detalles.aplicaSolicitud !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (detalles.tipoServicio === "LABORATORIO") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1${detalles.esAgendable !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1${detalles.esAgendable !== 'S' ? ' disabled' : ''}"> Agendar</a>`;
        }

        return botonVer + botonSolicitar;
    }


    // determinar condiciones de los botones 

    function determinarCondicionesBotones(datosServicio, estado) {
        let services = datosServicio;
        console.log('services', services);

        if (datosServicio.length == 0) {
            return `<div></div>`;
        }
        else{

            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                    let respuestaAgenda = "";
                    // Agregar ver orden 
                    respuestaAgenda += ` <div  class="btn text-primary-veris fw-normal fs--1" data-rel='${JSON.stringify(datosServicio)}'><i class="bi me-2"></i> Ver orden</div>`;

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
                            respuestaAgenda += `<a href="/citas-elegir-central-medica/${urlParams}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Agendar</a>`;
                        } else {
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 disabled"><i class="bi me-2"></i> Agendar</a>`;

                        }

                    }else if (datosServicio.estado == 'ATENDIDO'){

                        // mostrar boton de ver orden
                        respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 m-2"><i class="bi me-2"></i> Ver orden</a>`;

                    }else if (datosServicio.estado == 'AGENDADO'){
                        // mostrar boton de ver orden
                        respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 m-3"><i class="bi me-2"></i> Ver orden</a>`;

                        if (datosServicio.permitePago == 'S'){
                            // mostrar boton de pagar
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Pagar</a>`;
                        } 
                        if  (datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                            
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> ${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                        } 
                        
                        if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                            // mostrar boton de informacion
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2" onclick="mostrarInformacion(${datosServicio.detalleReserva.mensajeInformacion})"></i> Información</a>`;
                        } 
                    }

                    
                    return respuestaAgenda;
                    break;

                case "LAB":
                    let respuesta = "";
                    respuesta += ` <div  class="btn text-primary-veris fw-normal fs--1" data-rel='${JSON.stringify(datosServicio)}'><i class="bi me-2"></i> Ver orden</div>`;


                    if(estado == 'REALIZADO'){
                        // clear respuesta
                        respuesta = "";
                        
                        respuesta += `<div class="btn btn-sm btn-primary-veris fw-normal fs--1 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'><i class="bi me-2" 
                            ></i> Ver orden</div>`;
                    } 
                    else{

                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-veris fw-normal fs--1 m-2
                            "><i class="bi me-2"></i> Ver resultados</a>`;
                        } else {
                            respuesta += ``;
                        }

                        //condición para 'aplicaSolicitud'
                        if (datosServicio.aplicaSolicitud == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                        } 
                        else if (datosServicio.permitePago == "S"){
                            let params = {};
                            params.idPaciente = datosServicio.pacPacNumero;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            
                            respuesta += `<a href="/citas-laboratorio/${ulrParams}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Pagar</a>`;
                        }
                    }
                    
                    return respuesta;

                    break;

                case "RECETAS" :

                    let respuestaRecetas = "";
                    
                    respuestaRecetas += ` <div  class="btn text-primary-veris fw-normal fs--1" data-rel='${JSON.stringify(datosServicio)}'><i class="bi me-2"></i> Ver receta</div>`;

                    if(estado == 'REALIZADO'){
                        respuestaRecetas = "";
                        respuestaRecetas += `<div class="btn btn-sm btn-primary-veris fw-normal fs--1 btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'><i class="bi me-2" 
                            ></i> Ver orden</div>`;
                    }
                    if(datosServicio.aplicaSolicitud == "S"){
                        return `<a href="/farmacia-domicilio/${datosServicio.codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                    }
                    else{
                        // return boton ver receta
                        return `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Ver receta</a>`;
                    }
                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    respuestaOdontologia += ` <div  class="btn text-primary-veris fw-normal fs--1" data-rel='${JSON.stringify(datosServicio)}'><i class="bi me-2"></i> Ver orden</div>`;
                    if (datosServicio.esAgendable == "N") {
                        respuestaOdontologia += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1 disabled"><i class="bi me-2"></i> Agendar</a>`;
                      
                    } else {
                        respuestaOdontologia += `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Agendar</a>`;
                    }

                    return respuestaOdontologia;

                    break;

            }

        }
    }

    





    // mostrar lista de pacientes en el filtro
    function mostrarListaPacientesFiltro(){

        let data = familiar;

        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let elementoYo = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="{{ Session::get('userData')->numeroPaciente }}" data-rel='YO'
                                checked>
                                <span class="text-veris fw-bold">
                                    ${capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}")}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">Yo</small>
                                </span>
                            </label>`;
        divContenedor.append(elementoYo);

        console.log('sss',data);
        data.forEach((Pacientes) => {
            let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} unchecked>
                                <span class="text-veris fw-bold">
                                    
                                    ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                                </span>
                            </label>`;
            divContenedor.append(elemento);

        });
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        aplicarFiltros(contexto);



        // Obtener el texto completo de la opción seleccionada data-rel
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');

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
</script>
@endpush