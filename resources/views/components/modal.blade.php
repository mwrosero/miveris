<!-- resources/views/components/modal.blade.php -->
@props(['id' => 'modalAlert', 'title' => 'Título', 'message' => ''])

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-alert-component modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto title-section fw-bold" id="modalAlertTitle">{{ $title }}</h5>
            </div>
            <div class="modal-body text-center fs-14 mb-2" id="modalAlertMessage">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn w-50 m-0 fw-bold shadow-none border-0" data-bs-dismiss="modal" id="modalAlertButtonCancelar">Cancelar</button>
                <a href="#" type="button" class="btn bg-veris w-50 m-0 fw-bold d-none" id="modalAlertButtonAccion"></a>
                <button type="button" class="btn bg-veris w-100 m-0 fw-bold" data-bs-dismiss="modal" id="modalAlertButton">Aceptar</button>
            </div>
        </div>
    </div>
</div>