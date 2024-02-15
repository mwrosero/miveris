@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')

<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="parentescoFamiliarModal" tabindex="-1" aria-labelledby="parentescoFamiliarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-header justify-content-center align-items-center pt-3 pb-0 px-3">
                    <h1 class="modal-title fs--16 line-height-20 fw-medium" id="parentescoFamiliarModalLabel">Tipo de relación</h1>
                </div>
                <div class="modal-body p-3">
                    <!-- Lista dinámica de tipos de parentesco -->
                    <div class="list-group list-group-flush text-center fs--16">
                        <!-- La lista se llenará dinámicamente aquí -->
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn text-primary-veris fs--18 line-height-24 w-100 px-4 py-3" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaAgregadaModal" tabindex="-1" aria-labelledby="mensajePersonaAgregadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-medium line-height-20 m-0 mt-3">Persona agregada exitosamente</p>
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
                    <p class="fs--1 fw-medium line-height-20 m-0 mt-3" id="mensajeErrorModalLabel"></p>
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
                    <p class="fs--1 fw-medium line-height-20 m-0 mt-3" id="mensajePersonaYaExisteModalLabel"></p>
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
        <div class="container px-0">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <ul class="list-group bg-white">
                        <li class="list-group-item border-0 rounded-3 d-flex justify-content-between align-items-center px-3 py-2">
                            <div class="mx-auto">
                                <h6 class="fw-medium fs--16 line-height-20 mb-1">Hola <b class="fw-medium user-auth">{{ Session::get('userData')->nombre }}</b></h6>
                                <p class="fs--2 line-height-16 mb-0">Agrega personas a tu lista de familiares y amigos</p>
                            </div>
                        </li>
                    </ul>
                    <div class="card bg-transparent shadow-none mb-4">
                        <div class="card-body py-3 px-0">
                            <form class="row g-3">
                                <div class="col-md-12">
                                    <label for="tipoIdentificacion" class="form-label fs--1 line-height-16 fw-medium">{{ __('Tipo de identificación') }} *</label>
                                    <select class="form-select fs--1 line-height-16 p-3 form-filter border-0 rounded-3" name="tipoIdentificacion" id="tipoIdentificacion" required>
                                    </select>
                                    <div class="invalid-feedback">
                                        Elegir el tipo de identificación.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="numeroIdentificacion" class="form-label fs--1 line-height-16 fw-medium">{{ __('Número de identificación') }} *</label>
                                    <input type="text" class="form-control fs--1 line-height-16 p-3 rounded-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="Ingresa tu número de identificación" required />
                                    <div class="invalid-feedback">
                                        Ingresar número de identificación.
                                    </div>
                                </div>
                                <div class="col-12 mt--32">
                                    <button class="btn btn-outline-primary-veris bg-white rounded-3 fs--18 line-height-24 w-100 px-4 py-3" type="submit" id="btnBuscar">Buscar</button>
                                </div>
                            </form> 
                        </div>
                    </div>
                    <div id="resultadoConsulta" style="display: none;">
                        <ul class="list-group bg-white mb-3">
                            <li class="list-group-item border-0 d-flex justify-content-start align-items-center px-3 py-2">
                                <div class="me-auto">
                                    <h6 class="fw-medium fs--16 line-height-20 mb-0">Personas</h6>
                                </div>
                            </li>
                        </ul>
                        <div class="card mx-auto mx-lg-3">
                            <div class="card-body p--2">
                                <p class="text-secondary fs--16 line-height-20 mb-1"> <b class="hora-cita text-veris fw-medium" id="nombrePersona"></b></p>
                                <p class="text-secondary fs--1 mb-1" >Número de identificación: <b class="hora-cita text-veris fw-medium" id="numeroIdentificacionPersona"></b></p>
                                <p class="text-secondary fs--1 mb-1" >Ciudad: <b class="hora-cita text-veris fw-medium" id="ciudadPersona"></b></p>
                                <p class="text-secondary fs--1 mb-1" >Fecha de nacimiento: <b class="hora-cita text-veris fw-medium" id="fechaNacimientoPersona"></b></p>
                                <div class="d-flex justify-content-end align-items-center mt-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary-veris fs--1 px-3 py-2" data-bs-toggle="modal" data-bs-target="#parentescoFamiliarModal" id ="btnAgregarPersona">
                                        Agregar
                                    </button>
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
@push('scripts')
<script></script>
 
<script>
    // variables globales
    let datostiposIdentificacion;
    let datosConsultarPersona;
    let codigoParentescoClick;
    //llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await tiposIdentificacion();
        llenarSelect();
        
        
    });

    
    // funciones asyncronas
    // obtener los tipos de identificación
    async function tiposIdentificacion() {
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/seguridad/tiposIdentificacion";
        args["method"] = "GET";
        // args["showLoader"] = true;

        const data = await call(args);
        if (data.code == 200) {
            console.log('data.data', data.data);
            datostiposIdentificacion = data.data;
        } else if (data.code != 200) {
            $("#mensajeErrorModalLabel").html(data.message);
            $("#mensajeErrorModal").modal("show");
        }
        return data;
    }

    // Consultar base de personas.
    async function consultarPersona() {
        let canal= _canalOrigen;
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        let numeroIdentificacion = $("#numeroIdentificacion").val();
        let tipoIdentificacion = $("#tipoIdentificacion").val();
        let datosParentezco = [];
        console.log('tipoIdentificacion', tipoIdentificacion);
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/personas?canalOrigen=${canal}&codigoUsuario=${codigoUsuario}&numeroIdentificacion=${numeroIdentificacion}&tipoIdentificacion=${tipoIdentificacion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('consultqar persona', data);
        if (data.code == 200) {
            if(data.data == null){
                $("#mensajePersonaYaExisteModalLabel").html(data.message);
                $("#mensajePersonaYaExisteModal").modal("show");
                return;
            } else {
                datosConsultarPersona = data.data;
                console.log('datosConsultarPersona', datosConsultarPersona);
                $("#resultadoConsulta").show();

                //llenar datos de la persona
                $("#nombrePersona").text(revisarCamposNullUndefined(datosConsultarPersona[0].primerNombre) + " " + revisarCamposNullUndefined(datosConsultarPersona[0].segundoNombre) + " " + revisarCamposNullUndefined(datosConsultarPersona[0].primerApellido) + " " + revisarCamposNullUndefined(datosConsultarPersona[0].segundoApellido));
                $("#numeroIdentificacionPersona").text(datosConsultarPersona[0].numeroIdentificacion);
                $("#ciudadPersona").text(capitalizarPalabrasUnidasPorGuion(datosConsultarPersona[0].ciudad));
                $("#fechaNacimientoPersona").text(datosConsultarPersona[0].fechaNacimiento);
            }
        } else if (data.code != 200) {
            $("#mensajeErrorModalLabel").html(data.message);
            $("#mensajeErrorModal").modal("show");
        }
        return data;
    }
   
    // consular tipos de parentesco
    async function consultarTipoParentesco() {
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/perfil/tiposparentesco";
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log('consultarTipoParentesco', data);
        if (data.code == 200) {
            datosTipoParentesco = data.data;

            $("#parentescoFamiliarModal").modal("show");
        }
        else if (data.code != 200) {
            $("#mensajeErrorModalLabel").html(data.message);
            $("#mensajeErrorModal").modal("show");
        }
        return data;
    }

    // agregar persona
    async function agregarPersona() {
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/perfil/migrupo";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        
        args["data"] = JSON.stringify({
            "codigoUsuario": "{{ Session::get('userData')->numeroIdentificacion }}",
            "numeroIdentificacion": $("#numeroIdentificacion").val().toString(),
            "tipoIdentificacion": parseInt($("#tipoIdentificacion").val()),
            "codigoParentesco": codigoParentescoClick
        });

        const data = await call(args);
        console.log('agregarPersona', data);
        if (data.code == 200) {
            $("#mensajePersonaAgregadaModal").modal("show");
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

    //buscar persona
    $("form").on('submit', async function(e) {
        e.preventDefault(); // Evita el comportamiento predeterminado de envío del formulario
        await consultarPersona();
    });


    // agregar persona
    $("#btnAgregarPersona").click(async function() {
        await consultarTipoParentesco();
        llenarModal(datosTipoParentesco);

        // $("#parentescoFamiliarModal").modal("show");
    });

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
            listItem.textContent = parentesco.descripcion;
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