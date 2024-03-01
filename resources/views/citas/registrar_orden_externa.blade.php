@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - Nueva orden externa
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
@php
$data = utf8_encode(base64_decode(urldecode($params)));
$data1 = json_decode($data);
@endphp

<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal mensaje -->
    <div class="modal fade" id="mensajeOrdenExitosa" tabindex="-1" aria-labelledby="mensajeOrdenExitosaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h5 class="fw-bold fs-24 mb-0" id="titulo">Registro exitoso</h5>
                    <p class="fs--1 m-0" id="mensaje"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0 px-4 py-3" data-bs-dismiss="modal" id="btnEntendido">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalErrorArchivo" tabindex="-1" aria-labelledby="modalErrorArchivoLabel">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal mb-0 text-veris">Archivo no soportado, por favor revisa las especificaciones técnicas</p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris fw-medium fs--18 m-0 mb-3 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Nueva orden externa') }}</h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <form class="row g-3" enctype="multipart/form-data">
                            <label for="upload" class="btn btn-light me-2" tabindex="0">
                                <span class="d-none d-sm-block"><i class="fa-solid fa-upload"></i> Añadir archivos .png .jpg .jpeg .pdf</span>
                                <i class="fa-solid fa-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden="" accept=".png, .jpg, .jpeg, .pdf" multiple />
                            </label>
                            <div class="mt-0 text-nowrap overflow-hidden text-truncate" id="fileList"></div>
                            <p class="fs--1 mb-0 text-dark">Puedes subir hasta 5 fotos o archivos, cada uno de hasta 8Mb.</p>
                            <p class="fs--1 my-0 text-dark">Recuerda lo siguiente al enviar tu orden:</p>
                            <ul class="mx-3 my-0 px-3 fs--1 text-dark">
                                <li>Imagen clara</li>
                                <li>Nombres completos</li>
                                <li>Fecha</li>
                                <li>Diagnóstico</li>
                                <li>Firma y sello del médico</li>
                            </ul>
                            <h5 class="mb-0">Registro de datos del paciente</h5>
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Nombre del Paciente *</label>
                                <input type="text" class="form-control " name="paciente" id="paciente" placeholder="Nombre del paciente" disabled />
                            </div>
                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-bold">Cédula o pasaporte *</label>
                                <input type="text" class="form-control bg-neutral" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required disabled/>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold">Email *</label>
                                <input type="email" class="form-control " name="email" id="email"  required />
                            </div>
                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                                <input type="number" class="form-control " name="telefono" id="telefono"  required />
                            </div>
                            <div class="col-md-12">
                                <label for="convenio" class="form-label fw-bold">Convenio *</label>
                                <input type="text" class="form-control bg-neutral" name="convenio" id="convenio" placeholder="Convenio" disabled />
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary-veris w-100" type="submit" id="botonSiguiente">Siguiente</button>

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
    var totalArchivos = 0;

    var inputUpload = document.getElementById('upload');

    // Obtener referencia al contenedor de la lista de archivos
    var fileListContainer = document.getElementById('fileList');

    // Agregar evento de cambio al elemento de carga de archivos
    inputUpload.addEventListener('change', function() {
        totalArchivos = 0;
        $('#fileList').empty()
        // Obtener la lista de archivos seleccionados
        var archivos = inputUpload.files;
        // Verificar la cantidad total de archivos (ya cargados más los nuevos seleccionados)
        if (totalArchivos + archivos.length > 5) {
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

            //let elem = ``

            fileListContainer.classList.add('mt-3');
            // Crear elemento div para mostrar detalles del archivo
            var archivoDiv = document.createElement('div');
            archivoDiv.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'border', 'rounded', 'fs--3', 'ps-2', 'mb-2');
            archivoDiv.innerHTML = '<strong class="fs--3 overflow-hidden text-truncate w-75">' + archivo.name + '</strong> (' + formatBytes(archivo.size) + ')';

            // Agregar botón de eliminación
            var btnEliminar = document.createElement('button');
            btnEliminar.classList.add('btn', 'btn-sm', 'text-danger', 'shadow-none');
            btnEliminar.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.125 5C20.4375 5 20.75 5.3125 20.75 5.625C20.75 5.97656 20.4375 6.25 20.125 6.25H3.875C3.52344 6.25 3.25 5.97656 3.25 5.625C3.25 5.3125 3.52344 5 3.875 5H7.625L8.91406 3.28125C9.26562 2.8125 9.8125 2.5 10.4375 2.5H13.5625C14.1484 2.5 14.6953 2.8125 15.0469 3.28125L16.375 5H20.125ZM9.1875 5H14.8125L14.0312 4.02344C13.9141 3.86719 13.7578 3.75 13.5625 3.75H10.4375C10.2422 3.75 10.0469 3.86719 9.92969 4.02344L9.1875 5ZM18.875 7.5C19.1875 7.5 19.5 7.8125 19.5 8.125V19.375C19.5 21.1328 18.0938 22.5 16.375 22.5H7.625C5.86719 22.5 4.5 21.1328 4.5 19.375V8.125C4.5 7.8125 4.77344 7.5 5.125 7.5C5.4375 7.5 5.75 7.8125 5.75 8.125V19.375C5.75 20.4297 6.57031 21.25 7.625 21.25H16.375C17.3906 21.25 18.25 20.4297 18.25 19.375V8.125C18.25 7.8125 18.5234 7.5 18.875 7.5ZM8.875 18.75C8.875 19.1016 8.5625 19.375 8.25 19.375C7.89844 19.375 7.625 19.1016 7.625 18.75V10C7.625 9.6875 7.89844 9.375 8.25 9.375C8.5625 9.375 8.875 9.6875 8.875 10V18.75ZM12.625 18.75C12.625 19.1016 12.3125 19.375 12 19.375C11.6484 19.375 11.375 19.1016 11.375 18.75V10C11.375 9.6875 11.6484 9.375 12 9.375C12.3125 9.375 12.625 9.6875 12.625 10V18.75ZM16.375 18.75C16.375 19.1016 16.0625 19.375 15.75 19.375C15.3984 19.375 15.125 19.1016 15.125 18.75V10C15.125 9.6875 15.3984 9.375 15.75 9.375C16.0625 9.375 16.375 9.6875 16.375 10V18.75Z" fill="#D84315"/></svg>';
            btnEliminar.addEventListener('click', function() {
                event.preventDefault();
                this.parentNode.remove(); // Elimina el div del archivo
                totalArchivos--; // Disminuye el contador de archivos

                // Actualiza la lista de archivos en el input
                var dataTransfer = new DataTransfer();
                for (var i = 0; i < inputUpload.files.length; i++) {
                    if (inputUpload.files[i].name !== archivo.name) {
                        dataTransfer.items.add(inputUpload.files[i]);
                    }
                }
                inputUpload.files = dataTransfer.files;

                // Verifica si aún hay archivos después de la eliminación
                if (inputUpload.files.length === 0) {
                    $('#botonSiguiente').prop('disabled', true);
                }
            });


            archivoDiv.appendChild(btnEliminar);
            fileListContainer.appendChild(archivoDiv);
            totalArchivos++; // Aumentar el contador
        }
    });

    // Función para agregar mensajes debajo de la etiqueta label
    function agregarMensaje(mensaje) {
        /*var mensajeDiv = document.createElement('div');
        mensajeDiv.classList.add('mensaje-error', 'fw-bold', 'fs--2');
        // mensajeDiv.className = '';
        mensajeDiv.textContent = mensaje;
        fileListContainer.appendChild(mensajeDiv);*/
        $('#modalErrorArchivo').modal('show');
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

<script>
    // variables globales
    let params = @json($data1);
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    if (dataCita.origen == 'ordenExternaDomicilio') {
        // deshabilitar campos
        $('#paciente').prop('disabled', true);
        $('#numeroIdentificacion').prop('disabled', true);
        $('#email').prop('disabled', true);
        $('#telefono').prop('disabled', true);
        $('#convenio').prop('disabled', true);
        // agregar bg-neutral a los campos faltantes
        $('#paciente').addClass('bg-neutral');
        $('#numeroIdentificacion').addClass('bg-neutral');
        $('#email').addClass('bg-neutral');
        $('#telefono').addClass('bg-neutral');
        $('#convenio').addClass('bg-neutral');

    }
    let tipoIdentificacion = dataCita.paciente.tipoIdentificacion;
    let numeroIdentificacion = dataCita.paciente.numeroIdentificacion;
    let nombrePaciente = dataCita.paciente.primerNombre + ' ' + dataCita.paciente.segundoNombre + ' ' + dataCita.paciente.primerApellido + ' ' + dataCita.paciente.segundoApellido;
    let convenio = dataCita?.convenio;
    let codigoConvenio = dataCita.convenio.codigoConvenio || '';
    let nombreConvenio = dataCita.convenio.nombreConvenio || '';
    let direccion = dataCita?.paciente.direccion;
    let referencia = dataCita.paciente.referencias || '';
    let codigoCiudad = dataCita?.paciente.codigoCiudad  || '';
    let telefono = dataCita?.paciente.telefono;
    let latitud = dataCita?.paciente.latitud || '';
    let longitud = dataCita?.paciente.longitud  || '';
    let esDomicilio = dataCita?.esDomicilio;
    let codigoEmpresaConvenio = dataCita.convenio.codigoEmpresaConvenio || '';
    let correo = dataCita?.paciente.correo;

    let datosPaciente = [];

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function() {
        
        // ocultar convenio si es null
        console.log('convenio', convenio);
        if (convenio.length == 0) {
            $('#convenio').parent().hide();
        }
        
        llenarDatos();

        $('#botonSiguiente').prop('disabled', true);

    });

    // funciones asyncronas

    async function consultarConvenios(event) {
        
        let args = [];
        let canalOrigen = _canalOrigen;
        let dataRel = $(event.currentTarget).data('rel');
        console.log('dataRel', dataRel);

        let codigoUsuario = dataRel.numeroIdentificacion;
        let tipoIdentificacion = dataRel.tipoIdentificacion;
        args["endpoint"] = api_url + `/digitalestest/v1/comercial/paciente/convenios?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${codigoUsuario}&codigoEmpresa=1&tipoCredito=CREDITO_SERVICIOS&esOnline=N&excluyeNinguno=S  `
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataRel', data);

        if (data.code == 200) {
            // llenar select
            let options = '';
            data.data.forEach(element => {
                options += `<option value="${element.codigoConvenio}">${element.nombreConvenio}</option>`;
            });
            $('#convenio').html(options);
        }
        return data;
    }

    // crear solicitud de orden externa

    async function crearSolicitudLaboratorioDomicilio() {

        // si origen es ordenExternaDomicilio
        if (dataCita.origen !== 'ordenExternaDomicilio') {
            nombrePaciente = $('#paciente').val();
            correo = $('#email').val();
            telefono = $('#telefono').val();
            numeroIdentificacion = $('#numeroIdentificacion').val();
            esDomicilio = false;
        }

        let args = [];
        args["endpoint"] = api_url + "/digitalestest/v1/domicilio/laboratorio/solicitud";
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "formdata";

        // recibir los datos de la imagen 
        let files = document.getElementById('upload').files;

        let formData = new FormData();
        formData.append("tipoIdentificacionPaciente", tipoIdentificacion);
        formData.append("identificacionPaciente",  numeroIdentificacion);
        formData.append("nombrePaciente", nombrePaciente);
        formData.append("direccion", direccion);
        formData.append("telefono", telefono);
        formData.append("origenInvocacion", "WEB_EXTERNA");
        formData.append("mail", correo);
        formData.append("referencia", referencia);
        formData.append("codigoCiudad", codigoCiudad);
        formData.append("latitud", latitud);
        formData.append("longitud", longitud);
        formData.append("esDomicilio", esDomicilio);
        formData.append("codigoEmpresaConvenio", codigoEmpresaConvenio);
        formData.append("codigoConvenio", codigoConvenio);
        formData.append("nombreConvenio", nombreConvenio);
        formData.append("archivos", files);

        args["data"] = formData;

        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        if (data.code == 200) {
            // mostrar modal de exito
            $('#mensajeOrdenExitosa').modal('show');
            $('#titulo').text('Registro exitoso');
            
            $('#mensaje').text(data.message);
            $('#btnEntendido').on('click', function(){
                // redireccionar a ordenes externas
                window.location.href = `/ordenes-externas`;
            });
        } else if (data.code != 200) {
            // mostrar modal de error
            $('#mensajeOrdenExitosa').modal('show');
            $('#titulo').text('Error');
            $('#mensaje').text(data.message);
        }

        return data;
    }

    // enviar formulario

    $("form").on('submit', async function(e) {
        e.preventDefault(); 
        await crearSolicitudLaboratorioDomicilio();
    });

    // llenar datos con localstorage
    function llenarDatos() {
        if (dataCita) {
            $('#paciente').val(
                (dataCita.paciente.primerNombre || '') + ' ' +
                (dataCita.paciente.segundoNombre || '') + ' ' +
                (dataCita.paciente.primerApellido || '') + ' ' +
                (dataCita.paciente.segundoApellido || '')
            );

            $('#numeroIdentificacion').val(dataCita.paciente.numeroIdentificacion);
            $('#email').val(dataCita.paciente.correo);
            $('#telefono').val(dataCita.paciente.telefono);
            $('#convenio').val(`${ (dataCita.convenio.nombreConvenio !== null) ? dataCita.convenio.nombreConvenio : "Ninguno" }`);
        }
        let disabled = false;
        $("form input, form textarea").each(function(){
            if($(this).val() == ""){
                disabled = true;
            }
        });

        if(disabled){
            $('#btnSiguiente').attr('disabled', true);
        }else{
            $('#btnSiguiente').attr('disabled', false);
        }
    }


    // habilitar boton siguiente si hay datos en el formulario y hay archivos cargados 
    $('#upload').on('change', function(){
        if($('#upload').val() != '' && $('#email').val() != '' && $('#telefono').val() != ''){
            $('#botonSiguiente').prop('disabled', false);
        }else{
            $('#botonSiguiente').prop('disabled', true);
        }
    });

</script>
@endpush