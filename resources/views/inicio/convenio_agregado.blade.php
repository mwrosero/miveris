@extends('template.app-template-veris')
@section('title')
Mi Veris - Convenio agregado
@endsection
@section('content')

<div class="flex-grow-1 container-p-y pt-0">
    <section class="pt-4 p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 px-0">
                <div class="row">
                    <div class="col-12 text-center my-3">
                        <i class="fa-solid fa-circle-check text-veris-ai fs--64"></i>
                    </div>
                    <div class="col-12 text-center">
                        <p class="fs--28 line-height-36 fw-medium text-veris mb-0">Seguro médico agregado</p>
                        <p class="fs--16 line-height-20 my-4 text-veris mb-0">Hemos guardado tu seguro médico exitosamente.</p>
                    </div>
                    <div class="col-12 text-center">
                        <img src="{{asset('assets/img/svg/convenio-agregado.svg')}}" class="img-fluid mx-auto" width="300px" alt="">
                    </div>
                    <div class="col-12 mt--32">
                        <a href="/mis-convenios" class="btn btn-primary-veris rounded-3 fs--18 line-height-24 w-100 px-4 py-3 text-white" id="btnGuardar">Ver seguros</a>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')

@endpush