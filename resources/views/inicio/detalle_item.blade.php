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
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="../../assets/img/svg/atras.svg" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Detalle') }}</h5>
    </div>
    <section class="p-0 px-md-3"></section>

    <section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-3">
                    <div class="row g-3 justify-content-center" id="listado-detalles"></div>
                    {{-- <div class="card h-100">
                        <div class="card-body p--2 d-flex justify-content-between align-items-center">
                            <div class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line m-0">Urea</div>
                            <div class="label-status-detalle fs--2 line-height-16 m-0">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                Disponible
                            </div>
                        </div>
                    </div> --}}
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
        let showResultados = false;
        let elem = ``;
        $.each(dataCita.detalle, function(key, value){
            let estado = ``;
            if(value.estado == "Atendida"){
                showResultados = true;
                elem += `<div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body p--2">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1">${capitalizarElemento(value.nombreDetalle)}</h6>
                                <span class="text-warning-veris fs--2 line-height-16 mb-1 text-end" style="min-width: 90px;">
                                    <i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">Atendida</span>
                                </span>
                            </div>
                            <h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.nombreSucursal)}</h6>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${value.detalleReserva.horaReserva}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(value.detalleReserva.nombreMedicoReserva)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(dataCita.nombrePaciente)}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-sm me-2">
                                    <img src="${quitarComillas(dataCita.promocion.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            }else{
                if(value.estado == "Disponible"){
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2">
                            <i class="fa-regular fa-calendar-check me-2"></i>
                            Disponible
                        </div>`;
                }else if(value.estado == "Caducado"){
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2">
                            <img src="{{asset('assets/img/svg/fa-diamond-exclamation.svg')}}" />
                            <span style="color: #D84315;">Caducado</span>
                        </div>`;
                }else{
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2">
                            <i class="fa-solid fa-check me-2 text-success"></i>
                            <span class="text-success">Atendida</span>
                        </div>`;
                }
                elem += `<div class="col-12 mt-3">
                            <div class="card h-100" style="box-shadow: 0px 4px 8px 0px #0000001A;">
                                <div class="card-body p--2 d-flex justify-content-between align-items-center">
                                    <div class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 m-0">
                                        ${value.nombreDetalle}
                                    </div>
                                    ${estado}
                                </div>
                            </div>
                        </div>`;
            }
        })
        

        if((dataCita.promocion.tipoServicio == "LABORATORIO" || dataCita.promocion.tipoServicio == "IMAGENES" || dataCita.promocion.tipoServicio == "PROCEDIMIENTOS") && showResultados){
            let urlResultado = "/resultados-laboratorio";
            if(dataCita.promocion.tipoServicio != "LABORATORIO"){
                urlResultado = "/resultados-imagenes-procedimientos";
            }
            elem += `<div class="col-12 mt-3">
                        <a href="${urlResultado}" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5 waves-effect waves-light order-last">Ver resultados</a>
                    </div>`;
        }

        $('#listado-detalles').html(elem);
    })

</script>
<style>
    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal) .layout-page:before{
        display: none;
    }
</style>
@endpush