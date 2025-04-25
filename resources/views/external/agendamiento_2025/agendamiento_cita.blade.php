@extends('template.external')
@section('title')
Veris - Citas
@endsection
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.js"></script>

<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar-agendamiento')
<div class="flex-grow-1 container-p-y pt-0">
	<section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-3">
                	<h5 class="my-auto py-2 fs-20 line-height-24 text-primary-veris fw-bold">{{ __('Registrar paciente') }}</h5>
                	<p class="fs-18 line-height-20 mb-4">Ingresa el número de identificación del paciente</p>
				    <div class="mb-2">
				        <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Tipo de identificación *</label>
				        <select class="form-select fs--1 p-3"
				            id="tipoIdentificacion"
				            name="tipoIdentificacion"
				            onchange="actualizarMaxlength(this)"
				            autofocus
				            required>
				            {{-- <option disabled selected hidden>Elegir</option> --}}
				        </select>
				    </div>
				    <div class="mb-2">
				        <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Número de identificación *</label>
				        <input type="text"
				            class="form-control fs--1 p-3"
				            id="numeroIdentificacion"
				            name="numeroIdentificacion"
				            placeholder="Ingresa tu número de identificación"
				            maxlength="10" 
				            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))"
				            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
				            required />
				    </div>
				</div>
            </div>
        </div>
    </section>
</div>
@endsection