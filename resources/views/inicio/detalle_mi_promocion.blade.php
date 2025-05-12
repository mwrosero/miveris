@extends('template.app-template-veris')
@section('title')
{{-- Detalle de promo comprada --}}
Mi Veris - Citas - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenMods = base64_encode(uniqid());
    $tokenCita = base64_encode(uniqid());
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Promoción') }}</h5>
    </div>
    <section class="p-0 mb-0" style="overflow-x: hidden;">
        {{-- <div class="container"> --}}
            <div class="row g-3 d-flex justify-content-start align-items-start mx-0 mb-3 bg-white">
                <div class="col-12 col-md-4 feature-img-promocion" style="height: 200px;">
                </div>
                <div class="col-12 offset-md-0 col-md-6 mt-3 pb-2 mb-1 px-3 box-detalle-promocion">
                    {{-- <h6 class="title-promocion text-primary-veris mt-md-3 fs--18 line-height-24 fw-medium mb-1 h-auto"></h6>
                    <p class="fs--2 line-height-16 mb-1 text-veris nombrePaciente"></p>
                    <p class="fs--2 line-height-16 mb-1 text-veris fechaValidez d-none"></p> --}}
                </div>
            </div>
            <div class="row g-3 box-llamada-all d-none mx-0">
                <div class="col-12 offset-md-3 col-md-6 text-center mt-3 px-3">
                    <div class="box-llamada d-flex justify-content-center mt-0 align-items-center fs--1 line-height-16 mb-3">
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </section>
    <section class="p-0 px-md-3">
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue d-none" id="tituloPromocionPendiente">{{ __('Pendientes') }}</h5>
        <div class="mb-4 contenedorPromocionPendienteSection">
            <div class="d-flex justify-content-center mb-3 px-3">
                <div class="col-12 col-md-10 col-lg-9">
                    <div class="row g-3" id="contenedorPromocionPendiente">
                    </div>
                </div>
            </div>
        </div>
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue d-none" id="tituloPromocionRealizado">{{ __('Realizados') }}</h5>
        <div class="mb-4 contenedorPromocionRealizadoSection">
            <div class="d-flex justify-content-center mb-3 px-3">
                <div class="col-12 col-md-10 col-lg-9">
                    <div class="row g-3" id="contenedorPromocionRealizado">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    tipoFlujo = "agenda/paquetes";
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    dataCita.tipoFlujo = tipoFlujo;
    if(dataCita.paquete.esCaducada){
        $('#tituloPromocionPendiente').html('Caducado');
    }
    document.addEventListener("DOMContentLoaded", async function () {

        $('.feature-img-promocion').css('background', 'url("'+dataCita.paquete.urlImagen+'") no-repeat center');
        /*$('.title-promocion').html(capitalizarCadaPalabra(dataCita.paquete.nombrePaquete));
        $('.nombrePaciente').html(capitalizarCadaPalabra(dataCita.paquete.nombrePaciente));
        $('.fechaValidez').html(validarCaducidad())*/
        //consultarGrupoFamiliar();
        await obtenerDetallePaquetePromocional();

        $('body').on('click','.btn-detalle', function(){
            let url = '/detalle/item/';
            let data = {
                "secuenciaPaquetePaciente": dataCita.paquete.secuenciaPaquetePaciente,
                "detalle": JSON.parse($(this).attr("data-rel")),
                "detalleItemPaquete": JSON.parse($(this).attr("data-rel"))[0],
                "promocion": JSON.parse($(this).attr("promocion-rel")),
                "nombrePaciente": dataCita.paquete.nombrePaciente,
                "paciente": dataCita.paciente,
                "tipoFlujo": dataCita.tipoFlujo
            };
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(data));
            location.href = url + "{{ $tokenCita }}";
        })

        $('body').on('click','.btn-agendar-item', function(){
            let promocion = JSON.parse($(this).attr("promocion-rel"));
            let detalle = JSON.parse($(this).attr('data-rel'));
            let esTerapiaAgrupada = $(this).attr('esTerapiAgrupada-rel');
            {{-- console.log(promocion);
            console.log(detalle);
            return; --}}
            let cantidadMaximaAgenda = promocion.cantidadMaximaAgenda
            if(esTerapiaAgrupada !== undefined && esTerapiaAgrupada !== null && esTerapiaAgrupada == "true"){
                esTerapiaAgrupada = true;
            }else{
                esTerapiaAgrupada = false;
            }

            let url = '/seleccionar-datos-cita/';
            if(promocion.esOnline == "S"){
                url = '/citas-elegir-fecha-doctor/';
            }

            dataCita.secuenciaPaquetePaciente = dataCita.paquete.secuenciaPaquetePaciente;
            dataCita.nombrePaciente = dataCita.paquete.nombrePaciente;
            dataCita.paciente = dataCita.paciente;
            dataCita.promocion = promocion;
            dataCita.detalle = detalle;
            dataCita.detalleItemPaquete = detalle[0];
            dataCita.origen = "paquetes";
            dataCita.online = promocion.esOnline;
            dataCita.especialidad = {
                codigoEspecialidad: promocion.codigoEspecialidad,
                codigoPrestacion: promocion.codigoPrestacion,
                codigoServicio: promocion.codigoServicio,
                //codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                esOnline: promocion.esOnline,
                nombre: promocion.nombreEspecialidad
            }
            dataCita.convenio = {
                "permitePago": "S",
                "permiteReserva": "S",
                "idCliente": null,
                "codigoConvenio": null,
                "secuenciaAfiliado" : null,
            };

            dataCita.tipoFlujo = "agenda/paquetes";
            tipoFlujo = dataCita.tipoFlujo;

            if(esTerapiaAgrupada){
                detalle.forEach(item => {
                    item.lineaDetalleTratamiento = item.itemPaquete?.lineaDetalle || null;
                    item.nombreServicio = item.nombreDetalle;
                });
                {{-- console.log(detalle);return; --}}

                dataCita.tipoFlujo = "agenda/tratamiento/terapia_agrupada";
                dataCita.detallesServicios = detalle;
                {{-- dataCita.secuenciaAtencion = secuenciaAtencion.secuenciaAtenciones; --}}
                dataCita.datosTratamiento = promocion;
                dataCita.cantidadMaximaAgenda = cantidadMaximaAgenda;
                localStorage.setItem('cita-{{ $tokenMods }}', JSON.stringify(dataCita));
                location = "/agendamiento-multiple/{{ $tokenMods }}";;
                return;
            }

            //return;

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            window.location.href = `${url}{{ $tokenCita }}`;
        })
    })

    function validarCaducidad(){
        let elem = ``;
        if(dataCita.paquete.esCaducada){
            elem += `<span class="text-danger">${dataCita.paquete.fechaCaducidad} | Caducado</span>`;
        }else{
            elem += `Válida hasta: <span class="text-primary-veris">${dataCita.paquete.fechaCaducidad}</span>`;
        }
        return elem;
    }

    async function obtenerDetallePaquetePromocional(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=1&secuenciaPaquetePaciente=${dataCita.paquete.secuenciaPaquetePaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data);
        if (data.code == 200){
            if(data.data.pendientes.length > 0){
                $('.box-llamada').html(`<i class="fa-solid fa-circle-info text-primary-veris line-height-16 fs--16 me-2"></i><div>Para agendar tus servicios llámanos al <span>${data.data.numeroContactCenter}</span>.</div><a href="tel:+593${data.data.numeroContactCenter}" class="btn btn-sm btn-primary-veris fw-medium fs--16 line-height-16 px-3 py-2 shadow-none ms-2 d-block d-md-none" style="border-radius:8px;">Llamar</a>`);
                $('.fechaValidez, .box-llamada-all').removeClass('d-none');
                $('.box-detalle-promocion').html(`<h6 class="title-promocion text-primary-veris mt-md-3 fs--18 line-height-24 fw-medium mb-1 h-auto">${capitalizarCadaPalabra(dataCita.paquete.nombrePaquete)}</h6>
                    <p class="fs--2 line-height-16 mb-1 text-veris nombrePaciente">${capitalizarCadaPalabra(dataCita.paquete.nombrePaciente)}</p>
                    <p class="fs--2 line-height-16 mb-1 text-veris fechaValidez">${validarCaducidad()}</p>`);
                let elemPendiente = ``;
                $('#tituloPromocionPendiente').removeClass('d-none');
                $.each(data.data.pendientes, function(key, detalles){
                    elemPendiente += `<div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body p--2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                </div>
                                <p class="fs--1">Realizadas: <span style="color: #00C853">${detalles.cantidad}</span></p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="avatar-sm me-2">
                                        <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                    </div>
                                    <div>
                                        ${ drawBtnCardItem(detalles) }
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>`; 
                })
                $('#contenedorPromocionPendiente').html(elemPendiente);
            }else{
                $('.contenedorPromocionPendienteSection').remove();
                $('.box-detalle-promocion').html(`<h6 class="title-promocion text-primary-veris mt-md-3 fs--18 line-height-24 fw-medium mb-1 h-auto">${capitalizarCadaPalabra(dataCita.paquete.nombrePaquete)}</h6>
                    <div class="d-flex justify-content-between align-items-top">
                        <p class="fs--2 line-height-16 mb-1 text-veris nombrePaciente">${capitalizarCadaPalabra(dataCita.paquete.nombrePaciente)}</p>
                        <img class="ms-2" src="{{ asset('assets/img/svg/golden.svg') }}" />
                    </div>`);
            }
            if(data.data.realizados.length > 0){
                let elemRealizado = ``;
                $('#tituloPromocionRealizado').removeClass('d-none');
                $.each(data.data.realizados, async function(key, detalles){
                    // console.log(detalles)
                    let estadoCard = obtenerEstadoCard(detalles);
                    elemRealizado += `<div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body p--2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line">${capitalizarElemento(detalles.nombreServicio)}</h6>
                                    ${estadoCard}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="avatar-sm me-2">
                                        <img src="${quitarComillas(detalles.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                    </div>
                                    <div>
                                        <div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none btn-detalle" promocion-rel='${JSON.stringify(detalles)}' data-rel='${JSON.stringify(detalles.detalles)}'>Ver detalle</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>`; 
                })
                $('#contenedorPromocionRealizado').html(elemRealizado);
            }
        }else{
            alert(data.message);
        }
    }

    function obtenerEstadoCard(datos){
        let elem = ``;
        if(datos.detalles.length == 1){
            elem += `<div class="ms-auto fs--2"><i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">${datos.detalles[0].estado}</span></div>`
        }else{
            let estados = [];
            $.each(datos.detalles, function(key, value){
                estados.push(value.estado);
            })
            const uniqueEstados = [...new Set(estados)];
            if(uniqueEstados.length == 1){
                elem += `<div class="ms-auto fs--2"><i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">${uniqueEstados[0]}</span></div>`
            }
        }
        return elem;
    }

    function drawBtnCardItem(detalles){
        console.log(detalles);
        let tipoAgenda = detalles.tipoAgenda;
        // let tiposAgendaPermitida = ["CONSULTA_MEDICA","TERAPIA_FISICA","IMAGENES","PROCEDIMIENTOS"];
        let tiposAgendaPermitida = ["CONSULTA_MEDICA","TERAPIA_FISICA","TERAPIA_FISICA_AGRUPADA"];
        let titleBtn = `Ver detalle`;
        let tieneItemsSinAgendar = verificarItemsSinAgendar(detalles.detalles);
        let btnEnviaAgendarClass = `btn-detalle`;
        if(tiposAgendaPermitida.includes(tipoAgenda) && detalles.esAgendable && tieneItemsSinAgendar){
            titleBtn = `Agendar`;
            if((detalles.detalles.length == 1 && detalles.preparacionPrevia == null) || tipoAgenda == "TERAPIA_FISICA_AGRUPADA"){
                btnEnviaAgendarClass = `btn-agendar-item`;
            }
        }
        let esTerapiaAgrupada = false
        if(tipoAgenda == "TERAPIA_FISICA_AGRUPADA"){
            esTerapiaAgrupada = true;
        }
        return `<div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none ${btnEnviaAgendarClass}" esTerapiAgrupada-rel='${esTerapiaAgrupada}' promocion-rel='${JSON.stringify(detalles)}' data-rel='${JSON.stringify(detalles.detalles)}'>
                ${titleBtn}
            </div>`;
    }

    function verificarItemsSinAgendar(items){
        let tienItems = false;
        $.each(items, function(key, value){
            if(value.detalleReserva == null){
                tieneItems = true;
            }
        })
        return tieneItems;
    }
</script>
@endpush