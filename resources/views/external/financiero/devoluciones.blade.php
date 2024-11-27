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
    			<p class="fs--1 line-height-16 fw-normal mb-1 fw-medium label-step-2">Validación de factura</p>
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
    					<input type="text" maxlength="3" class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" id="first-input">
    					<i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
    					<input type="text" maxlength="3" class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" id="medium-input">
    					<i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
    					<input type="text" maxlength="9" class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 &amp;&amp; event.charCode <= 57" required="" id="last-input">
    				</div>
    				<button class="btn fs-14 fw-medium line-height-16 p-2 d-grid w-100 bg-veris rounded next-button mt-3 mb-3" id="btn-validar" type="button">Validar Factura</button>
    			</div>
    		</div>
    		<div class="col-12 mt-3 box-step step-2 d-none">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<p class="fw-bold text-veris">Datos bancarios</p>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-between align-items-start p-3">
    					<i class="fa-solid fa-circle-info mt-1 me-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Por favor ingresa los datos de la cuenta bancaria,</span> <span class="txt-veris fw-medium">para poder efectuar la devolución.</span> Asegúrate que los datos de la factura coincidan con los mismos datos, nombre-apellido y cédula, del propietario de la cuenta bancaria.</p>
    				</div>
    				<div class="w-100 mt-3">
    					<label for="cedula" class="form-label fw-medium fs--1">No. Cédula o Pasaporte del Titular de la Cuenta<span class="text-danger">*</span></label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="cedula">
    				</div>
    				<div class="w-100 mt-3">
    					<label for="nombres" class="form-label fw-medium fs--1">Nombre y apellido del Titular de la Cuenta<span class="text-danger">*</span></label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="nombres">
    				</div>
    				<div class="w-100 mt-3">
    					<label for="institucion" class="form-label fw-medium fs--1">Institución Bancaria<span class="text-danger">*</span></label>
    					<select type="text" class="select2 w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="nombres">
    						<option value="Bolivariano">Bolivariano</option>
    						<option value="Guayaquil">Guayaquil</option>
    						<option value="Produbanco">Produbanco</option>
    					</select>
    				</div>
    				<div class="w-100 mt-3">
    					<label for="numeroCuenta" class="form-label fw-medium fs--1">Número de Cuenta<span class="text-danger">*</span></label>
    					<input type="text" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="numeroCuenta">
    				</div>
    				<div class="w-100 mt-3">
    					<label class="form-label fw-medium fs--1">Tipo de Cuenta<span class="text-danger">*</span></label>
    					<div class="d-flex justify-content-start align-items-center">
    						<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 active position-relative waves-effect me-3" data-rel="A">
    							<i class="fa-solid fa-money-bill me-2"></i>Corriente
    						</button>
    						<button type="button" class="btn fs--16 line-height-24 m-0 p-2 px-4 shadow-none btn-tipo rounded-3 position-relative waves-effect" data-rel="A">
    							<i class="fa-solid fa-piggy-bank me-2"></i>Ahorros
    						</button>
    					</div>
    				</div>
    				<div class="w-100 mt-3">
    					<label for="email" class="form-label fw-medium fs--1">Correo electrónico<span class="text-danger">*</span></label>
    					<input type="email" class="w-100 text-start rounded-3 form-control fs--1 p-2" required="" id="email">
    				</div>
    				<button class="btn fs-14 fw-medium line-height-16 p-2 d-grid w-100 bg-veris rounded next-button mt-3 mb-3" id="btn-enviar" type="button">Enviar</button>
    			</div>
    		</div>
    		<div class="col-12 mt-3 box-step step-3 d-none">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<div class="rounded-3 w-100 w-md-50 bg-green d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-check me-2 text-green"></i>
    					<p class="mb-0 fs-12 line-height-14">Formulario enviado con éxito.</p>
    				</div>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Pronto te notificaremos vía whatsapp o mail, </span> <span class="txt-veris fw-medium">que tu devolución esta efectuada con éxito.</span></p>
    				</div>
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
</style>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
		$('.select2').select2({
  			placeholder: 'Elegir'
		});

		$('body').on('click', '.btn-tipo', function(){
			$('.btn-tipo').removeClass('active');
			$(this).addClass('active');
		})

		$('body').on('click', '#btn-validar', function(){
			$('.box-step').addClass('d-none');
			$('.step-2').removeClass('d-none');
			$('.progress-bar').css('width','50%');
			$('.progress-bar').attr('aria-valuenow','50');
			$('.label-porcentaje').html(`50%`);
			$('.label-step-2').addClass('txt-veris');
			$('.step-2-number').addClass('active');
		})

		$('body').on('click', '#btn-enviar', function(){
			$('.box-step').addClass('d-none');
			$('.step-3').removeClass('d-none');
			$('.progress-bar').css('width','75%');
			$('.progress-bar').attr('aria-valuenow','75');
			$('.label-porcentaje').html(`75%`);
			$('.label-step-3').addClass('txt-veris');
			$('.step-3-number').addClass('active');
		})
	});

</script>
@endsection