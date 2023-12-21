@extends('template.app-template-veris')
@section('title')
Mi Veris - Órdenes externas
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="nuevaOrdenExternaModal" tabindex="-1" aria-labelledby="nuevaOrdenExternaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <p class="fw-bold">María</p>
                    <p class="fs--1 mb-0">{{ __('¿Deseas el servicio a domicilio?') }}</p>
                </div>
                <div class="modal-footer justify-content-center px-3 pt-0 pb-3">
                    <a href="/registrar-orden-externa/2/0923796304/8185/SALUD%20S.A-SALUD%20S.A-PLAN%20ELITE%205D%20COSTA" class="btn btn-primary-veris">{{ __('NO') }}</a>
                    <a href="/registrar-orden-externa/2/0923796304/8185/SALUD%20S.A-SALUD%20S.A-PLAN%20ELITE%205D%20COSTA" class="btn btn-primary-veris">{{ __('SI') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- filtro -->
    

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Órdenes externas') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="text-center my-3">
                <button type="button" class="btn btn-primary-veris px-lg-4" data-bs-toggle="modal" data-bs-target="#nuevaOrdenExternaModal">
                    {{ __('Nueva orden externa') }}
                </button>
            </div>
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltrosLaboratorio'])
                @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
            </div>
            <div class="row gy-3 justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="row g-3" id="ordenesExternas">
                        <!-- items dinamicos -->
                        
                        
                    </div>
                </div>

                <!-- Mensaje El paciente seleccionado no tiene órdenes disponibles. -->
                <div class="col-12 d-flex justify-content-center d-none" id="mensajeOrdenesExternas">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                <h5>El paciente seleccionado no tiene <br> órdenes disponibles.</h5>
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
</script>

<script>

    // variables globales

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        // consultar ordenes externas de laboratorio
        await consultarOrdenesExternasLaboratorio();
        // consultar grupo familiar\
        await consultarGrupoFamiliar();

    });

    // funciones asyncronas

     // consultar ordenes externas de laboratorio
     async function consultarOrdenesExternasLaboratorio(_pacienteSeleccionado = '', _fechaDesde = '', _fechaHasta = '', _esAdmin = '') {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/ordenes/laboratorio?numeroIdentificacion=${codigoUsuario}&tipoIdentificacion=${tipoIdentificacion}&canalOrigen=${canalOrigen}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataOrde', data);
        if (data.code == 200){

            if (data.data.length > 0) {
                document.getElementById('mensajeOrdenesExternas').classList.add('d-none');
                let ordenesExternas = $('#ordenesExternas');
                ordenesExternas.empty();

                data.lsOrdenesLaboratorio.forEach((ordenes) => {

                    let elemento = `<div class="col-12 col-md-6">
                                        <div class="card rounded-3" style="border-left: 0.5rem solid #80BC00;">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-0">${capitalizarElemento(ordenes.descripcionOrden)}</h6>
                                                <p class="fs--1 mb-0"> ${capitalizarElemento(ordenes.nombrePaciente)}</p>
                                                <p class="fs--1 mb-0">Valor: <b class="fw-normal">$${ordenes.total}</b></p>
                                                <p class="text-dark fw-bold fs--1 mb-2">AGO 09, 2021 <b class="fw-bold me-2">10:20 AM</b></p>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span class="text-lime-veris fs--1"><i class="fa-solid fa-circle me-2"></i>Aprobada</span>
                                                    <a href="/citas" class="btn btn-sm btn-primary-veris fs--1">Solicitar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> `;
                    ordenesExternas.append(elemento);

                });


                                    


            } else {
                document.getElementById('mensajeOrdenesExternas').classList.remove('d-none');
            }
        }
        
     }



     // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientesFiltro();

        }
        return data;
    }


    // funciones js

    function mostrarListaPacientesFiltro(){

        let data = familiar;

        let divContenedor = $('.listaPacientesFiltro');
        divContenedor.empty(); // Limpia el contenido actual

        let elementoYo = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="{{ Session::get('userData')->numeroPaciente }}" checked>
                                <span class="text-veris fw-bold">
                                    ${capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}")}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">Yo</small>
                                </span>
                            </label>`;
        divContenedor.append(elementoYo);

        console.log('sss',data);
        data.forEach((Pacientes) => {
            let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} unchecked>
                                <span class="text-veris fw-bold">
                                    ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                                </span>
                            </label>`;
            divContenedor.append(elemento);

        });
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', async function(){
        const contexto = $(this).data('context');
        const pacienteSeleccionado = $('input[name="listGroupRadiosI"]:checked').val();
        let fechaDesde = $('#fechaDesde').val() || '';
        let fechaHasta = $('#fechaHasta').val() || '';
        const esAdmin = $('input[name="listGroupRadiosI"]:checked').attr('esAdmin');

        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);

        if (contexto === 'contextoAplicarFiltros') {
            console.log('exito');   
            await consultarOrdenesExternasLaboratorio(pacienteSeleccionado, fechaDesde, fechaHasta, esAdmin);
        }
    });
    
    // limpiar filtros
    $('#btnLimpiarFiltros').on('click', function(){
        const contexto = $(this).data('context');
        if (contexto === 'contextoLimpiarFiltros') {
            console.log('exitoss');
            const radioButtons = $('input[name="listGroupRadiosI"]');
            radioButtons.prop('checked', false);
            radioButtons.first().prop('checked', true);
            $('#fechaDesde').val('');
            $('#fechaHasta').val('');
            consultarOrdenesExternasLaboratorio();
        }
    });


    function formatearFecha(fecha) {
        // Validar si la entrada está vacía
        if (!fecha) {
            return '';
        }

        const fechaObj = new Date(fecha);
        // Validar si la fecha es válida
        if (isNaN(fechaObj.getTime())) {
            return '';
        }

        const dia = String(fechaObj.getDate()).padStart(2, '0');
        const mes = String(fechaObj.getMonth() + 1).padStart(2, '0');
        const año = fechaObj.getFullYear();

        return `${dia}/${mes}/${año}`;
    }



</script>
@endpush