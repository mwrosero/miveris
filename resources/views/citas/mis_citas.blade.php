@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis citas
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">

    <!-- offcanva ver pdf -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="verPdf" aria-labelledby="verPdfLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="verPdfLabel">Mis documentos</h5>
            <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atrás</b></button>
        </div>
        <br>
        <br>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <div>
                <div class="list-group gap-2 mb-3 verPdf">
                    <button class="list-group-item d-flex align-items-center gap-2 border rounded-3 py-3">
                        <span class="text-veris fw-bold">
                            RECOMENDACIONES
                        </span>
                        <i class="bi bi-download ms-auto"></i>
                    </button>
                </div>
                <div class="list-group gap-2 mb-3 verPdf">
                    <button class="list-group-item d-flex align-items-center gap-2 border rounded-3 py-3">
                        <span class="text-veris fw-bold">
                            FACTURA
                        </span>
                        <i class="bi bi-download ms-auto"></i>
                    </button>
                </div>
                
            </div>
        </div>
    </div>


    <!-- Filtro -->
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Mis citas') }}</h5>
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
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade mt-3 show active" id="pills-actuales" role="tabpanel" aria-labelledby="pills-actuales-tab" tabindex="0">
                    <!-- botn de agendar -->
                    <div class="text-center">
                        <a href="/citas" class="btn btn-primary-veris px-lg-5 mb-4 px-5 p-3">Agendar cita</a>
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
                                    <p class="fs--1">Agende una nueva cita pulsando el botón de abajo</p>
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
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTratamiento">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes tratamientos historial</h5>
                                    <p>En esta sección podrás ver los tratamientos terminados</p>
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

    // llamada al dom

    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerHistorialCitas();
        await obtenerCitas();
        await consultarGrupoFamiliar();
    });

    //funciones asincronas

    // obtener historial de citas

    async function obtenerHistorialCitas(fechaDesde, fechaHasta, pacienteSeleccionado , esAdmin, estadoCitas) {
        console.log(fechaDesde, fechaHasta);
        let args = [];
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
        let canalOrigen = _canalOrigen;
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        if (!Date.parse(fechaDesde) || !Date.parse(fechaHasta)) {
            console.log('Fechas inválidas');
            
            
            args["endpoint"] = api_url + `/digitalestest/v1/agenda/historialCitas?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion} `; 
        } else {
            console.log('si hay fechas');
            fechaDesde = formatearFecha(fechaDesde);
            fechaHasta = formatearFecha(fechaHasta);
            args["endpoint"] = api_url + `/digitalestest/v1/agenda/historialCitas?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&desde=${fechaDesde}&hasta=${fechaHasta}`;
        }
        

        // args["endpoint"] = api_url + `/digitalestest/v1/agenda/historialCitas?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}`;
        args["method"] = "GET";
        console.log('argsss', args["endpoint"]);
        args["showLoader"] = true;

        const data = await call(args);
        console.log('respuesta', data);

        if (data.code == 200){

            if (data.data.length == 0) {
                $('#mensajeNoCita').removeClass('d-none');
            } else{
                $('#mensajeNoCita').addClass('d-none');
                // llenar div historialCitas


                let historialCitas = $('#historialCitas');
                historialCitas.empty();

                // forEach de data.data

                data.data.forEach((historial) => {

                    let element = `<div class="col-12 col-md-6">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(historial.nombreEspecialidad)}</h6>
                                                        ${determinarMensajeEstadoCita(historial.mensajeEstado)}
                                                    </div>
                                                    <p class="fw-bold fs--2 mb-0">${capitalizarElemento(historial.nombreSucursal)}</p>
                                                    <p class="fw-normal fs--2 mb-0"> ${historial.dia}<b class="hora-cita fw-normal text-primary-veris"> ${determinarAmPm(historial.horaInicio)}</b></p>
                                                    <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(historial.nombreProfesional)}</p>
                                                    <p class="fw-normal fs--2 mb-0">${capitalizarElemento(historial.nombrePaciente)}</p>
                                                    <div class="d-flex justify-content-end align-items-center mt-3">
                                                        <div>
                                                            <a href="#" class="btn btn-sm btn-outline-primary-veris shadow-none" data-bs-toggle="offcanvas" data-bs-target="#verPdf" aria-controls="verPdf"><i class="bi bi-file-earmark-pdf"></i> Ver PDF</a>
                                                            <a href=${quitarComillas(historial.urlEncuesta)} class="btn btn-sm btn-outline-primary-veris shadow-none">Calificar</a>
                                                            <a href="/citas" class="btn btn-sm btn-primary-veris shadow-none">Reagendar</a>
                                                        </div>
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
        let canalOrigen = _canalOrigen;
        let numeroPaciente = "{{ Session::get('userData')->numeroIdentificacion }}";

        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        if (pacienteSeleccionado) {
            numeroPaciente = pacienteSeleccionado;
        }

        args["endpoint"] = api_url + `/digitalestest/v1/agenda/citasVigentes?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroPaciente}&version=7.8.0`
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
            } else{

                let citasActuales = $('#citasActuales');
                $('#mensajeNoCita').addClass('d-none');
                citasActuales.empty();

                // forEach de data.data

                data.data.forEach((cita) => {

                    let element = `<div class="col-12 col-md-6">
                                        <div class="card">
                                            <div class="card-body p-2">`
                                            if (cita.esVirtual == 'S') {
                                                element += `<div style="display: inline-flex; justify-content: space-between; align-items: center; background-color: #CEEEFA; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                                                                <h7 class="text-primary-veris fw-bold mb-0">Consulta online</h7>
                                                            </div>`;
                                            }
                        element += `<div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(cita.especialidad)}</h6>
                                        ${determinarMensajeEstadoCita(cita.mensajeEstado)}

                                    </div>
                                    <p class="fw-bold fs--2 mb-0">${capitalizarElemento(cita.sucursal)}</p>
                                    <p class="fw-normal fs--2 mb-0"> <b class="hora-cita fw-normal text-primary-veris">${cita.dia}</b></p>
                                    <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(cita.medico)}</p>
                                    <p class="fw-normal fs--2 mb-0">${cita.nombrePaciente}</p>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        ${determinarBotonCita(cita)}
                                        `;

                        if (cita.esVirtual == "S") {
                            element += `<a href="${cita.idTeleconsulta}" class="btn btn-sm btn-primary-veris m-3">Conectarme</a>
                                    </div>`;
                        }

                        element += `</div>
                                </div>
                            </div>
                        </div>`;
                    citasActuales.append(element);

                });

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
            mensaje += `<span class="fs--2 text-success fw-bold"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>`;
        } else if (mensajeEstado == 'No Atendida') {
            mensaje += `<span class="fs--2 text-warning-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> No atendida</span>`;
        } else if (mensajeEstado == 'Pago Pendiente') {
            mensaje += `<span class="fs--2 text-danger-veris fw-bold"><i class="fa-solid fa-circle me-1"></i> Pago pendiente</span>`;
        }

        return mensaje;
    }


    // mostrar lista de pacientes en el filtro
    function mostrarListaPacientesFiltro(){

        let data = familiar;

        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let elementoYo = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="{{ Session::get('userData')->numeroIdentificacion }}" data-rel='YO'
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
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroIdentificacion}" esAdmin= ${Pacientes.esAdmin} unchecked>
                                <span class="text-veris fw-bold">
                                    
                                    ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                                </span>
                            </label>`;
            divContenedor.append(elemento);

        });
    }


    // aplicar filtros
    $('#aplicarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        aplicarFiltrosCitas(contexto);
        // Obtener el texto completo de la opción seleccionada data-rel
        const texto = $('input[name="listGroupRadios"]:checked').data('rel');

        console.log('texto', texto);

        const elemento = document.getElementById('nombreFiltro');
        if (texto == 'YO') {
            elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
        } else{
            elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
        }

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







</script>
@endpush