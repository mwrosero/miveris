@extends('template.app-template-veris')
@section('title')
Elige Paciente
@endsection
@section('content')
@php
$data = json_decode(utf8_encode(base64_decode(urldecode($params))));
// dd(Session::get('userData'));
@endphp
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 pt-4">
                    <h5 class="mb-4">{{ __('Elige tu convenio:') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="list-group list-group-checkable d-grid gap-2 border-0" id= "listaConvenios">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-3 pb-3">
                    <button type="button" class="btn fw-normal m-0" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal noPermiteReserva-->
    <div class="modal fade" id="noPermiteReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noPermiteReservaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 mb-3" id="noPermiteReservaLabel">Veris</h1>
                        <p class="mb-0" id="noPermiteReservaMsg"></p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center p-2 pt-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0 waves-effect waves-light" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elegir paciente') }}</h5>
    <section class="p-3 mb-3">
        <div class="row g-3" id="listaPacientes">
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center px-4">
                        <a href="{{route('familia')}}">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                </div>
                            </div>
                            <p class="text-veris fw-medium fs--2">{{ __('Agregar nuevo paciente') }}</p>
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
    let familiar = [];
    // CAPTURAR PARAMETROS
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let online = dataCita?.online;
    let ordenExterna = dataCita?.ordenExterna;
    let dataPaciente;
    

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarGrupoFamiliar();
        $('body').on('click','.convenio-item', function(){
            reservaNoPermitida($(this).attr("url-rel"), $(this).attr("data-rel"));
        })
    });

    // funciones asyncronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientes();

        }
        return data;
    }

    // consultar lista de convenios
    async function consultarConvenios(event) {
        let listaConvenios = $('#listaConvenios');
        listaConvenios.empty();
        listaConvenios.append(`<div class="text-center p-2"><small>Nos estamos comunicando con tu aseguradora, el proceso puede tardar unos minutos</small></div>`);

        let args = [];
        let canalOrigen = _canalOrigen;
        let dataRel = $(event.currentTarget).data('rel');
        dataPaciente = dataRel;
        console.log("dataRel", dataRel);
        let codigoUsuario;
        let tipoIdentificacion;
        let nombreCompleto;
        let numeroPaciente;
        let direccion;
        let telefono;
        let correo;

        if(dataRel != ""){
            codigoUsuario = dataRel.numeroIdentificacion;
            tipoIdentificacion = dataRel.tipoIdentificacion;
            nombreCompleto = dataRel.primerNombre + ' ' + dataRel.primerApellido + ' ' + dataRel.segundoApellido;
            numeroPaciente = atob(dataRel.idPersona);
            direccion = dataRel.direccion;
            telefono = dataRel.telefono;
            correo = dataRel.correo;
        }

        args["endpoint"] = api_url + `/digitalestest/v1/comercial/paciente/convenios?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${codigoUsuario}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S  `
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        // llenar modal
        if (data.code == 200){
            let elemento = '';

            if(data.data.length > 0){
                listaConvenios.empty();
                data.data.forEach((convenios) => {
                    let params = {}
                    params.online = online;
                    params.convenio = convenios;
                    params.paciente = dataRel;

                    let ruta = '';
                    if (ordenExterna == 'S') {
                        if(online == 'S'){
                            ruta = `/registrar-orden-externa-ubicacion/{{ $params }}`;                       
                        }else{
                            ruta = `/registrar-orden-externa/{{ $params }}`;
                        }
                    }
                    else {
                        ruta = `/citas-elegir-especialidad/{{ $params }}`;
                    }
                    
                    if(convenios.permiteReserva == "N"){
                        ruta = `#`;
                    }
                    let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                    elemento += `<div data-rel='${ulrParams}' url-rel="${ruta}" class="convenio-item">
                                    <div class="list-group-item fs--2 rounded-3 p-2 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                                        <label for="listGroupCheckableRadios2" class="cursor-pointer">
                                            ${convenios.nombreConvenio}
                                        </label> 
                                    </div>
                                </div>`;
                });
                /*Agregar ninguno*/
                let params = {}
                params.online = online;
                params.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,

                };
                params.paciente = dataRel;
                let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                ruta = `/citas-elegir-especialidad/{{ $params }}`;
                if (ordenExterna == 'S') {
                    if(online == 'S'){
                        ruta = `/registrar-orden-externa-ubicacion/{{ $params }}`;                          
                    }else{

                        ruta = `/registrar-orden-externa/{{ $params }}`;
                    }
                }


                elemento += `<a href="${ruta}" class="d-block" data-rel='${ulrParams}' id="convenioNinguno">
                                <div class="list-group-item fs--2 rounded-3 p-2 border-0">
                                    NINGUNO
                                </div>
                            </a>`;

                listaConvenios.append(elemento); 
                
                // mostrar modal
                $('#convenioModal').modal('show');
                
            } else {

                let params = {}
                dataCita.online = online;
                dataCita.convenio = {
                    "permitePago": "S",
                    "permiteReserva": "S",
                    "idCliente": null,
                    "codigoConvenio": null,
                };
                dataCita.paciente = dataRel;
                localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

                let ulrParams = encodeURIComponent(btoa(JSON.stringify(params)));
                listaConvenios.empty();
                if (ordenExterna == 'S') {
                    console.log("orden externa");
                    if(online == 'S'){
                        ruta = `/registrar-orden-externa-ubicacion/{{ $params }}`;
                        
                    }else{
                        ruta = `/registrar-orden-externa/{{ $params }}`;
                    }
                }
                else {
                    ruta = `/citas-elegir-especialidad/{{ $params }}`;
                }

                window.location.href = ruta;
            }              
        }

        return data;
    }
    
    // mostrar lista de pacientes
    function mostrarListaPacientes(){

        let listaPacientes = $('#listaPacientes');
        
        let elemento = '';

        if(familiar != null){
            familiar.forEach((pacientes) => {
                let backgroundClass = pacientes.genero === "F" ? "bg-strong-magenta" : (pacientes.genero === "M" ? "bg-soft-blue" : "bg-soft-green");

                elemento += `<div class="col-6 col-md-3">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body text-center px-2">
                            
                            <div data-bs-toggle="modal"  onclick="consultarConvenios(event)" data-rel='${JSON.stringify(pacientes)}'>
                               <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded-circle ${backgroundClass}">${pacientes.primerNombre.charAt(0).toUpperCase()}</span>
                                    </div>
                                </div>
                                <p class="text-veris fw-medium fs--2 mb-0">${capitalizarElemento(pacientes.primerNombre)} ${capitalizarElemento(pacientes.segundoNombre)} ${capitalizarElemento(pacientes.primerApellido)}</p>
                                <p class="text-veris fs--3 mb-0">${capitalizarElemento(pacientes.parentesco)}</p>
                            </div>
                        </div>
                    </div>
                </div> `;

            });
        }
        listaPacientes.append(elemento);
    }

    async function reservaNoPermitida(url, data ){
        let convenio = JSON.parse(atob(decodeURIComponent(data)));
        console.log("convenio", convenio);
        $('#noPermiteReservaMsg').html(convenio.convenio.mensajeBloqueoReserva)
        if(convenio.convenio.permiteReserva == "S"){
            // Actualizar dataCita con los datos del convenio
            dataCita.convenio = convenio.convenio;
            dataCita.paciente = dataPaciente;
            // Aquí puedes añadir cualquier otra información relevante a dataCita

            // Guardar el objeto actualizado en localStorage
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

            location.href = url;
        }else{
            $('#convenioModal').modal('hide');
            var myModal = new bootstrap.Modal(document.getElementById('noPermiteReserva'));
            setTimeout(function(){
                $('.modal-backdrop').remove();
                myModal.show();
            },250);
        }
    }

    // setear cita en localstorage cuando se escoge un convenio ninguno
    $('body').on('click', '#convenioNinguno', function() {
        let params = {}
        dataCita.online = online;
        dataCita.convenio = {
            "permitePago": "S",
            "permiteReserva": "S",
            "idCliente": null,
            "codigoConvenio": null,
        };
        dataCita.paciente = dataPaciente;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

    });
   
    
    
</script>

<style>
    .bg-soft-blue {
        background-color: #0071CE !important;
    }
</style>
@endpush