@extends('template.login')
@section('title')
    Mi Veris - Crear Cuenta
@endsection
@section('back-button')
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 16px; cursor: pointer;" onclick="regresar()">
        <img src="../../assets/img/svg/atras.svg" alt="Atrás">
        <label class="fw-medium" style="font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
    </div>
</div>

@endsection
@section('content')
<!-- Logo -->

<div class="text-center mb-2">
    <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
</div>
<!-- /Logo -->
{{-- <form id="formAuthentication" class="mb-3" action="/registrar" method="POST"> --}}
<form id="registroWizard" onSubmit="return false">
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


    <section class="step step1">
    	<p class="text-left text-md-center title-section txt-alt mt-4 mt-md-2">Crear una cuenta</p>
	    <div class="mb-2">
	        <label for="tipoIdentificacion" class="form-label fw-medium">Tipo de identificación *</label>
	        <select class="form-select form-filter border-0"
	            id="tipoIdentificacion"
	            name="tipoIdentificacion"
	            onchange="actualizarMaxlength(this)"
	            autofocus
	            required>
	            {{-- <option disabled selected hidden>Elegir</option> --}}
	        </select>
	    </div>
	    <div class="mb-2">
	        <label for="numeroIdentificacion" class="form-label fw-medium">Número de identificación *</label>
	        <input type="text"
	            class="form-control form-filter border-0"
	            id="numeroIdentificacion"
	            name="numeroIdentificacion"
	            placeholder="Ingresa tu número de identificación"
	            maxlength="10" 
	            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))"
	            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="mail" class="form-label fw-medium">Correo electrónico *</label>
	        <input type="email"
	            class="form-control form-filter border-0"
	            id="mail"
	            name="mail"
	            placeholder="Ingresa tu correo electrónico"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="fechaNacimiento" class="form-label fw-medium">Fecha de Nacimiento *</label>
	        <input type="text"
	            class="form-control form-filter border-0"
	            id="fechaNacimiento"
	            name="fechaNacimiento"
	            placeholder="Fecha de Nacimiento"
	            onfocus="(this.type='date')"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="telefono" class="form-label fw-medium">Teléfono *</label>
	        <input type="tel"
	            class="form-control form-filter border-0"
				onkeypress="return validarNumero(event)"
	            oninput="limitarCaracteres(this, 10)"
	            id="telefono"
	            name="telefono"
	            placeholder="Ingresa tu Teléfono"
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
	            placeholder="Ingresa tu contraseña"
	            aria-describedby="password"
	            required />
	            <span id="togglePassword" class="input-group-text cursor-pointer form-filter border-0"
	            ><i class="ti ti-eye-off"></i></span>
	        </div>
	        <span class="fs-10">Tu contraseña debe tener 8 dígitos mínimo</span>
	    </div>
	    <div class="mb-2 form-password-toggle">
	        <div class="d-flex justify-content-between">
	            <label class="form-label fw-medium" for="password2">Repite tu contraseña *</label>
	        </div>
	        <div class="input-group input-group-merge">
	            <input type="password"
	            id="password2"
	            class="form-control form-filter border-0"
	            name="password2"
	            placeholder="Repite la contraseña"
	            aria-describedby="password2"
	            required />
	            <span id="togglePassword2" class="input-group-text cursor-pointer form-filter border-0"
	            ><i class="ti ti-eye-off"></i></span>
	        </div>
	    </div>
	    <div class="mt-3">
	        <button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris rounded next-button" type="button">Siguiente</button>
	    </div>
	</section>
	<section class="step step2 d-none">
		<div class="mb-2">
	        <label for="genero" class="form-label fw-medium">Género *</label>
	        <select class="form-select form-filter border-0"
	            id="genero"
	            name="genero"
	            autofocus
	            required>
	            {{-- <option disabled selected hidden>Elegir</option> --}}
	            <option value="M">Masculino</option>
	            <option value="F">Femenino</option>
	        </select>
	    </div>
	    <div class="mb-2">
	        <label for="primerNombre" class="form-label fw-medium">Nombre *</label>
	        <input type="text"
	            class="form-control"
	            id="primerNombre"
	            name="primerNombre"
	            placeholder="Ingresa tu nombre"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="primerApellido" class="form-label fw-medium">Primer Apellido *</label>
	        <input type="text"
	            class="form-control"
	            id="primerApellido"
	            name="primerApellido"
	            placeholder="Ingresa tu primer apellido"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="segundoApellido" class="form-label fw-medium">Segundo Apellido *</label>
	        <input type="text"
	            class="form-control"
	            id="segundoApellido"
	            name="segundoApellido"
	            placeholder="Ingresa tu segundo apellido"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="provincia" class="form-label fw-medium">Provincia *</label>
	        <select class="form-select form-filter border-0"
	            id="provincia"
	            name="provincia"
	            autofocus
	            required>
	            {{-- <option disabled selected hidden>Elegir</option> --}}
				
	        </select>
	    </div>
	    <div class="mb-2">
	        <label for="ciudad" class="form-label fw-medium">Ciudad *</label>
	        <select class="form-select form-filter border-0"
	            id="ciudad"
	            name="ciudad"
	            autofocus
	            required>
	            {{-- <option disabled selected hidden>Elegir</option> --}}
	        </select>
	    </div>
	    <div class="mt-3">
			{{-- <button class="btn d-grid w-100 bg-alt rounded mb-2">Anterior</button> --}}
	      	<button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris rounded btn-registrar">Crear Cuenta</button>
	    </div>
	</section>
	<section class="step step3 d-none">
		<p class="text-left text-md-center title-section txt-alt mt-4 mt-md-2">Código de activación</p>
		<img class="d-block mx-auto mt-3 mb-3" src="../../assets/img/veris/locker.svg">
		<div class="mb-4 text-center">
	        <span>Ingresa el código que enviamos a tu correo</span>
	        <p class="txt-alt fw-medium email-masked"></p>
	    </div>
	    <div class="mb-2">
	        <label for="codigoActivacion" class="form-label fw-medium">Código de activación *</label>
	        <input type="number"
	            class="form-control"
	            id="codigoActivacion"
	            name="codigoActivacion"
	            oninput="limitarCaracteres(this, 10)"
	            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
	            placeholder="Ingresa el código de activación"
	            required />
	    </div>
	    <button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-alt rounded mt-5 mb-2 btn-confirmar" type="button">Confirmar</button>
	</section>
</form>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
        await obtenerIdentificacion();
        const dataProvincia = await obtenerProvincias();
		console.log(dataProvincia);
		obtenerCiudades(dataProvincia[0].codigoProvincia);

        $('body').on('change', '#provincia', async function(){
        	await obtenerCiudades();
        })
    });

	const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    const passwordInput2 = document.getElementById('password2');
    const togglePassword2 = document.getElementById('togglePassword2');
	
	const botonAtras = document.getElementById('botonAtras');




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

    // Espera a que el DOM esté listo
	document.addEventListener("DOMContentLoaded", async function () {
		const primerNombreInput = document.getElementById('primerNombre');
		const primerApellidoInput = document.getElementById('primerApellido');
		const segundoApellidoInput = document.getElementById('segundoApellido');
		const form = document.getElementById("registroWizard");
		const step1 = document.querySelector(".step1");
		const step2 = document.querySelector(".step2");
		const step3 = document.querySelector(".step3");
		const nextButton = document.querySelector(".next-button");
		const prevButton = document.querySelector(".prev-button");
		const registerButton = document.querySelector(".btn-registrar");
		const confirmarButton = document.querySelector(".btn-confirmar");

		primerNombreInput.addEventListener('input', function(e) {
			const valor = e.target.value;
			e.target.value = valor.replace(/[0-9]/g, ''); // Eliminar números del valor
		});

		primerApellidoInput.addEventListener('input', function(e) {
			const valor = e.target.value;
			e.target.value = valor.replace(/[0-9]/g, ''); // Eliminar números del valor
		});

		segundoApellidoInput.addEventListener('input', function(e) {
			const valor = e.target.value;
			e.target.value = valor.replace(/[0-9]/g, ''); // Eliminar números del valor
		});

		// Al hacer clic en "Siguiente", valida los campos y muestra el paso 2 si son válidos
		nextButton.addEventListener("click", async function (e) {
			
			e.preventDefault();
			let errors = false;
            let msg = `<ul class="ms-0 text-start" id="itemsMsg">`;
            let existeCuenta = await verificarCuenta();
            let title = 'Campos requeridos';
            if(!existeCuenta){
	            if(getInput('numeroIdentificacion') == ""){
	                errors = true;
	                msg += `<li class="ms-0">Campo identificación es requerido</li>`;
	            }else if(getInput('tipoIdentificacion') == 2){
	            	if(!esValidaCedula(getInput('numeroIdentificacion').toString())){
	            		errors = true;
	                	msg += `<li class="ms-0">La cédula ingresada no es correcta</li>`;
	            	}
	            }
	            if(getInput('mail') == ""){
	                errors = true;
	                msg += `<li class="ms-0">Campo correo electrónico es requerido</li>`;
	            }else if(!isValidEmailAddress(getInput('mail'))){
	            	errors = true;
	                msg += `<li class="ms-0">Formato de correo electrónico no válido</li>`;
	            }
				if(getInput('fechaNacimiento') == ""){
	                errors = true;
	                msg += `<li class="ms-0">Campo fecha de nacimiento es requerido</li>`;
	            }
	            if(getInput('telefono') == ""){
	                errors = true;
	                msg += `<li class="ms-0">Campo teléfono es requerido</li>`;
	            } else if(getInput('telefono').length < 10){
					console.log(getInput('telefono').length);
	            	errors = true;
	                msg += `<li class="ms-0">Campo teléfono debe tener al menos 10 dígitos</li>`;
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
	            $('#modalAlertButtonCancelar').addClass('d-none');
				$('#modalAlertButtonAccion').addClass('d-none');
				$('#modalAlertButton').removeClass('d-none');
	        }else{
				
	        	errors = true;
	        	title = 'Veris';
	            msg += `<p class="txt-alt text-center">La cuenta que estás intentando crear ya existe. Al parecer has olvidado tu clave, puedes cambiarla ahora.</p>`;
	            
				$(document).ready(function() {
					console.log($('#itemsMsg').length);
					$('#itemsMsg').addClass('ps-0');
				});
				
	            $('#modalAlertButtonCancelar').removeClass('d-none');
				$('#modalAlertButtonAccion').removeClass('d-none');
				$('#modalAlertButtonAccion').attr('href','/olvide-clave');
				$('#modalAlertButton').addClass('d-none');
                $('#modalAlertButtonAccion').html("Cambiar mi clave");
	        }
			if(!errors){
				step1.classList.add("d-none");
				step2.classList.remove("d-none");
				botonAtras.classList.remove("d-none");
			}else{
				msg += `</ul>`;
				$('#modalAlertTitle').html(title);
                $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
			}
		});


		// // Al hacer clic en "Anterior", vuelve al paso 1
		// prevButton.addEventListener("click", function (e) {
		// 	console.log('click atras');
		// 	e.preventDefault();
		// 	step2.classList.add("d-none");
		// 	step1.classList.remove("d-none");
			
		// });

		// Aquí puedes escuchar el evento submit del formulario para enviar los datos.
		registerButton.addEventListener("click", async function (e) {
			console.log('click registrar');
			e.preventDefault();
			let errors = false;
            let msg = `<ul class="ms-0 text-start">`;
			let title = 'Campos requeridos';
			
			if(campoEstaVacio(getInput('primerNombre'))){
			    errors = true;
			    msg += `<li class="ms-0">Campo primer nombre es requerido</li>`;
			}
			if(campoEstaVacio(getInput('primerApellido'))){
			    errors = true;
			    msg += `<li class="ms-0">Campo primer apellido es requerido</li>`;
			}
			if(campoEstaVacio(getInput('segundoApellido'))){
			    errors = true;
			    msg += `<li class="ms-0">Campo segundo apellido es requerido</li>`;
			}
			if (campoEstaVacio(document.getElementById('ciudad').value)) {
				errors = true;
				msg += `<li class="ms-0">Campo ciudad es requerido</li>`;
			}
			if (campoEstaVacio(document.getElementById('provincia').value)) {
				errors = true;
				msg += `<li class="ms-0">Campo provincia es requerido</li>`;
			}
			$('#modalAlertButtonCancelar').addClass('d-none');
			$('#modalAlertButtonAccion').addClass('d-none');
			$('#modalAlertButton').removeClass('d-none');
			if(!errors){
				let registro = await registrarCuenta();
				if(registro.code == 200){
					$('.logo-login').hide();
					$('.email-masked').html(enmascararEmail(getInput('mail')));
					step2.classList.add("d-none");
					step3.classList.remove("d-none");
				}else{
					let title = 'Veris';
	            	msg += `<span class="txt-alt">${registro.message}</span>`;
					$('#modalAlertTitle').html(title);
				    $('#modalAlertMessage').html(msg);
				    $('#modalAlert').modal('show');
				}
			}else{
				msg += `</ul>`;
				$('#modalAlertTitle').html(title);
			    $('#modalAlertMessage').html(msg);
			    $('#modalAlert').modal('show');
			}
		});

		function campoEstaVacio(valor) {
			return !valor.trim();
		}

		confirmarButton.addEventListener("click", async function (e) {
			e.preventDefault();
			let confirmar = await confirmarCuenta();

			if(confirmar.code == 200){
				let title = 'Cuenta creada';
	            let msg = `<span class="txt-alt">Tu cuenta ha sido creada con éxito, ya puedes iniciar sesión.</span>`;
				
				$('#modalAlertButtonAccion').removeClass('w-50');
				$('#modalAlertButtonAccion').addClass('w-100');
				$('#modalAlertButtonAccion').attr('href','/login');
				$('#modalAlertButtonAccion').removeClass('d-none');
				
				$('#modalAlertButton').addClass('d-none');
                $('#modalAlertButtonAccion').html("Entendido");
                $('#modalAlertTitle').html(title);
			    $('#modalAlertMessage').html(msg);
                $('#modalAlert').modal('show');
			}else{
				let title = 'Veris';
            	let msg = `<span class="txt-alt">${confirmar.message}</span>`;
            	$('#modalAlertButtonAccion').addClass('d-none');
				$('#modalAlertButton').removeClass('d-none');
				$('#modalAlertTitle').html(title);
			    $('#modalAlertMessage').html(msg);
			    $('#modalAlert').modal('show');
			}
		});
	});


	// capturar codigoProvincia del select
	$('body').on('change', '#provincia', async function(){
		let codigoProvincia = $(this).val();
		await obtenerCiudades(codigoProvincia);
	});

	// regresar al paso anterior
	function regresar(){
		if (!document.querySelector(".step1").classList.contains("d-none")) {
			window.location.href = '/login';
		}else if (!document.querySelector(".step2").classList.contains("d-none")) {
			document.querySelector(".step2").classList.add("d-none");
			document.querySelector(".step1").classList.remove("d-none");
		}else if (!document.querySelector(".step3").classList.contains("d-none")) {
			document.querySelector(".step3").classList.add("d-none");
			document.querySelector(".step2").classList.remove("d-none");
		}
		
	}



   
</script>
@endsection