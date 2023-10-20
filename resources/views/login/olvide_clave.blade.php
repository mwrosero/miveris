@extends('template.login')
@section('title')
    Veris - Olvide Contraseña
@endsection
@section('content')
<!-- Content Olvide Clave -->
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-bold">Olvidé mi Contraseña</p>
<p class="fs-6 mb-4  text-center bg-colortext">Ingresa tu Usuario o Correo Electrónico </p>

<form id="formAuthentication" class="mb-3" method="post" action="/recuperar-clave" >
    @csrf
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
        {{ session('mensaje') }}
        </div>
    @endif
    <div class="mb-3">
        <label for="user" class="form-label bg-colortext fw-bold mt-2">Usuario o Correo Electrónico</label>
        <input type="text"
            class="form-control"
            id="user"
            name="user"
            autofocus
            required />
    </div>

    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100 bg-colorboton" type="submit" id="recuperarContrasena">Recuperar Contraseña</button>
    </div>
    <div class="mb-3 text-center">
        <a href="login" class="form-cha bg-colortext" for="noCerrarSeesion"> Regresar al Login</a>
    </div>
</form>
<!-- /Content Olvide Clave -->
@endsection