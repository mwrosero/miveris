@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Revisa tus datos
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
// $partesHora = explode(':', $data->horario->horaInicio);
// $hora = (int)$partesHora[0];
// // Determinar si es AM o PM
// if ($hora >= 12) {
//     $meridiano = "PM";
// } else {
//     $meridiano = "AM";
// }

// $medPayPlan = null;
// if(isset($data->convenio->informacionExternaPlan)){
//     $medPayPlan = $data->convenio->informacionExternaPlan;
// }

@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Revisa tus datos') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-grayish-blue p--2">
                        <h5 class="text-veris-many fw-medium line-height-16 m-0">{{ __('Precio') }} </h5>
                    </div>
                    <div class="card-body py-2 px-0">
                        <div class="row gx-0 justify-content-center align-items-center box-precio">
                        </div>
                    </div>
                    {{-- <div class="card-footer d-flex justify-content-between border-top p--2" id="contentLinkPago">
                        <div class="mx-1">
                            <p class="fs--2 line-height-16 mb-0 fw-medium">{{ __('¿Alguien más pagará esta cita?') }}</p>
                            <p class="fs--2 line-height-16 mb-0">{{ __('Genera tu link de pago') }}</p>
                        </div>
                        <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 line-height-16 ms-3 px-3 py-2">{{ __('Enviar link') }}</a>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-grayish-blue p--2">
                        <h5 class="text-veris-many fw-medium line-height-16 m-0">{{ __('Detalles de la cita') }}</h5>
                    </div>
                    <div class="card-body p--2">
                        <div class="" id="contentDetalleCita">
                            {{-- <p class="text-primary-veris fw-medium mb-0" id="nombreEspecialidad"></p>
                            <p class="fw-medium fs--1 mb-0">{{ isset($data->central) ? $data->central->nombreSucursal : 'VIRTUAL' }}</p>
                            <p class="fs--2 mb-0">{{ $data->horario->dia2 }} <b class="text-normal text-primary-veris fw-normal">{{ $data->horario->horaInicio }} {{ $meridiano }}</b></p>
                            <p class="fs--2 mb-0">Dr(a) {{ $data->horario->nombreMedico }}</p>
                            <p class="fs--2 mb-0">{{ $data->paciente->nombrePaciente }}</p>
                            <p class="fs--2 mb-0">{{ isset($data->convenio->nombreConvenio) ? $data->convenio->nombreConvenio : '' }}</p> --}}
                        </div>
                    </div>
                    <div class="card-footer pt-0 p--2" id="msg-cita">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 text-center mt-5">
                {{-- <a href="#" id="btn-pagar" class="btn btn-lg btn-primary-veris d-none w-100">{{ __('Pagar') }}</a> --}}
                <button id="btn-pagar" class="btn btn-lg btn-primary-veris d-none w-100 px-4 py-3 fs-5">{{ __('Pagar') }}</button>
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
    let online = dataCita?.online;
    let nombreEspecialidad = capitalizarCadaPalabra(dataCita.especialidad.nombre);
    var tipoIdentificacion = parseInt(dataCita.paciente.tipoIdentificacion);
    if (isNaN(tipoIdentificacion)) {
        tipoIdentificacion = parseInt(dataCita.paciente.codigoTipoIdentificacion);
    }
    // let tipoIdentificacion = dataCita.paciente.tipoIdentificacion;
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
        await obtenerPrecio();
        llenarDataDetallesCitas();

        if(dataCita.reserva){
            eliminarReserva();
        }

        $('body').on('click', '#btn-pagar', function () {
            reservarCita();
        });
    });

    async function eliminarReserva(){
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/eliminarReserva?codigoReserva=${dataCita.reserva.codigoReserva}`
        args["method"] = "PUT";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        const data = await call(args);

        //Menos para edictar reserva 
        if(data.code == 200){
            delete dataCita.reserva;
            guardarData();
        }

    }

    // llenar los datos en contentDetalleCita con los datos de dataCita
    function llenarDataDetallesCitas(){
        let elem = `<p class="text-primary-veris fs--16 line-height-20 fw-medium mb-1"  id="nombreEspecialidad">${capitalizarCadaPalabra(nombreEspecialidad)}</p>`;
        if(dataCita.online == "N"){    
            elem += `<p class="fw-medium fs--1 line-height-16 mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal)}</p>`;
        }
        let nombrePaciente;
        if(dataCita.paciente.nombrePaciente){
            nombrePaciente = dataCita.paciente.nombrePaciente;
        }else{
            nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
        }
        elem += `<p class="fs--2 line-height-16 mb-1">${dataCita.horario.dia} <b class="text-normal text-primary-veris fw-normal">${dataCita.horario.horaInicio} - ${dataCita.horario.horaFin} ${determinarMeridiano(horaInicio)}</b></p>
            <p class="fs--2 line-height-16 mb-1 text-capitalize">Dr(a) ${dataCita.horario.nombreMedico.toLowerCase()}</p>
            <p class="fs--2 line-height-16 mb-1 text-capitalize">${nombrePaciente.toLowerCase()}</p>`;
        if(dataCita.convenio.codigoConvenio){
            elem += `<p class="fs--2 line-height-16 mb-1 text-capitalize">${dataCita.convenio.nombreConvenio.toLowerCase()}</p>`
        }
        $('#contentDetalleCita').html(elem);

        if(dataCita.convenio.codigoConvenio){
            $('#contentLinkPago').removeClass('d-none');
        }

    }

    // determinar si es PM o AM segun horaInicio
    function determinarMeridiano(horaInicio){
        let partesHora = horaInicio.split(':');
        let hora = parseInt(partesHora[0]);
        let meridiano = "AM";
        if (hora >= 12) {
            meridiano = "PM";
        }
        return meridiano;
    }

    // consultar grupo familiar
    async function obtenerPrecio() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoReserva = ''; 
        let numeroOrden = ''; 
        let codigoEmpOrden = '';
        let lineaDetalle = '';
        let aplicaCredito = 'N';
        let aplicaProntoPago = 'S';

        if(dataCita.horario.porcentajeDescuento > 0){
            aplicaCredito = "S";
        }

        if(dataCita.convenio.aplicaProntoPago){
            aplicaProntoPago = dataCita.convenio.aplicaProntoPago;
        }

        if(dataCita.reservaEdit){
            codigoReserva = dataCita.reservaEdit.idCita;
            numeroOrden = dataCita.reservaEdit.numeroOrden;
            codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden;
            lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden;
        }
        if(dataCita.tratamiento){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
            
        }

        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";

        args["endpoint"] = api_url + `/digitalestest/v1/agenda/precio?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&idIntervalos=${dataCita.horario.idIntervalo}&permitePago=${permitePago}&codigoConvenio=${codigoConvenio}&esOnline=${dataCita.online}&porcentajeDescuento=${dataCita.horario.porcentajeDescuento}&aplicaProntoPago=${aplicaProntoPago}&codigoPrestacion=${dataCita.especialidad.codigoPrestacion}&codigoServicio=${dataCita.especialidad.codigoServicio}&codigoReserva=${codigoReserva}&secuenciaAfiliado=${secuenciaAfiliado}&aplicaCredito=${aplicaCredito}&codigoReserva=${codigoReserva}&numeroOrden=${numeroOrden}&codEmpOrden=${codigoEmpOrden}&lineaDetalle=${lineaDetalle}`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "fechaSeleccionada": dia2,
            "idCliente": idCliente,
            "estaPagada": (dataCita.reservaEdit) ? dataCita.reservaEdit.estaPagada : 'N',
            "esEmbarazada": "N",
            "medPayPlan": medPayPlan
        });
        const data = await call(args);
        
        if(data.code == 200){
            let { valor, porcentajeDescuento, valorCanalVirtual  } = data.data;
            var porcentajeDescuentoCopago = porcentajeDescuento;
            var subtotalCopago = valor;
            var valorTotalCopago = valorCanalVirtual;
            var subtotalCopagoFloat = parseFloat(valor);
            var valorTotalCopagoFloat = parseFloat(valorCanalVirtual);
            let params = {};

            let elem = ``;
            let descuentoLabel = ``;
            let classNone = 'd-none';
            if(porcentajeDescuentoCopago > 0){
                classNone = '';
                descuentoLabel = `*Se aplicó un ${porcentajeDescuentoCopago}% ${data.data.mensajeDescuento}`;
            }

            if(codigoConvenio){
                console.log('subTotal', subtotalCopagoFloat, 'valorTotal', valorTotalCopagoFloat);
                elem += `<div class="col-3 text-center">
                            <img src="${rutaImagenConvenio}" alt="" class="img-fluid" width="86" height="">
                        </div>
                        <div class="col-5 text-center">`;

                if(subtotalCopagoFloat > valorTotalCopagoFloat){
                elem +=     `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                                <del class="fs--2 line-height-16" id="precioBase">$${valor.toFixed(2)}</del>
                            </p>`;
                }
                        elem += `<h1 class="text-primary-veris fw-medium fs--36 line-height-44 mb-0" id="precioTotal" style="white-space: nowrap;">$${valorTotalCopago.toFixed(2)}</h1>
                        </div>
                        <p class="text-center text-primary-veris fw-medium fs--2 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }else{
                elem += `<div class="col-12 text-center">`
                if(porcentajeDescuentoCopago > 0){
                    elem += `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                        <del class="fs--2 line-height-16" id="precioBase">$${valor.toFixed(2)}</del>
                    </p>`;
                }
                elem += `<h1 class="text-primary-veris fw-medium fs--36 line-height-44 mb-0" id="precioTotal">$${valorTotalCopago.toFixed(2)}</h1>
                </div>
                <p class="text-center text-primary-veris fw-medium fs--2 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }


            $('.box-precio').html(elem);

            let elemMsg = ``;

            if(porcentajeDescuentos == 0 && permiteReserva == "S" && permitePago == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Puedes <b>reagendar</b> tu cita las veces que necesites.</p>
                    </div>`;
            }
            //Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.
            if(porcentajeDescuentos > 0 && permitePago == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-warning fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage style="color: #0A2240;">${data.data.mensajeAlerta}</p>
                    </div>`;
            }
            if(online == "S"){
                if(dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") {
                    elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                            <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                            <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Recuerda que para poder conectarte a tu cita <b>debes pagarla en los próximos 30 minutos</b>.</p>
                        </div>`;
                }
            }
            if(permitePago == "N"){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;"><b>Recuerda</b> llegar <b>20 minutos antes</b> de la cita y acercarte a caja para realizar el pago.</p>
                    </div>`;
            }
            $('#msg-cita').append(elemMsg)
            
            dataCita.precio = data.data;
            //let urlParams = btoa(JSON.stringify(params));
            if (dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") {
                $('#btn-pagar').attr('href','/citas-datos-facturacion/{{ $params }}');
            }else{
                $('#btn-pagar').html('Continuar');
                $('#btn-pagar').attr('href','/cita-agendada/{{ $params }}');
            }
            $('#btn-pagar').removeClass('d-none');
        }
        return data;
    }

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
            //"tipoProcesoVUA": "",
            /*precio*/
            "valorizacion": dataCita.precio.valorCanalVirtual,
            /*precio o reagendamiento*/
            "secuenciaTransaccion": dataCita.precio.secuenciaTransaccion,
            "valorCita": dataCita.precio.valorCanalVirtual,
            "valorDescuento": dataCita.precio.valorDescuento,
            "valorSubtotalCita": dataCita.precio.valor,
            "numeroAutorizacion": dataCita.precio.numeroAutorizacion,
            "esEmbarazada": "N",            
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
            if(data.data.permitePago == "S"){
                guardarData();
                location.href = '/citas-datos-facturacion/{{ $params }}';
            }else{
                location.href = '/cita-agendada/{{ $params }}';
            }
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