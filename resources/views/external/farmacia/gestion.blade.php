<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>PhantomX</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.svg') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/phantomx/css/theme-phantomx.css?v=1.0')}}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/jquery.toast.min.js')}}"></script>

    <script>
        let _token = "{{ session('accessToken') }}";
        const _application = "{{ \App\Models\VERIS::APPLICATION_FARMACIA }}";
        const _idOrganizacion = "{{ \App\Models\VERIS::IDORGANIZACION }}";
        const api_url = "{{ \App\Models\VERIS::BASE_URL }}";
    	const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
        const url_site = "{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}";
    </script>

</head>
<body>
    <div class="modal fade" id="confirmacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
    {{-- <div class="modal fade" id="confirmacion" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> --}}
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="confirmacionTitle">Se ha generado el picking correctamente.</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body text-center" id="confirmacionBody">
                    <!-- Preview content will be added here -->
                    <button type="button" class="btn btn-blue-phax" onclick="location.reload();">
			        	Gestionar nuevo Picking
			        </button>
                </div>
            </div>
        </div>
    </div>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid align-items-center">
                <a class="" href="#">
                    <img src="{{ asset('assets/external/phantomx/img/logo/phantomx.svg')}}" alt="Logo" width="112" />
                </a>
                <a class="" href="#">
                    <img src="{{ asset('assets/external/phantomx/img/logo/veris.svg')}}" alt="Logo" width="72" />
                </a>
            </div>
        </nav>
        <div class="container-fluid bg-green py-2">
        	<div class="row d-flex justify-content-between">
        		<div class="col-auto text-white">Gestión de Picking - Farmacia</div>
        		<div class="col-auto text-white">
        			Hola {{ session('userData')->codigoUsuario }}, 
        			<a href="/external/farmacia/logout" class="text-white text-decoration-none btn-cerrar" type="button">
        				Cerrar sesión
        			</a>
        		</div>
        	</div>
        </div>
    </header>
    <main>
        <section class="container-fluid px-0 mb-5">
            <div class="row my-4 d-flex justify-content-center align-items-center g-3 px-0 mx-0">
            	<div class="col-auto text-center">
            		<select id="sucursal" class="form-select fs--1 p-3 py-2 pe-5 text-capitalize" title="Central de Picking">
            		</select>
            	</div>
            	<div class="col-auto text-center">
                	<p class="fw-semibold fs-5 mb-0">Nro. de Solicitud: </p>
            	</div>
            	<div class="col-auto">
            		<input type="text" class="form-control fs--1 p-3 py-2" id="numeroSolicitud">
            	</div>
            	<div class="col-auto">
            		<button type="button" class="btn btn-blue-phax w-100 btn-buscar">Buscar</button>
            	</div>
            </div>
        </section>
        <div class="container-fluid px-0">
        	<div class="row d-none row-table-gestion bg-veris text-center mx-0">
        		<div class="col-12 text-white fs-5 py-2">
        			Prestaciones
        		</div>
        	</div>
        	<div class="row d-none row-table-gestion mx-0">
        		<div class="col-12 col-md-4 offset-md-4 mt-3">
        			<input type="text" id="strBarCodes" class="form-control" placeholder="Ingresar Códigos de Barra">
        		</div>
        		<div class="col-12 col-md-10 offset-md-1">
        			<table class="table w-100 mt-3">
        				<thead>
        					<tr>
        						<th class="text-nowrap">Requiere</th>
        						<th class="text-nowrap d-none">Código</th>
        						<th>Prestación</th>
        						<th class="text-nowrap">Cantidad</th>
        						<th class="text-nowrap">Estado</th>
        					</tr>
        				</thead>
        				<tbody id="dataPrestaciones">
        					{{-- <tr class="align-middle">
        						<td colspan="5" class="bg-silver-light">Paciente</td>
        					</tr>
        					<tr class="align-middle">
        						<td class="text-center"><i class="fa-solid fa-barcode"></i></td>
        						<td>
        							<input type="text" class="form-control" class="input-codigo">
        						</td>
        						<td>EZOLETIC 20MG TAB CJA X 28</td>
        						<td class="text-nowrap">1</td>
        						<td class="text-nowrap"><i class="fa-solid fa-circle-check text-success"></i></td>
        					</tr>
        					<tr class="align-middle">
        						<td></td>
        						<td>
        							<input type="text" class="form-control" class="input-codigo">
        						</td>
        						<td>EZOLETIC 20MG TAB CJA X 28</td>
        						<td class="text-nowrap">1</td>
        						<td class="text-nowrap"><i class="fa-solid fa-triangle-exclamation text-danger"></i></td>
        					</tr> --}}
        				</tbody>
        			</table>
        		</div>
        	</div>
            <div class="row justify-content-center align-items-center my-4 mx-0">
                <div class="col-12 col-lg-3">
                    <button type="button" class="btn fw-bold bg-green text-white w-100 btn-generar">Generar Picking</button>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-footer py-4">
            <div class="container-fluid px-3 px-lg-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="font-gotham fw-semibold">© 2025 Phantom X. Todos los derechos reservados.</div>
                    <div class="d-flex align-items-center">
                        <span class="text-success font-gotham fw-semibold">Vesion 6.7.2</span>
                    </div>
                </div>
            </div>
        </footer>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/external/phantomx/js/utils.js?v=1.0.3"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.0.0"></script>
    <script type="text/javascript" src="{{ asset('assets/external/resultados-laboratorio/js/pdf.min.js') }}"></script>
    <script>
    	let objeto = @json(session('roles'));
    	const codigosSucursalFiltrados = [
		  ...new Set(
		    objeto.roles
		      .filter(rol => rol.codigoRol === 1121 && rol.nombreRol === 'GUIA DE DESPACHO USUARIO2')
		      .map(rol => rol.codigoSucursal)
		  )
		];

		const sucursalesFiltradas = objeto.sucursales.filter(sucursal =>
			codigosSucursalFiltrados.includes(sucursal.codigoSucursal)
		);

        let tipoFlujo = "";
        window.config = {
            subdomain: @json(config('app.subdomain')),
            canalOrigen: (@json(config('app.subdomain')) == "veris") ? "VER_CMV" : "VER_PMF"
        };

        let numeroSolicitudEnProceso;
        document.addEventListener("DOMContentLoaded", async function () {
        	await fillSucursales();

        	$('body').on('click', '.btn-buscar', async function(){
        		let numeroSolicitud = getInput('numeroSolicitud');
        		if(numeroSolicitud == ''){
        			showMsg('Ingrese número de solicitud.', 'error');
        		}else{
        			await buscarSolicitud(numeroSolicitud);
        		}
        	})

        	$('#numeroSolicitud').on('keypress', async function(e) {
			    if (e.which === 13) {
			        e.preventDefault();
			        let numeroSolicitud = getInput('numeroSolicitud');
	        		if(numeroSolicitud == ''){
	        			showMsg('Ingrese número de solicitud.', 'error');
	        		}else{
	        			await buscarSolicitud(numeroSolicitud);
	        		}
			    }
			});

        	$('body').on('click', '.btn-generar', async function(){
        		let hasErrors = false;
        		let msg_error = `<ul>`;
        		if(getInput('sucursal') === ''){
        			hasErrors = true;
        			msg_error += `<li>Debe seleccionar una Sucursal para hacer el Picking.</li>`;
        		}

        		if($('.table td.td-required-empty').length > 0){
        			hasErrors = true;
        			msg_error += `<li>Verificar que todas las prestaciones requeridas de pistoleo hayan sido ingresadas.</li>`;
        		}

        		msg_error += `</ul>`
        		if(hasErrors){
        			showMsg(msg_error,'warning');
        		}else{
        			console.log("Generar")
        			await generarPicking();
        		}
        	})

        	let debounceTimer;

			$('#strBarCodes').on('input', function () {
			    clearTimeout(debounceTimer);

			    debounceTimer = setTimeout(function () {
			        const valorIngresado = $('#strBarCodes').val().trim();

			        $('input[codigos-rel]').each(function () {
			            const codigosRel = JSON.parse($(this).attr('codigos-rel') || '[]');
			            let codigoServicio = $(this).attr('codigoServicio-rel');
			            let codigoPrestacion = $(this).attr('codigoPrestacion-rel');

			            if (codigosRel.includes(valorIngresado)) {
			                $(this).removeClass('is-invalid').addClass('is-valid');
			                $(`#icon-status-${codigoServicio}-${codigoPrestacion}`).html(`<i class="fa-solid fa-circle-check text-success"></i>`);
			                $(`.td-${codigoServicio}-${codigoPrestacion}`).removeClass(`td-required-empty`);
			                $('#strBarCodes').val("");
			                showMsg('Prestación registrada para Picking.', 'success');
			            } else {
			            	if($('#strBarCodes').val() !== ""){
				                showMsg('Prestación no encontrada.', 'error');
				                $(this).removeClass('is-valid');
				            }
			            }
			        });
			    }, 500); // 1.5 segundos
			});

        	{{-- $('#strBarCodes').on('input', function () {
		        const valorIngresado = $(this).val().trim();

		        $('input[codigos-rel]').each(function () {
		            const codigosRel = JSON.parse($(this).attr('codigos-rel') || '[]');
		            let codigoServicio = $(this).attr('codigoServicio-rel');
					let codigoPrestacion = $(this).attr('codigoPrestacion-rel');
		            
		            if (codigosRel.includes(valorIngresado)) {
		                $(this).removeClass('is-invalid').addClass('is-valid');
		                $(`#icon-status-${codigoServicio}-${codigoPrestacion}`).html(`<i class="fa-solid fa-circle-check text-success"></i>`);
		                $('#strBarCodes').val("");
		                showMsg('Prestación registrada para Picking.','success');
		            } else {
						showMsg('Prestación no encontrada.','error');
		                $(this).removeClass('is-valid');
		            }
		        });
		    }); --}}

        	{{-- $(document).on('input', 'input[codigos-rel]', function () {
		        const codigosRel = JSON.parse($(this).attr('codigos-rel') || '[]');
		        const valorIngresado = $(this).val().trim();
		        let codigoServicio = $(this).attr('codigoServicio-rel');
				let codigoPrestacion = $(this).attr('codigoPrestacion-rel');
		        if (codigosRel.includes(valorIngresado)) {
		        	$(`#icon-status-${codigoServicio}-${codigoPrestacion}`).html(`<i class="fa-solid fa-circle-check text-success"></i>`)
		            $(this).removeClass('is-invalid').addClass('is-valid');
		        } else {
		        	$(`#icon-status-${codigoServicio}-${codigoPrestacion}`).html(`<i class="fa-solid fa-triangle-exclamation text-danger"></i>`)
		            $(this).removeClass('is-valid').addClass('is-invalid');
		        }
		    }); --}}
        })

		async function generarPicking(){
			let args = [];
			args["endpoint"] = api_url + `/facturacion/v1/farmacia_domicilio/solicitudes/${numeroSolicitudEnProceso}/actualizar_picking_transaccion?codigoEmpresa=1&codigoSucursal=${getInput('sucursal')}`;
	        args["method"] = "POST";
	        args["showLoader"] = true;
	        args["token"] = _token;
	        args["bodyType"] = "json";
        	args["data"] = JSON.stringify({});
	        args["dismissAlert"] = true;
	        const data = await call(args);
	        if(data.code == 200){
	        	{{-- $('#confirmacionTitle').html(data.message); --}}
	        	$('#confirmacion').modal('show')
	        }else{
	        	showMsg(data.message, 'error');
	        }
		}

        async function buscarSolicitud(numeroSolicitud){
        	let args = [];
        	// https://api-phantomx.veris.com.ec/facturacion/v1/farmacia_domicilio/solicitudes/123/detalle_transacciones?codigoEmpresa=1

	        args["endpoint"] = api_url + `/facturacion/v1/farmacia_domicilio/solicitudes/${numeroSolicitud}/detalle_transacciones?codigoEmpresa=1`;
	        args["method"] = "GET";
	        args["showLoader"] = true;
	        args["token"] = _token;
	        args["dismissAlert"] = true;
	        const data = await call(args);
	        console.log(data);
	        if(data.code == 200){
	        	if(data.data.length > 0){
	        		numeroSolicitudEnProceso = numeroSolicitud;
	        		$('.row-table-gestion').removeClass('d-none');
	        		await drawPrestaciones(data.data);
	        	}else{
	        		$('.row-table-gestion').addClass('d-none');
	        		showMsg("Datos no econtrados para la solicitud: "+numeroSolicitud, 'warning');
	        	}
	        }else{
	        	showMsg(data.message, 'warning');
	        	$('.row-table-gestion').addClass('d-none');
	        }
        }

        async function drawPrestaciones(data){
        	console.log(data);
        	let elem = ``
        	$.each(data, function(key, value){
        		let td_str_paciente = `<td colspan="4" class="bg-silver-light text-veris">Transacción: ${value.numeroTransaccion}`;
        		if(value.numeroComprobante !== null && value.numeroComprobante !== "--"){
        			td_str_paciente += `  <i class="fa-solid fa-grip-lines-vertical mx-3"></i> Comprobante: ${value.numeroComprobante}`;
        		}
        		if(value.nombreFactura !== null){
        			td_str_paciente += `  <i class="fa-solid fa-grip-lines-vertical mx-3"></i> Paciente: ${value.nombreFactura}`;
        		}
        		td_str_paciente += `</td>`
        		elem += `<tr class="align-middle fw-bold">
    						${td_str_paciente}
    					</tr>`;
    			$.each(value.detalles, function(k,v){
    				let aplicaPistoleo = v.aplicaPistoleo;
    				let isRequired = ``;
    				let iconBarCode = ``;
    				let classTdRequired = ``;
    				let codigos = [];
    				let iconCompleted = `<i class="fa-solid fa-circle-check text-success"></i>`
    				if(aplicaPistoleo){
    					iconBarCode = `<i class="fa-solid fa-barcode"></i><i class="fa-solid fa-barcode"></i>`;
    					isRequired = `required`;
    					codigos = v.codigoBarras;
    					iconCompleted = `<i class="fa-solid fa-triangle-exclamation text-danger"></i>`;
    					classTdRequired = `td-required-empty`;
    				}else{
    					isRequired = `disabled`;
    				}
    				console.log(codigos)
    				elem += `<tr class="align-middle">
        						<td class="${classTdRequired} td-${v.codigoServicio}-${v.codigoPrestacion}">${iconBarCode}</td>
        						<td class="d-none ${classTdRequired} td-${v.codigoServicio}-${v.codigoPrestacion}">
        							<input type="text" class="form-control" class="input-codigo" ${isRequired} codigos-rel='${JSON.stringify(codigos)}' codigoServicio-rel='${v.codigoServicio}' codigoPrestacion-rel='${v.codigoPrestacion}'>
        						</td>
        						<td class="${classTdRequired} td-${v.codigoServicio}-${v.codigoPrestacion}"><small class="fw-bold">${v.codigoPrestacion}</small> - ${v.nombrePrestacion}</td>
        						<td class="text-nowrap ${classTdRequired} td-${v.codigoServicio}-${v.codigoPrestacion}">${v.cantidad}</td>
        						<td class="text-nowrap ${classTdRequired} td-${v.codigoServicio}-${v.codigoPrestacion}" id="icon-status-${v.codigoServicio}-${v.codigoPrestacion}">${iconCompleted}</td>
        					</tr>`;
    			})
        	})
        	$('#dataPrestaciones').html(elem);
        }

        async function fillSucursales(){
        	let elem = `<option value="" disabled selected hidden>Elegir Central Médica</option>`;
        	$.each(sucursalesFiltradas, function(key, value){
        		elem += `<option value="${value.codigoSucursal}" class="text-capitalize">${value.nombreSucursal.toLowerCase()}</option>`;
        	})
        	$('#sucursal').html(elem);
        }

        function isIOS() {
            return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        }

        function generateUUIDv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                const r = (Math.random() * 16) | 0; // Genera un número aleatorio entre 0 y 15
                const v = c === 'x' ? r : (r & 0x3) | 0x8; // Asegura que el formato cumple con UUID v4
                return v.toString(16); // Convierte el número a hexadecimal
            });
        }

        function showMsg(msg,icon){
	        $.toast({
	            //heading: 'Atención',
	            text: msg,
	            icon: icon,
	            showHideTransition: 'fade',
	            position: 'top-right',
	            stack: false,
	            loader: false,
	            loaderBg: '#0071ce',
	            hideAfter: 5000,
	        });
	    }

    </script>
    <style>
        .bg-silver-light {
            background: #f2f2f2 !important;
        }
        .bg-green{
        	background: #2FCC71;
        }
        .bg-veris{
        	background: #0B62EA;
        }
        .text-veris{
        	color: #0b62ea !important;
        }
        .btn-generar:hover,
        .btn-generar:active{
        	background: #2FCC71 !important;
        	opacity: 0.9;
        }
        .btn-disabled{
        	pointer-events: none !important;
        	background: silver !important;
        }
        .td-required-empty{
        	background: #f500000f !important;
        }
    </style>
</body>

</html>