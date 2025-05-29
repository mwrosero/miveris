@extends('template.app-template-veris')
@section('title')
Mi Veris - Preguntas Frecuentes
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Preguntas frecuentes') }}</h5>
    </div>
    <section class="h-75">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-12 col-md-10 col-lg-8 h-100 mt-3">
                	<p class="text-veris-ai fs--16 line-height-20">Sobre agendamiento de citas</p>
                	<div class="accordion bg-transparent" id="accordionPanelsFaq">
                		
                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-heading1">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse1" aria-expanded="true" aria-controls="panelsStayOpen-collapse1">
                					¿Con cuánta anticipación puedo agendar una cita?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-collapse1" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-heading1">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Puedes agendar tu cita en cualquier momento a través de la app Mi Veris. Sin embargo, te recomendamos hacerlo con la mayor anticipación posible para asegurar la disponibilidad del médico y horario que prefieras. Recuerda llegar 15 minutos antes de tu cita para el proceso de facturación en la Central Médica, si aplica.
                				</div>
                			</div>
                		</div>

                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-heading2">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse2" aria-expanded="true" aria-controls="panelsStayOpen-collapse2">
                					¿Puedo agendar una cita para otra persona?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-collapse2" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-heading2">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Sí, la app Mi Veris te permite agendar citas para familiares u otras personas. Deberás agregarlo a tu grupo de familia y amigos o ingresar la información del paciente al momento de realizar la reserva.
                				</div>
                			</div>
                		</div>

                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-heading3">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse3" aria-expanded="true" aria-controls="panelsStayOpen-collapse3">
                					¿Cómo puedo ver y agendar los tratamientos de un familiar?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-collapse3" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-heading3">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Debes pedirle a esa persona permisos de administrador y luego ingresar el código que le enviamos al correo que tu familiar o amigo tiene registrado en Veris.
                				</div>
                			</div>
                		</div>

                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-heading4">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse4" aria-expanded="true" aria-controls="panelsStayOpen-collapse4">
                					¿Puedo ver la disponibilidad de horarios de los médicos en tiempo real?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-collapse4" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-heading4">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Sí, la app te muestra la disponibilidad de horarios de los médicos en tiempo real, lo que te permite elegir el horario que mejor se adapte a tus necesidades.
                				</div>
                			</div>
                		</div>

                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-heading5">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse5" aria-expanded="true" aria-controls="panelsStayOpen-collapse5">
                					¿Qué hago si no encuentro la especialidad o el médico que busco en la app?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-collapse5" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-heading5">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Si no encuentras la especialidad o el médico que buscas, puedes contactarnos a través del número de teléfono (04) 6009600 o visitar nuestra página web www.veris.com.ec. Nuestro personal te ayudará a encontrar la mejor opción para ti.
                				</div>
                			</div>
                		</div>
                	</div>

                	<p class="text-veris-ai fs--16 line-height-20 mt-4">Sobre pagos y facturación</p>
                	<div class="accordion bg-transparent" id="accordionPanelsFaq2">
                		
                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-2-heading1">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-2-collapse1" aria-expanded="true" aria-controls="panelsStayOpen-2-collapse1">
                					¿Qué métodos de pago se aceptan en la app?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-2-collapse1" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-2-heading1">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Aceptamos pagos con todas las tarjetas de crédito y débito Visa.
                				</div>
                			</div>
                		</div>

                		<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                			<h2 class="accordion-header border-0" id="panelsStayOpen-2-heading2">
                				<button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-2-collapse2" aria-expanded="true" aria-controls="panelsStayOpen-2-collapse2">
                					¿Cómo obtengo mi factura?
                				</button>
                			</h2>
                			<div id="panelsStayOpen-2-collapse2" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-2-heading2">
                				<div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                					Tu factura se generará automáticamente después de realizar el pago en la app y estará disponible para su descarga en la sección "Mis Citas" o se enviará a tu correo electrónico registrado. Si pagaste en la Central Médica, te entregarán la factura en físico.
                				</div>
                			</div>
                		</div>
                </div>
            </div>
        </div>
    </section>
</div>
<style>
	.bg-transparent{
		background: transparent !important;
	}
	.border-silver-1{
        border-bottom: 1px solid #E7E9EC;
    }
</style>
@endsection