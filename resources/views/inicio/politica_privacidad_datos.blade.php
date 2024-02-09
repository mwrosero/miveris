@extends('template.app-template-veris')
@section('title')
Mi Veris - Politica-privacidad-datos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- modal datos actualizados -->
    <div class="modal fade" id="mensajeDatosActualizados" tabindex="-1" aria-labelledby="mensajeDatosActualizadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Revisa tu correo</p>
                    <p class="fs--1 m-0">Confirma la actualización de tus datos en el correo electrónico que te enviamos</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajeActualizarPoliticas" tabindex="-1" aria-labelledby="mensajeActualizarPoliticasLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Datos actualizados correctamente</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Política de privacidad de datos') }}</h5>
    </div>
    <div class="row g-0 justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card bg-transparent shadow-none">
                <div class="card-body pt-5">
                    <form class="row g-3">
                        @csrf
                        <div class="col-12 justify-content-center align-items-center">
                            <h5 class="text-center fw-bold mb-2">{{ __('Confirmación de política de privacidad de datos personales') }}</h5>
                            <p class="text-center mb-4">{{ __('ARCO (Acceso-Rectificación - Cancelación - Oposición)' )}}</p>
                        </div>
                        <div class="col-md-6 border-lg-end">
                            <div class="d-flex justify-content-between">
                                <p class="lh-normal mb-0">{{ __('Rectificación de datos personales') }}</p>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioRectificacion" id="inlineRadioRectificacionNo" value="option1" >
                                        <label class="form-check-label cursor-pointer" for="inlineRadioRectificacionNo">{{ __('No') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioRectificacion" id="inlineRadioRectificacionSi" value="option2" checked>
                                        <label class="form-check-label cursor-pointer" for="inlineRadioRectificacionSi">{{ __('Si') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-lg-start ps-lg-4">
                            <div class="d-flex justify-content-between">
                                <p class="lh-normal mb-0">{{ __('Cancelación / Oposición de datos personales') }}</p>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioCancelacion" id="inlineRadioCancelacionNo" value="option1">
                                        <label class="form-check-label cursor-pointer" for="inlineRadioCancelacionNo">{{ __('No') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioCancelacion" id="inlineRadioCancelacionSi" value="option2">
                                        <label class="form-check-label cursor-pointer" for="inlineRadioCancelacionSi">{{ __('Si') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center mt-4 pt-2">Datos</h5>
                        <div class="col-md-3">
                            <label for="primerNombre" class="form-label fw-bold">Primer nombre</label>
                            <input type="text" class="form-control border-desaturated" name="primerNombre" id="primerNombre" required readonly />

                            <div class="invalid-feedback">
                                Ingrese su primer nombre.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="segundoNombre" class="form-label fw-bold">Segundo nombre</label>
                            <input type="text" class="form-control border-desaturated" name="segundoNombre" id="segundoNombre" required readonly/>
                            <div class="invalid-feedback">
                                Ingrese su segundo nombre.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="prmerApellido" class="form-label fw-bold">Primer apellido</label>
                            <input type="text" class="form-control border-desaturated" name="prmerApellido" id="prmerApellido" required readonly/>
                            <div class="invalid-feedback">
                                Ingrese su primer apellido.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="segundoApellido" class="form-label fw-bold">Segundo apellido</label>
                            <input type="text" class="form-control border-desaturated" name="segundoApellido" id="segundoApellido" required readonly/>
                            <div class="invalid-feedback">
                                Ingrese su segundo apellido.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="fechaNacimiento" class="form-label fw-bold">Fecha de nacimiento</label>
                            <input type="text" class="form-control border-desaturated" name="fechaNacimiento" id="fechaNacimiento" required readonly />
                            <div class="invalid-feedback">
                                Ingrese su fecha de naciemiento.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="sexo" class="form-label fw-bold">Sexo</label>
                            <select class="form-select border-desaturated custom-select-disabled" name="sexo" id="sexo" required >
                                <!-- Opciones del select aquí -->
                                <option value="0">Elegir</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="numeroIdentificacion" class="form-label fw-bold">Número de identificación</label>
                            <input type="text" class="form-control border-desaturated" name="numeroIdentificacion" id="numeroIdentificacion" required readonly/>
                            <div class="invalid-feedback">
                                Ingrese su número de identificación.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-bold">Número de teléfono</label>
                            <input type="number" class="form-control border-desaturated" name="telefono" id="telefono" required readonly/>
                            <div class="invalid-feedback">
                                Ingrese un número de teléfono.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="correoElctronico" class="form-label fw-bold">Correo electrónico</label>
                            <input type="email" class="form-control border-desaturated" name="correoElctronico" id="correoElctronico" required  readonly/>
                            <div class="invalid-feedback">
                                Ingrese un correo electrónico.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pais" class="form-label fw-bold">País</label>
                            <select class="form-select border-desaturated custom-select-disabled" name="pais" id="pais" required disabled>
                                <!-- Opciones del select aquí -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="provincia" class="form-label fw-bold">Provincia</label>
                            <select class="form-select border-desaturated custom-select-disabled" name="provincia" id="provincia" required disabled >
                                <!-- Opciones del select aquí -->
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label fw-bold">Ciudad</label>
                            <select class="form-select border-desaturated custom-select-disabled" name="ciudad" id="ciudad" required disabled >
                                
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dirección" class="form-label fw-bold">Dirección</label>
                            <input type="text" class="form-control border-desaturated" name="direccion" id="direccion" required readonly/>
                            <div class="invalid-feedback">
                                Ingrese su dirección.
                            </div>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button class="btn btn-primary-veris w-50 py-3" id="botonConfirmarPDP">{{ __('Guardar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    

<script>

    //variables globales

    let codeprovincia;
    let identificacion;
    let datosUsuario = [];
    let provincias = [];
    let ciudades = [];
    let sexo;

    // llamada al dom
    document.addEventListener('DOMContentLoaded', async function() {
        const respone = await obtenerPPD();
        console.log('dsd',respone);
        if(respone.code == 200){
            console.log('respone.data.estadoPoliticas',respone.data.estadoPoliticas);
            if((respone.data.estadoPoliticas == 'N' || respone.data.estadoPoliticas == 'R') && respone.data.isPoliticasAceptadas == false){
                $('#inlineRadioCancelacionNo').prop('checked', true);
            }else{
                $('#inlineRadioCancelacionSi').prop('checked', true);
            }
        }
        await obtenerDatosUsuario();
        provincias = await obtenerProvincias();
        ciudades = await obtenerCiudades(codeprovincia);
        llenarDatosUsuario(provincias, ciudades);

        toggleFieldsBasedOnRectificationOption();

        $('input[name="inlineRadioRectificacion"]').on('click', function () {
            toggleFieldsBasedOnRectificationOption();
        });

        //  cancelacion/ oposicion
        $('input[name="inlineRadioCancelacion"]').on('click', function () {
            toggleFieldsBasedOnCancelationOption();
        });
    });

    //obtener datos usuario

    async function obtenerDatosUsuario() {
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/seguridad/cuenta?canalOrigen=${_canalOrigen}&tipoIdentificacion={{Session::get('userData')->codigoTipoIdentificacion}}&numeroIdentificacion={{Session::get('userData')->numeroIdentificacion}}`;
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        
        const data = await call(args);
        console.log('datosUsuario',data);
        if (data.code == 200) {
            datosUsuario = data.data;
            sexo = data.data.sexo;
            codeprovincia = data.data.codigoProvincia;
            identificacion = data.data.numeroIdentificacion;
        }
    } 

    //setear los datos del usuario
    function llenarDatosUsuario(provincias , ciudades){
        
        $('#primerNombre').val(datosUsuario.primerNombre);
        $('#segundoNombre').val(datosUsuario.segundoNombre);
        $('#prmerApellido').val(datosUsuario.primerApellido);
        $('#segundoApellido').val(datosUsuario.segundoApellido);
        $('#fechaNacimiento').val(datosUsuario.fechaNacimiento);
        $('#numeroIdentificacion').val(datosUsuario.numeroIdentificacion);
        $('#telefono').val(datosUsuario.telefonoMovil);
        $('#correoElctronico').val(datosUsuario.mail);
        $('#dirección').val(datosUsuario.direccionDomicilio);

        // capitalizar los campos
        $('#primerNombre').val(capitalizarElemento($('#primerNombre').val()));
        $('#segundoNombre').val(capitalizarElemento($('#segundoNombre').val()));
        $('#prmerApellido').val(capitalizarElemento($('#prmerApellido').val()));
        $('#segundoApellido').val(capitalizarElemento($('#segundoApellido').val()));
        $('#direccion').val(capitalizarElemento($('#direccion').val()));
        
    
        // llenar el select de provincia
        $.each(provincias, function (index, value) {
            var nombreProvinciaCapitalizado = capitalizarElemento(value.nombreProvincia);
            if (value.codigoProvincia == datosUsuario.codigoProvincia) {
                $('#provincia').append('<option value="' + value.codigoProvincia + '" selected>' + nombreProvinciaCapitalizado + '</option>');
            } else {
                $('#provincia').append('<option value="' + value.codigoProvincia + '">' + nombreProvinciaCapitalizado + '</option>');
            }
        });

        // llenar el select de ciudad
        $.each(ciudades, function (index, value) {
            var nombreCiudadCapitalizado = capitalizarElemento(value.nombreCiudad);
            if (value.codigoCiudad == datosUsuario.codigoCiudad) {
                $('#ciudad').append('<option value="' + value.codigoCiudad + '" selected>' + nombreCiudadCapitalizado + '</option>');
            } else {
                $('#ciudad').append('<option value="' + value.codigoCiudad + '">' + nombreCiudadCapitalizado + '</option>');
            }
        });


        // llenar el select de pais con datos quemados
        $('#pais').append('<option value="1" selected>Ecuador</option>');

        // llenar el select de sexo
        
        // setear el sexo del usuario con la variable sexo
        $('#sexo').val(sexo);

    }
        

    //metodos jquery
    // boton confirmar politicas
    $('#botonConfirmarPDP').click(async function (e) {
        e.preventDefault();
        console.log('click');
        $(this).prop('disabled', true); // Disable the button
        await aceptarPoliticas();
        $(this).prop('disabled', false); // Re-enable the button

        await actualizarDatosUsuario();
        await enviarCorreoConfirmacion();
        await obtenerPPD();
        
    });


    // funciones asyncronas
    // aceptar politicas
    async function aceptarPoliticas(){
        
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            
            "aceptaPoliticas": $('#inlineRadioCancelacionNo').prop('checked') ? false : $('#inlineRadioCancelacionSi').prop('checked') ? true : false,
            "versionPoliticas": localStorage.getItem('ultimaVersionPoliticas'),
            "codigoEmpresa": 1,
            "plataforma": "WEB",
            "versionPlataforma": "7.0.1",
            "identificacion": "{{ Session::get('userData')->numeroIdentificacion }}",
            "tipoIdentificacion": {{ Session::get('userData')->codigoTipoIdentificacion }},
            "tipoEvento": "CR",
            "canalOrigen": _canalOrigen

        });
        const data = await call(args);
        
        return data;
    }
    //obtener las politicas
    async function obtenerPPD(){
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1";
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log('data',data.code);
        if(data.code == 200){
            localStorage.setItem('estadoPoliticas', data.data.estadoPoliticas);
            localStorage.setItem('isPoliticasAceptadas', data.data.isPoliticasAceptadas);
            localStorage.setItem('ultimaVersionPoliticas', data.data.ultimaVersionPoliticas);
        }
        return data;
    }

    //actualizar datos del usuario
    async function actualizarDatosUsuario() {
        console.log($('#direccion').val());
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/perfil"
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            "tipoIdentificacion": "{{ Session::get('userData')->codigoTipoIdentificacion }}",
            "numeroIdentificacion": "{{ Session::get('userData')->numeroIdentificacion }}",
            "primerNombre": $('#primerNombre').val(),
            "primerApellido": $('#primerApellido').val(),
            "segundoNombre": $('#segundoNombre').val(),
            "segundoApellido": $('#segundoApellido').val(),
            "mail": $('#correoElctronico').val(),
            "telefonoMovil": $('#telefono').val(),
            "codigoProvincia": $('#provincia').val(),
            "codigoCiudad": $('#ciudad').val(),
            "direccion": $('#direccion').val(),
            "sexo": $('#sexo').val(),
            
        });
        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        

    }

    // enviar correo de confirmacion post 
    async function enviarCorreoConfirmacion() {
        console.log('enviarCorreoConfirmacion');
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/enviaMailConfirmacionPolitica "
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            // enviar datos del formulario
            "usuario": "{{ Session::get('userData')->numeroIdentificacion }}",
            "idPaciente": {{ Session::get('userData')->numeroPaciente }},
            "aceptaPoliticas": true,
            "primerNombre": $('#primerNombre').val(),
            "segundoNombre": $('#segundoNombre').val(),
            "primerApellido": $('#prmerApellido').val(),
            "segundoApellido": $('#segundoApellido').val(),
            "fechaNacimiento": "12/12/1990", // obtenerFechaNacimiento($('#fechaNacimiento').val()),
            "telefono": $('#telefono').val(),
            "mail": $('#correoElctronico').val(),
            "direccion": $('#direccion').val(),
            "codigoCiudad": datosUsuario.codigoPais + "-" + datosUsuario.codigoProvincia + "-" + $('#ciudad').val(),
            "canalOrigenDigital": "APP_CMV"
        });
        const data = await call(args);
        console.log('enviarCorreoConfirmacion',data);

        if (data.code == 200) {
            // revisa tu correo mostrar modal
            $('#mensajeDatosActualizados').modal('show');

        }
        return data;
    }


    //obtener fecha de nacimiento en formato dd/mm/yyyy y devolver un string
    function obtenerFechaNacimiento(fecha) {
        let fechaNacimiento = new Date(fecha);
        let dia = fechaNacimiento.getDate();
        let mes = fechaNacimiento.getMonth() + 1;
        let anio = fechaNacimiento.getFullYear();
        return `${dia}/${mes}/${anio}`;
    }

    // actualizar el select de ciudades cuando selecciono provincia
   $( "#provincia").change(async function () {
        let codeprovincia = $(this).val();
        ciudades = await obtenerCiudades(codeprovincia);
        $('#ciudad').empty();
        $.each(ciudades, function (index, value) {
            $('#ciudad').append('<option value="' + value.codigoCiudad + '">' + value.nombreCiudad + '</option>');
        });
    });

    function toggleFieldsBasedOnRectificationOption() {
        const isRectificationYesChecked = $('#inlineRadioRectificacionSi').is(':checked');

        // Campos a habilitar/deshabilitar
        const fields = ['#primerNombre', '#segundoNombre', '#prmerApellido', '#segundoApellido', 
                        '#fechaNacimiento', '#telefono', '#correoElctronico', '#pais', 
                        '#provincia', '#ciudad', '#direccion', '#sexo'];

        // Habilitar/deshabilitar basado en la selección
        fields.forEach(field => {
            $(field).prop('readonly', !isRectificationYesChecked);
        });

        // Los selects requieren 'disabled' en lugar de 'readonly'
        $('#pais, #provincia, #ciudad, #sexo').prop('disabled', !isRectificationYesChecked);

        






        
    }


    
</script>
<script>
</script>
<style>
    .custom-select-disabled {
        background-color: white !important; 
        color: black !important; 
    }
    

    

</style>
@endpush