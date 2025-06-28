@extends('template.app-template-veris')
@section('title')
Mi Veris - Mis Datos
@endsection
@section('content')
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <!-- modal datos actualizados -->
    <div class="modal fade" id="mensajeDatosActualizados" tabindex="-1" aria-labelledby="mensajeDatosActualizadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/check-circle.svg')}}" alt="">
                    </div>
                    <p class="fs--16 line-height-20 fw-medium text-veris mb-0">Datos actualizados</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 linea-height-24 fw-medium m-0 w-100 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis Datos') }}</h5>
    </div>
    {{-- @foreach (Session::get('userData') as $key => $value)
    <p class="ps-4 mb-1 pb-2 bg-white">{{ $key }}: {{ $value }}</p>
    @endforeach --}}
    <section class="p-3">
        <div class="row g-0 justify-content-center align-items-center">
            <div class="col-md-10 col-lg-8">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body px-0">
                        <form class="row g-3">
                            @csrf
                            <div class="col-12 justify-content-center align-items-center">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    {{-- <span class="avatar avatar-xxl">
                                        <img src="{{ asset('assets/img/avatars/avatar.svg') }}" class="avatar-img rounded-circle" alt="user">
                                    </span> --}}
                                    <div class="avatar avatar-xxl d-flex justify-content-center align-items-center rounded-circle fs--60 line-height-70 fw-medium text-white bg-genero bg-genero-{{ strtolower(Session::get('userData')->sexo) }}">
                                        <span class="">{{ substr(Session::get('userData')->primerNombre, 0, 1) }}</span>
                                    </div>
                                </div>
                                <p class="user-name text-center fw-bold fs-sm mb-3 text-capitalize">{{ strtolower(Session::get('userData')->primerNombre) }} {{ strtolower(Session::get('userData')->primerApellido) }}</p>  
                            </div>
                            <div class="col-md-12">
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <p class="font-medium fs--1 linea-height-16 text-veris-ai mb-0">Información personal</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label fw-normal fs--1">{{ __('Nombres y Apellidos') }}*</label>
                                        <input type="text" class="form-control fs--1 p-3" name="nombre" id="nombre" disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="numeroDocumento" class="form-label fw-medium fs--1 text-capitalize strTipoDocumento">*</label>
                                        <input type="text" class="form-control fs--1 p-3" name="numeroDocumento" id="numeroDocumento" disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fechaNacimiento" class="form-label fw-normal fs--1">{{ __('Fecha de nacimiento') }} *</label>
                                        <input type="date" lang="es" class="form-control fs--1 p-3" name="fechaNacimiento" id="fechaNacimiento" disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sexo" class="form-label fw-normal fs--1">{{ __('Género') }} *</label>
                                        <select class="form-select fs--1 p-3" name="sexo" id="sexo" required>
                                            <option value="M" {{ (Session::get('userData')->sexo == 'M') ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ (Session::get('userData')->sexo == 'F') ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mail" class="form-label fw-normal fs--1">{{ __('Correo electrónico') }} *</label>
                                        <input type="email" class="form-control fs--1 p-3" name="mail" id="mail" required />
                                        <div class="invalid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <p class="font-medium fs--1 linea-height-16 text-veris-ai mb-0">Información de contacto</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefono" class="form-label fw-normal fs--1">{{ __('Número de Celular') }} *</label>
                                        <input type="number" class="form-control fs--1 p-3" name="telefono" id="telefono" minlength="10" maxlength="10" required />
                                        <div class="invalid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="direccion" class="form-label fw-normal fs--1">{{ __('Dirección') }}*</label>
                                        <input type="text" class="form-control fs--1 p-3" name="direccion" id="direccion" value="" required />
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                            <p class="font-medium fs--1 linea-height-16 text-veris-ai mb-0">Seguro médico privado</p>
                                            <a href="/mis-convenios" for="convenio" class="font-medium fs--1 linea-height-16 text-veris-ai mb-0">Ver todos<i class="fa-solid fa-angle-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control fs--1 p-3 text-capitalize" name="convenio" id="convenio" disabled />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer row justify-content-center mt-5 px-0">
                        <div class="col-12 col-md-6">
                            <button class="btn btn-primary-veris fs--18 linea-height-24 fw-medium py-3 px-4 w-100" id="btnActualizarDatosUsuario">{{ __('Guardar cambios') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<style>
    .form-label {
        color: #6C7A8C !important;
    }
    .bg-genero{
        font-family: 'Gotham Rounded';
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }
    .bg-genero-f{
        background: #C52BD2;
        border: 4px solid #F3F4F5;
    }
    .bg-genero-m{
        background: #0071CE;
        border: 4px solid #F3F4F5;
    }
</style>
<script>

    //variables globales
    let sexo;
    let codeprovincia;
    let identificacion;
    let datosUsuario = [];
    let provincias = [];
    let ciudades = [];

    document.addEventListener("DOMContentLoaded", async function () {
        // Carga inicial de datos y configuraciones
        console.log(_canalOrigen);
        await obtenerDatosUsuario();
        await obtenerConvenios();
        //provincias = await obtenerProvincias();
        //ciudades = await obtenerCiudades(1, codeprovincia);
        {{-- llenarDatosUsuario(provincias, ciudades); --}}
        llenarDatosUsuario();
        var fechaActual = new Date();
        var dia = ('0' + fechaActual.getDate()).slice(-2);
        var mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2);
        var ano = fechaActual.getFullYear();
        document.getElementById('fechaNacimiento').setAttribute('max', `${ano}-${mes}-${dia}`);

        // Evento para validar el formulario completo en cada cambio
        $('input[required], select[required]').on('blur change input', function() {
            validarFormulario(); // Llama a validarFormulario en cada cambio
        });

        validarFormulario(); // Validación inicial después de cargar los datos
    });

    async function obtenerConvenios() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${_canalOrigen}&tipoIdentificacion=${datosUsuario.codigoTipoIdentificacion}&numeroIdentificacion=${datosUsuario.numeroIdentificacion}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data);
        let elem = ``
        if (data.code == 200) {
            if(data.data.length == 0 || data.data === null){
                $('#convenio').val(`Ninguno`);
            }else{
                $('#convenio').val(`${data.data[0].nombreConvenioUsuarioFinal.toLowerCase().substring(0, 40) + '...'}`);
            }
        }
        return data;
    }

    // Validar el formulario completo
    function validarFormulario() {
        let esValido = true;
        $('input[required], select[required]').each(function() {
            // Usar validarCampo para cada input/select y actualizar esValido según sea necesario
            if (!validarCampo($(this))) {
                esValido = false;
            }
        });
        $('#btnActualizarDatosUsuario').prop('disabled', !esValido);
    }

    // Validar campo individual y mostrar mensaje de error si es necesario
    function validarCampo(campo) {
        campo.removeClass('is-invalid is-valid');
        campo.next('.invalid-feedback').remove();
        let min = campo.attr('minlength')
        let max = campo.attr('maxlength')
        if (campo.val().trim() === '') {
            campo.addClass('is-invalid');
            campo.after('<div class="invalid-feedback">Este campo es obligatorio.</div>');
            return false;
        }
        if(min !== undefined && max !== undefined){
            console.log(campo.val().length)
            if(campo.val().length < min || campo.val().length > min){
                campo.addClass('is-invalid');
                campo.after(`<div class="invalid-feedback">Este campo debe tener ${max} dígitos.</div>`);
                return false;
            }
        }
        if(campo.attr('type') === 'email' && !campo.val().match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            campo.addClass('is-invalid');
                campo.after(`<div class="invalid-feedback">Formato de correo electrónico incorrecto.</div>`);
                return false;
        }  
        return true;
    }





    // boton actualizar datos usuario
    $('#btnActualizarDatosUsuario').click(async function (e) {

        console.log('click exitoso');
        e.preventDefault();
        console.log('click');
        $(this).prop('disabled', true); // Disable the button
        await actualizarDatosUsuario();
        $(this).prop('disabled', false); // Re-enable the button
    });




    //funciones asyncronas
    //obtener datos usuario

    async function obtenerDatosUsuario() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/seguridad/cuenta?canalOrigen=${_canalOrigen}&tipoIdentificacion={{Session::get('userData')->codigoTipoIdentificacion}}&numeroIdentificacion={{Session::get('userData')->numeroIdentificacion}}`;
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

    // llenar formulario con datos del usuario
    function llenarDatosUsuario() {
        $('.strTipoDocumento').html(`${(datosUsuario.codigoTipoIdentificacion == 2) ? `Cédula` : `Pasaporte`}*`)
        $('#numeroDocumento').val(`${datosUsuario.numeroIdentificacion}`)
        $('#nombre').val(`${ (datosUsuario.primerNombre) ? capitalizarElemento(datosUsuario.primerNombre) : ``  } ${ (datosUsuario.segundoNombre) ? capitalizarElemento(datosUsuario.segundoNombre) : `` } ${ (datosUsuario.primerApellido) ? capitalizarElemento(datosUsuario.primerApellido) : `` } ${ (datosUsuario.segundoApellido) ? capitalizarElemento(datosUsuario.segundoApellido) : `` }`);
        $('#primerApellido').val(capitalizarElemento(datosUsuario.primerApellido));
        $('#segundoApellido').val(capitalizarElemento(datosUsuario.segundoApellido));
        $('#fechaNacimiento').val(convertirFechaNacimiento(datosUsuario.fechaNacimiento));
        $('#mail').val(datosUsuario.mail);
        $('#telefono').val(datosUsuario.telefonoMovil);
        // Llenar el select de provincia
        // $.each(provincias, function(index, value) {
        //     const isSelected = value.codigoProvincia == datosUsuario.codigoProvincia ? ' selected' : '';
        //     $('#provincia').append(`<option value="${value.codigoProvincia}"${isSelected}>${capitalizarElemento(value.nombreProvincia)}</option>`);
        // });

        // Llenar el select de ciudad
        // $.each(ciudades, function(index, value) {
        //     const isSelected = value.codigoCiudad == datosUsuario.codigoCiudad ? ' selected' : '';
        //     $('#ciudad').append(`<option value="${value.codigoCiudad}"${isSelected}>${capitalizarElemento(value.nombreCiudad)}</option>`);
        // });
        {{-- $('#ciudad').val(datosUsuario.codigoCiudad) --}}

        // Otros campos
        $('#direccion').val(capitalizarElemento(datosUsuario.direccionDomicilio));
    
        if (datosUsuario.sexo == 'M') {
            $('#sexo').val('M');
        } else {
            $('#sexo').val('F');
        }
    }

    //actualizar datos del usuario
    async function actualizarDatosUsuario() {
        // convertir fecha de nacimiento a formato dd/mm/yyyy
        //await validarFormulario()
        let fechaNacimiento = $('#fechaNacimiento').val();
        let partesFecha = fechaNacimiento.split('-');
        let fecha = partesFecha[2] + '/' + partesFecha[1] + '/' + partesFecha[0];
       

        console.log($('#direccion').val());
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil`
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            "tipoIdentificacion": "{{ Session::get('userData')->codigoTipoIdentificacion }}",
            "numeroIdentificacion": "{{ Session::get('userData')->numeroIdentificacion }}",
            // "primerNombre": $('#nombre').val(),
            // "primerApellido": $('#primerApellido').val(),
            // "segundoApellido": $('#segundoApellido').val(),
            "sexo": $('#sexo').val(),
            "mail": $('#mail').val(),
            "telefonoMovil": $('#telefono').val(),
            // "codigoProvincia": $('#provincia').val(),
            // "codigoCiudad": $('#ciudad').val(),
            "direccionDomicilio": $('#direccion').val(),    
            // "fechaNacimiento": fecha
        });

        console.log('args', args["data"]);

        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        if (data.code == 200) {
            $('#mensajeDatosActualizados').modal('show');
        }

    }


    //funciones de ayuda
    //convertir fecha nacimiento
    function convertirFechaNacimiento(fechaNacimiento) {

        let partesFecha = fechaNacimiento.split('/');
        let fecha = new Date(partesFecha[2], partesFecha[1] - 1, partesFecha[0]);
        let formattedFecha = fecha.toISOString().split('T')[0];

        return formattedFecha;
    }

   // actualizar el select de ciudades cuando selecciono provincia
   $( "#provincia").change(async function () {
        let codeprovincia = $(this).val();
        ciudades = await obtenerCiudades(1, codeprovincia);
        $('#ciudad').empty();
        $.each(ciudades, function (index, value) {
            $('#ciudad').append('<option value="' + value.codigoCiudad + '">' + value.nombreCiudad + '</option>');
        });
    });

</script>

@endpush