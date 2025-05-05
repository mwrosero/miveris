@extends('template.external')
@section('title')
Veris - Registrar cuenta
@endsection
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar-agendamiento', ['showInfo' => true])
<!-- Logo -->

<div class="flex-grow-1 container-p-y pt-0 pb-0">
	<section class="p-0 px-md-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 d-flex flex-column" style="height: 90vh;">
                	<div>
	                	<h5 class="my-auto py-2 fs-20 line-height-24 text-primary-veris fw-bold">{{ __('Registrar paciente') }}</h5>
	                	<p class="fs-18 line-height-20 mb-4">Necesitamos estos datos para una mejor atención</p>
	                	<div class="mb-2">
					        <label for="primerNombre" class="form-label fw-medium fs--1">Nombre *</label>
					        <input type="text"
					            class="form-control fs--1 p-3"
					            id="primerNombre"
					            name="primerNombre"
					            placeholder="Ingresa tu nombre"
					            required />
					    </div>
					    <div class="mb-2">
					        <label for="primerApellido" class="form-label fw-medium fs--1">Primer Apellido *</label>
					        <input type="text"
					            class="form-control fs--1 p-3"
					            id="primerApellido"
					            name="primerApellido"
					            placeholder="Ingresa tu primer apellido"
					            required />
					    </div>
					    <div class="mb-2">
					        <label for="fechaNacimiento" class="form-label fw-medium fs--1">Fecha de Nacimiento *</label>
					        <input type="text"
					            class="form-control fs--1 p-3"
					            id="fechaNacimiento"
					            name="fechaNacimiento"
					            placeholder="Fecha de Nacimiento"
					            lang="es"
					            onfocus="(this.type='date')"
					            required />
					    </div>
					    <div class="mb-2">
					        <label for="genero" class="form-label fw-medium fs--1">Género *</label>
					        <select class="form-select fs--1 p-3"
					            id="genero"
					            name="genero"
					            autofocus
					            required>
					            <option value="" disabled selected hidden>Elige el género del paciente</option>
					            <option value="M">Masculino</option>
					            <option value="F">Femenino</option>
					        </select>
					    </div>
					    <div class="mb-2">
					        <label for="mail" class="form-label fw-medium fs--1">Correo electrónico *</label>
					        <input type="email"
					            class="form-control fs--1 p-3"
					            id="mail"
					            name="mail"
					            placeholder="Ingresa tu correo electrónico"
					            required />
					    </div>
					    <div class="mb-2">
					        <label for="telefono" class="form-label fw-medium fs--1">Celular *</label>
					        <input type="tel"
					            class="form-control fs--1 p-3"
								onkeypress="return validarNumero(event)"
					            oninput="limitarCaracteres(this, 10)"
					            id="telefono"
					            name="telefono"
					            placeholder="Ingresa tu Teléfono"
					            required />
					    </div>
					    <div class="mb-2 form-pais d-none">
					        <label for="pais" class="form-label fw-medium fs--1">País *</label>
					        <select class="form-select fs--1 p-3"
					            id="pais"
					            name="pais"
					            autofocus
					            required>
					        </select>
					    </div>
					    <div class="mt-auto pt-2 mb-2">
					    	<button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris rounded btn-continuar d-flex">
					    		Continuar<i class="fa-solid fa-chevron-right ms-2"></i>
					    	</button>
					    </div>
	                </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
	// Variables globales
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

	document.addEventListener("DOMContentLoaded", async function () {
        await obtenerIdentificacion();
        await obtenerPaises(true);

        if(dataCita.registro.tipoIdentificacion == 3){
        	$('.form-pais').removeClass('d-none');
        }
        // const dataProvincia = await obtenerProvincias();
		// console.log(dataProvincia);
		// obtenerCiudades(1, dataProvincia[0].codigoProvincia);

        $('body').on('change', '#tipoIdentificacion', async function(){
        	if($(this).val() == '2'){
        		$('.form-pais').addClass('d-none');
        	}else{
        		$('.form-pais').removeClass('d-none');
        	}
        })
    
		const primerNombreInput = document.getElementById('primerNombre');
		const primerApellidoInput = document.getElementById('primerApellido');

		primerNombreInput.addEventListener('input', function(e) {
			const valor = e.target.value;
			e.target.value = valor.replace(/[0-9]/g, ''); // Eliminar números del valor
		});

		primerApellidoInput.addEventListener('input', function(e) {
			const valor = e.target.value;
			e.target.value = valor.replace(/[0-9]/g, ''); // Eliminar números del valor
		});

		$('body').on('click', '.btn-continuar', async function(){
			let errors = false;
            let msg = `<ul class="ms-0 text-start text-veris" id="itemsMsg">`;
            
            let title = 'Campos requeridos';
            if(campoEstaVacio(getInput('primerNombre'))){
			    errors = true;
			    msg += `<li class="ms-0">Campo primer nombre es requerido</li>`;
			}
			if(campoEstaVacio(getInput('primerApellido'))){
			    errors = true;
			    msg += `<li class="ms-0">Campo primer apellido es requerido</li>`;
			}
			if(getInput('fechaNacimiento') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo fecha de nacimiento es requerido</li>`;
            }

            if(getInput('mail') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo correo electrónico es requerido</li>`;
            }else if(!isValidEmailAddress(getInput('mail'))){
            	errors = true;
                msg += `<li class="ms-0">Formato de correo electrónico no válido</li>`;
            }
			if(getInput('telefono') == ""){
                errors = true;
                msg += `<li class="ms-0">Campo teléfono es requerido</li>`;
            } else if(getInput('telefono').length < 10){
				console.log(getInput('telefono').length);
            	errors = true;
                msg += `<li class="ms-0">Campo teléfono debe tener al menos 10 dígitos</li>`;
            }
            msg += `</ul>`;

			if(errors){
				showMessage('warning', 'Atención', msg)
			}else{
				await registrarUsuario();
			}
		});

		function campoEstaVacio(valor) {
			return !valor.trim();
		}

	});	

	async function registrarUsuario(){
		console.log('registro')
	    let args = [];
	    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta`;
	    args["method"] = "POST";
	    args["showLoader"] = true;
	    args["bodyType"] = "json";
	    let fechaParts = getInput('fechaNacimiento').split('-');
	    let fechaFormateada = fechaParts[2] + '/' + fechaParts[1] + '/' + fechaParts[0];

	    let payload = {
	        "tipoIdentificacion": parseInt(dataCita.registro.tipoIdentificacion),
	        "numeroIdentificacion": dataCita.registro.numeroIdentificacion,
	        "primerApellido": getInput('primerApellido'),
	        "primerNombre": getInput('primerNombre'),
	        "mail": getInput('mail').toLowerCase(),
	        "fechaNacimiento": fechaFormateada,
	        "genero": getInput('genero'),
	        "telfMovil": getInput('telefono'),
	        "canalOrigenDigital": window.config.canalOrigen
	    }

	    if(parseInt(dataCita.registro.tipoIdentificacion) == 3){
	        payload.codPais = parseInt(getInput('pais'));
	    }

	    args["data"] = JSON.stringify(payload);

	    const data = await call(args);
	    if(data.code == 200){
	    	await buscarUsuario();
	    }else{
	    	showMessage('error', 'Atención', data.message);
	    }
	}

	async function buscarUsuario(){
    	let args = [];
	    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?tipoIdentificacion=${dataCita.registro.tipoIdentificacion}&numeroIdentificacion=${dataCita.registro.numeroIdentificacion}`;
	    args["method"] = "GET";
	    args["dismissAlert"] = true;
	    args["showLoader"] = true;
	    const data = await call(args);
	    
	    if(data.code == 200){
	    	let dataCita = {
    			"paciente": data.data
    		}
    		localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    		location.href = `/external/agendamiento/seleccionar-datos-cita/{{ $params }}`;
	    }else{
	    	showMessage('error', 'Atención', data.message);
	    }
    }
</script>
<style>
	input:placeholder-shown,
	select:invalid{
	  border: 1px solid #E7E9EC !important;
	  background: #FFFFFFCC !important;
	  color: #3D4E66 !important;
	}

	input:not(:placeholder-shown),
	input:focus,
	select:valid{
	  border: 1px solid #0071CE !important;
	  color: #0071CE !important;
	  background: #FFFFFFCC !important;
	}

	input:not(:placeholder-shown),
	select:valid{
	  font-weight: 500 !important;
	}

	select{
		background-color: #fff;
	    background-image: url(data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5 7.5L10 12.5L15 7.5' stroke='%236f6b7d' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3Cpath d='M5 7.5L10 12.5L15 7.5' stroke='white' stroke-opacity='0.2' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E) !important;
	    background-repeat: no-repeat !important;
	    background-position: right 0.875rem center !important;
	    background-size: 22px 20px !important;
	}
</style>
@endsection