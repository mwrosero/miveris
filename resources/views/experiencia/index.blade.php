@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Cuéntanos tu experiencia
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Cuéntanos tu experiencia') }}</h5>
    <section class="p-3 mb-3">
        <div class="row g-0 justify-content-center mt-5">
            <div class="col-auto col-md-5 col-lg-4">
                <div class="card rounded-0">
                    <div class="card-body p-3">
                        <h4 class="fw-semibold">{{ __('Bienvenido a Veris') }}</h4>
                        <a href="#" class="btn btn-outline-primary-veris w-100 mb-2 py-3">{{ __('Ingresar como empresa') }}</a>
                        <a href="#" class="btn btn-outline-success-veris w-100 py-3">{{ __('Ingresar como paciente') }}</a>
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