@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
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
    
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Detalle') }}</h5>
    </div>
    <section class="p-0 px-md-3"></section>

    <section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-3">
                    <div class="row g-3 justify-content-center" id="listado-detalles"></div>
                    {{-- <div class="card h-100">
                        <div class="card-body p--2 d-flex justify-content-between align-items-center">
                            <div class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 text-one-line m-0">Urea</div>
                            <div class="label-status-detalle fs--2 line-height-16 m-0">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                Disponible
                            </div>
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
    let tiposAgendaPermitida = ["CONSULTA_MEDICA","TERAPIA_FISICA","IMAGENES","PROCEDIMIENTOS"];
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    console.log(dataCita);
    document.addEventListener("DOMContentLoaded", async function () {
        await drawDetalles();

        $('body').on('click', '.btn-informacion', async function(){
            dataCita.origen = "paquetes";
            dataCita.online = dataCita.promocion.esOnline;
            dataCita.especialidad = {
                codigoEspecialidad: dataCita.promocion.codigoEspecialidad,
                codigoPrestacion: dataCita.promocion.codigoPrestacion,
                codigoServicio: dataCita.promocion.codigoServicio,
                //codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                esOnline: dataCita.promocion.esOnline,
                nombre: dataCita.promocion.nombreEspecialidad
            }
            dataCita.convenio = {
                "permitePago": "S",
                "permiteReserva": "S",
                "idCliente": null,
                "codigoConvenio": null,
                "secuenciaAfiliado" : null,
            };
            let url = '/detalle/item/preparacion-previa/';
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        })

        $('body').on('click', '.btn-agendar', async function(){
            let detalle = JSON.parse($(this).attr('data-rel'));

            dataCita.detalleItemPaquete = detalle;
            dataCita.origen = "paquetes";
            dataCita.online = dataCita.promocion.esOnline;
            dataCita.especialidad = {
                codigoEspecialidad: dataCita.promocion.codigoEspecialidad,
                codigoPrestacion: dataCita.promocion.codigoPrestacion,
                codigoServicio: dataCita.promocion.codigoServicio,
                //codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                esOnline: dataCita.promocion.esOnline,
                nombre: dataCita.promocion.nombreEspecialidad
            }
            dataCita.convenio = {
                "permitePago": "S",
                "permiteReserva": "S",
                "idCliente": null,
                "codigoConvenio": null,
                "secuenciaAfiliado" : null,
            };

            // console.log(dataCita);return;

            let url = '/seleccionar-datos-cita/';
            if(dataCita.promocion.esOnline == "S"){
                url = '/citas-elegir-fecha-doctor/';
            }

            // if(dataCita.promocion.preparacionPrevia != null){
            //     url = '/detalle/item/preparacion-previa/';
            // }

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        })

        $('body').on('click', '.btn-CambiarFechaCita', async function(){
            let detalle = JSON.parse($(this).attr('data-rel'));

            let dataReserva = {
                "detalleItemPaquete": detalle,
                "promocion": dataCita.promocion,
                "online": dataCita.promocion.esOnline,
                "especialidad": {
                    codigoEspecialidad: dataCita.promocion.codigoEspecialidad,
                    codigoPrestacion: dataCita.promocion.codigoPrestacion,
                    codigoServicio: dataCita.promocion.codigoServicio,
                    //codigoTipoAtencion: datosServicio.codigoTipoAtencion,
                    esOnline: dataCita.promocion.esOnline,
                    nombre: dataCita.promocion.nombreEspecialidad
                },
                "convenio": {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                    "secuenciaAfiliado" : null,
                },
                "paciente": {
                    "numeroIdentificacion": dataCita.paciente.numeroIdentificacion,
                    "tipoIdentificacion": dataCita.paciente.tipoIdentificacion,
                    "nombrePaciente": dataCita.nombrePaciente,
                    "numeroPaciente": dataCita.paciente.numeroPaciente
                },
                "central": {
                    "codigoSucursal": dataCita.detalleItemPaquete.detalleReserva.codigoSucursal,
                    "nombreSucursal": dataCita.detalleItemPaquete.detalleReserva.nombreSucursal
                },
                "ciudad": {
                    "codigoPais": dataCita.detalleItemPaquete.detalleReserva.idCiudad,
                    "codigoProvincia": dataCita.detalleItemPaquete.detalleReserva.idProvincia,
                    "codigoCiudad": dataCita.detalleItemPaquete.detalleReserva.idPais
                },
                "reservaEdit": {
                    "estaPagada": "S",
                    "numeroOrden": detalle.numeroOrden,
                    "lineaDetalleOrden": detalle.lineaDetalleOrden,
                    "codigoEmpresaOrden": detalle.codigoEmpresaOrden,
                    "idOrdenAgendable": '',
                    "idCita": detalle.detalleReserva.codigoReserva,
                    "esSesionOdonto": "N"
                },
                "origen": "paquetes"
            }

            // console.log(dataReserva);return;
            
            let url = '/seleccionar-datos-cita/';
            if(dataCita.promocion.esOnline == "S"){
                url = '/citas-elegir-fecha-doctor/';
            }

            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataReserva));
            showLoader();
            window.location.href = `${url}{{ $tokenCita }}`;
        })
    })

    async function drawDetalles(){
        let showResultados = false;
        let elem = ``;
        let tipoAgenda = dataCita.promocion.tipoAgenda;
        $.each(dataCita.detalle, function(key, value){
            let estado = ``;
            if(value.estado == "Atendida"){
                showResultados = true;
            }
            //if(value.estado == "Atendida" && dataCita.promocion.tipoServicio != "LABORATORIO"){
            console.log(value.estado)
            if((value.estado == "Atendida" || value.estado == "Agendada") && tiposAgendaPermitida.includes(tipoAgenda)){
                let btnReagendar = ``;
                if(value.estado == "Agendada"){
                    btnReagendar += `<div>
                        ${ drawBtnCardItem(value) }
                    </div>`
                }
                elem += `<div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body p--2">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="text-primary-veris fw-medium fs--1 line-height-16 mb-1">${capitalizarElemento(value.nombreDetalle)}</h6>
                                <span class="text-warning-veris fs--2 line-height-16 mb-1 text-end" style="min-width: 90px;">
                                    <i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">${value.estado}</span>
                                </span>
                            </div>
                            <h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.nombreSucursal)}</h6>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${value.detalleReserva.horaReserva}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(value.detalleReserva.nombreMedicoReserva)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(dataCita.nombrePaciente)}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-sm me-2">
                                    <img src="${quitarComillas(dataCita.promocion.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                </div>
                                ${btnReagendar}
                            </div>
                        </div>
                    </div>
                </div>`;
            }else{
                if(value.estado == "Disponible"){
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-regular fa-calendar-check me-2"></i>
                            Disponible
                        </div>`;
                }else if(value.estado == "Caducado"){
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <img src="{{asset('assets/img/svg/fa-diamond-exclamation.svg')}}" />
                            <span style="color: #D84315;">Caducado</span>
                        </div>`;
                }else{
                    estado += `<div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-solid fa-check me-2 text-success"></i>
                            <span class="text-success">Atendida</span>
                        </div>`;
                }
                elem += `<div class="col-12 mt-3">
                            <div class="card h-100" style="box-shadow: 0px 4px 8px 0px #0000001A;">
                                <div class="card-body p--2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="text-primary-veris fw-medium fs--1 line-height-16 mb-1 m-0">
                                            ${value.nombreDetalle}
                                        </div>
                                        ${estado}
                                    </div>`;
                                if(tiposAgendaPermitida.includes(tipoAgenda)){
                                    elem += `<div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="avatar-sm me-2">
                                            <img src="${quitarComillas(dataCita.promocion.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
                                        </div>
                                        <div>
                                            ${ drawBtnCardItem(value) }
                                        </div>
                                    </div>`;
                                }
                                elem += `</div>
                            </div>
                        </div>`;
            }
        })
        

        if((dataCita.promocion.tipoServicio == "LABORATORIO" || dataCita.promocion.tipoServicio == "IMAGENES" || dataCita.promocion.tipoServicio == "PROCEDIMIENTOS") && showResultados){
            let urlResultado = "/resultados-laboratorio";
            if(dataCita.promocion.tipoServicio != "LABORATORIO"){
                urlResultado = "/resultados-imagenes-procedimientos";
            }
            elem += `<div class="col-12 mt-3">
                        <a href="${urlResultado}" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5 waves-effect waves-light order-last">Ver resultados</a>
                    </div>`;
        }else{
            if(dataCita.promocion.tipoServicio == "LABORATORIO" || dataCita.promocion.preparacionPrevia != null){
                elem += `<div class="col-12 mt-3">
                        <button type="button" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5 waves-effect btn-informacion waves-light order-last">Ver información</a>
                    </div>`;
            }
        }

        $('#listado-detalles').html(elem);
    }

    function drawBtnCardItem(detalles){
        console.log(detalles);
        console.log(999);
        if(detalles.estado == "Caducado" || (dataCita.promocion.hasOwnProperty('esAgendable') && !dataCita.promocion.esAgendable && !detalles.hasOwnProperty('detalleReserva') && detalles.detalleReserva != null)){
            return ``;
        }
        // "tipoAgenda": "CONSULTA_MEDICA"  o "TERAPIAS"
        // esAgendable:True
        // si el detalle tiene estado Disponible
        // y detalleReserva==null
        let tipoAgenda = dataCita.promocion.tipoAgenda;
        let titleBtn = `Agendar`;
        let btnEnviaAgendarClass = `btn-agendar`;
        if(tiposAgendaPermitida.includes(tipoAgenda) && detalles.estado == "Agendada" && dataCita.detalleItemPaquete.detalleReserva != null && dataCita.detalleItemPaquete.detalleReserva.habilitaBotonCambio == "S"){
            if(detalles.detalleReserva != null){
                titleBtn = `${dataCita.detalleItemPaquete.detalleReserva.nombreBotonCambiar}`;
                btnEnviaAgendarClass = `btn-CambiarFechaCita`;
            }
        }

        return `<div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none ${btnEnviaAgendarClass}" data-rel='${JSON.stringify(detalles)}'>
                ${titleBtn}
            </div>`;
    }

</script>
<style>
    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal) .layout-page:before{
        display: none;
    }
</style>
@endpush