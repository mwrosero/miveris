@extends('template.login')
@section('title')
    Veris - Recuperar Contraseña
@endsection
@section('content')
<div class="text-center mb-2">
    <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
</div>
<!-- Content Recuperar Clave -->
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-bold">Recupera tu contraseña</p>
<p class="fs-6 mb-3 text-center bg-colortext">Hemos enviado un código al correo electrónico con el que creaste tu cuenta.</p>
<form id="formAuthentication" class="mb-3" action="login">
    <div class="mb-3">
        <label for="codigo" class="form-label bg-colortext fw-bold mt-3">Código de autorización *</label>
        <input type="text"
            class="form-control"
            id="codigo"
            name="codigo-username"
            autofocus
            required />
    </div>
    <div class="mb-2 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label fw-bold" for="password">Contraseña *</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password"
            id="password"
            class="form-control"
            name="password"
            placeholder="Ingresa tu contraseña"
            aria-describedby="password"
            required />
            <span id="togglePassword" class="input-group-text cursor-pointer"
            ><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label fw-bold" for="password">Contraseña *</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password"
            id="password2"
            class="form-control"
            name="password2"
            placeholder="Confirma la contraseña"
            aria-describedby="password2"
            required />
            <span id="togglePassword2" class="input-group-text cursor-pointer"
            ><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-2">
        <button class="btn btn-primary d-grid w-100 bg-colorboton" type="submit" id="guardarContrasena">Recuperar contraseña</button>
    </div>
    <div>
        <p class="txt-alt fs-12 text-center">Revisa en tu bandeja de correo no deseado. Si no has recibido el correo con el código, comunícate al <b>6009600</b>.</p>
    </div>
</form>
<!-- /Content Recuperar Clave -->
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    const passwordInput2 = document.getElementById('password2');
    const togglePassword2 = document.getElementById('togglePassword2');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });

    togglePassword2.addEventListener('click', function() {
        if (passwordInput2.type === 'password') {
            passwordInput2.type = 'text';
            togglePassword2.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput2.type = 'password';
            togglePassword2.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });

</script>
@endsection