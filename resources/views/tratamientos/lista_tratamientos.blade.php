@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
$data = json_decode(base64_decode($params));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- offcanva detalle Receta médica -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detalleRecetaMedica" aria-labelledby="detalleRecetaMedicaLabel">
        <div class="offcanvas-header py-2">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="bi bi-arrow-left"></i> <b class="fw-medium">Atrás</b>
                </button>
                <h5 class="offcanvas-title" id="detalleRecetaMedicaLabel">Detalle de receta</h5>
            </div>
        </div>
        
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <small>Activa los recordatorios para notificarte el horario del que debes tomar tus medicinas</small>
            <br>
            <div>
                <div class="list-group gap-2 mb-3 verPdf">
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
                        
                        <i class="fa-solid fa-bell ms-auto"></i>
                    </label>
                </div>
            </div>
            
        </div>
        
        <div class="offcanvas-footer py-2">
            <div class="col-md-12 mb-3">
                <button class="btn btn-primary-veris w-100 mt-5 mb-3 mx-0 py-3 mr-3 verPdfReceta" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Ver PDF</button>
            </div>
        </div>
    </div>

    <!-- Modal Receta médica -->
    <div class="modal fade" id="recetaMedicaModal" tabindex="-1" aria-labelledby="recetaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="fw-medium text-center">{{ __('Receta médica') }}</h5>
                    <p class="text-center lh-1 fs--1 my-3">{{ __('¿Compraste esta receta en otra farmacia distinta a la de Veris y/o tomaste el medicamento?') }}</p>
                    <a href="#" class="btn btn-primary-veris w-100">{{ __('Sí, lo hice') }}</a>
                    <a href="#" class="btn btn w-100">No lo he hecho</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3 pb-2">Solicitud fallida</h1>
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

    <!-- Modal Examenes presencial -->
    <div class="modal fade" id="mensajeLaboratorioPresencialModal" tabindex="-1" aria-labelledby="mensajeLaboratorioPresencialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal">{{ __('Para realizarte este examen acercate a una central médica') }}</p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal VideoConsulta -->
    <div class="modal fade" id="mensajeVideoConsultaModal" tabindex="-1" aria-labelledby="mensajeVideoConsultaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal">{{ __('Para agendar esta videoconsulta llama al') }} <b>{{ __('6009600') }}</b></p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <a href="tel:+59346009600" class="btn btn-primary-veris w-100"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
                    <button type="button" class="btn text-primary-veris w-100" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ver informacion -->
    <div class="modal fade" id="informacionModal" tabindex="-1" aria-labelledby="informacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal" id = "mensajeInformacion"></p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <a href="tel:+59346009600" class="btn btn-primary-veris w-100"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
                    <button type="button" class="btn text-primary-veris w-100" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal no permite reserva -->
    <div class="modal fade" id="mensajeNoPermiteReservaModal" tabindex="-1" aria-labelledby="mensajeNoPermiteReservaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3">{{ __('Veris') }}</h1>
                    <p class="fs--1 fw-normal" id = "mensajeNoPermiteReserva"
                    >{{ __('Reserva no permitida por este canal') }}</p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal infomracion de la cita -->
    <div class="modal fade" id="informacionCitaModal" tabindex="-1" aria-labelledby="informacionCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal" id = "mensajeInformacionCita"></p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Tratamiento') }}</h5>  
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0">
            <div class="col-md-12">
                <div class="card rounded-0 border-0 shadow-none">
                    <div class="card-body p-3 pb-0">
                        <div class="row gx-0 justify-content-between align-items-center">
                            <div class="col-9 col-md-10" id="datosTratamientoCard">
                                <!-- datos del tratamiento -->
                            </div>
                            <div class="col-3 col-md-2 col-lg-1">
                                <div class="progress-circle ms-auto" id="progress-circle" data-percentage="10">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value">
                                        <div>
                                            <span><i class="bi bi-check2 success"></i></span>
                                            <p class="fw-medium text-success fs--2 mb-0"><span id="totalTratamientoRealizados">0</span>/<span id="totalTratamientoEnviados">7</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end rounded-0 px-3 pb-2">
                        <a href="#" class="btn btn-sm btn-label-primary-veris px-3 mb-2" id="verPdf"
                        >Ver PDF</a>
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
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-2" id="contenedorTratamientoPendiente">
                    <!-- items -->
                </div>
            </div>
        </div>
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue" id="tituloTratamientoRealizado" style="display: none;">{{ __('Realizados') }}</h5>
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-2" id="contenedorTratamientoRealizado">
                    <!-- items -->
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
    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        
        await obtenerTratamientos();
        llenarPorcentajeBarra();

    });

    // llenar el porcentaje de la barra con los datos del tratamiento
    function llenarPorcentajeBarra(){
        let porcentaje = datosTratamiento.porcentajeAvanceTratamiento;
        document.getElementById("progress-circle").setAttribute("data-percentage", porcentaje);
        // llenar el totalTratamientoEnviados y totalTratamientoRealizados
        // limpiar el contenido
        console.log('datosTratamientoee', datosTratamiento.totalTratamientoEnviados);
        $('#totalTratamientoEnviados').empty();
        $('#totalTratamientoRealizados').empty();
        $('#totalTratamientoEnviados').append(datosTratamiento.totalTratamientoEnviados);
        $('#totalTratamientoRealizados').append(datosTratamiento.totalTratamientoRealizados);


    }
    
    // funciones asyncronas
    // obtener tratamientos  ​/tratamientos​/{idTratamiento}
    async function obtenerTratamientos(){
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/${codigoTratamiento}?canalOrigen=${canalOrigen}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('sssisis',data);
        if(data.code == 200){
            secuenciaAtencion = data.data;
            ultimoTratamientoData = data.data;
            ultimoTratamiento = data.data;
                
            let datosTratamientoCard =  $('#datosTratamientoCard');
            datosTratamientoCard.empty; // Limpia el contenido actual
            let elemento = `<h5 class="card-title text-primary mb-0">${capitalizarElemento(ultimoTratamiento.nombreEspecialidad)} </h5>
                                <p class="fw-medium fs--2 mb-0">${capitalizarElemento(ultimoTratamiento.nombrePaciente)}</p>
                                <p class="fs--2 mb-0">Dr(a): ${capitalizarElemento(ultimoTratamiento.nombreMedico)}</p>
                                <p class="fs--2 mb-0">Tratamiento enviado: <b class="fw-light text-primary-veris" id="fechaTratamiento">${ultimoTratamiento.fechaTratamiento}</b></p>
                                <p class="fs--2 mb-0">${data.data.datosConvenio.nombreConvenio}</p> `;
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
        }
        else if (data.code != 200) {
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
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/detalle_tratamiento_realizado?origenTransaccion=${canalOrigen}`;
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

        console.log('datosrr', datos.realizados);
        let datosFiltrados;
        if(datos.pendientes.length > 0){
            datosFiltrados = datos.pendientes[datos.pendientes.length - 1];
        }
        else{
            console.log('datosrr2', datos.realizados[datos.realizados.length - 1]);
            datosFiltrados = datos.realizados[datos.realizados.length - 1];
        }
        console.log('datosFiltrados', datosFiltrados);
        let args = [];
        let canalOrigen = 'APP_CMV'
        let secuenciaAtencion = datos.secuenciaAtenciones;
        if(datosFiltrados.tipoCard == 'RECETAS'){
            args["endpoint"] = api_url + `/digitalestest/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=RECETA&numeroOrden=&secuenciaReceta=${datosFiltrados.secuenciaReceta}`;
        }
        else{
            args["endpoint"] = api_url + `/digitalestest/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=ORDEN&numeroOrden=${datosFiltrados.idOrden}`;
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


    // descargar documento pdf
    async function descargarDocumentoPdf(datos){

        let datosFiltrados = datos;
        console.log('datosFiltrados', datosFiltrados);
        let args = [];
        let canalOrigen = 'APP_CMV'
        let secuenciaAtencion = datos.secuenciaAtencion;
        if(datosFiltrados.tipoCard == 'RECETAS'){
            args["endpoint"] = api_url + `/digitalestest/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=RECETA&numeroOrden=&secuenciaReceta=${datosFiltrados.secuenciaReceta}`;
        }
        else{
            args["endpoint"] = api_url + `/digitalestest/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=ORDEN&numeroOrden=${datosFiltrados.idOrden}`;
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
        
        args["endpoint"] = api_url + `/digitalestest/v1/recetas/archivoreceta?codigoReceta=${datos.secuenciaReceta}`;
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


     //Consultar el detalle de una receta específica.
     async function consultarDetalleReceta(datos){
        console.log('datosDetta', datos);
        let args = [];
        let canalOrigen = 'APP_CMV'
        
        args["endpoint"] = api_url + `/digitalestest/v1/recetas/detallereceta?canalOrigen=${canalOrigen}&codigoReceta=${datos.secuenciaReceta}`;
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
                elementos += `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3 py-3">
                                <div class="d-flex flex-column">
                                    <small class="text-veris fw-medium denominacion">
                                        ${receta.denominacion}
                                    </small>
                                    <small class="text-veris fw-light concentracion">
                                        ${receta.concentracion} ${receta.formaFarmaceutica}
                                    </small>
                                    <small class="text-veris fw-light indicaciones">
                                        ${receta.indicaciones}
                                    </small>
                                </div>
                                <i class="fa-solid fa-bell ms-auto"></i>
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
                
                    let elemento = `<div class="card mb-3">
                                        <div class="card-body fs--2 p-3">
                                            ${determinarEsOnline(tratamientos)}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-medium fs--1 mb-0">${capitalizarCadaPalabra(tratamientos.nombreServicio)} </h6>
                                                <span class="text-warning-veris" id="estado">${determinarEstado(tratamientos.esPagada)}</span>
                                            </div>
                                            ${determinarFechasCaducadas(tratamientos, datosTratamiento)}
                                            <div id="recetaMedicaMensaje">
                                                ${determinarMensajeRecetaMedica(tratamientos)}
                                            </div> 
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar border rounded-circle bg-very-pale-red">
                                                    <img class="rounded-circle" src="${quitarComillas(tratamientos.urlImagenTipoServicio)}" width="26" alt="receta medica">
                                                </div>
                                                <div class="d-flex">
                                                    ${determinarCondicionesBotones(tratamientos, estado)}
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

                

                let elemento = `<div class="card mb-3">
                                    <div class="card-body fs--2 p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="text-primary-veris fw-medium fs--1 mb-0">${capitalizarCadaPalabra(tratamientos.nombreServicio)}</h6>
                                            <span id="estado"><i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">Atendida</span></span>
                                        </div>
                                        <div>

                                        ${determinarFechasCaducadas(tratamientos, datosTratamiento)}
                                            
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <div class="avatar border rounded-circle bg-very-pale-red">
                                                <img class="rounded-circle" src="${quitarComillas(tratamientos.urlImagenTipoServicio)}" width="26" alt="receta medica">
                                            </div>
                                            <div class="d-flex">
                                                ${determinarCondicionesBotones(tratamientos, estado)}
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
                        <h7 class="text-primary-veris fw-bold mb-0">Consulta online</h7>
                    </div>
                    `;
        }
        else{
            return ``;
        }
    }

    // mostrar banner de promocion
    function mostrarBannerPromocion(datos){
        let params = {};
        params.codigoTratamiento = codigoTratamiento;
        params.convenio = ultimoTratamiento.datosConvenio;
        let ulrParams = btoa(JSON.stringify(params));

        let divContenedor = $('#cardPromocion');
        divContenedor.empty(); // Limpia el contenido actual
        let elemento = `<div class="card rounded-0 border-0">
                            <div class="card-body p-3 position-relative px-lg-5"
                                style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                                <h4 class="fw-medium text-white mb-0">Compra y gestiona</h4>
                                <h6 class=" fw-light text-white mb-0">tu <b>tratamiento</b> sin <b>filas</b></h6>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="/tu-tratamiento/${ulrParams}
                                    " class="btn btn-sm btn-primary-veris px-4">Ver tratamiento</a>
                                </div>
                            </div>
                            <div class="position-absolute end-7 bottom-40">
                                <img src="{{ asset('/assets/img/card/carrito_promocion.png') }}" class="img-fluid" width="96" alt="carrito_promocion" />
                            </div>
                        </div>`;
        divContenedor.append(elemento);
    }

    // determinar fechas caducadas
    function determinarFechasCaducadas(datos, datosTratamiento){ 

        let dataFechas = ``;
        
        if (Object.keys(datosTratamiento.datosConvenio).length > 0) {

            if (datos.estado == "PENDIENTE_AGENDAR") {
                    if (datos.esCaducado == "S") {
                        dataFechas = `<p class="fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                    } else {
                        dataFechas = `` ;
                    }
                
            }
            if (datos.estado == "AGENDADO" || datos.estado == "ATENDIDO") {

                dataFechas = `<h5 class="card-title text-primary mb-0">${capitalizarElemento(datos.nombreSucursal)}</h5>
                                <p class="fw-bold fs--2 mb-0">${capitalizarElemento(datos.fechaOrden)}</p>
                                <p class="fs--2 mb-0">Dr(a): ${capitalizarElemento(datos.nombreMedicoAtencion)}</p>
                                <p class="fs--2 mb-0">${datos.nombrePaciente}</p> `;
                
            }


        }
        else{
            if (datos.estado == "PENDIENTE_AGENDAR") {
                    if (datos.esCaducado == "S") {
                        dataFechas = `<p class="fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                    } else {
                        dataFechas = `` ;
                    }
                
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
         
        if(servicio.nombreServicio == "RECETA MÉDICA"){
            let servicioStr = JSON.stringify(servicio);
            return `<a href="" class="fs--2" data-bs-toggle="modal" data-bs-target="#recetaMedicaModal" data-rel='${servicioStr}'>¿Ya compraste esta receta?</a>`;
        }
        else{
            return ``;
        }
    }


    
    



    // determinar si es receta medica o no botones
    function determinarbotonesRecetaMedica(servicio, esAgendable, tipoServicio, aplicaSolicitud){
        console.log('esAgendable: ' + esAgendable);
    
        if(tipoServicio == "FARMACIA" && aplicaSolicitud == 'S'){
            // Código para RECETA MÉDICA
            return `<a href="#" class="btn text-primary-veris">Ver receta</a>
                    <a href="/farmacia-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris shadow-none me-1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (tipoServicio == "FARMACIA" && (aplicaSolicitud == 'N' || aplicaSolicitud == null)) {
            // Código para RECETA MÉDICA
            return `<a href="#" class="btn text-primary-veris">Ver receta</a>
                    <a href="/farmacia-domicilio/${codigoTratamiento}"  class="btn btn-sm btn-primary-veris disabled"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (tipoServicio == "LABORATORIO" && esAgendable == 'N') {
            // Código para LABORATORIO
            return `<a href="#" class="btn text-primary-veris">Ver receta</a>
                    <a href="/laboratorio-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris shadow-none me-1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else {
            // Código para otros servicios
            let botonAgendarClase = "btn btn-sm btn-primary-veris shadow-none me-1";
            let botonAgendarDisabled = "";

            // Si esAgendable no es 'S', deshabilitar el botón
            if(esAgendable !== 'S'){
                botonAgendarClase += " disabled";
                botonAgendarDisabled = " disabled";
            }

            return `<a href="#" class="btn text-primary-veris">Ver orden</a>
                    <a href="#" class="${botonAgendarClase}"${botonAgendarDisabled}> Agendar</a>`;
        }
    }


    // determinar si es receta medica o no botones realizados
    function determinarbotonesRecetaMedicaRealizados(servicio){
        if(servicio == "FARMACIA"){
            return `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">Ver receta</a> `;
                                            
        }
        else{
            
            return `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">Ver orden</a> `;
        }
    }


    // determinar condiciones de los botones 

    function determinarCondicionesBotones(datosServicio, estado){
        let services = datosServicio;
        if (datosServicio.length == 0) {
            return `<div></div>`;
        }
        else{

            switch (datosServicio.tipoCard) {
                case "AGENDA" :
                    let respuestaAgenda = "";
                    // Agregar ver orden 
                    respuestaAgenda += ` <a class="btn btn-sm text-primary-veris shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard" data-bs-toggle="modal" data-bs-target="#verOrdenModal">Ver orden</a>`;
                    

                    if(datosServicio.estado == 'PENDIENTE_AGENDAR'){


                        if(datosServicio.esCaducado == 'S'){
                            // mostrar boton de informacion que llama al modal de informacion
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none me-1 btn-informacion" data-bs-toggle="modal" data-bs-target="#informacionCitaModal" data-rel='${JSON.stringify(datosServicio)}'>Información</a>`;
                            
                        } else {

                            if(datosServicio.permiteReserva == 'S'){
                                if (datosServicio.habilitaBotonAgendar == 'S') {

                                    if(datosServicio.modalidad == 'PRESENCIAL'){
                                        
                                        let ruta = '/citas-elegir-central-medica/';
                                        let urlCompleta = ruta + "{{ $params }}"
                                        respuestaAgenda += `<a href="${urlCompleta}" class="btn btn-sm btn-primary-veris shadow-none btn-agendar" data-rel='${JSON.stringify(datosServicio)}'>Agendar</a>`;
                                        
                                         
                                    } else {
                                        
                                        let ruta = '/citas-elegir-fecha-doctor/';
                                        let urlCompleta = ruta + "{{ $params }}"
                                        // ir a fechas
                                        respuestaAgenda += `<a href="${urlCompleta}" class="btn btn-sm btn-primary-veris shadow-none btn-agendar" data-rel='${datosServicio}'>Agendar</a>`;
                                        
                                    }
                                } else {
                                    respuestaAgenda += `<a href="#" class="btn btn-sm  fw-normal fs--1 disabled" style="background-color: #F3F0F0 !important; color: darkgrey !important;">
                                                            
                                                            Agendar
                                                        </a>`;

                                }
                            } 
                            else{
                                // abrir modal no permite reserva
                                respuestaAgenda += `<div href="#" class="btn btn-sm btn-primary-veris shadow-none" data-bs-toggle="modal" data-bs-target="#mensajeNoPermiteReservaModal">Agendar</div>`;
                            }
   
                        }

                    }else if (datosServicio.estado == 'ATENDIDO'){

                        // mostrar boton de ver orden
                        respuestaAgenda = ``;
                        respuestaAgenda += ` <div class="btn btn-sm btn-primary-veris shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard" data-bs-toggle="modal" data-bs-target="#verOrdenModal"> Ver orden</div>`;  
                    

                    }else if (datosServicio.estado == 'AGENDADO'){
                        // mostrar boton de ver orden
                        respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">Ver orden</a>`;

                        if (datosServicio.permitePago == 'S'){
                            // mostrar boton de pagar
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">Pagar</a>`;
                        }  else if  (datosServicio.detalleReserva.habilitaBotonCambio == 'S'){
                            
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none">${datosServicio.detalleReserva.nombreBotonCambiar}</a>`;
                        } else if (datosServicio.esPagada == 'S' && datosServicio.detalleReserva.esPricing == 'S') {
                            // mostrar boton de informacion
                            respuestaAgenda += `<a href="#" class="btn btn-sm btn-primary-veris shadow-none" onclick="mostrarInformacion(${datosServicio.detalleReserva.mensajeInformacion})">Información</a>`;
                        } 
                    }

                    
                    return respuestaAgenda;
                    break;

                case "LAB":
                    console.log('estadossss', estado);
                    let respuesta = "";
                    if (estado == 'PENDIENTE'){
                        
                        respuesta += ` <a  class="btn btn-sm text-primary-veris shadow-none" data-rel='${JSON.stringify(datosServicio)}' id="verOrdenCard" data-bs-toggle="modal" data-bs-target="#verOrdenModal">Ver orden</a>`;


                        // condición para 'verResultados'
                        if (datosServicio.verResultados == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${codigoTratamiento}" class="btn btn-sm btn-veris m-2
                            "> Ver resultados</a>`;
                        } else {
                            respuesta += ``;
                        }

                        //condición para 'aplicaSolicitud'
                        if (datosServicio.aplicaSolicitud == "S") {
                            respuesta += `<a href="/laboratorio-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris shadow-none me-1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                        } else
                        if (datosServicio.permitePago == "S"){
                            let params = {}
                            params.idPaciente = idPaciente;
                            params.numeroOrden = datosServicio.idOrden;
                            params.codigoEmpresa = datosServicio.codigoEmpresa;
                            let ulrParams = btoa(JSON.stringify(params));
                            
                            respuesta += `<a href="/citas-laboratorio/{{$params}}" class="btn btn-sm btn-primary-veris shadow-none btn-Pagar" data-rel='${JSON.stringify(datosServicio)}'>Pagar</a>`;
                        }
                    } 

                    else if (estado == 'REALIZADO'){
                        console.log('estadossss2', estado);
                        respuesta = "";
                        respuesta += ` <div class="btn btn-sm btn-primary-veris shadow-none" id="verOrdenCard"
                        data-rel='${JSON.stringify(datosServicio)}'>Ver orden</div>`;
                    
                    }
                    

                    return respuesta;

                    break;

                case "RECETAS" :
                    if (estado == 'REALIZADO') {
                        return `<div class="btn btn-sm btn-primary-veris btnVerOrden" data-bs-toggle="offcanvas" 
                        data-bs-target="#detalleRecetaMedica" aria-controls="detalleRecetaMedica" data-rel='${JSON.stringify(datosServicio)}'>
                         Ver receta</div>`;
                    } else {
                        if(datosServicio.aplicaSolicitud == "S"){
                            return `<a href="/farmacia-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris shadow-none me-1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
                        }
                    }
                    
                    

                   

                    break;
                case "ODONTOLOGIA" :
                    let respuestaOdontologia = "";
                    respuestaOdontologia += ` <div  class="btn text-primary-veris fw-normal fs--1" data-rel='${JSON.stringify(datosServicio)}'>Ver orden</div>`;
                    
                    // ABRIRE MODAL DE VIDEO CONSULTA
                    respuestaOdontologia += `<div href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1" data-bs-toggle="modal" data-bs-target="#mensajeVideoConsultaModal"> Agendar</div>`;
                      
                    

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

    // boton ver orden
    $(document).on('click', '#verOrdenCard', function(){
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
        let datos = $(this).data('rel');
        console.log('datos', datos.mensaje);

        // pasar mensaje a modal
        $('#mensajeInformacionCita').text(datos.mensaje);


    });

    
    // boton ver pdf receta
    $(document).on('click', '.verPdfReceta', function(){
        let datos = $('#detalleRecetaMedica').attr('data-rel');
        console.log('datocdcds', datos);
        datos = JSON.parse(datos);

        obtenerRecetaPdf(datos);
    });

    // setear los valores del agendamiento en localstorage

    $(document).on('click', '.btn-agendar', function(){
        let datosServicio = $(this).data('rel');
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
        };
        dataCita.convenio = ultimoTratamiento.datosConvenio;

        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    });

    // boton btn-Pagar
    $(document).on('click', '.btn-Pagar', function(){
        let datosServicio = $(this).data('rel');
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
        };
        dataCita.convenio = ultimoTratamiento.datosConvenio;
        dataCita.datosTratamiento = datosServicio;

        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    });

    
</script>
@endpush