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
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis Promociones') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <ul class="nav nav-pills justify-content-center bg-white w-auto p-1 rounded-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5 active" id="pills-compradas-tab" data-bs-toggle="pill" data-bs-target="#pills-compradas" type="button" role="tab" aria-controls="pills-compradas" aria-selected="true">Compradas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5" id="pills-realizadas-tab" data-bs-toggle="pill" data-bs-target="#pills-realizadas" type="button" role="tab" aria-controls="pills-realizadas" aria-selected="false">Realizadas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-8 px-md-5" id="pills-archivadas-tab" data-bs-toggle="pill" data-bs-target="#pills-archivadas" type="button" role="tab" aria-controls="pills-archivadas" aria-selected="false">Realizadas</button>
                </li>
            </ul>
            <div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
                <!-- Filtro -->
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
                <div class="tab-pane fade mt-3 show active" id="pills-compradas" role="tabpanel" aria-labelledby="pills-compradas-tab" tabindex="0">
                    <div id="contenedorPromocionesCompradas" class="px-0">
                    </div>
                </div>
                <div class="tab-pane fade mt-3" id="pills-realizadas" role="tabpanel" aria-labelledby="pills-realizadas-tab" tabindex="0">R
                </div>
                <div class="tab-pane fade mt-3" id="pills-archivadas" role="tabpanel" aria-labelledby="pills-archivadas-tab" tabindex="0">A
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
        /*
        ASIGNADO
        REALIZADAS
        ARCHIVADAS
        */
        await obtenerPaquetesPromocionales("contenedorPromocionesCompradas","ASIGNADO")

        // aplicar filtros
        $('#aplicarFiltros').on('click', async function() {
            const contexto = $(this).data('context');
            aplicarFiltros(contexto);
            // Obtener el texto completo de la opción seleccionada data-rel
            let texto = $('input[name="listGroupRadios"]:checked').data('rel');
            await consultarConvenios(texto);
            identificacionSeleccionada = texto.numeroPaciente;
            // colocar el nombre del filtro
            const elemento = document.getElementById('nombreFiltro');
            if (texto == 'YO') {
                elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
            } else{
                elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
            }
        });

        // limpiar filtros
        $('#btnLimpiarFiltros').on('click', function() {
            const contexto = $(this).data('context');
            limpiarFiltros(contexto);
            identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
            const elemento = document.getElementById('nombreFiltro');
            elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
        });

        // boton promociones compradas
        $('#pills-compradas-tab').on('click', async function(){
            const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
            // await obtenerTratamientosId(identificacionSeleccionada, '', '', 'REALIZADO', esAdmin);
        });

        // boton promociones realizadas
        $('#pills-realizadas-tab').on('click', async function(){
            // console.log('pendientes');
            const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
            // await obtenerTratamientosId(identificacionSeleccionada, '', '', 'PENDIENTE', esAdmin);
        });

        // boton promociones archivadas
        $('#pills-archivadas-tab').on('click', async function(){
            // console.log('pendientes');
            const esAdmin = $('input[name="listGroupRadios"]:checked').attr('esAdmin');
            // await obtenerTratamientosId(identificacionSeleccionada, '', '', 'PENDIENTE', esAdmin);
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

    async function obtenerPaquetesPromocionales(idSection, tipoFiltro){
        var paciente = JSON.parse($('input[name="listGroupRadios"]:checked').attr("data-rel"));
        // let idPaciente = "";
        // if(parseInt({{ Session::get('userData')->numeroPaciente }}) !== paciente.numeroPaciente){

        // }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=${tipoFiltro}&page=${page}&perPage=${perPage}&idPaciente=${ paciente.numeroPaciente }&estaPagado=true&verDetalle=false&buscarPorPromocion=${ (getInput('buscarPorPromocion').replace(/\s/g, '+')) }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
    }

    async function __obtenerPaquetesPromocionales(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=POR_ASIGNAR&page=${page}&perPage=${perPage}&verDetalle=false&buscarPorPromocion=${ (getInput('buscarPorPromocion').replace(/\s/g, '+')) }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let elem = ``;
            if(data.data.items.length == 0){
                cargandoContenido = true;
            }else{
                cargandoContenido = false;  
            }
            if(data.data.items.length > 0){
                $.each(data.data.items, function(key, paquete){
                    elem += `<div class="col-md-6">
                        <div class="card w-100" style="border: 1px solid #E7E9EC;box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.10);">
                            <div class="row g-0 justify-content-between aling-items-center cursor-pointer btn-comprar" data-rel='${ JSON.stringify(paquete) }'>
                                <div class="col-4 col-md-auto">
                                    <img src="{{ asset('assets/img/svg/promocion.svg') }}" class="img-fluid" alt="{{ __('promoción') }}">
                                </div>
                                <div class="col-8 col-md-8">
                                    <div class="card-body h-100 p--2 pb-2 d-flex flex-column justify-content-center">
                                        <h6 class="text-end fs--1 line-height-16 fw-medium mb-2">${truncateText(capitalizarElemento(paquete.nombrePaquete), 40)}</h6>
                                        <div class="d-flex justify-content-end">`;
                                            if(paquete.porcentajeDescuento > 0){
                                                elem += `<span class="badge bg-primary d-flex align-items-center fs--2 line-height-16 rounded-1 px--2 py-2 mx-3">-${paquete.porcentajeDescuento}%</span>`;
                                            }
                                                elem += `<div class="content-precio text-end">`;
                                            if(paquete.porcentajeDescuento > 0){
                                                elem += `<p class="fs--3 line-height-16 mb-0" style="color: #6E7A8C;">Antes <del>$${paquete.valorAnteriorPaquete.toFixed(2)}</del></p>`
                                            }
                                                elem += `<h4 class="fs-24 line-height-28 fw-medium mb-0" style="color: #0071CE !important;">$${paquete.valorTotalPaquete.toFixed(2)}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                })
                page++;
            }else{
                if(page == 1){
                    elem += `<p class="fs--16 line-height-20 text-center mt-5 mb-4">No se encontraron coincidencias para tu búsqueda</p>`;
                }
            }
            $('#listado-paquetes').append(elem);
        }else{
            alert(data.message);
        }
    }
</script>
@endpush