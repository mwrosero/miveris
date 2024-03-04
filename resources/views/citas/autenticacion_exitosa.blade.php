@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Autenticación exitosa
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData')->numeroIdentificacion);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-transparent shadow-none mt-3">
                    <div class="card-body p-0">
                        <form class="row g-3">
                            <div class="text-center">
                                <div class="avatar avatar-lg mx-auto mb-3">
                                    <span class="avatar-initial rounded-circle bg-primary">
                                        <i class="bi bi-check-lg fs-2"></i>
                                    </span>
                                </div>
                                <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Autenticación exitosa</h1>
                            </div>
                            <p class="fs--1 text-center mt-0 mb-3">Tu tarjeta se confirmó con éxito.</p>
                            <img src="{{ asset('assets/img/svg/autenticacion_exitosa.svg')}}" alt="">
                            <div class="col-12">
                                <button type="button" id="btn-pagar-otp" class="btn btn-lg btn-primary-veris w-100">Continuar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    document.addEventListener("DOMContentLoaded", async function () {
        $('body').on('click', '#btn-pagar-otp', async function(){
            $('#btn-pagar-otp').addClass('disabled');
            pagarCita();
        });

        if(dataCita.reserva){
            if (dataCita.reserva.aplicaProntoPago == "S") {
                window.addEventListener("beforeunload", beforeUnloadHandler);
            }
        }
    });

    async function pagarCita(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/registrar_pago_nuvei?canalOrigen=${_canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "tipoIdentificacion": parseInt(dataCita.facturacion.datosFactura.codigoTipoIdentificacion),
            "numeroIdentificacion": dataCita.facturacion.datosFactura.codigoUsuario,
            "codigoTransaccion": dataCita.transaccionVirtual.codigoTransaccion,
            "canalOrigenDigital": _canalOrigen,
            "tokenNuvei": dataCita.tarjeta.token
        });
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            console.log(data.data);
            window.removeEventListener("beforeunload", beforeUnloadHandler);
            if(data.data.estado.toUpperCase() == "APPROVED"){
                dataCita.registroPago = data.data;
                guardarData()
                let ruta = `/cita-agendada/{{ $params }}`;
                window.location.href = ruta;
            }else if(data.data.estado.toUpperCase() == "PENDING"){
                dataCita.registroPago = data.data;
                guardarData()
                let ruta = `/citas-confirmar-pago/{{ $params }}`;
                window.location.href = ruta;
            }
        }else{
            alert(data.message);
            $('#btn-pagar-otp').removeClass('disabled');
        }        
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
@endpush