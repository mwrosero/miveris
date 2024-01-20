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
                        @if($data->online == "N")
                        <div class="content-presencial">
                            <i class="bi bi-check-circle-fill h1 text-primary-veris"></i>
                            <h3 class="fw-bold mb-4">Cita agendada</h3>
                            <p class="mb-5">Tu cita se agendó exitosamente. <br> ¡Nos vemos pronto!</p>
                            <img src="{{ asset('assets/img/svg/doctora_2.svg') }}" alt="cita agendada">
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris w-50">Volver al inicio</a>
                            </div>
                        </div>
                        @else
                        <!-- cita agendada online -->
                        <div class="content-online">
                            <i class="bi bi-check-circle-fill h1 text-primary-veris"></i>
                            <h3 class="fw-bold mb-4">Cita agendada</h3>
                            <p class="mb-5">Recuerda conectarte <b>10 minutos antes de la cita.</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/doctora_2.svg') }}" class="d-none d-lg-block" alt="cita agendada">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}" class="d-lg-none d-block" alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris w-50">Volver al inicio</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>

</script>
@endpush