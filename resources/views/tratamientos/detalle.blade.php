@extends('template.app-template-veris')
@section('title')
Mi Veris - Citas - tratamiento
@endsection
@push('css')
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="informacionModal" tabindex="-1" aria-labelledby="informacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="modal-title fs-5 fw-bold text-center border-bottom mb-3 pb-2">Informacion</h1>
                    <p class="fs--1 fw-bold text-primary">Servicios incluidos en la compra</p>
                    <ul>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                        <li>Opciones...</li>
                    </ul>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-primary-veris w-100" data-bs-dismiss="modal">Entiendo</button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Tú tratamiento') }}</h5>
    <section class="pt-3 px-0 px-md-3 pb-0">
        <div class="row g-0 justify-content-center mt-5">
            <div class="col-auto col-md-6 col-lg-5">
                <div class="card bg-transparent shadow-none rounded-0">
                    <div class="card-header rounded-0 position-relative" style="background: linear-gradient(-264deg, #0805A1 1.3%, #1C89EE 42.84%, #3EDCFF 98.49%);">
                        <div class="content-text text-white lh-1">
                            <p class="mb-0">Veris te regala un</p>
                            <h4 class="text-white mb-0">XX% de descuento</h4>
                            <p class="mb-0">por pagar en app</p>
                        </div>
                        <div class="promo-img position-absolute">
                            <img src="{{ asset('assets/img/svg/regalo.svg') }}" class="card-img-top" alt="">
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <a href="#" class="d-flex align-items-center gap-2 bg-white py-2 px-3">
                            <img src="{{ asset('assets/img/svg/especialidades/alergologia.svg') }}" alt="especialidad" />
                            <div class="ms-2">
                                <h6 class="fw-bold mb-0">Traumatología</h6>
                                <p class="fw-normal fs--1 mb-0">Ver tratamiento en PDF <i class="bi bi-chevron-right ms-2"></i></p>
                            </div>
                        </a>
                        <h6 class="fw-bold py-2 px-3 mb-0" style="background: #E9EFF4;">Selecciona tus servicios</h6>
                        <div class="d-flex justify-content-between align-items-center px-3 py-1 bg-labe-grayish">
                            <span class="fw-bold fs--2">Servicio</span>
                            <span class="fw-bold fs--2">Cantidad</span>
                        </div>
                        <ul class="list-group gap-2 bg-white rounded-0">
                            <!-- items -->
                            <li class="list-group-item d-flex justify-content-between align-items-center shadow-veris border-0 rounded-0">
                                <div class="w-auto">
                                    <p class="text-veris mb-0">Cita médica traumatología</p>
                                    <div class="d-flex align-items-center">
                                        <p class="text-primary fw-bold fs--2 mb-0" id="precioTotal">
                                            <del class="text-danger fw-normal" id="precioBase">$50.00</del> 
                                            $45.00
                                        </p>
                                        <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" data-bs-toggle="modal" data-bs-target="#informacionModal"><i class="bi bi-info-circle"></i> </button> 
                                    </div>
                                </div>
                                <div class="input-group input-group-sm flex-nowrap w-25" data-quantity="data-quantity">
                                    <button class="btn btn-sm btn-minus px-2" data-type="minus">-</button>
                                    <input class="form-control text-center input-spin-none bg-transparent px-0" type="number" min="1" value="1" />
                                    <button class="btn btn-sm btn-plus px-2" data-type="plus">+</button>
                                </div>
                            </li>
                            <!-- items -->
                            <li class="list-group-item d-flex justify-content-between align-items-center shadow-veris border-0 rounded-0">
                                <div class="w-auto">
                                    <p class="text-veris mb-0">Terapia física </p>
                                    <div class="d-flex align-items-center">
                                        <p class="text-primary fw-bold fs--2 mb-0" id="precioTotal">
                                            <del class="text-danger fw-normal" id="precioBase">$50.00</del> 
                                            $45.00
                                        </p>
                                        <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" data-bs-toggle="modal" data-bs-target="#informacionModal"><i class="bi bi-info-circle"></i> </button> 
                                    </div>
                                </div>
                                <div class="input-group input-group-sm flex-nowrap w-25" data-quantity="data-quantity">
                                    <button class="btn btn-sm btn-minus px-2" data-type="minus">-</button>
                                    <input class="form-control text-center input-spin-none bg-transparent px-0" type="number" min="1" value="10" />
                                    <button class="btn btn-sm btn-plus px-2" data-type="plus">+</button>
                                </div>
                            </li>
                            <!-- items -->
                            <li class="list-group-item d-flex justify-content-between align-items-center shadow-veris border-0 rounded-0">
                                <div class="w-auto">
                                    <p class="text-veris mb-0">Procedimiento</p>
                                    <div class="d-flex align-items-center">
                                        <p class="text-primary fw-bold fs--2 mb-0" id="precioTotal">
                                            <del class="text-danger fw-normal" id="precioBase">$50.00</del> 
                                            $45.00
                                        </p>
                                        <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" data-bs-toggle="modal" data-bs-target="#informacionModal"><i class="bi bi-info-circle"></i> </button> 
                                    </div>
                                </div>
                                <div class="input-group input-group-sm flex-nowrap w-25" data-quantity="data-quantity">
                                    <button class="btn btn-sm btn-minus px-2" data-type="minus">-</button>
                                    <input class="form-control text-center input-spin-none bg-transparent px-0" type="number" min="1" value="1" />
                                    <button class="btn btn-sm btn-plus px-2" data-type="plus">+</button>
                                </div>
                            </li>
                            <!-- items -->
                            <li class="list-group-item d-flex justify-content-between align-items-center shadow-veris border-0 rounded-0">
                                <div class="w-auto">
                                    <p class="text-veris mb-0">Radiología </p>
                                    <div class="d-flex align-items-center">
                                        <p class="text-primary fw-bold fs--2 mb-0" id="precioTotal">
                                            <del class="text-danger fw-normal" id="precioBase">$50.00</del> 
                                            $45.00
                                        </p>
                                        <button type="button" class="btn btn-sm shadow-none py-0 px-1 text-primary" data-bs-toggle="modal" data-bs-target="#informacionModal"><i class="bi bi-info-circle"></i> </button> 
                                    </div>
                                </div>
                                <div class="input-group input-group-sm flex-nowrap w-25" data-quantity="data-quantity">
                                    <button class="btn btn-sm btn-minus px-2" data-type="minus">-</button>
                                    <input class="form-control text-center input-spin-none bg-transparent px-0" type="number" min="1" value="1" />
                                    <button class="btn btn-sm btn-plus px-2" data-type="plus">+</button>
                                </div>
                            </li>
                        </ul>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-normal text-veris fs--2 bg-labe-grayish" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Servicios que no están incluidos en tu compra. 
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center bg-white mb-3 py-2">
                            <div class="content-img">
                                <img src="{{ asset('assets/img/svg/regalo_abierto.svg') }}" alt="" />
                            </div>
                            <div class="ms-4">
                                <p class="text-danger fw-normal fs--2 mb-0" id="content-precioBase">Precio normal <del class="fw-bold" id="precioBase">$130.00</del></p>
                                <h2 class="text-primary fw-bold mb-0" id="precioTotal">$35.00</h2>
                            </div>
                        </div>
                        <div class="p-3">
                            <a href="#" class="btn btn-primary-veris w-100 mb-3">Comprar</a>
                            <a href="#" class="btn w-100 mb-3">Ahora no</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>


    // llamada al dom
    
    document.addEventListener("DOMContentLoaded", async function () {

    });


    // funciones asyncronas

    // ver detalle de tratamiento
    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientesFiltro();

        }
        return data;
    }




</script>
@endpush