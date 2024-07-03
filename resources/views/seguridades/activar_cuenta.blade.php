@extends('template.login')
@section('title')
    Mi Veris - Activar Cuenta
@endsection

@section('content')
<!-- Logo -->
<div class="text-center mb-2">
    <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
</div>
<!-- /Logo -->
{{-- <form id="formVerification" class="mb-3" action="/registrar" method="POST"> --}}
<!-- Modal -->
<div class="modal fade" id="modalAlertReenviar" tabindex="-1" aria-labelledby="modalAlertReenviarLabel">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                <p class="fs--1 fw-normal mb-0 text-veris" id="modalAlertMessageReenviar"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<form id="formVerification" class="mb-3" action="/activar-cuenta" method="POST">
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
	<section class="step">
		<p class="text-left text-md-center title-section txt-alt mt-4 mt-md-2">Código de activación</p>
		<img class="d-block mx-auto mt-3 mb-3" src="../../assets/img/veris/locker.svg">
		<div class="mb-4 text-center">
	        <span>Ingresa el código que enviamos a tu correo</span>
	        <p class="txt-alt fw-medium email-masked"></p>
	    </div>
	    <div class="mb-2">
	        <label for="codigoActivacion" class="form-label fw-medium fs--1">Código de activación *</label>
	        <input type="number"
	            class="form-control fs--1 p-3"
	            id="codigoActivacion"
	            name="codigoActivacion"
	            oninput="limitarCaracteres(this, 10)"
	            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
	            placeholder="Ingresa el código de activación"/>
	    </div>
	    <div class="mt-3 mb-2 text-center">
	    	<span type="button" class="txt-veris fs-12 fw-bold btn-send">Reenviar código</span>
	    </div>
	    <button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-alt rounded mt-5 mb-2 btn-confirmar" type="submit">Confirmar</button>
	</section>
</form>
<script>
	let tipoIdentificacion = {{ $tipoIdentificacion }};
	let numeroIdentificacion = '{{ $numeroIdentificacion }}';
	// Espera a que el DOM esté listo
	document.addEventListener("DOMContentLoaded", async function () {
		const form = document.getElementById("formVerification");
		const confirmarButton = document.querySelector(".btn-confirmar");
		$('.email-masked').html(enmascararEmail('{{ $mail }}'));

		form.addEventListener("submit", function(event) {
            // Realiza tu validación aquí
            if (!validateForm()) {
                event.preventDefault(); // Evitar que el formulario se envíe si la validación falla
            }
        });

        $('body').on('click','.btn-send',async function(){
        	let data = await sendCodeAgain();
        	console.log(data);
            $('#modalAlertMessageReenviar').html(data.message);
            $('#modalAlertReenviar').modal('show');
        	/*if(data.code == 200){
        		showMessage('success',data.message);
        	}else{
        		showMessage('error',data.message);
        	}*/
        })

        function validateForm(){
			let errors = false;
            let msg = `<ul class="ms-0 text-start text-veris">`;
            let title = 'Campos requeridos';

            if(getInput('codigoActivacion') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo código de activación es requerido</li>`;
            }

            console.log(errors);

            if(errors){
                $('#modalAlertTitle').html('Campos requeridos');
                $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
            }

            return !errors;
		};
	});
   
</script>
@endsection