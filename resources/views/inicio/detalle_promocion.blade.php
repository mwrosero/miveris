@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="plaPreventivoModal" tabindex="-1" aria-labelledby="plaPreventivoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>¿Quién va a utilizar el plan preventivo?</h6>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <!-- Opcion 1 -->
                        <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaGrupoFamiliar">
                            {{-- <a href="#" class="list-group-item list-group-item-action border rounded-3 py-2" aria-current="true">
                                <p class="fs--2 mb-0">Fernanda Alarcon Tapia</p>
                            </a> --}}
                        </div>

                        <!-- opcion 2 -->
                        {{-- <div class="list-group list-group-checkable d-grid gap-2 border-0 d-none">
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios1" value="" checked>
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios1">
                                Fernanda Alarcon Tapia
                            </label>
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios2">
                                Julia Tapia Lopez
                            </label>
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios3" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios3">
                                Gabriela Alarcon Tapia
                            </label>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Detalle') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="{{ asset('assets/img/veris/veris-v.svg') }}" class="img-fluid mb-3" alt="{{ __('veris') }}">
                            <h4 class="">{{ __('Plan preventivo') }}</h4>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <p class="fs--1 fw-normal pe-2" id="nombrePaquete"></p>
                            <div class="col-auto text-end lh-1">
                                <h5 class="text-primary-veris mb-0" id="valorTotalPaquete"></h5>
                                <p class="text-veris fs--1 fw-semibold mb-0 d-none" id="porcentajeDescuento"></p>
                                <p class="fs--1 mb-0 d-none" style="color: #6E7A8C !important;"><del id="valorAnteriorPaquete"></del></p>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="fs--2" id="descripcionPaquete"></p>
                                <h6 class="text-start">DETALLES DE PAQUETE</h6>
                                <ul class="fs--2" id="detallePaquete">
                                    {{-- <li class="mb-2"></li> --}}
                                </ul>
                            </div>
                        </div>

                        <!-- Button trigger modal -->
                        <div class="text-center">
                            <button type="button" class="btn btn-primary-veris w-100 py-3" data-bs-toggle="modal" data-bs-target="#plaPreventivoModal">
                                Continuar
                            </button>
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
        $('#nombrePaquete').html(dataCita.paquete.nombrePaquete);
        $('#descripcionPaquete').html(dataCita.paquete.descripcionPaquete);
        $('#valorTotalPaquete').html(`$${dataCita.paquete.valorTotalPaquete.toFixed(2)}`);
        if(dataCita.paquete.porcentajeDescuento > 0){
            $('#porcentajeDescuento').html(`-${dataCita.paquete.porcentajeDescuento} OFF`).removeClass('d-none');
            $('#valorAnteriorPaquete').html(`$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}`);
            $('#valorAnteriorPaquete').parent().removeClass('d-none');
        }
        consultarGrupoFamiliar();
        await obtenerDetallePaquetePromocional();

        $('body').on('click', '.btn-asignar', function(){
            let url = '/citas-datos-facturacion/';
            dataCita.paciente = JSON.parse($(this).attr('data-rel'));
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            location.href = url + "{{ $params }}";
        })
    })

    async function obtenerDetallePaquetePromocional(){
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=${dataCita.paquete.codigoEmpresaPaquete}&codigoPaquete=${dataCita.paquete.codigoPaquete}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            $('#detallePaquete').empty();
            dataCita.detallePaquete = data.data;
            let elem = ``;
            $.each(data.data.detallePromocion, function(key, value){
                $.each(value.detalles, function(k,v){
                    elem += `<li class="mb-2" title="${value.nombreServicio}">${v.nombreComercial}</li>`;
                })
            })
            $('#detallePaquete').append(elem);
        }else{
            alert(data.message);
        }
    }

    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            $('#listaGrupoFamiliar').empty();
            let elem = ``;
            $.each(data.data, function(key,value){
                elem += `<div data-rel='${ JSON.stringify(value) }' class="list-group-item list-group-item-action border rounded-3 py-2 btn-asignar" aria-current="true">
                    <p class="fs--2 mb-0">${value.primerNombre} ${value.primerApellido} ${value.segundoApellido}</p>
                </div>`;
            })
            $('#listaGrupoFamiliar').append(elem);
        }
        return data;
    }
</script>
@endpush