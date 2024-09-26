@extends('template.external')
@section('title')
Veris - Farmacia QR
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
<script src="{{ asset('assets/external/farmacia-qr/instascan.min.js') }}"></script>
<script src="{{ asset('assets/external/farmacia-qr/adapter-latest.js') }}"></script>

@include('external.components.navbar', ['showUser' => true])
{{-- Modal Nueva Solicitud --}}
<div class="modal fade" id="nuevaSolicitud" tabindex="-1" aria-labelledby="nuevaSolicitud" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaSolicitudLabel">Ingresar Nº Solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Nº Código:</label>
                        <input type="number" id="numeroSolicitud" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-veris btn-buscar fw-medium fs--18 m-0 w-100 px-4 py-3">Procesar Completado</button>
                <button type="button" class="btn fw-normal fs--16 line-height-20 m-0 px-3 py-2" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal info Cliente --}}
<div class="modal fade" id="infoPaciente" tabindex="-1" aria-labelledby="infoPaciente" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoPacienteLabel">Código de Solicitud: #<span class="codigoHeader"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Nº Identificación:</label>
                        <p class="p_info numeroIdentificacion"></p>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Nombres:</label>
                        <p class="p_info nombrePaciente"></p>
                    </div>
                    <input type="hidden" id="codigoSolicitudProcesar">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-veris btn-procesar fw-medium fs--18 m-0 w-100 px-4 py-3">Procesar Completado</button>
                <button type="button" class="btn fw-normal fs--16 line-height-20 m-0 px-3 py-2" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="flex-grow-1 container-p-y pt-0">
    <section class="mb-3 p-3 pt-0">
        <div class="row mt-2">
            <div class="col-12 col-md-4" id="box-show-camera">
                <button id="btn-camera" class="btn btn-light"><img width="32" src="{{ asset('assets/external/farmacia-qr/camera-on.svg') }}" alt=""> ACTIVAR CÁMARA</button>
            </div>
            <div class="col-12 col-md-4 d-none" id="box-hide-camera" onclick="hideCamera();">
                <button id="btn-camera-off" class="btn btn-light"><img width="32" src="{{ asset('assets/external/farmacia-qr/camera-off.svg') }}" alt=""> DESACTIVAR CÁMARA</button>
            </div>
            <div class="col-12 col-md-4 offset-md-4">
                <button type="button" class="btn btn-primary-veris btn-asignar w-100 fs--18 line-height-24 fw-medium px-4 py-3 btn-solicitud mt-1" data-toggle="modal" data-target="#nuevaSolicitud">
                    Ingresar Código de Solicitud
                </button>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-12">
                <button id="btn-camera" class="btn btn-dark"><img width="32" src="{{ asset('assets/external/farmacia-qr/camera-on.svg') }}" alt=""> ACTIVAR CÁMARA</button>
            </div>
            <div class="col-12" onclick="hideCamera();">
                <button id="btn-camera-off" class="btn btn-dark"><img width="32" src="{{ asset('assets/external/farmacia-qr/camera-off.svg') }}" alt=""> DESACTIVAR CÁMARA</button>
            </div>
        </div> --}}
        <div class="row">            
            <div class="col-sm-12">
                <video id="preview" class="p-1 border" playsinline style="width:100%;"></video>
            </div>
            <div class="col-sm-12 camera-option">         
                <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="options" value="1" autocomplete="off" checked> Camara frontal
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" value="2" autocomplete="off"> Camara trasera
                    </label>
                </div>
            </div>
        </div>
    </section>
</div>
<style type="text/css">
    #preview{
        max-height: 400px;
    }
    #btn-camera{
        display: none;
    }
    .btn-solicitud, #btn-camera, #btn-camera-off{
        width: 100%;
        margin: 10px 0px;
    }
    .btn-group{
        width: 100%;
        margin-bottom: 5px !important;
    }
    .btn-group label{
        width: 50%;
    }
    .jq-toast-single.jq-has-icon.jq-icon-success {
        padding-top: 10px;
        padding-right: 20px;
    }
    #infoPaciente label{
        color: #007bff;
    }
    .p_info {
        font-size: 18px;
        line-height: 18px;
    }
</style>
<script>
    var audio = new Audio('{{ asset('assets/audio/beep.mp3')}}');

    var scanner = new Instascan.Scanner({
        video: document.getElementById('preview'), 
        scanPeriod: 5, 
        mirror: false,
        facingMode: { exact: "environment" }
    });
    document.addEventListener("DOMContentLoaded", async function () {
        //var msg = "";
        scanner.addListener('scan',function(content){
            //alert("Código de Solicitud: "+content);
            //getInfoCodigoSolicitud(content);
            $('#codigoSolicitudProcesar').val(content);
            //showMsg("Nº Solicitud: "+content,'info');
            audio.play();
            actualizarStatus();
        });
        $('.btn-buscar').click(function(){
            var id = $('#numeroSolicitud').val();
            $('#codigoSolicitudProcesar').val(id);
            $('#nuevaSolicitud').modal('toggle');
            actualizarStatus();
            //getInfoCodigoSolicitud(id);
        });
        $('.btn-procesar').click(function(){
            actualizarStatus();
        });
        $('#btn-camera').click(function(){
            showCamera();
        });
        $('#btn-camera-off').click(function(){
            hideCamera();
        });
    })
    var url_services = 'https://www.veris.com.ec/services/';
    function actualizarStatus(){
        var id = $('#codigoSolicitudProcesar').val();
        var codigoUsuario = "{{ Session::get('userDataExternal')->codigoUsuario }}";
        //alert(id);
        $.get(url_services+'updateStatusSolicitudFarmaciaDomicilio.php', { "idSolicitud":id, "codigoUsuario":codigoUsuario }, function(data){
            console.log(data);
            if(data['mensaje'] == "OK"){
                //$('#infoPaciente').modal('toggle');
                showMsg('Despacho # '+id+' registrado exitosamente.','success');
                hideCamera();
            }else{
                showMsg('Error Solicitud #'+id+'</br>'+data['mensaje'],'error');
            }
        });
    }
    function getInfoCodigoSolicitud(id){
        $.get(url_services+'getInfoCodigoSolicitudFarmacia.php',{ "idSolicitud":id }, function(data){
            console.log(data['numeroIdentificacion']);
            if(data['success'] == "OK"){
                if(data['codigoTransaccion'] != 0){
                    $('#codigoSolicitudProcesar').val(id);
                    $('.codigoHeader').html(id);
                    $('.numeroIdentificacion').html(data['numeroIdentificacion'])
                    $('.nombrePaciente').html(data['nombresPaciente'])
                    $('#infoPaciente').modal();
                }else{
                    showMsg("Nº Solicitud no encontrado en el Sistema.",'warning');
                }
            }else{
                showMsg($data['mensaje'],'error');
            }
        });
    }
    function showCamera(){
        scanner.start();
        $('#preview').show();
        // $('#btn-camera').hide();
        // $('#btn-camera-off').show();

        $('#box-show-camera').removeClass('d-none')
        $('#box-hide-camera').addClass('d-none')
    }
    function hideCamera(){
        scanner.stop();
        $('#preview').hide();
        // $('#btn-camera-off').hide();
        // $('#btn-camera').show();
        $('#box-show-camera').addClass('d-none')
        $('#box-hide-camera').removeClass('d-none')
    }
    Instascan.Camera.getCameras().then(function (cameras){
        if(cameras.length>0){
            scanner.start(cameras[0]);
            $('[name="options"]').on('change',function(){
                if($(this).val()==1){
                    if(cameras[0]!=""){
                        scanner.start(cameras[0]);
                    }else{
                        alert('No Front camera found!');
                    }
                }else if($(this).val()==2){
                    if(cameras[1]!=""){
                        scanner.start(cameras[1]);
                    }else{
                        alert('No Back camera found!');
                    }
                }
            });
        }else{
            console.error('No cameras found.');
            alert('No se ha encontrado la cámara, asegurese de que no se esté usando en otro tab o app');
        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });
    //showMsg('Solicitud registrada exitosamente.','success');
    //showMsg('Usuario no encontrado en el Sistema, ingresar manualmente.','warning');
    function showMsg(msg,icon){
        $.toast({
            //heading: 'Atención',
            text: msg,
            icon: icon,
            showHideTransition: 'fade',
            position: 'top-right',
            stack: false,
            loader: false,
            loaderBg: '#0071ce',
            hideAfter: 5000,
        });
    }
</script>

@endsection