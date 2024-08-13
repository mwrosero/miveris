@extends('template.external')
@section('title')
Mi Veris - Comprobante de Pago
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar')

<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-3 pt-5 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
            	@if($data->data->estaPagado == true || $data->data->estaPagado == 1 ||  $data->data->estaFacturado)
                <div class="card bg-transparent">
                    <div class="card-body text-center">
                    	<div class="card-header">
		                    <h2 class="text-success">
		                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
		                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
		                        </svg>
		                        Pago exitoso
		                    </h2>
		                </div>
		                @if(isset($data->data->transacciones) && !empty($data->data->transacciones) && $data->data->transacciones != [])
		                <div class="card-body border-top border-bottom p-0 m-0 mb-3 pt-3">
		                    <?php
		                        foreach ($data->data->transacciones as $value) {    
		                    ?>
		                            <h4>Nro. Comprobante: <?= $value->numeroComprobante; ?></h4>
		                    <?php
		                        }
		                    ?>
		                </div>
		                @endif
		                <div class="card-footer text-muted">
		                    Fecha Solicitud: <?= $data->data->fechaSolicitud; ?>
		                    <br>
		                    Valor: <b>$<?= $data->data->valor; ?></b>
		                </div>
                    </div>
                </div>
                @else
                <h2 class="text-danger">
	                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
	                  <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
	                  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
	                </svg>
	                Pago no realizado.
	            </h2>
                @endif
            </div>
        </div>
    </section>
</div>

<script>
	let canalOrigen = (window.config.subdomain == "veris") ? "VER_CMV" : "VER_PMF";
	let data = @json($data);
</script>
@endsection