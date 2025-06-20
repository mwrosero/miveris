@extends('template.app-template-veris')
@section('title')
Mi Veris - Información de Convenio
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
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Agregar') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
               <div class="row g-2 justify-content-center">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label fw-medium fs--1">{{ __('Nombre') }}</label>
                        <input type="text" disabled readonly class="form-control text-capitalize fs--1 p-3" name="nombre" id="nombre" required />
                        <div class="invalid-feedback">
                            Looks good!
                        </div>
                    </div> 
                    <div class="col-md-12">
                        <label for="numeroIdentificacion" class="form-label fw-medium fs--1">{{ __('Número de identificación') }}</label>
                        <input type="text" disabled readonly class="form-control text-capitalize fs--1 p-3" name="numeroIdentificacion" id="numeroIdentificacion" required />
                        <div class="invalid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="aseguradora" class="form-label fw-medium fs--1">{{ __('Aseguradora') }}</label>
                        <input type="text" disabled readonly class="form-control text-capitalize fs--1 p-3" name="aseguradora" id="aseguradora" required />
                        <div class="invalid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="seguroMedicoPrivado" class="form-label fw-medium fs--1">{{ __('Seguro médico privado') }}*</label>
                        <input type="text" disabled readonly class="form-control text-capitalize fs--1 p-3" name="seguroMedicoPrivado" id="seguroMedicoPrivado" required />
                        <div class="invalid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-12 mt--32">
                        <button class="btn btn-primary-veris rounded-3 fs--18 line-height-24 w-100 px-4 py-3 text-white" id="btnGuardar">Guardar</button>
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

    document.addEventListener("DOMContentLoaded", async function () {

        $('#nombre').val(`${dataCita.convenio.nombreCompletoAfiliado.toLowerCase()}`);
        $('#numeroIdentificacion').val(`${dataCita.convenio.numeroIdentificacionAfiliado}`);
        $('#aseguradora').val(`${dataCita.infoAdicional.nombreCliente.toLowerCase()}`);
        $('#seguroMedicoPrivado').val(`${dataCita.convenio.nombreConvenio.toLowerCase()}`);
        $('#seguroMedicoPrivado').attr('title',`${dataCita.convenio.nombreConvenio}`);

        $('body').on('click', '#btnGuardar', async function(){
            await sincronizarConvenio();            
        })

    });

    async function sincronizarConvenio() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/sincronizarConvenioCliente?canalOrigen=${_canalOrigen}&idCliente=${dataCita.infoAdicional.idCliente}&numeroPaciente=${dataCita.usuario.numeroPaciente}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            metadataSincronizacion: dataCita.convenio.metadataSincronizacion
        });

        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            const existe = dataCita.conveniosSincronizados.some(item => item.secuenciaAfiliado === data.data.secuenciaAfiliado );
            console.log(existe)
            if(!existe){
                location.href = '/confirmacion-convenio-agregado/{{ $params }}';
            }else{
                $('.title-mensaje-info').html(`Ya tienes agregado este seguro`)
                $('#mensaje_400_validacion').html(`El seguro médico privado que estás intentando agregar ya está sincronizado.`);
                var myModal = new bootstrap.Modal(document.getElementById('modalErrorConvenio'));
                myModal.show();
                return;
            }
        }else{
            $('.title-mensaje-info').html(`Información importante`)
            $('#mensaje_400_validacion').html(data.message);
            var myModal = new bootstrap.Modal(document.getElementById('modalErrorConvenio'));
            myModal.show();
            return;
        }
    }
</script>
@endpush