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
{{-- Modal Categoria Promociones --}}
<div class="modal fade" id="modalCategoriaPromociones" tabindex="-1" aria-labelledby="modalCategoriaPromociones" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body text-center p-3 pb-0" id="lista-categorias">
                {{-- <h1 class="modal-title fs--20 line-height-24 my-3">Filtrar por</h1>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-person-dress fs--20 me-3"></i>
                    <span class="fs--16 me-3">Mujeres</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-person fs--20 me-3"></i>
                    <span class="fs--16 me-3">Hombres</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-child-reaching fs--20 me-3"></i>
                    <span class="fs--16 me-3">Adolescentes</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-baby fs--20 me-3"></i>
                    <span class="fs--16 me-3">Niños</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-person-cane fs--20 me-3"></i>
                    <span class="fs--16 me-3">Adultos mayores</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-display fs--20 me-3"></i>
                    <span class="fs--16 me-3">Veris virtual</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-tag fs--20 me-3"></i>
                    <span class="fs--16 me-3">Promociones</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                    <i class="fa-solid fa-tooth fs--20 me-3"></i>
                    <span class="fs--16 me-3">Odontológicos</span>
                    <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                </div> --}}
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris btnAplicarFiltroCategorias fw-medium fs--18 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aplicar</button>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Paquetes preventivos') }}</h5>
    </div>
    <section class="mb-0 p-3 pb-0">
        <div class="row justify-content-center mb-3 pt-3" style="background: #F3F4F5;">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3 mb-3" id="pills-tab-page" role="tablist">
                <li class="nav-item" role="presentation" style="width: 150px;">
                    <button data-rel='tienda' class="nav-link page-promociones px-8 px-md-5 active" id="pills-tienda-tab" data-bs-toggle="pill" data-bs-target="#pills-tienda" type="button" role="tab" aria-controls="pills-tienda" aria-selected="true">Tienda</button>
                </li>
                <li class="nav-item" role="presentation" style="width: 190px;">
                    <button data-rel='mis-promociones' class="nav-link page-promociones px-8 px-md-5" id="pills-mis-paquetes-tab" data-bs-toggle="pill" data-bs-target="#pills-mis-paquetes" type="button" role="tab" aria-controls="pills-mis-paquetes" aria-selected="false">Mis paquetes</button>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-8 mb-3 d-flex justify-content-between align-items-center">
                <img src="{{asset('assets/img/svg/BANNER_CUIDATE_X_MI.png')}}" class="w-100 link-item-banner" type='button' search-rel='Cuidate por mi' alt="">
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-8 mb-3 d-flex justify-content-between align-items-center">
                <div class="input-group search-box" style="border: 1px solid #D0D3D9">
                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-promociones"></span>
                    <input type="search" class="form-control bg-transparent fs--16 border-0 p-2 ps-0" name="buscarPorPromocion" id="buscarPorPromocion" value="{{ request()->query('s') }}" placeholder="Ejemplo: Exámenes de laboratorio" aria-describedby="search" style="border-radius: 8px;" />
                </div>
                <button class="btn btn-sm btn-outline-primary-veris ms-2 px-2 waves-effect flex-grow-1 h-100" type="button" data-bs-toggle="modal" data-bs-target="#modalCategoriaPromociones" style="width: 160px;border-radius: 8px;">
                    <img src="{{asset('assets/img/svg/fa-filter.svg')}}" class="me-1" alt="filtro categorías"> 
                    <p class="fs--1 line-height-16 fw-normal mb-0" id="nombreFiltro">Filtrar por</p>
                </button>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-8 mb-3 d-flex justify-content-between align-items-center">
                <div class="box-categorias-seleccionadas ms-2 mt-2 d-inline-block justify-content-start align-items-center"></div>
            </div>
        </div>
    </section>
    <section class="mb-3 p-3 pt-0">
        <div class="row justify-content-center mt-0">
            <div class="col-12 col-md-8">
                <div class="row gy-3" id="listado-paquetes">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<style>
    #buscarPorPromocion{
        border: none !important;
        background: initial !important;
    }
    .badge-discount {
        border-radius: 0px 0px 0px 4px;
        padding: 8px 12px;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        background: #cc0b39;
        font-size: 16px;
        font-style: normal;
        font-weight: 350;
        line-height: 20px;
    }
    .box-discount {
        font-size: 12px;
        line-height: 16px;
        color: #CC0B39;
        border: 1px solid #CC0B39;
        border-radius: 4px !important;
        width: auto;
    }
    .badge-domicilio {
        background: #D4E1FC;
        font-size: 12px;
        line-height: 16px;
        padding: 8px 12px !important;
    }
    input:not([type="checkbox"]):not([type="radio"]):not(:focus):not(:disabled):placeholder-shown, input:not([type="checkbox"]):not([type="radio"]):not(:focus):not(:disabled):not(:placeholder-shown), select:not(:focus):not(:disabled){
        box-shadow: none !important;
        outline: none !important;
    }
    input:not([type="checkbox"]):not([type="radio"]):focus, select:focus{
        box-shadow: none !important;
    }
</style>
<script>
    let page = 1;
    let perPage = 8;
    let cargandoContenido = false;
    let isFiltered = false;
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerCategorias();

        // await obtenerPaquetesSugeridos();
        await obtenerPaquetesPromocionales();

        $('body').on('click', '.link-item-banner', async function(){
            let s = $(this).attr('search-rel');
            $('#buscarPorPromocion').val(s).trigger('change');
            page = 1;
            $('#listado-paquetes').empty();
            await obtenerPaquetesPromocionales();
        })

        $('body').on('click','.page-promociones', function(){
            let section = $(this).attr('data-rel');
            if(section == 'tienda'){
                location.href = '/promociones';
            }else{
                location.href = '/mis-promociones';
            }
        })

        $('body').on('click', '.btnEliminarCategoria', async function(){
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').removeClass('category-selected');
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').find('.ico-unselected').removeClass('d-none')
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').find('.ico-selected').addClass('d-none')
            $('.btnAplicarFiltroCategorias').click();
        })

        $('body').on('click', '.btnAplicarFiltroCategorias', async function(){
            let categorias = await obtenerCategoriasSeleccionadas("texto-valor");
            let elem = ``;
            $.each(categorias, function(key, value){
                let label = value.split("-");
                elem += `<span class="badge bg-filter-promocion p-2 me-2 mb-2 fs--2 fw-medium">${label[1]} <i class="fa-solid fa-xmark ms-2 cursor-pointer btnEliminarCategoria" categoria-rel="${label[0]}"></i></span>`
            })
            $('.box-categorias-seleccionadas').html(elem);
            categorias.join(',')
            page = 1;
            $('#listado-paquetes').empty();
            cargandoContenido = false;
            isFiltered = true;
            await obtenerPaquetesPromocionales();
            isFiltered = false;
        })

        $('body').on('click', '.category-item', function(){
            // if (!$(event.target).hasClass('btn-unselect')) {
                if($(this).hasClass('category-selected')){
                    $(this).find('.ico-unselected').removeClass('d-none')
                    $(this).find('.ico-selected').addClass('d-none')
                    $(this).removeClass('category-selected');
                }else{
                    $(this).find('.ico-selected').removeClass('d-none')
                    $(this).find('.ico-unselected').addClass('d-none')
                    $(this).addClass('category-selected');
                }
            // }
        })

        // $('body').on('click', '.btn-unselect', function(){
        //     $(this).parent().removeClass('category-selected');
        // })

        var swiper = new Swiper('.swiper-promociones-sugeridas', {
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
                    slidesPerView: 1.1,
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
                    slidesPerView: 3.1,
                    // spaceBetween: 8,
                },
            },
        });

        $('#list-promociones-sugeridas').removeClass('invisible');

        $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll); 

        async function onScroll(){
            console.log('onScroll');
            if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 100 > $(document).height()) {
                cargandoContenido = true;
                console.log("near bottom!");
                await obtenerPaquetesPromocionales();
            }
        }

        // $(window).scroll(function() {
        // $(window).on('scroll touchmove', async function() {
        //     if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 10 > $(document).height()) {
        //         cargandoContenido = true;
        //         // console.log("near bottom!");
        //         obtenerPaquetesPromocionales();
        //     }
        // });

        $('body').on('click','.btn-comprar', function(){
            let url = '/promocion/detalle/';
            let data = {
                "paquete": JSON.parse($(this).attr("data-rel"))
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
            location.href = url + "{{ $tokenCita }}";
        })

        var typingTimer; // Timer identifier
        var doneTypingInterval = 750; // Tiempo de pausa en milisegundos (0.5 segundos)

        // Evento de escritura en el input
        $('#buscarPorPromocion').on('keyup', async function() {
            clearTimeout(typingTimer); // Limpiar el temporizador cada vez que se escribe

            var searchText = $(this).val();
            if (searchText.length >= 3) { // Solo realizar la búsqueda si hay al menos 3 caracteres
                typingTimer = setTimeout(async function() {
                    page = 1;
                    $('#listado-paquetes').empty();
                    cargandoContenido = true;
                    await obtenerPaquetesPromocionales(); // Llamar a la función de búsqueda después de la pausa
                }, doneTypingInterval);
            }else if(searchText.length == 0){
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                await obtenerPaquetesPromocionales();
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

    async function obtenerCategoriasSeleccionadas(type){
        var itemsSeleccionados = [];
        $('.category-item').each(function() {
            if ($(this).hasClass('category-selected')) {
                if(type == "valor"){
                    itemsSeleccionados.push($(this).attr('categoria-rel'))
                }else{
                    itemsSeleccionados.push($(this).attr('categoria-rel')+'-'+$(this).attr('nombreCategoria-rel'))
                }
            }
        });
        return itemsSeleccionados;
    }

    async function obtenerCategorias(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/categoriasPaquete?canalOrigen=${_canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        let preSelected = false;
        if(data.code == 200){
            let elem = `<h1 class="modal-title fs--20 line-height-24 my-3">Filtrar por</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute;right: 5px;top: 5px;"></button>`;
            $.each(data.data, function(key, categoria){
                let params = new URLSearchParams(window.location.search);
                let cat_sel = ``;
                if (params.has("c") && params.get("c") === categoria.nemonicoCategoria) {
                    preSelected = true;
                    cat_sel = `category-selected`;
                }
                elem += `<div nombreCategoria-rel="${capitalizarCadaPalabra(categoria.nombreCategoria)}" categoria-rel="${categoria.nemonicoCategoria}" class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item ${cat_sel}">
                        <img src="${categoria.urlImagenCategoria}" class="ico-categoria me-3 ico-unselected"/>
                        <img src="${categoria.urlImagenCategoriaSel}" class="ico-categoria me-3 ico-selected d-none"/>
                        <span class="fs--16 me-3 text-veris">${capitalizarCadaPalabra(categoria.nombreCategoria)}</span>
                        <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                    </div>`
            })
            $('#lista-categorias').html(elem)
            if (preSelected) {
                let categorias = await obtenerCategoriasSeleccionadas("texto-valor");
                let elem = ``;
                $.each(categorias, function(key, value){
                    let label = value.split("-");
                    elem += `<span class="badge bg-filter-promocion p-2 me-2 mb-2 fs--2 fw-medium">${label[1]} <i class="fa-solid fa-xmark ms-2 cursor-pointer btnEliminarCategoria" categoria-rel="${label[0]}"></i></span>`
                })
                console.log(elem)
                $('.box-categorias-seleccionadas').html(elem);
                categorias.join(',')
            }
        }
    }

    async function obtenerPaquetesSugeridos(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=SUGERIDOS&page=1&perPage=5&idPaciente={{ Session::get('userData')->numeroPaciente }}&estaPagado=false&verDetalle=false`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data)

        if(data.code == 200){
            let elem = ``;
            $.each(data.data.items, function(key, value){
                let nombrePaquete = (value.nombreComercialPaquete !== null) ? value.nombreComercialPaquete : value.nombrePaquete;
                elem += `<div class="swiper-slide">
                    <a class="cursor-pointer btn-comprar" data-rel='${ JSON.stringify(value) }'>
                        <div class="card m-1">
                            <div class="card-header position-relative feature-img-promocion" style="background: url(${value.urlImagen}) no-repeat center;">`;
                            if(value.porcentajeDescuento && value.porcentajeDescuento > 0){
                                elem += `<span class="label-descuento-promocion position-absolute fs--2 fw-medium">-${value.porcentajeDescuento}%</span>`;
                            }
                        elem += `</div>
                            <div class="card-body p-3 pb-0">
                                <h2 class="title-promocion fs--16 line-height-20 mb-2 text-capitalize">${nombrePaquete.toLowerCase()}</h2>
                                <h5 class="paciente-promocion fs--2 p-2 mb-2 text-nowrap overflow-hidden text-truncate text-capitalize"><strong>Ideal para: </strong>${value.nombrePaciente.toLowerCase()}</h5>
                            </div>
                            <div class="card-footer border-0 d-flex justify-content-between align-items-center p-3 pt-0">`;
                            if(value.porcentajeDescuento && value.porcentajeDescuento > 0){
                                elem += `<div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$${value.valorAnteriorPaquete.toFixed(2)}</span>
                                </div>`;
                            }
                            elem += `<div class="precio-venta ms-auto fs-medium">$${value.valorTotalPaquete.toFixed(2)}</div>
                            </div>
                        </div>
                    </a>
                </div>`;
            })
            $('#list-promociones-sugeridas').html(elem);
        }
    }

    async function obtenerPaquetesPromocionales(){
        let categorias = await obtenerCategoriasSeleccionadas("valor");
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=POR_ASIGNAR&page=${page}&perPage=${perPage}&estaPagado=false&verDetalle=false&categoria=${ categorias.join(',') }&buscarPorPromocion=${ (getInput('buscarPorPromocion').replace(/\s/g, '+')) }`;
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
            if(data.data.items.length > 0){
                $.each(data.data.items, function(key, value){
                    let strDescuento = ``;
                    let strDescuentoFooter = ``;
                    let badgesImg = ``;
                    if(value.porcentajeDescuento > 0){
                        //strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">-${value.porcentajeDescuento}%</span>`;
                        if(value.esDescuentoExclusivo){
                           strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">Desct. exclusivo web</span>`;
                        }
                        strDescuentoFooter = `<div class="p-1 font-gotham box-discount fw-medium text-center d-inline-block mb-1">-${value.porcentajeDescuento}% dto.</div><p class="mb-0 font-gotham text-muted text-sm">Antes <span class="text-decoration-line-through"> $${value.valorAnteriorPaquete}</span></p>`;
                    }
                    if(value.esDomicilio){
                        badgesImg = `<div class="position-absolute bottom-0 p-2 m-1 d-flex justify-content-start align-items-center">
                            <div class="p-2 badge-domicilio text-primary fw-medium rounded-1 font-gotham d-flex justify-content-between"><img src="{{asset('assets/img/svg/fa-icon-domicilio.svg')}}" style="width: 16px;margin-right: 4px;">A domicilio</div>
                        </div>`
                    }
                    elem += `<div class="col-12 col-md-6">
                        <div class="card h-100 border-0 box-shadow-3 rounded-4 p-3">
                            <div type="button" class="zoom-img btn-comprar position-relative rounded-3 overflow-hidden" data-rel='${JSON.stringify(value)}'>
                                <img src="${value.urlImagen}" onerror="this.onerror=null;this.src='https://www.veris.com.ec/wp-content/themes/veris2025/img/veris.png';"   class="card-img-top" alt="${value.nombrePaquete}">
                                ${strDescuento}
                                ${badgesImg}
                            </div>
                            <div class="card-body px-0">
                                <h5 class="card-title fs--4 text-capitalize text-primary">${value.nombreComercialPaquete.toLowerCase()}</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    ${strDescuentoFooter}
                                    <h4 class="text-primary font-gotham fw-bold mb-0">$${value.valorTotalPaquete}</h4>
                                </div>
                                <div type="button" data-rel='${JSON.stringify(value)}' class="btn btn-sm bg-veris-ai text-white fs--1 fw-medium ms-2 m-0 line-height-16 btn-comprar">Ver paquete</div>
                            </div>
                        </div>
                    </div>`;
                })
                page++;
            }else{
                if(page == 1){
                    $('#listado-paquetes').empty();
                    elem += `<p class="fs--16 line-height-20 text-center mt-5 mb-4">No se encontraron coincidencias para tu búsqueda</p>`;
                }
            }
            $('#listado-paquetes').append(elem);
        }else{
            alert(data.message);
        }
    }
</script>
@endpush