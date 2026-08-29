@extends('template.app-template-veris')
@section('title')
Mi Veris - Preparación previa
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24 title-preparacion"></h5>
    </div>

    <section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-4">
                    <div class="row g-3 justify-content-center">
                    	<div class="col-auto ps-3 pe-3 box-content-info" style="max-width: 350px;">
	                    	<p class="fs-18 line-height-24 text-start fw-medium text-veris mb-3 subtitle-preparacion"></p>
	                    	<ul id="lista-preparacion" class="ps-0 list-unstyled">	                    		
	                    	</ul>
	                    	<div class="box-actions d-none mt-5 w-100">
		                    	<div class="form-check d-flex justify-content-md-center align-items-center mb-3">
		                            <input class="form-check-input terminos-input me-2 mb-1 width-24" type="checkbox" value="" id="checkTerminosCondicion" required>
		                            <label class="form-check-label fs--1 line-height-16" for="checkTerminosCondicion">
		                                Leí y estoy de acuerdo con la preparación previa.
		                            </label>
		                            <div class="invalid-feedback">
		                                Debes aceptar antes de continuar
		                            </div>
		                        </div>
		                        <button type="button" class="btn btn-primary-veris fs--18 line-height-24 w-100 py-3 px-32 shadow-none d-flex justify-content-center align-items-center disabled" id="btn-next">
		                        	<span class="shadow-none">Entendido</span>
		                        </button>
		                        {{-- <a href="/servicio-domicilio" class="btn btn-primary-veris fs--18 line-height-24 w-100 py-3 px-32 shadow-none d-flex justify-content-center align-items-center disabled" id="btn-next">
		                        	<span class="shadow-none">Entendido</span>
		                        </a> --}}
		                    </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let tiposAgendaPermitida = ["CONSULTA_MEDICA","TERAPIA_FISICA","IMAGENES","PROCEDIMIENTOS"];
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    console.log(dataCita);
    
    document.addEventListener("DOMContentLoaded", async function () {
    	await drawPreparacionPrevia();
    	if(dataCita.promocion.tipoServicio == "IMAGENES" || dataCita.promocion.tipoServicio == "PROCEDIMIENTOS"){
    		// $('.box-actions').addClass('fixed-bottom').removeClass('d-none');
    		$('.box-actions').removeClass('d-none');
    		$('#btn-next').html(`<span class="shadow-none">Continuar</span>`);
    	}else{
    		$('.form-check').addClass('d-none')
    		// $('.box-actions').addClass('sticky-bottom').removeClass('d-none');
    		$('.box-actions').removeClass('d-none');
    		if(_canalOrigen == "VER_PMF"){
	    		$('#btn-next').html(`<span class="shadow-none">Entendido</span>`);
	    	}else{
	    		$('#btn-next').html(`<span class="shadow-none">Ir a la sección domicilio</span>`);
	    	}
	    	$('#btn-next').removeClass('disabled');
    	}

    	$('body').on('change', '#checkTerminosCondicion', function(){
            if($('#checkTerminosCondicion').is(':checked')) {
                $('#btn-next').removeClass('disabled');
            } else {
                $('#btn-next').addClass('disabled');
            }
        });

        $('body').on('click', '#btn-next', async function(){
        	// window.history.back();
        	// return;
        	if(_canalOrigen == "VER_PMF"){
        		window.history.back();
        		return;
        	}
        	if(dataCita.promocion.tipoServicio == "LABORATORIO"){
        		{{-- window.history.back(); --}}
        		location.href = `/servicio-domicilio`
        		return;
        	}
            let url = '/seleccionar-datos-cita/';
            if(dataCita.promocion.esOnline == "S"){
                url = '/citas-elegir-fecha-doctor/';
            }

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        })

    })

    async function drawPreparacionPrevia(){
    	$('.title-preparacion').html(`${ (dataCita.promocion.tipoServicio == "LABORATORIO") ? `Información` : `Preparación previa` }`)
    	// $('.subtitle-preparacion').html(`${ (dataCita.promocion.tipoServicio == "LABORATORIO") ? `Preparación previa` : `Lee y acepta la preparación previa` }`)
    	$('.subtitle-preparacion').html(`${ (dataCita.promocion.tipoServicio == "LABORATORIO") ? `Preparación previa` : `` }`)
    	if(dataCita.promocion.tipoServicio == "LABORATORIO"){
    		if(_canalOrigen != "VER_PMF"){
	    		$('.box-content-info').prepend(`<div class="d-flex justify-content-between align-items-center p-2 mb-3 rounded-3 box-legend">
	    			<i class="fa-solid fa-circle-info me-3 fs-24 text-primary-veris"></i>
	    			<p class="mb-0 fs--1 line-height-16 my-1"><span class="fw-bold">Solicita</span> la visita de laboratorio a domicilio en la <span class="fw-bold">sección domicilio.</span></p>
	    		</div>`)
	    	}
    	}
    	let elem = ``;
    	$.each(dataCita.promocion.preparacionPrevia, function(key, value){
    		elem += `<li class="fs--1 line-height-16 mb-2 d-flex justify-content-start align-items-start"><i class="fa-solid fa-circle mt-1 me-2" style="font-size: 5px"></i>${value.valor.charAt(0)}${value.valor.toLowerCase().substring(1)}</li>`;
    	})
    	$('#lista-preparacion').html(elem);
    }
</script>
<style>
    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal) .layout-page:before{
        display: none;
    }

    #lista-preparacion{
		/*max-height: 45vh;
    	overflow-y: auto;*/
    }

    .box-actions {
    	background: #f8f7fa;
	    width: 350px;
	    left: 0;
	    right: 0;
	    bottom: 20px;
	    margin: auto;
	}
	.box-actions.sticky-bottom{
		width: 100%;
	}
	.sticky-bottom #btn-next{
		width: 100% !important;
	}
	.box-legend{
		border: 1px solid #5489F2;
		background: #E6F1FA;
		width: 100%;
	}
	.box-legend p{
		color: #19408F;
	}
</style>
@endpush