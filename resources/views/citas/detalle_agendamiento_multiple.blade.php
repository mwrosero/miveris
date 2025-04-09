@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Detalle Agendamiento múltiple
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp

<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>

<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    
    {{-- <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Agendar') }}</h5>
    </div>
    <section class="p-0 px-md-3"></section> --}}

    <section class="p-0 px-md-3">
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 mt-3 text-center">
                    <div class="badge box-qty-terapias fs--20 line-height-24 p-2 px-4 rounded-pill">
                        
                    </div>
                    <p class="fw-medium text-center text-primary-veris my-3 fs--28 line-height-36">¡Listo!</p>
                    <p class="msg-next fs--20 line-height-24"></p>
                    <img src="{{asset('assets/img/svg/terapia_multiple.svg')}}" alt="">
                    <div class="row justify-content-center">
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5 waves-effect btn-continuar waves-light"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<style>
    .box-qty-terapias{
        color: #00447C;
        border: 2px solid #A9C4F9;
        background: #EAF0FD;
    }
</style>
<script>
    let tiposAgendaPermitida = ["TERAPIA_FISICA"];
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    tipoFlujo = dataCita.tipoFlujo;
    document.addEventListener("DOMContentLoaded", async function () {

        if(dataCita.items.length == dataCita.detalle_pre_agendamiento.length){
            $('.msg-next').html(`Ahora, revisa y confirma los datos de la cita`);
            $('.btn-continuar').html(`Revisar`);
        }else{
            $('.msg-next').html(`Elige tu siguiente cita`);
            $('.btn-continuar').html(`Continuar`);
        }

        $('.box-qty-terapias').html(`${dataCita.detalle_pre_agendamiento.length} de ${dataCita.items.length}`)

        $('body').on('click', '.btn-continuar', async function(){
            if(dataCita.items.length == dataCita.detalle_pre_agendamiento.length){
                let ruta = "/citas-revisa-tus-datos/" + "{{ $params }}";
                location.href = ruta;
            }else{
                let ruta = "/citas-elegir-fecha-doctor/" + "{{ $params }}";
                location.href = ruta;
            }
        })

        $(document).on('click', '.verOrdenCard', function(){
            let datos = $(this).data('rel');
            descargarDocumentoPdf(datos);
        });

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
            let items = await obtenerDataRelSeleccionados();
            // let detalle = JSON.parse($(this).attr('data-rel'));
            dataCita.items = items;
            localStorage.setItem('cita-{{ $tokenCita }}', JSON.stringify(dataCita));
            window.location.href = `/seleccionar-datos-cita/{{ $tokenCita }}`;
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
                "origen": "paquetes",
                // "tipoFlujo" = "reagenda/paquetes"
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

    async function obtenerDataRelSeleccionados() {
        let seleccionados = $(".atencionInmediata-input:checked").map(function() {
            return JSON.parse($(this).attr("data-rel")); // Obtiene el atributo data-rel como objeto
        }).get(); // Convierte el resultado en un array

        return seleccionados;
    }

    async function drawDetalles(){
        let showResultados = false;
        let elem = ``;
        $.each(dataCita.detallesServicios, function(key, value){
            let tipoAgenda = value.tipoAgenda;
            let estado = ``;
            if(value.estado == "Atendida"){
                showResultados = true;
            }
            //if(value.estado == "Atendida" && dataCita.promocion.tipoServicio != "LABORATORIO"){
            console.log(value.estado)
            if((value.estado == "Atendida" || value.estado == "Agendada")){
                let btnReagendar = ``;
                if(value.estado == "Agendada"){
                    btnReagendar += `<div>
                        ${ drawBtnCardItem(value) }
                    </div>`
                }
                if(dataCita.paciente.nombrePaciente){
                    nombrePaciente = dataCita.paciente.nombrePaciente;
                }else{
                    nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
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
                            ${determinarFechaCaducidadEncabezadoAgendamientoMultiple(value, dataCita.datosTratamiento)}
                            <h6 class="fw-medium fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.nombreSucursal)}</h6>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(value.detalleReserva.fechaReserva)} <b class="hora-cita fw-normal text-primary-veris">${value.detalleReserva.horaReserva}</b></p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">Dr(a): ${capitalizarElemento(value.detalleReserva.nombreMedicoReserva)}</p>
                            <p class="fw-normal fs--2 line-height-16 mb-1">${capitalizarElemento(nombrePaciente)}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="avatar-sm me-2">
                                    <img src="${quitarComillas(value.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
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
                if(value.detalleReserva !== null){
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
                                        <img src="${quitarComillas(value.urlImagenTipoServicio)}" alt="Avatar" class="rounded-circle bg-light-grayish-green">
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
            }
        })
        
        $('#listado-detalles').html(elem);
        let elemMultiple = `<div class="col-12 mt-3">
            Puedes agendar hasta 5 terapias a la vez
        </div>`;
        $.each(dataCita.detallesServicios, function(key, value){
            if(value.detalleReserva === null){
                elemMultiple += `<div class="col-12 my-1">
                    <div class="w-100 d-flex justify-content-between align-items-center border-bottom py-3 px-2">
                        <div class="form-check d-flex justify-content-start align-items-center">
                            <input class="form-check-input atencionInmediata-input me-2 mb-1 width-24" type="checkbox" value="" id="item-${value.lineaDetalleTratamiento}" data-rel='${JSON.stringify(value)}'>
                            <label class="text-primary-veris form-check-label fs--1 line-height-16 text-capitalize" for="item-${value.lineaDetalleTratamiento}">
                                ${value.nombreServicio.toLowerCase()}
                            </label>
                        </div>
                        <div style="min-width: 90px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                            <i class="fa-regular fa-calendar-check me-2"></i>
                            Disponible
                        </div>
                    </div>
                </div>`
            }
        })
        $('#listado-detalles-por-agendar').html(elemMultiple);
    }

    function drawBtnCardItem(detalles){
        console.log(detalles);
        console.log(999);
        if(detalles.estado == "Caducado" || (detalles.hasOwnProperty('esAgendable') && !detalles.esAgendable && !detalles.hasOwnProperty('detalleReserva') && detalles.detalleReserva != null)){
            return ``;
        }
        // "tipoAgenda": "CONSULTA_MEDICA"  o "TERAPIAS"
        // esAgendable:True
        // si el detalle tiene estado Disponible
        // y detalleReserva==null
        let tipoAgenda = detalles.tipoAgenda;
        let titleBtn = `Agendar`;
        let btnEnviaAgendarClass = `btn-agendar`;
        if(tiposAgendaPermitida.includes(tipoAgenda) && detalles.estado == "Agendada" && detalles.detalleReserva != null && detalles.detalleReserva.habilitaBotonCambio == "S"){
            if(detalles.detalleReserva != null){
                titleBtn = `${detalles.detalleReserva.nombreBotonCambiar}`;
                btnEnviaAgendarClass = `btn-CambiarFechaCita`;
            }
        }

        let btnOrden = `<a class="btn btn-sm fw-normal fs--1 px-3 py-2 border-0 text-primary-veris shadow-none verOrdenCard me-2" data-rel='${JSON.stringify(detalles)}'>Ver orden</a>`;

        return `${btnOrden} <div class="btn btn-sm btn-primary-veris fw-medium fs--1 line-height-16 px-3 py-2 shadow-none ${btnEnviaAgendarClass}" data-rel='${JSON.stringify(detalles)}'>
                ${titleBtn}
            </div>`;
    }

    async function descargarDocumentoPdf(datos){

        let datosFiltrados = datos;
        console.log('datosFiltrados', datosFiltrados);
        let args = [];
        let canalOrigen = 'APP_CMV'
        let secuenciaAtencion = dataCita.secuenciaAtencion;
        if(datosFiltrados.tipoCard == 'RECETAS'){
            args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=RECETA&numeroOrden=&secuenciaReceta=${datosFiltrados.secuenciaReceta}`;
        }
        else{
            args["endpoint"] = api_url + `/${api_war}/v1/hc/archivos/generarDocumento?secuenciaAtencion=${secuenciaAtencion}&tipoServicio=ORDEN&numeroOrden=${datosFiltrados.idOrden}`;
        }
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
            console.error('Error al obtener el PDF:', error);
        }
    }
</script>
<style>
    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal) .layout-page:before{
        display: none;
    }
</style>
@endpush