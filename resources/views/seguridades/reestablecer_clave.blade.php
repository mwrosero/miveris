@extends('template.login')
@section('title')
    Veris - Recuperar Contraseña
@endsection
@section('back-button')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData'));
// dd($data);
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="{{ route('login') }}" class="text-decoration-none">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 16px;">
            <img src="../../assets/img/svg/atras.svg" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium" style="font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
@endsection
@section('content')
<div class="text-center mb-2">
    <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
</div>
<!-- Content Recuperar Clave -->
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-medium">Recupera tu contraseña</p>
<p class="fs--1 mb-2 text-center text-dark-veris fw-normal">Ingresa el código que enviamos a tu correo.</p>
<p class="fs--2 text-center text-dark-veris fw-medium email-masked"></p>
<form id="formAuthentication" class="mb-3">
    <div class="mb-3">
        <label for="codigoAutorizacion" class="form-label bg-colortext fw-medium mt-3">Código de autorización *</label>
        <input type="text"
            class="form-control form-filter border-0"
            oninput="limitarCaracteres(this, 10)"
            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
            id="codigoAutorizacion"
            name="codigoAutorizacion"
            value=""
            autocomplete="codigoAutorizacion"
            placeholder="Código de autorización"
            required />
    </div>
    <div class="mb-2 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label fw-medium" for="password">Contraseña *</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password"
            id="password"
            class="form-control form-filter border-0"
            name="password"
            autocomplete="new-password"
            placeholder="Ingresa tu contraseña"
            required />
            <span id="togglePassword" class="input-group-text cursor-pointer form-filter border-0"
            ><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label fw-medium" for="password">Contraseña *</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password"
            id="password2"
            class="form-control form-filter border-0"
            name="password2"
            autocomplete="new-password2"
            placeholder="Confirma la contraseña"
            required />
            <span id="togglePassword2" class="input-group-text cursor-pointer form-filter border-0"
            ><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-2">
        <button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris btn-recuperar" type="button">Recuperar contraseña</button>
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

    const dataUser = JSON.parse(atob(@JSON($params)));

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

    let params;
    document.addEventListener("DOMContentLoaded", async function () {
        const reestablecerButton = document.querySelector(".btn-recuperar");
        await obtenerDatosUsuario();
        params = @json($data);
        reestablecerButton.addEventListener("click", async function (e) {
            e.preventDefault();
            let errors = false;
            let msg = `<ul class="ms-0 text-start">`;
            let title = 'Campos requeridos';
            if(getInput('codigoAutorizacion') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo código de autorización es requerido</li>`;
            }
            if(getInput('password') == "" || getInput('password').length < ""){
                errors = true;
                msg += `<li class="ms-0">Campo contraseña es requerido</li>`;   
            }else if(getInput('password').length < 8){
                errors = true;
                msg += `<li class="ms-0">Campo contraseña debe tener al menos 8 dígitos</li>`;
            }
            if(getInput('password2') == "" || getInput('password2').length < ""){
                errors = true;
                msg += `<li class="ms-0">Campo confirmar contraseña es requerido</li>`; 
            }else if(getInput('password2').length < 8){
                errors = true;
                msg += `<li class="ms-0">Campo confirmar contraseña debe tener al menos 8 dígitos</li>`;
            }
            if(getInput('password') != getInput('password2')){
                errors = true;
                msg += `<li class="ms-0">Las contraseñas no coinciden</li>`;    
            }

            if(!errors){
                let recuperar = await recuperarContrasena();
                // if(recuperar.code == 200){
                //     title = "Contraseña modificada";
                //     msg = "Tu contraseña ha sido modificada con éxito"
                //     $('#modalAlertButtonAccion').removeClass('w-50');
                //     $('#modalAlertButtonAccion').addClass('w-100');
                //     $('#modalAlertButtonAccion').attr('href','/login');
                //     $('#modalAlertButtonAccion').removeClass('d-none');
                    
                //     $('#modalAlertButton').addClass('d-none');
                //     $('#modalAlertButtonAccion').html("Entendido");
                //     $('#modalAlertTitle').html(title);
                //     $('#modalAlertMessage').html(msg);
                //     $('#modalAlert').modal('show');
                // }else{
                //     title = 'Veris';
                //     msg = `<span class="txt-alt">${recuperar.message}</span>`;
                //     $('#modalAlertButtonAccion').addClass('d-none');
                //     $('#modalAlertButton').removeClass('d-none');
                //     $('#modalAlertTitle').html(title);
                //     $('#modalAlertMessage').html(msg);
                //     $('#modalAlert').modal('show');
                // }
            }else{
                msg += `</ul>`;
                $('#modalAlertTitle').html(title);
                $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
            }
        });
    });

    async function obtenerDatosUsuario(tipoIdentificacion, numeroIdentificacion) {
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/seguridad/cuenta?canalOrigen=${_canalOrigen}&tipoIdentificacion=${ dataUser.tipoIdentificacion }&numeroIdentificacion=${ dataUser.numeroIdentificacion }`;
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        
        const data = await call(args);
        console.log('datosUsuario',data);
        if (data.code == 200) {
            $('.email-masked').html(enmascararEmail(data.data.mail));
        }
        return;
    } 
</script>
@endsection