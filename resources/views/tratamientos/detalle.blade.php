@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
@endpush
@section('content')
@php
//$data = json_decode(base64_decode($params));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="informacionModal" tabindex="-1" aria-labelledby="informacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <h1 class="modal-title fs-5 fw-medium text-center border-bottom mb-3 pb-2">Informacion</h1>
                    <p class="fs--1 fw-medium text-primary">Servicios incluidos en la compra</p>
                    <ul>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                    </ul>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal servicios no incluidos -->
    <div class="modal fade" id="serviciosNoIncluidosModal" tabindex="-1" aria-labelledby="serviciosNoIncluidosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <h1 class="modal-title fs-5 fw-medium text-center border-bottom mb-3 pb-2">Informacion</h1>
                    <p class="fs--1 fw-medium text-primary"id="descripcionServicio"></p>
                    <ul>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                    </ul>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Tú tratamiento') }}</h5>
    </div>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0 justify-content-center mt-5">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none rounded-0 d-none" id="box-detalle-promocion">
                    <div class="card-header rounded-0 position-relative" style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                        <div class="content-text text-white lh-1" id="contenedorPrincipal-descuento">
                            
                        </div>
                        <div class="promo-img position-absolute">
                            <img src="{{ asset('assets/img/svg/regalo.svg') }}" class="card-img-top" alt="">
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <a href="#" class="d-flex align-items-center gap-2 bg-white py-2 px-3">
                            <img src="{{ asset('assets/img/svg/especialidades/alergologia.svg') }}" alt="especialidad" />
                            <div class="ms-2">
                                <h6 class="fw-medium mb-0">Traumatología</h6>
                                <p class="fw-normal fs--1 mb-0">Ver tratamiento en PDF <i class="bi bi-chevron-right ms-2"></i></p>
                            </div>
                        </a>
                        <h6 class="fw-medium py-2 px-3 mb-0" style="background: #E9EFF4;">Selecciona tus servicios</h6>
                        <div class="d-flex justify-content-between align-items-center px-3 py-1 bg-labe-grayish">
                            <span class="fw-medium fs--2">Servicio</span>
                            <span class="fw-medium fs--2">Cantidad</span>
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
                                <p class="text-danger fw-normal fs--2 mb-0" id="content-precioBase">Precio normal <del class="fw-medium" id="precioBaseEnd"></del></p>
                                <h2 class="text-primary fw-medium mb-0" id="precioTotalEnd"></h2>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="btn btn-primary-veris w-100 mb-3"  id="btnComprar">Comprar</div>
                            <a href="javascript:history.go(-1)" class="btn w-100 mb-3">Ahora no</a>
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
    let esIncremento = null;
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    let codigoTratamiento = dataCita.datosTratamiento.codigoTratamiento;
    // llamada al dom
    
    document.addEventListener("DOMContentLoaded", async function () {
        await valorizacionServicios();
        console.log(dataCita.promocion)
        $('body').on('change','.input-group input', async function(){
            let detalle = JSON.parse($(this).attr("data-rel"));
            await actualizarValorizacionServicios(detalle, $(this).val());
            console.log(dataCita.promocion);
            drawNuevosValores();
            //await drawServicios();
        })

        // boton info
        $('#informacionModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget) // Button that triggered the modal
            let recipient = button.data('rel') // Extract info from data-* attributes
           
            let modal = $(this);
            modal.find('.modal-body').empty();
            modal.find('.modal-body').append(`<h1 class="modal-title fs-5 fw-medium text-center border-bottom mb-3 pb-2">${recipient.descripcionServicio}</h1>
                                                <p class="fs--1 fw-medium text-primary">Servicios incluidos en la compra</p>
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
            modal.find('.modal-body').append(`<h1 class="modal-title fs-5 fw-medium text-center border-bottom mb-3 pb-2">Informacion</h1>
                    <p class="fs--1 fw-medium text-primary">${recipient.detallePrestaciones[0].descripcionGrupoDetalle}</p>
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
            // capturar los valores de los inputs
            // console.log('entro a comprar');
            let inputs = $('.input-group input').toArray();
            let cantidadServicios = [];
            dataCita.preTransaccion = {
                "codigoPreTransaccion": dataCita.promocion.codigoPreTransaccion
            }
            let ruta = '/citas-datos-facturacion/' + '{{ $params }}';
            // console.log('ruta', ruta);  
            // window.location.href = "${ruta}";
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            window.location.href = ruta;
        })
        
        // boton cancelar redireccionar a la pagina de citas
        $('#btnCancelar').on('click', function() {
            window.location.href = "/citas";
        })
    });

    // llenar contenedor principal descuento
    function llenarContenedorPrincipalDescuento() {
        let contenedorPrincipalDescuento = $('#contenedorPrincipal-descuento');
        contenedorPrincipalDescuento.empty();
        if (dataCita.convenio.length > 0){
            contenedorPrincipalDescuento.append(`<p class="mb-0">Veris te regala un</p>
                                                <h4 class="text-white mb-0" id="content-descuento">% de descuento</h4>
                                                <p class="mb-0">por pagar en app</p>`);
        } else {
            contenedorPrincipalDescuento.append(`<p class="mb-0">Compra y gestiona </p>
                                                <p class="mb-0">tu tratamiento en app</p>`);
        }    
    }

    // Obtener la valorizacion de los servicios del tratamiento
    async function valorizacionServicios() {
        let args = {};
        let idTratamiento = codigoTratamiento;
        let canalOrigenDigital = _canalOrigen;
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/${idTratamiento}/valorizacion_servicio`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "codigoPreTransaccion": null,
            "canalOrigenDigital": canalOrigenDigital,
        });

        const data = await call(args);
        //console.log('dataservicio', data);

        if(data.code == 200){
            dataCita.promocion = data.data;
            return await drawServicios()            
        }
    }

    // funcion para manejar los eventos de los botones de los precios

    function sumarCantidad(index) {
        let cantidadMaxima = parseFloat($(`#cantidadServicio-${index}`).attr('max'));

        let valorPromocion = parseFloat($(`#valorPromocionHidden-${index}`).val());
        let valorNormal = parseFloat($(`#valorNormalHidden-${index}`).val());

        let cantidad = parseFloat($(`#listaServicios li:nth-child(${index + 1}) .input-group input`).val());
        cantidad++;

        if (cantidad > cantidadMaxima) {
            return;
        }

        esIncremento = true;
        $(`#listaServicios li:nth-child(${index + 1}) .input-group input`).val(cantidad).trigger('change');

        /*let precioTotal = cantidad * valorPromocion;
        let precioTotalLista = cantidad * valorNormal;
        let precioBase = $(`#precioBase-${index}`);
        let precioTotalList = $(`#precioTotalList-${index}`);
        precioBase.empty();
        precioBase.append(`$${precioTotalLista.toFixed(2)}`);
        precioTotalList.empty();
        precioTotalList.append(`$${precioTotal.toFixed(2)}`);

        let precioTotalEnd = $('#precioTotalEnd');
        let precioBaseEnd = $('#precioBaseEnd');

        let precioTotalEndValor = parseFloat(precioTotalEnd.text().replace('$', ''));
        let precioBaseEndValor = parseFloat(precioBaseEnd.text().replace('$', ''));

        precioTotalEndValor += valorPromocion;
        precioBaseEndValor += valorNormal;

        precioTotalEnd.empty();
        precioBaseEnd.empty();

        precioTotalEnd.append(`$${precioTotalEndValor.toFixed(2)}`);
        precioBaseEnd.append(`$${precioBaseEndValor.toFixed(2)}`);*/
    }


    function restarCantidad(index) {
        let valorPromocion = $(`#valorPromocionHidden-${index}`).val();
        let valorNormal = $(`#valorNormalHidden-${index}`).val();
        let precioBase = $(`#precioBase-${index}`);
        let precioTotalList = $(`#precioTotalList-${index}`);

        let cantidad = $(`#listaServicios li:nth-child(${index + 1}) .input-group input`).val();
        cantidad--;
        if (cantidad < 0) {
            cantidad = 0;
        }

        esIncremento = false;
        $(`#listaServicios li:nth-child(${index + 1}) .input-group input`).val(cantidad).trigger('change');

        /*let precioTotal = cantidad * valorPromocion;
        let precioTotalLista = cantidad * valorNormal;
        precioBase.empty();
        precioBase.append(`$${precioTotalLista.toFixed(2)}`);
        precioTotalList.empty();
        precioTotalList.append(`$${precioTotal.toFixed(2)}`);

        let precioTotalEnd = $('#precioTotalEnd');
        let precioBaseEnd = $('#precioBaseEnd');

        let precioTotalEndValor = precioTotalEnd.text().replace('$', '');
        let precioBaseEndValor = precioBaseEnd.text().replace('$', '');

        precioTotalEndValor = parseInt(precioTotalEndValor) - parseInt(valorPromocion);
        precioBaseEndValor = parseInt(precioBaseEndValor) - parseInt(valorNormal);

        precioTotalEnd.empty();
        precioBaseEnd.empty();

        precioTotalEnd.append(`$${precioTotalEndValor}`);

        precioBaseEnd.append(`$${precioBaseEndValor}`);*/
    }

    // actualizar la valorizacion de los servicios del tratamiento con un put

    async function actualizarValorizacionServicios(detalle, qty) {
        //console.log('-------------'+dataCita.promocion.codigoPreTransaccion)
        let args = {};
        //let canalOrigenDigital = 'APP_CMV';
        args["endpoint"] = api_url + `/digitalestest/v1/tratamientos/${codigoTratamiento}/actualizar_servicio`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "codigoPreTransaccion": dataCita.promocion.codigoPreTransaccion,
            "canalOrigenDigital": _canalOrigen,
            "esIncremento": esIncremento,
            "aplicaControlCantidad": detalle.aplicaControlCantidad,
            "cantidadModificada": parseInt(qty),
            "detalleAgrupacionPreTran": detalle.detalleAgrupacionPreTran
        });

        const data = await call(args);
        dataCita.promocion = data.data
        // console.log('dataservicio', data);
        return data;
    }

    async function drawServicios(){
        $('#box-detalle-promocion').removeClass('d-none');
        if(dataCita.promocion.serviciosIncluyeCompra.length == 0){
            $('#box-detalle-promocion').empty();
            let elem = `<div class="card-body">
                            <div class="text-center">
                                <div class="avatar avatar-lg mx-auto mb-3">
                                    <span class="avatar-initial rounded-circle bg-primary">
                                        <i class="fa-solid fa-info fs-2"></i>
                                    </span>
                                </div>
                                <h3 class="fs--28 line-height-36 fw-medium mb-2">Información</h3>
                                <p class="fs--16 line-height-20 text-veris mb-5">Esta promoción ya no está disponible</p>
                                <img src="{{ asset('assets/img/svg/promocionNoDisponible.svg') }}" class="img-fluid mt-3 mb-3 w-50" alt="">
                                <a href="/" class="btn btn-lg btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>`;
            $('#box-detalle-promocion').append(elem);
        }else{
            let contentDescuento = $('#content-descuento');
            contentDescuento.empty();
            contentDescuento.append(`${dataCita.promocion.porcentajeDescuentoPromocion}% de descuento`);

            let html = $('#listaServicios');
            html.empty();
            let precioTotal = 0;
            let elemento = '';

            dataCita.promocion.serviciosIncluyeCompra.forEach((resultados, index) => {
                elemento += `<li class="list-group-item d-flex justify-content-between align-items-center shadow-veris border-0 rounded-0">
                                <div class="w-auto">
                                    <p class="text-veris mb-0">${resultados.descripcionServicio}</p>
                                    <div class="d-flex align-items-center">
                                        <p class="text-primary fw-medium fs--2 mb-0" id="precioTotal">
                                            
                                            <del class="text-danger fw-normal" id="precioBase-${index}">$$${resultados.valorNormal}</del> 
                                            <span class="fw-medium" id="precioTotalList-${index}">
                                            $${resultados.valorPromocion}
                                            </span>
                                            <input type="hidden" id="valorPromocionHidden-${index}" value="${resultados.valorPromocion}">
                                            <input type="hidden" id="valorNormalHidden-${index}" value="${resultados.valorNormal}">
        
                                        </p>
                                        <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" data-bs-toggle="modal" data-bs-target="#informacionModal" data-rel='${JSON.stringify(resultados)}' ><i class="bi bi-info-circle"></i> </button> 
                                    </div>
                                </div>
                                <div class="input-group input-group-sm flex-nowrap w-25" data-quantity="data-quantity">
                                    <button class="btn btn-sm btn-minus px-2" data-type="minus" onclick="restarCantidad(${index})"
                                    >-</button>
                                    <input class="form-control text-center input-spin-none bg-transparent px-0" type="number" data-rel='${JSON.stringify(resultados)}' min="0" max=${resultados.cantidadMaximaPermitida}
                                    value="1" id="cantidadServicio-${index}"
                                     />
                                    <button class="btn btn-sm btn-plus px-2" data-type="plus" onclick="sumarCantidad(${index})"
                                    >+</button>
                                </div>
                            </li>`;
            });
            html.append(elemento);

            let serviciosNoIncluidos = $('#flush-collapseOne');
            serviciosNoIncluidos.empty();
            let elementoNoIncluido = '';

            dataCita.promocion.serviciosNoIncluyeCompra.forEach((resultados) => {
                //console.log(resultados.colorInformacion);
                elementoNoIncluido += `<div class="d-flex align-items-center justify-content-between">
                                            <div class="accordion-body" style="flex-grow: 1;">${resultados.descripcionServicio}</div>
                                            <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" ;"
                                                data-bs-toggle="modal" data-bs-target="#serviciosNoIncluidosModal" data-rel='${JSON.stringify(resultados)}'>
                                                <i class="bi bi-info-circle" style="color: ${resultados.colorInformacion};"
                                                ></i>
                                            </button>
                                        </div>`;
            });
            
            serviciosNoIncluidos.append(elementoNoIncluido);

            // eventos de los precios

            let precioBaseEnd = $('#precioBaseEnd');
            let precioTotalEnd = $('#precioTotalEnd');
            
            precioBaseEnd.empty();
            precioTotalEnd.empty();

            precioBaseEnd.append(`$${dataCita.promocion.valorNormal}`);
            precioTotalEnd.append(`$${dataCita.promocion.valorPromocion}`);
        }

        return;
    }

    function drawNuevosValores(){
        $('#precioBaseEnd').html(`$${dataCita.promocion.valorNormal.toFixed(2)}`);
        $('#precioTotalEnd').html(`$${dataCita.promocion.valorPromocion.toFixed(2)}`);
    }
</script>
@endpush