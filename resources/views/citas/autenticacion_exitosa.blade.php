@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Autenticación exitosa
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card bg-transparent shadow-none mt-3">
                    <div class="card-body p-0">
                        <form class="row g-3">
                            <div class="text-center">
                                <div class="avatar avatar-lg mx-auto mb-3">
                                    <span class="avatar-initial rounded-circle bg-primary">
                                        <i class="bi bi-check-lg fs-2"></i>
                                    </span>
                                </div>
                                <h1 class="modal-title fs-5 mb-3" id="conformarPagoLabel">Autenticación exitosa</h1>
                            </div>
                            <p class="fs--1 text-center mt-0 mb-3">Tu tarjeta se confirmó con éxito.</p>
                            <img src="{{ asset('assets/img/svg/autenticacion_exitosa.svg')}}" alt="">
                            <div class="col-12">
                                <a href="#" class="btn btn-lg btn-primary-veris w-100">Continuar</a>
                            </div>
                        </form>
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