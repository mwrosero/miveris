@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal Receta médica -->
    <div class="modal fade" id="recetaMedicaModal" tabindex="-1" aria-labelledby="recetaMedicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="fw-bold text-center">{{ __('Receta médica') }}</h5>
                    <p class="text-center lh-1 fs--1 my-3">{{ __('¿Compraste esta receta en otra farmacia distinta a la de Veris y/o tomaste el medicamento?') }}</p>
                    <a href="#" class="btn btn-primary-veris w-100">{{ __('Sí, lo hice') }}</a>
                    <a href="#" class="btn btn w-100">No lo he hecho</a>
                </div>
           
             </div>
        </div>
    </div>

    <!-- Modal Examenes presencial -->
    <div class="modal fade" id="mensajeLaboratorioPresencialModal" tabindex="-1" aria-labelledby="mensajeLaboratorioPresencialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal">{{ __('Para realizarte este examen acercate a una central médica') }}</p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">{{ __('Entiendo') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal VideoConsulta -->
    <div class="modal fade" id="mensajeVideoConsultaModal" tabindex="-1" aria-labelledby="mensajeVideoConsultaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center px-2 pt-3 pb-0">
                    <h1 class="modal-title fs-5 fw-bold mb-3">{{ __('Información') }}</h1>
                    <p class="fs--1 fw-normal">{{ __('Para agendar esta videoconsulta llama al') }} <b>{{ __('6009600') }}</b></p>
                </div>
                <div class="modal-footer border-0 px-2 pt-0 pb-3">
                    <a href="tel:+59346009600" class="btn btn-primary-veris w-100"><i class="bi bi-telephone-fill me-2"></i> Llamar</a>
                    <button type="button" class="btn text-primary-veris w-100" data-bs-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Tratamiento') }}</h5>  
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0">
            <div class="col-md-12">
                <div class="card rounded-0 border-0">
                    <div class="card-body p-3 pb-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-9 col-md-10" id="datosTratamientoCard">
                                <!-- datos del tratamiento -->
                            </div>
                            <div class="col-3 col-md-2 col-lg-1">
                                <div id="chart-progress" data-porcentaje="10" data-color="success"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end rounded-0 pb-2">
                        <a href="#" class="btn btn-sm btn-label-primary-veris px-3 mb-2">Ver PDF</a>
                    </div>
                </div>  
                <div class="card rounded-0 border-0">
                    <div class="card-body p-3 position-relative px-lg-5"
                        style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                        <h4 class="fw-bold text-white mb-0">Compra y gestiona</h4>
                        <h6 class=" fw-light text-white mb-0">tu <b>tratamiento</b> sin <b>filas</b></h6>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{route('tratamientos.detalle')}}" class="btn btn-sm btn-primary-veris px-4">Ver tratamiento</a>
                        </div>
                    </div>
                    <div class="position-absolute end-7 bottom-40">
                        <img src="{{ asset('/assets/img/card/carrito_promocion.png') }}" class="img-fluid" width="96" alt="carrito_promocion" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0 px-md-3">
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue" id="tituloTratamientoPendiente" style="display: none;">{{ __('Pendientes') }}</h5>
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-3" id="contenedorTratamientoPendiente">
                    <!-- items -->
                    
                    
                    
                </div>
            </div>
        </div>
        <h5 class="mb-3 py-2 px-3 bg-labe-grayish-blue" id="tituloTratamientoRealizado" style="display: none;">{{ __('Realizados') }}</h5>
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-3" id="contenedorTratamientoRealizado">
                    <!-- items -->
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>

    // variables globales
    let codigoTratamiento = {{ $codigoTratamiento }};
    let datosTratamiento = [];
    let ultimoTratamiento = [];
    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerTratamientos();
    });
    
    // funciones asyncronas
    // obtener tratamientos
    async function obtenerTratamientos(){
        let args = [];
        let canalOrigen = _canalOrigen;
        
        args["endpoint"] = api_url + `/digitales/v1/tratamientos/${codigoTratamiento}?canalOrigen=${canalOrigen}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            datosTratamiento = data.data.pendientes;
            var ultimoTratamiento = datosTratamiento[datosTratamiento.length - 1];
            console.log('ultimoTratamiento: ', ultimoTratamiento);
            let datosTratamientoCard =  $('#datosTratamientoCard');
            datosTratamientoCard.empty; // Limpia el contenido actual
            let elemento = `<h5 class="card-title text-primary mb-0">${capitalizarElemento(ultimoTratamiento.nombreEspecialidad)} </h5>
                                <p class="fw-bold fs--2 mb-0">${capitalizarElemento(ultimoTratamiento.nombrePaciente)}</p>
                                <p class="fs--2 mb-0">Dr(a): ${capitalizarElemento(ultimoTratamiento.nombreMedicoAtencion)}</p>
                                <p class="fs--2 mb-0">Tratamiento enviado: <b class="fw-light text-primary-veris ms-2" id="fechaTratamiento">${formatearFecha(ultimoTratamiento.fechaOrden)}</b></p>
                                <p class="fs--2 mb-0">${data.data.datosConvenio.nombreConvenio}</p> `;
            datosTratamientoCard.append(elemento);
            datosTratamiento = data.data;

            mostrarTratamientoenDiv();
            mostrarTratamientoenDivRealizados();
            
        }
        return data;

    }

    


    // funciones js
    // mostrar el tratamientos pendientes
    function mostrarTratamientoenDiv() {
        let data = datosTratamiento.pendientes;
        console.log(data);

        let divContenedor = $('#contenedorTratamientoPendiente');
        divContenedor.empty(); // Limpia el contenido actual
        if(data.length > 0){
            data.forEach((tratamientos) => {
                
                    let elemento = `<div class="card mb-3">
                                        <div class="card-body fs--2 p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary-veris fw-bold mb-0">${tratamientos.nombreServicio} </h6>
                                                <span class="text-warning-veris" id="estado">${determinarEstado(tratamientos.esPagada)}</span>
                                            </div>
                                            <p class="fw-light mb-2">Orden válida hasta: <b class="fecha-cita fw-light text-primary me-2">${determinarValoresNull(tratamientos.fechaCaducidad)}</b></p>
                                            <div id="recetaMedicaMensaje">
                                                ${determinarMensajeRecetaMedica(tratamientos.nombreServicio)}
                                            </div> 
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                                    ${determinarAvatar(tratamientos.tipoServicio)}
                                                </div>
                                                <div>
                                                    ${determinarbotonesRecetaMedica(tratamientos.nombreServicio, tratamientos.esAgendable, tratamientos.tipoServicio, tratamientos.aplicaSolicitud)}  
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>`;

                    divContenedor.append(elemento);
                
            });
            // mostrar el titulo de pendientes
            document.getElementById("tituloTratamientoPendiente").style.display = "block";
            chartProgres("#chart-progress");
        }
        
    }

    // mostrar el tratamientos realizados
    function mostrarTratamientoenDivRealizados(){

        let data = datosTratamiento.realizados;
        console.log('tratamientos realizados: ', data);
        
        let divContenedorRealizados = $('#contenedorTratamientoRealizado');
        divContenedorRealizados.empty(); // Limpia el contenido actual
        if(data.length > 0){
            data.forEach((tratamientos) =>{
                console.log('tratamientosee: ', tratamientos.nombreServicio); 

                let elemento = `<div class="card mb-3">
                                    <div class="card-body fs--2 p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="text-primary-veris fw-bold mb-0">${tratamientos.nombreServicio}</h6>
                                            <span id="estado"><i class="fa-solid fa-check me-2 text-success"></i><span class="text-success">Atendida</span></span>
                                        </div>
                                        <div>
                                            
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <div class="avatar-tratamiento border rounded-circle bg-very-pale-red">
                                                ${determinarAvatar(tratamientos.tipoServicio)}
                                            </div>
                                            <div>
                                                ${determinarbotonesRecetaMedicaRealizados(tratamientos.tipoServicio)}
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>`;

                divContenedorRealizados.append(elemento);
                
            });
             // mostrar el titulo de realizados
            document.getElementById("tituloTratamientoRealizado").style.display = "block";
        }
       

    }

    // determinar si es comprar o por comprar
    function determinarEstado(estado){
        if(estado == "S"){
            return `<i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprada</span>`;
        }else{
            return `<i class="fa-solid fa-circle me-2"></i>Por comprar`;
        }
    }

    // determinar si es receta medica o no mensaje 
    function determinarMensajeRecetaMedica(servicio){
        if(servicio == "RECETA MÉDICA"){
            return `<a href="" class="fs--2" data-bs-toggle="modal" data-bs-target="#recetaMedicaModal">¿Ya compraste esta receta?</a> `;
        }
        else{
            return ``;
        }
    }

    // determinar si es receta medica o no botones
    function determinarbotonesRecetaMedica(servicio, esAgendable, tipoServicio, aplicaSolicitud){
        console.log('esAgendable: ' + esAgendable);
    
        if(tipoServicio == "FARMACIA" && aplicaSolicitud == 'S'){
            // Código para RECETA MÉDICA
            return `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver receta</a>
                    <a href="/farmacia-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (tipoServicio == "FARMACIA" && (aplicaSolicitud == 'N' || aplicaSolicitud == null)) {
            // Código para RECETA MÉDICA
            return `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver receta</a>
                    <a href="/farmacia-domicilio/${codigoTratamiento}"  class="btn btn-sm btn-primary-veris fw-normal fs--1 disabled"><i class="bi bi-telephone-fill me-2"></i> Solicitar</a>`;
        } else if (tipoServicio == "LABORATORIO" && esAgendable == 'N') {
            // Código para LABORATORIO
            return `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver receta</a>
                    <a href="/laboratorio-domicilio/${codigoTratamiento}" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi bi-telephone-fill me-2"></i> Solicitar labor</a>`;
        } else {
            // Código para otros servicios
            let botonAgendarClase = "btn btn-sm btn-primary-veris fw-normal fs--1";
            let botonAgendarDisabled = "";

            // Si esAgendable no es 'S', deshabilitar el botón
            if(esAgendable !== 'S'){
                botonAgendarClase += " disabled";
                botonAgendarDisabled = " disabled";
            }

            return `<a href="#" class="btn text-primary-veris fw-normal fs--1">Ver orden</a>
                    <a href="{{route('citas.listaCentralMedica')}}" class="${botonAgendarClase}"${botonAgendarDisabled}> Agendar</a>`;
        }
    }


    // determinar si es receta medica o no botones realizados
    function determinarbotonesRecetaMedicaRealizados(servicio){
        if(servicio == "FARMACIA"){
            return `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Ver receta</a> `;
                                            
        }
        else{
            
            return `<a href="#" class="btn btn-sm btn-primary-veris fw-normal fs--1"><i class="bi me-2"></i> Ver orden</a> `;
        }
    }

    // determinar avatar 
    function determinarAvatar(servicio){
        if(servicio == "FARMACIA"){
            return `<img class="rounded-circle" src="{{ asset('assets/img/svg/receta.svg') }}" width="26" alt="receta medica">`;
        }
        else if (servicio == "LABORATORIO"){
            return `<img class="rounded-circle" src="{{ asset('assets/img/svg/microscopio.svg') }}" width="26" alt="receta medica">`;
        }
        else if (servicio == "INTERCONSULTA" || servicio == "CONSULTA" || servicio == "PROCEDIMIENTOS" || servicio == "ODONTOLOGIA"){
            return `<img class="rounded-circle" src="{{ asset('assets/img/svg/estetoscopio.svg') }}" width="26" alt="receta medica">`;
        }
        else if (servicio == "TERAPIA"){
            return `<img class="rounded-circle" src="{{ asset('assets/img/svg/muletas.svg') }}" width="26" alt="terapia">`;
            return ``;
        }
    }

    // determinar mensaje receta medica realizados  
    function determinarRecetaMedicaRealizadosDetalle(servicio, fechaOrden, nombrePaciente, nombreMedicoAtencion, nombreSucursal){
        console.log('entro a determinarbotonesRecetaMedicaRealizadosDetalle');
        if(servicio != "RECETA MÉDICA"){
            console.log('servicio: ', servicio);
            console.log('fechaOrden: ', fechaOrden);
            return `<p class="fw-light mb-2">Sucursal: <b class="fecha-cita fw-light text-primary me-2">${nombreSucursal}</b></p>
                    <p class="fw-light mb-2"><b class="fecha-cita fw-light text-primary me-2">${fechaOrden}</b></p>
                    <p class="fw-light mb-2">Dr(a): <b class="fecha-cita fw-light text-primary me-2">${nombreMedicoAtencion}</b></p>
                    <p class="fw-light mb-2">Paciente: <b class="fecha-cita fw-light text-primary me-2">${nombrePaciente}</b></p>`;
                    
        }
        else{
            return ``;
        }
    }

    // determinar valores null 
    function determinarValoresNull(valor){
        if(valor == null){
            return '';
        }
        else{
            return valor;
        }
    }

    // formatear fecha
    function formatearFecha(fecha) {
    const meses = ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"];
    
    // Asumiendo que la fecha entra en formato "DD-MM-YYYY"
    const partes = fecha.split('-');
    const dia = partes[0];
    const mes = meses[parseInt(partes[1], 10) - 1]; // Convertir a número y restar 1 porque los meses en JavaScript comienzan en 0
    const año = partes[2];

    return `${mes} ${dia}, ${año}`;
}


</script>
@endpush