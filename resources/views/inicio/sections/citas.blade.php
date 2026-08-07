<!-- Mis citas dinamico -->
<section class="{{ config('app.subdomain') == 'veris' ? 'bg-light-grayish-blue' : '' }} p-3 d-none" id="section-citas">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-medium border-start-veris ps-3 fs-18 mb-0">Próximas citas</h5>
        <a href="{{route('citas')}}" class="btn btn-sm text-primary-veris fs--2 d-none">Ver todas <i class="fa-solid fa-chevron-right ms-3"></i></a>
    </div>
    <div class="swiper swiper-proximas-citas position-relative py-3 pt-0">
        <div class="swiper-wrapper px-1 mb-3 mb-md-0" id=contenedorCitas>
        </div>
        <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
        <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
    </div>
    <div class="py-3 d-none" id="contenedorCitasHomePrincipal"></div>
</section>