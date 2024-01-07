@extends('template.app-template-veris')
@section('title')
Mi Veris - Historia clínica
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Historia clínica') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3" id= "checkEspecialidad">
                <div class="d-flex jusntify-content-start">
                    <div class="form-check form-check-reverse">
                        <input class="form-check-input cursor-pointer" type="checkbox" id="selectAll" />
                        <label class="form-check-label cursor-pointer" for="selectAll"> Seleccionar todos</label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10">
                <div class="row g-3" id="listaDoctores">
                    <!-- items  doctores -->
                    
                    
                    
                </div>
            </div>
            <div class="col-12 col-lg-6 text-center mt-5" id="btnContinuar" >
                <a  class="btn btn-primary-veris w-50 py-3" 
                >Continuar</a>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->


<script>

    // variables globales
    let codigoEspecialidad = {{$codigoEspecialidad}};
    let tipoIdentificacion = {{$tipoIdentificacion}};
    let numeroIdentificacion = {{$numeroIdentificacion}};
    let esOnline = '{{$esOnline}}';
    let informacionDoctor = [];
    let dataDoctor = [];


    // llamada al dom

    document.addEventListener("DOMContentLoaded", async function () {
        await consultarDoctores();
    });


    // funciones asincronas

    // Consultar los doctores según la especialedad seleccionada por el paciente
    async function consultarDoctores() {
        console.log('Consultando doctores...');
         let args = [];
         canalOrigen = _canalOrigen
         codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
         args["endpoint"] = api_url + `/digitalestest/v1/hc/doctores?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEspecialidad=${codigoEspecialidad}&esOnline=${esOnline}`;
         
         args["method"] = "GET";
         args["showLoader"] = true;
         const data = await call(args);
         console.log('datadoc', data);

        if (data.code == 200) {
            console.log('data.data', data.data);
            if (data.data == null) {
                console.log('No hay doctores disponibles');
                // Mostrar mensaje de no hay doctores disponibles
                let html = $('#listaDoctores');
                html.empty();
                let elemento = '';
                elemento = `<div class="col-12 d-flex justify-content-center" id="mensajeNoHayEspecialidades">
                                    <div class="card bg-transparent shadow-none">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/img/svg/doctor_light.svg') }}" class="img-fluid mb-3" alt="">
                                                <h5>${data.message}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                html.append(elemento);

                // Ocultar el checkbox de Seleccionar todos
                $('#checkEspecialidad').addClass('d-none');
                $('#checkEspecialidad').removeClass('d-block');
               
                // Ocultar el botón de Continuar
                $('#btnContinuar').addClass('d-none');
                $('#btnContinuar').removeClass('d-block');
            } 
            else if (data.data.length > 0) {
                dataDoctor = data.data;
                console.log('Hay doctores disponibles');
                let html = $('#listaDoctores');
                html.empty();
                let elemento = '';

                data.data.forEach((element, index) => {
                    elemento += `<div class="col-12 col-md-4">
                                    <label class="form-check-label cursor-pointer" for="flexCheckDefault-${index}">
                                        <div class="card">
                                            <div class="card-body p-2 pe-3">
                                                <div class="row gx-2 align-items-center">
                                                    <div class="col-3">
                                                        <img src='${quitarComillas(element.imagen)}' onerror="this.src='{{ asset('assets/img/svg/avatar_doctor.svg') }}'" class="card-img-top" width="62" alt="centro medico">
                                                    </div>
                                                    <div class="col-8">
                                                        <h6 class="fs--1 fw-bold mb-0">Dr(a) ${element.nombreMedico}</h6>
                                                        <p class="fs--2 mb-0">${element.nombreEspecialidad}</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input cursor-pointer" type="checkbox" value="" id="flexCheckDefault-${index}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>`;
                });

                html.append(elemento);

                // Agregar Event Listener a los Checkbox
                data.data.forEach((element, index) => {
                    $(`#flexCheckDefault-${index}`).on('change', function() {
                        if (this.checked) {
                            console.log('Nombre del Médico:', element.codigoMedico);
                            console.log('Especialidad:', element.codigoEspecialidad);

                            // Agregar la información del doctor al array
                            informacionDoctor.push({
                                codigoMedico: element.codigoMedico,
                                codigoEspecialidad: element.codigoEspecialidad
                            });
                        } else {
                            // Eliminar la información del doctor del array
                            informacionDoctor = informacionDoctor.filter(function (el) {
                                return el.codigoMedico !== element.codigoMedico;
                            });
                        }

                        // Para depuración, imprimir el estado actual
                        console.log('Estado actual de informacionDoctor:', informacionDoctor);
                    });
                });
            }
        }
        return data;
    }

    // funciones js 

    $('#btnContinuar').on('click', function () {
        console.log('informacionDoctor:', informacionDoctor);
        if (informacionDoctor.length > 0) {
            // Convertir el array a una cadena JSON
            let jsonStr = JSON.stringify(informacionDoctor);
            
            // Codificar la cadena JSON para URL
            let encodedJsonStr = encodeURIComponent(jsonStr);

            // Obtener los valores adicionales
            let codigoEspecialidad = {{$codigoEspecialidad}};
            let tipoIdentificacion = {{$tipoIdentificacion}};
            let numeroIdentificacion = {{$numeroIdentificacion}};

            // Crear la URL con todos los parámetros
            let url = "{{route('historiaClinica.solicitar')}}?doctores=" + encodedJsonStr +
                    "&codigoEspecialidad=" + codigoEspecialidad +
                    "&tipoIdentificacion=" + tipoIdentificacion +
                    "&numeroIdentificacion=" + numeroIdentificacion +
                    "&esOnline=" + esOnline;

            // Redireccionar a la nueva URL
            window.location.href = url;
        } 
    });

    // Event Listener para el Checkbox 'Seleccionar todos'
    $('#selectAll').on('change', function() {
        let isSelectAllChecked = $(this).is(':checked');

        dataDoctor.forEach((element, index) => {
            $(`#flexCheckDefault-${index}`).prop('checked', isSelectAllChecked);

            if (isSelectAllChecked) {
                if (!informacionDoctor.some(el => el.codigoMedico === element.codigoMedico)) {
                    informacionDoctor.push({
                        codigoMedico: element.codigoMedico,
                        codigoEspecialidad: element.codigoEspecialidad
                    });
                }
            } else {
                informacionDoctor = [];
            }
        });

        // Para depuración, imprimir el estado actual
        console.log('Estado actual de informacionDoctor:', informacionDoctor);
    });










</script>
@endpush