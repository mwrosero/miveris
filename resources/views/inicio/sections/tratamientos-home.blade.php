<!-- Tratamientos dinamico -->
<section class="{{ config('app.subdomain') == 'veris' ? 'bg-light-grayish-blue' : '' }} p-3 mb-3 d-none section-tratamientos">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-medium border-start-veris ps-3 fs-18 mb-0">Mis tratamientos</h5>
        <a href="{{route('tratamientos')}}" class="fw-medium fs--2 me-1 text-veris-ai" id="verTodosTratamientos">Ver todos</a>
    </div>
    <div class="swiper swiper-tratamientos position-relative pb-3">
        <div class="swiper-wrapper px-1 py-2" id="contenedorTratamientoHome">
        </div>
        <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
        <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
    </div>
    <div class="py-3 d-none" id="contenedorTratamientosHomePrincipal"></div>
</section>