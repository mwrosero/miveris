@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis citas
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
    <!-- Modal Convenios -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Elige tu convenio:') }}</h5>
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaConvenios">
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn fw-normal fs--16 line-height-20 m-0 px-3 py-2" data-bs-dismiss="modal" style="color: #6A7D8E;">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal noPermiteReserva-->
    <div class="modal fade" id="noPermiteReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noPermiteReservaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 fw-medium mb-3" id="noPermiteReservaLabel">Veris</h1>
                        <p class="fs--2 fw-normal" id="noPermiteReservaMsg"></p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de error -->
    <div class="modal fade" id="ModalError" tabindex="-1" aria-labelledby="ModalError" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">Veris</h1>
                    <p class="fs--2 fw-normal" id="mensajeError"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- offcanva ver pdf -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="verPdf" aria-labelledby="verPdfLabel">
        <div class="offcanvas-header flex-column align-items-start p-0">
            <div class="w-100 px-4 py-2 d-lg-none d-block" style="background: #F3F4F5;">
                <button type="button" class="btn p-0 d-flex align-items-center" data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{asset('assets/img/svg/arrow-left-filtro-body.svg')}}" class="me-1" alt="atras"><b class="fw-medium fs-- text-veris">Atrás</b></button>
            </div>
            <h5 class="offcanvas-title fs--20 line-height-24 w-100 px-4 py-3" id="verPdfLabel">Mis documentos</h5>
        </div>
        <div class="offcanvas-body p-3" style="background: rgba(249, 250, 251, 1) !important;">
            <div>
                <div class="list-group gap-3 verPdf">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis citas') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5 active" id="pills-actuales-tab" data-bs-toggle="pill" data-bs-target="#pills-actuales" type="button" role="tab" aria-controls="pills-actuales" aria-selected="true">Próximas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5" id="pills-historial-tab" data-bs-toggle="pill" data-bs-target="#pills-historial" type="button" role="tab" aria-controls="pills-historial" aria-selected="false">Historial</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
                <!-- Filtro -->
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade mt-3 show active" id="pills-actuales" role="tabpanel" aria-labelledby="pills-actuales-tab" tabindex="0">
                    <!-- botn de agendar -->
                    <div class="d-flex justify-content-center align-items-center my-4 px-2">
                        <div class="col-12 col-md-4">
                            <a href="/citas" class="btn btn-primary-veris w-100 fs--18 line-height-24 px-4 py-3">Agendar cita</a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-4 px-2">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3" id="citasActuales">
                                <!-- items dinamicos -->
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje No tiene cita -->
                    <div class="d-flex justify-content-center d-none" id="mensajeNoCita">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                    <h5 class="mb-0">No tienes citas disponibles aún</h5>
                                    <p class="fs--1">Agenda una nueva cita tocanco el botón.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje END -->
                </div>
                <div class="tab-pane fade mt-3" id="pills-historial" role="tabpanel" aria-labelledby="pills-historial-tab" tabindex="0">
                    <div class="d-flex justify-content-center mb-4 px-2">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3" id="historialCitas">
                                <!-- items dinamicos -->
                            </div>
                        </div>
                    </div>
                    <!-- Mensaje No tiene tratamiento -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoHistorialCitas">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes historial de citas</h5>
                                    <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
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

    let datosConvenios = [];
    let misCitasEleccion = localStorage.getItem('miscitas');
    console.log('misCitasEleccion', misCitasEleccion);

    // llamada al dom

    document.addEventListener("DOMContentLoaded", async function () {
        if (misCitasEleccion == 'historial') {
            $('#pills-historial-tab').click();
        } else {
            $('#pills-actuales-tab').click();
        }
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerHistorialCitas();
        await obtenerCitas();
        await consultarGrupoFamiliar();
        // await consultarConvenios();

        $('body').on('click', '.btn-eliminar-cita', function(){
            $('#idCitaEliminar').val($(this).attr('codigoReserva-rel'));
            var myModal = new bootstrap.Modal(document.getElementById('modalEliminarCita'));
            myModal.show();
        })

        $('body').on('click', '.btn-confirmar-eliminar-cita', async function(){
            await eliminarReserva()
        })

        $('body').on('click', '.btn-cita-informacion', async function(){
            let msg = $(this).attr('data-mensajeInformacion');
            $('#mensajeNoPermiteCambiar').html(msg)
        })
        
    });

    async function eliminarReserva(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/eliminarReserva?codigoReserva=${parseInt(getInput('idCitaEliminar'))}`
        args["method"] = "PUT";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        const data = await call(args);

        //Menos para edictar reserva 
        if(data.code == 200){
            $('#modalEliminarCita').hide();
            $('.modal-backdrop').remove();
            await obtenerCitas();
        }
    }

    //funciones asincronas
    // obtener historial de citas
    async function obtenerHistorialCitas(fechaDesde, fechaHasta, pacienteSeleccionado , esAdmin, estadoCitas) {
        console.log(fechaDesde, fechaHasta);
        let args = [];
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        if (!Date.parse(fechaDesde) || !Date.parse(fechaHasta)) {
            console.log('Fechas inválidas');
            args["endpoint"] = api_url + `/${api_war}/v1/agenda/historialCitas?canalOrigen=${_canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion} `; 
        } else {
            console.log('si hay fechas');
            fechaDesde = formatearFecha(fechaDesde);
            fechaHasta = formatearFecha(fechaHasta);
            args["endpoint"] = api_url + `/${api_war}/v1/agenda/historialCitas?canalOrigen=${_canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&desde=${fechaDesde}&hasta=${fechaHasta}`;
        }
        
        // args["endpoint"] = api_url + `/${api_war}/v1/agenda/historialCitas?canalOrigen=${_canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}`;
        args["method"] = "GET";
        console.log('argsss', args["endpoint"]);
        args["showLoader"] = true;

        const data = await call(args);
        console.log('respuesta', data);

        if (data.code == 200){
            if (data.data == null || data.data.length == 0) {
                console.log('no hay citass');    
                // clear div historialCitas
                $('#historialCitas').empty();
                $('#mensajeNoHistorialCitas').removeClass('d-none');
            } else {
                $('#mensajeNoCita').addClass('d-none');
                // llenar div historialCitas
                let historialCitas = $('#historialCitas');
                historialCitas.empty();

                // forEach de data.data
                data.data.forEach((historial) => {
                    let ruta = '';
                        if (historial.esVirtual == "S") {
                            ruta = "/citas-elegir-fecha-doctor/" + "{{ $tokenCita }}" 
                        } else {
                            ruta = "/citas-elegir-central-medica/" + "{{ $tokenCita }}"
                        }

                    let element = `<div class="col-12 col-md-6">
                                            <div class="card">
                                                <div class="card-body p--2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${capitalizarElemento(historial.nombreEspecialidad)}</h6>
                                                        ${determinarMensajeEstadoCita(historial.mensajeEstado)}
                                                    </div>
                                                    <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(historial.nombreSucursal)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1"> ${historial.dia}<b class="hora-cita fw-normal text-primary-veris"> ${determinarAmPm(historial.horaInicio)}</b></p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(historial.nombreProfesional)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(historial.nombrePaciente)}</p>
                                                    <div class="d-flex justify-content-end align-items-center mt-3">
                                                        <div>`
                                                    if(historial.secuenciaAtencion !== null){
                                                        element += `<button type="button" class="btn btn-sm btn-outline-primary-veris fs--1 shadow-none mb-2 me-1 btnVerPdf" data-bs-toggle="offcanvas" data-bs-target="#verPdf" aria-controls="verPdf" data-rel=${btoa(JSON.stringify(historial))}><i class="bi bi-file-earmark-pdf"></i>Ver PDF</button>`;
                                                    }
                                                    element += `<a href=${quitarComillas(historial.urlEncuesta)} target="_blank" class="btn btn-sm btn-outline-primary-veris shadow-none mb-2">Calificar</a>`;
                                                    if(historial.esImagen == "S"){
                                                        element += `<a href="/imagenes-procedimientos" class="btn btn-sm btn-primary-veris shadow-none ms-1 mb-2">Reagendar</a>`
                                                    }else{
                                                        element += `<div class="btn btn-sm btn-primary-veris shadow-none ms-1 mb-2" onclick="consultarConvenios(event)" data-rel='${JSON.stringify(historial)}'>Reagendar</div>`
                                                    }
                                                    element += `</div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>`;

                    historialCitas.append(element);
                });
            }
        }
    }

    async function obtenerCitas(fechaDesde, fechaHasta, pacienteSeleccionado , esAdmin, estadoCitas) {
        console.log("pacienteSeleccionado", pacienteSeleccionado);
        let args = [];
        let numeroPaciente = "{{ Session::get('userData')->numeroIdentificacion }}";

        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        if (pacienteSeleccionado) {
            numeroPaciente = pacienteSeleccionado;
        }

        args["endpoint"] = api_url + `/${api_war}/v1/agenda/citasVigentes?canalOrigen=${_canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroPaciente}&version=7.8.0`
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('citasxd',args["endpoint"]);
        const data = await call(args);
        console.log('citas',data);

        if (data.code == 200){
            if (data.data.length == 0) {
                // clear div citasActuales
                $('#citasActuales').empty();
                $('#mensajeNoCita').removeClass('d-none');
            } else {
                // let citasActuales = $('#citasActuales');
                // citasActuales.empty();
                $('#mensajeNoCita').addClass('d-none');
                const divContenedor = $('#citasActuales');
                divContenedor.empty();
                let elemento = '';
                const tokenCita = "{{ $tokenCita }}";
                data.data.forEach((citas) => {
                    console.log("-------------------------------")
                    console.log(citas)
                    const classElem = citas.estaPagada === "S" ? 'justify-content-end' : 'justify-content-between';
                    const esConsultaOnline = citas.esVirtual === "S";
                    const esPagada = citas.estaPagada === "S" ? 'Pagada' : 'No pagada';
                    let ruta = "/citas-elegir-fecha-doctor/" + tokenCita;

                    if (citas.esVirtual !== "S") {
                        ruta = "/citas-elegir-central-medica/" + tokenCita;
                    }

                    let convenio = {
                        "secuenciaAfiliado": citas.secuenciaAfiliado,
                        "idCliente": citas.idCliente,
                        "codigoConvenio": citas.codigoConvenio,
                        "secuenciaAfiliado": citas.secuenciaAfiliado,
                        "codigoEmpresa": citas.codigoEmpresa,
                        "permitePagoLab": citas.permitePagoLab,
                        "mensajePagoLab": citas.mensajePagoLab,
                        "permitePago": citas.permitePagoReserva,
                        "mensajeBloqueoPago": citas.mensajePagoReserva,
                        "permiteReserva": citas.permiteReserva,
                        "mensajeBloqueoReserva": citas.mensajeBloqueoReserva,
                        "aplicaVerificacionConvenio": citas.aplicaVerificacionConvenio
                    }

                    /*
                    permiteCambiar
                    mensajeInformacion
                    */

                    elemento += `
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body p--2">
                                    ${esConsultaOnline ? `
                                        <span class="badge bg-label-primary text-primary-veris fs--1 fw-medium p-2 mb-1" style="background-color: #CEEEFA !important;">Consulta online</span>
                                    ` : ''}
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary-veris fs--1 fw-medium line-height-16 mb-1">${capitalizarElemento(citas.especialidad)}</h6>
                                        <span class="fs--2 fw-medium line-height-16 mb-1" style="color: ${citas.colorEstado};"><i class="fa-solid fa-circle"></i> ${citas.mensajeEstado}</span>
                                    </div>
                                    <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(citas.sucursal)}</p>
                                    <p class="fw-normal fs--2 line-height-16 mb-1">${citas.dia} <b class="hora-cita fw-normal text-primary-veris">${citas.horaInicio} ${determinarMeridiano(citas.horaInicio)}</b></p>
                                    <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(citas.medico)}</p>
                                    <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(citas.nombrePaciente)}</p>
                                </div>
                                <div class="card-footer pt-0 p--2 d-flex ${classElem} align-items-center">
                                    ${citas.estaPagada === "N" ? `
                                        <button type="button" codigoReserva-rel="${citas.idCita}" class="btn btn-eliminar-cita btn-sm text-danger-veris shadow-none p-1"><img src="{{asset('assets/img/svg/trash.svg')}}" alt=""></button>
                                    ` : ''}
                                    <div class="mt-auto">
                                        ${citas.permiteCambiar == "S" ? `<div url-rel="${ruta}" class="btn btn-sm btn-outline-primary-veris fs--1 fw-normal line-height-16 shadow-none btn-CambiarFechaCita" convenio-rel='${JSON.stringify(convenio)}' data-rel='${JSON.stringify(citas)}'>${citas.nombreBotonCambiar}</div>
                                        ` : `<div data-bs-toggle="modal" data-mensajeInformacion="${citas.mensajeInformacion}" data-bs-target="#modalPermiteCambiar" class="btn btn-sm btn-outline-primary-veris fs--1 fw-normal btn-cita-informacion line-height-16 shadow-none border-0 pe-0 me-0">
                                                <i class="fa-solid fa-circle-info text-warning line-height-20" style="font-size:22px"></i>
                                            </div>`
                                        }
                                        ${citas.estaPagada === "N" ? `
                                        <a class="btn btn-sm btn-primary-veris fs--1 fw-medium ms-2 m-0 line-height-16 btn-pagar" convenio-rel='${JSON.stringify(convenio)}' data-rel='${JSON.stringify(citas)}'>Pagar</a>
                                        ` : ''}
                                    </div>
                                    ${esConsultaOnline && citas.estaPagada == "S" ? `
                                        <a href="${citas.idTeleconsulta}" class="btn btn-sm btn-primary-veris fs--1 ms-2 m-0 line-height-16">Conectarme</a>
                                    ` : ''}
                                </div>
                            </div>
                        </div>`;
                });
                divContenedor.append(elemento);
            }
        }
    }

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${_canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
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

    // obtener lista de documentos 
    async function obtenerListaDocumentos(datos) {
        console.log('datossss', datos.secuenciaAtencion);    
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/documentos?secuenciaAtencion=${datos.secuenciaAtencion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200) {
            let divContenedor = $('.verPdf');
            divContenedor.empty(); // Limpia el contenido actual
            data.data.forEach((documento) => {
                let nuevosdatos = {}
                nuevosdatos.datosCita = datos;
                nuevosdatos.datosDocumento = documento;
                let elemento = `<label class="list-group-item d-flex align-items-center gap-2 bg-white card-border cursor-pointer rounded-3 p-3 btnDescargarPdf text-start" data-rel=${btoa(JSON.stringify(nuevosdatos))}>
                                    <span class="text-veris fw-medium fs--16 line-height-20">
                                        ${capitalizarElemento(documento.nombreDocumento)}
                                    </span>
                                    <i class="bi bi-download ms-auto text-primary-veris fs--20" style="font-weight: 900;"></i>
                                </label>`;
                divContenedor.append(elemento);
            });
        }
        return data;
    }

    // descargar documento btnDescargarPdf
    $(document).on('click', '.btnDescargarPdf', async function() {
        let data = $(this).data('rel');
        // decodificar data
        data = JSON.parse(atob(data));
        console.log("------------------------------");
        console.log(data);
        console.log("------------------------------");
        await descargarDocumentoPdfPrincipal(data);
    });

    // descargar documento
    async function descargarDocumentoPdfPrincipal(datos){

        let args = [];
        let canalOrigen = 'APP_CMV'
        let secuenciaAtencion = datos.datosCita.secuenciaAtencion;
        let tipoServicio = datos.datosDocumento.tipoServicio;
        let numeroOrden = datos.datosDocumento.numeroOrden;
        if(numeroOrden == null){
            numeroOrden = datos.datosCita.numeroOrden;
        }

        if (tipoServicio == 'RECETA') {
            console.log('entro a receta');
            args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=${tipoServicio}&numeroOrden=&secuenciaReceta=${datos.datosDocumento.secuenciaReceta} `;
        }
        else {
            args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=${tipoServicio}&numeroOrden=${numeroOrden} `;
        }
        
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
    // determinar boton de cita
    function determinarBotonCita(cita) {
        let boton = '';
        if (cita.permiteCambiar == 'N') {
            boton += ``;
        } else if (cita.permiteCambiar == 'S') {
            boton += `<a href="#" class="btn btn-sm btn-primary-veris ms-auto" >Cambiar</a>`;
        }

        if (cita.pagado == 'S') {
            boton += `<a href="#" class="btn btn-sm btn-primary-veris ms-auto" >Pagar</a>`;
        } else if (cita.pagado == 'N') {
            boton += ``;
        }
        return boton;
    }

    // determinar mensaje estado cita
    function determinarMensajeEstadoCita(mensajeEstado) {
        // caso null
        if (mensajeEstado == null) {
            return '';
        }
        let mensaje = '';

        if (mensajeEstado == 'Cita Pagada') {
            mensaje += `<span class="fs--2 text-success fw-medium"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>`;
        } else if (mensajeEstado == 'No Atendida') {
            mensaje += `<span class="fs--2 text-warning-veris fw-medium"><i class="fa-solid fa-circle me-1"></i> No atendida</span>`;
        } else if (mensajeEstado == 'Pago Pendiente') {
            mensaje += `<span class="fs--2 text-danger-veris fw-medium"><i class="fa-solid fa-circle me-1"></i> Pago pendiente</span>`;
        }

        return mensaje;
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
                                <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="listGroupRadios-${Pacientes.numeroPaciente}" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroIdentificacion}" esAdmin= ${Pacientes.esAdmin} ${checkedAttribute}>
                                <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="listGroupRadios-${Pacientes.numeroPaciente}">
                                    <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}</p>
                                    <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</span>
                                </label>
                            </div>`;
            divContenedor.append(elemento);
        });
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        aplicarFiltrosCitas(contexto);
        // Obtener el texto completo de la opción seleccionada data-rel
        const texto = $('input[name="listGroupRadios"]:checked').data('rel');

        //consultarConvenios(texto);

        console.log('texto', texto);

        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
        

    });

    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        if (contexto === 'contextoLimpiarFiltros') {
            console.log('exitoss');
            $('input[name="listGroupRadiosI"]').prop('checked', false);
            $('input[name="listGroupRadiosI"]').first().prop('checked', true);
            $('#fechaDesde').val('');
            $('#fechaHasta').val('');
            // await obtenerTratamientos();
        }
    });

    // formatear fecha
    function formatearFecha(fecha) {
        const fechaObj = new Date(fecha);
        const dia = ('0' + fechaObj.getDate()).slice(-2);
        const mes = ('0' + (fechaObj.getMonth() + 1)).slice(-2);
        const año = fechaObj.getFullYear();

        return `${dia}/${mes}/${año}`;
    }

    // funcion para determinar si es AM o PM
    function determinarAmPm(hora) {

        // caso null
        if (hora == null) {
            return '';
        }
        let horaFormateada = '';
        let horaSplit = hora.split(':');
        let horaInt = parseInt(horaSplit[0]);
        let minutos = horaSplit[1];

        if (horaInt > 12) {
            horaInt = horaInt - 12;
            horaFormateada = `${horaInt}:${minutos} PM`;
        } else if (horaInt < 12) {
            horaFormateada = `${horaInt}:${minutos} AM`;
        } else if (horaInt == 12) {
            horaFormateada = `${horaInt}:${minutos} PM`;
        }

        return horaFormateada;
    }

    // ver pdf offcanvas
    $(document).on('click', '.btnVerPdf', async function() {
        let data = $(this).data('rel');
        // decodificar data
        data = JSON.parse(atob(data));
        // console.log(data)
        await obtenerListaDocumentos(data);
    });

    // setear los valores de la cita en localstorage
    $(document).on('click', '.btn-CambiarFechaCita', async function() {
        let data = $(this).data('rel');
        let url = $(this).attr('url-rel');
        let convenio = JSON.parse($(this).attr('convenio-rel'));
        console.log('dataCitaa', data);
        console.log(url)

        if(data.permiteReserva == "N"){
            $('#mensajeNoPermiteCambiar').html(data.mensajeBloqueoReserva);
            $('#modalPermiteCambiar').modal('show');
            return;
        }

        if (data.estaPagada == "N"){ 

            let params = {}
            params.online = data.esVirtual;
            params.especialidad = {
                codigoEspecialidad: data.idEspecialidad,
                codigoPrestacion  : data.codigoPrestacion,
                codigoServicio   : data.codigoServicio,
                codigoTipoAtencion: data.codigoTipoAtencion,
                esOnline : data.esVirtual,
                nombre : data.especialidad,
            }
            params.paciente = {
                "numeroIdentificacion": data.numeroIdentificacion,
                "tipoIdentificacion": data.tipoIdentificacion,
                "nombrePaciente": data.nombrePaciente,
                "numeroPaciente": data.numeroPaciente
            }

            params.origen = 'mis-citas';

            params.reservaEdit = {
                "estaPagada": data.estaPagada,
                "numeroOrden": data.numeroOrden,
                "lineaDetalleOrden": data.lineaDetalleOrden,
                "codigoEmpresaOrden": data.codigoEmpresaOrden,
                "idOrdenAgendable": data.idOrdenAgendable,
                "idCita": data.idCita
            }
            params.origen = "inicios";
            params.convenio = {                
                secuenciaAfiliado: data.secuenciaAfiliado,
                idCliente: data.idCliente,
                codigoConvenio: data.codigoConvenio,
                codigoEmpresa: data.codigoEmpresa,
                permitePagoLab : data.permitePagoLab,
                permitePago: data.permitePagoReserva,
                mensajeBloqueoPago : data.mensajeBloqueoPago,
                mensajeBloqueoReserva : data.mensajeBloqueoReserva,
                permiteReserva: data.permitePagoReserva,
                aplicaVerificacionConvenio: data.aplicaVerificacionConvenio,   
            }
            
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

            const datosConvenioServicio = await consultarConveniosFecha(data.numeroIdentificacion, data.tipoIdentificacion);
            console.log(datosConvenioServicio)
            if (datosConvenioServicio.data.length == 0) {
                location = url;
            } else {
                llenarModalConvenios(datosConvenioServicio.data, url);
                $('#convenioModal').modal('show');
            }

         } else {

            let params = {}
            params.online = data.esVirtual;
            params.especialidad = {
                codigoEspecialidad: data.idEspecialidad,
                codigoPrestacion  : data.codigoPrestacion,
                codigoServicio   : data.codigoServicio,
                codigoTipoAtencion: data.codigoTipoAtencion,
                esOnline : data.esVirtual,
                nombre : data.especialidad,
            }
            params.paciente = {
                "numeroIdentificacion": data.numeroIdentificacion,
                "tipoIdentificacion": data.tipoIdentificacion,
                "nombrePaciente": data.nombrePaciente,
                "numeroPaciente": data.numeroPaciente
            }

            params.convenio = convenio;
            params.convenio.origen = 'mis-citas';
            params.origen = 'mis-citas';

            params.reservaEdit = {
                "estaPagada": data.estaPagada,
                "numeroOrden": data.numeroOrden,
                "lineaDetalleOrden": data.lineaDetalleOrden,
                "codigoEmpresaOrden": data.codigoEmpresaOrden,
                "idOrdenAgendable": data.idOrdenAgendable,
                "idCita": data.idCita
            }
            params.origen = "inicios";
            
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

            location = url;

        }

       
    });

    // consultar convenios y llenar el modal de convenios
    function llenarModalConvenios(data, url){
        let divContenedor = $('#listaConvenios');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = '';
        data.forEach((convenios) => {
            console.log('convenioss', convenios);
            elemento += `
                        <div data-rel='${JSON.stringify(convenios)}' url-rel='${url}' class="convenio-item">
                            <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="cursor-pointer text-primary-veris fs--1 line-height-16">
                                    ${capitalizarCadaPalabra(convenios.nombreConvenio)}
                                </label> 
                            </div>
                        </div>`;
                                
            // agregar convenio ninguno
        });
        elemento += `
                    <a href="${url}" class="d-block convenio-ninguno" data-rel='ninguno' id="convenioNinguno">
                        <div class="list-group-item rounded-3 py-2 px-3 border-0">
                            <label class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                Ninguno
                            </label> 
                        </div>
                    </a>`;
        divContenedor.append(elemento);
    }

    // consultar convenios
    // servicio para consultar convenios
    async function consultarConveniosFecha(identificacion, tipoId) {
        let tipoIdentificacion = tipoId;
        let numeroIdentificacion = identificacion;
        let codigoEmpresa = 1
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${_canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEmpresa=${codigoEmpresa}&tipoCredito=CREDITO_SERVICIOS`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const dataConvenio = await call(args);
        if(dataConvenio.code == 200){
            datosConvenios = dataConvenio.data;
        }
       
        return dataConvenio;
    }

    $('body').on('click','.convenio-item', function(){
        reservaNoPermitida($(this).attr("url-rel"), $(this).attr("data-rel"));
    })

    // seleccionar convenio convenio-Ninguno
    $(document).on('click', '.convenio-ninguno', function(){
        let data = $(this).data('rel');
        console.log('dataConvenio', data);
        let params = JSON.parse(localStorage.getItem('cita-{{ $tokenCita }}'));
        params.convenio = {
            "permitePago": "S",
            "permiteReserva": "S",
            "idCliente": null,
            "codigoConvenio": null,
            "secuenciaAfiliado" : null,
        };
        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
        $('#convenioModal').modal('hide');
        location = $(this).attr('url-rel');
    });

    // setear los valores de la cita historial en localstorage
    // setear los valores de la cita en localstorage
    $(document).on('click', '.btn-CambiarFechaCitaHistorial', function(){
        console.log('click entro a cambiar fecha');
        let data = $(this).data('rel');
        // const dataConvenio = await consultarConvenios(data);
        // const dataPaciente = await consultarDatosPaciente(data);
        
        let params = {}
        params.online = data.esVirtual;
        params.especialidad = {
            codigoEspecialidad: data.codigoEspecialidad,
            codigoPrestacion  : data.prestaciones[0].codigoPrestacion,
            codigoServicio   : data.prestaciones[0].codigoServicio,
            codigoTipoAtencion: data.codigoTipoAtencion,
            esOnline : data.esVirtual,
            nombre : data.nombreEspecialidad,
        }
        if (datosConvenios.length > 0) {
            params.convenio = datosConvenios[0];
        } else {
            params.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                    "secuenciaAfiliado" : null,
                };
        }
        // params.paciente = {
        //     "numeroIdentificacion": datosPaciente.numeroIdentificacion,
        //     "tipoIdentificacion": datosPaciente.codigoTipoIdentificacion,
        //     "nombrePaciente": datosPaciente.primerNombre + ' ' + datosPaciente.segundoNombre + ' ' + datosPaciente.primerApellido + ' ' + datosPaciente.segundoApellido,
        //     "numeroPaciente": datosPaciente.numeroPaciente
        // }
        params.paciente = {
            "numeroIdentificacion": data.numeroIdentificacion,
            "tipoIdentificacion": data.tipoIdentificacion,
            "nombrePaciente": data.nombrePaciente,
            "numeroPaciente": data.numeroPaciente
        }

        /*params.reservaEdit = {
            "estaPagada": data.estaPagada,
            "numeroOrden": data.numeroOrden,
            "lineaDetalleOrden": data.lineaDetalleOrden,
            "codigoEmpresaOrden": data.codigoEmpresaOrden,
            "idOrdenAgendable": data.idOrdenAgendable,
            "idCita": data.idCita
        }*/
        params.origen = "inicios";

        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

        if(data.permitePagoReserva == "S"){
            location = url;
        }else{
            //data.mensajePagoReserva
            llenarModalConvenios(datosConvenios, url);
            $('#convenioModal').modal('show');
        }
    });

    // servicio para consultar convenios
    // async function consultarConvenios(event) {
    //     let dataRel = $(event.currentTarget).data('rel');
    //     let dataPaciente = $('input[name="listGroupRadios"]:checked').data('rel');
    //     // let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}"
    //     // let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}"
    //     let tipoIdentificacion = dataPaciente.tipoIdentificacion;
    //     let numeroIdentificacion = dataPaciente.numeroIdentificacion;
    //     let codigoEmpresa = 1
    //     if (datos) {
    //         tipoIdentificacion = datos.tipoIdentificacion;
    //         numeroIdentificacion = datos.numeroIdentificacion;
    //     }
    //     let args = [];
    //     args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${_canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEmpresa=${codigoEmpresa}&tipoCredito=CREDITO_SERVICIOS`;
    //     args["method"] = "GET";
    //     args["showLoader"] = true;
    //     const dataConvenio = await call(args);
    //     if(dataConvenio.code == 200){
    //         datosConvenios = dataConvenio.data;
    //     }
       
    //     return dataConvenio;
    // }

    async function reservaNoPermitida(url, data ){
        let dataConvenio = JSON.parse(data);
        console.log(url)
        console.log(dataConvenio)
        $('#noPermiteReservaMsg').html(dataConvenio.mensajeBloqueoReserva)
        if(dataConvenio.permiteReserva == "S"){
            let dataCita = JSON.parse(localStorage.getItem('cita-{{ $tokenCita }}'));
            dataCita.convenio = dataConvenio;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            location.href = url;
        }else{
            $('#convenioModal').modal('hide');
            var myModal = new bootstrap.Modal(document.getElementById('noPermiteReserva'));
            setTimeout(function(){
                $('.modal-backdrop').remove();
                myModal.show();
            },250);
        }
    }

    async function consultarConvenios(event) {
        console.log('entro a consultar convenios');
        let listaConvenios = $('#listaConvenios');
        listaConvenios.empty();
        listaConvenios.append(`<div class="text-center p-2"><small>Nos estamos comunicando con tu aseguradora, el proceso puede tardar unos minutos</small></div>`);

        let dataRel = $(event.currentTarget).data('rel');
        if(dataRel.permiteReserva == "N"){
            return;
        }
        console.log(dataRel);
        let dataOnline = dataRel.esVirtual;  
        let dataCodigoEspecialidad = dataRel.codigoEspecialidad;
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        let tipoIdentificacion = '{{ Session::get('userData')->codigoTipoIdentificacion }}';
        

        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${codigoUsuario}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S  `
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if (data.code == 200){
            if(data.data.length > 0){
                // llenar el modal con los convenios
                listaConvenios.empty();
                let elemento = '';
                console.log(data);
                data.data.forEach((convenios) => {
                    let params = {};
                    
                    params.online = dataOnline;
                    params.convenio = convenios;
                    params.convenio.origen = 'mis-citas';
                    if(dataRel.prestaciones){
                        params.especialidad = {
                            codigoEspecialidad: dataRel.codigoEspecialidad,
                            nombre: dataRel.nombreEspecialidad,
                            imagen: dataRel.imagenEspecialidad,
                            codigoServicio: dataRel.prestaciones[0].codigoServicio,
                            esOnline: dataRel.esVirtual,
                            codigoPrestacion: dataRel.prestaciones[0].codigoPrestacion,
                            codigoSucursal: dataRel.codigoSucursal,
                            origen: 'mis-citas',
                            
                        };
                    }else{
                        params.especialidad = {
                            codigoEspecialidad: dataRel.idEspecialidad,
                            nombre: dataRel.especialidad,
                            codigoServicio: dataRel.codigoServicio,
                            esOnline: dataRel.esVirtual,
                            codigoPrestacion: dataRel.codigoPrestacion,
                            codigoSucursal: dataRel.codigoSucursal,
                            origen: 'mis-citas',
                        };

                        params.reservaEdit = {
                            "estaPagada": dataRel.estaPagada,
                            "numeroOrden": (dataRel.numeroOrden !== null) ? dataRel.numeroOrden : '',
                            "lineaDetalleOrden": (dataRel.lineaDetalleOrden !== null) ? dataRel.lineaDetalleOrden : '',
                            "codigoEmpresaOrden": (dataRel.codigoEmpresaOrden !== null) ? dataRel.codigoEmpresaOrden : '',
                            "idOrdenAgendable": (dataRel.idOrdenAgendable !== null) ? dataRel.idOrdenAgendable : '',
                            "idCita": (dataRel.idCita !== null) ? dataRel.idCita : ''
                        }
                    }
                    params.paciente = {
                        numeroIdentificacion: '{{ Session::get('userData')->numeroIdentificacion }}',
                        tipoIdentificacion:  '{{ Session::get('userData')->codigoTipoIdentificacion }}',
                        nombrePaciente: '{{ Session::get('userData')->primerNombre }}',
                        numeroPaciente: '{{ Session::get('userData')->numeroPaciente }}',
                        origen: 'mis-citas',
                    }
                    params.codigoMedicoFavorito = dataRel.codigoProfesional;
                    params.central = {
                        codigoEmpresa: dataRel.codigoEmpresa,
                        codigoSucursal: dataRel.codigoSucursal,
                        nombreSucursal: (dataRel.nombreSucursal) ? dataRel.nombreSucursal : dataRel.sucursal
                    }
                    params.origen = 'mis-citas';
                    localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
                    let url = `/citas-elegir-fecha-doctor/`;
                    let ruta = url + "{{ $tokenCita }}";
                    /*elemento += `<a href="${ruta}" class="stretched-link">
                                    <div class="list-group-item fs--2 rounded-3 p-2 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}">
                                            ${convenios.nombreConvenio}
                                        </label> 
                                    </div>
                                </a>`;*/
                    if(convenios.permiteReserva == "N"){
                        ruta = `#`;
                    }
                    let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    elemento += `<div data-rel='${ulrParams}' url-rel="${ruta}" class="convenio-item mb-2">
                                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                            ${capitalizarCadaPalabra(convenios.nombreConvenio)}
                                        </label> 
                                    </div>
                                </div>`;
                });


                let params = {};
                    
                params.online = dataOnline;
                params.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                };
                params.convenio.origen = 'mis-citas';  
                params.especialidad = {
                    codigoEspecialidad: dataCodigoEspecialidad,
                    nombre: dataRel.nombreEspecialidad,
                    imagen: dataRel.imagenEspecialidad,
                    codigoServicio: dataRel.prestaciones[0].codigoServicio,
                    esOnline: dataRel.esOnline,
                    codigoPrestacion: dataRel.prestaciones[0].codigoPrestacion,
                    codigoSucursal: dataRel.codigoSucursal,
                    origen: 'mis-citas',
                    
                };
                params.paciente = {
                    numeroIdentificacion: '{{ Session::get('userData')->numeroIdentificacion }}',
                    tipoIdentificacion:  '{{ Session::get('userData')->codigoTipoIdentificacion }}',
                    nombrePaciente: '{{ Session::get('userData')->primerNombre }}',
                    numeroPaciente: '{{ Session::get('userData')->numeroPaciente }}',
                    origen: 'mis-citas',
                }
                params.codigoMedicoFavorito = dataRel.codigoProfesional;
                params.central = {
                    codigoEmpresa: dataRel.codigoEmpresa,
                    codigoSucursal: dataRel.codigoSucursal,
                    nombreSucursal: dataRel.nombreSucursal
                }
                params.origen = 'mis-citas';
                let url = `/citas-elegir-fecha-doctor/`;
                let ruta = url + "{{ $tokenCita }}";
                let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                elemento += `<a href="${ruta}" class="d-block convenio-ninguno" data-rel='${ulrParams}' id="convenioNinguno">
                                <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                    <label class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                        Ninguno
                                    </label> 
                                </div>
                            </a>`;

                listaConvenios.append(elemento);

                // abrir modal
                if(dataRel.permiteReserva != "N"){
                    $('#convenioModal').modal('show');
                }
            }else{
                let params = {};
                    
                params.online = dataOnline;
                params.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                };
                params.convenio.origen = 'mis-citas';  
                params.especialidad = {
                    codigoEspecialidad: dataCodigoEspecialidad,
                    nombre: dataRel.nombreEspecialidad,
                    imagen: dataRel.imagenEspecialidad,
                    codigoServicio: dataRel.prestaciones[0].codigoServicio,
                    esOnline: dataRel.esOnline,
                    codigoPrestacion: dataRel.prestaciones[0].codigoPrestacion,
                    codigoSucursal: dataRel.codigoSucursal,
                    origen: 'mis-citas',
                    
                };
                params.paciente = {
                    numeroIdentificacion: '{{ Session::get('userData')->numeroIdentificacion }}',
                    tipoIdentificacion:  '{{ Session::get('userData')->codigoTipoIdentificacion }}',
                    nombrePaciente: '{{ Session::get('userData')->primerNombre }}',
                    numeroPaciente: '{{ Session::get('userData')->numeroPaciente }}',
                    origen: 'mis-citas',
                }
                params.codigoMedicoFavorito = dataRel.codigoProfesional;
                params.central = {
                    codigoEmpresa: dataRel.codigoEmpresa,
                    codigoSucursal: dataRel.codigoSucursal,
                    nombreSucursal: dataRel.nombreSucursal
                }
                params.origen = 'mis-citas';
                localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
                let url = `/citas-elegir-fecha-doctor/`;
                let ruta = url + "{{ $tokenCita }}";
                location.href = ruta;
            }
        }

    }

    // btn-pagar para redireccionar a la pagina de pago
    $(document).on('click', '.btn-pagar', function(){
        let data = $(this).data('rel');
        let convenio = $(this).attr('convenio-rel');
        if(convenio.permitePago == "N" || data.permitePagoReserva == "N"){
            // Modal de error
            // setear el mensaje de error en mensajeError
            $('#mensajeError').text(data.mensajePagoReserva);
            
            $('#ModalError').modal('show');
            return;

        }

        let params = {}
        params.online = data.esVirtual;
        params.especialidad = {
            codigoEspecialidad: data.idEspecialidad,
            codigoPrestacion  : data.codigoPrestacion,
            codigoServicio   : data.codigoServicio,
            codigoTipoAtencion: data.codigoTipoAtencion,
            esOnline : data.esVirtual,
            nombre : data.especialidad,
        }
        
        params.convenio = convenio

        params.paciente = {
            "numeroIdentificacion": data.numeroIdentificacion,
            "tipoIdentificacion": data.tipoIdentificacion,
            "nombrePaciente": data.nombrePaciente,
            "numeroPaciente": data.numeroPaciente
        }

        params.reservaEdit = {
            "estaPagada": data.estaPagada,
            "numeroOrden": data.numeroOrden,
            "lineaDetalleOrden": data.lineaDetalleOrden,
            "codigoEmpresaOrden": data.codigoEmpresaOrden,
            "idOrdenAgendable": data.idOrdenAgendable,
            "idCita": data.idCita
        }
        params.origen = "inicios";

        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
        location.href = "/citas-datos-facturacion/" + "{{ $tokenCita }}"
    });

</script>
@endpush