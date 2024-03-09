@extends('template.app-template-veris')
@section('title')
Mi Veris - Historia clínica
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Historia clínica') }}</h5>
    </div>
    <!-- filtro -->
    @include('components.barraFiltro', ['context' => 'contextoAplicarFiltrosLaboratorio'])
    @include('components.offCanvaHC', ['context' => 'contextoLimpiarFiltros'])
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-lg-10 d-none">
            </div>
            <div class="row gx-2 gy-3 justify-content-center">
                <div class="col-12 col-lg-6">
                    <p class="fs--1 line-height-16 mb-3" style="color: #3D4E66;">Seleccione especialidad</p>
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
                        <div class="list-group gap-2 w-100" id='especialidadesAtendidas'>
                            <!-- Items de especialidades atendidas -->
                        </div>
                    </div>
                </div>
                <!-- Mensaje El paciente seleccionado no tiene especialidades disponibles. -->
                <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoHayEspecialidades">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                <h5>El paciente seleccionado no tiene <br> especialidades disponibles.</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje No tienes permisos de administrador -->
                <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministrador">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <div class="text-center">
                                <h5>No tienes permisos de administrador</h5>
                                <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                                <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mensaje END -->
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#fechaDesde", {
        locale: _langDate,
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
        locale: _langDate,
        // maxDate: "today"
    });
</script>
<script>
    // variables globales
    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await hcEspecialidadesAtendidas();
        await consultarGrupoFamiliar();
        const elemento = document.getElementById('nombreFiltro');
         elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
    });

    // funciones asincronas
    // Consulta las especialidades atendidas de un paciente.
    async function hcEspecialidadesAtendidas(numeroIdentificacion = '', codigoTipoIdentificacion = '', esAdmin = 'S') {
        console.log('si entra', numeroIdentificacion, codigoTipoIdentificacion, esAdmin);
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        if (numeroIdentificacion != '') {
            codigoUsuario = numeroIdentificacion;
        }
        if (codigoTipoIdentificacion == '') {
            codigoTipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        }
        args["endpoint"] = api_url + `/${api_war}/v1/hc/especialidadesAtendidas?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&tipoIdentificacion=${codigoTipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataES', data);
        let html = $('#especialidadesAtendidas');
        html.empty();

        if (data.code == 200){
            let datas = {};
           
            if (!(data && data.data)) {
                $('#mensajeNoHayEspecialidades').removeClass('d-none');
                
            } else if (data.data.length > 0) {

                $('#mensajeNoTienesPermisosAdministrador').addClass('d-none');
                $('#mensajeNoHayEspecialidades').addClass('d-none');
                
                let element = '';

                data.data.forEach((especialidades) => {
                    console.log('especialidades', especialidades);
                    datas.codigoEspecialidad = especialidades.codigoEspecialidad;
                    datas.tipoIdentificacion  = codigoTipoIdentificacion;
                    datas.numeroIdentificacion = codigoUsuario;
                    datas.esOnline = especialidades.esOnline;

                    let params = btoa(JSON.stringify(datas));
                    console.log('params', params);

                    element += `<a href="/lista-doctores/${params}" class="list-group-item list-group-item-action d-flex gap-2 p-3 border-0 rounded bg-white shadow-sm" aria-current="true">
                                    <img src="${quitarComillas(especialidades.imagen)}" alt="especialidad" width="40" height="40" class="rounded-circle flex-shrink-0" onerror="this.src='{{ asset('assets/img/svg/doctor_light.svg') }}'">
                                    <div class="d-flex gap-2 w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fs--16 line-height-20 mb-0">${capitalizarElemento(especialidades.nombre)}</h6>
                                        </div>
                                    </div>
                                </a> `;
                });
                html.append(element);
            }
        }
    }

    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            familiar = data.data;
            console.log('si hay grupo familiar');
            mostrarListaPacientesFiltro();
        }
        return data;
     }


    // funciones js
    // aplicar filtros
    $('#aplicarFiltros').on('click', function() {
        console.log('aplciar filtros');
        const contexto = $(this).data('context');
        console.log('contexto', contexto);
        aplicarFiltro(contexto );
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log('texto', texto);
        identificacionSeleccionada = texto.numeroPaciente;
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
    });

    async function aplicarFiltro(contexto) {
        console.log('si entra');
        // capturar los datos de data-rel del input radio
        let datos = $('input[name="listGroupRadios"]:checked').attr('data-rel');
        datos = JSON.parse(datos);
        
        let pacienteSeleccionado = datos.numeroIdentificacion;
        let tipoIdentificacion = datos.tipoIdentificacion;
        let esAdmin = datos.esAdmin;
        if (datos.parentesco === 'YO') {
            esAdmin = 'S';
        }

        console.log('paciente',datos.tipoIdentificacion);
        let fechaDesde = $('#fechaDesde').val() || '';
        let fechaHasta = $('#fechaHasta').val() || '';

        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);

        if (contexto === 'contextoAplicarFiltros') {
            await hcEspecialidadesAtendidas(pacienteSeleccionado, tipoIdentificacion, esAdmin);
            $('#filtroTratamientos').offcanvas('hide');
        }
    }

    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        limpiarFiltrosResultados(contexto, tipoServicio = 'LAB');
        identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");
    });


    // limpiar filtros para resultados
    async function limpiarFiltrosResultados(contexto, tipoServicio) {
        if (contexto === 'contextoLimpiarFiltros') {
            $('input[name="listGroupRadios"]').prop('checked', false);
            $('input[name="listGroupRadios"]').first().prop('checked', true);
            
            let pacienteSeleccionado = "{{ Session::get('userData')->numeroIdentificacion }}";
            let  tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
            await hcEspecialidadesAtendidas(pacienteSeleccionado, tipoIdentificacion, 'S');
            $('#filtroTratamientos').offcanvas('hide');
        }
    }

</script>
@endpush