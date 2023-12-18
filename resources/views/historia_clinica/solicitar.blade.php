@extends('template.app-template-veris')
@section('title')
Mi Veris - Historia clínica
@endsection
@push('css')
<!-- css -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="solictarHistoriaClinicaModal" tabindex="-1" aria-labelledby="solictarHistoriaClinicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h5>Veris</h5>
                    <p>Solicitud creada exitosamente</p>
                </div>
                <div class="modal-footer flex-column align-items-stretch w-100 gap-2 p-3 pt-0">
                    <button type="button" class="btn btn-primary-veris" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Historia clínica') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-5 py-4">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-md-12">
                                    <label for="fechaDesde" class="form-label fw-bold">{{ __('Desde la fecha') }}</label>
                                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="fechaHasta" class="form-label fw-bold">{{ __('Hasta la fecha') }}</label>
                                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaHasta" id="fechaHasta" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="motivo" class="form-label fw-bold">{{ __('Motivo de su consulta') }}</label>
                                    <textarea class="form-control" name="motivo" id="motivo" rows="4" maxlength="400" required
                                    ></textarea>
                                    <div class="text-end fs--3" id="contadorCaracteres">0 / 400</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="terminoCondicionCheck" required />
                                        <label class="form-check-label fs--1" for="terminoCondicionCheck">
                                            Acepto los Términos y condiciones
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary-veris w-100" type="submit" disabled
                                    >Solicitar</button>
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
<!-- script -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

    // Obtener la URL actual
    var url = window.location.href;

    // Crear un objeto URLSearchParams
    var urlParams = new URLSearchParams(window.location.search);

    // Extraer los parámetros
    var doctores = urlParams.get('doctores');
    var codigoEspecialidad = urlParams.get('codigoEspecialidad');
    var tipoIdentificacion = urlParams.get('tipoIdentificacion');
    var numeroIdentificacion = urlParams.get('numeroIdentificacion');

    // Si 'doctores' es una cadena JSON, conviértela a un objeto JavaScript
    if (doctores) {
        doctores = JSON.parse(decodeURIComponent(doctores));
    }

    // llamada al dom

    document.addEventListener("DOMContentLoaded", async function () {
        console.log('sss',doctores);
    });




    // funciones asyncronas

    // Solicitar historia clínica para un paciente.
    async function solicitarHistoriaClinica() {

        let args = [];
        let codigoUsuario = {{ Session::get('userData')->numeroIdentificacion }};

        // Obtener los valores de los campos
        let fechaDesde = document.getElementById('fechaDesde').value;
        let fechaHasta = document.getElementById('fechaHasta').value;
        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);
        let motivo = document.getElementById('motivo').value;

        args["endpoint"] = api_url + `/digitalestest/v1/hc/solicitud`;
        console.log('args["endpoint"]',args["endpoint"]);
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            "codigoUsuario": codigoUsuario,
            "codigoTipoIdentificacion": tipoIdentificacion,
            "numeroIdentificacion": numeroIdentificacion,
            "motivo": motivo,
            "fechaDesde": fechaDesde,
            "fechaHasta": fechaHasta,
            "tipoSolicitud": codigoEspecialidad,
            "canalOrigen": _canalOrigen,
            "doctores": doctores
        });

        console.log('args', args["data"]);

        const data = await call(args);
        if (data.code == "200") {
            // Mostrar el modal
            $("#solictarHistoriaClinicaModal").modal("show");
        } else {
            // Mostrar el mensaje de error
            mostrarMensajeError(data.message);
        }
        

    }


    // funciones js

    $("#terminoCondicionCheck").change(function () {
        if ($(this).is(":checked")) {
            $("button[type=submit]").prop("disabled", false);
        } else {
            $("button[type=submit]").prop("disabled", true);
        }
    });

    // Enviar el formulario
    $("form").on('submit', async function(e) {
        e.preventDefault(); // Evita el comportamiento predeterminado de envío del formulario
        // validar campos
        if (!$("#terminoCondicionCheck").is(":checked")) {
            return;
        }
        // validar campos
        if (!$("#fechaDesde").val() || !$("#fechaHasta").val() || !$("#motivo").val()) {
            // mostrar la validacion required
            return;
        }
        // Solicitar historia clínica para un paciente.
        await solicitarHistoriaClinica();
        
    });

    


    
    
</script>
@endpush