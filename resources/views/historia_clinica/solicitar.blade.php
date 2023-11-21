@extends('template.app-template-veris')
@section('title')
Mi Veris - Historia clínica
@endsection
@push('css')
<!-- css -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="solictarHistoriaClinicaModal" tabindex="-1" aria-labelledby="solictarHistoriaClinicaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h5>Veris</h5>
                    <p>Solicitud creada exitosamente</p>
                </div>
                <div class="modal-footer flex-column align-items-stretch w-100 gap-2 p-3 pt-0">
                    <button type="button" class="btn btn-primary-veris" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Historia clínica') }}</h5>
    <section class="p-3 pt-0 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-5 py-4">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-md-12">
                                    <label for="fechaDesde" class="form-label fw-bold">{{ __('Desde la fecha') }}</label>
                                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="fechaHasta" class="form-label fw-bold">{{ __('Hasta la fecha') }}</label>
                                    <input type="text" class="form-control bg-neutral" placeholder="Desde la fecha" name="fechaHasta" id="fechaHasta" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="motivo" class="form-label fw-bold">{{ __('Motivo de su consulta') }}</label>
                                    <textarea class="form-control" name="motivo" id="motivo" rows="4" maxlength="400"></textarea>
                                    <div class="text-end fs--3" id="contadorCaracteres">0 / 400</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="terminoCondicionCheck" required />
                                        <label class="form-check-label fs--1" for="terminoCondicionCheck">
                                            Acepto los Términos y condiciones
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary-veris w-100" type="submit">Solicitar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#fechaDesde", {
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
        // maxDate: "today"
    });

    // Obtener referencia al textarea y al elemento de conteo de caracteres
    var textareaMotivo = document.getElementById('motivo');
    var contadorCaracteres = document.getElementById('contadorCaracteres');

    // Agregar evento de input al textarea
    textareaMotivo.addEventListener('input', function() {
        // Obtener la cantidad de caracteres ingresados
        var cantidadCaracteres = textareaMotivo.value.length;

        // Actualizar el contador de caracteres
        contadorCaracteres.textContent = cantidadCaracteres + ' / 400';
    });
</script>
@endpush