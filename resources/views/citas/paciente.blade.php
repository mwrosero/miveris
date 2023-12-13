@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elegir paciente
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-bold top-50" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elegir paciente') }}</h5>
    <section class="p-3 mb-3">
        <div class="row" id="listaPacientes">
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{route('familia')}}">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                </div>
                            </div>
                            <p class="text-veris fw-bold fs--2">{{ __('Agregar nuevo paciente') }}</p>
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


    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarGrupoFamiliar();
    });

    // funciones asyncronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientes();

        }
        return data;
    }


    // consultar lista de convenios
    async function consultarConvenios(event) {
        console.log('entro');
        let args = [];
        let canalOrigen = _canalOrigen;
        let dataRel = $(event.currentTarget).data('rel');
        console.log('dataRel', dataRel);

        let codigoUsuario = dataRel.numeroIdentificacion;
        let tipoIdentificacion = dataRel.tipoIdentificacion;
        let nombreCompleto = dataRel.primerNombre + ' ' + dataRel.primerApellido + ' ' + dataRel.segundoApellido;

        args["endpoint"] = api_url + `/digitales/v1/comercial/paciente/convenios?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${codigoUsuario}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S  `
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('dataRel', data);

        // llenar modal
        if (data.code == 200){

            if(data.data.length > 0){
                

                let listaConvenios = $('#listaConvenios');
                listaConvenios.empty();
                let elemento = '';

                data.data.forEach((convenios) => {
                    elemento += `<a href="/registrar-orden-externa/${tipoIdentificacion}/${codigoUsuario}/${convenios.codigoConvenio}/${convenios.nombreConvenio}"
                        class="stretched-link">
                                    <div class="list-group-item fs--2 rounded-3 p-2">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                                        <label for="listGroupCheckableRadios2">
                                            ${convenios.nombreConvenio}
                                        </label> 
                                    </div>
                                </a>`;
                    
                });
                

                listaConvenios.append(elemento);
            } else {
                let listaConvenios = $('#listaConvenios');
                listaConvenios.empty();
                let elemento = '';
                elemento += `<div class="col-12">
                                <div class=" fs--2 rounded-3 p-2">
                                    {{ __('Ninguno') }}
                                </div>
                            </div> `;
                listaConvenios.append(elemento);    
            }

        }




        return data;
    }


    


    // funciones js
    
    // mostrar lista de pacientes

    function mostrarListaPacientes(){

        let listaPacientes = $('#listaPacientes');
        let pacienteYo = "{{ Session::get('userData')->primerNombre }} {{ Session::get('userData')->segundoNombre }} {{ Session::get('userData')->primerApellido }}";
        
        let pacienteYoGenero = "{{ Session::get('userData')->sexo }}";
        console.log('pacienteYoGenero', pacienteYoGenero);

        let backgroundClass = pacienteYoGenero === "F" ? "bg-strong-magenta" : (pacienteYoGenero === "M" ? "bg-soft-blue" : "bg-soft-green");
        let elemento = '';
        elemento += `<div class="col-6 col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <a data-bs-toggle="modal" data-bs-target="#convenioModal">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <div class="avatar me-2">
                                            <span class="avatar-initial rounded-circle ${backgroundClass}">${pacienteYo.charAt(0).toUpperCase()}</span>
                                        </div>
                                    </div>
                                    <p class="text-veris fw-bold fs--2 mb-0">${pacienteYo}</p>
                                    <p class="text-veris fs--3 mb-0">{{ __('Yo') }}</p>
                                </a>
                            </div>
                        </div>
                    </div> `;
        familiar.forEach((pacientes) => {
            console.log('pacientes', pacientes);
            let backgroundClass = pacientes.genero === "F" ? "bg-strong-magenta" : (pacientes.genero === "M" ? "bg-soft-blue" : "bg-soft-green");

            elemento += `<div class="col-6 col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        
                                        <div data-bs-toggle="modal" data-bs-target="#convenioModal" onclick="consultarConvenios(event)" data-rel='${JSON.stringify(pacientes)}'>
                                           <div class="d-flex justify-content-center align-items-center mb-2">
                                                <div class="avatar me-2">
                                                    <span class="avatar-initial rounded-circle ${backgroundClass}">${pacientes.primerNombre.charAt(0).toUpperCase()}</span>
                                                </div>
                                            </div>
                                            <p class="text-veris fw-bold fs--2 mb-0">${capitalizarElemento(pacientes.primerNombre)} ${capitalizarElemento(pacientes.segundoNombre)} ${capitalizarElemento(pacientes.primerApellido)}</p>
                                            <p class="text-veris fs--3 mb-0">${capitalizarElemento(pacientes.parentesco)}</p>
                                        </div>
                                    </div>
                                </div>
                            </div> `;

        } );

        listaPacientes.append(elemento);


    }

   
    
    
</script>

<style>
    .bg-soft-blue {
        background-color: #0071CE !important;
    }
</style>
@endpush