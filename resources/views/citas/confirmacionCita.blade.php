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
    <div class="modal fade" id="modalCitaAgendada" tabindex="-1" aria-labelledby="modalCitaAgendadaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3 pb-2">Cita agendada</h1>
                    <p class="fs--1 fw-normal">Recuerda que para confirmarla debes realizar el pago.</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 px-4 py-3 mt-0 mb-3 mx-0" data-bs-dismiss="modal">Cancelar</button>
                    <a href="/citas-datos-facturacion/{{ $params }}" class="btn btn-primary-veris m-0 w-100 px-4 py-3">Pagar</a>
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
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3">
                                 
                                <div class="col-md-12">
                                    <label for="fechaAtencion" class="form-label fw-semibold">{{ __('Fecha de la atención') }} </label>
                                    <input type="text" class="form-control bg-neutral" name="fechaAtencion" id="fechaAtencion" value="" readonly />
                                    <div class="invalid-feedback">
                                        Ingrese una fecha de atención
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="horarioLlegada" class="form-label fw-semibold">{{ __('Horario de llegada') }} </label>
                                    <input type="text" class="form-control bg-neutral" name="horarioLlegada" id="horarioLlegada" value="" readonly />
                                    <div class="invalid-feedback">
                                        Ingrese un horario de llegada
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="nombrePaciente" class="form-label fw-semibold">{{ __('Nombre del paciente') }} </label>
                                    <input type="text" class="form-control bg-neutral" name="nombrePaciente" id="nombrePaciente" value="" readonly />
                                    <div class="invalid-feedback">
                                        Ingrese un nombre de paciente
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="telefono" class="form-label fw-semibold">{{ __('Teléfono') }} </label>
                                    <input type="text" class="form-control bg-neutral" name="telefono" id="telefono" value="" readonly />
                                    <div class="invalid-feedback">
                                        Ingrese un teléfono
                                    </div> 
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-lg btn-primary-veris w-100" type="submit" id="btnConfirmarPagar" disabled><i class="bi bi-credit-card-fill me-2" 
                                        ></i> Confirmar y pagar</button>
                                </div>
                                
                            </form>
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
    let fechaAtencion = dataCita.fecha;
    let horarioLlegada = dataCita.horario.rangoAtencion;
    let nombrePaciente = dataCita.dataOrdenExterna.nombrePaciente;
    let telefono = dataCita.dataOrdenExterna.telefono;
    let codigoSolicitud = dataCita.dataOrdenExterna.codigoSolicitud;
    let codigoProfesional = dataCita.horario.codigoProfesional;
    let codigoZona = dataCita.dataOrdenExterna.codigoZona;
    let codigoPlanificacion = dataCita.horario.codigoPlanificacion;
    let lineaDetalle = dataCita.horario.lineaDetalle;
    let fecha = dataCita.fecha;


    // llamar al dom
    document.addEventListener("DOMContentLoaded", async function () {
        document.getElementById('fechaAtencion').value = fechaAtencion;
        document.getElementById('horarioLlegada').value = horarioLlegada;
        document.getElementById('nombrePaciente').value = nombrePaciente;
        document.getElementById('telefono').value = telefono;
        document.getElementById('btnConfirmarPagar').disabled = false;
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
        args["endpoint"] = api_url + `/digitalestest/v1/domicilio/laboratorio/reserva`;
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






</script>
@endpush