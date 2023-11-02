@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elegir paciente
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elegir paciente') }}</h5>
    <section class="p-3 mb-3">
        <div class="row">
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="#">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                </div>
                            </div>
                            <p class="text-veris fw-bold fs--2">{{ __('Agregar nuevo paciente') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{route('citas.listaEspecialidades')}}">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-strong-magenta">{{ __('M') }}</span>
                                </div>
                            </div>
                            <p class="text-veris fw-bold fs--2 mb-0">{{ __('María Yanina Samaniego') }}</p>
                            <p class="text-veris fs--3 mb-0">{{ __('Yo') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{route('citas.listaEspecialidades')}}">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-success">{{ __('M') }}</span>
                                </div>
                            </div>
                            <p class="text-veris fw-bold fs--2 mb-0">{{ __('Manuel Ricardo Donoso') }}</p>
                            <p class="text-veris fs--3 mb-0">{{ __('Padre') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{route('citas.listaEspecialidades')}}">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-success">{{ __('M') }}</span>
                                </div>
                            </div>
                            <p class="text-veris fw-bold fs--2 mb-0">{{ __('Manuel RicardoDonoso') }}</p>
                            <p class="text-veris fs--3 mb-0">{{ __('Abuelo(a) Mat') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
</script>
@endpush