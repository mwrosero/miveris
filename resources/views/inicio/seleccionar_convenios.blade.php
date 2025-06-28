@extends('template.app-template-veris')
@section('title')
Mi Veris - Elegir aseguradora
@endsection
@section('content')
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>

<!-- Modal -->
<div class="modal fade" id="modalErrorConvenio" tabindex="-1" aria-labelledby="modalErrorConvenioLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs--20 line-height-24 my-3 title-mensaje-info">Veris</h1>
                <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_400_validacion"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <div class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</div>
                {{-- <button data-bs-dismiss="modal" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</button> --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal Convenios -->
<div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <form class="modal-content rounded-4">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pb-2">
                <h5 class="fs--20 line-height-24 mt-3 mb--20 text-center">{{ __('Elige el seguro:') }}</h5>
                <h6 class="text-center fs--16 line-height-20 mb-2 text-center">{{ __('Elige el seguro que quieres agregar.') }}:</h6>
                <div class="row gx-2 justify-content-between align-items-center">
                    <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaConvenios">
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn w-100 fw-medium fs--16 waves-effect line-height-20 m-0 p-3" style="color: #0071CE;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
</div>

<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal eliminar tarjeta -->
    <div class="modal fade" id="modalEliminarConvenio" tabindex="-1" aria-labelledby="modalEliminarConvenioLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Eliminar convenio</h1>
                    <p class="fs--1 fw-normal text-veris" id="mensajeError">¿Estás seguro(a) de eliminar este convenio?</p>
                    <input type="hidden" id="idTarjetaEliminar">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</div>
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center btn-confirmar-eliminar-convenio">Eliminar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Elige la aseguradora') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <div class="row g-3" id="listado-clientes">
                            {{-- <div class="col-12">
                                <div class="form-check custom-option custom-option-basic shadow-sm d-flex justify-content-between align-items-center p-3">
                                    <img src="{{ asset('assets/img/svg/amex.svg')}}" class="me-3" alt="amex">
                                    <div>
                                        <p class="text-veris-ai fs--16 line-height-20 mb-1 fw-medium">BMI</p>
                                        <span class="fs--1 line-height- mb-0">BMI Igualas médicas-Banco PichBMI Igualas médicas-Banco PichBMI Igualas médicas-Banco Pich</span>
                                    </div>
                                    <div class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></div>
                                </div>
                            </div> --}}
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
    let idPaciente = '{{ Session::get('userData')->numeroPaciente }}';
    let local = localStorage.getItem('persona-{{ $params }}');
    let dataCita = JSON.parse(local);
    let convenioElegido;
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerClientes();

        $('body').on('click', '.convenio-item', async function(){
            let convenio = JSON.parse($(this).attr('data-rel'));
            if(convenio.aplicaSyncWs == "N"){
                $('.title-mensaje-info').html(`Información importante`)
                $('#mensaje_400_validacion').html(convenio.mensajeSync);
                var myModal = new bootstrap.Modal(document.getElementById('modalErrorConvenio'));
                myModal.show();
                return;
            }
            convenioElegido = convenio
            await buscarConvenio(convenio);
        })

        $('body').on('click', '.convenio-item-modal', async function(){
            let convenio = JSON.parse($(this).attr('data-rel'));
            dataCita.convenio = convenio;
            dataCita.infoAdicional = convenioElegido;
            localStorage.setItem('persona-{{ $params }}', JSON.stringify(dataCita));
            location.href = '/info-convenio/{{ $params }}';
        })

    });

    async function buscarConvenio(convenio) {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/consultaAfiliadoWs?canalOrigen=${_canalOrigen}&idCliente=${convenio.idCliente}&numeroIdentificacion=${dataCita.usuario.numeroIdentificacion}&codigoTipoIdentificacion=${dataCita.usuario.tipoIdentificacion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["dismissAlert"] = true;

        const data = await call(args);
        console.log(data);
        if(data.code == 200 ){
            if(data.data.length == 1){
                dataCita.convenio = data.data[0];
                dataCita.infoAdicional = convenioElegido;
                localStorage.setItem('persona-{{ $params }}', JSON.stringify(dataCita));
                location.href = '/info-convenio/{{ $params }}';
            }else{
                await drawConvenios(data.data);
            }
        }else{
            $('.title-mensaje-info').html(`Lo sentimos`)
            $('#mensaje_400_validacion').html(data.message);
            var myModal = new bootstrap.Modal(document.getElementById('modalErrorConvenio'));
            myModal.show();
        }
        return;
    }

    async function drawConvenios(convenios){
        let elem = ``;
        $.each(convenios, function(key, value){
            elem += `<div data-rel='${JSON.stringify(value)}' class="convenio-item-modal mb-2 custom-option">
                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${key}" value="">
                        <label for="listGroupCheckableRadios${key}" class="text-primary-veris fs--1 line-height-16 cursor-pointer text-capitalize">
                            ${value.nombreConvenio.toLowerCase()}
                        </label> 
                    </div>
                </div>`;
        })
        $('#listaConvenios').html(elem);
        $('#convenioModal').modal('show');
    }

    async function obtenerClientes(paciente = null) {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/lista/clientes?canalOrigen=${_canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data);
        let elem = ``
        if (data.code == 200) {
            if(data.data.length > 0){
                $.each(data.data, function(key, value){
                    elem += `<div class="col-6">
                        <div data-rel='${JSON.stringify(value)}' class="waves-effect p-1 convenio-item custom-option custom-option-basic shadow-sm d-flex justify-content-between align-items-center wa p-2">
                            <img src="${value.urlIcono}" class="mx-auto" height="56px" alt="">
                        </div>
                    </div>`;
                })
            }else{
                elem += `<div class="col-12 p-1 text-center">
                    <h2 class="fs-24 line-height-28">¿Tienes un seguro médico privado?</h2>
                    <p class="fs-16 line-height-20">Añade tu seguro médico privado.</p>
                    <img src="{{asset('assets/img/svg/empty-no-convenios.svg')}}" class="w-75 img-fluid" alt="">
                </div>`;
            }
            $('#listado-clientes').html(elem)
        }
        return data;
    }
</script>
@endpush