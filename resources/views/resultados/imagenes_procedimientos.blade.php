@extends('template.app-template-veris')
@section('title')
Mi Veris - Resultados
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- modal -->
    <div class="modal fade" id="resultadImagenesProcedimientosModal" tabindex="-1" aria-labelledby="resultadImagenesProcedimientosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3" id="modalBody">
                    <!-- contenido dinamico -->
                </div>
            </div>
        </div>
    </div>
    <!-- modal  ha ocurrido un error -->
    <div class="modal fade" id="haOcurridoUnErrorModal" tabindex="-1" aria-labelledby="resultadoLaboratorioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <h5 class="mb-3">Veris</h5>
                        <p class="mb-3">Ha ocurrido un error inesperado</p>
                        <button type="button" class="btn btn-primary-veris shadow-none w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Resultados') }}</h5>
    </div>
    <!-- filtro -->
    <div class="tab-content bg-transparent px-0 py-0 mb-4" id="pills-tabContent">
        @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
        @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
    </div>
    <section class="pt-0 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-lg-10">
                <div class="row g-4" id="resultadosIP">
                    <!-- items dinamicos -->
                </div>
            </div>
            <!-- Mensaje No tienes ordenes de terapia realizadas -->
            <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesResultadosRealizados">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body px-0">
                        <div class="text-center">
                            <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes resultados </h5>
                            <p class="fs--16 line-height-20 mb-4">En esta sección podrás revisar los resultados de tus exámenes</p>
                            <img src="{{ asset('assets/img/svg/sin_resultados.svg') }}" class="img-fluid" width="300" alt="sin resultados">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->
            <!-- Mensaje No tienes permisos de administrador -->
            <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministradorRealizados">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body px-0">
                        <div class="text-center">
                            <h5 class="fs-24 fw-medium line-height-20 mb-4">No tienes permisos de administrador</h5>
                            <p class="fs--16 line-height-20 mb-4">Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                            <img src="{{ asset('assets/img/svg/sin_resultado_administrador.svg') }}" class="img-fluid" width="300" alt="sin resultados">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->
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
    let familiar = [];
    let identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
 
     // llamada al dom 
     document.addEventListener("DOMContentLoaded", async function () {
        await consultarResultadosPorTipo();
        await consultarGrupoFamiliar();
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        $('body').on('click','.verResultados', async function () {
            let idRelacion = $(this).attr('data-object');
            console.log('idRelacion',idRelacion);
        });
     });
 
    // funciones asyncronas
    // Consultar resultados de laboratorio
    async function consultarResultadosPorTipo(numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}", tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}", desde = '', hasta = '', esAdmin = 'S') {
        const tipoServicio = "IMG,PROC";
        const canalOrigen = _canalOrigen;
        const args = {
            "endpoint": `${api_url}/digitalestest/v1/examenes/resultadosPorTipo?canalOrigen=${canalOrigen}&codigoUsuario={{ Session::get('userData')->numeroIdentificacion }}&numeroIdentificacion=${numeroIdentificacion}&tipoIdentificacion=${tipoIdentificacion}&desde=${desde}&hasta=${hasta}&tipoServicio=${tipoServicio}`
        };
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log(7,args["endpoint"]);
        const data = await call(args);
        console.log('data7', data.data.items);

        let html = $("#resultadosIP");
        html.empty();
        if (data.code == 200){
            let tienePermisos = data.data.tienePermisoAdmin;
            if (numeroIdentificacion == "{{ Session::get('userData')->numeroIdentificacion }}"){
                tienePermisos = true;
            }
            if (data.data.items.length == 0){
                if (tienePermisos == true){
                    $("#mensajeNoTienesResultadosRealizados").removeClass("d-none");
                    $("#mensajeNoTienesPermisosAdministradorRealizados").addClass("d-none");
                } else if (tienePermisos == false){
                    $("#mensajeNoTienesPermisosAdministradorRealizados").removeClass("d-none");
                    $("#mensajeNoTienesResultadosRealizados").addClass("d-none");        
                }
            } else {
                $("#mensajeNoTienesPermisosAdministradorRealizados").addClass("d-none");
                if (tienePermisos == true){
                    $("#mensajeNoTienesResultadosRealizados").addClass("d-none");
                    let items = data.data.items;
                    let elemento = "";
                    items.forEach((resultados) => {
                        elemento += `<div class="col-12 col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body p--2">
                                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1">${capitalizarElemento(resultados.nombreServicio)}</h6>
                                                <p class="fw-medium fs--2 line-height-16 mb-1" id="nombreResultadoLab" style="color: #0055AA !important">${capitalizarElemento(resultados.nombreOrigenResultado)}</p>
                                                <p class="fw-medium fs--2 line-height-16 mb-1" id="ubicacion">${capitalizarElemento(resultados.nombreSucursal)}</p>
                                                <p class="fw-normal fs--2 line-height-16 mb-1">Realizado: <b class="fw-normal" id="fecha">${resultados.dia}</b></p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div class="avatar avatar-sm me-2">
                                                        <img src=${quitarComillas(resultados.iconoServicio)} alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                                    </div>
                                                    <button onclick="detallesResultadosLaboratorio('${resultados.codigoOrdenApoyo}')"
                                                    type="button" class="btn btn-primary-veris shadow-none fs--1 line-height-16 border-0 rounded-1 verResultados">
                                                        Ver resultados
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    });
                    html.append(elemento);
                    
                } 
                else if (tienePermisos == false){
                    // mostrar mensaje de no tienes permisos de administrador
                    $("#mensajeNoTienesPermisosAdministradorRealizados").removeClass("d-none");
                }

            }

        }
        
    }

    // detalles de resultados de laboratorio
    async function detallesResultadosLaboratorio(codigoApoyo){
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";

        args["endpoint"] = api_url + `/digitalestest/v1/examenes/detalleexamen?canalOrigen=${canalOrigen}&codigoOrdenApoyo=${codigoApoyo} `;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('datad', data);

        // insertar datos en el modal
        if (data.code == 200){
            let items = data.data;
            console.log('items', items);
            if (items == null){
                verInforme(codigoApoyo, 'IMG');
            } else {
                console.log('entro2');
                let html = $("#modalBody");
                html.empty();
                
                let elemento = "";
                elemento += `<h1 class="text-center fw-medium fs--20 line-height-24 my-3">Resultados</h1>`;

                items.forEach((resultados, index) => {
                console.log('resultados', resultados);

                elemento += `<div class="my-3">
                                <p class="text-center fs-normal fs--1 line-height-16 my-3">${capitalizarElemento(resultados.nombrePrestacion)}</p>
                                <a href="${quitarComillas(resultados.urlVisorWeb)}" class="btn btn-lg btn-outline-primary-veris w-100 fs--18 line-height-24 px-4 py-3" target="_blank">Ver imagen</a>
                            </div>
                            <div class="border-top">
                                <button class="btn btn-lg btn-primary-veris w-100 fs--18 line-height-24 px-4 py-3 mt-3" target="_blank" onclick="verInforme('${resultados.codigoOrdenApoyos}' , '${resultados.tipo}')">Ver informe</button>
                            </div>
                            `;
                });
                html.append(elemento);
                $('#resultadImagenesProcedimientosModal').modal("show")
            }
        }
    }

    async function verInforme(codigoApoyo, tipo){
        console.log('si entro');    
        let args = {};
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";

        args["endpoint"] = api_url + `/digitalestest/v1/examenes/archivoresultado?canalOrigen=${canalOrigen}&codigoOrdenApoyo=${codigoApoyo} `;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        
        try {
            const blob = await callInformes(args);
            if (blob == null){
                let html = $("#modalBody");
                html.empty();
                
                let elemento = "";
                elemento += `<h1 class="text-center fw-medium fs--20 line-height-24 my-3">Resultados</h1>`;
                elemento += `<div class="my-3">
                                <p class="text-center fs-normal my-3">${capitalizarElemento(data.message)}</p>
                            </div>`;
            
                html.append(elemento);  
            }
            const pdfUrl = URL.createObjectURL(blob);

            window.open(pdfUrl, '_blank');

            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);

        } catch (error) {
            console.error('Error al obtener el PDF:', error);
            // mostrar mensaje de error
            $('#haOcurridoUnErrorModal').modal('show');
        }
    }

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
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
            let checkedAttribute = isFirstElement ? 'checked' : ''; // Establecer 'checked' para el primer elemento
            isFirstElement = false; // Asegurar que solo el primer elemento sea 'checked'

            let elemento = `<div class="position-relative">
                                <input class="form-check-input option-input position-absolute top-50 start-0 ms-3" type="radio" name="listGroupRadios" id="listGroupRadios-${Pacientes.numeroPaciente}" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroIdentificacion}" esAdmin= ${Pacientes.esAdmin} ${checkedAttribute}>
                                <label class="list-group-item p-3 ps-5 bg-white rounded-3" for="listGroupRadios-${Pacientes.numeroPaciente}">
                                    <p class="text-veris fs--16 line-height-20 fw-medium mb-0">${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}</p>
                                    <span class="fs--1 line-height-16 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</span>
                                </label>
                            </div>`;
            divContenedor.append(elemento);
        });
    }
 
    // funciones js 
    // aplicar filtros
    $('#aplicarFiltros').on('click', function() {
        console.log('aplciar filtros');
        const contexto = $(this).data('context');
        console.log('contexto', contexto);
        aplicarFiltrosResultados(contexto, tipoServicio = 'LAB');
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log('texto', texto);
        identificacionSeleccionada = texto.numeroPaciente;
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
    });

    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        limpiarFiltrosResultados(contexto, tipoServicio = 'LAB');
        identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
    });
    
</script>
{{-- <script>
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



</script> --}}


@endpush