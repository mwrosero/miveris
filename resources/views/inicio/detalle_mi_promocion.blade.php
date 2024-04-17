@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Promoción') }}</h5>
    </div>
    <section class="p-0 mb-0" style="overflow-x: hidden;">
        {{-- <div class="container"> --}}
            <div class="row g-3 d-flex justify-content-start align-items-start mx-0">
                <div class="col-12 col-md-4 feature-img-promocion" style="height: 200px;">
                </div>
                <div class="col-12 offset-md-0 col-md-6 mt-3 pb-2 mb-1 px-3">
                    <h6 class="title-promocion text-primary-veris fs--18 line-height-24 fw-medium mb-1 h-auto"></h6>
                    <p class="fw-medium fs--2 line-height-16 mb-1 text-veris nombrePaciente"></p>
                    <p class="fw-medium fs--2 line-height-16 mb-1 fechaValidez"></p>
                </div>
            </div>
            <div class="row g-3 box-llamada-all d-none mx-0">
                <div class="col-12 offset-md-3 col-md-6 text-center mt-3 px-3">
                    <div class="box-llamada d-flex justify-content-center align-items-center fs--1 line-height-16">
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </section>
    <section class="p-0 px-md-3">
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue d-none" id="tituloPromocionPendiente">{{ __('Pendientes') }}</h5>
        <div class="mb-4 contenedorPromocionPendienteSection">
            <div class="d-flex justify-content-center mb-3 px-3">
                <div class="col-12 col-md-10 col-lg-9">
                    <div class="row g-3" id="contenedorPromocionPendiente">
                    </div>
                </div>
            </div>
        </div>
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue d-none" id="tituloPromocionRealizado">{{ __('Realizados') }}</h5>
        <div class="mb-4 contenedorPromocionRealizadoSection">
            <div class="d-flex justify-content-center mb-3 px-3">
                <div class="col-12 col-md-10 col-lg-9">
                    <div class="row g-3" id="contenedorPromocionRealizado">
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
    if(dataCita.paquete.esCaducada){
        $('#tituloPromocionPendiente').html('Caducado');
    }
    document.addEventListener("DOMContentLoaded", async function () {

        $('.feature-img-promocion').css('background', 'url("'+dataCita.paquete.urlImagen+'") no-repeat center');
        $('.title-promocion').html(capitalizarCadaPalabra(dataCita.paquete.nombrePaquete));
        $('.nombrePaciente').html(capitalizarCadaPalabra(dataCita.paquete.nombrePaciente));
        $('.fechaValidez').html(validarCaducidad())
        //consultarGrupoFamiliar();
        await obtenerDetallePaquetePromocional();

        $('body').on('click','.btn-detalle', function(){
            let url = '/detalle/item/';
            let data = {
                "detalle": JSON.parse($(this).attr("data-rel")),
                "promocion": JSON.parse($(this).attr("promocion-rel")),
                "nombrePaciente": dataCita.paquete.nombrePaciente
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
            location.href = url + "{{ $tokenCita }}";
        })
    })

    function validarCaducidad(){
        let elem = ``;
        if(dataCita.paquete.esCaducada){
            elem += `<span class="text-danger">${dataCita.paquete.fechaCaducidad} | Caducado</span>`;
        }else{
            elem += `<span class="text-primary-veris">${dataCita.paquete.fechaCaducidad}</span>`;
        }
        return elem;
    }

    async function obtenerDetallePaquetePromocional(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=1&secuenciaPaquetePaciente=${dataCita.paquete.secuenciaPaquetePaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if (data.code == 200){
            if(data.data.pendientes.length > 0){
                $('.box-llamada').html(`<i class="fa-solid fa-circle-info text-primary-veris line-height-16 fs--16 me-2"></i><div>Para agendar tus servicios llámanos al <span>${data.data.numeroContactCenter}</span>.</div><a href="tel:+593${data.data.numeroContactCenter}" class="btn btn-sm btn-primary-veris fw-medium fs--16 line-height-16 px-3 py-2 shadow-none ms-2 d-block d-md-none" style="border-radius:8px;">Llamar</a>`);
                $('.box-llamada-all').removeClass('d-none');
                let elemPendiente = ``;
                $('#tituloPromocionPendiente').removeClass('d-none');
                $.each(data.data.pendientes, function(key, detalles){
                    elemPendiente += `<div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body p--2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                </div>
                                <p class="fs--1">Realizadas: <span style="color: #00C853">${detalles.cantidad}</span></p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="avatar-sm me-2">
                                        <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                    </div>
                                    <div>
                                        <div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-detalle" promocion-rel='${JSON.stringify(detalles)}' data-rel='${JSON.stringify(detalles.detalles)}'>Ver detalle</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>`; 
                })
                $('#contenedorPromocionPendiente').html(elemPendiente);
            }else{
                $('.contenedorPromocionPendienteSection').remove();
            }
            if(data.data.realizados.length > 0){
                let elemRealizado = ``;
                $('#tituloPromocionRealizado').removeClass('d-none');
                $.each(data.data.realizados, function(key, detalles){
                    elemRealizado += `<div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body p--2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                    <div class="ms-auto fs--2"><i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">Atendida</span></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="avatar-sm me-2">
                                        <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                    </div>
                                    <div>
                                        <div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-detalle" promocion-rel='${JSON.stringify(detalles)}' data-rel='${JSON.stringify(detalles.detalles)}'>Ver detalle</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>`; 
                })
                $('#contenedorPromocionRealizado').html(elemRealizado);
            }
        }else{
            alert(data.message);
        }
    }
</script>
@endpush