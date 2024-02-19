@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Terapia física
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
    <!-- Modal no permite reserva -->
    <div class="modal fade" id="mensajeNoPermiteReservaModal" tabindex="-1" aria-labelledby="mensajeNoPermiteReservaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">{{ __('Veris') }}</h1>
                    <p class="fs--1 fw-normal" id="mensajeNoPermiteReserva">{{ __('Reserva no permitida por este canal') }}</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Convenios -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Elige tu convenio:') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaConvenios">
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn fw-normal fs--16 line-height-20 m-0 px-3 py-2" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">Veris</h1>
                    <p class="fs--1 fw-normal" id="mensajeError" >
                </p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal infomracion de la cita -->
    <div class="modal fade" id="informacionCitaModal" tabindex="-1" aria-labelledby="informacionCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3"  id="tituloInformacionCita">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal" id="mensajeInformacionCita"></p>
                </div>
                <div id="footerInformacionCita">
                    <div class="modal-footer pt-0 pb-3 px-3">
                        <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24" id="nombreClass"
        ></h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5 active" id="pills-pendientes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Realizados</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
                <!-- Filtro -->
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltrosLaboratorio'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade mt-3 show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenes" class="px-0">
                    </div>
                    <!-- Mensaje No tienes órdenes de terapia -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientos">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes órdenes de terapia</h5>
                                    <p class="fs--16 line-height-20 mb-4">En esta sección podrás revisar tus órdenes de terapia física</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/muletas.svg') }}" alt="muletas" class="rounded-circle">
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
                </div>
                <div class="tab-pane fade mt-3" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <!-- Card header items -->
                    <div id="contenedorTratamientosImagenesRealizados" class="px-0">
                    </div>
                    <!-- Mensaje No tienes órdenes de terapia realizadas -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientosRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes órdenes de terapia realizadas</h5>
                                    <p class="fs--16 line-height-20 mb-4">En esta sección podrás revisar tus órdenes de terapia física realizadas</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/muletas.svg') }}" alt="muletas" class="rounded-circle">
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
    let servicioVariable = '{{ $tipoServicio }}';
    let nombreClase;

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        // cargar el nombre de la clase con el nombre de servicioVariable
        const nombreClass = document.getElementById('nombreClass');
        if (servicioVariable == 'TERAPIA') {
            nombreClass.innerHTML = 'Terapia física';
        } else if (servicioVariable == 'IMAGENES,PROCEDIMIENTOS') {
            nombreClass.innerHTML = 'Imágenes y procedimientos';
        }

        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerTratamientosId();
        await consultarGrupoFamiliar();

        var $enlace = $('.btn-agendar');

        // Maneja el evento de clic en el enlace
        $enlace.on('click', function(event) {
            // Previene el comportamiento predeterminado del enlace
            event.preventDefault();

            // Establece un retraso de 2 segundos antes de redirigir
            setTimeout(function() {
                // Obtiene la URL del enlace
                var url = $enlace.attr('href');
                // Redirige a la URL después del retraso
                window.location.href = url;
            }, 500); // Cambia este valor (en milisegundos) para ajustar el tiempo de retraso
        });

        // boton informacion
        $(document).on('click', '.btn-informacion', function(){
            let datosRel = $(this).data('rel');
            let datos = datosRel.servicio;
            if (datos.esCaducado === "S" && datos.esAgendable === "S") {
                // CAMBIAR TITUOLO MODAL
                $('#tituloModalInformacionCita').text('Orden expirada');
                $('#mensajeInformacionCita').text('El tiempo para agendar esta orden expiró, puedes agendar la cita sin cobertura.');
                // limpiar footer
                $('#footerInformacionCita').empty();
                // agregar boton agendar y salir
                $('#footerInformacionCita').append(`<div class="modal-footer pt-0 pb-3 px-3">
                        <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" data-rel='${JSON.stringify(datosRel)}' id="btnAgendarCitaModal">{{ __('Agendar') }}</button>
                    </div>
                    <div class="modal-footer pt-0 pb-3 px-3">
                        <button type="button" class="btn fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Salir') }}</button>
                    </div>`);
            } else {
                $('#mensajeInformacionCita').text(datos.mensaje);
            }
        });

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

        // boton ver ordenCard
        $(document).on('click', '#verOrdenCard', function(){
            let datos = $(this).data('rel');
            descargarDocumentoPdf(datos);
        });

        // boton ver orden  realizado
        $(document).on('click', '.btnVerOrden', function(){
            let datos = $(this).data('rel');
            descargarDocumentoPdf(datos);
        });

        // boton agendar cita modal setear datos en localstorage
        $(document).on('click', '#btnAgendarCitaModal', function(){
            let datosRel = $(this).data('rel');
            console.log('datosRel', datosRel);
            let datos = datosRel.servicio;
            let datosConvenio = datosRel.tratamiento;
            console.log('datosConvenio', datos);
            let online;
            if (datos.modalidad == 'PRESENCIAL') {
                online = 'N';
            } else {
                online = 'S';
            }
            // capturar el data-rel del filtro
            let dataPaciente = $('input[name="listGroupRadios"]:checked').data('rel');
            let params = {}
            params.online = online;
            params.paciente = dataPaciente;
            params.especialidad = {
                codigoEspecialidad : datos.codigoEspecialidad,
                codigoPrestacion : datos.codigoPrestacion,
                codigoServicio : datos.codigoServicio,
                codigoTipoAtencion : datos.codigoTipoAtencion,
                esOnline : online,
                imagen : datos.urlImagenTipoServicio,
                nombre : datos.nombreServicio,
            }
            params.convenio = datosConvenio;

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            if (online == 'S') {
                window.location.href = '/citas-elegir-fecha-doctor/{{ $tokenCita }}';
            } else {
                // ir a central medica
                window.location.href = '/citas-elegir-central-medica/{{ $tokenCita }}';
            }
            
        });

        // boton agendar cita modal setear datos en localstorage 
        $(document).on('click', '.btn-agendar', function(){
            let datosServicio = $(this).data('rel');
            let convenio = JSON.parse($(this).attr('convenio-rel'));
            console.log('datosServicio', datosServicio);

            let modalidad;
            if (datosServicio.modalidad === 'ONLINE') {
                modalidad = 'S';
            } else if (datosServicio.modalidad === 'PRESENCIAL') {
                modalidad = 'N';
            }
        
            let dataCita = {}
            dataCita.online = modalidad;

            let dataPaciente = $('input[name="listGroupRadios"]:checked').data('rel');
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
                origen: "Listatratamientos"
            };
            dataCita.origen = "Listatratamientos";
            dataCita.convenio = convenio;
            dataCita.convenio.origen = "Listatratamientos";
            dataCita.tratamiento = datosServicio;
            dataCita.tratamiento.numeroOrden = datosServicio.idOrden;
            dataCita.tratamiento.codigoEmpOrden = datosServicio.codigoEmpresa;
            dataCita.tratamiento.lineaDetalle = datosServicio.lineaDetalleOrden;

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
        });

        $(document).on('click', '.btn-CambiarFechaCita', function(){
            console.log('click entro a cambiar fecha');
            let data = $(this).data('rel');
            let url = $(this).attr('url-rel');
            // const dataConvenio = await consultarConvenios(data);
            // const dataPaciente = await consultarDatosPaciente(data);
            let esVirtual = "N";
            if(data.modalidad != "PRESENCIAL"){
                esVirtual = "S";
            }
            if (data.estaPagada == "N"){
                let params = {}
                let esVirtual = "N";
                if(data.modalidad != "PRESENCIAL"){
                    esVirtual = "S";
                }
                
                params.online = esVirtual;
                params.especialidad = {
                    codigoEspecialidad: data.codigoEspecialidad,
                    codigoPrestacion  : data.codigoPrestacion,
                    codigoServicio   : data.codigoServicio,
                    codigoTipoAtencion: data.codigoTipoAtencion,
                    esOnline : esVirtual,
                    nombre : data.nombreEspecialidad,
                }
                params.paciente = {
                    numeroIdentificacion: data.numeroIdentificacion,
                    tipoIdentificacion: data.tipoIdentificacion,
                    nombrePaciente: data.nombrePaciente,
                    numeroPaciente: data.numeroPaciente
                }

                params.reservaEdit = {
                    estaPagada: data.esPagada,
                    numeroOrden: data.idOrden,
                    lineaDetalleOrden: data.lineaDetalleOrden,
                    codigoEmpresaOrden: data.codigoEmpresa,
                    idOrdenAgendable: data.idOrdenAgendable,
                    idCita: data.detalleReserva.codigoReserva
                }
                params.origen = "inicios";
                
                localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

                if(datosConvenios.length == 0){
                    location = url;
                    return;
                }

                llenarModalConvenios(datosConvenios, url);

                $('#convenioModal').modal('show');
            }else{    
                let params = {}
                params.online = data.esVirtual;
                
                params.online = esVirtual;
                params.especialidad = {
                    codigoEspecialidad: data.codigoEspecialidad,
                    codigoPrestacion  : data.codigoPrestacion,
                    codigoServicio   : data.codigoServicio,
                    codigoTipoAtencion: data.codigoTipoAtencion,
                    esOnline : esVirtual,
                    nombre : data.nombreEspecialidad,
                }

                if (datosConvenios.length > 0) {
                    console.log('datosConvenio', datosConvenios);
                    // datosconvenio posicion 0
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

                params.reservaEdit = {
                    estaPagada: data.esPagada,
                    numeroOrden: data.idOrden,
                    lineaDetalleOrden: data.lineaDetalleOrden,
                    codigoEmpresaOrden: data.codigoEmpresa,
                    idOrdenAgendable: data.idOrdenAgendable,
                    idCita: data.detalleReserva.codigoReserva
                }
                params.origen = "inicios";
                localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
                
                if(data.permitePagoReserva == "S" || datosConvenios.length == 0){
                    // alert("Corrigiendo")
                    location = url;
                }else{
                    //data.mensajePagoReserva
                    llenarModalConvenios(datosConvenios, url);
                    $('#convenioModal').modal('show');
                }
            }
        });
        
    });


    // consultar convenios y llenar el modal de convenios
    function llenarModalConvenios(data, url){
        let divContenedor = $('#listaConvenios');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = '';
        data.forEach((convenios) => {
            console.log('convenioss', convenios);
            elemento += `<div data-rel='${JSON.stringify(convenios)}' url-rel='${url}' class="convenio-item mb-2">
                                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="text-primary-veris fs--1 line-height-16">
                                            ${capitalizarCadaPalabra(convenios.nombreConvenio)}
                                        </label> 
                                    </div>
                                </div>`;
        });
        // agregar convenio ninguno
        elemento += `<div data-rel='ninguno' class="convenio-ninguno" url-rel='${url}' >
                        <div class="list-group-item rounded-3 py-2 px-3 border-0">
                            <label for="listGroupCheckableRadiosninguno" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                Ninguno
                            </label>
                        </div>
                    </div>`;
        divContenedor.append(elemento);
    }
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
        let servicio = servicioVariable;
        if (fechaDesde != '' && fechaHasta == '') {
            fechaHasta = fechaDesde;
        }
        if (estado == 'PENDIENTE') {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
        } else if (estado == 'REALIZADO') {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=S&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
        }
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if (!pacienteSeleccionado) {
            data.data.tienePermisoAdmin = true;
        }
        if (data.code == 200){

            if(estado == 'PENDIENTE'){
                if (data.code == 200) {
                    if(data.data.items.length == 0){
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
                    } else {
                        if (data.data.tienePermisoAdmin) {
                            datosLaboratorio = data.data.items;
                            console.log('datosLaboratorio',datosLaboratorio);
                            let html = $('#contenedorTratamientosImagenes');
                            $('#mensajeNoTienesImagenesProcedimientos').addClass('d-none');
                            $('#mensajeNoTienesPermisosAdministrador').addClass('d-none');
                            html.empty();

                            let elementos = ''; // Definir la variable fuera del bucle

                            data.data.items.forEach((laboratorio) => {
                                elementos += `<div class="col-12 mb-4">
                                                <div class="card rounded-0">
                                                    <div class="card-body py-2 px-3">
                                                        <p class="fs--3 line-height-12 text-primary-veris mb-1">Tratamiento</p>
                                                        <h6 class="text-primary-veris fs--18 line-height-24 fw-medium mb-1">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h6>
                                                        <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                                                        <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                                                        <p class="fw-normal fs--2 line-height-16 mb-1">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                                                        <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mb-3 px-3">
                                                <div class="col-12 col-md-10 col-lg-9">
                                                    <div class="row g-3 cardTratamientoLaboratorio">
                                                        <!-- items -->
                                                        `;
                            
                                laboratorio.detallesTratamiento.forEach((detalles) =>{
                                    elementos += `<div class="col-12 col-md-6">
                                                    <div class="card">
                                                        <div class="card-body p--2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                                <span class="text-warning-veris fs--2 line-height-16 mb-1">${determinarEstado(detalles.esPagada , estado)}</span>
                                                            </div>
                                                            ${determinarFechaCaducidadEncabezado(detalles, laboratorio)}
                                                            ${determinarFechasCaducadas(detalles, laboratorio)}
                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <div class="avatar-sm me-2">
                                                                    <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                                </div>
                                                                <div>
                                                                    ${determinarCondicionesBotones(detalles, estado, laboratorio)}
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
                    }else{
                        if (data.data.tienePermisoAdmin) {
                            console.log('entrando a realizado lleno');
                            datosLaboratorio = data.data.items;
                            console.log('datosLaboratorio',datosLaboratorio);
                            let html = $('#contenedorTratamientosImagenesRealizados');
                            html.empty();
                            console.log('datosLaboratorioR',datosLaboratorio);

                            let elementos = ''; 

                            datosLaboratorio.forEach((laboratorio) => {
                                elementos += `<div class="col-12 mb-4">
                                                <div class="card rounded-0">
                                                    <div class="card-body py-2 px-3">
                                                        <p class="fs--3 line-height-12 text-primary-veris mb-1">Tratamiento</p>
                                                        <h6 class="text-primary-veris fs--18 line-height-24 fw-medium mb-1">${capitalizarElemento(laboratorio.nombreEspecialidad)}</h6>
                                                        <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombrePaciente)}</p>
                                                        <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(laboratorio.nombreMedico)}</p>
                                                        <p class="fw-normal fs--2 line-height-16 mb-1">Tratamiento enviado: <b class="text-primary fw-normal">${laboratorio.fechaTratamiento}</b></p>
                                                        <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(laboratorio.nombreConvenio)}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mb-3 px-3">
                                                <div class="col-12 col-md-10 col-lg-9">
                                                    <div class="row g-3 cardTratamientoLaboratorio">
                                                        <!-- items -->
                                                        `;
                            
                                laboratorio.detallesTratamiento.forEach((detalles) =>{
                                    elementos += `<div class="col-12 col-md-6">
                                                    <div class="card">
                                                        <div class="card-body p--2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                                <span class="text-warning-veris fs--2 line-height-16 mb-1">${determinarEstado(detalles.esPagada, estado)}</span>
                                                            </div>
                                                            ${determinarFechasCaducadas(detalles, laboratorio)}
                                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <div class="avatar-sm me-2">
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
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`;
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
            
            if (datos.estado == "AGENDADO" || datos.estado == "ATENDIDO") {
                dataFechas = `<h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(datos.nombreSucursal)}</h6>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(datos.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${datos.detalleReserva.horaReserva}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(datos.nombreMedicoAtencion)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarCadaPalabra(datos.nombrePaciente)}</p> `;
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

    // determinar condiciones de los botones 
    function determinarCondicionesBotones(datosServicio, estado, datosTratamiento){
        let services = datosServicio;
        if (datosServicio.length == 0) {
            return `<div></div>`;
        } else {
            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                    let respuestaAgenda = "";
                    // Agregar ver orden 
                    respuestaAgenda += ` <button type="button" class="btn btn-sm text-primary-veris fw-normal fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard" data-bs-toggle="modal" data-bs-target="#verOrdenModal">Ver orden</button>`;
                    let datosCombinados = {
                        servicio: datosServicio,
                        tratamiento: datosTratamiento
                    };
                    let convenio = {
                        "permitePago": "S",
                        "permiteReserva": "S",
                        "idCliente": null,
                        "codigoConvenio": null,
                    };
                    if(Object.keys(datosTratamiento.datosConvenio).length > 0){
                        convenio = datosTratamiento.datosConvenio
                    }
                    if(datosServicio.estado == 'PENDIENTE_AGENDAR'){
                        if(datosServicio.esCaducado == 'S'){
                            // mostrar boton de informacion que llama al modal de informacion
                            respuestaAgenda += `<button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-informacion" data-bs-toggle="modal" data-bs-target="#informacionCitaModal" data-rel='${JSON.stringify(datosCombinados)}'>Información</button>`;
                        } else {
                            if(datosServicio.permiteReserva == 'S'){
                                if (datosServicio.habilitaBotonAgendar == 'S') {
                                    if(datosServicio.modalidad == 'PRESENCIAL'){
                                        let ruta = '/citas-elegir-central-medica/';
                                        let urlCompleta = ruta + "{{ $tokenCita }}"
                                        respuestaAgenda += `<a href="${urlCompleta}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-agendar" convenio-rel='${JSON.stringify(convenio)}' data-rel='${JSON.stringify(datosServicio)}'>Agendar</a>`;
                                    } else {
                                        let ruta = '/citas-elegir-fecha-doctor/';
                                        let urlCompleta = ruta + "{{ $tokenCita }}"
                                        // ir a fechas
                                        respuestaAgenda += `<a href="${urlCompleta}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-agendar" convenio-rel='${JSON.stringify(convenio)}' data-rel='${datosServicio}'>Agendar</a>`;
                                    }
                                } else {
                                    respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 disabled">Agendar</a>`;
                                }
                            } else {
                                // abrir modal no permite reserva
                                respuestaAgenda += `<button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none" data-bs-toggle="modal" data-bs-target="#mensajeNoPermiteReservaModal">Agendar</button>`;
                            }
                        }
                    } else if (datosServicio.estado == 'ATENDIDO'){
                        // mostrar boton de ver orden
                        respuestaAgenda = ``;
                        respuestaAgenda += ` <button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard" data-bs-toggle="modal" data-bs-target="#verOrdenModal"> Ver orden</button>`;  
                    } else if (datosServicio.estado == 'AGENDADO'){
                        let ruta = "/citas-elegir-fecha-doctor/{{ $tokenCita }}";
                        if (datosServicio.modalidad == "PRESENCIAL") {
                            ruta = "/citas-elegir-central-medica/{{ $tokenCita }}";
                        }
                        // mostrar boton de ver orden
                        if (datosServicio.permitePago == 'S' && datosServicio.esPagada == "N"){
                            // mostrar boton de pagar
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none">Pagar</a>`;
                        }  else if  (datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                            
                            // respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            if(datosServicio.modalidad == "ONLINE"){
                                respuestaAgenda += `<a href="${datosServicio.detalleReserva.idTeleconsulta}" class="btn btn-sm fs--1 px-3 py-2 border-0 ms-2 btn-primary-veris shadow-none">Conectarme</a>`;
                            }
                        } else if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                            // mostrar boton de informacion
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none" onclick="mostrarInformacion(${datosServicio.detalleReserva.mensajeInformacion})">Información</a>`;
                        } 
                    }
                    return respuestaAgenda;
                    break;
                case "LAB":
                    console.log('estadossss', estado);
                    let respuesta = "";
                    if (estado == 'PENDIENTE'){
                        respuesta += ` <button type="button" class="btn btn-sm text-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard" data-bs-toggle="modal" data-bs-target="#verOrdenModal">Ver orden</button>`;
                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${codigoTratamiento}" class="btn btn-sm btn-veris fw-medium fs--1 line-height-16 px-3 py-2">Ver resultados</a>`;
                        } else {
                            respuesta += ``;
                        }
                        //condición para 'aplicaSolicitud'
                        if (datosServicio.aplicaSolicitud == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                        } else if (datosServicio.permitePago == "S"){
                            let params = {}
                            params.idPaciente = idPaciente;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            respuesta += `<a href="/citas-laboratorio/{{$tokenCita}}/${ulrParams}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none">Pagar</a>`;
                        }
                    } else if (estado == 'REALIZADO'){
                        console.log('estadossss2', estado);
                        respuesta = "";
                        respuesta += ` <button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none" id="verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    }
                    return respuesta;
                    break;
                case "RECETAS" :
                    if (estado == 'REALIZADO') {
                        return `<button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 btnVerOrden" data-bs-toggle="offcanvas" 
                        data-bs-target="#detalleRecetaMedica" aria-controls="detalleRecetaMedica" data-rel='${JSON.stringify(datosServicio)}'>
                         Ver receta</button>`;
                    } else {
                        if(datosServicio.aplicaSolicitud == "S"){
                            return `<a href="/farmacia-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none me-1"><i class="bi bi-telephone-fill me-2"></i>Solicitar</a>`;
                        }
                    }
                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    respuestaOdontologia += ` <button type="button" class="btn text-primary-veris fw-medium fs--1 line-height-16 px-3 py-2" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    // ABRIRE MODAL DE VIDEO CONSULTA
                    respuestaOdontologia += `<button type="button" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2" data-bs-toggle="modal" data-bs-target="#mensajeVideoConsultaModal"> Agendar</button>`;
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

        let isFirstElement = true; // Variable para identificar el primer elemento
        data.forEach((Pacientes) => {
            let checkedAttribute = isFirstElement ? 'checked' : 'unchecked'; // Establecer 'checked' para el primer elemento
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

</script>
@endpush