@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Confirma tu atención
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Confirma tu atención') }}</h5>
    </div>
    <section class="pt-4 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="text-center">
                    <h5 class="fs-24 line-height-28 mb--32" style="color: #FC0326 !important;">Urgencias ambulatorias</h5>
                    <p class="fs--1 line-height-16 fw-medium text-veris mb-5">Cuando lo que tienes no puede esperar.</p>
                    <img src="{{asset('assets/img/svg/vua.svg')}}" class="mb-5" alt="vua">
                    <div class="swiper swiperSintoma position-relative py-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Vómitos</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Malestar</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Cortes</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Vómitos</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Malestar</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Cortes</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Vómitos</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Malestar</p>
                            </div>
                            <div class="swiper-slide">
                                <p class="text-veris fs--16 line-height-20 mb-0 p-10">Cortes</p>
                            </div>
                        </div>
                        <button type="button" id="prevProperties" class="d-flex mt-n4 btn btn-prev-arrow fs--24"></button>
                        <button type="button" id="nextProperties" class="d-flex mt-n4 btn btn-next-arrow fs--24"></button>
                    </div>
                    <div class="form-check d-flex justify-content-center align-items-center mb-4">
                        <input class="form-check-input atencionInmediata-input me-2 mb-1" type="checkbox" value="" id="checkConfirmacionInmediata" required>
                        <label class="form-check-label fs--1 fw-normal line-height-16 text-veris text-start" for="checkConfirmacionInmediata">
                            Confirmo que tengo un caso de atención inmediata
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary-veris fs--18 line-height-24 fw-medium shadow-none w-100 px-4 py-3" type="button" id="btnAtencionInmediata" disabled> Agendar</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var swiper = new Swiper(".swiperSintoma", {
        spaceBetween: 13,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.btn-next-arrow',
            prevEl: '.btn-prev-arrow',
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>
@endpush