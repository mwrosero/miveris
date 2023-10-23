@extends('template.login')
@section('title')
    Mi Veris - Crear Cuenta
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
	        <label for="tipoIdentificacion" class="form-label fw-bold">Tipo de identificación *</label>
	        <select class="form-control"
	            id="tipoIdentificacion"
	            name="tipoIdentificacion"
	            autofocus
	            required>
	            <option disabled selected hidden>Elegir</option>
	        </select>
	    </div>
	    <div class="mb-2">
	        <label for="user" class="form-label fw-bold">Número de identificación *</label>
	        <input type="number"
	            class="form-control"
	            id="user"
	            name="user"
	            placeholder="Ingresa tu número de identificación"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="mail" class="form-label fw-bold">Correo electrónico *</label>
	        <input type="email"
	            class="form-control"
	            id="mail"
	            name="mail"
	            placeholder="Ingresa tu correo electrónico"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="fechaNacimiento" class="form-label fw-bold">Fecha de Nacimiento *</label>
	        <input type="text"
	            class="form-control"
	            id="fechaNacimiento"
	            name="fechaNacimiento"
	            placeholder="Fecha de Nacimiento"
	            onfocus="(this.type='date')"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="telefono" class="form-label fw-bold">Teléfono *</label>
	        <input type="tel"
	            class="form-control"
	            id="telefono"
	            name="telefono"
	            placeholder="Ingresa tu Teléfono"
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
	    <div class="mb-2 form-password-toggle">
	        <div class="d-flex justify-content-between">
	            <label class="form-label fw-bold" for="password">Contraseña *</label>
	        </div>
	        <div class="input-group input-group-merge">
	            <input type="password"
	            id="password2"
	            class="form-control"
	            name="password2"
	            placeholder="Repite la contraseña"
	            aria-describedby="password2"
	            required />
	            <span id="togglePassword2" class="input-group-text cursor-pointer"
	            ><i class="ti ti-eye-off"></i></span>
	        </div>
	    </div>
	    <div class="mt-3">
	        <button class="btn d-grid w-100 bg-veris rounded next-button" type="button">Siguiente</button>
	    </div>
	</section>
	<section class="step step2 d-none">
		<div class="mb-2">
	        <label for="genero" class="form-label fw-bold">Género *</label>
	        <select class="form-control"
	            id="genero"
	            name="genero"
	            autofocus
	            required>
	            <option disabled selected hidden>Elegir</option>
	        </select>
	    </div>
	    <div class="mb-2">
	        <label for="primerNombre" class="form-label fw-bold">Nombre *</label>
	        <input type="text"
	            class="form-control"
	            id="primerNombre"
	            name="primerNombre"
	            placeholder="Ingresa tu nombre"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="primerApellido" class="form-label fw-bold">Primer Apellido *</label>
	        <input type="text"
	            class="form-control"
	            id="primerApellido"
	            name="primerApellido"
	            placeholder="Ingresa tu primer apellido"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="segundoApellido" class="form-label fw-bold">Segundo Apellido *</label>
	        <input type="text"
	            class="form-control"
	            id="segundoApellido"
	            name="segundoApellido"
	            placeholder="Ingresa tu segundo apellido"
	            required />
	    </div>
	    <div class="mb-2">
	        <label for="provincia" class="form-label fw-bold">Provincia *</label>
	        <select class="form-control"
	            id="provincia"
	            name="provincia"
	            autofocus
	            required>
	            <option disabled selected hidden>Elegir</option>
	        </select>
	    </div>
	    <div class="mb-2">
	        <label for="ciudad" class="form-label fw-bold">Ciudad *</label>
	        <select class="form-control"
	            id="ciudad"
	            name="ciudad"
	            autofocus
	            required>
	            <option disabled selected hidden>Elegir</option>
	        </select>
	    </div>
	    <div class="mt-3">
			{{-- <button class="btn d-grid w-100 bg-alt rounded mb-2">Anterior</button> --}}
	      	<button class="btn d-grid w-100 bg-veris rounded" type="submit">Crear Cuenta</button>
	    </div>
	</section>
</form>
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

    // Espera a que el DOM esté listo
	document.addEventListener("DOMContentLoaded", function () {
	  const form = document.getElementById("registroWizard");
	  const step1 = document.querySelector(".step1");
	  const step2 = document.querySelector(".step2");
	  const nextButton = document.querySelector(".next-button");
	  const prevButton = document.querySelector(".prev-button");

	  // Al hacer clic en "Siguiente", valida los campos y muestra el paso 2 si son válidos
	  nextButton.addEventListener("click", function (e) {
	    e.preventDefault();
	    // Realiza tus validaciones aquí, por ejemplo:
	    step1.classList.add("d-none");
	    step2.classList.remove("d-none");
	    /*if (document.getElementById("input1").value && document.getElementById("input2").value) {
	      step1.classList.add("d-none");
	      step2.classList.remove("d-none");
	    } else {
	      alert("Completa los campos obligatorios en el Paso 1.");
	    }*/
	  });

	  // Al hacer clic en "Anterior", vuelve al paso 1
	  prevButton.addEventListener("click", function (e) {
	    e.preventDefault();
	    step2.classList.add("d-none");
	    step1.classList.remove("d-none");
	  });

	  // Agrega más validaciones según tus necesidades.

	  // Aquí puedes escuchar el evento submit del formulario para enviar los datos.
	  form.addEventListener("submit", function (e) {
	    e.preventDefault();
	    // Realiza cualquier validación final y envía el formulario si es necesario.
	  });
	});

   
</script>
@endsection