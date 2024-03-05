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
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
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
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
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
    numeroSemanaCurso = getWeekCurrent(currentDate);
    numeroMesCurso = currentDate.getMonth() + 1;
    numeroMesSeleccionado = numeroMesCurso;
    let fechasDisponibles = []; // Variable global para almacenar las fechas disponibles

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        if (dataCita.origen == 'ordenExternaSolicitud') {
            //renderCalendarExterna();
            fechasDisponibles = await obtenerFechasOrdenesExternas();
            await renderCalendar();
            reDrawCalendar();
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
            reDrawCalendar();
        }

        $('body').on('click','.btn-disponibilidad-medico-all', function(){
            let data = $(this).attr("data-rel")
            consultarDisponibilidadMedico(data);
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

    async function validacionFecha(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validacionFecha`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "fechaSeleccionada": _fechaSeleccionada
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

    async function renderCalendar() {
        // console.log('Lista de fecha: ' + fechasDisponibles); 
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
            let dia = lastDayOfPreviousMonth - i;
            let mes = ((currentDate.getMonth()) < 10) ? '0' + (currentDate.getMonth()) : (currentDate.getMonth() );
            let fechaSeleccionada = dia +"/"+ mes +"/"+currentDate.getFullYear();
            console.log(fechaSeleccionada)
            let weekNumber = getWeek(fechaSeleccionada);
            
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day', 'previous-month-day', 'dias-calendario', 'semana-'+weekNumber);
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
            // console.log(fechaSeleccionada)
            let weekNumber = getWeek(fechaSeleccionada);
            dayElement.classList.add('calendar-day', 'dias-calendario', 'current-month-day', 'semana-'+weekNumber, classFechaSeleccionada);
            dayElement.textContent = i;
            dayElement.setAttribute('fechaSeleccionada-rel', fechaSeleccionada);

            if (fechasDisponibles.length > 0 && fechaSeleccionada === fechasDisponibles[0] && firstRender) {
                // Agregar la clase 'selected-day' a la primera fecha disponible
                firstRender = false;
                dayElement.classList.add('selected-day');
                _fechaSeleccionada = fechasDisponibles[0];
            }else{
                $('[fechaseleccionada-rel="' + _fechaSeleccionada + '"]').addClass('selected-day');
            }
            
            if (fechasDisponibles.includes(fechaSeleccionada)) {
                // Habilitar solo para fechas disponibles
                dayElement.addEventListener('click', async () => {
                    if(!$('.' + classFechaSeleccionada).hasClass('unavailable-day')){
                        // console.log(fechaSeleccionada)
                        _fechaSeleccionada = fechaSeleccionada;
                        // console.log('_fechaSeleccionada: ' + _fechaSeleccionada);
                        // console.log('fechaSeleccionada: ' + fechaSeleccionada);
                        $('.calendar-day').removeClass('selected-day');
                        $('.' + classFechaSeleccionada).addClass('selected-day');
                        // Aquí puedes hacer algo con la fecha seleccionada, como enviarla al servidor para la cita médica.
                        if (!dataCita.origen || dataCita.origen != 'ordenExternaSolicitud'){
                            await consultarMedicos(fechaSeleccionada);
                        }
                        calendarContainer.style.maxHeight = '135px';
                        chevronIcon.className = 'bi bi-chevron-compact-down';
                        reDrawCalendar();
                    }
                });
            } else {
                // Deshabilitar para fechas no disponibles
                dayElement.classList.add('unavailable-day', 'dias-calendario');
            }

            calendarGrid.appendChild(dayElement);
        }
    }

    prevBtn.addEventListener('click', async () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        numeroMesSeleccionado = currentDate.getMonth() + 1;
        await renderCalendar();
        reDrawCalendar();
    });

    nextBtn.addEventListener('click', async () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        numeroMesSeleccionado = currentDate.getMonth() + 1;
        await renderCalendar();
        reDrawCalendar();
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
        reDrawCalendar();
    });

    function reDrawCalendar(){
        let numeroMesFechaSeleccionada = obtenerNumeroMes(_fechaSeleccionada);
        if(calendarContainer.style.maxHeight){
            console.log("Calendario cerrado")
            if(numeroMesFechaSeleccionada == numeroMesSeleccionado){
                let numeroSemanaActual = getWeek(_fechaSeleccionada);
                $('.dias-calendario').addClass('d-none');
                $('.semana-'+numeroSemanaActual).removeClass('d-none');
            }else{
                $('.dias-calendario').removeClass('d-none');
            }
        }else{
            console.log("Calendario abierto")
            $('.dias-calendario').removeClass('d-none');
        }
    }

    function obtenerNumeroMes(fechaString) {
        console.log(fechaString)
        // Dividir la cadena en partes
        var partes = fechaString.split('/');
        
        // Asegurarse de que hay 3 partes (día, mes, año)
        if (partes.length !== 3) {
            throw new Error("Formato de fecha incorrecto. Debe ser dd/mm/yyyy");
        }
        
        // Obtener el mes como un número
        var mes = parseInt(partes[1], 10);
        
        // Devolver el número del mes
        return mes;
    }

    async function consultarFechasDisponibles(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        let codigoMedico = "";
        if(dataCita.codigoMedicoFavorito){
            codigoMedico = dataCita.codigoMedicoFavorito
        }
        
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/fechasdisponibles?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&idMedico=${codigoMedico}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            fechasDisponibles = data.data; // Almacenar las fechas disponibles en la variable global
            let elemento = '';

            if(data.data.length > 0){
                _fechaSeleccionada = fechasDisponibles[0];
                await renderCalendar();
                $('.dias-calendario').addClass('d-none');
                $('.semana-'+numeroSemanaCurso).removeClass('d-none');
                await consultarMedicos(fechasDisponibles[0]);
            } else {
                await renderCalendar();
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

    async function consultarMedicos(fechaSeleccionada){
        if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
            let data = $(this).attr("data-rel");
            let necesitaValidacionFecha = await validacionFecha();
            console.log(necesitaValidacionFecha)
            if(necesitaValidacionFecha){
                $('#listaMedicos').empty();
                return;
            }
        }

        // console.log(fechaSeleccionada);
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/medicos/horarios?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(fechaSeleccionada)}`;
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
                                                <p class="fs--1 text-veris">No hay disponibilidad para el dia ${fechaSeleccionada}, intenta buscar con otra fecha.</p>
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
        //let fechaSeleccionada = $('.selected-day').attr('fechaSeleccionada-rel');
        let listaHorariosMedico = $('#listaHorariosMedico');
        listaHorariosMedico.empty();
        let bloques = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            bloques = dataCita.tratamiento.cantidadIntervalosReserva
        }
        
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/medicos/disponibilidad?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&codigoEspecialidad=${codigoEspecialidad}&codigoSucursal=${codigoSucursal}&codigoServicio=${codigoServicio}&codigoPrestacion=${codigoPrestacion}&fechaSeleccionada=${encodeURIComponent(_fechaSeleccionada)}&filtroIntervalos=SOLO_DISPONIBLES&idMedico=${medico.codigoMedico}&bloques=${bloques}`;
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
                    if(dataCita.central && dataCita.central.codigoTipoSucursal == "CAP"){
                        ruta = "/cita-urgencias-ambulatorias/" + "{{ $params }}";
                    }
                    elemento += `<a href="${ruta}">
                            <div class="card card-horario card-body rounded-3 position-relative py-3 mb-2 btn-disponibilidad-medico" data-horario='${JSON.stringify(horario)}'>
                        `;
                    if(horario.porcentajeDescuento > 0){
                        elemento += `<div class="badge-discount-top fs--2 line-height-16 fw-medium"><span>-${horario.porcentajeDescuento}%</span></div>`
                    }
                    elemento += `<p class="fs--16 line-height-20 text-primary-veris text-center mb-0">${horario.horaInicio} - ${horario.horaFin}</p>`;
                    if(horario.porcentajeDescuento > 0){
                        elemento += `<div class="badge-discount-bottom fs--2 line-height-16 fw-medium"><span>{{ __('descuento') }}</span></div>`;
                    }
                    elemento += `</div>
                        </a>`;
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
        args["endpoint"] = api_url + `/${api_war}/v1/domicilio/laboratorio/disponibilidad?canalOrigen=${_canalOrigen}&codigoSolicitud=${codigoSolicitud}&latitud=${latitud}&longitud=${longitud}&fecha=${_fechaSeleccionada}&codigoZona=${codigoZona}`;
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