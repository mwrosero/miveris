@extends('template.external')
@section('title')
Mi Veris - Detalle Promoción
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar')

<div class="d-flex justify-content-between align-items-center bg-white">
    <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Detalle') }}</h5>
</div>
<section class="p-3 mb-3">
    <div class="row justify-content-center">
        <div class="col-auto col-md-5">
            <div class="card bg-transparent shadow-none">
                <div class="card-body px-0">
                    <div class="text-center mb--32">
                        <img src="{{ asset('assets/img/svg/veris-v60.svg') }}" class="img-fluid mb-3" alt="{{ __('veris') }}">
                        <h4 class="fs-24" id="nombrePaquete"></h4>
                    </div>
                    <p class="text-veris fs--1 fw-bold mb-2 d-none text-center" id="porcentajeDescuento"></p>
                    <div class="d-flex justify-content-center align-items-center mx-lg-4 mb--32 lh-1" id="detalleValoresPaquete">
                    </div>
                    <div class="card card-border mb-4">
                        <div class="card-body p-3">
                            <p class="fs--2 mb-4" id="descripcionPaquete"></p>
                            <h6 class="text-start fs--1 fw-medium mb-4">DETALLES DE PAQUETE</h6>
                            <ul class="fs--2 mb-3" id="detallePaquete">
                            </ul>
                        </div>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="text-center box-action">
                        <button type="button" class="btn btn-primary-veris btn-asignar w-100 fs--18 line-height-24 fw-medium px-4 py-3">
                            Continuar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let local = localStorage.getItem('external-cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    document.addEventListener("DOMContentLoaded", async function () {
        $('#nombrePaquete').html(capitalizarElemento(dataCita.paquete.nombrePaquete));

        $('#descripcionPaquete').html(dataCita.paquete.descripcionPaquete);

        // if(dataCita.paquete.idPaciente !== null){
        //     $('.box-action').html(`<button type="button" class="btn btn-primary-veris btn-asignar w-100 fs--18 line-height-24 fw-medium px-4 py-3">
        //                         Continuar
        //                     </button>`)
        // }

        $('body').on('click', '.btn-asignar', function(){
            let url = '/external/planes-promocionales/asignar/'
            localStorage.setItem('external-cita-{{ $params }}', JSON.stringify(dataCita));
            location.href = url + "{{ $params }}";
        })

        let valorAnteriorElem = ``;
        if(dataCita.paquete.porcentajeDescuento > 0){
            $('#porcentajeDescuento').html(`-${dataCita.paquete.porcentajeDescuento}% OFF`).removeClass('d-none');
            $('#porcentajeDescuento').removeClass('d-none');
            //$('#valorAnteriorPaquete').html(`$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}`);
            valorAnteriorElem += `<p class="fs--1 fw-normal mb-0 me-2" style="color: #6E7A8C !important;"><del id="valorAnteriorPaquete">$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}</del></p>`;
        }

        let elemValores = `${valorAnteriorElem}
            <h5 class="text-primary-veris fs--20 fw-bold mb-0" id="valorTotalPaquete">$${dataCita.paquete.valorTotalPaquete.toFixed(2)}</h5>`;

        $('#detalleValoresPaquete').html(elemValores)

        //consultarGrupoFamiliar();
        await obtenerDetallePaquetePromocional();

        // $('body').on('click', '.btn-asignar', function(){
        //     let url = '/citas-datos-facturacion/';
        //     dataCita.paciente = JSON.parse($(this).attr('data-rel'));
        //     localStorage.setItem('external-cita-{{ $params }}', JSON.stringify(dataCita));
        //     location.href = url + "{{ $params }}";
        // })
    })

    async function obtenerDetallePaquetePromocional(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=${dataCita.paquete.codigoEmpresaPaquete}&codigoPaquete=${dataCita.paquete.codigoPaquete}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            $('#detallePaquete').empty();
            dataCita.detallePaquete = data.data;
            let elem = ``;
            $.each(data.data.detallePromocion, function(key, value){
                $.each(value.detalles, function(k,v){
                    elem += `<li class="mb-0" title="${value.nombreServicio}">${v.nombreComercial}</li>`;
                })
            })
            $('#detallePaquete').append(elem);
        }else{
            alert(data.message);
        }
    }

</script>

@endsection