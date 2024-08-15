// var token;
var url_site = "https://www.veris.com.ec";
var url_services = "https://phantom-wsexternos.phantomx.com.ec";
var url_services_phantomx = api_url+"/"+api_war+"/v1";
var canal_origen = (window.config.subdomain == "veris") ? "VER_CMV" : "VER_PMF";
var canal_origen_2 = (window.config.subdomain == "veris") ? "VER_CMV" : "MVE_PMF";
var flagStep = false;
var virtual = false;
var infoUsuario;
var myDatepicker;
var idReservaSeparada;
var tieneConvenios = false;
var valoresPago;
var companyIdSelected;
var listDiasDisponibles;
var soloOnline = false;
var _nombrePacienteVue;
var secuenciaTransaccion = "";

var respuestaEspecialidad = null;

var steps = [
    {
		path: "/step-1",
		text: "Registrar paciente",
		index: 0,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Paso 1',
		eventLabel: '1 Registro',
		fbTrack: '<Agendamiento_Web_V2_Paso1_Registro>'
    },
    {
		path: "/step-2",
		text: "Ciudad",
		index: 1,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Paso 2',
		eventLabel: '2 Ciudad',
		fbTrack: '<Agendamiento_Web_V2_Paso2_Ciudad>'
    },
    {
		path: "/step-3",
		text: "Especialidad",
		index: 2,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Paso 3',
		eventLabel: '3 Especialidad',
		fbTrack: '<Agendamiento_Web_V2_Paso3_Especialidad>'
    },
    {
		path: "/step-4",
		text: "Central médica",
		index: 3,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Paso 4',
		eventLabel: '4 Central Médica',
		fbTrack: '<Agendamiento_Web_V2_Paso4_Central>'
	},
    {
		path: "/step-5",
		text: "Detalles de la cita",
		index: 4,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Paso 5',
		eventLabel: '5 Detalles Cita',
		fbTrack: '<Agendamiento_Web_V2_Paso5_Detalles>'
    },
    {
		path: "/step-6",
		text: "Confirmación de datos",
		index: 5,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Paso 6',
		eventLabel: '6 Confirmación',
		fbTrack: '<Agendamiento_Web_V2_Paso6_Confirmación>'
    },
    {
		path: "/step-7",
		text: "Pago",
		index: 6,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Pasarela de pago',
		eventLabel: 'Intento de Pago',
    },
    {
		path: "/usuario-invalido",
		text: "Usuario no encontrado",
		index: 7,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Usuario no encontrado',
		eventLabel: '1 No existe Usuario',
		fbTrack: '<Agendamiento_Web_V2_Paso1_Usuario_no_encontrado>'
    },
    {
		path: "/abrir-popup",
		text: "Abrir Popup",
		index: 8,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Popup registro abierto',
		eventLabel: '1 Popup registro abierto',
		fbTrack: '<Agendamiento_Web_V2_Paso1_Popup_registro_abierto>'
    },
    {
		path: "/usuario-registrado",
		text: "Usuario Registrado",
		index: 9,
		eventCategory: 'Agendamiento Web V2',
		eventAction: 'Usuario Registrado',
		eventLabel: '1 Usuario Registrado',
		fbTrack: '<Agendamiento_Web_V2_Paso1_Usuario_registrado>'
    }
  ];
$( document ).ready(async function() {
	getTiposIdentificacion();
	await getPaisesRegistro();
	await getProvinciasRegistro();

	$('body').on('change', '#paisRegistro', async function(){
		let codigoPais = $(this).val();
		let codigoProvincia = $('#provinciaRegistro option:selected').val();
        $('#ciudadRegistro').empty();
	  	await getProvinciasRegistro(codigoPais);
	  	if($('#pais option:selected').attr('esDefault-rel') != "true"){
	  		console.log('NO REQUIRED')
	  		$('#provinciaRegistro').removeClass('required');
	  		$('#ciudadRegistro').removeClass('required');
			// $('.label-provincia').html('Provincia');
			// $('.label-ciudad').html('Ciudad');
	  	}else{
	  		console.log('REQUIRED')
	  		$('#provinciaRegistro').addClass('required');
	  		$('#ciudadRegistro').addClass('required');
	  		// $('.label-provincia').html('Provincia *');
			// $('.label-ciudad').html('Ciudad *');
	  	}
	});

	getParamsNuvei();
	$('body').on("click", '.box-central', function(){
		$('.box-central').removeClass("colorSel");
		$(this).addClass("colorSel");
	});
	
	if(window.location.href.split("#").length == 2 ){
        soloOnline = true;
        $('.hidden-presencial').hide();
    }

    gtag('event', 'link_click', {
	    event_category: steps[0].eventCategory,
	    event_action: steps[0].eventAction,
	    event_label: steps[0].eventLabel
	});

	$("#wizard").steps({
	    headerTag: "h2",
	    bodyTag: "section",
	    transitionEffect: "fade",
	    stepsOrientation: "vertical",
		    labels: {
	        current: "paso actual:",
	        pagination: "Paginación",
	        finish: "Pagar Cita Médica",
	        next: "Continuar <i class='icon-next fa fa-angle-right'></i>",
	        previous: "<i class='icon-next fa fa-angle-left'></i> Regresar",
	        loading: "Cargando..."
	    },
	    onStepChanging: function (event, currentIndex, priorIndex) {
	    	//doActionStep(priorIndex);
	    	//console.log('Origen: '+currentIndex);
	    	//console.log('Destino: '+priorIndex);
	    	$('#buscarEspecialidad').val("");
			$('#buscarCentral').val("");
	    	if( currentIndex > priorIndex ){
	    		$('.steps .current').nextAll().removeClass('done').addClass('disabled');
				if(currentIndex == 5){
					$('a[href$="previous"]').text('Regresar');
					$('a[href$="next"]').html("Continuar <i class='icon-next fa fa-angle-right'></i>");
					$('a[href$="next"]').removeClass('btnConfirmar');
				}
				if(currentIndex == 4 && priorIndex == 3){
					//console.log('Retrocedio a centrales')
					$('.box-centrales').empty();
				}
				if(priorIndex < 4){
					if(myDatepicker)
						destroyCalendar();
				}
				if(currentIndex == 5 && priorIndex == 4){
					cancelarCita();
				}
				if(currentIndex == 2 && priorIndex == 1 && getValueFIByName("ciudad")!="1-25-1"){
					console.log("Mostrar modal convenios Virtual");
					//flagStep = true;obtenerEspecialidades();
				}
	    		return true;
	    	}else{
	    		if(!flagStep){
	    			doActionStep(priorIndex);
	    		}
	    	}
	    	if(flagStep){
	    		flagStep = false;
	    		return true;
	    	}else{
	    		return flagStep;
	    	}
		},
		onStepChanged:function (event, currentIndex, priorIndex) {
			console.log('currentIndex: '+currentIndex);
			console.log('priorIndex: '+priorIndex);
			$('.steps .current').nextAll().removeClass('done').addClass('disabled');
			if(currentIndex == 0){
				virtual = false;
				$('.header-patient-name').remove();
			}
			//doActionStep(priorIndex);
			if(currentIndex == 2){// && priorIndex == 1
				//console.log("Mostrar modal convenios presencial");
				//obtenerEspecialidades();
			}
			if(currentIndex == 3){// && priorIndex == 2
				console.log("198----------------")
				$('.box-centrales').empty();
				var idCiudad = getValueFIByName('ciudad');
				if(idCiudad != "1-25-1"){
					obtenerCentralMedica();
				}
			}
			if(currentIndex == 4){// && priorIndex == 3
				$('.box-disponibilidad').empty();
				obtenerFechas();
			}
			if(currentIndex == 5){// && priorIndex == 4
				$('a[href$="previous"]').text('Cambiar');
				$('a[href$="next"]').html("Continuar <i class='icon-next fa fa-angle-right'></i>");
				$('a[href$="next"]').addClass('btnConfirmar');
				//$('a[href$="next"]').text('Confirmar Cita');
				$('.txt-info').html();
				$('.subtitle.descuento').hide();
				showLoader();
				mostrarInfoCita();
				separarCita();
				//validarTurno();
				//obtenerConvenios();
				//valorizarCita();
			}
			if(currentIndex == 6){
				$('a[href$="previous"]').hide();
				$('.actions ul li:first-child').remove();
				$('.actions ul li.disabled').remove();
				$('a[href$="finish"]').addClass('btnPagar');	// Aqui OCUALTAR EL BOTON
				$('a[href$="finish"]').hide();
				$('ul[role="tablist"]').css("pointer-events","none");
			}

			/*if(currentIndex < priorIndex && (currentIndex == 2 || currentIndex == 3 || currentIndex == 4 )){
				flagStep = true;
			}*/
			
			/*Saltarse el paso*/
			if(currentIndex == 3 && virtual && priorIndex == 2){
				flagStep = true;
				$('.box-centrales').empty();
				$('#wizard').steps("next");
			}

			/*Saltarse el paso al volver*/
			if(currentIndex == 3 && virtual && priorIndex == 4){
				$('.box-centrales').empty();
				$('.box-disponibilidad').empty();
				$('#wizard-t-2').trigger('click');
			}

			if(currentIndex > priorIndex){
				if(currentIndex != 6){
					fbq('track', steps[currentIndex-1].fbTrack);
		    		fbq('track', 'PageView');
		    		console.log('Fb step');
		    	}else{
		    		console.log('Fb valor');
		    	}

	    		gtag('event', 'link_click', {
				    event_category: steps[currentIndex-1].eventCategory,
				    event_action: steps[currentIndex-1].eventAction,
				    event_label: steps[currentIndex-1].eventLabel
				});
			}

		}
	});
	renderHtml();

	$('.title-home').html('Cita médica <img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/doctor-veris.png" style="margin-bottom: 10px;">');
	$('.title-confirmacion').prepend('<img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/svg/Icono-Listo.svg">');
	//getTiposIdentificacion();
	//obtenerCiudades();

	//getProvinciasRegistro();

	$('body').on('change', 'select#provinciaRegistro', function() {
		console.log('cambio de provincias');
		getCiudadesRegistro();
	});

	$('body').on('click', 'a.btnPagar', function() {
		var card = $('input[name="pago"]:checked').val();
		console.log(card);
		if($('input[name="pago"]:checked').val() != null){
			gtag('event', 'link_click', {
			    event_category: steps[7].eventCategory,
			    event_action: steps[7].eventAction,
			    event_label: steps[7].eventLabel + " - " + card
			});
			var axel = Math.random() + "";
			var a = axel * 10000000000000;
			$(document.body).prepend('<img style="height:1px;position:absolute;z-index:-1;" src="https://ad.doubleclick.net/ddm/activity/src=11242873;type=invmedia;cat=veris00;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;tfua=;npa=;gdpr=${GDPR};gdpr_consent=${GDPR_CONSENT_755};ord=' + a + '?" width="1" height="1" alt=""/>');

			$(document.body).prepend('<noscript><img style="height:1px;position:absolute;z-index:-1;" src="https://ad.doubleclick.net/ddm/activity/src=11242873;type=invmedia;cat=veris00;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;tfua=;npa=;gdpr=${GDPR};gdpr_consent=${GDPR_CONSENT_755};ord=1?" width="1" height="1" alt=""/></noscript>');

			$.getScript("https://secure.adnxs.com/px?id=1512381&t=1");
			gtag('event', 'conversion', {
                'send_to': 'AW-315657039/UPtOCP-WnboDEM-WwpYB',
                'event_callback': callback
            });
			if(card != "diners"){
				//Kushki
				var formKushkiElem = '<form id="kushki-payment-form" action="' + url_site + '/pago-online/" method="GET"><input type="hidden" name="numeroIdentificacion" value="'+getValueFI('numeroIdentificacion')+'" /><input type="hidden" name="tipoIdentificacion" value="'+getValueFI('tipoIdentificacion')+'" /><input type="hidden" name="codArticulo" value="'+idReservaSeparada+'" /><input type="hidden" name="tipoArticulo" value="CITA" /></form>';
				$('.modal-pagos .footer').append(formKushkiElem);
				console.log('KUSHKI');
				$('#kushki-payment-form').submit();
			}else{
				//Ptp
				var formPtpElem = '<form id="diners-payment-form" action="' + url_site + '/pago-online-ptp/" method="GET"><input type="hidden" name="numeroIdentificacion" value="'+getValueFI('numeroIdentificacion')+'" /><input type="hidden" name="tipoIdentificacion" value="'+getValueFI('tipoIdentificacion')+'" /><input type="hidden" name="codArticulo" value="'+idReservaSeparada+'" /><input type="hidden" name="tipoArticulo" value="CITA" /></form>';
				$('.modal-pagos .footer').append(formPtpElem);
				console.log('PTP');
				$('#diners-payment-form').submit();
			}
		}else{
			showError("Selecciona tu tarjeta de Débito o Crédito de preferencia.");
		}
	});

	$('body').on('change', 'input[name="pago"]', function() {
	    var card = $(this).val();
	    $('.btn_card').removeClass('card_selected');
	    $('.btn_card_'+card).addClass('card_selected');
	});

	$('body').on('click', 'input[name="ciudad"]', function() {
		console.log($(this).val());
		if( $(this).val() != "1-25-1" ){
			//flagStep = true;
			virtual = false;
		}else{
			//flagStep = false;
			virtual = true;
		}
	});

	$('.btn-cancelar-registro').click(function(){
		$('.modal-registro-paciente').modal('hide');
	});

	$('.btn-omitir').click(function(){
		//console.log('OMITIR');
		$('.modal-motivo-online').modal('hide');
		flagStep = true;
		setTimeout(function(){
			$('#wizard').steps("next");
		},250);
	});

	$('.btn-omitir-last').click(function(){
		//console.log('OMITIR');
		$('.modal-motivo-presencial').modal('hide');
		flagStep = true;
	});

	$('.btn-guardar-motivo').click(function(){
		showLoader();
		console.log('GUARDAR MOTIVO ONLINE');
		var motivo = getValueFI('motivo');
		if(motivo.length > 0){
			$('.modal-motivo-online').modal('hide');
			flagStep = true;
			//guardarMotivo();
			setTimeout(function(){
				hideLoader();
				$('#wizard').steps("next");
			},500);
		}else{
			hideLoader();
			showError('El Campo Motivo de Consulta es obligatorio');
		}
	});

	$('#tipoIdentificacion').change(function(){
		if($(this).val() == "3"){
			$('#numeroIdentificacion').attr('type','text');
		}else{
			$('#numeroIdentificacion').attr('type','number');
		}
	});

	$('#tipoIdentificacionRegistro').change(function(){
		if($(this).val() == "3"){
			$('#numeroIdentificacionRegistro').attr('type','text');
		}else{
			$('#numeroIdentificacionRegistro').attr('type','number');
		}
	});

	$('.btn-registrar').click(function(){
		$(this).prop('disabled', true);
		showLoader();
		var flagValidation = true;
		var flagValidationEmail = true;
		var flagNumeroIdentificacionRegistro = true;
		var tipoIdentificacionRegistro = $('#tipoIdentificacionRegistro').val();
		var numeroIdentificacionRegistro = $('#numeroIdentificacionRegistro').val().toUpperCase();
		var primerApellido = $('#primerApellido').val();
		var segundoApellido = $('#segundoApellido').val();
		var primerNombre = $('#primerNombre').val();
		var segundoNombre = $('#segundoNombre').val();
		var fechaNacimiento = $('#fechaNacimiento').val();
		var genero = $('#genero').val();
		var provinciaRegistro = $('#provinciaRegistro').val();
		var ciudadRegistro = $('#ciudadRegistro').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();

		var fechNac = fechaNacimiento.split("-");
		var fechNacFormated = fechNac[2]+"/"+fechNac[1]+"/"+fechNac[0];

		var pais = $('#provinciaRegistro option:selected').attr("pais-rel");
		var region = $('#provinciaRegistro option:selected').attr("region-rel");
		var msg_error = "";

		if(primerApellido.length<1 || segundoApellido.length<1 || primerNombre.length<1 || segundoNombre.length<1 || telefono.length<1 || genero == null || provinciaRegistro == null || ciudadRegistro == null || tipoIdentificacionRegistro == null || fechaNacimiento==""){
			flagValidation = false;
			msg_error = msg_error + "</br>Campos incompletos.";
		}

		if(!isValidEmailAddress(email)){
			flagValidationEmail = false;
			msg_error = msg_error + "</br>Email incorrecto.";
		}

		if(getValueFI('tipoIdentificacionRegistro') == "2"){
			flagNumeroIdentificacionRegistro = validarCedula(getValueFI('numeroIdentificacionRegistro'));
			if(!flagNumeroIdentificacionRegistro)
				msg_error = msg_error + "</br>Número de identificación inválida.";
		}

		hideLoader();

		if(flagValidation && flagValidationEmail && flagNumeroIdentificacionRegistro){
			//var method = "/MaruriWsrest/servicio/registro/crearusuarioveris";
			var method = "/seguridad/cuenta";
			var param = "?arg0="+tipoIdentificacionRegistro+"&arg1="+numeroIdentificacionRegistro+"&arg2="+primerApellido+"&arg3="+segundoApellido+"&arg4="+primerNombre+"&arg5="+segundoNombre+"&arg6="+fechNacFormated+"&arg7="+email+"&arg8="+genero+"&arg9="+pais+"&arg10="+provinciaRegistro+"&arg11="+ciudadRegistro+"&arg12="+region+"&arg13="+telefono;
			var settings = {
				"url": url_services_phantomx+method+param,
				"method": "POST",
				"timeout": 0,
				"headers": {
					"Content-Type": "application/json",
					"Authorization": "Bearer "+token
				},
				"data": JSON.stringify({
					"tipoIdentificacion": tipoIdentificacionRegistro,
					"numeroIdentificacion": numeroIdentificacionRegistro,
					"primerApellido": primerApellido,
					"segundoApellido": segundoApellido,
					"primerNombre": primerNombre,
					"segundoNombre": segundoNombre,
					"mail": email.toLowerCase(),
					"fechaNacimiento": fechNacFormated,
					"genero": genero,
					"telfMovil": telefono,
					"codPais": pais,
					"codigoProv": provinciaRegistro,
					"codigoCiudad": ciudadRegistro,
					"canalOrigenDigital": canal_origen
				}),
			};
			$.ajax(settings).done(function (response) {
				console.log(response);
				$('.btn-registrar').prop('disabled', false);
				$('.modal-motivo-presencial').modal('hide');
				if(response.code != 200){
					showError('Error de registro: '+response.message);
				}else{
					$('.form-registro').find('input').val("");
					fbq('track', 'CompleteRegistration');
					gtag('event', 'conversion', {
			            'send_to': 'AW-315657039/DY4TCO253OsCEM-WwpYB',
			            'event_callback': callback
			        });
					$('.modal-registro-paciente').modal('hide');
					showError('Usuario registrado exitosamente');
					$('#tipoIdentificacion').val(tipoIdentificacionRegistro).trigger('change');
					$('#numeroIdentificacion').val(numeroIdentificacionRegistro);
					//obtenerUsuario();
					gtag('event', 'link_click', {
					    event_category: steps[9].eventCategory,
					    event_action: steps[9].eventAction,
					    event_label: steps[9].eventLabel
					});
					
					/*$.ajax({
					    url: path_embudo+"js/tracking/registro.html",
					    success: function(newhtml){
					        console.log(newhtml);
					    }
					});*/
					var axel = Math.random() + "";
					var a = axel * 10000000000000;
					$(document.body).prepend('<img style="height:1px;position:absolute;z-index:-1;" src="https://ad.doubleclick.net/ddm/activity/src=11242873;type=invmedia;cat=veris0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;tfua=;npa=;gdpr=${GDPR};gdpr_consent=${GDPR_CONSENT_755};ord=' + a + '?" width="1" height="1" alt=""/>');
					$(document.body).prepend('<noscript><img style="height:1px;position:absolute;z-index:-1;" src="https://ad.doubleclick.net/ddm/activity/src=11242873;type=invmedia;cat=veris0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;tfua=;npa=;gdpr=${GDPR};gdpr_consent=${GDPR_CONSENT_755};ord=1?" width="1" height="1" alt=""/></noscript>');

					$.getScript("https://secure.adnxs.com/px?id=1512371&t=1");

				}
			}).fail(function (err) {
				showError('Error de registro: '+err.responseJSON.message);
				$('.btn-registrar').prop('disabled', false);
			});
		}else{
			$('.btn-registrar').prop('disabled', false);
			showError('Datos incorrectos: '+msg_error);
		}
	});

	$('.btn-guardar-motivo-presencial').click(function(){
		console.log('GUARDAR MOTIVO PRESENCIAL');
		var motivo = getValueFI('motivo-presencial');
		if(motivo.length > 0){
			$('.modal-motivo-presencial').modal('hide');
			flagStep = true;
			guardarMotivo();
		}else{
			showError('El Campo Motivo de Consulta es obligatorio');
		}
	});

	$('.btn-continuar-convenio').click(function(){
		console.log('SELECCIONO CONVENIO');
		if($('#convenios').find('option:selected').attr('permiteReserva-rel') == "N"){
			showError($('#convenios').find('option:selected').attr('mensajeBloqueoReserva-rel'));
			return;
		}

		flagStep = true;
		$('.modal-convenio').modal('hide');
		if($("#convenios").css('display') == 'none'){
			tieneConvenios = false;
		}
		var idCiudad = getValueFIByName('ciudad');
		if(idCiudad === "1-25-1"){
			//AQUI MIGUEL: preguntar si la ciudad elegida es == 1-25-1 cambias a Cita medica virtual con su respectivo icono
			// $('.tipo-cita').html('Cita médica virtual <i class="icon-step fa fa-slod fa-laptop fa-fw" style="color: #6A7D8E !important; font-size: 24px;"></i>');
			$('.tipo-cita').html('Cita médica virtual <img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/laptop-veris.png">');
		}else{
			$('.tipo-cita').html('Cita médica presencial <img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/doctor-veris.png">');
		}

		setTimeout(function(){
			$('#wizard').steps("next");
		},250);
	});

	$('.btn-continuar-especialidad').click(function(){
		console.log('He respondido la pregunta en la especialidad');
		$('.btn-continuar-especialidad').removeClass('respuesta-seleccionada')
		$(this).addClass('respuesta-seleccionada')
		$('.modal-pregunta-especialidad').modal('hide');
		respuestaEspecialidad = $(this).attr("data-rel");
		flagStep = true;

		setTimeout(function(){
			$('#wizard').steps("next");
		},250);
	});

	$('.btn-entendido-validacion-fecha').click(function(){
		$('.modal-validacion-fecha').modal('hide');
	});

	$('.btn-precio-confirmacion-datos').click(function(){
		$('.modal-precio-confirmacion-datos').modal('hide');
	});

	$('body').on('change', 'input[name="ciudad"]', function() {
		$('.box-especialidades').empty();
	});

	$('body').on('change', 'input[name="especialidad"]', function() {
		//flagStep = true;
		$('.box-centrales').empty();
	});

	$('body').on('change', 'input[name="central"]', function() {
		flagStep = true;
		$('.box-disponibilidad').empty();
	});

	$('body').on('click', 'div.box-individual', function() {
		$('.box-individual').removeClass('box-individual-selected');
		$(this).addClass('box-individual-selected');
		flagStep = true;
	});


	/*Nuvei*/
	$('body').on('click', '#btnNuvei', function() {
		/*if(referenceNuvei == ''){
			pagarNuvei();
		}else{
			pasarelaNuvei();
		}*/
		pagarNuvei();
	})

	$('#convenios').change(function(){
		var aplicaCobertura = $(this).find('option:selected').attr('aplicaCobertura-rel');
		var codigoConvenio = $(this).val();
		//valorizarCita(aplicaCobertura,codigoConvenio);
	});

	$("#tieneConvenio").change(function() {
	    if(this.checked && !tieneConvenios) {
	        //showError("No dispone de Convenios.");
	        //$("#tieneConvenio").prop('checked', false);
	        obtenerConvenios();
	    }

	    if(this.checked && tieneConvenios) {
	    	/*var aplicaCobertura = $('#convenios').find('option:selected').attr('aplicaCobertura-rel');
			var codigoConvenio = $('#convenios').val();
			valorizarCita(aplicaCobertura,codigoConvenio);*/
	        $('#convenios').show();
	    }

	    if(!this.checked) {
	    	$('#convenios').hide();
	    	tieneConvenios = false;		// tenia una s de mas.
	        //valorizarCita('S', 'NA');
	    }
	});

	$('body').on('click', 'img.btn-ptp', function() {
		console.log("Enviar PTP");
		$('#diners-payment-form').submit();
	});

	$('body').on('click', 'img.btn-kushki', function() {
		console.log("Enviar Kushki");
		$('#kushki-payment-form').submit();
	});

	$('body').on('click', 'a.btn-pagar', function() {
		console.log('modal de pagos');
		$('.modal-pagos').modal('show');
	});

	jQuery('body').on('change','#terminos-exc', function(){
		console.log(0)
        if(jQuery("#terminos-exc").is(':checked')){
			console.log(1)
            $('.btnConfirmar').removeClass("btnConfirmar-dis")
        }else{
			console.log(2)
            $('.btnConfirmar').addClass("btnConfirmar-dis")
        }
    })

	//listDiasDisponibles

	$('.label-cambio-fecha').click(function(){
		myDatepicker.show()
	});

	var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    if(dd < 10){
    	dd = "0"+dd;
    }
    if(mm < 10){
    	mm = "0"+mm;
    }
    $('.box-dia').html(dd);
	$('.box-mes').html(letrasMes(mm));
	//https://stackoverflow.com/questions/1890418/datepicker-for-web-page-that-can-allow-only-specific-dates-to-be-clicked

	$('#buscarEspecialidad').keyup(function(){
	    $('.box-especialidades .control').attr('style', 'display: none !important');

	    var txt = $('#buscarEspecialidad').val();
	    if(txt == ''){
	        $('.box-especialidades .control').attr('style', 'display: inline-block !important');
	    }else{
	        $('.box-especialidades .control').each(function(){
	            if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
	                $(this).attr('style', 'display: inline-block !important');;
	            }
	        });
	    }
	});

	$('#buscarCentral').keyup(function(){
	    $('.box-centrales .control').attr('style', 'display: none !important');

	    var txt = $('#buscarCentral').val();
	    if(txt == ''){
	        $('.box-centrales .control').attr('style', 'display: inline-block !important');
	    }else{
	        $('.box-centrales .control').each(function(){
	            if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
	                $(this).attr('style', 'display: inline-block !important');;
	            }
	        });
	    }
	});

	jQuery('body').on('change','input[type=checkbox][name=nombreTipoObjetoCheck]',function() {
		if(jQuery(this).is(':checked')){
			jQuery('.btnConfirmar').removeAttr('disabled', 'disabled');
			jQuery(".btnConfirmar").removeClass("disabled-vue");
	   	}else{
			jQuery('.btnConfirmar').attr('disabled', 'disabled');
			jQuery(".btnConfirmar").addClass("disabled-vue");
		}
	});

});

async function getPaisesRegistro(){
	var method = "/seguridad/paises";	
	var settings = {
		"url": url_services_phantomx+method,
		"method": "GET",
		"timeout": 0,
		"headers": {
			//"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		if(response.code == 200){
			$.each(response.data, function(key, value){
				if(value.codigoProvincia != 25){
					$('#paisRegistro').append(`<option esDefault-rel='${value.esDefault}' ${ (value.esDefault) ? 'selected' : '' } value="${value.codigoPais}">${value.nombrePais}</option>`);
				}
			});
		}else{
			showError('Provincias no Cargadas, por favor intente en unos momentos');
		}
	});
}

function pad(n){
	return n<10 ? '0'+n : n
}

function renderHtml(){
	$('.steps').prepend('<img class="logo logo-desktop" src="/assets/img/'+window.config.subdomain+'/logo-'+window.config.subdomain+'-citas.png">');
	$('.steps').prepend('<img class="logo logo-mobile" src="/assets/img/'+window.config.subdomain+'/logo-'+window.config.subdomain+'-mobile-citas.png">');
	//$('.content.clearfix').prepend('<div class="advertisement">HEMOS IMPLEMENTADO PARA TU COMODIDAD Y SEGURIDAD, 5 CENTRALES MÃ‰DICAS NO COVID PARA LA ATENCIÃ“N DE TUS NIÃ‘OS, CONTROL DE EMBARAZO Y ENFERMEDADES CRÃ“NICAS COMO HIPERTENSIÃ“N, DIABETES ENTRE OTRAS. EN GUAYAQUIL: MALL DEL SOL Y EL DORADO Y EN QUITO: SAN LUIS, GRANADOS Y QUICENTRO SUR.</div>');
}

var flagCalendar = true;
var lastDate;
function setCalendar(fecha){
	console.log(fecha);
	var lstFecha = fecha.split("/");
	//myDatepicker.selectDate(new Date(lstFecha[2], parseInt(lstFecha[1])-1, parseInt(lstFecha[0])));
	myDatepicker = $('#fechaCita').datepicker({
		minDate: new Date(),
		//startDate: new Date(parseInt(lstFecha[2]), parseInt(lstFecha[1])-1, parseInt(lstFecha[0])),
		autoClose: true,
		onSelect: function(dateText, inst) {
        	//console.log(dateText);
        	//console.log(inst);
        	//var fechaElegida = dateText.split("/");
        	console.log("Cambio");
        	//if(!flagCalendar){
        		console.log({dateText});
        		console.log(inst);
	        	var fechaElegida = dateText.split("/");
	        	var dia = fechaElegida[0];
	        	$('.box-dia').html(dia);
	        	var mes = fechaElegida[1];
	        	$('.box-mes').html(letrasMes(mes));
	        	$('.box-doctor').remove();
	        	//showLoader();
	        	console.log('---'+fechaElegida);
	        	flagStep = false;
	        	if(dateText.length > 0){
	        		if($("#convenios option:selected").attr("aplicaVerificacionConvenio-rel") == "S" && tieneConvenios){
						validacionFecha(fechaElegida)
					}else{
	        			obtenerDisponibilidad(fechaElegida);
					}
	        	}
	        //}else{
        	//	console.log("no cambia");
	        //	flagCalendar = false;
	        //}
       	},
       	onRenderCell: function (date, cellType) {
	        var day = pad(date.getDate());
	        var month = pad(date.getMonth()+1);
	        var year = date.getFullYear();
	        //console.log(day);
	        //console.log(month);
	        //console.log(year);
	        //console.log(listDiasDisponibles);
	        if(jQuery.inArray(day+"/"+month+"/"+year, listDiasDisponibles) !== -1){
	        	//console.log("MUESTRA: "+day+"/"+month+"/"+year);
	        	return {
	                classes: 'fecha-habilitada',
	                disabled: false
	            }
	        }else{
	        	//console.log("NO MUESTRA: "+day+"/"+month+"/"+year);
	        	return {
	                classes: 'fecha-deshabilitada',
	                disabled: true
	            }
	        }
	    }
	}).data('datepicker');
	//   04/02/2020
	if(flagCalendar){
		var lstFecha = fecha.split("/");
		console.log(lstFecha[2], parseInt(lstFecha[1])-1, parseInt(lstFecha[0]));
		myDatepicker.selectDate(new Date(lstFecha[2], parseInt(lstFecha[1])-1, parseInt(lstFecha[0])));
	}
	$('.box-calendar').css("visibility","visible");
}

function destroyCalendar(){
	$('.box-calendar').css("visibility","hidden");
	flagCalendar = true;
	myDatepicker.destroy();
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function imgError(source) {
	console.log(source);
	source.src = "/assets/img/veris/avatar_central_medica.png";
	source.onerror = "";
	return true;
}

function letrasMes(str){
	switch(str){
		case "01":
			return "Enero";
		break;
		case "02":
			return "Febrero";
		break;
		case "03":
			return "Marzo";
		break;
		case "04":
			return "Abril";
		break;
		case "05":
			return "Mayo";
		break;
		case "06":
			return "Junio";
		break;
		case "07":
			return "Julio";
		break;
		case "08":
			return "Agosto";
		break;
		case "09":
			return "Septiembre";
		break;
		case "10":
			return "Octubre";
		break;
		case "11":
			return "Noviembre";
		break;
		case "12":
			return "Diciembre";
		break;
	}
}

function mostrarModalRegistro(){
	$('#modal-registro-paciente').modal('show');
	gtag('event', 'link_click', {
	    event_category: steps[8].eventCategory,
	    event_action: steps[8].eventAction,
	    event_label: steps[8].eventLabel
	});
}

function getTiposIdentificacion(){
	//var method = "/MaruriWsrest/servicio/citas/obtenertiposidentificacion";
	var method = "/seguridad/tiposIdentificacion";
	var settings = {
		"url": url_services_phantomx+method,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		$.each(response.data, function(key, value){
			$('#tipoIdentificacion').append('<option value="'+value.codigoTipoIdentificacion+'">'+value.nombreTipoIdentificacion+'</option>');
			$('#tipoIdentificacionRegistro').append('<option value="'+value.codigoTipoIdentificacion+'">'+value.nombreTipoIdentificacion+'</option>');
		});
	});
}

async function getProvinciasRegistro(codigoPais = 1){
	//var method = "/MaruriWsrest/servicio/registro/obtenerprovincias";
	var method = "/seguridad/provincias?codigoPais="+codigoPais;	
	var settings = {
		"url": url_services_phantomx+method,
		"method": "GET",
		"timeout": 0,
		"headers": {
			//"Authorization": "Bearer "+token
		},
	};
	console.log(url_services_phantomx+method);
	$.ajax(settings).done(async function (response) {
		if(response.code == 200){
			let tieneProvincias = false;
			$('#provinciaRegistro').empty();
			$.each(response.data, function(key, value){
				if(value.codigoProvincia != 25){
					tieneProvincias = true;
					$('#provinciaRegistro').append('<option value="'+value.codigoProvincia+'" pais-rel="'+value.codigoPais+'" region-rel="'+value.codigoRegion+'">'+value.nombreProvincia+'</option>');
				}
			});

			if(tieneProvincias){
	            console.log('Tiene provincias');
	            $('#provinciaRegistro').removeClass('disabled-input');
	            await getCiudadesRegistro(codigoPais,$('#provinciaRegistro option:selected').val());
	        }else{
	            console.log('No tiene provincias');
	            $('#provinciaRegistro').addClass('disabled-input')
	            $('#ciudadRegistro').addClass('disabled-input')
	        }
		}else{
			showError('Provincias no Cargadas, por favor intente en unos momentos');
		}
	});
}

function getCiudadesRegistro(codigoPais = 1, codigoProvincia){
	$('#ciudadRegistro').empty();
	var idProvincia = $('#provinciaRegistro option:selected').val();
	
	// var method = "/MaruriWsrest/servicio/registro/obtenerciudades";
	// var param = "?arg0=1&arg1="+idProvincia
	var method = "/seguridad/ciudades";
	var param = "?codigoPais="+codigoPais+"&codigoProvincia="+idProvincia;
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		//console.log(response.data);
		if(response.code == 200){
			let tieneCiudades = false;
			$.each(response.data, function(key, value){
				tieneCiudades = true;
				$('#ciudadRegistro').append('<option value="'+value.codigoCiudad+'">'+value.nombreCiudad+'</option>');
			});
			if(tieneCiudades){
	            console.log('Tiene ciudades');
	            $('#ciudadRegistro').removeClass('disabled-input');
	        }else{
	            console.log('No tiene ciudades');
	            $('#ciudadRegistro').addClass('disabled-input')
	        }
		}else{
			showError('Ciudades no Cargadas, por favor intente en unos momentos');
		}
	});
}

function validarCedula(cedula){
	var cad = cedula.trim();
	var total = 0;
	var longitud = cad.length;
	var longcheck = longitud - 1;

	if (cad !== "" && longitud === 10){
		for(i = 0; i < longcheck; i++){
			if (i%2 === 0) {
				var aux = cad.charAt(i) * 2;
				if (aux > 9) aux -= 9;
				total += aux;
			} else {
				total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
			}
		}

		total = total % 10 ? 10 - total % 10 : 0;

		if (cad.charAt(longitud-1) == total) {
			//document.getElementById("salida").innerHTML = ("Cedula Válida");
			return true;
		}else{
			//document.getElementById("salida").innerHTML = ("Cedula Inválida");
			return false;
		}
	}

	return false;

}

function validarCedulaOld(cedula){
	if(cedula.length == 10){
        
        //Obtenemos el digito de la region que sonlos dos primeros digitos
        var digito_region = cedula.substring(0,2);
        
        //Pregunto si la region existe ecuador se divide en 24 regiones
        if( digito_region >= 1 && digito_region <=24 ){
          
          // Extraigo el ultimo digito
          var ultimo_digito   = cedula.substring(9,10);

          //Agrupo todos los pares y los sumo
          var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));

          //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
          var numero1 = cedula.substring(0,1);
          var numero1 = (numero1 * 2);
          if( numero1 > 9 ){ var numero1 = (numero1 - 9); }

          var numero3 = cedula.substring(2,3);
          var numero3 = (numero3 * 2);
          if( numero3 > 9 ){ var numero3 = (numero3 - 9); }

          var numero5 = cedula.substring(4,5);
          var numero5 = (numero5 * 2);
          if( numero5 > 9 ){ var numero5 = (numero5 - 9); }

          var numero7 = cedula.substring(6,7);
          var numero7 = (numero7 * 2);
          if( numero7 > 9 ){ var numero7 = (numero7 - 9); }

          var numero9 = cedula.substring(8,9);
          var numero9 = (numero9 * 2);
          if( numero9 > 9 ){ var numero9 = (numero9 - 9); }

          var impares = numero1 + numero3 + numero5 + numero7 + numero9;

          //Suma total
          var suma_total = (pares + impares);

          //extraemos el primero digito
          var primer_digito_suma = String(suma_total).substring(0,1);

          //Obtenemos la decena inmediata
          var decena = (parseInt(primer_digito_suma) + 1)  * 10;

          //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
          var digito_validador = decena - suma_total;

          //Si el digito validador es = a 10 toma el valor de 0
          if(digito_validador == 10)
            var digito_validador = 0;

          //Validamos que el digito validador sea igual al de la cedula
          if(digito_validador == ultimo_digito){
            //console.log('la cedula:' + cedula + ' es correcta');
            return true;
          }else{
            //console.log('la cedula:' + cedula + ' es incorrecta');
            return false;
          }
          
        }else{
          // imprimimos en consola si la region no pertenece
          //console.log('Esta cedula no pertenece a ninguna region');
          return false;
        }
     }else{
        //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
        //console.log('Esta cedula tiene menos de 10 Digitos');
        return false;
     }
}

function obtenerUsuario(){
	$('.header-patient-name').remove();
	var flagNumeroIdentificacion = true;
	if(getValueFI('tipoIdentificacion') == "2"){
		var flagNumeroIdentificacion = validarCedula(getValueFI('numeroIdentificacion'));
	}
	if(flagNumeroIdentificacion && getValueFI('numeroIdentificacion').length > 0){
		showLoader();
		//var method = "/MaruriWsrest/servicio/citas/obtenerusuario";
		var method = "/seguridad/cuenta";
		var param = "?tipoIdentificacion="+getValueFI('tipoIdentificacion')+"&numeroIdentificacion="+getValueFI('numeroIdentificacion').toUpperCase()+"&canalOrigen="+canal_origen;
		var settings = {
			"url": url_services_phantomx+method+param,
			"method": "GET",
			"timeout": 0,
			"headers": {
				"Authorization": "Bearer "+token
			},
		};
		$.ajax(settings).done(function (response) {
			//hideLoader();
			if(response.code == 200 && response.data != null){
				infoUsuario = response.data;
				getPolitics();
				//preguntarMotivoUsuario();
				_nombrePacienteVue = infoUsuario.primerNombre;
				obtenerCiudades();
				$('.content.clearfix').prepend('<div class="header-patient-name">Paciente: '+infoUsuario.primerNombre + ' '+infoUsuario.primerApellido+'</div>');
				//obtenerConvenios();
				//$('.modal-convenio').modal('show');
				flagStep = true;
				$('#wizard').steps("next");
			}else{
				gtag('event', 'link_click', {
				    event_category: steps[7].eventCategory,
				    event_action: steps[7].eventAction,
				    event_label: steps[7].eventLabel
				});
				hideLoader();
				showError('Usuario incorrecto, por favor verifica tu identificación');
			}		
		});
	}else{
		showError('Número de identificación incorrecto');
		gtag('event', 'link_click', {
		    event_category: steps[7].eventCategory,
		    event_action: steps[7].eventAction,
		    event_label: steps[7].eventLabel
		});
	}
}

var mostrarModalMotivoPresencial = false;
function preguntarMotivoUsuario(){
	//2-0923796304?arg0=
	if(virtual){
		var method = "/Verisrest/v1/externo/cita/aplicaMotivo/"+getValueFI('tipoIdentificacion')+"-"+getValueFI('numeroIdentificacion')+"?arg0="+idReservaSeparada;
	}else{
		var method = "/Verisrest/v1/externo/cita/aplicaMotivo/"+getValueFI('tipoIdentificacion')+"-"+getValueFI('numeroIdentificacion')+"?arg0=";
	}
	var settings = {
		"url": url_services+method,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};

	$.ajax(settings).done(function (response) {
		console.log(response.aplicaMotivo);
		if(response.aplicaMotivo == "S"){
			$('.btn-omitir').hide();
			$('.btn-omitir-last').hide();
			mostrarModalMotivoPresencial = true;
		}else{
			$('.btn-omitir').show();
			$('.btn-omitir-last').show();
		}
	});
}

function guardarMotivo(){
	// if(virtual){
	// 	var motivo = getValueFI('motivo');
	// }else{
	// 	var motivo = getValueFI('motivo-presencial');
	// }
	var motivo = getValueFI('motivo-presencial');

	var method = "/Verisrest/v1/externo/cita/motivo";
	var settings = {
		"url": url_services+method,
		"method": "PUT",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
			"idReserva": idReservaSeparada,
			"motivoConsultaPcte": motivo
		}),
	};

	$.ajax(settings).done(function (response) {
		console.log(response);
		if(!virtual){
			showError('Gracias por responder');
		}
	});
}

function obtenerCiudades(){
	showLoader();
	$('.box-presencial').empty();
	$('.box-online').empty();
	var method = "/Verisrest/v1/externo/ciudades";
	var method = "/agenda/ciudades";
	var params = "?codigoEmpresa=1&excluyeVirtual=false&canalOrigen="+canal_origen;
	var settings = {
		"url": url_services_phantomx+method+params,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		hideLoader();
		$.each(response.data, function(key, value){
			let idCiudad = value.codigoPais+"-"+value.codigoProvincia+"-"+value.codigoCiudad;
			var radioBtn = '<label class="control control-radio">'+value.nombreCiudad+'<input type="radio" name="ciudad" value="'+idCiudad+'" nombreCiudad-rel="'+value.nombreCiudad+'" /><div class="control_indicator"></div>';
			if(idCiudad != "1-25-1"){
    			$('.box-presencial').append(radioBtn);
			}else{
				$('.tieneModalidadOnline').removeClass('d-none');
				$('.box-online').append(radioBtn);
			}
		});			
	});
}

function obtenerEspecialidades(){
	//showLoader();
	$('#motivo').val();
	$('.box-especialidades').empty();
	var idCiudad = getValueFIByName('ciudad');
	var online = 'N';

	if(idCiudad == "1-25-1"){
		var online = 'S';
	}

	//var method = "/Verisrest/v1/externo/especialidades";
	//var param = "?arg0="+idCiudad+"&arg1="+online;
	var pais = idCiudad.split('-')[0];
	var provincia = idCiudad.split('-')[1];
	var ciudad = idCiudad.split('-')[2];

	var method = "/agenda/especialidades";
	var param = "?online="+online+"&codigoEmpresa=1&codigoPais="+pais+"&codigoProvincia="+provincia+"&codigoCiudad="+ciudad+"&canalOrigen="+canal_origen;

	/*var method = "/app-backend-service/v2/reservas/especialidades";
	if(idCiudad == "1-25-1"){
		var param = "?online="+online+"&codigoEmpresa=1&plataforma=WEB&codigoCiudad="+idCiudad;
	}else{
		var param = "?online="+online+"&codigoEmpresa=1&plataforma=WEB";
	}*/
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		//hideLoader();
		$.each(response.data, function(key, value){
			var radioBtn = '<label class="control control-radio">'+value.nombre+'<input type="radio" name="especialidad" codigoTipoAtencion-rel="'+value.codigoTipoAtencion+'" codigoEmpresa-rel="'+value.codigoEmpresa+'" codigoPrestacion-rel="'+value.codigoPrestacion+'" codigoServicio-rel="'+value.codigoServicio+'" nombreEspecialidad-rel="'+value.nombre+'" value="'+value.codigoEspecialidad+'" /><div class="control_indicator"></div>';
    		$('.box-especialidades').append(radioBtn);
		});			
	});

}

function validacionConvenio(){
	var method = "/comercial/validacionConvenio";

	var settings = {
		"url": url_services_phantomx+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
			"idCliente": $("#convenios option:selected").attr("idCliente-rel"),
			"codigoEspecialidad": parseInt($('input[name="especialidad"]:checked').val()),
			"idPaciente": parseInt(infoUsuario.numeroPaciente),
			"codigoTipoAtencion": $('input[name="especialidad"]:checked').attr("codigoTipoAtencion-rel")
		}),
	};
	$.ajax(settings).done(function (response) {
		hideLoader();
		console.log(response);
		if(response.code == 200){
			respuestaEspecialidad = null;
			if(response.data.requiereControlEmbarazo){
				$('.modal-pregunta-especialidad').modal('show');
			}else{
				console.log(99)
				flagStep = true;
				setTimeout(function(){
					$('#wizard').steps("next");
				},250);
			}
		}
	});//agregar fail
}

function validacionFecha(fechaElegida){
	var method = "/comercial/validacionFecha";

	var settings = {
		"url": url_services_phantomx+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
			"idCliente": $("#convenios option:selected").attr("idCliente-rel"),
			"fechaSeleccionada": $('#fechaCita').val()
		}),
	};
	$.ajax(settings).done(function (response) {
		hideLoader();
		console.log(response);
		if(response.code == 200){
			if(response.data.mensajeValidacion1 != null){
				//mostrar mensaje
				if(response.data.aplicaCondicionesSeguro){
					$('.box-disponibilidad').empty();
				}
				let msg = response.data.mensajeValidacion1+"<br>"+response.data.mensajeValidacion2;
				$('.modal-validacion-fecha .subtitle').html(msg.replace(/\*(.*?)\*/g, '<b class="text-veris">$1</b>'));
				$('.modal-validacion-fecha').modal('show');
			}else{
				obtenerDisponibilidad(fechaElegida);
			}
		}
	});//agregar fail
}

function obtenerCentralMedica(){
	showLoader();
	$('.box-centrales').empty();
	var idCiudad = getValueFIByName('ciudad');
	var idEspecialidad = getValueFIByName('especialidad');
	var codigoEmpresa = 1;//$('input[name="especialidad"]:checked').attr("codigoEmpresa-rel");

	var pais = idCiudad.split('-')[0];
	var provincia = idCiudad.split('-')[1];
	var ciudad = idCiudad.split('-')[2];
	
	//var method = "/Verisrest/v1/externo/centros";
	var method = "/agenda/centrosmedicos";
	var param = "?codigoEspecialidad="+idEspecialidad+"&codigoEmpresa="+codigoEmpresa+"&codigoProvincia="+provincia+"&codigoPais="+pais+"&codigoCiudad="+ciudad+"&mostrarSucursalPrioritaria=true&canalOrigen="+canal_origen;
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		hideLoader();
		$.each(response.data, function(key, value){
			let img_centroMedico  = '';
			if (value.nombre_foto != null) {
				img_centroMedico = "<img src='"+value.nombre_foto+"' onerror='imgError(this)' class='img-fluid w-50' alt='"+value.nombreSucursal+"'>";
				// img_centroMedico  = "<img src='"+value.nombre_foto+"' onerror='imgError(this)' class='img-fluid' style='border-radius: 10px;'>";
			}else{
				img_centroMedico  = "<img src='/assets/img/veris/avatar_central_medica.png' alt='doctor parami' class='img-fluid w-50' style='border-radius: 10px;'>";
			}
			let textUrgencias = '';
			if (value.codigoSucursal == "46") {
				textUrgencias = '<p class="text-vivid m-0 fs-14">Urgencias</p>';
			}
			var radioBtn = '<label class="box-central control control-radio" title="'+value.direccion+'"><div class="d-flex gap-2">'+img_centroMedico+'<div class="d-flex gap-2 w-100 justify-content-between"><div style="max-width: 85%;"><h5 class="m-0">'+value.nombreSucursal+'</h5>'+textUrgencias+'<p class="m-0 fs-12">'+value.direccion+'</p></div><input type="radio" name="central" codigoSucursalPX-rel="'+value.codigoSucursal+'" nombreCentral-rel="'+value.nombreSucursal+'" value="'+value.idCentro+'" /><div class="control_indicator"></div></div></div></label>';


			// var radioBtn = '<label title="'+value.direccion+'" class="control control-radio">'+value.nombreSucursal+'<input type="radio" name="central" codigoSucursalPX-rel="'+value.codigoSucursal+'" nombreCentral-rel="'+value.nombreSucursal+'" value="'+value.idCentro+'" /><div class="control_indicator"></div>';
    		$('.box-centrales').append(radioBtn);
		});			
	});
}

function obtenerFechas(){
	showLoader();
	var idCiudad = getValueFIByName('ciudad');
	var idEspecialidad = getValueFIByName('especialidad');
	var idCentro = getValueFIByName('central');
	var codigoSucursalPX = "";
	if(idCiudad == "1-25-1"){
		idCentro = "";
	}else{
		codigoSucursalPX = $('input[name="central"]:checked').attr("codigoSucursalPX-rel");
	}
	var esTeleconsulta = "";
	if(virtual){
		esTeleconsulta = "S";
	}
	//var method = "/Verisrest/v1/externo/fechasdisponibles";
	//var param = "?arg0="+idCentro+"&arg1="+idEspecialidad+"&arg2="+esTeleconsulta+"&arg3="+getValueFI('tipoIdentificacion')+"&arg4="+getValueFI('numeroIdentificacion');
	var method = "/agenda/fechasdisponibles";
	var param = "?codigoEmpresa=1&codigoSucursal="+codigoSucursalPX+"&codigoEspecialidad="+idEspecialidad+"&online="+((virtual) ? 'S' : 'N') +"&canalOrigen="+canal_origen;
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		if ($.trim(response.data)){
			listDiasDisponibles = response.data;
			//console.log(response.data[0]);
			$.each(response.data, function(key, value){
				var radioBtn = '<label class="control control-radio">'+value.nombre+'<input type="radio" name="central" value="'+value.idCentro+'" /><div class="control_indicator"></div>';
	    		$('.box-centrales').append(radioBtn);
			});
			$('.box-disponibilidad').empty();
			//obtenerDisponibilidad(response.data[0]);
		}else{
			hideLoader();
			showError('No existen citas disponibles');
		}
		setCalendar(response.data[0]);
	});
}

function obtenerDisponibilidad(fecha){
	showLoader();
	lastDate = fecha;
	$('.box-disponibilidad').empty();
	console.log('---'+fecha);
	$('.msg_dscto').hide();
	//$('.box-precio').html("<i class='fa fa-usd fa-fw' aria-hidden='true'></i>");	
	var idCiudad = getValueFIByName('ciudad');
	var idEspecialidad = getValueFIByName('especialidad');
	var idCentro = getValueFIByName('central');
	var codigoSucursalPX = "";
	if(idCiudad == "1-25-1"){
		idCentro = "";
	}else{
		codigoSucursalPX = $('input[name="central"]:checked').attr("codigoSucursalPX-rel");
	}
	var online = 'N';
	if(idCiudad == "1-25-1"){
		online = 'S';
		idCentro = "";
		codigoSucursalPX = "";
	}

	var fechaSeleccionada = fecha[0]+"/"+fecha[1]+"/"+fecha[2];
	console.log(fechaSeleccionada);

	var codigoPrestacion = $('input[name="especialidad"]:checked').attr("codigoPrestacion-rel");
	var codigoServicio = $('input[name="especialidad"]:checked').attr("codigoServicio-rel");
	
	var permitePago = $("#convenios option:selected").attr("permitePago-rel");
	
	var method ='/agenda/medicos/disponibilidad';
	//var param = '?codigoEmpresa=1&idPaciente=&codigoCiudad='+idCiudad+'&codigoEspecialidad='+idEspecialidad+'&online='+esTeleconsulta+'&fechaSeleccionada='+fecha+'&fechaSeleccionadaFin='+fecha+'&codigoServicio='+_codigoServicio+'&codigoPrestacion='+_idprestacion.split('-')[0]+'&codigoSucursal='+idCentro+'&canalOrigen=MVE';
	var param = '?codigoEmpresa=1&idPaciente='+infoUsuario.numeroPaciente+'&codigoCiudad='+idCiudad+'&codigoEspecialidad='+idEspecialidad+'&online='+online+'&fechaSeleccionada='+fechaSeleccionada+'&fechaSeleccionadaFin='+fechaSeleccionada+'&canalOrigen='+canal_origen+'&codigoServicio='+codigoServicio+'&codigoPrestacion='+codigoPrestacion+'&codigoSucursal='+codigoSucursalPX;
	
	//var method = "/Verisrest/v1/externo/disponibilidad";
	//var param = "?arg0="+idCentro+"&arg1="+idEspecialidad+"&arg3="+fecha+"&arg4="+online;
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		if ($.trim(response.data)){
			var path_icon = "https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/js/";
			let listDoctores = [];

			$.each(response.data, function(key, value){
			    if(jQuery.inArray(value.idMedico, listDoctores) == -1){
			        listDoctores.push(value.idMedico);
					let nombreMedico = "";
					if (codigoSucursalPX != "46") {
						nombreMedico = "<p>"+value.nombreMedico+"</p>";
						$('.subtitle').show();
					}
			        $('.box-disponibilidad').append('<div class="box-doctor box-doctor-'+value.idMedico+'"><p>'+value.nombreMedico+'</p></div>');
			    }
			});

			//$.each(doctores, function(k, v){
			$.each(response.data, function(key, value){
			//$('.box-disponibilidad').append('<div class="box-doctor box-doctor-'+v[0].idMedico+'"><p>'+v[0].nombreMedico+'</p></div>');
			//$.each(v, function(key, value){
				var icon_disponibilidad = '<i class="far fa-clock fa-fw"></i>';
				var clase_descuento = "";
				var title_descuento = "";					
				if(value.porcentajeDescuento > 0 && permitePago == "S"){
					icon_disponibilidad = '<img src="'+path_icon+'discount-ico.svg">';
					clase_descuento = "class_desc";
					title_descuento = "| Cita con descuento del "+value.porcentajeDescuento+"%";
				}
				var radioBtn = '<div title="'+value.dia+' - '+value.horaInicio+' '+title_descuento+'" class="box-individual '+clase_descuento+'" idMedico-rel="'+value.idMedico+'" nombreMedico-rel="'+value.nombreMedico.toLowerCase()+'" horaInicio-rel="'+value.horaInicio+'" horaFin-rel="'+value.horaFin+'" dia-rel="'+value.dia+'" dia2-rel="'+value.dia2+'" porcentajeDescuento-rel="'+value.porcentajeDescuento+'" idsIntervalos-rel="'+value.idIntervalo+'" ><div class="box-reloj">'+icon_disponibilidad+'</div><span>'+value.horaInicio+'-'+value.horaFin+'</span></div>';
	    		$('.box-doctor-'+value.idMedico).append(radioBtn);
	    	//});
			});
		}else{
			showError('No existe disponibilidad en la Fecha seleccionada');
		}
		hideLoader();
	});
}

function mostrarInfoCita(){
	jQuery('.box-info-vue').hide();
	var codigoSucursalPX = $('input[name="central"]:checked').attr("codigoSucursalPX-rel");
	if (codigoSucursalPX == "46") {
		jQuery('.box-infor-data').hide();
		jQuery('.box-info-vue').show();
		mostrarInfoVue();
		jQuery(".btnConfirmar").addClass("disabled-vue");

		// jQuery('.btnConfirmar').attr('disabled', 'disabled');
	} else {
		jQuery('.box-infor-data').show();
		jQuery('.box-info-vue').hide();
		jQuery(".btnConfirmar").removeClass("disabled-vue");
	}

	var txt_ciudad = $('input[name="ciudad"]:checked').attr('nombreCiudad-rel');
	var txt_especialidad = $('input[name="especialidad"]:checked').attr('nombreEspecialidad-rel');
	/*dd/mm/yyyy*/
	var txt_fecha = $('.box-individual-selected').attr('dia2-rel').split("/");
	var semana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
	var mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	var nueva_fecha = new Date(txt_fecha[1]+"/"+txt_fecha[0]+"/"+txt_fecha[2]);
	var txt_central = $('input[name="central"]:checked').attr('nombreCentral-rel');
	var txt_doctor = $('.box-individual-selected').attr('nombreMedico-rel');
	var txt_hora = $('.box-individual-selected').attr('horaInicio-rel');

	var txtNombreConvenio = "";
	if($("#tieneConvenio").prop('checked')){
		txtNombreConvenio = $('#convenios option:selected').html();
	}
	$('.txt-info-convenio').html(txtNombreConvenio);
	$('.txt-info-ciudad').html(txt_ciudad);
	$('.txt-info-especialidad').html(txt_especialidad);
	//$('.txt-info-fecha').html(semana[nueva_fecha.getDay()] + ", "+txt_fecha[0]+" de "+mes[nueva_fecha.getMonth()] +" del "+txt_fecha[2] + " | ");
	$('.txt-info-fecha').html(mes[nueva_fecha.getMonth()].substring(0, 3) + " "+txt_fecha[0]+", "+txt_fecha[2] + " | ");
	if(getValueFIByName("ciudad")!="1-25-1"){
		$('.txt-info-central').html(txt_central);
	}else{
		$('.txt-info-central').html("Virtual");
	}
	$('.txt-info-doctor').html('<span>Dr(a) </span>'+txt_doctor);
	var am_pm = "AM";
	if(txt_hora.split(':')[0] >= 12){
		am_pm = "PM";
	}

	$('.txt-info-hora').html(txt_hora+" "+am_pm);
	//Quitar con nuvei
	$('.box-nuvei').hide();
	$('.box-no-nuvei').show();
}

function mostrarInfoVue() {
	hideLoader();
	$('.symptom-0').empty();
	$('.symptom-1').empty();
	$('.symptom-2').empty();
	$('.symptom-3').empty();
	$('.symptom-4').empty();
	$('.symptom-5').empty();
	$('.symptom-6').empty();
	$('.symptom-7').empty();
	$('.symptom-8').empty();
	$('.symptom-9').empty();
	$('.symptom-10').empty();
	$('.symptom-11').empty();
	$('.form-check-input').prop('checked', false);
	// https://api-phantomx.veris.com.ec/digitales/v1/configuraciones?codigoFlujoProceso=3&canalOrigen=VER_CMV&codigoPantalla=8
	var method ='/configuraciones';
	var param = '?codigoFlujoProceso=3&codigoPantalla=8&canalOrigen='+canal_origen;
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		// console.log(response);
		$.each(response.data.pantallas, function(key, value){
			// console.log(value);
			// valor = value.configuraciones[0]
			// console.log(value.configuraciones[3]);
			// console.log(value.configuraciones[3].valor);

			let valor_symptom = value.configuraciones[3].valor;
			let item_symptom = valor_symptom.split('|');
			// console.log(item_symptom);

			jQuery('.symptom-0').append(item_symptom[0]);
			jQuery('.symptom-1').append(item_symptom[1]);
			jQuery('.symptom-2').append(item_symptom[2]);
			jQuery('.symptom-3').append(item_symptom[3]);
			jQuery('.symptom-4').append(item_symptom[4]);
			jQuery('.symptom-5').append(item_symptom[5]);
			jQuery('.symptom-6').append(item_symptom[6]);
			jQuery('.symptom-7').append(item_symptom[7]);
			jQuery('.symptom-8').append(item_symptom[8]);
			jQuery('.symptom-9').append(item_symptom[9]);
			jQuery('.symptom-10').append(item_symptom[10]);
			jQuery('.symptom-11').append(item_symptom[11]);
		
		});
		
	});
	console.log('VUE');
}


function separarCita(){
	var esTeleconsulta = "N";
	var codigoSucursalPX = "";
	if(virtual){
		codigoSucursalPX = $('input[name="central"]:checked').attr("codigoSucursalPX-rel");
		esTeleconsulta = "S";
	}
	var idsIntervalos = $('.box-individual-selected').attr('idsIntervalos-rel');
	var porcentajeDescuentoDinamico = $('.box-individual-selected').attr('porcentajeDescuento-rel');
	var permitePago = $("#convenios option:selected").attr("permitePago-rel");
	let tipoIdentificacion = getValueFI('tipoIdentificacion');
	let numeroIdentificacion = getValueFI('numeroIdentificacion');
	var idEspecialidad = getValueFIByName('especialidad');
	var codigoPrestacion = $('input[name="especialidad"]:checked').attr("codigoPrestacion-rel");
	var codigoServicio = $('input[name="especialidad"]:checked').attr("codigoServicio-rel");
	//var method = "/Verisrest/v2/externo/cita";
	var method = "/agenda/separarTurno?canalOrigen="+canal_origen;
	var settings = {
		"url": url_services_phantomx+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
			"idsIntervalos": idsIntervalos,
			"esTeleconsulta": esTeleconsulta,
			tipoIdentificacion,
			numeroIdentificacion,			
			"origen": "VER",
			"porcentajeDescuento":porcentajeDescuentoDinamico,
			"codigoPrestacion":codigoPrestacion,
			"codigoServicio":codigoServicio,
			"codigoEspecialidad":idEspecialidad,
			"codigoSucursal":codigoSucursalPX,
			"codigoEmpresa":null
		}),
	};

	$.ajax(settings).done(function (response) {
		console.log(response.mensaje);
		if(response.code == 200){
			idReservaSeparada = response.data.idReservaSeparada;
			// validarTurno();
			var codigoConvenio = $("#convenios option:selected").val();
			//obtenerConvenios();
			if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") != "46") {
				if(codigoConvenio == "NA" || !$("#tieneConvenio").prop('checked')){
					valorizarCita('S', 'NA');
				}else{
					var aplicaCobertura = $('#convenios').find('option:selected').attr('aplicaCobertura-rel');
					var codigoConvenio = $('#convenios').val();
					valorizarCita(aplicaCobertura, codigoConvenio);
				}
			}
			//$("#convenios").empty();
			//valorizarCita();
			console.log(7);
			window.onbeforeunload = function() {
				console.log(9);
				return 'Recuerda que para agendar tu cita debes pagarla. Si abandonas esta sección no se agendará.';
			}
		}else{
			hideLoader();
			showError("No se pudo realizar la reserva. " + response.message);
		}
	}).fail(function(xhr, status, error) {
		hideLoader();
        // error handling
		let { status: statusResponse, responseJSON } = xhr;
		showError("No se pudo realizar la reserva. " + responseJSON.message);
		hideLoader();
		console.log(status, error, xhr);
    });
}

//Llamar cuando click en botón Cambiar
function cancelarCita(){
	//var method = "/Verisrest/v1/externo/cita/"+idReservaSeparada;
	var method = "/agenda/eliminarPrereserva"
	var settings = {
		"url": url_services_phantomx+method,
		"method": "PUT",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
			"idRererva": idReservaSeparada,
			"codigoEmpresa":null
		}),
	};

	$('.btnConfirmar-dis').removeClass("btnConfirmar-dis");
	$('.box-terminos-exc').remove();

	$.ajax(settings).done(function (response) {
		console.log(response);
		idReservaSeparada = "";
	});
}

function validarTurno(){
	var idsIntervalos = $('.box-individual-selected').attr('idsIntervalos-rel');
	var param = "?arg0="+getValueFI('tipoIdentificacion')+"&arg1="+getValueFI('numeroIdentificacion')+"&arg2="+idsIntervalos+"&arg3="+idReservaSeparada;
	var method = "/MaruriWsrest/servicio/citas/validarturno";
	var settings = {
		"url": url_services+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};
	$.ajax(settings).done(function (response) {
		console.log(response);
		if(response.resultado == "OK"){
			$("#convenios").empty();
			obtenerConvenios();
		}else{
			hideLoader();
			showError("No se pudo realizar la reserva. " + response.resultado);
		}
	});
}

/*
quoteAppointment = (insuranceCompanies) => {
    const { documentType, idNumber, reserveId } = this.props;
    api.quoteAppointment({ documentType, idNumber, reserveId, applyCoverage: 'S', companyId: 'NA' }).then( quote => {
      this.processQuote({ quote, index: -1 });
    });
    insuranceCompanies.forEach((insuranceCompany, index) =>
      api.quoteAppointment({
        documentType,
        idNumber,
        reserveId,
        applyCoverage: insuranceCompany.aplicaCobertura,
        companyId: insuranceCompany.codigoConvenio }).then( quote => this.processQuote({ quote, index })) )
  };
*/

function obtenerConvenios(){
	$('#convenios').empty();
	var msg_convenios = "NOS ESTAMOS COMUNICANDO CON TU ASEGURADORA, EL PROCESO PUEDE TARDAR UNOS MINUTOS";
	var idEspecialidad = getValueFIByName('especialidad');
	var esTeleconsulta = "N";
	if(virtual){
		esTeleconsulta = "S";
	}
	//var method = "/Verisrest/v1/externo/convenios";
	//var param = "?arg0="+esTeleconsulta+"&arg1="+getValueFI('tipoIdentificacion')+"&arg2="+getValueFI('numeroIdentificacion')+'&arg3='+idEspecialidad;

	var method = "/comercial/paciente/convenios";
	var param = "?numeroIdentificacion="+getValueFI('numeroIdentificacion')+"&tipoIdentificacion="+getValueFI('tipoIdentificacion')+"&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&canalOrigen="+canal_origen_2+"&esOnline="+esTeleconsulta+"&excluyeNinguno=S";
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "GET",
		"timeout": 0,
		/*"headers": {
			"Authorization": "Bearer "+token
		},*/
	};
	showInfo(msg_convenios);
	$.ajax(settings).done(function (response) {
		console.log(response);
		//Agregar valor de cita sin convenio
		//if(response.data){
		if($.trim(response.data)){
			$('#convenios').show();
			console.log(response);
			hideLoader();
			tieneConvenios = true;
			$("#tieneConvenio").prop('checked', true);
			$.each(response.data, function(key, value){
				console.log("Agregar en Select");
				console.log(value);
				let informacionExternaPlan = JSON.stringify(value.informacionExternaPlan);
				console.log(informacionExternaPlan);
				$("#convenios").append(`<option aplicaVerificacionConvenio-rel='${value.aplicaVerificacionConvenio}' idCliente-rel='${value.idCliente}' informacionExternaPlan-rel='${informacionExternaPlan}' aplicaPagoDigitalObligatorio-rel="${value.aplicaPagoDigitalObligatorio}" secuenciaAfiliado-rel="${value.secuenciaAfiliado}" permitePago-rel="${value.permitePago}" aplicaConfirmacion-rel="${value.aplicaConfirmacion}" permiteReserva-rel="${value.permiteReserva}" mensajeBloqueoReserva-rel="${value.mensajeBloqueoReserva}" aplicaCobertura-rel="${value.aplicaCobertura}" value="${value.codigoConvenio}">${value.nombreConvenio}</option>`);
			});
			// var aplicaCobertura = $('#convenios').find('option:selected').attr('aplicaCobertura-rel');
			// var codigoConvenio = $('#convenios').val();
			// valorizarCita(aplicaCobertura, codigoConvenio);
		}else{
			console.log("Sin convenios");
			let informacionExternaPlan = null;
			$("#convenios").append('<option aplicaVerificacionConvenio-rel="N" idCliente-rel="0" informacionExternaPlan-rel="'+informacionExternaPlan+'" aplicaPagoDigitalObligatorio-rel="N" permitePago-rel="S" aplicaConfirmacion-rel="N" secuenciaAfiliado-rel="" permiteReserva-rel="S" aplicaCobertura-rel="S" value="NA">No posee convenios</option>');
			tieneConvenios = false;
			//valorizarCita('S', 'NA');
			$("#tieneConvenio").prop('checked', false);
			/*hideLoader();
			var texto;
			if(response.texto &&  response.texto != '' ){
				texto = response.texto;
			}else{
				$texto = "";
			}*/
			showError("No tiene convenios disponibles.");
		}
		$.toast().reset('all');
	});

}

function valorizarCita(applyCoverage,companyId){
	$('.box-precio').html("");
	companyIdSelected = companyId;
	valoresPago = "";
	$('.msg_dscto').hide();

	$('.msg-info-valorizar msg-reagendar').hide();
	$('.msg-no-cambio').hide();
	$('.msg-aviso-conexion').hide();
	$('.msg-aviso-no-permite-pago').hide();
	$('.text-info-llegada').hide();

	showLoader();
	if($("#convenios option:selected").attr("aplicaConfirmacion-rel") == "S"){
		alert("No pudimos comunicarnos con tu aseguradora, por favor contáctate con ellos, el valor a pagar se mostrará sin crédito. Â¿Deseas continuar?");
	}

	var idsIntervalos = $('.box-individual-selected').attr('idsIntervalos-rel');
	//+"&arg5="+//idsIntervalos;

	//$('.box-precio').html("<i class='fa fa-usd fa-fw' aria-hidden='true'></i>");
	/*var param = "?arg0="+getValueFI('tipoIdentificacion')+"&arg1="+getValueFI('numeroIdentificacion')+"&arg2="+idReservaSeparada+"&arg3="+applyCoverage+"&arg4="+companyId;
	var method = "/MaruriWsrest/servicio/citas/valorizarcita";
	var settings = {
		"url": url_services+method+param,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token
		},
	};*/
	var codigoSucursalPX = "";
	var codigoConvenio = "";
	if(!virtual){
		codigoSucursalPX = $('input[name="central"]:checked').attr("codigoSucursalPX-rel");
	}
	if($("#convenios option:selected").val() != "NA" && $("#tieneConvenio").prop('checked')){
		codigoConvenio = parseInt($("#convenios option:selected").val());
	}
	if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {	// valorizacion
		codigoConvenio = "";
	}
	var codigoPrestacion = $('input[name="especialidad"]:checked').attr("codigoPrestacion-rel");
	var codigoServicio = $('input[name="especialidad"]:checked').attr("codigoServicio-rel");
	var secuenciaAfiliado = $("#convenios option:selected").attr("secuenciaAfiliado-rel");

	var codigoReservaCita = "";
	var permitePago = $("#convenios option:selected").attr("permitePago-rel");
	if(permitePago == "S"){
		codigoReservaCita = idReservaSeparada;
	}

	var idEspecialidad = getValueFIByName('especialidad');
	var esTeleconsulta = "N";
	if(virtual){
		esTeleconsulta = "S";
	}

	var idsIntervalos = $('.box-individual-selected').attr('idsIntervalos-rel');
	var esParticular = ( $("#convenios option:selected").val() == "NA" ) ? "S" : "N";

	var porcentajeDescuentoDinamico = $('.box-individual-selected').attr('porcentajeDescuento-rel');
	var aplicaProntoPagoConvenio = $("#convenios option:selected").attr("aplicaPagoDigitalObligatorio-rel");
	var codigoPrestacion = $('input[name="especialidad"]:checked').attr("codigoPrestacion-rel");
	var codigoServicio = $('input[name="especialidad"]:checked').attr("codigoServicio-rel");
	var secuenciaAfiliado = $("#convenios option:selected").attr("secuenciaAfiliado-rel");

	if(!tieneConvenios){
		esParticular = "S";
		secuenciaAfiliado = "";
		codigoConvenio = "";
		permitePago = "S";
		aplicaProntoPagoConvenio = "S";
	}

	var method = "/agenda/precio";
	var params = "?canalOrigen="+canal_origen_2+"&tipoIdentificacion="+getValueFI('tipoIdentificacion')+"&numeroIdentificacion="+getValueFI('numeroIdentificacion')+"&codigoEspecialidad="+idEspecialidad+"&esParticular="+esParticular+"&idIntervalos="+idsIntervalos+"&permitePago="+permitePago+"&codigoConvenio="+codigoConvenio+"&esOnline="+esTeleconsulta+"&porcentajeDescuento="+porcentajeDescuentoDinamico+"&aplicaProntoPago="+aplicaProntoPagoConvenio+"&codigoPrestacion="+codigoPrestacion+"&codigoServicio="+codigoServicio+"&codigoReserva="+idReservaSeparada+"&secuenciaAfiliado="+secuenciaAfiliado;
	
	var medpayPlan = $.parseJSON($("#convenios option:selected").attr("informacionExternaPlan-rel"));
	var settings = {
		"url": url_services_phantomx+method+params,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token,
			"Content-Type": "application/json"
		},
		"data": JSON.stringify({
			"fechaSeleccionada": $('#fechaCita').val(),
			"idCliente": (tieneConvenios) ? $("#convenios option:selected").attr("idCliente-rel") : '',
			"estaPagada": null,
			"esEmbarazada": respuestaEspecialidad,
			"medPayPlan": medpayPlan
		})
	};
	// var method = "/phantomx-digitales-api/v1/comercial/valorizacion";
	// var params = "?codigoEmpresa=1&canalInvocacion=WEB&tipoValorizacion=GRUPAL&codigoSucursal="+codigoSucursalPX+"&responseCompleto=true&esConsulta=S";
	/*var settings = {
		"url": url_services+method+params,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Authorization": "Bearer "+token,
			"Content-Type": "application/json"
		},
		"data": JSON.stringify({
			"numeroidentificacionPaciente": getValueFI('numeroIdentificacion'),
		    "tipoidentificacionPaciente": getValueFI('tipoIdentificacion'),
		    "codigoConvenio": codigoConvenio,
		    "secuenciaAfiliado": secuenciaAfiliado,
		    "secuenciaPaquetePaciente": null,
		    "secuenciaTarjetaXPaciente": null,
		    "prestaciones": [{
	            "codigoPrestacion": codigoPrestacion,
	            "codigoEmpresa": 1,
	            "codigoServicio": codigoServicio,
	            "idObject": "1",
	            "numeroOrden": null,
	            "lineaDetalleOrden": null,
	            "cantidad": 1,
	            "tieneCobertura": null,
	            "nemonicoMotivoAutorizacion": null,
	            "codigoReserva":null,
	            "codigoIntervalo":null,
	            "codigoReserva":codigoReservaCita
		    }],
		    "diagnosticos": null
		})
	};*/
	$.ajax(settings).done(function (response) {
		hideLoader();
		console.log(999)
		console.log(response);
		if(response.code == 200){
			if(response.data.aplicaCondicionesSeguro){
				cancelarCita();
				
				let msg = response.data.mensajeValidacion;//+"<br>"+response.data.mensajeValidacion2;
				$('.modal-validacion-condiciones-seguro .subtitle').html(msg.replace(/\*(.*?)\*/g, '<b class="text-veris">$1</b>'));
				$('.modal-validacion-condiciones-seguro').modal('show');
			}
			valoresPago = response.data;//.prestacionesValorizadas[0];
			console.log(valoresPago);
			console.log("Mostrar Valor");
			secuenciaTransaccion = response.data.secuenciaTransaccion;

			if(response.data.mensajeValidacion && response.data.mensajeValidacion != ""){
				if($("#convenios option:selected").attr("aplicaVerificacionConvenio-rel") == "S" && tieneConvenios){
					let msg = response.data.mensajeValidacion;//+"<br>"+response.data.mensajeValidacion2;
					$('.modal-precio-confirmacion-datos .subtitle').html(msg.replace(/\*(.*?)\*/g, '<b class="text-veris">$1</b>'));
					$('.modal-precio-confirmacion-datos').modal('show');
				}else{
					showInfo(response.data.mensajeValidacion, 15000);
				}
			}

			//debugger;
			// $('.box-precio').html("<i class='fa fa-usd fa-fw' aria-hidden='true'></i>"+parseFloat(response.lista[0].precioReal).toFixed(2));
			var porcentajeDescuentoDinamico = $('.box-individual-selected').attr('porcentajeDescuento-rel');
			var permitePago = $("#convenios option:selected").attr("permitePago-rel");
			
			//let { subtotalCopago, porcentajeDescuentoCopago, valorTotalCopago } = valoresPago;
			let { valor, porcentajeDescuento, valorCanalVirtual  } = valoresPago;
			let porcentajeDescuentoCopago = porcentajeDescuento;
			let subtotalCopago = valor;
			let valorTotalCopago = valorCanalVirtual;
			porcentajeDescuento = 0;
			console.log(valoresPago);
			if(porcentajeDescuentoCopago)
				porcentajeDescuento = +porcentajeDescuentoCopago;
				
			if(porcentajeDescuento > 0 && virtual) {
				console.log("mostrar descuento virtual detalle");
				$('.subtitle.descuento').show();
				$('#descuento').html(parseFloat(porcentajeDescuento));
			}else{
				console.log("Ocultar descuento virtual detalle");
				$('.subtitle.descuento').hide();
			}
			
			let valorDescuento = +valorTotalCopago * porcentajeDescuento/100;
			valorDescuento = +parseFloat(valorDescuento).toFixed(2);

			//var paymentAmount =  ((valorTotalCopago) * (1 - Number(porcentajeDescuento) / 100)).toFixed(2);
			paymentAmount = valorTotalCopago.toFixed(2);
			if(porcentajeDescuentoDinamico > 0 && permitePago == "S"){
				$('.msg_dscto').show();
				$('.text-discount').html("por el horario que elegiste");
				$('.msg-no-cambio').show();
				// $('.msg-aviso-conexion').show();
			}else{
				if(porcentajeDescuento > 0){
                                	$('.text-discount').html(response.data.mensajeDescuento);
                        	}
			}
			$('.box-precio').html("$"+paymentAmount);
			//console.log(response.lista[0]);

			if (virtual && porcentajeDescuentoDinamico > 0) {
				$('.msg-reagendar').hide();
				$('.msg-aviso-conexion').show();
				$('.text-info-llegada').hide();
			}

			if (virtual) {
				$('.text-info-llegada').hide();
			}
			//Info de precios y convenios JUNIO
			$('.txt_sub').show();

			if(!virtual){	/* No virtual es precesncia*/
				$('.msg-reagendar').show();
			}else{
				$('.msg-aviso-conexion').show();
				$('.text-info-llegada').hide();
			}

			/* $('.msg-reagendar').show(); */
			if(valorTotalCopago == 0){
				//Agregar validador de PPD
				if( politics.data.estadoPoliticas == "N" || politics.data.estadoPoliticas == null ){
					let elem = `
					<div class="box-terminos-exc">
						<input class="form-check-input mx-auto" type="checkbox" checked id="terminos-exc" checked style="display: inline-block;vertical-align: top;">
						<label class="form-check-label f-xs text-blue" for="terminos-exc" style="display: inline-block;width: 90%;vertical-align: middle;margin-left: 5px;">
							Acepto <a href="${politics.data.linkPoliticaPrivacidad}" target="_blank" class="text-decoration-none text-blue fw-bold">${politics.data.leyendaPoliticas}</a>
						</label>
					</div>`;
					/*<input form="kushki-pay-form" type="hidden" name="ajustarPPD" id="ajustarPPD" value="S">
					<input form="kushki-pay-form" type="hidden" name="versionPPD" id="versionPPD" value="${politics.data.ultimaVersionPoliticas}">
					<input form="kushki-pay-form" type="hidden" name="numeroIdentificacionPPD" id="numeroIdentificacionPPD" value="${ getValueFI('numeroIdentificacion') }">*/
					$('#wizard-p-5').append(elem)
				}
				//excento y debemos validar que convenio tiene
				$('.msg-reagendar').show();
				$('.msg-aviso-conexion').hide();
				$('.txt_sub').hide();
				$('.msg-no-cambio').hide();
				$('.txt_sub .precio-subtotal').html("$"+parseFloat(valoresPago.subtotalCopago).toFixed(2));
				if($("#convenios option:selected").html().toLowerCase().indexOf("bmi") >= 0){
					//BMI
					$('.text-discount').html("Estás exento de pago por ser cliente BMI");
					if(!virtual){
						$('.text-info-llegada').show();
					}else{
						$('.text-info-llegada').hide();
					}
					
				}else{
					//NO BMI
					$('.text-discount').html("Estás exento de pago por tu convenio");
					$('.text-info-llegada').show();
					if (virtual) {
						$('.text-info-llegada').hide();
					}
				}
			}else{
				$('.box-terminos-exc').remove();
				if(porcentajeDescuentoDinamico > 0 && permitePago == "S"){
					$('.msg-no-cambio').show();
					
				}
				if (permitePago == "N") {
					$('.msg-reagendar').hide();
				}
				var paymentAmount =  ((valorTotalCopago) * (1 - Number(porcentajeDescuentoCopago) / 100)).toFixed(2);
				if(porcentajeDescuentoCopago > 0){
					
					$('.txt_sub .precio-subtotal').html("$"+parseFloat(subtotalCopago).toFixed(2));
					
					var valor_descuento = (valorTotalCopago *  Number(porcentajeDescuentoCopago)) / 100;
					$('.txt_descuento').html("-"+porcentajeDescuentoCopago+"%");
					
					//$('.txt_price').html("$"+paymentAmount);
					
					$('.txt_descuento').css("display","block");
					$('.discount-rate').css("display","block");
					$('.txt_sub').css("display","block");
				}else{
					$('.txt_descuento').css("display","none");
					$('.discount-rate').css("display","none");
					$('.txt_sub').css("display","none");
				}

				if($("#convenios option:selected").attr("permitePago-rel") == "N" && !virtual){
					$('.msg-aviso-no-permite-pago').show();
					$('.text-info-llegada').hide();
				}
			}

			if (porcentajeDescuentoDinamico > 0) {
				$('.msg-reagendar').hide();
			}
			
		}else{
			showError("Estamos presentando inconvenientes técnicos, intente nuevamente en unos minutos");
		}
	}).fail(function(xhr, status, error) {
        // error handling
		console.log(xhr, status, error);
    });
}


function obtenerDescuento(){
	var method = "/Verisrest/v2/externo/detallepago";
	var settings = {
		"url": url_services + method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer " + token
		},
		"data": JSON.stringify({
			"listaOrdenes": [
				{
					"numeroOrden": 14540845
				}
			],
			"listaOrdenPaquete": null,
			"idFacturacion": {
				"tipoIdentificacion": getValueFI('tipoIdentificacion'),
				"numeroIdentificacion": getValueFI('numeroIdentificacion'),
				"idPaciente": null
			},
			"valorizacionAutomatica": "S"
		}

		),
	};
	$.ajax(settings).done(function (response) {
		hideLoader();
		console.log(response);
		if(response.resultado == "ok"){
			valoresPago = response.lista[0];
			console.log(valoresPago);
			console.log("Mostrar Valor");
			//$('.box-precio').html("<i class='fa fa-usd fa-fw' aria-hidden='true'></i>"+parseFloat(response.lista[0].precioReal).toFixed(2));
			//console.log(response.lista[0]);
		}else{
			showError("Estamos presentando inconvenientes técnicos, intente nuevamente en unos minutos");
		}
	}).fail(function(xhr, status, error) {
        // error handling
		//debugger;
		console.log(xhr, status, error);
    });
}

// var aplicaProntoPago = "N";
var aplicaProntoPago = false;
function confirmarCita(){
	/*
	lista: []
	texto: ""
	resultado: "La cita fue eliminada por sobrepasar el limite de espera."
	numero: 0
	excentoPago: "N"
	--------------------------------
	lista: []
	texto: ""
	resultado: "ok"
	numero: 0
	excentoPago: "N"
	*/

	// var method = "/MaruriWsrest/servicio/citas/confirmarcita";
	// var param = "?arg0="+idReservaSeparada+"&arg1="+companyIdSelected;
	showLoader();
	var codigoConvenio = "";
	if($("#convenios option:selected").val() != "NA" && $("#tieneConvenio").prop('checked')){
		codigoConvenio = parseInt($("#convenios option:selected").val());
	}
	if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {
		codigoConvenio = "";
	}

	var aplicaProntoPagoConvenio = $("#convenios option:selected").attr("aplicaPagoDigitalObligatorio-rel");
	var permitePago = $("#convenios option:selected").attr("permitePago-rel");
	var esTeleconsulta = "N";
	if(virtual){
		esTeleconsulta = "S";
	}
	
	var valorizacion;
	let _valorCanalVirtual = 0;
	let _valorDescuento = 0;
	let _valor = 0;
	let _numeroAutorizacion = 0;
	if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {
		valorizacion = 0;
	}else{
		valorizacion = parseFloat(valoresPago.valorCanalVirtual).toFixed(2)
		// valorizacion = parseFloat(valoresPago.valor).toFixed(2)
		_valorCanalVirtual = valoresPago.valorCanalVirtual;
		_valorDescuento = valoresPago.valorDescuento;
		_valor = valoresPago.valor;
		_numeroAutorizacion = valoresPago.numeroAutorizacion;
	}


	let params = {
		"idReserva": idReservaSeparada,
		"idConvenio": codigoConvenio,
		"porcentajeDescuento": parseFloat($('.box-individual-selected').attr('porcentajeDescuento-rel')),
		"codigoEmpresa":1,
		"permitePago": permitePago,
		"valorizacion": valorizacion,	// parseFloat(valoresPago.subtotalCopago).toFixed(2),
		"aplicaProntoPago": aplicaProntoPagoConvenio,
		"esOnline": esTeleconsulta,
		"enviarLinkPago": null,
		"esNotificacion": null,
  		"secuenciaTransaccion": secuenciaTransaccion,
		"esEmbarazada": respuestaEspecialidad,
		"valorCita": _valorCanalVirtual,
		"valorDescuento": _valorDescuento,
		"valorSubtotalCita": _valor,
		"numeroAutorizacion": _numeroAutorizacion
	};


	var secuenciaAfiliado = $("#convenios option:selected").attr("secuenciaAfiliado-rel");
	if(secuenciaAfiliado != ""){
		params.secuenciaAfiliado = secuenciaAfiliado;
	}
	// compruebo si es numero
	//if(!isNaN(companyIdSelected)) params = { ...params, idConvenio: companyIdSelected };

	//var method = "/Verisrest/v1/externo/cita";
	var method = "/agenda/confirmaTurno";
	var param = "";
	var settings = {
		"url": url_services_phantomx+method+param,
		"method": "PUT",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify(params)
	};

	$.ajax(settings).done(function (response) {
		
		//if (response.data.mensaje === "Cita confirmada exitosamente") {
		if (response.code == 200) {
			
			if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {
				hideLoader();
				// $('#wizard-t-6').hide();
				$('.title-confirmacion').prepend('<img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold5/images/svg/Icono-Listo.svg">');
				txtMsgCita = "¡Te estamos esperando!";
				$('.titulo-pasarela').text(_nombrePacienteVue);
				$('.box-finalizar-flow').hide();
				$('.box-finalizar-Vue').show();
				$('.msg-after-excento').html(txtMsgCita);
				flagStep = true;
				$('#wizard').steps("next");

			}
			fbq('track', 'AddToCart');

		    fbq('track', 'PageView');
			gtag('event', 'conversion', {
	            'send_to': 'AW-315657039/HfGqCPOE67kDEM-WwpYB',
	            'event_callback': callback
	        });


			/*flagStep = true;
			$('#wizard').steps("next");
			$('.actions ul li.disabled').remove();
			$('a[href$="previous"]').parent().attr("style", "display: none;");

			var strPago = "¡Tu cita está reservada!";
			var strPagoExcento = "Tu cita ha sido agendada correctamente.";
			var strRecordatorio = "Recuerda que si vas a pagar en nuestro centro médico debes estar 20 minutos antes de tu cita y tomar un ticket antes de ver al médico.<br>Si pagas en línea, es suficiente con estar 10 minutos antes de tu cita y no necesitas tomar un ticket.";
			var strRecordatorioExcento = "Recuerda venir 15 minutos antes de la hora acordada a la central médica para tu cita.";
			var strCitaVirtual = "Has reservado una consulta, <b>se eliminará en 30 minutos al no realizar el pago</b> y confirmación de la cita.";
			//valoresPago
			if(virtual){
				$('.box-final').addClass('box-banner-online');
				var txt_label_price = "VALOR FINAL A CANCELAR";
			}else{
				$('.box-final').addClass('box-banner-presencial');
				var txt_label_price = "VALOR A CANCELAR";
			}*/
			
			/*if(response.excentoPago == "S"){		
				$('.title-confirmacion').html(strPagoExcento);
				$('.subtitle-confirmacion').html(strRecordatorioExcento);
				var paymentAmount = 0;
			}else{
				$('.box-inline').css("display","inline-block");
				$('.title-confirmacion').html(strPago);
				$('.subtitle-confirmacion').html(strRecordatorio);

				//let { precioReal, porcDesc, subtotalCopago } = valoresPago;
				let { subtotalCopago, porcentajeDescuentoCopago, valorTotalCopago } = valoresPago;
				
				var paymentAmount =  ((valoresPago.valorTotalCopago) * (1 - Number(valoresPago.porcentajeDescuentoCopago) / 100)).toFixed(2);
				if(valoresPago.porcentajeDescuentoCopago > 0){
					// $('.txt_sub').html("<p>VALOR DE LA CITA</p><i class='fa fa-usd fa-fw' aria-hidden='true'></i>"+parseFloat(valoresPago.valorTotalCopago).toFixed(2));
					
					$('.txt_sub').html("<p>VALOR DE LA CITA</p><i class='fa fa-usd fa-fw' aria-hidden='true'></i>"+parseFloat(valoresPago.subtotalCopago).toFixed(2));
					var valor_descuento = (valoresPago.valorTotalCopago *  Number(valoresPago.porcentajeDescuentoCopago)) / 100;
					// $('.txt_descuento').html("<p>DESCUENTO "+valoresPago.porcentajeDescuentoCopago+"%</p><i class='fa fa-usd fa-fw' aria-hidden='true'></i>"+valor_descuento.toFixed(2));
					
					$('.txt_descuento').html("<p>DESCUENTO "+valoresPago.porcentajeDescuentoCopago+"%</p><i class='fa fa-usd fa-fw' aria-hidden='true'></i>"+valoresPago.valorDescuentoCopago.toFixed(2));
					
					$('.txt_descuento').css("display","inline-block");
					$('.txt_sub').css("display","inline-block");
				}else{
					$('.txt_descuento').css("display","none");
					$('.txt_sub').css("display","none");
				}

				$('.box-pagos').empty();
				var path_cards = "https:/
/veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/cards";
				var radioBtn = '<label class="control control-radio btn_card btn_card_visa"><img class="mt-5" src="'+path_cards+'/visa.png"><input type="radio" name="pago" value="visa"/><div class="control_indicator"></div>';
    			$('.box-pagos').append(radioBtn);
    			var radioBtn = '<label class="control control-radio btn_card btn_card_mastercard"><img class="mt-3" src="'+path_cards+'/mastercard.png"><input type="radio" name="pago" value="mastercard"/><div class="control_indicator"></div>';
    			$('.box-pagos').append(radioBtn);
    			var radioBtn = '<label class="control control-radio btn_card btn_card_diners"><img class="mt-5" src="'+path_cards+'/diners.png"><input type="radio" name="pago" value="diners"/><div class="control_indicator"></div>';
    			$('.box-pagos').append(radioBtn);
    			var radioBtn = '<label class="control control-radio btn_card btn_card_discover"><img class="mt-9" src="'+path_cards+'/discover.png"><input type="radio" name="pago" value="discover"/><div class="control_indicator"></div>';
    			$('.box-pagos').append(radioBtn);
    			var radioBtn = '<label class="control control-radio btn_card btn_card_american"><img class="mt-0" src="'+path_cards+'/american.png"><input type="radio" name="pago" value="american"/><div class="control_indicator"></div>';
    			$('.box-pagos').append(radioBtn);
    			var radioBtn = '<label class="control control-radio btn_card btn_card_alia"><img class="mt-0" src="'+path_cards+'/alia.png"><input type="radio" name="pago" value="alia"/><div class="control_indicator"></div>';
    			$('.box-pagos').append(radioBtn);
				//$('.txt_price').html("$"+paymentAmount+"<span>sin descuento $"+valoresPago.valorTotalCopago+"</span>");


				// $('.txt_price').html("<p>"+txt_label_price+"</p><i class='fa fa-usd fa-fw' aria-hidden='true'></i><div style='display: inline-block;'>"+paymentAmount+'<div>');

				$('.txt_price').html("<p>"+txt_label_price+"</p><i class='fa fa-usd fa-fw' aria-hidden='true'></i><div style='display: inline-block;'>"+valoresPago.valorTotalCopago.toFixed(2)+'<div>');
				
				//$('a[href$="previous"]').text('Pagar Cita Médica');
				$('a[href$="previous"]').addClass('btn-pagar');
				$('a[href$="previous"]').attr('href','');
				var formPtpElem = '<form id="diners-payment-form" action="' + url_site + '/pago-online-ptp/" method="GET"><input type="hidden" name="numeroIdentificacion" value="'+getValueFI('numeroIdentificacion')+'" /><input type="hidden" name="tipoIdentificacion" value="'+getValueFI('tipoIdentificacion')+'" /><input type="hidden" name="codArticulo" value="'+idReservaSeparada+'" /><input type="hidden" name="tipoArticulo" value="CITA" /></form>';
		    	var formKushkiElem = '<form id="kushki-payment-form" action="' + url_site + '/pago-online/" method="GET"><input type="hidden" name="numeroIdentificacion" value="'+getValueFI('numeroIdentificacion')+'" /><input type="hidden" name="tipoIdentificacion" value="'+getValueFI('tipoIdentificacion')+'" /><input type="hidden" name="codArticulo" value="'+idReservaSeparada+'" /><input type="hidden" name="tipoArticulo" value="CITA" /></form>';
				$('.modal-pagos .footer').append(formPtpElem);
				$('.modal-pagos .footer').append(formKushkiElem);

			}*/

			// if(virtual){
			// 	$('.adv-virtual').html(strCitaVirtual);
			// 	$('.adv-virtual').show();
			// 	guardarMotivo();

			// }else{
			// 	preguntarMotivoUsuario();
			// 	if(mostrarModalMotivoPresencial ||){
			// 		$('.modal-motivo-presencial').modal('show');
					
			// 		$('#wizard-p-6').css("position","fixed");
			// 		setTimeout(function(){
			// 		    $('#wizard-p-6').css("position","absolute");
			// 		},200);
			// 	}
			// }

			//preguntarMotivoUsuario();
			//if(mostrarModalMotivoPresencial || virtual){
			//	$('.modal-motivo-presencial').modal('show');
			//	
			//	$('#wizard-p-6').css("position","fixed");
			//	setTimeout(function(){
			//	    $('#wizard-p-6').css("position","absolute");
			//	},200);
			//}

			/*var porcentajeDescuentoDinamico = $('.box-individual-selected').attr('porcentajeDescuento-rel');
			var permitePago = $("#convenios option:selected").attr("permitePago-rel");
			console.log(porcentajeDescuentoDinamico);
			if(porcentajeDescuentoDinamico > 0 && permitePago == "S"){
				$('.msg_dscto_label').show();
			}else{
				$('.msg_dscto_carrito').hide();
				console.log("99");
			}*/

			if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") != "46") {
				if(response.excentoPago == "S"){	
					var paymentAmount = 0;
				}else{
					// let { subtotalCopago, porcentajeDescuentoCopago, valorTotalCopago } = valoresPago;
					// var paymentAmount =  ((valoresPago.valorTotalCopago) * (1 - Number(valoresPago.porcentajeDescuentoCopago) / 100)).toFixed(2);

					let { valor, porcentajeDescuento, valorCanalVirtual  } = valoresPago;
					let porcentajeDescuentoCopago = porcentajeDescuento;
					let subtotalCopago = valor;
					let valorTotalCopago = valorCanalVirtual;
					var paymentAmount =  ((valorTotalCopago) * (1 - Number(porcentajeDescuentoCopago) / 100)).toFixed(2);
				}
			}

			$('.total-pago-nuvei').html('$'+valoresPago.valorCanalVirtual.toFixed(2));

			//fbq('track', steps[5].fbTrack);
			fbq('track', steps[5].fbTrack, {
				value: paymentAmount,
				currency: 'USD'
			});
			fbq('track', 'PageView');

			gtag('event', 'conversion', {'send_to': 'AW-10812404534/UVf_CMWCx4kDELbm4KMo'});

			aplicaProntoPago = response.data.aplicaProntoPago;
			window.onbeforeunload = null;
			let url = url_site + '/pago-online-web?numeroIdentificacion='+getValueFI('numeroIdentificacion')+'&tipoIdentificacion='+getValueFI('tipoIdentificacion')+'&codArticulo='+idReservaSeparada+'&tipoArticulo=CITA';
			
			// https://veris.com.ec/pago-online-ptp/?numeroIdentificacion=1201263975&tipoIdentificacion=2&codArticulo=2191053439&tipoArticulo=CITA
			// let url = url_site + '/pago-online-ptp/?numeroIdentificacion='+getValueFI('numeroIdentificacion')+'&tipoIdentificacion='+getValueFI('tipoIdentificacion')+'&codArticulo='+idReservaSeparada+'&tipoArticulo=CITA';
			
			if(paymentAmount > 0 || $("#convenios option:selected").attr("permitePago-rel") == "N" || aplicaProntoPago == "S"){
				console.log("0");
				if(aplicaProntoPago == "S" && paymentAmount > 0 && $("#convenios option:selected").attr("permitePago-rel") == "S" && $('input[name="central"]:checked').attr("codigoSucursalPX-rel") != "46"){
					console.log("1");
					window.onbeforeunload = null;
					showPasarelaInterna();
				}else{
					window.onbeforeunload = null;
					console.log("2");
					if($("#convenios option:selected").attr("permitePago-rel") == "N" || $('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46"){
						console.log("3");
						$('.actions').hide();
						hideLoader();
						if(!virtual){
							// txtMsgCita = "Tu cita se agendó exitosamente.<br>Recuerda llegar 20 minutos antes de la cita y <br>acercarte a caja para realizar el pago";
							// $('.msg-after-excento').after('<img class="citapresencial" src="https://veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/svg/ico-digiturno.svg">');

							txtMsgCita = "Tu cita se agendó exitosamente. <br>¡Nos vemos pronto!";
							$('.msg-after-excento').after('<img class="citapresencial" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/svg/doctora.svg">');
							$('.box-finalizar-flow').show();
						
						}else{
							txtMsgCita = "Tu cita ha sido agendada.<br>Comunicate con nosotros para gestionar tu pago.";
							$('.msg-after-excento').after('<img class="citapresencial" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/svg/ico-cita-pago.svg">');
							$('.box-finalizar-flow').show();
						}

						if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {
							$('#wizard-t-6').hide();
							$('.title-confirmacion').prepend('<img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold5/images/svg/Icono-Listo.svg">');
							txtMsgCita = "¡Te estamos esperando!";
							$('.titulo-pasarela').html(_nombrePacienteVue);
							$('.box-finalizar-flow').hide();
							$('.box-finalizar-Vue').show();
						}

						$('.msg-after-excento').html(txtMsgCita);
						flagStep = true;
						$('#wizard').steps("next");
					}else{
						console.log("4");
						if($('input[name="central"]:checked').attr("codigoSucursalPX-rel") != "46"){
							console.log(url);
							console.log("Redirecciona");
							location.href = url;
						}else{
							$('.actions').hide();
							hideLoader();
							$('#wizard-t-6').hide();
							$('.title-confirmacion').prepend('<img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold5/images/svg/Icono-Listo.svg">');
							txtMsgCita = "¡Te estamos esperando!";
							$('.titulo-pasarela').text(_nombrePacienteVue);
							$('.box-finalizar-flow').hide();
							$('.box-finalizar-Vue').show();
							('.msg-after-excento').html(txtMsgCita);
							flagStep = true;
							$('#wizard').steps("next");
						}

						// location.href = url;
						// console.log(url);
					}
				}
			}else{
				if(politics && politics.code == 200 && politics.data.isPoliticasAceptadas != true ){
					updatePolitics();
				}
				window.onbeforeunload = null;
				console.log("5");
				$('.actions').hide();
				//Mostrar mensajes dependiendo del convenio/excento y modalidad cita
				hideLoader();
				var esBmi = false;
				if($("#convenios option:selected").html().toLowerCase().indexOf("bmi") >= 0){
					esBmi = true;
				}
				var txtMsgCita = "";
				if(virtual){
					
					/*if(esBmi){
						$('.citavirtual').show();
					}else{
						$('.citapago').show();
					}*/
					txtMsgCita = "Tu cita se agendó exitosamente.<br>Recuerda conectarte 10 minutos antes de la cita.";
					$('.msg-after-excento').after('<img class="citapresencial" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/svg/ico-virtual-cita.svg">');	
					$('.box-finalizar-flow').show();
				}else{
					txtMsgCita = "Tu cita se agendó exitosamente. <br>¡Nos vemos pronto!";
					$('.msg-after-excento').after('<img class="citapresencial" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/svg/doctora.svg">');
					// $('.steps').prepend('<img class="logo logo-mobile" src="https://veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/logo-mobile.png">');
					$('.box-finalizar-flow').show();
				}

				if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {
					$('#wizard-t-6').hide();
					$('.title-confirmacion').prepend('<img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold5/images/svg/Icono-Listo.svg">');
					txtMsgCita = "¡Te estamos esperando!";
					$('.titulo-pasarela').text(_nombrePacienteVue);
					$('.box-finalizar-flow').hide();
					$('.box-finalizar-Vue').show();
				}

				$('.msg-after-excento').html(txtMsgCita);
				console.log("Es excento, es Bmi:"+esBmi);
				flagStep = true;
				$('#wizard').steps("next");
			}
		}else{
			showError("No se pudo reservar cita");
			hideLoader();
		}

	}).fail(function(xhr, status, error) {
		hideLoader();
        // error handling
		let { status: statusResponse, responseJSON } = xhr;
		showError(responseJSON.message);
		console.log('Error de reserva');
		hideLoader();
		console.log(status, error, xhr);
    });

}

function showPasarelaInterna(){
	$('#box-pasarela-embudo').show();
	$('.titulo-pasarela').empty();
	//Prevenir cierre
	// window.onbeforeunload = function() {
	// 	console.log(9);
	// 	return 'Recuerda que para agendar tu cita debes pagarla. Si abandonas esta sección no se agendará.';
	// }

	$('.container-figures').empty();
	$('.title-confirmacion').empty();
	hideLoader();
	flagStep = true;
	$('#wizard').steps("next");
	$('.title-confirmacion').html("Estás solo a un paso de agendar tu cita ");
	$('.img-placetopay').html('<img class="w-100" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoAkold4/images/placeopaycard.png" alt="placetopay">');
	get_detalle_pagos();
	// $('.container-figures').html("AQUI VA LO DE MIGUEL");
}

function groupBy(array, key){
	return array.reduce((result, currentValue) => {(
		result[currentValue.idMedico] = result[currentValue.idMedico] || []).push(
			currentValue
		);
		//console.log(result);
		return result;
	}, {});
}

function getValueFI(idElem){
	return $("#"+idElem).val();
}

function getValueFIByName(nameElem){
	return $('input[name="'+nameElem+'"]:checked').val();
	
}

function showInfo(msg){
	$.toast({
		//heading: 'Atención',
	    text: msg,
	    //icon: 'info',
	    hideAfter: 600000,
	    showHideTransition: 'fade',
	    position: 'top-right',
	    stack: false,
	    loader: false,
	    loaderBg: '#0071ce'
	});
}

function showError(msg, time = 6000){
	$.toast({
		//heading: 'Atención',
	    text: msg,
	    hideAfter: time,
	    showHideTransition: 'fade',
	    position: 'top-right',
	    stack: false,
	    loader: false,
	    loaderBg: '#0071ce'
	});
}

function showLoader(){
	$('body').css('overflow','hidden');
	$('.loader-box').show();
}

function hideLoader(){
	$('body').css('overflow','auto');
	$('.loader-box').hide();
}

function modalConvenios(){
	console.log("elegir convenio");
	obtenerEspecialidades();
	obtenerConvenios();
	$('.modal-convenio').modal('show');
}

async function modalConsultaEspecialidad(){
	console.log("Pregunta luego de elegir especialidad");
	if($("#convenios option:selected").attr("aplicaVerificacionConvenio-rel") == "S" && tieneConvenios){
		console.log(88)
		await validacionConvenio()
	}else{
		console.log(77)
		flagStep = true;
		setTimeout(function(){
			// $('#wizard').steps("next");
		},250);
	}
}

function reloadPage(){
	location.reload();
}

async function doActionStep(index){
	console.log("-----------"+index+"-----------");
	switch(index) {
	    case 1:
	    	//console.log('Obtener Usuario');
	        obtenerUsuario();
	        break;
	    case 2:
			// obtenerConvenios();
			// $('.modal-convenio').modal('show');
	    	if(getValueFIByName('ciudad')){
		    	/*$('.box-especialidades').empty();
		    	if(!flagStep){
		        	$('.modal-motivo-online').modal('show');
		        	setTimeout(function(){
		        		$('#motivo').focus();
		        	},250);
		        }*/

		        modalConvenios();
		    }else{
		    	showError("Debe seleccionar una Ciudad para continuar");
		    }
	        break;
	    case 3:
	    	console.log("luego de elegir especialidad")
	    	if(getValueFIByName('especialidad')){
		    	modalConsultaEspecialidad();
		    	$('.box-centrales').empty();
		    }else{
		    	showError("Debe seleccionar una Especialidad para continuar");
		    }
	        break;
	    case 4:
	    	if(!getValueFIByName('central')){
		    	showError("Debe seleccionar una Central Médica para continuar");
		    }else{
		    	$('.box-centrales').empty();
		    }
	        break;
	    case 5:
	    	if(!flagStep){
		    	showError("Debe seleccionar una Cita para continuar");
		    }
	        break;
	    case 6:
	    	var permiteReserva = $('#convenios').find('option:selected').attr('permiteReserva-rel');
	    	var mensajeBloqueoReserva = $('#convenios').find('option:selected').attr('mensajeBloqueoReserva-rel');
	    	var flagConvenio = $("#tieneConvenio").prop('checked');

	    	if(permiteReserva == "S" || !flagConvenio){
				confirmarCita();
	    	}else{
		    	showError(mensajeBloqueoReserva);
	    	}
	        break;
	    default:
	        console.log('Evento por capturar');
	}
}

var kushki;
var codigoPreTransaccion;
var datosPreTrx;
var detallePago;
async function get_detalle_pagos() {
	jQuery('.actions clearfix').hide();
	var msg_convenios = "Estás solo a un paso de agendar tu cita.<br>Recuerda que para agendar tu cita debes pagarla. Si abandonas esta sección no se agendará.";
	showLoader();
	//idReservaSeparada

	$('#codigoReserva').val(idReservaSeparada);

	var codigoConvenio = "";
	if($("#convenios option:selected").val() != "NA" && $("#tieneConvenio").prop('checked')){
	    codigoConvenio = parseInt($("#convenios option:selected").val());
	}
	if ($('input[name="central"]:checked').attr("codigoSucursalPX-rel") == "46") {
	    codigoConvenio = "";
	}
	var secuenciaAfiliado = $("#convenios option:selected").attr("secuenciaAfiliado-rel");

	var method = '/facturacion/crear_pretransaccion?canalOrigen=VER_CMV';
	var settings = {
		"url": url_services_phantomx+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
		    "idPaciente": infoUsuario.numeroPaciente,
		    "tipoServicio": "CITA",
		    "codigoConvenio": codigoConvenio,
		    "secuenciaAfiliado": secuenciaAfiliado,
		    "listaCitas": [{
		        "codigoReserva": idReservaSeparada
		    }]
		}),

	};
	showInfo(msg_convenios, 15000);
	jQuery.ajax(settings).done(function (responsePre) {
		if(responsePre!=null && responsePre!='' && responsePre!='[]'){
            console.log(responsePre.data);
            datosPreTrx = responsePre;
            if(responsePre.code == 200){
            	codigoPreTransaccion = responsePre.data.codigoPreTransaccion;
            	$('#idPreTransaccion').val(codigoPreTransaccion);
            	var method = '/facturacion/consultar_datos_factura?idPreTransaccion='+responsePre.data.codigoPreTransaccion+'&codigoTipoIdentificacion='+getValueFI('tipoIdentificacion')+'&numeroIdentificacion='+getValueFI('numeroIdentificacion');
				var settings = {
					"url": url_services_phantomx+method,
					"method": "GET",
					"timeout": 0,
					"headers": {
						"Content-Type": "application/json",
						"Authorization": "Bearer "+token
					}

				};
				jQuery.ajax(settings).done(function (response) {
					detallePago = response;
					hideLoader();
					/*Activar Pasarelas*/
					let isOnePasarela = false;
					/*if(response.data.datosFactura.permiteKushki && response.data.datosFactura.permiteKushki == "S"){
						$('.box-kushki').show();
						isOnePasarela = true;
					}else{
						$('.box-kushki').hide();
						$('.btn-cambiar-kushki').hide();
					}*/

					/*if(response.data.datosFactura.permitePlaceToPay && response.data.datosFactura.permitePlaceToPay == "S"){
						if(!isOnePasarela){
							$('.box-PTP').show();
							isOnePasarela = true;
						}
					}else{
						$('.box-PTP').hide();
						$('.btn-cambiar-ptp').hide();
					}*/

					if(response.data.datosFactura.permiteNuvei && response.data.datosFactura.permiteNuvei == "S"){
						$('.box-nuvei').show();
						$('.box-no-nuvei').hide();
					}else{
						$('.box-nuvei').hide();
						$('.box-no-nuvei').show();
					}
					//$('.box-nuvei').hide();
					//$('.box-no-nuvei').show();

					$.each(response.data.detalleServicio.citas, function(key, value){
		            	console.log(value);
		            	//Cargas los detalles de la cita
		            	jQuery('#nombreDeta').html(value.primerNombre +' '+ value.primerApellido +' '+ value.segundoApellido);
		            	jQuery('#consultaDeta').html(value.especialidad);
		            	jQuery('#medicoDeta').html(value.doctor);
		            	jQuery('#centralDeta').html(value.centroMedico);
		            	jQuery('#fechaDeta').html(value.fechaHoraCita);
					});

					// jQuery('#valorDeta').html(response.data.totales.subtotalIva0);
	            	// jQuery('#valorTotalDeta').html(response.data.totales.subtotalIva0);
					// jQuery('#amountPTPTotal').html(response.data.totales.subtotalIva0);

					jQuery('#valorDeta').html(response.data.totales.subtotal);
	            	jQuery('#valorTotalDeta').html(response.data.totales.total);
					jQuery('#amountPTPTotal').html(response.data.totales.total);

					//con lo de arriba autocompletas el form de datos de fact
					jQuery('#tipoIdentificacionFact').val(response.data.datosFactura.codigoTipoIdentificacion)
		            jQuery('#numeroIdentificacionFact').val(response.data.datosFactura.codigoUsuario);
		            jQuery('#primerNombreFact').val(response.data.datosFactura.primerNombre);
		            jQuery('#primerApellidoFact').val(response.data.datosFactura.primerApellido);
		            jQuery('#segundoApellidoFact').val(response.data.datosFactura.segundoApellido);
		            jQuery('#direccionFact').val(response.data.datosFactura.direccion);
		            jQuery('#mailFact').val(response.data.datosFactura.email);
		            jQuery('#telefonoFact').val(response.data.datosFactura.telefonoCelular);

		            isCompleteBill();

		            kushki = new KushkiCheckout({
				        form: "kushki-pay-form",
				        merchant_id: merchantId,
				        amount: response.data.totales.total,//valoresPago.valorCanalVirtual , // Monto total
				        currency: "USD", // Codigo de moneda, por defecto "USD"
				        inTestEnvironment:false,
				        isDeferred: true,
				        is_subscription: false // true si se trata de una suscripcion (pago recurrente); false, si no.
				    });
		            	
				});
            }else{
            	showError(responsePre.message);
            }
            
        }
	}).fail(function(xhr, status, error) {
        // error handling
		hideLoader();
		let { status: statusResponse, responseJSON } = xhr;
		showError("No se pudo realizar la reserva. " + responseJSON.message);
		$('.title.title-confirmacion.titulo-pasarela').html(responseJSON.message);
		$('.title.title-confirmacion.titulo-pasarela').css("margin-top","150px");
		$('#box-pasarela-embudo').hide();
		console.log(status, error, xhr);
    });
    $.toast().reset('all');;
}

async function get_detalle_pagos_old() {
	jQuery('.actions clearfix').hide();
	var msg_convenios = "Estás solo a un paso de agendar tu cita.<br>Recuerda que para agendar tu cita debes pagarla. Si abandonas esta sección no se agendará.";
	showLoader();
	//idReservaSeparada

	$('#codigoReserva').val(idReservaSeparada);

	// https://virtualdev.veris.com.ec/Verisrest/v2/externo/detallepago
	var method = '/Verisrest/v2/externo/detallepago';
	var settings = {
		"url": url_services+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
		    "listaReservas": [
		      {
		        "codigoReserva": idReservaSeparada
		      }
		    ],
		    "idFacturacion": {
		      "tipoIdentificacion": getValueFI('tipoIdentificacion') ,
		      "numeroIdentificacion": getValueFI('numeroIdentificacion'),
		      "idPaciente": null
		    }
		}),

	};
	showInfo(msg_convenios, 15000);
	jQuery.ajax(settings).done(function (response) {
		hideLoader();
		if(response!=null && response!='' && response!='[]'){
            console.log(response.data.citas);
            $.each(response.data.citas, function(key, value){
            	console.log(value);
            	//Cargas los detalles de la cita
            	jQuery('#nombreDeta').html(value.primerNombre +' '+ value.primerApellido +' '+ value.segundoApellido);
            	jQuery('#consultaDeta').html(value.especialidad);
            	jQuery('#medicoDeta').html(value.doctor);
            	jQuery('#centralDeta').html(value.centroMedico);
            	jQuery('#fechaDeta').html(value.hora);
            	jQuery('#valorDeta').html(value.subtotalIva0);
            	jQuery('#valorTotalDeta').html(value.subtotalIva0);
				jQuery('#amountPTPTotal').html(value.subtotalIva0);
            	
            })
            console.log(response.data.datosFacturacion.primerNombre);
            //con lo de arriba autocompletas el form de datos de fact
            jQuery('#numeroIdentificacionFact').val(response.data.datosFacturacion.numeroIdentificacion);
            jQuery('#primerNombreFact').val(response.data.datosFacturacion.primerNombre);
            jQuery('#primerApellidoFact').val(response.data.datosFacturacion.primerApellido);
            jQuery('#segundoApellidoFact').val(response.data.datosFacturacion.segundoApellido);
            jQuery('#direccionFact').val(response.data.datosFacturacion.direccion);
            jQuery('#mailFact').val(response.data.datosFacturacion.mail);
            jQuery('#telefonoFact').val(response.data.datosFacturacion.telefono);

            isCompleteBill();

            kushki = new KushkiCheckout({
		        form: "kushki-pay-form",
		        merchant_id: merchantId,
		        amount: valoresPago.valorTotalCopago , // Monto total
		        currency: "USD", // C�digo de moneda, por defecto "USD"
		        inTestEnvironment:false,
		        isDeferred: true,
		        is_subscription: false // true si se trata de una suscripcion (pago recurrente); false, si no.
		    });
        }
        $.toast().reset('all');
	});
}

function pagarPtp(){
	/*window.onbeforeunload = null;
	showLoader();
	showError("Estamos procesando su link de pago.");
	//Quiero todos los campos de la facturacion asignados a variables
	//https://veris.com.ec/pago-online-ptp/?numeroIdentificacion=0923796304&tipoIdentificacion=2&codArticulo=1686024939&tipoArticulo=CITA
	//process-link-p2p/?tipo_identificacion=%tipo_identificacion%&identificacion=%identificacion%&tnombres=%nombre%&primer_apellido=%primer_apellido%&segundo_apellido=%segundo_apellido%&direccion=%direccion%&correo=%correo%&telefono=%telefono%&tipoP=paquete
    let url = url_site + '/process-link-p2p/?identificacion='+getValueFI('numeroIdentificacion')+'&tipo_identificacion='+getValueFI('tipoIdentificacion')+'&nombre='+getValueFI('primerNombreFact')+'&primer_apellido='+getValueFI('primerApellidoFact')+'&segundo_apellido='+getValueFI('segundoApellidoFact')+'&correo='+getValueFI('mailFact')+'&telefono='+getValueFI('telefonoFact')+'&tipo=link&tipo_articulo=CITA&codigo_articulo='+idReservaSeparada+'&canal_origen=&direccion='+removeCharacters(getValueFI('direccionFact'));
    location.href = url*/
	showLoader();
	let tipoIdentificacionFact = parseInt(jQuery('#tipoIdentificacionFact').val());
	let numeroIdentificacionFact = jQuery('#numeroIdentificacionFact').val();
	let primerNombreFact = jQuery('#primerNombreFact').val();
    let segundoNombreFact = jQuery('#segundoNombreFact').val();
    let primerApellidoFact = jQuery('#primerApellidoFact').val();
    let segundoApellidoFact = jQuery('#segundoApellidoFact').val();
    let direccionFact = jQuery('#direccionFact').val();    
    let mailFact = jQuery('#mailFact').val();
    let telefonoFact = jQuery('#telefonoFact').val();

    let razonSocial = "";
    if(tipoIdentificacionFact == 1){
    	razonSocial = primerNombreFact;
    }

    var agenteUsuario = navigator.userAgent;
    let modeloDispositivo;
	if (/(iPhone)/i.test(agenteUsuario)) {
	   console.log("El usuario está utilizando un iPhone");
	   modeloDispositivo = "Iphone"
	} else if (/(Android)/i.test(agenteUsuario) && /(Mobile)/i.test(agenteUsuario)) {
	   console.log("El usuario está utilizando un teléfono Android");
	   modeloDispositivo = "Android"
	} else {
	   console.log("No se puede determinar el modelo del dispositivo");
	   modeloDispositivo = "PC"
	}

	if(politics && politics.code == 200 && politics.data.isPoliticasAceptadas != true ){
		updatePolitics();
	}


    //Crear Transaccion
    var method = '/facturacion/crear_transaccion_virtual?idPreTransaccion='+codigoPreTransaccion;
	var settings = {
		"url": url_services_phantomx+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
		    "codigoUsuario": numeroIdentificacionFact,
		    // "idPaciente": infoUsuario.numeroPaciente,
			"codigoTipoIdentificacion": tipoIdentificacionFact,
			"numeroIdentificacion": numeroIdentificacionFact,
			"nombreFactura": razonSocial,
			"primerNombre": primerNombreFact,
			"primerApellido": primerApellidoFact,
			"direccionFactura": direccionFact,
			"emailFactura": mailFact,
			"telefonoFactura": telefonoFact,
			"modeloDispositivo": modeloDispositivo,
			"versionSO": "",
			"plataformaOrigen": "WEB",
			"tipoBoton": "PTP",
			"canalOrigenDigital": "VER_CMV"
		}),

	};
	// showInfo(msg_convenios, 15000);
	jQuery.ajax(settings).done(function (response) {
		if(response!=null && response!='' && response!='[]'){
            if(response.code == 200){
            	location.href = response.data.linkPagoPTP;
            }else{
            	showError(response.message);
            }
        }
        hideLoader();
    }).fail(function(xhr, status, error) {
		hideLoader();
		let { status: statusResponse, responseJSON } = xhr;
		showError(responseJSON.message);
		console.log(status, error, xhr);
    });

}

function removeCharacters(str){
	return str.replace("#", "%23");;
}

let dataNuvei;
function getParamsNuvei(){
	var method = '/seguridad/parametrosNuvei?codigoAplicacion=MI_VERIS_WEB';
	var settings = {
		"url": url_services_phantomx+method,
		"method": "GET",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		}
	};
	jQuery.ajax(settings).done(function (response) {
		console.log(response);
		dataNuvei = response.data;
	})
}

let referenceNuvei = '';
function pagarNuvei(){
	showLoader();
	let tipoIdentificacionFact = parseInt(jQuery('#tipoIdentificacionFact').val());
	let numeroIdentificacionFact = jQuery('#numeroIdentificacionFact').val();
	let primerNombreFact = jQuery('#primerNombreFact').val();
    let segundoNombreFact = jQuery('#segundoNombreFact').val();
    let primerApellidoFact = jQuery('#primerApellidoFact').val();
    let segundoApellidoFact = jQuery('#segundoApellidoFact').val();
    let direccionFact = jQuery('#direccionFact').val();    
    let mailFact = jQuery('#mailFact').val();
    let telefonoFact = jQuery('#telefonoFact').val();

    let razonSocial = "";
    if(tipoIdentificacionFact == 1){
    	razonSocial = primerNombreFact;
    }

    var agenteUsuario = navigator.userAgent;
    let modeloDispositivo;
	if (/(iPhone)/i.test(agenteUsuario)) {
	   console.log("El usuario está utilizando un iPhone");
	   modeloDispositivo = "Iphone"
	} else if (/(Android)/i.test(agenteUsuario) && /(Mobile)/i.test(agenteUsuario)) {
	   console.log("El usuario está utilizando un teléfono Android");
	   modeloDispositivo = "Android"
	} else {
	   console.log("No se puede determinar el modelo del dispositivo");
	   modeloDispositivo = "PC"
	}

	if(politics && politics.code == 200 && politics.data.isPoliticasAceptadas != true ){
		updatePolitics();
	}

    //Crear Transaccion
    var method = '/facturacion/crear_transaccion_virtual?idPreTransaccion='+codigoPreTransaccion;
	var settings = {
		"url": url_services_phantomx+method,
		"method": "POST",
		"timeout": 0,
		"headers": {
			"Content-Type": "application/json",
			"Authorization": "Bearer "+token
		},
		"data": JSON.stringify({
		    "codigoUsuario": numeroIdentificacionFact,
		    // "idPaciente": infoUsuario.numeroPaciente,
			"codigoTipoIdentificacion": tipoIdentificacionFact,
			"numeroIdentificacion": numeroIdentificacionFact,
			"nombreFactura": razonSocial,
			"primerNombre": primerNombreFact,
			"primerApellido": primerApellidoFact,
			"direccionFactura": direccionFact,
			"emailFactura": mailFact,
			"telefonoFactura": telefonoFact,
			"modeloDispositivo": modeloDispositivo,
			"versionSO": "",
			"plataformaOrigen": "WEB",
			"tipoBoton": "NUVEI",
			"canalOrigenDigital": "VER_CMV"
		}),

	};
	// showInfo(msg_convenios, 15000);
	jQuery.ajax(settings).done(function (response) {
		if(response!=null && response!='' && response!='[]'){
            if(response.code == 200){
            	referenceNuvei = response;
            	pasarelaNuvei()
            }else{
            	showError(response.message);
            	hideLoader;
            }
        }
    }).fail(function(xhr, status, error) {
		hideLoader();
		let { status: statusResponse, responseJSON } = xhr;
		showError(responseJSON.message);
		console.log(status, error, xhr);
    });

}

function pasarelaNuvei(){
	hideLoader();
	let paymentCheckout = new PaymentCheckout.modal({
	    client_app_code: dataNuvei.applicationCode, // Client Credentials
	    client_app_key: dataNuvei.applicationKey, // Client Credentials
	    locale: 'es', // User's preferred language (es, en, pt). English will be used by default.
	    env_mode: 'prod', // `prod`, `stg`, `local` to change environment. Default is `stg`
	    onOpen: function () {
	    	console.log('modal open');
	    },
	    onClose: function () {
	    	console.log('modal closed');
	    },
	    onResponse: function (response) {
			console.log('modal response');
	        //document.getElementById('response').innerHTML = JSON.stringify(response);
	        if(response.transaction.status == "success" && response.transaction.status_detail == 3){
	        	console.log(JSON.stringify(response));
	        	console.log("Inicio Enviando formulario de pago TC");
	        	$('#btnNuvei').hide();
	        	updatePolitics();
	        	createPostForm(response);
	        	$('#btnNuvei').hide();
	        	showError('Procesando pago, por favor no cierre el navegador.');
	        	showLoader();
	        	/*armar formulario y hacer submit a procesarlo*/
	        	// $('#metodo-pago-form').submit();
	        }else{
	        	console.log(response);
	        	alert("Transacción rechazada, intenta con otra tarjeta");
	        }
	    }
	});

	$('.total-pago-nuvei').html('$'+detallePago.data.totales.total.toFixed(2));

	paymentCheckout.open({
		user_id: String(referenceNuvei.data.codigoTransaccion),
		user_email: infoUsuario.mail, //optional
		user_phone: infoUsuario.telefonoMovil,//optional
		order_description: referenceNuvei.data.reference,
		order_amount: detallePago.data.totales.total,
		order_vat: 0,
		order_taxable_amount: 0,
		order_tax_percentage: 0,
		order_reference: referenceNuvei.data.orderReference,
	});
}

/*$(document).ready(function(){
	$('form').submit(function() {
		if ($('form input[type="submit"]').data('submitted') == '1') {
		    return false;
		}else {
		$('form input[type="submit"]')
		      .attr('data-submitted', '1')
		      .addClass('submitting')
		      .val('Finalizando...');
		}

		return true; // for demo purposes only
	});
	$('input[name=agree]').change(function() {
		if(this.checked) {
		    $('.js-payment-checkout').css("pointer-events","auto");
		}else{
			$('.js-payment-checkout').css("pointer-events","none");
		}
	});
});*/

window.addEventListener('popstate', function () {
	paymentCheckout.close();
});

function createPostForm(response) {
	fbq('track', 'Purchase', {value: valoresPago.valorCanalVirtual, currency: 'USD'});
	// Crear el formulario
	var $form = $('<form>', {
		method: 'POST',
		action: '/procesar-pago-servicios-nuvei'
	});

	var $tipoIdentificacionNuvei = $('<input>', {
		type: 'text',
		name: 'tipoIdentificacionNuvei',
		value: detallePago.data.datosFactura.codigoTipoIdentificacion
	});

	var $numeroIdentificacionNuvei = $('<input>', {
		type: 'text',
		name: 'numeroIdentificacionNuvei',
		value: detallePago.data.datosFactura.codigoUsuario
	});

	var $idPreTransaccionNuvei = $('<input>', {
		type: 'text',
		name: 'idPreTransaccionNuvei',
		value: codigoPreTransaccion
	});

	var $codigoEPagoNuvei = $('<input>', {
		type: 'text',
		name: 'codigoEPagoNuvei',
		value: referenceNuvei.data.codigoTransaccion
	});

	// Campo oculto con el objeto convertido a texto
	var $datosNuvei = $('<input>', {
		type: 'text',
		name: 'datosNuvei',
		value: JSON.stringify(response)
	});

	// Campo oculto con el objeto convertido a texto
	var $codigoReserva = $('<input>', {
		type: 'text',
		name: 'codigoReservaNuvei',
		value: idReservaSeparada
	});

	// Botón de envío
	var $submitButton = $('<input>', {
		type: 'submit',
		value: 'Enviar'
	});


	// Agregar los elementos al formulario
	$form.append($tipoIdentificacionNuvei, $numeroIdentificacionNuvei, $idPreTransaccionNuvei, $codigoEPagoNuvei, $datosNuvei, $submitButton, $codigoReserva, $submitButton);

	// Agregar el formulario a algún lugar en el documento
	$('body').append($form);

	//Enviar formulario
	$form.submit();

}
