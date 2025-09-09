@extends('template.app-template-veris')
@section('title')
{{-- Detalle de promo para comprar --}}
Mi Veris - Citas - Detalle
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- Modal -->
    <div class="modal fade" id="plaPreventivoModal" tabindex="-1" aria-labelledby="plaPreventivoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <h6 class="fs--16 line-height-20 fw-medium mt-3 mb-4">¿Quién va a utilizar el plan preventivo?</h6>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <!-- Opcion 1 -->
                        <div class="list-group list-group-checkable d-grid gap-3 mb-3 border-0 grupoFamiliar-item" id="listaGrupoFamiliar">
                            {{-- <a href="#" class="list-group-item list-group-item-action border rounded-3 py-2" aria-current="true">
                                <p class="fs--2 mb-0">Fernanda Alarcon Tapia</p>
                            </a> --}}
                        </div>
                        <!-- opcion 2 -->
                        {{-- <div class="list-group list-group-checkable d-grid gap-2 border-0 d-none">
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios1" value="" checked>
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios1">
                                Fernanda Alarcon Tapia
                            </label>
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios2" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios2">
                                Julia Tapia Lopez
                            </label>
                            <!-- items -->
                            <input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios3" value="">
                            <label class="list-group-item fs--2 rounded-3 p-2" for="listGroupCheckableRadios3">
                                Gabriela Alarcon Tapia
                            </label>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center bg-white shadow-bottom">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24" id="nombrePaquete"></h5>
    </div>
    <section class="p-3 mb-3">
        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="card border-0">
                    <div class="card-body p-0 imagenPaquete">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="mb-3">
                    <div class="original-price d-flex justify-content-start align-items-center">
                        <p class="card-text text-veris-ai fs-28 line-height-36 fw-bold mb-0 precioVenta"></p>
                        <div class="discounted-price d-none ms-2 mb-0 mt-1" style="color: #425065;">
                            <p class="fs--1 mb-0">Antes <del class="precioRegular"></del></p>
                        </div>
                        <div class="p-1 font-gotham box-discount fw-medium text-center d-none mb-0 mt-1 ms-2"></div>
                    </div>
                </div>
                <span class="badge text-bg-pale-blue rounded-4 fw-normal px-2 py-1 mb-4 strCategoria d-none"></span>
                <div class="border-0 rounded-3 mb-4 listPrestaciones">
                </div>
                <button type="button" class="btn bg-veris-ai text-white btn-asignar w-100 fs--18 line-height-24 fw-medium px-4 py-3 rounded-3">Comprar</button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="p-3 fs--16 line-height-20 text-start" id="descripcionPaquete" style="background: #EAF0FD;border-radius: 8px;"></div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<style>
    .badge-discount {
        border-radius: 0px 0px 0px 4px;
        padding: 8px 12px;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        background: #cc0b39;
        font-size: 16px;
        font-style: normal;
        font-weight: 350;
        line-height: 20px;
        border-top-right-radius: 8px;
    }
    .box-discount {
        font-size: 12px;
        line-height: 16px;
        color: #CC0B39;
        border: 1px solid #CC0B39;
        border-radius: 4px !important;
        width: auto;
    }
    .badge-domicilio {
        background: #D4E1FC;
        font-size: 12px;
        line-height: 16px;
        padding: 8px 12px !important;
    }
    .badge-mas-vendido{
        background: #FBE9E7;
        font-size: 12px;
        line-height: 16px;
        padding: 8px 12px !important;
        color: #D84315;
    }
</style>
<script>
    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    document.addEventListener("DOMContentLoaded", async function () {
        $('#nombrePaquete').html(capitalizarElemento(dataCita.paquete.nombreComercialPaquete));

        let descripcion = dataCita.paquete.descripcionPaquete.replace(/\u00A0/g, " ").replace(/\n/g, "<br>");
        {{-- let centrales = `<br><br><b class="fs--16 line-height-20">Puedes realizarlo en las centrales: </b><br>
            <div class='text-capitalize'>`
        let centralesArr = []
        $.each(dataCita.paquete.sucursalesAsignacion, function(key, value){
            centralesArr.push(value.nombreSucursal.toLowerCase());
        })
        centrales += centralesArr.join(', ');
        centrales += `.</div>`;

        $('#descripcionPaquete').html(descripcion + centrales); --}}
        $('#descripcionPaquete').html(descripcion);

        $('.imagenPaquete').html(`<img src="${dataCita.paquete.urlImagen}" class="img-fluid rounded-3 w-100" alt="${dataCita.paquete.nombrePaquete}" />`);
        if(dataCita.paquete.porcentajeDescuento > 0){
            $('.precioRegular').html(`$${dataCita.paquete.valorAnteriorPaquete}`).parent().parent().removeClass('d-none');
        }

        let strDescuento = ``;
        let badgesMasVendido = ``;
        let badgesImg = `<div class="position-absolute bottom-0 p-2 m-1 d-flex justify-content-start align-items-center gap-2">`;
        if(dataCita.paquete.porcentajeDescuento > 0){
            //strDescuento = `<span class="badge badge-discount position-absolute top-0 end-0">-${dataCita.paquete.porcentajeDescuento}%</span>`;
            if(dataCita.paquete.esDescuentoExclusivo){
               strDescuento += `<span class="badge badge-discount position-absolute top-0 end-0">Desct. exclusivo web</span>`;
            }
        }
        
        if(dataCita.paquete.esMasVendido){
            badgesImg += `<div class="d-flex justify-content-start align-items-center">
                <div class="p-2 badge-mas-vendido fw-medium rounded-1 font-gotham d-flex justify-content-between"><i class="fa-solid fa-fire me-2"></i>Más vendido</div>
            </div>`;
        }

        if(dataCita.paquete.esDomicilio){
            badgesImg += `<div class="d-flex justify-content-start align-items-center">
                <div class="p-2 badge-domicilio text-primary fw-medium rounded-1 font-gotham d-flex justify-content-between"><img src="{{asset('assets/img/svg/fa-icon-domicilio.svg')}}" style="width: 16px;margin-right: 4px;">A domicilio</div>
            </div>`
        }

        badgesImg += `</div>`;

        $('.imagenPaquete').append(`<div>${strDescuento} ${badgesImg}</div>`)


        $('.precioVenta').html(`$${dataCita.paquete.valorTotalPaquete}`);
        if(dataCita.paquete.porcentajeDescuento > 0){
            $('.box-discount').removeClass('d-none').html(`-${dataCita.paquete.porcentajeDescuento}% dto.`)
        }
        {{-- $('.descripcion').html(dataCita.paquete.descripcionPaquete + `<p class="fw-bold mb-0">¡HACEMOS FÁCIL CUIDARTE!</p>`); --}}
        
        await obtenerDetallePaquetePromocional();
        let prestaciones = ``;
        $.each(dataCita.detallePaquete.detallePromocion, function(key, value){
            prestaciones += `<h6 class="text-veris-ai fw-bold">${value.nombreServicio}</h6>
                            <ul class="ps-5 mb-0 text-sm">`;
            $.each(value.detalles, function(k, v){
                prestaciones += `<li class= fs--16 line-height-20 mb-2">${v.nombreComercial}</li>`;
            })
            prestaciones += `</ul>`;
        })
        $('.listPrestaciones').html(prestaciones);

        $('body').on('click', '.btn-asignar', function(){
            let url = '/citas-elegir-paciente/'
            if(dataCita.paquete.idPaciente !== null){
                url = '/citas-datos-facturacion/';
                dataCita.paciente = {
                    "numeroPaciente": dataCita.paquete.idPaciente
                };
            }else{
                
            }
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            location.href = url + "{{ $params }}";
        })

        let valorAnteriorElem = ``;
        if(dataCita.paquete.porcentajeDescuento > 0){
            $('#porcentajeDescuento').html(`-${dataCita.paquete.porcentajeDescuento}% OFF`).removeClass('d-none');
            $('#porcentajeDescuento').removeClass('d-none');
            //$('#valorAnteriorPaquete').html(`$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}`);
            valorAnteriorElem += `<p class="fs--1 fw-normal mb-0 me-2" style="color: #6E7A8C !important;"><del id="valorAnteriorPaquete">$${dataCita.paquete.valorAnteriorPaquete.toFixed(2)}</del></p>`;
        }

        let elemValores = `${valorAnteriorElem}
            <h5 class="text-primary-veris fs--20 fw-bold mb-0" id="valorTotalPaquete">$${dataCita.paquete.valorTotalPaquete.toFixed(2)}</h5>`;

        $('#detalleValoresPaquete').html(elemValores)

        //consultarGrupoFamiliar();
        

        // $('body').on('click', '.btn-asignar', function(){
        //     let url = '/citas-datos-facturacion/';
        //     dataCita.paciente = JSON.parse($(this).attr('data-rel'));
        //     localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
        //     location.href = url + "{{ $params }}";
        // })
    })

    function clearNbsp($str){
        $entities = str_replace('&nbsp;', ' ', htmlentities($str));
        return html_entity_decode($entities);
    }


    async function obtenerDetallePaquetePromocional(){
        let args = [];
        args["endpoint"] = api_url + `/${api_war}/v1/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=${dataCita.paquete.codigoEmpresaPaquete}&codigoPaquete=${dataCita.paquete.codigoPaquete}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            $('#detallePaquete').empty();
            dataCita.detallePaquete = data.data;
            let elem = ``;
            $.each(data.data.detallePromocion, function(key, value){
                $.each(value.detalles, function(k,v){
                    elem += `<li class="mb-0" title="${value.nombreServicio}">${v.nombreComercial}</li>`;
                })
            })
            $('#detallePaquete').append(elem);
        }else{
            alert(data.message);
        }
    }

    async function consultarGrupoFamiliar() {
        let args = [];
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        args["endpoint"] = api_url + `/${api_war}/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        console.log('dataFa', data);
        if(data.code == 200){
            $('#listaGrupoFamiliar').empty();
            let elem = ``;
            $.each(data.data, function(key,value){
                elem += `<div data-rel='${ JSON.stringify(value) }' class="list-group-item rounded-3 py-2 px-3 border-0 btn-asignar" aria-current="true">
                    <input class="list-group-item-check pe-none" type="radio" name="listGrupoFamiliar" id="listGrupoFamiliar${value.numeroPaciente}" value="">
                    <label for="listGrupoFamiliar${value.numeroPaciente}" class="text-primary-veris fs--1 line-height-16 cursor-pointer">
                        ${capitalizarElemento(value.primerNombre)} ${capitalizarElemento(value.primerApellido)} ${capitalizarElemento(value.segundoApellido)}
                    </label>
                </div>`;
            })
            $('#listaGrupoFamiliar').append(elem);
        }
        return data;
    }
</script>
@endpush