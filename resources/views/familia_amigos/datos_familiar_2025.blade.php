@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')

<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal actualizacion exitosa -->
    <div class="modal fade" id="mensajeActualizacionExitosa" tabindex="-1" aria-labelledby="mensajeActualizacionExitosa" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/check-circle.svg')}}" alt="">
                    </div>
                    <div class="text-center">
                        <p class="fs--16 line-height-20 fw-medium text-veris mb-0" id="mensajeActualizacionExitosa">Actualización exitosa</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <a href="/familia-amigos-lista" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24" id="nombreFamiliar"></h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-5">
                <ul class="list-group mb-3 d-none">
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center p-2">
                        <div class="mx-auto">
                            <p class="fs--2 mb-0">¿Deseas asignar a esta persona como administrador de tu cuenta?</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input fs-3 ms-0" type="checkbox" role="switch" name="administrador"id="administrador" />
                        </div>
                    </li>
                </ul>
                <div class="info-admin mb-3"></div>
                <div class="card mb-3 bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <div class="col-md-12">
                            <label for="numeroIdentificacion" class="form-label fs--1 line-height-16 fw-medium">{{ __('Número de identificación') }} *</label>
                            <input type="text" disabled class="form-control fs--1 line-height-16 p-3 rounded-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="Ingresa tu número de identificación" required />
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="relacion" class="form-label fs--1 line-height-16 fw-medium">{{ __('Relación') }} *</label>
                            <select class="form-select form-filter fs--1 line-height-16 p-3 bg-white" id="relacion" required>
                            </select>
                            <div class="invalid-feedback">
                                Elegir el tipo de parentesco.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto mx-lg-3">
                    <button class="btn btn-primary-veris w-100 fs--18 line-height-24 rounded-3 py-3 disabled" type="button" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    // variables globales
    let local = localStorage.getItem('persona-{{ $params }}');
    let dataCita = JSON.parse(local);
    let datosTipoParentesco = [];
    let valorCheck = "N"; 
    let tipoParentesco;
    let tipoRelacion;
    let administrador = "N";

    // llamada del dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarTipoParentesco();
        llenarDatosFamiliar();

        $('body').on('change', '#relacion', function(){
            $('#btnGuardar').removeClass('disabled');
        })
    });

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
            llenarSelectTipoParentesco();
        }
        return data;
    }

    //modificar datos del familiar

    async function modificarDatosFamiliar(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
            "codigoParentesco": parseInt(getInput('relacion')),
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
        let select = document.getElementById('relacion');
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
        document.getElementById('nombreFamiliar').innerHTML = dataCita.persona.primerNombreFamiliar + ' ' + dataCita.persona.primerApellidoFamiliar;
        $('#numeroIdentificacion').val(dataCita.persona.numeroIdentificacion);
        tipoParentesco = dataCita.persona.codigoParentesco;
        tipoRelacion = dataCita.persona.idRelacion;
        // llenar el select con el parentesco del localstorage
        let select = document.getElementById('relacion');
        select.value = tipoParentesco;

        // llenar el check con el administrador del localstorage
        if(dataCita.persona.poseoAdmin == "S"){
            $('#administrador').prop('checked', true);
        }else{
            $('#administrador').prop('checked', false);
        }

        let esAdminBadge = ``;
        let ownMyAccount = ``;

        if(dataCita.persona.poseoAdmin == "S"){
            esAdminBadge = `<span class="badge rounded-pill bg-purple-light text-veris-ai line-height-12 fs--3 me-2 fw-light">Eres administrador</span>`;
        }

        if(dataCita.persona.tieneAdmin = "S"){
            ownMyAccount = `<span class="badge rounded-pill bg-green-light text-green line-height-12 fs--3 me-2 fw-light">Este usuario administra tu cuenta</span>`;
        }

        $('.info-admin').html(`${esAdminBadge}${ownMyAccount}`);

    }
</script>
<style>
    .fs-1 {
        font-size: 1.5rem !important;
    }
    .bg-purple-light{
        background: #EAF0FD;
    }
    .bg-green-light{
        background: #D1FDDE;
    }
    .text-green{
        color: #0D9947;
    }
    {{-- input:placeholder-shown,
    select:invalid{
      border: 1px solid #E7E9EC !important;
      background: #FFFFFFCC !important;
      color: #3D4E66 !important;
    }

    input:not(:placeholder-shown),
    input:focus,
    select:valid{
      border: 1px solid #0071CE !important;
      color: #0071CE !important;
    }

    input:-webkit-autofill {
        border: 1px solid #0071CE !important;
        color: #0071CE !important;
        font-weight: 500 !important;
        -webkit-text-fill-color: #0071CE !important;
        transition: background-color 9999s ease-in-out 0s; /* Hack para evitar el fondo amarillo */
        background: #FFFFFFCC !important;
    }

    input:not(:placeholder-shown),
    select:valid{
      font-weight: 500 !important;
    } --}}
</style>
@endpush