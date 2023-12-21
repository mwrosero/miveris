@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elige la especialidad
@endsection
@section('content')
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
        <div class="row">
            <div class="col-6 col-md-3 mb-3">
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
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/cardiologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Cardiología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/cirugia_general.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Cirugía general') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/cirugia_maxilo_facial.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Cirugía maxilo-facial') }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/cirugia_oncológica.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Cirugía oncológica') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/cirugia_vascular.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Cirugía vascular') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/dermatolgia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Dermatolgía') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/endocrinologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Endocrinología') }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/fisiatria.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Fisiatría') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/gastroenterologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Gastroenterología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/geriatria.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Geriatría') }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/ginecologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Ginecología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/medicina_general.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Medicina general') }} </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/medicina_interna.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Medicina interna') }} </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/nefrologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Nefrología') }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/neurologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Neurología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/nutricion_dietetica.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Nutrición y dietética') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/oftalmologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Oftalmología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/optometria.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Optometría') }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/otrorrinolaringologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Otrorrinolaringología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/pediatria.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Pediatría') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/psicologia_clinica.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Psicología clínica') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/psiquiatria.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Psiquiatría') }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/reumatolologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Reumatolología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/terapia_fisica.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Terapia física') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/traumatologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Traumatología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body px-2 text-center">
                        <a href="{{route('citas.listaCentralMedica')}}">
                            <div class="avatar avatar-lg mx-auto">
                                <div class="avatar-especialidad">
                                    <img src="{{ asset('assets/img/svg/especialidades/urologia.svg') }}" alt="especialidad">
                                </div>
                            </div>
                            <p class="text-veris fs--2 fw-bold mb-0">{{ __('Urología') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    // variables globales

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarCiudadesEspecialidad();
    });


    // funciones asyncronas
    // agendamiento consulta de ciudades

    async function consultarCiudadesEspecialidad() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitales/v1/agenda/ciudades?canalOrigen=${canalOrigen}&codigoEmpresa=1&excluyeVirtual=false `;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('ciudades', data);
        

        return data;
    }


    

</script>
@endpush