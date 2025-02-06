@extends('template.app-template-veris')
@section('title')
Elige Paciente
@endsection
@section('content')
@php
$tokenCita = base64_encode(uniqid());
$tokenCitaNormal = base64_encode(uniqid());
@endphp

<!-- Modal de error -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
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

<!-- Modal mensaje -->
<div class="modal fade" id="modalEmbarazo" tabindex="-1" aria-labelledby="modalEmbarazoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 pb-2">
                <div class="text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="fa-solid fa-info fs-2"></i>
                        </span>
                    </div>
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información solicitada por tu aseguradora</h1>
                    <p class="fs--1 fw-normal mb-3 mx-3 line-height-16">¿Esta cita es por control de <b>embarazo</b>?</p>
                    <input type="hidden" id="especialidadElegida">
                </div>
                <div class="d-flex">
                    <div respuesta-rel="S" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 me-3 btn-respuesta-embarazo">SI</div>
                    <div respuesta-rel="N" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 btn-respuesta-embarazo">NO</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tratamiento-->
<div class="modal fade" id="consultaTratamientoModal" tabindex="-1" aria-labelledby="consultaTratamientoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-header border-0 d-none">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <h5 class="fw-medium line-height-24 mb-8">Tienes una <b class="fw-medium text-primary-veris">{{ __('cita pendiente') }}</b> {{ __('de esta especialidad en tu tratamiento de') }}:</h5>
                <div class="border rounded-3 mb-8 p--2" id="tratamiento-content">
                </div>
                <p class="fs--16 line-height-20 fw-medium mb-8">{{ __('¿Estas agendando por este motivo?') }}</p>
                <button type="button" id="btn-si-tratamiento" class="btn btn-primary-veris fs--18 w-100 px-4 py-3 m-0 mb-3">{{ __('Agendar esta orden') }}</button>
                <button type="button" id="btn-no-tratamiento" class="btn btn-outline-primary-veris fs--18 w-100 px-4 py-3 m-0">{{ __('No') }}</button>
                {{-- <button type="button" class="btn btn-outline-primary-veris w-100 mb-3" data-bs-dismiss="modal">{{ __('No') }}</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Elige tu convenio para continuar:') }}</h5>
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
                    <div class="row g-3 justify-content-start mb-3" id="box-animacion-horizontal">
                        <div class="col-12">
                            <div class="card h-100 border-ai">
                                <div class="card-body d-flex justify-content-between align-items-center px-3 py-2 bg-white rounded-3" style="min-height:100px;">
                                    <div class="me-3 animated-svg-container">
                                        <img src="{{ asset('assets/img/svg/vericita.svg') }}" class="w-100 img-ai" alt="">
                                    </div>
                                    <h6 class="fw-medium flex-grow-1 fs--1 mb-0 text-veris-ai" id="typewriter"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-start steps step-1 d-none" id="listaPacientes">
                        <div class="col-6 ">
                            <div class="card h-100 btn-add-familia cursor-pointer">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center px-3 py-2">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <div class="avatar avatar-10">
                                            <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <p class="text-veris fw-medium fs--2 text-center mb-0">{{ __('Agregar nuevo paciente') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-start steps step-2 d-none">
                        <div class="col-12">
                            <div class="mb-3 box-btn-especialidad element-no-paquete">
                                <button class="btn bg-white w-100 btn-sm rounded-3 waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" style="border: 1px solid #E7E9EC;box-shadow: none !important;">
                                    {{-- data-bs-toggle="modal" data-bs-target="#especialidadModal" id="btn-especialidad" data-rel="" --}}
                                    <p class="fs--1 line-height-16 fw-normal fs--1 mb-0" style="color: #3D4E66;">Elegir especialidad</p>
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
                    <div class="row g-3 pt-5 justify-content-start steps step-3 mb-3 d-none">
                        <div class="col-12 mt-5">
                            <div class="row g-3 justify-content-start">
                                <div class="col-12 pt-3 text-center">
                                    <div class="animated-svg-container mb-5" style="width:150px;height:150px;">
                                        <img src="{{ asset('assets/img/svg/vericita.svg') }}" class="mx-auto mb-5 img-ai" alt="" style="width:150px;height:150px;">
                                    </div>
                                    <h6 class="fw-medium fs--1 mb-0 text-veris-ai w-75 mx-auto" id="typewriterVertical"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-start steps step-4 mb-3 d-none">
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
                    </div>
                </div>
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="row g-3 justify-content-start steps step-4 mb-3 d-none">
                        <div class="col-12">
                            <div class="swiper swiper-horarios position-relative py-3 pt-md-2 pb-md-4">
                                <div class="swiper-wrapper px-0" id="listadoSugerencias">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-5 mt-3">
                    <div class="row g-3 justify-content-start steps step-4 mb-3 d-none">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3 mb-3 btn-mas-sugerencias">Ver más sugerencias <img class="ms-2" src="{{ asset('assets/img/svg/ai-bn-icon.svg') }}" alt=""></button>
                            <button type="button" class="btn bg-white text-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3 mb-3 btn-seleccionar-datos">Prefiero elegir los datos</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    dataCita.estaEmbarazada = "N";
    let online = dataCita?.online;
    let ordenExterna = dataCita?.ordenExterna;
    let dataPaciente;
    

    // llamada al dom 
    let swiper; 
    let estaEscribiendo = false;
    document.addEventListener("DOMContentLoaded", async function () {
        $('#typewriter').empty();
        typeWriter('Por favor elige para quién es \n la cita médica.','typewriter');
        
        setTimeout(async function(){
            await consultarGrupoFamiliar();
            $('.step-1').removeClass('d-none');
            createSwiperSlider();
        }, 3500 );
        
        $('body').on('click','.btn-add-familia', async function(){
            $('#box-animacion-horizontal').addClass('d-none');
            $('#typewriterVertical').empty();
            goTo(3,'Te enviaré a la sección donde \n podrás agregar un familiar o amigo.','typewriterVertical');
            setTimeout(function(){
                window.location.href = '/familia-amigos';
            }, 5000)
        });

        $('body').on('click','.convenio-item', async function(){
            $('#convenioModal').modal('hide');
            reservaNoPermitida($(this).attr("data-rel"));
        });

        $('body').on('click','.box-btn-especialidad', async function(){
            $(this).addClass('d-none');
            await consultarEspecialidades()
        })

        $('body').on('click', '#btn-no-tratamiento', async function(){
            $('#box-animacion-horizontal').addClass('d-none');
            $('#typewriterVertical').empty();
            goTo(3,'Ahora estoy buscando las mejores \n opciones...','typewriterVertical');
            $('#consultaTratamientoModal').modal('hide');
            await obtenerCitasSugeridas();
        })

        $('body').on('click', '#btn-si-tratamiento', async function(){
            dataCita.tratamiento = JSON.parse($(this).attr("data-rel"));
            $('#box-animacion-horizontal').addClass('d-none');
            $('#typewriterVertical').empty();
            goTo(3,'Ahora estoy buscando las mejores \n opciones...','typewriterVertical');
            $('#consultaTratamientoModal').modal('hide');
            await obtenerCitasSugeridas();
        })

        $('body').on('click', '.btn-respuesta-embarazo', async function(){
            let estaEmbarazada = $(this).attr('respuesta-rel');
            dataCita.estaEmbarazada = estaEmbarazada;
            await consultarSiEsTratamiento();
            
            // $('#box-animacion-horizontal').addClass('d-none');
            // $('#typewriterVertical').empty();
            // goTo(3,'Ahora estoy buscando las mejores \n opciones...','typewriterVertical');
            // await obtenerCitasSugeridas();
        })

        $('body').on('click', '.especialidad-item', async function(){
            let especialidad = JSON.parse($(this).attr('data-rel'));
            dataCita.especialidad = especialidad;

            let data = await validarCondicionConvenio();
            if(data.data.permiteReserva == "N"){
                $('#mensajeError').html(`${data.data.mensajeReserva}`);
                $('#modalError').modal('show');
                return;
            }else{
                dataCita.estaEmbarazada = "N";
                if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
                    let controlEmbarazo = await validacionConvenio();
                    if(controlEmbarazo){
                        //$('#especialidadElegida').val($(this).attr('data-rel'))
                        $('#modalEmbarazo').modal("show");
                    }else{
                        await consultarSiEsTratamiento();
                    }
                }else{
                    await consultarSiEsTratamiento();
                }
            }

        })

        $('body').on('input', '#buscar', function () {
            var value = $(this).val().toLowerCase();
            // console.log("Valor de búsqueda:", value);
            
            $("#listaEspecialidades .item-especialidad").each(function () {
                let text = $(this).find('p.text-veris').text().toLowerCase(); // Obtiene el texto dentro de <p>
                // console.log("Texto del elemento:", text);
                
                // Verificar si el texto contiene el valor de búsqueda
                if (text.indexOf(value) > -1 || value === "") {
                    $(this).removeClass("d-none"); // Mostrar el elemento
                } else {
                    $(this).addClass("d-none"); // Ocultar el elemento
                }
            });
        });

        $('body').on('click','.btn-modalidad', async function(){
            let modalidad = $(this).attr('data-rel')
            dataCita.online = modalidad;
            if(modalidad == "S"){
                console.log("Validar");
                let data = await validarCondicionConvenio();
                console.log(111)
                if(data.data.permiteReserva == "N"){
                    dataCita.online = "N";
                    $('#mensajeError').html(`${data.data.mensajeReserva}`);
                    $('#modalError').modal('show');
                    console.log(222)
                    return;
                }
            }
            console.log(333)

            $('#listadoSugerencias').empty();
            let newArrayCard = grouped[modalidad].slice(0,2);
            let elemento = '';
            // let qty = 
            if(newArrayCard.length > 0){
                newArrayCard.forEach((medico) => {
                    elemento += drawCardMedico(medico);
                })
                
                $('#listadoSugerencias').html(`${elemento}`);
                swiper.update()
            }

            if(!$(this).parent().hasClass('modalidad-selected')){
                $('.btn-modalidad').parent().removeClass('modalidad-selected');
                $(this).parent().addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
                console.log(444)
            }
        })

        $('body').on('click','.btn-mas-sugerencias', async function(){
            let modalidad = $('.btn-modalidad').attr('data-rel');
            let totalObj = grouped[modalidad].length;
            let totalSlides = swiper.slides.length;
            if(totalObj > totalSlides){
                let newArrayCard = grouped[modalidad].slice(totalSlides,totalSlides+2);
                let elemento = '';
                // let qty = 
                if(newArrayCard.length > 0){
                    newArrayCard.forEach((medico) => {
                        elemento += drawCardMedico(medico);
                    })
                    
                    $('#listadoSugerencias').append(`${elemento}`);
                    swiper.update()
                        setTimeout(() => {
                        let totalSlides = swiper.slides.length; // Contar slides
                        let penultimateIndex = totalSlides - 2; // Índice del penúltimo slide

                        if (penultimateIndex >= 0) {
                            swiper.slideTo(penultimateIndex, 500); // Ir al penúltimo slide en 500ms
                        }
                    }, 100); // Pequeño delay para asegurar la actualización
                }
            }else{
                console.log('Límite')
                $('#box-animacion-horizontal').addClass('d-none');
                $('#typewriterVertical').empty();
                goTo(3,'En este momento no puedo encontrar lo que buscas.\n\nPara poder agendar tu cita da clic en continuar e ingresa los datos','typewriterVertical');
                setTimeout(function(){
                    $('#typewriterVertical').after(`<button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3 mt-3 btn-seleccionar-datos">Continuar</button>`)
                },7000);
            }

        })

        $('body').on('click','.btn-seleccionar-datos', async function(){
            let especialidad = dataCita.especialidad;

            dataCita.especialidad = {
                "codigoEspecialidad": especialidad.codigoEspecialidad,
                "nombre": especialidad.nombreEspecialidad,
                "imagen": especialidad.nombreEspecialidad,
                "esOnline": dataCita.online,
                "codigoServicio": (dataCita.online == "S") ? especialidad.modalidadPrestacionAgenda.online.codigoServicio : especialidad.modalidadPrestacionAgenda.presencial.codigoServicio,
                "codigoPrestacion": (dataCita.online == "S") ? especialidad.modalidadPrestacionAgenda.online.codigoPrestacion : especialidad.modalidadPrestacionAgenda.presencial.codigoPrestacion,
                "codigoTipoAtencion": especialidad.codigoTipoAtencion,
                "esOdonto": especialidad.esOdonto
            }

            dataCita.origen = "agendamiento-ai";

            localStorage.setItem('cita-{{ $tokenCitaNormal }}', JSON.stringify(dataCita));
            window.location.href = "/seleccionar-datos-cita/" + "{{ $tokenCitaNormal }}";

            // localStorage.setItem('cita-{{ $tokenCitaNormal }}', JSON.stringify(params));
            // window.location.href = "/citas-elegir-paciente/" + "{{ $tokenCitaNormal }}";
        })

        $('body').on('click','.btn-elegir', async function(){
            let detalles = JSON.parse($(this).attr("data-rel"));
            console.log(detalles);
            dataCita.horario = {
                "idIntervalo": detalles.idIntervalo,
                "horaInicio": detalles.horaInicio,
                "horaFin": detalles.horaFin,
                "idMedico": detalles.idMedico,
                "nombreMedico": detalles.nombreMedico,
                "dia": detalles.dia,
                "dia2": detalles.dia2,
                "nombreSucursal": detalles.nombreSucursal,
                "idSurcursal": detalles.idSurcursal,
                "porcentajeDescuento": detalles.porcentajeDescuento,
                "textoPorcentaje": detalles.textoPorcentaje,
                "mensajePricing": detalles.mensajePricing
            }

            dataCita.central = {
                "nombreSucursal": detalles.nombreSucursal,
                "codigoSucursal": detalles.idSurcursal
            }

            let especialidad = dataCita.especialidad;

            dataCita.especialidad = {
                "codigoEspecialidad": especialidad.codigoEspecialidad,
                "nombre": especialidad.nombreEspecialidad,
                "imagen": especialidad.nombreEspecialidad,
                "esOnline": dataCita.online,
                "codigoServicio": (dataCita.online == "S") ? especialidad.modalidadPrestacionAgenda.online.codigoServicio : especialidad.modalidadPrestacionAgenda.presencial.codigoServicio,
                "codigoPrestacion": (dataCita.online == "S") ? especialidad.modalidadPrestacionAgenda.online.codigoPrestacion : especialidad.modalidadPrestacionAgenda.presencial.codigoPrestacion,
                "codigoTipoAtencion": especialidad.codigoTipoAtencion,
                "esOdonto": especialidad.esOdonto
            }

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            window.location.href = "/citas-revisa-tus-datos/" + "{{ $tokenCita }}";

        })
        
    });

    function goTo(stepNumber, legend, idElem, showLegend = true){
        $('.steps').addClass('d-none');
        $('#typewriter').empty();
        if(showLegend){
            typeWriter(legend,idElem)
        }
        $('.step-'+stepNumber).removeClass('d-none');
    }

    async function validacionConvenio(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validacionConvenio`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "codigoEspecialidad": parseInt(dataCita.especialidad.codigoEspecialidad),
            "idPaciente": parseInt(dataCita.paciente.numeroPaciente),
            "codigoTipoAtencion": dataCita.especialidad.codigoTipoAtencion
        });
        const data = await call(args);
        
        if(data.code == 200){
            return data.data.requiereControlEmbarazo;
        }else{
            return false;
        }
    }

    async function consultarSiEsTratamiento(){
        let codigoServicio = dataCita.especialidad.modalidadPrestacionAgenda.presencial.codigoServicio;
        let codigoPrestacion = dataCita.especialidad.modalidadPrestacionAgenda.presencial.codigoPrestacion;
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/obtener_tratamiento_compatible?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${dataCita.online}&idPaciente=${dataCita.paciente.numeroPaciente}
        &codigoServicio=${ codigoServicio }&codigoPrestacion=${ codigoPrestacion }&codigoConvenio=${ (dataCita.convenio.codigoConvenio != null) ? dataCita.convenio.codigoConvenio : '' }`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        let params = {}
        
        if (data.code == 200 && data.data != null){
            params.tratamiento = data.data;
            let urlParamsSi = JSON.stringify(data.data);
            $("#btn-si-tratamiento").attr("data-rel", urlParamsSi);

            $('#tratamiento-content').empty();
            
            let elem = `<div class="progress-circle mx-auto" data-percentage="${ roundToDraw(data.data.porcentajeAvanceTratamiento) }">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value">
                    <div>
                        <span><i class="bi bi-check2 success"></i></span>
                        <p class="fs--2 mb-0">${data.data.totalTratamientoRealizados}/${data.data.totalTratamientoEnviados}</p>
                    </div>
                </div>
            </div>
            <h5 class="card-title h6 fw-medium mb-2 text-primary-veris">${capitalizarCadaPalabra(data.data.nombreEspecialidad)}</h5>
            <p class="fs--2 mb-0">{{ __('Tratamiento enviado') }}: <b class="fw-normal text-primary-veris" id="fechaCitaPendiente">${ data.data.fechaTratamiento }</b></p>`;

            $('#tratamiento-content').append(elem);

            var myModal = new bootstrap.Modal(document.getElementById('consultaTratamientoModal'));
            myModal.show();
        }else{
            $('#box-animacion-horizontal').addClass('d-none');
            $('#typewriterVertical').empty();
            goTo(3,'Ahora estoy buscando las mejores \n opciones...','typewriterVertical');
            await obtenerCitasSugeridas();
        }

    }

    async function validarCondicionConvenio(){
        let paramasAditional = ``;
        if(dataCita.hasOwnProperty('especialidad')){
            let codigoServicio = dataCita.especialidad.modalidadPrestacionAgenda.presencial.codigoServicio;
            let codigoPrestacion = dataCita.especialidad.modalidadPrestacionAgenda.presencial.codigoPrestacion;
            if($('.modalidad-selected button').attr('data-rel') == "S"){
                codigoServicio = dataCita.especialidad.modalidadPrestacionAgenda.online.codigoServicio;
                codigoPrestacion = dataCita.especialidad.modalidadPrestacionAgenda.online.codigoPrestacion;
            }
            paramasAditional += `&codigoServicio=${ codigoServicio }&codigoPrestacion=${ codigoPrestacion }&tipoModalidad=${ (dataCita.online == "N") ? "PRESENCIAL" : "ONLINE" }`;
        }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validaCondicionConvenio?canalOrigen=${_canalOrigen}&esValidacionLink=false&codigoEmpresa=1&codigoConvenio=${(dataCita.convenio.codigoConvenio != null) ? dataCita.convenio.codigoConvenio : ''}${paramasAditional}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            dataCita.validarCondicionConvenio = data.data;
        }
        return data;
    }
    
    // swiper.update()
    function createSwiperSlider(){
        swiper = new Swiper('.swiper-horarios', {
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
    }

    // async function drawTabs(){
    //     $.each(dataCita.especialidad.modalidadPrestacionAgenda, function(key, value){
    //         if(value != null){
                
    //         }
    //     })
    // }

    let grouped = [];
    async function obtenerCitasSugeridas(){
        $('#listadoSugerencias').empty();
        let fechaSeleccionada;
        // if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
        //     let necesitaValidacionFecha = await validacionFecha();
        //     console.log(necesitaValidacionFecha)
        //     if(necesitaValidacionFecha){
        //         $('#listaMedicos').empty();
        //         return;
        //     }
        // }

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

        let aplicaOnline = (dataCita.especialidad.modalidadPrestacionAgenda.online != null) ? "S" : "N";

        if(aplicaOnline == "N"){
            $('.box-modalidad-presencial').removeClass('col-6').addClass('col-12');
            $('.box-modalidad-online').addClass('d-none');
        }

        args["endpoint"] = api_url + `/${api_war}/v1/agenda/disponibilidadSugerida?canalOrigen=${_canalOrigen}&codigoEmpresa=1&idPaciente=${dataCita.paciente.numeroPaciente}&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&aplicaOnline=${aplicaOnline}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&esPlanStar=${esPlanStar}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
            if(data.data == null){
                $('#box-animacion-horizontal').addClass('d-none');
                $('#typewriterVertical').empty();
                goTo(3,'En este momento no puedo encontrar lo que buscas.\n\nPara poder agendar tu cita da clic en continuar e ingresa los datos','typewriterVertical');
                setTimeout(function(){
                    $('#typewriterVertical').after(`<button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3 mt-3 btn-seleccionar-datos">Continuar</button>`)
                },7000);
                return;
            }
            grouped = data.data.reduce((acc, item) => {
                acc[item.esOnline] = acc[item.esOnline] || [];
                acc[item.esOnline].push(item);
                return acc;
            }, {});

            let newArrayCardByModalidad = (dataCita.online == "S") ? grouped['S'] : grouped['N'];
            let newArrayCard = newArrayCardByModalidad.slice(0,2);
            let elemento = '';
            // let qty = 
            if(newArrayCard.length > 0){
                newArrayCard.forEach((medico) => {
                    elemento += drawCardMedico(medico);
                })
                
                $('#listadoSugerencias').html(`${elemento}`);
                swiper.update()
            }

            // $('#box-animacion-horizontal').removeClass('d-none');
            $('#box-animacion-horizontal').removeClass('d-none');
            $('#typewriter').after(`<img class="ms-2 img-ai" src="{{ asset('assets/img/svg/ai-icon.svg') }}" alt="">`)
            goTo(4, 'Citas generadas con \n inteligencia artificial \n Elegí estas citas tomando en cuenta tu interacción con Veris', 'typewriter', false);
            typeWriterWithStyle(
                "Citas generadas con \n inteligencia artificial \n Elegí estas citas tomando en cuenta tu interacción con Veris",
                "typewriter",
                { 
                    "Citas generadas con": "fw-medium text-veris fs--16 line-height-20",
                    "inteligencia artificial":"fw-medium text-veris fs--16 line-height-20 text-ai"
                }
            );

        }
    }

    function drawCardMedico(medico){
        // ${ (medico.esFavorito == "S") ? `flex-grow-1` : `` }
        let esMedicoAnterior = (medico.esMedicoAnterior == "S") ? `<div class="badge rounded-3 p-2 bg-cita-atendida d-flex justify-content-start align-items-center gap-1 me-2">
                <i class="fa-solid fa-clock" style="color:#2F7833;"></i>
                <span class="fw-normal fs--2" style="color:#2F7833;">Te atendiste con este doctor</span>
            </div>` : ``;

        let esFavorito = (medico.esFavorito == "S") ? `<div class="badge rounded-3 p-2 bg-fav-atendida">
                <i class="fa-solid fs--2 fa-heart" style="color:#D84315;"></i>
            </div>` : ``;

        return `<div class="swiper-slide border-ai border-ai-thin">
            <div class="bg-white rounded-3 p--2">
                <div class="header-doctor d-flex justify-content-between align-items-start mb-3">
                    <div class="content-doctor ms-2 flex-grow-1">
                        <div class="name-rate d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fs--1 line-height-16 fw-medium flex-grow-1 m-0 flex-grow-1 text-primary-veris">${capitalizarCadaPalabra(dataCita.especialidad.nombreEspecialidad)}</h6>
                        </div>
                        ${ (dataCita.online == "N") ? `<p class="fs--2 line-height-16 fw-medium mb-1 text-veris">${capitalizarCadaPalabra(medico.nombreSucursal) } </p>` : ``}
                        <p class="fs--2 line-height-16 fw-normal mb-1 text-veris">${formatDate(medico.dia2)} <span class="text-primary-veris ms-2">${medico.horaInicio} ${determinarMeridiano(medico.horaInicio)}</span</p>
                        <p class="fs--2 line-height-16 fw-normal mb-1 text-veris">Dr(a) ${capitalizarCadaPalabra(medico.nombreMedico)}</p>
                        <p class="fs--2 line-height-16 fw-normal mb-1 text-veris" style="color: #3B4E66;">${ capitalizarCadaPalabra(concatenarNombres(dataCita.paciente.primerNombre, dataCita.paciente.segundoNombre, dataCita.paciente.primerApellido, dataCita.paciente.segundoNombre)) }</p>
                        <div class="info-adicional-medico d-flex justify-content-start align-items-center">
                            ${esMedicoAnterior}
                            ${esFavorito}
                        </div>
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-between align-items-center">
                    <img width="32px" class="me-2" src="${medico.urlIconoConsulta}"/>
                    <div class="btn btn-primary-veris m-0 px-3 py-2 fs--1 fw-medium ms-auto btn-elegir" data-rel='${JSON.stringify(medico)}'>
                    Elegir
                    </div>
                </div>
            </div>
        </div>`;
    }

    function formatDate(dateString) {
        // Separar la fecha en día, mes y año
        let [day, month, year] = dateString.split('/');

        // Crear un objeto Date (restamos 1 al mes porque en JS los meses van de 0 a 11)
        let date = new Date(year, month - 1, day);

        // Formatear la fecha en el formato deseado
        let options = { month: 'short', day: '2-digit', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    function concatenarNombres(primerNombre, segundoNombre, primerApellido, segundoApellido) {
        return [primerNombre, segundoNombre, primerApellido, segundoApellido]
            .filter(nombre => nombre && nombre.trim() !== "") // Filtra nulos, vacíos y espacios
            .join(" "); // Une con espacio
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

                    let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    elemento += `<div data-rel='${ulrParams}' class="convenio-item mb-2">
                                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="text-veris fs--1 line-height-16 cursor-pointer">
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

                elemento += `<div class="d-block convenio-item" data-rel='${ulrParams}' id="convenioNinguno">
                                <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                    <label class="text-veris fs--1 line-height-16 cursor-pointer">
                                        Ninguno
                                    </label> 
                                </div>
                            </div>`;

                listaConvenios.append(elemento); 
                
                // mostrar modal
                $('#convenioModal').modal('show');
                
            } else {
                console.log(77)
                goTo(2, 'Perfecto, ahora dime en que \n especialidad quieres \n atenderte', 'typewriter');

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

    async function reservaNoPermitida( data ){
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
            console.log(99)
            goTo(2, 'Perfecto, ahora dime en que \n especialidad quieres \n atenderte', 'typewriter');
            // location.href = url;
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
    .text-ai{
        color: #296BEF;
    }
    .bg-cita-atendida{
        background: #B9F6CA;
    }
    .bg-fav-atendida{
        background: #FBE9E7;
    }
    .swiper-slide:first-child > div {
        margin-right: 0.5px;
    }

    .animated-svg-container {
        position: relative;
        display: inline-block;
    }

    .animated-svg-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(53.36% 53.36% at 26.21% 29.37%, 
            #003AAF 4.6%, 
            rgba(41, 107, 239, 0.8) 50.1%, 
            rgba(254, 40, 154, 0.6) 100%);
        border-radius: 50%;
        /*filter: blur(5px);*/
        filter: blur(5px) brightness(1.3) contrast(1.8);
        animation: rotateBackground 1s linear infinite;

    }

    @keyframes rotateBackground {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /*.animated-svg-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(53.36% 53.36% at 26.21% 29.37%, 
            #003AAF 4.6%, 
            rgba(41, 107, 239, 0.8) 50.1%, 
            rgba(254, 40, 154, 0.6) 100%);
        border-radius: 50%;
        filter: blur(10px);
        opacity: 0.8;
        animation: rotateBackground 3s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }

    @keyframes rotateBackground {
        0% {
            transform: rotate(0deg) scale(1);
            opacity: 0.8;
        }
        50% {
            transform: rotate(180deg) scale(1.1);
            opacity: 0.9;
        }
        100% {
            transform: rotate(360deg) scale(1);
            opacity: 1;
        }
    }*/

    .img-ai {
        position: relative;
        z-index: 1; /* Asegura que el SVG quede por encima del fondo */
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