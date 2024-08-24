@extends('template.external')
@section('title')
Veris - Datos de facturación
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

<link href="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.paymentez.com/ccapi/sdk/payment_checkout_stable.min.js" charset="UTF-8"></script>
@include('external.components.navbar')

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
    <div class="modal-dialog modal-xl modalDesglose-size modal-dialog-centered mx-auto">
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
{{-- <div class="d-flex justify-content-between align-items-center bg-white">
    <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">Pago en línea</h5>
</div> --}}

<section class="p-3 mb-3">
	@if(request()->input('tipoArticulo') == "CITA")
	{{-- <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue">Detalles de Agendamiento</h5> --}}
	<div class="row justify-content-center">
	    <div class="col-md-10 col-lg-8">
	        <div class="card bg-transparent shadow-none">
	            <div class="card-body p-0 pb-3 p-md-3">
	                <div class="row g-3">
	                    <div class="col-md-12">
	                        <div class="row g-3">
	                            <div class="col-12">
	                            	<div class="card">
					                    <div class="card-header bg-grayish-blue p--2">
					                        <h5 class="text-veris-many fw-medium line-height-16 m-0">{{ __('Detalles de la cita') }}</h5>
					                    </div>
					                    <div class="card-body p--2">
					                        <div class="" id="contentDetalleCita">
					                        </div>
					                    </div>
					                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	@endif
	<h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue">Datos de facturación</h5>
	<div class="row justify-content-center">
	    <div class="col-md-10 col-lg-8">
	        <div class="card bg-transparent shadow-none">
	            <div class="card-body p-0 p-md-3">
	                <form class="row g-3 form-factura needs-validation" novalidate>
	                    <div class="col-md-6">
	                        <div class="row g-3">
	                            <div class="col-md-12">
	                                <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Elige tu documento *</label>
	                                <select class="form-select fs--1 p-3" name="tipoIdentificacion" id="tipoIdentificacion" required>
	                                    <option value="2">CÉDULA</option>
	                                    <option value="1">RUC</option>
	                                </select>
	                                <div class="invalid-feedback">
	                                    Elegir el tipo de documento.
	                                </div>
	                            </div>
	                            <div class="col-md-12">
	                                <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Número de documento *</label>
	                                <input type="number" class="form-control fs--1 p-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required />
	                                <div class="invalid-feedback">
	                                    Ingrese un numero de identificacion.
	                                </div>
	                            </div>
	                            <div class="col-md-12 d-none box-ruc">
	                                <label for="razonSocial" class="form-label fw-medium fs--1">Razón Social *</label>
	                                <input type="text" class="form-control fs--1 p-3" name="razonSocial" id="razonSocial" placeholder="" required />
	                                <div class="invalid-feedback">
	                                    Ingrese su nombres y apellidos.
	                                </div>
	                            </div>
	                            <div class="col-md-12 box-no-ruc">
	                                <label for="primerNombre" class="form-label fw-medium fs--1">Primer Nombre *</label>
	                                <input type="text" class="form-control fs--1 p-3" name="primerNombre" id="primerNombre" placeholder="" required />
	                                <div class="invalid-feedback">
	                                    Ingrese su nombres y apellidos.
	                                </div>
	                            </div>
	                            <div class="col-md-12 box-no-ruc">
	                                <label for="primerApellido" class="form-label fw-medium fs--1">Primer Apellido *</label>
	                                <input type="text" class="form-control fs--1 p-3" name="primerApellido" id="primerApellido" placeholder="" required />
	                                <div class="invalid-feedback">
	                                    Ingrese su nombres y apellidos.
	                                </div>
	                            </div>
	                            <div class="col-md-12 box-no-ruc">
	                                <label for="segundoApellido" class="form-label fw-medium fs--1">Segundo Apellido *</label>
	                                <input type="text" class="form-control fs--1 p-3" name="segundoApellido" id="segundoApellido" placeholder="" required />
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
	                                <input type="text" class="form-control fs--1 p-3" name="direccion" id="direccion" placeholder="" required />
	                                <div class="invalid-feedback">
	                                    Ingrese una direccion.
	                                </div>
	                            </div>
	                            <div class="col-md-12">
	                                <label for="telefono" class="form-label fw-medium fs--1">Teléfono *</label>
	                                <input type="number" class="form-control fs--1 p-3" name="telefono" id="telefono" placeholder="+593 999 999 9999" required />
	                                <div class="invalid-feedback">
	                                    Ingrese un telefono.
	                                </div>
	                            </div>
	                            <div class="col-md-12">
	                                <label for="mail" class="form-label fw-medium fs--1">Email *</label>
	                                <input type="email" class="form-control fs--1 p-3" name="mail" id="mail" placeholder="micorreo@gmail.com" required />
	                                <div class="valid-feedback">
	                                    Ingrese un correo electronico.
	                                </div>
	                            </div>
	                            <div class="col-md-12">
	                                <ul class="list-group fs--1 bg-neutral rounded-3 pt-2 pb-2">
	                                    <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 fw-medium">
	                                        Detalle de factura
	                                    </li>
	                                    <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2">
	                                        Subtotal
	                                        <span class="badge text-dark fw-normal fs--1 p-0" id="subtotal"></span>
	                                    </li>
	                                    <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2">
	                                        Crédito/convenio
	                                        <span class="badge text-dark fw-normal fs--1 p-0" id="creditoConvenio"></span>
	                                    </li>
	                                    <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2">
	                                        Descuento aplicado
	                                        <span class="badge text-dark fw-normal fs--1 p-0" id="descuentoAplicado"></span>
	                                    </li>
	                                    <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2">
	                                        IVA
	                                        <span class="badge text-dark fw-normal fs--1 p-0" id="iva"></span>
	                                    </li>
	                                    <li class="list-group-item d-flex justify-content-between align-items-center py-0 px-2 fw-medium">
	                                        Total
	                                        <span class="badge text-dark fw-normal fs--1 p-0" id="total"></span>
	                                    </li>
	                                </ul>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-12 text-center mt-4">
	                        <div class="form-check d-flex justify-content-md-center align-items-center">
	                            <input class="form-check-input terminos-input me-2 mb-1 width-24" type="checkbox" value="" id="checkTerminosCondicion" required>
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
	                            <div class="col-12 col-md-6">
	                                <button type="button" class="btn btn-primary-veris fs--18 line-height-24 w-100 py-3 px-32 shadow-none d-flex justify-content-between align-items-center disabled" id="btn-next">
	                                    <span class="col-5 shadow-none">Continuar</span>
	                                    |
	                                    <span class="col-5 mb-0 shadow-none cursor-inherit" id="totalLabel"></span>
	                                </button>
	                                <!-- <div class="btn-master w-100 mx-auto">
	                                    <button type="button" id="btn-next" class="col-5 btn fs--18 line-height-24 disabled text-white shadow-none">Continuar</button>
	                                    |
	                                    <p class="col-5 btn text-white fs--18 line-height-24 mb-0 shadow-none cursor-inherit" id="totalLabel"></p>
	                                </div> -->
	                            </div>
	                        </div>
	                        <div class="row justify-content-center align-items-center">
	                            <div class="col-12 col-md-6">
	                                <div id="btn-ver-examenes" class="btn-master w-100 mx-auto mt-2 cursor-pointer justify-content-center align-items-center d-none">
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
<script>
	let canalOrigen = (window.config.subdomain == "veris") ? "VER_CMV" : "VER_PMF";
	let preTransaccion = @json($pretransaccion);
	let dataCita = {};
	dataCita.returnUrl = "{{ $urlRetornoPago }}"
	dataCita.preTransaccion = preTransaccion.data;
	dataCita.executionId = "{{ request()->input('executionId', '') }}";
	console.log("{{ $paciente->data->telefonoMovil }}");
	// dataCita.preTransaccion.codigoPreTransaccion
	document.addEventListener("DOMContentLoaded", async function () {
		await consultarDatosFactura();
		console.log("{{ request()->input('executionId', '') }}")
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

        // $('body').on('click', '.btnNuvei', function() {
		// 	$('.btnNuvei').css('pointer-events','none')
		// 	pasarelaNuvei();
		// })

		if("{{ request()->input('tipoArticulo') }}" == "ORDEN"){
            addPrestacionesToModal();
            $("#btn-ver-examenes").removeClass('d-none');
        }

        @if(request()->input('tipoArticulo') == "CITA")
			llenarDataDetallesCitas()
		@endif
	});

	function mostrarDesglose(){
        var myModal = new bootstrap.Modal(document.getElementById('modalDesglose'));
        myModal.show();
    }

	async function consultarDatosFactura(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/consultar_datos_factura?canalOrigen=${canalOrigen}&idPreTransaccion=${ preTransaccion.data.codigoPreTransaccion }&codigoTipoIdentificacion={{ request()->query('tipoIdentificacion') }}&numeroIdentificacion={{ request()->query('numeroIdentificacion') }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.facturacion = data.data;
            if(dataCita.facturacion.datosFactura.permiteNuvei == "S"){
            	$('#btn-next').addClass('btnNuvei');
            }
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
        $('#subtotal').html(`$${dataCita.facturacion.totales.subtotal.toFixed(2)}`);
        $('#creditoConvenio').html(`-$${dataCita.facturacion.totales.creditoConvenio.toFixed(2)}`);
        $('#descuentoAplicado').html(`-$${dataCita.facturacion.totales.descuentoAplicado.toFixed(2)}`);
        $('#iva').html(`+$${dataCita.facturacion.totales.iva.toFixed(2)}`);
        $('#total').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);
        $('#totalLabel').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);

        if(dataCita.ordenExterna){
            addPrestacionesToModal();
        }
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
            var numeroIdentificacion = $("#numeroIdentificacion").val();
            if (numeroIdentificacion.length !== 13) {
                errors = true;
                msg += `<li class="ms-0">El campo Número Documento debe tener 13 dígitos.</li>`;
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
            if (primerNombre.trim() === "") {
                errors = true;
                msg += `<li class="ms-0">El campo primer nombre es obligatorio.</li>`;
            }
            if (primerApellido.trim() === "") {
                errors = true;
                msg += `<li class="ms-0">El campo primer apellido es obligatorio.</li>`;
            }
            if (segundoApellido.trim() === "") {
                errors = true;
                msg += `<li class="ms-0">El campo segundo apellido es obligatorio.</li>`;
            }
        }

        // Validar campos obligatorios comunes
        var direccion = $("#direccion").val();
        var telefono = $("#telefono").val();
        var mail = $("#mail").val();
        if (direccion.trim() === "") {
            errors = true;
            msg += `<li class="ms-0">El campo dirección obligatorio.</li>`;
        }
        if (telefono.trim() === "") {
            errors = true;
            msg += `<li class="ms-0">El campo teléfono es obligatorio.</li>`;
        }
        if (mail.trim() === "") {
            errors = true;
            msg += `<li class="ms-0">El campo correo electrónico es obligatorio.</li>`;
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
        //args["endpoint"] = api_url + `/${api_war}/v1/facturacion/crear_transaccion_virtual?canalOrigen=${canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/crear_transaccion_virtual?idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST"; 
        args["showLoader"] = true; 
        args["bodyType"] = "json"; 
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({            
            "codigoUsuario": getInput('numeroIdentificacion'),
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
            "executionId": dataCita.executionId,
            "canalOrigenDigital": canalOrigen//"VER_CMV"
        });
        const data = await call(args);
        console.log(data);

        window.removeEventListener("beforeunload", beforeUnloadHandler);

        if (data.code == 200){
            dataCita.transaccionVirtual = data.data;
            // if (estadoPoliticas == "N"){
            //     await aceptarPoliticas();
            // }   
            guardarData();
            if(tipoBoton == "NUVEI"){
                // var myModal = new bootstrap.Modal(document.getElementById('metodoPago'));
                // myModal.show();
                await pasarelaNuvei();
                $('#btn-seleccionar-tarjeta').attr("href",`/citas-seleccionar-tarjeta/{{ $tokenCita }}`)
                $('#btn-agregar-tarjeta').attr("href",`/citas-informacion-pago/{{ $tokenCita }}`)
            }else{
                if(tipoBoton == "KUSHKI"){
                    // let ulrParams = btoa(JSON.stringify(dataCita));
                    let ruta = `/external/payment/kushki/{{ $tokenCita }}`;
                    console.log(ruta);
                    window.location.href = ruta;
                }else{
                    location.href = data.data.linkPagoPTP;
                }
            }
        }else{
            alert(data.message);
        }
    }

    function pasarelaNuvei(){
		let paymentCheckout = new PaymentCheckout.modal({
		    client_app_code: dataCita.transaccionVirtual.applicationCode, // Client Credentials
		    client_app_key: dataCita.transaccionVirtual.applicationKey, // Client Credentials
		    locale: 'es', // User's preferred language (es, en, pt). English will be used by default.
		    env_mode: '{{ \App\Models\Veris::ENVIRONMENT_NUVEI }}', // `prod`, `stg`, `local` to change environment. Default is `stg`
		    onOpen: function () {
		    	console.log('modal open');
		    },
		    onClose: function () {
		    	console.log('modal closed');
		    	$('.btnNuvei').css('pointer-events','auto')
		    },
		    onResponse: function (response) {
				console.log('modal response');
		        //document.getElementById('response').innerHTML = JSON.stringify(response);
		        if(response.transaction.status == "success" && response.transaction.status_detail == 3){
		        	console.log(JSON.stringify(response));
		        	console.log("Inicio Enviando formulario de pago TC");
		        	$('.btnNuvei').hide();
		        	createPostForm(response);
		        	$('.btnNuvei').hide();
		        	showLoader();
		        	showError('Procesando pago, por favor no cierre el navegador.');
		        	//alert('Procesando pago, por favor no cierre el navegador. '+response.message);
		        	/*armar formulario y hacer submit a procesarlo*/
		        	// $('#metodo-pago-form').submit();
		        }else{
		        	$('.btnNuvei').css('pointer-events','auto')
		        	console.log(response);
		        	alert("Transaciión rechazada, intenta con otra tarjeta");
		        }
		    }
		});

		paymentCheckout.open({
			user_id: String(dataCita.transaccionVirtual.codigoTransaccion),
			user_email: getInput('mail'), //optional
			user_phone: "{{ $paciente->data->telefonoMovil }}",//optional
			order_description: dataCita.transaccionVirtual.reference,
			order_amount: dataCita.facturacion.totales.total,
			order_vat: 0,
			order_taxable_amount: 0,
			order_tax_percentage: 0,
			order_reference: dataCita.transaccionVirtual.orderReference,
		});
	}

	async function llenarDataDetallesCitas(){
		let elem = ``;
		$.each(dataCita.facturacion.detalleServicio.citas, function(key, value){
		    elem = `<p class="text-primary-veris fs--16 line-height-20 fw-medium mb-1">${capitalizarCadaPalabra(value.especialidad)}</p>`;
	        if(value.esTeleconsulta == "N"){    
	            elem += `<p class="fw-medium fs--1 line-height-16 mb-1">${capitalizarCadaPalabra(value.centroMedico)}</p>`;
	        }
	        elem += `<p class="fs--2 line-height-16 mb-1">${value.fechaHoraCita}</b></p>
            <p class="fs--2 line-height-16 mb-1 text-capitalize">Dr(a) ${value.doctor.toLowerCase()}</p>
            <p class="fs--2 line-height-16 mb-1 text-capitalize">${value.nombresPaciente.toLowerCase()}</p>`;
	        if(value.convenio != null && value.convenio != ""){
	            elem += `<p class="fs--2 line-height-16 mb-1 text-capitalize">${ value.convenio.toLowerCase() }</p>`
	        }
		})
		$('#contentDetalleCita').html(elem);
    }

	function createPostForm(response) {
		var $form = $('<form>', {
			method: 'POST',
			action: '/external/payment/nuvei/procesar/{{ $tokenCita }}'
		});

	    // Agregar el campo hidden para el CSRF token
	    var csrfToken = $('meta[name="csrf-token"]').attr('content');

		var $csrfTokenInput = $('<input>', {
		    type: 'hidden',
		    name: '_token',
		    value: csrfToken
		});


		var $tipoIdentificacionNuvei = $('<input>', {
			type: 'text',
			name: 'tipoIdentificacionNuvei',
			value: $('#tipoIdentificacion option:selected').val()
		});

		var $numeroIdentificacionNuvei = $('<input>', {
			type: 'text',
			name: 'numeroIdentificacionNuvei',
			value: $('#numeroIdentificacion').val()
		});

		var $idPreTransaccionNuvei = $('<input>', {
			type: 'text',
			name: 'idPreTransaccionNuvei',
			value: preTransaccion.data.codigoPreTransaccion
		});

		var $codigoEPagoNuvei = $('<input>', {
			type: 'text',
			name: 'codigoEPagoNuvei',
			value: dataCita.transaccionVirtual.codigoTransaccion
		});

		// Campo oculto con el objeto convertido a texto
		var $datosNuvei = $('<input>', {
			type: 'text',
			name: 'datosNuvei',
			value: JSON.stringify(response)
		});

		var $codigoReserva = $('<input>', {
			type: 'text',
			name: 'codigoReservaNuvei',
			value: {{ request()->query('codArticulo') }}
		});

		var $canalOrigenPost = $('<input>', {
			type: 'text',
			name: 'canalOrigenNuvei',
			value: canalOrigen
		});

		var $submitButton = $('<input>', {
			type: 'submit',
			value: 'Enviar'
		});


		// Agregar los elementos al formulario
		$form.append($tipoIdentificacionNuvei, $numeroIdentificacionNuvei, $idPreTransaccionNuvei, $codigoEPagoNuvei, $datosNuvei, $submitButton, $codigoReserva, $submitButton);

		// Agregar el formulario a algÃºn lugar en el documento
		$('body').append($form);

		//Enviar formulario
		$form.submit();

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
            }else{
                $('.modalDesglose-size').removeClass('modal-md');
                $('.modalDesglose-size').addClass('modal-lg');
            }
        }else{
            if(dataCita.facturacion.detalleServicio.detallePaquetes === null){
                $.each(dataCita.facturacion.detalleServicio.detallePacientes, function(key, value){
                    elem = `<div class="row">
                        <div class="col-12 text-center fw-medium fs--1 mb-2">${value.nombrePaciente}</div>`
                    
                    // $.each(dataCita.facturacion.detalleServicio.detalleOrdenes, function(key, value){
                    $.each(value.detalleExamenes, function(key, value){
                        elem += `<div class="col-12 col-md-6 mb-3">
                            <p class="text-start text-nowrap overflow-hidden text-truncate fs--2 mb-1">${value.nombreExamen}</p>
                            <div class="card bg-neutral shadow-none p-2">
                                <table class="card-body w-100">
                                    <tr class="border-bottom">
                                        <th class="fw-medium fs--2">P.V.P.</th>
                                        <th class="fw-medium fs--2">Crédito/convenio</th>
                                        <th class="fw-medium fs--2">IVA</th>
                                        <th class="fw-medium fs--2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <td class="fs--2">$${value.valorPaciente.toFixed(2)}</td>
                                        <td class="fs--2">$${value.valorCubreEmpresa.toFixed(2)}</td>
                                        <td class="fs--2">$${value.iva.toFixed(2)}</td>
                                        <td class="fs--2">$${value.valorVenta.toFixed(2)}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>`;
                    });
                    elem += `</div>`;
                })
                if(dataCita.facturacion.detalleServicio.detalleOrdenes.length < 2){
                    $('.modalDesglose-size').removeClass('modal-lg');
                    $('.modalDesglose-size').addClass('modal-md');
                }else{
                    $('.modalDesglose-size').removeClass('modal-md');
                    $('.modalDesglose-size').addClass('modal-lg');
                }
            }else{
                elem = `<div class="row">
                    <div class="col-12 text-center fw-medium fs--1 mb-2">Prestaciones</div>`
                $.each(dataCita.facturacion.detalleServicio.detalleOrdenes, function(key, value){
                    
                    // $.each(dataCita.facturacion.detalleServicio.detalleOrdenes, function(key, value){
                    //$.each(value.detalleExamenes, function(key, value){
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
                                        <td class="fs--2">$${value.valorPaciente.toFixed(2)}</td>
                                        <td class="fs--2">$${value.valorCubreEmpresa.toFixed(2)}</td>
                                        <td class="fs--2">$${value.iva.toFixed(2)}</td>
                                        <td class="fs--2">$${value.valorVenta.toFixed(2)}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>`;
                    //});
                })
                elem += `</div>`;
                if(dataCita.facturacion.detalleServicio.detalleOrdenes.length < 2){
                    $('.modalDesglose-size').removeClass('modal-lg');
                    $('.modalDesglose-size').addClass('modal-md');
                }else{
                    $('.modalDesglose-size').removeClass('modal-md');
                    $('.modalDesglose-size').addClass('modal-lg');
                }
            }
            /*elem = `<div class="row">
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
            }*/
        }
        $('#contenidoDesglose').append(elem);
    }

    function guardarData(){
        dataCita.datosIngresadosFactura = {            
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
        }
        localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
    }
</script>
<style>
	#layout-navbar{
		z-index: 9 !important;
	}
</style>
@endsection