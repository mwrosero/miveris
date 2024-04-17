@extends('template.app-template-veris')
@section('title')
Mi Veris - Cita agendada
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-3 mb-3">
        <div class="row g-0 justify-content-center">
            <div class="col-md-6">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center p-0">
                        <!-- cita presencial online -->
                        <div class="content-presencial d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Cita agendada</h3>
                            <p class="fs--16 line-height-20 mb-5">Tu cita se agendó exitosamente. <br> ¡Nos vemos pronto!</p>
                            <img src="{{ asset('assets/img/svg/doctora_2.svg') }}" alt="cita agendada">
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- cita agendada online -->
                        <div class="content-online d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Cita agendada</h3>
                            <p class="fs--16 line-height-20 mb-5">Recuerda conectarte <b>10 minutos antes de la cita.</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Paquete comprado -->
                        <div class="content-paquete d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="Promoción comprada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Promoción comprada</h3>
                            <p style="color: #0A2240;" class="fs--16 line-height-20">Tu promoción se compró exitosamente.<br>¡Nos vemos pronto!</p>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar"></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/paquete-comprado.svg') }}"  alt="Promoción comprada">
                            </div>
                            <div class="mt-5">
                                <a href="/mis-promociones" class="btn btn-primary-veris fs--18 line-height-24 w-100 w-md-75 px-4 py-3 mb-2">Ir a mis promociones</a>
                                <a href="/" class="btn btn-sm fs--18 line-height-24 px-4 py-3 w-100 w-md-75 border-0 text-primary-veris shadow-none">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Promoción tratamiento comprado -->
                        <div class="content-tratamiento d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Tratamiento comprado</h3>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar"></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Laboratorio presencial comprado -->
                        <div class="content-lab-presencial d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Laboratorio pagado</h3>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar">Acércate a cualquier central Veris.<br><b>¡Nos vemos pronto!</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/lab_presencial.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Laboratorio domicilio comprado -->
                        <div class="content-lab-domicilio d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Laboratorio pagado</h3>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar">Tu laboratorio a domicilio ha sido  agendado.<br><b>¡Nos vemos pronto!</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/lab_domicilio.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 fw-medium w-100 px-4 py-3">Volver al inicio</a>
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
        if(!dataCita.paquete && !dataCita.promocion && !dataCita.datosTratamiento && !dataCita.ordenExterna){
            if(dataCita.online == "S"){
                $('.content-online').removeClass('d-none');
            }else{
                $('.content-presencial').removeClass('d-none');
            }
        }else{
            if(dataCita.paquete){
                //$('#infoAgendar').html(`Para agendarla comunícate con nosotros al <b>${dataCita.detallePaquete.numeroContactCenter}</b>.`)
                $('.content-paquete').removeClass('d-none');
            }else if(dataCita.promocion){
                $('.content-tratamiento').removeClass('d-none');
            }else if(dataCita.datosTratamiento){
                if(dataCita.datosTratamiento.tipoServicio == "LABORATORIO"){
                    $('.content-lab-presencial').removeClass('d-none');
                }else{
                    $('.content-presencial').removeClass('d-none');
                }
            }else if(dataCita.ordenExterna){
                if(dataCita.ordenExterna.aplicoDomicilio == "N"){
                    $('.content-lab-presencial').removeClass('d-none');
                }else{
                    $('.content-lab-domicilio').removeClass('d-none');
                }
            }
        }
    });
</script>
<style>
    @media (min-width: 768px) {
        /* CUSTOM WIDTHS */
        .w-md-75 { width: 75% !important; }
    }
</style>
@endpush