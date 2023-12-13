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
    <div class="modal fade" id="resultadImagenesProcedimientosModal" tabindex="-1" aria-labelledby="resultadoLaboratorioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body" id="modalBody">
                    <!-- contenido dinamico -->
                </div>
            </div>
        </div>
    </div>

    <!-- filtro -->
    
    <h5 class="ps-4 pt-3 mb-1 pb-2 bg-white">{{ __('Resultados') }}</h5>
    @include('components.barraFiltro', ['context' => 'contextoAplicarFiltrosLaboratorio'])
    @include('components.offCanva', ['context' => 'contextoLimpiarFiltros'])
    <section class="p-3 pt-0 mb-3">
        <div class="row justify-content-center">
            
            <div class="col-auto col-lg-10">
                <div class="row gy-3" id="resultadosIP">
                    <!-- items dinamicos -->
                    
                </div>
            </div>

            <!-- Mensaje No tienes resultados -->
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

<script>
   

    // variables globales
 
 
     // llamada al dom 
     document.addEventListener("DOMContentLoaded", async function () {
         await resultadosportipo();
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
 
     async function resultadosportipo() {
         let args = [];
         let canalOrigen = _canalOrigen;
         codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
         tipoIdentificacion = "{{ Session::get('userData')->codigoTipoIdentificacion }}";
         tipoServicio = "LAB";
         numeroIdentificacion = "{{ Session::get('userData')->numeroIdentificacion }}";
 
                 
         args["endpoint"] = api_url + `/digitalestest/v1/examenes/resultadosPorTipo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&numeroIdentificacion=${numeroIdentificacion}&tipoIdentificacion=${tipoIdentificacion}&tipoServicio=${tipoServicio}`;
         args["method"] = "GET";
         args["showLoader"] = false;
         console.log(7,args["endpoint"]);
         const data = await call(args);
         console.log('data7', data.data.items);
 
         if (data.code == 200){
             if (data.data.items.length > 0){
                 $("#mensajeNoTienesResultadosRealizados").addClass("d-none");
                 let html = $("#resultadosIP");
                 html.empty();
                 let items = data.data.items;
                 let elemento = "";
 
                 items.forEach((resultados) => {
 
                     elemento += `<div class="col-12 col-md-6">
                                     <div class="card h-100">
                                         <div class="card-body p-3">
                                             <h6 class="text-primary-veris fw-bold fs--1 mb-1">${capitalizarElemento(resultados.nombreServicio)}</h6>
                                             <p class="text-primary-veris fw-bold fs--2 mb-1" id="nombreResultadoLab">${capitalizarElemento(resultados.nombreOrigenResultado)}</p>
                                             <p class="fw-bold fs--2 mb-1" id="ubicacion">${capitalizarElemento(resultados.nombreSucursal)}</p>
                                             <p class="fw-normal fs--2 mb-1">Realizado: <b class="fw-normal" id="fecha">${resultados.dia}</b></p>
                                             <div class="d-flex justify-content-between align-items-center mt-3">
                                                 <div class="avatar me-2">
                                                     <img src=${quitarComillas(resultados.iconoServicio)} alt="imagenes-procedimientos" class="rounded-circle border" style="background: #F1F8E2;">
                                                    
                                                         
                                                 </div>
                                                 <button onclick="detallesResultadosLaboratorio('${resultados.codigoOrdenApoyo}')"
                                                 type="button"  class="btn btn-sm btn-primary-veris verResultados" data-bs-toggle="modal" data-bs-target="#resultadImagenesProcedimientosModal">
                                                     Ver resultados
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>`;
                 });
                 html.append(elemento);
 
             } else {
                 $("#mensajeNoTienesResultadosRealizados").removeClass("d-none");
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
          args["showLoader"] = false;
          const data = await call(args);
          console.log('datad', data);
  
          // insertar datos en el modal
          if (data.code == 200){
             let items = data.data;
             
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
     
                 items.forEach((resultados) => {
     
                     elemento += `<div class="my-3">
                                     <p class="text-center fs-normal my-3">${capitalizarElemento(resultados.nombrePrestacion)}</p>
                                     <a href="${quitarComillas   (resultados.urlVisorWeb)}" class="btn btn-outline-primary-veris w-100" target="_blank">Ver imagen</a>
                                 </div>`;
                             });
     
                 elemento += `<div class="border-top">
                                 <a onclick="detallesResultadosLaboratorio('${codigoApoyo}')" href="${quitarComillas(data.data[0].urlVisorWeb)}"
                                 class="btn btn-primary-veris w-100 mt-3" target="_blank">Ver informe</a>
                             </div>`;
                 html.append(elemento);
     
             }        
      
              
          }
  
      }
 
 
     // consultar grupo familiar
     async function consultarGrupoFamiliar() {
         let args = [];
         canalOrigen = _canalOrigen
         codigoUsuario = "{{ Session::get('userData')->numeroIdentificacion }}";
         args["endpoint"] = api_url + `/digitales/v1/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}`
         args["method"] = "GET";
         args["showLoader"] = false;
         const data = await call(args);
         if(data.code == 200){
             familiar = data.data;
             mostrarListaPacientesFiltro();
 
         }
         return data;
     }
 
 
     // funciones js 
 
     // mostrar lista de pacientes
     function mostrarListaPacientesFiltro(){
 
         let data = familiar;
 
         let divContenedor = $('.listaPacientesFiltro');
         divContenedor.empty(); // Limpia el contenido actual
 
         let elementoYo = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                 <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="{{ Session::get('userData')->numeroPaciente }}" checked>
                                 <span class="text-veris fw-bold">
                                     ${capitalizarElemento("{{ Session::get('userData')->nombre }} {{ Session::get('userData')->primerApellido }} {{ Session::get('userData')->segundoApellido }}")}
                                     <small class="fs--3 d-block fw-normal text-body-secondary">Yo</small>
                                 </span>
                             </label>`;
         divContenedor.append(elementoYo);
 
         console.log('sss',data);
         data.forEach((Pacientes) => {
             let elemento = `<label class="list-group-item d-flex align-items-center gap-2 border rounded-3">
                                 <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadiosI" id="listGroupRadios1" value="${Pacientes.numeroPaciente}" esAdmin= ${Pacientes.esAdmin} unchecked>
                                 <span class="text-veris fw-bold">
                                     ${capitalizarElemento(Pacientes.primerNombre)} ${capitalizarElemento(Pacientes.primerApellido)} ${capitalizarElemento(Pacientes.segundoApellido)}
                                     <small class="fs--3 d-block fw-normal text-body-secondary">${capitalizarElemento(Pacientes.parentesco)}</small>
                                 </span>
                             </label>`;
             divContenedor.append(elemento);
 
         });
     }
 
 
 
 </script>
 
@endpush