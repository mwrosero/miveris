@extends('template.app-template-veris')
@section('title')
Mi Veris - Agregar familiar o amigo
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

{{-- Modal de pregunta --}}
<div class="modal fade" id="confirmarPregunta" tabindex="-1" aria-labelledby="confirmarPreguntaLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <h5 class="fs-18 line-height-24 my-3">¿Administras los tratamientos de <span class="primerNombreFamiliar text-capitalize"></span>?</h5>
                <p class="fs--1 line-height-16 mb-0">Pídele permisos de administrador. Esto te permitirá agendarle citas, gestionar sus tratamientos, ver resultados y más.</p>
                <div class="d-flex flex-column">
                    <button type="button" id="btnSolicitarPermiso" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 mt-3 w-100 px-4 py-3" data-bs-dismiss="modal">Solicitar Permisos</button>
                    <button type="button" id="btnAgregarPersona" class="btn btn-lg shadow-none text-primary-veris fw-medium col fs--18 line-height-24 m-0 mt-2 w-100 px-4 py-3" data-bs-dismiss="modal">Ahora no</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">

    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaAgregadaModal" tabindex="-1" aria-labelledby="mensajePersonaAgregadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/check-circle.svg')}}" alt="">
                    </div>
                    <div class="text-center">
                        <p class="fs--16 line-height-20 fw-medium text-veris mb-0">Persona agregada exitosamente</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal mensaje para errores fuera de 200 -->    
    <div class="modal fade" id="mensajeErrorModal" tabindex="-1" aria-labelledby="mensajeErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-exclamation-triangle-fill  text-primary-veris h2"></i>
                    <p class="fs--1 fw-medium line-height-20 text-veris m-0 mt-3" id="mensajeErrorModalLabel"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mensajePersonaYaExisteModal" tabindex="-1" aria-labelledby="mensajePersonaYaExisteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-exclamation-triangle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-medium line-height-20 text-veris m-0 mt-3" id="mensajePersonaYaExisteModalLabel"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Familia y amigos') }}</h5>
    </div>
    <section class="pt-4 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 px-0">
                <ul class="list-group bg-white rounded-3 shadow-sm w-100">
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-3 py-2">
                        <div class="mx-0">
                            <h6 class="fw-medium fs--16 line-height-20 mb-1 text-veris-ai nombreFamiliar text-capitalize"></h6>
                            <p class="fs--2 text-veris line-height-16 mb-0 numeroIdentificacionFamiliar"></p>
                            <p class="fs--2 text-veris line-height-16 mb-0 fechaNacimientoFamiliar"></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 px-0">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-transparent shadow-none mb-4">
                            <div class="card-body py-3 pt-2 px-0">
                                <div class="row g-3">
                                    <div class="col-md-12 listConvenios">
                                    </div>
                                    <div class="col-md-12">
                                        <p class="fs--20 line-height-24 text-veris my-0 ">Ingresa la relación</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="relacion" class="form-label fs--1 line-height-16 fw-medium">{{ __('Relación') }} *</label>
                                        <select class="form-select fs--1 line-height-16 p-3 form-filter border-0 rounded-3 text-capitalize" name="relacion" id="relacion" required>
                                        </select>
                                        <div class="invalid-feedback">
                                            Elegir relación.
                                        </div>
                                    </div>
                                    <div class="col-12 mt--32">
                                        <button class="btn btn-primary-veris rounded-3 fs--18 line-height-24 w-100 px-4 py-3 text-white disabled" data-bs-toggle="modal" data-bs-target="#confirmarPregunta" id="btnGuardar">Guardar</button>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')>
 
<script>
    // variables globales
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let datostiposIdentificacion;
    let datosConsultarPersona;
    let codigoParentescoClick;
    //llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        $('.nombreFamiliar').html(`${(dataCita.familiar.primerNombre.toLowerCase()) ?? `` } ${(dataCita.familiar.primerApellido.toLowerCase()) ?? ``} ${(dataCita.familiar.segundoApellido.toLowerCase()) ?? ``}`);
        $('.primerNombreFamiliar').html(`${dataCita.familiar.primerNombre.toLowerCase()}`);

        $('.numeroIdentificacionFamiliar').html(`<b>No. de identificación:</b> ${dataCita.familiar.numeroIdentificacion}`)
        $('.fechaNacimientoFamiliar').html(`<b>Fecha de nacimiento:</b> ${dataCita.familiar.fechaNacimiento}`)

        $('body').on('change', '#relacion', function(){
            $('#btnGuardar').removeClass('disabled');
        })

        await consultarTipoParentesco();
        await obtenerConvenios();
    });

    
    // funciones asyncronas
    // obtener los tipos de identificación
    async function obtenerConvenios() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${_canalOrigen}&tipoIdentificacion=${dataCita.familiar.tipoIdentificacion}&numeroIdentificacion=${dataCita.familiar.numeroIdentificacion}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data);
        let elem = ``
        if (data.code == 200) {
            $.each(data.data, function(key, value){
                elem += `<label class="list-group-item border rounded-3 bg-white p-2 shadow-sm mb-2">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <img src="${value.rutaImagenConvenio}" class="img-fluid">
                        <div class="col-auto flex-grow-1 text-start ms-2">
                            <p class="text-veris fs--1 fw-medium line-height-16 mb-0 text-capitalize text-truncate">${value.nombreConvenioUsuarioFinal.toLowerCase().substring(0, 40) + '...'}</p>
                        </div>
                    </div>
                </label>`;
            })
            $('.listConvenios').html(elem)
        }
        return data;
    }

    // consular tipos de parentesco
    async function consultarTipoParentesco() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/tiposparentesco`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log('consultarTipoParentesco', data);
        if (data.code == 200) {
            datosTipoParentesco = data.data;
            let elem = `<option value="" disabled hidden selected>Elegir relación</option>`;
            $.each(datosTipoParentesco, function(key, value){
                elem += `<option data-rel='${JSON.stringify(value)}' class="text-capitalize" value="${value.codigoParentesco}">${value.descripcion.toLowerCase()}</option>`;
            })
            $('#relacion').html(elem);
        }else if (data.code != 200) {
            $("#mensajeErrorModalLabel").html(data.message);
            $("#mensajeErrorModal").modal("show");
        }
        return data;
    }

    // agregar persona
    async function agregarPersona(showConfirmation = false) {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        
        args["data"] = JSON.stringify({
            "codigoUsuario": "{{ Session::get('userData')->numeroIdentificacion }}",
            "numeroIdentificacion": dataCita.familiar.numeroIdentificacion,
            "tipoIdentificacion": parseInt(dataCita.familiar.tipoIdentificacion),
            "codigoParentesco": parseInt(getInput('relacion'))
        });

        const data = await call(args);
        console.log('agregarPersona', data);
        if (data.code == 200) {
            if(!showConfirmation){
                $("#mensajePersonaAgregadaModal").modal("show");
            }
        }
        else if (data.code != 200) {
            $("#mensajeErrorModalLabel").html(data.message);
            $("#mensajeErrorModal").modal("show");
        }
        return data;
    }


    // funciones jquery
    // revisar campos null y undefined
    function revisarCamposNullUndefined(campo) {
        if (campo == null || campo == undefined) {
            return "";
        } else {
            // return campo;
            return campo.charAt(0).toUpperCase() + campo.slice(1).toLowerCase();
        }
    }

    // agregar persona
    $("#btnAgregarPersona").click(async function() {
        await agregarPersona();
    });

    $("#btnSolicitarPermiso").click(async function() {
        await agregarPersona(true);
        await sendCode();
    });

    async function sendCode(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/solicitaAdmin`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        
        args["data"] = JSON.stringify({
            "numeroPaciente": dataCita.familiar.numeroPaciente,
            "virusu": dataCita.familiar.numeroIdentificacion,
            "correo": dataCita.familiar.correo,
            "canalOrigenDigital": _canalOrigen
        });

        const data = await call(args);
        if(data.code == 200){
            dataCita.parentesco = JSON.parse($('#relacion option:selected').attr('data-rel'))
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            location.href = "/confirmar-soporte/{{ $params }}";
        }
    }

    // seleccionar tipo de parentesco
    $(document).on('click', '#parentescoClick', async function() {
        let parentesco = $(this).text();
        let codigoParentesco = $(this).val();
        codigoParentescoClick = codigoParentesco;
        console.log('parentesco', parentesco);
        console.log('codigoParentesco', codigoParentesco);
        $("#parentescoFamiliarModal").modal("hide");
        await agregarPersona();
    });

    // Función para llenar el select
    function llenarSelect() {
        if (datostiposIdentificacion) {
            datostiposIdentificacion.forEach(function(tipoIdentificacion) {
                $("#tipoIdentificacion").append('<option value="' + tipoIdentificacion.codigoTipoIdentificacion + '">' + tipoIdentificacion.nombreTipoIdentificacion + '</option>');
            });
        }
    }

    // Función para llenar la lista de tipos de parentesco

    function llenarModal(datosTipoParentesco) {
        const lista = document.querySelector('.list-group');

        lista.innerHTML = '';

        datosTipoParentesco.forEach(parentesco => {
            const listItem = document.createElement('a');
            // listItem.href = "{{route('familia.lista')}}";
            listItem.classList.add('list-group-item', 'list-group-item-action', 'text-primary-veris', 'fs--16', 'px-3', 'py--2');
            listItem.textContent = capitalizarElemento(parentesco.descripcion);
            listItem.value = parentesco.codigoParentesco;
            listItem.id = 'parentescoClick'
            lista.appendChild(listItem);
        });
    }

    // redireccionar a la lista de familiares
    $("#btnEntendido").click(function() {
        window.location.href = "{{route('familia.lista')}}";
    });

</script>
@endpush