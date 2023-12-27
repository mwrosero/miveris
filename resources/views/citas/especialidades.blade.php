@extends('template.app-template-veris')
@section('title')
Elige la especialidad
@endsection
@section('content')
@php
$data = json_decode(base64_decode($params));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="citaPendienteModal" tabindex="-1" aria-labelledby="citaPendienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-header border-0 d-none">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h6 class="fw-bold mb-4">Tienes una <b class="text-primary-veris">{{ __('cita pendiente') }}</b> {{ __('de esta especialidad en tu tratamiento de') }}:</h6>
                    <div class="border rounded-3 mb-3 p-3">
                        <div id="chart-progress" data-porcentaje="10" data-color="success"><i class="bi bi-check2 position-absolute top-25 start-40 success"></i></div>
                        <h5 class="card-title h6 fw-bold mb-2 text-primary-veris">{{ __('Traumatología') }}</h5>
                        <p class="fs--2 mb-0">{{ __('Tratamiento enviado') }}: <b class="fw-normal text-primary-veris" id="fechaCitaPendiente">{{ __('SEP 09, 2022') }}</b></p>
                    </div>
                    <p class="fw-bold">{{ __('¿Estas agendando por este motivo?') }}</p>
                    <button type="button" class="btn btn-primary-veris w-100 mb-3">{{ __('Agendar esta orden') }}</button>
                    <button type="button" class="btn btn-outline-primary-veris w-100 mb-3" data-bs-dismiss="modal">{{ __('No') }}</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elige la especialidad') }}</h5>
    <section class="p-3 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0" id="search"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control bg-transparent border-0" name="search" id="search" placeholder="Buscar especialidad" aria-describedby="search" />
                </div>
            </div>
        </form>
        <div class="row" id="listaEspecialidades">
            {{-- <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/alergologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Alergología') }}</p>
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

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarEspecialidades();
    });

    async function consultarEspecialidades(){
        let listaEspecialidades = $('#listaEspecialidades');
        listaEspecialidades.empty();
        
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/especialidades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&online={{ $data->online }}`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                listaEspecialidades.empty();

                data.data.forEach((especialidad) => {
                    let params = @json($data);
                    params.especialidad = especialidad;
                    let urlParams = btoa(JSON.stringify(params));
                    let path_url = "citas-elegir-central-medica";
                    if(params.online == "S"){
                        path_url = "citas-elegir-fecha-doctor";
                    }
                    elemento += `<div class="col-6 col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body px-2 text-center">
                                            <a href="/${path_url}/${urlParams}">
                                                <div class="avatar avatar-lg mx-auto">
                                                    <div class="avatar-especialidad">
                                                        <img src="${especialidad.imagen}" alt="${especialidad.nombre}">
                                                    </div>
                                                </div>
                                                <p class="text-veris fs--2 fw-bold mb-0">${especialidad.nombre}</p>
                                            </a>
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

</script>
@endpush