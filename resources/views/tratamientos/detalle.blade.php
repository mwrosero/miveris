@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="informacionModal" tabindex="-1" aria-labelledby="informacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="modal-title fs-5 fw-bold text-center border-bottom mb-3 pb-2">Informacion</h1>
                    <p class="fs--1 fw-bold text-primary">Servicios incluidos en la compra</p>
                    <ul>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                    </ul>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal servicios no incluidos -->
    <div class="modal fade" id="serviciosNoIncluidosModal" tabindex="-1" aria-labelledby="serviciosNoIncluidosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="modal-title fs-5 fw-bold text-center border-bottom mb-3 pb-2">Informacion</h1>
                    <p class="fs--1 fw-bold text-primary"id="descripcionServicio"></p>
                    <ul>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                    </ul>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Tú tratamiento') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0 justify-content-center mt-5">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none rounded-0">
                    <div class="card-header rounded-0 position-relative" style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                        <div class="content-text text-white lh-1">
                            <p class="mb-0">Veris te regala un</p>
                            <h4 class="text-white mb-0" id="content-descuento">% de descuento</h4>
                            <p class="mb-0">por pagar en app</p>
                        </div>
                        <div class="promo-img position-absolute">
                            <img src="{{ asset('assets/img/svg/regalo.svg') }}" class="card-img-top" alt="">
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <a href="#" class="d-flex align-items-center gap-2 bg-white py-2 px-3">
                            <img src="{{ asset('assets/img/svg/especialidades/alergologia.svg') }}" alt="especialidad" />
                            <div class="ms-2">
                                <h6 class="fw-bold mb-0">Traumatología</h6>
                                <p class="fw-normal fs--1 mb-0">Ver tratamiento en PDF <i class="bi bi-chevron-right ms-2"></i></p>
                            </div>
                        </a>
                        <h6 class="fw-bold py-2 px-3 mb-0" style="background: #E9EFF4;">Selecciona tus servicios</h6>
                        <div class="d-flex justify-content-between align-items-center px-3 py-1 bg-labe-grayish">
                            <span class="fw-bold fs--2">Servicio</span>
                            <span class="fw-bold fs--2">Cantidad</span>
                        </div>
                        <ul class="list-group gap-2 bg-white rounded-0" id="listaServicios">
                            <!-- items -->
                            
                            
                        </ul>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-normal text-veris fs--2 bg-labe-grayish" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Servicios que no están incluidos en tu compra. 
                                    </button>
                                </h2>
                                <div>
                                    <!-- items servicios no incluidos -->
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body" >Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center bg-white mb-3 py-2">
                            <div class="content-img">
                                <img src="{{ asset('assets/img/svg/regalo_abierto.svg') }}" alt="" />
                            </div>
                            <div class="ms-4">
                                <p class="text-danger fw-normal fs--2 mb-0" id="content-precioBase">Precio normal <del class="fw-bold" id="precioBaseEnd"></del></p>
                                <h2 class="text-primary fw-bold mb-0" id="precioTotalEnd"></h2>
                            </div>
                        </div>
                        <div class="p-3">
                            <button type="button" class="btn btn-primary-veris w-100 mb-3"  id="btnComprar">Comprar</button>
                            <a href="#" class="btn w-100 mb-3">Ahora no</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script>
<script>



    // variables globales
    let datosValorizacion = [];
    let codigoTratamiento = {{ $codigoTratamiento }};
    // llamada al dom
    
    document.addEventListener("DOMContentLoaded", async function () {

        await valorizacionServicios();
    });


    // funciones asyncronas

    // Obtener la valorizacion de los servicios del tratamiento
    async function valorizacionServicios() {
        let args = {};
        let idTratamiento = codigoTratamiento;
        let canalOrigenDigital = 'APP_CMV';
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/${idTratamiento}/valorizacion_servicio`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "codigoPreTransaccion": null,
            "canalOrigenDigital": canalOrigenDigital,
        });

        const data = await call(args);
        console.log('dataservicio', data);

        if(data.code == 200){
            datosValorizacion = data.data;
            
            // llenar el content descuento
            let contentDescuento = $('#content-descuento');
            contentDescuento.empty();
            contentDescuento.append(`${data.data.porcentajeDescuentoPromocion}% de descuento`);

            let html = $('#listaServicios');
            html.empty();
            let precioTotal = 0;
            let elemento = '';

            data.data.serviciosIncluyeCompra.forEach((resultados) => {
                elemento += `<li class="list-group-item d-flex justify-content-between align-items-center shadow-veris border-0 rounded-0">
                                <div class="w-auto">
                                    <p class="text-veris mb-0">${resultados.descripcionServicio}</p>
                                    <div class="d-flex align-items-center">
                                        <p class="text-primary fw-bold fs--2 mb-0" id="precioTotal">
                                            <del class="text-danger fw-normal" id="precioBase">$${resultados.valorNormal}</del> 
                                            $${resultados.valorPromocion}
                                            <input type="hidden" id="valorPromocionHidden" value="${resultados.valorPromocion}">
                                            <input type="hidden" id="valorNormalHidden" value="${resultados.valorNormal}">
                                        </p>
                                        <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" data-bs-toggle="modal" data-bs-target="#informacionModal" data-rel='${JSON.stringify(resultados)}' ><i class="bi bi-info-circle"></i> </button> 
                                    </div>
                                </div>
                                <div class="input-group input-group-sm flex-nowrap w-25" data-quantity="data-quantity">
                                    <button class="btn btn-sm btn-minus px-2" data-type="minus">-</button>
                                    <input class="form-control text-center input-spin-none bg-transparent px-0" type="number" min="0" max=${resultados.cantidadMaximaPermitida}
                                    value="1" />
                                    <button class="btn btn-sm btn-plus px-2" data-type="plus">+</button>
                                </div>
                            </li>`;
            });
            html.append(elemento);

            let serviciosNoIncluidos = $('#flush-collapseOne');
            serviciosNoIncluidos.empty();
            let elementoNoIncluido = '';


            data.data.serviciosNoIncluyeCompra.forEach((resultados) => {
                elementoNoIncluido += `<div class="d-flex align-items-center justify-content-between">
                                            <div class="accordion-body" style="flex-grow: 1;">${resultados.descripcionServicio}</div>
                                            <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" style="color: ${resultados.colorInformacion};"
                                                data-bs-toggle="modal" data-bs-target="#serviciosNoIncluidosModal" data-rel='${JSON.stringify(resultados)}'>
                                                <i class="bi bi-info-circle"></i>
                                            </button>
                                        </div>`;
            });
            
            serviciosNoIncluidos.append(elementoNoIncluido);

            // eventos de los precios

            let precioBaseEnd = $('#precioBaseEnd');
            let precioTotalEnd = $('#precioTotalEnd');
            
            precioBaseEnd.empty();
            precioTotalEnd.empty();

            precioBaseEnd.append(`$${data.data.valorNormal}`);
            precioTotalEnd.append(`$${data.data.valorPromocion}`);


            $('.btn-minus, .btn-plus').off('click').on('click', function() {
                let input = $(this).closest('.input-group').find('input');
                let currentValue = parseInt(input.val());
                let maxValue = parseInt(input.attr('max'));

                let precioBaseElement = $(this).closest('li').find('#precioBase');
                let precioPromocionElement = $(this).closest('li').find('#precioTotal');
                let precioBaseHidden = $(this).closest('li').find('#valorNormalHidden');
                let precioPromocionHidden = $(this).closest('li').find('#valorPromocionHidden');

                if ($(this).hasClass('btn-minus')) {
                    if (currentValue > 0) {
                        input.val(currentValue - 1);
                        console.log(precioPromocionHidden.val());
                        console.log(precioBaseHidden.val());
                        // Actualizar los valores al disminuir la cantidad
                        updatePrices(precioBaseElement, precioPromocionElement, currentValue - 1, precioBaseHidden, precioPromocionHidden);
                    }
                } else if ($(this).hasClass('btn-plus')) {
                    if (currentValue < maxValue) {
                        input.val(currentValue + 1);
                        // Actualizar los valores al aumentar la cantidad
                        updatePrices(precioBaseElement, precioPromocionElement, currentValue + 1, precioBaseHidden, precioPromocionHidden);
                    }
                }

                 // Verificar si todos los contadores han llegado a cero y deshabilitar el botón
                let allCountersZero = $('.input-group input').toArray().every(function(el) {
                    return parseInt($(el).val()) === 0;
                });

                if (allCountersZero) {
                    $('#btnComprar').prop('disabled', true);
                } else {
                    $('#btnComprar').prop('disabled', false);
                }



            });

            function updatePrices(precioBaseElement, precioPromocionElement, newQuantity, precioBaseHidden, precioPromocionHidden) {

                // obtener los valores de los inputs hidden
                let valorPromocion = parseFloat(precioPromocionHidden.val());
                let valorNormal = parseFloat(precioBaseHidden.val());

                let valorPrecioBase = parseFloat(precioBaseElement.text().split('$')[1]);
                let valorPrecioPromocion = parseFloat(precioPromocionElement.text().split('$')[1]);

                console.log('valorPromocion', valorPromocion)
                console.log('valorNormal', valorNormal)

                let precioBaseCambia = valorPrecioBase * newQuantity;
                let precioPromocionCambia = valorPrecioPromocion * newQuantity;

                if (newQuantity > 1) {
                    // restablecer los valores de los precios
                    console.log('entro al caso 2')
                    precioBaseCambia = valorNormal * newQuantity;
                    precioPromocionCambia = valorPromocion * newQuantity;
                }
                else if (newQuantity == 0) {
                    precioBaseCambia = 0;
                    precioPromocionCambia = 0;
                }
                else if (newQuantity == 1) {
                    // restablecer los valores de los precios
                    console.log('entro al caso 1')
                    precioBaseCambia = valorNormal;
                    precioPromocionCambia = valorPromocion;
                }

                // Actualizar los valores del  preciobaseElement y precioPromocionElement
                precioBaseElement.text(`$${precioBaseCambia.toFixed(2)}`);
                precioPromocionElement.text(`$${precioPromocionCambia.toFixed(2)}`);
                
                // Actualizar el precio total

                let precioTotal = 0;
                let precioTotalElement = $('#precioTotalEnd');
                precioTotalElement.empty();


                 

                $('#listaServicios li').each(function() {
                    let precioPromocion = parseFloat($(this).find('#precioTotal').text().split('$')[1]);
                    precioTotal += precioPromocion;
                });

                precioTotalElement.append(`$${precioTotal.toFixed(2)}`);

            }
        return data;
    }
    }

    // actualizar la valorizacion de los servicios del tratamiento con un put

    function actualizarValorizacionServicios() {
        let args = {};
        let idTratamiento = 2102945;
        let canalOrigenDigital = 'APP_CMV';
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/${idTratamiento}/valorizacion_servicio`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "codigoPreTransaccion": null,
            "canalOrigenDigital": canalOrigenDigital,
        });

        const data = call(args);
        console.log('dataservicio', data);
        return data;
    }

    // funciones js

    // boton info
    $('#informacionModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let recipient = button.data('rel') // Extract info from data-* attributes
       
        let modal = $(this);
        modal.find('.modal-body').empty();
        modal.find('.modal-body').append(`<h1 class="modal-title fs-5 fw-bold text-center border-bottom mb-3 pb-2">${recipient.descripcionServicio}</h1>
                                            <p class="fs--1 fw-bold text-primary">Servicios incluidos en la compra</p>
                                            <ul id="listaServicios"></ul>`);
        let listaServicios = modal.find('#listaServicios');
        recipient.detallePrestaciones.forEach((resultados) => {
            resultados.grupoDetalles.forEach((resultados2) => {
                listaServicios.append(`<li>${resultados2.nombrePrestacion}</li>`);
            });
        });

    })

    // boton info servicios no incluidos
    $('#serviciosNoIncluidosModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let recipient = button.data('rel') // Extract info from data-* attributes
       
        let modal = $(this);
        modal.find('.modal-body').empty();
        modal.find('.modal-body').append(`<h1 class="modal-title fs-5 fw-bold text-center border-bottom mb-3 pb-2">Informacion</h1>
                                            <p class="fs--1 fw-bold text-primary">${recipient.detallePrestaciones[0].descripcionGrupoDetalle}</p>
                                            <ul id="listaServicios"></ul>`);
        let listaServicios = modal.find('#listaServicios');
        recipient.detallePrestaciones.forEach((resultados) => {
            resultados.grupoDetalles.forEach((resultados2) => {
                listaServicios.append(`<li>${resultados2.nombrePrestacion}</li>`);
            });
        });

    })


    // boton comprar redireccionar a la pagina de pago
    $('#btnComprar').on('click', function() {
        window.location.href = "/citas-revisa-tus-datos";
    })
    
    // boton cancelar redireccionar a la pagina de citas
    $('#btnCancelar').on('click', function() {
        window.location.href = "/citas";
    })




</script>
@endpush