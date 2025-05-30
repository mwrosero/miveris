@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Agendamiento múltiple
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp

<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>

<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Agendar') }}</h5>
    </div>
    <section class="p-0 px-md-3"></section>

    <section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-3">
                    <div class="row justify-content-center mb-3" id="listado-detalles-por-agendar">
                        <div class="col-12 mt-3">
                            {{-- Puedes agendar hasta <span class="maxQty"></span> terapias a la vez --}}
                        </div>
                        {{-- <div class="col-12 my-2">
                            <div class="w-100 d-flex justify-content-between align-items-center border-bottom py-3 px-2">
                                <div class="form-check d-flex justify-content-start align-items-center">
                                    <input class="form-check-input atencionInmediata-input me-2 mb-1 width-24" type="checkbox" value="" id="item" required>
                                    <label class="text-primary-veris form-check-label fs--1 line-height-16" for="item">
                                        Terapía física 1
                                    </label>
                                </div>
                                <div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                                    <i class="fa-regular fa-calendar-check me-2"></i>
                                    Disponible
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row g-3 justify-content-center" id="listado-detalles"></div>
                    {{-- <div class="card h-100">
                        <div class="card-body p--2 d-flex justify-content-between align-items-center">
                            <div class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line m-0">Urea</div>
                            <div class="label-status-detalle fs--2 line-height-16 m-0">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                Disponible
                            </div>
                        </div>
                    </div> --}}
                    <div class="row justify-content-center">
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5 waves-effect btn-agendar waves-light d-none" disabled>Agendar</a>
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
    let tiposAgendaPermitida = ["TERAPIA_FISICA"];
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let mensajeBloqueoReserva = ``;
    tipoFlujo = dataCita.tipoFlujo;
    let classEsOrdenTratamiento = ``;
    document.addEventListener("DOMContentLoaded", async function () {
        if(!dataCita.hasOwnProperty('secuenciaAtencion')){
            classEsOrdenTratamiento = `d-none`;
        }
        if(dataCita.hasOwnProperty('detalle_agendamiento_multiple_atendido')){
            await drawDetallesAtendidos();
        }else{
            $('.btn-agendar').removeClass('d-none')
            await drawDetalles();
        }

        $(".atencionInmediata-input").on("change", function() {
            let maxSeleccionados = dataCita.cantidadMaximaAgenda;
            let seleccionados = $(".atencionInmediata-input:checked").length;

            if(seleccionados > 0){
                $('.btn-agendar').prop("disabled", false);
            }else{
                $('.btn-agendar').prop("disabled", true);
            }

            if (seleccionados >= maxSeleccionados) {
                $(".atencionInmediata-input:not(:checked)").prop("disabled", true);
                {{-- showMessage('warning','Atención','Solo puedes agendar hasta '+dataCita.cantidadMaximaAgenda+' terapias a la vez') --}}
                // $('.btn-agendar').prop("disabled", true);
                //$(".atencionInmediata-input").prop("disabled", true);
            } else {
                $(".atencionInmediata-input").prop("disabled", false);
            }
        });

        $(document).on('click', '.verOrdenCard', function(){
            let datos = $(this).data('rel');
            descargarDocumentoPdf(datos);
        });

        $('body').on('click', '.btn-informacion', async function(){
            dataCita.origen = "paquetes";
            dataCita.online = dataCita.promocion.esOnline;
            dataCita.especialidad = {
                codigoEspecialidad: dataCita.promocion.codigoEspecialidad,
                codigoPrestacion: dataCita.promocion.codigoPrestacion,
                codigoServicio: dataCita.promocion.codigoServicio,
                //codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                esOnline: dataCita.promocion.esOnline,
                nombre: dataCita.promocion.nombreEspecialidad
            }
            dataCita.convenio = {
                "permitePago": "S",
                "permiteReserva": "S",
                "idCliente": null,
                "codigoConvenio": null,
                "secuenciaAfiliado" : null,
            };
            let url = '/detalle/item/preparacion-previa/';
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        })

        $('body').on('click', '.btn-agendar', async function(){
            let items = await obtenerDataRelSeleccionados();
            let permiteReserva = await vaidarSiPuedeReservar(items)
            // let detalle = JSON.parse($(this).attr('data-rel'));
            if(!permiteReserva){
                $('#mensajeNoPermiteCambiar').html(mensajeBloqueoReserva);
                $('#modalPermiteCambiar').modal('show');
                return;
            }
            dataCita.items = items;
            dataCita.position = 0;
            dataCita.esEdicion = false;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            window.location.href = `/seleccionar-datos-cita/{{ $tokenCita }}`;
        })

        $('body').on('click', '.btn-pagar', function(){
            let datosServicio = JSON.parse($(this).attr('data-rel'));
            let convenio = dataCita.convenio;

            if(datosServicio.esPagada && datosServicio.tipoCard == "LAB" && datosServicio.modalidad == "PRESENCIAL"){
                $('#mensajeNoPermiteCambiar').html(datosServicio.mensaje);
                $('#modalPermiteCambiar').modal('show');
                return;
            }

            if(datosServicio.permitePago == "N" && datosServicio.tipoCard != "LAB"){
                $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoPago);
                console.log(datosServicio.mensajeBloqueoPago)
                $('#modalPermiteCambiar').modal('show');
                return;
            }else if(datosServicio.tipoCard == "LAB" && datosServicio.modalidad == "PRESENCIAL" && datosServicio.permitePago == "N"){
                $('#mensajeNoPermiteCambiar').html(datosServicio.mensajeBloqueoPago);
                console.log(datosServicio.mensajeBloqueoPago)
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
            let tipoServicio = datosServicio.tipoServicio.toLowerCase();
            dataCita.tipoFlujo = "agenda/tratamiento/"+tipoServicio;
            tipoFlujo = dataCita.tipoFlujo;

            dataCita.especialidad = {
                codigoEspecialidad: datosServicio.codigoEspecialidad,
                nombre : datosServicio.nombreEspecialidad,
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

            dataCita.pagoAgendamientoMultiple = {
                "codigoReserva": datosServicio.detalleReserva.codigoReserva
            }

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            url = '/citas-datos-facturacion/';
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        });

        $('body').on('click', '.btn-CambiarFechaCita', async function(){
            let data = JSON.parse($(this).attr('data-rel'));
            let convenio = dataCita.convenio;
            console.log(data);

            if(data.permiteReserva == "N" && data.esPagada != "S"){
                $('#mensajeNoPermiteCambiar').html(data.mensajeBloqueoReserva);
                $('#modalPermiteCambiar').modal('show');
                return;
            }

            // const dataConvenio = await consultarConvenios(data);
            // const dataPaciente = await consultarDatosPaciente(data);
            let esVirtual = "N";
            if(data.modalidad != "PRESENCIAL"){
                esVirtual = "S";
            }
            
            let params = {}
            let tipoServicio;
            
            if(data.hasOwnProperty('itemPaquete')){
                tipoFlujo = "reagenda/paquetes/terapia";
            }else{
                tipoServicio = data.tipoServicio.toLowerCase();
                tipoFlujo = "reagenda/tratamiento/"+tipoServicio;
            }
            params.tipoFlujo = tipoFlujo;;
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
                "numeroPaciente": data.pacPacNumero
            }
            params.central = {
                "codigoSucursal": data.detalleReserva.codigoSucursal,
                "nombreSucursal": data.detalleReserva.nombreSucursal
            }
            params.ciudad = {
                "codigoPais": data.idPais,
                "codigoProvincia": data.idProvincia,
                "codigoCiudad": data.idCiudad
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

            if(data.hasOwnProperty('itemPaquete')){
                params.especialidad = dataCita.especialidad;
                params.paciente = dataCita.paciente;
                params.online = dataCita.online;
                params.reservaEdit = {
                    "estaPagada": "S",
                    "numeroOrden": (data.numeroOrden) ? data.numeroOrden : data.idOrden,
                    "lineaDetalleOrden": data.lineaDetalleOrden,
                    "codigoEmpresaOrden": (data.codigoEmpresaOrden) ? data.codigoEmpresaOrden : data.codigoEmpresa,
                    "idOrdenAgendable": data.idOrdenAgendable,
                    "idCita": data.detalleReserva.codigoReserva
                }
                params.ciudad = {
                    "codigoPais": data.detalleReserva.idPais,
                    "codigoProvincia": data.detalleReserva.idProvincia,
                    "codigoCiudad": data.detalleReserva.idCiudad
                }
            }

            {{-- console.log(params);return; --}}
            
            let url = '/seleccionar-datos-cita/';
            if(params.online == "S"){
                url = '/citas-elegir-fecha-doctor/';
            }
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(params));
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        })
    })

    async function vaidarSiPuedeReservar(items){
        let puede = true;
        $.each(items, function(key, value){
          if(value.permiteReserva == "N"){
                mensajeBloqueoReserva = value.mensajeBloqueoReserva;
                puede = false;
            }
        })
        return puede;
    }

    async function obtenerDataRelSeleccionados() {
        let seleccionados = $(".atencionInmediata-input:checked").map(function() {
            return JSON.parse($(this).attr("data-rel")); // Obtiene el atributo data-rel como objeto
        }).get(); // Convierte el resultado en un array

        return seleccionados;
    }

    async function drawDetallesAtendidos(){
        $('.btn-agendar').addClass('d-none')
        let elem = ``;
        $.each(dataCita.detallesServicios, function(key, value){
            if(dataCita.paciente.nombrePaciente){
                nombrePaciente = dataCita.paciente.nombrePaciente;
            }else{
                nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
            }
            elem += `<div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body p--2">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1">${capitalizarElemento(value.nombreDetalle)}</h6>
                            <div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                                <i class="fa-solid fa-check me-2 text-success"></i>
                                <span class="text-success">Atendida</span>
                            </div>
                        </div>
                        <h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.nombreSucursal)}</h6>
                        <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${value.detalleReserva.horaReserva}</b></p>
                        <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(value.detalleReserva.nombreMedicoReserva)}</p>
                        <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(nombrePaciente)}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="avatar-sm me-2">
                                <img src="${quitarComillas(value.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                            </div>
                            <a class="btn btn-sm btn-primary-veris fw-medium verOrdenCard ${classEsOrdenTratamiento} fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(value)}'>Ver orden</a>
                        </div>
                    </div>
                </div>
            </div>`;
            $('#listado-detalles-por-agendar').html(elem);
        })
    }

    async function drawDetalles(){
        let showResultados = false;
        let elem = ``;
        let tienePorAgendar = false;
        $.each(dataCita.detallesServicios, function(key, value){
            let tipoAgenda = value.tipoAgenda;
            let estado = ``;
            if(value.estado == "Atendida"){
                showResultados = true;
            }
            if(value.detalleReserva === null){
                tienePorAgendar = true;
            }
            //if(value.estado == "Atendida" && dataCita.promocion.tipoServicio != "LABORATORIO"){
            {{-- console.log(value.estado) --}}
            if((value.estado == "Atendida" || value.estado == "Agendada")){
                let btnReagendar = ``;
                if(value.estado == "Agendada"){
                    btnReagendar += `<div>
                        ${ drawBtnCardItem(value) }
                    </div>`
                }
                if(dataCita.paciente.nombrePaciente){
                    nombrePaciente = dataCita.paciente.nombrePaciente;
                }else{
                    nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
                }

                console.log(value)
                let estadoReserva = `<span class="fs--2 line-height-16 mb-1 text-end" style="min-width: 90px;">
                        <i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprado</span>
                    </span>`

                if(value.hasOwnProperty('itemPaquete')){
                    estadoReserva = `<span class="fs--2 line-height-16 mb-1 text-end" style="min-width: 90px;">
                        <i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Agendado</span>
                    </span>`
                }

                if(value.estado == "Atendida"){
                    estadoReserva = `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-solid fa-check me-2 text-success"></i>
                            <span class="text-success">Atendida</span>
                        </div>`;
                    btnReagendar = `<a class="btn btn-sm btn-primary-veris verOrdenCard ${classEsOrdenTratamiento} fw-medium fs--1 line-height-16 px-3 py-2 shadow-none" data-rel='${JSON.stringify(value)}'>Ver orden</a>`;
                }
                
                if(value.esPagada == "N"){
                    estadoReserva = `<span class="fs--2 line-height-16 mb-1 text-end" style="min-width: 90px;">
                        <i class="fa-solid fa-circle me-2 text-warning-veris"></i><span class="text-warning-veris">Por comprar</span>
                    </span>`
                }

                let urlAvatar = value.urlImagenTipoServicio;
                let caducidadAgendamiento = ``;
                if(!dataCita.hasOwnProperty('promocion')){
                    caducidadAgendamiento = determinarFechaCaducidadEncabezadoAgendamientoMultiple(value, dataCita.datosTratamiento)

                }else{
                    urlAvatar = dataCita.promocion.urlImagenTipoServicio
                }

                elem += `<div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body p--2">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1">${capitalizarElemento(value.nombreDetalle)}</h6>
                                ${ estadoReserva }
                            </div>
                            ${caducidadAgendamiento}
                            <h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.nombreSucursal)}</h6>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${value.detalleReserva.horaReserva}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(value.detalleReserva.nombreMedicoReserva)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(nombrePaciente)}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-sm me-2">
                                    <img src="${quitarComillas(urlAvatar)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                </div>
                                ${btnReagendar}
                            </div>
                        </div>
                    </div>
                </div>`;
            }else{
                if(value.estado == "Disponible"){
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-regular fa-calendar-check me-2"></i>
                            Disponible
                        </div>`;
                }else if(value.estado == "Caducado"){
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <img src="{{asset('assets/img/svg/fa-diamond-exclamation.svg')}}" />
                            <span style="color: #D84315;">Caducado</span>
                        </div>`;
                }else{
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-solid fa-check me-2 text-success"></i>
                            <span class="text-success">Atendida</span>
                        </div>`;
                }
                if(value.detalleReserva !== null){
                    elem += `<div class="col-12 mt-3">
                        <div class="card h-100" style="box-shadow: 0px 4px 8px 0px #0000001A;">
                            <div class="card-body p--2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 m-0">
                                        ${value.nombreDetalle}
                                    </div>
                                    ${estado}
                                </div>`;
                            if(tiposAgendaPermitida.includes(tipoAgenda)){
                                elem += `<div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="avatar-sm me-2">
                                        <img src="${quitarComillas(value.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                    </div>
                                    <div>
                                        ${ drawBtnCardItem(value) }
                                    </div>
                                </div>`;
                            }
                            elem += `</div>
                        </div>
                    </div>`;
                }
            }
        })
        
        $('#listado-detalles').html(elem);
            
        let elemMultiple = ``;
        if(tienePorAgendar){
            elemMultiple = `<div class="col-12 mt-3">
                Puedes agendar hasta ${dataCita.cantidadMaximaAgenda} terapias a la vez
            </div>`;
        }
        $.each(dataCita.detallesServicios, function(key, value){
            if(value.detalleReserva === null){
                let iconStatusTiempo = `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-regular fa-calendar-check me-2"></i>
                            Disponible
                        </div>`;
                if(value.esCaducado == "S"){
                    iconStatusTiempo = `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end text-danger fw-medium">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            Caducado
                        </div>`;
                }
                let identifier = (dataCita.hasOwnProperty('secuenciaAtencion')) ? value.lineaDetalleTratamiento : key;
                elemMultiple += `<div class="col-12 my-1">
                    <div class="w-100 d-flex justify-content-between align-items-center border-bottom py-3 px-2">
                        <div class="form-check d-flex justify-content-start align-items-center">
                            <input class="form-check-input atencionInmediata-input me-2 mb-1 width-24" type="checkbox" value="" id="item-${identifier}" data-rel='${JSON.stringify(value)}'>
                            <label class="text-primary-veris form-check-label fs--1 line-height-16 text-capitalize" for="item-${identifier}">
                                ${value.nombreServicio.toLowerCase()}
                            </label>
                        </div>
                        ${iconStatusTiempo}
                    </div>
                </div>`
            }
        })
        $('#listado-detalles-por-agendar').html(elemMultiple);
    }

    function drawBtnCardItem(detalles){
        console.log(detalles);
        {{-- console.log(999); --}}
        if(detalles.estado == "Caducado" || (detalles.hasOwnProperty('esAgendable') && !detalles.esAgendable && !detalles.hasOwnProperty('detalleReserva') && detalles.detalleReserva != null)){
            return ``;
        }
        // "tipoAgenda": "CONSULTA_MEDICA"  o "TERAPIAS"
        // esAgendable:True
        // si el detalle tiene estado Disponible
        // y detalleReserva==null
        let tipoAgenda = detalles.tipoAgenda;
        let titleBtn = `Agendar`;
        let btnEnviaAgendarClass = `btn-agendar`;
        if(tiposAgendaPermitida.includes(tipoAgenda) && detalles.estado == "Agendada" && detalles.detalleReserva != null && detalles.detalleReserva.habilitaBotonCambio == "S"){
            if(detalles.detalleReserva != null){
                titleBtn = `${detalles.detalleReserva.nombreBotonCambiar}`;
                btnEnviaAgendarClass = `btn-CambiarFechaCita`;
            }
        }

        if(detalles.hasOwnProperty('itemPaquete')){
            return `<div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-CambiarFechaCita" data-rel='${JSON.stringify(detalles)}'>
                    ${detalles.detalleReserva.nombreBotonCambiar}
                </div>`
        }

        if(detalles.esPagada == "S"){
            let btnOrden = `<a class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard ${classEsOrdenTratamiento} me-2" data-rel='${JSON.stringify(detalles)}'>Ver orden</a>`;

            return `${btnOrden} <div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none ${btnEnviaAgendarClass}" data-rel='${JSON.stringify(detalles)}'>
                    ${titleBtn}
                </div>`;
        }else{
            let btnPagar = `<a class="btn btn-sm btn-primary-veris fw-medium fs--1 px-3 py-2 border-0 text-white shadow-none btn-pagar me-2" data-rel='${JSON.stringify(detalles)}'>Pagar</a>`;

            return `<div class="btn btn-sm fw-normal text-primary-veris fs--1 line-height-16 px-3 py-2 shadow-none ${btnEnviaAgendarClass}" data-rel='${JSON.stringify(detalles)}'>
                    ${titleBtn}
                </div> ${btnPagar}`;
        }
    }

    async function descargarDocumentoPdf(datos){

        let datosFiltrados = datos;
        console.log('datosFiltrados', datosFiltrados);
        let args = [];
        let canalOrigen = 'APP_CMV'
        let secuenciaAtencion = dataCita.secuenciaAtencion;
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
</script>
<style>
    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal) .layout-page:before{
        display: none;
    }
</style>
@endpush