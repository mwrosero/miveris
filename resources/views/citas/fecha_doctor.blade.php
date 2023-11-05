@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elige fecha y doctor
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- modal position-absolute -->
    <div class="modal bg-transparent fade" id="elegirHorarioModal" tabindex="-1" aria-labelledby="elegirHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content"> <!-- style="max-height: 300px;" -->
                <div class="modal-body pb-0">
                    <h6 class="text-center fw-bold mb-2">{{ __('Horarios') }}:</h6>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                            <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                            <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                            <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                            <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                            <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <div class="badge-discount-top fs--3 fw-bold"><span>{{ __('-30%') }}</span></div>
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                            <div class="badge-discount-bottom fs--3 fw-bold"><span>{{ __('descuento') }}</span></div>
                        </a>
                    </div>
                    <div class="card card-body rounded-3 position-relative py-2 mb-2">
                        <a href="{{route('citas.detalleCita')}}">
                            <p class="fs--2 text-primary-veris text-center my-1">08:00 - 08:20</p>
                        </a>
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0 py-1">
                    <button type="button" class="btn btn-sm w-100 text-primary-veris fw-bold shadow-none" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elige fecha y doctor') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto">
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
                                <div class="col-auto overflow-auto" style="max-height: 433px;">
                                    <div class="card shadow-none mb-3">
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
                                    </div>

                                    <div class="card shadow-none mb-3">
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
                                    </div>

                                    <div class="card shadow-none mb-3">
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
    const daysOfWeek = ["D", "L", "M", "M", "J", "V", "S"];
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const calendarGrid = document.getElementById('calendar-grid');
    const monthYearElement = document.getElementById('month-year');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentDate = new Date();

    function renderCalendar() {
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
            dayElement.classList.add('calendar-day', 'current-month-day');
            dayElement.textContent = i;

            if (currentDate.getMonth() === new Date().getMonth() && i === new Date().getDate() && currentDate.getFullYear() === new Date().getFullYear()) {
                dayElement.classList.add('selected-day');
            }

            dayElement.addEventListener('click', () => {
                // Aquí puedes hacer algo con la fecha seleccionada, como enviarla al servidor para la cita médica.
                console.log(`Fecha seleccionada: ${i}/${currentDate.getMonth() + 1}/${currentDate.getFullYear()}`);
            });

            calendarGrid.appendChild(dayElement);
        }
    }

    renderCalendar();

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

    toggleCalendarBtn.addEventListener('click', () => {
        if (calendarContainer.style.maxHeight) {
            calendarContainer.style.maxHeight = null;
        } else {
            calendarContainer.style.maxHeight = '135px';
        }
    });
</script>
@endpush