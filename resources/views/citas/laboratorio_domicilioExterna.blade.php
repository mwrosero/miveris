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
    // dd(Session::get('userData'));
@endphp
<!-- Modal Permite Cambio -->
<div class="modal fade" id="modalCobertura" tabindex="-1" aria-labelledby="modalCoberturaLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3">
                <h1 class="modal-title fs-5 fw-medium mb-3">Veris</h1>
                <p class="fs--1 fw-normal" id="mensajeNoCobertura"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
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
                    <button type="button" class="btn btn-primary-veris fs--18 line-height-24 w-100 m-0 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Laboratorio a domicilio') }}</h5>
    </div>
    <div id="map" style="height: 400px;"></div>
    <input id="searchBox" class="form-control w-75 ms-2 mt-3 mb-3 w-50 mx-auto d-none" type="text" placeholder="Buscar ubicación">

    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <label for="ciudad" class="form-label fw-medium fs--1">Selecciona tu Ciudad *</label>
                                <select class="form-select fs--1 p-3" name="ciudad" id="ciudad" required>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="direccion" class="form-label fw-medium fs--1">Dirección *</label>
                                <textarea class="form-control fs--1 p-3" name="direccion" id="direccion" rows="3" required style="resize: none;"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-medium fs--1">Cédula o pasaporte *</label>
                                <input type="text" class="form-control fs--1 p-3" name="numeroIdentificacion" id="numeroIdentificacion"  required />
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-medium fs--1">Email *</label>
                                <input type="email" class="form-control fs--1 p-3" name="email" id="email"  required />
                            </div>
                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-medium fs--1">Teléfono *</label>
                                <input type="number" class="form-control fs--1 p-3" name="telefono" id="telefono"  required />
                            </div>
                            <div class="col-md-12">
                                <label for="convenio" class="form-label fw-medium">Convenio *</label>
                                <input type="text" class="form-control fs--1 p-3" name="convenio" id="convenio" placeholder="Convenio" disabled />
                            </div>
                            <div class="col-md-12">
                                <label for="referencias" class="form-label fw-medium fs--1">Referencias *</label>
                                <textarea class="form-control" name="referencias" id="referencias" rows="3" required style="resize: none;"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary-veris w-100 fs--18 fw-medium line-leight-24 px-4 py-3 waves-effect waves-light shadow-none" type="submit"  id="btnSiguiente" disabled>Siguiente</button>
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
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_tHt53kdevXWEWJii_qfBOsjf7fjI510&libraries=places&callback=initMap" async defer>
</script>

<script>
    var map = null;
    var marker = null;
    var markers = [];
    var lat_tmp = -2.177526;
    var long_tmp = -79.898608;
    function initMap() {
        var myOptions = {
            center: { lat: parseFloat(lat_tmp), lng: parseFloat(long_tmp)},
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP, // Configuración inicial del tipo de mapa
            mapTypeControl: false,
            clickableIcons: false,
            streetViewControl: false,
            fullscreenControl: true
        };

        map = new google.maps.Map(document.getElementById("map"), myOptions);
        var image = {
            url: "https://www.veris.com.ec/wp-content/themes/xstore/images/marker.png",
            scaledSize : new google.maps.Size(70, 56),
        };
        marker = new google.maps.Marker({
            draggable: true,
            position: new google.maps.LatLng(lat_tmp,long_tmp),
            map: map,
            title: "Domicilio Toma de muestra"
            //icon: image
        });

        marker.setMap(map);

        var input = document.getElementById('searchBox');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            var location = places[0].geometry.location;
            var lat = location.lat();
            var lng = location.lng();

            window.setTimeout(function() {
                const center = new google.maps.LatLng(location.lat(), location.lng());
                marker.setPosition(center);
                // using global variable:
                window.map.panTo(center);
            }, 100);

            // Eliminar los marcadores existentes
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            console.log("Latitud: "+event.latLng.lat());
            console.log("Longitud: "+event.latLng.lng());
            lat_tmp = event.latLng.lat();
            long_tmp = event.latLng.lng();
            window.setTimeout(function() {
                const center = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
                // using global variable:
                window.map.panTo(center);
            }, 100);
        });

        google.maps.event.addListener(map, 'click', function(event) {
            console.log("Latitud: "+event.latLng.lat());
            console.log("Longitud: "+event.latLng.lng());
            lat_tmp = event.latLng.lat();
            long_tmp = event.latLng.lng();
            marker.setPosition(event.latLng);
            window.setTimeout(function() {
                const center = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
                // using global variable:
                window.map.panTo(center);
            }, 100);
        });

        setTimeout(function(){
            $('#searchBox').removeClass('d-none');
        },1500)

        // Solicitar ubicación actual al usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Actualizar mapa y marcador con la ubicación actual
                map.setCenter(pos);
                marker.setPosition(pos);
            }, function () {
                handleLocationError(true, marker, map.getCenter());
            });
        } else {
            // El navegador no soporta geolocalización
            handleLocationError(false, marker, map.getCenter());
        }

        /*var input = document.getElementById('searchTextField');
        new google.maps.places.Autocomplete(input);*/

    }

    // Manejar errores de geolocalización
    function handleLocationError(browserHasGeolocation, marker, pos) {
        marker.setPosition(pos);
        marker.setTitle(browserHasGeolocation ?
            'Error: La geolocalización ha fallado.' :
            'Error: Tu navegador no soporta geolocalización.');
    }


    async function obtenerLatitudYLongitudDelMarcador() {
        var position = marker.getPosition();
        var latitud = position.lat();
        var longitud = position.lng();
        
        return { latitud: latitud, longitud: longitud };
    }

    // variables globales

    let params = @json($data);

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarCiudadesEspecialidad();
        llenarDatos();

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
            let lnglat = await obtenerLatitudYLongitudDelMarcador();
            let validarCobertura = await consultarCobertura(lnglat.latitud, lnglat.longitud);
            if(validarCobertura.code == 400 || !validarCobertura.data.tieneCobertura || validarCobertura.data.tieneCobertura == "N"){
                let msg = "";
                if(validarCobertura.code == 400){
                    msg = validarCobertura.message;
                }else{
                    msg = validarCobertura.data.mensaje;
                }
                $('#mensajeNoCobertura').html(msg);
                $('#modalCobertura').modal('show');
                return;
            }

            // setear datos en localstorage
            dataCita.paciente.direccion = $('#direccion').val();
            dataCita.paciente.numeroIdentificacion = $('#numeroIdentificacion').val();
            dataCita.paciente.correo = $('#email').val();
            dataCita.paciente.telefono = $('#telefono').val();
            dataCita.paciente.referencias = $('#referencias').val();
            dataCita.paciente.codigoCiudad = $('#ciudad').val();
            dataCita.paciente.nombreCiudad = $('#ciudad option:selected').text();
            // longitud y latitud
            dataCita.paciente.latitud = lnglat.latitud;
            dataCita.paciente.longitud = lnglat.longitud;
            dataCita.esDomicilio = true;
            dataCita.origen = "ordenExternaDomicilio";

            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

            window.location.href = `/registrar-orden-externa/{{ $params }}`;
        });
        
    });

    async function consultarCobertura(latitud, longitud) {
        let args = [];
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/domicilio/laboratorio/coberturaServicio?canalOrigen=${_canalOrigen}&latitud=${latitud }&longitud=${longitud}`;
        args["method"] = "GET";
        args["dismissAlert"] = true;
        args["showLoader"] = false;
        const data = await call(args);
        return data;
    }

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

    // llenar datos con localstorage
    function llenarDatos(){
        console.log('dataCita', dataCita);
        if(dataCita){
            $('#direccion').val(dataCita.paciente.direccion);
            $('#numeroIdentificacion').val(dataCita.paciente.numeroIdentificacion);
            $('#email').val(dataCita.paciente.correo);
            $('#telefono').val(dataCita.paciente.telefono);
            $('#convenio').val(`${ (typeof dataCita !== 'undefined' && dataCita.convenio && typeof dataCita.convenio.nombreConvenio !== 'undefined') ? dataCita.convenio.nombreConvenio : "Ninguno" }`);
        }

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
    }

</script>
    
@endpush