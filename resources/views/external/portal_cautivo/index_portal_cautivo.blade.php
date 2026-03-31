@extends('template.external')
@section('title')
Veris - Portal Cautivo
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.0.6"></script>

<link rel="stylesheet" href="{{ asset('assets/css/theme-portal-cautivo.css?v=1.0.4')}}">

{{-- @include('external.components.navbar-portal-cautivo') --}}
{{-- <div id="splash">
	@include('external.bot.splash2')
</div> --}}
{{-- @include('external.components.navbar') --}}

{{-- <section class="p-2 m-2"> --}}
<section class="p-0 m-0">
	<div class="row mx-0">
		<div class="col-12 px-0">
			<div class="chat-area">
				<!-- chatbox -->
				<div class="chatbox">
					{{-- STEP 1 --}}
					<div class="step step-1 modal-dialog-scrollable">
						<div class="modal-content">
							<div class="msg-head bg-vris-light-grayish-blue-3">
								<div class="settings-tray rounded d-flex justify-content-center align-items-center">
									<img class="my-2" height="40px" src="{{ asset('assets/img/veris/logo-veris-2025.svg')}}">
								</div>
							</div>
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="alert bg-white m-3 rounded-3 align-items-start mb-4 alert-dismissible fade show d-flex justify-content-between align-items-top gap-2" role="alert">
									  	<i class="fa-regular fa-lightbulb text-veris-ai fs--20 mt-1"></i>
								        <div class="alert-text fw-normal text-secundario-midnight-blue-00 fs--1">
								            Si tienes <strong>síntomas severos</strong> y no puedes completar este formulario, solo asiste a la consulta.
								        </div>
									  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								    <div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								        	<h2 class="text-secundario-midnight-blue-00 mb-0">Hacemos más fácil cuidarte.</h2>
								        </div>
								        <p class="text-secundario-midnight-blue-00 fs--16 line-height-20 fw-normal mb-2">
								            Vamos ayudar a tu doctor a comprender mejor tus síntomas llenando los siguientes datos antes de tu cita.
								        </p>
								        <p class="text-secundario-midnight-blue-00 fs--16 line-height-20 fw-normal mb-2">
								            De esta forma, tu atención será más personalizada.
								        </p>
									    <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 my-4 py-4 fs--20 line-height-24 fw-medium" id="btn-comenzar">Continuar</button>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP 2 --}}
					<div class="step step-2 d-none modal-dialog-scrollable">
						<div class="modal-content">
							@include('external.portal_cautivo.navigation')
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								        	<h2 class="text-secundario-midnight-blue-00 mb-0">Comencemos con tu identificación.</h2>
								        </div>
								        <div class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 p-4 swipe-up-entry w-100">
										  	<div class="col-md-12 mb-2">
				                                <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Elige tu documento *</label>
				                                <select class="form-select fs--1 p-3" name="tipoIdentificacion" id="tipoIdentificacion" required>
				                                    <option value="2">Cédula</option>
				                                    <option value="3">Pasaporte</option>
				                                </select>
				                                <div class="invalid-feedback">
				                                    Elegir el tipo de documento.
				                                </div>
				                            </div>
				                            <div class="col-md-12">
				                                <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Número de documento *</label>
				                                <input type="number" class="form-control fs--1 p-3 w-100" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required />
				                                <div class="invalid-feedback">
				                                    Ingrese un numero de identificacion.
				                                </div>
				                            </div>
				                            <div class="col-12 text-center mt-4">
						                        <div class="form-check d-flex justify-content-md-center align-items-center">
						                            <input class="form-check-input terminos-input me-2 mb-1 width-24" type="checkbox" value="" id="checkTerminosCondicion" required>
						                            <label class="form-check-label text-start fs--1 fw-medium line-height-16 label-terminos" for="checkTerminosCondicion">
						                                Acepto los <a href="https://www.veris.com.ec/terminos-y-condiciones/" target="_blank" class="">Términos y condiciones</a> 
						                                <span id="politicas" class="d-none">y <a href="https://www.veris.com.ec/politicas/" target="_blank">Política de protección de Datos Personales</a></span>
						                            </label>
						                            <div class="invalid-feedback">
						                                Debes aceptar antes de enviar
						                            </div>
						                        </div>
						                    </div>
										</div>
									    <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 my-4 py-4 fs--20 line-height-24 fw-medium" disabled id="btn-validar">Continuar</button>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP 3 --}}
					<div class="step step-3 d-none modal-dialog-scrollable">
						<div class="modal-content">
							@include('external.portal_cautivo.navigation')
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								            <div>
									        	<h2 class="text-secundario-midnight-blue-00 mb-0">Hola, <span class="namePaciente">Michael</span>.</h2>
									        	<p class="fs--16 line-height-20 text-secundario-midnight-blue-00 mb-0">Selecciona tu cita.</p>
									        </div>
								        </div>
								        <div class="w-100 swipe-up-entry" id="lista-citas">
									        <div type="button" class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 px-2 w-100 shadow-sm item-cita">
											  	<div class="col-md-12 mb-2">
					                                <p class="text-secundario-midnight-blue-00 fs--16 line-height-20 fw-normal mb-2">Tendrás una cita con:</p>
					                                <div class="box-horario d-flex justify-content-between align-items-center gap-3">
					                                	<div style="background: url(https://dikg1979lm6fy.cloudfront.net/fotosMedicos/0913067625.jpg) no-repeat top center;    background-size: cover; border-radius: 100%; border: 1px solid #BAB9BE; width: 80px; height: 80px;">
					                                	</div>
					                                	<div class="infoCita flex-grow-1">
					                                		<p class="fs--16 line-height-20 mb-1 text-secundario-midnight-blue-00 fw-medium">Arianna Sofía Flores Alvarado</p>
					                                		<p class="fs--14 line-height-18 mb-1 text-Silver-676767 fw-normal">Medicina General</p>
					                                		<p class="fs--14 line-height-18 mb-1 text-veris-ai fw-medium">Hoy, 3:00 pm</p>
					                                	</div>
					                                </div>
					                            </div>
											</div>
											<div type="button" class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 px-2 w-100 shadow-sm item-cita">
											  	<div class="col-md-12 mb-2">
					                                <p class="text-secundario-midnight-blue-00 fs--16 line-height-20 fw-normal mb-2">Tendrás una cita con:</p>
					                                <div class="box-horario d-flex justify-content-between align-items-center gap-3">
					                                	<div style="background: url(https://dikg1979lm6fy.cloudfront.net/fotosMedicos/0913067625.jpg) no-repeat top center;    background-size: cover; border-radius: 100%; border: 1px solid #BAB9BE; width: 80px; height: 80px;">
					                                	</div>
					                                	<div class="infoCita flex-grow-1">
					                                		<p class="fs--16 line-height-20 mb-1 text-secundario-midnight-blue-00 fw-medium">Arianna Sofía Flores Alvarado</p>
					                                		<p class="fs--14 line-height-18 mb-1 text-Silver-676767 fw-normal">Medicina General</p>
					                                		<p class="fs--14 line-height-18 mb-1 text-veris-ai fw-medium">Hoy, 3:00 pm</p>
					                                	</div>
					                                </div>
					                            </div>
											</div>
										</div>
									    <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 mt-4 mb-1 py-4 fs--20 line-height-24 fw-medium" disabled id="btn-elegir-cita">Continuar</button>
									        <div type="button" id="btn-datos-erroneos" class="text-center py-3 text-veris-ai fw-medium fs--18 line-height-24">No soy esa persona</div>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP 4 --}}
					<div class="step step-4 d-none modal-dialog-scrollable">
						<div class="modal-content">
							@include('external.portal_cautivo.navigation')
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								            <div>
								        		<h2 class="text-secundario-midnight-blue-00 mb-0">Ahora sí, comencemos.</h2>
								        		<p class="fs--16 line-height-20 text-secundario-midnight-blue-00 mb-0">Te tomará solo unos minutos.</p>
								        	</div>
								        </div>
								        <div class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 pb-0 px-2 w-100 shadow-sm swipe-up-entry mb-3">
										  	<div class="col-md-12 mb-2">
				                                {{-- <label class="form-label fw-medium fs--1">¿Cuál es el motivo de tu visita?</label> --}}
				                                <p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">¿Cuál es el motivo de tu visita?</p>
				                                <div class="text-end ms-auto" style="max-width: 300px;">
				                                	<input type="radio" class="btn-check d-none" name="tipoCita" id="sentirse_mal" value="sentirse_mal" autocomplete="off">
				                                	<label class="btn btn-outline-primary fs--16 line-height-22 rounded-3 px-4 py-3 fw-normal mb-3 item-radio" for="sentirse_mal">
				                                		Me siento mal
				                                	</label>
				                                	<input type="radio" class="btn-check d-none" name="tipoCita" id="control" value="control" autocomplete="off">
				                                	<label class="btn btn-outline-primary fs--16 line-height-22 rounded-3 px-4 py-3 fw-normal mb-3 item-radio" for="control">
				                                		Es un control
				                                	</label>
				                                </div>
				                            </div>
				                        </div>
									    {{-- <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 mt-4 mb-1 py-4 fs--20 line-height-24 fw-medium" disabled id="btn-elegir-cita">Continuar</button>
									        <div type="button" id="btn-datos-erroneos" class="text-center py-3 text-veris-ai fw-medium fs--18 line-height-24">No soy esa persona</div>
									    </div> --}}
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP 5 --}}
					<div class="step step-5 d-none modal-dialog-scrollable">
						<div class="modal-content">
							@include('external.portal_cautivo.navigation')
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 pb-0 px-2 w-100 shadow-sm swipe-up-entry mb-3">
										  	<div class="col-md-12 mb-2">
				                                <p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">¿Dónde te duele?</p>
				                                <div class="alert bg-Light-Sky-Blue-Tint-90 rounded-3 align-items-start mb-3 alert-dismissible fade show d-flex justify-content-between align-items-top gap-2" role="alert">
												  	<i class="fa-regular fa-lightbulb text-veris-ai fs--20 mt-1"></i>
											        <div class="alert-text fw-normal text-secundario-midnight-blue-00 fs--1">
											            Puedes buscar tus síntomas utilizando el buscador o seleccionando una parte del cuerpo.
											        </div>
												  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
												</div>

												<ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
													<li class="nav-item flex-fill" role="presentation">
														<button class="nav-link fs--16 line-height-20 py-3 active" id="pills-buscador-tab" data-bs-toggle="pill" data-bs-target="#pills-buscador" type="button" role="tab" aria-controls="pills-buscador" aria-selected="true">Buscador</button>
													</li>
													<li class="nav-item flex-fill" role="presentation">
														<button class="nav-link fs--16 line-height-20 py-3" id="pills-cuerpo-tab" data-bs-toggle="pill" data-bs-target="#pills-cuerpo" type="button" role="tab" aria-controls="pills-cuerpo" aria-selected="false">Parte del cuerpo</button>
													</li>
												</ul>

												<div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
													<div class="tab-pane fade mt-3 show active" id="pills-buscador" role="tabpanel" aria-labelledby="pills-buscador-tab" tabindex="0">
														<p class="text-secundario-midnight-blue-00 fs--14 line-height-18 fw-normal mb-2">Busca tu molestia o dolor para mostrarte las opciones específicas.</p>
														<div class="d-flex gap-2 justify-content-between align-items-center mb-3 p-3 rounded-3" style="background: #0000000D;">
															<i class="fa-solid fa-magnifying-glass text-muted text-silver-neutral"></i>
															<input type="search" 
																class="fs--14 line-height-18 shadow-none border-0 text-silver-neutral bg-transparent flex-grow-1" 
																id="parte_cuerpo" 
																name="parte_cuerpo" 
																placeholder="Ej. Dolor de Cabeza" >
														</div>
													</div>
													<div class="tab-pane fade mt-3" id="pills-cuerpo" role="tabpanel" aria-labelledby="pills-cuerpo-tab" tabindex="0">
														<p class="text-secundario-midnight-blue-00 fs--14 line-height-18 fw-normal mb-2">Selecciona la parte del cuerpo dónde sientas molestia o dolor para mostrarte opciones generales.</p>
													</div>
												</div>
				                            </div>
				                        </div>
									    <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 my-4 py-4 fs--20 line-height-24 fw-medium" disabled id="btn-continuar-cuerpo">Continuar</button>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- chatbox -->
		</div>
	</div>
</section>
<script>
	// Previene "pull-to-refresh" en navegadores móviles
    document.addEventListener('touchstart', function (e) {
        // Guarda la posición vertical inicial cuando se toca la pantalla
        window.initialY = e.touches[0].clientY;
    });

    let currentStep = 1;
    document.addEventListener('touchmove', function (e) {
        // Calcula la diferencia entre la posición vertical actual y la inicial
        let currentY = e.touches[0].clientY;
        let diffY = currentY - window.initialY;

        // Si estamos en la parte superior del documento (scrollTop = 0) y se está haciendo scroll hacia abajo
        if (window.scrollY === 0 && diffY > 0) {
            // Previene el comportamiento de "pull-to-refresh"
            e.preventDefault();
        }
    }, { passive: false }); // `passive: false` es necesario para poder prevenir el comportamiento por defecto

	document.addEventListener("DOMContentLoaded", async function () {
		setTimeout(function(){
			// $('#splash').fadeOut(1000);
		}, 500);

		$('body').on('click', '#btn-comenzar', function(){
			$('.step').addClass('d-none');
			$('.step-2').removeClass('d-none');
			currentStep++;
		})

		$('body').on('change', '#checkTerminosCondicion', function(){
            if($('#checkTerminosCondicion').is(':checked')) {
                $('#btn-validar').attr('disabled', false);
            } else {
                $('#btn-validar').attr('disabled', true);
            }
        });

        $('body').on('click', '#btn-validar', function(){
			$('.step').addClass('d-none');
			$('.step-3').removeClass('d-none');
			//Realizar en el ws para obtener citas
			$('.item-cita').removeClass('item-cita-selected');
			$('#btn-elegir-cita').attr('disabled', true);
			currentStep++;
		})

		$('body').on('click', '#btn-elegir-cita', function(){
			let detalleCita = [];
			$('.step').addClass('d-none');
			$('.step-4').removeClass('d-none');
			currentStep++;
		})

        $('body').on('click', '.btn-back', function(){
        	switch(currentStep){
        		case 2:
        		case 3:
        		case 4:
					currentStep--;
        			$('.step').addClass('d-none');
					$(`.step-${currentStep}`).removeClass('d-none');
        		break;
        	}
        })

        $('body').on('click', '#btn-datos-erroneos', function(){
        	$('.step').addClass('d-none');
			$('.step-2').removeClass('d-none');
        	currentStep--;
        })

        $('body').on('click', '.item-cita', function(){
        	$('.item-cita').removeClass('item-cita-selected');
        	$(this).addClass('item-cita-selected');
        	$('#btn-elegir-cita').attr('disabled', false);
        })

        $('body').on('change', 'input:radio', function() {
        	let nombreGrupo = $(this).attr('name');
    		let valorSeleccionado = $(this).val();

    		console.log("Se cambió el grupo: " + nombreGrupo);
    		console.log("Nuevo valor seleccionado: " + valorSeleccionado);
    		currentStep++;
    		$('.step').addClass('d-none');
			$(`.step-${currentStep}`).removeClass('d-none');

    		/*switch(nombreGrupo){
    			case 'tipoCita':

    			break;
    		}*/
        })
		
	});
</script>
@endsection