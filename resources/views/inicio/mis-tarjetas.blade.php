@extends('template.app-template-veris')
@section('title')
Mi Veris - Mis tarjetas
@endsection
@section('content')
@php
// $data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData')->numeroIdentificacion);
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal eliminar tarjeta -->
    <div class="modal fade" id="modalEliminarTarjeta" tabindex="-1" aria-labelledby="modalEliminarTarjetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="fs-24 line-height-28 my-3">Eliminar tarjeta</h1>
                    <p class="fs--1 line-height-16 mb-0" id="mensajeTarjeta"></p>
                    <input type="hidden" id="idTarjetaEliminar">
                    <div class="d-flex flex-column pb-3">
                        <button type="button" id="aceptarPDP" class="btn btn-lg btn-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3 btn-confirmar-eliminar-tarjeta">Eliminar</button>
                        <button type="button" class="btn btn-lg shadow-none text-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmacion eliminacion -->
    <div class="modal fade" id="modalConirmacionEliminarTarjeta" tabindex="-1" aria-labelledby="modalConirmacionEliminarTarjetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <p class="my-3"><i class="fa-solid fa-circle-check text-veris-ai fs-48"></i></p>
                    <h1 class="fs-24 line-height-28 my-3">Tarjeta eliminada</h1>
                    <div class="d-flex flex-column pb-3">
                        <button type="button" id="aceptarPDP" class="btn btn-lg btn-primary-veris fw-medium col fs--18 mt-3 m-0 px-4 py-3" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis tarjetas') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <form class="row g-3" id="listado-tarjetas">
                            {{-- <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="card1Wallet">
                                        <input name="cardWallet" class="form-check-input" type="radio" value="" id="card1Wallet">
                                        <span class="custom-option-header w-100">
                                            <div>
                                                <img src="{{ asset('assets/img/svg/amex.svg')}}" class="me-3" alt="amex">
                                                <span class="fs--2 mb-0">****3466</span>
                                            </div>
                                            <a href="#" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", async function () {
        await cargarListaTarjetas();

        $('body').on('click', '.btn-delete-card', async function(){
            $('#idTarjetaEliminar').val($(this).attr('codigoTarjetaSuscrita-rel'));
            let tarjeta = JSON.parse($(this).attr('data-rel'));
            console.log(tarjeta);
            //$('#mensajeTarjeta').html(`Estás seguro de que deseas eliminar la tarjeta de crédito
            $('#mensajeTarjeta').html(`Estás seguro de que deseas eliminar la tarjeta de crédito <b>${tarjeta.marca}</b> terminada en <b>${tarjeta.cuatroUltimosDigitos}</b>?`);
            var myModal = new bootstrap.Modal(document.getElementById('modalEliminarTarjeta'));
            myModal.show();
        })

        $('body').on('click', '.btn-confirmar-eliminar-tarjeta', async function(){
            await eliminarTarjeta()
        })

    });

    async function eliminarTarjeta(){
        let tarjeta = $('#idTarjetaEliminar').val();
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/tarjetas?canalOrigen=${_canalOrigen}&codigoTarjetaSuscrita=${tarjeta}`;
        args["method"] = "DELETE";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            $('#modalEliminarTarjeta').hide();
            $('.modal-backdrop').remove();
            $('.tarjeta-'+tarjeta).remove();
            $('#modalConirmacionEliminarTarjeta').modal('show')
            if($('#listado-tarjetas .item-tarjeta').length == 0){
                let elem = `<div class="col-12 text-center">
                    <h6 class="card-title text-veris fs-24 line-height-28 mb-3">No tienes tarjetas guardadas</h6>
                    <p>En esta sección podrás ver y eliminar tus tarjetas.</p>
                    <img src="{{ asset('assets/img/svg/no-credit-card.svg') }}" class="img-fluid mt-3" >
                </div>`;
                $('#listado-tarjetas').append(elem);  
                window.removeEventListener("beforeunload", beforeUnloadHandler);
                var myModal = new bootstrap.Modal(document.getElementById('noExisteTarjeta'));
                myModal.show();
                await cargarListaTarjetas(false);
            }
        }
    }

    async function cargarListaTarjetas(showLoader = true){
        $('#listado-tarjetas').empty();
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/tarjetas?canalOrigen=${_canalOrigen}&virusu={{ Session::get('userData')->numeroIdentificacion }}`;
        args["method"] = "GET";
        args["showLoader"] = showLoader;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            let elem = ``;
            let count = 0;
            if(data.data.length == 0){
                elem += `<div class="col-12 text-center">
                    <h6 class="card-title text-veris fs-24 line-height-28 mb-3">No tienes tarjetas guardadas</h6>
                    <p>En esta sección podrás ver y eliminar tus tarjetas.</p>
                    <img src="{{ asset('assets/img/svg/no-credit-card.svg') }}" class="img-fluid mt-3" >
                </div>`;
            }else{
                // $.each(data.data, function(key, value){
                for (const value of data.data) {
                    {{-- if(value.tipoBoton == "NUV"){ --}}
                        count++;
                        let disabledItem = "";
                        let elemDisabledItem = "";
                        if(value.tarjetaVencida){
                            disabledItem = "disabled";
                            elemDisabledItem = `<br><b class="fw-normal text-danger-veris">Tarjeta caducada.</b>`;
                        }
                        //let path_card = "{{ asset('assets/img/icons/payments') }}/"+value.marca.toLowerCase()+".png";
                        /*let path_card = "{{ asset('assets/img/veris/credit-card.svg') }}";
                        const existeImagen = await verificarImagen(value.nombre_foto);
                        if (existeImagen) {
                            path_card = value.nombre_foto;
                        }*/                     
                        elem += `<div class="col-12 col-md-6 item-tarjeta tarjeta-${value.codigoTarjetaSuscrita}">
                            <div class="form-check custom-option custom-option-basic border-secondary">
                                <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center px-3" for="card-${value.codigoTarjetaSuscrita}">
                                    <input ${disabledItem} name="cardWallet" class="form-check-input d-none" type="radio" value="" id="card-${value.codigoTarjetaSuscrita}" data-rel='${ JSON.stringify(value) }'>
                                    <span class="custom-option-header w-100">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <img src="${value.urlIconoMarca}" class="me-3 w-25" alt="" style="height: 40px;">
                                            <span class="fs--2 mb-0">****${value.cuatroUltimosDigitos} ${elemDisabledItem}</span>
                                        </div>
                                        <button type="button" codigoTarjetaSuscrita-rel="${value.codigoTarjetaSuscrita}" class="btn btn-sm text-danger shadow-none btn-delete-card" data-rel='${ JSON.stringify(value) }'><i class="bi bi-trash fs-4"></i></button>
                                    </span>
                                </label>
                            </div>
                        </div>`
                    {{-- } --}}
                };
            }
            if(count == 0){
                {{-- var myModal = new bootstrap.Modal(document.getElementById('noExisteTarjeta'));
                myModal.show(); --}}
            } 
            $('#listado-tarjetas').append(elem);          
        }else{
            alert(data.message);
        }
    }

</script>
@endpush