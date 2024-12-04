@extends('template.external')
@section('title')
Veris - Trazabilidad devoluciones
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.css" />
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/select2/select2.js"></script>

<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
@include('external.components.navbar')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Seguimiento de proceso de devolución') }}</h5>
    </div>
    <section class="mb-0 p-3 pb-0">
    	<div class="row mt-0">
    		<div class="col-6 offset-md-3 col-md-6 text-center p-3" id="info">
    		</div>
    	</div>
    </section>
</div>
<script>
	document.addEventListener("DOMContentLoaded", async function () {
		await obtenerTracking();
	})

	async function obtenerTracking(){
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/comprobantes/notas_creditos_x_devoluciones_bancarias?codigoEmpresa=1&page=1&perPage=10&tipoNotaCredito=TODOS&tipoFiltro=NUM_PACIENTE_COMPROBANTE&codigoTipoIdentificacion={{ $tipoIdentificacion }}&numeroIdentificacion={{ $numeroIdentificacion }}&numeroComprobante={{ $numeroFactura }}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        console.log(data);

        if(data.code == 200){
        	// dataDevolucion.parametros = data.data
        	let detalle = data.data.rows[0];
        	let elem = ``;
        	let estado = (detalle.estadoTrackingDevolucion == "TRANSFERENCIA REALIZADA") ? `Acreditado` : `En proceso`;
        	elem += `<h2>Estado: ${estado}</h2>`;
        	elem += `<p>Fecha de solicitud: ${detalle.notaCredito.fechaEmision}</p>`;
        	elem += `<p>Valor: ${detalle.notaCredito.valorTotal}</p>`;
        	elem += `<p>Motivo: ${detalle.notaCredito.descripcionMotivo}</p>`;
        	$('#info').html(elem);
        }
	}
</script>
@endsection