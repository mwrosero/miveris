@extends('template.app-template-veris')
@section('title')
Mi Veris - Mis Convenios
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal eliminar tarjeta -->
    <div class="modal fade" id="modalEliminarConvenio" tabindex="-1" aria-labelledby="modalEliminarConvenioLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Eliminar convenio</h1>
                    <p class="fs--1 fw-normal text-veris" id="mensajeError">¿Estás seguro(a) de eliminar este convenio?</p>
                    <input type="hidden" id="idTarjetaEliminar">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</div>
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center btn-confirmar-eliminar-convenio">Eliminar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Mis Facturas') }}</h5>
    </div>
    <section class="p-3 mb-3 bg-white">
        <div class="row justify-content-center">
            <div class="mx-n4 px-2 mx-lg-n6 px-lg-6 bg-white mb-3 mb-md-4">
                <!-- filtro -->
                @include('components.barraFiltro', ['context' => 'contextoAplicarFiltrosLaboratorio'])
                @include('components.offCanvaHC', ['context' => 'contextoLimpiarFiltros'])
            </div>
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body p-0">
                        <div class="row g-2" id="listado-facturas">
                            {{-- <div class="col-12">
                                <div class="form-check custom-option custom-option-basic shadow-sm d-flex justify-content-between align-items-center p-3">
                                    <img src="{{ asset('assets/img/svg/amex.svg')}}" class="me-3" alt="amex">
                                    <div>
                                        <p class="text-veris-ai fs--16 line-height-20 mb-1 fw-medium">BMI</p>
                                        <span class="fs--1 line-height- mb-0">BMI Igualas médicas-Banco PichBMI Igualas médicas-Banco PichBMI Igualas médicas-Banco Pich</span>
                                    </div>
                                    <div class="btn btn-sm text-danger shadow-none"><i class="bi bi-trash fs-4"></i></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let dataCita = {};
    let idPaciente = '{{ Session::get('userData')->numeroPaciente }}';
    let conveniosSincronizados;
    
    document.addEventListener("DOMContentLoaded", async function () {
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
        await consultarGrupoFamiliar();
        await obtenerFacturas();

        $('body').on('click', '.btn-delete-convenio', async function(){
            $('#idTarjetaEliminar').val($(this).attr('codigoTarjetaSuscrita-rel'));
            var myModal = new bootstrap.Modal(document.getElementById('modalEliminarConvenio'));
            myModal.show();
        })

        $('body').on('click', '.btn-confirmar-eliminar-convenio', async function(){
            alert(0)
        })

        $('body').on('click', '#btnAgregar', function(){
            let data = $('input[name="listGroupRadios"]:checked').data('rel');
            let usuario;
            let tipoIdentificacion = {{ Session::get('userData')->codigoTipoIdentificacion }};
            let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
            let numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";
            
            if(data !== undefined){
                tipoIdentificacion = data.tipoIdentificacion;
                numeroIdentificacion = data.numeroIdentificacion;
                numeroPaciente = data.numeroPaciente;
            }
            usuario = {
                "numeroIdentificacion": numeroIdentificacion,
                "tipoIdentificacion": tipoIdentificacion,
                "numeroPaciente": numeroPaciente
            }
            dataCita.usuario = usuario;
            dataCita.conveniosSincronizados = conveniosSincronizados;
            localStorage.setItem('persona-{{ $tokenCita }}', JSON.stringify(dataCita));
            location.href = '/seleccionar-convenio-agregar/{{ $tokenCita }}';
        })

        $(document).on('click', '.verRide', function(){
            let datos = $(this).data('rel');
            descargarDocumentoRide(datos);
        });

    });

    async function descargarDocumentoRide(datos){
        let args = [];

        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/obtenerRide?numeroTransaccion=${datos.numeroTransaccion}&canalOrigen=${_canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);
            window.open(pdfUrl, '_blank');
            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);
        } catch (error) {
            console.error('Error al obtener el RIDE:', error);
        }
    }

    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
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

    $('#aplicarFiltros').on('click', async function(){
        let contexto = $(this).data('context');
        // const pacienteSeleccionado = $('input[name="listGroupRadios"]:checked').val();
        // Obtener el texto completo de la opción seleccionada data-rel
        const texto = $('input[name="listGroupRadios"]:checked').data('rel');

        obtenerFacturas(texto);
        $('#filtroTratamientos').offcanvas('hide');
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);        

    });

    $('#btnLimpiarFiltros').on('click', function(){
        const contexto = $(this).data('context');
        let numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
        let tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
        obtenerFacturas();
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");

    });

    async function obtenerFacturas(paciente = null) {
        let numeroPaciente = "{{ Session::get('userData')->numeroPaciente }}";

        if(paciente !== null){
            numeroPaciente = paciente.numeroPaciente;
        }

        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/facturacion/comprobantes?numeroPaciente=${numeroPaciente}&codigoEmpresa=1&canalOrigen=${_canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data);
        let elem = ``
        if (data.code == 200) {
            if(data.data.length > 0){
                conveniosSincronizados = data.data;
                $.each(data.data, function(key, value){
                    elem += `<div class="col-12">
                        <div class="card h-100 rounded-3" style="border: 1px solid #E7E9EC;box-shadow: 0px 0px 4px 0px #0000000D;">
                            <div class="card-body p--2">
                                <h6 class="fw-medium fs--16 line-height-20 mb-2 text-capitalize">${value.nombreServicio.toLowerCase()}</h6>
                                <p class="mb-2 fs--1 line-height-16">Número de orden: ${value.numeroOrden}</p>
                                <p class="mb-2 fs--1 line-height-16">Valor: $${value.valorTotal}</p>
                                <p class="mb-4 fw-medium fs--1 line-height-16">${value.fechaEmision} <b class="hora-cita ms-1 fw-medium text-veris-ai">${value.horaEmision}</b></p>
                                <div class="d-flex justify-content-end align-items-center">
                                    {{-- <div class="mt-auto">
                                        <div data-bs-toggle="modal" data-bs-target="#masOpcionesModalCitas" class="btn btn-sm btn-outline-veris-ai fs--1 fw-normal line-height-16 shadow-none verOrdenCard" data-rel="">Ver orden</div>
                                    </div> --}}
                                    <div data-rel='${JSON.stringify(value)}' class="btn btn-sm bg-veris-ai fs--1 ms-2 m-0 line-height-16 text-white verRide">Ver factura</div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                })
            }else{
                elem += `<div class="col-12 p-1 text-center">
                    <img src="{{asset('assets/img/svg/empty-no-facturas.svg')}}" class="w-75 img-fluid" alt="">
                    <h2 class="fs-24 line-height-28">No hay facturas para visualizar</h2>
                </div>`;
            }
            $('#listado-facturas').html(elem)
        }
        return data;
    }

</script>
@endpush