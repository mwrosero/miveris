@extends('template.external')
@section('title')
Veris - Pago en línea
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
<section class="p-3 mb-3 box-aprobado d-none">
</section>
<section class="p-3 mb-3 box-transaccion">
	<h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue">Pago en línea</h5>
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
					                        <h5 class="text-veris-many fw-medium line-height-16 m-0">{{ __('Detalles del pago') }}</h5>
					                    </div>
					                    <div class="card-body p--2">
					                        <div class="" id="contentDetalleCita">
												<p class="text-primary-veris fs--16 line-height-20 fw-medium mb-1">{{ $info->nombreServicio }}</p>
												<p class="fw-medium fs--1 line-height-16 mb-1">Razón social: {{ $info->nombrePersonaFactura }}</p>
												<p class="fs--2 line-height-16 mb-1">Cédula/RUC: {{ $info->numeroIdentificacionFactura }}</p>
												@if($esServicioCaja)
												@foreach ($info->serviciosNivel1 as $servicio)
													<p class="fs--2 line-height-16 mb-1">{{ $servicio }}</p>
												@endforeach
												@endif
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
	<div class="row justify-content-center">
	    <div class="col-md-10 col-lg-8">
	        <div class="card bg-transparent shadow-none">
	            <div class="card-body p-0 p-md-3">
	                <form class="row g-3 form-factura needs-validation" novalidate>
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
	                                    <span class="col-5 mb-0 shadow-none cursor-inherit" id="totalLabel">${{ $info->valor }}</span>
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
	let dataNuvei;
	let referenceNuvei;
	let infoTransaccion = @json($info);
	let dataCita = {};
	dataCita.executionId = "{{ request()->input('executionId', '') }}";
	document.addEventListener("DOMContentLoaded", async function () {
		await obtenerCredenciales();
        await crearReferencia();

        $('body').on('change', '#checkTerminosCondicion', function(){
            if($('#checkTerminosCondicion').is(':checked')) {
                $('#btn-next').removeClass('disabled');
            } else {
                $('#btn-next').addClass('disabled');
            }
        });

        $('body').on('click', '#btn-next', async function(){
            //validar formulario datos factura
            await pasarelaNuvei();
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

	async function obtenerCredenciales(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/seguridad/parametrosNuvei?codigoAplicacion=MI_VERIS_WEB`;
        args["method"] = "GET";
        args["bodyType"] = "json";
        args["showLoader"] = false;
        const data = await call(args);
        dataNuvei = data.data;
        return data;
    }

    async function crearReferencia(){
    	let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/pagos_electronicos/nuvei/crear_referencia`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        args["data"] = JSON.stringify({
            "codigoEmpresa": parseInt({{ $codigoEmpresa }}),
            "codigoEpago": parseInt({{ $info->codigoEpago }})
        });
        const data = await call(args);
        referenceNuvei = data;
        return data;
    }

	function mostrarDesglose(){
        var myModal = new bootstrap.Modal(document.getElementById('modalDesglose'));
        myModal.show();
    }

    function pasarelaNuvei(){
		let paymentCheckout = new PaymentCheckout.modal({
		    client_app_code: dataNuvei.applicationCode, // Client Credentials
		    client_app_key: dataNuvei.applicationKey, // Client Credentials
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
		        	registrarPagoNuvei(response);
		        	$('.btnNuvei').hide();
		        	showLoader();
		        	//showError('Procesando pago, por favor no cierre el navegador.');
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
			user_id: String("{{ $info->codigoEpago }}"),
			user_email: "{{ $paciente->mail }}", //optional
			user_phone: "{{ $paciente->telefonoMovil }}",//optional
			order_description: referenceNuvei.data.reference,
			order_amount: {{ $info->valor }},
			order_vat: 0,
			order_taxable_amount: 0,
			order_tax_percentage: 0,
			order_reference: referenceNuvei.data.orderReference,
		});
	}

	async function registrarPagoNuvei(responseNuveiApproved) {
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/pagos_electronicos/transaccion_epago/{{ $info->codigoEpago }}`;
        args["method"] = "GET";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const dataTE = await call(args);

        if(dataTE.data.estaPagado){
        	// $('.box-aprobado').html(`<div class="col-12" style="text-align: center;font-size: 30px;font-weight: 700;">Pago realizado exitosamente.</div>`)
            // $('.box-aprobado').show();
            // $('.box-transaccion').hide();
            window.location.href = `/external/payment/comprobante?${ btoa(infoTransaccion.codigoEpago) }`;
        }else{
        	args = [];
	        args["endpoint"] = api_url + `/facturacion/v1/pagos_electronicos/nuvei/registrar_cobro`;
	        args["method"] = "POST";
	        args["bodyType"] = "json";
	        args["showLoader"] = true;
	        args["token"] = "{{ $accessToken }}";
	        args["data"] = JSON.stringify({
	            "codigoEmpresa": parseInt({{ $codigoEmpresa }}),
	            "codigoEpago": parseInt({{ $info->codigoEpago }}),
	            @if($esServicioCaja)
	            "nemonicoFlujoCobro": "{{ \App\Models\Veris::NEMONICO_FLUJO_PAGO }}",
	            @else
	            "nemonicoFlujoCobro": "{{ \App\Models\Veris::NEMONICO_FARMACIA }}",
	            @endif
                "metadataIdFlujoCobro": {
                    //"codigoIngresoVap": null,
                    @if($esServicioCaja)
                    "idPreTransaccion": infoTransaccion.codigoPreTransaccion,
                    @else
                    "codigoSolicitudServDomicilio": infoTransaccion.codigoSolicitudServDomicilio
                    @endif
                },
                "datosNuvei": responseNuveiApproved
	        });
	        const data = await call(args);
	        referenceNuvei = data;
		    if(response.code == 200){
                $('.box-aprobado').html(`<div class="col-12" style="text-align: center;font-size: 30px;font-weight: 700;">Pago realizado exitosamente.</div>`)
                $('.box-aprobado').show();
                $('.box-transaccion').hide();
            }else{
                alert(response.message)
                $('.box-transaccion').show();
                $('.box-aprobado').hide();
            }
        }
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