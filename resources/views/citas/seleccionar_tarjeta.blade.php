@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Selecciona tu tarjeta
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal noExisteTarjeta-->
    <div class="modal fade" id="noExisteTarjeta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noExisteTarjetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body px-3 py-4">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-info fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">No existen tarjetas guardadas</h1>
                        <p class="fs--1 mb-3 mx-3" style="line-height: 16px;">Para realizar el pago debes ingresar una tarjeta</p>
                    </div>
                    <a href="{{route('citas.citaInformacionPago')}}" class="btn btn-lg btn-primary-veris w-100 mb-2">Ingresar tarjeta</a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Selecciona tu tarjeta') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <form class="row g-3" id="listado-tarjetas">
                            {{-- <div class="col-12">
                                <div class="form-check custom-option custom-option-basic border-primary">
                                    <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="customRadioTemp1">
                                        <input name="customRadioTemp" class="form-check-input" type="radio" value="" id="customRadioTemp1">
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
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="btn-master w-100 mx-auto">
                                    <a href="{{route('citas.agendada')}}" class="btn disabled text-white shadow-none">{{ __('Pagar') }}</a>
                                    |
                                    <p class="btn text-white mb-0 shadow-none cursor-inherit" id="total">$134.00</p>
                                </div>
                            </div>
                        </div>
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
    });

    async function cargarListaTarjetas(){
        $('#listado-tarjetas').empty();
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/facturacion/tarjetas?canalOrigen=${_canalOrigen}&virusu={{ Session::get('userData')->numeroIdentificacion }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            let elem = ``;
            if(data.data.length == 0){
                elem += `<div class="col-12 text-center">
                    No tiene tarjetas guardadas
                </div>`;
            }else{
                $.each(data.data, function(key, value){
                    let disabledItem = "";
                    let elemDisabledItem = "";
                    if(value.tarjetaVencida){
                        disabledItem = "disabled";
                        elemDisabledItem = `<br><b class="fw-normal text-danger-veris">Tarjeta vencida.</b>`;
                    }
                    elem += `<div class="col-12">
                        <div class="form-check custom-option custom-option-basic border-primary">
                            <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="card-${value.codigoTarjetaSuscrita}">
                                <input ${disabledItem} name="customRadioTemp" class="form-check-input" type="radio" value="" id="card-${value.codigoTarjetaSuscrita}">
                                <span class="custom-option-header w-100">
                                    <div>
                                        <img src="${value.urlIconoMarca}" class="me-3" alt="amex">
                                        <span class="fs--2 mb-0">****${value.cuatroUltimosDigitos} ${elemDisabledItem}</span>
                                    </div>
                                    <a href="#" codigoTarjetaSuscrita-rel="${value.codigoTarjetaSuscrita}" class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></a>
                                </span>
                            </label>
                        </div>
                    </div>`
                });
            } 
            $('#listado-tarjetas').append(elem);          
        }else{
            alert(data.message);
        }
    }

</script>
@endpush