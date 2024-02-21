@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Datos de facturación
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal Metodo de pago -->
    <div class="modal fade" id="metodoPago" aria-hidden="true" tabindex="-1" aria-labelledby="metodoPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 mb-3" id="metodoPagoLabel">Selecciona el método de pago</h1>
                    </div>
                    <a href="#" id="btn-seleccionar-tarjeta" class="btn btn-lg btn-primary-veris fs--18 line-height-24 py-3 w-100 m-0 mb-3">Seleccionar tarjeta</a>
                    <a href="#" id="btn-agregar-tarjeta" class="btn btn-lg btn-outline-primary-veris fs--18 line-height-24 py-3 w-100 m-0">Agregar otro método de pago</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Validacion -->
    <div class="modal fade" id="modalRequeridos" tabindex="-1" aria-labelledby="modalRequeridosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-header pt-3 pb-0 px-3">
                    <h5 class="modal-title mx-auto title-section fw-medium" id="modalAlertTitleRequeridos">Campos requeridos</h5>
                </div>
                <div class="modal-body text-center p-3" id="modalAlertMessageRequeridos">
                    {{-- <i class="bi bi-exclamation-triangle-fill text-primary-veris h2"></i> --}}
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3 m-0" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Desgloce -->
    <div class="modal fade" id="modalDesglose" tabindex="-1" aria-labelledby="modalDesgloseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modalDesglose-size modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-header pt-3 pb-0 px-3">
                    <h5 class="modal-title mx-auto title-section fw-medium">Desglose de valores</h5>
                </div>
                <div class="modal-body text-center p-3" id="contenidoDesglose">
                    {{-- <div class="row">
                        <div class="col-12 text-center fw-medium fs--1 mb-2">Michael Rosero Peralta</div>
                        <div class="col-6 mb-2">
                            <p class="text-start fs--2 mb-1">Hemograma completo</p>
                            <div class="card bg-neutral shadow-none p-2">
                                <table class="card-body w-100">
                                    <tr class="border-bottom">
                                        <th class="fw-medium fs--2">P.V.P.</th>
                                        <th class="fw-medium fs--2">Crédito/convenio</th>
                                        <th class="fw-medium fs--2">IVA</th>
                                        <th class="fw-medium fs--2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <td class="fs--2">$9.80</td>
                                        <td class="fs--2">$0.00</td>
                                        <td class="fs--2">$0.00</td>
                                        <td class="fs--2">$9.80</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" id="btn-confirmar-y-pagar" class="btn btn-primary-veris fs--18 line-height-24 w-50 px-4 py-3 m-0 mx-auto" data-bs-dismiss="modal">Confirmar y pagar ahora</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">Datos de facturación</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0 p-md-3">
                        <form class="row g-3 form-factura needs-validation" novalidate>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Elige tu documento *</label>
                                        <select class="form-select form-filter border-0 fs--1 p-3" name="tipoIdentificacion" id="tipoIdentificacion" required>
                                            <option value="2">CÉDULA</option>
                                            <option value="1">RUC</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Elegir el tipo de documento.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Número de documento *</label>
                                        <input type="number" class="form-control form-filter border-0 fs--1 p-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required />
                                        <div class="invalid-feedback">
                                            Ingrese un numero de identificacion.
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none box-ruc">
                                        <label for="razonSocial" class="form-label fw-medium fs--1">Razón Social *</label>
                                        <input type="text" class="form-control border-fiord fs--1 p-3" name="razonSocial" id="razonSocial" placeholder="" required />
                                        <div class="invalid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12 box-no-ruc">
                                        <label for="primerNombre" class="form-label fw-medium fs--1">Primer Nombre *</label>
                                        <input type="text" class="form-control border-fiord fs--1 p-3" name="primerNombre" id="primerNombre" placeholder="" required />
                                        <div class="invalid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12 box-no-ruc">
                                        <label for="primerApellido" class="form-label fw-medium fs--1">Primer Apellido *</label>
                                        <input type="text" class="form-control border-fiord fs--1 p-3" name="primerApellido" id="primerApellido" placeholder="" required />
                                        <div class="invalid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12 box-no-ruc">
                                        <label for="segundoApellido" class="form-label fw-medium fs--1">Segundo Apellido *</label>
                                        <input type="text" class="form-control border-fiord fs--1 p-3" name="segundoApellido" id="segundoApellido" placeholder="" required />
                                        <div class="invalid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="direccion" class="form-label fw-medium fs--1">Dirección *</label>
                                        <input type="text" class="form-control form-filter border-0 fs--1 p-3" name="direccion" id="direccion" placeholder="" required />
                                        <div class="invalid-feedback">
                                            Ingrese una direccion.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="telefono" class="form-label fw-medium fs--1">Teléfono *</label>
                                        <input type="number" class="form-control border-fiord fs--1 p-3" name="telefono" id="telefono" placeholder="+593 999 999 9999" required />
                                        <div class="invalid-feedback">
                                            Ingrese un telefono.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="mail" class="form-label fw-medium fs--1">Email *</label>
                                        <input type="email" class="form-control border-fiord fs--1 p-3" name="mail" id="mail" placeholder="micorreo@gmail.com" required />
                                        <div class="valid-feedback">
                                            Ingrese un correo electronico.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group fs--1 bg-neutral rounded-3 pt-2 pb-2">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-medium">
                                                Detalle de factura
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                Subtotal
                                                <span class="badge text-dark fw-normal fs--1 p-0" id="subtotal"></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                Crédito/convenio
                                                <span class="badge text-dark fw-normal fs--1 p-0" id="creditoConvenio"></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                Descuento aplicado
                                                <span class="badge text-dark fw-normal fs--1 p-0" id="descuentoAplicado"></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0">
                                                IVA
                                                <span class="badge text-dark fw-normal fs--1 p-0" id="iva"></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-medium">
                                                Total
                                                <span class="badge text-dark fw-normal fs--1 p-0" id="total"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <div class="form-check d-flex justify-content-center align-items-center">
                                    <input class="form-check-input terminos-input me-2 mb-1" type="checkbox" value="" id="checkTerminosCondicion" required>
                                    <label class="form-check-label fs--1 fw-medium line-height-16" for="checkTerminosCondicion">
                                        Acepto los <a href="https://www.veris.com.ec/terminos-y-condiciones/" target="_blank" class="">Términos y condiciones</a> 
                                        <span id="politicas" class="d-none">y <a href="https://www.veris.com.ec/politicas/" target="_blank">Política de protección de Datos Personales</a></span>
                                    </label>
                                    <div class="invalid-feedback">
                                        Debes aceptar antes de enviar
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 col-md-8">
                                        <div class="btn-master w-100 mx-auto">
                                            <button type="button" id="btn-next" class="col-5 btn disabled text-white shadow-none">Continuar</button>
                                            |
                                            <p class="col-5 btn text-white mb-0 shadow-none cursor-inherit" id="totalLabel"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div id="btn-ver-examenes" class="btn-master w-lg-50 mx-auto mt-2 cursor-pointer justify-content-center align-items-center d-none">
                                            <div class="text-center">
                                                Ver exámenes a pagar
                                            </div>
                                        </div>
                                    </div>
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

    // variables globales
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let estadoPoliticas;
    let ultimaVersionPoliticas;

    document.addEventListener("DOMContentLoaded", async function () {
        //await reservarCita();
        if(dataCita.reserva){
            if (dataCita.reserva.aplicaProntoPago == "S") {
                window.addEventListener("beforeunload", beforeUnloadHandler);
            }
        }
        await obtenerPPD();
        
        if(!dataCita.reserva && !dataCita.datosTratamiento && !dataCita.reservaEdit && !dataCita.ordenExterna && !dataCita.paquete){
            window.history.back();
        }

        if(!dataCita.promocion){
            await crearPreTransaccion();
        }else{
            await consultarDatosFactura();
        }

        $('body').on('change', '#tipoIdentificacion', function(){
            if($(this).val() == '2'){
                $('.box-ruc').addClass('d-none');
                $('.box-no-ruc').removeClass('d-none');
            }else{
                $('.box-no-ruc').addClass('d-none');
                $('.box-ruc').removeClass('d-none');
            }
        })

        $('body').on('change', '#checkTerminosCondicion', function(){
            
            if($('#checkTerminosCondicion').is(':checked')) {
                $('#btn-next').removeClass('disabled');
            } else {
                $('#btn-next').addClass('disabled');
            }
        });

        $('body').on('click', '#btn-next', async function(){
            //validar formulario datos factura
            await validarDatosFactura();
        })

        $('body').on('click', '#btn-ver-examenes', async function(){
            if($('#checkTerminosCondicion').is(':checked')) {
                $('#btn-confirmar-y-pagar').html("Confirmar y pagar ahora");
            }else{
                $('#btn-confirmar-y-pagar').html("Continuar");
            }
            await mostrarDesglose();
        })

        $('body').on('click', '#btn-confirmar-y-pagar', async function(){
            if($('#checkTerminosCondicion').is(':checked')) {
                await validarDatosFactura();
            }else{
                $('#modalDesglose').modal('hide');
            }
        })

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

        // let idPaciente = {{ Session::get('userData')->numeroPaciente }};
        let idPaciente = dataCita.paciente.numeroPaciente;
        let tipoServicio = "CITA";
        let tipoSolicitud = null;

        let codigoConvenio;
        let secuenciaAfiliado;
        
        if(dataCita.listadoPrestaciones && dataCita.listadoPrestaciones.length > 0){
            tipoServicio = "ORDEN";
            addPrestacionesToModal();
            $("#btn-ver-examenes").removeClass('d-none');
        }

        if(dataCita.ordenExterna){
            addPrestacionesToModal();
            $('.modalDesglose-size').removeClass('modal-lg');
            $('.modalDesglose-size').addClass('modal-md');
            $("#btn-ver-examenes").removeClass('d-none');
            $('#modalDesglose .modal-header').hide();
            // idPaciente = dataCita.paciente.numeroPaciente;
            codigoConvenio = dataCita.ordenExterna.pacientes[0].codigoConvenio;
            if(dataCita.ordenExterna.aplicoDomicilio === 'N'){
                tipoServicio = "ORDEN";
                tipoSolicitud = "LAB";
            }else{
                obtenerPreparacionPrevia();
                tipoServicio= "DOMICILIO";
                tipoSolicitud= "LAB";
            }
        }else{
            if(!dataCita.paquete){
                codigoConvenio = dataCita?.convenio.codigoConvenio;
                secuenciaAfiliado = dataCita?.convenio.secuenciaAfiliado;
            }
        }

        if(dataCita.paquete){
            tipoServicio= "PAQUETE";
        }

        //Consultar si idPaciente es del que hizo login o del beneficiario de lo que se va a pagar
        let dataPT = {
            "idPaciente":idPaciente,
            //"codigoPreTransaccion": dataCita.reserva.secuenciaTransaccion,
            "tipoServicio": tipoServicio,
            "tipoSolicitud": tipoSolicitud,
            "codigoConvenio": codigoConvenio,
            "secuenciaAfiliado": secuenciaAfiliado,
        }

        if(dataCita.dataOrdenExterna){
            dataPT.codigoPreTransaccion = dataCita.dataOrdenExterna.codigoPreTransaccion
        }

        if(dataCita.reserva){
            dataPT.listaCitas = [{
                "codigoReserva": dataCita.reserva.codigoReserva
            }]
        }

        if(dataCita.paquete){
            dataPT.paquete = {
                "codigoPaquete": dataCita.paquete.codigoPaquete
            }
        }

        if(dataCita.reservaEdit){
            dataPT.listaCitas = [{
                "codigoReserva": dataCita.reservaEdit.idCita
            }]
        }


        if(dataCita.listadoPrestaciones && dataCita.listadoPrestaciones.length > 0){
            dataPT.listaOrdenes = dataCita.listadoPrestaciones;
        }

        if(dataCita.ordenExterna){
            if(dataCita.ordenExterna.aplicoDomicilio === 'N'){
                dataPT.listaOrdenes = dataCita.ordenExterna.pacientes[0].examenes;
            }else{
                dataPT.codigoSolicitud = dataCita.ordenExterna.codigoSolicitud;
            }
        }

        args["data"] = JSON.stringify(dataPT);
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.preTransaccion = data.data;
            await consultarDatosFactura();
        }else{
            alert(data.message);
        }
    }

    //Consultar datos de facturación si son del dueño de la cuenta o del beneficiario
    async function consultarDatosFactura(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/consultar_datos_factura?canalOrigen=${_canalOrigen}&idPreTransaccion=${ dataCita.preTransaccion.codigoPreTransaccion }&codigoTipoIdentificacion={{ Session::get('userData')->codigoTipoIdentificacion }}&numeroIdentificacion={{ Session::get('userData')->numeroIdentificacion }}`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.facturacion = data.data;
            mostrarInfo();
        }else{
            alert(data.message);
        }
    }

    //obtener las politicas
    async function obtenerPPD(){
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1";
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log('data',data.code);
        if(data.code == 200){
            ultimaVersionPoliticas = data.data.ultimaVersionPoliticas;
            estadoPoliticas = data.data.estadoPoliticas;
            if(estadoPoliticas == "N"){
                $('#politicas').removeClass('d-none');
            }
        }
        return data;
    }

    //aceptar politicas
    async function aceptarPoliticas(){
        
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            
            "aceptaPoliticas": true,
            "versionPoliticas": ultimaVersionPoliticas,
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

    function mostrarInfo(){
        /*Datos de Facturación*/
        $('#tipoIdentificacion').val(dataCita.facturacion.datosFactura.codigoTipoIdentificacion).trigger('change');
        $('#numeroIdentificacion').val(dataCita.facturacion.datosFactura.codigoUsuario);
        $('#nombre').val(dataCita.facturacion.datosFactura.nombreCliente);
        $('#primerNombre').val(dataCita.facturacion.datosFactura.primerNombre);
        $('#primerApellido').val(dataCita.facturacion.datosFactura.primerApellido);
        $('#segundoApellido').val(dataCita.facturacion.datosFactura.segundoApellido);
        $('#direccion').val(dataCita.facturacion.datosFactura.direccion);
        $('#telefono').val(dataCita.facturacion.datosFactura.telefonoCelular);
        $('#mail').val(dataCita.facturacion.datosFactura.email);

        if(dataCita.facturacion.datosFactura.codigoTipoIdentificacion == 2){
            $('.box-ruc').addClass('d-none');
            $('.box-no-ruc').removeClass('d-none');
        }else{
            $('.box-no-ruc').addClass('d-none');
            $('.box-ruc').removeClass('d-none');
        }

        /*Detalle de factura*/
        $('#subtotal').html(`$${dataCita.facturacion.totales.subtotal.toFixed(2)}`);
        $('#creditoConvenio').html(`$${dataCita.facturacion.totales.creditoConvenio.toFixed(2)}`);
        $('#descuentoAplicado').html(`$${dataCita.facturacion.totales.descuentoAplicado.toFixed(2)}`);
        $('#iva').html(`$${dataCita.facturacion.totales.iva.toFixed(2)}`);
        $('#total').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);
        $('#totalLabel').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);
    }

    async function validarDatosFactura(){
        let errors = false;
        let msg = `<ul class="ms-0 text-start fs--1" id="itemsMsg">`;

        var tipoIdentificacion = parseInt($("#tipoIdentificacion").val());
        if (tipoIdentificacion == 1) {
            // Validar razonSocial
            var razonSocial = $("#razonSocial").val();
            if (razonSocial.trim() === "") {
                errors = true;
                msg += `<li class="ms-0">El campo Razón Social es obligatorio.</li>`;
            }
        } else if (tipoIdentificacion == 2) {
            // Validar numeroIdentificacion
            var numeroIdentificacion = $("#numeroIdentificacion").val();
            if (numeroIdentificacion.length !== 10) {
                errors = true;
                msg += `<li class="ms-0">El campo Número Documento debe tener 10 dígitos.</li>`;
            }else if (!esValidaCedula(numeroIdentificacion)) {
                errors = true;
                msg += `<li class="ms-0">Número Documento inválido.</li>`;
            }

            // Validar nombres y apellidos
            var primerNombre = $("#primerNombre").val();
            var primerApellido = $("#primerApellido").val();
            var segundoApellido = $("#segundoApellido").val();
            if (primerNombre.trim() === "" || primerApellido.trim() === "" || segundoApellido.trim() === "") {
                errors = true;
                msg += `<li class="ms-0">Los campos Primer Nombre, Primer Apellido y Segundo Apellido son obligatorios.</li>`;
            }
        }

        // Validar campos obligatorios comunes
        var direccion = $("#direccion").val();
        var telefono = $("#telefono").val();
        var mail = $("#mail").val();
        if (direccion.trim() === "" || telefono.trim() === "" || mail.trim() === "") {
            errors = true;
            msg += `<li class="ms-0">Los campos Dirección, Teléfono y Correo Electrónico son obligatorios.</li>`;
        }
        msg += `</ul>`;

        if(errors){
            $('#modalAlertMessageRequeridos').html(msg);
            var myModal = new bootstrap.Modal(document.getElementById('modalRequeridos'));
            myModal.show();
        }else{
            await crearTransaccionVirtual();
        }

    }

    async function crearTransaccionVirtual(){
        //let tipoBoton = "KUSHKI";
        let tipoBoton = "NUVEI";
        if(dataCita.facturacion.datosFactura.permiteNuvei != "S"){
            if(dataCita.facturacion.datosFactura.permiteKushki == "S"){
                tipoBoton = "KUSHKI";
            }else{
                tipoBoton = "PTP";
            }
        }
        let args = [];
        //args["endpoint"] = api_url + `/digitalestest/v1/facturacion/crear_transaccion_virtual?canalOrigen=${_canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["endpoint"] = api_url +
        `/digitalestest/v1/facturacion/crear_transaccion_virtual?idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST"; args["showLoader"] = true; args
        ["bodyType"] = "json"; args["data"] = JSON.stringify({            
            "codigoUsuario": "{{ Session::get('userData')->numeroIdentificacion }}",
            "codigoTipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
            "numeroIdentificacion": getInput('numeroIdentificacion'),
            "nombreFactura": getInput('razonSocial'),
            "primerNombre": getInput('primerNombre'),
            "primerApellido": getInput('primerApellido'),
            "segundoApellido": getInput('segundoApellido'),
            "direccionFactura": getInput('direccion'),
            "telefonoFactura": getInput('telefono'),
            "mailFactura": getInput('mail'),
            "emailFactura": getInput('mail'),
            "direccionIP": "",
            "modeloDispositivo": "",
            "versionSO": "",
            "plataformaOrigen": "WEB",
            "tipoBoton": tipoBoton,
            "sistemaOperativo": "",
            "idNavegador": "",
            "idiomaNavegador": "",
            "navegadorUA": "",
            "canalOrigenDigital": _canalOrigen//"VER_CMV"
        });
        const data = await call(args);
        console.log(data);

        window.removeEventListener("beforeunload", beforeUnloadHandler);

        if (data.code == 200){
            dataCita.transaccionVirtual = data.data;
            if (estadoPoliticas == "N"){
                await aceptarPoliticas();
            }   
            guardarData();
            if(tipoBoton == "NUVEI"){
                let tieneTarjetas = await cargarListaTarjetas()
                if(tieneTarjetas == 0){
                    window.location.href = `/citas-informacion-pago/{{ $params }}`;
                    return;
                }
                var myModal = new bootstrap.Modal(document.getElementById('metodoPago'));
                myModal.show();
                // let ulrParams = btoa(JSON.stringify(dataCita));
                // console.log(ulrParams);
                $('#btn-seleccionar-tarjeta').attr("href",`/citas-seleccionar-tarjeta/{{ $params }}`)
                $('#btn-agregar-tarjeta').attr("href",`/citas-informacion-pago/{{ $params }}`)
            }else{
                if(tipoBoton == "KUSHKI"){
                    // let ulrParams = btoa(JSON.stringify(dataCita));
                    let ruta = `/citas-pago-kushki/{{ $params }}`;
                    window.location.href = ruta;
                }else{
                    location.href = data.data.linkPagoPTP;
                }
            }
        }else{
            alert(data.message);
        }
    }

    function addPrestacionesToModal(){
        $('#contenidoDesglose').empty();
        let elem;
        if(dataCita.datosTratamiento){
            elem = `<div class="row">
                <div class="col-12 text-center fw-medium fs--1 mb-2">${dataCita.datosTratamiento.nombrePaciente}</div>`
            
            $.each(dataCita.listadoPrestaciones, function(key, value){
                elem += `<div class="col-12 col-md-6 mb-3">
                    <p class="text-start text-nowrap overflow-hidden text-truncate fs--2 mb-1">${value.nombrePrestacion}</p>
                    <div class="card bg-neutral shadow-none p-2">
                        <table class="card-body w-100">
                            <tr class="border-bottom">
                                <th class="fw-medium fs--2">P.V.P.</th>
                                <th class="fw-medium fs--2">Crédito/convenio</th>
                                <th class="fw-medium fs--2">IVA</th>
                                <th class="fw-medium fs--2">TOTAL</th>
                            </tr>
                            <tr>
                                <td class="fs--2">$${value.subtotal.toFixed(2)}</td>
                                <td class="fs--2">$${value.cubreEmpresa.toFixed(2)}</td>
                                <td class="fs--2">$${value.montoIva.toFixed(2)}</td>
                                <td class="fs--2">$${value.total.toFixed(2)}</td>
                            </tr>
                        </table>
                    </div>
                </div>`;
            });
            elem += `</div>`;
            if(dataCita.listadoPrestaciones.length < 2){
                $('.modalDesglose-size').removeClass('modal-lg');
                $('.modalDesglose-size').addClass('modal-md');
            }
        }else{
            elem = `<div class="row">
                <div class="col-12 text-center fw-medium fs--1 mb-2">${dataCita.ordenExterna.pacientes[0].nombrePacienteOrden}</div>`
            
                elem += `<div class="col-12 mb-3">
                    <div class="card bg-neutral shadow-none p-2">
                        <table class="card-body w-100">
                            <tr class="border-bottom">
                                <th class="fw-medium fs--2 mb-2">Nro. Orden</th>
                                <th class="fw-medium fs--2 mb-2">Detalle</th>
                            </tr>`
                $.each(dataCita.ordenExterna.pacientes[0].examenes, function(key, value){
                    elem += `<tr>
                                <td class="fs--2 pb-2">${value.numeroOrden}</td>
                                <td class="fs--2 pb-2 text-nowrap overflow-hidden text-truncate">${value.nombreExamen}</td>
                            </tr>`;
                });
                        `</table>
                    </div>
                </div>`;
            elem += `</div>`;
            if(dataCita.ordenExterna.pacientes[0].examenes.length < 2){
                $('.modalDesglose-size').removeClass('modal-lg');
                $('.modalDesglose-size').addClass('modal-md');
            }
        }
        $('#contenidoDesglose').append(elem);
    }

    function mostrarDesglose(){
        var myModal = new bootstrap.Modal(document.getElementById('modalDesglose'));
        myModal.show();
    }

    async function obtenerPreparacionPrevia(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/domicilio/laboratorio/preparacionPrevia?canalOrigen=${_canalOrigen}&codigoSolicitud=${ dataCita.ordenExterna.codigoSolicitud }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.facturacion = data.data;
            mostrarInfo();
        }
    }

    async function cargarListaTarjetas(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/tarjetas?canalOrigen=${_canalOrigen}&virusu={{ Session::get('userData')->numeroIdentificacion }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let count = 0;
            for (const value of data.data) {
                if(value.tipoBoton == "NUV"){
                    count++;
                }
            }
            return count;
        }else{
            return 0;
        }
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
@endpush