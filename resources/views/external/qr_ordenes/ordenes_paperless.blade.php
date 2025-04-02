@extends('template.external')
@section('title')
Veris - Resultados de Laboratorio
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<link rel="stylesheet" href="{{ asset('assets/external/phantomx/css/theme-phantomx.css?v=1.0')}}">
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/external/phantomx/js/utils.js"></script>

@include('external.components.navbar-phantom-x')

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

<section class="container-fluid px-0">

    <div class="text-center my-4">
        <h2 class="fw-semibold text-title-2">Soportes Paperless</h2>
    </div>

    <div class="accordion accordion-flush" id="accordionDocument">
        <div class="accordion-item border-0 mb-2">
            <h2 class="accordion-header">
                <div class="accordion-button accordion-bg-secondary px-3 px-lg-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelectPatient" aria-expanded="false" aria-controls="collapseSelectPatient">
                    <div class="d-flex flex-column justify-content-start align-items-start w-100">
                        <button class="btn btn-light-phax btn-sm mb-3 me-3" style="border-radius: 4px; font-weight: bold;">
                            Seleccionar Paciente
                        </button>
                        <div class="d-flex align-items-center text-montserrat">
                          <span class="fw-bold me-3">Nombre del Paciente</span>
                          <span class="fw-bold me-2">Identificación</span>
                          <span class="me-2 fw-normal">C317448495</span>
                          <button class="btn btn-link p-0 text-white" onclick="copyToClipboard('C317448495')">
                            <img src="{{ asset('assets/external/phantomx/img/icon/copy.svg') }}" alt="copy"/>
                            <!-- <span id="copyBadge" class="visually-hidden position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Copiado</span> -->
                          </button>
                        </div>
                    </div>
                </div>
            </h2>
            <div id="collapseSelectPatient" class="accordion-collapse collapse" data-bs-parent="#accordionDocument">
                <div class="accordion-body px-3 px-lg-5">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
            </div>
        </div>

        <div class="accordion-item border-0 mb-2">
            <h2 class="accordion-header">
                <div class="accordion-button accordion-bg-blue px-3 px-lg-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCurrentPatient" aria-expanded="true" aria-controls="collapseCurrentPatient">
                    <div class="d-flex flex-column justify-content-start align-items-start w-100">
                        <button class="btn btn-success-phax btn-sm mb-3 me-3" style="border-radius: 4px; font-weight: bold;">
                            Paciente actual
                        </button>
                        <div class="d-flex align-items-center text-montserrat">
                          <span class="fw-bold me-3">Nombre del Paciente</span>
                          <span class="fw-bold me-2">Identificación</span>
                          <span class="me-2 fw-normal">C317448495</span>
                          <button class="btn btn-link p-0 text-white" onclick="copyToClipboard('C317448495')">
                            <img src="{{ asset('assets/external/phantomx/img/icon/copy.svg') }}" alt="copy"/>
                            <!-- <span id="copyBadge" class="visually-hidden position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Copiado</span> -->
                          </button>
                        </div>
                    </div>
                </div>
            </h2>
            <div id="collapseCurrentPatient" class="accordion-collapse collapse show" data-bs-parent="#accordionDocument">
                <div class="accordion-body px-3 px-lg-5">

                    <h3 class="fw-semibold text-title-2">Soportes por cobertura</h3>
                    <div class="alert alert-blue-phax d-flex align-items-center px-3 py-2 font-gotham fw-semibold" role="alert">
                        <i class="fa-solid fa-circle-info text-blue me-2 fs-4"></i>
                        <div class="text-title-2">
                            <p class="fw-bold mb-0">Subir aquí todos los documentos que sirvan de respaldo: <b class="fw-normal">Órdenes externas, carta de autorización de crédito, etc.</b></p>
                        </div>
                    </div>

                    <div class="container mb-3">
                        <div class="row gap-4">
                            <!-- Document Preview Area -->
                            <div class="slider-document position-relative">
                                <div class="swiper my-swiper py-2">
                                    <div class="swiper-wrapper" id="swiperWrapper"></div>
                                </div>
                                <div class="swiper-pagination position-absolute bottom-0 d-none"></div>
                                <!-- Navigation -->
                                <div class="swiper-button-next mt-n5 top-lg-60 box-shadow-2 d-none" style="margin-right: 6.5%;"></div>
                                <div class="swiper-button-prev mt-n5 top-lg-60 box-shadow-2 d-none" style="margin-left: 6.5%;"></div>
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
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-icon me-2">
                                        <img src="{{ asset('assets/external/phantomx/img/icon/upload-image.svg') }}" alt="">
                                    </div>
                                    <div class="upload-text lh-sm">
                                        <p class="mb-0">Sube un archivo o </p>
                                        <p class="mb-0">tómale una foto al archivo.</p>
                                    </div>
                                    <input type="file" id="fileInput" accept=".pdf,.jpg,.jpeg,.png" multiple class="file-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid border-top">
                        <div class="row g-3">
                            <!-- Soporte por autorización -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="text-start">
                                        <h3 class="fw-semibold text-title-2 my-3">
                                            Soporte por autorización 
                                            <button type="button" class="btn btn-sm border border-blue-phax rounded-3 text-blue"><i class="fa-solid fa-rotate"></i></button>
                                        </h3>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="accordion accordion-flush" id="accordionAuthLab">
                                            <div class="accordion-item">
                                                <h5 class="text-pale-sky-40 mb-0">SALUD S.A</h5>
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button accordion-bg-white fs-4 fw-semibold text-success px-0 pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuthLab" aria-expanded="true" aria-controls="collapseAuthLab">
                                                        Laboratorio
                                                    </button>
                                                </h2>
                                                <div id="collapseAuthLab" class="accordion-collapse collapse show" data-bs-parent="#accordionAuthLab">
                                                    <div class="accordion-body px-0 py-1">
                                                        <div class="file-list">
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authLabFile-1">
                                                                <label class="form-check-label" for="authLabFile-1">
                                                                    <span class="text-blue-70">Archivo 1:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authLabFile-2">
                                                                <label class="form-check-label" for="authLabFile-2">
                                                                    <span class="text-blue-70">Archivo 2:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authLabFile-3">
                                                                <label class="form-check-label" for="authLabFile-3">
                                                                    <span class="text-blue-70">Archivo 3:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authLabFile-4">
                                                                <label class="form-check-label" for="authLabFile-4">
                                                                    <span class="text-blue-70">Archivo 4:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 border-start">
                                        <div class="accordion accordion-flush" id="accordionAuthImg">
                                            <div class="accordion-item">
                                                <h5 class="text-pale-sky-40 mb-0">BMI</h5>
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button accordion-bg-white fs-4 fw-semibold text-success px-0 pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAuthImg" aria-expanded="true" aria-controls="collapseAuthImg">
                                                        Imágenes
                                                    </button>
                                                </h2>
                                                <div id="collapseAuthImg" class="accordion-collapse collapse show" data-bs-parent="#accordionAuthImg">
                                                    <div class="accordion-body px-0 py-1">
                                                        <div class="file-list">
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authImgFile-1">
                                                                <label class="form-check-label" for="authImgFile-1">
                                                                    <span class="text-blue-70">Archivo 1:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authImgFile-2">
                                                                <label class="form-check-label" for="authImgFile-2">
                                                                    <span class="text-blue-70">Archivo 2:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authImgFile-3">
                                                                <label class="form-check-label" for="authImgFile-3">
                                                                    <span class="text-blue-70">Archivo 3:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="authImgFile-4">
                                                                <label class="form-check-label" for="authImgFile-4">
                                                                    <span class="text-blue-70">Archivo 4:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- Ordenes externas -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="text-start">
                                        <h3 class="fw-semibold text-title-2">Ordenes externas</h3>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="accordion accordion-flush" id="accordionExternalLab">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button accordion-bg-white fs-4 fw-semibold text-success px-0 pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExternalLab" aria-expanded="true" aria-controls="collapseExternalLab">
                                                        Laboratorio
                                                    </button>
                                                </h2>
                                                <div id="collapseExternalLab" class="accordion-collapse collapse show" data-bs-parent="#accordionExternalLab">
                                                    <div class="accordion-body px-0 py-1">
                                                        <div class="file-list">
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalLabFile-1">
                                                                <label class="form-check-label" for="externalLabFile-1">
                                                                    <span class="text-blue-70">Archivo 1:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalLabFile-2">
                                                                <label class="form-check-label" for="externalLabFile-2">
                                                                    <span class="text-blue-70">Archivo 2:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalLabFile-3">
                                                                <label class="form-check-label" for="externalLabFile-3">
                                                                    <span class="text-blue-70">Archivo 3:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalLabFile-4">
                                                                <label class="form-check-label" for="externalLabFile-4">
                                                                    <span class="text-blue-70">Archivo 4:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6 border-start">
                                        <div class="accordion accordion-flush" id="accordionExternalImg">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button accordion-bg-white fs-4 fw-semibold text-success px-0 pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExternalImg" aria-expanded="true" aria-controls="collapseExternalImg">
                                                        Imágenes
                                                    </button>
                                                </h2>
                                                <div id="collapseExternalImg" class="accordion-collapse collapse show" data-bs-parent="#accordionExternalImg">
                                                    <div class="accordion-body px-0 py-1">
                                                        <div class="file-list">
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalImgFile-1">
                                                                <label class="form-check-label" for="externalImgFile-1">
                                                                    <span class="text-blue-70">Archivo 1:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalImgFile-2">
                                                                <label class="form-check-label" for="externalImgFile-2">
                                                                    <span class="text-blue-70">Archivo 2:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalImgFile-3">
                                                                <label class="form-check-label" for="externalImgFile-3">
                                                                    <span class="text-blue-70">Archivo 3:</span> Orden Lorem Impsun_01.pdf
                                                                </label>
                                                            </div>
                                                            <div class="file-item d-flex align-items-center fw-bold mb-2">
                                                                <input type="checkbox" class="form-check-input fs-4 m-0 me-2" id="externalImgFile-4">
                                                                <label class="form-check-label" for="externalImgFile-4">
                                                                    <span class="text-blue-70">Archivo 4:</span> Orden Lorem_012.jpg
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center my-4">
                        <div class="col-12 col-lg-2">
                            <button type="button" class="btn btn-lg btn-blue-phax w-100">Subir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>

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

<script>
	document.addEventListener("DOMContentLoaded", async function () {
		await getData();
	})

	async function getData(){
		let args = [];
        args["endpoint"] = api_url + `/facturacion/v1/pre_transacciones/{{ $idPreTransaccion }}/soportes_generales?codigoEmpresa={{ $codigoEmpresa }}`;
        args["method"] = "GET";
        args["token"] = "{{ $accessToken }}";
        args["showLoader"] = true;

        const data = await call(args);
        console.log(data)
	}
</script>


@endsection