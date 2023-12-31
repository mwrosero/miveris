@extends('template.app-template-veris')
@section('title')
Mi Veris - Politica-privacidad-datos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajeActualizarPoliticas" tabindex="-1" aria-labelledby="mensajeActualizarPoliticasLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Datos actualizados correctamente</p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Política de privacidad de datos') }}</h5>
    </div>
    <div class="row g-0 justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card bg-transparent shadow-none">
                <div class="card-body pt-5">
                    <form class="row g-3">
                        @csrf
                        <div class="col-12 justify-content-center align-items-center">
                            <h5 class="text-center fw-bold mb-2">{{ __('Confirmación de política de privacidad de datos personales') }}</h5>
                            <p class="text-center mb-4">{{ __('ARCO (Acceso-Rectificación - Cancelación - Oposición)' )}}</p>
                        </div>
                        <div class="col-md-6 border-lg-end">
                            <div class="d-flex justify-content-between">
                                <p class="lh-normal mb-0">{{ __('Rectificación de datos personales') }}</p>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioRectificacion" id="inlineRadioRectificacionNo" value="option1">
                                        <label class="form-check-label cursor-pointer" for="inlineRadioRectificacionNo">{{ __('No') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioRectificacion" id="inlineRadioRectificacionSi" value="option2">
                                        <label class="form-check-label cursor-pointer" for="inlineRadioRectificacionSi">{{ __('Si') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-lg-start ps-lg-4">
                            <div class="d-flex justify-content-between">
                                <p class="lh-normal mb-0">{{ __('Cancelación / Oposición de datos personales') }}</p>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioCancelacion" id="inlineRadioCancelacionNo" value="option1">
                                        <label class="form-check-label cursor-pointer" for="inlineRadioCancelacionNo">{{ __('No') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cursor-pointer" type="radio" name="inlineRadioCancelacion" id="inlineRadioCancelacionSi" value="option2">
                                        <label class="form-check-label cursor-pointer" for="inlineRadioCancelacionSi">{{ __('Si') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center mt-4 pt-2">Datos</h5>
                        <div class="col-md-3">
                            <label for="primerNombre" class="form-label fw-bold">Primer nombre</label>
                            <input type="text" class="form-control border-desaturated" name="primerNombre" id="primerNombre" required />
                            <div class="invalid-feedback">
                                Ingrese su primer nombre.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="segundoNombre" class="form-label fw-bold">Segundo nombre</label>
                            <input type="text" class="form-control border-desaturated" name="segundoNombre" id="segundoNombre" required />
                            <div class="invalid-feedback">
                                Ingrese su segundo nombre.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="prmerApellido" class="form-label fw-bold">Primer apellido</label>
                            <input type="text" class="form-control border-desaturated" name="prmerApellido" id="prmerApellido" required />
                            <div class="invalid-feedback">
                                Ingrese su primer apellido.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="segundoApellido" class="form-label fw-bold">Segundo apellido</label>
                            <input type="text" class="form-control border-desaturated" name="segundoApellido" id="segundoApellido" required />
                            <div class="invalid-feedback">
                                Ingrese su segundo apellido.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fechaNacimiento" class="form-label fw-bold">Fecha de nacimiento</label>
                            <input type="text" class="form-control border-desaturated" name="fechaNacimiento" id="fechaNacimiento" required />
                            <div class="invalid-feedback">
                                Ingrese su fecha de naciemiento.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="numeroIdentificacion" class="form-label fw-bold">Número de identificación</label>
                            <input type="text" class="form-control border-desaturated" name="numeroIdentificacion" id="numeroIdentificacion" required />
                            <div class="invalid-feedback">
                                Ingrese su número de identificación.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-bold">Número de teléfono</label>
                            <input type="number" class="form-control border-desaturated" name="telefono" id="telefono" required />
                            <div class="invalid-feedback">
                                Ingrese un número de teléfono.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="correoElctronico" class="form-label fw-bold">Correo elctrónico</label>
                            <input type="email" class="form-control border-desaturated" name="correoElctronico" id="correoElctronico" required />
                            <div class="invalid-feedback">
                                Ingrese un correo elctrónico.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pais" class="form-label fw-bold">País</label>
                            <select class="form-select border-desaturated" name="pais" id="pais" required>
                                <option selected>Select one</option>
                                <option value="">New Delhi</option>
                                <option value="">Istanbul</option>
                                <option value="">Jakarta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="provincia" class="form-label fw-bold">Provincia</label>
                            <select class="form-select border-desaturated" name="provincia" id="provincia" required>
                                <option selected>Select one</option>
                                <option value="">New Delhi</option>
                                <option value="">Istanbul</option>
                                <option value="">Jakarta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label fw-bold">Ciudad</label>
                            <select class="form-select border-desaturated" name="ciudad" id="ciudad" required>
                                <option selected>Select one</option>
                                <option value="">New Delhi</option>
                                <option value="">Istanbul</option>
                                <option value="">Jakarta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dirección" class="form-label fw-bold">Dirección</label>
                            <input type="text" class="form-control border-desaturated" name="dirección" id="dirección" required />
                            <div class="invalid-feedback">
                                Ingrese su dirección.
                            </div>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button class="btn btn-primary-veris w-50 py-3" id="botonConfirmarPDP">{{ __('Guardar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const respone = await obtenerPPD();
        console.log('dsd',respone);
        if(respone.code == 200){
            console.log('respone.data.estadoPoliticas',respone.data.estadoPoliticas);
            if((respone.data.estadoPoliticas == 'N' || respone.data.estadoPoliticas == 'R') && respone.data.isPoliticasAceptadas == false){
                $('#inlineRadioCancelacionNo').prop('checked', true);
            }else{
                $('#inlineRadioCancelacionSi').prop('checked', true);
            }
        }
    });

    //metodos jquery
    // boton confirmar politicas
    $('#botonConfirmarPDP').click(async function (e) {
        e.preventDefault();
        console.log('click');
        $(this).prop('disabled', true); // Disable the button
        await aceptarPoliticas();
        $(this).prop('disabled', false); // Re-enable the button
    });


    // funciones asyncronas
    // aceptar politicas
    async function aceptarPoliticas(){
        
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            
            "aceptaPoliticas": $('#inlineRadioCancelacionNo').prop('checked') ? false : $('#inlineRadioCancelacionSi').prop('checked') ? true : false,
            "versionPoliticas": localStorage.getItem('ultimaVersionPoliticas'),
            "codigoEmpresa": 1,
            "plataforma": "WEB",
            "versionPlataforma": "7.0.1",
            "identificacion": "{{ Session::get('userData')->numeroIdentificacion }}",
            "tipoIdentificacion": {{ Session::get('userData')->codigoTipoIdentificacion }},
            "tipoEvento": "CR",
            "canalOrigen": _canalOrigen

        });
        const data = await call(args);
        if(data.code == 200){
            $('#mensajeActualizarPoliticas').modal('show');
            setTimeout(function() {
                $('#mensajeActualizarPoliticas').modal('hide');
            }, 2000);
        }
        return data;
    }
    //obtener las politicas
    async function obtenerPPD(){
        console.log('obtenerPPDsisis');
        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/politicas/usuarios/{{ Session::get('userData')->numeroIdentificacion }}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1";
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log('data',data.code);
        if(data.code == 200){
            localStorage.setItem('estadoPoliticas', data.data.estadoPoliticas);
            localStorage.setItem('isPoliticasAceptadas', data.data.isPoliticasAceptadas);
            localStorage.setItem('ultimaVersionPoliticas', data.data.ultimaVersionPoliticas);
        }
        return data;
    }
    
</script>
<script>
</script>
@endpush