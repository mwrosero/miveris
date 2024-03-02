@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Confirma tu atención
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Confirma tu atención') }}</h5>
    </div>
    <section class="pt-4 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="text-center">
                    <h5 class="fs-24 line-height-28 mb--32" style="color: #FC0326 !important;">Urgencias ambulatorias</h5>
                    <p class="fs--1 line-height-16 fw-medium text-veris mb-5">Cuando lo que tienes no puede esperar.</p>
                    <img src="{{asset('assets/img/svg/vua.svg')}}" class="mb-5" alt="vua">
                    <div class="swiper swiperSintoma position-relative py-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Vómitos</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Malestar</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Cortes</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Vómitos</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Malestar</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Cortes</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Vómitos</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Malestar</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Cortes</p>
                            </div>
                        </div>
                        <button type="button" id="prevProperties" class="d-flex mt-n4 btn btn-prev-arrow fs--24"></button>
                        <button type="button" id="nextProperties" class="d-flex mt-n4 btn btn-next-arrow fs--24"></button>
                    </div>
                    <div class="form-check d-flex justify-content-center align-items-center mb-4">
                        <input class="form-check-input atencionInmediata-input me-2 mb-1 width-24" type="checkbox" value="" id="checkConfirmacionInmediata" required>
                        <label class="form-check-label fs--1 fw-normal line-height-16 text-veris text-start" for="checkConfirmacionInmediata">
                            Confirmo que tengo un caso de atención inmediata
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary-veris fs--18 line-height-24 fw-medium shadow-none w-100 px-4 py-3 disabled" type="button" id="btnAtencionInmediata"> Agendar</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

        </div>
    </section>
</div>
@endsection
@push('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    var swiper = new Swiper(".swiperSintoma", {
        spaceBetween: 13,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.btn-next-arrow',
            prevEl: '.btn-prev-arrow',
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let online = dataCita?.online;
    var tipoIdentificacion = parseInt(dataCita.paciente.tipoIdentificacion);
    let numeroIdentificacion = dataCita.paciente.numeroIdentificacion;
    let codigoEspecialidad = dataCita.especialidad.codigoEspecialidad;
    let secuenciaAfiliado = dataCita.convenio.secuenciaAfiliado || '' ;
    let codigoConvenio = dataCita.convenio.codigoConvenio || '';
    let idIntervalo = dataCita.horario.idIntervalo;
    let porcentajeDescuentos = dataCita.horario.porcentajeDescuento;
    let medPayPlan = dataCita.convenio.informacionExternaPlan;
    let permiteReserva = dataCita.convenio.permiteReserva;
    let dia2 = dataCita.horario.dia2;
    let idCliente = dataCita.convenio.idCliente;
    let rutaImagenConvenio = dataCita.convenio.rutaImagenConvenio;
    let horaInicio = dataCita.horario.horaInicio;
    let permitePago = "S";
    if(dataCita.convenio.permitePago){
        permitePago = dataCita.convenio.permitePago;
    }

    document.addEventListener("DOMContentLoaded", async function () {

        $('body').on('change', '#checkConfirmacionInmediata', function(){
            if($('#checkConfirmacionInmediata').is(':checked')) {
                $('#btnAtencionInmediata').removeClass('disabled');
            } else {
                $('#btnAtencionInmediata').addClass('disabled');
            }
        });

        $('body').on('click', '#btnAtencionInmediata', async function(){
            await reservarCita();
        })
    });

    async function reservarCita(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/reservar?canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        let estaPagada = "N";
        if(dataCita.reservaEdit != null ) {
            estaPagada = dataCita.reservaEdit.estaPagada;
        }

        let datosReserva = {
            "numeroIdentificacion": dataCita.paciente.numeroIdentificacion,
            "tipoIdentificacion": tipoIdentificacion,
            "idIntervalos": dataCita.horario.idIntervalo,
            "codigoEmpresa": 1,
            "codigoEspecialidad": dataCita.especialidad.codigoEspecialidad,
            "codigoPrestacion": dataCita.especialidad.codigoPrestacion,
            "usuarioLogin": "{{ Session::get('userData')->numeroIdentificacion }}",
            "esOnline": dataCita.online,
            "origen": 4,
            "motivoConsulta": "",
            "codigoServicio": dataCita.especialidad.codigoServicio,
            "canalOrigenAgendamiento": "MVE",
            "codigoEmpresaRegistro": 1,
            "codigoSucursalRegistro": null,
            "porcentajeDescuento": dataCita.horario.porcentajeDescuento,
            // "permitePago": dataCita.convenio.permitePago,
            "permitePago": dataCita.convenio.permitePago,
            "secuenciaAfiliado": dataCita.convenio.secuenciaAfiliado,
            "canalOrigen": _canalOrigen,
            "enviarLinkPago": null,
            "tipoProcesoVUA": "INGRESO",
            /*precio*/
            //"valorizacion": dataCita.precio.valorCanalVirtual,
            /*precio o reagendamiento*/
            //"secuenciaTransaccion": dataCita.precio.secuenciaTransaccion,
            //"valorCita": dataCita.precio.valorCanalVirtual,
            //"valorDescuento": dataCita.precio.valorDescuento,
            //"valorSubtotalCita": dataCita.precio.valor,
            //"numeroAutorizacion": dataCita.precio.numeroAutorizacion,
            "esEmbarazada": (dataCita.estaEmbarazada) ? dataCita.estaEmbarazada : "N",
            "fechaSeleccionada": dataCita.horario.dia2,
            /*Si estoy modificando/tratamiento o sino N*/
            "estaPagada": estaPagada
        }

        /*Para reagendamiento*/
        //"codigoReservaCambio": "string",
        
        if(dataCita.online == "N"){
            datosReserva.codigoSucursal = dataCita.central.codigoSucursal;
        }    

        /*Solo si tiene convenio seleccionado*/
        if(dataCita.convenio.codigoConvenio){
            datosReserva.codigoEmpConvenio = 1;
            datosReserva.codigoConvenio = dataCita.convenio.codigoConvenio;
            datosReserva.idCliente = dataCita.convenio.idCliente;
        }

        if(dataCita.tratamiento){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
        }

        if(dataCita.reservaEdit){
            /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
            datosReserva.numeroOrden = dataCita.reservaEdit.numeroOrden;
            datosReserva.codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden;
            datosReserva.lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden;
            datosReserva.codigoReservaCambio = dataCita.reservaEdit.idCita;
        }

        args["data"] = JSON.stringify(datosReserva);
        const data = await call(args);

        if (data.code == 200){
            dataCita.reserva = data.data;
            guardarData();
            location.href = '/cita-agendada/{{ $params }}';
            return;
        }else{
            //guardarData();
            //location.href = '/citas-datos-facturacion/{{ $params }}';
            alert(data.message);
        }
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
@endpush