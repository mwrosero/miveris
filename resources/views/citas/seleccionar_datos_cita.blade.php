@extends('template.app-template-veris')
@section('title')
Elige datos para la Cita
@endsection
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
<!-- Modal de error -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs-5 fw-medium mb-3">Veris</h1>
                <p class="fs--2 fw-normal" id="mensajeError"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Entiendo</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal mensaje -->
<div class="modal fade" id="modalEmbarazo" tabindex="-1" aria-labelledby="modalEmbarazoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 pb-2">
                <div class="text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="fa-solid fa-info fs-2"></i>
                        </span>
                    </div>
                    <h1 class="modal-title fs--20 line-height-24 my-3">Información solicitada por tu aseguradora</h1>
                    <p class="fs--1 fw-normal mb-3 mx-3 line-height-16">¿Esta cita es por control de <b>embarazo</b>?</p>
                    <input type="hidden" id="especialidadElegida">
                </div>
                <div class="d-flex">
                    <div respuesta-rel="S" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 me-3 btn-respuesta-embarazo">SI</div>
                    <div respuesta-rel="N" data-bs-dismiss="modal" class="btn btn-sm btn-outline-primary-veris waves-effect w-50 m-0 px-4 py-3 btn-respuesta-embarazo">NO</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal Tratamiento-->
    <div class="modal fade" id="consultaTratamientoModal" tabindex="-1" aria-labelledby="consultaTratamientoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-header border-0 d-none">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-3">
                    <h5 class="fw-medium line-height-24 mb-8">Tienes una <b class="fw-medium text-primary-veris">{{ __('cita pendiente') }}</b> {{ __('de esta especialidad en tu tratamiento de') }}:</h5>
                    <div class="border rounded-3 mb-8 p--2" id="tratamiento-content">
                    </div>
                    <p class="fs--16 line-height-20 fw-medium mb-8">{{ __('¿Estas agendando por este motivo?') }}</p>
                    <a href="#" type="button" id="btn-si-tratamiento" class="btn btn-primary-veris fs--18 w-100 px-4 py-3 m-0 mb-3">{{ __('Agendar esta orden') }}</a>
                    <a href="#" type="button" id="btn-no-tratamiento" class="btn btn-outline-primary-veris fs--18 w-100 px-4 py-3 m-0">{{ __('No') }}</a>
                    {{-- <button type="button" class="btn btn-outline-primary-veris w-100 mb-3" data-bs-dismiss="modal">{{ __('No') }}</button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Datos para la cita') }}</h5>
    </div>
    <section class="p-0 bg-dark-blue-veris-medium-sm mt-0 box-contenido-seleccion invisible element-no-paquete">
        <div class="row g-0 justify-content-center">
            <div class="col-auto p-3 bg-dark-blue-veris-medium" style="min-width: 375px;">
                <p class="text-white fw-medium fs--18 mt-1 mb-2">Elige la modalidad de la cita médica</p>
                <div class="row d-flex">
                    <div class="col-6">
                        <button type="button" class="btn bg-white fs--18 line-height-24 m-0 p-3 w-100 border border-2 border-secondary btn-modalidad" data-rel="N">Presencial</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn bg-white fs--18 line-height-24 m-0 p-3 w-100 border border-2 border-secondary btn-modalidad" data-rel="S">Virtual</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0 box-contenido-seleccion invisible">
        <div class="row g-0 justify-content-center">
            <div class="col-auto ps-3 pe-3" style="min-width: 375px;">
                <p class="card-body fw-medium fs--18 mt-3 mb-3 pt-1">Elige los datos de la cita médica</p>
                <!-- CONVENIOS -->
                <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
                        <form class="modal-content rounded-4">
                            <div class="modal-header d-none">
                                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3 pb-2">
                                <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Elige tu convenio:') }}</h5>
                                <div class="row gx-2 justify-content-between align-items-center">
                                    <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaConvenios">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pt-0 pb-3 px-3">
                                <button type="button" class="btn w-100 fw-medium fs--16 waves-effect line-height-20 m-0 p-3" style="color: #0071CE;" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1 element-no-paquete">Convenio*</p>
                <div class="mb-3 box-btn-convenio element-no-paquete">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" data-bs-toggle="modal" data-bs-target="#convenioModal" id="btn-convenio" data-rel="">
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0 text-truncate"></p>
                        <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Convenios"> 
                    </button>
                </div>

                <!-- CIUDAD -->
                <div class="modal modal-top fade" id="ciudadModal" tabindex="-1" aria-labelledby="ciudadModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
                        <form class="modal-content rounded-4">
                            <div class="modal-header d-none">
                                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3 pb-2">
                                <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Elige tu ciudad:') }}</h5>
                                <div class="row gx-2 justify-content-between align-items-center">
                                    <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaCiudades">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pt-0 pb-3 px-3">
                                <button type="button" class="btn w-100 fw-medium fs--16 waves-effect line-height-20 m-0 p-3" style="color: #0071CE;" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1 item-presencial">Ciudad*</p>
                <div class="mb-1 box-btn-ciudad item-presencial">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" data-bs-toggle="modal" data-bs-target="#ciudadModal" id="btn-ciudad" data-rel="">
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0"></p>
                        <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Ciudad"> 
                    </button>
                </div>
                <span class="mb-2 d-block fs--2 line-height-16 text-light d-none label-sugerencia label-sugerencia-ciudad">Seleccionada en base a tus agendamientos anteriores</span>

                <!-- ESPECIALIDAD -->
                <div class="modal modal-top fade" id="especialidadModal" tabindex="-1" aria-labelledby="especialidadModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
                        <form class="modal-content rounded-4">
                            <div class="modal-header d-none">
                                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3 pb-2">
                                <h5 class="fs--20 line-height-24 mb-2 text-center">{{ __('Elige especialidad') }}</h5>
                                <div class="row gx-2 justify-content-between align-items-center">
                                    <div class="col-12 mb-2 d-flex justify-content-center">
                                        <div class="input-group search-box">
                                            <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-especialidad"></span>
                                            <input type="search" class="form-control bg-transparent fs--16 border-0 p-3 ps-0" name="buscar" id="buscar" placeholder="Buscar especialidad" aria-describedby="buscar">
                                        </div>
                                    </div>
                                    <div class="list-group-checkable d-grid gap-2 border-0" id="listaEspecialidades">
                                        <div class="col-12 p-2 ps-3 pe-3 rounded-3 d-flex justify-content-start align-items-center bg-white item-especialidad waves-effect shadow-item-modal cursor-pointer especialidad-item" type-rel="button">
                                            <div class="avatar avatar-10 me-2">
                                                <div class="avatar-especialidad">
                                                    <img src="https://dikg1979lm6fy.cloudfront.net/especialidades/ico_cirugia_oncologica_v2.png" alt="CIRUGÍA ONCOLOGICA" onerror="this.src='http://127.0.0.1:7000/assets/img/svg/especialidades/medicina_general.svg'">
                                                </div>
                                            </div>
                                            <p class="text-veris fs--16 fw-medium text-one-line mb-0">Cirugía Oncologica</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pt-0 pb-3 px-3">
                                <button type="button" class="btn w-100 fw-medium fs--16 waves-effect line-height-20 m-0 p-3" style="color: #0071CE;" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1 element-no-paquete">Especialidad*</p>
                <div class="mb-3 box-btn-especialidad element-no-paquete">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" data-bs-toggle="modal" data-bs-target="#especialidadModal" id="btn-especialidad" data-rel="">
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0">Seleccionar</p>
                        <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Especialidad"> 
                    </button>
                </div>

                <!-- CENTRAL MEDICA -->
                <div class="modal modal-top fade" id="centralModal" tabindex="-1" aria-labelledby="centralModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
                        <form class="modal-content rounded-4">
                            <div class="modal-header d-none">
                                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3 pb-2">
                                <h5 class="fs--20 line-height-24 mb-3 text-center">{{ __('Elige centro médico') }}</h5>
                                <div class="row gx-2 justify-content-between align-items-center">
                                    <div class="list-group-checkable d-grid gap-2 border-0" id="listaCentrales">
                                        <div class="card h-100 card-central-medica waves-effect shadow-item-modal cursor-pointer item-central-medica central-item select-item" data-central-medica="">
                                            <div class="card-body p--2">
                                                <div class="d-flex">
                                                    <div class="avatar avatar-88 me-2">
                                                        <img src="https://dikg1979lm6fy.cloudfront.net/fotosCentrales/1_46.jpg" onerror="this.src='http://127.0.0.1:7000/assets/img/svg/dummy_central.svg'" class="card-img-top" alt="VERIS URGENCIAS AMBULATORIAS">
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="fs--16 line-height-20 fw-medium mb-2">Veris - Juan Tanca Marengo</h6>
                                                        <p class="fs--1 line-height-16 mb-0">Av. Juan Tanca Marengo Km 2.5</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pt-0 pb-3 px-3">
                                <button type="button" class="btn w-100 fw-medium fs--16 waves-effect line-height-20 m-0 p-3" style="color: #0071CE;" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1 item-presencial">Central médica*</p>
                <div class="mb-1 box-btn-central item-presencial">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" id="btn-central" data-rel="">
                        {{-- data-bs-toggle="modal" data-bs-target="#centralModal" --}}
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0"></p>
                        <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Especialidad"> 
                    </button>
                </div>
                <span class="mb-2 d-block fs--2 line-height-16 text-light d-none label-sugerencia label-sugerencia-central">Seleccionada en base a tus agendamientos anteriores</span>
                <button id="btn-continuar" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5 mt-2">{{ __('Continuar') }}</button>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    // variables globales
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    console.log(dataCita);
    if(dataCita.hasOwnProperty('convenio')){
        if(dataCita.convenio.nombreConvenio == undefined && (dataCita.convenio.codigoConvenio == null || dataCita.convenio.codigoConvenio == "" )){
            dataCita.convenio.nombreConvenio = "Ninguno";
        }
    }
    // let convenio = dataCita.convenio.codigoConvenio || ' ';


    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        if(dataCita.online == "S"){
            $('.item-presencial').addClass('d-none');
        }
        if(dataCita.origen == "Listatratamientos"){
            $('.label-sugerencia').addClass('d-none');
            console.log(dataCita);
            $('.btn-modalidad[data-rel="'+dataCita.online+'"]').addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            $('.btn-modalidad').css('pointer-events','none');
            $('#btn-convenio p').html(`${cutString(capitalizarCadaPalabra(dataCita.convenio.nombreConvenio)) }`)
            $('#btn-especialidad p').html(`${capitalizarCadaPalabra(dataCita.especialidad.nombre) }`)
            await consultarCiudades();
            await consultarCentralesMedicasRecomendadas();
            await validarEspecialidadEnCentralSeleccionada();
            $('#btn-ciudad').removeClass('disabled selectable')
            $('#btn-central').removeClass('disabled selectable')
        }else if(dataCita.hasOwnProperty('reservaEdit')){
            console.log("------reservaEdit------");
            if(dataCita.convenio.nombreConvenio == undefined && dataCita.convenio.codigoConvenio != null){
                await cargarConvenios();
            }
            $('.label-sugerencia').addClass('d-none');
            console.log(dataCita);
            $('.btn-modalidad[data-rel="'+dataCita.online+'"]').addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            $('.btn-modalidad').css('pointer-events','none');
            $('#btn-convenio p').html(`${cutString(capitalizarCadaPalabra(dataCita.convenio.nombreConvenio)) }`)
            $('#btn-especialidad p').html(`${capitalizarCadaPalabra(dataCita.especialidad.nombre) }`)
            // await consultarCentralesMedicasRecomendadas();
            $('#btn-central p').html(`${capitalizarCadaPalabra(dataCita.central.nombreSucursal) }`)
            $('#btn-ciudad').removeClass('disabled selectable')
            $('#btn-central').removeClass('disabled selectable')
            await consultarCiudades();
            await validarEspecialidadEnCentralSeleccionada();
            if(dataCita.reservaEdit.estaPagada == "N"){
                $('#btn-convenio').removeClass('disabled selectable')
            }
        }else if(dataCita.origen == "mis-citas"){
            $('.label-sugerencia').addClass('d-none');
            $('.btn-modalidad[data-rel="'+dataCita.online+'"]').addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            $('.btn-modalidad').css('pointer-events','none');
            $('#btn-especialidad p').html(`${capitalizarCadaPalabra(dataCita.especialidad.nombre) }`)
            $('#btn-central p').html(`${capitalizarCadaPalabra(dataCita.central.nombreSucursal) }`)
            await cargarConvenios();
            await consultarCiudades();
            $('#btn-convenio').removeClass('disabled selectable')
        }else if(dataCita.origen == "doctorFavorito"){
            if(dataCita.online == "N"){
                // let centrales = await obtenerCiudadParaMedicoFavoritoPorCentral();
                // console.log(centrales);
                // let buscarSucursal = centrales.filter(sucursal => parseInt(sucursal.codigoSucursal) === parseInt(dataCita.central.codigoSucursal));
                // console.log(buscarSucursal);
                // let dataCiudad = buscarSucursal[0].codigoCiudad.split('-')
                // console.log(dataCiudad);
                // dataCita.ciudad = {
                //     "codigoPais": parseInt(dataCiudad[0]),
                //     "codigoProvincia": parseInt(dataCiudad[1]),
                //     "codigoCiudad": parseInt(dataCiudad[2])
                // }
            }
            $('.label-sugerencia').addClass('d-none');
            $('.btn-modalidad[data-rel="'+dataCita.online+'"]').addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            $('.btn-modalidad').css('pointer-events','none');
            $('#btn-especialidad p').html(`${capitalizarCadaPalabra(dataCita.especialidad.nombre) }`)
            $('#btn-central p').html(`${capitalizarCadaPalabra(dataCita.central.nombreSucursal) }`)
            await cargarConvenios();
            await consultarCiudades();
            $('#btn-convenio').removeClass('disabled selectable')
        }else if(dataCita.origen == "paquetes"){
            $('.element-no-paquete').addClass('d-none');
            $('.label-sugerencia').removeClass('d-none');
            if(dataCita.online == "N"){
                await consultarCiudades();
                await consultarCentralesMedicasRecomendadas();
            }
            $('.btn-modalidad[data-rel="'+dataCita.online+'"]').addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            $('.btn-modalidad').css('pointer-events','none');
            $('#btn-ciudad').removeClass('disabled');
            $('#btn-central').removeClass('disabled');
        }else{
            $('.label-sugerencia').removeClass('d-none');
        // await consultarEspecialidades();
            delete dataCita.especialidad
        //if(dataCita.convenio == null){
            await cargarConvenios();
            await consultarCiudades();
            await consultarCentralesMedicasRecomendadas();
        //}
        }

        $('.box-contenido-seleccion').removeClass('invisible');

        $('body').on('click','#btn-continuar', async function(){
            let msg = ``;

            if(!dataCita.hasOwnProperty('online')){
                msg += `Selecciona una modalidad<br>`;
            }
            if(!dataCita.hasOwnProperty('convenio')){
                msg += `Selecciona un convenio o Particular<br>`;
            }
            if(!dataCita.hasOwnProperty('especialidad')){
                msg += `Selecciona una especialidad<br>`;
            }
            if(!dataCita.hasOwnProperty('central') && dataCita.online == "N"){
                msg += `Selecciona una Central Médica<br>`;
            }

            if(msg == ``){
                let data = await validarCondicionConvenio();
                console.log(data);
                if(data.data.permiteReserva == "N"){
                    $('#mensajeError').html(`${data.data.mensajeReserva}`);
                    $('#modalError').modal('show');
                }else{
                    dataCita.estaEmbarazada = "N";
                    if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
                        let controlEmbarazo = await validacionConvenio();
                        if(controlEmbarazo){
                            //$('#especialidadElegida').val($(this).attr('data-rel'))
                            $('#modalEmbarazo').modal("show");
                        }else{
                            await consultarSiEsTratamiento();
                        }
                    }else{
                        await consultarSiEsTratamiento();
                    }
                }
            }else{
                showMessage('warning',msg);
            }
        })

        $('body').on('click', '.btn-respuesta-embarazo', async function(){
            let estaEmbarazada = $(this).attr('respuesta-rel');
            dataCita.estaEmbarazada = estaEmbarazada;
            await consultarSiEsTratamiento();
        })

        $('body').on('click','.btn-modalidad', async function(){
            if(!$(this).hasClass('modalidad-selected')){
                $('.label-sugerencia').addClass('d-none');
                if(dataCita.tratamiento == null && dataCita.reservaEdit == null){
                    $('#btn-convenio').removeClass('disabled');
                }
                $('#btn-ciudad').removeClass('disabled');
                $('#btn-especialidad').removeClass('disabled');
                $('#btn-central').removeClass('disabled');
                dataCita.online = $(this).attr('data-rel');
                if($(this).attr('data-rel') == "S"){
                    $('.item-presencial').addClass('d-none');
                    delete dataCita.especialidad;
                    $('#btn-especialidad p').html(`Seleccionar`);
                    $('#btn-especialidad').addClass('selectable');
                    await validarCondicionConvenio();
                }else{
                    $('.item-presencial').removeClass('d-none');
                }

                statusButtons();

                $('.btn-modalidad').addClass('bg-white').removeClass('text-white').removeClass('btn-primary-veris').removeClass('modalidad-selected');
                $(this).addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
                dataCita.vua = (dataCita.online == "N") ? true : false;
            }
        })

        $('body').on('click','.box-btn-convenio', function(){
            if ($(this).find('#btn-convenio').hasClass('disabled') && dataCita.origen != "Listatratamientos" && !dataCita.hasOwnProperty('reservaEdit')) {
                showMessage('warning','Debes seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click','.box-btn-ciudad', function(){
            if ($(this).find('#btn-ciudad').hasClass('disabled') && dataCita.origen != "Listatratamientos" && !dataCita.hasOwnProperty('reservaEdit') && dataCita.origen != "mis-citas" && dataCita.origen != "doctorFavorito") {
                showMessage('warning','Debes seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click','.box-btn-especialidad', function(){
            if ($(this).find('#btn-especialidad').hasClass('disabled') && dataCita.origen != "Listatratamientos" && !dataCita.hasOwnProperty('reservaEdit') && dataCita.origen != "mis-citas" && dataCita.origen != "doctorFavorito") {
                showMessage('warning','Debes seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click','.box-btn-central', async function(){
            if ($(this).find('#btn-central').hasClass('disabled') && dataCita.origen != "mis-citas" && dataCita.origen != "doctorFavorito") {
                showMessage('warning','Debes seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }else{
                if(!dataCita.hasOwnProperty('especialidad')){
                    showMessage('warning','Debes seleccionar una especialidad');
                }else if(dataCita.origen != 'mis-citas' && dataCita.origen != 'doctorFavorito'){
                    await consultarCentralesMedicas();
                    $('#centralModal').modal('show');
                }
            }
        })

        $('body').on('click', '#btn-especialidad', async function(){
            await consultarEspecialidades(); 
        })

        $('body').on('click', '.convenio-item', function(){
            $('#btn-convenio').removeClass(`selectable`);
            let convenio = JSON.parse($(this).attr('data-rel'));
            dataCita.convenio = convenio;
            if(dataCita.convenio.codigoConvenio != null){
                $('#btn-convenio p').html(`${capitalizarCadaPalabra(convenio.nombreConvenio)}`);
            }else{
                $('#btn-convenio p').html(`Ninguno`);
            }
            $('.convenio-item').removeClass('select-item-active');
            $(this).addClass('select-item-active');
        })

        $('body').on('click', '.ciudad-item', async function(){
            $('#btn-ciudad').removeClass(`selectable`);
            let ciudad = JSON.parse($(this).attr('data-rel'));
            dataCita.ciudad = ciudad;
            $('#btn-ciudad p').html(`${capitalizarCadaPalabra(ciudad.nombreCiudad)}`);
            $('.ciudad-item').removeClass('select-item-active');
            $(this).addClass('select-item-active');
            $('.label-sugerencia-ciudad').hide();
            $('#btn-central p').html(`Seleccionar`);
            $('#btn-central').addClass(`selectable`);
            $('#btn-central').attr('data-rel','');
            if(dataCita.hasOwnProperty('especialidad')){
                await consultarCentralesMedicas()
            }
            $('.ciudad-item').removeClass('select-item-active');
            $(this).addClass('select-item-active');
        })

        $('body').on('click', '.especialidad-item', async function(){
            $('#btn-especialidad').removeClass(`selectable`);
            let especialidad = JSON.parse($(this).attr('data-rel'));
            dataCita.especialidad = especialidad;
            $('#btn-especialidad p').html(`${capitalizarCadaPalabra(especialidad.nombre)}`);
            $('.especialidad-item').removeClass('select-item-active');
            $(this).addClass('select-item-active');
            if(!dataCita.hasOwnProperty('central')){
                await consultarCentralesMedicas();
            }else{
                await validarEspecialidadEnCentralSeleccionada();
            }
        })

        $('body').on('click', '.central-item', async function(){
            $('#btn-central').removeClass(`selectable`);
            let central = JSON.parse($(this).attr('data-rel'));
            dataCita.central = central;
            $('#btn-central p').html(`${capitalizarCadaPalabra(central.nombreSucursal)}`);
            $('.central-item').removeClass('select-item-active');
            $(this).addClass('select-item-active');
            $('.label-sugerencia-central').hide();
        })

        /*VALIDACIONES*/
        /*$('body').on('click', '.item-especialidad', async function(){
            dataCita.estaEmbarazada = "N";
            let especialidad = JSON.parse($(this).attr('data-rel'));
            dataCita.especialidad = especialidad;
            if(dataCita.convenio.aplicaVerificacionConvenio && dataCita.convenio.aplicaVerificacionConvenio == "S"){
                let controlEmbarazo = await validacionConvenio($(this).attr('data-rel'));
                console.log(controlEmbarazo);
                if(controlEmbarazo){
                    $('#especialidadElegida').val($(this).attr('data-rel'))
                    $('#modalEmbarazo').modal("show");
                }else{
                    await consultarSiEsTratamiento($(this).attr('data-rel'));
                }
            }else{
                await consultarSiEsTratamiento($(this).attr('data-rel'));
            }
        })

        $('body').on('click', '.btn-respuesta-embarazo', async function(){
            let estaEmbarazada = $(this).attr('respuesta-rel');
            dataCita.estaEmbarazada = estaEmbarazada;
            await consultarSiEsTratamiento($('#especialidadElegida').val());
        })*/

        $('body').on('input', '#buscar', function () {
            var value = $(this).val().toLowerCase();
            console.log("Valor de búsqueda:", value);
            
            $("#listaEspecialidades .item-especialidad").each(function () {
                let text = $(this).find('p.text-veris').text().toLowerCase(); // Obtiene el texto dentro de <p>
                console.log("Texto del elemento:", text);
                
                // Verificar si el texto contiene el valor de búsqueda
                if (text.indexOf(value) > -1 || value === "") {
                    $(this).removeClass("d-none"); // Mostrar el elemento
                } else {
                    $(this).addClass("d-none"); // Ocultar el elemento
                }
            });
        });


        $('body').on('click', '#btn-si-tratamiento', async function(){
            dataCita.tratamiento = JSON.parse($(this).attr("data-rel"));
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
        })

        // var $enlace = $('#btn-si-tratamiento');

        // // Maneja el evento de clic en el enlace
        // $enlace.on('click', function(event) {
        //     // Previene el comportamiento predeterminado del enlace
        //     event.preventDefault();

        //     // Establece un retraso de 2 segundos antes de redirigir
        //     setTimeout(function() {
        //         // Obtiene la URL del enlace
        //         var url = $enlace.attr('href');
        //         // Redirige a la URL después del retraso
        //         window.location.href = url;
        //     }, 500); // Cambia este valor (en milisegundos) para ajustar el tiempo de retraso
        // });
    });

    function statusButtons() {
        if(!dataCita.hasOwnProperty('especialidad') && !$('#btn-especialidad').hasClass('disabled')){
            $('#btn-especialidad').addClass(`selectable`);
        }
    }

    async function validarCondicionConvenio(){
        let paramasAditional = ``;
        if(dataCita.hasOwnProperty('especialidad')){
            paramasAditional += `&codigoServicio=${ dataCita.especialidad.codigoServicio }&codigoPrestacion=${ dataCita.especialidad.codigoPrestacion }&tipoModalidad=${ (dataCita.online == "N") ? "PRESENCIAL" : "ONLINE" }`;
        }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validaCondicionConvenio?canalOrigen=${_canalOrigen}&esValidacionLink=false&codigoEmpresa=1&codigoConvenio=${(dataCita.convenio.codigoConvenio != null) ? dataCita.convenio.codigoConvenio : ''}${paramasAditional}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            dataCita.validarCondicionConvenio = data.data;
        }
        return data;
    }

    async function cargarConvenios(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${_canalOrigen}&tipoIdentificacion=${dataCita.paciente.tipoIdentificacion}&numeroIdentificacion=${dataCita.paciente.numeroIdentificacion}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&excluyeNinguno=S`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        // llenar modal
        if (data.code == 200){
            if(data.data.length > 0){
                //$('#btn-convenio').attr('data-rel',JSON.stringify(dataCita.convenio));
                dataCita.convenio = data.data[0];
                $('#btn-convenio p').html(`${cutString(capitalizarCadaPalabra(dataCita.convenio.nombreConvenio))}`);
            }else{
                dataCita.convenio = {
                    "nombreConvenio": "Ninguno",
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                }
                $('#btn-convenio p').html(`Ninguno`);
            }
            drawConvenios(data.data);
        }
    }

    function drawConvenios(dataConvenios){
        let listaConvenios = $('#listaConvenios');
        let elemento = ``;
        listaConvenios.empty();
        if(dataConvenios.length > 0){
            dataConvenios.forEach((convenios) => {
                elemento += `<div id="convenio-${convenios.codigoConvenio}" data-rel='${JSON.stringify(convenios)}' class="convenio-item mb-2" data-bs-dismiss="modal">
                <div class="list-group-item rounded-3 py-2 px-3 border-0">
                    <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${convenios.codigoConvenio}" value="">
                    <label for="listGroupCheckableRadios${convenios.codigoConvenio}" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                        ${capitalizarCadaPalabra(convenios.nombreConvenio)}
                    </label> 
                </div>
            </div>`;
            });
        }
        let sinConvenio = {
            "nombreConvenio": "Ninguno",
            "permitePago": "S",
            "permiteReserva": "S",
            "idCliente": null,
            "codigoConvenio": null,
        };

        elemento += `<div id="convenio-${sinConvenio.codigoConvenio}" data-rel='${JSON.stringify(sinConvenio)}' class="convenio-item mb-2" data-bs-dismiss="modal">
            <div class="list-group-item rounded-3 py-2 px-3 border-0">
                <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios0" value="">
                <label for="listGroupCheckableRadios0" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                    Ninguno
                </label> 
            </div>
        </div>`;

        listaConvenios.append(elemento); 
        console.log(7)
        if(dataCita.hasOwnProperty('convenio')){
            console.log(8)
            $('#convenio-'+dataCita.convenio.codigoConvenio).addClass('select-item-active');
        }
    }

    async function consultarCiudades() {
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/ciudades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&excluyeVirtual=true&idPaciente=${dataCita.paciente.numeroPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        // console.log(data);return;esDefault

        if(data.code == 200){
            let listaCiudades = $('#listaCiudades');
            let elemento = ``;
            listaCiudades.empty();
            $.each(data.data, function(key, value){
                let selected =  ``;
                if((dataCita.hasOwnProperty('reservaEdit') || dataCita.origen == "mis-citas" || dataCita.origen == "doctorFavorito" ) && value.codigoCiudad == dataCita.ciudad.codigoCiudad ){
                    selected = `select-item-active`;
                    $('#btn-ciudad p').html(`${capitalizarCadaPalabra(value.nombreCiudad)}`);
                }
                elemento += `<div id="ciudad-${value.codigoCiudad}" data-rel='${JSON.stringify(value)}' class="ciudad-item select-item ${selected} mb-2" data-bs-dismiss="modal">
                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${value.codigoCiudad}" value="">
                        <label for="listGroupCheckableRadios${value.codigoCiudad}" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                            ${capitalizarCadaPalabra(value.nombreCiudad)}
                        </label> 
                    </div>
                </div>`;
                if(value.esDefault && !dataCita.hasOwnProperty('reservaEdit') && dataCita.origen != "mis-citas" && dataCita.origen != "doctorFavorito"){
                    $('#btn-ciudad p').html(`${capitalizarCadaPalabra(value.nombreCiudad)}`);
                    dataCita.ciudad = value;
                }
            })
            listaCiudades.append(elemento);
            if(dataCita.hasOwnProperty('ciudad') && data.data.length > 0){
                $('#ciudad-'+dataCita.ciudad.codigoCiudad).addClass('select-item-active');
            }
            //await consultarCentralesPorCiudad();
        }

        return data;
    }

    async function consultarCentralesMedicasRecomendadas(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/listado/centrosMedicos?canalOrigen=${_canalOrigen}&codigoEmpresa=1&codigoCiudad=${dataCita.ciudad.codigoPais+'-'+dataCita.ciudad.codigoProvincia+'-'+dataCita.ciudad.codigoCiudad}&idPaciente=${dataCita.paciente.numeroPaciente}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            drawCentrales(data.data);
            if(data.data.length > 0){
                dataCita.central = data.data[0];
                $('#btn-central p').html(`${capitalizarCadaPalabra(dataCita.central.nombreSucursal)}`);
            }
        }
    }

    async function obtenerCiudadParaMedicoFavoritoPorCentral(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/listado/centrosMedicos?canalOrigen=${_canalOrigen}&codigoEmpresa=1`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            return data.data;
        }
    }

    function cutString(str){
        if(str.length > 40){
            return str.substring(0, 40) + '...'
        }
        return str;
    }

    function drawCentrales(dataCentrales){
        let listaCentrales = $('#listaCentrales');
        let elemento = ``;
        listaCentrales.empty();
        if(dataCentrales.length > 0){
            dataCentrales.forEach((central) => {
                elemento += `<div id="central-${central.codigoSucursal}" data-rel='${JSON.stringify(central)}' class="card h-100 card-central-medica waves-effect shadow-item-modal cursor-pointer item-central-medica central-item select-item" data-bs-dismiss="modal">
                    <div class="card-body p--2">
                        <div class="d-flex">
                            <div class="avatar avatar-88 me-2" style="background: url(${ (central.nombre_foto != null) ? central.nombre_foto : '{{ asset('assets/img/svg/dummy_central.svg') }}' }) no-repeat center center; background-size:cover;">
                            </div>
                            <div class="col">
                                <h6 class="fs--16 line-height-20 fw-medium mb-2">${capitalizarCadaPalabra(central.nombreSucursal)}</h6>
                                <p class="fs--1 line-height-16 mb-0">${capitalizarCadaPalabra(central.direccion)}</p>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }else{
            elemento += `<div class="card bg-transparent shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('assets/img/svg/dummy_central.svg') }}" class="img-fluid mb-3" alt="">
                        <p class="fs--1 line-height-16 mb-0">Lo sentimos no se encontraron centros médicos disponibles para la especialidad seleccionada en ${capitalizarCadaPalabra(dataCita.ciudad.nombreCiudad)}.</p>
                    </div>
                </div>
            </div>`;
        }
        listaCentrales.append(elemento); 
        if(dataCita.hasOwnProperty('central') && dataCentrales.length > 0){
            $('#central-'+dataCita.central.codigoSucursal).addClass('select-item-active');
        }
    }

    async function validarEspecialidadEnCentralSeleccionada(){
        let mostrarVua = (dataCita.vua && !dataCita.tratamiento) ? dataCita.vua : false;
        let ciudad = dataCita.ciudad;
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/centrosmedicos?canalOrigen=${_canalOrigen}&codigoEmpresa=1&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&codigoPais=${dataCita.ciudad.codigoPais}&codigoProvincia=${dataCita.ciudad.codigoProvincia}&codigoCiudad=${dataCita.ciudad.codigoCiudad}&mostrarSucursalPrioritaria=${mostrarVua}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            let existeSucursal = data.data.some(sucursal => parseInt(sucursal.codigoSucursal) === parseInt(dataCita.central.codigoSucursal));
            if(!existeSucursal){
                $('.label-sugerencia-central').hide();
                $('#btn-central p').html(`Seleccionar`);
                $('#btn-central').attr('data-rel','');
                $('#btn-central').addClass(`selectable`);
                delete dataCita.central;
            }
        }
    }

    async function consultarCentralesMedicas(){
        console.log('----------')
        // $('#btn-central p').html(`Seleccionar`);
        // $('#btn-central').attr('data-rel','');
        // delete dataCita.central;
        let mostrarVua = (dataCita.vua && !dataCita.tratamiento) ? dataCita.vua : false;
        let ciudad = dataCita.ciudad;
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/centrosmedicos?canalOrigen=${_canalOrigen}&codigoEmpresa=1&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&codigoPais=${dataCita.ciudad.codigoPais}&codigoProvincia=${dataCita.ciudad.codigoProvincia}&codigoCiudad=${dataCita.ciudad.codigoCiudad}&mostrarSucursalPrioritaria=${mostrarVua}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            drawCentrales(data.data);
        }
    }

    async function validacionConvenio(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validacionConvenio`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "codigoEspecialidad": parseInt(dataCita.especialidad.codigoEspecialidad),
            "idPaciente": parseInt(dataCita.paciente.numeroPaciente),
            "codigoTipoAtencion": dataCita.especialidad.codigoTipoAtencion
        });
        const data = await call(args);
        
        if(data.code == 200){
            return data.data.requiereControlEmbarazo;
        }else{
            return false;
        }
    }

    async function consultarEspecialidades(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/especialidades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${ dataCita.online }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                data.data.forEach((especialidad) => {
                    elemento += `<div id="especialidad-${especialidad.codigoEspecialidad}" data-rel='${JSON.stringify(especialidad)}' class="col-12 p-2 ps-3 pe-3 rounded-3 d-flex justify-content-start align-items-center bg-white item-especialidad waves-effect shadow-item-modal cursor-pointer especialidad-item" type-rel="button" data-bs-dismiss="modal">
                    <div class="avatar avatar-10 me-2">
                        <div class="avatar-especialidad">
                            <img src="${especialidad.imagen}" alt="${capitalizarCadaPalabra(especialidad.nombre)}" onerror="this.src='{{ asset('assets/img/svg/especialidades/medicina_general.svg') }}'">
                        </div>
                    </div>
                    <p class="text-veris fs--16 fw-medium text-one-line mb-0">${capitalizarCadaPalabra(especialidad.nombre)}</p>
                </div>`
                });
            } else {
                listaEspecialidades.empty();
                elemento += `<div class="col-12">
                                <div class=" fs--2 rounded-3 p-2">
                                    {{ __('No existe data que mostrar') }}
                                </div>
                            </div> `;
            }
            
            listaEspecialidades.append(elemento);    
            if(dataCita.hasOwnProperty('especialidad') && data.data.length > 0){
                $('#especialidad-'+dataCita.especialidad.codigoEspecialidad).addClass('select-item-active');
            }
        }

        return data;
    }

    async function consultarSiEsTratamiento(){
        if(dataCita.hasOwnProperty('tratamiento') || dataCita.hasOwnProperty('reservaEdit')){
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            window.location.href = '/citas-elegir-fecha-doctor/{{ $params }}';
        }
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/obtener_tratamiento_compatible?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${dataCita.online}&idPaciente=${dataCita.paciente.numeroPaciente}
        &codigoServicio=${ dataCita.especialidad.codigoServicio }&codigoPrestacion=${ dataCita.especialidad.codigoPrestacion }&codigoConvenio=${ (dataCita.convenio.codigoConvenio != null) ? dataCita.convenio.codigoConvenio : '' }`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        let params = {}

        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

        path_url = "/citas-elegir-fecha-doctor/{{ $params }}";
        
        if (data.code == 200 && data.data != null){
            $("#btn-no-tratamiento").attr("href",path_url);
            params.tratamiento = data.data;
            let urlParamsSi = JSON.stringify(data.data);
            $("#btn-si-tratamiento").attr("data-rel", urlParamsSi);
            $("#btn-si-tratamiento").attr("href",path_url);

            //dataCita.tratamiento = data.data
            $('#tratamiento-content').empty();
            
            let elem = `<div class="progress-circle mx-auto" data-percentage="${ roundToDraw(data.data.porcentajeAvanceTratamiento) }">
                <span class="progress-left">
                    <span class="progress-bar"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar"></span>
                </span>
                <div class="progress-value">
                    <div>
                        <span><i class="bi bi-check2 success"></i></span>
                        <p class="fs--2 mb-0">${data.data.totalTratamientoRealizados}/${data.data.totalTratamientoEnviados}</p>
                    </div>
                </div>
            </div>
            <h5 class="card-title h6 fw-medium mb-2 text-primary-veris">${capitalizarCadaPalabra(data.data.nombreEspecialidad)}</h5>
            <p class="fs--2 mb-0">{{ __('Tratamiento enviado') }}: <b class="fw-normal text-primary-veris" id="fechaCitaPendiente">${ data.data.fechaTratamiento }</b></p>`;

            $('#tratamiento-content').append(elem);

            var myModal = new bootstrap.Modal(document.getElementById('consultaTratamientoModal'));
            myModal.show();
        }else{
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            window.location.href = '/citas-elegir-fecha-doctor/{{ $params }}';
        }

    }

</script>
<style>
    .btn-modalidad{
        color: #13243F;
    }

    .text-title-select{
        color: #6C7A8C;
    }

    .bg-white-80{
        background: #FFFFFFCC;
    }

    .btn{
        border-radius: 8px !important;
    }

    .shadow-item-modal{
        border: 1px solid #E7E9EC;
        box-shadow: 0px 4px 8px 0px #0000001A;
    }

    .list-group-checkable {
        max-height: 500px;
        overflow-y: auto;
    }

    .list-group-checkable::-webkit-scrollbar {
      height: 10px;
      width: 10px;
    }
    .list-group-checkable::-webkit-scrollbar-track {
      border-radius: 5px;
      background-color: #DFE9EB;
    }

    .list-group-checkable::-webkit-scrollbar-track:hover {
      background-color: #D5DEE0;
    }

    .list-group-checkable::-webkit-scrollbar-track:active {
      background-color: #D5DEE0;
    }

    .list-group-checkable::-webkit-scrollbar-thumb {
      border-radius: 5px;
      background-color: #0071CE;
    }

    .list-group-checkable::-webkit-scrollbar-thumb:hover {
      background-color: #19408F;
    }

    .list-group-checkable::-webkit-scrollbar-thumb:active {
      background-color: #19408F;
    }
    .btn.disabled {
        color: #3D4E66 !important;
        background: #E7E9EC;
        border: 1px solid #6C7A8C !important;
    }
    .btn.selectable{
        font-weight: normal !important;
        color: #3D4E66 !important;
        background: #fff !important;
        border: 1px solid #E7E9EC !important;
    }
</style>
@endpush