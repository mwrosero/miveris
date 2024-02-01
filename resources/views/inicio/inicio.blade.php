@extends('template.app-template-veris')
@section('title')
Mi Veris - Inicio
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
    // dd($tokenCita);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="agendarCitaMedicaModal" tabindex="-1" aria-labelledby="agendarCitaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header">
                    <button type="button" class="btn-close fw-medium bg-transparent me-2 top-50 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-3 pt-2">
                    <h5 class="text-center mb-4">¿Qué quieres agendar?</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col-6 col-lg-6">
                            <div class="card mb-3">
                                <a href="/mis-tratamientos">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-7 col-md-7">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Lo que envió') }} <br> {{ __('mi doctor') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-4">
                                            <img src="{{ asset('assets/img/card/svg/paste.svg') }}" class="img-fluid" alt="paste">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="card mb-3">
                                <a href="/citas">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-7 col-md-7">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Una nueva') }} <br> {{ __('cita médica') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-4">
                                            <img src="{{ asset('assets/img/card/svg/doctor.svg') }}" class="img-fluid" alt="doctor">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Inicio') }}</h5>
    </div>
    <!-- Accesos rápidos -->
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-medium border-start-veris ps-3 fs-18">{{ __('Accesos rápidos') }}</h6>
        </div>
        <div class="swiper swiper-acceso-rapidos position-relative py-3">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card">
                        <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#agendarCitaMedicaModal">
                            <div class="row g-0 justify-content-between align-items-center">
                                <div class="col-7 col-md-7">
                                    <div class="card-body p-0 ps-2">
                                        <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Agendar cita médica') }}</h6>
                                    </div>
                                </div>
                                <div class="col-5 col-md-auto">
                                    <img src="{{ asset('assets/img/card/svg/doctora.svg') }}" class="img-fluid" alt=""  >
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card">
                        <a href="{{route('home.promociones')}}">
                            <div class="row g-0 justify-content-between align-items-center">
                                <div class="col-7 col-md-7">
                                    <div class="card-body p-0 ps-2">
                                        <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Comprar promociones') }}</h6>
                                    </div>
                                </div>
                                <div class="col-5 col-md-auto">
                                    <img src="{{ asset('assets/img/card/svg/comprar.svg') }}" class="img-fluid" alt=""  >
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card">
                        <a href="/servicio-domicilio" >
                            <div class="row g-0 justify-content-between align-items-center">
                                <div class="col-7 col-md-7">
                                    <div class="card-body p-0 ps-2">
                                        <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Solicitar servicios') }} <br> {{ __('a domicilio') }}</h6>
                                    </div>
                                </div>
                                <div class="col-5 col-md-auto">
                                    <img src="{{ asset('assets/img/card/svg/motociclista.svg') }}" class="img-fluid" alt=""  >
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <button type="button" id="prevProperties" class="d-flex d-lg-none mt-n4 btn btn-prev rounded-circle"></button>
            <button type="button" id="nextProperties" class="d-flex d-lg-none mt-n4 btn btn-next rounded-circle"></button>
        </div>
    </section>
    <!-- Tratamientos dinamico -->
    <section class="bg-light-grayish-blue p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-medium border-start-veris ps-3 fs-18 mb-0">Mis tratamientos</h5>
            <a href="{{route('tratamientos')}}" class="fw-medium fs--2 me-1" id="verTodosTratamientos">Ver todos</a>
        </div>
        <div class="swiper swiper-tratamientos position-relative py-3">
            <div class="swiper-wrapper mb-3 mb-md-0" id="contenedorTratamientoHome">
            </div>
            <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
            <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
        </div>
        <div class="py-3" id="contenedorTratamientosHomePrincipal"></div>
    </section>
    <!-- Mis citas dinamico -->
    <section class="bg-light-grayish-blue p-3 mb-3" id="section-citas">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-medium border-start-veris ps-3 fs-18 mb-0">Mis citas</h5>
            <a href="{{route('citas')}}" class="btn btn-sm text-primary-veris fs--2 d-none">Ver todas <i class="fa-solid fa-chevron-right ms-3"></i></a>
        </div>
        <div class="swiper swiper-proximas-citas position-relative py-3">
            <div class="swiper-wrapper" id=contenedorCitas>
            </div>
            <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
            <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
        </div>
        <div class="py-3" id="contenedorCitasHomePrincipal"></div>
    </section>
    <!-- Urgencias ambulatorias dinamico -->
    <section class="bg-light-grayish-blue p-3 mb-3" id="section-urgencias">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-medium border-start-grenadier ps-3 fs-18 mb-0">Urgencias ambulatorias</h5>
            <a href="javascript:void(0)" class="btn btn-sm text-primary-veris fs--2 d-none">Ver todos</a>
        </div>
        <div class="swiper swiper-urgencias-ambulatorias position-relative py-3">
            <div class="swiper-wrapper" id="contenedorUrgenciasAmbulatorias">
            </div>
            <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
            <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
        </div>
        <div class="py-3" id="contenedorUrgenciasAmbulatoriasMensaje"></div>
    </section>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script>
<script>

    //variables globales
    let datosTratamientos = [];
    let datosCitas = [];
    let datosConvenios = [];
    let datosPaciente = [];

    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPPD();
        await obtenerTratamientos();
        await obtenerCitas();
        await obtenerUrgenciasAmbulatorias();
        await consultarConvenios();
        // await consultarDatosPaciente();
        // initializeSwiper('.swipertratamientos');
        // initializeSwiper('.swiper-proximas-citas');
    });

    //  ---Funciones asyncronas

    

    // servicio para consultar convenios
    async function consultarConvenios(){
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}"
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}"
        let codigoEmpresa = 1
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/comercial/paciente/convenios?canalOrigen=APP_CMV&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEmpresa=${codigoEmpresa}&tipoCredito=CREDITO_SERVICIOS`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const dataConvenio = await call(args);
        if(dataConvenio.code == 200){
            datosConvenios = dataConvenio.data;
        }
       
        return dataConvenio;
    }

    // servicio para consultar datos del paciente
    async function consultarDatosPaciente(data){
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}"
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}"
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/seguridad/cuenta?canalOrigen=APP_CMV&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const dataPaciente = await call(args);
        if(dataPaciente.code == 200){
            datosPaciente = dataPaciente.data;
        }
        return dataPaciente;
    }
    //obtener las politicas
    let _ppd;
    async function obtenerPPD(){
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1";
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        _ppd = data.data;
        if(data.code == 200){
            console.log(data.data)

            if(localStorage.getItem('politicasAbiertas') == null){
                console.log('emtro');
                let politicas = JSON.parse(localStorage.getItem('politicas'));
                if((data.data.estadoPoliticas == "N" || data.data.estadoPoliticas == "R") && (data.data.isPoliticasAceptadas == null || data.data.isPoliticasAceptadas == false)){
                    localStorage.setItem('politicasAbiertas', true);
                    $('#modalPPD').modal('show');
                    // $('#politicasPPD').attr('href',politicas.linkPoliticaPrivacidad);
                }
                else {
                    // localStorage.setItem('estadoPoliticas', data.data.estadoPoliticas);
                    // localStorage.setItem('isPoliticasAceptadas', data.data.isPoliticasAceptadas);
                    $('#modalPPD').modal('hide');
                }
            }
            else {
                $('#modalPPD').modal('hide');
            }
        }
    }

    //aceptar las politicas
    async function aceptarPoliticas(){
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({

            "aceptaPoliticas": true,
            "versionPoliticas": _ppd.ultimaVersionPoliticas,
            "codigoEmpresa": 1,
            "plataforma": "WEB",
            "versionPlataforma": "7.0.1",
            "identificacion": "{{ Session::get('userData')->numeroIdentificacion }}",
            "tipoIdentificacion": {{ Session::get('userData')->codigoTipoIdentificacion }},
            "tipoEvento": "CR",
            "canalOrigen": _canalOrigen

        });
        const data = await call(args);
        return data;
    }

    // recibir los tratamientos en home
    async function obtenerTratamientos(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = {{ Session::get('userData')->numeroPaciente }};
        // imprimir todos los valores de session
        
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&estadoTratamiento=PENDIENTE&fechaInicio=&fechaFin=&page=1&perPage=3&idPacienteFiltrar=&esDetalleRealizado=N&esResumen=S&cantidadDetalles=2&canalOrigen=${canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(args["endpoint"]);
        const data = await call(args);
        console.log('INITR',data.data.items);
        if(data.code == 200){
            if(data.data.items.length == 0){
                mostrarNoExistenTratamientos();
            } else {
                datosTratamientos = data.data.items;
                console.log(datosTratamientos.length);
                mostrarTratamientoenDiv();
            }
        }
        chartProgres('#chart-progress');
        return data;
    }

    // consultar citas
    async function obtenerCitas(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = {{ Session::get('userData')->codigoTipoIdentificacion }};

        args["endpoint"] = api_url + `/digitalestest/v1/agenda/citasVigentes?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroPaciente}&version=7.8.0`
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(args["endpoint"]);
        const data = await call(args);
        console.log('citas',data);
        if (data.code == 200) {
            console.log(0, data.data.length);
            if (data.data.length == 0) {
                mostrarNoExistenCitas();
            } else {
                console.log('si hay citas');
                datosCitas = data.data;
                mostrarCitasenDiv();
            }
        }
        return data;
    }

    // consultar urgencias ambulatorias
    async function obtenerUrgenciasAmbulatorias(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = {{ Session::get('userData')->codigoTipoIdentificacion }};

        args["endpoint"] = api_url + `/digitalestest/v1/atencion_prioritaria/ingresos?idPaciente=${numeroPaciente}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if (data.code == 200) {
           console.log('exito',data.data.length);
           if(data.data.length == 0){
                mostrarNoExistenUrgencias();
              } else {
                // mostrarUrgenciasAmbulatorias();
           }
        }
        return data;
    }

    //aceptar politicas
    $('#aceptarPDP').click(async function(){
        console.log("clicks");
        const response = await aceptarPoliticas();
        console.log("sisi",response);
        if(response.code == 200){
            cerrarModal();
        }
    });

    //cerrar el modal de politicas reuerdame
    $(document).on('click', '#modalRecuerdame', function(){
        console.log('click');
        localStorage.setItem('politicaspoliticasAbiertas', true);
        $('#modalPPD').modal('hide');
    });

    function cerrarModal(){
        $('#modalPPD').modal('hide');
    }

    // llenar el div de tratamientos
    function mostrarTratamientoenDiv() {
        let data = datosTratamientos;

        let divContenedor = $('#contenedorTratamientoHome');
        divContenedor.empty(); // Limpia el contenido actual

        data.forEach((tratamientos) => {
            let elemento = `<div class="swiper-slide">
                                <div class="card h-100">
                                    <div class="card-body p-3">
                                        <div class="row gx-0 justify-content-between align-items-center mb-3">
                                            <div class="col-9">
                                                <h6 class="card-title text-primary-veris mb-0 capitalizar">${capitalizarElemento(tratamientos.nombreEspecialidad)}</h6>
                                                <p class="fw-medium fs--2 mb-0">${capitalizarElemento(tratamientos.nombrePaciente)}</p>
                                                <p class="card-text fs--2">Dr(a): ${capitalizarElemento(tratamientos.nombreMedico)}</p>
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
                                                            <p class="text-success fw-medium fs--2 mb-0">${tratamientos.totalTratamientoRealizados}/${tratamientos.totalTratamientoEnviados}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group list-group-checkable d-grid align-items-center h-50 gap-2 border-0">`;

            // Bucle anidado para detalleTratamiento
            tratamientos.detallesTratamiento.forEach((detalle) => {
                let params = {
                    codigoTratamiento: detalle.codigoTratamiento,
                    porcentajeAvanceTratamiento: tratamientos.porcentajeAvanceTratamiento
                };

                // convertir objeto a base64
                let paramsBase64 = btoa(JSON.stringify(params));

                elemento += `<label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 p-2 my-auto">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                        <img class="rounded-circle" src=${quitarComillas(detalle.urlImagenTipoServicio)}  width="26" alt="icono">
                                    </div>
                                    <p class="text-veris fw-medium fs--2 mb-0">${capitalizarElemento(detalle.nombreServicio)}</p>
                                </div>
                                <a href="/tratamiento/${paramsBase64}"
                                class="btn btn-sm text-primary-veris fs--2 shadow-none">Ver <i class="fa-solid fa-chevron-right ms-1"></i></a>
                            </label>`;
            });

            // Finalizar construcción del elemento HTML
            elemento += `</div></div></div></div>`;

            // Agregar 'elemento' al DOM
            divContenedor.append(elemento);
        });
    }

    // mostrar mensaje de no hay tratamientos
    function mostrarNoExistenTratamientos() {
        document.getElementById('verTodosTratamientos').style.display = 'none';
        document.querySelector('.swiper-tratamientos').style.display = 'none';
        let data = datosTratamientos;

        let divContenedor = $('#contenedorTratamientosHomePrincipal');
        divContenedor.empty(); // Limpia el contenido actual

        let elemento = `<div class="text-center">
                            <img src="{{ asset('assets/img/svg/rheumatology.svg') }}" alt="">
                            <h6 class="fw-normal">Agenda una cita y revisa tus <b>tratamientos</b> aquí</h6>
                        </div>`;
        divContenedor.append(elemento);
            
    }

    // llenar el div de citas
    function mostrarCitasenDiv() {
        let data = datosCitas;

        let divContenedor = $('#contenedorCitas');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = '';

        data.forEach((citas) => {
            let classElem = 'justify-content-between';
            if(citas.estaPagada == "S"){
                classElem = 'justify-content-end';
            }
            elemento +=`<div class="swiper-slide">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="w-100">`;
            if(citas.esVirtual == "S"){
                elemento += `<div style="display: inline-flex; justify-content: space-between; align-items: center; background-color: #CEEEFA; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                        <h7 class="text-primary-veris fw-bold mb-0">Consulta online</h7>
                    </div>`;
            }
                    elemento += `<div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-primary-veris fw-medium mb-0">${capitalizarElemento(citas.especialidad)}</h6>
                            <span class="fs--2 text-success fw-medium">${esPagada(citas.estaPagada)}</span>
                        </div>
                        <p class="fw-medium fs--2 mb-0">${capitalizarElemento(citas.sucursal)}</p>
                        <p class="fw-normal fs--2 mb-0">${citas.fechaReserva} <b class="hora-cita fw-normal text-primary-veris">${citas.horaInicio}</b></p>
                        <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(citas.medico)}</p>
                        <p class="fw-normal fs--2 mb-0">${citas.nombrePaciente}</p>
                        <div class="d-flex ${classElem} align-items-center mt-3">`
            if(citas.estaPagada == "N"){
                elemento += `<button type="button" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>`;
            }
            let ruta = '';
            if (citas.esVirtual == "S") {
                ruta = "/citas-elegir-fecha-doctor/" + "{{ $tokenCita }}" 
            } else {
                ruta = "/citas-elegir-central-medica/" + "{{ $tokenCita }}"
            }

            elemento += `   <a href="${ruta}" class="btn btn-sm text-primary-veris border-none shadow-none btn-CambiarFechaCita" data-rel='${JSON.stringify(citas)}'>${citas.nombreBotonCambiar}</a> `
            if (citas.esVirtual == "S") {
                elemento += `<a href="${citas.idTeleconsulta}
                " class="btn btn-sm btn-primary-veris ms-3 m-0">Conectarme</a>`;
            }
            elemento += `
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        });
        divContenedor.append(elemento);
    } 

    // mostrar mensaje de no hay citas
    function mostrarNoExistenCitas() {
        document.getElementById('section-citas').style.display = 'none';
        document.querySelector('.swiper-proximas-citas').style.display = 'none';
        let data = datosCitas;
        let divContenedor = $('#contenedorCitasHomePrincipal');
        divContenedor.empty(); // Limpia el contenido actual

        let elemento = `<div class="text-center">
                            <img src="{{ asset('assets/img/svg/rheumatology.svg') }}" alt="">
                            <h6 class="fw-medium mb-0">No tiene próximas citas</h6>
                            <p class="fw-normal">Agenda una cita pulsado aqui <a href="{{route('citas')}}">Agendar cita</a></p>
                        </div>`;
        divContenedor.append(elemento);
    }

    // llenar el div de urgencias ambulatorias
    function mostrarUrgenciasAmbulatorias() {
        let data = datosCitas;

        let divContenedor = $('#contenedorUrgenciasAmbulatorias');
        divContenedor.empty(); // Limpia el contenido actual

        let elemento =+ ``;
        data.forEach((urgencias) => {
        let elemento =+ `<div class="swiper-slide">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary-veris fw-medium mb-0">${capitalizarElemento(urgencias.modulo)}</h6>
                                        <span class="fs--2 text-success fw-medium"><i class="fa-solid fa-circle me-1"></i>Reservado</span>
                                    </div>
                                    <p class="fw-medium fs--2 mb-0">${capitalizarElemento(urgencias.nombreSucursal)}</p>
                                    <p class="fw-normal fs--2 mb-0">AGO 09, 2022 <b class="hora-cita fw-normal text-primary-veris">10:20 AM</b></p>
                                    <p class="fw-normal fs--2 mb-0">Dr(a) ${capitalizarElemento(urgencias.medico)}</p>
                                    <p class="fw-normal fs--2 mb-0">${urgencias.paciente}</p>
                                    <div class="d-flex justify-content-between align-items-center m-0 ms-3">
                                        <button type="submit" class="btn btn-sm text-danger-veris shadow-none"><i class="fa-regular fa-trash-can"></i></button>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary-veris">Nueva fecha</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        });
        divContenedor.append(elemento);
    }

    // mostrar mensaje de no hay urgencias
    function mostrarNoExistenUrgencias() {
        document.getElementById('section-urgencias').style.display = 'none';
        document.querySelector('.swiper-urgencias-ambulatorias').style.display = 'none';
        let data = datosCitas;
        let divContenedor = $('#contenedorUrgenciasAmbulatoriasMensaje');
        divContenedor.empty(); // Limpia el contenido actual

        let elemento = `<div class="text-center">
                            <img src="{{ asset('assets/img/svg/rheumatology.svg') }}" alt="">
                            <h6 class="fw-medium mb-0">No tiene urgencias ambulatorias</h6>
                        </div>`;
        divContenedor.append(elemento);
    }
    

    // funcion para controlar swiper independientes
    // function initializeSwiper(swiperSelector) {
    //     document.querySelectorAll(swiperSelector).forEach(swiperElement => {
    //         const prevButton = swiperElement.querySelector('.btn-prev');
    //         const nextButton = swiperElement.querySelector('.btn-next');
    //         const slides = swiperElement.querySelectorAll('.swiper-slide');

    //         // Ocultar botones si hay menos de 4 slides
    //         console.log(slides.length);
    //         if (slides.length >= 4) {
    //         prevButton.style.opacity = 1;
    //         nextButton.style.opacity = 1;
    //     } else {
    //         prevButton.style.opacity = 0;
    //         nextButton.style.opacity = 0;
    //     }

    //         new Swiper(swiperElement, {
    //             navigation: {
    //                 nextEl: nextButton,
    //                 prevEl: prevButton,
    //             },
    //                 // Agrega aquí otras opciones de configuración si son necesarias
    //                 slidesPerView: 3,
    //                 spaceBetween: 10,
                    
    //             });
    //         });
    // }

    // funcion esPagada para saber si la cita esta pagada
    function esPagada(pagada){
        if(pagada == 'S'){
            return `<span class="fs--2 text-success fw-medium"><i class="fa-solid fa-circle me-1"></i> Cita pagada</span>`;
        } else {
            return `<span class="fs--2 text-danger-veris fw-medium"><i class="fa-solid fa-circle me-1"></i> Cita no pagada</span>`;
        }
    }

    // setear los valores de la cita en localstorage
    $(document).on('click', '.btn-CambiarFechaCita', function(){
        console.log('click entro a cambiar fecha');
        let data = $(this).data('rel');
        // const dataConvenio = await consultarConvenios(data);
        // const dataPaciente = await consultarDatosPaciente(data);
        
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
        if (datosConvenios.length > 0) {
            params.convenio = dataConvenio.data[0];
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
            "estaPagada": data.estaPagada,
            "numeroOrden": data.numeroOrden,
            "lineaDetalleOrden": data.lineaDetalleOrden,
            "codigoEmpresaOrden": data.codigoEmpresaOrden,
            "idOrdenAgendable": data.idOrdenAgendable,
            "idCita": data.idCita
        }
        params.origen = "inicios";

        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
    });

    

</script>
<style>
    /* .btn-transition {
        opacity: 0;
        transition: opacity 0.01s ease;
    } */
</style>

@endpush