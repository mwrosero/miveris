@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis tratamientos
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Mis tratamientos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-pendienes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Realizados</button>
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

                                
                                <!-- Mensaje No tiene tratamiento -->
                                <div class="col-12 d-flex justify-content-center d-none">
                                    <div class="card bg-transparent shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h5>No tienes tratamientos realizados</h5>
                                                <p>En esta sección podrás ver los tratamientos terminados</p>
                                                <img src="{{ asset('assets/img/svg/sin_tratamiento.svg') }}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
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
</script>
<script>
    
    // variables globales
    let datosTratamientos = [];
    let familiar = [];

    // llamar al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        console.log('canalOrigen', _canalOrigen);   
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        // const elementoRealizados = document.getElementById('nombreFiltroRealizados');
        // elementoRealizados.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerTratamientos();
        await consultarGrupoFamiliar();
        
    });


    // funciones js adicionales

    // mostrar el tratamientos pendientes
    function mostrarTratamientoenDiv() {
        let data = datosTratamientos;

        let divContenedor = $('#contenedorTratamiento');
        divContenedor.empty(); // Limpia el contenido actual
        data.forEach((tratamientos) => {
            if(tratamientos.porcentajeAvanceTratamiento < 100){
                let elemento = `<div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="row gx-0 justify-content-between align-items-center mb-2">
                                                <div class="col-9">
                                                    <h6 class="card-title text-primary-veris mb-0">${capitalizarElemento(tratamientos.nombreEspecialidad)}</h6>
                                                    <p class="fw-bold fs--2 mb-0">${capitalizarElemento(tratamientos.nombrePaciente)}</p>
                                                    <p class="card-text fs--2 mb-0">Dr(a): ${capitalizarElemento(tratamientos.nombreMedico)}</p>
                                                    <p class="fw-normal fs--2 mb-0">Tratamiento enviado: <b class="fecha-enviado fw-normal text-primary-veris">${tratamientos.fechaTratamiento}</b></p>
                                                </div>
                                                <div class="col-3">
                                                    <div id="chart-progress" data-porcentaje="${tratamientos.porcentajeAvanceTratamiento}" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a href="/tratamiento/${tratamientos.codigoTratamiento}" class="btn btn-sm btn-primary-veris">
                                                        ${ botonMisTratamientosPorcentaje(tratamientos.porcentajeAvanceTratamiento) }
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

                divContenedor.append(elemento);
            }
        });
        chartProgres("#chart-progress");
    }

    
    // mostrar el tratamientos realizados
    function mostrarTratamientoenDivRealizados(){
        let data = datosTratamientos;

        let divContenedor = $('#contenedorTratamientoRealizados');
        divContenedor.empty(); // Limpia el contenido actual

        data.forEach((tratamientosRealizados) =>{
            if(tratamientosRealizados.porcentajeAvanceTratamiento == 100){
                let elemento = `<div class="col-12 col-md-6">
                                    <div class="card">
                                        <div class="card-body position-relative p-3">
                                            <div class="position-absolute end-0">
                                                <img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3" alt="golden">
                                            </div>
                                            <div class="text-center">
                                                <div class="col-auto">
                                                    <div id="chart-progressRealizado" data-porcentaje="${tratamientosRealizados.porcentajeAvanceTratamiento}" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                                                </div>
                                                <h6 class="card-title mb-2">${capitalizarElemento(tratamientosRealizados.nombreEspecialidad)}</h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div>
                                                    <p class="fw-bold fs--2 mb-0">¡Tratamiento terminado!</p>
                                                    <p class="fw-normal fs--2 mb-0">Dr(a): ${capitalizarElemento(tratamientosRealizados.nombreMedico)}</p>
                                                    <p class="fw-light fs--2 mb-0">Terminado el: <b class="text-primary-veris fw-light fs--2" id="fechaTratamiento">${tratamientosRealizados.fechaTratamiento}</b></p>
                                                </div>
                                                <div>
                                                    <a href="#" class="btn btn-sm btn-primary-veris">Ver todo</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                divContenedor.append(elemento);
                
            }

        });
        chartProgres("#chart-progressRealizado");
    }
    // mostrar lista de pacientes en el filtro
    function mostrarListaPacientesFiltro(){

        let data = familiar;

        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let elementoYo = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="{{ Session::get('userData')->numeroPaciente }}" checked>
                                <span class="text-veris fw-bold">
                                    ${capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}")}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">Yo</small>
                                </span>
                            </label>`;
        divContenedor.append(elementoYo);

        console.log('sss',data);
        data.forEach((Pacientes) => {
            let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="${Pacientes.numeroPaciente}" unchecked>
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
        divContenedorRealizados.append(elemento);
    }
    // aplicar filtros
    $('#aplicarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        let pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
        let fechaDesde = $('#fechaDesde').val();
        let fechaHasta = $('#fechaHasta').val();
        let estadoTratamiento;
        if (document.getElementById('pills-pendienes-tab').getAttribute('aria-selected') === 'true') {
            estadoTratamiento = 'PENDIENTE';
        } else if (document.getElementById('pills-realizados-tab').getAttribute('aria-selected') === 'true') {
            estadoTratamiento = 'REALIZADO';
        }


        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);
        console.log('fechaDesde', fechaDesde);
        console.log('fechaHasta', fechaHasta);
        if (contexto === 'contextoAplicarFiltros') {
            await obtenerTratamientosId(pacienteSeleccionado, fechaDesde, fechaHasta, estadoTratamiento);
        }

        
        
    });
    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        if (contexto === 'contextoLimpiarFiltros') {
            $('input[name="listGroupRadios"]').prop('checked', false);
            $('input[name="listGroupRadios"]').first().prop('checked', true);
            $('#fechaDesde').val('');
            $('#fechaHasta').val('');
            await obtenerTratamientos();
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



    // funciones asynronas
    // obtener tratamientos
    async function obtenerTratamientos(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = {{ Session::get('userData')->numeroPaciente }};

        args["endpoint"] = api_url + `/digitales/v1/tratamientos?idPaciente=${numeroPaciente}&estadoTratamiento=TODOS&canalOrigen=${canalOrigen}&page=1&perPage=100&version=7.8.0`
        args["method"] = "GET";
        args["showLoader"] = false;
        console.log(args["endpoint"]);
        const data = await call(args);
        console.log('sa',data);
        if(data.code == 200){
            console.log(data.data.items.length);
            if (data.data.items.length == 0) {
                mostrarMensajeNoTieneTratamiento();
                mostrarMensajeNoTieneTratamientoRealizados();
            }else {
                datosTratamientos = data.data.items;
                mostrarTratamientoenDiv();
                mostrarTratamientoenDivRealizados();
            }
        }
        return data;

    }

    // obtener tratamiento por id
    async function obtenerTratamientosId(id, fechaDesde, fechaHasta, estadoTratamiento){

        console.log('fechaDesde', fechaDesde);
        console.log('fechaHasta', fechaHasta);
        
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = id;

        if (isNaN(fechaDesde) || isNaN(fechaHasta)) {
            args["endpoint"] = api_url + `/digitales/v1/tratamientos?idPaciente=${numeroPaciente}&estadoTratamiento=${estadoTratamiento}&canalOrigen=${canalOrigen}&page=1&perPage=100&version=7.8.0`
        }else {
        
        args["endpoint"] = api_url + `/digitales/v1/tratamientos?idPaciente=${numeroPaciente}&estadoTratamiento=${estadoTratamiento}&canalOrigen=${canalOrigen}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&version=7.8.0`
        }
        args["method"] = "GET";
        args["showLoader"] = false;
        console.log(args["endpoint"]);
        const data = await call(args);
        console.log(data.data.items);
        if(data.code == 200){
            datosTratamientos = data.data.items;
            if (document.getElementById('pills-pendienes-tab').getAttribute('aria-selected') === 'true') {
                if (datosTratamientos.length == 0) {
                    mostrarMensajeNoTieneTratamiento();
                }else {
                    mostrarTratamientoenDiv();
                }
            } else if (document.getElementById('pills-realizados-tab').getAttribute('aria-selected') === 'true') {
                if (datosTratamientos.length == 0) {
                    mostrarMensajeNoTieneTratamientoRealizados();
                }else {
                    mostrarTratamientoenDivRealizados();
                }
            }
        }

        return data;
    }

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientesFiltro();

        }
        return data;
    }
</script>
@endpush