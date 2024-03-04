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
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h5 class="fs--20 fw-medium line-height-24 my-3">Veris</h5>
                    <p class="fs--16 line-height-20 text-veris mb-0">Solicitud creada exitosamente</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 fw-medium line-height-24 mb-3 w-100 px-4 py-3" data-bs-dismiss="modal" id='btnAceptarModal'>Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Historia clínica') }}</h5>
    </div>
    <section class="mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body px-0">
                            <form class="row g-3 needs-validation" id="solicitudHistorial" novalidate>
                                <div class="col-md-12">
                                    <label for="fechaDesde" class="form-label fs--1 line-height-16 fw-medium">{{ __('Desde la fecha') }}</label>
                                    <input class="form-control fs--1 line-height-16 p-3" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required/>
                                </div>
                                <div class="col-md-12">
                                    <label for="fechaHasta" class="form-label fs--1 line-height-16 fw-medium">{{ __('Hasta la fecha') }}</label>
                                    <input class="form-control fs--1 line-height-16 p-3" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="motivo" class="form-label fs--1 line-height-16 fw-medium">{{ __('Motivo de su consulta') }}</label>
                                    <textarea class="form-control fs--1 line-height-16 p-3" name="motivo" id="motivo" rows="4" maxlength="400" required></textarea>
                                    <div class="text-end fs--3" id="contadorCaracteres">0 / 400</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input width-24 me-2" type="checkbox" value="" id="terminoCondicionCheck" required />
                                        <label class="form-check-label fs--1 my-auto" for="terminoCondicionCheck">
                                            Acepto los términos y condiciones
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer px-0">
                        <div class="col-12">
                            <button class="btn btn-primary-veris w-100 fs--18 fw-medium line-height-24 px-4 py-3 shadow-none" form="solicitudHistorial" type="submit" disabled>Solicitar</button>
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
    let fechaDesdePicker = flatpickr("#fechaDesde", {
        maxDate: new Date().fp_incr(0),
        onChange: function(selectedDates, dateStr, instance) {
            if (!document.getElementById('fechaHasta').disabled) {
                fechaHastaPicker.set('minDate', dateStr);
            } else {
                document.getElementById('fechaHasta').disabled = false;
                fechaHastaPicker = flatpickr("#fechaHasta", {
                    minDate: dateStr,
                    maxDate: new Date().fp_incr(0)
                });
            }
        }
    });

    let fechaHastaPicker = flatpickr("#fechaHasta", {
        maxDate: new Date().fp_incr(0),
        minDate: new Date(), 
        onChange: function(selectedDates, dateStr, instance) {
        }
    });

    document.getElementById('fechaHasta').disabled = true;
    // quitar el readonly
    $("#fechaDesde").removeAttr("readonly");
    $("#fechaHasta").removeAttr("readonly");
    // no permitir autocomplete
    $("#fechaDesde").attr("autocomplete", "off");
    $("#fechaHasta").attr("autocomplete", "off");

    // Obtener referencia al textarea y al elemento de conteo de caracteres
    var textareaMotivo = document.getElementById('motivo');
    var contadorCaracteres = document.getElementById('contadorCaracteres');

    // Agregar evento de input al textarea
    textareaMotivo.addEventListener('input', function () {
        // Obtener la cantidad de caracteres ingresados
        var cantidadCaracteres = textareaMotivo.value.length;

        // Actualizar el contador de caracteres
        contadorCaracteres.textContent = cantidadCaracteres + ' / 400';
    });
    
</script>

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
    console.log(66,numeroIdentificacion)
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
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";

        // Obtener los valores de los campos
        let fechaDesde = document.getElementById('fechaDesde').value;
        let fechaHasta = document.getElementById('fechaHasta').value;
        fechaDesde = formatearFecha(fechaDesde);
        fechaHasta = formatearFecha(fechaHasta);
        let motivo = document.getElementById('motivo').value;

        args["endpoint"] = api_url + `/${api_war}/v1/hc/solicitud`;
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
    $("#solicitudHistorial").on('submit', async function(e) {
        e.preventDefault(); // Evita el comportamiento predeterminado de envío del formulario
        // validar campos
        if (!$("#terminoCondicionCheck").is(":checked")) {
            return;
        }
        // validar campos
        // validar fechas vacias
        if (!$("#fechaDesde").val() || !$("#fechaHasta").val() || !$("#motivo").val()) {
            // mostrar mensaje de error 
            return;
        }
        // Solicitar historia clínica para un paciente.
        await solicitarHistoriaClinica();
    });

    // redireccionar a la pagina de inicio
    $("#btnAceptarModal").click(function () {
        window.location.href = "/";
    });
    
</script>
@endpush