@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis tratamientos
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
                <div class="modal-body p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal" id="mensajeError">
                </p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis tratamientos') }}</h5>
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
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade mt-3 px-2 show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    <div class="d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row gx-0 gy-3 g-md-3" id="contenedorTratamiento">
                                <!-- items dinamicos de tratamientos -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mt-3 px-2" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <div class="d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row gx-0 gy-3 g-md-3" id="contenedorTratamientoRealizados">
                                <!-- items dinamicos de tratamientos realizados -->
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
        locale: _langDate,
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
        locale: _langDate,
        // maxDate: "today"
    });
</script>
<script>
    
    // variables globales
    let datosTratamientos = [];
    let familiar = [];
    let identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
    let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
    let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
    let nombrePaciente = "{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}";
    let numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";
    

    // llamar al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        console.log('canalOrigen', _canalOrigen);   
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        
        await obtenerTratamientosId();
        await consultarGrupoFamiliar();
        
    });


    // funciones asynronas
    // obtener tratamientos
    // obtener tratamiento por id
    async function obtenerTratamientosId(id='', fechaDesde='', fechaHasta='', estadoTratamiento='PENDIENTE', esAdmin='S') {
        let args = [];
        let canalOrigen = _canalOrigen;
        if (id == '') {
            id = {{ Session::get('userData')->numeroPaciente }};
        }

        fechaDesde = $('#fechaDesde').val() || '';
        fechaHasta = $('#fechaHasta').val() || '';
        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);

        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos?idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${id}&estadoTratamiento=${estadoTratamiento}&canalOrigen=${canalOrigen}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&version=7.8.0`
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(args["endpoint"]);
        const data = await call(args);
        console.log(22,data.data.tienePermisoAdmin);
        
        if(data.code == 200){
            if (data.data.tienePermisoAdmin) {
                esAdmin = 'S';
            }else{
                esAdmin = 'N';
            }

            datosTratamientos = data.data.items;
            
            if (document.getElementById('pills-pendientes-tab').getAttribute('aria-selected') === 'true') {
                if (estadoTratamiento == 'PENDIENTE') {
                    mostrarTratamientoenDiv(esAdmin);
                }
            } else if (document.getElementById('pills-realizados-tab').getAttribute('aria-selected') === 'true') {
                if (estadoTratamiento == 'REALIZADO') {
                    mostrarTratamientoenDivRealizados(esAdmin);
                }
            }
        } else if (data.code != 200) {
            console.log('errorza');
            // mostrar modal de error
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');

        }
        return data;
    }


    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
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

    // funciones js adicionales
    // mostrar el tratamientos pendientes
    function mostrarTratamientoenDiv(esAdmin){
        console.log('esAdmin4', esAdmin);
        let data = datosTratamientos;
        let divContenedor = $('#contenedorTratamiento');
        divContenedor.empty(); // Limpia el contenido actual
        if (esAdmin == 'N') {
            mostrarMensajeNoEsAdmin();
        } else if (data.length == 0) {
            mostrarMensajeNoTieneTratamiento();
        } else {
            data.forEach((tratamientos) => {
                let params = { 
                    "codigoTratamiento": tratamientos.codigoTratamiento,
                    "porcentajeAvanceTratamiento": tratamientos.porcentajeAvanceTratamiento
                }
                params.paciente = {
                    "numeroIdentificacion": numeroIdentificacion,
                    "tipoIdentificacion": tipoIdentificacion,
                    "nombrePaciente": nombrePaciente,
                    "numeroPaciente": numeroPaciente
                }
                let ulrParams = btoa(JSON.stringify(params));

                let elemento = `<div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p--2">
                                            <div class="row gx-0 justify-content-between align-items-center mb-2">
                                                <div class="col-9">
                                                    <h5 class="card-title text-one-line text-primary-veris fs--18 fs-medium line-height-24 mb-1 cart">${capitalizarElemento(tratamientos.nombreEspecialidad)}</h5>
                                                    <p class="fw-medium text-one-line fs--2 line-height-16 mb-1">${capitalizarElemento(tratamientos.nombrePaciente)}</p>
                                                    <p class="card-text text-one-line fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(tratamientos.nombreMedico)}</p>
                                                    <p class="fw-normal fs--2 line-height-16 mb-1">Tratamiento enviado: <b class="fecha-enviado fw-normal text-primary-veris">${tratamientos.fechaTratamiento}</b></p>
                                                </div>
                                                <div class="col-3">
                                                    <div class="progress-circle ms-auto" data-percentage="${ roundToDraw(tratamientos.porcentajeAvanceTratamiento) }">
                                                        <span class="progress-left">
                                                            <span class="progress-bar"></span>
                                                        </span>
                                                        <span class="progress-right">
                                                            <span class="progress-bar"></span>
                                                        </span>
                                                        <div class="progress-value">
                                                            <div>
                                                                <span><i class="bi bi-check2 fw-medium success"></i></span>
                                                                <p class="fw-medium text-success fs--2 mb-0">${tratamientos.totalTratamientoRealizados}/${tratamientos.totalTratamientoEnviados}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <a href="/tratamiento/{{ $tokenCita }}" data-rel='${JSON.stringify(params)}' 
                                                 class="btn btn-sm btn-primary-veris shadow-none btn-tratamiento border-0 fs-medium fs--1 line-height-16 px-3 py-2">
                                                    ${ botonMisTratamientosPorcentaje(tratamientos.porcentajeAvanceTratamiento) }
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

                divContenedor.append(elemento);
            });
            chartProgres("#chart-progress");
        }
    }

    
    // mostrar el tratamientos realizados
    function mostrarTratamientoenDivRealizados(esAdmin){
        console.log('esAdmin3', esAdmin);
        let data = datosTratamientos;

        let divContenedor = $('#contenedorTratamientoRealizados');
        divContenedor.empty(); // Limpia el contenido actual

        if (esAdmin == 'N') {
            console.log('esAdmin2 entro', esAdmin);
            mostrarMensajeNoEsAdminRealizados();
        } else{
            if (data.length == 0) {
                mostrarMensajeNoTieneTratamientoRealizados();
            }
        }
        
        data.forEach((tratamientosRealizados) =>{
            let params = {
                "codigoTratamiento": tratamientosRealizados.codigoTratamiento,
                "porcentajeAvanceTratamiento": tratamientosRealizados.porcentajeAvanceTratamiento
            }
            params.paciente = {
                "numeroIdentificacion": numeroIdentificacion,
                "tipoIdentificacion": tipoIdentificacion,
                "nombrePaciente": nombrePaciente,
                "numeroPaciente": numeroPaciente
            }

            let ulrParams = btoa(JSON.stringify(params));
            console.log('ulrParams', params);
            let elemento = `<div class="col-12 col-md-6">
                                <div class="card h-100">
                                    <div class="card-body position-relative p--2">
                                        <div class="position-absolute end-0">
                                            <img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3" alt="golden">
                                        </div>
                                        <div class="text-center">
                                            <div class="col-auto mb-2">
                                                <div class="progress-circle mx-auto mb-0" data-percentage="${tratamientosRealizados.porcentajeAvanceTratamiento}">
                                                    <span class="progress-left">
                                                        <span class="progress-bar"></span>
                                                    </span>
                                                    <span class="progress-right">
                                                        <span class="progress-bar"></span>
                                                    </span>
                                                    <div class="progress-value">
                                                        <div>
                                                            <span><i class="bi bi-check2 fw-medium success"></i></span>
                                                            <p class="fw-medium text-success fs--2 mb-0">${tratamientosRealizados.totalTratamientoRealizados}/${tratamientosRealizados.totalTratamientoEnviados}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title text-primary-veris fs--18 fs-medium line-height-24 mb-2 cartR">${capitalizarElemento(tratamientosRealizados.nombreEspecialidad)}</h5>
                                        </div>
                                        <div class="row g-3 g-lg-0 justify-content-between align-items-end">
                                            <div class="col-8 col-md-8">
                                                <p class="fw-medium fs--1 line-height-16 mb-1" style="color: #003B83;">¡Tratamiento terminado!</p>
                                                <p class="fw-normal text-one-line fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(tratamientosRealizados.nombreMedico)}</p>
                                                <p class="fw-light fs--2 line-height-16 mb-1">Terminado el: <b class="text-primary-veris fw-light fs--2" id="fechaTratamiento">${tratamientosRealizados.fechaTratamiento}</b></p>
                                            </div>
                                            <div class="col-4 col-md-4 text-end">
                                                <a href="/tratamiento/{{ $tokenCita }}" data-rel='${JSON.stringify(params)}' class="btn btn-sm btn-primary-veris btn-tratamientoRealizado shadow-none border-0 fs-medium fs--1 line-height-16 px-3 py-2">Ver todo</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            divContenedor.append(elemento);
        });

        chartProgres("#chart-progressRealizado");
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

    // mostrar no tiene tratamiento pendientes
    function mostrarMensajeNoTieneTratamiento(){
        let data = datosTratamientos;
        let divContenedor = $('#contenedorTratamiento');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = `<div class="col-12 d-flex justify-content-center">
                            <div class="card bg-transparent shadow-none">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes tratamientos</h5>
                                        <p>En esta sección podrás revisar tus tratamientos</p>
                                        <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" width="300" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>`;
        divContenedor.append(elemento);
    }

    // mostar no tiene tratamiento realizados
    function mostrarMensajeNoTieneTratamientoRealizados(){
        let data = datosTratamientos;
        let divContenedorRealizados = $('#contenedorTratamientoRealizados');
        divContenedorRealizados.empty(); // Limpia el contenido actual
        let elemento = `<div class="col-12 d-flex justify-content-center" id="mensajeNoTieneTratamientoRealizados">
                            <div class="card h-100 bg-transparent shadow-none">
                                <div class="card-body px-0">
                                    <div class="text-center">
                                        <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes tratamientos realizados</h5>
                                        <p class="fs--16 line-height-20 mb-4">En esta sección podrás ver los tratamientos terminados</p>
                                        <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" width="300" alt="sin resultados">
                                    </div>
                                </div>
                            </div>
                        </div>`;
        divContenedorRealizados.append(elemento);
    }

    // mostrar no es admin 
    function mostrarMensajeNoEsAdmin(){
        let data = datosTratamientos;
        let divContenedor = $('#contenedorTratamiento');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = `<div class="col-12 d-flex justify-content-center" id="mensajeNoTieneTratamientoRealizados">
                                    <div class="card bg-transparent shadow-none">
                                        <div class="card-body px-0">
                                            <div class="text-center">
                                                <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes permisos de administrador</h5>
                                                <p class="fs--16 line-height-20 mb-4">Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                                <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" width="300" alt="sin resultados">
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
        divContenedor.append(elemento);
    }

    // mostrar no es admin  en tratamientos realizados
    function mostrarMensajeNoEsAdminRealizados(){
        let data = datosTratamientos;
        let divContenedor = $('#contenedorTratamientoRealizados');
        divContenedor.empty(); // Limpia el contenido actual
        
        let elemento = `<div class="col-12 d-flex justify-content-center" id="mensajeNoTieneTratamientoRealizados">
                                    <div class="card bg-transparent shadow-none">
                                        <div class="card-body px-0">
                                            <div class="text-center">
                                                <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes permisos de administrador</h5>
                                                <p class="fs--16 line-height-20 mb-4">Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                                <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" width="300" alt="sin resultados">
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
        divContenedor.append(elemento);
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        aplicarFiltros(contexto);
        // Obtener el texto completo de la opción seleccionada data-rel
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');
        paciente = texto;
        console.log('textoPaciente', texto);

        identificacionSeleccionada = texto.numeroPaciente;
        numeroIdentificacion = texto.numeroIdentificacion;
        tipoIdentificacion = texto.tipoIdentificacion;
        nombrePaciente = texto.primerNombre + ' ' + texto.primerApellido + ' ' + texto.segundoApellido;
        numeroPaciente = texto.numeroPaciente;
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

    
    // funcion para Mostrar mensaje en el boton de mis tratamientos
    function botonMisTratamientosPorcentaje(porcentajeAvanceTratamiento){
        if (porcentajeAvanceTratamiento == 100) {
            return 'Ver todo';
        }else if (porcentajeAvanceTratamiento > 0 && porcentajeAvanceTratamiento < 100) {
            return 'Continuar';
        }else if (porcentajeAvanceTratamiento == 0) {
            return 'Empezar';
        }
    }

    // boton tratamiento realizado
    $('#pills-realizados-tab').on('click', async function(){
        const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
        await obtenerTratamientosId(identificacionSeleccionada, '', '', 'REALIZADO', esAdmin);
    });

    // boton tratamiento pendientes
    $('#pills-pendientes-tab').on('click', async function(){
        const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
        await obtenerTratamientosId(identificacionSeleccionada, '', '', 'PENDIENTE', esAdmin);
    });

    // funcion para setear los valores del tratamiento en el localstorage
    $(document).on('click', '.btn-tratamiento', function(){
        let dataTratamiento = $(this).data('rel');
        let paciente = $('input[name="listGroupRadios"]:checked').data('rel');
        let params = { }
        params.paciente = paciente;
        params.tratamiento = dataTratamiento;
        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
    });


    // funcion para setear los valores del tratamiento realizado en el localstorage
    $(document).on('click', '.btn-tratamientoRealizado', function(){
        let dataTratamiento = $(this).data('rel');
        let paciente = $('input[name="listGroupRadios"]:checked').data('rel');
        let params = { }
        params.paciente = paciente;
        params.tratamiento = dataTratamiento;
        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
    });

</script>
@endpush