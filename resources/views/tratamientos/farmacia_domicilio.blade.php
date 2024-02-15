@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Farmacia a domicilio
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
                    <h1 class="modal-title fs-5 fw-medium mb-3">Solicitud exitosa</h1>
                    <p class="fs--1 fw-normal" id="mensaje"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3"id="btnGuardarSolicitudLlamada" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Farmacia a domicilio') }}</h5>
    </div>
    <section class="pt-5 px-0 px-md-3 pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="card card-border">
                        <div class="card-body p-3">
                            <h6 class="text-center fs--16 line-height-20 fw-medium my-3">Farmacia a domicilio</h6>
                            <form class="row g-3 px-2 needs-validation" novalidate>
                                <div class="col-md-12">
                                    <label for="paciente" class="form-label fs--1 line-height-16 fw-medium">Selecciona el paciente</label>
                                    <select class="form-select fs--1 p-3 bg-neutral rounded-3" name="paciente" id="paciente" required>
                                       
                                    </select>
                                    <div class="invalid-feedback">
                                        Elegir un paciente
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="paciente" class="form-label fs--1 line-height-16 fw-medium">Selecciona la ciudad</label>
                                    <select class="form-select fs--1 p-3 bg-neutral rounded-3" name="ciudad" id="ciudad" required>
                                        <option selected disabled value="">Elegir...</option>
                                        
                                    </select>
                                    <div class="invalid-feedback">
                                        Elegir una ciudad
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="number" class="form-control fs--1 p-3 bg-neutral rounded-3"  name="telefono" id="telefono" value="" placeholder="Teléfono móvil" required />
                                    <div class="invalid-feedback">
                                        Ingrese un numero de telefono
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control fs--1 p-3 bg-neutral rounded-3"  name="direccion"id="direccion" value="" placeholder="Dirección" required />
                                    <div class="invalid-feedback">
                                        Ingrese una direcciovisun
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-lg btn-primary-veris fs--18 line-height-24 w-100 fw-medium rounded-3 w-100 px-4 py-3" type="button" id="btnGuardar"><i class="bi bi-telephone-fill me-2" id="btnGuardarSolicitudLlamada"></i> Solicitar llamada</button>
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
    
    let familiar = [];
    let numeroIdentificacion = '';
    let tipoIdentificacion = '';
    let message = '';
    let codigoTratamiento = "{{ $codigoTratamiento }}";
    // llama al dom

    document.addEventListener("DOMContentLoaded", async function () {
        await consultarPacientes();
        await consultarCiudades();
        // await crearFarmaciaDomicilio();
        // // boton guardar
        // $('body').on('click','#btnGuardar', async function () {
        //     await guardarFarmaciaDomicilio();
        // });
    });

    // funciones asyncronas

    // consultar pacientes
    async function consultarPacientes() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            let html = '';
            // html += `<option value="">{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->primerApellido }} (Yo)</option>`;
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

    async function crearFarmaciaDomicilio() {
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
            console.log(1)
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
        });

        console.log('args', args["data"]);

        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        if(data.code == 200){
            $('#mensajeSolicitudLlamadaModal').modal('show');
            document.getElementById("mensaje").innerHTML = data.message;
        }
        else{
            $('#mensajeSolicitudLlamadaModal').modal('show');
            document.getElementById("mensaje").innerHTML = data.message;

        }
        return data;

    }

    // funciones js
    
    

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
        crearFarmaciaDomicilio();
    });

    $('#btnGuardarSolicitudLlamada').click(function() {
        $('#mensajeSolicitudLlamadaModal').modal('hide');
        window.history.back();
        //window.location.href = `/tratamiento/${codigoTratamiento}`;
    });
</script>
@endpush