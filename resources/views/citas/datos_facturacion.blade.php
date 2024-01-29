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
    <div class="modal fade" id="metodoPago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="metodoPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3 py-4">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 mb-3" id="metodoPagoLabel">Selecciona el método de pago</h1>
                    </div>
                    <a href="#" id="btn-seleccionar-tarjeta" class="btn btn-lg btn-primary-veris w-100 mb-2">Seleccionar tarjeta</a>
                    <a href="#" id="btn-agregar-tarjeta" class="btn btn-lg btn-outline-primary-veris w-100">Agregar otro método de pago</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Validacion -->
    <div class="modal fade" id="modalRequeridos" tabindex="-1" aria-labelledby="modalRequeridosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto title-section fw-bold" id="modalAlertTitleRequeridos">Campos requeridos</h5>
                </div>
                <div class="modal-body text-center p-3" id="modalAlertMessageRequeridos">
                    {{-- <i class="bi bi-exclamation-triangle-fill text-primary-veris h2"></i> --}}
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">Datos de facturación</h5>
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
                                        <label for="tipoIdentificacion" class="form-label fw-bold fs--2">Elige tu documento *</label>
                                        <select class="form-select" name="tipoIdentificacion" id="tipoIdentificacion" required>
                                            <option value="2">CÉDULA</option>
                                            <option value="1">RUC</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Elegir el tipo de documento.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="numeroIdentificacion" class="form-label fw-bold fs--2">Número de documento *</label>
                                        <input type="number" class="form-control" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0975375835" required />
                                        <div class="valid-feedback">
                                            Ingrese un numero de identificacion.
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none box-ruc">
                                        <label for="razonSocial" class="form-label fw-bold fs--2">Razón Social *</label>
                                        <input type="text" class="form-control" name="razonSocial" id="razonSocial" placeholder="" required />
                                        <div class="valid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12 box-no-ruc">
                                        <label for="primerNombre" class="form-label fw-bold fs--2">Primer Nombre *</label>
                                        <input type="text" class="form-control" name="primerNombre" id="primerNombre" placeholder="" required />
                                        <div class="valid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12 box-no-ruc">
                                        <label for="primerApellido" class="form-label fw-bold fs--2">Primer Apellido *</label>
                                        <input type="text" class="form-control" name="primerApellido" id="primerApellido" placeholder="" required />
                                        <div class="valid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                    <div class="col-md-12 box-no-ruc">
                                        <label for="segundoApellido" class="form-label fw-bold fs--2">Segundo Apellido *</label>
                                        <input type="text" class="form-control" name="segundoApellido" id="segundoApellido" placeholder="" required />
                                        <div class="valid-feedback">
                                            Ingrese su nombres y apellidos.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="direccion" class="form-label fw-bold fs--2">Dirección *</label>
                                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="" required />
                                        <div class="invalid-feedback">
                                            Ingrese una direccion.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="telefono" class="form-label fw-bold fs--2">Teléfono *</label>
                                        <input type="number" class="form-control" name="telefono" id="telefono" placeholder="+593 097 989 3554" required />
                                        <div class="valid-feedback">
                                            Ingrese un telefono.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="mail" class="form-label fw-bold fs--2">Email *</label>
                                        <input type="email" class="form-control" name="mail" id="mail" placeholder="micorreo@gmail.com" required />
                                        <div class="valid-feedback">
                                            Ingrese un correo electronico.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group fs--1 bg-neutral rounded-3 pt-2 pb-2">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-bold">
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
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 border-0 fw-bold">
                                                Total
                                                <span class="badge text-dark fw-normal fs--1 p-0" id="total"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input terminos-input me-2" type="checkbox" value="" id="checkTerminosCondicion" required>
                                    <label class="form-check-label fs--1" for="checkTerminosCondicion">
                                        Acepto los <a href="https://www.veris.com.ec/terminos-y-condiciones/" target="_blank">Términos y condiciones</a>
                                    </label>
                                    <div class="invalid-feedback">
                                        Debes aceptar antes de enviar
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="btn-master w-lg-50 mx-auto">
                                    <a href="#" id="btn-next" class="btn disabled text-white shadow-none">Continuar</a>
                                    |
                                    <p class="btn text-white mb-0 shadow-none cursor-inherit" id="totalLabel"></p>
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
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    document.addEventListener("DOMContentLoaded", async function () {
        //await reservarCita();
        await crearPreTransaccion();

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
        args["data"] = JSON.stringify({
            "idPaciente":{{ Session::get('userData')->numeroPaciente }},
            //"codigoPreTransaccion": dataCita.reserva.secuenciaTransaccion,
            "tipoServicio": "CITA",
            "codigoConvenio": dataCita.convenio.codigoConvenio,
            "secuenciaAfiliado": dataCita.convenio.secuenciaAfiliado,
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
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/consultar_datos_factura?canalOrigen=${_canalOrigen}&idPreTransaccion=${ dataCita.preTransaccion.codigoPreTransaccion }&codigoTipoIdentificacion={{ Session::get('userData')->codigoTipoIdentificacion }}&numeroIdentificacion={{ Session::get('userData')->numeroIdentificacion }}`;
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
        $('#subtotal').html(`$${dataCita.facturacion.totales.subtotal}`)
        $('#creditoConvenio').html(`$${dataCita.facturacion.totales.creditoConvenio}`)
        $('#descuentoAplicado').html(`$${dataCita.facturacion.totales.descuentoAplicado}`)
        $('#iva').html(`$${dataCita.facturacion.totales.iva}`)
        $('#total').html(`$${dataCita.facturacion.totales.total}`)
        $('#totalLabel').html(`$${dataCita.facturacion.totales.total}`)
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
        let tipoBoton = "NUVEI";
        if(dataCita.facturacion.datosFactura.permiteNuvei != "S"){
            tipoBoton = "KUSHKI";
        }
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/crear_transaccion_virtual?canalOrigen=${_canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({            
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
            "canalOrigenDigital": _canalOrigen
        });
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.transaccionVirtual = data.data;
            guardarData();
            if(dataCita.facturacion.datosFactura.permiteNuvei == "S"){
                var myModal = new bootstrap.Modal(document.getElementById('metodoPago'));
                myModal.show();
                let ulrParams = btoa(JSON.stringify(dataCita));
                console.log(ulrParams);
                $('#btn-seleccionar-tarjeta').attr("href",`/citas-seleccionar-tarjeta/{{ $params }}`)
                $('#btn-agregar-tarjeta').attr("href",`/citas-informacion-pago/{{ $params }}`)
            }else{
                let ulrParams = btoa(JSON.stringify(dataCita));
                let ruta = `/citas-pago-kushki/{{ $params }}`;
                window.location.href = ruta;
            }
        }else{
            alert(data.message);
        }
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }
</script>
@endpush