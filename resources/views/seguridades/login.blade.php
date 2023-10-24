@extends('template.login')
@section('title')
    Mi Veris - Login
@endsection

@section('content')
<!-- Logo -->
<div class="text-center mb-4">
    <img class="logo-login" src="../../assets/img/veris/icono.svg">
</div>
<!-- /Logo -->
<form id="formAuthentication" class="mb-3" action="/autenticar" method="POST">
    @csrf
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
            {{ session('mensaje') }}
        </div>
    @endif
    @if($errors->has('csrf_token'))
    <div class="alert alert-warning">
        {{ $errors->first('csrf_token') }}
    </div>
    @endif
    <div class="mb-3 mt-5">
        <label for="numeroIdentificacion" class="form-label fw-bold">Número de identificación *</label>
        <input type="number"
            class="form-control"
            id="numeroIdentificacion"
            name="numeroIdentificacion"
            oninput="limitarCaracteres(this, 13)"
            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
            placeholder="Ingresa tu identificación"
            @if (session()->has('numeroIdentificacion'))
            value="{{ session('numeroIdentificacion') }}"
            @endif
            autofocus />
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label fw-bold" for="password">Contraseña *</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password"
            id="password"
            class="form-control"
            name="password"
            placeholder="Ingresa tu contraseña"
            aria-describedby="password"/>
            <span id="togglePassword" class="input-group-text cursor-pointer"
            ><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-5 text-left">
        <a class="txt-veris fs-12" href="/olvide-clave"> Olvide mi Contraseña</a>
    </div>
    <div class="mt-5 mb-3">
        <button class="btn d-grid w-100 bg-veris rounded" id="btnLogin" type="submit">Iniciar Sesión</button>
    </div>
    <div class="mb-3">
        <a href="registrar-cuenta" class="btn d-grid w-100 bg-alt rounded">Crear una cuenta</a>
    </div>
</form>
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("formAuthentication");
        var submitButton = document.getElementById("btnLogin");

        form.addEventListener("submit", function(event) {
            // Realiza tu validación aquí
            if (!validateForm()) {
                event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            }
        });

        function validateForm(){
            let errors = false;
            let msg = `<ul class="ms-0 text-start">`;
            if(getInput('numeroIdentificacion') == "" || getInput('numeroIdentificacion').length < 10 ){
                errors = true;
                msg += `<li class="ms-0">Campo cédula o pasaporte es requerido</li>`;
            }
            if(getInput('password') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo contraseña es requerido</li>`;
            }
            msg += `</ul>`;
            if(errors){
                $('#modalAlertTitle').html('Campos requeridos');
                $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
            }
            return !errors;
        }
    });
</script>
@endsection