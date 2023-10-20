$(document).ready(function() {
    
    if (localStorage.getItem('sessionTime') === null) {
        localStorage.setItem('sessionTime', new Date().getTime());
    }

    setInterval(checkAndUpdateToken, 15 * 60 * 1000);

});

function logout(){
    localStorage.removeItem('sessionTime');
    window.location.href = "/logout";
}

function checkAndUpdateToken() {
    console.log("Verificar si existe una sesión y ha transcurrido al menos 15 minutos");
    var sessionTime = localStorage.getItem('sessionTime');
    
    // Verificar si existe una sesión y ha transcurrido al menos 25 minutos
    if (sessionTime && new Date().getTime() - sessionTime >= 15 * 60 * 1000) {
        // Actualizar el token
        updateToken();
        // Reiniciar la hora de sesión
        localStorage.setItem('sessionTime', new Date().getTime());
    }
}

async function updateToken() {
    // Realizar una solicitud para actualizar el token
    console.log("Realizar una solicitud para actualizar el token");
    let args = [];
    args["endpoint"] = url_site+"/refreshToken";
    args["method"] = "GET";
    args["bodyType"] = "json";
    args["showLoader"] = false;

    const data = await call(args);
    console.log(data);
    if(!data || data.code != 200){
        //showMessage("warning","Atención",data.message);
        logout();
    }else{
        _token = data.idToken;
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
    if(args.bodyType == "json"){
        myHeaders.append("Content-Type", "application/json");
        requestOptions.headers = myHeaders;
    }
        
    myHeaders.append("Application", _application);
    myHeaders.append("IdOrganizacion", _idOrganizacion);
    myHeaders.append("Authorization","Bearer "+ _token);

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
            toastr.error("Ha ocurrido un problema con la comunicación al servicio requerido, inténtelo en unos momentos.","ERROR");
            //console.log(error);
        });
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