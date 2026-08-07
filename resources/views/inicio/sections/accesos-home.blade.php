<!-- Accesos rápidos -->
<section class="{{ config('app.subdomain') == 'parami' ? 'bg-light-grayish-blue' : 'pb-0' }} p-3 pe-md-3 mb-3" style="overflow-x: hidden;">
    <div class="d-flex justify-content-between align-items-center {{ config('app.subdomain') == 'parami' ? 'mb-3' : '' }}">
        <h6 class="fw-medium border-start-veris ps-3 fs-18 mb-0">{{ __('Accesos rápidos') }}</h6>
    </div>
    
    @if(config('app.subdomain') == 'veris')
    <div class="container-fluid px-0 mt-3">
        <div class="row px-1 d-flex justify-content-start align-items-stretch mb-3">
            <div class="col-6 col-md-4 d-flex">
                <a href="{{route('citas.agendamiento-ai')}}" class="w-100">
                    <div class="card h-100 d-flex justify-content-center border-ai">
                        <div class="row h-100 g-0 justify-content-between align-items-center">
                            <div class="col-8 col-md-7">
                                <div class="card-body p-0 ps-2">
                                    <h6 class="fw-medium fs--2 fs--lg-1 mb-0">{{ __('Agendamiento inteligente') }}</h6>
                                </div>
                            </div>
                            <div class="col-4 col-md-auto text-end">
                                <img src="{{ asset('assets/img/svg/vericita-icon.svg') }}" class="img-fluid me-2" alt="">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 d-flex">
                <a class="cursor-pointer d-block w-100">
                    <div class="card h-100" id="cita-nueva">
                        <div class="row h-100 g-0 justify-content-between align-items-center">
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
        </div>
    </div>
    @endif

    <div class="container-fluid px-0">
        <div class="row px-1 d-flex justify-content-start align-items-center {{ config('app.subdomain') == 'parami' ? 'gap-3' : '' }} ">
            @if(config('app.subdomain') == "veris")
            <a href="/promociones" class="col-3 col-md-2 text-center text-veris bg-transparent">
                <div class="box-container-icon mb-1 p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/descuento-icon.svg') }}" class="w-100 img-fluid" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium label-txt-acceso-directo">Paquetes</p>
            </a>
            <a href="/servicio-domicilio" class="col-3 col-md-2 text-center text-veris bg-transparent">
                <div class="box-container-icon mb-1 p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/domicilio-icon.svg') }}" class="w-100 img-fluid" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium label-txt-acceso-directo">Domicilio</p>
            </a>
            <a href="/receta-medica" class="col-3 col-md-2 text-center text-veris bg-transparent">
                <div class="box-container-icon mb-1 p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/recetas-icon.svg') }}" class="w-100 img-fluid" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium label-txt-acceso-directo">Recetas</p>
            </a>
            <a href="/resultados" class="col-3 col-md-2 text-center text-veris bg-transparent">
                <div class="box-container-icon mb-1 p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/resultados-icon.svg') }}" class="w-100 img-fluid" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium label-txt-acceso-directo">Resultados</p>
            </a>
            @else
            <div type="button" id="cita-nueva" class="col-3 col-md-2 text-center text-veris bg-white py-2 rounded-3">
                <div class="p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/parami/cita-medica.svg') }}" class="w-100" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium txt-parami-primary">Agendar <br> cita médica</p>
            </div>
            <a href="/promociones" class="col-3 col-md-2 text-center text-veris bg-white pt-2 pb-3 rounded-3">
                <div class="p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/parami/carrito-ico.svg') }}" class="w-100" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium txt-parami-primary">Ver <br> promociones</p>
            </a>
            <a href="/receta-medica" class="col-3 col-md-2 text-center text-veris bg-white pt-2 pb-3 rounded-3">
                <div class="p-2 rounded-3">
                    <img src="{{ asset('assets/img/svg/parami/receta-ico.svg') }}" class="w-100" alt="" style="max-width: 80px;">
                </div>
                <p class="m-0 fs-18 line-height-24 fw-medium txt-parami-primary">Ver <br> mis recetas</p>
            </a>
            @endif
        </div>
    </div>
</section>