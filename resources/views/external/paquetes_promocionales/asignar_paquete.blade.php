@extends('template.external')
@section('title')
Veris - Asignar Promoción
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar')

<div class="d-flex justify-content-between align-items-center bg-white">
    <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Asignar beneficiario') }}</h5>
</div>
<section class="p-3 mb-3">
    <div class="row justify-content-between">
        <div class="col-12 col-md-5 detalle-paquete">
        </div>
        <div class="col-12 col-md-7">
            <div class="card bg-transparent shadow-none">
                <div class="card-body p-0 p-md-3">
                    <form class="row g-3 form-factura needs-validation" novalidate>
                        <div class="col-12 mt-0">
                            <p class="text-primary-veris fs--16 line-height-20 fw-medium mb-1 mt-5 mt-md-0">Información del Beneficiario del Paquete</p>
                            <span class="fs--1 line-height-16 mb-0">La información solicitada a continuación es referente a la persona a la que estará destinado el paquete.</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="primerApellido" class="form-label fw-medium fs--1">Primer Apellido *</label>
                            <input type="text" class="form-control fs--1 p-3" name="primerApellido" id="primerApellido" placeholder="" required />
                            <div class="invalid-feedback">
                                Ingrese su nombres y apellidos.
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="segundoApellido" class="form-label fw-medium fs--1">Segundo Apellido *</label>
                            <input type="text" class="form-control fs--1 p-3" name="segundoApellido" id="segundoApellido" placeholder="" required />
                            <div class="invalid-feedback">
                                Ingrese su nombres y apellidos.
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="primerNombre" class="form-label fw-medium fs--1">Primer Nombre *</label>
                            <input type="text" class="form-control fs--1 p-3" name="primerNombre" id="primerNombre" placeholder="" required />
                            <div class="invalid-feedback">
                                Ingrese su nombres y apellidos.
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="genero" class="form-label fw-medium fs--1">Género *</label>
                            <select class="form-select fs--1 p-3" name="genero" id="genero" required>
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select>
                            <div class="invalid-feedback">
                                Elegir el género.
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="tipoIdentificacion" class="form-label fw-medium fs--1">Tipo de identificación *</label>
                            <select class="form-select fs--1 p-3" name="tipoIdentificacion" id="tipoIdentificacion" required>
                                <option value="2">CÉDULA</option>
                                <option value="3">PASAPORTE</option>
                            </select>
                            <div class="invalid-feedback">
                                Elegir el tipo de documento.
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Nro. de identificación *</label>
                            <input type="text" class="form-control fs--1 p-3" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required />
                            <div class="invalid-feedback">
                                Ingrese un numero de identificacion.
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="fechaNacimiento" class="form-label fw-medium fs--1">Fecha de nacimiento *</label>
                            <input type="date" lang="es" class="form-control fs--1 p-3" name="fechaNacimiento" id="fechaNacimiento" required />
                            <div class="invalid-feedback">
                                Ingrese una fecha de nacimiento
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="codigoAsesor" class="form-label fw-medium fs--1">Código asesor</label>
                            <input type="text" class="form-control fs--1 p-3" name="codigoAsesor" id="codigoAsesor" placeholder="" />
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-check d-flex justify-content-start align-items-center h-100">
                                <input class="form-check-input terminos-input me-2 mb-1 width-24 shadow" type="checkbox" value="" id="regalo" style="border: 1px solid #D0D3D9">
                                <label class="form-check-label text-start fs--1 fw-medium line-height-16" for="regalo">
                                    Esto es un regalo
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 box-regalo d-none">
                            <label for="nombreEmisor" class="form-label fw-medium fs--1">De:*</label>
                            <input type="text" class="form-control fs--1 p-3" name="nombreEmisor" id="nombreEmisor" placeholder="Tu nombre" />
                        </div>
                        <div class="col-12 col-md-6 box-regalo d-none">
                            <label for="emailEmisor" class="form-label fw-medium fs--1">Tu correo:*</label>
                            <input type="email" class="form-control fs--1 p-3" name="emailEmisor" id="emailEmisor" placeholder="ejemplo@ejemplo.com" />
                        </div>
                        <div class="col-12 box-regalo d-none">
                            <label for="emailEmisor" class="form-label fw-medium fs--1">Mensaje:*</label>
                            <textarea name="mensaje" id="mensaje" class="form-control fs--1 p-3" placeholder="Escribe aquí tu mensaje o dedicatoria"></textarea>
                        </div>
                        <div class="col-12 col-md-4 ms-auto align-self-end">
                            <!-- Button trigger modal -->
                            <div class="text-center box-action">
                                <button type="button" class="btn btn-primary-veris btn-asignar w-100 fs--18 line-height-24 fw-medium px-4 py-3">
                                    Continuar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@component('components.modal', ['id' => 'modalAlert', 'title' => 'Error', 'message' => session('alert')])
    <button type="button" class="btn btn-primary">Aceptar</button>
@endcomponent

<script>
    let local = localStorage.getItem('external-cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    document.addEventListener("DOMContentLoaded", async function () {
        await drawCard();

        $('body').on('change', '#regalo', function(){
            if($(this).is(':checked')){
                $('.box-regalo').removeClass('d-none');
            }else{
                $('.box-regalo').addClass('d-none');
            }
        })

        // if(dataCita.paquete.idPaciente !== null){
        //     $('.box-action').html(`<button type="button" class="btn btn-primary-veris btn-asignar w-100 fs--18 line-height-24 fw-medium px-4 py-3">
        //                         Continuar
        //                     </button>`)
        // }

        $('body').on('click', '.btn-asignar', async function(){
            await crearUsuarioPaquete();
            // let url = '/external/paquetes-promocionales/asignar/'
            // localStorage.setItem('external-cita-{{ $params }}', JSON.stringify(dataCita));
            // location.href = url + "{{ $params }}";
        })

        let valorAnteriorElem = ``;
        if(dataCita.paquete.porcentajeDescuento > 0){
            $('#porcentajeDescuento').html(`-${dataCita.paquete.porcentajeDescuento}% OFF`).removeClass('d-none');
            $('#porcentajeDescuento').removeClass('d-none');
            //$('#valorAnteriorPaquete').html(`$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}`);
            valorAnteriorElem += `<p class="fs--1 fw-normal mb-0 me-2" style="color: #6E7A8C !important;"><del id="valorAnteriorPaquete">$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}</del></p>`;
        }

        let elemValores = `${valorAnteriorElem}
            <h5 class="text-primary-veris fs--20 fw-bold mb-0" id="valorTotalPaquete">$${dataCita.paquete.valorTotalPaquete.toFixed(2)}</h5>`;

        $('#detalleValoresPaquete').html(elemValores)

        //consultarGrupoFamiliar();
        await obtenerDetallePaquetePromocional();

        // $('body').on('click', '.btn-asignar', function(){
        //     let url = '/citas-datos-facturacion/';
        //     dataCita.paciente = JSON.parse($(this).attr('data-rel'));
        //     localStorage.setItem('external-cita-{{ $params }}', JSON.stringify(dataCita));
        //     location.href = url + "{{ $params }}";
        // })
    })

    function removeAccents(str){
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    async function asignarPaquete(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/asignarpaquete?tipoIdentificacion=${getInput('tipoIdentificacion')}&numeroIdentificacion=${getInput('numeroIdentificacion')}&codigoEmpresa=${dataCita.paquete.codigoEmpresaPaquete}&codigoPaquete=${dataCita.paquete.codigoPaquete}&codigoAsesor=${getInput('codigoAsesor')}&canalOrigen=${_canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            let codigoReserva = data.data.numeroOrden;
            let url = `/external/payment?tipoArticulo=PAQUETE&codArticulo=${codigoReserva}&tipoIdentificacion=${ jQuery('#tipoIdentificacion').val() }&numeroIdentificacion=${ jQuery('#numeroIdentificacion').val() }&canalOrigen=${_canalOrigen}`;
            // let url = `/external/payment?tipoArticulo=PAQUETE&codArticulo=${codigoReserva}&tipoIdentificacion=${ jQuery('#tipoIdentificacion').val() }&numeroIdentificacion=${ jQuery('#numeroIdentificacion').val() }`;
            fbq('track', 'AddToCart');
            if($('#regalo').is(':checked')){
                await enviarRegalo(data.data.secuanciaPaquetePaciente);
            }
            location.href = url;
            console.log(url);
            return;
        }
    }

    async function enviarRegalo(secuanciaPaquetePaciente){
        let mensaje = $('#mensaje').val();
        let nombreEmisor = $('#nombreEmisor').val();
        let emailEmisor = $('#emailEmisor').val();
        let formData = new FormData();
        let obj = {
            "tipoCampania": "DIG_PROMO_REGALO",
            "tipoIdentificacion": getInput('tipoIdentificacion'),
            "numeroIdentificacion": getInput('numeroIdentificacion'),
            "nombrePaciente": nombreEmisor,
            "mail": emailEmisor,
            "aceptaTerminos": true,
            "secuenciaPaquetePaciente": secuanciaPaquetePaciente,
            "mensajeRemitente": mensaje,
            "canalOrigen": "MVE_CMV"
        }
        formData.append("data", JSON.stringify(obj));
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/v1/promociones/registroCampania`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["data"] = formData;
        args["bodyType"] = "formdata";
        const data = await call(args);
    }

    async function validateForm(){
        let errors = false;
        let title = 'Campos requeridos';
        let msg = `<ul class="ms-0 text-start text-veris" id="itemsMsg">`;
        if(getInput('primerApellido') == ""){
            errors = true;
            msg += `<li class="ms-0">Campo primer apellido es requerido</li>`;
        }
        if(getInput('segundoApellido') == ""){
            errors = true;
            msg += `<li class="ms-0">Campo segundo apellido es requerido</li>`;
        }
        if(getInput('primerNombre') == ""){
            errors = true;
            msg += `<li class="ms-0">Campo primer nombre es requerido</li>`;
        }
        if(getInput('numeroIdentificacion') == ""){
            errors = true;
            msg += `<li class="ms-0">Campo Número de documento es requerido</li>`;
        }else if(parseInt(getInput('tipoIdentificacion')) == 2){
            if(!esValidaCedula(getInput('numeroIdentificacion').toString())){
                errors = true;
                msg += `<li class="ms-0">La cédula ingresada no es correcta</li>`;
            }
        }
        if(getInput('fechaNacimiento') == ""){
            errors = true;
            msg += `<li class="ms-0">Campo fecha de nacimiento es requerido</li>`;
        }


        if($('#regalo').is(':checked')){

            if(getInput('nombreEmisor') == ""){
                errors = true;
                msg += `<li class="ms-0">El campo del nombre de quien envía el regalo es requerido</li>`;
            }

            if(getInput('emailEmisor') == ""){
                errors = true;
                msg += `<li class="ms-0">El campo del correo de quien envía el regalo es requerido</li>`;
            }

            if(getInput('mensaje') == ""){
                errors = true;
                msg += `<li class="ms-0">El campo del mensaje del regalo es requerido</li>`;
            }

        }


        msg += `</ul>`;

        if(!errors){
            return true
        }else{
            $('#modalAlertTitle').html(title);
            $('#modalAlertMessage').html(msg);
            $('#modalAlert').modal('show');
            return false;
        }
    }

    async function crearUsuarioPaquete(){
        let validarForm = await validateForm();
        if(!validarForm){
            return;
        }
        let f_n = $('#fechaNacimiento').val().split('-');
        let fechaNacimiento = f_n[2]+'/'+f_n[1]+'/'+f_n[0];
        let tipoIdentificacion = $('#tipoIdentificacion').val();
        let numeroIdentificacion = $('#numeroIdentificacion').val();
        let primerNombre = $('#primerNombre').val();
        let primerApellido = $('#primerApellido').val();
        let segundoApellido = $('#segundoApellido').val();
        let genero = $('#genero').val();

        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/crearusuariopaquete?tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&primerApellido=${removeAccents(primerApellido)}&segundoApellido=${removeAccents(segundoApellido)}&primerNombre=${removeAccents(primerNombre)}&fechaNacimiento=${fechaNacimiento}&genero=${genero}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200 || data.code == 400){
            fbq('track', 'CompleteRegistration');
            asignarPaquete();
        }else{
            console.log("ERROR")
        }
    }

    async function drawCard(){
        let elem = `<div class="card w-100" style="border: 1px solid #E7E9EC;box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.10);border-radius: 8px;">
                <div class="row g-0 justify-content-between aling-items-center cursor-pointer">
                    <div class="col-4 position-relative feature-img-promocion-horizontal" style="background: url(${dataCita.paquete.urlImagen}) no-repeat center;">`
                    if(dataCita.paquete.porcentajeDescuento && dataCita.paquete.porcentajeDescuento > 0){
                        elem += `<span class="label-descuento-promocion position-absolute fs--2 fw-medium">-${dataCita.paquete.porcentajeDescuento}%</span>`;
                    }
                    elem += `</div>
                    <div class="col-8 col-md-8">
                        <div class="card-body h-100 p--2 pb-2 d-flex flex-column justify-content-center">
                            <h6 class="title-promocion-horizontal fs--1 line-height-16 mb-2">${capitalizarElemento(dataCita.paquete.nombrePaquete)}</h6>
                            <div class="border-0 d-flex justify-content-between align-items-center">`;
                                if(dataCita.paquete.porcentajeDescuento && dataCita.paquete.porcentajeDescuento > 0){
                                    elem += `<div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}</span>
                                    </div>`;
                                }
                                elem += `<div class="precio-venta ms-auto fs-medium">$${dataCita.paquete.valorTotalPaquete.toFixed(2)}</div>
                            </div>
                            <p class="fw-small fs--2 mb-0 text-primary cursor-pointer ver-todo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetallePaquete" aria-expanded="false" aria-controls="collapseDetallePaquete">Ver detalles</p>
                        </div>
                    </div>
                    <div class="col-12 p-3 collapse" id="collapseDetallePaquete">
                        <h6 class="text-start fs--1 fw-medium mb-2">DETALLES DE PAQUETE</h6>
                        <ul class="fs--2 mb-3 ps-3" id="detallePaquete">
                        </ul>
                    </div>
                </div>
            </div>`;

        $('.detalle-paquete').html(elem);
    }

    async function obtenerDetallePaquetePromocional(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=${dataCita.paquete.codigoEmpresaPaquete}&codigoPaquete=${dataCita.paquete.codigoPaquete}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            $('#detallePaquete').empty();
            dataCita.detallePaquete = data.data;
            let elem = ``;
            $.each(data.data.detallePromocion, function(key, value){
                $.each(value.detalles, function(k,v){
                    elem += `<li class="mb-0" title="${value.nombreServicio}">${v.nombreComercial}</li>`;
                })
            })
            $('#detallePaquete').append(elem);
        }else{
            alert(data.message);
        }
    }

</script>

@endsection