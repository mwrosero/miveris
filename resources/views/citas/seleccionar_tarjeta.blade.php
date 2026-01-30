@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Selecciona tu tarjeta
@endsection
@section('content')
@php
// $data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData')->numeroIdentificacion);
@endphp
@include('components.dataBrowser')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal noExisteTarjeta-->
    <div class="modal fade" id="noExisteTarjeta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noExisteTarjetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <div class="avatar avatar-lg mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-info fs-2"></i>
                            </span>
                        </div>
                        <h1 class="modal-title fs-5 mb-3" id="confirmarPagoLabel">No existen tarjetas guardadas</h1>
                        <p class="fs--1 mb-3 mx-3" style="line-height: 16px;">Para realizar el pago debes ingresar una tarjeta</p>
                    </div>
                    <a href="/citas-informacion-pago/{{ $params }}" class="btn btn-lg btn-primary-veris w-100 m-0 px-4 py-3">Ingresar tarjeta</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar tarjeta -->
    <div class="modal fade" id="modalCvc" tabindex="-1" aria-labelledby="modalCvcLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Ingrese el código CVV</h1>
                    <input type="text" class="form-control fs--1 p-3" name="cvcTarjeta" id="cvcTarjeta" placeholder="Código de seguridad (CVV)" required />
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center mt-3">
                    <div class="btn btn-lg btn-outline-primary-veris fs--18 line-height-24 py-3 w-100 m-0 disabled" id="btn-pagar-cvv">Pagar</div>
                </div>
            </div>
        </div>
    </div>

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
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Selecciona tu tarjeta') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
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
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="btn-master w-100 mx-auto" id="btn-pagar" type="button">
                                    <div class="btn disabled text-white shadow-none">{{ __('Pagar') }}</div>
                                    |
                                    <p class="btn text-white mb-0 shadow-none cursor-inherit" id="total"></p>
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
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    document.addEventListener("DOMContentLoaded", async function () {
        if(dataCita.reserva){
            if (dataCita.reserva.aplicaProntoPago == "S") {
                window.addEventListener("beforeunload", beforeUnloadHandler);
            }
        }
        $('#total').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);
        await cargarListaTarjetas();

        $('body').on('change', 'input[name="cardWallet"]', function() {
            $('#btn-pagar div').removeClass('disabled');
            let dataCard = JSON.parse($(this).attr('data-rel'))
            dataCita.tarjeta = dataCard;
        });
        
        $('body').on('click', '#btn-pagar', async function(){
            $('#cvcTarjeta').val("");
            $('#btn-pagar-cvv').addClass('disabled');
            $('#modalCvc').modal('show');
            //await pagarCita();
        })

        $('body').on('click', '#btn-pagar-cvv', async function(){
            $('#modalCvc').modal('hide');
            await pagarCita();
        })

        $('body').on('click', '.btn-delete-card', async function(){
            $('#idTarjetaEliminar').val($(this).attr('codigoTarjetaSuscrita-rel'));
            var myModal = new bootstrap.Modal(document.getElementById('modalEliminarTarjeta'));
            myModal.show();
        })

        $('body').on('click', '.btn-confirmar-eliminar-tarjeta', async function(){
            await eliminarTarjeta()
        })

        const cvcInput = document.getElementById('cvcTarjeta');

        cvcInput.addEventListener('input', (e) => {
            // Eliminamos cualquier caracter que no sea número
            let value = e.target.value.replace(/\D/g, '');
            
            // Limitamos a 4 dígitos manualmente por seguridad
            if (value.length > 4) {
                value = value.slice(0, 4);
            }
    
            // Actualizamos el valor del input
            e.target.value = value;
    
            // Lógica del evento: 3 o más dígitos
            if (value.length >= 3) {
                $('#btn-pagar-cvv').removeClass('disabled');
            }else{
                $('#btn-pagar-cvv').addClass('disabled');
            }
        });

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

    async function pagarCita(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/registrar_pago_nuvei?canalOrigen=${_canalOrigen}&idPreTransaccion=${dataCita.preTransaccion.codigoPreTransaccion}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "cvcTarjeta": btoa(getInput('cvcTarjeta')),
            "browser_info": getClientBrowserInfo(serverData),
            "tipoIdentificacion": parseInt(dataCita.facturacion.datosFactura.codigoTipoIdentificacion),
            "numeroIdentificacion": dataCita.facturacion.datosFactura.codigoUsuario,
            "codigoTransaccion": dataCita.transaccionVirtual.codigoTransaccion,
            "canalOrigenDigital": _canalOrigen,
            "tokenNuvei": dataCita.tarjeta.tokenNuvei
        });
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            console.log(data.data);
            window.removeEventListener("beforeunload", beforeUnloadHandler);
            if(data.data.estado.toUpperCase() == "APPROVED"){
                dataCita.registroPago = data.data;
                guardarData();
                let ruta = `/cita-agendada/{{ $params }}`;
                window.location.href = ruta;
            }else if(data.data.estado.toUpperCase() == "PENDING"){
                dataCita.registroPago = data.data;
                guardarData();
                let ruta = `/citas-confirmar-pago/{{ $params }}`;
                window.location.href = ruta;
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
                    No tiene tarjetas guardadas
                </div>`;
            }else{
                // $.each(data.data, function(key, value){
                for (const value of data.data) {
                    if(value.tipoBoton == "NUV"){
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
                        elem += `<div class="col-12 item-tarjeta tarjeta-${value.codigoTarjetaSuscrita}">
                            <div class="form-check custom-option custom-option-basic border-primary">
                                <label class="form-check-label custom-option-content d-flex justify-content-between align-items-center" for="card-${value.codigoTarjetaSuscrita}">
                                    <input ${disabledItem} name="cardWallet" class="form-check-input" type="radio" value="" id="card-${value.codigoTarjetaSuscrita}" data-rel='${ JSON.stringify(value) }'>
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
                    }
                };
            }
            if(count == 0){
                var myModal = new bootstrap.Modal(document.getElementById('noExisteTarjeta'));
                myModal.show();
            } 
            $('#listado-tarjetas').append(elem);          
        }else{
            alert(data.message);
        }
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }

</script>
<style>
#cvcTarjeta:placeholder-shown {
    border: 1px solid #E7E9EC !important;
    background-color: #E7E9EC !important;
    border: 0px !important;
}

/* Estilos para input-group-text cuando el input asociado tiene foco */
.input-group input:focus+.input-group-text {
    border: 1px solid #3394DD;
    background: #fff;
}

/* Estilos para input-group-text cuando el input tiene un valor */
.input-group input:not(:placeholder-shown)+.input-group-text {
    border: 1px solid #3D4E66;
    background: #fff;
}
</style>
@endpush