@extends('template.app-template-veris')
@section('title')
Mi Veris - Verificación exitosa
@endsection
@section('content')
@php
// dd(Session::get('userData'));
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="/mi-cuenta" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Solicitud de administrador') }}</h5>
    </div>
    <section class="pt-4 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 px-0">
                <div class="row">
                    <div class="col-12 text-center my-3">
                        <i class="fa-solid fa-circle-check text-veris-ai fs--64"></i>
                    </div>
                    <div class="col-12 text-center">
                        <p class="fs--28 line-height-36 fw-medium text-veris mb-0">Verificación exitosa</p>
                        <p class="fs--16 line-height-20 my-4 text-veris mb-0">Ya eres administrador de <span class="nombreFamiliar text-capitalize text-veris-ai"></span>, podrás gestionar sus citas, tratamientos y más.</p>
                    </div>
                    <div class="col-12 text-center">
                        <img src="{{asset('assets/img/svg/soporte_aprobado.svg')}}" class="img-fluid mx-auto" width="300px" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')>

<script>
    // variables globales
    let local = localStorage.getItem('persona-{{ $params }}');
    let dataCita = JSON.parse(local);
    console.log(dataCita);
    
    //llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        $('.nombreFamiliar').html(`${dataCita.familiar.primerNombre.toLowerCase()}`);
    });

</script>
<style>
    .digit-box {
        width: 45px;
        height: 45px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        line-height: 45px;
        border-radius: 8px;
    }
    .masked {
        background-color: #adb5bd; /* Gris */
    }
    .input-digit {
        border: 2px solid #adb5bd;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        width: 45px;
        height: 45px;
    }
    /* Para Chrome, Safari, Edge, Opera */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Para Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endpush