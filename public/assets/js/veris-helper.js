const _canalOrigen = "MVE_CMV";
const _plataforma = "WEB";
const _version = "7.8.0";

async function call(args){
    if(args.showLoader || args.showLoader == true){
        showLoader();
    }
    
    let requestOptions = {
        method: args.method,
        redirect: 'follow'
    };
    
    let myHeaders = new Headers();
    if(args.bodyType == "json"){
        myHeaders.append("Content-Type", "application/json");
        requestOptions.headers = myHeaders;
    }
        
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
            return data;
        }).catch(function(error) {
            if(args.showLoader || args.showLoader == true){
                hideLoader();
            }
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
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/tiposIdentificacion";
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
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/provincias?codigoPais=1";
    args["method"] = "GET";
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
    // args["endpoint"] = api_url + "/digitalestest/v1/seguridad/ciudades?codigoPais=1&codigoProvincia="+getInput('provincia');
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/ciudades?codigoPais=1&codigoProvincia="+codigoCiudades;
    args["method"] = "GET";
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

async function verificarCuenta(){
    let args = [];
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/cuenta?tipoIdentificacion="+getInput('tipoIdentificacion')+"&numeroIdentificacion="+getInput('numeroIdentificacion');
    args["method"] = "GET";
    args["showLoader"] = false;

    const data = await call(args);
    if(data.code == 200 && data.data != null){
        return true;
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
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/cuenta";
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
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/cuenta/activacion";
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
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/codigoreset";
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
    args["endpoint"] = api_url + "/digitalestest/v1/seguridad/cuenta/clave";
    args["method"] = "PUT";
    args["showLoader"] = true;
    args["bodyType"] = "json";
    args["data"] = JSON.stringify({
        "codigoUsuario": codigoUsuario,
        "codigoAutorizacion": parseInt(getInput('codigoAutorizacion')),
        "nuevaClave": getInput('password'),
        "canalOrigenDigital": _canalOrigen
    });

    const data = await call(args);
    return data;
}


// funciones para el filtro pendientes, realizadas 

async function aplicarFiltros(contexto) {
    const pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
    let fechaDesde = $('#fechaDesde').val() || '';
    let fechaHasta = $('#fechaHasta').val() || '';
    const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
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
    
    let pacienteSeleccionado = datos.tipoIdentificacion;
    let tipoIdentificacion = datos.numeroIdentificacion;
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
        let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                            <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} unchecked>
                            <span class="text-veris fw-bold">
                                
                                ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                            </span>
                        </label>`;
        divContenedor.append(elemento);
    });
}

function verificarImagen(urlImagen, callback) {
    var img = new Image();
        img.onload = function() {
        // La imagen se cargó exitosamente
        callback(true);
    };

    img.onerror = function() {
        // Hubo un error al cargar la imagen
        callback(false);
    };
    img.src = urlImagen;
}

// Ejemplo de uso
var urlImagen = 'https://ejemplo.com/imagen.jpg';

verificarImagen(urlImagen, function(existeImagen) {
    if (existeImagen) {
        console.log('La imagen existe y es accesible.');
    } else {
        console.log('La imagen no existe o no es accesible.');
    }
});