@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis tratamientos
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <!-- Modal de error -->

    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3 pb-2">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal" id="mensajeError" >
                </p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grow-1 container-p-y pt-0">


    

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Mis tratamientos') }}</h5>
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
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    <div class="d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3" id="contenedorTratamiento">
                                <!-- items dinamicos de tratamientos -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-realizados" role="tabpanel" aria-labelledby="pills-realizados-tab" tabindex="0">
                    <div class="d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="row g-3" id="contenedorTratamientoRealizados">
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
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
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
        let numeroPaciente = id;

        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos?idPaciente=${numeroPaciente}&estadoTratamiento=${estadoTratamiento}&canalOrigen=${canalOrigen}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&version=7.8.0`

        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(args["endpoint"]);
        const data = await call(args);
        console.log(data.data.items);
        if(data.code == 200){
            datosTratamientos = data.data.items;
            
            if (document.getElementById('pills-pendientes-tab').getAttribute('aria-selected') === 'true') {
                if (estadoTratamiento == 'PENDIENTE') {
                    mostrarTratamientoenDiv(esAdmin);
                }
            }
                
            else if (document.getElementById('pills-realizados-tab').getAttribute('aria-selected') === 'true') {
                if (estadoTratamiento == 'REALIZADO') {
                    mostrarTratamientoenDivRealizados(esAdmin);
                }
                
            }
        }
        else if (data.code != 200) {
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
        } else{

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
                console.log('ulrParams', params);

                let elemento = `<div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row gx-0 justify-content-between align-items-center">
                                                <div class="col-9">
                                                    <h6 class="card-title text-primary-veris mb-0">${capitalizarElemento(tratamientos.nombreEspecialidad)}</h6>
                                                    <p class="fw-bold fs--2 mb-0">${capitalizarElemento(tratamientos.nombrePaciente)}</p>
                                                    <p class="card-text fs--2 mb-0">Dr(a): ${capitalizarElemento(tratamientos.nombreMedico)}</p>
                                                    <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="fecha-enviado fw-normal text-primary-veris">${tratamientos.fechaTratamiento}</b></p>
                                                </div>
                                                <div class="col-3">
                                                    <div class="progress-circle" data-percentage="${ roundToDraw(tratamientos.porcentajeAvanceTratamiento) }">
                                                        <span class="progress-left">
                                                            <span class="progress-bar"></span>
                                                        </span>
                                                        <span class="progress-right">
                                                            <span class="progress-bar"></span>
                                                        </span>
                                                        <div class="progress-value">
                                                            <div>
                                                                <span><i class="bi bi-check2 success"></i></span>
                                                                <p class="fs--2 mb-0">${tratamientos.totalTratamientoRealizados}/${tratamientos.totalTratamientoEnviados}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a href="/tratamiento/${ulrParams}
                                                    " class="btn btn-sm btn-primary-veris shadow-none">
                                                        ${ botonMisTratamientosPorcentaje(tratamientos.porcentajeAvanceTratamiento) }
                                                    </a>
                                                </div>
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
                                <div class="card">
                                    <div class="card-body position-relative p-3">
                                        <div class="position-absolute end-0">
                                            <img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3" alt="golden">
                                        </div>
                                        <div class="text-center">
                                            <div class="col-auto">
                                                <div class="progress-circle" data-percentage="${tratamientosRealizados.porcentajeAvanceTratamiento}">
                                                    <span class="progress-left">
                                                        <span class="progress-bar"></span>
                                                    </span>
                                                    <span class="progress-right">
                                                        <span class="progress-bar"></span>
                                                    </span>
                                                    <div class="progress-value">
                                                        <div>
                                                            <span><i class="bi bi-check2 success"></i></span>
                                                            <p class="fs--2 mb-0">${tratamientosRealizados.totalTratamientoRealizados}/${tratamientosRealizados.totalTratamientoEnviados}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="card-title mb-2">${capitalizarElemento(tratamientosRealizados.nombreEspecialidad)}</h6>
                                        </div>
                                        <div class="row g-0 justify-content-between align-items-end">
                                            <div class="col-md-9">
                                                <p class="fw-bold fs--2 mb-0" style="color: #003B83;">¡Tratamiento terminado!</p>
                                                <p class="fw-normal fs--2 mb-0">Dr(a): ${capitalizarElemento(tratamientosRealizados.nombreMedico)}</p>
                                                <p class="fw-light fs--2 mb-0">Terminado el: <b class="text-primary-veris fw-light fs--2" id="fechaTratamiento">${tratamientosRealizados.fechaTratamiento}</b></p>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="/tratamiento/${ulrParams}"
                                                 class="btn btn-sm btn-primary-veris px-2">Ver todo</a>
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
    // mostrar no tiene tratamiento pendientes
    function mostrarMensajeNoTieneTratamiento(){
        
        let data = datosTratamientos;

        let divContenedor = $('#contenedorTratamiento');
        divContenedor.empty(); // Limpia el contenido actual
        
        let elemento = `<div class="col-12 d-flex justify-content-center">
                            <div class="card bg-transparent shadow-none">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5>No tienes tratamientos</h5>
                                        <p>En esta sección podrás revisar tus tratamientos</p>
                                        <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
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
                                    <div class="card bg-transparent shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h5>No tienes tratamientos realizados</h5>
                                                <p>En esta sección podrás ver los tratamientos terminados</p>
                                                <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
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
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h5>No tienes permisos de administrador</h5>
                                                <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                                <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
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
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h5>No tienes permisos de administrador</h5>
                                                <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                                <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
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
</script>
@endpush