@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Cuéntanos tu experiencia
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0" style="background-color: #e4e5e6;">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Cuéntanos tu experiencia') }}</h5>
    </div>
    <section class="h-75">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-12 col-md-6 h-100">
                    <div class="card shadow-none h-100">
                        <div class="card-body">
                            <div class="iframe-container" style="">
                                <iframe src="https://cuentanostuexperiencia.veris.com.ec/vvoc/?cf_id=119345" style="border: 0; height: 100%; left: 0; position: absolute; top: 0; width: 100%;" title="Cuéntanos tu experiencia"></iframe>
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
<!-- script -->
@endpush