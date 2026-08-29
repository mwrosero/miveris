@extends('template.app-template-veris')
@section('title')
Mi Veris - Agregar familiar o amigo
@endsection
@section('content')
@php
// dd(Session::get('userData'));
@endphp
<div style="height: 40px; background-color: #F3F4F5; display: flex; align-items: center;">
    <a href="javascript:history.back()" class="text-decoration-none d-block">
        <div class="d-flex align-items-center justify-content-center" style="width: 87px; margin-left: 5px;">
            <img src="{{asset('assets/img/svg/atras.svg')}}" class="cursor-pointer prev-image" alt="Atrás">
            <label class="fw-medium cursor-pointer" style="color: #0A2240;font-family: 'Gotham Rounded'; font-size: 16px;">Atrás</label>
        </div>
    </a>
</div>

<!-- Modal -->
<div class="modal fade" id="modalErrorValidacion" tabindex="-1" aria-labelledby="modalErrorValidacionLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                <p class="fs--1 fw-normal mb-0 text-veris" id="mensaje_400_validacion"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <div class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</div>
                {{-- <button data-bs-dismiss="modal" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 w-100 px-4 py-3">Aceptar</button> --}}
            </div>
        </div>
    </div>
</div>

{{-- Modal de pregunta --}}
<div class="modal fade" id="confirmarPregunta" tabindex="-1" aria-labelledby="confirmarPreguntaLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <h5 class="fs-18 line-height-24 my-3">¿Administras los tratamientos de <span class="primerNombreFamiliar text-capitalize"></span>?</h5>
                <p class="fs--1 line-height-16 mb-0">Pídele permisos de administrador. Esto te permitirá agendarle citas, gestionar sus tratamientos, ver resultados y más.</p>
                <div class="d-flex flex-column">
                    <button type="button" id="btnSolicitarPermiso" class="btn btn-primary-veris fw-medium fs--18 line-height-24 m-0 mt-3 w-100 px-4 py-3" data-bs-dismiss="modal">Solicitar Permisos</button>
                    <button type="button" id="btnAgregarPersona" class="btn btn-lg shadow-none text-primary-veris fw-medium col fs--18 line-height-24 m-0 mt-2 w-100 px-4 py-3" data-bs-dismiss="modal">Ahora no</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">

    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajePersonaAgregadaModal" tabindex="-1" aria-labelledby="mensajePersonaAgregadaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <div class="avatar avatar-md mx-auto my-3">
                        <img src="{{asset('assets/img/svg/check-circle.svg')}}" alt="">
                    </div>
                    <div class="text-center">
                        <p class="fs--16 line-height-20 fw-medium text-veris mb-0">Persona agregada exitosamente</p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal mensaje para errores fuera de 200 -->    
    <div class="modal fade" id="mensajeErrorModal" tabindex="-1" aria-labelledby="mensajeErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-exclamation-triangle-fill  text-primary-veris h2"></i>
                    <p class="fs--1 fw-medium line-height-20 text-veris m-0 mt-3" id="mensajeErrorModalLabel"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mensajeReenviar" tabindex="-1" aria-labelledby="mensajeReenviarLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-exclamation-triangle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-medium line-height-20 text-veris m-0 mt-3" id="mensajePersonaYaExisteModalLabel"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Solicitud de administrador') }}</h5>
    </div>
    <section class="pt-4 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 px-0">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-transparent shadow-none mb-4">
                            <div class="card-body py-3 px-0">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <p class="fs--20 line-height-24 text-veris my-3">Código de Verificación</p>
                                        <p class="fs--16 line-height-20 infoFamiliar"></p>
                                        <p class="fs--16 line-height-20 infoMail fw-medium my-3 text-center"></p>
                                        <div class="box-digits d-none d-flex justify-content-center gap-2 mb-3 text-veris-dark">
                                            <input type="number" maxlength="1" class="input-digit" id="digit1">
                                            <input type="number" maxlength="1" class="input-digit" id="digit2">
                                            <input type="number" maxlength="1" class="input-digit" id="digit3">
                                            <input type="number" maxlength="1" class="input-digit" id="digit4">
                                            <input type="number" maxlength="1" class="input-digit" id="digit5">
                                        </div>
                                        <div class="mt-3">
                                            <div class="fs--16 line-height-20 text-center counter">
                                                Solicitar nuevo código en <span id="timer"></span>
                                            </div>
                                            <div style="button" class="btn-reenviar text-veris-ai text-center fs--16 line-height-20 d-none">Solicitar nuevo código</div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt--32">
                                        <button class="btn btn-primary-veris rounded-3 fs--18 line-height-24 w-100 px-4 py-3 text-white disabled" data-bs-toggle="modal" id="btnContinuar">Continuar</button>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')>

<script>
    // variables globales
    let local = localStorage.getItem('persona-{{ $params }}');
    let dataCita = JSON.parse(local);
    console.log(dataCita);
    
    //llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {

        $('.infoFamiliar').html(`Pídele a <b class="text-capitalize">${dataCita.familiar.primerNombre.toLowerCase()}</b> <b class="text-capitalize">(${dataCita.parentesco.descripcion.toLowerCase()})</b> el código que hemos enviado al correo.`);
        $('.infoMail').html(`${ocultarEmail(dataCita.familiar.correo)}`);

        const inputs = document.querySelectorAll(".input-digit");
        $('.box-digits').removeClass('d-none')

        document.getElementById('timer').innerHTML = "05" + ":" + "00";
        startTimer();

        $('body').on('click', '#btnContinuar', async function(){
            await validarCodigo();
        })

        $('body').on('click', '.btn-reenviar', async function(){
            await sendCode()
        });

        inputs.forEach((input, index) => {
            input.addEventListener("input", function () {
                // Solo permitir un solo número
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);

                // Si hay un número, pasar al siguiente input
                if (this.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                const allFilled = Array.from(inputs).every(i => i.value.trim() !== "");
                if (allFilled) {
                    $('#btnContinuar').removeClass('disabled');
                }else{
                    $('#btnContinuar').addClass('disabled');
                }

            });

            input.addEventListener("keydown", function (e) {
                // Si presionan Backspace en un campo vacío, regresar al anterior
                if (e.key === "Backspace" && this.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        await consultarGrupoFamiliar();
    });

    let idRelacion;
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('data', data);
        if(data.code == 200){
            const resultado = data.data.find(item => item.numeroIdentificacion === dataCita.familiar.numeroIdentificacion);
            idRelacion = resultado.idRelacion;
        }
        return data;
    }

    async function validarCodigo(){
        let codigo = `${ $('#digit1').val() }${ $('#digit2').val() }${ $('#digit3').val() }${ $('#digit4').val() }${ $('#digit5').val() }`
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "codigoUsuario": "{{ Session::get('userData')->numeroIdentificacion }}",
            "codigoParentesco": dataCita.parentesco.codigoParentesco,
            "esAdmin": (dataCita.familiar.esAdmin !== null) ? dataCita.familiar.esAdmin : "N",
            "idRelacion": idRelacion,
            "codigoSolicitud": parseInt(codigo),
            "requiereAdmin": "S"
        });

        const data = await call(args);

        if(data.code == 200){
            if(dataCita.hasOwnProperty('provienePaquete')){
                location.href = '/mi-promocion/detalle/{{ $params }}';
            }else{
                location.href = '/confirmacion-aprobada/{{ $params }}';
            }
        }else{
            $('#mensaje_400_validacion').html(data.message);
            var myModal = new bootstrap.Modal(document.getElementById('modalErrorValidacion'));
            myModal.show();
        }

        return data;
    }

    function startTimer() {
        var presentTime = document.getElementById('timer').innerHTML;
        var timeArray = presentTime.split(/[:]+/);
        var m = timeArray[0];
        var s = checkSecond((timeArray[1] - 1));
        if(s==59){m=m-1}
        if (parseInt(m) === 0 && parseInt(s) === 0) {
            $('.counter').addClass('d-none');
            $('.btn-reenviar').removeClass('d-none');
            return;
        }

        document.getElementById('timer').innerHTML = m + ":" + s;
        setTimeout(startTimer, 1000);
    }

    function checkSecond(sec) {
        if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
        if (sec < 0) {sec = "59"};
        return sec;
    }

    function ocultarEmail(email) {
        const partes = email.split("@");
        const nombre = partes[0];
        const dominio = partes[1];

        const visibleInicio = nombre.substring(0, 2);
        const visibleFinal = nombre.slice(-2);
        const puntos = ".".repeat(14); // puedes ajustar la cantidad

        return `${visibleInicio}${puntos}${visibleFinal}@${dominio}`;
    }


    async function sendCode(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/solicitaAdmin`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        
        args["data"] = JSON.stringify({
            "numeroPaciente": dataCita.familiar.numeroPaciente,
            "virusu": dataCita.familiar.numeroIdentificacion,
            "correo": dataCita.familiar.correo,
            "canalOrigenDigital": _canalOrigen
        });

        const data = await call(args);
        if(data.code == 200){
            $('.counter').removeClass('d-none');
            $('.btn-reenviar').addClass('d-none');
            document.getElementById('timer').innerHTML = "05" + ":" + "00";
            startTimer();
        }
    }

    // redireccionar a la lista de familiares
    $("#btnEntendido").click(function() {
        window.location.href = "{{route('cuenta.lista')}}";
    });

</script>
<style>
    .digit-box {
        width: 45px;
        height: 45px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        line-height: 45px;
        border-radius: 8px;
    }
    .masked {
        background-color: #adb5bd; /* Gris */
    }
    .input-digit {
        border: 2px solid #adb5bd;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        width: 45px;
        height: 45px;
    }
    /* Para Chrome, Safari, Edge, Opera */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Para Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endpush