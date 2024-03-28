@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Promociones
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
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Promociones sugeridas') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="tab-content bg-transparent p-0" id="pills-tabContent">
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3 d-none">
            <div class="col-12 col-md-6 mb--24">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-promociones"></span>
                    <input type="search" class="form-control bg-transparent fs--16 border-0 p-3 ps-0" name="buscarPorPromocion" id="buscarPorPromocion" placeholder="Buscar plan preventivo" aria-describedby="search" />
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-lg-10">
                <div class="row gy-3" id="listado-paquetes">
                    {{-- <div class="col-md-6">
                        <div class="card w-100">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img/svg/promocion.svg') }}" class="img-fluid" alt="{{ __('promoción') }}">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body p--2">
                                            <h6 class="text-end fw-medium text-one-line">Prevención y Cuidado Mamario Integral</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-medium lh-1 mb-0" style="color: #6E7A8C !important;">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
           
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let page = 1;
    let perPage = 10;
    let cargandoContenido = false;
    let isFiltered = false;
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await consultarGrupoFamiliar();
        
        $('.box-fechas-filtro').remove();

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
            await obtenerPaquetesPromocionales();
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
            await obtenerPaquetesPromocionales();
            isFiltered = false;
            $('#filtroTratamientos').offcanvas('hide');
        });

        await obtenerPaquetesPromocionales();

        $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll); 

        async function onScroll(){
            // console.log('onScroll');
            // console.log(cargandoContenido)
            // console.log(isFiltered)
            // console.log($(window).scrollTop() + $(window).height() + 10)
            // console.log($(document).height())
            if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 100 > $(document).height()) {
                cargandoContenido = true;
                console.log("near bottom!");
                await obtenerPaquetesPromocionales();
            }
        }

        //$(window).scroll(async function() {
        // $(window).on('scroll touchmove', async function() {
        //     if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 10 > $(document).height()) {
        //         cargandoContenido = true;
        //         console.log("near bottom!");
        //         await obtenerPaquetesPromocionales();
        //     }
        // });

        $('body').on('click','.btn-comprar', function(){
            let url = '/promocion/detalle/';
            let data = {
                "paquete": JSON.parse($(this).attr("data-rel"))
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
            location.href = url + "{{ $tokenCita }}";
        })

        var typingTimer; // Timer identifier
        var doneTypingInterval = 500; // Tiempo de pausa en milisegundos (0.5 segundos)

        // Evento de escritura en el input
        $('#buscarPorPromocion').on('keyup', function() {
            clearTimeout(typingTimer); // Limpiar el temporizador cada vez que se escribe

            var searchText = $(this).val();
            if (searchText.length >= 3) { // Solo realizar la búsqueda si hay al menos 3 caracteres
                typingTimer = setTimeout(function() {
                    page = 1;
                    $('#listado-paquetes').empty();
                    cargandoContenido = false;
                    obtenerPaquetesPromocionales(); // Llamar a la función de búsqueda después de la pausa
                }, doneTypingInterval);
            }else if(searchText.length == 0){
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                obtenerPaquetesPromocionales();
            }
        });

        $('#buscarPorPromocion').on('search', function() {
            if ($(this).val().length === 0) {
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                obtenerPaquetesPromocionales();
            }
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

    async function obtenerPaquetesPromocionales(){
        var paciente = JSON.parse($('input[name="listGroupRadios"]:checked').attr("data-rel"));
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=SUGERIDOS&idPaciente={{ Session::get('userData')->numeroPaciente }}&idPacienteFiltrar=${paciente.numeroPaciente}&page=${page}&perPage=${perPage}&esPagado=false&verDetalle=false`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let elem = ``;
            if(data.data.tienePermisoAdmin){
                $.each(data.data.items, function(key, paquete){
                    elem += `<div class="col-md-6">
                        <div class="card w-100" style="border: 1px solid #E7E9EC;box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.10);border-radius: 8px;">
                            <div class="row g-0 justify-content-between aling-items-center cursor-pointer btn-comprar" data-rel='${ JSON.stringify(paquete) }'>
                                <div class="col-4 position-relative feature-img-promocion-horizontal" style="background: url(${paquete.urlImagen}) no-repeat center;">`
                                if(paquete.porcentajeDescuento && paquete.porcentajeDescuento > 0){
                                    elem += `<span class="label-descuento-promocion position-absolute fs--2 fw-medium">-${paquete.porcentajeDescuento}%</span>`;
                                }
                                elem += `</div>
                                <div class="col-8 col-md-8">
                                    <div class="card-body h-100 p--2 pb-2 d-flex flex-column justify-content-center">
                                        <h6 class="title-promocion-horizontal fs--1 line-height-16 mb-2">${capitalizarElemento(paquete.nombrePaquete)}</h6>
                                        <div class="border-0 d-flex justify-content-between align-items-center">`;
                                            if(paquete.porcentajeDescuento && paquete.porcentajeDescuento > 0){
                                                elem += `<div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$${paquete.valorAnteriorPaquete.toFixed(2)}</span>
                                                </div>`;
                                            }
                                            elem += `<div class="precio-venta ms-auto fs-medium">$${paquete.valorTotalPaquete.toFixed(2)}</div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                })
                page++;
                if(data.data.items == 0){
                    elem += `<p class="fs--16 line-height-20 text-center mt-5 mb-4">No se encontraron coincidencias para tu búsqueda</p>`;
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
            $('#listado-paquetes').append(elem);
        }else{
            alert(data.message);
        }
    }
</script>
@endpush