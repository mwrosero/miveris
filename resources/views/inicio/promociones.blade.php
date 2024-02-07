@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Promociones
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Promociones') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0" id="search"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control bg-transparent border-0" name="buscarPorPromocion" id="buscarPorPromocion" placeholder="Buscar plan preventivo" aria-describedby="search" />
                </div>
            </div>
        </form>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row gy-3" id="listado-paquetes">
                    {{-- <div class="col-md-6">
                        <div class="card w-100">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img/svg/promocion.svg') }}" class="img-fluid" alt="{{ __('promoción') }}">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body p--2">
                                            <h6 class="text-end fw-medium text-one-line">Prevención y Cuidado Mamario Integral</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-medium lh-1 mb-0" style="color: #6E7A8C !important;">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
           
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let page = 1;
    let perPage = 16;
    let cargandoContenido = false;
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerPaquetesPromocionales();

        $(window).scroll(function() {
            if(!cargandoContenido && $(window).scrollTop() + $(window).height() + 10 > $(document).height()) {
                cargandoContenido = true;
                console.log("near bottom!");
                obtenerPaquetesPromocionales();
            }
        });

        $('body').on('click','.btn-comprar', function(){
            let url = '/promocion/detalle/';
            let data = {
                "paquete": JSON.parse($(this).attr("data-rel"))
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
            location.href = url + "{{ $tokenCita }}";
        })

        var typingTimer; // Timer identifier
        var doneTypingInterval = 500; // Tiempo de pausa en milisegundos (0.5 segundos)

        // Evento de escritura en el input
        $('#buscarPorPromocion').on('keyup', function() {
            clearTimeout(typingTimer); // Limpiar el temporizador cada vez que se escribe

            var searchText = $(this).val();
            if (searchText.length >= 3) { // Solo realizar la búsqueda si hay al menos 3 caracteres
                typingTimer = setTimeout(function() {
                    page = 1;
                    $('#listado-paquetes').empty();
                    cargandoContenido = false;
                    obtenerPaquetesPromocionales(); // Llamar a la función de búsqueda después de la pausa
                }, doneTypingInterval);
            }else if(searchText.length == 0){
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                obtenerPaquetesPromocionales();
            }
        });

        $('#buscarPorPromocion').on('search', function() {
            if ($(this).val().length === 0) {
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                obtenerPaquetesPromocionales();
            }
        });


    })

    async function obtenerPaquetesPromocionales(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=POR_ASIGNAR&page=${page}&perPage=${perPage}&verDetalle=false&buscarPorPromocion=${ encodeURIComponent(getInput('buscarPorPromocion')) }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let elem = ``;
            if(data.data.items.length == 0){
                cargandoContenido = true;
            }else{
                cargandoContenido = false;  
            }
            $.each(data.data.items, function(key, paquete){
                elem += `<div class="col-md-6">
                    <div class="card w-100">
                        <div class="row cursor-pointer btn-comprar g-0 justify-content-between align-items-center" data-rel='${ JSON.stringify(paquete) }'>
                            <div class="col-3">
                                <img src="{{ asset('assets/img/svg/promocion.svg') }}" class="img-fluid" alt="{{ __('promoción') }}">
                            </div>
                            <div class="col-9">
                                <div class="card-body p--2">
                                    <h6 class="text-end fw-medium text-one-line">${paquete.nombrePaquete}</h6>
                                    <div class="d-flex justify-content-end">`;
                                if(paquete.porcentajeDescuento > 0){
                                    elem += `<span class="badge bg-primary d-flex align-items-center px-3 mx-3">-${paquete.porcentajeDescuento}%</span>`;
                                }
                                    elem += `<div class="content-precio text-end">`;
                                if(paquete.porcentajeDescuento > 0){
                                    elem += `<p class="text-secondary fs--3 mb-0">Antes <del>$${paquete.valorAnteriorPaquete.toFixed(2)}</del></p>`
                                }
                                    elem += `<h4 class="fw-medium lh-1 mb-0" style="color: #6E7A8C !important;">$${paquete.valorTotalPaquete.toFixed(2)}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            })
            page++;
            $('#listado-paquetes').append(elem);
        }else{
            alert(data.message);
        }
    }
</script>
@endpush