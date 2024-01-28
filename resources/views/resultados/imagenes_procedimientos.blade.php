@extends('template.app-template-veris')
@section('title')
Mi Veris - Resultados
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<div class="flex-grow-1 container-p-y pt-0">
    <!-- modal -->
    <div class="modal fade" id="resultadImagenesProcedimientosModal" tabindex="-1" aria-labelledby="resultadImagenesProcedimientosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body" id="modalBody">
                    <!-- contenido dinamico -->
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-24">{{ __('Resultados') }}</h5>
    </div>

    <!-- filtro -->
    <div class="tab-content bg-transparent px-0 px-lg-4" id="pills-tabContent">
        @include('components.barraFiltro', ['context' => 'contextoAplicarFiltros'])
        @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
    </div>
    
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto col-lg-10">
                <div class="row gy-3" id="resultadosIP">
                    <!-- items dinamicos -->
                </div>
            </div>
            <!-- Mensaje No tienes ordenes de terapia realizadas -->
            <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesResultadosRealizados">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <h5>No tienes resultados </h5>
                            <p>En esta sección podrás revisar los resultados de tus exámenes</p>
                            <div class="avatar avatar-xxl-10 mx-auto">
                                <span class="avatar-initial rounded-circle bg-light-grayish-blue">
                                    <img src="{{ asset('assets/img/svg/doctora.svg') }}" alt="recetas" class="rounded-circle">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->

            <!-- Mensaje No tienes permisos de administrador -->
            <div class="col-12 d-flex justify-content-center d-none" id="mensajeNoTienesPermisosAdministradorRealizados">
                <div class="card bg-transparent shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <h5>No tienes permisos de administrador</h5>
                            <p>Pídele a esta persona que te otorgue los permisos en la sección <b>Familia y amigos</b>.</p>
                            <img src="{{ asset('assets/img/svg/resultado_2.svg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensaje END -->

        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- script -->

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    let fechaDesdePicker = flatpickr("#fechaDesde", {
        maxDate: new Date().fp_incr(0),
        onChange: function(selectedDates, dateStr, instance) {
            if (!document.getElementById('fechaHasta').disabled) {
                fechaHastaPicker.set('minDate', dateStr);
            } else {
                document.getElementById('fechaHasta').disabled = false;
                fechaHastaPicker = flatpickr("#fechaHasta", {
                    minDate: dateStr,
                    maxDate: new Date().fp_incr(0)
                });
            }
        }
    });

    let fechaHastaPicker = flatpickr("#fechaHasta", {
        maxDate: new Date().fp_incr(0),
        minDate: new Date(), 
        onChange: function(selectedDates, dateStr, instance) {
        }
    });

    document.getElementById('fechaHasta').disabled = true;
    // quitar el readonly

    $("#fechaDesde").removeAttr("readonly");
    $("#fechaHasta").removeAttr("readonly");
    // no permitir autocomplete
    $("#fechaDesde").attr("autocomplete", "off");
    $("#fechaHasta").attr("autocomplete", "off");



</script>


<script>
   

    // variables globales
 
        let familiar = [];
        let identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
 
     // llamada al dom 
     document.addEventListener("DOMContentLoaded", async function () {
         await consultarResultadosPorTipo();
         await consultarGrupoFamiliar();
         const elemento = document.getElementById('nombreFiltro');
         elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}" );
         $('body').on('click','.verResultados', async function () {
             let idRelacion = $(this).attr('data-object');
             console.log('idRelacion',idRelacion);
                 
         });
     });
 
     // funciones asyncronas
 
     // Consultar resultados de laboratorio
 
     async function consultarResultadosPorTipo(numeroIdentificacion, tipoIdentificacion, desde='', hasta = '', tipoServicio , esAdmin = 'S') {
         let args = [];
         let canalOrigen = _canalOrigen;
         codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
         tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
         tipoServicio = "IMG,PROC";
         numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
 
                 
         args["endpoint"] = api_url + `/digitalestest/v1/examenes/resultadosPorTipo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&numeroIdentificacion=${numeroIdentificacion}&tipoIdentificacion=${tipoIdentificacion}&desde=${desde}&hasta=${hasta}&tipoServicio=${tipoServicio}`
         
         args["method"] = "GET";
         args["showLoader"] = true;
         console.log(7,args["endpoint"]);
         const data = await call(args);
         console.log('data7', data.data.items);
 
         let html = $("#resultadosIP");
         html.empty();
         if (data.code == 200){
            if (data.data.items.length == 0){
                 if (esAdmin == 'S'){
                     $("#mensajeNoTienesResultadosRealizados").removeClass("d-none");
                    $("#mensajeNoTienesPermisosAdministradorRealizados").addClass("d-none");

                 } else if (esAdmin == 'N'){
                    $("#mensajeNoTienesPermisosAdministradorRealizados").removeClass("d-none");
                    $("#mensajeNoTienesResultadosRealizados").addClass("d-none");
                     
                 }
            } 
            else {
                
                $("#mensajeNoTienesPermisosAdministradorRealizados").addClass("d-none");
                if (esAdmin == 'S'){
                
                    $("#mensajeNoTienesResultadosRealizados").addClass("d-none");
                    
                    
                    let items = data.data.items;
                    let elemento = "";
    
                    items.forEach((resultados) => {
    
                        elemento += `<div class="col-12 col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <h6 class="text-primary-veris fw-bold fs--1 mb-1">${capitalizarElemento(resultados.nombreServicio)}</h6>
                                                <p class="fw-bold fs--2 mb-1" id="nombreResultadoLab" style="color: #0055AA !important">${capitalizarElemento(resultados.nombreOrigenResultado)}</p>
                                                <p class="fw-bold fs--2 mb-1" id="ubicacion">${capitalizarElemento(resultados.nombreSucursal)}</p>
                                                <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">${resultados.dia}</b></p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div class="avatar me-2">
                                                        <img src=${quitarComillas(resultados.iconoServicio)} alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                                    </div>
                                                    <button onclick="detallesResultadosLaboratorio('${resultados.codigoOrdenApoyo}')"
                                                    type="button"  class="btn btn-primary-veris shadow-none verResultados" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                                        Ver resultados
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    });
                    html.append(elemento);
                    
                } 
                else if (esAdmin == 'N'){
                    // mostrar mensaje de no tienes permisos de administrador
                    $("#mensajeNoTienesPermisosAdministradorRealizados").removeClass("d-none");
                }

            }

        }
         
     }

 
     //  detalles de resultados de laboratorio
 
     async function detallesResultadosLaboratorio(codigoApoyo){
          let args = [];
          canalOrigen = _canalOrigen
          codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
          tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
  
          args["endpoint"] = api_url + `/digitalestest/v1/examenes/detalleexamen?canalOrigen=${canalOrigen}&codigoOrdenApoyo=${codigoApoyo} `;
          args["method"] = "GET";
          args["showLoader"] = true;
          const data = await call(args);
          console.log('datad', data);
  
          // insertar datos en el modal
          if (data.code == 200){
             let items = data.data;
             console.log('items', items);
             
             if (items == null){
                 console.log('entro1');
                 let html = $("#modalBody");
                 html.empty();
                 
                 let elemento = "";
                 elemento += `<h1 class="text-center fw-bold fs-5">Resultados</h1>`;
                 elemento += `<div class="my-3">
                                 <p class="text-center fs-normal my-3">${capitalizarElemento(data.message)}</p>
                             </div>`;
                 
                 html.append(elemento);  
             } else {
                 console.log('entro2');
 
                 let html = $("#modalBody");
                 html.empty();
                 
                 let elemento = "";
     
                 elemento += `<h1 class="text-center fw-bold fs-5">Resultados</h1>`;
     
                 items.forEach((resultados, index) => {
                    console.log('resultados', resultados);
     
                     elemento += `<div class="my-3">
                                     <p class="text-center fs-normal my-3">${capitalizarElemento(resultados.nombrePrestacion)}</p>
                                     <a href="${quitarComillas   (resultados.urlVisorWeb)}" class="btn btn-lg btn-outline-primary-veris w-100" target="_blank">Ver imagen</a>
                                 </div>
                                 <div class="border-top">
                                    <button class="btn btn-lg btn-primary-veris w-100 mt-3" target="_blank" onclick="verInforme('${resultados.codigoOrdenApoyos}' , '${resultados.tipo}')">Ver informe</button>
                                </div>
                                 `;
                             });

                
                 html.append(elemento);
     
             }        
      
              
          }
  
    }

    async function verInforme(codigoApoyo, tipo){
        console.log('si entro');    
        
        let args = {};
        canalOrigen = _canalOrigen
        codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
        tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";

        args["endpoint"] = api_url + `/digitalestest/v1/examenes/archivoresultado?canalOrigen=${canalOrigen}&codigoOrdenApoyo=${codigoApoyo} `;
       
        args["method"] = "GET";
        args["showLoader"] = true;
        console.log('arsgs', args["endpoint"]);
        try {
            const blob = await callInformes(args);
            const pdfUrl = URL.createObjectURL(blob);

            window.open(pdfUrl, '_blank');

            setTimeout(() => {
                URL.revokeObjectURL(pdfUrl);
            }, 100);

        } catch (error) {
            console.error('Error al obtener el PDF:', error);
        }

    }

    
 
 
     // consultar grupo familiar
     async function consultarGrupoFamiliar() {
         let args = [];
         canalOrigen = _canalOrigen
         codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
         args["endpoint"] = api_url + `/digitalestest/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`;
         args["method"] = "GET";
         args["showLoader"] = true;
         const data = await call(args);
         if(data.code == 200){
             familiar = data.data;
             mostrarListaPacientesFiltro();
 
         }
         return data;
     }

     

 
 
     // funciones js 
 
     



      // aplicar filtros
    $('#aplicarFiltros').on('click', function() {

        console.log('aplciar filtros');
        const contexto = $(this).data('context');
        console.log('contexto', contexto);
        aplicarFiltrosResultados(contexto, tipoServicio = 'LAB');
        let texto = $('input[name="listGroupRadios"]:checked').data('rel');
        console.log('texto', texto);
        identificacionSeleccionada = texto.numeroPaciente;
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento(texto.primerNombre + ' ' + texto.primerApellido);
        
    });

    
    // limpiar filtros
    
    $('#btnLimpiarFiltros').on('click', function() {
        const contexto = $(this).data('context');
        limpiarFiltrosResultados(contexto, tipoServicio = 'LAB');
        identificacionSeleccionada = "{{ Session::get('userData')->numeroPaciente }}";
        const elemento = document.getElementById('nombreFiltro');
        elemento.innerHTML = capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }}");

    });



 
 
 
</script>
{{-- <script>
    let fechaDesdePicker = flatpickr("#fechaDesde", {
        maxDate: new Date().fp_incr(0),
        onChange: function(selectedDates, dateStr, instance) {
            if (!document.getElementById('fechaHasta').disabled) {
                fechaHastaPicker.set('minDate', dateStr);
            } else {
                document.getElementById('fechaHasta').disabled = false;
                fechaHastaPicker = flatpickr("#fechaHasta", {
                    minDate: dateStr,
                    maxDate: new Date().fp_incr(0)
                });
            }
        }
    });

    let fechaHastaPicker = flatpickr("#fechaHasta", {
        maxDate: new Date().fp_incr(0),
        minDate: new Date(), 
        onChange: function(selectedDates, dateStr, instance) {
        }
    });

    document.getElementById('fechaHasta').disabled = true;
    // quitar el readonly

    $("#fechaDesde").removeAttr("readonly");
    $("#fechaHasta").removeAttr("readonly");
    // no permitir autocomplete
    $("#fechaDesde").attr("autocomplete", "off");
    $("#fechaHasta").attr("autocomplete", "off");



</script> --}}


@endpush