@extends('template.app-template-veris')
@section('title')
Elige datos para la Cita
@endsection
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
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
    <!-- Modal -->
    <div class="modal fade" id="citaPendienteModal" tabindex="-1" aria-labelledby="citaPendienteModalLabel" aria-hidden="true">
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
    <section class="p-0 bg-dark-blue-veris-medium-sm">
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
    <section class="p-0">
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
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1">Convenio</p>
                <div class="mb-3 box-btn-convenio">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" data-bs-toggle="modal" data-bs-target="#convenioModal" id="btn-convenio" data-rel="">
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0"></p>
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
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1 item-presencial">Ciudad</p>
                <div class="mb-3 box-btn-ciudad item-presencial">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" data-bs-toggle="modal" data-bs-target="#ciudadModal" id="btn-ciudad" data-rel="">
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0"></p>
                        <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Ciudad"> 
                    </button>
                </div>

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
                                            <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="http://127.0.0.1:7000/assets/img/svg/search.svg" alt="veris-especialidad"></span>
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
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1">Especialidad</p>
                <div class="mb-3 box-btn-especialidad">
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
                <p class="text-title-select fw-medium fs--1 mt-3 mb-1 item-presencial">Central médica</p>
                <div class="mb-3 box-btn-central item-presencial">
                    <button class="btn disabled bg-white-80 w-100 btn-sm btn-outline-primary-veris waves-effect d-flex justify-content-between align-items-center pt-3 pb-3 border-1" type="button" data-bs-toggle="modal" data-bs-target="#centralModal" id="btn-central" data-rel="">
                        <p class="fs--1 line-height-16 fw-medium fs--1 mb-0"></p>
                        <img src="{{asset('assets/img/svg/arrow-right.svg')}}" class="ms-1" alt="Filtro Especialidad"> 
                    </button>
                    <span class="mt-1 fs--2 line-height-16 text-light">Seleccionada en base a tus agendamientos anteriores</span>
                </div>
                <button id="btn-continuar" class="btn btn-lg btn-primary-veris w-100 px-4 py-3 fs-5">{{ __('Continuar') }}</button>
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
    // let online = dataCita.online;
    // let numeroPaciente = dataCita.paciente.numeroPaciente;
    // let convenio = dataCita.convenio.codigoConvenio || ' ';


    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        // await consultarEspecialidades();

        if(dataCita.convenio == null){
            await cargarConvenios();
            await consultarCiudadesEspecialidad();
            await consultarCentralesMedicasRecomendadas();
        }

        $('body').on('click','.btn-modalidad', function(){
            if(dataCita.tratamiento == null && dataCita.reservaEdit == null){
                $('#btn-convenio').removeClass('disabled');
            }
            $('#btn-ciudad').removeClass('disabled');
            $('#btn-especialidad').removeClass('disabled');
            $('#btn-central').removeClass('disabled');
            if($(this).attr('data-rel') == "S"){
                $('.item-presencial').addClass('d-none');
                await validarCondicionConvenio();
            }else{
                $('.item-presencial').removeClass('d-none');
            }
        })

        $('body').on('click','.box-btn-convenio', function(){
            if ($(this).find('#btn-convenio').hasClass('disabled')) {
                showMessage('warning','Debe seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click','.box-btn-ciudad', function(){
            if ($(this).find('#btn-ciudad').hasClass('disabled')) {
                showMessage('warning','Debe seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click','.box-btn-especialidad', function(){
            if ($(this).find('#btn-especialidad').hasClass('disabled')) {
                showMessage('warning','Debe seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click','.box-btn-central', function(){
            if ($(this).find('#btn-central').hasClass('disabled')) {
                showMessage('warning','Debe seleccionar una modalidad');
                event.preventDefault(); // Evitar cualquier acción
                return; // Salir de la función
            }
        })

        $('body').on('click', '.btn-modalidad', function(){
            $('.btn-modalidad').addClass('bg-white').removeClass('text-white').removeClass('btn-primary-veris').removeClass('modalidad-selected');
            $(this).addClass('btn-primary-veris').addClass('modalidad-selected').addClass('text-white').removeClass('bg-white');
            dataCita.vua = ($('.btn-modalidad.modalidad-selected').attr('data-rel') == "N") ? true : false;
        })

        $('body').on('click', '#btn-especialidad', async function(){
            await consultarEspecialidades(); 
        })

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

        var $enlace = $('#btn-si-tratamiento');

        // Maneja el evento de clic en el enlace
        $enlace.on('click', function(event) {
            // Previene el comportamiento predeterminado del enlace
            event.preventDefault();

            // Establece un retraso de 2 segundos antes de redirigir
            setTimeout(function() {
                // Obtiene la URL del enlace
                var url = $enlace.attr('href');
                // Redirige a la URL después del retraso
                window.location.href = url;
            }, 500); // Cambia este valor (en milisegundos) para ajustar el tiempo de retraso
        });
    });

    async function cargarConvenios(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/paciente/convenios?canalOrigen=${_canalOrigen}&tipoIdentificacion=${dataCita.paciente.tipoIdentificacion}&numeroIdentificacion=${dataCita.paciente.numeroIdentificacion}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&excluyeNinguno=S`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        // llenar modal
        if (data.code == 200){
            drawConvenios(data.data);
            if(data.data.length > 0){
                //$('#btn-convenio').attr('data-rel',JSON.stringify(dataCita.convenio));
                dataCita.convenio = data.data[0];
                $('#btn-convenio p').html(`${capitalizarCadaPalabra(dataCita.convenio.nombreConvenio)}`);
            }else{
                dataCita.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                }
                $('#btn-convenio p').html(`Ninguno`);
            }
        }
    }

    function drawConvenios(dataConvenios){
        let listaConvenios = $('#listaConvenios');
        let elemento = ``;
        listaConvenios.empty();
        if(dataConvenios.length > 0){
            dataConvenios.forEach((convenios) => {
                elemento += `<div data-rel='${JSON.stringify(convenios)}' class="convenio-item mb-2">
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
            "permitePago": "S",
            "permiteReserva": "S",
            "idCliente": null,
            "codigoConvenio": null,
        };

        elemento += `<div data-rel='${JSON.stringify(sinConvenio)}' class="convenio-item mb-2">
            <div class="list-group-item rounded-3 py-2 px-3 border-0">
                <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios0" value="">
                <label for="listGroupCheckableRadios0" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                    Ninguno
                </label> 
            </div>
        </div>`;;

        listaConvenios.append(elemento); 
    }

    async function consultarCiudadesEspecialidad() {
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
                elemento += `<div data-rel='${JSON.stringify(value)}' class="ciudad-item select-item mb-2">
                    <div class="list-group-item rounded-3 py-2 px-3 border-0">
                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios${value.codigoCiudad}" value="">
                        <label for="listGroupCheckableRadios${value.codigoCiudad}" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                            ${capitalizarCadaPalabra(value.nombreCiudad)}
                        </label> 
                    </div>
                </div>`;
                if(value.esDefault){
                    $('#btn-ciudad p').html(`${capitalizarCadaPalabra(value.nombreCiudad)}`);
                    dataCita.ciudad = value;
                }
            })
            listaCiudades.append(elemento);
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
                data.central = data.data[0];
                $('#btn-central p').html(`${capitalizarCadaPalabra(data.central.nombreSucursal)}`);
            }
        }
        console.log(data);
    }

    function drawCentrales(dataCentrales){
        let listaCentrales = $('#listaCentrales');
        let elemento = ``;
        listaCentrales.empty();
        if(dataCentrales.length > 0){
            dataCentrales.forEach((central) => {
                elemento += `<div class="card h-100 card-central-medica waves-effect shadow-item-modal cursor-pointer item-central-medica central-item select-item" data-central-medica="">
                    <div class="card-body p--2">
                        <div class="d-flex">
                            <div class="avatar avatar-88 me-2" style="background: url(${ (central.nombreFoto != null) ? central.nombreFoto : '{{ asset('assets/img/svg/especialidades/dummy_central.svg') }}' }) no-repeat center center; background-size:cover;">
                            </div>
                            <div class="col">
                                <h6 class="fs--16 line-height-20 fw-medium mb-2">${capitalizarCadaPalabra(central.nombreSucursal)}</h6>
                                <p class="fs--1 line-height-16 mb-0">${capitalizarCadaPalabra(central.direccion)}</p>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }
        listaCentrales.append(elemento); 
    }

    async function consultarCentralesMedicas(){
        let mostrarVua = (dataCita.vua && !dataCita.tratamiento) ? dataCita.vua : false;
        let ciudad = dataCita.ciudad;
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/centrosmedicos?canalOrigen=${canalOrigen}&codigoEmpresa=1&codigoEspecialidad=${codigoEspecialidad}&codigoPais=${ciudad.codigoPais}&codigoProvincia=${ciudad.codigoProvincia}&codigoCiudad=${ciudad.codigoCiudad}&mostrarSucursalPrioritaria=${mostrarVua}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
    }

    async function validacionConvenio(detalle){
        let especialidad = JSON.parse(detalle);
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/validacionConvenio`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["dismissAlert"] = true;
        args["data"] = JSON.stringify({
            "idCliente": dataCita.convenio.idCliente,
            "codigoEspecialidad": parseInt(especialidad.codigoEspecialidad),
            "idPaciente": parseInt(numeroPaciente),
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
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/especialidades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${ $('.btn-modalidad.modalidad-selected').attr('data-rel') }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                data.data.forEach((especialidad) => {
                    elemento += `<div data-rel='${JSON.stringify(especialidad)}' class="col-12 p-2 ps-3 pe-3 rounded-3 d-flex justify-content-start align-items-center bg-white item-especialidad waves-effect shadow-item-modal cursor-pointer especialidad-item" type-rel="button">
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
        }

        return data;
    }

    async function consultarSiEsTratamiento(dataEspecialidad){
        let especialidad = JSON.parse(dataEspecialidad);
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/obtener_tratamiento_compatible?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}&idPaciente=${numeroPaciente}
        &codigoServicio=${ especialidad.codigoServicio }&codigoPrestacion=${ especialidad.codigoPrestacion }&codigoConvenio=${ convenio }`;
        
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        let params = {}
        dataCita.especialidad = especialidad;

        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

        let path_url = "/citas-elegir-central-medica";
        if(online == "S"){
            path_url = "/citas-elegir-fecha-doctor";
        }
        
        if (data.code == 200 && data.data != null){
            $("#btn-no-tratamiento").attr("href",path_url+"/"+ "{{ $params }}" );
            params.tratamiento = data.data;
            let urlParamsSi = JSON.stringify(data.data);
            $("#btn-si-tratamiento").attr("data-rel", urlParamsSi);
            $("#btn-si-tratamiento").attr("href",path_url+"/"+ "{{ $params }}" );

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

            var myModal = new bootstrap.Modal(document.getElementById('citaPendienteModal'));
            myModal.show();
        }else{
            let urlParams = encodeURIComponent(btoa(JSON.stringify(params)));
            location.href = path_url+"/"+ "{{ $params }}" ;
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
</style>
@endpush