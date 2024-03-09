@extends('template.login')
@section('title')
    Veris - Olvide Contraseña
@endsection
@section('back-button')
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
<!-- Logo -->
<div class="text-center mb-2">
    <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
</div>
<!-- /Logo -->
<!-- Content Olvide Clave -->
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-medium">Recupera tu contraseña</p>
<p class="fs-12 mb-5 text-center bg-colortext">Recibirás un código a tu correo electrónico para recuperar tu contraseña.</p>

<form id="formAuthentication" class="mb-3">
    @csrf
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
        {{ session('mensaje') }}
        </div>
    @endif
    <div class="mt-5 mb-2">
        <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Tipo de identificación *</label>
        <select class="form-select fs--1 p-3"
            id="tipoIdentificacion"
            name="tipoIdentificacion"
            onchange="actualizarMaxlength(this)"
            required />
            {{-- <option disabled selected hidden>Elegir</option> --}}
        </select>
    </div>
    <div class="mb-3">
        <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Número de identificación *</label>
        <input type="number"
            class="form-control fs--1 p-3"
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
        <button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris btn-reset" type="button" id="recuperarContrasena">Enviar</button>
    </div>
</form>
<!-- /Content Olvide Clave -->

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const resetButton = document.querySelector(".btn-reset");
        await obtenerIdentificacion();

        resetButton.addEventListener("click", async function (e) {
            e.preventDefault();
            let errors = false;
            let msg = `<ul class="ms-0 text-start text-veris">`;
            let title = 'Campos requeridos';
            if(getInput('numeroIdentificacion') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo identificación es requerido</li>`;
            }else if(getInput('tipoIdentificacion') == 2){
                if(!esValidaCedula(getInput('numeroIdentificacion').toString())){
                    errors = true;
                    msg += `<li class="ms-0">La cédula ingresada no es correcta</li>`;
                }
            }

            if(!errors){
                let reset = await codigoReset();
                if(reset.code == 200){
                    let param = {};
                    param.tipoIdentificacion = getInput('tipoIdentificacion');
                    param.numeroIdentificacion = getInput('numeroIdentificacion');
                    let codigoUsuario = btoa(JSON.stringify(param));
                    location.href = '/reestablecer-clave/'+codigoUsuario;
                }else{
                    title = 'Veris';
                    msg = `<span class="txt-alt">${reset.message}</span>`;
                    $('#modalAlertButtonAccion').addClass('d-none');
                    $('#modalAlertButton').removeClass('d-none');
                    $('#modalAlertTitle').html(title);
                    $('#modalAlertMessage').html(msg);
                    $('#modalAlert').modal('show');
                }
                // reset.then((data) => {
                //     console.log(data); // Aquí obtendrás el resultado de la promesa una vez que se resuelva.
                //     if(data.code == 200){
                //         let param = {};
                //         param.tipoIdentificacion = getInput('tipoIdentificacion');
                //         param.numeroIdentificacion = getInput('numeroIdentificacion');
                //         let codigoUsuario = btoa(JSON.stringify(param));
                //         location.href = '/reestablecer-clave/'+codigoUsuario;
                //     }else{
                //         title = 'Veris';
                //         msg = `<span class="txt-alt">${data.message}</span>`;
                //         $('#modalAlertButtonAccion').addClass('d-none');
                //         $('#modalAlertButton').removeClass('d-none');
                //         $('#modalAlertTitle').html(title);
                //         $('#modalAlertMessage').html(msg);
                //         $('#modalAlert').modal('show');
                //     }
                // }).catch((error) => {
                //     console.log(error);
                //     title = 'Veris';
                //     msg = `<span class="txt-alt">${error.message}</span>`;
                //     $('#modalAlertButtonAccion').addClass('d-none');
                //     $('#modalAlertButton').removeClass('d-none');
                //     $('#modalAlertTitle').html(title);
                //     $('#modalAlertMessage').html(msg);
                //     $('#modalAlert').modal('show');
                // });

            }else{
                msg += `</ul>`;
                $('#modalAlertButtonAccion').addClass('d-none');
                $('#modalAlertButton').removeClass('d-none');
                $('#modalAlertTitle').html(title);
                $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
            }
        });        
    });
</script>

@endsection