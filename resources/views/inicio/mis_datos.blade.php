@extends('template.app-template-veris')
@section('title')
Mi Veris - Mis Datos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">Mis Datos</h5>
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
                                    <label for="nombre" class="form-label fw-semibold">{{ __('Nombre') }}</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="primerApellido" class="form-label fw-semibold">{{ __('Primer apellido') }}</label>
                                    <input type="text" class="form-control" name="primerApellido" id="primerApellido" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="segundoApellido" class="form-label fw-semibold">{{ __('Segundo apellido') }}</label>
                                    <input type="text" class="form-control" name="segundoApellido" id="segundoApellido" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="fechaNacimiento" class="form-label fw-semibold">{{ __('Fecha de nacimiento') }} *</label>
                                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento"  required />
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
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="telefono" class="form-label fw-semibold">{{ __('Teléfono') }} *</label>
                                    <input type="number" class="form-control" name="telefono" id="telefono" required />
                                    <div class="valid-feedback">
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
                                    <label for="direccion" class="form-label fw-semibold">{{ __('Dirección') }}</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button class="btn btn-primary-veris w-50" id="btnActualizarDatosUsuario">{{ __('Guardar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    //variables globales
    let sexo;
    let codeprovincia;
    let identificacion;

    document.addEventListener("DOMContentLoaded", async function () {
        console.log('cargfgDOMContentLoaded');
        await obtenerDatosUsuario();
        obtenerProvincias();
        
        obtenerCiudades(codeprovincia);
        await obtenerDatosUsuario();
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

    //funciones asyncronas
    //obtener datos usuario

    async function obtenerDatosUsuario() {
        let args = [];
        args["endpoint"] = api_url + `/digitales/v1/seguridad/cuenta?canalOrigen=${_canalOrigen}&tipoIdentificacion={{Session::get('userData')->codigoTipoIdentificacion}}&numeroIdentificacion={{Session::get('userData')->numeroIdentificacion}}`;
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = false;
        
        const data = await call(args);
        console.log('datosUsuario',data);
        if (data.code == 200) {

            console.log('data.data',data.data.sexo);
            sexo = data.data.sexo;
            codeprovincia = data.data.codigoProvincia;
            identificacion = data.data.numeroIdentificacion;

            $('#nombre').val(data.data.nombre);
            $('#primerApellido').val(data.data.primerApellido);
            $('#segundoApellido').val(data.data.segundoApellido);
            $('#fechaNacimiento').val(convertirFechaNacimiento(data.data.fechaNacimiento));
            $('#mail').val(data.data.mail);
            $('#telefono').val(data.data.telefonoMovil);
            $('#provincia').val(data.data.codigoProvincia);
            $('#ciudad').val(data.data.codigoCiudad);
            $('#direccion').val(data.data.direccionDomicilio);
            if (data.data.sexo == 'M') {
                $('#sexo').val('M');
            } else {
                $('#sexo').val('F');
            }
        }
    } 

    //actualizar datos del usuario
    async function actualizarDatosUsuario() {
        console.log($('#direccion').val());
        let args = [];
        args["endpoint"] = api_url + "/digitales/v1/perfil"
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "PUT";
        args["showLoader"] = false;
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

    }


    //funciones de ayuda
    //convertir fecha nacimiento
    function convertirFechaNacimiento(fechaNacimiento) {

        let partesFecha = fechaNacimiento.split('/');
        let fecha = new Date(partesFecha[2], partesFecha[1] - 1, partesFecha[0]);
        let formattedFecha = fecha.toISOString().split('T')[0];

        return formattedFecha;
    }

   


</script>

@endpush