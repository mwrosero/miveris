@extends('template.login')
@section('title')
    Veris - Olvide Contraseña
@endsection
@section('content')
<!-- Logo -->
<div class="text-center mb-2">
    <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
</div>
<!-- /Logo -->
<!-- Content Olvide Clave -->
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-bold">Recupera tu contraseña</p>
<p class="fs-12 mb-5 text-center bg-colortext">Recibirás un código a tu correo electrónico para recuperar tu contraseña.</p>

<form id="formAuthentication" class="mb-3" method="post" action="/recuperar-clave" onSubmit="return false">
    @csrf
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
        {{ session('mensaje') }}
        </div>
    @endif
    <div class="mt-5 mb-2">
        <label for="tipoIdentificacion" class="form-label fw-bold">Tipo de identificación *</label>
        <select class="form-control"
            id="tipoIdentificacion"
            name="tipoIdentificacion"
            onchange="actualizarMaxlength(this)"
            required>
            {{-- <option disabled selected hidden>Elegir</option> --}}
        </select>
    </div>
    <div class="mb-3">
        <label for="numeroIdentificacion" class="form-label fw-bold">Número de identificación *</label>
        <input type="number"
            class="form-control"
            id="numeroIdentificacion"
            name="numeroIdentificacion"
            placeholder="Ingresa tu número de identificación"
            maxlength="10" 
            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))"
            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
            autofocus
            required />
    </div>
    <div class="mb-3">
        <button class="btn d-grid w-100 bg-veris" type="submit" id="recuperarContrasena">Enviar</button>
    </div>
</form>
<!-- /Content Olvide Clave -->

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerIdentificacion();
    });
</script>

@endsection