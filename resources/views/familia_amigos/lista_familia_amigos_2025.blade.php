@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Familia y amigos
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="/mi-cuenta" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="eliminarFamiliarModal" tabindex="-1" aria-labelledby="eliminarFamiliarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3 pb-0">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/ifon-tria.svg')}}" alt="">
                    </div>
                    <div class="text-center">
                        <h5 class="fw-medium line-height-24 mb-3">Eliminar familiar</h5>
                        <p class="fs--1 text-veris mb-3">¿Deseas eliminar a <b class="fw-medium text-veris" id="nombreFamiliar"></b> de tu lista?</p>
                        <input type="hidden" id="idRelacion">
                    </div>
                </div>
                <div class="modal-footer justify-content-center pt-0 p-3">
                    <button type="button" class="btn text-danger fs--18 line-height-24 m-0 px-4 py-3" style="color: #D84315;" id="eliminarFamiliar">Eliminar</button>
                    <button type="button" class="btn text-primary fs--18 line-height-24 m-0 px-4 py-3" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaEliminadaModal" tabindex="-1" aria-labelledby="mensajePersonaEliminadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/check-circle.svg')}}" alt="">
                    </div>
                    <div class="text-center">
                        <p class="fs--16 line-height-20 fw-medium text-veris mb-0">Persona eliminada de tu grupo</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Familia y amigos') }}</h5>
    </div>
    <section class="py-4 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card bg-transparent shadow-none mb-4">
                        <div class="card-body p-0">
                            <div class="text-center d-none" id="noPeopleAdded">
                                <i class="bi bi-person" style="font-size: 128px;"></i>
                                <p class="fw-medium">Aún no tiene personas agregadas</p>
                            </div>
                            <div class="card-footer p-0 mb-3">
                                <a href="{{route('familia')}}" class="btn btn-primary-veris fs--18 line-height-24 rounded-3 m-0 w-100 px-4 py-3">Agregar</a>
                            </div>
                            <div class="d-flex flex-column flex-md-row gap-4 align-items-center justify-content-center">
                                <div class="list-group list-group-radio d-grid gap-3 border-0 w-100" id="familia-lista">
                                    <!-- Puedes agregar familias dinámicamente aquí desde JavaScript -->
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

        $('body').on('click','.enlaceDetalles', async function () {
            let persona = JSON.parse($(this).attr('data-rel'));
            let url = $(this).attr('href-rel');
            let dataCita = {}
            dataCita.persona = persona;
            localStorage.setItem('persona-{{ $tokenCita }}', JSON.stringify(dataCita));
            location.href = `/datos-familiar/{{ $tokenCita }}`;
        });
        
    });

    // Funciones asycnronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('data', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarDatosEnDiv(data.message);
        }
        return data;
    }

    // eliminar familiar

    async function eliminarFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        let idRelacion = $('#idRelacion').val();
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo/${idRelacion}`
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
    function mostrarDatosEnDiv(msg) {
        const data = familiar;
        const divContenedor = document.getElementById('familia-lista');
        // Limpiar el contenido actual
        divContenedor.innerHTML = '';
        // Iterar sobre los datos y crear elementos para cada familiar
        let elem = ``;
        if(familiar !== null){
            console.log(familiar)
            data.forEach(familiar => {
                let esAdminBadge = ``;
                let ownMyAccount = ``;
                console.log(familiar.poseoAdmin, familiar.tieneAdmin)
                if(familiar.poseoAdmin == "S"){
                    esAdminBadge = `<span class="badge rounded-pill bg-purple-light text-veris-ai line-height-12 fs--3 me-2 fw-light">Eres administrador</span>`;
                }

                if(familiar.tieneAdmin == "S"){
                    ownMyAccount = `<span class="badge rounded-pill bg-green-light text-green line-height-12 fs--3 me-2 fw-light">Este usuario administra tu cuenta</span>`;
                }

                elem += `<div class="list-group-item border rounded-3 bg-white p-3" style="border: 1px solid #CDD4DA !important; box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.05);">
                    <div class="d-flex justify-content-start align-items-center w-100 mb-2">
                        ${esAdminBadge}
                        ${ownMyAccount}
                    </div>
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="flex-grow-1">
                            <p class="text-veris fs--1 fw-medium line-height-16 mb-1 nombrePariente">${capitalizarElemento(familiar.primerNombre)} ${capitalizarElemento(familiar.primerApellido)} ${capitalizarElemento(familiar.segundoApellido)}</p>
                            <p class="fs--3 line-height-12 mb-1 parentesco">${capitalizarElemento(familiar.parentesco)}</p>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn p-0 text-danger shadow-none me-2 eliminarFamiliarBtn" data-bs-toggle="modal" data-bs-target="#eliminarFamiliarModal" idRelacion-rel="${familiar.idRelacion}" nombre-familiar="${familiar.primerNombre} ${familiar.primerApellido}">
                                <img src="{{asset('assets/img/svg/Tacho.svg')}}" class="" alt="eliminar familiar medico">
                            </button>
                            <div class="btn p-0 text-primary enlaceDetalles" data-rel='${JSON.stringify(familiar)}'>
                                <img src="{{asset('assets/img/svg/chevron.svg')}}" class="" alt="editar familiar medico">
                            </div>
                            <input type="hidden" value="${familiar.idRelacion}" id="idRelacion">
                        </div>
                    </div>
                </div>`;
            });
        }else{
            elem += `<p class="fs--16 text-center line-height-20 mb-4">${msg}</p>`;
        }
        $('#familia-lista').append(elem);
    }
</script>
<style>
    .bg-purple-light{
        background: #EAF0FD;
    }
    .bg-green-light{
        background: #D1FDDE;
    }
    .text-green{
        color: #0D9947;
    }
</style>
@endpush