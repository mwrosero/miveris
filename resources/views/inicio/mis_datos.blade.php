@extends('template.app-template-veris')
@section('title')
Mi Veris - Mis Datos
@endsection
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">Mis Datos</h5>
    <div class="row g-0 justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card bg-transparent shadow-none">
                <div class="card-body">
                    <form class="row g-3" action="" method="post">
                        @csrf
                        <div class="col-12 justify-content-center align-items-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <span class="avatar avatar-xxl">
                                    <img src="{{ asset('assets/img/avatars/avatar.svg') }}" class="avatar-img rounded-circle" alt="user">
                                </span>
                            </div>
                            <p class="user-name text-center fw-bold fs-sm mb-3">María Donoso</p>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <label for="nombre" class="form-label fw-semibold">{{ __('Nombre') }}</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="primerApellido" class="form-label fw-semibold">{{ __('Primer apellido') }}</label>
                                    <input type="text" class="form-control" name="primerApellido" id="primerApellido" value="" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="segundoApellido" class="form-label fw-semibold">{{ __('Segundo apellido') }}</label>
                                    <input type="text" class="form-control" name="segundoApellido" id="segundoApellido" value="" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="fechaNacimiento" class="form-label fw-semibold">{{ __('Fecha de nacimiento') }} *</label>
                                    <input type="text" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="" required />
                                    <div class="invalid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="sexo" class="form-label fw-semibold">{{ __('Sexo') }} *</label>
                                    <select class="form-select" name="sexo" id="sexo" required>
                                        <option selected disabled value="">Selecciona uno</option>
                                        <option>...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <label for="mail" class="form-label fw-semibold">{{ __('Correo electrónico') }} *</label>
                                    <input type="email" class="form-control" name="mail" id="mail" value="" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="telefono" class="form-label fw-semibold">{{ __('Teléfono') }} *</label>
                                    <input type="number" class="form-control" name="telefono" id="telefono" value="" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="provincia" class="form-label fw-semibold">{{ __('Provincia') }} *</label>
                                    <select class="form-select" name="provincia" id="provincia" required>
                                        <option selected disabled value="">Selecciona uno</option>
                                        <option>...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="ciudad" class="form-label fw-semibold">{{ __('Ciudad') }} *</label>
                                    <select class="form-select" name="ciudad" id="ciudad" required>
                                        <option selected disabled value="">Selecciona uno</option>
                                        <option>...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid state.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="direccion" class="form-label fw-semibold">{{ __('Dirección') }}</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="" required />
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button class="btn btn-primary-veris w-50" type="submit">{{ __('Guardar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
</script>
@endpush