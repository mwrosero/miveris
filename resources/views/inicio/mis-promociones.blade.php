@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Mis Promociones
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<!-- Modal Permite Cambio -->
<div class="modal fade" id="modalArchivarDesarchivar" tabindex="-1" aria-labelledby="modalArchivarDesarchivarLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3 pb-0">
                <h1 class="fs-24 fw-medium line-height-28 my-3">Veris</h1>
                <p class="fs--1 line-height-16 text-veris mb-3" id="mensajeArchivarDesarchivar"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" onclick="refreshSection();">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis Promociones') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center w-auto p-1 rounded-3 invisible" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-white btn-estado-promocion px-8 px-md-5 m-1 d-flex flex-column active" tipoFiltro-rel="ASIGNADO" id="pills-compradas-tab" data-bs-toggle="pill" data-bs-target="#pills-compradas" type="button" role="tab" aria-controls="pills-compradas" aria-selected="true">
                        <img src="{{ asset('assets/img/svg/promociones-compradas-selected-ico.svg') }}" alt="" class="ico-estado ico-estado-activo">
                        <img src="{{ asset('assets/img/svg/promociones-compradas-ico.svg') }}" alt="" class="d-none ico-estado ico-estado-inactivo">
                        <p class="fs--2 line-height-20 mt-2 mb-0">Compradas</p>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-white btn-estado-promocion px-8 px-md-5 m-1 d-flex flex-column" tipoFiltro-rel="REALIZADAS" id="pills-realizadas-tab" data-bs-toggle="pill" data-bs-target="#pills-realizadas" type="button" role="tab" aria-controls="pills-realizadas" aria-selected="false">
                        <img src="{{ asset('assets/img/svg/promociones-realizadas-ico.svg') }}" alt="" class="ico-estado ico-estado-inactivo">
                        <img src="{{ asset('assets/img/svg/promociones-realizadas-selected-ico.svg') }}" alt="" class="d-none ico-estado ico-estado-activo">
                        <p class="fs--2 line-height-20 mt-2 mb-0">Realizadas</p>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-white btn-estado-promocion px-8 px-md-5 m-1 d-flex flex-column" tipoFiltro-rel="ARCHIVADAS" id="pills-archivadas-tab" data-bs-toggle="pill" data-bs-target="#pills-archivadas" type="button" role="tab" aria-controls="pills-archivadas" aria-selected="false">
                        <img src="{{ asset('assets/img/svg/promociones-archivadas-ico.svg') }}" alt="" class="ico-estado ico-estado-inactivo">
                        <img src="{{ asset('assets/img/svg/promociones-archivadas-selected-ico.svg') }}" alt="" class="d-none ico-estado ico-estado-activo">
                        <p class="fs--2 line-height-20 mt-2 mb-0">Archivadas</p>
                    </button>
                </li>
            </ul>
            <div class="tab-content bg-transparent px-0 pt-0 pb-3 px-lg-4" id="pills-tabContent">
                <!-- Filtro -->
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                {{-- <div class="tab-pane fade mt-3 show active" id="pills-compradas" role="tabpanel" aria-labelledby="pills-compradas-tab" tabindex="0">
                    <div id="contenedorPromocionesCompradas" class="px-0">
                    </div>
                </div>
                <div class="tab-pane fade mt-3" id="pills-realizadas" role="tabpanel" aria-labelledby="pills-realizadas-tab" tabindex="0">R
                </div>
                <div class="tab-pane fade mt-3" id="pills-archivadas" role="tabpanel" aria-labelledby="pills-archivadas-tab" tabindex="0">A
                </div> --}}
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-lg-10">
                <div class="row gy-3" id="contenedorPromociones">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let page = 1;
    let perPage = 16;
    let cargandoContenido = false;
    
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await consultarGrupoFamiliar();
        $('#pills-tab').removeClass("invisible");

        $('.box-fechas-filtro').remove();

        $('#aplicarFiltros').on('click', async function() {
            // colocar el nombre del filtro
            page = 1;
            $('#contenedorPromociones').empty();
            let texto = $('input[name="listGroupRadios"]:checked').data('rel');
            const elemento = document.getElementById('nombreFiltro');
            if (texto == 'YO') {
                elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
            } else {
                elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
            }
            isFiltered = true;
            await obtenerPaquetesPromocionales($('.btn-estado-promocion.active').attr("tipoFiltro-rel"));
            isFiltered = false;
            $('#filtroTratamientos').offcanvas('hide');

        });

        $('#btnLimpiarFiltros').on('click', async function() {
            page = 1;
            $('#contenedorPromociones').empty();
            const contexto = $(this).data('context');
            $('input[name="listGroupRadios"]').prop('checked', false);
            $('input[name="listGroupRadios"]').first().prop('checked', true);
            const elemento = document.getElementById('nombreFiltro');
            elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
            isFiltered = true;
            await obtenerPaquetesPromocionales($('.btn-estado-promocion.active').attr("tipoFiltro-rel"));
            isFiltered = false;
            $('#filtroTratamientos').offcanvas('hide');
        });

        $('body').on('click','.btn-detalle', function(){
            let url = '/mi-promocion/detalle/';
            let data = {
                "paquete": JSON.parse($(this).attr("data-rel"))
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
            location.href = url + "{{ $tokenCita }}";
        })

        $('body').on('click', '.btnDesarchivar', async function(){
            await archivarDesarchivar($(this).attr("secuenciaPaquetePaciente-rel"), $(this).attr("tipo-rel"));
        })

        /*
        ASIGNADO
        REALIZADAS
        ARCHIVADAS
        */
        await obtenerPaquetesPromocionales("ASIGNADO")

        // aplicar filtros
        $('#aplicarFiltros').on('click', async function() {
            // colocar el nombre del filtro
            page = 1;
            $('#listado-paquetes').empty();
            let texto = $('input[name="listGroupRadios"]:checked').data('rel');
            const elemento = document.getElementById('nombreFiltro');
            if (texto == 'YO') {
                elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
            } else {
                elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
            }
            isFiltered = true;
            await obtenerPaquetesPromocionales($('.btn-estado-promocion.active').attr("tipoFiltro-rel"));
            isFiltered = false;
            $('#filtroTratamientos').offcanvas('hide');

        });
        
        $('#btnLimpiarFiltros').on('click', async function() {
            page = 1;
            $('#listado-paquetes').empty();
            const contexto = $(this).data('context');
            $('input[name="listGroupRadios"]').prop('checked', false);
            $('input[name="listGroupRadios"]').first().prop('checked', true);
            const elemento = document.getElementById('nombreFiltro');
            elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
            isFiltered = true;
            await obtenerPaquetesPromocionales($('.btn-estado-promocion.active').attr("tipoFiltro-rel"));
            isFiltered = false;
            $('#filtroTratamientos').offcanvas('hide');
        });

        // boton promociones compradas
        $('#pills-compradas-tab, #pills-realizadas-tab, #pills-archivadas-tab').on('click', async function(){
            $('.ico-estado-activo').addClass('d-none');
            $('.ico-estado-inactivo').removeClass('d-none');

            $(this).find('.ico-estado-inactivo').addClass('d-none')
            $(this).find('.ico-estado-activo').removeClass('d-none')

            page = 1;
            $('#contenedorPromociones').empty();
            await obtenerPaquetesPromocionales($('.btn-estado-promocion.active').attr("tipoFiltro-rel"));
        });
    })

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        // console.log('dataFa', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientesFiltro();
        }
        return data;
    }

    // mostrar lista de pacientes en el filtro
    function mostrarListaPacientesFiltro(){
        let data = familiar;
        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let isFirstElement = true; // Variable para identificar el primer elemento
        data.forEach((Pacientes) => {
            let checkedAttribute = isFirstElement ? 'checked' : 'unchecked'; // Establecer 'checked' para el primer elemento
            isFirstElement = false; // Asegurar que solo el primer elemento sea 'checked'

            let elemento = `<div class="position-relative">
                                <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="listGroupRadios-${Pacientes.numeroPaciente}" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} ${checkedAttribute}>
                                <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="listGroupRadios-${Pacientes.numeroPaciente}">
                                    <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}</p>
                                    <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</span>
                                </label>
                            </div>`;
            divContenedor.append(elemento);
        });
    }

    async function obtenerPaquetesPromocionales(tipoFiltro){
        var paciente = JSON.parse($('input[name="listGroupRadios"]:checked').attr("data-rel"));
        // let idPaciente = "";
        // if(parseInt({{ Session::get('userData')->numeroPaciente }}) !== paciente.numeroPaciente){

        // }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=${tipoFiltro}&page=${page}&perPage=${perPage}&idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${ paciente.numeroPaciente }&estaPagado=true&verDetalle=false`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        
        console.log(data);

        if(data.code == 200){
            let elem = ``;
            if(data.data.tienePermisoAdmin){
                $.each(data.data.items, function(key, value){
                    if(tipoFiltro == "ASIGNADO" || tipoFiltro == "ARCHIVADAS"){
                        elem += `<div class="col-md-6" id="promocion-${value.secuenciaPaquetePaciente}">
                            <div class="card m-1">
                                <div class="card-header position-relative feature-img-promocion" style="background: url(${value.urlImagen}) no-repeat center;">
                                </div>
                                <div class="card-body p-3 pb-0">
                                    <h2 class="title-promocion-mis-compras line-height-20 fs--16 mb-2">${capitalizarCadaPalabra(value.nombrePaquete)}</h2>
                                    <p class="fs--2 mb-1 text-nowrap overflow-hidden text-truncate">${capitalizarCadaPalabra(value.nombrePaciente)}</p>
                                    <p class="fs--2 mb-1">Válido hasta: ${ validarCaducidad(value.fechaCaducidad, value.esCaducada) }</p>
                                </div>
                                <div class="card-footer border-0 d-flex justify-content-end align-items-center p-3 pt-0">`;
                                if(!value.esCaducada){
                                    elem += `<div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-detalle" data-rel='${JSON.stringify(value)}'>Ver promoción</div>`;
                                }else{
                                    elem += `<div class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none btn-detalle" data-rel='${JSON.stringify(value)}'>Ver promoción</div>`;
                                }
                                
                                if(value.esCaducada && tipoFiltro == "ASIGNADO"){
                                    elem += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btnDesarchivar" tipo-rel="A" secuenciaPaquetePaciente-rel="${value.secuenciaPaquetePaciente}">Archivar</a>`
                                }else if(tipoFiltro == "ARCHIVADAS"){
                                    elem += `<a href="#" class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btnDesarchivar" tipo-rel="D" secuenciaPaquetePaciente-rel="${value.secuenciaPaquetePaciente}">Desarchivar</a>`
                                }
                                    elem += `
                                </div>
                            </div>
                        </div>`;
                    }else if(tipoFiltro == "REALIZADAS"){
                        elem += `<div class="col-md-6" id="promocion-${value.secuenciaPaquetePaciente}">
                            <div class="card m-1">
                                <div class="card-header position-relative feature-img-promocion" style="background: url(${value.urlImagen}) no-repeat center;">
                                </div>
                                <div class="card-body p-3 pb-0">
                                    <h2 class="title-promocion-mis-compras line-height-20 fs--16 mb-2">${capitalizarCadaPalabra(value.nombrePaquete)}</h2>
                                    <p class="fs--2 mb-1 text-nowrap overflow-hidden text-truncate">${capitalizarCadaPalabra(value.nombrePaciente)}</p>
                                </div>
                                <div class="card-footer border-0 d-flex justify-content-between align-items-center p-3 pt-0">
                                    <img src="{{ asset('assets/img/svg/golden.svg') }}" />
                                    <div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-detalle" data-rel='${JSON.stringify(value)}'>Ver promoción</div>
                                </div>
                            </div>
                        </div>`;
                    }
                })
                if(data.data.items == 0){
                    let tipoF;
                    if(tipoFiltro == "ASIGNADO"){
                        tipoF = "compradas";
                    }else if(tipoFiltro == "REALIZADAS"){
                        tipoF = "realizadas";
                    }else{
                        tipoF = "archivadas";
                    }
                    elem += `<div class="col-12 d-flex justify-content-center" id="mensajeNoTienesPermisosAdministradorRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-28 mb-4">No tienes promociones ${tipoF}</h5>
                                    <img src="{{ asset('assets/img/svg/no-resultados-promociones.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
            }else{
                elem += `<div class="col-12 d-flex justify-content-center" id="mensajeNoTienesPermisosAdministradorRealizados">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fs-24 fw-medium line-height-28 mb-4">No tienes permisos de administrador</h5>
                                    <p class="fs--16 line-height-20 mb-4">Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                    <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                    </div>`;
            }
            $('#contenedorPromociones').html(elem);
        }
    }

    function validarCaducidad(fecha, esCaducada){
        let elem = ``;
        if(esCaducada){
            elem += `<span class="text-danger">${fecha} | Caducado</span>`;
        }else{
            elem += `<span class="text-primary-veris">${fecha}</span>`;
        }
        return elem;
    }

    async function archivarDesarchivar(secuenciaPaquetePaciente, tipo){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paqueteArchivar/${secuenciaPaquetePaciente}`;
        args["method"] = "PUT";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(tipo);
        console.log(data);
        //Menos para edictar reserva 
        if(data.code == 200){
            // $('#promocion-'+secuenciaPaquetePaciente).remove();
            $('#mensajeArchivarDesarchivar').html(data.message);
            $('#modalArchivarDesarchivar').modal("show");
        }
    }

    async function refreshSection(){
        await obtenerPaquetesPromocionales($('.btn-estado-promocion.active').attr("tipoFiltro-rel"));
    }

</script>
<style>
    .nav-pills .nav-link{
        box-shadow: 0px 2px 4px 0px #0000000D !important;
        border-radius: 8px !important;
        padding: 8px !important;
        border: 2px solid #fff;
        color: #3A5068;
        width: 104px !important;
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link.active:hover, .nav-pills .nav-link.active:focus {
        background-color: #fff;
        color: #0071CE;
        border: 2px solid #0071CE;
        box-shadow: 0px 2px 4px 0px #0000000D !important;
        border-radius: 8px !important;
        padding: 8px !important;
        font-weight: 500;
    }
</style>    
@endpush