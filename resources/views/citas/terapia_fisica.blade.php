@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Terapia física
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroTerapiaFisica" aria-labelledby="filtroTerapiaFisicaLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroTerapiaFisicaLabel">Filtros</h5>
            <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atras</b></button>
        </div>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <form action="">
                <h6 class="fw-light">Selecciona el paciente</h6>
                <div class="list-group gap-2 mb-3">
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked>
                        <span class="text-veris fw-bold">
                            Mary Samaniego Loor
                            <small class="fs--3 d-block fw-normal text-body-secondary">Madre</small>
                        </span>
                    </label>
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                        <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios2" value="">
                        <span class="text-veris fw-bold">
                            John Donoso Salgado
                            <small class="fs--3 d-block fw-normal text-body-secondary">Padre</small>
                        </span>
                    </label>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="fechaDesde" class="form-label">{{ __('Elige el rango de fechas') }} *</label>
                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                </div>
                <div class="col-md-12 mb-5">
                    <input type="text" class="form-control bg-neutral" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary-veris w-100 mt-5 mb-3 mx-0" type="submit">Aplicar filtros</button>
                    <button class="btn text-primary w-100 mb-3 mx-0" type="submit"><i class="bi bi-trash me-2"></i> Limpiar filtros</button>
                </div>
            </form>
        </div>
    </div>
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Terapia física') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-pendientes-tab" data-bs-toggle="pill" data-bs-target="#pills-pendientes" type="button" role="tab" aria-controls="pills-pendientes" aria-selected="true">Pendientes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-realizados-tab" data-bs-toggle="pill" data-bs-target="#pills-realizados" type="button" role="tab" aria-controls="pills-realizados" aria-selected="false">Realizados</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent" id="pills-tabContent">
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltrosLaboratorio'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    
                    <!-- Card header items -->

                    <div id="contenedorTratamientosImagenes">
                        

                    </div>
                    
                    <!-- Mensaje No tienes ordenes de terapia -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientos">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes ordenes de terapia</h5>
                                    <p>En esta sección podrás revisar tus ordenes de terapia física</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/muletas.svg') }}" alt="muletas" class="rounded-circle">
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
                                    <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
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

                    <!-- Mensaje No tienes ordenes de terapia realizadas -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesImagenesProcedimientosRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>No tienes ordenes de terapia realizadas</h5>
                                    <p>En esta sección podrás revisar tus ordenes de terapia física realizadas</p>
                                    <div class="avatar avatar-xxl-10 mx-auto">
                                        <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                            <img src="{{ asset('assets/img/svg/muletas.svg') }}" alt="muletas" class="rounded-circle">
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
                                    <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
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

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerTratamientos('PENDIENTE');
        await consultarGrupoFamiliar();
    });

    // funciones asyncronas
    // Consultar los tratamientos de un paciente imagen y procedimientos
    async function obtenerTratamientos(estado, pacienteSeleccionado, fechaDesde, fechaHasta, esAdmin) {
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
        let servicio = 'TERAPIA';
        if (isNaN(fechaDesde) || isNaN(fechaHasta)) {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
       
        } else {
            args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
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
                                                        <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">${detalles.fechaCaducidad}</b></p>
                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                            <div class="avatar me-2">
                                                                <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                                
                                                            </div>
                                                            <div>
                                                                ${determinarbotonesRecetaMedica(detalles)}  
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
                        datosLaboratorio = data.data.items;
                        console.log('datosLaboratorio',datosLaboratorio);
                        let html = $('#contenedorTratamientosImagenesRealizados');
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
                                                    <div class="col-12 col-md-6">`;
                        
                            laboratorio.detallesTratamiento.forEach((detalles) =>{
                                elementos += `<div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="text-primary-veris fw-bold mb-0">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                                            <span class="fs--2 text-warning-veris fw-bold">${determinarEstado(detalles.esPagada)}</span>
                                                        </div>
                                                        <p class="fw-normal fs--2 mb-0">Orden válida hasta: <b class="fw-normal text-primary-veris">${detalles.fechaCaducidad}</b></p>
                                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                                            <div class="avatar me-2">
                                                                <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                                            </div>
                                                            <div>
                                                                ${determinarbotonesRecetaMedica(detalles)}  
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




    // funciones js 

    // determinarCondiciones
    function determinarCondicionesBotones(data){

        if (data.length == 0) {
            return `<div></div>`;
        } else {

            switch (data.tipoCard){

                case 'AGENDA' : {
                    return `<div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar me-2">
                                    <img src="${quitarComillas(data.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                </div>
                                <div>
                                    <a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1${data.esAgendable !== 'S' ? ' disabled' : ''}"> Agendar</a>
                                </div>
                            </div>`;
                    
                        
                }

                break;
            }


        }

    }

    // determinar condiciones de agenda

    function determinarAgenda(data){
        if(data.esAgendable == 'S'){
            return `<a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1"> Agendar</a>`;
        }else{
            return '';
        }
        if (data.estado == 'PENDIENTE_AGENDAR'){




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

    // determinar si es receta medica o no botones
    function determinarbotonesRecetaMedica(detalles) {
        let botonVer = `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver ${detalles.tipoServicio === "LABORATORIO" ? "orden" : "receta"}</a>`;
        let botonSolicitar;

        if(detalles.esPagada === "N"){
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi  me-2"></i> Pagar</a>`;
            
        }else  if (detalles.tipoServicio === "FARMACIA") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1${detalles.aplicaSolicitud !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (detalles.tipoServicio === "LABORATORIO") {
            botonSolicitar = `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1${detalles.esAgendable !== 'S' ? ' disabled' : ''}"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else {
            botonSolicitar = `<a href="{{route('citas.listaCentralMedica')}}" class="btn btn-sm btn-primary-veris fw-normal fs--1${detalles.esAgendable !== 'S' ? ' disabled' : ''}"> Agendar</a>`;
        }

        return botonVer + botonSolicitar;
    }

    // mostrar lista de pacientes
    function mostrarListaPacientesFiltro(){

        let data = familiar;

        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let elementoYo = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="{{ Session::get('userData')->numeroPaciente }}" checked>
                                <span class="text-veris fw-bold">
                                    ${capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}")}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">Yo</small>
                                </span>
                            </label>`;
        divContenedor.append(elementoYo);

        console.log('sss',data);
        data.forEach((Pacientes) => {
            let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} unchecked>
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
        let pacienteSeleccionado = $('input[name="listGroupRadiosI"]:checked').val();
        let fechaDesde = $('#fechaDesde').val();
        let fechaHasta = $('#fechaHasta').val();
        let esAdmin = $('input[name="listGroupRadiosI"]:checked').attr('esAdmin');
        let estadoTratamiento;
        if (document.getElementById('pills-pendientes-tab').getAttribute('aria-selected') === 'true') {
            estadoTratamiento = 'PENDIENTE';
        } else if (document.getElementById('pills-realizados-tab').getAttribute('aria-selected') === 'true') {
            estadoTratamiento = 'REALIZADO';
        }


        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);



        if (contexto === 'contextoAplicarFiltros') {
            console.log('exito');   
            await obtenerTratamientos( estadoTratamiento, pacienteSeleccionado, fechaDesde, fechaHasta, esAdmin);
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

    // boton tratamiento realizado
    $('#pills-realizados-tab').on('click', async function(){
        console.log('realizados');
        await obtenerTratamientos('REALIZADO');
    });
</script>
@endpush