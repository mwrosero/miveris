@extends('template.external')
@section('title')
Veris - Devoluciones
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.js"></script>

<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
@include('external.components.navbar')

{{-- Modal de confirmacion de datos bancarios --}}
<div class="modal modal-top" id="modalDatosBancarios" tabindex="-1" aria-labelledby="modalDatosBancariosLabel">
    <div class="modal-dialog modal-dialog-centered mx-auto">
        <form class="modal-content rounded-3">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Confirmación de datos bancarios') }}</h5>
                <div class="row gx-2 justify-content-between align-items-center">
                	<div class="box-datos-bancarios rounded-3">
                	</div>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <button type="button" class="btn fw-normal fs--16 badge bg-menu-theme text-white m-0 px-4 py-2 fs-4 mx-2" data-bs-dismiss="modal">Corregir</button>
                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 fs-4 mx-2" id="btn-confirma-enviar" data-bs-dismiss="modal"><i class="fa-regular fa-circle-check me-2"></i>Confirmar</button>
            </div>
        </form>
    </div>
</div>

<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Proceso de devolución') }}</h5>
    </div>
    <section class="mb-0 p-3 pb-0">
    	<div class="row mt-0">
    		<div class="col-6 col-md-3 text-center p-3">
    			<span class="d-flex align-items-center justify-content-center step step-1-number active mx-auto p-2 mb-2 fs-20">1</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 txt-veris fw-medium label-step-1">Validación de factura</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">Valida tu factura para poder<br>proceder al siguiente paso.</p>
    		</div>
    		<div class="col-6 col-md-3 text-center p-3">
    			<span class="d-flex align-items-center justify-content-center step step-2-number active mx-auto p-2 mb-2 fs-20">2</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 txt-veris fw-medium label-step-2">Datos bancarios</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">Llena el formulario con los<br>datos bancarios solicitados.</p>
    		</div>
    		<div class="col-6 col-md-3 text-center p-3">
    			<span class="d-flex align-items-center justify-content-center step step-3-number active mx-auto p-2 mb-2 fs-20">3</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 fw-medium  txt-veris label-step-3">Devolución en proceso</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">¡Ya casi terminamos!<br>Pronto obtendrás tu devolución.</p>
    		</div>
    		<div class="col-6 col-md-3 text-center p-3">
    			<span class="d-flex align-items-center justify-content-center step step-4-number mx-auto p-2 mb-2 fs-20">4</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 fw-medium label-step-4">Devolución lista</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">¡Listo! revisa tu cuenta bancaria para<br>que veas reflejada tu devolución.</p>
    		</div>
    		<div class="col-12 mt-3 mb-0">
    			<div class="progress" style="height: 8px;">
  					<div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
    		</div>
    		<div class="col-6 text-start mt-2 fw-bold text-veris">
    			Progreso
    		</div>
    		<div class="col-6 text-end mt-2 fw-bold text-veris label-porcentaje">
    			75%
    		</div>
    		<div class="col-12 mt-3 box-step step-1 d-none">
    		</div>
    		<div class="col-12 mt-3 box-step step-2 d-none">
    		</div>
    		<div class="col-12 mt-3 box-step step-3 d-none">
    			<div class="row rounded-3 p-2 p-md-4 bg-blue-sky">
	    			<div class="col-12 col-lg-6 mb-3">
	    				<div class="rounded-3 w-100 bg-green d-flex justify-content-start align-items-start p-3" id="badge-info-status-3">
	    				</div>
	    				<div class="mt-3 rounded-3 w-100 bg-white d-flex justify-content-start align-items-start p-3">
	    					<i class="fa-solid fa-circle-info me-2 mt-2 txt-veris"></i>
	    					<div class="info-step-3"></div>
	    				</div>
	    				<div class="box-datos-antiguos">
	    					
	    				</div>
	    			</div>
	    			<div class="col-12 col-lg-6">
	    				<p class="fw-bold text-veris">Datos bancarios</p>
	    				<div class="mt-3 rounded-3 w-100 bg-white d-flex justify-content-between align-items-start p-3">
	    					<i class="fa-solid fa-circle-info mt-1 me-2 txt-veris"></i>
	    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Por favor ingresa los datos de la cuenta bancaria,</span> <span class="txt-veris fw-medium">para poder efectuar la devolución.</span> Asegúrate que los datos de la factura coincidan con los mismos datos, nombre-apellido y cédula, del propietario de la cuenta bancaria.</p>
	    				</div>
	    				<div class="w-100 mt-3">
	    					<label for="numeroIdentificacion" class="form-label fw-medium fs--1">Nro. Cédula o Pasaporte del Titular de la Cuenta<span class="text-danger">*</span></label>
	    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="numeroIdentificacion">
	    				</div>
	    				<div class="w-100 mt-2">
	    					<label for="nombres" class="form-label fw-medium fs--1">Nombre y apellido del Titular de la Cuenta<span class="text-danger">*</span></label>
	    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2 onlyLetters" required="" id="nombres">
	    				</div>
	    				<div class="w-100 mt-2">
	    					<label for="institucion" class="form-label fw-medium fs--1">Institución Bancaria<span class="text-danger">*</span></label>
	    					<select type="text" class="select2 w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="institucion">
	    					</select>
	    				</div>
	    				<div class="w-100 mt-2">
	    					<label for="numeroCuenta" class="form-label fw-medium fs--1">Número de Cuenta<span class="text-danger">*</span></label>
	    					<input type="text" maxlength="20" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="numeroCuenta" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" autocomplete="off">
	    				</div>
	    				<div class="w-100 mt-2">
	    					<label class="form-label fw-medium fs--1">Tipo de Cuenta<span class="text-danger">*</span></label>
	    					<div class="d-flex justify-content-start align-items-center" id="listTiposCuenta">
	    					</div>
	    				</div>
	    				<div class="w-100 mt-2">
	    					<label for="email" class="form-label fw-medium fs--1">Correo electrónico<span class="text-danger">*</span></label>
	    					<input type="email" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="email">
	    				</div>
	    				<div class="row d-none box-errors-step-2">
	    					<div class="col-12">
	    						<div class="mt-3 rounded-3 w-100 bg-error border-error d-flex justify-content-between align-items-start p-3">
			    					<i class="fa-solid fa-circle-info mt-1 me-2 text-danger"></i>
			    					<p class="mb-0 fs-12 line-height-14" id="msg-error-step-2">
			    						<span class="text-veris fw-medium">Hubo un inconveniente con uno de los campos del formulario,</span> por favor revisa bien la información o completa todos los campos requeridos que hagan falta.
			    					</p>
			    				</div>
	    					</div>
	    				</div>
	    				<button class="btn fs-14 fw-medium line-height-16 p-2 d-grid w-100 bg-veris rounded next-button mt-3 mb-3" id="btn-enviar" type="button">Enviar</button>
	    			</div>
	    		</div>
    		</div>
    		<div class="col-12 mt-3 box-step step-4 d-none">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<div class="rounded-3 w-100 w-md-50 d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-check me-2 text-green"></i>
    					<p class="mb-0 fs-12 line-height-14">Solicitud acreditada exitosamente.</p>
    				</div>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 mt-2 txt-veris"></i>
    					<div class="info-step-4"></div>
    				</div>
    				{{-- <div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 mt-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Pronto te notificaremos vía whatsapp o mail, </span> <span class="txt-veris fw-medium">que tu devolución esta efectuada con éxito.</span></p>
    				</div> --}}
    			</div>
    		</div>
    	</div>
    </section>
</div>
<script>
	let dataDevolucion = {};
	document.addEventListener("DOMContentLoaded", async function () {
		await obtenerTracking();

		$('body').on('click', '.btn-tipo', function(){
			$('.btn-tipo').removeClass('active');
			$(this).addClass('active');
		})

		$('body').on('click', '#btn-enviar', async function(){
			$('.box-datos-bancarios').empty()
			let puedeCrearNC = await validarDatosNC();
			if(puedeCrearNC){
				let elem = `<p class="fs--16 line-height-16 my-2 text-veris fw-bold">Detalles del titular de la cuenta:</p>
					<p class="mb-0 fs-14 line-height-14"><span class="txt-veris fw-medium">Nro. identificación:</span> ${ $('#numeroIdentificacion').val() }</p>
					<p class="mb-0 fs-14 line-height-14"><span class="txt-veris fw-medium">Nombre:</span> ${ $('#nombres').val() }</p>
					<p class="mb-0 fs-14 line-height-14"><span class="txt-veris fw-medium">Institución bancaria:</span> ${ $('#institucion option:selected').html() }</p>
					<p class="mb-0 fs-14 line-height-14"><span class="txt-veris fw-medium">Tipo de cuenta:</span> ${ $('.btn-tipo.active').attr("tipo-rel") }</p>
					<p class="mb-0 fs-14 line-height-14"><span class="txt-veris fw-medium">Nro. cuenta:</span> ${ $('#numeroCuenta').val() }</p>
					<p class="mb-0 fs-14 line-height-14"><span class="txt-veris fw-medium">Correo electrónico:</span> ${ $('#email').val() }</p>
				`;
				$('.box-datos-bancarios').html(elem);
				$('#modalDatosBancarios').modal('show');
			}
		})

		$('body').on('click', '#btn-confirma-enviar', async function(){
			$('.box-errors-step-2').addClass('d-none');
			// $('#msg-error-step-2').html(``);
			let puedeCrearNC = await validarDatosNC();
			if(puedeCrearNC){
				await solicitarNC();
			}
		})

	})

	async function obtenerTracking(){
		let args = [];
	    args["endpoint"] = api_url + `/facturacion/v1/comprobantes/notas_creditos_x_devoluciones_bancarias?codigoEmpresa=1&page=1&perPage=10&tipoNotaCredito=TODOS&tipoFiltro=NUM_PACIENTE_COMPROBANTE&codigoTipoIdentificacion={{ $tipoIdentificacion }}&numeroIdentificacion={{ $numeroIdentificacion }}&numeroComprobante={{ $numeroFactura }}`;
	    args["method"] = "GET";
	    args["showLoader"] = true;
	    args["token"] = "{{ $accessToken }}";

	    const data = await call(args);
	    console.log(data);

	    if(data.code == 200){
	    	let detalle = data.data.rows[0];
	    	dataDevolucion.comprobante = detalle;
	    	let elem = ``;
	    	if(detalle.estadoTrackingDevolucion == "TRANSFERENCIA REALIZADA"){
	    		$('.box-step').addClass('d-none');
				$('.progress-bar').css('width','100%');
				$('.progress-bar').attr('aria-valuenow','100');
				$('.label-porcentaje').html(`100%`);
				$('.label-step-4').addClass('txt-veris');
				$('.step-4-number').addClass('active');
	    		elem += `<h3 class="fs-18 text-veris mb-1">Estado: Acreditada</h3>`;
	    		elem += `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Fecha de solicitud:</span> ${detalle.notaCredito.fechaEmision}</p>`;
		    	elem += `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Valor:</span> $${detalle.notaCredito.valorTotal}</p>`;
		    	elem += `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Motivo:</span> ${detalle.notaCredito.descripcionMotivo}</p>`;
		    	$('.info-step-4').html(elem);
		    	$('.step-4').removeClass('d-none');
	    	}else if(detalle.estadoPago == "REBOTE" && detalle.estadoTrackingDevolucion == "TRANSFERENCIA RECHAZADA"){
	    		$('#badge-info-status-3').html(`<i class="fa-solid fa-circle-info me-2 text-danger"></i>
	    			<p class="mb-0 fs-12 line-height-14"><b>Tu solicitud no fue aprobada.</b> Por favor, revisa los detalles e inténtalo nuevamente.</p>`).addClass('bg-error border-error');

	    		elem += `<h3 class="fs-18 text-veris mb-1 text-capitalize">Estado: ${ detalle.estadoTrackingDevolucion.toLowerCase() }</h3>
		    		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Fecha de solicitud:</span> ${detalle.notaCredito.fechaEmision}</p>
		    		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Valor:</span> $${detalle.notaCredito.valorTotal}</p>
		    		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Motivo:</span> ${detalle.notaCredito.descripcionMotivo}</p>`;

		    	$('.info-step-3').html(elem);

		    	$('.box-datos-antiguos').html(`<p class="fw-bold text-veris mt-3">Datos bancarios que utilizaste</p>
					<div class="w-100 mt-1">
    					<label class="form-label fw-medium fs--1">Nro. Cédula o Pasaporte del Titular de la Cuenta</label>
    					<input type="text" class="w-100 text-start disabled rounded-3 form-control fs--1 p-2" readonly value="${detalle.numeroIdentificacionCuenta}">
    				</div>
    				<div class="w-100 mt-1">
    					<label class="form-label fw-medium fs--1">Nombre y apellido del Titular de la Cuenta</label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2 disabled" value="${detalle.nombreTitularCuenta}" readonly>
    				</div>
    				<div class="w-100 mt-1">
    					<label class="form-label fw-medium fs--1">Institución Bancaria</label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2 disabled" value="${detalle.nombreInstitucion}" readonly>
    				</div>
    				<div class="w-100 mt-1">
    					<label class="form-label fw-medium fs--1">Número de Cuenta</label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2 disabled" value="${detalle.numeroCuenta}" readonly>
    				</div>
    				<div class="w-100 mt-1">
    					<label class="form-label fw-medium fs--1">Tipo de Cuenta</label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2 disabled" value="${detalle.nombreTipoCuenta}" readonly>
    				</div>
    				<div class="w-100 mt-1">
    					<label for="email" class="form-label fw-medium fs--1">Correo electrónico</label>
    					<input class="w-100 text-start rounded-3 form-control fs--1 p-2 disabled" value="${detalle.correoElectronico}" readonly>
    				</div>`);

		    	await cargarTiposCuenta();
		    	await cargarInstitucionesBancarias();

		    	$('.select2').select2({
		  			placeholder: 'Elegir'
				});

		    	$('.step-3').removeClass('d-none');
	    	}else{
	    		$('#badge-info-status-3').html(`<i class="fa-solid fa-circle-check me-2 text-green"></i>
	    			<p class="mb-0 fs-12 line-height-14">Solicitud enviada con éxito.</p>`).addClass('bg-green');
	    		elem += `<h3 class="fs-18 text-veris mb-1 text-capitalize">Estado: ${ detalle.estadoTrackingDevolucion.toLowerCase() }</h3>
		    		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Fecha de solicitud:</span> ${detalle.notaCredito.fechaEmision}</p>
		    		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Valor:</span> $${detalle.notaCredito.valorTotal}</p>
		    		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Motivo:</span> ${detalle.notaCredito.descripcionMotivo}</p>`;
		    	$('.info-step-3').html(elem);
		    	$('.step-3').removeClass('d-none');
	    	};
	    }
	}

	async function solicitarNC(){
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/comprobantes/registro_devoluciones_bancarias?accion=REGISTRO_BANCARIO_PORTAL`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        let payload = {
        	"secuenciaDevBancaria": dataDevolucion.comprobante.secuenciaDevBancaria,
			"secuenciaComprobante": dataDevolucion.comprobante.secuenciaComprobante, 
			"codigoTipoIdentificacionCuenta": dataDevolucion.comprobante.codigoTipoIdentificacionCuenta,
			"numeroIdentificacionCuenta": $('#numeroIdentificacion').val(),
			"nombreTitularCuenta": $('#nombres').val(),
			"codigoTipoCuenta": parseInt($('.btn-tipo.active').attr('data-rel')), 
			"esTitularCuenta": dataDevolucion.comprobante.esTitularCuenta,
			"numeroCuenta": $('#numeroCuenta').val(),
			"codigoInstitucion": parseInt($('#institucion').val()),
			"correoElectronico": $('#email').val()
        }

        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	await showSuccessResend();
        }else{
        	// $('#msg-error-step-2').html(`${mensajes}`);
        	$('.box-errors-step-2').removeClass('d-none');
        }
	}

	async function showSuccessResend(){
		let elem = `<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
			<div class="rounded-3 w-100 w-md-50 bg-green d-flex justify-content-start align-items-start p-3">
				<i class="fa-solid fa-circle-check me-2 text-green"></i>
				<p class="mb-0 fs-12 line-height-14">Solicitud enviada con éxito.</p>
			</div>
			<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
				<i class="fa-solid fa-circle-info me-2 mt-1 txt-veris"></i>
				<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Pronto te notificaremos vía whatsapp o mail, </span> <span class="txt-veris fw-medium">que tu devolución esta efectuada con éxito.</span></p>
			</div>
		</div>`;
		$('.step-3').html(elem);
	}

	async function validarDatosNC(){
		let send = true;
		$('#numeroIdentificacion').removeClass('error-input');
		$('#nombres').removeClass('error-input');
		$('#numeroCuenta').removeClass('error-input');
		$('#email').removeClass('error-input');
		if($('#numeroIdentificacion').val() != dataDevolucion.comprobante.numeroIdentificacionCuenta){
			send = false;
			$('#numeroIdentificacion').addClass('error-input');
		}
		if($('#nombres').val() == ""){
			send = false;
			$('#nombres').addClass('error-input');
		}
		if($('#numeroCuenta').val() == ""){
			send = false;
			$('#numeroCuenta').addClass('error-input');
		}
		if($('.btn-tipo.active').attr('data-rel') == undefined){
			send = false;
		}
		if(!isValidEmailAddress($('#email').val())){
			send = false
			$('#email').addClass('error-input');
		}
		if(!send){
			$('.box-errors-step-2').removeClass('d-none');
		}
		return send;
	}

	async function cargarInstitucionesBancarias(){
		let args = [];
        args["endpoint"] = api_url + `/general/v1/instituciones/bancarias`;
        args["method"] = "GET";
        args["showLoader"] = false;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        if(data.code == 200){
        	let elem = ``;
        	$.each(data.data, function(key, value){
        		elem += `<option value="${value.codigoInstitucion}">${value.nombreComercial}</option>`;
        	})
        	$('#institucion').html(elem);
        }
	}

	async function cargarTiposCuenta(){
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/util/tipos_cuenta_bancaria`;
        args["method"] = "GET";
        args["showLoader"] = false;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        if(data.code == 200){
        	// dataDevolucion.tiposCuenta = data.data
        	let elem = ``;
        	$.each(data.data, function(key, value){
        		if(value.nombreTipoCuenta == "AHORROS"){
        			elem += `<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 position-relative waves-effect me-3" data-rel="${value.codigoTipoCuenta}" tipo-rel="Ahorros">
						<i class="fa-solid fa-piggy-bank me-2"></i>Ahorros
					</button>`
        		}else{
        			elem += `<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 position-relative waves-effect me-3" data-rel="${value.codigoTipoCuenta}" tipo-rel="Corriente">
						<i class="fa-solid fa-money-bill me-2"></i>Corriente
					</button>`;
        		}
        	})
        	$('#listTiposCuenta').html(elem);
        }
	}
</script>
<style>
	.step{
		width: 50px;
		height: 50px;
		border: 4px solid #9DA7B3;
		border-radius: 100%;
	}
	.step.active{
		border: 4px solid #0071CE;
	}
	.bg-blue-sky{
		background: #E6F1FA;
	}
	button.disabled {
	    background: #9DA7B3 !important;
	}
	.select2-selection {
	    border: 1px solid #3D4E66 !important;
	}
	#select2-nombres-container {
	    font-size: 0.875rem !important;    
	}
	.light-style .select2-container--default .select2-selection--single .select2-selection__rendered{
	    padding-left: 8px;
	    color: #3D4E66;
	}
	.btn-tipo{
		background: #fff;
		border: 1.5px solid #0071CE;
		color: #0071CE;
	}
	.btn-tipo:hover{
		background: #fff;
		border: 1.5px solid #0A2240;
	}
	.btn-tipo.active{
		background: #0A2240;
		border: 1.5px solid #0A2240;
		color: #fff;
	}
	.btn-tipo.active:after{
		content: '\f00c'; /* Código Unicode del icono */
    	font-family: 'Font Awesome 6 Free'; /* Especifica la fuente */
    	border-radius: 100%;
		background: #0071CE;
		color: #fff;
		width: 20px;
		height: 20px;
		position: absolute;
		top: -5px;
		right: -5px;
		font-size: 12px;
	}
	.bg-green{
		background: #B9F6CA;
		border: 1px solid #00C853
	}
	.text-green{
		color: #00C853;
	}
	.bg-error{
		background: #FBE9E7;
	}
	.border-error{
		border: 1px solid #D84315
	}
	.select2-selection__rendered{
		font-size: 0.875rem !important;
	}
	.box-datos-antiguos input {
		pointer-events: none;
	}
	.error-input{
    	border: 1px solid #ff000059 !important;
	    background: #ff00000f !important;
	}
	.box-datos, .box-datos-bancarios {
	    background: #E6F1FA;
	    padding: 10px;
	    border-radius: 8px;
	}
</style>
@endsection