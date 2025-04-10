<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>PhantomX</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.svg') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/external/phantomx/css/theme-phantomx.css?v=1.0')}}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>
<body>
    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalTitle">Vista previa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="previewModalBody">
                    <!-- Preview content will be added here -->
                </div>
            </div>
        </div>
    </div>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid align-items-center px-3 px-lg-5">
                <a class="" href="#">
                    <img src="{{ asset('assets/external/phantomx/img/logo/phantomx.svg')}}" alt="Logo" width="112" />
                </a>
                <a class="" href="#">
                    <img src="{{ asset('assets/external/phantomx/img/logo/veris.svg')}}" alt="Logo" width="72" />
                </a>
            </div>
        </nav>
    </header>
    <main>
        <section class="container-fluid px-0">
            <div class="text-center my-4">
                <h2 class="fw-semibold text-title-2">Soportes Paperless</h2>
            </div>
            <div class="accordion accordion-flush" id="accordionDocument">
                
            </div>
        </section>
        <div class="container-fluid px-3 px-lg-5">
            <div class="row justify-content-center align-items-center my-4">
                <div class="col-12 col-lg-2">
                    <button type="button" class="btn btn-lg btn-blue-phax w-100 btn-subir">Subir</button>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-footer py-4">
            <div class="container-fluid px-3 px-lg-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="font-gotham fw-semibold">© 2025 Phantom X. Todos los derechos reservados.</div>
                    <div class="d-flex align-items-center">
                        <span class="text-success font-gotham fw-semibold">Vesion 6.7.2</span>
                    </div>
                </div>
            </div>
        </footer>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/external/phantomx/js/utils.js?v=1.0.0"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
    <script>
        const api_url = "{{ \App\Models\Veris::BASE_URL }}";
        const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
        const _application = "{{ \App\Models\Veris::APPLICATION }}";
        let _idOrganizacion = "{{ \App\Models\Veris::IDORGANIZACION }}";
        // "@if (\App\Models\Veris::CONTIENE_DESARROLLO)  {{ \App\Models\Veris::IDORGANIZACIONRESULTADOSLAB }} @else {{ \App\Models\Veris::IDORGANIZACION }} @endif";
        // const _idOrganizacionResultadosLaboratorio = "";
        let tipoFlujo = "";
        window.config = {
            subdomain: @json(config('app.subdomain')),
            canalOrigen: (@json(config('app.subdomain')) == "veris") ? "VER_CMV" : "VER_PMF"
        };

        document.addEventListener("DOMContentLoaded", async function () {
            await getData();

            $('body').on('click', '.btn-subir', async function(e){
                e.preventDefault(); // opcional, por si es un botón de formulario
                const $btn = $(this);

                // Si ya está deshabilitado, no hacer nada
                if ($btn.prop('disabled')) return;

                // Desactiva el botón
                $btn.prop('disabled', true);
                $btn.text('Subiendo...');

                await uploadSoportes();

            })
        })

        async function initProcessUpload(){
            for (const value of soportes_generales) {
                let pacienteId = value.paciente.idPaciente;
                const swiperWrapper = document.querySelector(`#swiperWrapper-${pacienteId}`); 
                const numberOfSlides = swiperWrapper.querySelectorAll('.swiper-slide').length;
                if(numberOfSlides > 0){

                }
            }
        }

        let soportes_generales;
        async function getData(){
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/pre_transacciones/{{ $idPreTransaccion }}/soportes_generales?codigoEmpresa={{ $codigoEmpresa }}`;
            args["method"] = "GET";
            args["token"] = "{{ $accessToken }}";
            args["showLoader"] = true;

            const data = await call(args);
            console.log(data)
            if(data.code == 200){
                soportes_generales = data.data; 
                await drawCollapseItem(data.data)
            }else{
                alert(data.message);
            }
        }

        async function drawSoportes(data, idPaciente){
            let elem = ``;
            let elem_seguros = ``;
            let elem_ordenes = ``;
            let box_elem_seguros = ``;
            let box_elem_ordenes = ``;
            
            $.each(data.agrupaciones, async function(key, value){
                //Dibujar seguros
                if(value.tiposSoportes.includes('AUTORIZACION_ASEGU')){
                    elem_seguros += `<div class="col-12 col-md-6 col-paciente-${idPaciente}">
                        <div class="accordion accordion-flush" id="accordion-AUTORIZACION_ASEGU-${value.idAgrupacion}-${value.codigoServicioNivel1}">
                            <div class="accordion-item">
                                <h5 class="text-pale-sky-40 mb-0">${value.beneficio.convenio.nombreConvenio}</h5>
                                <h2 class="accordion-header">
                                    <button class="accordion-button accordion-bg-white fs-4 fw-semibold text-success px-0 pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-AUTORIZACION_ASEGU-${value.idAgrupacion}-${value.codigoServicioNivel1}" aria-expanded="true" aria-controls="collapse-AUTORIZACION_ASEGU-${value.idAgrupacion}-${value.codigoServicioNivel1}">
                                        ${value.nombreServicioNivel1}
                                    </button>
                                </h2>
                                <div id="collapse-AUTORIZACION_ASEGU-${value.idAgrupacion}-${value.codigoServicioNivel1}" class="accordion-collapse collapse show" data-bs-parent="#accordion-AUTORIZACION_ASEGU-${value.idAgrupacion}-${value.codigoServicioNivel1}">
                                    <div class="accordion-body px-0 py-1">
                                        <div class="file-list" idPaciente-rel="${idPaciente}" nombreServicioNivel1-rel='${value.nombreServicioNivel1}' type-rel="AUTORIZACION_ASEGU" convenio-rel='${JSON.stringify(value.beneficio.convenio)}' idAgrupacion-rel='${value.idAgrupacion}' codigoServicioNivel1-rel='${value.codigoServicioNivel1}'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }

                if(value.tiposSoportes.includes('SERV_DEMANDA')){
                    elem_ordenes += `<div class="col-12 col-md-6 col-paciente-${idPaciente}">
                        <div class="accordion accordion-flush" id="accordion-SERV_DEMANDA-${value.idAgrupacion}-${value.codigoServicioNivel1}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button accordion-bg-white fs-4 fw-semibold text-success px-0 pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-SERV_DEMANDA-${value.idAgrupacion}-${value.codigoServicioNivel1}" aria-expanded="true" aria-controls="collapse-SERV_DEMANDA-${value.idAgrupacion}-${value.codigoServicioNivel1}">
                                        ${value.nombreServicioNivel1}
                                    </button>
                                </h2>
                                <div id="collapse-SERV_DEMANDA-${value.idAgrupacion}-${value.codigoServicioNivel1}" class="accordion-collapse collapse show" data-bs-parent="#accordion-SERV_DEMANDA-${value.idAgrupacion}-${value.codigoServicioNivel1}">
                                    <div class="accordion-body px-0 py-1">
                                        <div class="file-list" idPaciente-rel="${idPaciente}" nombreServicioNivel1-rel='${value.nombreServicioNivel1}' type-rel="SERV_DEMANDA" idAgrupacion-rel='${value.idAgrupacion}' codigoServicioNivel1-rel='${value.codigoServicioNivel1}'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
            })
            if(elem_seguros.length > 0){
                box_elem_seguros = `<div class="row">
                    <div class="text-start">
                        <h3 class="fw-semibold text-title-2 my-3">
                            Soporte por autorización 
                            <button type="button" class="btn btn-sm border border-blue-phax rounded-3 text-blue"><i class="fa-solid fa-rotate"></i></button>
                        </h3>
                    </div>
                    ${elem_seguros}
                </div>`
            }

            if(elem_ordenes.length > 0){
                box_elem_ordenes = `<div class="row">
                    <div class="text-start">
                        <h3 class="fw-semibold text-title-2">
                            Ordenes externas `;
                if(elem_seguros.length == 0){
                    box_elem_ordenes += `<button type="button" class="btn btn-sm border border-blue-phax rounded-3 text-blue"><i class="fa-solid fa-rotate"></i></button>`;
                }
                box_elem_ordenes += `</h3>
                    </div>
                    ${elem_ordenes}
                </div>`
            }

            return box_elem_seguros + box_elem_ordenes;
        }

        async function drawCollapseItem(data){
            let elem = ``;
            // $.each(data, async function(key, value){
            for (const value of data) {
                let soportes = await drawSoportes(value, value.paciente.idPaciente);
                elem += `<h2 class="accordion-header">
                    <div class="accordion-button px-3 px-lg-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelect${value.paciente.idPaciente}" aria-expanded="false" aria-controls="collapseSelect${value.paciente.idPaciente}">
                        <div class="d-flex flex-column justify-content-start align-items-start w-100">
                            <button class="btn btn-badge-paciente btn-sm mb-3 me-3" style="border-radius: 4px; font-weight: bold;">
                                Seleccionar Paciente
                            </button>
                            <div class="d-flex align-items-center text-montserrat">
                              <span class="fw-bold me-3 text-capitalize">${value.paciente.nombreCompleto.toLowerCase()}</span>
                              <span class="fw-bold me-2">Identificación</span>
                              <span class="me-2 fw-normal">${value.paciente.numeroIdentificacion}</span>
                              <button class="btn btn-link p-0 text-white">
                                <img src="{{ asset('assets/external/phantomx/img/icon/copy.svg')}}"/>
                              </button>
                            </div>
                        </div>
                    </div>
                </h2>
                <div id="collapseSelect${value.paciente.idPaciente}" class="accordion-collapse collapse" data-bs-parent="#accordionDocument">
                    <div class="accordion-body px-3 px-lg-5">
                        <h3 class="fw-semibold text-title-2">Soportes por cobertura</h3>
                        <div class="alert alert-blue-phax d-flex align-items-center px-3 py-2 font-gotham fw-semibold" role="alert">
                            <i class="fa-solid fa-circle-info text-blue me-2 fs-4"></i>
                            <div class="text-title-2">
                                <p class="fw-bold mb-0">Subir aquí todos los documentos que sirvan de respaldo: <b class="fw-normal">Órdenes externas, carta de autorización de crédito, etc.</b></p>
                            </div>
                        </div>
                        <div class="container mb-3" data-id="${value.paciente.idPaciente}">
                            <div class="row gap-4">
                                <!-- Document Preview Area -->
                                <div class="slider-document position-relative">
                                    <div class="swiper my-swiper py-2" id="swiper-${value.paciente.idPaciente}">
                                        <div class="swiper-wrapper" id="swiperWrapper-${value.paciente.idPaciente}"></div>
                                    </div>
                                    <div class="swiper-pagination position-absolute bottom-0 d-none" id="swiperPagination-${value.paciente.idPaciente}"></div>
                                    <!-- Navigation -->
                                    <div class="swiper-button-next mt-n5 top-lg-60 box-shadow-2 d-none" style="margin-right: 6.5%;" id="swiperNext-${value.paciente.idPaciente}"></div>
                                    <div class="swiper-button-prev mt-n5 top-lg-60 box-shadow-2 d-none" style="margin-left: 6.5%;" id="swiperPrev-${value.paciente.idPaciente}"></div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- File Type Information -->
                                    <div class="text-center font-gotham fw-semibold">
                                        <p class="text-blue-70 mb-1">Tipos de archivos permitidos: <span class="text-dark">(.pdf), (.jpg), (.png)</span></p>
                                        <p class="text-blue-70">Tamaño máximo: <span class="text-dark">20 MB</span></p>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <!-- Upload Area -->
                                    <div class="upload-area" idPaciente-rel="${value.paciente.idPaciente}" data-rel='${JSON.stringify(value)}' id="uploadArea-${value.paciente.idPaciente}">
                                        <div class="upload-icon me-2">
                                            <img src="{{ asset('assets/external/phantomx/img/icon/upload-image.svg') }}" alt="">
                                        </div>
                                        <div class="upload-text lh-sm">
                                            <p class="mb-0">Sube un archivo o </p>
                                            <p class="mb-0">tómale una foto al archivo.</p>
                                        </div>
                                        <input type="file" accept=".pdf,.jpg,.jpeg,.png" id="file-${value.paciente.idPaciente}" multiple class="file-input" data-id="${value.paciente.idPaciente}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid border-top">
                            <div class="row g-3">
                                <!-- Soporte por autorización -->
                                <div class="col-sm-12 content-soportes-box" id="content-soportes-${value.paciente.idPaciente}">
                                    ${soportes}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>`;
            }
            $('#accordionDocument').html(elem);
        }

        async function addInputCard(idPaciente, fileDetail, uniqueId) {
            console.log(fileDetail);
    
            $(`#content-soportes-${idPaciente} .file-list`).each(function(index, element) {
                const $el = $(element);
                const convenio = $el.attr('convenio-rel');
                const idAgrupacion = $el.attr('idAgrupacion-rel');
                const codigoServicioNivel1 = $el.attr('codigoServicioNivel1-rel');
                const type = $el.attr('type-rel');

                const swiperWrapper = document.querySelector(`#swiperWrapper-${idPaciente}`); 
                const numberOfSlides = swiperWrapper.querySelectorAll('.swiper-slide').length;

                let elem = `<div class="file-item d-flex align-items-center fw-bold mb-2 ${uniqueId}">
                    <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="file-${type}-${idPaciente}-${idAgrupacion}-${codigoServicioNivel1}-${numberOfSlides}" convenio-rel='${convenio ?? ''}' data-index="${(numberOfSlides-1)}">
                    <label class="form-check-label" for="file-${type}-${idPaciente}-${idAgrupacion}-${codigoServicioNivel1}-${numberOfSlides}">
                        <span class="text-blue-70">Archivo <b class="fileNumber">${numberOfSlides}</b>:</span> ${fileDetail.name}
                    </label>
                </div>`;                
                
                $el.append(elem); // <- usamos $el directamente
            });
        }

        async function uploadSoportes(){
            let hasFiles = false;
            $(`.content-soportes-box .file-list`).each(async function(index, element) {
                const $fileList = $(element); // convierte el DOM element en objeto jQuery

                const notEmpty = $fileList.html().trim() !== '';
                const hasCheckboxChecked = $fileList.find('input[type="checkbox"]').is(':checked');
                if (notEmpty && hasCheckboxChecked) {
                    hasFiles = true;
                    const $fileList = $(element);
                    const idPaciente = $fileList.attr('idPaciente-rel');
                    const idAgrupacion = $fileList.attr('idAgrupacion-rel');
                    const nombreServicioNivel1 = $fileList.attr('nombreServicioNivel1-rel');
                    const type = $fileList.attr('type-rel');
                    const fileInput = $(`#uploadArea-${idPaciente}`).find('input[type="file"]')[0];
                    const allFiles = fileInput.files;
                    const checkedIndexes = $fileList.find('input[type="checkbox"]:checked').map(function () {
                        return parseInt($(this).data('index'));
                    }).get();

                    const selectedFiles = checkedIndexes.map(i => allFiles[i]);
                    console.log(`Archivos seleccionados para paciente ${idPaciente}:`, selectedFiles);
                    let detallesAgrupacion = [];
                    let count = 1;
                    for(const file of selectedFiles){
                        try{
                            let upload = await uploadFile(file, count);
                            count++;
                            if(upload.code == 200){
                                detallesAgrupacion.push({
                                    "codigoSoporteOrden": upload.data.codigoSoporteOrden,
                                    // "_id": generateUUIDv4()
                                })
                            }
                        }catch(error) {
                            $('.btn-subir').prop('disabled', false).html("Subir")
                            alert(`Error al subir el archivo ${file.name}:`, error);
                        }
                    }
                    await asociarSoportes(detallesAgrupacion, idPaciente, idAgrupacion, type)
                    $('.btn-subir').prop('disabled', false).html("Subir")
                }

            });
            if(!hasFiles){
                $('.btn-subir').prop('disabled', false).html("Subir")
            }
        }

        async function asociarSoportes(detallesAgrupacion, idPaciente, idAgrupacion, tipoSoporte){
            console.log(detallesAgrupacion, idPaciente, idAgrupacion, tipoSoporte)
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/soportes_ordenes/asociar_det_agrup_pre_trans`;
            args["method"] = "PUT";
            args["token"] = "{{ $accessToken }}";
            args["bodyType"] = "json";
            args["data"] = JSON.stringify({
                "codigoEmpresa": {{ $codigoEmpresa }},
                "idPreTransaccion": {{ $idPreTransaccion }},
                "idAgrupacion": parseInt(idAgrupacion),
                "tipoSoporte": tipoSoporte,
                "detallesAgrupacion": detallesAgrupacion
            })
            args["showLoader"] = true;
            const data = await call(args);
            console.log(data)
            if(data.code == 200){
                alert("Archivos guardados")
            }else{
                console.log(error)
            }
        }

        async function uploadFile(file, orden){
            let finalFile;
            // Si ya es PDF, lo enviamos tal cual
            if (file.type === "application/pdf") {
                finalFile = file;
            } else if (file.type === "image/jpeg" || file.type === "image/png") {
                // Convertir imagen a base64
                const imageDataURL = await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });

                // Crear PDF con jsPDF
                const { jsPDF } = window.jspdf;
                {{-- const pdf = new jsPDF();
                pdf.addImage(imageDataURL, 'JPEG', 10, 10, 180, 160); --}}

                const pdf = new jsPDF({
                    orientation: 'portrait', // o 'landscape'
                    unit: 'mm',               // milímetros
                    format: 'a4'              // tamaño de página
                });

                pdf.addImage(imageDataURL, 'JPEG', 10, 10, 180, 160);

                // Convertir a blob
                finalFile = pdf.output('blob');

                // Le damos un nombre al archivo
                finalFile = new File([finalFile], "convertido.pdf", { type: "application/pdf" });
            } else {
                alert("Formato de archivo no permitido. Solo se aceptan PDF o imágenes JPG/PNG.");
                return;
            }

            const formData = new FormData();
            formData.append("documento", finalFile);

            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/soportes_ordenes?codigoEmpresa={{ $codigoEmpresa }}&orden=${orden}`;
            args["method"] = "POST";
            args["token"] = "{{ $accessToken }}";
            args["showLoader"] = true;
            args["data"] = formData;
            args["bodyType"] = "formdata"; 
            const data = await call(args);
            console.log(data)
            if(data.code == 200){
                return data;
            }else{
                console.log(error)
            }
        }

        function fileToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
                reader.readAsDataURL(file);
            });
        }

        function generateUUIDv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                const r = (Math.random() * 16) | 0; // Genera un número aleatorio entre 0 y 15
                const v = c === 'x' ? r : (r & 0x3) | 0x8; // Asegura que el formato cumple con UUID v4
                return v.toString(16); // Convierte el número a hexadecimal
            });
        }

    </script>
    <style>
        span.swiper-pagination-bullet {
            display: none;
        }
    </style>
</body>

</html>