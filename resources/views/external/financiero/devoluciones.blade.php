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
{{-- Modal de verificacion --}}
<div class="modal modal-top" id="modalVerificacion" tabindex="-1" aria-labelledby="modalVerificacionLabel">
    <div class="modal-dialog modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Información del Comprobante') }}</h5>
                <div class="row gx-2 justify-content-between align-items-center">
                	<div class="box-datos">
                	</div>
                	<p class="fs--16 line-height-16 my-2 text-veris fw-bold">Detalles:</p>
                    <ul class="list-group mb-0 border-0 p-0" id="listaPrestaciones">
                    </ul>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <button type="button" class="btn fw-normal fs--16 badge bg-menu-theme text-white m-0 px-4 py-2 fs-4 mx-2" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 fs-4 mx-2 btn-continuar-nc" data-bs-dismiss="modal"><i class="fa-regular fa-circle-check me-2"></i>Continuar</button>
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
    			<span class="d-flex align-items-center justify-content-center step step-2-number mx-auto p-2 mb-2 fs-20">2</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 fw-medium label-step-2">Datos bancarios</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">Llena el formulario con los<br>datos bancarios solicitados.</p>
    		</div>
    		<div class="col-6 col-md-3 text-center p-3">
    			<span class="d-flex align-items-center justify-content-center step step-3-number mx-auto p-2 mb-2 fs-20">3</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 fw-medium label-step-3">Devolución en proceso</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">¡Ya casi terminamos!<br>Pronto obtendrás tu devolución.</p>
    		</div>
    		<div class="col-6 col-md-3 text-center p-3">
    			<span class="d-flex align-items-center justify-content-center step step-4-number mx-auto p-2 mb-2 fs-20">4</span>
    			<p class="fs--1 line-height-16 fw-normal mb-1 fw-medium label-step-4">Devolución lista</p>
    			<p class="fs--3 line-height-12 fw-normal mb-0">¡Listo! revisa tu cuenta bancaria para<br>que veas reflejada tu devolución.</p>
    		</div>
    		<div class="col-12 mt-3 mb-0">
    			<div class="progress" style="height: 8px;">
  					<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
    		</div>
    		<div class="col-6 text-start mt-2 fw-bold text-veris">
    			Progreso
    		</div>
    		<div class="col-6 text-end mt-2 fw-bold text-veris label-porcentaje">
    			25%
    		</div>
    		<div class="col-12 mt-3 box-step step-1">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<p class="fw-bold text-veris">Formulario de devoluciones</p>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-between align-items-start p-3">
    					<i class="fa-solid fa-circle-info mt-1 me-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Para efectuar tu devolución con éxito,</span> <span class="txt-veris fw-medium">por favor ingresa el No. de Factura correcto.</span> Si la factura se valida, por favor ten a la mano los datos de la cuenta de banco y asegúrate que deben coincidir los datos de la factura.</p>
    				</div>
    				<p class="fs--2 fw-bold text-veris mt-3">Número de Factura<span class="text-danger">*</span></p>
    				<div class="d-flex mt-3 align-items-center justify-content-between">
    					{{-- <input type="text" maxlength="3" class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" autocomplete="off" id="first-input"> --}}
    					<input type="text" maxlength="3" 
							class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" 
							oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
							onkeypress="return validarNumeros(event)" 
							onblur="completarConCeros(this)" 
							required 
							autocomplete="off" 
							id="first-input">
    					<i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
    					{{-- <input type="text" maxlength="3" class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" autocomplete="off" id="medium-input"> --}}
    					<input type="text" maxlength="3" 
							class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" 
							oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
							onkeypress="return validarNumeros(event)" 
							onblur="completarConCeros(this)" 
							required 
							autocomplete="off" 
							id="medium-input">
    					<i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
    					{{-- <input type="text" maxlength="9" class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" autocomplete="off" id="last-input"> --}}
    					<input type="text" maxlength="9" 
							class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" 
							oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
							onkeypress="return validarNumeros(event)" 
							onblur="completarConCeros(this)" 
							required 
							autocomplete="off" 
							id="last-input">
    				</div>
    				<div class="row d-none box-errors-step-1">
    					<div class="col-12">
    						<div class="mt-3 rounded-3 w-100 w-md-50 bg-error border-error d-flex justify-content-between align-items-start p-3">
		    					<i class="fa-solid fa-circle-info mt-1 me-2 text-danger"></i>
		    					<p class="mb-0 fs-12 line-height-14 text-veris fw-medium" id="msg-error-step-1"></p>
		    				</div>
    					</div>
    				</div>
    				<button class="btn fs-14 fw-medium line-height-16 p-2 d-grid w-100 bg-veris rounded next-button mt-3 mb-3" id="btn-validar" type="button">Validar Factura</button>
    			</div>
    		</div>
    		<div class="col-12 mt-3 box-step step-2 d-none">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
	    			<div class="rounded-3 mb-3 w-100 w-md-50 bg-green d-flex justify-content-start align-items-start p-3">
						<i class="fa-solid fa-circle-check me-2 text-green"></i>
						<p class="mb-0 fs-12 line-height-14">La factura se validó con éxito.</p>
					</div>
    				<p class="fw-bold text-veris">Datos bancarios</p>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-between align-items-start p-3">
    					<i class="fa-solid fa-circle-info mt-1 me-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Por favor ingresa los datos de la cuenta bancaria,</span> <span class="txt-veris fw-medium">para poder efectuar la devolución.</span> Asegúrate que los datos de la factura coincidan con los mismos datos, nombre-apellido y cédula, del propietario de la cuenta bancaria.</p>
    				</div>
    				<div class="w-100 mt-3">
    					<label for="numeroIdentificacion" class="form-label fw-medium fs--1">No. Cédula o Pasaporte del Titular de la Cuenta<span class="text-danger">*</span></label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="numeroIdentificacion">
    				</div>
    				<div class="w-100 mt-3">
    					<label for="nombres" class="form-label fw-medium fs--1">Nombre y apellido del Titular de la Cuenta<span class="text-danger">*</span></label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2 onlyLetters" required="" id="nombres">
    				</div>
    				<div class="w-100 mt-3">
    					<label for="institucion" class="form-label fw-medium fs--1">Institución Bancaria<span class="text-danger">*</span></label>
    					<select type="text" class="select2 w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="institucion">
    						{{-- <option value="Bolivariano">Bolivariano</option>
    						<option value="Guayaquil">Guayaquil</option>
    						<option value="Produbanco">Produbanco</option> --}}
    					</select>
    				</div>
    				<div class="w-100 mt-3">
    					<label for="numeroCuenta" class="form-label fw-medium fs--1">Número de Cuenta<span class="text-danger">*</span></label>
    					<input type="text" maxlength="20" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="numeroCuenta" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" autocomplete="off">
    				</div>
    				<div class="w-100 mt-3">
    					<label class="form-label fw-medium fs--1">Tipo de Cuenta<span class="text-danger">*</span></label>
    					<div class="d-flex justify-content-start align-items-center" id="listTiposCuenta">
    						{{-- <button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 active position-relative waves-effect me-3" data-rel="1">
    							<i class="fa-solid fa-money-bill me-2"></i>Corriente
    						</button>
    						<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 position-relative waves-effect" data-rel="2">
    							<i class="fa-solid fa-piggy-bank me-2"></i>Ahorros
    						</button> --}}
    					</div>
    				</div>
    				<div class="w-100 mt-3">
    					<label for="email" class="form-label fw-medium fs--1">Correo electrónico<span class="text-danger">*</span></label>
    					<input type="email" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="email">
    				</div>
    				<div class="row d-none box-errors-step-2">
    					<div class="col-12">
    						<div class="mt-3 rounded-3 w-100 w-md-50 bg-error border-error d-flex justify-content-between align-items-start p-3">
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
    		<div class="col-12 mt-3 box-step step-3 d-none">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<div class="rounded-3 w-100 w-md-50 bg-green d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-check me-2 text-green"></i>
    					<p class="mb-0 fs-12 line-height-14">Solicitud enviada con éxito.</p>
    				</div>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Revisa tu correo electrónico </span> <span class="txt-veris fw-medium">para que puedas darle seguimiento</span> a tu solicitud.</p>
    				</div>
    				{{-- <div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Pronto te notificaremos vía whatsapp o mail, </span> <span class="txt-veris fw-medium">que tu devolución esta efectuada con éxito.</span></p>
    				</div> --}}
    			</div>
    		</div>
    	</div>
    </section>
</div>
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
	#listaPrestaciones {
        max-height: 300px;
        overflow-y: auto;
    }
    .error-input{
    	border: 1px solid #ff000059 !important;
	    background: #ff00000f !important;
	}
</style>
<script>
	let dataDevolucion = {};
	document.addEventListener("DOMContentLoaded", async function () {
		await cargarInstitucionesBancarias();
		await cargarTiposCuenta();
		await parametrosDevoluciones();

		$('body').on('click', '.btn-continuar-nc', function(){
			datosConfirmados();
		})

		$('.select2').select2({
  			placeholder: 'Elegir'
		});

		$('body').on('click', '.btn-tipo', function(){
			$('.btn-tipo').removeClass('active');
			$(this).addClass('active');
		})

		$('body').on('click', '#btn-validar', async function(){
        	$('.box-errors-step-1').addClass('d-none');
			$('#msg-error-step-1').html(``);
			await validarComprobante();
		})

		$('body').on('click', '#btn-enviar', async function(){
			$('.box-errors-step-2').addClass('d-none');
			// $('#msg-error-step-2').html(``);
			let puedeCrearNC = await validarDatosNC();
			if(puedeCrearNC){
				await solicitarNC();
			}
		})

		$('body').on('change', '#numeroIdentificacion', function(){
			if( parseInt($(this).val()) != parseInt(dataDevolucion.comprobante.numeroIdentificacionPersonaFactura) ){
				$('.box-errors-step-2').removeClass('d-none');
				$('#nombres').val("");
			}else{
				$('.box-errors-step-2').addClass('d-none');
				$('#nombres').val(dataDevolucion.comprobante.nombrePersonaFactura);
			}
		})

		$('.onlyLetters').on('keypress keydown', function(e) {
	        // Permitir teclas de control como backspace, suprimir, flechas
	        const keyCode = e.keyCode || e.which;
	        const allowedKeys = [8, 9, 37, 39, 46]; // backspace, tab, left arrow, right arrow, delete

	        // Expresión regular para letras, tildes y ñ
	        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

	        // Permitir teclas de control
	        if (allowedKeys.includes(keyCode)) {
	          	return true;
	        }

	        // Validar caracteres permitidos
	        const char = String.fromCharCode(keyCode);
	        if (!regex.test(char)) {
	          	e.preventDefault();
	          	return false;
	        }
	    });

	});

	async function parametrosDevoluciones(){
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/util/parametros_devoluciones_automaticas?codigoEmpresa=1`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        console.log(data);

        if(data.code == 200){
        	dataDevolucion.parametros = data.data
        }
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
        	dataDevolucion.tiposCuenta = data.data
        	let elem = ``;
        	$.each(data.data, function(key, value){
        		if(value.nombreTipoCuenta == "AHORROS"){
        			elem += `<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 position-relative waves-effect me-3" data-rel="${value.codigoTipoCuenta}">
						<i class="fa-solid fa-piggy-bank me-2"></i>Ahorros
					</button>`
        		}else{
        			elem += `<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 position-relative waves-effect me-3" data-rel="${value.codigoTipoCuenta}">
						<i class="fa-solid fa-money-bill me-2"></i>Corriente
					</button>`;
        		}
        	})
        	$('#listTiposCuenta').html(elem);
        }
	}

	async function validarComprobante(){
		$('.box-datos').empty();
		let numeroComprobante = `${$('#first-input').val()}${$('#medium-input').val()}${$('#last-input').val()}`
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/comprobantes/factura_paciente/consulta_por_anulacion/devolucion_bancaria?codigoEmpresa=1&numeroComprobante=${numeroComprobante}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        console.log(data);

        if(data.code == 200){
        	dataDevolucion.comprobante = data.data;
        	if(data.data.permitirDevolucionesAutomaticas){
        		dataDevolucion.comprobante = data.data;
        		let elem_datos = `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Nro. Factura:</span> ${dataDevolucion.comprobante.numeroComprobante}</p>
        		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Fecha de emisión:</span> ${dataDevolucion.comprobante.fechaComprobante}</p>
        		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Identificación Factura:</span> ${dataDevolucion.comprobante.numeroIdentificacionPersonaFactura}</p>
        		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Nombre Factura:</span> ${dataDevolucion.comprobante.nombrePersonaFactura}</p>
        		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Identificación Paciente:</span> ${dataDevolucion.comprobante.numeroIdentificacionPaciente}</p>
        		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Nombre Paciente:</span> ${dataDevolucion.comprobante.nombrePaciente}</p>
        		<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Total:</span> $${dataDevolucion.comprobante.totales.paciente.valorTotal}</p>`;
	        	$('.box-datos').html(elem_datos);

	        	let elem_prestaciones = ``;
	        	$.each(dataDevolucion.comprobante.detalles, function(key,value){
		            //let class_estado_prestacion = (value.)
		            elem_prestaciones += `<li class="list-group-item text-veris border-0 mb-1 py-0 fs-14 line-height-14 text-start">
		                — ${ value.nombrePrestacion }
		                </li>`
		        })
		        $('#listaPrestaciones').html(elem_prestaciones);
		        $('#modalVerificacion').modal('show');
        	}else{
        		let mensajes = `<ul class="mb-0">`;
        		$.each(data.data.mensajeInformativo, function(k,v){
        			mensajes += `<li>${v}</li>`;
        		})
        		mensajes += `</ul>`;
        		$('#msg-error-step-1').html(`${mensajes}`);
        		$('.box-errors-step-1').removeClass('d-none');
        	}
        }

        //permitirDevolucionesAutomaticas
	}

	function datosConfirmados(){
		$('.box-step').addClass('d-none');
		$('.step-2').removeClass('d-none');
		$('.progress-bar').css('width','50%');
		$('.progress-bar').attr('aria-valuenow','50');
		$('.label-porcentaje').html(`50%`);
		$('.label-step-2').addClass('txt-veris');
		$('.step-2-number').addClass('active');
	}

	async function solicitarNC(){
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/comprobantes/anulacion_paciente/devolucion_bancaria?codigoEmpresa=${dataDevolucion.comprobante.codigoEmpresa}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        let payload = {
        	"secuenciaUsuario": dataDevolucion.parametros.secuenciaUsuario,
        	"nemonicoCanalFacturacion": "{{ $canalOrigen }}",
        	"secuenciaUsuarioAutorizacion": dataDevolucion.parametros.secuenciaUsuario,
        	"codigoMotivo": dataDevolucion.parametros.codigoMotivo,
        	"observacionMotivo": dataDevolucion.parametros.observacionMotivo,
        	"tipoDevolucion": "TRANSFERENCIA_AUTOMATICA",
        	"caja": dataDevolucion.parametros.caja,
        	"numeroOrden": dataDevolucion.comprobante.numeroOrden,
        	"secuenciaComprobante": dataDevolucion.comprobante.secuenciaComprobante,
        	"detalles": dataDevolucion.comprobante.detalles,
        	"pagos": dataDevolucion.comprobante.pagos,
        	"datosBancarios": {
        		"codigoTipoIdentificacionCuenta": dataDevolucion.comprobante.codigoTipoIdentificacionPersonaFactura,
        		"numeroIdentificacionCuenta": $('#numeroIdentificacion').val(),
        		"codigoInstitucion": parseInt($('#institucion').val()),
        		"numeroCuenta": $('#numeroCuenta').val(),
        		"codigoTipoCuenta": parseInt($('.btn-tipo.active').attr('data-rel')),
        		"nombreTitularCuenta": $('#nombres').val(),
        		"correoElectronico": $('#email').val()
        	}
        }

        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	$('.box-step').addClass('d-none');
			$('.step-3').removeClass('d-none');
			$('.progress-bar').css('width','75%');
			$('.progress-bar').attr('aria-valuenow','75');
			$('.label-porcentaje').html(`75%`);
			$('.label-step-3').addClass('txt-veris');
			$('.step-3-number').addClass('active');
        }else{
        	// $('#msg-error-step-2').html(`${mensajes}`);
        	$('.box-errors-step-2').removeClass('d-none');
        }
	}

	async function validarDatosNC(){
		let send = true;
		$('#numeroIdentificacion').removeClass('error-input');
		$('#nombres').removeClass('error-input');
		$('#numeroCuenta').removeClass('error-input');
		$('#email').removeClass('error-input');
		if($('#numeroIdentificacion').val() != dataDevolucion.comprobante.numeroIdentificacionPersonaFactura){
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

	// Valida que solo se puedan ingresar números
	function validarNumeros(event) {
	    return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) 
	        ? null 
	        : event.charCode >= 48 && event.charCode <= 57;
	}

	// Completa con ceros a la izquierda hasta el maxlength definido
	function completarConCeros(input) {
	    const maxLength = parseInt(input.getAttribute('maxlength'), 10);
	    if (input.value.length < maxLength) {
	        input.value = input.value.padStart(maxLength, '0');
	    }
	}

	// Adicional: Limita caracteres a `maxlength` manualmente si es necesario (por redundancia)
	function limitarCaracteres(input, maxLength) {
	    if (input.value.length > maxLength) {
	        input.value = input.value.slice(0, maxLength);
	    }
	}


</script>
@endsection