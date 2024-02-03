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
                    <h5 class="fw-bold fs-24" id="titulo">Registro exitoso</h5>
                    <p class="fs--1  m-0 mt-3" id="mensaje"></p>
                </div>
                <div class="modal-footer pb-3 pt-0 px-3">
                    <button type="button" class="btn btn-primary-veris w-100 m-0" data-bs-dismiss="modal" id="btnEntendido">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Nueva orden externa') }}</h5>
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
                                <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpg, image/jpeg, image/pdf," multiple />
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
                            <h5>Registro de datos del paciente</h5>
                            <div class="col-md-12">
                                <label for="paciente" class="form-label fw-bold">Nombre del Paciente *</label>
                                <input type="text" class="form-control bg-neutral" name="paciente" id="paciente" placeholder="Nombre del paciente" disabled />
                            </div>
                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fw-bold">Cédula o pasaporte *</label>
                                <input type="text" class="form-control bg-neutral" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="0999999999" required disabled/>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold">Email *</label>
                                <input type="email" class="form-control bg-neutral" name="email" id="email"  required />
                            </div>
                            <div class="col-md-12">
                                <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                                <input type="number" class="form-control bg-neutral" name="telefono" id="telefono"  required />
                            </div>
                            <div class="col-md-12 d-none">
                                <label for="conveio" class="form-label fw-bold">Elige el convenio *</label>
                                <input type="text" class="form-control bg-neutral" name="conveio" id="conveio" placeholder="Convenio" disabled />
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

            fileListContainer.classList.add('mt-3');
            // Crear elemento div para mostrar detalles del archivo
            var archivoDiv = document.createElement('div');
            archivoDiv.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'border', 'rounded', 'fs--2', 'ps-2', 'mb-2');
            archivoDiv.innerHTML = '<strong class="fs--2">' + archivo.name + '</strong> (' + formatBytes(archivo.size) + ')';

            // Agregar botón de eliminación
            var btnEliminar = document.createElement('button');
            btnEliminar.classList.add('btn', 'btn-sm', 'fs-1', 'text-danger', 'shadow-none');
            btnEliminar.innerHTML = '<i class="bi bi-trash"></i>';
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

<script>
    // variables globales
    let params = @json($data1);
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);




    let tipoIdentificacion = dataCita.paciente.tipoIdentificacion;
    let numeroIdentificacion = dataCita.paciente.numeroIdentificacion;
    let nombrePaciente = dataCita.paciente.primerNombre;
    let convenio = dataCita?.convenio;
    let codigoConvenio = dataCita?.convenio.codigoConvenio;
    let nombreConvenio = dataCita?.convenio.nombreConvenio;
    let direccion = dataCita?.paciente.direccion;
    let datosPaciente = [];

    // llamada al dom
    document.addEventListener("DOMContentLoaded", async function() {
        
        // ocultar convenio si es null
        console.log('convenio', convenio);
        if (convenio.length == 0) {
            $('#conveio').parent().hide();
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
            $('#conveio').html(options);

            
            

        }
        return data;
    }


    // crear solicitud de orden externa

    async function crearSolicitudLaboratorioDomicilio() {
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
        formData.append("files", files);
        args["data"] = formData;


        console.log('args1111', args["data"]);

        const data = await call(args);
        console.log('actualizarDatosUsuario',data);
        if (data.code == 200) {
            // mostrar modal de exito
            $('#mensajeOrdenExitosa').modal('show');
            $('#titulo').text('Registro exitoso');
            
            $('#mensaje').text( 'Tu solicitud está en revisión, un asesor la validará y pronto podrás continuar con tu proceso.' ); 
            $('#btnEntendido').on('click', function(){
                // redireccionar a ordenes externas
                window.location.href = `/ordenes-externas`;
            });
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
            $('#conveio').val(dataCita.convenio.codigoConvenio);



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