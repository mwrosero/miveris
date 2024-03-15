@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
$tokenMods = base64_encode(uniqid());
@endphp
<!-- Modal embarazo -->
<div class="modal fade" id="modalEmbarazo" tabindex="-1" aria-labelledby="modalEmbarazoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3">
                <div class="text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="fa-solid fa-info fs-2"></i>
                        </span>
                    </div>
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información solicitada por tu aseguradora</h1>
                    <p class="fs--1 fw-normal text-veris mb-3 mx-3 line-height-16">¿Esta cita es por control de <b>embarazo</b>?</p>
                    <input type="hidden" id="datosGen">
                </div>
                <div class="d-flex">
                    <div respuesta-rel="S" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 me-3 btn-respuesta-embarazo">SI</div>
                    <div respuesta-rel="N" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 btn-respuesta-embarazo">NO</div>
                </div>
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

<div class="flex-grow-1 container-p-y pt-0">
    <!-- offcanva detalle Receta médica -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detalleRecetaMedica" aria-labelledby="detalleRecetaMedicaLabel">
        <div class="offcanvas-header flex-column align-items-start p-0">
            <div class="w-100 px-4 py-2 d-lg-none d-block" style="background: #F3F4F5;">
                <button type="button" class="btn p-0 d-flex align-items-center" data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{asset('assets/img/svg/arrow-left-filtro-body.svg')}}" class="me-1" alt="atras"><b class="fw-medium fs-- text-veris">Atrás</b></button>
            </div>
            <h5 class="offcanvas-title fs--20 line-height-24 w-100 px-4 py-3" id="detalleRecetaMedicaLabel">Detalle de receta</h5>
        </div>
        
        <div class="offcanvas-body p-3" style="background: rgba(249, 250, 251, 1) !important;">
            <small class="d-none">Activa los recordatorios para notificarte el horario del que debes tomar tus medicinas</small>
            <div>
                <div class="list-group gap-3 verPdf">
                    <label class="list-group-item d-flex align-items-center gap-2 border rounded-3 py-3">
                        <div class="d-flex flex-column">
                            <small class="text-veris fw-medium denominacion">
                                RECOMENDACIONES
                            </small>
                            <small class="text-veris fw-light concentracion">
                                concentracion
                            </small>
                            <small class="text-veris fw-light indicaciones">
                                indicaciones
                            </small>
                        </div>
                        {{-- <i class="fa-solid fa-bell ms-auto"></i> --}}
                    </label>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer px-3">
            <div class="col-md-12">
                <button class="btn btn-primary-veris w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3 verPdfReceta" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Ver PDF</button>
            </div>
        </div>
    </div>

    <!-- Modal Receta médica -->
    <div class="modal fade" id="recetaMedicaModal" tabindex="-1" aria-labelledby="recetaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <h5 class="fw-medium text-center">{{ __('Receta médica') }}</h5>
                    <p class="text-center lh-1 fs--1 text-veris my-3">{{ __('¿Compraste esta receta en otra farmacia distinta a la de Veris y/o tomaste el medicamento?') }}</p>
                    <a href="#" id="btnRecetaMedicaSi" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3">{{ __('Sí, lo hice') }}</a>
                    <a href="#" class="btn btn m-0 w-100 px-4 py-3" data-bs-dismiss="modal">No lo he hecho</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Interconsulta médica -->
    <div class="modal fade" id="interconsultaMedicaModal" tabindex="-1" aria-labelledby="interconsultaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <h5 class="fw-medium text-center">{{ __('Interconsulta - Medicina General') }}</h5>
                    <p class="text-center lh-1 fs--1 text-veris my-3">{{ __('No contamos con esta especialidad') }}</p>
                    
                    <p class="text-center fw-medium lh-1 fs--1 my-3">{{ __('¿Ya realizaste esta cita médica?') }}</p>
                    <a href="#" id="btnInterconsultaMedicaSi" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3">{{ __('Sí, lo hice') }}</a>
                    <a href="#" class="btn btn m-0 w-100 px-4 py-3" data-bs-dismiss="modal">No lo he hecho</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensajeError"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Examenes presencial -->
    <div class="modal fade" id="mensajeLaboratorioPresencialModal" tabindex="-1" aria-labelledby="mensajeLaboratorioPresencialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris">{{ __('Para realizarte este examen acercate a una central médica') }}</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal VideoConsulta -->
    <div class="modal fade" id="mensajeVideoConsultaModal" tabindex="-1" aria-labelledby="mensajeVideoConsultaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris">{{ __('Para agendar este procedimiento llama al') }} <b>{{ __('6009600') }}</b></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    {{-- <a href="tel:+59346009600" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
                    <button type="button" class="btn text-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Cerrar') }}</button> --}}
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ver informacion -->
    <div class="modal fade" id="informacionModal" tabindex="-1" aria-labelledby="informacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">{{ __('Veris') }}</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id = "mensajeInformacion"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    {{-- <a href="tel:+59346009600" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
                    <button type="button" class="btn text-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Cerrar') }}</button> --}}
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal no permite reserva -->
    <div class="modal fade" id="mensajeNoPermiteReservaModal" tabindex="-1" aria-labelledby="mensajeNoPermiteReservaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">{{ __('Veris') }}</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id="mensajeNoPermiteReserva">{{ __('Reserva no permitida por este canal') }}</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal infomracion de la cita -->
    <div class="modal fade" id="informacionCitaModal" tabindex="-1" aria-labelledby="informacionCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris" id = "mensajeInformacionCita"></p>
                </div>
                <div id="footerInformacionCita">
                    <div class="modal-footer pt-0 pb-3 px-3">
                        <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Tratamiento') }}</h5>
    </div>

    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0">
            <div class="col-md-12">
                <div class="card rounded-0 border-0 shadow-none">
                    <div class="card-body p-3 pb-2">
                        <div class="row gx-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-10" id="datosTratamientoCard">
                                <!-- datos del tratamiento -->
                            </div>
                            <div class="col-3 col-md-2 col-lg-1">
                                <div class="progress-circle ms-auto" id="progress-circle" data-percentage="0">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            <span><i class="bi bi-check2 success"></i></span>
                                            <p class="fw-medium text-success fs--2 mb-0"><span id="totalTratamientoRealizados"> </span>/<span id="totalTratamientoEnviados"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end rounded-0 px-3 pb-3">
                        <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 px-3" id="verPdf">Ver PDF</a>
                    </div>
                </div>  
                <div class="card rounded-0 border-0" id="cardPromocion">
                    <!-- banner promocion -->
                </div>
            </div>
        </div>
    </section>
    <section class="p-0 px-md-3">
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue" id="tituloTratamientoPendiente" style="display: none;">{{ __('Pendientes') }}</h5>
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="row g-3 justify-content-center" id="contenedorTratamientoPendiente">
                        <!-- items -->
                    </div>
                </div>
            </div>
        </div>
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue" id="tituloTratamientoRealizado" style="display: none;">{{ __('Realizados') }}</h5>
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="row g-3 justify-content-center" id="contenedorTratamientoRealizado">
                        <!-- items -->
                        
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
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let codigoTratamiento = dataCita.tratamiento.codigoTratamiento;
    let porcentaje = dataCita.tratamiento.porcentajeAvanceTratamiento;
    let secuenciaAtencion = [];
    let ultimoTratamiento = [];
    let idPaciente ;
    let datosTratamiento = [];
    let ultimoTratamientoData = [];
    let dataRecetaTmp;
    let datosConvenios = [];
    let datosPaciente = [];
    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        console.log(9)

        await obtenerTratamientos();
        llenarPorcentajeBarra();

        // var $enlace = $('.btn-agendar');

        // // Maneja el evento de clic en el enlace
        // $enlace.on('click', function(event) {
        //     // Previene el comportamiento predeterminado del enlace
        //     event.preventDefault();

        //     // Establece un retraso de 2 segundos antes de redirigir
        //     setTimeout(function() {
        //         // Obtiene la URL del enlace
        //         var url = $enlace.attr('href');
        //         // Redirige a la URL después del retraso
        //         window.location.href = url;
        //     }, 500); // Cambia este valor (en milisegundos) para ajustar el tiempo de retraso
        // });
    });

    async function validacionConvenio(dataCita){
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
            "codigoTipoAtencion": null
        });
        const data = await call(args);
        
        if(data.code == 200){
            return data.data.requiereControlEmbarazo;
        }else{
            return false;
        }
    }

    // llenar el porcentaje de la barra con los datos del tratamiento
    function llenarPorcentajeBarra(){
        let porcentaje = datosTratamiento.porcentajeAvanceTratamiento;
        document.getElementById("progress-circle").setAttribute("data-percentage", roundToDraw(porcentaje));
        // llenar el totalTratamientoEnviados y totalTratamientoRealizados
        // limpiar el contenido
        console.log('datosTratamientoee', datosTratamiento.totalTratamientoEnviados);
        $('#totalTratamientoEnviados').empty();
        $('#totalTratamientoRealizados').empty();
        $('#totalTratamientoEnviados').append(datosTratamiento.totalTratamientoEnviados);
        $('#totalTratamientoRealizados').append(datosTratamiento.totalTratamientoRealizados);
    }
    
    // funciones asyncronas
    // obtener tratamientos 
    async function obtenerTratamientos(){
        let args = [];
        let canalOrigen = _canalOrigen;
        
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/${codigoTratamiento}?canalOrigen=${canalOrigen}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('sssisis',data);
        if(data.code == 200){
            secuenciaAtencion = data.data;
            ultimoTratamientoData = data.data;
            ultimoTratamiento = data.data;
            $('#datosTratamientoCard').empty();    
            let datosTratamientoCard =  $('#datosTratamientoCard');
            datosTratamientoCard.empty; // Limpia el contenido actual
            let elemento = `<h5 class="card-title card-g text-primary-veris line-height-24 mb-1">${capitalizarElemento(ultimoTratamiento.nombreEspecialidad)} </h5>
                                <p class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(ultimoTratamiento.nombrePaciente)}</p>
                                <p class="fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(ultimoTratamiento.nombreMedico)}</p>
                                <p class="fs--2 line-height-16 mb-1">Tratamiento enviado: <b class="fw-light text-primary-veris" id="fechaTratamiento">${ultimoTratamiento.fechaTratamiento}</b></p>
                                <p class="fs--2 line-height-16 mb-1">${ (data.data.datosConvenio.idCliente !== null) ? capitalizarElemento(data.data.datosConvenio.nombreConvenio) : "" }</p> `;
            datosTratamientoCard.append(elemento);
            // mostrar el porcentaje
            document.getElementById("progress-circle").setAttribute("data-percentage", porcentaje);
            datosTratamiento = data.data;

            mostrarTratamientoenDiv();
            mostrarTratamientoenDivRealizados();
            if(data.data.aplicaPromocion == 'S'){
                mostrarBannerPromocion(data.data);
            }
            else {
                document.getElementById("cardPromocion").style.display = "none";
            }
            if(porcentaje == 100){
                $('#datosTratamientoCard').append(`<img src="{{ asset('assets/img/svg/golden.svg') }}" class="pe-3 position-absolute" alt="golden">`);
            }
        } else if (data.code != 200) {
            console.log('errorza');
            // mostrar modal de error
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
        return data;
    }

    // cambiar el estado del tratamiento a realizada
    async function detalleTratamientoRealizado(datos){
        console.log('datosJson', datos);
        let datosExterna;
        if (datos.esExterna == 'S') {
            datosExterna = true;
        } else {
            datosExterna = false;
        }
        let args = [];
        let canalOrigen = _canalOrigen
        
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/detalle_tratamiento_realizado?origenTransaccion=APP_CMV`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify(
            {
                "codigoTratamiento": datos.codigoTratamiento,
                "lineaDetalleTratamiento": datos.lineaDetalleTratamiento,
                "recetas": [
                    {
                        "secuenciaReceta": datos.secuenciaReceta,
                        "esCompraExterna": datosExterna,
                        "fechaRealizado": obtenerFechaActual()
                    }
                ],
                "generarSolicitud": false,
                "fechaRealizado": obtenerFechaActual()
            }
        );

        console.log('args', args["data"]);

        const data = await call(args);
        if (data.code == 200) {
            console.log('datos', data.data);
            // cerrar modal
            $('#recetaMedicaModal').modal('hide');
            // actualizar la lista de tratamientos
            await obtenerTratamientos();
            llenarPorcentajeBarra();

        } else if (data.code != 200) {
            console.log('errorza');
            // mostrar modal de error
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
    }

    // cambiar el estado del interconsulta a realizada
    async function detalleInterconsultaRealizado(datos){
        console.log('datosInterconsulta', datos);
        
        let args = [];
        let canalOrigen = _canalOrigen
        
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/detalle_tratamiento_realizado?origenTransaccion=APP_CMV`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify(
            {
                "codigoTratamiento": dataCita.tratamiento.codigoTratamiento,
                "lineaDetalleTratamiento": datos.lineaDetalleTratamiento,
                "ordenes": [
                    {
                        "codigoEmpresa": datos.codigoEmpresa,
                        "numeroOrden": datos.idOrden,
                        "lineaDetalle": datos.lineaDetalleOrden,
                        "fechaRealizado": obtenerFechaActual()
                    }
                ],
                "generarSolicitud": false,
                "fechaRealizado": obtenerFechaActual()
            }
        );

        const data = await call(args);
        if (data.code == 200) {
            console.log('datos', data.data);
            // cerrar modal
            $('#interconsultaMedicaModal').modal('hide');
            // actualizar la lista de tratamientos
            await obtenerTratamientos();
            llenarPorcentajeBarra();
        } else if (data.code != 200) {
            console.log('errorza');
            // mostrar modal de error
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
    }

    // recibir fechas y horas actuales
    function obtenerFechaActual(){
        let fechaActual = new Date();

        let dia = String(fechaActual.getDate()).padStart(2, '0');
        let mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Enero es 0
        let anio = fechaActual.getFullYear();

        let horas = String(fechaActual.getHours()).padStart(2, '0');
        let minutos = String(fechaActual.getMinutes()).padStart(2, '0');
        let segundos = String(fechaActual.getSeconds()).padStart(2, '0');

        return `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
    }

    // descargar documento pdf
    async function descargarDocumentoPdfPrincipal(datos){
        /*console.log('datosrr', datos.realizados);
        let datosFiltrados;
        if(datos.pendientes.length > 0){
            datosFiltrados = datos.pendientes[datos.pendientes.length - 1];
        } else{
            console.log('datosrr2', datos.realizados[datos.realizados.length - 1]);
            datosFiltrados = datos.realizados[datos.realizados.length - 1];
        }
        console.log('datosFiltrados', datosFiltrados);
        let secuenciaAtencion = datos.secuenciaAtenciones;
        console.log('datossFiltrados', datosFiltrados.tipoCard);*/
        //reporteAcumulativoAtencion
        let args = [];
        let canalOrigen = 'APP_CMV'
        args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/reporteAcumulativoAtencion?secuenciaAtencion=${secuenciaAtencion.secuenciaAtenciones}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);
            window.open(pdfUrl, '_blank');
            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);
        } catch (error) {
            console.error('Error al obtener el PDF:', error);
        }
    }

    // descargar documento pdf
    async function descargarDocumentoPdf(datos){

        let datosFiltrados = datos;
        console.log('datosFiltrados', datosFiltrados);
        let args = [];
        let canalOrigen = 'APP_CMV'
        let secuenciaAtencion = datos.secuenciaAtencion;
        if(datosFiltrados.tipoCard == 'RECETAS'){
            args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=RECETA&numeroOrden=&secuenciaReceta=${datosFiltrados.secuenciaReceta}`;
        }
        else{
            args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=ORDEN&numeroOrden=${datosFiltrados.idOrden}`;
        }
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);
            window.open(pdfUrl, '_blank');
            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);
        } catch (error) {
            console.error('Error al obtener el PDF:', error);
        }
    }

    // obtener la receta en formato pdf
    async function obtenerRecetaPdf(datos){
        console.log('datosPdfff', datos);
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/${api_war}/v1/recetas/archivoreceta?codigoReceta=${datos.secuenciaReceta}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);

            window.open(pdfUrl, '_blank');

            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);

        } catch (error) {
            console.error('Error al obtener el PDF');
        }
    }

    //Consultar el detalle de una receta específica.
    async function consultarDetalleReceta(datos){
        console.log('datosDetta', datos);
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/${api_war}/v1/recetas/detallereceta?canalOrigen=${canalOrigen}&codigoReceta=${datos.secuenciaReceta}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        const data = await call(args);
        console.log('data', data);
        if(data.code == 200){
            let html = $('.verPdf');
            html.empty();
            let elementos = '';
            data.data.forEach((receta) => {
                elementos += `<label class="list-group-item d-flex align-items-center gap-2 bg-white card-border rounded-3 p--2">
                                <div class="d-flex flex-column">
                                    <small class="text-veris fs--1 line-height-16 mb-1 fw-medium denominacion">
                                        ${capitalizarElemento(agregarEspacios(receta.denominacion))}
                                    </small>
                                    <small class="text-veris fw-light fs--2 line-height-16 concentracion">
                                        ${capitalizarElemento(receta.concentracion)} ${capitalizarElemento(receta.formaFarmaceutica)}
                                    </small>
                                    <small class="text-veris fw-light fs--2 line-height-16 indicaciones">
                                        ${capitalizarElemento(receta.indicaciones)}
                                    </small>
                                </div>
                                <!--i class="fa-solid fa-bell ms-auto"></i-->
                            </label>`;
            });
            html.append(elementos);
        }
        return data;
    }
    
    // funciones js
    // mostrar el tratamientos pendientes
    function mostrarTratamientoenDiv() {
        let data = datosTratamiento.pendientes;
        let estado = 'PENDIENTE'
        let divContenedor = $('#contenedorTratamientoPendiente');
        divContenedor.empty(); // Limpia el contenido actual
        if(data.length > 0){
            idPaciente = datosTratamiento.idPaciente;
            data.forEach((tratamientos) => {
                let elemento = `<div class="col-12">
                                    <div class="card h-100">
                                        <div class="card-body p--2">
                                            ${determinarEsOnline(tratamientos)}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarCadaPalabra(tratamientos.nombreServicio)} </h6>
                                                <span class="text-warning-veris fs--2 line-height-16 mb-1" id="estado">${determinarEstado(tratamientos.esPagada)}</span>
                                            </div>
                                            ${determinarFechaCaducidadEncabezado(tratamientos, datosTratamiento)}
                                            ${determinarFechasCaducadas(tratamientos, datosTratamiento)}
                                            <div class="recetaMedicaMensaje">
                                                ${determinarMensajeRecetaMedica(tratamientos)}
                                            </div>                                            
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar avatar-sm border rounded-circle bg-very-pale-red">
                                                    <img class="rounded-circle" src="${quitarComillas(tratamientos.urlImagenTipoServicio)}" alt="receta medica">
                                                </div>
                                                <div class="d-flex">
                                                    ${determinarCondicionesBotones(tratamientos, estado,datosTratamiento)}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

                divContenedor.append(elemento);
            });
            // mostrar el titulo de pendientes
            document.getElementById("tituloTratamientoPendiente").style.display = "block";
            chartProgres("#progress-circle");
        }
    }

    // mostrar el tratamientos realizados
    function mostrarTratamientoenDivRealizados(){
        let estado = 'REALIZADO'
        let data = datosTratamiento.realizados;
        console.log('tratamientos realizados: ', data);
        
        let divContenedorRealizados = $('#contenedorTratamientoRealizado');
        divContenedorRealizados.empty(); // Limpia el contenido actual
        if(data.length > 0){
            data.forEach((tratamientos) =>{

                let elemento = `<div class="col-12">
                                    <div class="card h-100">
                                        <div class="card-body p--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarCadaPalabra(tratamientos.nombreServicio)}</h6>
                                                <span id="estado" class="fs--1 line-height-16 mb-1"><i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">${ (tratamientos.tipoCard == "RECETAS") ? "Comprada" : "Atendida" }</span></span>
                                            </div>
                                            <div>
                                                ${determinarFechasCaducadas(tratamientos, datosTratamiento)}
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar avatar-sm border rounded-circle bg-very-pale-red">
                                                    <img class="rounded-circle" src="${quitarComillas(tratamientos.urlImagenTipoServicio)}" alt="receta medica">
                                                </div>
                                                <div class="d-flex">
                                                    ${determinarCondicionesBotones(tratamientos, estado, datosTratamiento)}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

                divContenedorRealizados.append(elemento);
            });
             // mostrar el titulo de realizados
            document.getElementById("tituloTratamientoRealizado").style.display = "block";
            // chartProgres("#progress-circle");
        }
    }

    // determinar si es online o presencial
    function determinarEsOnline(datos){
        if(datos.modalidad == 'ONLINE'){
            return `<div style="display: inline-flex; justify-content: space-between; align-items: center; background-color: #CEEEFA; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                        <h7 class="text-primary-veris fw-medium mb-0">Consulta online</h7>
                    </div>`;
        } else {
            return ``;
        }
    }

    // mostrar banner de promocion
    function mostrarBannerPromocion(datos){
        console.log(datos)

        let divContenedor = $('#cardPromocion');
        divContenedor.empty(); // Limpia el contenido actual
        let ruta = "/tu-tratamiento/" + "{{ $tokenMods }}";
        let elemento = '';
        if(datos.datosConvenio.idCliente !== null){
            elemento = `<div class="card rounded-0 border-0">
                                <div class="card-body px-3 py-4 position-relative px-lg-5"
                                    style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                                    <h4 class="fs--20 fs-lg-28 fw-medium text-white line-height-24 mb-1">Compra y gestiona</h4>
                                    <h6 class="fs--16 fs-lg-20 fw-light text-white mb-0">tu <b class="fw-medium">tratamiento</b> sin <b>filas</b></h6>
                                    <div class="d-flex justify-content-end mt-2">
                                        <a href=" ${ruta}
                                        " class="btn btn-sm btn-primary-veris fs--1 fw-medium line-height-16 px-3 py-2 border-0 btn-verPromocion
                                        " data-rel='${JSON.stringify(datos)}'>Ver tratamiento</a>
                                    </div>
                                </div>
                                <div class="position-absolute end-7 bottom-40">
                                    <img src="{{ asset('/assets/img/card/carrito_promocion.png') }}" class="img-fluid" width="94" alt="tratamiento" />
                                </div>
                            </div>`;
        } else {
            elemento = `<div class="card rounded-0 border-0">
                                <div class="card-body px-3 py-4 position-relative px-lg-5"
                                    style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                                    <h4 class="fs--20 fs-lg-28 fw-medium text-white line-height-24 fw-normal mb-1">Descubre la <b class="fw-medium">promoción</b></h4>
                                    <h6 class="fs--16 fs-lg-20 fw-light text-white mb-0">que la app <b class="fw-medium">Mi Veris</b></h6>
                                    <h6 class="fs--16 fs-lg-20 fw-light text-white mb-0">tiene para ti</h6>
                                    <div class="d-flex justify-content-end mt-2">
                                        <a href=" ${ruta}
                                        " class="btn btn-sm btn-primary-veris fs--1 fw-medium line-height-16 px-3 py-2 border-0 btn-verPromocion
                                        " data-rel='${JSON.stringify(datos)}'>Ver promoción</a>
                                    </div>
                                </div>
                                <div class="position-absolute end-7 bottom-40">
                                    <img src="{{ asset('/assets/img/svg/regalo.svg') }}" class="img-fluid" width="94" alt="carrito_promocion" />
                                </div>
                            </div>`;
        }
        divContenedor.append(elemento);
    }

    // determinar fechas caducadas
    function determinarFechasCaducadas(datos, datosTratamiento){ 
        let dataFechas = ``;
        if (Object.keys(datosTratamiento.datosConvenio).length > 0) {
            
            if (datos.estado == "AGENDADO" || datos.estado == "ATENDIDO") {
                dataFechas = `<h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(datos.nombreSucursal)}</h6>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(datos.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${datos.detalleReserva.horaReserva}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(datos.nombreMedicoAtencion)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarCadaPalabra(datos.nombrePaciente)}</p> `;
            }
        }
        return dataFechas;
    }




    // determinar si es comprar o por comprar
    function determinarEstado(estado){
        if(estado == "S"){
            return `<i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprada</span>`;
        }else{
            return `<i class="fa-solid fa-circle me-2"></i>Por comprar`;
        }
    }

    // determinar si es receta medica o no mensaje 
    function determinarMensajeRecetaMedica(servicio){
        if(servicio.nombreServicio == "RECETA MÉDICA" || servicio.esExterna == "S"){
            let servicioStr = JSON.stringify(servicio);
            let msg_pregunta = "¿Ya compraste esta receta?";
            let tipoModal = "recetaMedicaModal";
            if(servicio.esExterna == "S"){
                msg_pregunta = "¿Ya realizaste esta interconsulta?"
                tipoModal = "interconsultaMedicaModal";
            }
            return `<a href="" class="fs--2 btn-compraste-receta" data-bs-toggle="modal" data-bs-target="#${tipoModal}" data-rel='${servicioStr}'>${msg_pregunta}</a>`;
        } else {
            return ``;
        }
    }

    


    // determinar si es receta medica o no botones realizados
    function determinarbotonesRecetaMedicaRealizados(servicio){
        if(servicio == "FARMACIA"){
            return `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1 px-3 py-2">Ver receta</a> `;
        } else{
            return `<a href="#" class="btn btn-sm btn-primary-veris shadow-none fw-normal fs--1 px-3 py-2">Ver orden</a> `;
        }
    }

    // determinar condiciones de los botones 
    function determinarCondicionesBotones(datosServicio, estado, datosTratamiento){
        // console.log(estado, datosServicio.estado, datosServicio.tipoCard)
        let services = datosServicio;
        if (datosServicio.length == 0) {
            return `<div></div>`;
        } else{
            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                    let respuestaAgenda = "";
                    // Agregar ver orden 
                    //respuestaAgenda += ` <a class="btn btn-sm text-primary-veris shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard">Ver orden</a>`;
                    if(datosServicio.estado == 'PENDIENTE_AGENDAR'){
                        console.log(0)
                        if(datosServicio.esExterna == "N"){
                            respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                        }else{
                            respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                        }
                        if(datosServicio.esCaducado == 'S' || datosServicio.esAgendable == "N"){
                            // mostrar boton de informacion que llama al modal de informacion
                            respuestaAgenda += `<a href="#" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none btn-informacion" data-bs-toggle="modal" data-bs-target="#informacionCitaModal" data-rel='${JSON.stringify(datosServicio)}' datosTratamiento-rel='${JSON.stringify(datosTratamiento)}'>Información</a>`;
                        } else {
                            if(datosServicio.permiteReserva == 'S'){
                                if (datosServicio.habilitaBotonAgendar == 'S' && datosServicio.esExterna == "N") {
                                    let ruta = "/citas-elegir-fecha-doctor/{{ $tokenMods }}";
                                    if (datosServicio.modalidad == "PRESENCIAL") {
                                        ruta = "/citas-elegir-central-medica/{{ $tokenMods }}";
                                    }
                                    respuestaAgenda += `<div url-rel="${ruta}" data-rel='${JSON.stringify(datosServicio)}' class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none btn-agendar">Agendar</div>`;
                                } else {
                                    if(datosServicio.esExterna == "N"){
                                        respuestaAgenda += `<a href="#" class="btn btn-sm fs--1 px-3 py-2 border-0  fw-normal fs--1 disabled" style="background-color: #F3F0F0 !important; color: darkgrey !important;">Agendar </a>`;
                                    }
                                }
                            } else {
                                // abrir modal no permite reserva
                                respuestaAgenda += `<button type="button" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none" data-bs-toggle="modal" data-bs-target="#mensajeNoPermiteReservaModal">Agendar</button>`;
                            }
                        }
                    } else if (datosServicio.estado == 'AGENDADO'){
                        // mostrar boton de ver orden
                        //respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">Ver orden</a>`;
                        let ruta = "/citas-elegir-fecha-doctor/{{ $tokenMods }}";
                        if (datosServicio.modalidad == "PRESENCIAL") {
                            ruta = "/citas-elegir-central-medica/{{ $tokenMods }}";
                        }
                        if (datosServicio.permitePago == 'S' && datosServicio.esPagada == "N"){
                            // mostrar boton de pagar
                            if(datosServicio.detalleReserva === null){
                                respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                            }else{
                                respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn btn-sm fs--1 px-3 py-2 border-0 ms-2 text-primary-veris border-none shadow-none btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            }

                            respuestaAgenda += `<div url-rel="/citas-datos-facturacion/{{ $tokenMods }}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-pagar" data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}'>Pagar</div>`;
                        }else if(datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                            if(datosServicio.modalidad != "ONLINE" && datosServicio.esPagada == "S"){
                                respuestaAgenda += ` <a class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</a>`;
                            }
                            if((datosServicio.esPagada == "S" && datosServicio.modalidad == "ONLINE") || datosServicio.esPagada == "N"){
                                respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn btn-sm fs--1 px-3 py-2 border-0 ms-2 text-primary-veris border-none shadow-none btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            }else{
                                respuestaAgenda += `<a href="#" url-rel='${ruta}' data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' class="btn btn-sm fs--1 px-3 py-2 border-0 ms-2 btn-primary-veris shadow-none btn-CambiarFechaCita">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                            }
                            if(datosServicio.modalidad == "ONLINE" && datosServicio.esPagada == "S"){
                                respuestaAgenda += `<a href="${datosServicio.detalleReserva.idTeleconsulta}" class="btn btn-sm fs--1 px-3 py-2 border-0 ms-2 btn-primary-veris shadow-none">Conectarme</a>`;
                            }
                            if(datosServicio.esPagada == "N"){
                                respuestaAgenda += `<div url-rel="/citas-datos-facturacion/{{ $tokenMods }}" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-pagar" data-rel='${JSON.stringify(datosServicio)}' convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}'>Pagar</div>`;
                            }
                        } else if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                            // mostrar boton de informacion
                            // respuestaAgenda += `<a href="#" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none" onclick="mostrarInformacion('${datosServicio.detalleReserva.mensajeInformacion}')">Información</a>`;
                            respuestaAgenda = `<div class="btn btn-sm btn-outline-primary-veris fs--1 fw-normal btn-cita-informacion line-height-16 shadow-none border-0 pe-0 me-0" onclick="mostrarInformacion('${datosServicio.detalleReserva.mensajeInformacion}')">
                                        <i class="fa-solid fa-circle-info text-warning line-height-20" style="font-size:22px"></i>
                                    </div>`
                        } 
                    }else if (datosServicio.estado == 'ATENDIDO'){
                        // mostrar boton de ver orden
                        respuestaAgenda = ``;
                        respuestaAgenda += ` <button type="button" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`; 
                    } 
                    return respuestaAgenda;
                    break;
                case "LAB":
                    console.log('estadossss', estado);
                    let respuesta = "";
                    if (estado == 'PENDIENTE'){
                        if(datosServicio.verResultados != "S" && datosServicio.aplicaSolicitud != "S" && datosServicio.permitePago != "S"){
                            // respuesta += ` <button type="button" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                            respuesta += ` <button type="button" class="btn btn-sm fs--1 px-3 py-2 border-0 ms-2 text-primary-veris border-none shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                            let params = {}
                            params.idPaciente = idPaciente;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            if(datosServicio.modalidad == "PRESENCIAL"){
                                respuesta += `<div url-rel="/citas-laboratorio/{{$tokenMods}}" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'><i class="fa-solid fa-circle-info me-2 line-height-20"></i>Información</div>`;
                            }else{
                                respuesta += `<div url-rel="/citas-laboratorio/{{$tokenMods}}" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'>Pagar</div>`;
                            }
                        }else{
                            respuesta += ` <button type="button" class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }
                        
                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            let ruta = "/laboratorio-domicilio/" + "{{ $params }}";
                            respuesta += `<a url-rel="${ruta}" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-veris btnSolicitarLaboratorio" data-rel='${JSON.stringify(datosServicio)}'>Ver resultados</a>`;
                        
                        } else {
                            respuesta += ``;
                        }
                        //condición para 'aplicaSolicitud'
                        if (datosServicio.aplicaSolicitud == "S") {
                            let ruta = "/laboratorio-domicilio/" + "{{ $params }}";
                            respuesta += `<a url-rel="${ruta}" class="btn btn-sm btn-primary-veris shadow-none me-1 btnSolicitarLaboratorio" data-rel='${JSON.stringify(datosServicio)}'><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                            
                        
                        } else if (datosServicio.permitePago == "S"){
                            let params = {}
                            params.idPaciente = idPaciente;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            respuesta += `<div url-rel="/citas-laboratorio/{{$tokenMods}}" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none btn-pagar" convenio-rel='${JSON.stringify(datosTratamiento.datosConvenio)}' data-rel='${JSON.stringify(datosServicio)}'>Pagar</div>`;
                        }
                    } else if (estado == 'REALIZADO'){
                        console.log('estadossss2', estado);
                        respuesta = "";
                        respuesta += ` <button type="button" class="btn btn-sm fw-medium fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    
                    }else if (datosServicio.estado == 'ATENDIDO'){
                        // mostrar boton de ver orden
                        respuestaAgenda = ``;
                        respuestaAgenda += ` <button type="button" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;  
                    }
                    return respuesta;
                    break;
                case "RECETAS" :
                    let respuestaReceta = ``;
                    if (estado == 'REALIZADO') {
                        respuestaReceta += ` <button class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        respuestaReceta += `<button type="button" class="btn btn-sm fw-medium fs--1 px-3 py-2 border-0 btn-primary-veris btnVerOrden" data-bs-toggle="offcanvas" data-bs-target="#detalleRecetaMedica" aria-controls="detalleRecetaMedica" data-rel='${JSON.stringify(datosServicio)}'>Ver receta</button>`;
                    } else if(estado == "PENDIENTE") {
                        if(datosServicio.aplicaSolicitud != "S"){
                            respuestaReceta += ` <button class="btn btn-sm fw-medium fs--1 px-3 py-2 border-0 btn-primary-veris btnVerOrden" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }else{
                            respuestaReceta += ` <button class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        }
                        if(datosServicio.aplicaSolicitud == "S"){
                            respuestaReceta += `<a href="/farmacia-domicilio/${codigoTratamiento}" class="btn btn-sm fs--1 px-3 py-2 border-0 btn-primary-veris fw-medium shadow-none"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                        }
                    }
                    return respuestaReceta;
                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    if(estado == "PENDIENTE"){
                        respuestaOdontologia += ` <button class="btn btn-sm fw-normal fs--1 me-1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                        // ABRIRE MODAL DE VIDEO CONSULTA
                        respuestaOdontologia += `<button type="button" class="btn btn-sm fw-medium fs--1 px-3 py-2 border-0 btn-primary-veris" data-bs-toggle="modal" data-bs-target="#mensajeVideoConsultaModal">Agendar</button>`;
                    }else if(estado == 'REALIZADO'){
                        respuestaOdontologia += ` <button class="btn btn-sm fw-medium fs--1 px-3 py-2 border-0 btn-primary-veris verOrdenCard" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</button>`;
                    }
                    return respuestaOdontologia;
                    break;

            }
        }
    }

    // agendar cita odontologia
    function agendarCitaOdontologia(){
        //abrir modal video consulta
        $('#mensajeVideoConsultaModal').modal('show');
    }

    // mostrar informacion
    function mostrarInformacion(mensaje){
        if (mensaje == null) {
            //abrir modal informacion
            $('#informacionModal').modal('show');
            document.getElementById("mensajeInformacion").innerHTML = "No hay información disponible";
        } else{
            //abrir modal informacion
            $('#informacionModal').modal('show');
            document.getElementById("mensajeInformacion").innerHTML = mensaje;
        }
    }

    // determinar valores null 
    function determinarValoresNull(valor){
        if(valor == null){
            return '';
        }
        else{
            return valor;
        }
    }

    // formatear fecha
    function formatearFecha(fecha) {
        const meses = ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"];
        const partes = fecha.split('-');
        const dia = partes[0];
        const mes = meses[parseInt(partes[1], 10) - 1];
        const año = partes[2];

        return `${mes} ${dia}, ${año}`;
    }

    // boton ver pdf
    $('#verPdf').click(function(){
        descargarDocumentoPdfPrincipal(ultimoTratamientoData);
    });

    // asignacion de datos al modal receta medica
    $('#recetaMedicaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var datos = JSON.parse(button.attr('data-rel'));
        $('#btnRecetaMedicaSi').data('rel', datos);
    });

    // boton receta medica si lo hice
    $('#btnRecetaMedicaSi').click(async function(){
        let datos = $(this).data('rel');
        await detalleTratamientoRealizado(datos);
    });

    // asignacion de datos al modal interconsulta medica
    $('#interconsultaMedicaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var datos = JSON.parse(button.attr('data-rel'));
        $('#btnInterconsultaMedicaSi').data('rel', datos);
    });

    // boton interconsulta medica si lo hice
    $('#btnInterconsultaMedicaSi').click(async function(){
        let datos = $(this).data('rel');
        await detalleInterconsultaRealizado(datos);
    });

    // boton ver orden
    $(document).on('click', '.verOrdenCard', function(){
        let datos = $(this).data('rel');
        descargarDocumentoPdf(datos);
    });

    $(document).on('click', '.btnVerOrden', function(){
        // llamar al servicio de detalle de receta
        let datos = $(this).data('rel');
        console.log('datos', datos);
        consultarDetalleReceta(datos);

        // pasar data rel a modal
        $('#detalleRecetaMedica').attr('data-rel', JSON.stringify(datos));
    });

    // boton informacion
    $(document).on('click', '.btn-informacion', function(){
        let datos = JSON.parse($(this).attr('data-rel'));
        let datosTratamiento = JSON.parse($(this).attr('datosTratamiento-rel'));
        console.log(datos)
        if (datos.esCaducado === "S" && datos.esAgendable === "S") {
            // CAMBIAR TITUOLO MODAL
            $('#tituloModalInformacionCita').text('Orden expirada');
            $('#mensajeInformacionCita').text('El tiempo para agendar esta orden expiró, puedes agendar la cita sin cobertura.');
            // limpiar footer
            $('#footerInformacionCita').empty();
            // agregar boton agendar y salir
            $('#footerInformacionCita').append(`<div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" datosTratamiento-rel='${JSON.stringify(datosTratamiento)}' data-rel='${JSON.stringify(datos)}' id="btnAgendarCitaModal">{{ __('Agendar') }}</button>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Salir') }}</button>
                </div>`);
        } else if(datos.esAgendable === "N") {
                $('#tituloModalInformacionCita').text('Información');
                $('#mensajeInformacionCita').text(datos.mensaje);
                $('#footerInformacionCita').empty();
                $('#footerInformacionCita').append(`<div class="modal-footer pt-0 pb-3 px-3">
                        <button type="button" class="btn btn-primary-veris fs--18 line-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                    </div>`)
        } else {
            $('#mensajeInformacionCita').text(datos.mensaje);
        }
    });

    // boton agendar cita modal setear datos en localstorage
    $(document).on('click', '#btnAgendarCitaModal', function(){
            
            let datos = $(this).data('rel');
            let datosServicio = JSON.parse($(this).attr('datosTratamiento-rel'));
            // console.log(datos)
            // console.log(datosServicio)
            // return;
            let url = $(this).attr('url-rel');
            if(datos.permiteReserva == "N"){// && datos.esPagada == "N"
                $('#mensajeNoPermiteCambiar').html(datos.mensajeBloqueoReserva);
                $('#modalPermiteCambiar').modal('show');
                return;
            }

            let modalidad;
            let online;
            if (datos.modalidad == 'PRESENCIAL') {
                online = 'N';
            } else {
                online = 'S';
            }
            let params = {}
            params.online = online;
            params.paciente = dataCita.paciente;
            params.especialidad = {
                codigoEspecialidad : datos.codigoEspecialidad,
                codigoPrestacion : datos.codigoPrestacion,
                codigoServicio : datos.codigoServicio,
                codigoTipoAtencion : datos.codigoTipoAtencion,
                esOnline : online,
                imagen : datos.urlImagenTipoServicio,
                nombre : datos.nombreServicio,
            }
            // params.convenio = datosServicio.datosConvenio;
            params.convenio = datosServicio.datosConvenio;

            localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(params));
            if (online == 'S') {
                window.location.href = '/citas-elegir-fecha-doctor/{{ $tokenMods }}';
            } else {
                // ir a central medica
                window.location.href = '/citas-elegir-central-medica/{{ $tokenMods }}';
            }
            
        });

    
    // boton ver pdf receta
    $(document).on('click', '.verPdfReceta', function(){
        let datos = $('#detalleRecetaMedica').attr('data-rel');
        datos = JSON.parse(datos);

        obtenerRecetaPdf(datos);
    });

    // setear los valores del agendamiento en localstorage

    $(document).on('click', '.btn-agendar', async function(){
        let datosServicio = $(this).data('rel');
        let url = $(this).attr('url-rel');

        if(datosServicio.permiteReserva == "N"){
            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoReserva);
            $('#modalPermiteCambiar').modal('show');
            return;
        }

        console.log('datosServicio', datosServicio);
        let modalidad;
        if (datosServicio.modalidad === 'ONLINE') {
            modalidad = 'S';
        } else if (datosServicio.modalidad === 'PRESENCIAL') {
            modalidad = 'N';
        }

        dataCita.online = modalidad;

        dataCita.especialidad = {
            codigoEspecialidad: datosServicio.codigoEspecialidad,
            nombre : datosServicio.nombreServicio,
            imagen : datosServicio.urlImagenTipoServicio,
            esOnline : modalidad,
            codigoServicio : datosServicio.codigoServicio,
            codigoPrestacion : datosServicio.codigoPrestacion,
            codigoTipoAtencion : datosServicio.codigoTipoAtencion,
            codigoSucursal : datosServicio.codigoSucursal,
            origen: "Listatratamientos"
        };
        dataCita.origen = "Listatratamientos";
        dataCita.convenio = ultimoTratamiento.datosConvenio;
        dataCita.convenio.origen = "Listatratamientos";

        dataCita.tratamiento = {
            cantidadIntervalosReserva: datosServicio.cantidadIntervalosReserva,
            numeroOrden: datosServicio.idOrden,
            codigoEmpOrden: datosServicio.codigoEmpresa,
            lineaDetalle: datosServicio.lineaDetalleOrden,
            esPagada: datosServicio.esPagada
        }

        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
            let controlEmbarazo = await validacionConvenio(dataCita);
            if(controlEmbarazo){
                $('#datosGen').val(data);
                $('.btn-respuesta-embarazo').attr("url-rel",$url);
                $('#modalEmbarazo').modal("show");
            }else{
                localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
                location = url;
            }
        }else{
            localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
            location = url;
        }
        
    });

    $('body').on('click', '.btn-respuesta-embarazo', async function(){
        let estaEmbarazada = $(this).attr('respuesta-rel');
        dataCita.estaEmbarazada = estaEmbarazada;
        localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
        let ruta = $(this).attr('url-rel');
        location.href = ruta;
    })

    // boton btn-pagar
    $(document).on('click', '.btn-pagar', function(){
        let datosServicio = $(this).data('rel');
        let convenio = JSON.parse($(this).attr('convenio-rel'));

        if(datosServicio.esPagada && datosServicio.tipoCard == "LAB" && datosServicio.modalidad == "PRESENCIAL"){
            $('#mensajeNoPermiteCambiar').html(datosServicio.mensaje);
            $('#modalPermiteCambiar').modal('show');
            return;
        }

        if(datosServicio.permitePago == "N" && datosServicio.tipoCard != "LAB"){
            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoPago);
            $('#modalPermiteCambiar').modal('show');
            return;
        }else if(datosServicio.tipoCard == "LAB" && datosServicio.modalidad == "PRESENCIAL" && datosServicio.permitePago == "N"){
            $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoPago);
            $('#modalPermiteCambiar').modal('show');
            return;
        }
        // console.log(datosServicio);return;
        let modalidad;
        if (datosServicio.modalidad === 'ONLINE') {
            modalidad = 'S';
        } else if (datosServicio.modalidad === 'PRESENCIAL') {
            modalidad = 'N';
        }

        dataCita.online = modalidad;

        dataCita.especialidad = {
            codigoEspecialidad: datosServicio.codigoEspecialidad,
            nombre : datosServicio.nombreServicio,
            imagen : datosServicio.urlImagenTipoServicio,
            esOnline : modalidad,
            codigoServicio : datosServicio.codigoServicio,
            codigoPrestacion : datosServicio.codigoPrestacion,
            codigoTipoAtencion : datosServicio.codigoTipoAtencion,
            codigoSucursal : datosServicio.codigoSucursal,
            origen: "Listatratamientos"
        };
        dataCita.convenio = convenio;
        dataCita.convenio.origen = "Listatratamientos";
        dataCita.datosTratamiento = datosServicio;
        dataCita.datosTratamiento.origen = "Listatratamientos";
        console.log(dataCita)

        localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
        location.href = $(this).attr("url-rel");
    });

    // boton btn-verPromocion
    $(document).on('click', '.btn-verPromocion', function(){
        let datosPromocion = $(this).data('rel');

        dataCita.especialidad = {
            codigoEspecialidad: datosPromocion.codigoEspecialidad,
            nombre : datosPromocion.nombreEspecialidad,
            imagen : datosPromocion.urlImagenEspecialidad,
            
            codigoServicio : datosPromocion.codigoServicio,
            codigoPrestacion : datosPromocion.codigoPrestacion,
            codigoTipoAtencion : datosPromocion.codigoTipoAtencion,
            codigoSucursal : datosPromocion.codigoSucursal,
            origen: "Listatratamientos"
        };

        dataCita.convenio = datosPromocion.datosConvenio;
        dataCita.convenio.origen = "Listatratamientos";
        dataCita.datosTratamiento = datosPromocion;
        dataCita.datosTratamiento.origen = "Listatratamientos";

        localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
    });

    $(document).on('click', '.btn-CambiarFechaCita', function(){
        console.log('click entro a cambiar fecha');
        let data = $(this).data('rel');
        let url = $(this).attr('url-rel');
        let convenio = JSON.parse($(this).attr('convenio-rel'));
        // console.log(convenio);return;

        if(data.permiteReserva == "N" && data.esPagada != "S"){
            $('#mensajeNoPermiteCambiar').html(data.mensajeBloqueoReserva);
            $('#modalPermiteCambiar').modal('show');
            return;
        }

        console.log('dataCa', data);
        console.log('urlCa', url);
        // const dataConvenio = await consultarConvenios(data);
        // const dataPaciente = await consultarDatosPaciente(data);
        let esVirtual = "N";
        if(data.modalidad != "PRESENCIAL"){
            esVirtual = "S";
        }
        
        let params = {}
        params.online = esVirtual;
        params.especialidad = {
            codigoEspecialidad: data.codigoEspecialidad,
            codigoPrestacion  : data.codigoPrestacion,
            codigoServicio   : data.codigoServicio,
            codigoTipoAtencion: data.codigoTipoAtencion,
            esOnline : esVirtual,
            nombre : data.nombreEspecialidad,
        }
        params.paciente = {
            "numeroIdentificacion": data.numeroIdentificacion,
            "tipoIdentificacion": data.tipoIdentificacion,
            "nombrePaciente": data.nombrePaciente,
            "numeroPaciente": data.numeroPaciente
        }

        params.reservaEdit = {
            "estaPagada": data.esPagada,
            "numeroOrden": (data.numeroOrden) ? data.numeroOrden : data.idOrden,
            "lineaDetalleOrden": data.lineaDetalleOrden,
            "codigoEmpresaOrden": (data.codigoEmpresaOrden) ? data.codigoEmpresaOrden : data.codigoEmpresa,
            "idOrdenAgendable": data.idOrdenAgendable,
            "idCita": data.detalleReserva.codigoReserva
        }
        params.origen = "inicios";
        params.convenio = convenio;
        
        localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(params));
        location = url;
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
                                        <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="text-primary-veris fs--1 line-height-16">
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

    // boton btnSolicitarLaboratorio
    $(document).on('click', '.btnSolicitarLaboratorio', function(){
        let datosServicio = $(this).data('rel');
        let url = $(this).attr('url-rel');

        console.log('datosServicio', datosServicio);
        let modalidad;
        if (datosServicio.modalidad === 'ONLINE') {
            modalidad = true;
        } else if (datosServicio.modalidad === 'PRESENCIAL') {
            modalidad = false;
        }

        dataCita.online = modalidad;

        dataCita.especialidad = {
            codigoEspecialidad: datosServicio.codigoEspecialidad,
            nombre : datosServicio.nombreServicio,
            imagen : datosServicio.urlImagenTipoServicio,
            esOnline : modalidad,
            codigoServicio : datosServicio.codigoServicio,
            codigoPrestacion : datosServicio.codigoPrestacion,
            codigoTipoAtencion : datosServicio.codigoTipoAtencion,
            codigoSucursal : datosServicio.codigoSucursal,
            origen: "Listatratamientos"
        };
        dataCita.origen = "Listatratamientos";
        dataCita.convenio = ultimoTratamiento.datosConvenio;
        dataCita.convenio.origen = "Listatratamientos";

        dataCita.tratamiento.numeroOrden = datosServicio.idOrden;
        dataCita.tratamiento.codigoEmpOrden = datosServicio.codigoEmpresa;
        dataCita.tratamiento.lineaDetalle = datosServicio.lineaDetalleOrden;

        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
        location = url;
    });

    
</script>
@endpush