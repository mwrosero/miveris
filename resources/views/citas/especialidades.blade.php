@extends('template.app-template-veris')
@section('title')
Elige la especialidad
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd($data);
@endphp
<!-- Modal mensaje -->
<div class="modal fade" id="modalEmbarazo" tabindex="-1" aria-labelledby="modalEmbarazoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3">
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
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Elige la especialidad') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6 mb--24">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-especialidad"></span>
                    <input type="search" class="form-control bg-transparent fs--16 border-0 p-3 ps-0" name="buscar" id="buscar" placeholder="Buscar especialidad" aria-describedby="buscar" />
                </div>
            </div>
        </div>
        <div class="row g-3" id="listaEspecialidades">
            {{-- <div class="col-6 col-md-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/alergologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-medium mb-0">{{ __('Alergología') }}</p>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    // variables globales
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let online = dataCita.online;
    let numeroPaciente = dataCita.paciente.numeroPaciente;
    let convenio = dataCita.convenio.codigoConvenio || ' ';


    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarEspecialidades();

        $('body').on('click', '.item-especialidad', async function(){
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
        })

        $('body').on('input','#buscar', function () {
            var value = $(this).val().toLowerCase();
            $("#listaEspecialidades .item-especialidad").filter(function () {
                let text = $(this).text().toLowerCase();
                if(text.indexOf(value) > -1 || value === "") {
                    $(this).parent().removeClass("d-none");
                }else{
                    $(this).parent().addClass("d-none");
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
        args["endpoint"] = api_url + `/${api_war}/v1/agenda/especialidades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online=${online}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(77,data);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                listaEspecialidades.empty();

                data.data.forEach((especialidad) => {
                    let params = {}
                    params.especialidad = especialidad;
                    let urlParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    let path_url = "citas-elegir-central-medica";
                    if(params.online == "S"){
                        path_url = "citas-elegir-fecha-doctor";
                    }
                    elemento += `<div class="col-6 col-md-3">
                                    <div class="card item-especialidad h-100" type="button" data-rel='${ JSON.stringify(especialidad) }'>
                                        <div class="card-body px-3 py-2 text-center">
                                            <div class="w-100">
                                                <div class="avatar avatar-18 mx-auto mb-2">
                                                    <div class="avatar-especialidad">
                                                        <img src="${especialidad.imagen}" alt="${especialidad.nombre}">
                                                    </div>
                                                </div>
                                                <p class="text-veris fs--2 fw-medium text-one-line mb-0">${capitalizarCadaPalabra(especialidad.nombre)}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
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
@endpush