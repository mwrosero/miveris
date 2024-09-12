@extends('template.external')
@section('title')
Veris - Planes Promociones
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
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
<div id="splash">
	@include('external.bot.splash2')
</div>
{{-- @include('external.components.navbar') --}}

<section class="p-2 m-2">
	<div class="row">
		<div class="col-12">
			<div class="chat-area">
				<!-- chatbox -->
				<div class="chatbox">
					<div class="modal-dialog-scrollable">
						<div class="modal-content">
							<div class="msg-head">
								<div class="settings-tray rounded d-flex justify-content-between align-items-center">
									<div class="friend-drawer no-gutters friend-drawer--grey justify-content-start align-items-center flex-grow-1">
										<img class="profile-image" src="../../assets/img/veris/isotipo.svg">
										<div class="text">
											<h6>Vericita</h6>
											<p class="text-muted">Cuidarte es tan fácil.</p>
										</div>
									</div>
									<button class="border-0">
										<i class="fa-solid fa-bars fs-3"></i>
									</button>
								</div>
							</div>
							<div class="modal-body">
								<div class="msg-body">
									<div class="box-accesos row mt-2 p-2">
										<div class="col-12 col-md-8 offset-md-2">
											<div class="swiper swiper-acceso-rapidos position-relative pb-2">
									            <div class="swiper-wrapper">
									                <div class="swiper-slide">
									                    <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#agendarCitaMedicaModal">
									                        <div class="card">
									                            <div class="row g-0 justify-content-between align-items-center">
									                                <div class="col-7 col-md-7">
									                                    <div class="card-body p-0 ps-2">
									                                        <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Agendar cita médica') }}</h6>
									                                    </div>
									                                </div>
									                                <div class="col-5 col-md-auto text-end">
									                                    <img src="{{ asset('assets/img/card/svg/doctora_1.svg') }}" class="img-fluid" alt="">
									                                </div>
									                            </div>
									                        </div>
									                    </a>
									                </div>
									                <div class="swiper-slide">
									                    <a href="#">
									                        <div class="card">
									                            <div class="row g-0 justify-content-between align-items-center">
									                                <div class="col-7 col-md-7">
									                                    <div class="card-body p-0 ps-2">
									                                        <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Comprar planes promociones') }}</h6>
									                                    </div>
									                                </div>
									                                <div class="col-5 col-md-auto text-end">
									                                    <img src="{{ asset('assets/img/card/svg/comprar_1.svg') }}" class="img-fluid" alt=""  >
									                                </div>
									                            </div>
									                        </div>
									                    </a>
									                </div>
									                <div class="swiper-slide">
									                    <a href="#" >
									                        <div class="card">
									                            <div class="row g-0 justify-content-between align-items-center">
									                                <div class="col-7 col-md-7">
									                                    <div class="card-body p-0 ps-2">
									                                        <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Solicitar servicios') }} <br> {{ __('a domicilio') }}</h6>
									                                    </div>
									                                </div>
									                                <div class="col-5 col-md-auto text-end">
									                                    <img src="{{ asset('assets/img/card/svg/motociclista_1.svg') }}" class="img-fluid" alt=""  >
									                                </div>
									                            </div>
									                        </div>
									                    </a>
									                </div>
									            </div>
									            <button type="button" id="prevProperties" class="d-flex d-none mt-n4 btn btn-prev rounded-circle"></button>
									            <button type="button" id="nextProperties" class="d-flex d-none mt-n4 btn btn-next rounded-circle"></button>
									        </div>
									    </div>
									</div>
									<ul class="p-2" id="conversacion">
										<li class="sender mt-1 mb-1">
											<p>Hola, soy Vericita. Tu asistente inteligente. En qué puedo ayudarte hoy?</p>
											<span class="time">10:06 am</span>
										</li>
										<li class="reply mt-1 mb-1">
											<p>Si, quiero agendar una cita médica</p>
											<span class="time">10:20 am</span>
										</li>
										<li class="sender mt-1 mb-1">
											<p>Por supuesto, ayúdame con tu número de identificación</p>
											<span class="time">10:26 am</span>
										</li>
										<li class="reply mt-1 mb-1">
											<p>0923795888</p>
											<span class="time">10:35 am</span>
										</li>
										{{-- <li>
											<div class="divider">
												<h6>Today</h6>
											</div>
										</li> --}}
										<li class="sender mt-1 mb-1">
											<p>Michael, cuéntame con que especialista quieres agendar</p>
											<span class="time">10:36 am</span>
										</li>
										<li class="reply mt-1 mb-1">
											<p>Con un traumatólogo</p>
											<span class="time">10:38 am</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="send-box">
								<div class="chat-box-tray justify-content-between align-items-center rounded">
									{{-- <i class="fa-solid fa-paperclip"></i> --}}
									{{-- <input autofocus type="text" class="p-2 flex-grow-1" id="prompt" placeholder="Escribe un mensaje..."> --}}
									<textarea autofocus type="text" class="p-2 flex-grow-1 form-control auto-expand-textarea rounded" rows="1" id="prompt" placeholder="Escribe un mensaje..."></textarea>
									<i role="button" id="btn-grabar" class="fa-solid fa-microphone ms-2 me-2"></i>
									<i role="button" id="btn-enviar" class="fa-solid fa-paper-plane d-none ms-2 me-2"></i>
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
	document.addEventListener("DOMContentLoaded", async function () {
		setTimeout(function(){
			$('#splash').fadeOut(1000);
		}, 500);

		$('.auto-expand-textarea').on('input', function () {
            this.style.height = 'auto'; // Restablece la altura
            this.style.height = (this.scrollHeight) + 'px'; // Ajusta a la altura del contenido
        });

		$('body').on('input','#prompt',function(){
			let value = $(this).val(); // Captura el valor del input

			if (value.length > 0) {
				$('#btn-enviar').removeClass('d-none');
				$('#btn-grabar').addClass('d-none');
			} else {
				$('#btn-grabar').removeClass('d-none');
				$('#btn-enviar').addClass('d-none');
			}
		})

		// scrollToBottom();
		$('body').on('click', '#btn-enviar', function(){
			if($('#prompt').val() != ""){
				let elem = `<li class="reply mt-1 mb-1">
						<p>${ $('#prompt').val() }</p>
						<span class="time">${ obtenerHoraActual() }</span>
					</li>`;
				$('#conversacion').append(elem);
				scrollToBottom();
			}
			$('#prompt').val("");
		})

		var swiper = new Swiper('.swiper-acceso-rapidos', {
            // slidesPerView: 1,
            spaceBetween: 8,
            
            navigation: {
                nextEl: '.btn-next',
                prevEl: '.btn-prev',
            },
            autoplay: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                300: {
                    slidesPerView: 2.1,
                    centeredSlides: false,
                    // loop: true,
                    spaceBetween: 4,
                },
                768: {
                    slidesPerView: 2.1,
                    // centeredSlides: true,
                    // loop: true,
                    // spaceBetween: 8,
                },
                1024: {
                    slidesPerView: 3,
                    // spaceBetween: 8,
                },
            },
        });
	});

	function scrollToBottom() {
        var modalBody = $('.modal-body'); // Selecciona el contenedor con la clase modal-body
        modalBody.scrollTop(modalBody[0].scrollHeight); // Establece el desplazamiento hasta el fondo
    }

	function obtenerHoraActual() {
	    const fecha = new Date();
	    let horas = fecha.getHours();
	    let minutos = fecha.getMinutes();
	    const ampm = horas >= 12 ? 'pm' : 'am';

	    horas = horas % 12;  // Convierte de formato de 24 horas a 12 horas
	    horas = horas ? horas : 12;  // La hora 0 debe ser '12'
	    minutos = minutos < 10 ? '0' + minutos : minutos;  // Asegura que los minutos siempre tengan dos dígitos

	    const horaFormateada = horas + ':' + minutos + ' ' + ampm;
	    return horaFormateada;
	}

</script>
<style>
	.auto-expand-textarea {
	    border: 1px solid #ced4da; /* Estilo de input */
	    border-radius: 0.25rem; /* Estilo de input */
	    padding: 0.375rem 0.75rem; /* Espaciado de input */
	    overflow: hidden; /* Ocultar barra de desplazamiento */
	    resize: none; /* Desactivar redimensionado manual */
	}

	.profile-image {
		width: 50px;
		height: 50px;
		border-radius: 40px;
	}
	.settings-tray {
		background: #eee;
		padding: 10px 15px;
	}
	.settings-tray .no-gutters {
		padding: 0;
	}
	.settings-tray--right {
		float: right;
	}
	.settings-tray--right i {
		margin-top: 10px;
		font-size: 25px;
		color: grey;
		margin-left: 14px;
		transition: 0.3s;
	}
	.settings-tray--right i:hover {
		color: #74b9ff;
		cursor: pointer;
	}
	.search-box {
		background: #fafafa;
		padding: 10px 13px;
	}
	.search-box .input-wrapper {
		background: #fff;
		border-radius: 40px;
	}
	.search-box .input-wrapper i {
		color: grey;
		margin-left: 7px;
		vertical-align: middle;
	}
	input, textarea {
		border: none;
		border-radius: 30px !important;
		width: 80%;
	}
	input::placeholder, textarea::placeholder {
		color: #e3e3e3;
		font-weight: 300;
		margin-left: 20px;
	}
	input:focus, textarea:focus {
		outline: none;
	}
	.friend-drawer {
		padding: 10px 15px;
		display: flex;
		vertical-align: baseline;
		background: #fff;
		transition: 0.3s ease;
	}
	.friend-drawer--grey {
		background: #eee;
	}
	.friend-drawer .text {
		margin-left: 12px;
		width: 70%;
	}
	.friend-drawer .text h6 {
		margin-top: 6px;
		margin-bottom: 0;
	}
	.friend-drawer .text p {
		margin: 0;
	}
	.friend-drawer .time {
		color: grey;
	}
	.friend-drawer--onhover:hover {
		background: #74b9ff;
		cursor: pointer;
	}
	.friend-drawer--onhover:hover p, .friend-drawer--onhover:hover h6, .friend-drawer--onhover:hover .time {
		color: #fff !important;
	}
	hr {
		margin: 5px auto;
		width: 60%;
	}
	.chat-bubble {
		padding: 10px 14px;
		background: #eee;
		margin: 10px 30px;
		border-radius: 9px;
		position: relative;
		animation: fadeIn 1s ease-in;
	}
	.chat-bubble:after {
		content: '';
		position: absolute;
		top: 50%;
		width: 0;
		height: 0;
		border: 20px solid transparent;
		border-bottom: 0;
		margin-top: -10px;
	}
	.chat-bubble--left:after {
		left: 0;
		border-right-color: #eee;
		border-left: 0;
		margin-left: -20px;
	}
	.chat-bubble--right:after {
		right: 0;
		border-left-color: #74b9ff;
		border-right: 0;
		margin-right: -20px;
	}
	@keyframes fadeIn {
		0% {
			opacity: 0;
		}
		100% {
			opacity: 1;
		}
	}
	.offset-md-9 .chat-bubble {
		background: #74b9ff;
		color: #fff;
	}
	.chat-box-tray {
		background: #eee;
		display: flex;
		padding: 10px 15px;
		/*align-items: baseline;
		align-items: center;*/
		margin-top: 19px;
		bottom: 0;
	}
	.chat-box-tray input, .chat-box-tray textarea {
		margin: 0 10px;
		padding: 6px 2px;
	}
	.chat-box-tray i {
		color: #0a2240;/*grey*/
		font-size: 20px;
		vertical-align: middle;
		width: 25px;
    	text-align: right;
	}
	/*.chat-box-tray i:last-of-type {
		margin-left: 15px;
	}*/
	.message-area {
	    height: 100vh;
	    overflow: hidden;
	    padding: 30px 0;
	    background: #f5f5f5;
	}

.chat-area {
    position: relative;
    width: 100%;
    background-color: #fff;
    border-radius: 0.3rem;
    height: 94vh;
    overflow: hidden;
    min-height: calc(100% - 1rem);
}

.chatlist {
    outline: 0;
    height: 100%;
    overflow: hidden;
    width: 300px;
    float: left;
    padding: 15px;
}

.chat-area .modal-content {
    border: none;
    border-radius: 0;
    outline: 0;
    height: 100%;
}

.chat-area .modal-dialog-scrollable {
    height: 100% !important;
}

.chatbox {
    width: auto;
    overflow: hidden;
    height: 100%;
}

.chatbox .modal-dialog,
.chatlist .modal-dialog {
    max-width: 100%;
    margin: 0;
}

.msg-search {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chat-area .form-control {
    display: block;
    width: 80%;
    padding: 0.375rem 0.75rem;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    color: #222;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.chat-area .form-control:focus {
    outline: 0;
    box-shadow: inherit;
}

a.add img {
    height: 36px;
}

.chat-area .nav-tabs {
    border-bottom: 1px solid #dee2e6;
    align-items: center;
    justify-content: space-between;
    flex-wrap: inherit;
}

.chat-area .nav-tabs .nav-item {
    width: 100%;
}

.chat-area .nav-tabs .nav-link {
    width: 100%;
    color: #180660;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
    text-transform: capitalize;
    margin-top: 5px;
    margin-bottom: -1px;
    background: 0 0;
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.chat-area .nav-tabs .nav-item.show .nav-link,
.chat-area .nav-tabs .nav-link.active {
    color: #222;
    background-color: #fff;
    border-color: transparent transparent #000;
}

.chat-area .nav-tabs .nav-link:focus,
.chat-area .nav-tabs .nav-link:hover {
    border-color: transparent transparent #000;
    isolation: isolate;
}

.chat-list h3 {
    color: #222;
    font-size: 16px;
    font-weight: 500;
    line-height: 1.5;
    text-transform: capitalize;
    margin-bottom: 0;
}

.chat-list p {
    color: #343434;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    text-transform: capitalize;
    margin-bottom: 0;
}

.chat-list a.d-flex {
    margin-bottom: 15px;
    position: relative;
    text-decoration: none;
}

.chat-list .active {
    display: block;
    content: '';
    clear: both;
    position: absolute;
    bottom: 3px;
    left: 34px;
    height: 12px;
    width: 12px;
    background: #00DB75;
    border-radius: 50%;
    border: 2px solid #fff;
}

.msg-head h3 {
    color: #222;
    font-size: 18px;
    font-weight: 600;
    line-height: 1.5;
    margin-bottom: 0;
}

.msg-head p {
    color: #343434;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    text-transform: capitalize;
    margin-bottom: 0;
}


.moreoption {
    display: flex;
    align-items: center;
    justify-content: end;
}

.moreoption .navbar {
    padding: 0;
}

.moreoption li .nav-link {
    color: #222;
    font-size: 16px;
}

.moreoption .dropdown-toggle::after {
    display: none;
}

.moreoption .dropdown-menu[data-bs-popper] {
    top: 100%;
    left: auto;
    right: 0;
    margin-top: 0.125rem;
}

.msg-body{
	overflow-x: hidden;
}

.msg-body ul {
    overflow: hidden;
}

.msg-body ul li {
    list-style: none;
    /*margin: 15px 0;*/
}

.msg-body ul li.sender {
    display: block;
    width: 99%;
    position: relative;
}

.msg-body ul li.sender:before {
    display: block;
    clear: both;
    content: '';
    position: absolute;
    top: -6px;
    left: -7px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 12px 15px 12px;
    border-color: transparent transparent #f5f5f5 transparent;
    -webkit-transform: rotate(-37deg);
    -ms-transform: rotate(-37deg);
    transform: rotate(-37deg);
}

.msg-body ul li.sender p {
    color: #000;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 400;
    padding: 15px;
    background: #f5f5f5;
    display: inline-block;
    border-bottom-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    margin-bottom: 0;
}

.msg-body ul li.sender p b {
    display: block;
    color: #180660;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 500;
}

.msg-body ul li.reply {
    display: block;
    width: 99%;
    text-align: right;
    position: relative;
    margin: auto;
}

.msg-body ul li.reply:before {
    display: block;
    clear: both;
    content: '';
    position: absolute;
    bottom: 15px;
    right: -7px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 12px 15px 12px;
    border-color: transparent transparent #4b7bec transparent;
    -webkit-transform: rotate(37deg);
    -ms-transform: rotate(37deg);
    transform: rotate(37deg);
}

.msg-body ul li.reply p {
    color: #fff;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 400;
    padding: 15px;
    background: #4b7bec;
    display: inline-block;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    margin-bottom: 0;
}

.msg-body ul li.reply p b {
    display: block;
    color: #061061;
    font-size: 14px;
    line-height: 1.5;
    font-weight: 500;
}

.msg-body ul li.reply:after {
    display: block;
    content: '';
    clear: both;
}

.time {
    display: block;
    color: #000;
    font-size: 10px;
    line-height: 12px;
    font-weight: 400;
}

li.sender .time {
	margin-left: 10px;
}

li.reply .time {
    margin-right: 10px;
}

.divider {
    position: relative;
    z-index: 1;
    text-align: center;
}

.msg-body h6 {
    text-align: center;
    font-weight: normal;
    font-size: 14px;
    line-height: 1.5;
    color: #222;
    background: #fff;
    display: inline-block;
    padding: 0 5px;
    margin-bottom: 0;
}

.divider:after {
    display: block;
    content: '';
    clear: both;
    position: absolute;
    top: 12px;
    left: 0;
    border-top: 1px solid #EBEBEB;
    width: 100%;
    height: 100%;
    z-index: -1;
}


.send-box form {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
}

.send-box .form-control {
    display: block;
    width: 85%;
    padding: 0.375rem 0.75rem;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    color: #222;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.send-box button {
    border: none;
    background: #3867d6;
    padding: 0.375rem 5px;
    color: #fff;
    border-radius: 0.25rem;
    font-size: 14px;
    font-weight: 400;
    width: 24%;
    margin-left: 1%;
}

.send-box button i {
    margin-right: 5px;
}

.send-btns .button-wrapper {
    position: relative;
    width: 125px;
    height: auto;
    text-align: left;
    margin: 0 auto;
    display: block;
    background: #F6F7FA;
    border-radius: 3px;
    padding: 5px 15px;
    float: left;
    margin-right: 5px;
    margin-bottom: 5px;
    overflow: hidden;
}

.send-btns .button-wrapper span.label {
    position: relative;
    z-index: 1;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    width: 100%;
    cursor: pointer;
    color: #343945;
    font-weight: 400;
    text-transform: capitalize;
    font-size: 13px;
}

#upload {
    display: inline-block;
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}

.send-btns .attach .form-control {
    display: inline-block;
    width: 120px;
    height: auto;
    padding: 5px 8px;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.5;
    color: #343945;
    background-color: #F6F7FA;
    background-clip: padding-box;
    border: 1px solid #F6F7FA;
    border-radius: 3px;
    margin-bottom: 5px;
}

.send-btns .button-wrapper span.label img {
    margin-right: 5px;
}

.button-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    text-align: center;
    margin: 0 auto;
}

button:focus {
    outline: 0;
}

.add-apoint {
    display: inline-block;
    margin-left: 5px;
}

.add-apoint a {
    text-decoration: none;
    background: #F6F7FA;
    border-radius: 8px;
    padding: 8px 8px;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.2;
    color: #343945;
}

.add-apoint a svg {
    margin-right: 5px;
}

.chat-icon {
    display: none;
}

.closess i {
    display: none;
}



@media (max-width: 767px) {
    .chat-icon {
        display: block;
        margin-right: 5px;
    }
    .chatlist {
        width: 100%;
    }
    .showbox {
        left: 0 !important;
        transition: all 0.5s ease;
    }
    .msg-head h3 {
        font-size: 14px;
    }
    .msg-head p {
        font-size: 12px;
    }
    .msg-head .flex-shrink-0 img {
        height: 30px;
    }
    .send-box button {
        width: 28%;
    }
    .send-box .form-control {
        width: 70%;
    }
    .chat-list h3 {
        font-size: 14px;
    }
    .chat-list p {
        font-size: 12px;
    }
    .msg-body ul li.sender p {
        font-size: 13px;
        padding: 8px;
        border-bottom-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }
    .msg-body ul li.reply p {
        font-size: 13px;
        padding: 8px;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom-left-radius: 6px;
    }
}
</style>
@endsection