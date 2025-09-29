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
<!-- Modal No Cobertura -->
<div class="modal fade" id="modalCobertura" tabindex="-1" aria-labelledby="modalCoberturaLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3 pb-0">
                <h1 class="fs-24 fw-medium line-height-28 my-3">Lo sentimos</h1>
                <p class="fs--1 line-height-16 text-veris mb-3" id="mensajeNoCobertura">No tenemos cobertura de servicio a domicilio en el sector.</p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                <button type="button" class="btn btn-primary-veris fs--18 line-height-24 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cobertura -->
<div class="modal fade" id="modalSiCubre" tabindex="-1" aria-labelledby="modalSiCubreLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3 pb-0">
                <i class="fa-solid fa-circle-check me-2 text-veris-ai my-3" style="font-size: 48px;"></i>
                <h1 class="fs-18 fw-medium line-height-24 my-3 w-100">Si tenemos cobertura</h1>
            </div>
        </div>
    </div>
</div>
<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-0">
        <div class="row g-0 justify-content-center">
            <div class="col-auto ps-3 pe-3" style="min-width: 375px;">
                <p class="card-body fw-medium fs--18 mt-3 mb-2">Ingresa una dirección </p>
                <p class="card-body fs--14 mb-2">Verificaremos que tengamos cobertura en el sector.</p>
                <input id="searchBox" class="form-control my-3 p-3 w-100 mx-auto" type="text" placeholder="Buscar ubicación">
                <div id="map" style="height: 400px;"></div>
                <button type="button" class="btn bg-veris-ai text-white btn-verificar w-100 fs--18 line-height-24 fw-medium px-4 py-3 rounded-3 mt-5">Verificar</button>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\Veris::API_KEY_GOOGLE_MAP }}&libraries=places&callback=initMap" async defer>
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
            url: "{{asset('assets/img/svg/icon-ubicar.svg')}}",
            scaledSize : new google.maps.Size(70, 56),
        };
        marker = new google.maps.Marker({
            draggable: true,
            position: new google.maps.LatLng(lat_tmp,long_tmp),
            map: map,
            title: "Ubicar",
            icon: image
        });

        marker.setMap(map);

        var input = document.getElementById('searchBox');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

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

        $('body').on('click', '.btn-verificar', async function(){
            let lnglat = await obtenerLatitudYLongitudDelMarcador();
            let validarCobertura = await consultarCobertura(lnglat.latitud, lnglat.longitud);
            if(validarCobertura.code == 200){
                if(validarCobertura.data.tieneCobertura === "S"){
                    $('#modalSiCubre').modal('show');
                    let url = '/citas-elegir-paciente/'
                    console.log("SI")
                    setTimeout(function(){
                        location.href = url + "{{ $params }}";
                    }, 800)
                }else{
                    $('#mensajeNoCobertura').html(validarCobertura.data.mensaje)
                    $('#modalCobertura').modal('show');
                }
            }else{
                alert(validarCobertura.message)
            }
        })
        
    });

    async function consultarCobertura(latitud, longitud) {
        let args = [];
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/domicilio/laboratorio/coberturaServicio?canalOrigen=${_canalOrigen}&latitud=${latitud }&longitud=${longitud}`;
        args["method"] = "GET";
        args["dismissAlert"] = true;
        args["showLoader"] = true;
        const data = await call(args);
        return data;
    }

</script>
    
@endpush