@extends('template.app-template-veris')
@section('title')
Mi Veris - Doctores favoritos
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">

    <!-- Modal convenios-->
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
    <!-- Modal de error -->
    <div class="modal fade" id="mensajeSolicitudLlamadaModalError" tabindex="-1" aria-labelledby="mensajeSolicitudLlamadaModalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-medium mb-3 pb-2">Solicitud fallida</h1>
                    <p class="fs--1 fw-normal" id="mensajeError" >
                </p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="eliminarDoctorModal" tabindex="-1" aria-labelledby="eliminarDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="mb-0">Eliminar doctor</h5>
                    <p class="mb-0">¿Estás seguro de eliminar este doctor de su lista de favoritos?</p>
                </div>
                <div class="modal-footer flex-nowrap justify-content-center pt-0 px-0">
                    <button type="button" class="btn btn-link text-primary-veris shadow-none" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#!" class="btn btn-link text-primary-veris shadow-none" id="btnEliminarDoctor"
                    >Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Doctores favoritos') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-6 text-center mt-5 mb-5">
                <a href="{{route('doctoresFavoritos.buscarDoctor')}}" class="btn btn-primary-veris w-50 py-3">Buscar doctor</a>
            </div>
            <div class="row justify-content-center"  id="doctoresFavoritos" >
            </div>
            <!-- Doctor favorito dinamico -->

            <!-- Mensaje Aún no tienes doctores favoritos -->
            <div class="col-12 d-flex justify-content-center d-none" id="noDoctorFavorito">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/svg/doctors_favoritos.svg') }}" class="img-fluid" alt="">
                            <h5>Aún no tienes doctores favoritos</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->
            
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->
<script>

    // variables globales
    let dataDoctorFavorito = [];
    

    // llamada al dom 
     document.addEventListener("DOMContentLoaded", async function () {
        await obtenerDoctorFavorito();
    });


    // funciones asyncronas
    // Consulta datos de los doctores favoritos
    async function obtenerDoctorFavorito() {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        

        args["endpoint"] = api_url + `/digitalestest/v1/perfil/doctores/favoritos?codigoUsuario=${codigoUsuario}&idPersona=${codigoUsuario}&canalOrigen=${canalOrigen}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('doc',data);

        if (data.data == null) {
            // limpiar el html
            $('#doctoresFavoritos').html('');
            
            $('#noDoctorFavorito').removeClass('d-none');
        }
        else
        
        if(data.data.length > 0){
            let html = $('#doctoresFavoritos');
            const promesas = data.data.map(doctores => obtenerDisponibilidadDoctor(doctores));
            const resultados = await Promise.all(promesas);
            let elemento = '';

            // Ahora iterar sobre los resultados para construir el HTML
            resultados.forEach((disponibilidad, index) => {
                let doctores = data.data[index];
                elemento+= `<div class="col-12 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row gx-2">
                                                <div class="col-3 d-flex justify-content-center align-items-center">
                                                    <img src=${doctores.imagen} class="card-img-top" alt="centro medico" onerror="this.src='{{ asset('assets/img/svg/avatar_doctor.svg') }}'; this.style.height='50px'; this.style.width='50px';">

                                                </div>

                                                <div class="col-9">
                                                    <h6 class="fw-medium mb-0">Dr(a) ${doctores.primerNombre} ${doctores.segundoNombre} ${doctores.primerApellido} ${doctores.segundoApellido}</h6>
                                                    <p class="text-primary-veris fw-medium fs--2 mb-0">${doctores.nombreSucursal}</p>
                                                    <p class="fs--2 mb-0">${doctores.nombreEspecialidad}</p>
                                                    <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">  ${disponibilidad}
                                                        </b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end p-3">
                                            <button type="button" class="btn btn-outline-primary-veris btn-sm me-2" data-bs-toggle="modal" data-bs-target="#eliminarDoctorModal" data-rel='${doctores.secuencia}'>Descartar</button>
                                            <div class="btn btn-sm btn-primary-veris" onclick="consultarConvenios(event)" data-rel='${JSON.stringify(doctores)}'>Reservar cita</div>
                                        </div>
                                    </div>
                                </div>`;
                
            });
            html.append(elemento);

            
        } else {
            $('.d-none').removeClass('d-none');
        }
        
        
        return data;

    }

    

    // consultar convenios 
    async function consultarConvenios(event) {
        console.log('entro a consultar convenios');
        let listaConvenios = $('#listaConvenios');
        listaConvenios.empty();
        listaConvenios.append(`<div class="text-center p-2"><small>Nos estamos comunicando con tu aseguradora, el proceso puede tardar unos minutos</small></div>`);

        let dataRel = $(event.currentTarget).data('rel');
        let dataOnline = dataRel.esOnline;  
        let dataCodigoEspecialidad = dataRel.codigoEspecialidad;
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        let tipoIdentificacion = '{{ Session::get('userData')->codigoTipoIdentificacion }}';
        

        args["endpoint"] = api_url + `/digitalestest/v1/comercial/paciente/convenios?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${codigoUsuario}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S  `
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if (data.code == 200){
            if(data.data.length > 0){
                
                

                
                // llenar el modal con los convenios
                listaConvenios.empty();
                let elemento = '';
                data.data.forEach((convenios) => {
                    console.log('convenioslrrtd', convenios);
                    let params = {};
                    params.convenios = convenios;
                    params.online = dataOnline;
                    params.especialidad = {
                        codigoEspecialidad: dataCodigoEspecialidad,
                        codigoServicio: dataRel.codigoServicio,
                        codigoPrestacion: dataRel.codigoPrestacion,
                        codigoSucursal: dataRel.codigoSucursal,
                        nombre: dataRel.nombreEspecialidad,
                    };
                    params = btoa(JSON.stringify(params));
                    let ruta = `/citas-elegir-fecha-doctor/${params}`;
                    elemento += `<a href="${ruta}" class="stretched-link">
                                    <div class="list-group-item fs--2 rounded-3 p-2 border-0">
                                        <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                                        <label for="listGroupCheckableRadios2">
                                            ${convenios.nombreConvenio}
                                        </label> 
                                    </div>
                                </a>`;
                });
                listaConvenios.append(elemento);

                // abrir modal
                $('#convenioModal').modal('show');


            }
        }

    }

    // consulta de disponibilidad
    async function obtenerDisponibilidadDoctor(doctor) {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = '{{ Session::get('userData')->numeroIdentificacion }}';
        let fechaHoy = new Date().toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        console.log(fechaHoy);

        args["endpoint"] = api_url + `/digitalestest/v1/agenda/medicos/horarios?canalOrigen=${canalOrigen}&codigoEmpresa=${doctor.codigoEmpresa}&codigoSucursal=${doctor.codigoSucursal}&codigoEspecialidad=${doctor.codigoEspecialidad}&codigoPrestacion=${doctor.codigoPrestacion}&codigoServicio=${doctor.codigoServicio}&online=${doctor.esOnline}&fechaSeleccionada=${fechaHoy}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('doctor',doctor);
        console.log('disponibilidad',data);
        if (data.data.length == 0) {
            return 'No hay disponibilidad';
        }
        else {
            return 'Disponible';
        }
        return data;

    }

    // eliminar doctor favorito

    async function eliminarDoctorFavorito(secuenciaDoctor) {
        console.log('secuencia', secuenciaDoctor);
        let args = [];
        let codigoUsuario ='{{Session::get('userData')->numeroIdentificacion}}';
      

        args["endpoint"] = api_url + `/digitalestest/v1/perfil/doctores/favoritos/eliminar?codigoUsuario=${codigoUsuario}&secuenciaDoctor=${secuenciaDoctor}`;
        args["method"] = "DELETE";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('eliminar',data);
        if (data.code == 200) {
            $('#eliminarDoctorModal').modal('hide');
            await obtenerDoctorFavorito();
        }
        else if (data.code != 200) {
            $('#mensajeError').text(data.message);
            $('#mensajeSolicitudLlamadaModalError').modal('show');
        }


        return data;

    }



    // funciones js 

    // setear los valores de data-rel en el modal
    $('#eliminarDoctorModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Botón que activó el modal
        // extrae el dato de data rel
        let data = button.data('rel');
        // setea el valor de data rel en el boton eliminar
        $('#btnEliminarDoctor').attr('data-rel', data);



    });




    // eliminar doctor favorito
    $('body').on('click', '#btnEliminarDoctor', async function () {
        let secuenciaDoctor = $(this).attr("data-rel");
        console.log('Secuencia Doctor:', secuenciaDoctor);
        await eliminarDoctorFavorito(secuenciaDoctor);
    });

    

</script>
@endpush