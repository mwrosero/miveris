@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Servicios a domicilio
@endsection
@push('css')
@endpush
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal tu cita ha sido agendada -->
    <div class="modal fade" id="modalCitaAgendada" tabindex="-1" aria-labelledby="modalCitaAgendadaLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3 pb-2">Tu cita ha sido agendada</h1>
                    <p class="fs--1 fw-normal">Recuerda que para confirmarla debes realizar el pago.</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <a href="/" class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</a>
                    <a href="/citas-datos-facturacion/{{ $params }}" class="text-primary-veris fs--1 fw-medium cursor-pointer text-center">Pagar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3 pb-2">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal" id="mensajeError"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Confirmación de la cita') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body pb-0">
                        <div class="g-3 bg-white shadow-sm rounded p-3" id="listaPrestaciones">
                        </div>
                    </div>
                </div>
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col-md-12">
                                <label for="fechaAtencion" class="form-label fw-semibold">{{ __('Fecha de la atención') }} </label>
                                <input readonly type="text" class="form-control fs--1 p-3 bg-neutral" name="fechaAtencion" id="fechaAtencion" value="" disabled />
                                <div class="invalid-feedback">
                                    Ingrese una fecha de atención
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="horarioLlegada" class="form-label fw-semibold">{{ __('Horario de llegada') }} </label>
                                <input readonly type="text" class="form-control fs--1 p-3 bg-neutral" name="horarioLlegada" id="horarioLlegada" value="" disabled />
                                <div class="invalid-feedback">
                                    Ingrese un horario de llegada
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="nombrePaciente" class="form-label fw-semibold">{{ __('Nombre del paciente') }} </label>
                                <input readonly type="text" class="form-control fs--1 p-3 bg-neutral" name="nombrePaciente" id="nombrePaciente" value="" disabled />
                                <div class="invalid-feedback">
                                    Ingrese un nombre de paciente
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="direccion" class="form-label fw-semibold">{{ __('Dirección') }} </label>
                                <input readonly type="text" class="form-control fs--1 p-3 bg-neutral" name="direccion" id="direccion" value="" disabled />
                                <div class="invalid-feedback">
                                    Ingrese un nombre de paciente
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-semibold">{{ __('Teléfono') }} </label>
                                <input readonly type="text" class="form-control fs--1 p-3 bg-neutral" name="telefono" id="telefono" value="" disabled />
                                <div class="invalid-feedback">
                                    Ingrese un teléfono
                                </div> 
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary-veris fs--18 line-height-24 px-4 py-3 w-100 shadow-none" type="submit" id="btnConfirmarPagar" disabled>
                                    {{-- <i class="bi bi-credit-card-fill me-2"></i>  --}}
                                    Confirmar y pagar
                                </button>
                            </div>
                            
                        </form>
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
    let fechaAtencion = dataCita.fecha;
    let horarioLlegada = dataCita.horario.rangoAtencion;
    let nombrePaciente = dataCita.ordenExterna.nombrePaciente;
    let direccion = dataCita.ordenExterna.direccion;
    let telefono = dataCita.ordenExterna.telefono;
    let codigoSolicitud = dataCita.ordenExterna.codigoSolicitud;
    let codigoProfesional = dataCita.horario.codigoProfesional;
    let codigoZona = dataCita.ordenExterna.codigoZona;
    let codigoPlanificacion = dataCita.horario.codigoPlanificacion;
    let lineaDetalle = dataCita.horario.lineaDetalle;
    let fecha = dataCita.fecha;
    let examenes;


    // llamar al dom
    document.addEventListener("DOMContentLoaded", async function () {
        document.getElementById('fechaAtencion').value = fechaAtencion;
        document.getElementById('horarioLlegada').value = horarioLlegada;
        document.getElementById('nombrePaciente').value = nombrePaciente;
        document.getElementById('direccion').value = direccion;
        document.getElementById('telefono').value = telefono;
        document.getElementById('btnConfirmarPagar').disabled = false;

        examenes = dataCita.ordenExterna.pacientes[0].examenes;

        $.each(dataCita.ordenExterna.pacientes, function(key, paciente){
            llenarListaExamenes(paciente, '#listaPrestaciones');
        })
    });


    // evento on btnConfirmarPagar
    $("form").on('submit', async function(e) {
        e.preventDefault();
        let data = await reservarCita();
        if (data.code === 200) {
            $('#modalCitaAgendada').modal('show');
        } else {
            document.getElementById('mensajeError').innerHTML = data.message;
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }
    });

    // servicio para reservar cita
    async function reservarCita() {

        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/domicilio/laboratorio/reserva`;
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            "codigoSolicitud": codigoSolicitud,
            "codigoProfesional": codigoProfesional,           
            "codigoZona": codigoZona,
            "codigoPlanificacion": codigoPlanificacion,
            "lineaDetalle": lineaDetalle,
            "fecha": fecha
        });

        console.log('args', args["data"]);

        const data = await call(args);
        if (data.code === 200) {
            console.log('data', data);
            return data;
        } else {
            console.log('data', data);
            return data;
        }
    }

    function llenarListaExamenes(paciente, idElement) {
        let elemento = '';

        // Limitar la lista de exámenes a mostrar inicialmente
        const examenesLimitados = paciente.examenes.slice(0, 3);
        const mostrarVerTodo = paciente.examenes.length > 3;

        // Construir el contenido inicial de la lista, separando el nombre del paciente
        elemento += `<div class="examenLista">
                <h6 class="fw-medium mb-0">${paciente.nombrePacienteOrden}</h6>
                <div class="listaExamenes">
                    ${examenesLimitados.map(examen => `
                        <p class="fw-small fs--2 mb-0">${examen.nombreExamen}</p>
                    `).join('')}
                    ${mostrarVerTodo ? '<p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo" paciente-rel="'+paciente.numeroIdentificacion+'">Ver todo</p>' : ''}
                </div>
            </div>
        `;

        $(idElement).append(elemento);

        // Delegar el evento clic desde el elemento #listaPrestaciones para manejar "Ver todo" y "Ver menos"
        $('#listaPrestaciones').off('click', '.ver-todo').on('click', '.ver-todo', function() {
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

</script>
@endpush