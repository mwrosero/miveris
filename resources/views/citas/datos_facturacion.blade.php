@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Datos de facturación
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
//dd(Session::get('userData'));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="metodoPago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="metodoPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3 py-4">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 mb-3" id="metodoPagoLabel">Selecciona el método de pago</h1>
                    </div>
                    <a href="{{route('citas.seleccionarTarjeta')}}" class="btn btn-lg btn-primary-veris w-100 mb-2">Seleccionar tarjeta</a>
                    <a href="{{route('citas.citaInformacionPago')}}" class="btn btn-lg btn-outline-primary-veris w-100">Agregar otro método de pago</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Datos de facturación') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="tipoIdentificacion" class="form-label fw-bold fs--2">{{ __('Elige tu documento') }} *</label>
                                        <select class="form-select bg-neutral" name="tipoIdentificacion" id="tipoIdentificacion" required>
                                            <option selected disabled value="">Seleccionar...</option>
                                            <option value="">Cédula de identidad</option>
                                            <option value="">RUC</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Elegir el tipo de documento.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="numeroIdentificacion" class="form-label fw-bold fs--2">{{ __('Número de documento') }} *</label>
                                        <input type="number" class="form-control bg-neutral" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0975375835" required />
                                        <div class="valid-feedback">
                                            Ingrese un numero de identificacion.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="nombre" class="form-label fw-bold fs--2">{{ __('Nombres y Apellidos') }} *</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="María Yanina Donoso Samaniego" required />
                                        <div class="valid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="direccion" class="form-label fw-bold fs--2">{{ __('Dirección') }} *</label>
                                        <input type="text" class="form-control bg-neutral" name="direccion" id="direccion" placeholder="Colinas de los ceibos, 318" required />
                                        <div class="invalid-feedback">
                                            Ingrese una direccion.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="telefono" class="form-label fw-bold fs--2">{{ __('Teléfono') }} *</label>
                                        <input type="number" class="form-control" name="telefono" id="telefono" placeholder="+593 097 989 3554" required />
                                        <div class="valid-feedback">
                                            Ingrese un telefono.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="mail" class="form-label fw-bold fs--2">{{ __('Email') }} *</label>
                                        <input type="email" class="form-control" name="mail" id="mail" placeholder="micorreo@gmail.com" required />
                                        <div class="valid-feedback">
                                            Ingrese un correo electronico.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group fs--1 bg-neutral rounded-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-bold">
                                                {{ __('Detalle de factura') }}
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('Subtotal') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">$36.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('Crédito/convenio') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">-$32.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('Descuento aplicado') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">-$1.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                {{ __('IVA') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">+$4.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-bold">
                                                {{ __('Total') }}:
                                                <span class="badge text-dark fw-normal fs--1 p-0">7.00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-5">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input terminos-input me-2" type="checkbox" value="" id="checkTerminosCondicion" required>
                                    <label class="form-check-label fs--1" for="checkTerminosCondicion">
                                        {{ __('Acepto los Términos y condiciones') }}
                                    </label>
                                    <div class="invalid-feedback">
                                        Debes aceptar antes de enviar
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="btn-master w-lg-50 mx-auto">
                                    <a href="{{route('citas.citaInformacionPago')}}" class="btn text-white shadow-none">{{ __('Continuar') }}</a>
                                    |
                                    <p class="btn text-white mb-0 shadow-none cursor-inherit" id="total">$7.00</p>
                                </div>
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
    let dataCita = @json($data);
    document.addEventListener("DOMContentLoaded", async function () {
        await reservarCita();
    });

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
            "esEmbarazada": "string",            
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
            await crearPreTransaccion();
        }else{
            alert(data.message);
        }
    }

    async function crearPreTransaccion(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/crear_pretransaccion?canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "idPaciente":{{ Session::get('userData')->numeroPaciente }},
            //"codigoPreTransaccion": dataCita.reserva.secuenciaTransaccion,
            "tipoServicio": "CITA",
            "codigoConvenio": dataCita.convenio.codigoConvenio,
            "secuenciaAfiliado": dataCita.convenio.secuenciaAfiliado,
            "codigoSolicitud": 0,
            "tipoSolicitud": null,
            "listaCitas": [{
                "codigoReserva": dataCita.reserva.codigoReserva
            }],
            "paquete": null,
            "listaOrdenes": null
        });
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.preTransaccion = data.data;
            await consultarDatosFactura();
        }else{
            alert(data.message);
        }
    }

    async function consultarDatosFactura(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/consultar_datos_factura?canalOrigen=${_canalOrigen}&idPreTransaccion=${ dataCita.preTransaccion.codigoPreTransaccion }&virusu=${ btoa("{{ Session::get('userData')->numeroIdentificacion }}") }&codigoTipoIdentificacion={{ Session::get('userData')->codigoTipoIdentificacion }}+numeroIdentificacion={{ Session::get('userData')->numeroIdentificacion }}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.facturacion = data.data;
            await crearPreTransaccion();
        }else{
            alert(data.message);
        }
    }

</script>
@endpush