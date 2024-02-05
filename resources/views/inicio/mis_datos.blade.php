@extends('template.app-template-veris')
@section('title')
Mi Veris - Mis Datos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">

    <!-- modal datos actualizados -->

    <div class="modal fade" id="mensajeDatosActualizados" tabindex="-1" aria-labelledby="mensajeDatosActualizadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Datos actualizados</p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">Mis Datos</h5>

    {{-- @foreach (Session::get('userData') as $key => $value)
    <p class="ps-4 mb-1 pb-2 bg-white">{{ $key }}: {{ $value }}</p>
    
 
    @endforeach --}}

    
    <div class="row g-0 justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card bg-transparent shadow-none">
                <div class="card-body">
                    
                    <form class="row g-3">
                        @csrf
                        <div class="col-12 justify-content-center align-items-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <span class="avatar avatar-xxl">
                                    <img src="{{ asset('assets/img/avatars/avatar.svg') }}" class="avatar-img rounded-circle" alt="user">
                                </span>
                            </div>
                            <p class="user-name text-center fw-bold fs-sm mb-3">{{ Session::get('userData')->nombre }}</p>  
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <label for="nombre" class="form-label fw-semibold">{{ __('Nombre') }}*</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="primerApellido" class="form-label fw-semibold">{{ __('Primer apellido') }}*</label>
                                    <input type="text" class="form-control" name="primerApellido" id="primerApellido" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="segundoApellido" class="form-label fw-semibold">{{ __('Segundo apellido') }}*</label>
                                    <input type="text" class="form-control" name="segundoApellido" id="segundoApellido" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="fechaNacimiento" class="form-label fw-semibold">{{ __('Fecha de nacimiento') }} *</label>
                                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="sexo" class="form-label fw-semibold">{{ __('Sexo') }} *</label>
                                    <select class="form-select" name="sexo" id="sexo" required>
                                        <option selected disabled value="">Selecciona uno</option>
                                        <option value="M" {{ (Session::get('userData')->sexo == 'M') ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ (Session::get('userData')->sexo == 'F') ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <label for="mail" class="form-label fw-semibold">{{ __('Correo electrónico') }} *</label>
                                    <input type="email" class="form-control" name="mail" id="mail" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="telefono" class="form-label fw-semibold">{{ __('Teléfono') }} *</label>
                                    <input type="number" class="form-control" name="telefono" id="telefono" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="provincia" class="form-label fw-semibold">{{ __('Provincia') }} *</label>
                                    <select class="form-select" name="provincia" id="provincia" required>
                                        <option selected disabled value="">Selecciona uno</option>
                                        <option>...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="ciudad" class="form-label fw-semibold">{{ __('Ciudad') }} *</label>
                                    <select class="form-select" name="ciudad" id="ciudad" required>
                                        <option selected disabled value="">Selecciona uno</option>
                                        <option>...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="direccion" class="form-label fw-semibold">{{ __('Dirección') }}*</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button class="btn btn-primary-veris w-50 py-3" id="btnActualizarDatosUsuario">{{ __('Guardar') }}</button>
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
    let sexo;
    let codeprovincia;
    let identificacion;
    let datosUsuario = [];
    let provincias = [];
    let ciudades = [];

    document.addEventListener("DOMContentLoaded", async function () {
        console.log(_canalOrigen);
        await obtenerDatosUsuario();
        provincias = await obtenerProvincias();
        ciudades = await obtenerCiudades(codeprovincia);
        llenarDatosUsuario(provincias, ciudades);
        var fechaActual = new Date();
        var dia = ('0' + fechaActual.getDate()).slice(-2); // Añade un cero delante si es necesario
        var mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2); // Los meses empiezan en 0
        var ano = fechaActual.getFullYear();
        document.getElementById('fechaNacimiento').setAttribute('max', `${ano}-${mes}-${dia}`);
        $('input[required], select[required]').on('blur', function() {
            // Validar el campo específico
            let esValido = validarCampo($(this));
            // deshabilitar el botón si hay campos inválidos
            $('#btnActualizarDatosUsuario').prop('disabled', !esValido);
            
        });
 
    });

    // metodos jquery
    // boton actualizar datos usuario
    $('#btnActualizarDatosUsuario').click(async function (e) {

        console.log('click exitoso');
        e.preventDefault();
        console.log('click');
        $(this).prop('disabled', true); // Disable the button
        await actualizarDatosUsuario();
        $(this).prop('disabled', false); // Re-enable the button
    });

    // validar que los campos del formulario no esten vacios y llenar mensaje n invalid-feedback 
    function validarCampo(campo) {
        campo.removeClass('is-invalid is-valid');
        campo.next('.invalid-feedback').remove(); 
        if (campo.val().trim() === '') {
            campo.addClass('is-invalid');
            campo.after('<div class="invalid-feedback">Este campo es obligatorio.</div>');
        } 

        return campo.hasClass('is-invalid') ? false : true;
    }



    //funciones asyncronas
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

    // llenar formulario con datos del usuario
    function llenarDatosUsuario(provincias) {
        $('#nombre').val(capitalizarElemento(datosUsuario.nombre));
        $('#primerApellido').val(capitalizarElemento(datosUsuario.primerApellido));
        $('#segundoApellido').val(capitalizarElemento(datosUsuario.segundoApellido));
        $('#fechaNacimiento').val(convertirFechaNacimiento(datosUsuario.fechaNacimiento));
        $('#mail').val(datosUsuario.mail);
        $('#telefono').val(datosUsuario.telefonoMovil);
        // Llenar el select de provincia
        $.each(provincias, function(index, value) {
            const isSelected = value.codigoProvincia == datosUsuario.codigoProvincia ? ' selected' : '';
            $('#provincia').append(`<option value="${value.codigoProvincia}"${isSelected}>${capitalizarElemento(value.nombreProvincia)}</option>`);
        });

        // Llenar el select de ciudad
        $.each(ciudades, function(index, value) {
            const isSelected = value.codigoCiudad == datosUsuario.codigoCiudad ? ' selected' : '';
            $('#ciudad').append(`<option value="${value.codigoCiudad}"${isSelected}>${capitalizarElemento(value.nombreCiudad)}</option>`);
        });

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
            "primerNombre": $('#nombre').val(),
            "primerApellido": $('#primerApellido').val(),
            "segundoApellido": $('#segundoApellido').val(),
            "sexo": $('#sexo').val(),
            "mail": $('#mail').val(),
            "telefonoMovil": $('#telefono').val(),
            "codigoProvincia": $('#provincia').val(),
            "codigoCiudad": $('#ciudad').val(),
            "direccionDomicilio": $('#direccion').val()
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
        ciudades = await obtenerCiudades(codeprovincia);
        $('#ciudad').empty();
        $.each(ciudades, function (index, value) {
            $('#ciudad').append('<option value="' + value.codigoCiudad + '">' + value.nombreCiudad + '</option>');
        });
    });

    


    

    



</script>

@endpush