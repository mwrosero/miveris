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
                    <p class="fs--1 fw-medium m-0 mt-3" id="mensajeOrden">Orden generada exitosamente</p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Laboratorio a domicilio') }}</h5>
    </div>
    <div id="map" style="height: 400px;"></div>
    <input id="searchBox" class="form-control mt-3 mb-3 w-50 mx-auto" type="text" placeholder="Buscar ubicación">

    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <label for="ciudad" class="form-label fw-medium">Selecciona tu Ciudad *</label>
                                <select class="form-select" name="ciudad" id="ciudad" required>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="direccion" class="form-label fw-medium">Dirección *</label>
                                <textarea class="form-control" name="direccion" id="direccion" rows="3" required style="resize: none;"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-medium">Cédula o pasaporte *</label>
                                <input type="text" class="form-control bg-neutral" name="numeroIdentificacion" id="numeroIdentificacion"  required />
                            </div>

                            <div class="col-md-12">
                                <label for="email" class="form-label fw-medium">Email *</label>
                                <input type="email" class="form-control " name="email" id="email"  required />
                            </div>

                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-medium">Teléfono *</label>
                                <input type="number" class="form-control" name="telefono" id="telefono"  required />
                            </div>

                            <div class="col-md-12">
                                <label for="referencias" class="form-label fw-medium">Referencias *</label>
                                <textarea class="form-control" name="referencias" id="referencias" rows="3" required style="resize: none;"></textarea>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"  id="btnSiguiente" disabled
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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_tHt53kdevXWEWJii_qfBOsjf7fjI510&callback=initMap&libraries=places">
</script>

<script>
    let longitud;
    let latitud;
    function initMap() {
        // Opciones por defecto del mapa
        var mapOptions = {
            center: {lat: -34.397, lng: 150.644}, // Coordenadas por defecto
            zoom: 8
        };

        // Crear mapa
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Agregar Autocompletado
        var input = document.getElementById('searchBox');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Sesgar los resultados del SearchBox hacia la vista actual del mapa.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Escuchar el evento cuando un usuario selecciona una predicción y recupera
        // más detalles para ese lugar.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Eliminar los marcadores existentes
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // Para cada lugar, obtener el icono, nombre y ubicación.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("El lugar devuelto no contiene geometría");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Crear un marcador para cada lugar.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Solo geocodifica si el lugar tiene una geometría.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        // Intentar geolocalizar al usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                // setear longitud y latitud
                longitud = position.coords.longitude;
                latitud = position.coords.latitude;

                // Centrar el mapa en la ubicación del usuario
                map.setCenter(userLocation);
                map.setZoom(14); // Ajustar el zoom para acercar al usuario

                // Opcional: Colocar un marcador en la ubicación del usuario
                var marker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    title: 'Tu ubicación'
                });
            }, function() {
                handleLocationError(true, map.getCenter());
            });
        } else {
            // El navegador no soporta Geolocalización
            handleLocationError(false, map.getCenter());
        }
    }

    // Función para manejar errores de geolocalización
    function handleLocationError(browserHasGeolocation, pos) {
        console.log(browserHasGeolocation ?
                    'Error: El servicio de Geolocalización falló.' :
                    'Error: Tu navegador no soporta geolocalización.');
    }

</script>
<script>

    // variables globales

    let params = @json($data);

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarCiudadesEspecialidad();
        llenarDatos();

        
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

    // disable button si hay campos vacios
    $("form input, form textarea").on('keyup', function(){
        let disabled = false;
        $("form input, form textarea").each(function(){
            if($(this).val() == ""){
                disabled = true;
            }
        });

        if(disabled){
            $('#btnSiguiente').attr('disabled', true);
        }else{
            $('#btnSiguiente').attr('disabled', false);
        }
    });

    $("form").on('submit', async function(e) {
        e.preventDefault(); 

        // setear datos en localstorage
        
        dataCita.paciente.direccion = $('#direccion').val();
        dataCita.paciente.numeroIdentificacion = $('#numeroIdentificacion').val();
        dataCita.paciente.correo = $('#email').val();
        dataCita.paciente.telefono = $('#telefono').val();
        dataCita.paciente.referencias = $('#referencias').val();
        dataCita.paciente.codigoCiudad = $('#ciudad').val();
        dataCita.paciente.nombreCiudad = $('#ciudad option:selected').text();
        // longitud y latitud
        dataCita.paciente.longitud = longitud;
        dataCita.paciente.latitud = latitud;
        dataCita.esDomicilio = true;
        dataCita.origen = "ordenExternaDomicilio";

        

        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

        window.location.href = `/registrar-orden-externa/{{ $params }}`;
    });


    // llenar datos con localstorage
    function llenarDatos(){
        console.log('dataCita', dataCita);
        if(dataCita){
            $('#direccion').val(dataCita.paciente.direccion);
            $('#numeroIdentificacion').val(dataCita.paciente.numeroIdentificacion);
            $('#email').val(dataCita.paciente.correo);
            $('#telefono').val(dataCita.paciente.telefono);
        }
    }

</script>
    
@endpush