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
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/external/phantomx/js/utils.js?v=1.0.1"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
    <script type="text/javascript" src="{{ asset('assets/external/resultados-laboratorio/js/pdf.min.js') }}"></script>
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

                console.log("Iniciar carga");
                let hasFiles = await uploadSoportes();
                console.log("Carga terminada");
                if(hasFiles){
                    alert("Documentos subidos exitosamente");
                    $(`.swiper-wrapper`).empty();
                    $(`.file-list`).empty();
                    await getData("reload")
                    /*setTimeout(async function(){
                        location.reload();
                    }, 1000);*/
                }
            })

            $('body').on('click', '.btn-reload', async function(){
                await getData("reload")
            })
            
            $('body').on('click', '.view-file', async function(){
                let detalle = JSON.parse($(this).attr('data-rel'));
                if(isIOS()){
                    await mostrarPdfSoporteOnlineIos(detalle);
                }else{
                    await mostrarPdfSoporteOnline(detalle);
                }
            })

            $('body').on('click', '.btn-eliminar-soporte', async function(){
                let servicio = $(this).parent().parent().parent().attr('data-rel');
                let detalle = JSON.parse($(this).attr('data-rel'));
                let idPaciente = JSON.parse($(this).attr('idPaciente-rel'));

                await deleteSoporte(detalle);
                
                $(`.box-${servicio} .box-soporte-${detalle.codigoSoporteOrden}`).remove();
                console.log(`.col-paciente-${idPaciente} .box-${servicio} .file-list`);
                let globalObj = JSON.parse($(`.col-paciente-${idPaciente} .box-${servicio} .file-list`).attr('soportescargados-rel'));
                console.log(detalle)
                console.log(globalObj)
                let nuevoArray;
                if(detalle.length > 1){
                    nuevoArray = data.filter(item => item.codigoSoporteOrden !== detalle.codigoSoporteOrden);
                }else{
                    nuevoArray = {};
                }
                $(`.col-paciente-${idPaciente} .box-${servicio} .file-list`).attr('soportescargados-rel', JSON.stringify(nuevoArray))
            })

        })

        function isIOS() {
            return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        }

        async function deleteSoporte(detalle){
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/soportes_ordenes/${detalle.codigoSoporteOrden}?idAgrupacion=${detalle.codigoAgrupacion}&tipoSoporte=${detalle.tipoSoporte}`;
            args["method"] = "DELETE";
            args["token"] = "{{ $accessToken }}";
            args["isPhantomX"] = true;
            args["bodyType"] = "json";
            args["showLoader"] = true;

            const data = await call(args);
            console.log(data);
        }

        async function mostrarPdfSoporteOnline(detalle) {
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/soportes_ordenes/${ detalle.codigoSoporteOrden }`;
            args["method"] = "GET";
            args["token"] = "{{ $accessToken }}";
            args["isPhantomX"] = true;
            args["responseType"] = "blob"; // <--- clave para no intentar convertir a JSON
            args["showLoader"] = true;

            const data = await call(args); // ← el PDF viene aquí como Blob

            // Forzamos el tipo PDF si no está definido
            const pdfBlob = new Blob([data], { type: 'application/pdf' });
            const fileURL = URL.createObjectURL(pdfBlob);
            const fileName = "Soporte.pdf"; // puedes hacerlo dinámico si lo necesitas

            const modalTitle = document.getElementById("previewModalTitle");
            const modalBody = document.getElementById("previewModalBody");

            modalTitle.innerHTML = `
                <h6 class="text-blue-70 fs-sm line-clamp-1">
                    <b class="text-title-3">${fileName}</b>
                </h6>`;

            modalBody.innerHTML = "";

            const embed = document.createElement("embed");
            embed.src = fileURL;
            embed.type = "application/pdf";
            embed.width = "100%";
            embed.height = "500px";

            modalBody.appendChild(embed);

            const previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
            previewModal.show();

            // Limpieza cuando se cierre el modal
            const modalElement = document.getElementById("previewModal");
            modalElement.addEventListener("hidden.bs.modal", () => {
                URL.revokeObjectURL(fileURL);
            }, { once: true });
        }

        async function mostrarPdfSoporteOnlineIos(detalle) {
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/soportes_ordenes/${ detalle.codigoSoporteOrden }`;
            args["method"] = "GET";
            args["token"] = "{{ $accessToken }}";
            args["isPhantomX"] = true;
            args["responseType"] = "blob";
            args["showLoader"] = true;

            const modalTitle = document.getElementById("previewModalTitle");
            const modalBody = document.getElementById("previewModalBody");
            const modalElement = document.getElementById("previewModal");
            const previewModal = new bootstrap.Modal(modalElement);

            try {
                const data = await call(args);
                const pdfBlob = new Blob([data], { type: 'application/pdf' });
                const pdfUrl = URL.createObjectURL(pdfBlob);

                modalTitle.innerHTML = `
                    <h6 class="text-blue-70 fs-sm line-clamp-1">
                        <b class="text-title-3">Soporte.pdf</b>
                    </h6>`;
                modalBody.innerHTML = `<div id="canvases"></div>`;

                await drawPdf(pdfUrl);
                previewModal.show();

                modalElement.addEventListener("hidden.bs.modal", () => {
                    URL.revokeObjectURL(pdfUrl);
                }, { once: true });

            } catch (error) {
                console.error('Error al obtener o renderizar el PDF:', error);

                // Intentamos hacer una segunda llamada simple para recuperar el blob
                try {
                    const response = await fetch(api_url + `/facturacion/v1/soportes_ordenes/${ detalle.codigoSoporteOrden }`, {
                        method: "GET",
                        headers: {
                            Authorization: "Bearer {{ $accessToken }}",
                            Application: _application,
                            IdOrganizacion: _idOrganizacion
                        }
                    });
                    if (!response.ok) throw new Error("No se pudo descargar el PDF");

                    const fallbackBlob = await response.blob();
                    const fallbackUrl = URL.createObjectURL(fallbackBlob);

                    modalTitle.innerHTML = `<h6 class="text-blue-70 fs-sm">Soporte.pdf</h6>`;
                    modalBody.innerHTML = `
                        <div class="alert alert-warning text-center">
                            No pudimos mostrar el PDF en esta vista.<br>
                            <a href="${fallbackUrl}" download="Soporte.pdf" class="btn btn-primary mt-2">
                                Abrir PDF en una nueva pestaña
                            </a>
                        </div>`;
                    previewModal.show();

                    modalElement.addEventListener("hidden.bs.modal", () => {
                        URL.revokeObjectURL(fallbackUrl);
                    }, { once: true });

                } catch (fetchError) {
                    console.error("Error al obtener el PDF para fallback:", fetchError);
                    modalTitle.innerHTML = `<h6 class="text-blue-70 fs-sm">Error</h6>`;
                    modalBody.innerHTML = `
                        <div class="alert alert-danger text-center">
                            No se pudo cargar el archivo PDF.
                        </div>`;
                    previewModal.show();
                }
            }
        }



        async function drawPdf(pdfUrl){
            pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset('assets/external/resultados-laboratorio/js/pdf.worker.js') }}';

            let pdfDoc = null;
            let scale = 1.5;

            function renderPage(num, canvas) {
                let ctx = canvas.getContext('2d');
                pdfDoc.getPage(num).then(function(page) {
                    let viewport = page.getViewport({ scale });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    let renderContext = {
                        canvasContext: ctx,
                        viewport
                    };

                    page.render(renderContext);
                });
            }

            pdfDoc = await pdfjsLib.getDocument(pdfUrl).promise;
            const pages = pdfDoc.numPages;

            let canvasHtml = '';
            for (let i = 0; i < pages; i++) {
                canvasHtml += `<canvas class="mb-3 w-100 border" id="canvas_${i}"></canvas>`;
            }

            document.getElementById('previewModalBody').innerHTML = canvasHtml;

            for (let i = 0; i < pages; i++) {
                let canvas = document.getElementById(`canvas_${i}`);
                renderPage(i + 1, canvas);
            }
        }


        let soportes_generales;
        async function getData(type = "inicio"){
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/pre_transacciones/{{ $idPreTransaccion }}/soportes_generales?codigoEmpresa={{ $codigoEmpresa }}`;
            args["method"] = "GET";
            args["token"] = "{{ $accessToken }}";
            args["isPhantomX"] = true;
            args["showLoader"] = true;

            const data = await call(args);
            console.log(data)
            if(data.code == 200){
                soportes_generales = data.data; 
                if(type == "inicio"){
                    await drawCollapseItem(data.data)
                }else{
                    await reDrawCollapseItem(data.data)
                }
            }else{
                alert(data.message);
            }
        }

        async function reDrawCollapseItem(data){
            console.log(data);
            for (const value of data) {
                let soportes = await drawSoportes(value, value.paciente.idPaciente);
                $(`#content-soportes-${value.paciente.idPaciente}`).html(`${soportes}`);
                await redrawInputCards(value.paciente.idPaciente)
            }
        }

        function redrawInputCards(idPaciente) {
            const swiperWrapper = document.querySelector(`#swiperWrapper-${idPaciente}`);
            if (!swiperWrapper) return;

            const slides = swiperWrapper.querySelectorAll(".swiper-slide");

            // Limpiar los inputs existentes
            $(`#content-soportes-${idPaciente} .file-list`).each(function () {
                $(this).empty();
            });

            slides.forEach((slide, slideIndex) => {
                // Obtener nombre real del archivo
                let fileName = `Archivo ${slideIndex + 1}`;
                const label = slide.querySelector("label");

                if (label) {
                    const span = label.querySelector("span");
                    if (span && span.nextSibling && span.nextSibling.nodeType === Node.TEXT_NODE) {
                        fileName = span.nextSibling.textContent.trim();
                    }
                }

                const uniqueId = slide.querySelector(".file-item")?.classList[1] || `file-${idPaciente}-${slideIndex}`;

                // Redibujar inputs en cada lista correspondiente
                $(`#content-soportes-${idPaciente} .file-list`).each(function (index, element) {
                    const $el = $(element);
                    const convenio = $el.attr('convenio-rel');
                    const idAgrupacion = $el.attr('idAgrupacion-rel');
                    const codigoServicioNivel1 = $el.attr('codigoServicioNivel1-rel');
                    const type = $el.attr('type-rel');

                    const inputId = `file-${type}-${idPaciente}-${idAgrupacion}-${codigoServicioNivel1}-${slideIndex + 1}-${index}`;

                    const elem = `<div class="file-item d-flex align-items-center fw-bold mb-2 ${uniqueId}">
                        <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="${inputId}" convenio-rel="${convenio ?? ''}" data-index="${slideIndex}" data-file-name="${fileName}">
                        <label class="form-check-label" for="${inputId}">
                            <span class="text-blue-70">Archivo <b class="fileNumber">${slideIndex + 1}</b>:</span> ${fileName}
                        </label>
                    </div>`;

                    $el.append(elem);
                });
            });
        }

        async function drawSoportes(data, idPaciente){
            let elem = ``;
            let elem_seguros = ``;
            let elem_ordenes = ``;
            let box_elem_seguros = ``;
            let box_elem_ordenes = ``;
            
            let soportesJson_AUTORIZACION_ASEGU = {};
            let soportesJson_SERV_DEMANDA = {};
            $.each(data.agrupaciones, async function(key, value){
                let soportesExistentes_AUTORIZACION_ASEGU = `<!--p class="w-100 mb-0">Documentos cargados</p--><div class="w-100 d-flex p-2 px-0 justify-content-start align-items-center g-2">`;
                let soportesExistentes_SERV_DEMANDA = `<!--p class="w-100 mb-0">Documentos cargados</p--><div class="w-100 d-flex p-2 px-0 justify-content-start align-items-center g-2">`;
                if(value.soportes.length > 0){
                    $.each(value.soportes, function(k,v){
                        if(v.tipoSoporte == "AUTORIZACION_ASEGU"){
                            soportesJson_AUTORIZACION_ASEGU = v;
                            soportesExistentes_AUTORIZACION_ASEGU += `<div class="d-flex justify-content-between align-items-center badge bg-silver-light mx-2 box-soporte-${v.codigoSoporteOrden}">
                                <div class="view-file mx-1 text-success" data-rel='${JSON.stringify(v)}'>
                                    <i class="fa-solid fa-file me-1"></i>
                                    <small>${v.codigoSoporteOrden}${v.extensionArchivo}</small>
                                </div>
                                <small type="button" class="ms-2 btn-eliminar-soporte" idPaciente-rel='${idPaciente}' data-rel='${JSON.stringify(v)}'><i class="fa-regular fa-trash-can text-danger fw-bold"></i></small>
                            </div>`;
                        }else{
                            soportesJson_SERV_DEMANDA = v;
                            soportesExistentes_SERV_DEMANDA += `<div class="d-flex justify-content-between align-items-center badge bg-silver-light mx-2 box-soporte-${v.codigoSoporteOrden}">
                                <div class="view-file mx-1 text-success" data-rel='${JSON.stringify(v)}'>
                                    <i class="fa-solid fa-file me-1"></i>
                                    <small>${v.codigoSoporteOrden}${v.extensionArchivo}</small>
                                </div>
                                <small type="button" class="ms-2 btn-eliminar-soporte" idPaciente-rel='${idPaciente}' data-rel='${JSON.stringify(v)}'><i class="fa-regular fa-trash-can text-danger fw-bold"></i></small>
                            </div>`;
                        }
                    })
                }
                soportesExistentes_AUTORIZACION_ASEGU += `</div>`;
                soportesExistentes_SERV_DEMANDA += `</div>`;

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
                                    <div class="accordion-body px-0 py-1 box-AUTORIZACION_ASEGU" data-rel='AUTORIZACION_ASEGU'>
                                        ${soportesExistentes_AUTORIZACION_ASEGU}
                                        <div class="file-list" soportesCargados-rel='${JSON.stringify(soportesJson_AUTORIZACION_ASEGU)}' idPaciente-rel="${idPaciente}" nombreServicioNivel1-rel='${value.nombreServicioNivel1}' type-rel="AUTORIZACION_ASEGU" convenio-rel='${JSON.stringify(value.beneficio.convenio)}' idAgrupacion-rel='${value.idAgrupacion}' codigoServicioNivel1-rel='${value.codigoServicioNivel1}'>
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
                                    <div class="accordion-body px-0 py-1 box-SERV_DEMANDA" data-rel='SERV_DEMANDA'>
                                        ${soportesExistentes_SERV_DEMANDA}
                                        <div class="file-list" soportesCargados-rel='${JSON.stringify(soportesJson_SERV_DEMANDA)}' idPaciente-rel="${idPaciente}" nombreServicioNivel1-rel='${value.nombreServicioNivel1}' type-rel="SERV_DEMANDA" idAgrupacion-rel='${value.idAgrupacion}' codigoServicioNivel1-rel='${value.codigoServicioNivel1}'>
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
                    <div class="text-start alert-blue-phax mb-3">
                        <h3 class="fw-semibold text-title-2 my-3">
                            Soporte por autorización 
                            <button type="button" class="btn btn-sm border border-blue-phax rounded-3 text-blue btn-reload"><i class="fa-solid fa-rotate"></i></button>
                        </h3>
                    </div>
                    ${elem_seguros}
                </div>`
            }

            if(elem_ordenes.length > 0){
                box_elem_ordenes = `<div class="row">
                    <div class="text-start alert-blue-phax mb-3">
                        <h3 class="fw-semibold text-title-2 my-3">
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
            let isShowed = ``;
            if(soportes_generales.length == 1){
                isShowed = `show`;
            }
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
                <div id="collapseSelect${value.paciente.idPaciente}" class="accordion-collapse collapse ${isShowed}" data-bs-parent="#accordionDocument">
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

            const swiperWrapper = document.querySelector(`#swiperWrapper-${idPaciente}`); 
            const numberOfSlides = swiperWrapper.querySelectorAll('.swiper-slide').length;

            $(`#content-soportes-${idPaciente} .file-list`).each(function(index, element) {
                const $el = $(element);
                const convenio = $el.attr('convenio-rel');
                const idAgrupacion = $el.attr('idAgrupacion-rel');
                const codigoServicioNivel1 = $el.attr('codigoServicioNivel1-rel');
                const type = $el.attr('type-rel');

                const inputId = `file-${type}-${idPaciente}-${idAgrupacion}-${codigoServicioNivel1}-${numberOfSlides}-${index}`;

                let elem = `<div class="file-item d-flex align-items-center fw-bold mb-2 ${uniqueId}">
                    <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="${inputId}" convenio-rel='${convenio ?? ''}' data-index="${(numberOfSlides - 1)}" data-file-name="${fileDetail.name}" >
                    <label class="form-check-label" for="${inputId}">
                        <span class="text-blue-70">Archivo <b class="fileNumber">${numberOfSlides}</b>:</span> ${fileDetail.name}
                    </label>
                </div>`;                

                $el.append(elem);
            });
        }


        async function uploadSoportes() {
            let hasFiles = false;
            const fileLists = $('.content-soportes-box .file-list').toArray();

            for (const element of fileLists) {
                const $fileList = $(element);
                let soportesPrevios = JSON.parse($fileList.attr('soportescargados-rel'));

                const notEmpty = $fileList.html().trim() !== '';
                const hasCheckboxChecked = $fileList.find('input[type="checkbox"]').is(':checked');

                const idPaciente = $fileList.attr('idPaciente-rel');
                const idAgrupacion = $fileList.attr('idAgrupacion-rel');
                const type = $fileList.attr('type-rel');

                console.log("Paciente:", idPaciente);
                console.log("Tiene contenido HTML:", notEmpty);
                console.log("Checkbox checked:", hasCheckboxChecked);
                console.log("Checkbox encontrados:", $fileList.find('input[type="checkbox"]').length);
                console.log("Contenido actual del file-list:", $fileList.html());

                if (notEmpty && hasCheckboxChecked) {
                    console.log("tiene archivos")
                    hasFiles = true;
                    const fileInput = $(`#uploadArea-${idPaciente}`).find('input[type="file"]')[0];
                    const allFiles = fileInput.files;
                    {{-- const checkedIndexes = $fileList.find('input[type="checkbox"]:checked').map(function () {
                        return parseInt($(this).data('index'));
                    }).get();
                    const selectedFiles = checkedIndexes.map(i => allFiles[i]); --}}

                    const checkedFileNames = $fileList.find('input[type="checkbox"]:checked').map(function () {
                        return $(this).data('file-name');
                    }).get();
                    const selectedFiles = Array.from(allFiles).filter(file => checkedFileNames.includes(file.name));

                    console.log("Files reales en input:", allFiles);
                    console.log("Nombres seleccionados por checkbox:", checkedFileNames);
                    console.log("Archivos encontrados en filter:", selectedFiles);

                    let detallesAgrupacion = [];
                    let count = 1;
                    for (const file of selectedFiles) {
                        try {
                            let upload = await uploadFile(file, count);
                            count++;
                            if (upload.code == 200) {
                                detallesAgrupacion.push({
                                    "codigoSoporteOrden": upload.data.codigoSoporteOrden,
                                });
                                if (Object.keys(soportesPrevios).length !== 0) {
                                    detallesAgrupacion.push({
                                        "codigoSoporteOrden": soportesPrevios.codigoSoporteOrden,
                                    });
                                }
                            }
                        } catch (error) {
                            $('.btn-subir').prop('disabled', false).html("Subir");
                            // console.log(error);
                        }
                    }

                    await asociarSoportes(detallesAgrupacion, idPaciente, idAgrupacion, type);
                    $('.btn-subir').prop('disabled', false).html("Subir");
                } else {
                    console.log("no tiene archivos")
                    let detallesAgrupacion = [];
                    if (Object.keys(soportesPrevios).length !== 0) {
                        // console.log("tiene soportes")
                        // console.log(soportesPrevios)
                        hasFiles = true;
                        $.each(soportesPrevios, function (k1, v1) {
                            detallesAgrupacion.push({
                                "codigoSoporteOrden": soportesPrevios.codigoSoporteOrden,
                            });
                        });
                        await asociarSoportes(detallesAgrupacion, idPaciente, idAgrupacion, type);
                        $('.btn-subir').prop('disabled', false).html("Subir");
                    }
                }
            }

            if (!hasFiles) {
                $('.btn-subir').prop('disabled', false).html("Subir");
            }
            return hasFiles;
        }

        async function isArrayWithOnlyEmptyObject(arr) {
            return Array.isArray(arr) &&
                   arr.length === 1 &&
                   typeof arr[0] === 'object' &&
                   arr[0] !== null &&
                   Object.keys(arr[0]).length === 0;
        }

        async function asociarSoportes(detallesAgrupacion, idPaciente, idAgrupacion, tipoSoporte){
            console.log(detallesAgrupacion, idPaciente, idAgrupacion, tipoSoporte)
            if(detallesAgrupacion.length == 0){
                console.log("No existe data para agrupar")
            }
            let args = [];
            args["endpoint"] = api_url + `/facturacion/v1/soportes_ordenes/asociar_det_agrup_pre_trans`;
            args["method"] = "PUT";
            args["token"] = "{{ $accessToken }}";
            args["isPhantomX"] = true;
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
                console.log("datos agrupados")
                // alert("Archivos guardados")
                // $(`.swiper-wrapper`).empty();
                // $(`.file-list`).empty();
            }else{
                console.log(error)
                alert(data.message);
            }
        }

        async function uploadFile(file, orden) {
            let finalFile;

            if (file.type === "application/pdf") {
                finalFile = file;
            } else if (file.type === "image/jpeg" || file.type === "image/png") {
                const imageDataURL = await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const props = pdf.getImageProperties(imageDataURL);
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const margin = 10;

                let imgWidth = pageWidth - margin * 2;
                let imgHeight = (props.height * imgWidth) / props.width;

                if (imgHeight > pageHeight - margin * 2) {
                    imgHeight = pageHeight - margin * 2;
                    imgWidth = (props.width * imgHeight) / props.height;
                }

                const x = (pageWidth - imgWidth) / 2;
                const y = (pageHeight - imgHeight) / 2;

                pdf.addImage(imageDataURL, props.fileType, x, y, imgWidth, imgHeight);

                // Convertir a blob y renombrar
                finalFile = pdf.output('blob');
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
            args["isPhantomX"] = true;
            args["showLoader"] = true;
            args["data"] = formData;
            args["bodyType"] = "formdata";

            try {
                const data = await call(args);
                console.log(data);
                if (data.code == 200) {
                    return data;
                } else {
                    console.log("Error en respuesta:", data);
                }
            } catch (error) {
                console.error("Error en uploadFile:", error);
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
        .view-file{
            font-size: 12px;
            line-height: 12px;
            cursor: pointer;
        }
        .bg-silver-light {
            background: #f2f2f2;
        }
    </style>
</body>

</html>