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
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0.1')}}">
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.0.6"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/body-part.js?v=1.0.7"></script>

<link rel="stylesheet" href="{{ asset('assets/css/theme-portal-cautivo.css?v=1.0.5')}}">

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
				                                <input type="number" class="form-control fs--1 p-3 w-100" name="numeroIdentificacion" pattern="^\S*$" id="numeroIdentificacion" placeholder="0999999999" required />
				                                <div class="invalid-feedback">
				                                    Ingrese un numero de identificacion.
				                                </div>
				                            </div>
				                            <div class="col-12 text-center mt-4">
						                        <div class="form-check d-flex justify-content-md-center align-items-center">
						                            <input class="form-check-input terminos-input me-2 mb-1 width-24 shadow border-box-light-blue" type="checkbox" value="" id="checkTerminosCondicion" required>
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
									<div class="alert bg-success-claro m-3 rounded-3 align-items-start mb-4 alert-dismissible fade show d-flex justify-content-between align-items-top gap-3" role="alert">
									  	<i class="fa-solid fa-circle-check text-lime-veris fs--20 mt-1"></i>
								        <div class="alert-text fw-normal text-secundario-midnight-blue-00 fs--1 flex-grow-1">
								            Los datos han sido validados <br> con éxito.
								        </div>
									  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								            <div>
									        	<h2 class="text-secundario-midnight-blue-00 mb-0">Hola, <span class="namePaciente"></span>.</h2>
									        	<p class="fs--16 line-height-20 text-secundario-midnight-blue-00 mb-0">Selecciona tu cita.</p>
									        </div>
								        </div>
								        <div class="w-100 swipe-up-entry" id="lista-citas">
									        {{-- <div type="button" class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 px-2 w-100 shadow-sm item-cita">
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
											</div> --}}
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
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP CONTROL --}}
					<div class="step step-control d-none modal-dialog-scrollable">
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
				                                <p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">Puedes describir el control</p>
												<div class="w-100 mb-3">
						                            <textarea rows="4" type="text" class="form-control fs--1 p-3 w-100 rounded-3" name="detalle_control" id="detalle_control">
						                            </textarea>
						                        </div>
				                            </div>
				                        </div>
				                        <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 my-4 py-4 fs--20 line-height-24 fw-medium" id="btn-finalizar-control">Continuar</button>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP 5 --}}
					<div class="step step-5 d-none modal-dialog-scrollable progreso-step">
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
												</div>

												<ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab" role="tablist">
													<li class="nav-item flex-fill" role="presentation">
														<button class="nav-link fs--14 line-height-18 py-3 active" id="pills-buscador-tab" data-bs-toggle="pill" data-bs-target="#pills-buscador" type="button" role="tab" aria-controls="pills-buscador" aria-selected="true">Buscador</button>
													</li>
													<li class="nav-item flex-fill" role="presentation">
														<button class="nav-link fs--14 line-height-18 py-3" id="pills-cuerpo-tab" data-bs-toggle="pill" data-bs-target="#pills-cuerpo" type="button" role="tab" aria-controls="pills-cuerpo" aria-selected="false">Parte del cuerpo</button>
													</li>
												</ul>

												<div class="tab-content bg-transparent px-0 px-lg-4 py-1" id="pills-tabContent">
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
														<div id="motivo-seleccionado-autocomplete"></div>
														<div id="listado-motivos-autocomplete"></div>
													</div>
													<div class="tab-pane fade mt-3" id="pills-cuerpo" role="tabpanel" aria-labelledby="pills-cuerpo-tab" tabindex="0">
														<p class="text-secundario-midnight-blue-00 fs--14 line-height-18 fw-normal mb-2">Selecciona la parte del cuerpo dónde sientas molestia o dolor para mostrarte opciones generales.</p>
														<ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab-vista" role="tablist">
															<li class="nav-item flex-fill" role="presentation">
																<button class="nav-link fs--14 line-height-18 py-3 active" id="pills-frente-tab" data-bs-toggle="pill" data-bs-target="#pills-frente" type="button" role="tab" aria-controls="pills-frente" aria-selected="true">Frente</button>
															</li>
															<li class="nav-item flex-fill" role="presentation">
																<button class="nav-link fs--14 line-height-18 py-3" id="pills-espalda-tab" data-bs-toggle="pill" data-bs-target="#pills-espalda" type="button" role="tab" aria-controls="pills-espalda" aria-selected="false">Espalda</button>
															</li>
														</ul>
														<div class="tab-content bg-transparent px-0 px-lg-4 pb-0" id="pills-tabContentParte">
															<div class="tab-pane fade mt-1 show active" id="pills-frente" role="tabpanel" aria-labelledby="pills-frente-tab" tabindex="0">
																<div id="body-svg-wrapper"></div>
															</div>
															<div class="tab-pane fade mt-1" id="pills-espalda" role="tabpanel" aria-labelledby="pills-espalda-tab" tabindex="0">
															</div>
														</div>
														{{-- <pre id="json-output" style="font-size:0.78rem; color:#8888aa; margin:0; white-space: pre-wrap; word-break: break-all;">[]</pre> --}}
														<div id="motivo-seleccionado"></div>
														<div id="listado-motivos"></div>
													</div>
												</div>
				                            </div>
				                        </div>
									    <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 my-4 py-4 fs--20 line-height-24 fw-medium" disabled id="btn-seleccionar-motivo">Continuar</button>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- STEP 6 --}}
					<div class="step step-6 d-none modal-dialog-scrollable progreso-step">
						<div class="modal-content">
							@include('external.portal_cautivo.navigation')
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								            <div>
									        	<h2 class="text-secundario-midnight-blue-00 mb-0">Hola, <span class="namePaciente"></span>.</h2>
									        	<p class="fs--16 line-height-20 text-secundario-midnight-blue-00 mb-0">Selecciona tu cita.</p>
									        </div>
								        </div>
								        <div class="w-100 swipe-up-entry" id="lista-citas">
									        <div type="button" class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 px-2 w-100 shadow-sm">
									        	<div class="col-md-12 mb-2">
				                                	<p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">¿Qué tan intenso es tu dolor?</p>
				                                	<p class="text-center color-ranking fw-medium valor-ranking-dolor mb-2 mt-4 fs--28 line-height-32">0</p>
				                                	<p class="text-center color-ranking fw-medium descripcion-ranking-dolor mb-4 fs--16 line-height-20"></p>
				                                	<div class="rating-card mb-3">
				                                		<div class="emoji-rating d-flex justify-content-between align-items-center">
				                                			<div type="button" class="btn-ranking bg-neutral-05 border-neutral-10 rounded-3 py-2 px-1 fs-32 line-height-36" data-ranking="1">😃</div>
				                                			<div type="button" class="btn-ranking bg-neutral-05 border-neutral-10 rounded-3 py-2 px-1 fs-32 line-height-36" data-ranking="2">😊</div>
				                                			<div type="button" class="btn-ranking bg-neutral-05 border-neutral-10 rounded-3 py-2 px-1 fs-32 line-height-36" data-ranking="3">😐</div>
				                                			<div type="button" class="btn-ranking bg-neutral-05 border-neutral-10 rounded-3 py-2 px-1 fs-32 line-height-36" data-ranking="4">😖</div>
				                                			<div type="button" class="btn-ranking bg-neutral-05 border-neutral-10 rounded-3 py-2 px-1 fs-32 line-height-36" data-ranking="5">😫</div>
				                                		</div>
				                                	</div>
				                                	<div class="d-flex justify-content-between align-items-center gap-2">
				                                		<span>Sin dolor</span>
				                                		<span>Dolor insoportable</span>
				                                	</div>
				                                </div>
											</div>
										</div>
									    <div class="footer-action w-100">
									        <button class="btn btn-primary-veris rounded-3 btn-continue w-100 mt-4 mb-1 py-4 fs--20 line-height-24 fw-medium" disabled id="btn-calificar-dolor">Continuar</button>
									    </div>
								    </div>
								</div>
							</div>
						</div>
					</div>

					{{-- Step gracias --}}
					
					<div class="step step-gracias d-none modal-dialog-scrollable progreso-step">
						<div class="modal-content">
							<div class="msg-head bg-vris-light-grayish-blue-3">
								<div class="settings-tray rounded d-flex justify-content-center align-items-center">
									<img class="my-2" height="40px" src="{{ asset('assets/img/veris/logo-veris-2025.svg')}}">
								</div>
							</div>
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="w-100 swipe-up-entry">
								        	<div class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 px-2 w-100 shadow-sm">
									        	<div class="col-md-12 mb-2 text-center">
									        		<i class="fa-solid fa-circle-check text-primary-veris fs--20 mt-1 mb-3 fs-72"></i>
									        		<h2 class="text-primary-veris fw-medium fs-24 line-height-28">Tus respuestas se han enviado con éxito.</h2>
									        		<p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">¡Nos vemos pronto <span class="namePaciente"></span>!</p>
									        		<img width="130px" src="{{ asset('assets/external/portal-cautivo/final-thank.svg') }}" alt="">
									        	</div>
										</div>
									    <div class="footer-action w-100 mb-3">
									        <a href="https://www.veris.com.ec" class="btn btn-primary-veris rounded-3 btn-continue w-100 mt-4 mb-1 py-4 fs--20 line-height-24 fw-medium">Salir</a>
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
    {{-- document.addEventListener('touchstart', function (e) {
        // Guarda la posición vertical inicial cuando se toca la pantalla
        window.initialY = e.touches[0].clientY;
    }); --}}

    document.addEventListener('touchstart', function (e) {
	    window.initialY = e.touches[0].clientY;
	}, { passive: true }); // <--- Agrega esto

    let _codigoEmpresa = 1;
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


    let descripcionDolor = ["","Sin dolor","Dolor leve","Dolor moderado","Dolor fuerte","Dolor insoportable"];
    let preguntas;

	document.addEventListener("DOMContentLoaded", async function () {
		setTimeout(function(){
			// $('#splash').fadeOut(1000);
		}, 500);

		$('body').on('change', '#tipoIdentificacion', function(){
			$('#numeroIdentificacion').val('');
            if(numeroIdentificacion == "2") {
                $('#numeroIdentificacion').attr('type', 'number');
            } else {
                $('#numeroIdentificacion').attr('type', 'text');
            }
        });

        $('#numeroIdentificacion').on('keydown', function(event) {
		  	if (event.key === ' ') {
		    	event.preventDefault();
		  	}
		});

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

        $('body').on('click', '#btn-validar', async function(){
			let citas = await obtenerCitas();
			
			if(citas.code == 200){
				if(citas.data.length == 0){
					showMessage('warning','No existen citas asociadas a su identificación.');
					return;
				}else{
					$('.step').addClass('d-none');
					$('.step-3').removeClass('d-none');
					let elem = ``;
					$.each(citas.data, function(key, value){
						let img_doctor = (value.fotoMedico != null) ? value.fotoMedico : '{{ asset('assets/img/svg/avatar_doctor.svg') }}';
						elem += `<div type="button" class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 px-2 w-100 shadow-sm item-cita" data-rel='${ JSON.stringify(value) }'>
								  	<div class="col-md-12 mb-2">
		                                <p class="text-secundario-midnight-blue-00 fs--16 line-height-20 fw-normal mb-2">Tendrás una cita con:</p>
		                                <div class="box-horario d-flex justify-content-between align-items-center gap-3">
		                                	<div style="background: url(${img_doctor}) no-repeat top center;    background-size: cover; border-radius: 100%; border: 1px solid #BAB9BE; width: 80px; height: 80px;">
		                                	</div>
		                                	<div class="infoCita flex-grow-1">
		                                		<p class="fs--16 line-height-20 mb-1 text-secundario-midnight-blue-00 fw-medium text-capitalize">${value.nombreMedico.toLowerCase()}</p>
		                                		<p class="fs--14 line-height-18 mb-1 text-Silver-676767 fw-normal text-capitalize">${value.nombreEspecialidad.toLowerCase()}</p>
		                                		<p class="fs--14 line-height-18 mb-1 text-Silver-676767 fw-normal text-capitalize">${value.nombreSucursal.toLowerCase()}</p>
		                                		<p class="fs--14 line-height-18 mb-1 text-veris-ai fw-medium">${formatearFechaRelativa(value.horaInicio)}</p>
		                                	</div>
		                                </div>
		                            </div>
								</div>`;
						$('.namePaciente').html(capitalizarFirstLetter(value.primerNombrePaciente.toLowerCase()));
					})

					$('#lista-citas').html(elem);

					$('.item-cita').removeClass('item-cita-selected');
					$('#btn-elegir-cita').attr('disabled', true);
					currentStep++;
				}
			}else{
				showMessage('error', citas.message);
			}
		})

		$('body').on('click', '#btn-elegir-cita', function(){
			let detalleCita = [];
			$('.step').addClass('d-none');
			$('.step-4').removeClass('d-none');
			currentStep++;
		})

		$('body').on('click', '#btn-finalizar-control', async function(){
			console.log('traducir');
			showMessage('info', 'Estamos procesando sus respuestas.');
			await obtenerTraduccion('control');
			return;
        })

		$('body').on('click', '#btn-seleccionar-motivo', function(){
			let detalleCita = [];
			$('.step').addClass('d-none');
			$('.step-6').removeClass('d-none');
			currentStep++;
			actualizarProgreso(2, 12);
		})

		$('body').on('click', '.btn-continue-dinamico', async function(){
			let position = $(this).attr('stepNext-rel');
			let idInput = $(this).attr('idInput-rel');
			let isRequired = $(this).attr('isRequired-rel');

			let ultimaPregunta = $(`.step-${currentStep}`).attr('ultimaPregunta-rel');

			if(ultimaPregunta == "S"){
				showMessage('info', 'Estamos procesando sus respuestas.');
				await obtenerTraduccion('formulario');
				return;
			}

			if(isRequired){
				//if(getInput(idInput, 'radio') === undefined){
				if(getInput(idInput) === ""){
					showMessage('warning', 'El campo solicitado es obligatorio.');
					return;
				}
			}

			$('.step').addClass('d-none');
			$(`.step-${position}`).removeClass('d-none');
			currentStep++;
			actualizarProgreso(currentStep, preguntas.data.preguntas.length + 7);
		})

        $('body').on('click', '.btn-back', function(){
        	console.log('Before: '+currentStep);
			currentStep--;
			console.log('After: '+currentStep);
        	switch(currentStep){
        		case 2:
        		case 3:
        			$('.item-cita').removeClass('item-cita-selected');
		        	$('#btn-elegir-cita').attr('disabled', true);
		        break;
        		case 4:
		        	$('input[name="tipoCita"]').prop('checked', false);
				    state.selection = [];
				    renderSVG();
        			$('#motivo-seleccionado').empty();
				    $('#listado-motivos').empty();

        			$('#motivo-seleccionado-autocomplete').empty();
        			$('#listado-motivos-autocomplete').empty();
        			$('#parte_cuerpo').val('');

				    $('#btn-seleccionar-motivo').attr('disabled', true);
		        break;
        		case 5:
        			// $('input[name="tipoCita"]').prop('checked', false);
        			console.log("motivo cita")
        			actualizarProgreso(2, 12);
        		break;
        		// case 6:
        		// break;
        		default:
        			actualizarProgreso(currentStep, preguntas.data.preguntas.length + 7);
        			$(`.step-dinamico.step-${currentStep} input[type="radio"]`).prop('checked', false);
        	}
			$('.step').addClass('d-none');
			$(`.step-${currentStep}`).removeClass('d-none');
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

        $('#parte_cuerpo').on('keypress', async function(e) {
		    if (e.which === 13) {
		        // Evita que el formulario se envíe (si el input está dentro de uno)
		        e.preventDefault();
		        
		        // Captura el valor del input
		        let valorBusqueda = $(this).val();
		        await cargarDoloresAsociados(valorBusqueda);		        
		    }
		});

		$('body').on('click', '#btn-calificar-dolor', async function(){
			preguntas = await cargarPreguntas();
			if(preguntas.code == 200){
				await drawSeccionesCuestionario();
	        	$('.step').addClass('d-none');
				$('.step-7').removeClass('d-none');
	        	currentStep++;
	        	actualizarProgreso(currentStep, preguntas.data.preguntas.length + 7);
	        }else{
	        	showMessage('warning', data.message);
	        }
        })

        $('body').on('change', 'input:radio', async function() {
        	let nombreGrupo = $(this).attr('name');
    		let valorSeleccionado = $(this).val();

    		console.log("Se cambió el grupo: " + nombreGrupo);
    		console.log("Nuevo valor seleccionado: " + valorSeleccionado);

    		switch(nombreGrupo){
    			case 'tipoCita':
    				if(valorSeleccionado == "control"){
	    				currentStep++;
			    		$('.step').addClass('d-none');
						$(`.step-control`).removeClass('d-none');
					}else{
						currentStep++;
			    		$('.step').addClass('d-none');
						$(`.step-${currentStep}`).removeClass('d-none');
						actualizarProgreso(1, 12);
					}
    			break;
    			case 'motivoCita':
    				let detalle = JSON.parse($(this).attr('data-rel'));
    				var tab = $('#pills-tab .nav-link.active').text(); // "Buscador"
    				let idListado = (tab == "Buscador") ? `motivo-seleccionado-autocomplete` : `motivo-seleccionado`;
    				$(`#${idListado}`).html(`<span class="badge bg-primario-Royal-blue-Tint-90 my-2 btn-outline-primary-veris d-inline-block fw-medium fs--2 line-height-24 p-2 border rounded-3 me-2 text-wrap">${ capitalizarFirstLetter(detalle.descripcion) } <i class="fa-solid fa-xmark px-2 cursor-pointer btnEliminarDolor"></i></span>`);
    				$('#btn-seleccionar-motivo').attr('disabled', false);
    			break;
    			default:
    				let ultimaPregunta = $(`.step-${currentStep}`).attr('ultimaPregunta-rel');
					if(ultimaPregunta == "S"){
						showMessage('info', 'Estamos procesando sus respuestas.');
						await obtenerTraduccion();
						return;
					}

    				currentStep++;
		    		$('.step').addClass('d-none');
					$(`.step-${currentStep}`).removeClass('d-none');
    				actualizarProgreso(currentStep, preguntas.data.preguntas.length + 7);
    		}
        })

        $('body').on('click', '.btnEliminarDolor', function(){
        	var tab = $('#pills-tab .nav-link.active').text(); // "Buscador"
    		let idListado = (tab == "Buscador") ? `motivo-seleccionado-autocomplete` : `motivo-seleccionado`;
        	console.log(tab);
    		console.log({idListado});
        	$(`#${idListado}`).empty();
		    
		    $('#btn-seleccionar-motivo').attr('disabled', true);
		    $('input[name="motivoCita"]').prop('checked', false);
        });

        $('body').on('click', '.btn-ranking', function(){
        	let valor = $(this).attr('data-ranking');
        	$('.color-ranking').attr('data-ranking',valor);
			$('.valor-ranking-dolor').html(valor);
			$('.descripcion-ranking-dolor').html(descripcionDolor[valor]).removeClass('d-none');
        	$('.btn-ranking').removeClass('btn-ranking-selected py-3');
        	$(this).addClass('btn-ranking-selected py-3');
        	$('#btn-calificar-dolor').attr('disabled', false);
        })
		
	});

	function capitalizarFirstLetter(string) {
		if (!string) return "";
		return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
	}

	async function obtenerCitas(){
		let aditional = ``;
		@if($codigoSucursal)
			aditional = `&codigoSucursal={{ $codigoSucursal }}`;
		@endif
		let args = [];
        args["endpoint"] = `${api_url}/historiaclinica/v1/prediligenciamiento/agenda_paciente?codigoEmpresa=${_codigoEmpresa}${aditional}&codigoTipoIdentificacion=${getInput('tipoIdentificacion')}&numeroIdentificacion=${getInput('numeroIdentificacion').toUpperCase()}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = _token;
        args["dismissAlert"] = true;
        const data = await call(args);
        return data;
	}

	async function cargarDoloresAsociados(strBusqueda){
		let args = [];
        args["endpoint"] = `${api_url}/${api_war_ai}/v1/prediligencionamiento-hc/motivos/buscar`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = _token;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
		args["data"] = JSON.stringify({
		  	"texto": strBusqueda,
		  	"codigo_empresa": _codigoEmpresa
		});
        const data = await call(args);
        $('#motivo-seleccionado').empty();
        $('#btn-seleccionar-motivo').attr('disabled', true);
        var tab = $('#pills-tab .nav-link.active').text(); // "Buscador"
        let idListado = (tab == "Buscador") ? `listado-motivos-autocomplete` : `listado-motivos`;

        console.log(data);
        if(data.code == 200){
        	let elem = ``;
        	$.each(data.data.motivos, function(key, value){
        		elem += `<div class="mb-2 position-relative">
			                <input type="radio" class="btn-check-motivo d-none" name="motivoCita" 
			                       id="motivo_${value.codigo}" value="${value.codigo}" data-rel='${JSON.stringify(value)}' autocomplete="off">
			                <label class="btn w-100 text-start p-3 py-2 d-flex justify-content-between align-items-center value-radio" 
			                       for="motivo_${value.codigo}">
				        		<div class="me-2">
				                    <i class="fa-regular fa-square fs-20"></i>
				                    <i class="fa-solid fa-square-check fs-20"></i>
				                </div>
			                    <span class="flex-grow-1 fw-normal">${capitalizarFirstLetter(value.descripcion)}</span>
			                </label>
			            </div>`
        	});
        	$(`#${idListado}`).html(elem);
        	$('.modal-body, .modal-dialog-scrollable, .step').scrollTop(99999);
        }else{
        	$(`#${idListado}`).empty();
        	showMessage('warning', data.message);
        }
	}

	async function cargarPreguntas(){
		showMessage('info','Optimizando tu experiencia con inteligencia artificial. Por favor, espera un momento.');
		let args = [];
        args["endpoint"] = `${api_url}/${api_war_ai}/v1/prediligencionamiento-hc/preguntas`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = _token;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
		args["data"] = JSON.stringify({
		  	"codigo_motivo": parseInt(getInput('motivoCita', 'radio')),
		  	"codigo_empresa": _codigoEmpresa
		});
        const data = await call(args);
		console.log(data);
		return data;
	}

	async function drawSeccionesCuestionario(){
		let elem = ``;
		let counter = 7;
		var total = preguntas.data.preguntas.length;
		$.each(preguntas.data.preguntas, function(key, value){
			let seccionPregunta = drawPreguntaIndividual(value);
			let esUltima = "N";
			if (key === total - 1) {
		        esUltima = "S";
		    }
			let footer = drawFooter(value, counter, esUltima);

			elem += `<div class="step-dinamico progreso-step step step-${counter} d-none modal-dialog-scrollable" ultimaPregunta-rel='${esUltima}'>
						<div class="modal-content">
							@include('external.portal_cautivo.navigation')
							<div class="modal-body">
								<div class="h-100 d-flex flex-column justify-content-between">
									<div class="d-flex flex-column align-items-start px-3 mt-auto">
								        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								            <img src="{{ asset('assets/external/bot/logo-vericita.png') }}" width="75px">
								            <div>
								        		<h2 class="text-secundario-midnight-blue-00 mb-0">Un poco más de detalle.</h2>
								        		<p class="fs--16 line-height-20 text-secundario-midnight-blue-00 mb-0">Nos ayudará a comprender mejor tu dolor o malestar.</p>
								        	</div>
								        </div>
								        <div class="bg-white m-3 rounded-3 mb-0 gap-2 row mx-0 py-3 pb-0 px-2 w-100 shadow-sm swipe-up-entry mb-3">
										  	<div class="col-md-12 mb-2">
				                                ${seccionPregunta}
				                            </div>
				                        </div>
										<p class="text-Secundario-Midnight-blue-Tint-40 fs--14 line-height-16 fw-normal text-end w-100 mt-2 mb-3 px-2">Danos tu opinión</p>
										${footer}
								    </div>
								</div>
							</div>
						</div>
					</div>`;
			counter++;
		});
		$('.chatbox').append(elem);
	}

	function actualizarProgreso(pasoActual, totalPasos) {
		console.log("***********Pasos***********");
		console.log(pasoActual, totalPasos);
	    let porcentaje = (pasoActual / totalPasos) * 100;
	    $('.progreso-step .msg-head').css('--progreso', porcentaje + '%');
	}

	// Estos TipoPregunta = Literal["TEXT", "NUMBER", "SELECT", "TEXTAREA", "DATE", "DURATION"]
	function drawPreguntaIndividual(value){
		let elem = ``;
		let required;
		switch(value.tipo){
			case 'DURATION':
			case 'SELECT':
				elem += `<p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">${value.texto}</p>
						<div class="text-end">`;
				let options = ``;

				$.each(value.opciones, function(k, v){
					options += `<div class="w-100">
							<input type="radio" class="btn-check d-none" name="${value.id}" id="opt-${value.id}-${k}" value="${v}" autocomplete="off">
			            	<label class="btn btn-outline-primary fs--16 line-height-22 rounded-3 px-4 py-2 fw-normal mb-3 item-radio text-end" for="opt-${value.id}-${k}">
			            		${capitalizarFirstLetter(v)}
			            	</label>
						</div>`;
				});
				elem += options;
				elem += `</div>`;
			break;
			case 'TEXT':
				required = (value.requerido) ? `required` : ``;
				elem += `<p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">${value.texto}</p>
						<div class="w-100 mb-3">
                            <input type="text" class="form-control fs--1 p-3 w-100" name="${value.id}" id="${value.id}" ${required} />
                        </div>`;
			break;
			case 'TEXTAREA':
				required = (value.requerido) ? `required` : ``;
				elem += `<p class="text-Secundario-Midnight-blue-Tint-20s fw-normal fs--18 line-height-24 mb-3">${value.texto}</p>
						<div class="w-100 mb-3">
                            <textarea rows="4" type="text" class="form-control fs--1 p-3 w-100 rounded-3" name="${value.id}" id="${value.id}" ${required}></textarea>
                        </div>`;
			break;
		}

		return elem;
	}

	function drawFooter(value, position){
		let elem = ``;
		switch(value.tipo){
			case 'DURATION':
			case 'SELECT':
				return ``;
			break;
			default:
				elem += `<div class="footer-action w-100">
			        <button class="btn btn-primary-veris rounded-3 btn-continue btn-continue-dinamico w-100 my-4 mt-1 py-4 fs--20 line-height-24 fw-medium" idInput-rel='${value.id}' isRequired-rel='${value.requerido}' stepNext-rel='${position+1}'>Continuar</button>
			    </div>`;
		}
		return elem;
	}

	async function obtenerRespuestas(){
		let respuestasObj = [];
		$.each(preguntas.data.preguntas, function(key, value){
			let respuesta;
		    switch(value.tipo){
				case 'DURATION':
				case 'SELECT':
					respuesta = $(`input[name="${value.id}"]:checked`).val();
				break;
				case 'TEXT':
				case 'TEXTAREA':
					respuesta = $(`#${value.id}`).val();
				break;
		    }

		    respuestasObj.push({
		      	"pregunta_id": value.id,
		      	"pregunta_texto": value.texto,
		      	"respuesta": respuesta
		    })
		})

		return respuestasObj;
	}

	async function obtenerRespuestasConModelo(){
		let respuestasObj = [];
		$.each(preguntas.data.preguntas, function(key, value){
			let respuesta;
		    switch(value.tipo){
				case 'DURATION':
				case 'SELECT':
					respuesta = $(`input[name="${value.id}"]:checked`).val();
				break;
				case 'TEXT':
				case 'TEXTAREA':
					respuesta = $(`#${value.id}`).val();
				break;
		    }

		    respuestasObj.push({
		      	"codigoModelo": value.modelo,
		      	"codigoPregunta": value.id,
		      	"descripcionPregunta": value.texto,
		      	"respuestaPaciente": respuesta
		    })
		})

		return respuestasObj;
	}

	let traduccion;
	async function obtenerTraduccion(type){
		let payload;
		if(type == "control"){
			payload = {
				"codigo_motivo": null,
				"codigo_empresa": _codigoEmpresa,
				"texto_libre_sintomas": getInput('detalle_control').trim()
			}
		}else{
			let respuestas = await obtenerRespuestas();
			payload = {
				"codigo_motivo": preguntas.data.motivo_id,
				"motivo_descripcion": preguntas.data.motivo_descripcion,
				"codigo_empresa": _codigoEmpresa,
				"respuestas": respuestas
			}
		}

		let args = [];
        args["endpoint"] = `${api_url}/${api_war_ai}/v1/prediligencionamiento-hc/traducir`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = _token;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
		args["data"] = JSON.stringify(payload);
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
        	traduccion = data.data;
        	await guardarBorrador(type);
        }else{
        	showMessage('warning', data.message);
        }
	}

	let secuenciaBorrador;
	async function guardarBorrador(type){
		let infoCita = JSON.parse($('.item-cita-selected').attr('data-rel'));
		let valorEscala = $('.btn-ranking-selected').attr('data-ranking');
		let payload;
		if(type == "control"){
			payload = {
				"codigoEmpresa": _codigoEmpresa,
			    "codigoReserva": infoCita.codigoReserva,
			    "enfermedadActual": `CONTROL - ${traduccion.narrativo_medico}`,
			    "codigoEscalaDolor": 1,
			    "codigoMotivo": null,
			    "nombreMotivo": "NA",
			    "aceptaTerminosCond": "S",
			    "esControl": "S"
			}
		}else{
			payload = {
				"codigoEmpresa": _codigoEmpresa,
			    "codigoReserva": infoCita.codigoReserva,
			    "enfermedadActual": traduccion.narrativo_medico,
			    "codigoEscalaDolor": parseInt(valorEscala),
			    "codigoMotivo": preguntas.data.motivo_id,
			    "nombreMotivo": preguntas.data.motivo_descripcion,
			    "aceptaTerminosCond": "S",
			    "esControl": "N"
			}
		}
		

		let args = [];
        args["endpoint"] = `${api_url}/historiaclinica/v1/prediligenciamiento/anamnesis`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = _token;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
		args["data"] = JSON.stringify(payload);
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
			$('.step').addClass('d-none');
			$(`.step-gracias`).removeClass('d-none');
			secuenciaBorrador = data.data.secuenciaBorrador;
			actualizarProgreso(1, 1);
			if(type !== "control"){
				await guardarRespuestaPaciente();
			}
        }else{
        	showMessage('warning', data.message);
        }
	}

	async function guardarRespuestaPaciente(){
		let payload = await obtenerRespuestasConModelo();

		let args = [];
		args["endpoint"] = `${api_url}/historiaclinica/v1/prediligenciamiento/anamnesis/${secuenciaBorrador}/respuesta_paciente`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = _token;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
		args["data"] = JSON.stringify({
			"respuestas": payload
		});
        const data = await call(args);
        console.log(data);
        if(data.code !== 200){
        	showMessage('warning', data.message);
        }
	}

	function formatearFechaRelativa(fechaStr) {
	    // 1. Crear objetos de fecha (reemplazamos '-' por '/' para compatibilidad total)
	    var fechaInput = new Date(fechaStr.replace(/-/g, '/'));
	    var ahora = new Date();

	    // 2. Normalizar fechas para comparar solo el día (sin horas)
	    var hoy = new Date(ahora.getFullYear(), ahora.getMonth(), ahora.getDate());
	    var fechaComparar = new Date(fechaInput.getFullYear(), fechaInput.getMonth(), fechaInput.getDate());

	    // 3. Calcular la diferencia en días
	    var diferenciaTiempo = fechaComparar.getTime() - hoy.getTime();
	    var diferenciaDias = Math.round(diferenciaTiempo / (1000 * 3600 * 24));

	    // 4. Formatear la hora (ej: 08:40 pm)
	    var opcionesHora = { hour: '2-digit', minute: '2-digit', hour12: true };
	    var horaFormateada = fechaInput.toLocaleTimeString('en-US', opcionesHora).toLowerCase();

	    // 5. Determinar el prefijo
	    var prefijo = "";
	    if (diferenciaDias === 0) {
	        prefijo = "Hoy";
	    } else if (diferenciaDias === 1) {
	        prefijo = "Mañana";
	    } else if (diferenciaDias === -1) {
	        prefijo = "Ayer";
	    } else {
	        // Para fechas más lejanas: "12 de abr."
	        prefijo = fechaInput.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
	    }

	    return prefijo + ", " + horaFormateada;
	}

	async function updateToken(){
		console.log("No hace refresh");
	}
</script>
@endsection