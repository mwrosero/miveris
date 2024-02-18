@extends('template.app-template-veris')
@section('title')
Mi Veris - Buscar doctor
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal mensaje doctor agregado -->
    <div class="modal fade" id="mensajeDoctorAgregadoModal" tabindex="-1" aria-labelledby="mensajeDoctorAgregadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/check-circle.svg')}}" alt="">
                    </div>
                    <div class="text-center">
                        <p class="fs--16 line-height-20 fw-medium mb-0">Doctor agregado a tus favoritos</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 linr-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- filtro -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroSearchDoctors" aria-labelledby="filtroSearchDoctorsLabel">
        <div class="offcanvas-header flex-column align-items-start p-0">
            <div class="w-100 px-4 py-2 d-lg-none d-block" style="background: #F3F4F5;">
                <button type="button" class="btn p-0 d-flex align-items-center" data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{asset('assets/img/svg/arrow-left-filtro-body.svg')}}" class="me-1" alt="atras"><b class="fw-medium fs-- text-veris">Atrás</b></button>
            </div>
            <h5 class="offcanvas-title fs--20 line-height-24 w-100 px-4 py-3" id="filtroTratamientosLabel">Filtros</h5>
        </div>
        <div class="offcanvas-body py-2" style="background: rgba(249, 250, 251, 1);">
            <form action="">
                <h6 class="fs--16 line-height-20 fw-light">Selecciona la especialidad</h6>
                <div class="list-group gap-3 mb-3 listaPacientesFiltro" id="listaEspecialidades">
                    <!-- especialidades dinamicas -->
                </div>
                <div class="col-md-12 mb-3">
                    <label for="fechaDesde" class="fw-light fs--16 line-height-20 mb-3">{{ __('Elige el rango de fechas') }}</label>
                    <input type="text" class="form-control fs--1 p-3 bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                </div>
                <div class="col-md-12 mb-5">
                    <input type="text" class="form-control fs--1 p-3 bg-neutral" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary-veris w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Aplicar filtros</button>
                    <button class="btn text-primary w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3" type="button" id="btnLimpiarFiltros" data-context="contextoLimpiarFiltros"><img src="{{asset('assets/img/svg/delete-blue.svg')}}" class="me-2" alt="linmpiar filtro"> Limpiar filtros</button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Buscar doctor') }}</h5>
    </div>
    <section class="p-3 pt-0 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-12 col-md-6 my-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-especialidad"></span>
                    <input type="search" class="form-control bg-transparent fs--16 border-0 p-3 ps-0" name="search" id="searchDoctor" placeholder="Buscar" aria-describedby="search" />
                </div>
            </div>
        </form>
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <button class="btn btn-sm btn-outline-primary-veris fw-normal" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroSearchDoctors" aria-controls="filtroSearchDoctors"><i class="bi bi-sliders me-1"></i> Filtros</button>
            </div>
            <div class="col-12 col-lg-9">
                <div class="row g-4" id="doctoresFavoritos"></div>
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
    </section>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let fechaDesdePicker = flatpickr("#fechaDesde", {
        maxDate: new Date().fp_incr(0),
        onChange: function(selectedDates, dateStr, instance) {
            if (!document.getElementById('fechaHasta').disabled) {
                fechaHastaPicker.set('minDate', dateStr);
            } else {
                document.getElementById('fechaHasta').disabled = false;
                fechaHastaPicker = flatpickr("#fechaHasta", {
                    minDate: dateStr,
                    maxDate: new Date().fp_incr(0)
                });
            }
        }
    });

    let fechaHastaPicker = flatpickr("#fechaHasta", {
        maxDate: new Date().fp_incr(0),
        minDate: new Date(), 
        onChange: function(selectedDates, dateStr, instance) {
        }
    });

    document.getElementById('fechaHasta').disabled = true;
    // quitar el readonly

    $("#fechaDesde").removeAttr("readonly");
    $("#fechaHasta").removeAttr("readonly");
    // no permitir autocomplete
    $("#fechaDesde").attr("autocomplete", "off");
    $("#fechaHasta").attr("autocomplete", "off");



</script>

<script>
    

    // variables globales
    let dataEspecialidades = [];
    let dataDoctores = [];

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function() {
        await consultarEspecialidades();
        await obtenerDisponibilidadDoctor();
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
        if (data.code == 200) {
            if (data.data.length == 0) {
                $('#noHayDoctores').removeClass('d-none');
            }
            console.log('especialidades', data.data);
            let html = $('#listaEspecialidades');
            html.empty();
            let idUnico = 1; // Inicializar el contador de IDs únicos
            let isFirstElement = true; // Variable para identificar el primer elemento
            let elemento = '';
            dataEspecialidades.forEach(element => {
                let checkedAttribute = isFirstElement ? 'checked' : ''; // Establecer 'checked' para el primer elemento
                isFirstElement = false; // Asegurar que solo el primer elemento sea 'checked'

                let idElemento = `listGroupRadios-${idUnico++}`; // Generar el ID único para este elemento
                elemento += `<div class="position-relative">
                                <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="${idElemento}" data-rel='${JSON.stringify(element)}' value="${element.nombreEspecialidad}" ${checkedAttribute} />
                                <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="${idElemento}">
                                    <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(element.nombreEspecialidad)}</p>
                                    <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(element.nombreSucursal)}</span>
                                </label>
                            </div>`;
            });
            html.append(elemento);
        }
        return data;
    }


    // consultar disponibilidad de doctores

    async function obtenerDisponibilidadDoctor(doctores) {
        console.log('filtrott', doctores);
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        let codigoSucursal = '';
        let codigoEspecialidad = '';
        let fechaDesde = '';
        let fechaHasta = '';

        if (doctores == undefined){
            doctores = {
                codigoEspecialidad: '',
                codigoSucursal: '',
            }
        } else{
            
            codigoSucursal = doctores.codigoSucursal ? doctores.codigoSucursal : '';
            codigoEspecialidad = doctores.codigoEspecialidad;
            fechaDesde = $('#fechaDesde').val();
            fechaHasta = $('#fechaHasta').val();
        }
        
        fechaDesde = esFechaValida(fechaDesde) ? formatearFecha(fechaDesde) : '';
        fechaHasta = esFechaValida(fechaHasta) ? formatearFecha(fechaHasta) : '';

        args["endpoint"] = api_url + `/digitalestest/v1/perfil/doctores?codigoUsuario=${codigoUsuario}&codigoSucursal=${codigoSucursal}&codigoEspecialidad=${codigoEspecialidad}&fechaDesde=${fechaDesde}&fechaHasta=${fechaHasta}&canalOrigen=${canalOrigen}`;
    
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('data.data.length', data.data.length);
        if (data.code == 200){
            if (data.data.length == 0){
                console.log('no hay doctores'); 
                // limpiar doctores

                $('#doctoresFavoritos').empty();
                $('#noHayDoctores').removeClass('d-none');
            } else{
                let doctores = data.data;
                dataDoctores = data.data;
                let html = $('#doctoresFavoritos');
                html.empty();
                let elemento = '';
                data.data.forEach(element => {
                    elemento += `<div class="col-12 col-md-6 box-doctor-${element.codigoProfesional}">
                                        <div class="card card-border">
                                            <div class="card-body p--2">
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-auto">
                                                        <img src=${element.imagen} class="card-img-top" alt="centro medico" onerror="this.src='{{ asset('assets/img/svg/avatar_doctor.svg') }}'; this.style.height='78px'; this.style.width='64px';">
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="mx-2">
                                                            <h6 class="fs--16 line-height-20 fw-medium mb-1 truncate-text-two">Dr(a) ${capitalizarElemento(element.primerNombre)} ${capitalizarElemento(element.segundoNombre)} ${capitalizarElemento(element.primerApellido)} ${capitalizarElemento(element.segundoApellido)}</h6>
                                                            <p class="text-primary-veris fw-medium fs--1 line-height-16 mb-1">${capitalizarElemento(element.nombreSucursal)}</p>
                                                            <p class="fs--1 line-height-16 mb-0">${capitalizarElemento(element.nombreEspecialidad)}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <button type="button" class="btn btn-icon shadow-none p-0" data-rel='${ JSON.stringify(element)}'><img src="{{asset('assets/img/svg/plus-blue.svg')}}" alt="plus"></button>
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
        console.log('doctor', doctor);

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
            $('.box-doctor-'+doctor.codigoProfesional).remove();
            $('#mensajeDoctorAgregadoModal').modal('show');
        }

    }


    

    //agregar doctor favorito boton +
    $(document).on('click', '.btn-icon', async function() {
        let doctor = $(this).data('rel');
        console.log('doctor', doctor);
        await agregarDoctorFavorito(doctor);
    });


    
    // funciones js

    // fecha valida
    function esFechaValida(fecha) {
        const date = new Date(fecha);
        return date instanceof Date && !isNaN(date);
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', async function(){
        
        let especialidadSeleccionada = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log('filtros',especialidadSeleccionada);
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

    // buscar doctor por filtro 
    $("form").on("submit", function(e) {
        e.preventDefault();
        let search = $("#searchDoctor").val().toLowerCase(); // Obtener el valor y convertirlo a minúsculas
        console.log('search', dataDoctores);

        // Filtrar los doctores basados en el criterio de búsqueda
        let doctoresFiltrados = dataDoctores.filter(function(doctor) {
            
            // permitir valores nulos
            return determinarValorNull(doctor.primerNombre).toLowerCase().includes(search) || 
            determinarValorNull(doctor.segundoNombre).toLowerCase().includes(search) ||
            determinarValorNull(doctor.primerApellido).toLowerCase().includes(search) ||
            determinarValorNull(doctor.segundoApellido).toLowerCase().includes(search);
        });

        // Construir el HTML basado en los doctores filtrados
        let html = $('#doctoresFavoritos');
        html.empty(); // Limpiar los doctores actuales

        let elemento = '';
        console.log('doctoresFiltrados', doctoresFiltrados);
        if (doctoresFiltrados.length == 0){
            $('#noHayDoctores').removeClass('d-none');
        } else{
            $('#noHayDoctores').addClass('d-none');
            
            doctoresFiltrados.forEach(element => { // Usar `doctoresFiltrados` en lugar de `dataDoctores`
                elemento += `<div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row gx-2 align-items-center">
                                            <div class="col-3">
                                                <img src=${element.imagen} class="card-img-top" alt="centro medico" onerror="this.src='{{ asset('assets/img/svg/avatar_doctor.svg') }}'; this.style.height='50px'; this.style.width='50px';">
                                            </div>
                                            <div class="col-7">
                                                <h6 class="fw-medium mb-0">Dr(a) ${capitalizarElemento(element.primerNombre)} ${capitalizarElemento(element.segundoNombre)} ${capitalizarElemento(element.primerApellido)} ${capitalizarElemento(element.segundoApellido)}</h6>
                                                <p class="text-primary-veris fw-medium fs--2 mb-0">${capitalizarElemento(element.nombreSucursal)}</p>
                                                <p class="fs--2 mb-0">${capitalizarElemento(element.nombreEspecialidad)}</p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <div class="btn rounded-pill btn-icon btn-primary-veris" data-rel='${ JSON.stringify(element) }'>
                                                    <i class="bi bi-plus-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            });
            html.append(elemento); // Actualizar el HTML del contenedor de doctores
        }
    });



</script>
@endpush