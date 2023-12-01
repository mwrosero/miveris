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
    
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Laboratorio') }}</h5>
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
                <div class="tab-pane fade show active" id="pills-pendientes" role="tabpanel" aria-labelledby="pills-pendientes-tab" tabindex="0">
                    @include('components.barraFiltro')
                    @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])

                    <!-- Card header items -->
                    <div id="contenedorTratamientosPendientes">
                        
                    </div>
                    
                    <!-- Mensaje No tienes ordenes de laboratorio -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesProcedimientos">
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
                    <div class="col-12 d-flex justify-content-center d-none">
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
                    <div id="contenedorTratamientosRealizados">
                        

                    </div>

                    <!-- Mensaje No tienes ordenes de laboratorio realizadas -->
                    <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesProcedimientosRealizados">
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
                    <div class="col-12 d-flex justify-content-center d-none">
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

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await obtenerTratamientos('PENDIENTE');
        await consultarGrupoFamiliar();
    });

    // funciones asyncronas
    // Consultar los tratamientos de un paciente imagen y procedimientos
    async function obtenerTratamientos(estado, pacienteSeleccionado, fechaDesde, fechaHasta) {
        console.log('obtenerTratamientosImagenProcedimientos');
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = {{ Session::get('userData')->numeroPaciente }};
        let plataforma = _plataforma;
        let version = _version;
        let servicio = 'LABORATORIO';
        if (isNaN(fechaDesde) || isNaN(fechaHasta)) {
            args["endpoint"] = api_url + `/digitales/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
       
        } else {
            args["endpoint"] = api_url + `/digitales/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&canalOrigen=${canalOrigen}&estadoTratamiento=${estado}&fechaInicio=${fechaDesde}&fechaFin=${fechaHasta}&page=1&perPage=100&esDetalleRealizado=N&esResumen=N&tipoServicio=${servicio}&plataforma=${plataforma}&version=${version}&aplicaNuevoControl=false`;
        }
        args["method"] = "GET";
        args["showLoader"] = false;
        console.log(args["endpoint"]);
        const data = await call(args);
        if(estado == 'PENDIENTE'){
            console.log('entrando a pendiente');
            if (data.code == 200) {
                if(data.data.items.length == 0){
                    $('#mensajeNoTienesProcedimientos').removeClass('d-none');
                    
                }else{
                    datosLaboratorio = data.data.items;
                    console.log('datosLaboratorio',datosLaboratorio);
                    let html = $('#contenedorTratamientosPendientes');
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
                                                            <img src="{{ asset('assets/img/svg/microscopio.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
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

                } 
                return data;
            } 
        }else if(estado == 'REALIZADO'){
            console.log('entrando a realizado');
            if (data.code == 200) {
                if(data.data.items.length == 0){
                    $('#mensajeNoTienesProcedimientosRealizados').removeClass('d-none');
                    
                }else{
                    datosLaboratorio = data.data.items;
                    console.log('datosLaboratorio',datosLaboratorio);
                    let html = $('#contenedorTratamientosRealizados');
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
                                                            <img src="{{ asset('assets/img/svg/microscopio.svg') }}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
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
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="${Pacientes.numeroPaciente}" unchecked>
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
        let pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
        let fechaDesde = $('#fechaDesde').val();
        let fechaHasta = $('#fechaHasta').val();
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
            await obtenerTratamientos( estadoTratamiento, pacienteSeleccionado, fechaDesde, fechaHasta);
        }

        
        
    });
    // limpiar filtros
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