@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Elegir paciente
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-bold top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 pt-4">
                    <h5 class="mb-4">{{ __('Elige tu convenio:') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="list-group list-group-checkable d-grid gap-2 border-0">
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios1" value="" checked>
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios1">
                                Nombre del convenio
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios2">
                                Nombre del convenio
                            </label>

                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios3" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios3">
                                Nombre del convenio
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-3 pb-3">
                    <button type="button" class="btn fw-normal m-0" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Elegir paciente') }}</h5>
    <section class="p-3 mb-3">
        <div class="row">
            <div class="col-6 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{route('familia')}}">
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