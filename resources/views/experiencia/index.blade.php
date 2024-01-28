@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Cuéntanos tu experiencia
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Cuéntanos tu experiencia') }}</h5>
    </div>
    
    <div class="iframe-container" style="overflow:hidden; padding-top:56.25%; position:relative;">
        <iframe src="https://cuentanostuexperiencia.veris.com.ec/vvoc/?cf_id=119345" style="border: 0; height: 100%; left: 0; position: absolute; top: 0; width: 100%;" title="Cuéntanos tu experiencia"></iframe>
    </div>
</div>
@endsection
@push('scripts')
<!-- script -->
@endpush