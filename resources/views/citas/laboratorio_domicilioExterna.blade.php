@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Laboratorio a domicilio Orden Externa
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $data = json_decode(base64_decode($params));
@endphp
<div class="flex-grow-1 container-p-y pt-0">


      <!-- Modal mensaje -->
      <div class="modal fade" id="mensajeOrdenExitosa" tabindex="-1" aria-labelledby="mensajeOrdenExitosaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <i class="bi bi-check-circle-fill text-primary-veris h2"></i>
                    <p class="fs--1 fw-bold m-0 mt-3">Tu orden ha sido enviada exitosamente</p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>


    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Laboratorio a domicilio') }}</h5>
    <div id="map" style="height: 400px;"></div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        

                        <form class="row g-3" enctype="multipart/form-data">
                            


                            <div class="col-md-12">
                                <label for="ciudad" class="form-label fw-bold">Selecciona tu Ciudad *</label>
                                <select class="form-select bg-neutral" name="ciudad" id="ciudad" required>
                                    
                                </select>
                            </div>
                            

                            <div class="col-md-12">
                                <label for="direccion" class="form-label fw-bold">Dirección *</label>
                                <textarea class="form-control" name="direccion" id="direccion" rows="3" required style="resize: none;"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-bold">Cédula o pasaporte *</label>
                                <input type="text" class="form-control bg-neutral" name="numeroIdentificacion" id="numeroIdentificacion"  required />
                            </div>


                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold">Email *</label>
                                <input type="email" class="form-control bg-neutral" name="email" id="email"  required />
                            </div>


                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                                <input type="number" class="form-control bg-neutral" name="telefono" id="telefono"  required />
                            </div>


                            <div class="col-md-12">
                                <label for="referencias" class="form-label fw-bold">Referencias *</label>
                                <textarea class="form-control" name="referencias" id="referencias" rows="3" required style="resize: none;"
                                ></textarea>
                            </div>


                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"
                                >Siguiente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- imagen -->


<script>
 
    
</script>
<script async
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8
        });
    }
</script>
<script>

    // variables globales

    let params = @json($data);
    console.log('params', params);

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarCiudadesEspecialidad();

        
    });

    async function consultarCiudadesEspecialidad() {
        let args = [];
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
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
        }

        return data;
    }

    $("form").on('submit', async function(e) {
        e.preventDefault(); 

        // enviar datos por parametros
        params.Uciudad = $('#ciudad').val();
        params.Udireccion = $('#direccion').val();
        params.UnumeroIdentificacion = $('#numeroIdentificacion').val();
        params.Uemail = $('#email').val();
        params.Utelefono = $('#telefono').val();
        params.Ureferencias = $('#referencias').val();

        let ulrParams = btoa(JSON.stringify(params)); 
        console.log('ulrParams', ulrParams);
        
        window.location.href = `/registrar-orden-externa/${ulrParams}`;
    });
</script>
    
@endpush