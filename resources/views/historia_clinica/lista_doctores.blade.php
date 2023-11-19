@extends('template.app-template-veris')
@section('title')
Mi Veris - Historia clínica
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Historia clínica') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white py-2 mb-3">
                <div class="d-flex jusntify-content-start">
                    <div class="form-check form-check-reverse">
                        <input class="form-check-input cursor-pointer" type="checkbox" id="selectAll" />
                        <label class="form-check-label cursor-pointer" for="selectAll"> Seleccionar todos</label>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-check-label cursor-pointer" for="flexCheckDefault-1">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row gx-2 align-items-center">
                                <div class="col-2">
                                    <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" width="62" alt="centro medico">
                                </div>
                                <div class="col-8">
                                    <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                    <p class="fs--2 mb-0">Cardiología</p>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input cursor-pointer" type="checkbox" value="" id="flexCheckDefault-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-check-label cursor-pointer" for="flexCheckDefault-2">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row gx-2 align-items-center">
                                <div class="col-2">
                                    <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" width="62" alt="centro medico">
                                </div>
                                <div class="col-8">
                                    <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                    <p class="fs--2 mb-0">Optometría</p>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input cursor-pointer" type="checkbox" value="" id="flexCheckDefault-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-check-label cursor-pointer" for="flexCheckDefault-1">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row gx-2 align-items-center">
                                <div class="col-2">
                                    <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" width="62" alt="centro medico">
                                </div>
                                <div class="col-8">
                                    <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                    <p class="fs--2 mb-0">Cardiología</p>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input cursor-pointer" type="checkbox" value="" id="flexCheckDefault-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-check-label cursor-pointer" for="flexCheckDefault-2">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row gx-2 align-items-center">
                                <div class="col-2">
                                    <img src="{{ asset('assets/img/avatars/avatar_doctor.png') }}" class="card-img-top" width="62" alt="centro medico">
                                </div>
                                <div class="col-8">
                                    <h6 class="fw-bold mb-0">Dr(a) Villon Asencio Abel Armando</h6>
                                    <p class="fs--2 mb-0">Optometría</p>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input cursor-pointer" type="checkbox" value="" id="flexCheckDefault-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <div class="col-12 text-center mt-5">
                <a href="#" class="btn btn-primary-veris">Continuar</a>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->
<script>
    // Select All checkbox click
    const selectAll = document.querySelector('#selectAll'),
    checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener('change', t => {
        checkboxList.forEach(e => {
            e.checked = t.target.checked;
        });
    });
</script>
@endpush