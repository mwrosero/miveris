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
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar')

{{-- Modal Categoria Promociones --}}
<div class="modal fade" id="modalCategoriaPromociones" tabindex="-1" aria-labelledby="modalCategoriaPromociones" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body text-center p-3 pb-0" id="lista-categorias">
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris btnAplicarFiltroCategorias fw-medium fs--18 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aplicar</button>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Comprar promociones') }}</h5>
    </div>
    <section class="mb-0 p-3 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18">{{ __('Promociones disponibles') }}</h5>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6 mb-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-promociones"></span>
                    <input type="search" class="form-control bg-transparent fs--16 border-0 p-2 ps-0" name="buscarPorPromocion" id="buscarPorPromocion" placeholder="Ejemplo: Exámenes de laboratorio" aria-describedby="search" />
                </div>
            </div>
        </div>
    </section>
    <section class="mb-3 shadow-bottom">
        <div class="col-auto p-2">
            <button class="btn btn-sm btn-outline-primary-veris ms-2 px-2 waves-effect" type="button" data-bs-toggle="modal" data-bs-target="#modalCategoriaPromociones">
                <p class="fs--1 line-height-16 fw-normal mb-0" id="nombreFiltro">Filtrar por categorías</p>
                <img src="{{asset('assets/img/svg/arrow-down.svg')}}" class="ms-1" alt="filtro categorías"> 
            </button>
            <div class="box-categorias-seleccionadas ms-2 mt-2 d-inline-block justify-content-start align-items-center"></div>
        </div>
    </section>
    <section class="mb-3 p-3 pt-0">
        <div class="row justify-content-center mt-0">
            <div class="col-lg-10">
                <div class="row gy-3" id="listado-paquetes">
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let page = 1;
    let perPage = 12;
    let cargandoContenido = false;
    let isFiltered = false;
    let canalOrigen = (window.config.subdomain == "veris") ? "VER_CMV" : "VER_PMF";

    document.addEventListener("DOMContentLoaded", async function () {
        console.log(99)
        obtenerCategorias();
        await obtenerPaquetesPromocionales();

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
            let url = '/external/planes-promocionales/detalle/';
            let data = {
                "paquete": JSON.parse($(this).attr("data-rel"))
            };
            localStorage.setItem('external-cita-{{ $tokenCita }}', JSON.stringify(data));
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
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/categoriasPaquete?canalOrigen=${canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        
        if(data.code == 200){
            let elem = `<h1 class="modal-title fs--20 line-height-24 my-3">Filtrar por</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute;right: 5px;top: 5px;"></button>`;
            $.each(data.data, function(key, categoria){
                elem += `<div nombreCategoria-rel="${capitalizarCadaPalabra(categoria.nombreCategoria)}" categoria-rel="${categoria.nemonicoCategoria}" class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                        <img src="${categoria.urlImagenCategoria}" class="ico-categoria me-3 ico-unselected"/>
                        <img src="${categoria.urlImagenCategoriaSel}" class="ico-categoria me-3 ico-selected d-none"/>
                        <span class="fs--16 me-3 text-veris">${capitalizarCadaPalabra(categoria.nombreCategoria)}</span>
                        <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                    </div>`
            })
            $('#lista-categorias').html(elem)
        }
    }

    async function obtenerPaquetesPromocionales(){
        let categorias = await obtenerCategoriasSeleccionadas("valor");
        let args = [];

        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${canalOrigen}&codigoEmpresa=1&tipoFiltro=POR_ASIGNAR&page=${page}&perPage=${perPage}&estaPagado=false&verDetalle=false&categoria=${ categorias.join(',') }&buscarPorPromocion=${ (getInput('buscarPorPromocion').replace(/\s/g, '+')) }`;
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
                $.each(data.data.items, function(key, paquete){
                    elem += `<div class="col-md-6">
                        <div class="card w-100" style="border: 1px solid #E7E9EC;box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.10);border-radius: 8px;">
                            <div class="row g-0 justify-content-between aling-items-center cursor-pointer btn-comprar" data-rel='${ JSON.stringify(paquete) }'>
                                <div class="col-4 position-relative feature-img-promocion-horizontal" style="background: url(${paquete.urlImagen}) no-repeat center;">`
                                if(paquete.porcentajeDescuento && paquete.porcentajeDescuento > 0){
                                    elem += `<span class="label-descuento-promocion position-absolute fs--2 fw-medium">-${paquete.porcentajeDescuento}%</span>`;
                                }
                                elem += `</div>
                                <div class="col-8 col-md-8">
                                    <div class="card-body h-100 p--2 pb-2 d-flex flex-column justify-content-center">
                                        <h6 class="title-promocion-horizontal fs--1 line-height-16 mb-2">${capitalizarElemento(paquete.nombrePaquete)}</h6>
                                        <div class="border-0 d-flex justify-content-between align-items-center">`;
                                            if(paquete.porcentajeDescuento && paquete.porcentajeDescuento > 0){
                                                elem += `<div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$${paquete.valorAnteriorPaquete.toFixed(2)}</span>
                                                </div>`;
                                            }
                                            elem += `<div class="precio-venta ms-auto fs-medium">$${paquete.valorTotalPaquete.toFixed(2)}</div>
                                            </div>
                                    </div>
                                </div>
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
@endsection