@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Nueva orden externa
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Nueva orden externa') }}</h5>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3" enctype="multipart/form-data">
                            <label for="upload" class="btn btn-light me-2" tabindex="0">
                                <span class="d-none d-sm-block"><i class="fa-solid fa-upload"></i> Añadir archivos .png .jpg .jpeg .pdf</span>
                                <i class="fa-solid fa-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpg, image/jpeg, image/pdf," multiple />
                            </label>
                            <div class="mt-0" id="fileList"></div>
                            <p class="fs--1 mb-0 text-dark">Puedes subir hasta 5 fotos o archivos, cada uno de hasta 8Mb.</p>
                            <p class="fs--1 my-0 text-dark">Recuerda lo siguiente al enviar tu orden:</p>
                            <ul class="mx-3 my-0 px-3 fs--1 text-dark">
                                <li>Imagen clara</li>
                                <li>Nombres completos</li>
                                <li>Fecha</li>
                                <li>Diagnóstico</li>
                                <li>Firma y sello del médico</li>
                            </ul>
                            <h5>Registro de datos del paciente</h5>
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Selecciona el paciente *</label>
                                <select class="form-select bg-neutral" name="paciente" id="paciente" required>
                                    <option selected disabled value="">Selecciona el paciente</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-bold">Cédula o pasaporte *</label>
                                <input type="text" class="form-control bg-neutral" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required />
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold">Email *</label>
                                <input type="email" class="form-control bg-neutral" name="email" id="email" placeholder="jaz.ordenana@gmail.com" required />
                            </div>
                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                                <input type="number" class="form-control bg-neutral" name="telefono" id="telefono" placeholder="0997874554" required />
                            </div>
                            <div class="col-md-12">
                                <label for="conveio" class="form-label fw-bold">Elige el convenio *</label>
                                <select class="form-select bg-neutral" name="conveio" id="conveio" required>
                                    <option selected disabled value="">Elige el convenio</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Siguiente</button>
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
<!-- imagen -->
<script>
    // Obtener referencia al elemento de carga de archivos
    var inputUpload = document.getElementById('upload');
    // Obtener referencia al contenedor de la lista de archivos
    var fileListContainer = document.getElementById('fileList');

    // Agregar evento de cambio al elemento de carga de archivos
    inputUpload.addEventListener('change', function() {
        // Obtener la lista de archivos seleccionados
        var archivos = inputUpload.files;

        // Limpiar la lista de archivos anterior
        fileListContainer.innerHTML = '';

        // Verificar la cantidad de archivos seleccionados
        if (archivos.length > 5) {
            agregarMensaje('Seleccione un máximo de 5 archivos.');
            inputUpload.value = ''; // Limpiar la selección
            return;
        }

        // Verificar el tamaño de cada archivo y mostrar detalles
        for (var i = 0; i < archivos.length; i++) {
            var archivo = archivos[i];

            if (archivo.size > 8 * 1024 * 1024) { // 8 MB en bytes
                agregarMensaje('El archivo ' + archivo.name + ' supera el tamaño máximo de 8 MB.');
                inputUpload.value = ''; // Limpiar la selección
                return;
            }

            // Verificar la extensión del archivo
            var extensionesPermitidas = ['.png', '.jpg', '.jpeg', '.pdf'];
            var extension = archivo.name.slice(((archivo.name.lastIndexOf(".") - 1) >>> 0) + 2);

            if (extensionesPermitidas.indexOf('.' + extension.toLowerCase()) === -1) {
                agregarMensaje('El archivo ' + archivo.name + ' no es un formato permitido.');
                inputUpload.value = ''; // Limpiar la selección
                return;
            }

            fileListContainer.classList.add('mt-3');
            // Crear elemento div para mostrar detalles del archivo
            var archivoDiv = document.createElement('div');
            archivoDiv.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'border', 'rounded', 'fs--2', 'ps-2', 'mb-2');
            archivoDiv.innerHTML = '<strong class="fs--2">' + archivo.name + '</strong> (' + formatBytes(archivo.size) + ')';

            // Agregar botón de eliminación
            var btnEliminar = document.createElement('button');
            btnEliminar.classList.add('btn', 'btn-sm', 'fs--2', 'text-danger', 'shadow-none');
            btnEliminar.innerHTML = '<i class="bi bi-trash"></i>';
            btnEliminar.addEventListener('click', function() {
                // Evitar el envío del formulario
                event.preventDefault();
                // Eliminar el elemento div al que pertenece el botón
                this.parentNode.remove();
                // Limpiar la selección
                inputUpload.value = '';
            });

            archivoDiv.appendChild(btnEliminar);
            fileListContainer.appendChild(archivoDiv);
        }
    });

    // Función para agregar mensajes debajo de la etiqueta label
    function agregarMensaje(mensaje) {
        var mensajeDiv = document.createElement('div');
        mensajeDiv.classList.add('mensaje-error', 'fw-bold', 'fs--2');
        // mensajeDiv.className = '';
        mensajeDiv.textContent = mensaje;
        fileListContainer.appendChild(mensajeDiv);
    }

    // Función para formatear bytes a kilobytes o megabytes
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
</script>
@endpush