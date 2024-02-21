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
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-2">
                    <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3">Veris</h1>
                    <p class="fs--16 fw-normal mb-3" id="mensajeError" ></p>
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
                    <div id="listaHorariosMedico">
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
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                    <div class="text-center">
                        <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3" id="sinFechaDisponiblesLabel">Veris</h1>
                        <p class="fs--16 fw-normal mb-3">No tiene fechas disponibles.</p>
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
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3 pb-2">
                    <div class="text-center">
                        <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3" id="sinMedicosDisponiblesLabel">Veris</h1>
                        <p class="fs--16 fw-normal mb-3">No tiene médicos disponibles.</p>
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
    <section class="p-3 mb-3">
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
        codigoServicio = dataCita?.especialidad.codigoServicio || ' ';
        codigoPrestacion = dataCita?.especialidad.codigoPrestacion || ' ';
        nombreSucursal = dataCita?.central?.nombreSucursal || ' ';
        nombreEspecialidad = dataCita?.especialidad.nombre || ' ';
    }
    
    let _fechaSeleccionada;
    const daysOfWeek = ["D", "L", "M", "M", "J", "V", "S"];
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const calendarGrid = document.getElementById('calendar-grid');
    const monthYearElement = document.getElementById('month-year');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentDate = new Date();
    let fechasDisponibles = []; // Variable global para almacenar las fechas disponibles

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        if (dataCita.origen == 'ordenExternaSolicitud') {
            renderCalendarExterna();
            llenarListaExamenes();
            // setear titulo fecha doctor
            document.getElementById('tituloFechaDoctor').innerHTML = 'Exámenes';
        } else {
            await consultarFechasDisponibles();
        }
        $('body').on('click','.btn-disponibilidad-medico', function(){
            let data = $(this).attr("data-rel");
            consultarDisponibilidadMedico(data);
        })
        // Listener para seleccionar un horario
        $('body').on('click', '.card-horario', function () {
            let horario = $(this).data('horario');
            guardarHorarioEnDataCita(horario);
        });

        // btnEntiendoError redirecciona a la página inicial
        $('#btnEntiendoError').click(function(){
            if(!dataCita.ordenExterna){
                window.location.href = "{{ route('home') }}";
            }
        });
    });

    function renderCalendar() {
        console.log('Lista de fecha: ' + fechasDisponibles); 

        calendarGrid.innerHTML = '';
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const lastDayOfPreviousMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
        const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        monthYearElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        // Agregar los días de la semana en el encabezado
        for (let i = 0; i < daysOfWeek.length; i++) {
            const dayOfWeekElement = document.createElement('div');
            dayOfWeekElement.classList.add('calendar-day', 'day-of-week', 'header');
            dayOfWeekElement.textContent = daysOfWeek[i];
            calendarGrid.appendChild(dayOfWeekElement);
        }

        // Llenar los días del mes anterior
        for (let i = firstDayOfMonth - 1; i >= 0; i--) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day', 'previous-month-day');
            dayElement.textContent = lastDayOfPreviousMonth - i;
            calendarGrid.appendChild(dayElement);
        }

        // Llenar los días del mes actual
        for (let i = 1; i <= lastDayOfMonth; i++) {
            const dayElement = document.createElement('div');
            let dia = (i < 10) ? '0' + i : i;
            let mes = ((currentDate.getMonth() + 1) < 10) ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1);
            let fechaSeleccionada = dia +"/"+ mes +"/"+currentDate.getFullYear();
            let classFechaSeleccionada = dia +"_"+ mes +"_"+currentDate.getFullYear();
            dayElement.classList.add('calendar-day', 'current-month-day', classFechaSeleccionada);
            dayElement.textContent = i;
            dayElement.setAttribute('fechaSeleccionada-rel', fechaSeleccionada);

            if (fechasDisponibles.length > 0 && fechaSeleccionada === fechasDisponibles[0]) {
                // Agregar la clase 'selected-day' a la primera fecha disponible
                dayElement.classList.add('selected-day');
            }
            
            if (fechasDisponibles.includes(fechaSeleccionada)) {
                // Habilitar solo para fechas disponibles
                dayElement.addEventListener('click', async () => {
                    console.log(0)
                    if(!$('.' + classFechaSeleccionada).hasClass('unavailable-day')){
                        console.log(1)
                        console.log(fechaSeleccionada)
                        _fechaSeleccionada = fechaSeleccionada;
                        console.log('_fechaSeleccionada: ' + _fechaSeleccionada);
                        console.log('fechaSeleccionada: ' + fechaSeleccionada);
                        $('.calendar-day').removeClass('selected-day');
                        $('.' + classFechaSeleccionada).addClass('selected-day');
                        // Aquí puedes hacer algo con la fecha seleccionada, como enviarla al servidor para la cita médica.
                        await consultarMedicos(fechaSeleccionada);
                        calendarContainer.style.maxHeight = '135px';
                        chevronIcon.className = 'bi bi-chevron-compact-down';
                    }
                });
            } else {
                // Deshabilitar para fechas no disponibles
                dayElement.classList.add('unavailable-day');
            }

            calendarGrid.appendChild(dayElement);
        }
    }

    prevBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    const calendarContainer = document.querySelector('.calendar-container');
    const toggleCalendarBtn = document.getElementById('toggle-calendar-btn');
    const chevronIcon = document.querySelector('#toggle-calendar-btn i');

    toggleCalendarBtn.addEventListener('click', () => {
        if (calendarContainer.style.maxHeight) {
            calendarContainer.style.maxHeight = null;
            chevronIcon.className = 'bi bi-chevron-compact-up';
        } else {
            calendarContainer.style.maxHeight = '135px';
            chevronIcon.className = 'bi bi-chevron-compact-down';
        }
    });

    async function consultarFechasDisponibles(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }
        
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/fechasdisponibles?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&idMedico=${codigoMedico}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            fechasDisponibles = data.data; // Almacenar las fechas disponibles en la variable global
            let elemento = '';

            if(data.data.length > 0){
                renderCalendar();
                await consultarMedicos(fechasDisponibles[0]);
            } else {
                renderCalendar();
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

    async function consultarMedicos(fechaSeleccionada){
        console.log(fechaSeleccionada);
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/medicos/horarios?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(fechaSeleccionada)}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        let listaMedicos = $('#listaMedicos');
        listaMedicos.empty();

        if (data.code == 200){
            let elemento = '';
            if(data.data.length > 0){
                data.data.forEach((medico) => {
                    elemento += `<div class="card shadow-none mb-3">
                        <div class="card-body p--2">
                            <div class="row g-2">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('assets/img/svg/avatar_doctor.svg') }}" class="img-fluid mt-4" alt="doctor" width="48">
                                </div>
                                <div class="col-9">
                                    <h6 class="fs--16 line-height-20 fw-medium mb-1">Dr(a) ${capitalizarCadaPalabra(medico.nombreMedico)}</h6>
                                    <p class="text-primary-veris fs--1 line-height-16 fw-medium mb-1">${nombreSucursal}</p>
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
                            <button type="button" class="btn btn-sm btn-primary-veris btn-disponibilidad-medico fs--1 line-height-16 fw-medium border-0 m-0 px-3 py-2" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                Elegir Cita
                            </button>
                        </div>
                    </div>`;
                })
            }else{

                /* Mostrar la modal cuando No hay médicos disponibles. */
                console.log("No hay médicosS disponibles");
                let nohayHorarios = $('#listaMedicos');
                let elementoHorarios = '';
                elementoHorarios += `<div class="card bg-transparent shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                                
                                                <p class="fs--1">No hay disponibilidad para el dia ${fechaSeleccionada}, intenta buscar con otra fecha.</p>
                                            </div>
                                        </div>
                                    </div>`;
                nohayHorarios.append(elementoHorarios);
                
            }

            listaMedicos.append(elemento);    
        }
        return data;
    }

    async function consultarDisponibilidadMedico(dataMedico){
        let medico = JSON.parse(dataMedico);
        let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        let listaHorariosMedico = $('#listaHorariosMedico');
        listaHorariosMedico.empty();
        let bloques = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            bloques = dataCita.tratamiento.cantidadIntervalosReserva
        }
        
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/medicos/disponibilidad?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(fechaSeleccionada)}&filtroIntervalos=SOLO_DISPONIBLES&idMedico=${medico.codigoMedico}&bloques=${bloques}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(7,data);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                data.data.forEach((horario) => {
                    let params = {};
                    //params.medico = medico;
                    dataCita.horario = horario;
                    let urlParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    let ruta = "/citas-revisa-tus-datos/" + "{{ $params }}";
                    elemento += `<div class="card card-horario card-body rounded-3 position-relative py-3 mb-2 btn-disponibilidad-medico
                    " data-horario='${JSON.stringify(horario)}'>
                    <a href="${ruta}">`;
                    if(horario.porcentajeDescuento > 0){
                        elemento += `<div class="badge-discount-top fs--2 line-height-16 fw-medium"><span>-${horario.porcentajeDescuento}%</span></div>`
                    }
                    elemento += `<p class="fs--16 line-height-20 text-primary-veris text-center mb-0">${horario.horaInicio} - ${horario.horaFin}</p>`;
                    if(horario.porcentajeDescuento > 0){
                        elemento += `<div class="badge-discount-bottom fs--2 line-height-16 fw-medium"><span>{{ __('descuento') }}</span></div>`;
                    }
                    elemento += `</a>
                        </div>`;
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

    // calendario para consultas externas
    // funcion que muestra el calendario para consultas externas  de los 30 dias posteriores a la fecha actual
    function renderCalendarExterna() {
        calendarGrid.innerHTML = '';
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const lastDayOfPreviousMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
        const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        monthYearElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        // Agregar los días de la semana en el encabezado
        for (let i = 0; i < daysOfWeek.length; i++) {
            const dayOfWeekElement = document.createElement('div');
            dayOfWeekElement.classList.add('calendar-day', 'day-of-week');
            dayOfWeekElement.textContent = daysOfWeek[i];
            calendarGrid.appendChild(dayOfWeekElement);
        }

        // Llenar los días del mes anterior
        for (let i = firstDayOfMonth - 1; i >= 0; i--) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day', 'previous-month-day');
            dayElement.textContent = lastDayOfPreviousMonth - i;
            calendarGrid.appendChild(dayElement);
        }

        // Llenar los días del mes actual
        for (let i = 1; i <= lastDayOfMonth; i++) {
            const dayElement = document.createElement('div');
            let dia = (i < 10) ? '0' + i : i;
            let mes = ((currentDate.getMonth() + 1) < 10) ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1);
            let fechaSeleccionada = dia +"/"+ mes +"/"+currentDate.getFullYear();
            let classFechaSeleccionada = dia +"_"+ mes +"_"+currentDate.getFullYear();
            dayElement.classList.add('calendar-day', 'current-month-day', classFechaSeleccionada);
            dayElement.textContent = i;
            dayElement.setAttribute('fechaSeleccionada-rel', fechaSeleccionada);
            dayElement.addEventListener('click', async () => {
                _fechaSeleccionada = fechaSeleccionada;
                $('.calendar-day').removeClass('selected-day');
                $('.' + classFechaSeleccionada).addClass('selected-day');
                // captura la fecha seleccionada
                renderCalendarExternaFecha = fechaSeleccionada;
                console.log('renderCalendarExternaFecha: ' + renderCalendarExternaFecha);
                fechaOrdenExterna = renderCalendarExternaFecha;
               
            });
            calendarGrid.appendChild(dayElement);
        }
    }

    // llenar lista de medicos con examenes

    function llenarListaExamenes() {
        // habilitar el botón de agendar orden externa
        $('#btnAgendarOrdenExterna').removeClass('d-none');
        let listaMedicos = $('#listaMedicos');
        listaMedicos.empty(); // Vaciar la lista actual para evitar duplicados
        let elemento = '';

        // Limitar la lista de exámenes a mostrar inicialmente
        const examenesLimitados = examenes.slice(0, 3);
        const mostrarVerTodo = examenes.length > 3;

        // Construir el contenido inicial de la lista, separando el nombre del paciente
        elemento += `
            <div class="card-body p-2">
                <div class="examenLista">
                    <h6 class="fw-medium mb-0">${pacienteExternaSolicitud.nombrePaciente}</h6>
                    <div class="listaExamenes">
                        ${examenesLimitados.map(examen => `
                            <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                        `).join('')}
                        ${mostrarVerTodo ? '<p class="fw-small fs--2 mb-0 text-primary text-decoration-underline cursor-pointer ver-todo">Ver todo</p>' : ''}
                    </div>
                </div>
            </div>
        `;

        listaMedicos.append(elemento);

        // Delegar el evento clic desde el elemento #listaMedicos para manejar "Ver todo" y "Ver menos"
        $('#listaMedicos').off('click', '.ver-todo').on('click', '.ver-todo', function() {
            const isExpanded = $(this).hasClass('expanded');
            $(this).toggleClass('expanded');

            if (!isExpanded) {
                // Mostrar todos los exámenes
                const fullExamenesList = examenes.map(examen => `
                    <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                `).join('');
                $(this).closest('.examenLista').find('.listaExamenes').html(fullExamenesList + '<p class="fw-small fs--2 mb-0 text-primary text-decoration-underline cursor-pointer ver-todo expanded">Ver menos</p>');
            } else {
                // Volver a mostrar solo los exámenes limitados
                const limitedExamenesList = examenesLimitados.map(examen => `
                    <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                `).join('');
                $(this).closest('.examenLista').find('.listaExamenes').html(limitedExamenesList + '<p class="fw-small fs--2 mb-0 ver-todo">Ver todo</p>');
            }
        });
    }



    // consultar horas de motorizados
    async function consultarHorasMotorizados() {
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/domicilio/laboratorio/disponibilidad?canalOrigen=APP_CMV&codigoSolicitud=${codigoSolicitud}&latitud=${latitud}&longitud=${longitud}&fecha=${fechaOrdenExterna}&codigoZona=${codigoZona}`;
        args["method"] = "GET";
        args["showLoader"] = true;
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
                    elemento += `<div class="card card-horario card-body rounded-3 position-relative py-2 mb-2 btn-disponibilidad-motorizado
                    " data-horario='${JSON.stringify(horario)}'>
                    <a href="${ruta}">`;
                    
                    elemento += `<p class="fs--2 text-primary-veris text-center my-1">${horario.rangoAtencion}</p>`;
                    
                    elemento += `</a>
                        </div>`;
                })
                // abrir modal de horarios
                $('#elegirHorarioModal').modal('show');
            } else {
                console.log("No hay fechas disponibles");
            }
            
            listaHorariosMedico.append(elemento);    
        } else if (data.code != 200){
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
        return data;
    }
    

    // btnAgendarServicioOrdenExterna llama a la función consultarHorasMotorizados  
    $('#btnAgendarServicioOrdenExterna').click(async function(){
        let data = await consultarHorasMotorizados();        
    });

    // btn-disponibilidad-motorizado setea el horario seleccionado en dataCita
    $('body').on('click', '.btn-disponibilidad-motorizado', function () {
        let horario = $(this).data('horario');
        guardarHorarioEnDataCitaExterna(horario);
    });

    // guardarHorarioEnDataCitaExterna 
    function guardarHorarioEnDataCitaExterna(horario) {
        dataCita.horario = horario;
        dataCita.fecha = fechaOrdenExterna;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }


    



                            








</script>
<style>
    .examenLista {
        width: Hug (343px);
        height: Hug (124px);
        padding: 12px;
        border-radius: 8px;
        gap: 8px;
        box-shadow: 0px 4px 8px 0px #0000001A;
        border: 1px solid #E7E9EC;
        
    }
</style>
@endpush