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
                    <h1 class="modal-title fs--20 line-height-24 my-3">Eliminar tarjeta</h1>
                    <p class="fs--1 fw-normal text-veris" id="mensajeError">¿Estás seguro(a) de eliminar esta tarjeta?</p>
                    <input type="hidden" id="idTarjetaEliminar">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</div>
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center btn-confirmar-eliminar-tarjeta">Eliminar</div>
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
            if($('#listado-tarjetas .item-tarjeta').length == 0){
                let elem = `<div class="col-12 text-center">
                    No tiene tarjetas guardadas
                </div>`;
                $('#listado-tarjetas').append(elem);  
                window.removeEventListener("beforeunload", beforeUnloadHandler);
                var myModal = new bootstrap.Modal(document.getElementById('noExisteTarjeta'));
                myModal.show();
            }
        }
    }

    async function cargarListaTarjetas(){
        $('#listado-tarjetas').empty();
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/tarjetas?canalOrigen=${_canalOrigen}&virusu={{ Session::get('userData')->numeroIdentificacion }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            let elem = ``;
            let count = 0;
            if(data.data.length == 0){
                elem += `<div class="col-12 text-center">
                    <h6 class="card-title text-veris fs-24 line-height-28 mb-3">No tiene tarjetas guardadas</h6>
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
                            elemDisabledItem = `<br><b class="fw-normal text-danger-veris">Tarjeta vencida.</b>`;
                        }
                        let path_card = "{{ asset('assets/img/icons/payments') }}/"+value.marca.toLowerCase()+".png";
                        /*let path_card = "{{ asset('assets/img/veris/credit-card.svg') }}";
                        const existeImagen = await verificarImagen(value.nombre_foto);
                        if (existeImagen) {
                            path_card = value.nombre_foto;
                        }*/                     
                        elem += `<div class="col-6 item-tarjeta tarjeta-${value.codigoTarjetaSuscrita}">
                            <div class="form-check custom-option custom-option-basic border-secondary">
                                <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center px-3" for="card-${value.codigoTarjetaSuscrita}">
                                    <input ${disabledItem} name="cardWallet" class="form-check-input d-none" type="radio" value="" id="card-${value.codigoTarjetaSuscrita}" data-rel='${ JSON.stringify(value) }'>
                                    <span class="custom-option-header w-100">
                                        <div>
                                            <img src="${path_card}" class="me-3 w-25" alt="" >
                                            <span class="fs--2 mb-0">****${value.cuatroUltimosDigitos} ${elemDisabledItem}</span>
                                        </div>
                                        <button type="button" codigoTarjetaSuscrita-rel="${value.codigoTarjetaSuscrita}" class="btn btn-sm text-danger shadow-none btn-delete-card"><i class="bi bi-trash fs-4"></i></button>
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