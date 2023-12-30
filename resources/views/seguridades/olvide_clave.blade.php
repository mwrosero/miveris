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

<form id="formAuthentication" class="mb-3">
    @csrf
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
        {{ session('mensaje') }}
        </div>
    @endif
    <div class="mt-5 mb-2">
        <label for="tipoIdentificacion" class="form-label fw-bold">Tipo de identificación *</label>
        <select class="form-select border-0"
            id="tipoIdentificacion"
            name="tipoIdentificacion"
            onchange="actualizarMaxlength(this)"
            required style="background-color: var(--opacidad-oscuro-05, rgba(0, 0, 0, 0.05)) !important;" />
            {{-- <option disabled selected hidden>Elegir</option> --}}
        </select>
    </div>
    <div class="mb-3">
        <label for="numeroIdentificacion" class="form-label fw-bold">Número de identificación *</label>
        <input type="number"
            class="form-control border-0"
            id="numeroIdentificacion"
            name="numeroIdentificacion"
            placeholder="Ingresa tu número de identificación"
            maxlength="10" 
            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))"
            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
            autofocus
            required style="background-color: var(--opacidad-oscuro-05, rgba(0, 0, 0, 0.05)) !important;" />
    </div>
    <div class="mb-3">
        <button class="btn d-grid w-100 bg-veris btn-reset" type="button" id="recuperarContrasena">Enviar</button>
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
            let msg = `<ul class="ms-0 text-start">`;
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
                let reset = codigoReset();
                reset.then((data) => {
                    console.log(data); // Aquí obtendrás el resultado de la promesa una vez que se resuelva.
                    if(data.code == 200){
                        let codigoUsuario = btoa(getInput('numeroIdentificacion'));
                        location.href = '/reestablecer-clave/'+codigoUsuario;
                    }else{
                        title = 'Veris';
                        msg = `<span class="txt-alt">${data.message}</span>`;
                        $('#modalAlertButtonAccion').addClass('d-none');
                        $('#modalAlertButton').removeClass('d-none');
                        $('#modalAlertTitle').html(title);
                        $('#modalAlertMessage').html(msg);
                        $('#modalAlert').modal('show');
                    }
                }).catch((error) => {
                    title = 'Veris';
                    msg = `<span class="txt-alt">${error.message}</span>`;
                    $('#modalAlertButtonAccion').addClass('d-none');
                    $('#modalAlertButton').removeClass('d-none');
                    $('#modalAlertTitle').html(title);
                    $('#modalAlertMessage').html(msg);
                    $('#modalAlert').modal('show');
                });

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