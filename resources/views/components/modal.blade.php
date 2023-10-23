<!-- resources/views/components/modal.blade.php -->
@props(['id' => 'modalAlert', 'title' => 'Título', 'message' => 'Mensaje'])

<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-alert-component modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
            </div>
            <div class="modal-body">
                <p>{{ $message }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-veris w-100 m-0" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>