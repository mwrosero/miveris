@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')

<!-- Modal actualizacion exitosa -->

<div class="modal fade" id="mensajeActualizacionExitosa" tabindex="-1" aria-labelledby="mensajeActualizacionExitosa" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                <p class="fs--1 fw m-0 mt-3" id="mensajeActualizacionExitosa">Actualización exitosa</p>
            </div>
            <div class="modal-footer pb-3 pt-0 px-3">
                <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white" id="nombreFamiliar"></h5>
    
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-4">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-3 py-2">
                        <div class="mx-auto">
                            <p class="fs--2 mb-0">¿Deseas asignar a esta persona como administrador de tu cuenta?</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input fs-3" type="checkbox" role="switch" name="administrador"id="administrador" />
                        </div>
                    </li>
                </ul>
                <div class="card mb-4">
                    <div class="card-body py-3">
                        
                        <div class="col-md-12">
                            <p class="fs--1 mb-0">Cédula: <b class="fw-normal" id="numeroIdentificacion"></b></p>
                        </div>
                        <div class="col-md-12">
                            <label for="tipoParentesco" class="form-label">{{ __('Selecciona el tipo de relación que tienes con esta persona') }} *</label>
                            <select class="form-select form-filter" id="tipoParentesco" required>
                                
                            </select>
                            <div class="invalid-feedback">
                                Elegir el tipo de parentesco.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto mx-lg-3">
                    <button class="btn btn-primary-veris w-100" type="button" id="btnGuardar" >
                        Guardar</button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>

    // variables globales

    let datosTipoParentesco = [];
    let valorCheck = "N"; 
    let tipoParentesco;
    let tipoRelacion;
    let administrador = "N";

    // llamada del dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarTipoParentesco();
        llenarDatosFamiliar();
    });


    // funciones asyncronas

    // // consultar grupo familiar
    // async function consultarGrupoFamiliar() {
    //     let args = [];
    //     let canalOrigen = _canalOrigen
    //     let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
    //     let tipoIdentificacion = localStorage.getItem('tipoIdentificacion');
    //     let numeroIdentificacion = localStorage.getItem('numeroIdentificacion');
    //     args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&numeroIdentificacion=${numeroIdentificacion}&tipoIdentificacion=${tipoIdentificacion}`
    //     console.log('args', args["endpoint"]);
    //     args["method"] = "GET";
    //     args["showLoader"] = false;
    //     const data = await call(args);
    //     console.log('dddata', data);
    //     if(data.code == 200){
    //         familiar = data.data;
    //         mostrarDatosEnDiv();

    //     }
    //     return data;
    // }

    // consular tipos de parentesco
    async function consultarTipoParentesco() {
        let args = [];
        args["endpoint"] = api_url + "/digitales/v1/perfil/tiposparentesco";
        args["method"] = "GET";
        args["showLoader"] = false;

        const data = await call(args);
        console.log('consultarTipoParentesco', data);

        if (data.code == 200) {
            datosTipoParentesco = data.data;
            llenarSelectTipoParentesco();
        }
        return data;
    }

    //modificar datos del familiar

    async function modificarDatosFamiliar(){
        let args = [];
        args["endpoint"] = api_url + "/digitales/v1/perfil/migrupo";
        args["method"] = "PUT";
        args["showLoader"] = false;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "codigoParentesco": parseInt(getInput('tipoParentesco')),
            "esAdmin" : valorCheck,
            "idRelacion": tipoRelacion,
        });

        console.log('args', args["data"]);

        const data = await call(args);
        console.log('modificarDatosFamiliar', data);

        return data;
    }

    // funciones jquery

    // guardar datos del familiar
    $('#btnGuardar').click(async function() {
        console.log('btnGuardar');
        const data = await modificarDatosFamiliar(); 
        if(data.code == 200){
            $('#mensajeActualizacionExitosa').modal('show');
        }   
    });

    //llenar el select 

    function llenarSelectTipoParentesco() {
        let select = document.getElementById('tipoParentesco');
        let html = '';
        datosTipoParentesco.forEach(element => {
            html += `<option value="${element.codigoParentesco}">${element.descripcion}</option>`;
        });
        select.innerHTML = html;
    }

    // valor del check
    $('#administrador').change(function() {
        if($(this).is(":checked")) {
            valorCheck = "S";
        }else{
            valorCheck = "N";
        }
        console.log('valorCheck', valorCheck);
    });

    //llenar datos del familiar
    function llenarDatosFamiliar() {
        document.getElementById('nombreFamiliar').innerHTML = localStorage.getItem('primerNombreFamiliar') + ' ' + localStorage.getItem('primerApellidoFamiliar');
        document.getElementById('numeroIdentificacion').innerHTML = localStorage.getItem('numeroIdentificacion');
        tipoParentesco = localStorage.getItem('codigoParentesco');
        tipoRelacion = localStorage.getItem('idRelacion');
        // llenar el select con el parentesco del localstorage
        let select = document.getElementById('tipoParentesco');
        select.value = tipoParentesco;

        // llenar el check con el administrador del localstorage
        if(localStorage.getItem('administrador') == "S"){
            $('#administrador').prop('checked', true);
        }else{
            $('#administrador').prop('checked', false);
        }

    }








</script>
<style>
    .fs-1 {
        font-size: 1.5rem !important;
    }
</style>
@endpush