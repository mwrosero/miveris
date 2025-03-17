@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elige fecha y doctor
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3">Veris</h1>
                    <p class="fs--16 fw-normal text-veris mb-3" id="mensajeError" ></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100" data-bs-dismiss="modal" id="btnEntiendoError">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de error validacion fecha -->
    <div class="modal fade" id="modalValidacionFecha" tabindex="-1" aria-labelledby="modalValidacionFechaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información de tu seguro</h1>
                    <p class="fs--1 fw-normal" id="msg-validacion-fecha"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 px-4 py-3 w-100" data-bs-dismiss="modal" id="btnEntiendoError">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal elegir horario -->
    <div class="modal bg-transparent fade" id="elegirHorarioModal" tabindex="-1" aria-labelledby="elegirHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                    <h6 class="text-center fs--16 line-height-20 fw-medium mb-2">{{ __('Horarios') }}:</h6>
                    <div id="listaHorariosMedico" class="row g-2">
                        {{-- <div class="card card-body rounded-3 position-relative py-2 mb-2">
                            <a href="{{route('citas.detalleCita')}}">
                                <div class="badge-discount-top fs--3 fw-medium"><span>{{ __('-30%') }}</span></div>
                                <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                                <div class="badge-discount-bottom fs--3 fw-medium"><span>{{ __('descuento') }}</span></div>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-sm text-primary-veris fs--18 line-height-24 fw-medium shadow-none m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal NO HAY FECHA DISPONIBLES -->
    <div class="modal fade" id="sinFechaDisponibles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sinFechaDisponiblesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                    <div class="text-center">
                        <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3" id="sinFechaDisponiblesLabel">Veris</h1>
                        <p class="fs--16 fw-normal text-veris mb-3" title="titleNoDisponibilidad">No tiene fechas disponibles.</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <a href="{{ url()->previous() }}" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal no hay medicos disponibles -->
    <div class="modal fade" i|d="sinMedicosDisponibles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sinMedicosDisponiblesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                    <div class="text-center">
                        <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3" id="sinMedicosDisponiblesLabel">Veris</h1>
                        <p class="fs--16 fw-normal text-veris mb-3">No tiene médicos disponibles.</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <a href="{{ url()->previous() }}" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Elige fecha y doctor') }}</h5>
    </div>
    <section class="p-0 bg-dark-blue-veris-medium-sm">
        <div class="row g-0 justify-content-center">
            <div class="col-auto p-2 bg-dark-blue-veris-medium" style="min-width: 375px;">
                <p class="text-center text-white fw-medium fs--18 line-height-24 m-1 mb-0 text-capitalize" id="month-name"></p>
                <div class="row g-0 d-flex">
                    <div class="col-12">
                        <div class="calendar-container invisible p-0 mb-1 w-100">
                            <span class="arrow mt-3" id="prev-week">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                            <div class="calendar-header">
                                <div class="week-container pt-3 mt-1" id="week-days"></div>
                            </div>
                            <span class="arrow mt-3" id="next-week">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0">
        <div class="row g-0 justify-content-center">
            <div class="col-auto ps-3 pe-3" style="min-width: 375px; max-width: 407px;">
                <p class="fs--1 mt-2 line-height-16 fw-normal mb-0 d-none" id="nombreFiltro">Filtrar por</p>
                <ul class="nav nav-pills d-none justify-content-center border-box-veris w-auto p-1 rounded-3 mt-2 mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item w-50" role="presentation" data-rel="T">
                        <button data-rel="N" class="nav-link options-date ps-1 pe-1 active" id="pills-options-tab" data-bs-toggle="pill" data-bs-target="#pills-options" type="button" role="tab" aria-controls="pills-options" aria-selected="true">Todos</button>
                    </li>
                    <li class="nav-item w-50" role="presentation" data-rel="D">
                        <button data-rel="S" class="nav-link options-date ps-1 pe-1" id="pills-options-descuentos-tab" data-bs-toggle="pill" data-bs-target="#pills-options-descuentos" type="button" role="tab" aria-controls="pills-options-descuentos" aria-selected="false" tabindex="-1">Con descuento
                            <svg width="18" height="17" viewBox="0 0 18 17" class="ms-1 badge-icon-selected" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.2178 8.3125C17.2178 9.50488 16.6377 10.5361 15.7031 11.1162C15.9287 12.1797 15.6387 13.3398 14.8008 14.1455C13.9951 14.9834 12.835 15.3057 11.7715 15.0801C11.1592 15.9824 10.1602 16.5625 8.96777 16.5625C7.80762 16.5625 6.77637 15.9824 6.16406 15.0801C5.10059 15.3057 3.97266 14.9834 3.13477 14.1455C2.3291 13.3398 2.00684 12.1797 2.23242 11.1162C1.33008 10.5361 0.717773 9.50488 0.717773 8.3125C0.717773 7.15234 1.33008 6.12109 2.23242 5.54102C2.00684 4.47754 2.3291 3.31738 3.13477 2.47949C3.97266 1.67383 5.13281 1.35156 6.16406 1.57715C6.77637 0.674805 7.80762 0.0625 8.96777 0.0625C10.1602 0.0625 11.1592 0.674805 11.7715 1.57715C12.835 1.35156 13.9951 1.67383 14.8008 2.47949C15.6387 3.31738 15.9287 4.47754 15.7031 5.54102C16.6055 6.12109 17.2178 7.15234 17.2178 8.3125ZM6.90527 5.21875C6.35742 5.21875 5.87402 5.70215 5.87402 6.25C5.87402 6.83008 6.35742 7.28125 6.90527 7.28125C7.48535 7.28125 7.9043 6.83008 7.9043 6.25C7.9043 5.70215 7.48535 5.21875 6.90527 5.21875ZM7.45312 10.9229L11.5781 6.79785C11.9004 6.50781 11.9004 6.02441 11.5781 5.73438C11.2881 5.41211 10.8047 5.41211 10.5146 5.73438L6.38965 9.85938C6.06738 10.1494 6.06738 10.6328 6.38965 10.9229C6.51855 11.084 6.71191 11.1484 6.9375 11.1484C7.13086 11.1484 7.32422 11.084 7.45312 10.9229ZM11.0303 11.4062C11.6104 11.4062 12.0615 10.9551 12.0615 10.375C12.0615 9.82715 11.6104 9.34375 11.0303 9.34375C10.4824 9.34375 9.99902 9.82715 9.99902 10.375C9.99902 10.9551 10.4824 11.4062 11.0303 11.4062Z" fill="#EF2E79"/></svg> </button>
                    </li>
                </ul>
                <div class="overflow-auto" id="listaMedicos">
                    {{-- <div class="border-box-light-blue rounded-3 p--2 mb-3">
                        <div class="header-doctor d-flex justify-content-between align-items-start mb-3">
                            <div class="picture-doctor border-box-light-blue border-3 rounded-circle" style="background: url({{ asset('assets/img/svg/avatar_doctor.svg') }}) no-repeat center center;background-size: auto;">
                            </div>
                            <div class="content-doctor ms-2 flex-grow-1">
                                <div class="name-rate d-flex justify-content-between align-items-center mb-1">
                                    <h6 style="max-width: 200px" class="fs--16 line-height-20 fw-medium flex-grow-1 m-0">Juan Alberto Rodrigues Gonzáles</h6>
                                    <div class="star-box text-center ms-1">
                                        <i class="fa-solid fa-star fw-bold star-ico fs--20 d-block"></i>
                                        <span class="fw-normal fs--3 mt-1 rate-label">4.6</span>
                                    </div>
                                </div>
                                <p class="fs--2 line-height-16 fw-normal mb-1" style="color: #425065;">Dermatología</p>
                                <div class="info-adicional-medico d-flex justify-content-between align-items-center">
                                    <div class="badge rounded-3 py-1 px-2 bg-cita-atendida d-flex justify-content-between align-items-center gap-1 flex-grow-1 me-2">
                                        <i class="fa-solid fa-clock" style="color:#2F7833;"></i>
                                        <span class="fw-normal fs--2" style="color:#2F7833;">Te atendiste con este doctor</span>
                                    </div>
                                    <div class="badge rounded-3 py-1 px-2 bg-fav-atendida">
                                        <i class="fa-solid fs--2 fa-heart" style="color:#D84315;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dates-doctor">
                            <p class="fs--1 line-height-16 fw-medium mb-2" style="color:#296BEF;">Horario más próximo:</p>
                            <div class="row g-2" style="max-width:341px">
                                <div class="col-6">
                                    <div class="cursor-pointer waves-effect p--2 px-3 w-100 bg-time-doctor rounded-3 d-flex justify-content-center align-items-center">
                                        <span class="fs--1 line-height-20 rate-label text-center mb-0">09:00 - 09:20</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="cursor-pointer waves-effect p--2 px-3 w-100 bg-time-doctor box-time-doctor-with-discount position-relative rounded-3 d-flex justify-content-end align-items-center">
                                        <div class="box-badge-discount-time position-absolute">
                                            <span class="badge-discount-time position-absolute fs--2 fw-medium">-10%</span>
                                        </div>
                                        <span class="fs--1 line-height-20 rate-label text-center mb-0">09:00 - 09:20</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="cursor-pointer waves-effect p--2 px-3 w-100 bg-time-doctor rounded-3 d-flex justify-content-center align-items-center">
                                        <span class="fs--1 line-height-20 rate-label text-center mb-0">09:00 - 09:20</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="cursor-pointer waves-effect p--2 px-3 w-100 bg-time-doctor-alt rounded-3 d-flex justify-content-center align-items-center">
                                        <span class="fs--1 line-height-20 rate-label text-center mb-0">Ver más horarios</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="p-3 mb-3 d-none">
        <div class="row justify-content-center">
            <div class="col-auto" style="min-width: 375px;">
                <div class="card card-fecha-foctor position-relative">
                    <div class="card-body p-0">
                        <div class="calendar-body position-relative">
                            <div class="calendar-container w-auto" style="max-height: 140px;">
                                <div class="calendar-header">
                                    <button class="btn btn-sm px-0 shadow-none prev-btn"><i class="bi bi-chevron-left fs--1 text-white"></i></button>
                                    <h6 class="text-white fw-normal fs--1 mx-3 mb-0" id="month-year"></h6>
                                    <button class="btn btn-sm px-0 shadow-none next-btn"><i class="bi bi-chevron-right fs--1 text-white"></i></button>
                                </div>
                                <div class="calendar-grid" id="calendar-grid"></div>
                            </div>
                            <button class="btn btn-sm shadow-none text-white fs-2 fw-medium w-100" id="toggle-calendar-btn"><i class="bi bi-chevron-compact-down"></i></button>
                        </div>
                        <div class="card shadow-none border-24" style="background: var(--neutral-05, #F3F4F5);">
                            <div class="card-header border-bottom py-2" id="tituloFechaDoctor">
                                Resultados
                            </div>
                            <div class="card-body p-3" style="max-width: 433px;">
                                <div class="col-auto overflow-auto" id="listaMedicos" style="max-height: 433px;">
                                    {{-- <div class="card shadow-none mb-3">
                                        <div class="card-body p--2">
                                            <div class="row g-2">
                                                <div class="col-3 text-center">
                                                    <img src="{{ asset('assets/img/svg/avatar_doctor.svg') }}" class="img-fluid mt-4" alt="doctor" width="48">
                                                </div>
                                                <div class="col-9">
                                                    <h6 class="fw-medium mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                                    <p class="text-primary-veris fw-medium fs--2 mb-0">Veris - Alborada</p>
                                                    <p class="fs--2 mb-0">Cardiología</p>
                                                    <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">Do/Lu/Ma/Mi/Ju/Vi/Sa</b></p>
                                                    <p class="fs--2 mb-0">Horarios: <b class="fw-normal text-primary-veris" id="horarios">08h00 - 12h00</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end p--2">
                                            <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal">
                                                Elegir Cita
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-footer border-0 p-3 d-none" id="btnAgendarOrdenExterna">  
                                <div class="col-auto overflow-auto" style="max-height: 433px;">
                                    <div class="card-body p-2">
                                        <div class="examenLista">
                                            <!-- Fila para el encabezado -->
                                            <div class="examenEncabezado">
                                                <h6 class="fw-medium mb-0">Disponibilidad</h6>
                                            </div>
                                            <!-- Fila para el botón, alineado a la derecha -->
                                            <div class="botonAgendar" style="text-align: right; margin-top: 10px;">
                                                <a href="#" class="btn btn-primary-veris" id="btnAgendarServicioOrdenExterna"
                                                 >Agendar Servicio</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- modal -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let currentDate = new Date();
    const daysOfWeek = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'];

    // Variables globales
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let dataOrigen = dataCita?.origen;  
    let renderCalendarExternaFecha;
    let pacienteExternaSolicitud;
    let examenes;
    let online;
    let codigoEspecialidad;
    let codigoSucursal;
    let codigoServicio;
    let codigoPrestacion;
    let nombreSucursal;
    let nombreEspecialidad;
    let codigoSolicitud;
    let latitud;
    let longitud;
    let fechaOrdenExterna;
    let codigoZona;

    let esPlanStar;

    let firstRender = true;
    let numeroSemanaCurso;
    let numeroMesCurso;
    let numeroMesSeleccionado;

    if(dataOrigen == 'ordenExternaSolicitud'){
        console.log('No se puede seleccionar fecha y doctor para una cita de orden externa');
        examenes = dataCita.ordenExterna.pacientes[0].examenes;
        pacienteExternaSolicitud = dataCita.ordenExterna;
        online = dataCita.online;
        codigoSolicitud = dataCita.ordenExterna.codigoSolicitud;    
        latitud = dataCita.ordenExterna.latitud;
        longitud = dataCita.ordenExterna.longitud;
        codigoZona = dataCita.ordenExterna.codigoZona;
    } else {
        online = dataCita?.online;
        codigoEspecialidad = dataCita?.especialidad.codigoEspecialidad;

        if(dataOrigen == 'doctorFavorito'){
            codigoSucursal = dataCita?.especialidad.codigoSucursal;
        }else if (dataCita?.central){
            codigoSucursal = dataCita?.central.codigoSucursal;
        }else {
            codigoSucursal = ""
        }
        esPlanStar = dataCita?.convenio.esPlanStar || 'false';
        codigoServicio = dataCita?.especialidad.codigoServicio || ' ';
        codigoPrestacion = dataCita?.especialidad.codigoPrestacion || ' ';
        nombreSucursal = dataCita?.central?.nombreSucursal || ' ';
        nombreEspecialidad = dataCita?.especialidad.nombre || ' ';
    }
    
    let _fechaSeleccionada;
    // const daysOfWeek = ["D", "L", "M", "M", "J", "V", "S"];
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const calendarGrid = document.getElementById('calendar-grid');
    const monthYearElement = document.getElementById('month-year');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    // let currentDate = new Date();
    numeroSemanaCurso = getWeekCurrent(currentDate);
    numeroMesCurso = currentDate.getMonth() + 1;
    numeroMesSeleccionado = numeroMesCurso;
    let fechasDisponibles = []; // Variable global para almacenar las fechas disponibles*/

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        // if((dataCita.central && dataCita.central.codigoTipoSucursal == "CAP") || dataCita.hasOwnProperty('detalleItemPaquete')){
        if((dataCita.central && dataCita.central.codigoTipoSucursal == "CAP")){
            $('#nombreFiltro').addClass('d-none');
            $('#pills-tab').addClass('d-none');
            $('#listaMedicos').addClass('pt-3');
        }else{
            $('#nombreFiltro').removeClass('d-none');
            $('#pills-tab').removeClass('d-none');
        }
        if (dataCita.origen == 'ordenExternaSolicitud') {
            //renderCalendarExterna();
            fechasDisponibles = await obtenerFechasOrdenesExternas();
            //await renderCalendar();
            await renderWeek();
            // $('.dias-calendario').addClass('d-none');
            // $('.semana-'+numeroSemanaCurso).removeClass('d-none');
            let listaMedicos = $('#listaMedicos');
            listaMedicos.empty();
            $.each(dataCita.ordenExterna.pacientes, function(key, paciente){
                llenarListaExamenes(paciente, '#listaMedicos');
            })
            // setear titulo fecha doctor
            $('#btnAgendarOrdenExterna').removeClass('d-none');
            document.getElementById('tituloFechaDoctor').innerHTML = 'Exámenes';
        } else {
            await consultarFechasDisponibles();
            // renderWeek();
        }

        // Deshabilitar la navegación hacia atrás
        $('#prev-week').click(function() {
            const today = new Date();
            if (currentDate > today) {
                currentDate.setDate(currentDate.getDate() - 7);
                renderWeek();
            }
        });

        $('#next-week').click(function() {
            currentDate.setDate(currentDate.getDate() + 7);
            renderWeek();
        });

        $('body').on('click', '.day', async function(){
            $('.day').removeClass('selected-day');
            $(this).addClass('selected-day');
            let fechaSeleccionada = $(this).attr("fechaSeleccionada-rel");
            /*if (fechasDisponibles.includes(fechaSeleccionada)) {
                if(!$(this).hasClass('unavailable-day')){
                    if (!dataCita.origen || dataCita.origen != 'ordenExternaSolicitud'){
                        await consultarMedicos(fechaSeleccionada);
                    }
                }
            }*/
            if (!dataCita.origen || dataCita.origen != 'ordenExternaSolicitud'){
                await consultarMedicos(fechaSeleccionada);
            }
        })

        //renderWeek();

        $('body').on('click','.options-date', async function(){
            // let fechaSeleccionada = $('.selected-day').attr("fechaSeleccionada-rel");
            await consultarMedicos();
        })

        $('body').on('click','.btn-disponibilidad-medico', function(){
            dataCita.horario = JSON.parse($(this).attr("data-horario")); 
            let ruta = "/citas-revisa-tus-datos/" + "{{ $params }}";
            if(dataCita.central && dataCita.central.codigoTipoSucursal == "CAP"){
                ruta = "/cita-urgencias-ambulatorias/" + "{{ $params }}";
            }
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            window.location.href = ruta;
        })

        $('body').on('click','.btn-disponibilidad-medico-all', function(){
            let data = $(this).attr("data-rel")
            consultarDisponibilidadMedico(data, true);
        })
        // Listener para seleccionar un horario
        $('body').on('click', '.card-horario', function () {
            let horario = $(this).data('horario');
            if (dataCita.origen == 'ordenExternaSolicitud') {
                guardarHorarioEnDataCitaExterna(horario)
            }else{
                guardarHorarioEnDataCita(horario);
            }
        });

        // btnEntiendoError redirecciona a la página inicial
        $('#btnEntiendoError').click(function(){
            if(!dataCita.ordenExterna){
                window.location.href = "{{ route('home') }}";
            }
        });

        // btnAgendarServicioOrdenExterna llama a la función consultarHorasMotorizados  
        $('#btnAgendarServicioOrdenExterna').click(async function(){
            let data = await consultarHorasMotorizados();        
        });
    });

    async function renderWeek() {
        const weekDaysContainer = $('#week-days');
        weekDaysContainer.empty();

        // Obtener la fecha actual y establecerla como el primer día a mostrar
        const firstDayOfWeek = new Date(currentDate);
        firstDayOfWeek.setHours(0, 0, 0, 0); // Eliminamos la parte de horas para comparar solo la fecha

        $('#month-name').text(firstDayOfWeek.toLocaleDateString('es-ES', { month: 'long' }));

        // Generar los días de la semana a partir del día actual
        for (let i = 0; i < 7; i++) {
            const day = new Date(firstDayOfWeek);
            day.setDate(firstDayOfWeek.getDate() + i); // Incrementamos para cada día

            const today = new Date();
            today.setHours(0, 0, 0, 0); // Comparación solo de fecha
            const isToday = day.toDateString() === today.toDateString();

            // Formatear la fecha como dd/mm/yyyy para la comparación
            const formattedDate = day.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            // Verificar si la fecha está en fechasDisponibles
            const isAvailable = fechasDisponibles.includes(String(formattedDate));
            console.log(formattedDate,isAvailable);
            const unavailableClass = '';
            // const unavailableClass = isAvailable ? '' : 'unavailable-day';
            const todayLabel = isToday ? '<div class="today-label fw-light fs--2">Hoy</div>' : '';

            // Crear el elemento del día
            const dayElement = $(`
                <div fechaSeleccionada-rel='${formattedDate}' class="day p-2 fs--16 line-height-12 ${isToday ? 'selected-day' : ''} ${unavailableClass}">
                    ${todayLabel}
                    <span class="d-block mb-1">${daysOfWeek[day.getDay()]}</span>
                    <span class="d-block">${day.getDate()}</span>
                </div>
            `);

            weekDaysContainer.append(dayElement);
        }
        $('.calendar-container').removeClass('invisible');
    }

    async function validacionFecha(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validacionFecha`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "fechaSeleccionada": $('.selected-day').attr("fechaSeleccionada-rel")
        });
        const data = await call(args);
        console.log(data)
        if(data.code == 200){
            if(data.data.mensajeValidacion1 != null){
                //mostrar mensaje
                if(data.data.aplicaCondicionesSeguro){
                    $('.box-disponibilidad').empty();
                }
                let msg = data.data.mensajeValidacion1+"<br>"+data.data.mensajeValidacion2;
                $('#msg-validacion-fecha').html(msg.replace(/\*(.*?)\*/g, '<b class="text-primary-veris">$1</b>'));
                $('#modalValidacionFecha').modal("show");
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    async function obtenerFechasOrdenesExternas(){
        var fechas = [];
        var fechaActual = new Date();
        fechaActual.setDate(fechaActual.getDate() + 1); // Empezar desde el día siguiente al actual
        for (var i = 0; i < 30; i++) { // Generar los próximos 15 días
            var dia = fechaActual.getDate();
            var mes = fechaActual.getMonth() + 1;
            var año = fechaActual.getFullYear();
            var fechaFormateada = (dia < 10 ? '0' : '') + dia + '/' + (mes < 10 ? '0' : '') + mes + '/' + año;
            fechas.push(fechaFormateada); // Añadir la fecha al array
            fechaActual.setDate(fechaActual.getDate() + 1); // Incrementar la fecha para el siguiente día
        }
        return fechas;
    }

    async function consultarFechasDisponibles(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }
        
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/fechasdisponibles?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&idMedico=${codigoMedico}&esPlanStar=${esPlanStar}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            fechasDisponibles = data.data; // Almacenar las fechas disponibles en la variable global
            let elemento = '';

            if(data.data.length > 0){
                _fechaSeleccionada = fechasDisponibles[0];
                await renderWeek();
                $('.dias-calendario').addClass('d-none');
                $('.semana-'+numeroSemanaCurso).removeClass('d-none');
                await consultarMedicos();
            } else {
                await renderWeek();
                $('#titleNoDisponibilidad').html(data.message);
                $('#sinFechaDisponibles').modal('show');
                /* Mostrar la modal cuando No hay fecha disponibles. */
                console.log("No hay fechas disponibles");
            }
            
            listaEspecialidades.append(elemento);    
        } else if (data.code != 200){
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }

        return data;
    }

    async function consultarMedicos(){
        console.log("-------------------------");
        let fechaSeleccionada = $('.selected-day').attr("fechaSeleccionada-rel");
        console.log("-------------------------");
        console.log(fechaSeleccionada);
        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
            let data = $(this).attr("data-rel");
            let necesitaValidacionFecha = await validacionFecha();
            console.log(necesitaValidacionFecha)
            if(necesitaValidacionFecha){
                $('#listaMedicos').empty();
                return;
            }
        }

        let soloDescuento = $('.options-date.active').attr("data-rel");
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }
        // console.log(fechaSeleccionada);
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/medicos/horarios?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent($('.selected-day').attr("fechaSeleccionada-rel"))}&esPlanStar=${esPlanStar}&mostrarDisponibilidad=S&idPaciente=${dataCita.paciente.numeroPaciente}&soloDescuento=${soloDescuento}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        let listaMedicos = $('#listaMedicos');
        listaMedicos.empty();
        let newArrayCard;
        if(codigoMedico != ""){
            newArrayCard = data.data.filter(item => item.codigoMedico === parseInt(codigoMedico))
        }else{
            newArrayCard = data.data;
        }
        console.log(newArrayCard)
        if (data.code == 200){
            let elemento = '';
            if(newArrayCard !== null && newArrayCard.length > 0){
                newArrayCard.forEach((medico) => {
                    let img_doctor = (medico.imagen != null) ? medico.imagen : '{{ asset('assets/img/svg/avatar_doctor.svg') }}';

                    if(dataCita.central && dataCita.central.codigoTipoSucursal == "CAP"){
                        elemento += `<div class="card shadow-none mt-3">
                            <div class="card-body p--2">
                                <div class="row g-2">
                                    <div class="col-3 text-center">
                                        <img src="{{ asset('assets/img/svg/avatar_doctor.svg') }}" class="img-fluid mt-4" alt="doctor" width="48">
                                    </div>
                                    <div class="col-9">
                                        <h6 class="fs--16 line-height-20 fw-medium mb-1">Dr(a) ${capitalizarCadaPalabra(medico.nombreMedico)}</h6>
                                        <p class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${capitalizarCadaPalabra(nombreSucursal)}</p>
                                        <p class="fs--1 line-height-16 fw-normal mb-1" style="color: 33D4E66;">${capitalizarCadaPalabra(nombreEspecialidad)}</p>
                                        <div class="d-flex mb-1">
                                            <p class="fs--1 line-height-16 fw-normal mb-0 me-1" style="color: #9EA7B3;">Disponibilidad:</p>
                                            <p class="fs--1 line-height-16 fw-normal mb-0" style="color: #0055AA;" id="disponibilidad">${medico.disponibilidad}</p>
                                        </div>
                                        <p class="fs--1 line-height-16 fw-normal mb-1" style="color: #9EA7B3;">Horarios: <b class="fw-normal" style="color: #0055AA;" id="horarios">${medico.horario}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end pt-0 pb--2 px--2">
                                <button type="button" class="btn btn-sm btn-primary-veris btn-disponibilidad-medico-all fs--1 line-height-16 fw-medium border-0 m-0 px-3 py-2" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                    Elegir Cita
                                </button>
                            </div>
                        </div>`;
                    }else{
                        let listadoHorarios = ``;
                        let cantidadMaxListado = (medico.intervalos.length >= 3) ? 3 : 1;
                        $.each(medico.intervalos, function(k,v){
                            if(k < cantidadMaxListado){
                                listadoHorarios += drawHorarioMedico(v);
                            }else{
                                return false;
                            }
                        })

                        //${ (dataCita.online == "N") ? `<p class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal) } </p>` : ``}

                        let esMedicoAnterior = (medico.esMedicoAnterior == "S") ? `<div class="badge rounded-3 py-1 px-2 bg-cita-atendida d-flex justify-content-between align-items-center gap-1 ${ (medico.esFavorito == "S") ? `flex-grow-1` : `` } me-2">
                                            <i class="fa-solid fa-clock" style="color:#2F7833;"></i>
                                            <span class="fw-normal fs--2" style="color:#2F7833;">Te atendiste con este doctor</span>
                                        </div>` : ``;
                        
                        let esFavorito = (medico.esFavorito == "S") ? `<div class="badge rounded-3 py-1 px-2 bg-fav-atendida">
                                            <i class="fa-solid fs--2 fa-heart" style="color:#D84315;"></i>
                                        </div>` : ``;

                        elemento += `<div class="border-box-light-blue rounded-3 p--2 mb-3">
                            <div class="header-doctor d-flex justify-content-between align-items-start mb-3">
                                <div class="picture-doctor border-box-light-blue border-3 rounded-circle" style="background: url(${img_doctor}) no-repeat top center;background-size: cover;">
                                </div>
                                <div class="content-doctor ms-2 flex-grow-1">
                                    <div class="name-rate d-flex justify-content-between align-items-start mb-1">
                                        <h6 style="max-width: 200px" class="fs--16 line-height-20 fw-medium flex-grow-1 m-0">${capitalizarCadaPalabra(medico.nombreMedico)}</h6>
                                        <div class="star-box text-center ms-1">
                                            <i class="fa-solid fa-star fw-bold star-ico fs--20 d-block"></i>
                                            <span class="d-block fw-normal fs--3 mt-1 rate-label">5.0</span>
                                        </div>
                                    </div>
                                    ${ (dataCita.online == "N") ? `<p class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${capitalizarCadaPalabra(dataCita.central.nombreSucursal) } </p>` : ``}
                                    <p class="fs--2 line-height-16 fw-normal mb-1" style="color: #425065;">${capitalizarCadaPalabra(nombreEspecialidad)}</p>
                                    <div class="info-adicional-medico d-flex justify-content-between align-items-center">
                                        ${esMedicoAnterior}
                                        ${esFavorito}
                                    </div>
                                </div>
                            </div>
                            <div class="dates-doctor">
                                <p class="fs--1 line-height-16 fw-medium mb-2" style="color:#296BEF;">Horario más próximo:</p>
                                <div class="row g-2" style="max-width:341px">
                                    ${listadoHorarios}
                                    <div class="col-6">
                                        <div class="cursor-pointer waves-effect p--2 px-3 w-100 bg-time-doctor-alt rounded-3 d-flex justify-content-center align-items-center btn-disponibilidad-medico-all" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                            <span class="fs--1 line-height-20 rate-label text-center mb-0">Ver más horarios</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                })
            }else{

                /* Mostrar la modal cuando No hay médicos disponibles. */
                console.log("No hay médicosS disponibles");
                let nohayHorarios = $('#listaMedicos');
                let elementoHorarios = '';
                let str = ($('.options-date.active').attr("data-rel") == "N") ? `No hay médicos disponibles este día.` : `Lo sentimos, no hay horarios con<br>descuento disponibles para este día.`;
                let img = ($('.options-date.active').attr("data-rel") == "N") ? `{{ asset('assets/img/svg/sin_medicos.svg') }}` : `{{ asset('assets/img/svg/sin_horarios.svg') }}`;
                elementoHorarios += `<div class="card bg-transparent shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <p class="fw-medium fs--16 line-height-24 text-veris">${str}</p>
                                                <img src="${img}" class="img-fluid mb-3" alt="">
                                            </div>
                                        </div>
                                    </div>`;
                nohayHorarios.append(elementoHorarios);
                
            }

            listaMedicos.append(elemento);    
        }
        return data;
    }

    function drawHorarioMedico(horario, size = 6, isPopup = false){        
        let aditionalClass = `box-badge-discount-time`;
        let esAuto = ``;
        let elem = ``;
        if(isPopup){
            esAuto = `mx-auto`;
            aditionalClass = `box-badge-discount-time-popup`;
            elem += `<div class="box-badge-discount-time-popup-label position-absolute">
                <span class="badge-discount-time position-absolute fs--2 fw-regular">descuento</span>
            </div>`;
        }

        // if(horario.porcentajeDescuento > 0 && !dataCita.hasOwnProperty('detalleItemPaquete')){
        if(horario.porcentajeDescuento > 0 ){
            return `<div class="col-${size}">
                <div class="cursor-pointer waves-effect btn-disponibilidad-medico p--2 px-3 w-100 bg-time-doctor box-time-doctor-with-discount position-relative rounded-3 d-flex justify-content-end align-items-center" data-horario='${JSON.stringify(horario)}'>
                    <div class="${aditionalClass} position-absolute">
                        <span class="badge-discount-time position-absolute fs--2 fw-medium">-${horario.porcentajeDescuento}%</span>
                    </div>
                    <span class="fs--1 line-height-20 rate-label text-center mb-0 ${esAuto}">${horario.horaInicio} - ${horario.horaFin}</span>
                    ${elem}
                </div>
            </div>`;
        }else{
            return `<div class="col-${size}">
                <div class="cursor-pointer waves-effect btn-disponibilidad-medico p--2 px-3 w-100 bg-time-doctor rounded-3 d-flex justify-content-center align-items-center" data-horario='${JSON.stringify(horario)}'>
                    <span class="fs--1 line-height-20 rate-label text-center mb-0">${horario.horaInicio} - ${horario.horaFin}</span>
                </div>
            </div>`;
        }
    }

    async function consultarDisponibilidadMedico(dataMedico, esPopup = false){
        let medico = JSON.parse(dataMedico);
        let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        let listaHorariosMedico = $('#listaHorariosMedico');
        listaHorariosMedico.empty();
        let bloques = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            bloques = dataCita.tratamiento.cantidadIntervalosReserva
        }

        let argsSesion = '';
        if(dataCita.sesion){
            argsSesion = `&secuenciaPlanTto=${dataCita.sesion.secuenciaPlanTto}&numeroSesion=${dataCita.sesion.numeroSesion}&tiempoSesion=${dataCita.detalleSesion.tiempoSesion}&tipoAtencion=${dataCita.detalleSesion.tipoAtencion}`;
        }
        
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/medicos/disponibilidad?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(fechaSeleccionada)}&filtroIntervalos=SOLO_DISPONIBLES&idMedico=${medico.codigoMedico}&esPlanStar=${esPlanStar}&bloques=${bloques}${argsSesion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(7,data);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                data.data.forEach((horario) => {
                    elemento += drawHorarioMedico(horario,12, esPopup);
                })
            } else {
                elemento += `<div class="card card-horario card-body rounded-3 position-relative py-3 mb-2>
                    <p class="fs--16 line-height-20 text-primary-veris text-center mb-0">${data.message}</p>
                </div>`;
            }
            
            listaHorariosMedico.append(elemento);    
        }

        return data;
    }

    function guardarHorarioEnDataCita(horario) {
        dataCita.horario = horario;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }

    // llenar lista de medicos con examenes
    function llenarListaExamenes(paciente, idElement) {
        let elemento = '';

        // Limitar la lista de exámenes a mostrar inicialmente
        const examenesLimitados = paciente.examenes.slice(0, 3);
        const mostrarVerTodo = paciente.examenes.length > 3;

        // Construir el contenido inicial de la lista, separando el nombre del paciente
        elemento += `
            <div class="card-body p-2">
                <div class="examenLista">
                    <h6 class="fw-medium mb-0">${paciente.nombrePacienteOrden}</h6>
                    <div class="listaExamenes">
                        ${examenesLimitados.map(examen => `
                            <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                        `).join('')}
                        ${mostrarVerTodo ? '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo" paciente-rel="'+paciente.numeroIdentificacion+'">Ver todo</p>' : ''}
                    </div>
                </div>
            </div>
        `;

        $(idElement).append(elemento);

        // Delegar el evento clic desde el elemento #listaMedicos para manejar "Ver todo" y "Ver menos"
        $('#listaMedicos').off('click', '.ver-todo').on('click', '.ver-todo', function() {
            const isExpanded = $(this).hasClass('expanded');
            $(this).toggleClass('expanded');

            if (!isExpanded) {
                // Mostrar todos los exámenes
                const fullExamenesList = examenes.map(examen => `
                    <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                `).join('');
                $(this).closest('.examenLista').find('.listaExamenes').html(fullExamenesList + '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo expanded">Ver menos</p>');
            } else {
                // Volver a mostrar solo los exámenes limitados
                const limitedExamenesList = examenesLimitados.map(examen => `
                    <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                `).join('');
                $(this).closest('.examenLista').find('.listaExamenes').html(limitedExamenesList + '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo">Ver todo</p>');
            }
        });
    }

    async function obtenerPreparacionPrevia(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/domicilio/laboratorio/preparacionPrevia?canalOrigen=${_canalOrigen}&codigoSolicitud=${ dataCita.ordenExterna.codigoSolicitud }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            //dataCita.facturacion = data.data;
            //mostrarInfo();
        }
    }

    function getWeekCurrent(){
        var onejan = new Date(currentDate.getFullYear(),0,1);
        var millisecsInDay = 86400000;
        return Math.ceil((((currentDate - onejan) /millisecsInDay) + onejan.getDay()+1)/7);
    }

    function getWeek(dateString) {
        var parts = dateString.split('/');
    
        // Asegurarse de que hay 3 partes (día, mes, año)
        if (parts.length !== 3) {
            throw new Error("Formato de fecha incorrecto. Debe ser dd/mm/yyyy");
        }
        
        // Convertir las partes en números enteros
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1; // Restar 1 al mes porque en JavaScript los meses van de 0 a 11
        var year = parseInt(parts[2], 10);
        
        // Crear y devolver el objeto Date
        let date = new Date(year, month, day);
        var onejan = new Date(date.getFullYear(),0,1);
        var millisecsInDay = 86400000;
        return Math.ceil((((date - onejan) /millisecsInDay) + onejan.getDay()+1)/7);
    }

    // consultar horas de motorizados
    async function consultarHorasMotorizados() {
        //let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/domicilio/laboratorio/disponibilidad?canalOrigen=${_canalOrigen}&codigoSolicitud=${codigoSolicitud}&latitud=${latitud}&longitud=${longitud}&fecha=${$('.selected-day').attr("fechaSeleccionada-rel")}&codigoZona=${codigoZona}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        const data = await call(args);
        console.log('consultarHorasMotorizados', data);
        
        if (data.code == 200){
            let elemento = '';
            let listaHorariosMedico = $('#listaHorariosMedico');
            listaHorariosMedico.empty();
            if(data.data.length > 0){
                data.data[0].horario.forEach((horario) => {
                    console.log("si hay fechas disponibles");
                    let params = {};
                    //params.medico = medico;
                    dataCita.horario = horario;
                    let urlParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    let ruta = "/confirmacion-cita/" + "{{ $params }}";
                    elemento += `<a href="${ruta}">
                        <div class="card card-horario card-body rounded-3 position-relative py-3 mb-2 btn-disponibilidad-medico" data-horario='${JSON.stringify(horario)}'>`;
                    
                    elemento += `<p class="fs--16 line-height-20 text-primary-veris text-center mb-0">${horario.rangoAtencion}</p>`;
                    
                    elemento += `</div>
                        </a>`;
                })
                // abrir modal de horarios
                $('#elegirHorarioModal').modal('show');
            } else {
                console.log("No hay fechas disponibles");
            }
            
            listaHorariosMedico.append(elemento);    
        } else if (data.code != 200){
            $('#mensajeError').html(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
        return data;
    }

    // guardarHorarioEnDataCitaExterna 
    function guardarHorarioEnDataCitaExterna(horario) {
        let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        dataCita.horario = horario;
        dataCita.fecha = fechaSeleccionada;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }

</script>
<style>
.examenLista {
    /*width: Hug (343px);
    height: Hug (124px);*/
    width: 343px;
    height: 124px;
    padding: 12px;
    border-radius: 8px;
    gap: 8px;
    box-shadow: 0px 4px 8px 0px #0000001A;
    border: 1px solid #E7E9EC;
    
}
.calendar-container {
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-height: 66px;
}
.calendar-content {
    text-align: center;
    flex-grow: 1;
}
.week-container {
    display: flex;
    gap: 0.25rem;
    overflow: hidden;
}
.day {
    border: 1px solid #E7E9EC;
    background-color: white;
    color: #13243F;
    border-radius: 8px;
/*    padding: 0.5rem;*/
    text-align: center;
    width: 40px;
    cursor: pointer;
    position: relative;
}
.day.selected-day {
    background-color: #0071CE;
    color: #fff;
    /*font-weight: bold;*/
}
.today-label {
  position: absolute;
  top: -1rem; /* Ajusta el espacio para que se muestre encima */
  left: 50%;
  transform: translateX(-50%);
  color: #fff; /* Color amarillo para destacar */
  font-family: var(--font) !important;
}
.arrow {
    color: white;
    font-size: 1.25rem;
    text-align: center;
    width: 24px;
    height: 24px;
    cursor: pointer;
}
#pills-tab .active .badge-icon-selected path{
    fill: #fff !important;
}
.picture-doctor{
    width: 88px;
    height: 88px;
}
.star-ico{
    color: #FFC107;
}
.rate-label{
    color: #13243F;
}
.bg-cita-atendida{
    background: #B9F6CA;
}
.bg-fav-atendida{
    background: #FBE9E7;
}
.bg-time-doctor{
    background: #EAF0FD;
}
.bg-time-doctor-alt{
    background: #A9C4F9;
}
.box-badge-discount-time {
    top: 0px;
    left: 0px;
    height: 100%;
    width: 44px;
    background: #FFE5EF;
    border-radius: 0px 0px 32px 0px;
}
.badge-discount-time {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 20px;
    width: 44px;
    margin: auto;
    text-align: center;
    color: #EF2E79;
}
.box-badge-discount-time-popup {
    top: 0px;
    left: 0px;
    height: 25px;
    width: 60px;
    background: #FFE5EF;
    border-radius: 0px 0px 32px 0px;
}
.box-badge-discount-time-popup-label {
    bottom: 0px;
    right: 0px;
    height: 25px;
    width: 90px;
    background: #FFE5EF;
    border-radius: 32px 0px 0px 0px;
}
</style>
@endpush