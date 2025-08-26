@extends('template.external')
@section('title')
@if(config('app.subdomain') == "parami")
Parami - Citas
@else
Veris - Citas
@endif
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
    // dd($tokenCita);
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.js"></script>

<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
@if(config('app.subdomain') == "parami")
<link rel="stylesheet" href="{{ asset('assets/css/embudo-parami.css?v=1.0.0')}}">
@endif
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar-agendamiento', ['showInfo' => false])
<div class="flex-grow-1 container-p-y pt-0 pb-0">
	<section class="p-0 px-md-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto d-flex flex-column min-vh-100" style="min-width: 375px;">
                	<div>
	                	<h5 class="my-auto py-2 fs-20 line-height-24 text-primary-veris fw-bold">{{ __('Registrar paciente') }}</h5>
	                	<p class="fs-18 line-height-20 mb-4">Ingresa el número de identificación del paciente</p>

					    <div class="mb-2">
					        <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Tipo de identificación *</label>
					        <select class="form-select fs--1 p-3"
					            id="tipoIdentificacion"
					            name="tipoIdentificacion"
					            onchange="actualizarMaxlength(this)"
					            autofocus
					            required>
					        </select>
					    </div>
					    <div class="mb-2">
					        <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Número de identificación *</label>
					        <input type="text"
					            class="form-control fs--1 p-3"
					            id="numeroIdentificacion"
					            name="numeroIdentificacion"
					            placeholder="Ingresa tu número de identificación"
					            maxlength="10" 
					            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))"
					            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
					            required />
					    </div>
				    </div>
				    <div class="mt-auto pt-2 mb-2">
				    	<button class="btn fs--18 fw-medium line-height-24 px-4 py-3 d-grid w-100 bg-veris rounded next-button d-flex" type="button">
				    		Continuar<i class="fa-solid fa-chevron-right ms-2"></i>
				    	</button>
				    </div>
				</div>
            </div>
        </div>
    </section>
</div>

<script>
	document.addEventListener("DOMContentLoaded", async function () {
        await obtenerIdentificacion();

        $('body').on('click', '.next-button', async function(){
        	let tipoIdentificacion = getInput('tipoIdentificacion');
        	let numeroIdentificacion = getInput('numeroIdentificacion');
        	if(tipoIdentificacion == '2'){
        		if(esValidaCedula(numeroIdentificacion)){
        			await buscarUsuario();
        		}else{
        			showMessage('warning','Atención','Número de cédula incorrecto')
        		}
        	}else{
        		if(numeroIdentificacion != "" && numeroIdentificacion.length > 5){
        			await buscarUsuario();
        		}else{
        			showMessage('warning','Atención','Número de pasaporte incorrecto')
        		}
        	}
        })
    })

    async function buscarUsuario(){
    	let args = [];
	    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?tipoIdentificacion=${getInput('tipoIdentificacion')}&numeroIdentificacion=${getInput('numeroIdentificacion')}`;
	    args["method"] = "GET";
	    args["dismissAlert"] = true;
	    args["showLoader"] = true;
	    const data = await call(args);
	    
	    if(data.code == 200){
	    	let dataCita;
	    	if(data.data === null){
	    		dataCita = {
	    			"registro": {
		    			"tipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
		    			"numeroIdentificacion": getInput('numeroIdentificacion')
		    		}
	    		}
	    		localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
	    		location.href = `/external/agendamiento/registro/{{ $tokenCita }}`;
	    	}else{
	    		dataCita = {
	    			"paciente": data.data
	    		}
	    		localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
	    		location.href = `/external/agendamiento/seleccionar-datos-cita/{{ $tokenCita }}`;
	    	}
	    }else{
	    	showMessage('error', 'Atención', data.message);
	    }
    }
</script>
<style>
	body {
	  min-height: 100vh;
	  min-height: -webkit-fill-available;
	}
	html {
	  height: -webkit-fill-available;
	}

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
	}

	input:-webkit-autofill {
		border: 1px solid #0071CE !important;
		color: #0071CE !important;
		font-weight: 500 !important;
		-webkit-text-fill-color: #0071CE !important;
		transition: background-color 9999s ease-in-out 0s; /* Hack para evitar el fondo amarillo */
		background: #FFFFFFCC !important;
	}

	input:not(:placeholder-shown),
	select:valid{
	  font-weight: 500 !important;
	}
</style>
@endsection