@extends('template.app-template-veris')
@section('title')
Mi Veris - Inicio
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
    // dd($tokenCita);
@endphp

{{-- <style>
    #animacion {
      width: 300px;
      height: 300px;
      margin: auto;
      position: absolute;
      z-index: 9;
      pointer-events: none;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script> --}}
<div class="flex-grow-1 container-p-y pt-0">
    {{-- <div id="animacion"></div> --}}

    <!-- Modal de error -->
    <div class="modal fade" id="ModalError" tabindex="-1" aria-labelledby="ModalError" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal text-veris" id="mensajeError"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fw-medium fs--18 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Convenios -->
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
                    <button type="button" class="btn fw-normal fs--16 line-height-20 m-0 px-3 py-2" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Agendar Cita -->
    <div class="modal modal-top fade" id="agendarCitaMedicaModal" tabindex="-1" aria-labelledby="agendarCitaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered px-2 px-md-0 mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header py-3">
                    <button type="button" class="btn-close fw-medium bg-transparent me-1 me-md-2 top-50 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3 px-2 px-md-3 pb--40">
                    <h5 class="text-center fs--20 line-height-24 mb--32">¿Qué quieres agendar?</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="col-6 col-lg-6">
                            <a href="/mis-tratamientos">
                                <div class="card card-border">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-7 col-md-6">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Lo que envió') }} <br> {{ __('mi doctor') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-auto text-end">
                                            <img src="{{ asset('assets/img/card/svg/paste.svg') }}" class="img-fluid" alt="paste">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-6">
                            <a href="/citas">
                                <div class="card card-border">
                                    <div class="row g-0 justify-content-between align-items-center">
                                        <div class="col-7 col-md-6">
                                            <div class="card-body p-0 ps-2">
                                                <h6 class="fw-medium fs--2 mb-0">{{ __('Una nueva') }} <br> {{ __('cita médica') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-auto text-end">
                                            <img src="{{ asset('assets/img/card/svg/doctor.svg') }}" class="img-fluid" alt="doctor">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white mb-4" style="box-shadow: 0px 0px 4px 0px #0000000D !important;">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Inicio') }}</h5>
    </div>
    <!-- Banners -->
    <section class="p-3 py-3 pt-0 pe-0 pe-md-3 mb-0 d-none section-banners" style="background: #F9FAFB;">
        <div class="swiper swiper-banners position-relative pb-2">
            <div class="swiper-wrapper px-1" id="box-banners">
            </div>
        </div>
    </section>
    
    @if(config('app.subdomain') == "veris")
        @include('inicio.sections.tratamientos-home')
    @else
        @include('inicio.sections.accesos-home')
    @endif

    @if(config('app.subdomain') == "veris")
        @include('inicio.sections.accesos-home')
    @else
        @include('inicio.sections.citas')
    @endif

    @if(config('app.subdomain') == "veris")
        @include('inicio.sections.citas')
        @include('inicio.sections.citas-vua') 
    @else
        @include('inicio.sections.tratamientos-home')
    @endif

    
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
        {{-- var anim = lottie.loadAnimation({
            container: document.getElementById('animacion'),
            renderer: 'svg', // 👈 evita canvas
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/json/SPIDER_JSON.json') }}' // tu archivo Lottie JSON
        }); --}}
        
        await controlVersion();
        
        /*var swiper = new Swiper('.swiper-acceso-rapidos', {
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
                    slidesPerView: 2.1,
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
                    slidesPerView: 3,
                    // spaceBetween: 8,
                },
            },
        });*/
        await obtenerPPD();
        // await cargarConfiguracionesHome();

        await cargarBanners();
        await obtenerTratamientos();
        
        await obtenerCitas();
        @if(config('app.subdomain') == "veris")
        await obtenerUrgenciasAmbulatorias();
        @endif
        // chartProgres('#chart-progress');
        await consultarConvenios();
        await consultarDatosPaciente();
        
        // initializeSwiper('.swipertratamientos');
        // initializeSwiper('.swiper-proximas-citas');
        $('body').on('click', '.btn-opciones-sesion', function(){
            $('.data-popup-opciones').attr('data-rel', $(this).attr("data-rel"));
            $('.data-popup-opciones.btn-CambiarFechaCita').attr('url-rel', "/seleccionar-datos-cita/{{ $tokenCita }}");
        });

        $('#cita-nueva, .banner-cita-nueva').on('click', function(){
            let params = {}
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

            // redireccionar a la pagina de citas
            window.location.href = "/citas-elegir-paciente/" + "{{ $tokenCita }}";
        });

        $('body').on('click', '.btn-opciones-cita', function(){
            console.log("btn-opciones-cita")
            let datos = JSON.parse($(this).attr("data-rel"));
            let url = `seleccionar-datos-cita`;
            if(datos.esVirtual === "S" && datos.estaPagada == "S"){
                url = `citas-elegir-fecha-doctor`;
            }else{
                url = `seleccionar-datos-cita`;
            }

            $('#modificar-cita-normal').removeClass('disabled-item');
            if(datos.permiteCambiar === "N"){
                $('#modificar-cita-normal').addClass('disabled-item');
            }

            /*$('#cambiar-modalidad').removeClass('disabled-item');
            if(datos.habilitaCambioModalidad === "N" || datos.aplicaCambioModalidad === "N"){
                $('#cambiar-modalidad').addClass('disabled-item');
            }*/
            $('#cambiar-modalidad').removeClass('disabled-item');
            if(datos.esVirtual === "S" || datos.idTeleconsulta !== null){
                $('#cambiar-modalidad').addClass('disabled-item');
            }

            $('.data-popup-opciones-cita').attr('data-rel', $(this).attr("data-rel"));
            $('.data-popup-opciones-cita.btn-CambiarFechaCita').attr('url-rel', `/${url}/{{ $tokenCita }}`);
            $('#masOpcionesModalCitas').modal('show');
            {{-- data-bs-toggle="modal" data-bs-target="#masOpcionesModalCitas" --}}
        });

        /*$('body').on('click', '.btn-cambio-modalidad', async function(){
            let datosServicio = JSON.parse($(this).data('rel'));
            let ruta = "/citas-revisa-tus-datos/{{ $tokenCita }}";
            console.log(datosServicio);
            console.log(ruta);
            return;
            if(datosServicio.habilitaCambioModalidad === "N" || datosServicio.aplicaCambioModalidad === "N"){
                $('#mensajeNoPermiteCambiarModalidad').html(datosServicio.mensajeValidacion1);
                $('#modalPermiteCambiarModalidad').modal('show');
                return;
            }else{
                location.href = ruta;
            }
        })*/

        $('body').on('click', '.btn-cambio-modalidad', async function(){
            let datosServicio = $(this).data('rel');
            let ruta = "/citas-revisa-tus-datos/{{ $tokenCita }}";

            if(datosServicio.habilitaCambioModalidad === "N" || datosServicio.aplicaCambioModalidad === "N"){
                $('#mensajeNoPermiteCambiarModalidad').html(datosServicio.mensajeValidacion1);
                $('#modalPermiteCambiarModalidad').modal('show');
                return;
            }

            let params = {}

            if(datosServicio.permiteReserva == "N"){
                $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoReserva);
                $('#modalPermiteCambiar').modal('show');
                return;
            }

            params.cambioModalidad = "S";
            params.convenio = {
                "secuenciaAfiliado": datosServicio.secuenciaAfiliado,
                "idCliente": datosServicio.idCliente,
                "codigoCliente": datosServicio.codigoCliente,
                "codigoConvenio": datosServicio.codigoConvenio,
                "codigoEmpresa": datosServicio.codigoEmpresa,
                "permitePagoLab" : datosServicio.permitePagoLab,
                "permitePago": datosServicio.permitePagoReserva,
                "mensajeBloqueoPago" : datosServicio.mensajeBloqueoPago,
                "mensajeBloqueoReserva" : datosServicio.mensajeBloqueoReserva,
                "permiteReserva": datosServicio.permitePagoReserva,
                "aplicaVerificacionConvenio": datosServicio.aplicaVerificacionConvenio,
                "esPlanStar":  datosServicio.esPlanStar
            }

            params.online = datosServicio.esVirtual;

            params.especialidad = {
                codigoEspecialidad: datosServicio.idEspecialidad,
                codigoPrestacion  : datosServicio.codigoPrestacion,
                codigoServicio   : datosServicio.codigoServicio,
                codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                esOnline : datosServicio.esVirtual,
                nombre : datosServicio.especialidad,
            }
            params.paciente = {
                "numeroIdentificacion": datosServicio.numeroIdentificacion,
                "tipoIdentificacion": datosServicio.tipoIdentificacion,
                "nombrePaciente": datosServicio.nombrePaciente,
                "numeroPaciente": datosServicio.numeroPaciente
            }

            params.tratamiento = {
                idPaciente: datosServicio.numeroPaciente,
                origen: 'INICIO',
            }

            params.reservaEdit = {
                "estaPagada": datosServicio.estaPagada,
                "numeroOrden": datosServicio.numeroOrden,
                "lineaDetalleOrden": datosServicio.lineaDetalleOrden,
                "codigoEmpresaOrden": datosServicio.codigoEmpresaOrden,
                "idOrdenAgendable": datosServicio.idOrdenAgendable,
                "idCita": datosServicio.idCita
            }

            params.horario = {
                "fechaReserva": datosServicio.fechaReserva,
                "horaInicio": datosServicio.horaInicio,
                "horaFin": datosServicio.horaFin,
                "nombreMedico": datosServicio.medico
            }

            // params.sesion = {
            //     secuenciaPlanTto: datosServicio.secuenciaPlanTto,
            //     numeroSesion: datosServicio.numeroSesion
            // }

            params.origen = "INICIO";
            params.convenio.origen = "INICIO";

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            location = ruta;
        });

        $('body').on('click', '.btn-sesion', async function(){
            let datosServicio = $(this).data('rel');
            let ruta = "/detalle-sesion/{{ $tokenCita }}";

            let params = {}

            if(datosServicio.permiteReserva == "N"){
                $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoReserva);
                $('#modalPermiteCambiar').modal('show');
                return;
            }

            params.sesion = datosServicio;
            params.convenio = {
                "secuenciaAfiliado": datosServicio.secuenciaAfiliado,
                "idCliente": datosServicio.idCliente,
                "codigoCliente": datosServicio.codigoCliente,
                "codigoConvenio": datosServicio.codigoConvenio,
                "codigoEmpresa": datosServicio.codigoEmpresa,
                "permitePagoLab" : datosServicio.permitePagoLab,
                "permitePago": datosServicio.permitePagoReserva,
                "mensajeBloqueoPago" : datosServicio.mensajeBloqueoPago,
                "mensajeBloqueoReserva" : datosServicio.mensajeBloqueoReserva,
                "permiteReserva": datosServicio.permitePagoReserva,
                "aplicaVerificacionConvenio": datosServicio.aplicaVerificacionConvenio,
                "esPlanStar":  datosServicio.esPlanStar
            }
            params.central = {
                "codigoSucursal": datosServicio.codigoSucursal,
                "nombreSucursal": datosServicio.sucursal
            }
            params.ciudad = {
                "codigoPais": datosServicio.idPais,
                "codigoProvincia": datosServicio.idProvincia,
                "codigoCiudad": datosServicio.idCiudad
            }
            params.online = datosServicio.esVirtual;

            params.especialidad = {
                codigoEspecialidad: datosServicio.idEspecialidad,
                codigoPrestacion  : datosServicio.codigoPrestacion,
                codigoServicio   : datosServicio.codigoServicio,
                codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                esOnline : datosServicio.esVirtual,
                nombre : datosServicio.especialidad,
            }
            params.paciente = {
                "numeroIdentificacion": datosServicio.numeroIdentificacion,
                "tipoIdentificacion": datosServicio.tipoIdentificacion,
                "nombrePaciente": datosServicio.nombrePaciente,
                "numeroPaciente": datosServicio.numeroPaciente
            }

            params.tratamiento = {
                idPaciente: datosServicio.numeroPaciente,
                origen: 'INICIO',
            }

            params.reservaEdit = {
                "estaPagada": datosServicio.estaPagada,
                "numeroOrden": datosServicio.numeroOrden,
                "lineaDetalleOrden": datosServicio.lineaDetalleOrden,
                "codigoEmpresaOrden": datosServicio.codigoEmpresaOrden,
                "idOrdenAgendable": datosServicio.idOrdenAgendable,
                "idCita": datosServicio.idCita
            }

            // params.sesion = {
            //     secuenciaPlanTto: datosServicio.secuenciaPlanTto,
            //     numeroSesion: datosServicio.numeroSesion
            // }

            params.origen = "Listatratamientos";
            params.convenio.origen = "Listatratamientos";

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            location = ruta;
        });

        $('body').on('click', '.btn-eliminar-cita', function(){
            $('#idCitaEliminar').val($(this).attr('codigoReserva-rel'));
            var myModal = new bootstrap.Modal(document.getElementById('modalEliminarCita'));
            myModal.show();
        })

        $('body').on('click', '.btn-confirmar-eliminar-cita', async function(){
            await eliminarReserva()
        })

        $('body').on('click', '.btn-cita-informacion', async function(){
            let msg = $(this).attr('data-mensajeInformacion');
            $('#mensajeNoPermiteCambiar').html(msg)
        })

        // seleccionar convenio convenio-item
        $(document).on('click', '.convenio-item', function(){
            let data = $(this).data('rel');
            console.log('dataConvenio', data);
            let params = JSON.parse(localStorage.getItem('cita-{{ $tokenCita }}'));
            params.convenio = data;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            $('#convenioModal').modal('hide');
            location = $(this).attr('url-rel');
        });

        // seleccionar convenio convenio-Ninguno
        $(document).on('click', '.convenio-ninguno', function(){
            let data = $(this).data('rel');
            console.log('dataConvenio', data);
            let params = JSON.parse(localStorage.getItem('cita-{{ $tokenCita }}'));
            params.convenio = {
                "permitePago": "S",
                "permiteReserva": "S",
                "idCliente": null,
                "codigoConvenio": null,
                "secuenciaAfiliado" : null,
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            $('#convenioModal').modal('hide');
            location = $(this).attr('url-rel');
        });

        $(document).on('click', '.btn-preparacionPrevia', function(){
            let data = $(this).data('rel');
            obtenerPreparacionPrevia(data.codigoSolicitud)
        })

        $(document).on('click', '.btn-pagar-lab', async function(){
            let params = {};
            let data = JSON.parse($(this).attr("data-rel"));
            const paciente = await obtenerDatosUsuario(data.tipoIdentificacion,data.numeroIdentificacion);
            // console.log(data);return;
            if(data.permitePagoReserva == "N"){
                $('#mensajeError').text(data.mensajePagoReserva);
                $('#ModalError').modal('show');
                return;
            }

            if(data.codigoConvenio !== null){
                params.convenio = {
                    "secuenciaAfiliado": data.secuenciaAfiliado,
                    "idCliente": data.idCliente,
                    "codigoCliente": data.codigoCliente,
                    "codigoConvenio": data.codigoConvenio,
                    "codigoEmpresa": data.codigoEmpresa,
                    "permitePagoLab" : data.permitePagoLab,
                    "permitePago": data.permitePagoReserva,
                    "mensajeBloqueoPago" : data.mensajeBloqueoPago,
                    "mensajeBloqueoReserva" : data.mensajeBloqueoReserva,
                    "permiteReserva": data.permitePagoReserva,
                    "aplicaVerificacionConvenio": data.aplicaVerificacionConvenio,
                    "esPlanStar":  data.esPlanStar
                };
            }else{
                params.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                    "secuenciaAfiliado" : null,
                    "esPlanStar":  data.esPlanStar
                };
            }
            params.horario = {
                "dia2": "",//datosServicio.fechaReserva,
                "horaInicio": "",//datosServicio.horaInicio,
                "horaFin": "",//datosServicio.horaFin,
            }
            params.paciente = paciente.data
            params.ordenExterna = data;
            params.origen = 'ordenExterna'; 
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            location.href = `/citas-datos-facturacion/{{ $tokenCita }}`;
        })

        // btn-pagar para redireccionar a la pagina de pago
        $(document).on('click', '.btn-pagar', function(){
            let data = $(this).data('rel');
            console.log('dataPagar', data);
            if(data.permitePagoReserva == "N"){
            // if(datosConvenios.length > 0 && datosConvenios[0].permitePago == "N" || data.permitePagoReserva == "N"){
                
                // Modal de error
                // setear el mensaje de error en mensajeError
                $('#mensajeError').text(data.mensajePagoReserva);
                
                $('#ModalError').modal('show');
                return;
            }

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
            params.convenio = {
                secuenciaAfiliado: data.secuenciaAfiliado,
                idCliente: data.idCliente,
                codigoCliente: data.codigoCliente,
                codigoConvenio: data.codigoConvenio,
                codigoEmpresa: data.codigoEmpresa,
                permitePagoLab : data.permitePagoLab,
                permitePago: data.permitePagoReserva,
                mensajeBloqueoPago : data.mensajeBloqueoPago,
                mensajeBloqueoReserva : data.mensajeBloqueoReserva,
                permiteReserva: data.permitePagoReserva,
                aplicaVerificacionConvenio: data.aplicaVerificacionConvenio,
                esPlanStar:  data.esPlanStar
            }

            if(data.esSesionOdonto == "S"){
                params.sesion = {
                    secuenciaPlanTto: data.secuenciaPlanTto,
                    numeroSesion: data.numeroSesion,
                    tiempoSesion: data.tiempoSesion
                };
                params.detalleSesion = {
                    tipoAtencion: data.tipoAtencion,
                    tiempoSesion: data.tiempoSesion,
                    duracion: data.duracion
                }
            }
            // if (datosConvenios.length > 0) {
            //     params.convenio = datosConvenios[0];
            // } else {
            //     params.convenio = {
            //         "permitePago": "S",
            //         "permiteReserva": "S",
            //         "idCliente": null,
            //         "codigoConvenio": null,
            //         "secuenciaAfiliado" : null,
            //     };
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
            location.href = "/citas-datos-facturacion/" + "{{ $tokenCita }}"
        });

        $('body').on('click', '.link-item-banner', async function(){
            console.log('Banner click')
            let url = $(this).attr('url-rel');
            let codigoPaquete = $(this).attr('codigoPaquete-rel');

            if (typeof codigoPaquete === "undefined"){
                
                if(url != ''){
                    location.href = url;
                    return;
                }
            }else{
                console.log(codigoPaquete);
                let args = [];
                args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=POR_ASIGNAR&page=1&perPage=1&estaPagado=false&verDetalle=false&categoria=&buscarPorPromocion=&codigoPaquete=5759`;
                args["method"] = "GET";
                args["showLoader"] = true;
                const res = await call(args);
                let url = '/promocion/detalle/';
                let data = {
                    "paquete": res.data.items[0]
                };
                localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
                location.href = url + "{{ $tokenCita }}";
                return;
            }

        })

        //cerrar el modal de politicas reuerdame
        $(document).on('click', '#modalRecuerdame', function(){
            console.log('click');
            localStorage.setItem('politicaspoliticasAbiertas', true);
            $('#modalPPD').modal('hide');
        });

        // ver tratamiento Inicio
        $(document).on('click', '.btn-VerTratamientoInicio', function(){
            let data = $(this).data('rel');
            console.log('dataTratamiento', data);
            let params = { };
            params.tratamiento = data;
            params.paciente = datosPaciente;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));

        });

    });

    async function cargarConfiguracionesHome(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/configuraciones/home?canalOrigen=${window.config.canalOrigen}&usuario={{ Session::get('userData')->numeroIdentificacion }}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        
        const data = await call(args);
        console.log(data);
        let opt = data.data[0].pantallas[0].configuraciones;
        let resumen = await constructHtml(opt);
        console.log(resumen);
        $('.resumen-consentimiento').html(resumen);
        $('#modalPPD2').modal('show');
    }

    async function constructHtml(configuraciones) {
        let elem = ``;
        $.each(configuraciones, function(key, item){

            // Evitar errores si item o nombreTipoObjeto no vienen definidos
            if (!item || !item.nombreTipoObjeto) return elem;

            switch (item.nombreTipoObjeto) {
                case "TITLE":
                    elem += `<h3 class="fw-medium fs--2 line-height-16 text-veris mb-2">${item.valor}</h3>`;
                    break;

                case "SUBTITLE":
                    elem += `<h4 class="fw-normal fs--1 line-height-16 text-veris mb-2">${item.valor}</h4>`;
                    break;

                case "SALTO_LINEA":
                    // Calculamos el salto dinámico multiplicando por un factor base en rem o px
                    const multiplicador = Number(item.valor || 1);
                    elem += `<div style="height: ${multiplicador * 0.5}rem;"></div>`;
                    break;

                case "TEXTO": {
                    const textStr = item.valor || "";
                    const startsWithStar = textStr.startsWith('* ');
                    const startsWithSection = textStr.startsWith('§ ');
                    const startsWithBullet = startsWithStar || startsWithSection;
                    
                    // Limpiamos el prefijo si existe
                    const textContent = startsWithBullet ? textStr.slice(2) : textStr;
                    
                    if (startsWithBullet) {
                        const bulletChar = startsWithStar ? '•' : '§';
                        elem += `
                            <div class="d-flex align-items-start ${startsWithStar ? 'ms-2' : ''} mb-1">
                                <span class="fw-normal fs--2 line-height-16 text-veris me-2">${bulletChar}</span>
                                <p class="fw-normal fs--2 line-height-16 text-veris mb-0 flex-1">${textContent}</p>
                            </div>`;
                    } else {
                        elem += `<p class="fw-normal fs--2 line-height-16 text-veris mb-2">${textContent}</p>`;
                    }
                    break;
                }

                case "PARRAFO_CON_INFO":
                    elem += `
                        <p class="fw-normal fs--2 line-height-16 text-veris mb-2">
                            <span class="fw-medium">${item.valor} </span>
                            <span>${item.valorAdicional || ''}</span>
                        </p>`;
                    break;

                case "CHECK_MULTIPLE_CONSENTIMIENTO": {
                    const key = item.valor; // La clave única del consentimiento
                    
                    // Creamos un grupo de botones de opción (Radio Buttons) estilizados
                    elem += `
                        <div class="d-flex justify-content-end gap-2 my-3 pe-3 consentimiento-group" data-key="${key}">
                            <label class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2 px-3 py-2" style="width: 120px; font-size: 0.85rem;">
                                <input type="radio" name="consentimiento_${key}" value="true" class="d-none consent-input-accept">
                                <span class="check-icon-placeholder d-inline-block border text-center rounded" style="width: 16px; height: 16px; font-size: 10px; line-height: 14px;"></span>
                                Aceptar
                            </label>
                            
                            <label class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2 px-3 py-2" style="width: 120px; font-size: 0.85rem;">
                                <input type="radio" name="consentimiento_${key}" value="false" class="d-none consent-input-reject">
                                <span class="check-icon-placeholder d-inline-block border text-center rounded" style="width: 16px; height: 16px; font-size: 10px; line-height: 14px;"></span>
                                Rechazar
                            </label>
                        </div>`;
                    break;
                }

                default:
                    break;
            }
        })

        return elem;
    }

    async function cargarBanners(){
        let codigoLineaNegocio = (window.config.subdomain == "veris") ? 12 : 10;
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/configuraciones?codigoFlujoProceso=${codigoLineaNegocio}&canalOrigen=${window.config.canalOrigen}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        
        const data = await call(args);
        console.log("----------------BANNERS--------------")
        console.log(data)
        let tieneSlides = false;
        if(data.code == 200){
            if(data.data === null){
                return;
            }
            if(data.data.pantallas.length > 0){
                let elem = ``;
                $.each(data.data.pantallas, function(key, value){
                    $.each(value.configuraciones, function(k,v){
                        tieneSlides = true;
                        let classAdd = ``;
                        let attrAditional = `url-rel=''`;
                        if(v.nombreTipoObjeto == "BANNER_CUIDATE_X_MI"){
                            attrAditional = `type='button' url-rel='/promociones?s=Cuidate por mi'`;
                        }else if(v.nombreTipoObjeto == "BANNER_BIENESTAR"){
                            attrAditional = `type='button' url-rel='/bienestar'`;
                        }else if(v.nombreTipoObjeto == "BAN_DESC_EXCLUSIVOS"){
                            attrAditional = `type='button' url-rel='/promociones?c=TP'`;
                        }else if(v.nombreTipoObjeto == "BANNER_PROMO_FILTRADA"){
                            attrAditional = `type='button' url-rel='/promociones?s=${v.valorAdicional}'`;
                        }else if(v.nombreTipoObjeto == "BANNER_PROMO_X_CODIGO"){
                            attrAditional = `type='button' codigoPaquete-rel='${v.valorAdicional}'`;
                        }else if(v.nombreTipoObjeto == "BANNER_AGENDAMIENTO"){
                            classAdd = `banner-cita-nueva`;
                        }

                        elem += `<div class="swiper-slide">
                            <div class="card d-block h-100 d-flex justify-content-center align-items-between shadow-none border-0">
                                <div class="row h-100 g-0 justify-content-between align-items-center">
                                    <div class="col-12 link-item-banner" ${attrAditional}>
                                        <img src="${v.valor}" class="img-fluid ${classAdd}" alt=""  >
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    })
                })
                if(tieneSlides){
                    $('#box-banners').html(elem);
                    var banners = new Swiper('.swiper-banners', {
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
                                slidesPerView: 1.5,
                                // centeredSlides: true,
                                // loop: true,
                                // spaceBetween: 8,
                            },
                            1024: {
                                slidesPerView: 2.7,
                                // spaceBetween: 8,
                            },
                        },
                    });
                    $('.section-banners').removeClass('d-none');
                }
            }
        }
    }

    async function obtenerDatosUsuario(tipoIdentificacion, numeroIdentificacion) {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?canalOrigen=${window.config.canalOrigen}&tipoIdentificacion=${ tipoIdentificacion }&numeroIdentificacion=${ numeroIdentificacion }`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        
        const data = await call(args);
        console.log('datosUsuario',data);
        if (data.code == 200) {
            return data;
        }
        return [];
    } 

    async function eliminarReserva(){
        let args = [];
        let canalOrigen = _canalOrigen
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/eliminarReserva?codigoReserva=${parseInt(getInput('idCitaEliminar'))}`
        args["method"] = "PUT";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        const data = await call(args);

        //Menos para edictar reserva 
        if(data.code == 200){
            $('#modalEliminarCita').hide();
            $('.modal-backdrop').remove();
            await obtenerCitas();
            swiperProximasCitas.update();
            swiperProximasCitas.slideTo(0);
            await obtenerUrgenciasAmbulatorias();
            swiperUrgenciasAmbulatorias.update();
            swiperUrgenciasAmbulatorias.slideTo(0);
        }
    }

    // servicio para consultar convenios
    async function consultarConvenios(){
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}"
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}"
        let codigoEmpresa = 1
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${window.config.canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEmpresa=${codigoEmpresa}&tipoCredito=CREDITO_SERVICIOS`;
        args["method"] = "GET";
        args["showLoader"] = false;
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
        args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?canalOrigen=${window.config.canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}`;
        args["method"] = "GET";
        args["showLoader"] = false;
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
        args["endpoint"] = api_url + `/${api_war}/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}?codigoEmpresa=1&plataforma=WEB&version=7.0.1`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        _ppd = data.data;
        // Verificar ppd 2.0
        // return;

        if(data.code == 200){
            console.log(data.data)
            localStorage.setItem('estadoPoliticas', data.data.estadoPoliticas);

            if(localStorage.getItem('politicasAbiertas') == null){
                let politicas = JSON.parse(localStorage.getItem('politicas'));
                if((data.data.estadoPoliticas == "N") && (data.data.isPoliticasAceptadas == null || data.data.isPoliticasAceptadas == false)){
                    localStorage.setItem('politicasAbiertas', true);
                    $('#modalPPD').modal('show');
                    $('#politicasPPD').attr('href',data.data.linkPoliticaPrivacidad);
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

    async function controlVersion(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/seguridad/controlVersion?codigoUsuario={{ Session::get('userData')->numeroIdentificacion }}&plataforma=WEB&version=1.0.0&canalOrigen=${window.config.canalOrigen}`;
                args["method"] = "GET";
                args["showLoader"] = true;
        const data = await call(args);
        console.log(data)
        if(data.code == 200){
            // console.log(data.data.codigoRastreo)
            localStorage.setItem('codigoRastreo', data.data.codigoRastreo);
        }
    }

    //aceptar las politicas
    async function aceptarPoliticas(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}`;
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
        
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/detallesPorServicio?idPaciente=${numeroPaciente}&estadoTratamiento=PENDIENTE&fechaInicio=&fechaFin=&page=1&perPage=3&idPacienteFiltrar=&esDetalleRealizado=N&esResumen=S&cantidadDetalles=2&canalOrigen=${window.config.canalOrigen}`;
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
                if(datosTratamientos.length > 0){
                    $('.section-tratamientos').removeClass('d-none');
                    mostrarTratamientoenDiv();
                }
            }
        }
        chartProgres('#chart-progress');
        return data;
    }

    // consultar citas
    async function obtenerCitas(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = {{ Session::get('userData')->codigoTipoIdentificacion }};
        let numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";

        args["endpoint"] = api_url + `/${api_war}/v1/agenda/citasVigentes?canalOrigen=${window.config.canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroPaciente=${numeroPaciente}&numeroIdentificacion=${numeroIdentificacion}&codigoUsuario=${numeroIdentificacion}&version=7.8.0&adicionaSolicitudes=S&soloUsuarioSesion=S`
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
                $('#section-citas').removeClass('d-none')
                console.log('si hay citas');
                datosCitas = data.data;
                mostrarCitasenDiv();
            }
        }
        return data;
    }

    // consultar urgencias ambulatorias
    let citas_vua;
    async function obtenerUrgenciasAmbulatorias(){
        let args = [];
        let canalOrigen = _canalOrigen;
        let numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";
        let tipoIdentificacion = {{ Session::get('userData')->codigoTipoIdentificacion }};

        args["endpoint"] = api_url + `/${api_war}/v1/agenda/reservas/ingresos?idPaciente=${numeroPaciente}&canalOrigen=${window.config.canalOrigen}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        citas_vua = '';
        if (data.code == 200) {
            if(data.data === null || data.data.length == 0){
                mostrarNoExistenUrgencias();
            } else {
                $('#section-urgencias').removeClass('d-none')
                citas_vua = data.data
                mostrarUrgenciasAmbulatorias();
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
                                <div class="card h-100 bg-white shadow-none">
                                    <div class="card-body p-3">
                                        <div class="row gx-0 justify-content-between align-items-center mb-2">
                                            <div class="col-9">
                                                <h6 class="card-title text-veris-ai fs--16 line-height-20 mb-0 capitalizar">${capitalizarElemento(tratamientos.nombreEspecialidad)}</h6>
                                                <p class="fw-medium line-height-16 fs--2 mb-0">${capitalizarElemento(tratamientos.nombrePaciente)}</p>
                                                <p class="card-text line-height-16 fs--2 text-one-line">Dr(a): ${capitalizarElemento(tratamientos.nombreMedico)}</p>
                                            </div>
                                            <div class="col-3">
                                                <div class="progress-circle my-auto ms-auto" data-percentage="${ roundToDraw(tratamientos.porcentajeAvanceTratamiento) }">
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
                                        <div class="list-group list-group-checkable d-grid align-items-center h-50 gap-2 border-0 d-none">`;

            // Bucle anidado para detalleTratamiento
            tratamientos.detallesTratamiento.forEach((detalle) => {
                let params = {
                    codigoTratamiento: detalle.codigoTratamiento,
                    porcentajeAvanceTratamiento: tratamientos.porcentajeAvanceTratamiento
                };

                // convertir objeto a base64
                let paramsBase64 = btoa(JSON.stringify(params));
                let ruta = '/tratamiento/' + "{{ $tokenCita }}"

                elemento += `<label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 py-2 px-3 my-auto" style="border: 1px solid #F3F4F5 !important;box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.10);">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                        <img class="rounded-circle" src=${quitarComillas(detalle.urlImagenTipoServicio)}  width="26" alt="icono">
                                    </div>
                                    <p class="text-veris fw-medium fs--2 mb-0">${capitalizarElemento(detalle.nombreServicio)}</p>
                                </div>
                                <a href="${ruta}" data-rel='${JSON.stringify(tratamientos)}'
                                class="btn btn-sm text-primary-veris fw-normal fs--2 shadow-none py-2 px-0 btn-VerTratamientoInicio">Ver <i class="fa-solid fa-chevron-right fs--2 ms-1"></i></a>
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
                            <h6 class="fs--16 fw-normal">Agenda una cita y revisa tus <b>tratamientos</b> aquí</h6>
                        </div>`;
        divContenedor.append(elemento);
        $('#contenedorTratamientosHomePrincipal').removeClass('d-none');
    }

    // llenar el div de citas
    function mostrarCitasenDiv() {
        const data = datosCitas;
        const divContenedor = $('#contenedorCitas');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = '';
        const tokenCita = "{{ $tokenCita }}";
        data.forEach((citas) => {
            const classElem = citas.estaPagada === "S" ? 'justify-content-end' : 'justify-content-between';
            const esConsultaOnline = citas.esVirtual === "S";
            const esPagada = citas.estaPagada === "S" ? 'Pagada' : 'No pagada';
            let ruta = "/citas-elegir-fecha-doctor/" + tokenCita;

            if (citas.esVirtual !== "S") {
                ruta = "/seleccionar-datos-cita/" + tokenCita;
            }

            if(citas.esSesionOdonto){
                //console.log("AQUI ODONTO")
            }

            /*
            permiteCambiar
            mensajeInformacion
            */

            let tituloCard = capitalizarElemento(citas.especialidad);
            if(citas.esLabDomicilio && citas.esLabDomicilio == "S"){
                let prestaciones = ``;
                let count = 0;
                $.each(citas.pacientes, function(k,v){
                    $.each(v.examenes, function(k1,v1){
                        if(count < 3){
                            count++;
                            prestaciones +=`<li class="text-nowrap overflow-hidden text-truncate fs--3 line-height-12">${v1.nombreExamen}${(v.examenes.length < 3 || count == 3) ? `...` : ``}</li>`;
                        }
                    })
                })
                {{-- tituloCard = `Solicitud de laboratorio a domicilio - ${citas.codigoSolicitud}`; --}}
                tituloCard = `Laboratorio a domicilio`;
                elemento += `<div class="swiper-slide">
                    <div class="card h-100 bg-transparent shadow-none">
                        <div class="card-body p--2">
                            ${esConsultaOnline ? `
                                <span class="badge fs--12 fw-medium p-2 mb-2" style="background-color: #D7EDFD!important;color:#3A5068"><i class="fa-solid fa-video me-2 label-status-detalle"></i>Videoconsulta</span>
                            ` : `<span class="badge fs--12 fw-medium p-2 mb-2 text-capitalize" style="background-color: #D7EDFD!important;color:#3A5068"><i class="fa-solid fa-motorcycle me-2 label-status-detalle"></i>A Domicilio</span>`}
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-veris-ai fs--1 fw-medium line-height-16 mb-1">${tituloCard}</h6>
                                <span class="fs--2 fw-medium line-height-16 mb-1" style="color: ${ (citas.estaPagada == "S") ? "#00C853" : "#D84315"};"><i class="fa-solid fa-circle"></i> ${ (citas.estaPagada == "S") ? "Cita pagada" : "Pago pendiente" }</span>
                            </div>
                            <ul class="fw-normal fs--2 line-height-16 mb-1 p-0">
                                ${ prestaciones }
                            </ul>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${formatoFechaDiaMesAnio(citas.fechaReserva)} <b class="hora-cita ms-1 fw-normal text-veris-ai">${citas.horaInicio}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Paciente: ${capitalizarElemento(citas.nombrePaciente)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(citas.direccion)}</p>
                        </div>
                        <div class="card-footer pt-0 pb--2 px--2 d-flex justify-content-end align-items-center">
                            <div class="mt-auto">
                                ${citas.estaPagada === "N" ? `
                                <div class="btn btn-sm btn-outline-veris-ai fs--1 fw-normal line-height-16 shadow-none btn-preparacionPrevia" data-rel='${JSON.stringify(citas)}'>Preparación previa</div>
                                <a class="btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16 btn-pagar-lab" data-rel='${JSON.stringify(citas)}'>Pagar</a>
                                ` : `<div class="btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16 btn-preparacionPrevia" data-rel='${JSON.stringify(citas)}'>Preparación previa</div>`}
                            </div>
                        </div>
                    </div>
                </div>`;
            }else{
                let noPermiteCambio = ``;
                if(citas.permiteCambiar == "N"){
                    noPermiteCambio += `<div data-bs-toggle="modal" data-mensajeInformacion="${citas.mensajeInformacion}" data-bs-target="#modalPermiteCambiar" class="btn btn-sm btn-outline-veris-ai fs--1 fw-normal btn-cita-informacion line-height-16 shadow-none border-0 pe-0 me-0">
                            <i class="fa-solid fa-circle-info text-warning line-height-20" style="font-size:22px"></i>
                        </div>`;
                }
                elemento += `<div class="swiper-slide">
                    <div class="card h-100 bg-transparent shadow-none">
                        <div class="card-body p--2">
                            ${(esConsultaOnline || citas.idTeleconsulta !== null) ? `
                                <span class="badge fs--12 fw-medium p-2 mb-2" style="background-color: #D7EDFD!important;color:#3A5068"><i class="fa-solid fa-video me-2 label-status-detalle"></i>Videoconsulta</span>
                            ` : `<span class="badge fs--12 fw-medium p-2 mb-2 text-capitalize" style="background-color: #D7EDFD!important;color:#3A5068"><i class="fa-solid fa-door-closed me-2 label-status-detalle"></i>${citas.nombreSitio.toLowerCase()}</span>`}
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-veris-ai fs--1 fw-medium line-height-16 mb-1">${tituloCard}</h6>
                                <span class="fs--2 fw-medium line-height-16 mb-1" style="color: ${citas.colorEstado};"><i class="fa-solid fa-circle"></i> ${citas.mensajeEstado}</span>
                            </div>
                            <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(citas.sucursal)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${formatoFechaDiaMesAnio(citas.fechaReserva)} <b class="hora-cita ms-1 fw-normal text-veris-ai">${citas.horaInicio}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(citas.medico)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(citas.nombrePaciente)}</p>
                        </div>
                        <div class="card-footer pt-0 pb--2 px--2 d-flex ${classElem} align-items-center">
                            ${citas.estaPagada === "N" ? `
                                <button type="button" codigoReserva-rel="${citas.idCita}" class="btn btn-eliminar-cita btn-sm text-danger-veris shadow-none p-1"><img src="{{asset('assets/img/svg/trash.svg')}}" alt=""></button>
                            ` : ''}
                            <div class="mt-auto">
                                ${( citas.esSesionOdonto != "S") ? `<div class="${(citas.estaPagada === "S" && citas.esVirtual === "N" && citas.idTeleconsulta === null) ? `btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16`: `btn btn-sm btn-outline-veris-ai fs--1 fw-normal line-height-16 shadow-none`} btn-opciones-cita" data-rel='${JSON.stringify(citas)}'>Más opciones</div>
                                ` : (citas.esSesionOdonto != "S") ? `<div data-bs-toggle="modal" data-mensajeInformacion="${citas.mensajeInformacion}" data-bs-target="#modalPermiteCambiar" class="btn btn-sm btn-outline-veris-ai fs--1 fw-normal btn-cita-informacion line-height-16 shadow-none border-0 pe-0 me-0">
                                        <i class="fa-solid fa-circle-info text-warning line-height-20" style="font-size:22px"></i>
                                    </div>` : ( citas.estaPagada == "S" ) ? `<div data-bs-toggle="modal" data-bs-target="#masOpcionesModal" class="btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16 btn-opciones-sesion" data-rel='${JSON.stringify(citas)}'>Más opciones</div>` : `<div data-bs-toggle="modal" data-bs-target="#masOpcionesModal" class="btn btn-sm btn-outline-veris-ai fs--1 fw-normal line-height-16 shadow-none btn-opciones-sesion" data-rel='${JSON.stringify(citas)}'>Más opciones</div>
                                        <a class="btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16 btn-sesion" data-rel='${JSON.stringify(citas)}'>Pagar</a>
                                    `
                                }
                                ${ (citas.estaPagada === "N" && citas.esSesionOdonto != "S") ? `
                                <a class="btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16 btn-pagar" data-rel='${JSON.stringify(citas)}'>Pagar</a>
                                ` : ''}
                            </div>
                            ${(esConsultaOnline || citas.idTeleconsulta !== null) && citas.estaPagada == "S" ? `
                                <a href="${citas.idTeleconsulta}" class="btn btn-sm bg-veris-ai fs--1 ms-2 m-0 line-height-16 text-white">Entrar<i class="fa-solid fa-video ms-2"></i></a>
                            ` : ''}
                            ${noPermiteCambio}
                        </div>
                    </div>
                </div>`;
            }
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
                            <h6 class="fs--16 fw-medium mb-0">No tiene próximas citas</h6>
                            <p class="fs--16 fw-normal text-veris">Agenda una cita pulsado aqui <a href="{{route('citas')}}">Agendar cita</a></p>
                        </div>`;
        divContenedor.append(elemento);
        $('#contenedorCitasHomePrincipal').removeClass('d-none');
    }

    // llenar el div de urgencias ambulatorias
    function mostrarUrgenciasAmbulatorias() {
        let data = citas_vua;

        let divContenedor = $('#contenedorUrgenciasAmbulatorias');
        divContenedor.empty(); // Limpia el contenido actual

        var elemento = ``;
        data.forEach((urgencias) => {
            console.log(urgencias)
            elemento += `<div class="swiper-slide">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-primary-veris fs--1 fw-medium line-height-16 mb-1">${capitalizarElemento(urgencias.nombreEspecialidad)}</h6>
                            <span class="fs--2 text-success fw-medium"><i class="fa-solid fa-circle me-1"></i>Reservado</span>
                        </div>
                        <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(urgencias.nombreSucursal)}</p>
                        <p class="fw-normal fs--2 line-height-16 mb-1">${urgencias.fechaAdmision.replace(/\*(.*?)\*/g, '<b class="hora-cita fw-normal text-veris-ai">$1</b>')}</p>
                        <!--p class="fw-normal fs--2 line-height-16 mb-1">Dr(a) ${capitalizarElemento(urgencias.medico)}</p-->
                        <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(urgencias.paciente)}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" codigoReserva-rel="${urgencias.codigoReserva}" class="btn btn-eliminar-cita btn-sm text-danger-veris shadow-none p-1"><img src="{{asset('assets/img/svg/trash.svg')}}" alt=""></button>
                            <a href="https://maps.app.goo.gl/Fndz1pxDUdT3sYyg7" target="_blank" class="btn btn-sm btn-primary-veris fs--1 line-height-16">Cómo llegar</a>
                        </div>
                    </div>
                </div>
            </div>`;
            console.log(elemento)
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
                            <h6 class="fs--16 fw-medium mb-0">No tiene urgencias ambulatorias</h6>
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
        if(pagada.estaPagada == 'S'){
            return `<span class="fs--2 text-success fw-medium"><i class="fa-solid fa-circle me-1"></i> ${pagada.mensajeEstado}</span>`;
               
        } else {
            return `<span class="fs--2 text-danger-veris fw-medium"><i class="fa-solid fa-circle me-1"></i> ${pagada.mensajeEstado}</span>`;
        }
    }

    // setear los valores de la cita en localstorage
    $(document).on('click', '.btn-CambiarFechaCita', async function(){
        //alert(0);
        console.log('click entro a cambiar fecha');
        let data = $(this).data('rel');
        // console.log('datasss', data);return;
        let url = $(this).attr('url-rel');
        console.log(url);
        
        tipoFlujo = "reagenda/home";
        // const dataConvenio = await consultarConvenios(data);
        // const dataPaciente = await consultarDatosPaciente(data);
        if(data.permiteReserva == "N"){
            $('#mensajeNoPermiteCambiar').html(data.mensajeBloqueoReserva);
            $('#modalPermiteCambiar').modal('show');
            return;
        }
        
        if (data.estaPagada == "N"){
            let params = {}
            params.online = data.esVirtual;
            params.especialidad = {
                codigoEspecialidad: data.idEspecialidad,
                codigoPrestacion  : data.codigoPrestacion,
                codigoServicio   : data.codigoServicio,
                codigoTipoAtencion: data.codigoTipoAtencion,
                esOnline : data.esVirtual,
                nombre : data.especialidad
            }
            params.paciente = {
                "numeroIdentificacion": data.numeroIdentificacion,
                "tipoIdentificacion": data.tipoIdentificacion,
                "nombrePaciente": data.nombrePaciente,
                "numeroPaciente": data.numeroPaciente
            }

            params.central = {
                "codigoSucursal": data.codigoSucursal,
                "nombreSucursal": data.sucursal
            }
            params.ciudad = {
                "codigoPais": data.idPais,
                "codigoProvincia": data.idProvincia,
                "codigoCiudad": data.idCiudad
            }

            params.reservaEdit = {
                "estaPagada": data.estaPagada,
                "numeroOrden": data.numeroOrden,
                "lineaDetalleOrden": data.lineaDetalleOrden,
                "codigoEmpresaOrden": data.codigoEmpresaOrden,
                "idOrdenAgendable": data.idOrdenAgendable,
                "idCita": data.idCita,
            }
            params.origen = "inicios";
            if(data.esSesionOdonto == "S"){
                params.sesion = {
                    secuenciaPlanTto: data.secuenciaPlanTto,
                    numeroSesion: data.numeroSesion,
                    tiempoSesion: data.tiempoSesion
                };
                params.detalleSesion = {
                    tipoAtencion: data.tipoAtencion,
                    tiempoSesion: data.tiempoSesion,
                    duracion: data.duracion
                }
            }
            // if(datosConvenios.length == 0){
            //     params.convenio = {
            //         "permitePago": "S",
            //         "permiteReserva": "S",
            //         "idCliente": null,
            //         "codigoConvenio": null,
            //         "secuenciaAfiliado" : null,
            //     };
            //     localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            //     // location = url;
            //     return;
            // }
            params.convenio = {
                secuenciaAfiliado: data.secuenciaAfiliado,
                idCliente: data.idCliente,
                codigoCliente: data.codigoCliente,
                codigoConvenio: data.codigoConvenio,
                codigoEmpresa: data.codigoEmpresa,
                permitePagoLab : data.permitePagoLab,
                permitePago: data.permitePagoReserva,
                mensajeBloqueoPago : data.mensajeBloqueoPago,
                mensajeBloqueoReserva : data.mensajeBloqueoReserva,
                permiteReserva: data.permitePagoReserva,
                aplicaVerificacionConvenio: data.aplicaVerificacionConvenio,
                esPlanStar:  data.esPlanStar
            }
            // console.log(params);return;
            params.tipoFlujo = tipoFlujo;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            location = url;
            return;
            
            const datosConvenioServicio = await consultarConvenios();
            console.log('datosConvenioServicio', datosConvenioServicio);
            if (datosConvenioServicio.data.length == 0) {
                location = url;
            } else {

                llenarModalConvenios(datosConvenioServicio.data, url);

                $('#convenioModal').modal('show');
            }
        }else{    
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
            params.convenio = {
                secuenciaAfiliado: data.secuenciaAfiliado,
                idCliente: data.idCliente,
                codigoCliente: data.codigoCliente,
                codigoConvenio: data.codigoConvenio,
                codigoEmpresa: data.codigoEmpresa,
                permitePagoLab : data.permitePagoLab,
                permitePago: data.permitePagoReserva,
                mensajeBloqueoPago : data.mensajeBloqueoPago,
                mensajeBloqueoReserva : data.mensajeBloqueoReserva,
                permiteReserva: data.permitePagoReserva,
                aplicaVerificacionConvenio: data.aplicaVerificacionConvenio,
                esPlanStar:  data.esPlanStar
            }

            // if (datosConvenios.length > 0) {
            //     console.log('datosConvenio', datosConvenios);
            //     // datosconvenio posicion 0
            //     params.convenio = datosConvenios[0];

            // } else {
            //     params.convenio = {
            //         "permitePago": "S",
            //         "permiteReserva": "S",
            //         "idCliente": null,
            //         "codigoConvenio": null,
            //         "secuenciaAfiliado" : null,
            //     };
            // }
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

            params.central = {
                "codigoSucursal": data.codigoSucursal,
                "nombreSucursal": data.sucursal
            }
            params.ciudad = {
                "codigoPais": data.idPais,
                "codigoProvincia": data.idProvincia,
                "codigoCiudad": data.idCiudad
            }

            params.reservaEdit = {
                "estaPagada": data.estaPagada,
                "numeroOrden": data.numeroOrden,
                "lineaDetalleOrden": data.lineaDetalleOrden,
                "codigoEmpresaOrden": data.codigoEmpresaOrden,
                "idOrdenAgendable": data.idOrdenAgendable,
                "idCita": data.idCita,
                "esSesionOdonto": data.esSesionOdonto
            }
            if(data.esSesionOdonto == "S"){
                params.sesion = {
                    secuenciaPlanTto: data.secuenciaPlanTto,
                    numeroSesion: data.numeroSesion,
                    tiempoSesion: data.tiempoSesion,
                };
                params.detalleSesion = {
                    tipoAtencion: data.tipoAtencion,
                    tiempoSesion: data.tiempoSesion,
                    duracion: data.duracion
                }
            }
            params.origen = "inicios";
            // console.log(params);return;
            params.tipoFlujo = tipoFlujo;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            location = url;
            
            /*if(data.permitePagoReserva == "N" || datosConvenios.length == 0){
                location = url;
            }else{
                //data.mensajePagoReserva
                llenarModalConvenios(datosConvenios, url);
                $('#convenioModal').modal('show');
            }*/
        }
    });


    // consultar convenios y llenar el modal de convenios
    function llenarModalConvenios(data, url){
        let divContenedor = $('#listaConvenios');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = '';
        data.forEach((convenios) => {
            console.log('convenioss', convenios);
            elemento += `<div data-rel='${JSON.stringify(convenios)}' url-rel='${url}' class="convenio-item mb-2">
                                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="cursor-pointer text-primary-veris fs--1 line-height-16">
                                            ${capitalizarCadaPalabra(convenios.nombreConvenio)}
                                        </label> 
                                    </div>
                                </div>`;
        });
        // agregar convenio ninguno
        elemento += `<div data-rel='ninguno' class="convenio-ninguno" url-rel='${url}' >
                        <div class="list-group-item rounded-3 py-2 px-3 border-0">
                            <label for="listGroupCheckableRadiosninguno" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                                Ninguno
                            </label>
                        </div>
                    </div>`;
        divContenedor.append(elemento);
    }

    // consultar datos de facturacion
    async function consultarDatosFacturacion(data){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/consultar_datos_factura?idPreTransaccion=5017811&codigoTipoIdentificacion=2&numeroIdentificacion=0940389299
        `;
        args["method"] = "GET";
        args["showLoader"] = true;
        const dataFacturacion = await call(args);
        console.log('dataFacturacion', dataFacturacion);
        if(dataFacturacion.code == 200){
            return dataFacturacion.data;
        }
        return [];
    }



</script>
<style>
    .link-item-banner {
        cursor: pointer;
        pointer-events: auto;
        z-index: 10;
    }
    .box-container-icon{
        border: 1px solid #D4E1FC
    }
    @media screen and (max-width: 600px) {
        .label-txt-acceso-directo{
            font-size: 14px;
        }
    }
    @media screen and (max-width: 500px) {
        .label-txt-acceso-directo{
            font-size: 12px;
        }
    }
    /* .btn-transition {
        opacity: 0;
        transition: opacity 0.01s ease;
    } */
</style>

@endpush