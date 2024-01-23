@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Revisa tus datos
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
$partesHora = explode(':', $data->horario->horaInicio);
$hora = (int)$partesHora[0];
// Determinar si es AM o PM
if ($hora >= 12) {
    $meridiano = "PM";
} else {
    $meridiano = "AM";
}

$medPayPlan = null;
if(isset($data->convenio->informacionExternaPlan)){
    $medPayPlan = $data->convenio->informacionExternaPlan;
}

@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Revisa tus datos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-grayish-blue p-2">
                        <h5 class="text-primary-veris fw-bold m-1">{{ __('Precio') }} </h5>
                    </div>
                    <div class="card-body p-2 my-3">
                        <div class="row gx-0 justify-content-evenly align-items-center box-precio">
                        </div>
                    </div>
                    {{-- <div class="card-footer d-flex justify-content-between border-top p-2" id="contentLinkPago">
                        <div class="mx-1">
                            <p class="fs--2 mb-0 fw-bold">{{ __('¿Alguien más pagará esta cita?') }}</p>
                            <p class="fs--2 mb-0">{{ __('Genera tu link de pago') }}</p>
                        </div>
                        <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 mx-1">{{ __('Enviar link') }}</a>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-grayish-blue p-2">
                        <h5 class="text-primary-veris fw-bold m-1">{{ __('Detalles de la cita') }}</h5>
                    </div>
                    <div class="card-body px-2">
                        <div class="mx-1 mt-3">
                            <p class="text-primary-veris fw-bold mb-0">{{ $data->especialidad->nombre }}</p>
                            <p class="fw-bold fs--1 mb-0">{{ isset($data->central) ? $data->central->nombreSucursal : 'VIRTUAL' }}</p>
                            <p class="fs--2 mb-0">{{ $data->horario->dia2 }} <b class="text-normal text-primary-veris fw-normal">{{ $data->horario->horaInicio }} {{ $meridiano }}</b></p>
                            <p class="fs--2 mb-0">Dr(a) {{ $data->horario->nombreMedico }}</p>
                            <p class="fs--2 mb-0">{{ $data->paciente->nombrePaciente }}</p>
                            <p class="fs--2 mb-0">{{ isset($data->convenio->nombreConvenio) ? $data->convenio->nombreConvenio : '' }}</p>
                        </div>
                    </div>
                    <div class="card-footer px-2 pb-2" id="msg-cita">
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-5">
                <a href="#" id="btn-pagar" class="btn btn-primary-veris d-none w-25 px-3 py-3">{{ __('Pagar') }}</a>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let dataCita = @json($data);
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPrecio();
    });

    // consultar grupo familiar
    async function obtenerPrecio() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/precio?canalOrigen=${canalOrigen}&tipoIdentificacion={{ $data->paciente->tipoIdentificacion}}&numeroIdentificacion={{ $data->paciente->numeroIdentificacion}}&codigoEspecialidad={{ $data->especialidad->codigoEspecialidad}}&secuenciaAfiliado={{ isset($data->convenio->secuenciaAfiliado) ? $data->convenio->secuenciaAfiliado : '' }}&codigoConvenio={{ isset($data->convenio->codigoConvenio) ? $data->convenio->codigoConvenio : '' }}&idIntervalos={{ $data->horario->idIntervalo }}&esOnline={{ $data->online }}&porcentajeDescuento={{ $data->horario->porcentajeDescuento }}`
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "fechaSeleccionada": "{{ $data->horario->dia2 }}",
            "idCliente": "{{ $data->convenio->idCliente }}",
            "estaPagada": "N",
            "esEmbarazada": "N",
            "medPayPlan": @JSON($medPayPlan)
        });
        const data = await call(args);
        
        if(data.code == 200){
            let { valor, porcentajeDescuento, valorCanalVirtual  } = data.data;
            let porcentajeDescuentoCopago = porcentajeDescuento;
            let subtotalCopago = valor;
            let valorTotalCopago = valorCanalVirtual;
            let params = @json($data);

            console.log(porcentajeDescuentoCopago,subtotalCopago,valorTotalCopago)
            let elem = ``;
            let descuentoLabel = ``;
            if(porcentajeDescuentoCopago > 0){
                descuentoLabel = `*Se aplicó un ${porcentajeDescuentoCopago}% de descuento por pago en app`;
            }

            if(params.convenio.codigoConvenio){
                elem += `<div class="col-5">
                    <div class="text-center">
                        @if(isset($data->convenio->rutaImagenConvenio))
                        <img src="{{ $data->convenio->rutaImagenConvenio }}" width="86" alt="">
                        @endif
                    </div>
                </div>
                <div class="col-5 text-end">`;
                if(porcentajeDescuentoCopago > 0){
                    `<p class="text-danger fs--3 mb-0" id="content-precioBase">Precio normal 
                        <del id="precioBase">$${valor}</del>
                    </p>`;
                }
                elem += `<h3 class="text-primary-veris fw-bold mb-0" id="precioTotal">$${valorTotalCopago}</h3>
                </div>
                <p class="text-center text-primary-veris fs--2 mb-0" id="infoDescuento"></p>`;
            }else{
                elem += `<div class="col-12 text-center">`
                if(porcentajeDescuentoCopago > 0){
                    `<p class="text-danger fs--3 mb-0" id="content-precioBase">Precio normal 
                        <del id="precioBase">$${valor}</del>
                    </p>`;
                }
                elem += `<h3 class="text-primary-veris fw-bold mb-0" id="precioTotal">$${valorTotalCopago}</h3>
                </div>
                <p class="text-center text-primary-veris fs--2 mb-0" id="infoDescuento"></p>`;
            }


            $('.box-precio').html(elem);

            let elemMsg = ``;

            if({{ $data->horario->porcentajeDescuento }} == 0 && "{{ $data->convenio->permiteReserva }}" == "S" && "{{ $data->convenio->permitePago }}" == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top py-3">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Puedes <b>reagendar</b> tu cita las veces que necesites.</p>
                    </div>`;
            }
            if({{ $data->horario->porcentajeDescuento }} > 0 && "{{ $data->convenio->permitePago }}" == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top py-3">
                        <i class="bi bi-info-circle-fill h4 mb-0 mx-3 text-warning"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.</p>
                    </div>`;
            }
            if("{{ $data->online }}" == "S"){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top py-3">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Recuerda que para poder conectarte a tu cita <b>debes pagarla en los próximos 30 minutos</b>.</p>
                    </div>`;
            }
            if("{{ $data->convenio->permitePago }}" == "N"){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top py-3">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage"><b>Recuerda</b> llegar <b>20 minutos antes</b> de la cita y acercarte a caja para realizar el pago.</p>
                    </div>`;
            }
            $('#msg-cita').append(elemMsg)
            
            params.precio = data.data;
            dataCita.precio = data.data;
            await reservarCita();
            /*let urlParams = btoa(JSON.stringify(params));
            $('#btn-pagar').attr('href','/citas-datos-facturacion/'+urlParams);
            $('#btn-pagar').removeClass('d-none');*/
        }
        return data;
    }

    async function reservarCita(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/reservar?canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        let datosReserva = {
            "numeroIdentificacion": dataCita.paciente.numeroIdentificacion,
            "tipoIdentificacion": dataCita.paciente.tipoIdentificacion,
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
            "permitePago": "S",
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
            "estaPagada": "N"
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
            /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
            datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
            datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
            datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
        }

        args["data"] = JSON.stringify(datosReserva);
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.reserva = data.data;
            if(data.data.permitePago == "S"){
                let urlParams = btoa(JSON.stringify(params));
                $('#btn-pagar').attr('href','/citas-datos-facturacion/'+urlParams.replace(/\//g, '|'));
                $('#btn-pagar').removeClass('d-none');
            }else{
                let urlParams = btoa(JSON.stringify(params));
                $('#btn-pagar').attr('href','/cita-agendada/'+urlParams.replace(/\//g, '|'));
                $('#btn-pagar').removeClass('d-none');
            }
        }else{
            alert(data.message);
        }
    }
</script>
@endpush