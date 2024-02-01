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
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3 pb-2">Veris</h1>
                    <p class="fs--1 fw-normal" id="mensajeError" >
                </p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal" id="btnEntiendoError"
                    >Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal position-absolute -->
    <div class="modal bg-transparent fade" id="elegirHorarioModal" tabindex="-1" aria-labelledby="elegirHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content"> <!-- style="max-height: 300px;" -->
                <div class="modal-body pb-0">
                    <h6 class="text-center fw-bold mb-2">{{ __('Horarios') }}:</h6>
                    <div id="listaHorariosMedico">
                        {{-- <div class="card card-body rounded-3 position-relative py-2 mb-2">
                            <a href="{{route('citas.detalleCita')}}">
                                <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                                <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                                <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0 py-1">
                    <button type="button" class="btn btn-sm w-100 text-primary-veris fw-bold shadow-none" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal NO HAY FECHA DISPONIBLES -->
    <div class="modal fade" id="sinFechaDisponibles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sinFechaDisponiblesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 mb-3" id="sinFechaDisponiblesLabel">Veris</h1>
                        <p class="mb-0">No tiene fechas disponibles.</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center p-2 pt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-primary-veris m-0 w-100">Aceptar</a>
                </div>
            </div>
        </div>
    </div>

    <! -- modal no hay medicos disponibles -->
    <div class="modal fade" id="sinMedicosDisponibles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sinMedicosDisponiblesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 mb-3" id="sinMedicosDisponiblesLabel">Veris</h1>
                        <p class="mb-0">No tiene médicos disponibles.</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center p-2 pt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-primary-veris m-0 w-100">Aceptar</a>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elige fecha y doctor') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto" style="min-width: 375px;">
                <div class="card card-fecha-foctor position-relative">
                    <div class="card-body p-0">
                        <div class="calendar-body position-relative">
                            <div class="calendar-container w-auto" style="max-height: 135px;">
                                <div class="calendar-header">
                                    <button class="btn btn-sm px-0 shadow-none prev-btn"><i class="bi bi-chevron-left fs--1 text-white"></i></button>
                                    <h6 class="text-white fw-normal fs--1 mx-3 mb-0" id="month-year"></h6>
                                    <button class="btn btn-sm px-0 shadow-none next-btn"><i class="bi bi-chevron-right fs--1 text-white"></i></button>
                                </div>
                                <div class="calendar-grid" id="calendar-grid"></div>
                            </div>
                            <button class="btn btn-sm shadow-none text-white fs-2 fw-bold w-100" id="toggle-calendar-btn"><i class="bi bi-chevron-compact-down"></i></button>
                        </div>
                        <div class="card shadow-none border-24" style="background: var(--neutral-05, #F3F4F5);">
                            <div class="card-header border-bottom py-2">
                                Resultados
                            </div>
                            <div class="card-body p-3">
                                <div class="col-auto overflow-auto" id="listaMedicos" style="max-height: 433px;">
                                    {{-- <div class="card shadow-none mb-3">
                                        <div class="card-body p-2">
                                            <div class="row g-2">
                                                <div class="col-3 text-center">
                                                    <img src="{{ asset('assets/img/svg/avatar_doctor.svg') }}" class="img-fluid mt-4" alt="doctor" width="48">
                                                </div>
                                                <div class="col-9">
                                                    <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                                    <p class="text-primary-veris fw-bold fs--2 mb-0">Veris - Alborada</p>
                                                    <p class="fs--2 mb-0">Cardiología</p>
                                                    <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">Do/Lu/Ma/Mi/Ju/Vi/Sa</b></p>
                                                    <p class="fs--2 mb-0">Horarios: <b class="fw-normal text-primary-veris" id="horarios">08h00 - 12h00</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end p-2">
                                            <button type="button" class="btn btn-sm btn-primary-veris" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal">
                                                Elegir Cita
                                            </button>
                                        </div>
                                    </div> --}}
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
    let online = dataCita?.online;
    let codigoEspecialidad = dataCita?.especialidad.codigoEspecialidad;

    let codigoSucursal;
    if(dataOrigen == 'central'){
        codigoSucursal = dataCita?.central.codigoSucursal;
    }else if (dataOrigen == 'doctorFavorito'){
        codigoSucursal = dataCita?.especialidad.codigoSucursal;
    } else {
        codigoSucursal = ""
    }
    let codigoServicio = dataCita?.especialidad.codigoServicio || ' ';
    let codigoPrestacion = dataCita?.especialidad.codigoPrestacion || ' ';
    let nombreSucursal = dataCita?.central?.nombreSucursal || ' ';
    let nombreEspecialidad = dataCita?.especialidad.nombre || ' ';
    


    let _fechaSeleccionada;
    const daysOfWeek = ["D", "L", "M", "M", "J", "V", "S"];
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const calendarGrid = document.getElementById('calendar-grid');
    const monthYearElement = document.getElementById('month-year');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentDate = new Date();
    let fechasDisponibles = []; // Variable global para almacenar las fechas disponibles

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

            if (fechasDisponibles.length > 0 && fechaSeleccionada === fechasDisponibles[0]) {
                // Agregar la clase 'selected-day' a la primera fecha disponible
                dayElement.classList.add('selected-day');
            }
            
            if (fechasDisponibles.includes(fechaSeleccionada)) {
                // Habilitar solo para fechas disponibles
                dayElement.addEventListener('click', async () => {
                    _fechaSeleccionada = fechaSeleccionada;
                    console.log('_fechaSeleccionada: ' + _fechaSeleccionada);
                    console.log('fechaSeleccionada: ' + fechaSeleccionada);
                    $('.calendar-day').removeClass('selected-day');
                    $('.' + classFechaSeleccionada).addClass('selected-day');
                    // Aquí puedes hacer algo con la fecha seleccionada, como enviarla al servidor para la cita médica.
                    await consultarMedicos(fechaSeleccionada);
                    calendarContainer.style.maxHeight = '135px';
                    chevronIcon.className = 'bi bi-chevron-compact-down';
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

    document.addEventListener("DOMContentLoaded", async function () {
        await consultarFechasDisponibles();

        $('body').on('click','.btn-disponibilidad-medico', function(){
            let data = $(this).attr("data-rel");
            consultarDisponibilidadMedico(data);
        })
        // Listener para seleccionar un horario
        $('body').on('click', '.card-horario', function () {
            let horario = $(this).data('horario');
            guardarHorarioEnDataCita(horario);
        });
    });

    async function consultarFechasDisponibles(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/fechasdisponibles?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}`;
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
                        <div class="card-body p-2">
                            <div class="row g-2">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('assets/img/svg/avatar_doctor.svg') }}" class="img-fluid mt-4" alt="doctor" width="48">
                                </div>
                                <div class="col-9">
                                    <h6 class="fw-bold mb-0">Dr(a) ${medico.nombreMedico}</h6>
                                    <p class="text-primary-veris fw-bold fs--2 mb-0">${nombreSucursal}</p>
                                    <p class="fs--2 mb-0">${nombreEspecialidad}</p>
                                    <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">${medico.disponibilidad}</b></p>
                                    <p class="fs--2 mb-0">Horarios: <b class="fw-normal text-primary-veris" id="horarios">${medico.horario}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end p-2">
                            <button type="button" class="btn btn-sm btn-primary-veris btn-disponibilidad-medico" data-bs-toggle="modal" data-bs-target="#elegirHorarioModal" data-rel='${JSON.stringify(medico)}'>
                                Elegir Cita
                            </button>
                        </div>
                    </div>`;
                })
            }else{
                $('#sinMedicosDisponibles').modal('show');
                /* Mostrar la modal cuando No hay médicos disponibles. */
                console.log("No hay médicos disponibles");
                
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
        
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/medicos/disponibilidad?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(fechaSeleccionada)}&filtroIntervalos=SOLO_DISPONIBLES&idMedico=${medico.codigoMedico}`;
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
                    elemento += `<div class="card card-horario card-body rounded-3 position-relative py-2 mb-2 btn-disponibilidad-medico
                    " data-horario='${JSON.stringify(horario)}'>
                    <a href="${ruta}">`;
                    if(horario.porcentajeDescuento > 0){
                        elemento += `<div class="badge-discount-top fs--3 fw-bold"><span>-${horario.porcentajeDescuento}%</span></div>`
                    }
                    elemento += `<p class="fs--2 text-primary-veris text-center my-1">${horario.horaInicio} - ${horario.horaFin}</p>`;
                    if(horario.porcentajeDescuento > 0){
                        elemento += `<div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>`;
                    }
                    elemento += `</a>
                        </div>`;
                })
            } else {
                console.log("No hay fechas disponibles");
            }
            
            listaHorariosMedico.append(elemento);    
        }

        return data;
    }

    function guardarHorarioEnDataCita(horario) {
        dataCita.horario = horario;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
    }


    // btnEntiendoError redirecciona a la página inicial
    $('#btnEntiendoError').click(function(){
        window.location.href = "{{ route('home') }}";
    });

</script>
@endpush