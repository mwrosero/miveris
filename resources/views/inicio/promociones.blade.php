@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Promociones
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Promociones') }}</h5>
    <section class="p-3 mb-3">
        <form class="d-flex justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0" id="search"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control bg-transparent border-0" name="search" id="search" placeholder="Buscar plan preventivo" aria-describedby="search" />
                </div>
            </div>
        </form>

        <div class="row justify-content-center">
            <div class="col-auto col-lg-10">
                <div class="row gy-3">
                    <div class="col-auto col-md-6">
                        <div class="card">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3 col-md-auto rounded-end-circle d-flex justify-content-center align-items-center py-2" style="background: #E7E9EC;">
                                        <img src="{{ asset('assets/img/svg/Character.svg') }}" class="img-fluid ms-1 ps-1 me-3" alt="{{ __('promoción') }}" width="64">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body py-2 px-3">
                                            <h6 class="text-end fw-bold">Prevención y Cuidado Mamario Integral</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-bold text-primary-veris lh-1 mb-0">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
        
                    <div class="col-auto col-md-6">
                        <div class="card">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3 col-md-auto rounded-end-circle d-flex justify-content-center align-items-center py-2" style="background: #E7E9EC;">
                                        <img src="{{ asset('assets/img/svg/Character.svg') }}" class="img-fluid ms-1 ps-1 me-3" alt="{{ __('promoción') }}" width="64">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body py-2 px-3">
                                            <h6 class="text-end fw-bold">Cuida Tu Corazón: CONTROL HIPERTENSIÓN</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-bold text-primary-veris lh-1 mb-0">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
        
                    <div class="col-auto col-md-6">
                        <div class="card">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3 col-md-auto rounded-end-circle d-flex justify-content-center align-items-center py-2" style="background: #E7E9EC;">
                                        <img src="{{ asset('assets/img/svg/Character.svg') }}" class="img-fluid ms-1 ps-1 me-3" alt="{{ __('promoción') }}" width="64">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body py-2 px-3">
                                            <h6 class="text-end fw-bold">Ecografía Mamaria + Consulta Ginecología</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-bold text-primary-veris lh-1 mb-0">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
        
                    <div class="col-auto col-md-6">
                        <div class="card">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3 col-md-auto rounded-end-circle d-flex justify-content-center align-items-center py-2" style="background: #E7E9EC;">
                                        <img src="{{ asset('assets/img/svg/Character.svg') }}" class="img-fluid ms-1 ps-1 me-3" alt="{{ __('promoción') }}" width="64">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body py-2 px-3">
                                            <h6 class="text-end fw-bold">Plan Cuidado Esencial Femenino (Imagen y consulta)</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-bold text-primary-veris lh-1 mb-0">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script></script>
@endpush