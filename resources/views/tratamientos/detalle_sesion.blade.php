@extends('template.app-template-veris')
@section('title')
Mi Veris - Sesión - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Detalle') }}</h5>
    </div>
    <section class="p-0">
        <div class="container-fluid ps-3 pe-3">
            <div class="row justify-content-start m-0 p-0" style="background: #E9F7FF;">
                <div class="col-12 m-2 p-1" id="detalleSesion">
                    
                </div>
            </div>
        </div>
    </section>

    <section class="p-0 px-md-3 bg-white">
        <div class="container-fluid mb-4">
            <div class="row justify-content-center">
                {{-- col-12 col-md-6 col-lg-5 --}}
                <div class="col-12">
                    <div class="row g-3 justify-content-center" id="listado-detalles"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    document.addEventListener("DOMContentLoaded", async function () {
        await obtenerDetalleSesion();
        let showResultados = false;
        let elem = ``;
        $.each(dataCita.detalleSesion.detallesPrestacion, function(key, value){
            let estado = ``;
            if(value.esPagado == "N"){
                estado += `<div style="min-width: 100px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end text-warning-veris">
                        <i class="fa-solid fa-circle me-2"></i>Por comprar
                    </div>`;
            }else{
                estado += `<div style="min-width: 100px;" class="label-status-detalle fs--2 line-height-16 m-0 ms-2 text-end">
                        <i class="fa-solid fa-circle me-2 text-success"></i><span class="text-success">Comprada</span>
                    </div>`;
            }
            elem += `<div class="col-12 mt-3 mb-3" style="border-bottom: 1px solid #CCEAFA;">
                        <div class="row">
                            <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 m-0 p-0 m-md-auto p-md-auto">
                                <div class="card h-100 shadow-none" style="/*box-shadow: 0px 4px 8px 0px #0000001A;*/border-radius: 0px !important;">
                                    <div class="card-body p--2 d-flex justify-content-between align-items-center">
                                        <div class="text-primary-veris fs--1 line-height-16 m-0">
                                            ${ capitalizarCadaPalabra(value.nombrePrestacion) }
                                        </div>
                                        ${estado}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
        });

        elem += `<div class="col-12 mt-3 mb-3">
                        <div class="row">
                            <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                                <div class="mt-5">
                                    <a href="/citas-elegir-central-medica/{{ $params }}" class="btn btn-primary-veris fs--18 line-height-24 w-100 px-4 py-3">Agendar</a>
                                </div>
                            </div>
                        </div>
                    </div>`;

        $('#listado-detalles').html(elem);
    })

    async function obtenerDetalleSesion(codigoReserva = ''){
        let args = [];
        
        args["endpoint"] = api_url + `/${api_war}/v1/tratamientos/consultaDetalleSesion?canalOrigen=${_canalOrigen}&idPaciente=${dataCita.tratamiento.idPaciente}&secuenciaPlanTto=${dataCita.sesion.secuenciaPlanTto}&numeroSesion=${dataCita.sesion.numeroSesion}&codigoReserva=${codigoReserva}`;
        console.log(args["endpoint"]);
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code = 200){
            let elem = `<p class="fs--1 line-height-16 mb-1 text-one-line"><span class="text-primary-veris fw-medium">${data.data.nombreServicio}:</span> ${data.data.descripcion}</p>
                    <p class="fs--2 line-height-16 mb-0"><img src="{{asset('assets/img/veris/reloj-ico.svg')}}" class="me-1" alt="duración">Duración de la sesión: <span class="fw-medium">${data.data.duracion}</span></p>`;
            $('#detalleSesion').html(elem);
            dataCita.detalleSesion = data.data;
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
        }
        return data;
    }

</script>
<style>
    
</style>
@endpush