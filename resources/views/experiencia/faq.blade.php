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
                <div class="col-12 col-md-10 col-lg-8 h-100 mt-3" id="listaFaq">
                	{{-- <p class="text-veris-ai fs--16 line-height-20">Sobre agendamiento de citas</p>
                	<div class="accordion bg-transparent" id="accordionPanelsFaq1">
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
                    </div> --}}
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
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        await cargarFaq();
    });
    let faq;
    async function cargarFaq() {
            let args = [];
            args["endpoint"] = api_url + `/${api_war}/v1/generales/preguntasFrecuentes?canalOrigen=${_canalOrigen}`;
            args["method"] = "GET";
            args["showLoader"] = true;

            const data = await call(args);
            console.log(data);
            faq = data.data;
            if (data.code == 200) {
                let elem = ``;
                $.each(data.data, function(key,value){
                    elem += `<p class="text-veris-ai fs--16 line-height-20">${value.categoria}</p>
                        <div class="accordion bg-transparent" id="accordionPanelsFaq${key}">`;
                    $.each(value.preguntas, function(k1,v1){
                        console.log(v1)
                        elem += `<div class="accordion-item bg-transparent pb-3 mb-3 border-silver-1">
                            <h2 class="accordion-header border-0" id="panelsStayOpen-heading${key}${k1}">
                                <button class="accordion-button p-0 bg-transparent fs--1 line-height-16 label-status-detalle border-0" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${key}${k1}" aria-expanded="true" aria-controls="panelsStayOpen-collapse${key}${k1}">
                                    ${v1.pregunta}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse${key}${k1}" class="accordion-collapse collapse bg-transparent" aria-labelledby="panelsStayOpen-heading${key}${k1}">
                                <div class="accordion-body p-0 mt-3 fs--1 line-height-16 label-status-detalle">
                                    ${v1.respuesta}
                                </div>
                            </div>
                        </div>`;
                    })
                    elem += `</div>`;
                })
                $('#listaFaq').html(elem);
            }
        }
    </script>
@endsection