@extends('template.app-template-veris')
@section('title')
Mi Veris - Cita agendada
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-3 mb-3">
        <div class="row g-0 justify-content-center">
            <div class="col-md-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body text-center p-0">
                        <!-- cita presencial online -->
                        <div class="content-presencial d-none">
                            {{-- <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Cita agendada</h3>
                            <p class="fs--16 line-height-20 mb-5">Tu cita se agendó exitosamente. <br> ¡Nos vemos pronto!</p>
                            <img src="{{ asset('assets/img/svg/doctora_2.svg') }}" alt="cita agendada">
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div> --}}
                        </div>
                        <!-- cita agendada online -->
                        <div class="content-online d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Cita agendada</h3>
                            <p class="fs--16 line-height-20 mb-5">Recuerda conectarte <b>10 minutos antes de la cita.</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Paquete comprado -->
                        <div class="content-paquete d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="Promoción comprada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Promoción comprada</h3>
                            <p style="color: #0A2240;" class="fs--16 line-height-20">Tu promoción se compró exitosamente.<br>¡Nos vemos pronto!</p>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar"></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/paquete-comprado.svg') }}"  alt="Promoción comprada">
                            </div>
                            <div class="mt-5">
                                <a href="/mis-promociones" class="btn btn-primary-veris fs--18 line-height-24 w-100 w-md-75 px-4 py-3 mb-2">Ir a mis promociones</a>
                                <a href="/" class="btn btn-sm fs--18 line-height-24 px-4 py-3 w-100 w-md-75 border-0 text-primary-veris shadow-none">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Promoción tratamiento comprado -->
                        <div class="content-tratamiento d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Tratamiento comprado</h3>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar"></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/cita_agendada_online.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Laboratorio presencial comprado -->
                        <div class="content-lab-presencial d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Laboratorio pagado</h3>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar">Acércate a cualquier central Veris.<br><b>¡Nos vemos pronto!</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/lab_presencial.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Volver al inicio</a>
                            </div>
                        </div>
                        <!-- Laboratorio domicilio comprado -->
                        <div class="content-lab-domicilio d-none">
                            <div class="avatar avatar-lg mx-auto mb-4">
                                <img src="{{asset('assets/img/svg/visto.svg')}}" alt="cita agendada">
                            </div>
                            <h3 class="fs--28 line-height-36 fw-medium mb-4">Laboratorio pagado</h3>
                            <p class="fs--16 line-height-20 mb-5" id="infoAgendar">Tu laboratorio a domicilio ha sido  agendado.<br><b>¡Nos vemos pronto!</b></p>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/img/svg/lab_domicilio.svg') }}"  alt="cita agendada">
                            </div>
                            <div class="mt-5">
                                <a href="/" class="btn btn-primary-veris fs--18 line-height-24 fw-medium w-100 px-4 py-3">Volver al inicio</a>
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
<script>
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let datoReserva;
    document.addEventListener("DOMContentLoaded", async function () {
        // let urlImagen = "share-img.png";
        let imagenBase64 = await obtenerImagenCompartir();
        datoReserva = await obtenerDatosReserva(dataCita.reserva.codigoReserva);
        // convertirImagenABase64(urlImagen, function(base64Imagen) {
        //     imagenBase64 = base64Imagen
        // });

        $('body').on('click', '.btnShare', async function(){
            try {
                let urlCita = "https://www.veris.com.ec"
                await navigator.share({
                    files: [
                        new File([dataURItoBlob(imagenBase64)], 'cita.png', { type: 'image/png' })
                    ],
                    title: "Cita agendada",
                    text: urlCita,
                    url: urlCita
                });
                console.log('Archivo compartido correctamente');
            } catch (error) {
                console.error('Error al compartir el archivo:', error);
            }
        })

        $('body').on('click', '.btn-link-home', async function(){
            if($('#calendario').is(":checked")){
                let url = await sincronizarCalendario();
                window.open(url, "_blank");
                setTimeout(function(){
                    location = "/";
                },500);
            }else{
                location = "/";
            }
        })

        if(!dataCita.paquete && !dataCita.promocion && !dataCita.datosTratamiento && !dataCita.ordenExterna){
            if(dataCita.online == "S"){
                let card = await drawCardAgenda();
                $('.content-online').html(card).removeClass('d-none');
            }else{
                let card = await drawCardAgenda();
                $('.content-presencial').html(card).removeClass('d-none');
            }
        }else{
            if(dataCita.paquete){
                //$('#infoAgendar').html(`Para agendarla comunícate con nosotros al <b>${dataCita.detallePaquete.numeroContactCenter}</b>.`)
                $('.content-paquete').removeClass('d-none');
            }else if(dataCita.promocion){
                $('.content-tratamiento').removeClass('d-none');
            }else if(dataCita.datosTratamiento){
                if(dataCita.datosTratamiento.tipoServicio == "LABORATORIO"){
                    $('.content-lab-presencial').removeClass('d-none');
                }else{
                    let card = await drawCardAgenda();
                    $('.content-presencial').html(card).removeClass('d-none');
                }
            }else if(dataCita.ordenExterna){
                if(dataCita.ordenExterna.aplicoDomicilio == "N"){
                    $('.content-lab-presencial').removeClass('d-none');
                }else{
                    $('.content-lab-domicilio').removeClass('d-none');
                }
            }
        }
    });

    function dataURItoBlob(dataURI) {
        var byteString = atob(dataURI.split(',')[1]);
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: mimeString });
    }

    function formatoHoraGoogle(dia, hora){
        var partesDia = dia.split("/");
        var fecha = new Date(partesDia[2], partesDia[1] - 1, partesDia[0]); // Ajustamos el mes para que empiece desde 0

        // Formatear la fecha
        var diaFormateado = fecha.getFullYear() + ('0' + (fecha.getMonth() + 1)).slice(-2) + ('0' + fecha.getDate()).slice(-2);

        // Formatear la hora
        var horaFormateada = hora.replace(':', '') + '00';

        // Combinar fecha y hora en el formato deseado
        var fechaHoraFormateada = diaFormateado + "T" + horaFormateada;
        return fechaHoraFormateada.toString();
    }

    async function obtenerDatosReserva(codigoReserva){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/reserva/${codigoReserva}?canalOrigen=${_canalOrigen}`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        return data;
    }

    async function sincronizarCalendario(){
        // Variables del evento
        let urlVirtual = ``;
        var tituloEvento = (dataCita.online == "N") ? "Cita agendada" : "Cita virtual agendada";
        var descripcionEvento = `Especialidad: ${capitalizarElemento(dataCita.especialidad.nombre)}\nDr(a): ${capitalizarElemento(datoReserva.data.datosReserva.nombreProfesional)}\n`;
        if(dataCita.online == "N"){
            descripcionEvento += `Central: ${capitalizarElemento(dataCita.central.nombreSucursal)}\n`
        }else{
            urlVirtual += `Link de cita virtual: <a href='${datoReserva.data.linkVideoConsulta}' target="_blank">Click aquí</a>`;
        }
        descripcionEvento += `Fecha: ${dataCita.horario.dia}\nHora: ${dataCita.horario.horaInicio}\n`+urlVirtual;
        // descripcionEvento += `[url]https://www.veris.com.ec[/url]`;
        var ubicacionEvento = (dataCita.online == "N") ? capitalizarElemento(dataCita.central.nombreSucursal) : "";
        var fechaInicio = formatoHoraGoogle(dataCita.horario.dia2, dataCita.horario.horaInicio); // Formato ISO 8601 para la fecha de inicio del evento
        var fechaFin = formatoHoraGoogle(dataCita.horario.dia2, dataCita.horario.horaFin); // Formato ISO 8601 para la fecha de fin del evento

        // Reemplaza los saltos de línea con %0A en la descripción del evento
        descripcionEvento = descripcionEvento.replace('[br]', "%3Cbr%3E");
        //.replace('[url]', "%3Ca+href%3D%22").replace('[/url]', "%3C/a%3E");

        // Construir el enlace para agregar el evento a Google Calendar
        var enlaceGoogleCalendar = "https://www.google.com/calendar/render?action=TEMPLATE" +
            "&text=" + encodeURIComponent(tituloEvento) +
            "&details=" + encodeURIComponent(descripcionEvento) +
            "&location=" + encodeURIComponent(ubicacionEvento) +
            "&dates=" + encodeURIComponent(fechaInicio + "/" + fechaFin);
        // if(dataCita.online == "N"){
        //     enlaceGoogleCalendar += "&sprop=" + encodeURIComponent("&location=" + dataCita.central.latitud + "," + dataCita.central.longitud);
        // }

        // Ahora puedes utilizar este enlace en un <a> o en cualquier otra parte de tu aplicación
        console.log(enlaceGoogleCalendar); // Esto imprimirá el enlace en la consola para verificar
        return enlaceGoogleCalendar;
    }

    async function drawCardAgenda(){
        let urlLocalidad = (dataCita.online == "N") ? `https://www.google.com/maps?q=${dataCita.central.latitud},${dataCita.central.longitud}` : '';

        let detalleAgenda = `<p class="mb-3 fs--1 label-status-detalle"><span class="fw-medium text-primary-veris">Especialidad:</span> ${capitalizarElemento(dataCita.especialidad.nombre)}</p>
            <p class="mb-3 fs--1 label-status-detalle"><span class="fw-medium text-primary-veris">Dr(a):</span> ${capitalizarElemento(datoReserva.data.datosReserva.nombreProfesional)}</p>`;
            if(dataCita.online == "N"){
                detalleAgenda += `<p class="mb-3 fs--1 label-status-detalle"><span class="fw-medium text-primary-veris">Central:</span> ${capitalizarElemento(dataCita.central.nombreSucursal)}</p>`;
            }
            detalleAgenda += `<p class="mb-3 fs--1 label-status-detalle"><span class="fw-medium text-primary-veris">Fecha:</span> ${dataCita.horario.dia}</p>
            <p class="mb-3 fs--1 label-status-detalle"><span class="fw-medium text-primary-veris">Hora:</span> ${dataCita.horario.horaInicio}</p>`;

        let urlImagen = (dataCita.online == "N") ? "{{ asset('assets/img/veris/doctora-cita.svg') }}" : "{{ asset('assets/img/svg/cita_agendada_online.svg') }}"

        let elem = `<div class="card h-100 shadow-veris">
            <div class="card-body p-0">
                <div class="row p-3 gx-0 justify-content-between align-items-center mb-0" style="background:#EFF3F8;">
                    <div class="col-7 text-start">
                        <h6 class="card-title text-primary-veris fs-24 line-height-28 mb-3 capitalizar">Cita agendada</h6>
                        <p class="label-status-detalle line-height-16 fs--1 mb-3">${datoReserva.data.mensajeInformacion1.replace(/\*(.*?)\*/g, function(match, p1) {
                                return "<br><b>" + p1 + "</b>";
                            }) }</p>
                        <p class="card-text text-veris-many line-height-16 fs--2">${datoReserva.data.mensajeInformacion2.replace(/\*(.*?)\*/g, function(match, p1) {
                                return "<br><b>" + p1 + "</b>";
                            }) }</p>
                    </div>
                    <div class="col-5 ps-2">
                        <div class="my-auto ms-auto">
                            <img class="w-100" src="${urlImagen}" alt="cita agendada">
                        </div>
                    </div>
                </div>
                <div class="row p-3 gx-0 text-start mb-2">
                    <div class="col-12 text-start">
                        ${detalleAgenda}  
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="fs--2 d-flex justify-content-between align-items-center" style="color:#3A5068;"><i class="fa-solid fa-calendar text-primary-veris me-2 fs--18"></i>Agregar a mi calendario</div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input fs-3 ms-0" type="checkbox" role="switch" name="calendario" id="calendario" checked/>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center align-items-center">`;
                    if(dataCita.online == "N"){
                        elem += `<a href="${urlLocalidad}" target="_blank" class="rounded shadow-veris p-3 mt-3 text-center w-100 me-3 border-icon-box">
                            <i class="fa-solid fa-location-dot text-primary-veris fs-24 mb-2"></i>
                            <div class="fs--2 line-height-16" style="color:#3A5068;">¿Cómo llegar?</div>
                        </a>`
                    };
                    elem += `<div role="button" class="rounded shadow-veris p-3 mt-3 text-center w-100 border-icon-box btnShare">
                            <i class="fa-solid fa-paper-plane text-primary-veris fs-24 mb-2"></i>
                            <div class="fs--2 line-height-16" style="color:#3A5068;">Compartir</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        elem += `<div class="mt-4">
                    <div class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3 btn-link-home">Volver al inicio</div>
                </div>`;
        return elem;
    }

    async function obtenerImagenCompartir(){
        let codigoReserva;
        if(dataCita.reserva){
            codigoReserva = dataCita.reserva.codigoReserva;
        }
        if(dataCita.reservaEdit){
            codigoReserva = dataCita.reservaEdit.idCita;
        }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/archivoReserva/${codigoReserva}?canalOrigen=${_canalOrigen}&tipoArchivo=JPG`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            return data.data.imagen;
        }else{
            alert(data.message);
        }
    }
</script>
<style>
    .shadow-veris{
        box-shadow: 0px 4px 8px 0px #0000001A !important;
    }

    .border-icon-box{
        border: 1px solid #CFD3D9 !important;
    }

    @media (min-width: 768px) {
        /* CUSTOM WIDTHS */
        .w-md-75 { width: 75% !important; }
    }
</style>
@endpush