@extends('template.external')
@section('title')
Veris - Atención
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.0.6"></script>

@include('external.components.navbar')

<div class="flex-grow-1 container-p-y pt-0 h-100">
	<section class="px-3  h-100">
		<div class="row justify-content-center h-100">
			<div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center align-items-center">
				<div class="card bg-transparent border-0 shadow-none">
					<div class="card-body text-center">
						<div class="card-header text-center">
							<img src="{{ asset('assets/img/svg/sand-clock.svg') }}" alt="">
						</div>
						<div class="card-body p-0 m-0 mb-3 pt-3">
							<h5 class="mb-3 fs-20 line-height-24 fw-medium">
								Este enlace ha expirado
							</h5>
							<p class="fs-12 line-height-16 fw-normal mb-0">Lo sentimos, el enlace que estás intentando utilizar ya no está disponible o ha caducado por motivos de seguridad.</p>
							<a href="https://www.veris.com.ec/paquetes-preventivos/" class="text-veris-ai text-decoration-none fs-14 line-height-18 d-block" style="margin-top: 96px;">Ver todos los paquetes</a>
						</div>
						@if(isset($error))
							@if($showButtonRePay)
							<div class="card-footer text-muted">
								<a href="/external/payment?{!! $urlRetornoPago !!}" class="btn btn-primary-veris fs--18 line-height-24 w-100 py-3 px-32 shadow-none d-flex justify-content-between align-items-center mt-3" id="btn-next">
	                                <span class="col-12 shadow-none">Intentar pagar nuevamente</span>
	                            </a>
							</div>
							@endif
						@else
							<div class="card-footer text-muted">
								<a href="/external/payment?{{ session('url') }}" class="btn btn-primary-veris fs--18 line-height-24 w-100 py-3 px-32 shadow-none d-flex justify-content-between align-items-center mt-3" id="btn-next">
	                                <span class="col-12 shadow-none">Intentar pagar nuevamente</span>
	                            </a>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection