@extends('template.app-template-veris')
@section('title')
Elige Paciente
@endsection
@section('content')
@php
$tokenCita = base64_encode(uniqid());
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
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
    <div class="d-flex justify-content-between align-items-center bg-ai">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Agendamiento inteligente') }} <img class="ms-2" src="{{ asset('assets/img/svg/ai-icon.svg') }}" alt=""></h5>
    </div>
    <section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-3">
                    <div class="row g-3 justify-content-start mb-3">
                        <div class="col-12">
                            <div class="card h-100 border-ai">
                                <div class="card-body d-flex justify-content-between align-items-center px-3 py-2 bg-white rounded-3" style="min-height:100px;">
                                    <img src="{{ asset('assets/img/svg/vericita.svg') }}" class="w-25 me-3" alt="" style="min-height:84px;">
                                    <h6 class="fw-medium flex-grow-1 fs--1 mb-0 text-veris-ai" id="typewriter"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-start steps step-1" id="listaPacientes">
                        <div class="col-6 ">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center px-3 py-2">
                                    <a class="" href="{{route('familia')}}">
                                        <div class="d-flex justify-content-center align-items-center mb-2">
                                            <div class="avatar avatar-10">
                                                <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <p class="text-veris fw-medium fs--2 text-center mb-0">{{ __('Agregar nuevo paciente') }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-start steps step-2 d-none">
                        <div class="col-12">
                            <div class="mb-3 box-btn-especialidad element-no-paquete">
                                <button class="btn bg-white w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button">
                                    {{-- data-bs-toggle="modal" data-bs-target="#especialidadModal" id="btn-especialidad" data-rel="" --}}
                                    <p class="fs--1 line-height-16 fw-medium fs--1 mb-0">Seleccionar</p>
                                    <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Especialidad"> 
                                </button>
                            </div>
                            <div class="row w-100 m-0 bg-white rounded-3 p-3 gx-2 justify-content-between align-items-center box-lista-especialidades d-none">
                                <div class="col-12 mb-2 d-flex justify-content-center px-0">
                                    <div class="input-group search-box">
                                        <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-especialidad"></span>
                                        <input type="search" class="form-control bg-transparent fs--16 border-0 p-3 ps-0" name="buscar" id="buscar" placeholder="Buscar especialidad" aria-describedby="buscar">
                                    </div>
                                </div>
                                <div class="list-group-checkable p-0 d-grid gap-2 border-0" id="listaEspecialidades">
                                    {{-- <div class="col-12 p-2 px-3 rounded-3 d-flex justify-content-start align-items-center bg-white item-especialidad waves-effect shadow-item-modal cursor-pointer especialidad-item border" type-rel="button">
                                        <p class="text-veris fs--16 line-height-20 fw-medium text-one-line mb-0">Cirugía Oncologica</p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-start steps step-3 mb-3 d-none">
                        <div class="col-12 mb-3">
                            <div class="row border-modalidades">
                                <div class="col-6 mx-0 box-modalidad box-modalidad-presencial modalidad-selected">
                                    <button type="button" class="bg-transparent border-0 fs--18 line-height-24 m-0 p-3 py-2 w-100 shadow-none btn-modalidad rounded-0" data-rel="N">Presencial</button>
                                </div>
                                <div class="col-6 mx-0 box-modalidad box-modalidad-online">
                                    <button type="button" class="bg-transparent border-0 fs--18 line-height-24 m-0 p-3 py-2 w-100 shadow-none btn-modalidad rounded-0" data-rel="S">Virtual</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="swiper swiper-horarios position-relative py-3 pt-md-2 pb-md-4">
                                <div class="swiper-wrapper px-1">
                                    <div class="swiper-slide">
                                        asdasd
                                    </div>
                                    <div class="swiper-slide">
                                        asdasd
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="p-3 mb-3">
        <div class="row g-3" id="listaPacientes">
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center px-3 py-2">
                        <a class="" href="{{route('familia')}}">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar avatar-10">
                                    <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                </div>
                            </div>
                            <p class="text-veris fw-medium fs--2 text-center mb-0">{{ __('Agregar nuevo paciente') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
</div>
@endsection
@push('scripts')
<script>
    // variables globales
    let familiar = [];
    // CAPTURAR PARAMETROS
    let local = localStorage.getItem('cita-{{ $tokenCita }}');
    let dataCita = {};//JSON.parse(local);
    dataCita.online = "N";
    let online = dataCita?.online;
    let ordenExterna = dataCita?.ordenExterna;
    let dataPaciente;
    

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarGrupoFamiliar();
        $('body').on('click','.convenio-item', function(){
            reservaNoPermitida($(this).attr("url-rel"), $(this).attr("data-rel"));
        })
        
        $('#typewriter').empty();
        typeWriter('Por favor elige para quién es \n la cita médica.');

        $('body').on('click','.box-btn-especialidad', async function(){
            $(this).addClass('d-none');
            await consultarEspecialidades()
        })

        $('body').on('click', '.especialidad-item', async function(){
            let especialidad = JSON.parse($(this).attr('data-rel'));
            dataCita.especialidad = especialidad;
            await drawTabs();
            goTo(3,'Ahora estoy buscando las mejores opciones...');
            await obtenerCitasSugeridas();
        })

        $('body').on('input', '#buscar', function () {
            var value = $(this).val().toLowerCase();
            console.log("Valor de búsqueda:", value);
            
            $("#listaEspecialidades .item-especialidad").each(function () {
                let text = $(this).find('p.text-veris').text().toLowerCase(); // Obtiene el texto dentro de <p>
                console.log("Texto del elemento:", text);
                
                // Verificar si el texto contiene el valor de búsqueda
                if (text.indexOf(value) > -1 || value === "") {
                    $(this).removeClass("d-none"); // Mostrar el elemento
                } else {
                    $(this).addClass("d-none"); // Ocultar el elemento
                }
            });
        });

        $('body').on('click','.btn-modalidad', async function(){
            if(!$(this).parent().hasClass('modalidad-selected')){
                $('.btn-modalidad').parent().removeClass('modalidad-selected');
                $(this).parent().addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            }
        })

        var swiper = new Swiper('.swiper-horarios', {
            // slidesPerView: 1,
            spaceBetween: 8,
            navigation: {
                nextEl: '.btn-next',
                prevEl: '.btn-prev',
            },
            autoplay: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                300: {
                    slidesPerView: 1.1,
                    centeredSlides: false,
                    // loop: true,
                    spaceBetween: 4,
                },
                768: {
                    slidesPerView: 2.1,
                    // centeredSlides: true,
                    // loop: true,
                    // spaceBetween: 8,
                },
                1024: {
                    slidesPerView: 2.1,
                    // spaceBetween: 8,
                },
            },
        });

    });

    function goTo(stepNumber, legend){
        $('.steps').addClass('d-none');
        $('#typewriter').empty();
        typeWriter(legend)
        $('.step-'+stepNumber).removeClass('d-none');
    }

    async function drawTabs(){
        $.each(dataCita.especialidad.modalidadPrestacionAgenda, function(key, value){
            if(value != null){
                
            }
        })
    }

    let grouped = [];
    async function obtenerCitasSugeridas(){
        let fechaSeleccionada;
        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
            let necesitaValidacionFecha = await validacionFecha();
            console.log(necesitaValidacionFecha)
            if(necesitaValidacionFecha){
                $('#listaMedicos').empty();
                return;
            }
        }

        let soloDescuento = $('.options-date.active').attr("data-rel");
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }

        let args = [];
        let esPlanStar = dataCita?.convenio.esPlanStar || 'false';
        let codigoServicio = dataCita.especialidad.modalidadPrestacionAgenda.presencial.codigoServicio;
        let codigoPrestacion = dataCita.especialidad.modalidadPrestacionAgenda.presencial.codigoPrestacion;
        if($('.modalidad-selected button').attr('data-rel') == "S"){
            let codigoServicio = dataCita.especialidad.modalidadPrestacionAgenda.online.codigoServicio;
            let codigoPrestacion = dataCita.especialidad.modalidadPrestacionAgenda.online.codigoPrestacion;
        }

        args["endpoint"] = api_url + `/${api_war}/v1/agenda/disponibilidadSugerida?canalOrigen=${_canalOrigen}&codigoEmpresa=1&idPaciente=${dataCita.paciente.numeroPaciente}&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&aplicaOnline=S&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&esPlanStar=${esPlanStar}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
            grouped = data.reduce((acc, item) => {
                acc[item.esOnline] = acc[item.esOnline] || [];
                acc[item.esOnline].push(item);
                return acc;
            }, {});
            let elemento = '';
            if(newArrayCard.length > 0){
                newArrayCard.forEach((medico) => {
                    let img_doctor = (medico.imagen != null) ? medico.imagen : '{{ asset('assets/img/svg/avatar_doctor.svg') }}';
                    let listadoHorarios = ``;
                    let cantidadMaxListado = (medico.intervalos.length >= 3) ? 3 : 1;
                    $.each(medico.intervalos, function(k,v){
                        if(k < cantidadMaxListado){
                            listadoHorarios += drawHorarioMedico(v);
                        }else{
                            return false;
                        }
                    })

                    //${ (dataCita.online == "N") ? `<p class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal) } </p>` : ``}

                    let esMedicoAnterior = (medico.esMedicoAnterior == "S") ? `<div class="badge rounded-3 py-1 px-2 bg-cita-atendida d-flex justify-content-between align-items-center gap-1 ${ (medico.esFavorito == "S") ? `flex-grow-1` : `` } me-2">
                                        <i class="fa-solid fa-clock" style="color:#2F7833;"></i>
                                        <span class="fw-normal fs--2" style="color:#2F7833;">Te atendiste con este doctor</span>
                                    </div>` : ``;
                    
                    let esFavorito = (medico.esFavorito == "S") ? `<div class="badge rounded-3 py-1 px-2 bg-fav-atendida">
                                        <i class="fa-solid fs--2 fa-heart" style="color:#D84315;"></i>
                                    </div>` : ``;

                    elemento += `<div class="border-box-light-blue rounded-3 p--2 mb-3">
                        <div class="header-doctor d-flex justify-content-between align-items-start mb-3">
                            <div class="picture-doctor border-box-light-blue border-3 rounded-circle" style="background: url(${img_doctor}) no-repeat top center;background-size: cover;">
                            </div>
                            <div class="content-doctor ms-2 flex-grow-1">
                                <div class="name-rate d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="fs--16 line-height-20 fw-medium flex-grow-1 m-0 flex-grow-1">${capitalizarCadaPalabra(medico.nombreMedico)}</h6>
                                </div>
                                ${ (dataCita.online == "N") ? `<p class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal) } </p>` : ``}
                                <p class="fs--2 line-height-16 fw-normal mb-1" style="color: #425065;">${capitalizarCadaPalabra(nombreEspecialidad)}</p>
                                <div class="info-adicional-medico d-flex justify-content-between align-items-center">
                                    ${esMedicoAnterior}
                                    ${esFavorito}
                                </div>
                            </div>
                        </div>
                        <div class="dates-doctor">
                            <p class="fs--1 line-height-16 fw-medium mb-2" style="color:#296BEF;">Horario más próximo:</p>
                            <div class="row g-2" style="max-width:341px">
                                ${listadoHorarios}
                                <div class="col-6">
                                    <div class="cursor-pointer waves-effect p--2 px-3 w-100 bg-time-doctor-alt rounded-3 d-flex justify-content-center align-items-center btn-disponibilidad-medico-all" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                        <span class="fs--1 line-height-20 rate-label text-center mb-0">Ver más horarios</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                })
            }
        }
    }

    async function validacionFecha(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validacionFecha`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "fechaSeleccionada": $('.selected-day').attr("fechaSeleccionada-rel")
        });
        const data = await call(args);
        console.log(data)
        if(data.code == 200){
            if(data.data.mensajeValidacion1 != null){
                //mostrar mensaje
                if(data.data.aplicaCondicionesSeguro){
                    $('.box-disponibilidad').empty();
                }
                let msg = data.data.mensajeValidacion1+"<br>"+data.data.mensajeValidacion2;
                $('#msg-validacion-fecha').html(msg.replace(/\*(.*?)\*/g, '<b class="text-primary-veris">$1</b>'));
                $('#modalValidacionFecha').modal("show");
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    async function consultarEspecialidades(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/listado/especialidades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&modalidad=TODAS`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            $('.box-lista-especialidades').removeClass('d-none')
            let elemento = '';

            if(data.data.length > 0){
                data.data.forEach((especialidad) => {
                    elemento += `<div id="especialidad-${especialidad.codigoEspecialidad}" data-rel='${JSON.stringify(especialidad)}' class="col-col-12 p-2 px-3 rounded-3 d-flex justify-content-start align-items-center bg-white item-especialidad waves-effect shadow-item-modal cursor-pointer especialidad-item border" type-rel="button" data-bs-dismiss="modal">
                        <p class="text-veris fs--16 line-height-20 fw-medium text-one-line mb-0">${capitalizarCadaPalabra(especialidad.nombreEspecialidad)}</p>
                    </div>`
                });
            } else {
                listaEspecialidades.empty();
                elemento += `<div class="col-12">
                                <div class=" fs--2 rounded-3 p-2">
                                    {{ __('No existe data que mostrar') }}
                                </div>
                            </div> `;
            }
            
            listaEspecialidades.append(elemento);
        }

        return data;
    }

    // funciones asyncronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientes();
        }
        return data;
    }

    // consultar lista de convenios
    async function consultarConvenios(event) {
        // if(typeof dataCita.paquete !== 'undefined'){
        //     let dataRel = $(event.currentTarget).data('rel');
        //     let url = '/citas-datos-facturacion/';
        //     dataCita.paciente = dataRel;
        //     localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
        //     location.href = url + "{{ $tokenCita }}";
        //     return;
        // }
        let listaConvenios = $('#listaConvenios');
        listaConvenios.empty();
        listaConvenios.append(`<div class="text-center p-2"><small>Nos estamos comunicando con tu aseguradora, el proceso puede tardar unos minutos</small></div>`);

        let args = [];
        let canalOrigen = _canalOrigen;
        let dataRel = $(event.currentTarget).data('rel');
        dataPaciente = dataRel;
        console.log("--------------------------");
        console.log("dataRel", dataRel);
        let codigoUsuario;
        let tipoIdentificacion;
        let nombreCompleto;
        let numeroPaciente;
        let direccion;
        let telefono;
        let correo;

        if(dataRel != ""){
            codigoUsuario = dataRel.numeroIdentificacion;
            tipoIdentificacion = dataRel.tipoIdentificacion;
            nombreCompleto = dataRel.primerNombre + ' ' + dataRel.primerApellido + ' ' + dataRel.segundoApellido;
            numeroPaciente = atob(dataRel.idPersona);
            direccion = dataRel.direccion;
            telefono = dataRel.telefono;
            correo = dataRel.correo;
        }

        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${codigoUsuario}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=${dataCita.online}&excluyeNinguno=S  `
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        // llenar modal
        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                listaConvenios.empty();
                data.data.forEach((convenios) => {
                    let params = {}
                    params.online = online;
                    params.convenio = convenios;
                    params.paciente = dataRel;

                    let ruta = '';
                    if (ordenExterna == 'S') {
                        if(online == 'S'){
                            ruta = `/registrar-orden-externa-ubicacion/{{ $tokenCita }}`;                       
                        }else{
                            ruta = `/registrar-orden-externa/{{ $tokenCita }}`;
                        }
                    }
                    else {
                        ruta = `/citas-elegir-especialidad/{{ $tokenCita }}`;
                    }
                    
                    if(convenios.permiteReserva == "N"){
                        ruta = `#`;
                    }
                    let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    elemento += `<div data-rel='${ulrParams}' url-rel="${ruta}" class="convenio-item mb-2" data-bs-dismiss="modal">
                                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                            ${capitalizarCadaPalabra(convenios.nombreConvenio)}
                                        </label> 
                                    </div>
                                </div>`;
                });
                /*Agregar ninguno*/
                let params = {}
                params.online = online;
                params.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                };
                params.paciente = dataRel;
                let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                ruta = `/citas-elegir-especialidad/{{ $tokenCita }}`;
                if (ordenExterna == 'S') {
                    if(online == 'S'){
                        ruta = `/registrar-orden-externa-ubicacion/{{ $tokenCita }}`;                          
                    }else{

                        ruta = `/registrar-orden-externa/{{ $tokenCita }}`;
                    }
                }

                elemento += `<a href="${ruta}" class="d-block convenio-ninguno" data-rel='${ulrParams}' id="convenioNinguno">
                                <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                    <label class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                        Ninguno
                                    </label> 
                                </div>
                            </a>`;

                listaConvenios.append(elemento); 
                
                // mostrar modal
                $('#convenioModal').modal('show');
                
            } else {

                let params = {}
                dataCita.online = online;
                dataCita.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                };
                dataCita.paciente = dataRel;
                localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));

                let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                listaConvenios.empty();
                if (ordenExterna == 'S') {
                    console.log("orden externa");
                    if(online == 'S'){
                        ruta = `/registrar-orden-externa-ubicacion/{{ $tokenCita }}`;
                        
                    }else{
                        ruta = `/registrar-orden-externa/{{ $tokenCita }}`;
                    }
                }
                else {
                    ruta = `/citas-elegir-especialidad/{{ $tokenCita }}`;
                }

                //window.location.href = ruta;
                // alert(0)
                goTo(2, 'Perfecto, ahora dime en que \n especialidad quieres \n atenderte');
            }              
        }

        return data;
    }
    
    // mostrar lista de pacientes
    function mostrarListaPacientes(){

        let listaPacientes = $('#listaPacientes');
        
        let elemento = '';

        if(familiar != null){
            familiar.forEach((pacientes) => {
                let backgroundClass = pacientes.genero === "F" ? "bg-strong-magenta" : (pacientes.genero === "M" ? "bg-soft-blue" : "bg-soft-green");

                elemento += `<div class="col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body text-center px-3 py-2">
                            
                            <div onclick="consultarConvenios(event)" data-rel='${JSON.stringify(pacientes)}'>
                               <div class="d-flex justify-content-center align-items-center mb-1">
                                    <div class="avatar avatar-10">
                                        <span class="avatar-initial rounded-circle ${backgroundClass}">${pacientes.primerNombre.charAt(0).toUpperCase()}</span>
                                    </div>
                                </div>
                                <p class="text-veris fw-medium fs--2 mb-1">${capitalizarElemento(pacientes.primerNombre)} <br> ${capitalizarElemento(pacientes.primerApellido)} ${capitalizarElemento(pacientes.segundoApellido)}</p>
                                <p class="text-veris fs--3 mb-0">${capitalizarElemento(pacientes.parentesco)}</p>
                            </div>
                        </div>
                    </div>
                </div> `;

            });
        }
        listaPacientes.append(elemento);
    }

    async function reservaNoPermitida(url, data ){
        let convenio = JSON.parse(atob(decodeURIComponent(data)));
        console.log("convenio", convenio);
        $('#noPermiteReservaMsg').html(convenio.convenio.mensajeBloqueoReserva)
        if(convenio.convenio.permiteReserva == "S"){
            // Actualizar dataCita con los datos del convenio
            dataCita.convenio = convenio.convenio;
            dataCita.paciente = dataPaciente;
            // Aquí puedes añadir cualquier otra información relevante a dataCita

            // Guardar el objeto actualizado en localStorage
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));

            // location.href = url;
            goTo(2, 'Perfecto, ahora dime en que \n especialidad quieres \n atenderte');
        }else{
            $('#convenioModal').modal('hide');
            var myModal = new bootstrap.Modal(document.getElementById('noPermiteReserva'));
            setTimeout(function(){
                $('.modal-backdrop').remove();
                myModal.show();
            },250);
        }
    }

    // setear cita en localstorage cuando se escoge un convenio ninguno
    $('body').on('click', '#convenioNinguno', function() {
        let params = {}
        dataCita.online = online;
        dataCita.convenio = {
            "permitePago": "S",
            "permiteReserva": "S",
            "idCliente": null,
            "codigoConvenio": null,
        };
        dataCita.paciente = dataPaciente;
        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));

    });
   
    
    
</script>

<style>
    .bg-soft-blue {
        background-color: #0071CE !important;
    }
    .content-wrapper{
        background: linear-gradient(169.06deg, #D5F0FC 0%, #E8EBF8 50.5%, #F8E8F5 100%);
    }
    .box-lista-especialidades {
        max-height: 350px;
        overflow: auto;
    }
    .border-modalidades{
        border-bottom: 1px solid #9DA7B3
    }
    .modalidad-selected{
        border-bottom: 3px solid #296BEF;
    }
    .modalidad-selected button{
        font-weight: 700;
        color: #296BEF;
    }

    /* Estilo de la barra de desplazamiento */
    ::-webkit-scrollbar {
        width: 5px;
        /* Ancho de la barra de desplazamiento */
    }

    /* Estilo del thumb (agarre) de la barra de desplazamiento */
    ::-webkit-scrollbar-thumb {
        background-color: #3962E6;
        /* Color de fondo del thumb */
        border-radius: 4px;
        /* Borde redondeado del thumb */
    }

    /* Estilo del thumb al pasar el mouse sobre Ã©l*/
    ::-webkit-scrollbar-thumb:hover {
        background-color: #171d49;
        /* Color de fondo del thumb al pasar el mouse */
    }

    ::-webkit-scrollbar {
        height: 8px;
        /* Establece la altura de la barra de desplazamiento */
    }

    ::-webkit-scrollbar-thumb {
        background-color: #3962E6;
        /* Color del pulgar de la barra de desplazamiento */
        border-radius: 4px;
        /* Borde redondeado del pulgar */
    }

    ::-webkit-scrollbar-track {
        background-color: #d8d9db;
        /* Color de fondo de la barra de desplazamiento */
    }
</style>
@endpush