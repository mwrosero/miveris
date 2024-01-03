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
                    <!-- especialidades dinamicas -->
                </div>
                <div class="col-md-12 mb-3">
                    <label for="fechaDesde" class="form-label">{{ __('Elige el rango de fechas') }} *</label>
                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                </div>
                <div class="col-md-12 mb-5">
                    <input type="text" class="form-control bg-neutral" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary-veris w-100 mt-5 mb-3 mx-0 py-3" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Aplicar filtros</button>
                    <button class="btn text-primary w-100 mb-3 mx-0" type="button" id="btnLimpiarFiltros" data-context="contextoLimpiarFiltros"><i class="bi bi-trash me-2" ></i> Limpiar filtros</button>
                </div>
            </form>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Buscar doctore') }}</h5>
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
                <div class="row gy-3" id="doctoresFavoritos">
                    <!-- Mensaje No hay doctores disponibles -->
                    <div class="col-12 d-flex justify-content-center d-none" id="noHayDoctores">
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
    let dataEspecialidades = [];

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function() {
        await consultarEspecialidades();
        await obtenerDisponibilidadDoctor(dataEspecialidades[0]);
    });

    // funciones asyncronas
    // consulta de especialidades
    async function consultarEspecialidades() {
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        let endpoint = api_url + `/digitalestest/v1/perfil/especialidades?codigoUsuario=${codigoUsuario}`;
        console.log(endpoint);
        const data = await call({ endpoint, method: "GET", showLoader: false });
        dataEspecialidades = data.data;
        
        if (data.code == 200){

            if (data.data.length == 0){
                $('#noHayDoctores').removeClass('d-none');
            }
            console.log('especialidades', data.data);
            let html = $('#listaEspecialidades');
            html.empty();
            let firstItem = true;
            let elemento = '';
            dataEspecialidades.forEach(element => {
                elemento += `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" value="${element.nombreEspecialidad}" ${firstItem ? 'checked' : ''} data-rel='${ JSON.stringify(element) }'>
                                    <span class="text-veris fw-bold">
                                        ${capitalizarElemento(element.nombreEspecialidad)}
                                        <small class="fs--2 d-block fw-normal text-body-secondary">${element.nombreSucursal}</small>
                                    </span>
                                </label>`;
                
                firstItem = false;
            });
            html.append(elemento);
        }
        return data;
    }


    // consultar disponibilidad de doctores

    async function obtenerDisponibilidadDoctor(doctores) {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        let codigoSucursal = doctores.codigoSucursal ? doctores.codigoSucursal : '';
        let codigoEspecialidad = doctores.codigoEspecialidad;
        let fechaDesde = $('#fechaDesde').val();
        let fechaHasta = $('#fechaHasta').val();
        
        fechaDesde = esFechaValida(fechaDesde) ? formatearFecha(fechaDesde) : '';
        fechaHasta = esFechaValida(fechaHasta) ? formatearFecha(fechaHasta) : '';

        args["endpoint"] = api_url + `/digitalestest/v1/perfil/doctores?codigoUsuario=${codigoUsuario}&codigoSucursal=${codigoSucursal}&codigoEspecialidad=${codigoEspecialidad}&fechaDesde=${fechaDesde}&fechaHasta=${fechaHasta}&canalOrigen=${canalOrigen}`;
    
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if (data.code == 200){
            if (data.data.length == 0){
                $('#noHayDoctores').removeClass('d-none');
            } else{
                let doctores = data.data;
                let html = $('#doctoresFavoritos');
                html.empty();
                let elemento = '';
                data.data.forEach(element => {
                    elemento = `<div class="col-12 col-md-6">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row gx-2 align-items-center">
                                                    <div class="col-3">
                                                        <img src=${element.imagen} class="card-img-top" alt="centro medico" onerror="this.src='https://i.pinimg.com/474x/93/b5/f9/93b5f9913d2e4316cd6e541c67b9aed0.jpg'; this.style.height='50px'; this.style.width='50px';">
                                                    </div>
                                                    <div class="col-7">
                                                        <h6 class="fw-bold mb-0">Dr(a) ${capitalizarElemento(element.primerNombre)} ${capitalizarElemento(element.segundoNombre)} ${capitalizarElemento(element.primerApellido)} ${capitalizarElemento(element.segundoApellido)}</h6>
                                                        <p class="text-primary-veris fw-bold fs--2 mb-0">${capitalizarElemento(element.nombreSucursal)}</p>
                                                        <p class="fs--2 mb-0">${capitalizarElemento(element.nombreEspecialidad)}</p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <a href="#!" class="btn rounded-pill btn-icon btn-primary-veris" onclick="agregarDoctorFavorito(${element})"
                                                        ><i class="bi bi-plus-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    
                });
                html.append(elemento);
            }
        }
        
    }

    // agregar doctores favoritos 
    async function agregarDoctorFavorito(doctor) {

        let args = [];
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/doctores/favoritos/agregar?codigoUsuario=${codigoUsuario}`;
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            "codigoEspecialidad": doctor.codigoEspecialidad,
            "codigoProfesional": doctor.codigoProfesional,
            "nombreDoctor": doctor.primerNombre + ' ' + doctor.segundoNombre + ' ' + doctor.primerApellido + ' ' + doctor.segundoApellido,
            "nombreEspecialidad": doctor.nombreEspecialidad,
            "secuenciaPersonal": doctor.secuenciaPersonal,
            "imagen": doctor.imagen,
            "codigoSucursal": doctor.codigoSucursal,
            "codigoEmpresa": doctor.codigoEmpresa,
            "esOnline": doctor.esOnline,
        });

        console.log('args', args["data"]);

        const data = await call(args);
        console.log('data', data);
        if (data.code == 200) {
            console.log('doctor agregado');
        }

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
        console.log('limpiar filtros');
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
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