@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Laboratorio a domicilio
@endsection
@push('css')
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModal" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3 pb-2">Solicitud exitosa</h1>
                    <p class="fs--1 fw-normal">Un asesor te contactará pronto</p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Laboratorio a domicilio') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-center fw-bold mb-3">Laboratorio a domicilio</h6>
                        <form class="row g-3">
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Selecciona el paciente</label>
                                <select class="form-select bg-neutral" name="paciente" id="paciente" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="">...</option>
                                    <option value="">...</option>
                                </select>
                                <div class="invalid-feedback">
                                    Elegir un paciente
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Selecciona la ciudad</label>
                                <select class="form-select bg-neutral" name="ciudad" id="ciudad" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="">...</option>
                                    <option value="">...</option>
                                </select>
                                <div class="invalid-feedback">
                                    Elegir una ciudad
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="number" class="form-control bg-neutral"  name="telefono" id="telefono" value="" placeholder="Teléfono móvil" required />
                                <div class="invalid-feedback">
                                    Ingrese un numero de telefono
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control bg-neutral"  name="direccion"id="direccion" value="" placeholder="Dirección" required />
                                <div class="invalid-feedback">
                                    Ingrese una direccion
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-lg btn-primary-veris w-100" type="button" id="btnGuardar"
                                ><i class="bi bi-telephone-fill me-2"></i> Solicitar llamada</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script></script>
<script>

    // llama al dom

    document.addEventListener("DOMContentLoaded", async function () {
        await consultarPacientes();
        await consultarCiudades();
    });

    // funciones asyncronas

    // consultar pacientes
    async function consultarPacientes() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            let html = '';
            html += `<option value="">{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }} (Yo)</option>`;
            data.data.forEach(element => {
                html += `<option data-rel='${ JSON.stringify(element) }'>${element.primerNombre} ${element.primerApellido} (${element.parentesco})</option>`;
            });
            // yo
            $('#paciente').html(html);

        }
        return data;
    }

    // consultar ciudades

    async function consultarCiudades() {
        let args = [];
        canalOrigen = _canalOrigen
        args["endpoint"] = api_url + `/digitales/v1/domicilio/laboratorio/ciudades?canalOrigen=${canalOrigen}`
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('dataCiudades', data);
        if(data.code == 200){
            let ciudades = data.data;
            let html = '';
            ciudades.forEach(element => {
                html += `<option value="${element.secuencialCiudad}">${element.nombreCiudad}</option>`;
            });
            $('#ciudad').html(html);
        }
        return data;
    }

    //Crea una nueva solicitud de orden de laboratorio a domicilio.
    async function crearSolicitudLaboratorioDomicilio() {
        let args = [];
        args["endpoint"] = api_url + "/digitales/v1/domicilio/laboratorio/solicitud";
        args["method"] = "POST";
        args["showLoader"] = false;
        args["bodyType"] = "formdata";
        let paciente = [];

        if(getInput('paciente') == ''){
            console.log(0)
            paciente = {
                tipoIdentificacion: "{{ Session::get('userData')->tipoIdentificacion }}",
                numeroIdentificacion: "{{ Session::get('userData')->numeroIdentificacion }}",
                nombrePaciente: "{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }}",
            }
        }else{
            console.log(1)
            paciente = JSON.parse($('#paciente option:selected').attr("data-rel"));
            paciente["nombrePaciente"] = paciente.primerNombre + ' ' + paciente.primerApellido;
            console.log(paciente)
        }

        console.log(paciente)

        let formData = new FormData();
        formData.append("tipoIdentificacionPaciente", paciente.tipoIdentificacion);
        formData.append("identificacionPaciente", paciente.numeroIdentificacion);
        formData.append("nombrePaciente", paciente.nombrePaciente);
        formData.append("codigoCiudad", getInput('ciudad'));
        formData.append("direccion", getInput('direccion'));
        formData.append("telefono", getInput('telefono'));

        args["data"] = formData;

        console.log('args1111', args["data"]);

        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        if(data.code == 200){
            $('#mensajeSolicitudLlamadaModal').modal('show');
        }
        else{
            alert("Error al guardar los datos");
        }
        return data;

    }

    // funciones js
    // obtener datos del select paciente
    $('#paciente').change(function() {
    var seleccion = $(this).val(); // Obtiene el valor seleccionado
    var valores = seleccion.split(','); // Separa los valores

    numeroIdentificacion = valores[0];
    tipoIdentificacion = valores[1];
    correo = valores[2];
    var textoCompleto = $(this).find('option:selected').text();

   
    // Extrayendo solo los nombres del paciente
    nombrePaciente = textoCompleto.substring(0, textoCompleto.lastIndexOf(" ("));
    });

     // obtener los datos del select ciudades
     $('#ciudad').change(function() {
        var seleccion = $(this).val(); // Obtiene el valor seleccionado
        var valores = seleccion.split(','); // Separa los valores

        ciudad = valores[0];
        console.log('ciudad',ciudad);
        var textoCompleto = $(this).find('option:selected').text();
    });

    // enviar datos
    
    $('#btnGuardar').click(function() {
        if ($('#paciente').val() == '') {
            $('#paciente').addClass('is-invalid');
            return false;
        } else {
            $('#paciente').removeClass('is-invalid');
        }
        if ($('#ciudad').val() == '') {
            $('#ciudad').addClass('is-invalid');
            return false;
        } else {
            $('#ciudad').removeClass('is-invalid');
        }
        if ($('#telefono').val() == '') {
            $('#telefono').addClass('is-invalid');
            return false;
        } else {
            $('#telefono').removeClass('is-invalid');
        }
        if ($('#direccion').val() == '') {
            $('#direccion').addClass('is-invalid');
            return false;
        } else {
            $('#direccion').removeClass('is-invalid');
        }
        // $('#mensajeSolicitudLlamadaModal').modal('show');
        crearSolicitudLaboratorioDomicilio();
    });

</script>
@endpush