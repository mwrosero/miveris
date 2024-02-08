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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center">
                        <!-- cita presencial online -->
                        <div class="content-presencial d-none">
                            <i class="bi bi-check-circle-fill h1 text-primary-veris"></i>
                            <h3 class="fw-medium mb-4">Cita agendada</h3>
                            <p class="mb-5">Tu cita se agendó exitosamente. <br> ¡Nos vemos pronto!</p>
                            <img src="{{ asset('assets/img/svg/doctora_2.svg') }}" alt="cita agendada">
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris w-50">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- cita agendada online -->
                        <div class="content-online d-none">
                            <i class="bi bi-check-circle-fill h1 text-primary-veris"></i>
                            <h3 class="fw-medium mb-4">Cita agendada</h3>
                            <p class="mb-5">Recuerda conectarte <b>10 minutos antes de la cita.</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris w-50">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Paquete comprado -->
                        <div class="content-paquete d-none">
                            <i class="bi bi-check-circle-fill h1 text-primary-veris"></i>
                            <h3 class="fw-medium mb-4">Promoción comprada</h3>
                            <p class="mb-5" id="infoAgendar"></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris w-50">Volver al inicio</a>
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
        if(!dataCita.paquete){
            if(dataCita.online == "S"){
                $('.content-online').removeClass('d-none');
            }else{
                $('.content-presencial').removeClass('d-none');
            }
        }else{
            $('#infoAgendar').html(`Para agendarla comunícate con nosotros al <b>${dataCita.detallePaquete.numeroContactCenter}</b>.`)
            $('.content-paquete').removeClass('d-none');
        }
    });
</script>
@endpush