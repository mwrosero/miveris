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
                    <a  class="btn btn-primary-veris" id="btnNo"
                    >{{ __('NO') }}</a>
                    <a  class="btn btn-primary-veris" id="btnSi"
                    >{{ __('SI') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de error -->

    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3 pb-2">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal" id="mensajeError" >
                </p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
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
                @include('components.offCanvaHC', ['context' => 'contextoLimpiarFiltros'])
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
    let dataConvenio = [];
    let idPaciente = '{{ Session::get('userData')->numeroPaciente }}';


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
     async function consultarOrdenesExternasLaboratorio(_pacienteSeleccionado = '', tipoIdentificacion = '', _fechaDesde = '', _fechaHasta = '', _esAdmin = '') {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        if (_pacienteSeleccionado != '') {
            codigoUsuario = _pacienteSeleccionado;
        }
        
        if (tipoIdentificacion == '') {
            tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        }


        args["endpoint"] = api_url + `/digitalestest/v1/ordenes/laboratorio?numeroIdentificacion=${codigoUsuario}&tipoIdentificacion=${tipoIdentificacion}&canalOrigen=${canalOrigen}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataOrde', data);
        if (data.code == 200){

            if (data.data.lsOrdenesLaboratorio.length > 0) {

                // ocultar mensaje no hay ordenes
                
                $('#mensajeOrdenesExternas').addClass('d-none');

                dataConvenio = data.data;
                document.getElementById('mensajeOrdenesExternas').classList.add('d-none');
                let ordenesExternas = $('#ordenesExternas');
                ordenesExternas.empty();
                let elemento = '';

                data.data.lsOrdenesLaboratorio.forEach((ordenes) => {

                    elemento = `<div class="col-12 col-md-6">
                                    <div class="card rounded-3" style="border-left: 0.5rem solid #80BC00;">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-0">${capitalizarElemento(ordenes.descripcionOrden)}</h6>
                                            <p class="fs--1 mb-0"> ${capitalizarElemento(ordenes.nombrePaciente)}</p>
                                            <p class="fs--1 mb-0">Valor: <b class="fw-normal">$${ordenes.total}</b></p>
                                            <p class="text-dark fw-bold fs--1 mb-2">${convertirFecha(ordenes.fechaItem)}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="text-lime-veris fs--1"><i class="fa-solid fa-circle me-2"></i>Aprobada</span>
                                                ${determinarBotonesPagarSolicitar(ordenes)}
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div> `;
                    

                });

                ordenesExternas.append(elemento);


                                    


            } else {
                dataConvenio = [];
                // limpiar lista de ordenes
                $('#ordenesExternas').empty();
                // mostrar mensaje no hay ordenes

                document.getElementById('mensajeOrdenesExternas').classList.remove('d-none');
            }
        }
        if (data.code != 200) {
            dataConvenio = [];
            // limpiar lista de ordenes
            $('#ordenesExternas').empty();
            // mostrar mensaje error en el modal
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
            
        }

     }

     function convertirFecha(fechaOriginal) {
        try {
            const meses = {
                '01': 'ENE', '02': 'FEB', '03': 'MAR', '04': 'ABR',
                '05': 'MAY', '06': 'JUN', '07': 'JUL', '08': 'AGO',
                '09': 'SEP', '10': 'OCT', '11': 'NOV', '12': 'DIC'
            };

            const [dia, mes, año] = fechaOriginal.split("/");

            if (!dia || !mes || !año || !meses[mes]) {
                throw new Error("Formato de fecha inválido");
            }

            return `${meses[mes]} ${dia}, ${año}`;
        } catch (error) {
            return fechaOriginal;
        }
    }



     // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
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
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="{{ Session::get('userData')->numeroPaciente }}" data-rel='YO'
                                checked>
                                <span class="text-veris fw-bold">
                                    ${capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}")}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">Yo</small>
                                </span>
                            </label>`;
        divContenedor.append(elementoYo);

        console.log('sss',data);
        data.forEach((Pacientes) => {
            let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" data-rel='${JSON.stringify(Pacientes)}' value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} unchecked>
                                <span class="text-veris fw-bold">
                                    
                                    ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                    <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                                </span>
                            </label>`;
            divContenedor.append(elemento);

        });
    }

    // aplicar filtros
    $('#aplicarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        aplicarFiltrosOrdenesExternas(contexto);


        
        // Obtener el texto completo de la opción seleccionada data-rel
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log('texto', texto);

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
    $('#btnLimpiarFiltros').on('click', function(){
        const contexto = $(this).data('context');
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        limpiarFiltrosOrdenesExternas(contexto, numeroIdentificacion, tipoIdentificacion);
        identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");

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

    // btn si o no
    $('#btnSi').on('click', function(){

        let params = {
            "ordenExterna" :  "S" ,
            "online" : "S"
        }
        let ulrParams = btoa(JSON.stringify(params));


        // recireccionar a registrar orden externa
        window.location.href = `/citas-elegir-paciente/${ulrParams}`;

    });

    $('#btnNo').on('click', function(){

        let params = {
            "ordenExterna" :  "S" ,
            "online" : "N"
        }
        let ulrParams = btoa(JSON.stringify(params));

        // window.location.href = `/citas-elegir-paciente/${ulrParams}`;
        window.location.href = `/citas-elegir-paciente/${ulrParams}`;
    });

    // determinar botones pagar o solicitar
    function determinarBotonesPagarSolicitar(data){
        let params = {
            "idPaciente" : idPaciente,
            "numeroOrden" : data.numeroOrden,
            "codigoEmpresa" : data.codigoEmpresa,

        }
        let ulrParams = btoa(JSON.stringify(params));
        let elemento = '';
        if(data.permitePago == 'S'){
            elemento = `<a href="/citas-laboratorio/${ulrParams}" class="btn btn-sm btn-primary-veris fs--1">Pagar</a>`;
            
        }else if(data.permitePago == 'N'){
            elemento = `<a href="/citas-elegir-fecha-doctor/${ulrParams}" class="btn btn-sm btn-primary-veris fs--1">Solicitar</a>`;
        }
        return elemento;

    }



</script>
@endpush