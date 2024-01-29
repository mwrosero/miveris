@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Citas Laboratorio
@endsection
@push('css')
@endpush
@section('content')
@php
    $data = json_decode(base64_decode($params));
@endphp


<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Citas / Laboratorio') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0 justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-start">
                    <h5 class="mb-0" id="numeroOrden"
                    ></h5>
                    <p class="fw-light">Paciente: <b id="paciente"></b> </p>
                </div>
            </div>
            <div class="col-auto">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="overflow-auto" style="min-height:256px; max-height: 256px" id="detallesOrdenLaboratorio">
                            <!-- items -->
                            
                        </div>
                        <div class="mb-2">
                            <div class="row g-0 justify-content-between">
                                <div class="col-9"><p class="fw-bold text-end text-opcaity mb-0">Subtotal</p></div>
                                <div class="col-3"><p class="fw-light text-end mb-0" id="Subtotal"></p></div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-square-fill fs-5 text-success me-2"></i>
                                <p class="text-900 fw-normal fs--2 mb-0"> Pago permitido por este canal</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-dash-square-fill fs-5 text-warning-veris me-2"></i>
                                <p class="text-900 fw-normal fs--2 mb-0"> Pago no permitido por este canal</p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-master w-100">
                                <a href="/citas-confirmar-pago" class="btn text-white shadow-none">{{ __('Pagar') }}</a>
                                |
                                <p class="btn text-white mb-0 shadow-none cursor-inherit" id="btntotal"></p>
                            </div>
                        </div>
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

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let idPaciente = dataCita.paciente.numeroPaciente;
    let numeroOrden = dataCita.datosTratamiento.idOrden;
    let codigoEmpresa = dataCita.datosTratamiento.codigoEmpresa;

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarDetallesOrdenLaboratorio();
    });

    // funciones asincronas

    // Consulta los detalles de una orden de laboratorio de un usuario específico.
    async function consultarDetallesOrdenLaboratorio(){
        let args = [];
        let canalOrigen = _canalOrigen
        
        args["endpoint"] = api_url + `/digitalestest/v1/ordenes/detallesLaboratorio?canalOrigen=${canalOrigen}&idPaciente=${idPaciente}&numeroOrden=${numeroOrden}&codigoEmpresa=${codigoEmpresa}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dett', data);

        // llenar los datos de la orden
        if (data.code == 200){
            let elementonumeroOrden = $('#numeroOrden');
            let elementopaciente = $('#paciente');
            let elementodetallesOrdenLaboratorio = $('#detallesOrdenLaboratorio');
            
            elementonumeroOrden.text(data.data.numeroOrden);
            elementopaciente.text(data.data.paciente);
            elementodetallesOrdenLaboratorio.empty();
            let elementos = '';

            data.data.lsOrdenesLaboratorio.forEach(element => {
                element.listaOrdenesDetalle.forEach(elemento => {
                    elementos += `
                    <div class="row g-0 justify-content-between">
                        <div class="col-9 d-flex align-items-center">
                            <i class="bi bi-check-square-fill fs-5 text-primary me-2"></i>
                            <p class="text-900 fw-semi-bold fs--2 mb-0">${elemento.nombrePrestacion}</p>
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <p class="text-1100 fw-semi-bold fs--2 mb-0">$ ${elemento.total}</p>

                            ${permitePago(elemento.permitePago)}
                            
                        </div>
                    </div>
                    `;
                });

                let elementototal = $('#Subtotal');
                elementototal.text("$" +
                    element.subtotal);
                let elementototal2 = $('#btntotal');
                elementototal2.text( "$" +
                    element.total);
            });

            elementodetallesOrdenLaboratorio.append(elementos);

            





        }
        return data;
    }

    // permite pago 

    function permitePago(data){

        if (data == 'S'){
            return `<i class="bi bi-check-square-fill fs-5 text-success ms-2"></i>`;
            // return `<i class="bi bi-dash-square-fill fs-5 text-warning-veris ms-2"></i>`;
        }else{
            // return amarillo

            return `<i class="bi bi-dash-square-fill fs-5 text-warning-veris ms-2"></i>`;
        }
    }



</script>
@endpush