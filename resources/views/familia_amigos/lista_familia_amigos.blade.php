@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">

    <!-- Modal -->
    <div class="modal fade" id="eliminarFamiliarModal" tabindex="-1" aria-labelledby="eliminarFamiliarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                        <div class="text-center">
                            <i class="bi bi-exclamation-triangle-fill fs-2 text-danger"></i>
                            <h5 class="mb-3">Eliminar familiar</h5>
                            <p class="fs--2 mb-0">¿Deseas eliminar a <b class="fw-bold" id="nombreFamiliar">
                                
                            </b> de tu lista?</p>
                            <input type="hidden" id="idRelacion">
                        </div>
                </div>
                <div class="modal-footer justify-content-center px-3 pt-0">
                    <button type="button" class="btn text-danger" id="eliminarFamiliar">Eliminar</button>
                    <button type="button" class="btn text-primary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaEliminadaModal" tabindex="-1" aria-labelledby="mensajePersonaEliminadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Persona eliminada de tu grupo</p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>


    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Familia y amigos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-4">
                <div class="card bg-transparent shadow-none mb-4">
                    <div class="card-body p-3">
                        <div class="text-center d-none" id="noPeopleAdded">
                            <i class="bi bi-person" style="font-size: 128px;"></i>
                            <p class="fw-bold">Aún no tiene personas agregadas</p>
                        </div>
                        <div class="card-footer p-0 mb-3">
                            <a href="{{route('familia')}}" class="btn btn-primary-veris m-0 w-100 py-3">Agregar</a>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-4 align-items-center justify-content-center">
                            <div class="list-group list-group-radio d-grid gap-2 border-0 w-100" id="familia-lista">
                                <!-- Puedes agregar familias dinámicamente aquí desde JavaScript -->
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
<script>

    // Variables globales

    let familiar = [];

    //llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarGrupoFamiliar();

        // boton Eliminar familiar

        $('body').on('click','#eliminarFamiliar', async function () {
            await eliminarFamiliar();
            
        });

        $('body').on('click','.eliminarFamiliarBtn', async function () {
            let idRelacion = $(this).attr('idRelacion-rel');
            $('#idRelacion').val(idRelacion);
            let nombreFamiliar = $(this).attr('nombre-familiar');
            $('#nombreFamiliar').text(capitalizarElemento(nombreFamiliar));
        });
        
    });

    // Funciones asycnronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('data', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarDatosEnDiv();

        }
        return data;
    }

    // eliminar familiar

    async function eliminarFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        let idRelacion = $('#idRelacion').val();
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo/${idRelacion}`
        args["method"] = "DELETE";
        args["showLoader"] = true;

        console.log('endpoint', args["endpoint"]);
        const data = await call(args);
        console.log('data', data);
        if(data.code == 200){
            $('#eliminarFamiliarModal').modal('hide');
            $('#mensajePersonaEliminadaModal').modal('show');
            await consultarGrupoFamiliar();
        }
        return data;
    }


    // funciones jquery
    function mostrarDatosEnDiv() {
        const data = familiar;
        const divContenedor = document.getElementById('familia-lista');

        // Limpiar el contenido actual
        divContenedor.innerHTML = '';

        // Iterar sobre los datos y crear elementos para cada familiar
        data.forEach(familiar => {
            let elem = `<label class="list-group-item d-flex justify-content-between align-items-center border rounded-3 bg-white px-2">
                            <div class="col-auto">
                                <p class="fs--2 fw-bold mb-0" id="nombrePariente">${capitalizarElemento(familiar.primerNombre)} ${capitalizarElemento(familiar.primerApellido)} ${capitalizarElemento(familiar.segundoApellido)}</p>
                                <p class="fs--3 mb-0" id="parentezco">${capitalizarElemento(familiar.parentesco)}</p>
                            </div>
                            <div class="d-flex">
                                <div class="btn px-1 text-danger shadow-none eliminarFamiliarBtn" data-bs-toggle="modal" data-bs-target="#eliminarFamiliarModal" idRelacion-rel="${familiar.idRelacion}" nombre-familiar="${familiar.primerNombre} ${familiar.primerApellido}">
                                    <i class="bi bi-trash"></i>
                                </div>
                                <a href='{{ route("familia.datosFamiliar") }}'; class="btn px-1 text-primary" id="enlaceDetalles" 
                                onclick="localStorage.setItem('primerNombreFamiliar', '${familiar.primerNombre}');
                                localStorage.setItem('primerApellidoFamiliar', '${familiar.primerApellido}');
                                localStorage.setItem('codigoParentesco', '${familiar.codigoParentesco}');
                                localStorage.setItem('administrador', '${familiar.esAdmin}');
                                localStorage.setItem('numeroIdentificacion', '${familiar.numeroIdentificacion}');
                                localStorage.setItem('idRelacion', '${familiar.idRelacion}');">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                                <input type="hidden" value="${familiar.idRelacion}" id="idRelacion">
                            </div>
                        </label>`;
            // Agregar el elemento al contenedor en cada iteración
            $('#familia-lista').append(elem);
        });
    }
</script>
@endpush