@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elige central médica
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elige central médica') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-2 pt-2">
                        <div class="row gx-2">
                            <div class="col-3">
                                <img src="{{ asset('assets/img/card/avatar_central_medica.png') }}" class="card-img-top" alt="centro medico">
                            </div>
                            <div class="col-9">
                                <h6 class="fw-bold mb-1">{{ __('VERIS - ALBORADA') }}</h6>
                                <p class="fs--2">{{ __('Av. Rodolfo Baquerizo Nazur y José María Egas') }}.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end pb-2">
                        <a href="#!" class="btn btn-sm btn-primary-veris">{{ __('Ver Medicos') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-2 pt-2">
                        <div class="row gx-2">
                            <div class="col-3">
                                <img src="{{ asset('assets/img/card/avatar_central_medica.png') }}" class="card-img-top" alt="centro medico">
                            </div>
                            <div class="col-9">
                                <h6 class="fw-bold mb-1">{{ __('VERIS - ALBORADA') }}</h6>
                                <p class="fs--2">{{ __('Av. Rodolfo Baquerizo Nazur y José María Egas') }}.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end pb-2">
                        <a href="#!" class="btn btn-sm btn-primary-veris">{{ __('Ver Medicos') }}</a>
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