@extends('template.app-template-veris')
@section('title')
Mi Veris - Doctores favoritos
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
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
                    <a href="#!" class="btn btn-link text-primary-veris shadow-none">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Doctores favoritos') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-6 text-center mt-5 mb-5">
                <a href="{{route('doctoresFavoritos.buscarDoctor')}}" class="btn btn-primary-veris w-50 py-3">Buscar doctor</a>
            </div>
            <div class="row justify-content-center"  id="doctoresFavoritos" >
            </div>
            <!-- Doctor favorito dinamico -->

            <!-- Mensaje Aún no tienes doctores favoritos -->
            <div class="col-12 d-flex justify-content-center d-none">
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
        let codigoUsuario = {{ Session::get('userData')->numeroIdentificacion }};
        

        args["endpoint"] = api_url + `/digitalestest/v1/perfil/doctores/favoritos?codigoUsuario=${codigoUsuario}&idPersona=${codigoUsuario}&canalOrigen=${canalOrigen}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('doc',data);
        
        if(data.data.length > 0){
            let html = $('#doctoresFavoritos');
            const promesas = data.data.map(doctores => obtenerDisponibilidadDoctor(doctores));
            const resultados = await Promise.all(promesas);
            

            // Ahora iterar sobre los resultados para construir el HTML
            resultados.forEach((disponibilidad, index) => {
                let doctores = data.data[index];
                let elemento = `<div class="col-12 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row gx-2">
                                                <div class="col-3 d-flex justify-content-center align-items-center">
                                                    <img src=${doctores.imagen} class="card-img-top" alt="centro medico" onerror="this.src='{{ asset('assets/img/svg/avatar_doctor.svg') }}'; this.style.height='50px'; this.style.width='50px';">

                                                </div>

                                                <div class="col-9">
                                                    <h6 class="fw-bold mb-0">Dr(a) ${doctores.primerNombre} ${doctores.segundoNombre} ${doctores.primerApellido} ${doctores.segundoApellido}</h6>
                                                    <p class="text-primary-veris fw-bold fs--2 mb-0">${doctores.nombreSucursal}</p>
                                                    <p class="fs--2 mb-0">${doctores.nombreEspecialidad}</p>
                                                    <p class="fs--2 mb-0">Disponibilidad: <b class="fw-normal text-primary-veris" id="disponibilidad">  ${disponibilidad}
                                                        </b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end p-3">
                                            <button type="button" class="btn btn-outline-primary-veris btn-sm me-2" data-bs-toggle="modal" data-bs-target="#eliminarDoctorModal">Descartar</button>
                                            <a href="#!" class="btn btn-sm btn-primary-veris">Reservar Cita</a>
                                        </div>
                                    </div>
                                </div>`;
                html.append(elemento);
            });

            
        } else {
            $('.d-none').removeClass('d-none');
        }
        
        
        return data;

    }

    // consulta de disponibilidad
    async function obtenerDisponibilidadDoctor(doctor) {
        let args = [];
        let canalOrigen = _canalOrigen;
        let codigoUsuario = {{ Session::get('userData')->numeroIdentificacion }};
        let fechaHoy = new Date().toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        console.log(fechaHoy);

        args["endpoint"] = api_url + `/digitales/v1/agenda/medicos/horarios?canalOrigen=${canalOrigen}&codigoEmpresa=${doctor.codigoEmpresa}&codigoSucursal=${doctor.codigoSucursal}&codigoEspecialidad=${doctor.codigoEspecialidad}&codigoPrestacion=${doctor.codigoPrestacion}&codigoServicio=${doctor.codigoServicio}&online=${doctor.esOnline}&fechaSeleccionada=${fechaHoy}`;
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



    // funciones js 
    

</script>
@endpush