@extends('template.external')
@section('title')
Veris - Detalle Promoción
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="{{ asset('assets/external/resultados-laboratorio/css/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('assets/external/resultados-laboratorio/js/flatpickr.js') }}"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.min.js"></script>

@include('external.components.navbar')

{{-- <div class="d-flex justify-content-between align-items-center bg-white">
    <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Exámenes de Laboratorio') }}</h5>
</div> --}}
<section class="p-3 mb-3">
    <div class="row g-0 mb-3">
        <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
            <div class="card rounded-0 border-0 shadow-sm">
                <div class="card-body p-3 pb-2">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-1">
                            {{-- <i class="fa-solid fa-user me-3 text-primary-veris"></i> --}}
                            <span class="card-title card-g text-primary-veris fw-bold line-height-24 mb-0">Paciente:</span>
                            <p class="flex-grow-1 card-title card-g text-primary-veris fw-bold line-height-24 ms-1 mb-0">Michael Rosero Peralta</p>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center mb-1">
                            <i class="fa-solid fa-address-card me-3"></i>
                            <span class="fw-medium fs--1 line-height-16 mb-0">Identificación:</span>
                            <p class="flex-grow-1 fw-medium fs--1 line-height-16 mb-0 ms-1">0923796304</p>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center mb-1">
                            <i class="fa-solid fa-rectangle-list me-3"></i>
                            <span class="fw-medium fs--1 line-height-16 mb-0">Cod. único de atención:</span>
                            <p class="flex-grow-1 fw-medium fs--1 line-height-16 mb-0 ms-1">{{ $idPaciente }}</p>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12 bg-white p-2 d-flex justify-content-between align-items-center">
            <h5 class="ps-3 my-auto py-2 fs-20 fs-md-24 flex-grow-1">Exámenes de Laboratorio</h5>
            <button class="btn btn-sm btn-outline-primary-veris ms-2 px-2 py-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroResultados" aria-controls="filtroResultados" >
                {{-- <img src="{{asset('assets/img/svg/filtro.svg')}}" class="me-1" alt="filtro"> --}}
                <i class="fa-solid fa-calendar-day ms-1 me-1 fs--1" alt="filtro"></i><small>Filtro</small>
                {{-- <p class="fs--1 line-height-16 fw-normal mb-0" id="filtroFechas">Rango de fechas</p> --}}
            </button>
        </div>
        <!--off canva filtro-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="filtroResultados" aria-labelledby="filtroResultadosLabel">
            <div class="offcanvas-header flex-column align-items-start p-0">
                <div class="w-100 px-4 py-2 d-lg-none d-block" style="background: #F3F4F5;">
                    <button type="button" class="btn p-0 d-flex align-items-center" data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{asset('assets/img/svg/arrow-left-filtro-body.svg')}}" class="me-1" alt="atras"><b class="fw-medium fs-- text-veris">Atrás</b></button>
                </div>
                <h5 class="offcanvas-title fs--20 line-height-24 w-100 px-4 py-3" id="filtroResultadosLabel">Filtro de búsqueda</h5>
            </div>
            <div class="offcanvas-body px-3 pt--2" style="background: rgba(249, 250, 251, 1);">
                <div>
                    <h6 class="fs--16 line-height-20 fw-light" style="color: #3D4E66 !important;">Elige el rango de fechas</h6>
                    <div class="col-md-12 mb-3 box-fechas-filtro">
                        <input type="text" class="form-control fs--1 p-3" placeholder="Desde la fecha" name="fechaDesde" id="fechaDesde" required />
                    </div>
                    <div class="col-md-12 mb-5 box-fechas-filtro">
                        <input type="text" class="form-control fs--1 p-3" placeholder="Hasta la fecha" name="fechaHasta" id="fechaHasta" required />
                    </div>
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary-veris w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3" type="button" id="aplicarFiltros" data-context="contextoAplicarFiltros">Aplicar filtros</button>
                        <button class="btn text-primary w-100 fs--18 line-height-24 mb-2 mx-0 px-4 py-3" type="button" id="btnLimpiarFiltros" data-context="contextoLimpiarFiltros"><img src="{{asset('assets/img/svg/delete-blue.svg')}}" class="me-2" alt="limpiar filtro">Limpiar filtro</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="swiper swiper-ordenes position-relative pb-2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div data-rel="" class="card p-4 orden-seleccionada" type="button">
                            <p class="flex-grow-1 fs--1 card-g text-primary-veris fw-bold line-height-16 mb-3 d-flex justify-content-between align-items-center">N.° de Orden: 89008388 <i class="fa-regular fa-bell text-warning border-warning fw-bold fs--1"></i></p>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>
                                <span class="fw-bold">Fecha de Toma: 17-08-2024 | 07:25:00</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                <span class="fw-bold">Fecha de Compromiso: 24/08/2024</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                <span class="fw-bold">Laboratorio: Central</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div data-rel="" class="card p-4" type="button">
                            <p class="flex-grow-1 fs--1 card-g text-primary-veris fw-bold line-height-16 mb-3">N.° de Orden: 89008388</p>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>
                                <span class="fw-bold">Fecha de Toma: 17-08-2024 | 07:25:00</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                <span class="fw-bold">Fecha de Compromiso: 24/08/2024</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                <span class="fw-bold">Laboratorio: Central</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div data-rel="" class="card p-4" type="button">
                            <p class="flex-grow-1 fs--1 card-g text-primary-veris fw-bold line-height-16 mb-3">N.° de Orden: 89008388</p>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>
                                <span class="fw-bold">Fecha de Toma: 17-08-2024 | 07:25:00</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                <span class="fw-bold">Fecha de Compromiso: 24/08/2024</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                <span class="fw-bold">Laboratorio: Central</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div data-rel="" class="card p-4" type="button">
                            <p class="flex-grow-1 fs--1 card-g text-primary-veris fw-bold line-height-16 mb-3">N.° de Orden: 89008388</p>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar me-2"></i>
                                <span class="fw-bold">Fecha de Toma: 17-08-2024 | 07:25:00</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-regular fa-calendar-check me-2"></i>
                                <span class="fw-bold">Fecha de Compromiso: 24/08/2024</span>
                            </div>
                            <div class="text-veris fs--2 line-height-14 mb-1">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                <span class="fw-bold">Laboratorio: Central</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <button type="button" id="prevProperties" class="d-flex  mt-n4 btn btn-prev rounded-circle"></button>
                <button type="button" id="nextProperties" class="d-flex  mt-n4 btn btn-next rounded-circle"></button> --}}
                <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
                <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
            </div>
        </div>
    </div>
    <div class="row py-1 bg-labe-grayish-blue mt-2 mb-3 d-flex justify-content-between align-items-center">
        <div class="col-12 col-md-4 text-start mt-1 mb-1">
            <span class="fs--1 card-g text-veris fw-bold line-height-16">Resultados de Laboratorio: 4/10</span>
        </div>
        <div class="col-7 col-md-4 text-start text-md-center mt-1 mb-1 flex-grow-1">
            <div class="progress" style="height:25px;">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
            </div>
        </div>
        <div class="col-5 col-md-4 text-start text-md-end mt-1 mb-1 text-end">
            <button class="btn btn-sm btn-primary-veris p-2 m-0 text-white" data-bs-toggle="modal" data-bs-target="#modalViewer">
                <i class="fa-solid fa-file-pdf me-2"></i>
                Visualizar 
            </button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-datatable table-responsive">
                    <table class="table table-responsive table-borderless" id="table_prestaciones_niveles">
                        <thead>
                            <tr>
                                {{-- <span class="d-md-none">ESTADO</span> --}}
                                <th valign="middle" width="30px" class="text-center"></th>
                                <th valign="middle">EXÁMENES</th>
                                <th valign="middle">ESTADO</th>
                                <th valign="middle">N.° COMPROBANTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="header">
                                <td type="button" width="30px" class="text-center"><i class="fa-solid fa-caret-down text-primary-veris"></i></td>
                                <td class="fw-bold text-primary-veris" colspan="3">Imnunología</td>
                            </tr>
                            <tr class="">
                                <td></td>
                                <td class="fw-bold text-veris">Biometría Hemática</td>
                                <td><span class="badge rounded-pill w-100 bg-warning">En proceso</span></td>
                                <td>0000914529704707786396</td>
                            </tr>
                            <tr class="">
                                <td></td>
                                <td class="fw-bold text-veris">Glucosa en sangre</td>
                                <td><span class="badge rounded-pill w-100 bg-warning">En proceso</span></td>
                                <td>0000914529704707786396</td>
                            </tr>
                            <tr class="header">
                                <td type="button" width="30px" class="text-center"><i class="fa-solid fa-caret-down text-primary-veris"></i></td>
                                <td class="fw-bold text-primary-veris" colspan="3">Imnunología</td>
                            </tr>
                            <tr class="">
                                <td></td>
                                <td class="fw-bold text-veris">Biometría Hemática</td>
                                <td><span class="badge rounded-pill w-100 bg-success">Listo</span></td>
                                <td>0000914529704707786396</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalViewer" aria-labelledby="modalViewerLabel" data-bs-keyboard="true" tabindex="-1" aria-hidden="true">
    {{-- data-bs-backdrop="static" --}}
    {{-- <div class="modal-dialog modal-xl"> --}}
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-2">
            <div class="modal-header pt-2 d-flex justify-content-between align-items-center">
                <button id="downloadBtn" class="btn btn-success p-2 fs--3" onclick="downloadPDF()">
                    <i class="fa-solid fa-download me-1"></i> Descargar
                </button>
                <i type="button" class="fa-regular fa-rectangle-xmark m-2 text-primary-veris fs-24" data-bs-dismiss="modal"></i>
            </div>
            <div class="modal-body p-0" id="canvases">
            </div>
        </div>
    </div>
</div>

<style>
    .swiper-ordenes .btn.disabled, .swiper-ordenes .btn:disabled{
        display: none !important;
    }
    .orden-seleccionada, .swiper-ordenes .swiper-slide .card:hover{
        background: #296BEF0D;
    }
    .progress{
        background: #d7d7d7 !important;
    }
    .table tr.header {
        background: #296BEF1A;
        cursor: pointer;
        -webkit-user-select: none;
        /* Chrome all / Safari all */
        -moz-user-select: none;
        /* Firefox all */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
        /* Likely future */
    }

    .table tbody tr:not(.header) {
        display: none;
    }

    #canvases canvas {
        width: 100%;
        border-bottom: 5px solid #cbcbcb75;
    }
    #canvases canvas:last-child{
        border-bottom: none;
    }
</style>
<script>
    flatpickr("#fechaDesde", {
        locale: _langDate,
        // maxDate: "today"
    });
    flatpickr("#fechaHasta", {
        locale: _langDate,
        // maxDate: "today"
    });
    
    var pdfUrl = "{{ asset('assets/external/resultados-laboratorio/resultado.pdf') }}";
    var pdfjsLib = window['pdfjs-dist/build/pdf'];

    document.addEventListener("DOMContentLoaded", async function () {
        var ua = navigator.userAgent,
        event = (ua.match(/iPad/i)) ? "touchstart" : "click";
        if ($('.table').length > 0) {
            $('.table .header').on(event, function() {
                $(this).toggleClass("active", "").nextUntil('.header').css('display', function(i, v) {
                    return this.style.display === 'table-row' ? 'none' : 'table-row';
                });
                $(this).toggleClass("active", "").nextUntil('.header').css('display', function(i, v) {
                    let status = (this.style.display === 'table-row') ? 'none' : 'table-row';
                    console.log(status);
                });
            });
        }

        var swiper = new Swiper('.swiper-ordenes', {
            // slidesPerView: 3.1,
            spaceBetween: 8,
            navigation: {
                nextEl: '.btn-next',
                prevEl: '.btn-prev',
            },
            autoplay: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                300: {
                    slidesPerView: 1.2,
                    centeredSlides: false,
                    // loop: true,
                    spaceBetween: 4,
                },
                768: {
                    slidesPerView: 2.1,
                    // centeredSlides: true,
                    // loop: true,
                    // spaceBetween: 8,
                },
                1024: {
                    slidesPerView: 3.1,
                    // spaceBetween: 8,
                },
                1150: {
                    slidesPerView: 3.5,
                    // spaceBetween: 8,
                },
            },
        });

        $('body').on('click', '.swiper-ordenes .swiper-slide .card', async function(){
            $('.swiper-ordenes .swiper-slide .card').removeClass('orden-seleccionada');
            $(this).addClass('orden-seleccionada');
            await obtenerOrden($(this).attr("data-rel"))
        });

        
        
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.2/pdf.worker.js';
        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 10.0;

        function renderPage(num, canvas) {
            var ctx = canvas.getContext('2d');
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({scale: scale});
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
        }

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;

            const pages = parseInt(pdfDoc.numPages);

            var canvasHtml = '';
            for (var i = 0; i < pages; i++) {
                canvasHtml += '<canvas id="canvas_' + i + '"></canvas>';
            }

            document.getElementById('canvases').innerHTML = canvasHtml;
            for (var i = 0; i < pages; i++) {
                var canvas = document.getElementById('canvas_' + i);
                renderPage(i+1, canvas);
            }
        });

    });

        // Modificar el viewport para permitir el zoom al abrir el modal
        document.getElementById('modalViewer').addEventListener('show.bs.modal', function () {
            const metaViewport = document.querySelector('meta[name="viewport"]');
            metaViewport.setAttribute('content', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=3, user-scalable=yes');
        });

        // Restaurar el viewport original al cerrar el modal
        document.getElementById('modalViewer').addEventListener('hidden.bs.modal', function () {
            const metaViewport = document.querySelector('meta[name="viewport"]');
            metaViewport.setAttribute('content', 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no');
        });


    function downloadPDF() {
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = 'resultado-orden-12112.pdf';
        link.click();
    }

    async function obtenerOrden(params){
        console.log(params);
    }
</script>
@endsection