const _canalOrigen = "MVE_CMV";
const _plataforma = "WEB";
const _version = "7.8.0";
const _langDate = {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
            }, 
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            }
        }
async function call(args){
    if(args.showLoader || args.showLoader == true){
        showLoader();
    }
    
    let requestOptions = {
        method: args.method,
        redirect: 'follow'
    };
    
    let myHeaders = new Headers();
    myHeaders.append("Accept-Language", "es");
    if(args.bodyType == "json"){
        myHeaders.append("Content-Type", "application/json");
        //requestOptions.headers = myHeaders;
    }
    requestOptions.headers = myHeaders;
        
    // myHeaders.append("Application", _application);
    // myHeaders.append("IdOrganizacion", _idOrganizacion);
    // myHeaders.append("Authorization","Bearer "+ _token);

    if(args.method == "POST" || args.method == "PUT" || args.method == "DELETE"){
        if(args.data){
            requestOptions.body = args.data;
        }
    }
    
    return fetch(args.endpoint, requestOptions)
        .then((response) => {
            return response.json();
        }).then((data) => {
            if(args.showLoader || args.showLoader == true){
                hideLoader();
            }
            if(!args.dismissAlert && data.code == 400){
                window.removeEventListener("beforeunload", beforeUnloadHandler);
                $('#mensaje_400').html(data.message);
                var myModal = new bootstrap.Modal(document.getElementById('modalError400'));
                myModal.show();
                return;
            }
            return data;
        }).catch(function(error) {
            if(args.showLoader || args.showLoader == true){
                hideLoader();
            }
            throw error;
            // toastr.error("Ha ocurrido un problema con la comunicación al servicio requerido, inténtelo en unos momentos.","ERROR");
            //console.log(error);
        });
}

async function callInformes(args) {
    if (args.showLoader) {
        showLoader();
    }

    let requestOptions = {
        method: args.method,
        redirect: 'follow'
    };
    let myHeaders = new Headers();
    if (args.bodyType === "json") {
        myHeaders.append("Content-Type", "application/json");
        requestOptions.headers = myHeaders;
    }
    if (["POST", "PUT", "DELETE"].includes(args.method) && args.data) {
        requestOptions.body = args.data;
    }

    try {
        const response = await fetch(args.endpoint, requestOptions);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const blob = await response.blob();
        if (args.showLoader) {
            hideLoader();
        }

        return blob;
    } catch (error) {
        if (args.showLoader) {
            hideLoader();
        }

        // Construye un objeto de error para devolver información relevante
        let errorInfo = {
            status: error.message.includes('HTTP error') ? parseInt(error.message.replace(/\D/g, '')) : 500, // Extrae el código de estado del mensaje de error, o asume 500 si no es específico
            message: 'Ha ocurrido un problema con la comunicación al servicio requerido, inténtelo en unos momentos.'
        };

        

        return errorInfo;
    }
}


function removeLeadingZero(input, maxLength) {
    input.value = input.value.replace(/^0/, '');
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}

function maxLengthNumber(input, maxLength) {
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}

function showMessage(type,title,message){
	switch(type){
		case 'warning':
			toastr.warning(message,title);
		break;
		case 'success':
			toastr.success(message,title);
		break;
		case 'info':
			toastr.info(message,title);
		break;
		case 'error':
			toastr.error(message,title);
		break;
	}
}

function showLoader(){
	$.blockUI({
        message: '<div class="spinner-border txt-veris" role="status"></div>',
        css: {
			backgroundColor: 'transparent',
			border: '0'
        },
        overlayCSS: {
        	opacity: 0.5
        }
    });
}

function hideLoader(){
	$.unblockUI();
}

function sonNumeros(str) {
    return /^\d+$/.test(str);
}

function getInput(idElem, type = 'input'){
    let valor;
    switch(type){
        case 'input':
        case 'select':
            valor = document.getElementById(idElem).value
        break;
        case 'radio':
            valor = $("input[name='"+idElem+"']:checked").val();
        break;
        case 'fecha':
            valor = document.getElementById(idElem)._flatpickr.getDate();
        break;
        case 'hora':
            valor = document.getElementById(idElem)._flatpickr.getDate();
        break;
        case 'select2':
            //console.log(value);
            valor = $('#'+idElem).val();
        break;
        case 'button':
            // console.log("."+idElem+".active");
            $("."+idElem+".active").attr("id-rel");
        break;
        case 'checkbox':
            // console.log('#'+idElem)
            valor = "I";
            if($('#'+idElem).is(":checked")){
                valor = "A";
            }
        break;
    }
    return valor;
}

function limitarCaracteres(input, maxCaracteres) {
    // Obtén el valor actual del campo de entrada
    var valor = input.value;

    // Limita la longitud del valor a `maxCaracteres`
    if (valor.length > maxCaracteres) {
        valor = valor.slice(0, maxCaracteres);
    }

    // Establece el valor limitado en el campo de entrada
    input.value = valor;
}

function validarNumero(event) {
    // Verifica si el carácter es un número
    if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
        // Previene la entrada del carácter si no es un número
        event.preventDefault();
    }
}

function enmascararEmail(email) {
    // Dividir el correo electrónico en dos partes: nombre de usuario y dominio
    const partes = email.split('@');
    if (partes.length === 2) {
        const usuario = partes[0];
        const dominio = partes[1];

        // Enmascarar el nombre de usuario con asteriscos
        const enmascarado = usuario.charAt(0) + '*'.repeat(usuario.length - 1);

        // Reconstruir el correo electrónico enmascarado
        return enmascarado + '@' + dominio;
    }

    // Devolver el correo electrónico original si no se pudo enmascarar
    return email;
}

async function obtenerIdentificacion(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/tiposIdentificacion`;
    args["method"] = "GET";
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        $.each(data.data, function(key, value){
            $('#tipoIdentificacion').append(`<option value="${value.codigoTipoIdentificacion}">${value.nombreTipoIdentificacion}</option>`);
        })
    }
}

async function obtenerProvincias(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/provincias?codigoPais=1`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        console.log('provincias', data);
        $('#provincia').empty();
        $.each(data.data, function(key, value){
            
            $('#provincia').append(`<option value="${value.codigoProvincia}" codigoRegion-rel="${value.codigoRegion}">${value.nombreProvincia}</option>`);
        })
        
        return data.data;
    }

}

async function obtenerCiudades(codigoCiudades){

    console.log(codigoCiudades);
    let args = [];
    // args["endpoint"] = api_url + `/${api_war}/v1/seguridad/ciudades?codigoPais=1&codigoProvincia="+getInput('provincia');
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/ciudades?codigoPais=1&codigoProvincia=${codigoCiudades}`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200){
        $('#ciudad').empty();
        $.each(data.data, function(key, value){
            $('#ciudad').append(`<option value="${value.codigoCiudad}">${value.nombreCiudad}</option>`);
        })

        return data.data;
    }
}

function isValidEmailAddress(emailAddress) {
    let pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function esValidaCedula(cedula) {
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
                total += parseInt(cad.charAt(i)); // parseInt o concatenarÃ¡ en lugar de sumar
            }
        }

        total = total % 10 ? 10 - total % 10 : 0;

        if (cad.charAt(longitud-1) == total) {
            //document.getElementById("salida").innerHTML = ("Cedula VÃ¡lida");
            return true;
        }else{
            //document.getElementById("salida").innerHTML = ("Cedula InvÃ¡lida");
            return false;
        }
    }

    return false;
}

async function verificarCuenta() {
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?tipoIdentificacion=${getInput('tipoIdentificacion')}&numeroIdentificacion=${getInput('numeroIdentificacion')}`;
    args["method"] = "GET";
    args["dismissAlert"] = true;
    args["showLoader"] = false;

    try {
        const data = await call(args);
        if ('code' in data && data.code == 200 && data.data != null) {
            return true;
        }
    } catch (error) {
        console.error("Error al verificar la cuenta:", error);
    }

    return false;
}

function actualizarMaxlength(select) {
    let numeroIdentificacionInput = document.getElementById('numeroIdentificacion');
    if (select.value == "3") {
        numeroIdentificacionInput.setAttribute('maxlength', '13');
        numeroIdentificacionInput.type = "text";
        numeroIdentificacionInput.onkeypress = function (event) {
        var charCode = event.charCode;
        // Permitir caracteres alfabéticos (letras) y numéricos (números)
        if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode >= 48 && charCode <= 57)) {
            return true;
        }
        // Permitir teclas de control (backspace, enter)
        if (charCode == 8 || charCode == 13) {
            return true;
        }
        // Restringir otros caracteres
        return false;
    };

    } else {
        numeroIdentificacionInput.setAttribute('maxlength', '10');
        numeroIdentificacionInput.type = "number";
        numeroIdentificacionInput.onkeypress = function (event) {
            return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57;
        };
    }
}

async function registrarCuenta(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    let fechaParts = getInput('fechaNacimiento').split('-');
    let fechaFormateada = fechaParts[2] + '/' + fechaParts[1] + '/' + fechaParts[0];

    args["data"] = JSON.stringify({
        "tipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
        "numeroIdentificacion": getInput('numeroIdentificacion'),
        "primerApellido": getInput('primerApellido'),
        "segundoApellido": getInput('segundoApellido'),
        "primerNombre": getInput('primerNombre'),
        "mail": getInput('mail'),
        "fechaNacimiento": fechaFormateada,
        "genero": getInput('genero'),
        "telfMovil": getInput('telefono'),
        "codPais": 1,
        "codigoProv": parseInt(getInput('provincia')),
        "codigoCiudad": parseInt(getInput('ciudad')),
        "pass": getInput('password'),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    return data;
}

async function confirmarCuenta(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta/activacion`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "tipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
        "numeroIdentificacion": getInput('numeroIdentificacion'),
        "codigoActivacion": parseInt(getInput('codigoActivacion')),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    return data;
}

async function codigoReset(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/codigoreset`;
    args["method"] = "POST";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "tipoIdentificacion": parseInt(getInput('tipoIdentificacion')),
        "numeroIdentificacion": getInput('numeroIdentificacion'),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    return data;
}

async function recuperarContrasena(){
    let args = [];
    args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta/clave`;
    args["method"] = "PUT";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "codigoUsuario": params.numeroIdentificacion,
        "codigoAutorizacion": parseInt(getInput('codigoAutorizacion')),
        "nuevaClave": getInput('password'),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    if(data.code == 200){
        title = "Contraseña modificada";
        msg = "Tu contraseña ha sido modificada con éxito"
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
        title = 'Veris';
        msg = `<span class="txt-alt">${recuperar.message}</span>`;
        $('#modalAlertButtonAccion').addClass('d-none');
        $('#modalAlertButton').removeClass('d-none');
        $('#modalAlertTitle').html(title);
        $('#modalAlertMessage').html(msg);
        $('#modalAlert').modal('show');
    }
    return data;
}


// funciones para el filtro pendientes, realizadas 

async function aplicarFiltros(contexto) {
    console.log("***********----------************")
    console.log('contexto', contexto);
    const pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
    const parentesco = $('input[name="listGroupRadios"]:checked').attr('parentesco');
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';
    const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
    if (parentesco === 'YO') {

        esAdmin = 'S';
    }
    let estadoTratamiento;

    if ($('#pills-pendientes-tab').attr('aria-selected') === 'true') {
        estadoTratamiento = 'PENDIENTE';
    } else if ($('#pills-realizados-tab').attr('aria-selected') === 'true') {
        estadoTratamiento = 'REALIZADO';
    }

    fechaDesde = formatearFecha(fechaDesde);
    fechaHasta = formatearFecha(fechaHasta);

    if (contexto === 'contextoAplicarFiltros') {
        console.log('exito');
        await obtenerTratamientosId(pacienteSeleccionado, fechaDesde, fechaHasta, estadoTratamiento, esAdmin);
        $('#filtroTratamientos').offcanvas('hide');
    }
}

async function aplicarFiltrosCitas(contexto) {
    const pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
    console.log('pacientexx', pacienteSeleccionado);  
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';
    const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
    let estadoCitas;
    if (document.getElementById('pills-actuales-tab').getAttribute('aria-selected') === 'true') {
        estadoCitas = 'ACTUAL';
    } else if (document.getElementById('pills-historial-tab').getAttribute('aria-selected') === 'true') {
        estadoCitas = 'HISTORICO';
    }

    console.log('estadoCitas', estadoCitas);    
    if (contexto === 'contextoAplicarFiltros') {
        if (estadoCitas === 'ACTUAL'){
            await obtenerCitas(fechaDesde, fechaHasta, pacienteSeleccionado, esAdmin, estadoCitas);
        }
        else if (estadoCitas === 'HISTORICO'){
            await obtenerHistorialCitas(fechaDesde, fechaHasta, pacienteSeleccionado, esAdmin, estadoCitas);
        }

    }
    $('#filtroTratamientos').offcanvas('hide');
    console.log("***********----------************")
}

// limpiar filtros
async function limpiarFiltros(contexto) {
    if (contexto === 'contextoLimpiarFiltros') {
        $('input[name="listGroupRadios"]').prop('checked', false);
        $('input[name="listGroupRadios"]').first().prop('checked', true);
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        let estado = document.getElementById('pills-pendientes-tab').getAttribute('aria-selected');
        if (estado === 'true') {
            await obtenerTratamientosId('', '', '', 'PENDIENTE');
            $('#filtroTratamientos').offcanvas('hide');
        } else {
            await obtenerTratamientosId('', '', '', 'REALIZADO');
            $('#filtroTratamientos').offcanvas('hide');
        }
    }
}

// aplicar filtros para resultados
async function aplicarFiltrosResultados(contexto, tipoServicio) {
    
    // capturar los datos de data-rel del input radio
    let datos = $('input[name="listGroupRadios"]:checked').attr('data-rel');
    datos = JSON.parse(datos);
    console.log('datosI8I',datos);
    let pacienteSeleccionado = datos.numeroIdentificacion;
    let tipoIdentificacion = datos.tipoIdentificacion;
    let esAdmin = datos.esAdmin;
    

    console.log('paciente',datos.tipoIdentificacion);
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';

    fechaDesde = formatearFecha(fechaDesde);
    fechaHasta = formatearFecha(fechaHasta);

    if (contexto === 'contextoAplicarFiltros') {
        console.log('exito');
        await consultarResultadosPorTipo(pacienteSeleccionado, tipoIdentificacion, fechaDesde, fechaHasta, tipoServicio, esAdmin);
        $('#filtroTratamientos').offcanvas('hide');
    }
}

// limpiar filtros para resultados
async function limpiarFiltrosResultados(contexto, tipoServicio) {
    if (contexto === 'contextoLimpiarFiltros') {
        $('input[name="listGroupRadios"]').prop('checked', false);
        $('input[name="listGroupRadios"]').first().prop('checked', true);
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        let pacienteSeleccionado = "{{ Session::get('userData')->numeroIdentificacion }}";
        let  tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        await consultarResultadosPorTipo(pacienteSeleccionado, tipoIdentificacion, '', '', tipoServicio, 'S');
    }
}


//aplicarfiltro ordenes externas
async function aplicarFiltrosOrdenesExternas(contexto) {
    
    // capturar los datos de data-rel del input radio
    let datos = $('input[name="listGroupRadios"]:checked').attr('data-rel');
    datos = JSON.parse(datos);
    console.log('datosI8I',datos.numeroIdentificacion);
    let pacienteSeleccionado = datos.numeroIdentificacion
    let tipoIdentificacion = datos.tipoIdentificacion;
    let esAdmin = datos.esAdmin;
    if (datos.parentesco === 'YO') {
        esAdmin = 'S';
    }

    console.log('paciente',datos.tipoIdentificacion);
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';

    fechaDesde = formatearFecha(fechaDesde);
    fechaHasta = formatearFecha(fechaHasta);

    if (contexto === 'contextoAplicarFiltros') {
        console.log('exito');
        await consultarOrdenesExternasLaboratorio(pacienteSeleccionado, tipoIdentificacion, fechaDesde, fechaHasta, esAdmin);
        $('#filtroTratamientos').offcanvas('hide');
    }
}

// limpiar filtros para ordenes externas

async function limpiarFiltrosOrdenesExternas(contexto, numeroIdentificacion, tipoIdentificacionn) {
    if (contexto === 'contextoLimpiarFiltros') {
        $('input[name="listGroupRadios"]').prop('checked', false);
        $('input[name="listGroupRadios"]').first().prop('checked', true);
        
        let pacienteSeleccionado = numeroIdentificacion
        let  tipoIdentificacion = tipoIdentificacionn;
        await consultarOrdenesExternasLaboratorio(pacienteSeleccionado, tipoIdentificacion, '', '', 'S');
        $('#filtroTratamientos').offcanvas('hide');
    }

}


// formatear fecha
function formatearFecha(fecha) {
    if (!fecha) return '';

    const fechaObj = new Date(fecha);
    if (isNaN(fechaObj.getTime())) return '';

    const dia = fechaObj.getDate().toString().padStart(2, '0');
    const mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
    const año = fechaObj.getFullYear();

    return `${dia}/${mes}/${año}`;
}


// mostrar lista de pacientes
function mostrarListaPacientesFiltro(){
    let data = familiar;
    let divContenedor = $('.listaPacientesFiltro');
    divContenedor.empty();
    data.forEach((Pacientes) => {
        let elemento = `<div class="position-relative">
                            <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="listGroupRadios-${Pacientes.numeroPaciente}" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} >
                            <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="listGroupRadios-${Pacientes.numeroPaciente}">
                                <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}</p>
                                <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</span>
                            </label>
                        </div>`;
        divContenedor.append(elemento);
    });
}

async function verificarImagen(urlImagen) {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = function() {
            // La imagen se cargó exitosamente
            resolve(true);
        };
        img.onerror = function() {
            // Hubo un error al cargar la imagen
            resolve(false);
        };
        img.src = urlImagen;
    });
}


// async function verificarImagen(urlImagen, callback) {
//     var img = new Image();
//         img.onload = function() {
//         // La imagen se cargó exitosamente
//         callback(true);
//     };

//     img.onerror = function() {
//         // Hubo un error al cargar la imagen
//         callback(false);
//     };
//     img.src = urlImagen;
// }

// Ejemplo de uso
/*var urlImagen = 'https://ejemplo.com/imagen.jpg';

verificarImagen(urlImagen, function(existeImagen) {
    if (existeImagen) {
        console.log('La imagen existe y es accesible.');
    } else {
        console.log('La imagen no existe o no es accesible.');
    }
});*/

function roundToDraw(porcentajeAvanceTratamiento){
    return ((porcentajeAvanceTratamiento % 10 >= 5) ? Math.ceil(porcentajeAvanceTratamiento / 10) * 10 : Math.floor(porcentajeAvanceTratamiento / 10) * 10);
}

// Función para capitalizar la primera letra
function capitalizarPrimeraLetra(texto) {
    // Verificar si el texto es null o undefined
    if (texto === null || texto === undefined) {
        return '';
    }

    try {
        // Intenta realizar la capitalización
        return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
    } catch (error) {
        // En caso de error, imprime el error en la consola y retorna una cadena vacía
        console.error("Error al capitalizar:", error);
        return '';
    }
}



function capitalizarCadaPalabra(texto) {
    return texto.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ');
}

function capitalizarPalabrasUnidasPorGuion(cadena) {
    return cadena
    .split('-')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
    .join('-');
}

function agregarEspacios(cadena) {
    return cadena.replace(/\//g, ' / ');
}

function beforeUnloadHandler(event){
    // const beforeUnloadHandler = (event) => {
    // Recommended
    event.preventDefault();
    // Included for legacy support, e.g. Chrome/Edge < 119
    event.returnValue = true;
};

function formatearNumero(numero) {
    return numero.toFixed(2);
}

function truncateText(text, maxLength) {
    return text.length > maxLength ? text.slice(0, maxLength - 3) + '...' : text;
}

function determinarMeridiano(horaInicio){
    let partesHora = horaInicio.split(':');
    let hora = parseInt(partesHora[0]);
    let meridiano = "AM";
    if (hora >= 12) {
        meridiano = "PM";
    }
    return meridiano;
}



const determinarFechaCaducidadEncabezado = (datos, datosTratamiento) => {
    let dataFechas;
    
    if (Object.keys(datosTratamiento.datosConvenio).length > 0) {
        if (datos.estado == "PENDIENTE_AGENDAR" || datos.estado == null) {
            
            if (datos.esCaducado == "S") {
                if(datos.fechaCaducidad == null){
                    dataFechas = ``;
                } else {
                    dataFechas = `<p class="fs--2 fw-light mb-2">Orden expirada: <b class="fecha-cita fw-light text-danger me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
                }
            } else {
                // orden valida
                if(datos.fechaCaducidad == null){
                    
                    dataFechas = ``;
                    
                } else {
                    dataFechas = `<p class="fs--2 fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary-veris me-2">${determinarValoresNull(datos.fechaCaducidad)}</b></p>`;
            
                }
            }
        }
        else {
            dataFechas = ``;
        }
    } else {
        dataFechas = ``;
    }
    
    return dataFechas;
};