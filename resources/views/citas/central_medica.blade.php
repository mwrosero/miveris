@extends('template.app-template-veris')
@section('title')
Elige central médica
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData')->codigoProvincia);
// dd(Session::get('userData')->codigoCiudad);

@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elige central médica') }}</h5>
    <section class="p-3 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-12 col-md-4 mb-4">
                <select class="form-select form-filter border-0" name="ciudad" id="ciudad">
                    {{-- <option selected disabled value="">Elegir ciudad</option>
                    <option value="">{{ __('Guayaquil') }}</option>
                    <option value="">{{ __('Quito') }}</option>
                    <option value="">{{ __('Duran') }}</option>
                    <option value="">{{ __('Cuenca') }}</option> --}}
                </select>
            </div>
        </form>
        <div class="row gy-3 justify-content-center">
            <div class="col-auto col-lg-10">
                <div class="row gy-3" id="listaCentrales">
                    {{-- <div class="col-auto col-md-6">
                        <div class="card">
                            <div class="card-body px-2 py-2">
                                <div class="row gx-2">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img/card/avatar_central_medica.png') }}" class="card-img-top" alt="centro medico">
                                    </div>
                                    <div class="col-9">
                                        <h6 class="fw-medium mb-1">{{ __('VERIS - ALBORADA') }}</h6>
                                        <p class="fs--2">{{ __('Av. Rodolfo Baquerizo Nazur y José María Egas') }}.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end pb-2">
                                <a href="/citas-elegir-fecha-doctor" class="btn btn-sm btn-primary-veris">{{ __('Ver Medicos') }}</a>
                            </div>
                        </div>
                    </div> --}}
                </div>
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
    let online = dataCita?.online;
    let codigoEspecialidad = dataCita.especialidad.codigoEspecialidad;

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarCiudadesEspecialidad();
        $('body').on('change', '#ciudad', consultarCentralesPorCiudad);
    });

    // Listener para el botón 'Ver Médicos'
    $('body').on('click', '.btn-ver-medicos', function (e) {
        e.preventDefault();
        let centralMedica = $(this).closest('.card-central-medica').data('central-medica');
        guardarCentralEnLocalStorage(centralMedica);
    });



    async function consultarCiudadesEspecialidad() {
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/ciudades?canalOrigen=${_canalOrigen}&codigoEmpresa=1&excluyeVirtual=false `;
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);

        if(data.code == 200){
            $('#ciudad').empty();
            $.each(data.data, function(key, value){
                if(value.codigoProvincia != 25){
                    let selectedAttr = "";
                    if(value.codigoProvincia == {{Session::get('userData')->codigoProvincia}} && value.codigoCiudad == {{Session::get('userData')->codigoCiudad}}){
                        selectedAttr = "selected"
                    }
                    $('#ciudad').append(`<option ${selectedAttr} data-rel='${JSON.stringify(value)}' value="${value.codigoCiudad}">${value.nombreCiudad}</option>`);
                }
            })
            await consultarCentralesPorCiudad();
        }

        return data;
    }

    async function consultarCentralesPorCiudad(){
        let listaCentrales = $('#listaCentrales');
        listaCentrales.empty();
        let ciudad = JSON.parse($('#ciudad option:selected').attr("data-rel"));
        
        let args = [];
        args["endpoint"] = api_url + `/digitalestest/v1/agenda/centrosmedicos?canalOrigen=${_canalOrigen}&codigoEmpresa=1&codigoEspecialidad=${codigoEspecialidad}&codigoPais=${ciudad.codigoPais}&codigoProvincia=${ciudad.codigoProvincia}&codigoCiudad=${ciudad.codigoCiudad}&mostrarSucursalPrioritaria=true`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                listaCentrales.empty();

                //data.data.forEach((central) => {
                for (const central of data.data) {
                    let params = {};
                    dataCita.central = central;
                    
                    let urlParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    let path_central = "{{ asset('assets/img/card/avatar_central_medica.png') }}";

                    /*const existeImagen = await verificarImagen(central.nombre_foto);
                    if (existeImagen) {
                        path_central = central.nombre_foto;
                    }*/
                    
                    console.log(99)
                    elemento += `<div class="col-12 col-md-6">
                                    <div class="card h-100 card-central-medica" data-central-medica='${ JSON.stringify(central) }'>
                                        <div class="card-body px-2 py-2">
                                            <div class="row gx-2">
                                                <div class="col-3">
                                                    <img src="${path_central}" class="card-img-top" alt="${central.nombreTipoSucursal}">
                                                </div>
                                                <div class="col-9">
                                                    <h6 class="fw-medium mb-1">${central.nombreSucursal}</h6>
                                                    <p class="fs--2">${central.direccion}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end pb-2">
                                            <a href="/citas-elegir-fecha-doctor/{{$params}}"
                                            class="btn btn-sm btn-primary-veris btn-ver-medicos">{{ __('Ver Médicos') }}</a>
                                        </div>

                                    </div>
                                </div>`
                };
                
            } else {
                listaCentrales.empty();
                elemento += `<div class="col-12">
                                <div class=" fs--2 rounded-3 p-2">
                                    {{ __('No existe data que mostrar') }}
                                </div>
                            </div> `;
            }
            
            listaCentrales.append(elemento);    
        }

        return data;
    }

    function guardarCentralEnLocalStorage(centralMedica) {
        // Aquí guardamos la central médica seleccionada en dataCita y luego en localStorage
        dataCita.central = centralMedica;
        dataCita.origen = 'central';
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

        window.location.href = "/citas-elegir-fecha-doctor/{{$params}}";
    }

</script>
@endpush