@extends('template.external')
@section('title')
Veris - Devoluciones
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<div class="rounded-3 w-100 w-md-50 bg-green d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-check me-2 text-green"></i>
    					<p class="mb-0 fs-12 line-height-14">Solicitud enviada con éxito.</p>
    				</div>
    				<div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 mt-2 txt-veris"></i>
    					<div class="info-step-3"></div>
    				</div>
    				{{-- <div class="mt-3 rounded-3 w-100 w-md-50 bg-white d-flex justify-content-start align-items-start p-3">
    					<i class="fa-solid fa-circle-info me-2 mt-2 txt-veris"></i>
    					<p class="mb-0 fs-12 line-height-14"><span class="text-veris fw-medium">Pronto te notificaremos vía whatsapp o mail, </span> <span class="txt-veris fw-medium">que tu devolución esta efectuada con éxito.</span></p>
    				</div> --}}
    			</div>
    		</div>
    		<div class="col-12 mt-3 box-step step-4 d-none">
    			<div class="w-100 rounded-3 p-2 p-md-4 bg-blue-sky">
    				<div class="rounded-3 w-100 w-md-50 bg-green d-flex justify-content-start align-items-start p-3">
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
</style>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
		await obtenerTracking();
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
	    	// dataDevolucion.parametros = data.data
	    	let detalle = data.data.rows[0];
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
	    		elem += `<h3 class="fs-18 text-veris mb-1">Estado: Transferencia rechazada</h3>`;
	    	}else{
	    		elem += `<h3 class="fs-18 text-veris mb-1">Estado: En Proceso</h3>`;
		    	elem += `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Fecha de solicitud:</span> ${detalle.notaCredito.fechaEmision}</p>`;
		    	elem += `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Valor:</span> $${detalle.notaCredito.valorTotal}</p>`;
		    	elem += `<p class="mb-0 fs-14 line-height-14"><span class="txt-veris">Motivo:</span> ${detalle.notaCredito.descripcionMotivo}</p>`;
		    	$('.info-step-3').html(elem);
		    	$('.step-3').removeClass('d-none');
	    	};
	    }
	}
</script>
@endsection