@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Servicios a domicilio
@endsection
@push('css')
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModal" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-bold mb-3">Solicitud exitosa</h1>
                    <p class="fs--1 fw-normal" id="mensaje"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-bold mb-3">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal" id="mensajeError"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Servicios a domicilio') }}</h5>
    </div>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                        <label class="form-check-label cursor-pointer fw-bold" for="inlineRadio1">Laboratorio</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                        <label class="form-check-label cursor-pointer fw-bold" for="inlineRadio2">Farmacia</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="paciente" class="form-label fw-bold">Selecciona el paciente</label>
                                    <select class="form-select bg-neutral" name="paciente" id="paciente" >
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
                                    <input type="text" class="form-control bg-neutral" name="telefono" id="telefono" value="" placeholder="Teléfono móvil" maxlength="10" required />
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
                                    <button class="btn btn-lg btn-primary-veris w-100" type="submit" id="btnSolicitarLlamada" disabled><i class="bi bi-telephone-fill me-2" 
                                        ></i> Solicitar llamada</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    // variables globales

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        // consultar grupo familiar
        await consultarGrupoFamiliar();
        // consultar ciudades
        await consultarCiudades();
        
    });

    

    // funciones asincronas 

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataFa', data);
        if (data.code == "200") {
            let html = '';
            html += `<option value="">{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }} (Yo)</option>`;
            data.data.forEach(element => {
                html += `<option data-rel='${ JSON.stringify(element) }'>${element.primerNombre} ${element.primerApellido} (${element.parentesco})</option>`;
            });
            $('#paciente').html(html);
        
        } 
    }

    // consultar ciudades

    async function consultarCiudades() {
        let args = [];
        canalOrigen = _canalOrigen
        args["endpoint"] = api_url + `/digitalestest/v1/domicilio/laboratorio/ciudades?canalOrigen=${canalOrigen}`
        args["method"] = "GET";
        args["showLoader"] = true;
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

    // guardar farmacia domicilio
    async function consultarFarmaciaDomicilio() {
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/domicilio/farmacia/solicitud";
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        let paciente = [];

        if(getInput('paciente') == ''){
            console.log(0)
            paciente = {
                tipoIdentificacion: "{{ Session::get('userData')->tipoIdentificacion }}",
                numeroIdentificacion: "{{ Session::get('userData')->numeroIdentificacion }}",
                nombrePaciente: "{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }}",
            }
        }else{
            console.log(2)
            paciente = JSON.parse($('#paciente option:selected').attr("data-rel"));
            paciente["nombrePaciente"] = paciente.primerNombre + ' ' + paciente.primerApellido;
            console.log(paciente)
        }

        args["data"] = JSON.stringify({
            "tipoIdentificacionPaciente": paciente.tipoIdentificacion,
            "identificacionPaciente": paciente.numeroIdentificacion,
            "nombrePaciente":  paciente.nombrePaciente,
            "mail": paciente.correo,
            "direccion": getInput('direccion'), 
            "telefono": getInput('telefono'),
            "origenInvocacion": "WEB",
        });

        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        if(data.code == 200){
            $('#mensajeSolicitudLlamadaModal').modal('show');
            document.getElementById("mensaje").innerHTML = data.message;
        }
        if(data.code != 200){
            console.log('entro a error farmacia')
            $('#mensajeSolicitudLlamadaModalError').modal('show');
            document.getElementById("mensajeError").innerHTML = data.message;
        }
        return data;

    }


    //Crea una nueva solicitud de orden de laboratorio a domicilio.
    async function crearSolicitudLaboratorioDomicilio() {
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/domicilio/laboratorio/solicitud";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "formdata";
        let paciente = [];

        if(getInput('paciente') == ''){
            paciente = {
                tipoIdentificacion: "{{ Session::get('userData')->codigoTipoIdentificacion }}",
                numeroIdentificacion: "{{ Session::get('userData')->numeroIdentificacion }}",
                nombrePaciente: "{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }}",
            }
        }else{
            paciente = JSON.parse($('#paciente option:selected').attr("data-rel"));
            paciente["nombrePaciente"] = paciente.primerNombre + ' ' + paciente.primerApellido;
        }
        let formData = new FormData();
        formData.append("tipoIdentificacionPaciente", paciente.tipoIdentificacion);
        formData.append("identificacionPaciente", paciente.numeroIdentificacion);
        formData.append("nombrePaciente", paciente.nombrePaciente);
        formData.append("codigoCiudad", getInput('ciudad'));
        formData.append("direccion", getInput('direccion'));
        formData.append("telefono", getInput('telefono'));
        formData.append("origenInvocacion", 'WEB'); 

        args["data"] = formData;

        const data = await call(args);
        if(data.code == 200){
            $('#mensajeSolicitudLlamadaModal').modal('show');
            document.getElementById("mensaje").innerHTML = data.message;
        }
        if(data.code != 200){
            $('#mensajeSolicitudLlamadaModalError').modal('show');
            document.getElementById("mensajeError").innerHTML = data.message;
        }
        return data;

    }


    // funciones JS

    $("form").on('submit', async function(e) {
        e.preventDefault(); // Evita el comportamiento predeterminado de envío del formulario
        // recibir los valores del checkbox
        let tipoServicio = $('input[name="inlineRadioOptions"]:checked').val();

        if (tipoServicio == 'option1') {
            await crearSolicitudLaboratorioDomicilio();
        } else {
            await consultarFarmaciaDomicilio();
        }
    });

    // deshabilitar el boton btnSolicitarLlamada si algun campo esta vacio
    $("form").on('change', function() {
        let tipoServicio = $('input[name="inlineRadioOptions"]:checked').val();
        if (tipoServicio == 'option1') {
            if (getInput('telefono') != '' && getInput('direccion') != '') {
                $('#btnSolicitarLlamada').prop('disabled', false);
            } else {
                $('#btnSolicitarLlamada').prop('disabled', true);
            }
        } else {
            if (getInput('telefono') != '' && getInput('direccion') != '') {
                $('#btnSolicitarLlamada').prop('disabled', false);
            } else {
                $('#btnSolicitarLlamada').prop('disabled', true);
            }
        }
    });


    // limitar el input telefono a 10 caracteres y solo numeros
    $('#telefono').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });


</script>
@endpush