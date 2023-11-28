@extends('template.app-template-veris')
@section('title')
Mi Veris - Buscar doctor
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroSearchDoctors" aria-labelledby="filtroSearchDoctorsLabel">
        <div class="offcanvas-header py-2">
            <h5 class="offcanvas-title" id="filtroSearchDoctorsLabel">Filtros</h5>
            <button type="button" class="btn d-lg-none d-block" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-arrow-left"></i> <b class="fw-normal">Atras</b></button>
        </div>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <form action="">
                <h6 class="fw-light">Selecciona la especialidad</h6>
                
                <div class="list-group gap-2 mb-3" id="listaEspecialidades">
                    
                    
                </div>
                <div class="col-md-12 mb-3">
                    <label for="fechaDesde" class="form-label">{{ __('Elige el rango de fechas') }} *</label>
                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                </div>
                <div class="col-md-12 mb-5">
                    <input type="text" class="form-control bg-neutral" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary-veris w-100 mt-5 mb-3 mx-0" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Aplicar filtros</button>
                    <button class="btn text-primary w-100 mb-3 mx-0" type="button"><i class="bi bi-trash me-2" id="btnLimpiarFiltros" data-context="contextoLimpiarFiltros"></i> Limpiar filtros</button>
                </div>
            </form>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Buscar doctor') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-md-4 my-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0" id="search"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control bg-transparent border-0" name="search" id="search" placeholder="Buscar" aria-describedby="search" />
                </div>
            </div>
        </form>
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <button class="btn btn-sm btn-outline-primary-veris" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroSearchDoctors" aria-controls="filtroSearchDoctors"><i class="bi bi-sliders me-1"></i> Filtros</button>
            </div>
            <div class="col-auto col-lg-10">
                <div class="row gy-3">
                    
                    <!-- Mensaje No hay doctores disponibles -->
                    <div class="col-12 d-flex justify-content-center d-none">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/svg/doctors_search.svg') }}" class="img-fluid mb-3" alt="">
                                    <h5>No hay doctores disponibles</h5>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#fechaDesde", {
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
        // maxDate: "today"
    });

    // variables globales

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function() {
        await consultarEspecialidades();
    });

    // funciones asyncronas
    // consulta de especialidades
    async function consultarEspecialidades() {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = {{ Session::get('userData')->numeroIdentificacion }};
        console.log(codigoUsuario);
        args["endpoint"] = api_url + `/digitales/v1/perfil/especialidades?codigoUsuario=${codigoUsuario}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('especial',data);
        
        if (data.code == 200){
            // agregar especialidades dinamicamente
            let especialidades = data.data;
            let html = $('#listaEspecialidades');

            data.data.forEach(element => {
                let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked data-rel='${ JSON.stringify(element) }'>
                                    <span class="text-veris fw-bold">
                                        ${capitalizarElemento(element.nombreEspecialidad)}
                                        <small class="fs--2 d-block fw-normal text-body-secondary">${element.nombreSucursal}</small>
                                    </span>
                                </label>`;
                html.append(elemento);
            });
        }
        return data;
    }

    // consultar disponibilidad de doctores

    async function obtenerDisponibilidadDoctor(doctores) {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = {{ Session::get('userData')->numeroIdentificacion }};
        let codigoSucursal = doctores.codigoSucursal ? doctores.codigoSucursal : '';
        let codigoEspecialidad = doctores.codigoEspecialidad;
        let fechaDesde = $('#fechaDesde').val();
        let fechaHasta = $('#fechaHasta').val();
        console.log('fechaDesde',fechaDesde);
        console.log('fechaHasta',fechaHasta);
        
        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);
        args["endpoint"] = api_url + `/digitales/v1/perfil/doctores?codigoUsuario=${codigoUsuario}&codigoSucursal=${codigoSucursal}&codigoEspecialidad=${codigoEspecialidad}&fechaDesde=${fechaDesde}&fechaHasta=${fechaHasta}&canalOrigen=${canalOrigen}`;
    
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('disponibilidadzzz',data);
        
    }
    
    // funciones js

    // fecha valida
    function esFechaValida(fecha) {
        const date = new Date(fecha);
        return date instanceof Date && !isNaN(date);
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', async function(){
        
        let especialidadSeleccionada = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log(especialidadSeleccionada);
        let fechaDesde = $('#fechaDesde').val();
        let fechaHasta = $('#fechaHasta').val();
        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);
        await obtenerDisponibilidadDoctor(especialidadSeleccionada);
    });

    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        if (contexto === 'contextoLimpiarFiltros') {
            $('input[name="listGroupRadios"]').prop('checked', false);
            $('input[name="listGroupRadios"]').first().prop('checked', true);
            $('#fechaDesde').val('');
            $('#fechaHasta').val('');
            await obtenerTratamientos();
        }
    });

    // formatear fecha
    function formatearFecha(fecha) {
        const fechaObj = new Date(fecha);
        const dia = ('0' + fechaObj.getDate()).slice(-2);
        const mes = ('0' + (fechaObj.getMonth() + 1)).slice(-2);
        const año = fechaObj.getFullYear();

        return `${dia}/${mes}/${año}`;
    }

</script>
@endpush