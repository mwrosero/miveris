@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Revisa tus datos
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode($params)));
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
if(isset($data->convenio)){
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
                        <div class="row gx-0 justify-content-evenly align-items-center">
                            <div class="col-5">
                                <div class="text-center">
                                    @if(isset($data->convenio) && $data->convenio->rutaImagenConvenio)
                                    <img src="{{ $data->convenio->rutaImagenConvenio }}" width="86" alt="$data->convenio->nombreConvenio">
                                    @endif
                                </div>
                            </div>
                            <div class="col-5 text-end box-precio">
                                
                            </div>
                            <p class="text-center text-primary-veris fs--2 mb-0" id="infoDescuento">{{-- __('*Se aplicó un 5% de descuento por pago en app') --}}</p>
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
                            <p class="fs--2 mb-0">{{ isset($data->convenio) ? $data->convenio->nombreConvenio : '' }}</p>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-start align-items-center border-top py-3 px-2">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Puedes <b>reagendar</b> tu cita las veces que necesites.</p>
                    </div>
                    <div class="card-footer d-flex justify-content-start align-items-center border-top py-3 px-2">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.</p>
                    </div>
                    <div class="card-footer d-flex justify-content-start align-items-center border-top py-3 px-2">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage">Recuerda que para poder conectarte a tu cita <b>debes pagarla en los próximos 30 minutos</b>.</p>
                    </div>
                    <div class="card-footer d-flex justify-content-start align-items-center border-top py-3 px-2">
                        <i class="bi bi-info-circle-fill text-primary-veris h4 mb-0 mx-3"></i>
                        <p class="fs--1 lh-1 mb-0" id="infoMessage"><b>Recuerda</b> llegar <b>20 minutos antes</b> de la cita y acercarte a caja para realizar el pago.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-5">
                <a href="{{route('citas.datosFacturacion')}}" class="btn btn-primary-veris w-25 px-3 py-3">{{ __('Pagar') }}</a>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPrecio();
    });

    // consultar grupo familiar
    async function obtenerPrecio() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/precio?canalOrigen=${canalOrigen}&tipoIdentificacion={{ $data->paciente->tipoIdentificacion}}&numeroIdentificacion={{ $data->paciente->numeroIdentificacion}}&codigoEspecialidad={{ $data->especialidad->codigoEspecialidad}}&secuenciaAfiliado={{ isset($data->convenio) ? $data->convenio->secuenciaAfiliado : '' }}&codigoConvenio={{ isset($data->convenio) ? $data->convenio->codigoConvenio : '' }}&idIntervalos={{ $data->horario->idIntervalo }}&esOnline={{ $data->online }}&porcentajeDescuento={{ $data->horario->porcentajeDescuento }}`
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

            console.log(porcentajeDescuentoCopago,subtotalCopago,valorTotalCopago)
            let elem = ``;
            if(porcentajeDescuentoCopago == 0){
                elem += `<h3 class="text-primary-veris fw-bold mb-0" id="precioTotal">$${valorTotalCopago}</h3>`;
            }else{
                elem += `<p class="text-danger fs--3 mb-0" id="content-precioBase">Precio normal 
                            <del id="precioBase">$${valorTotalCopago}<</del>
                        </p>
                        <h3 class="text-primary-veris fw-bold mb-0" id="precioTotal">$${valorTotalCopago}<</h3>`;
            }
            $('.box-precio').html(elem);
        }
        return data;
    }
</script>
@endpush