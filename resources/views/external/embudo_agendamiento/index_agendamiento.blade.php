@extends('template.external')
@section('title')
    Citas - Veris
@endsection
@section('content')
@php
    $tokenCita = base64_encode(uniqid());
@endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-315657039"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-315657039');
        var callback = function () {
            if (typeof(url) != 'undefined') {
                window.location = url;
            }
        };
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '635192523705714');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=635192523705714&ev=PageView&noscript=1"
            /></noscript>
            <!-- End Facebook Pixel Code -->
    <script>
        const token = "{{ $accesToken }}";
        const tokenCita = "{{ $tokenCita }}";
        const environment_nuvei = '{{ \App\Models\Veris::ENVIRONMENT_NUVEI }}';
    </script>
    <!-- Dependencias adicionales -->
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/normalize.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/jquery.modal.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/hover.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/default.date.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/default.time.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/owlcarousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/owlcarousel/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external/embudo_agendamiento/css/style.css') }}">

    <script src="{{ asset('assets/external/embudo_agendamiento/js/modernizr-2.6.2.min.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/jquery.cookie-1.3.1.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/jquery.validate.js')}}"></script>
    {{-- <script src="{{ asset('assets/external/embudo_agendamiento/js/jquery.modal.js')}}"></script> --}}
    <script src="{{ asset('assets/external/embudo_agendamiento/js/jquery.steps.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/jquery.toast.min.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/additional-methods.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/datepicker.es.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/js/ruc_jquery_validator.min.js')}}"></script>
    <script src="{{ asset('assets/external/embudo_agendamiento/owlcarousel/owl.carousel.min.js')}}"></script>

    <div class="loader-box">
        <div class="loader"></div>
    </div>

    <div id="wizard">
        <h2>
            <i class="icon-step fas fa-server fa-fw"></i>
            <span class="title-span">Registrar Paciente</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <!-- <h1 class="title">Registrar Paciente</h1> -->
            <!-- <h4 class="subtitle">Ingresa el número de identificación del PACIENTE para proceder a reservar la cita. <br>Es importante que si la cita no es para ti, recuerdes ingresar la identificación de la persona que deseas reciba la consulta médica.</h4> -->
            <!-- <img class="" src="https://www.veris.com.ec/wp-content/themes/xstore/embudoMedpay/images/doctor-veris.png"> -->
            <h1 class="fs-title title-home"></h1>
            <h4 class="fs-subtitle">Registrar Paciente</h4>
            <div class="form-box d-lg-grid justify-content-lg-center">
                <div class="form-group">
                    <label>Tipo de identificación del Paciente</label>
                    <div class="box-input">
                        <i class="fas fas fa-user fa-fw"></i>
                        <select id="tipoIdentificacion" name="tipoIdentificacion" class="required"></select>
                        <div class="line"></div>
                        <div class="line-border"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Número de identificación del Paciente</label>
                    <div class="box-input">
                        <i class="fas fa-fingerprint fa-fw"></i>
                        <input type="number" id="numeroIdentificacion" name="numeroIdentificacion" class="required" autofocus value="">
                        <div class="line"></div>
                        <div class="line-border"></div>
                    </div>
                </div>
                <p class="url_registro">Si no tienes usuario Veris, <span onclick="mostrarModalRegistro()">regístrate aquí</span></p>
            </div>
            <div class="modal modal-registro-paciente fade" id="modal-registro-paciente" tabindex="-1" aria-labelledby="modal-registro-pacienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
                    <div class="modal-content">
                        <div class="modal-header d-block">
                            <h1 class="title mb-1">Registrar Nuevo Paciente</h1>
                            <h4 class="subtitle mb-1">Ingresa tus datos para registrarte en el sistema.</h4>
                        </div>
                        <div class="modal-body pt-0 pb-0">
                            <div class="form-registro d-flex">
                                <div class="input-field-container">
                                    <div class="form-group">
                                        <label>Número de identificación</label>
                                        <div class="box-input">
                                            <select id="tipoIdentificacionRegistro" name="tipoIdentificacionRegistro" class="required"></select>
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Número de identificación</label>
                                        <div class="box-input">
                                            <input type="number" id="numeroIdentificacionRegistro" name="numeroIdentificacionRegistro" class="required" autofocus>
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Primer Apellido</label>
                                        <div class="box-input">
                                            <input type="text" id="primerApellido" name="primerApellido" class="required">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Segundo Apellido</label>
                                        <div class="box-input">
                                            <input type="text" id="segundoApellido" name="segundoApellido" class="required">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Primer Nombre</label>
                                        <div class="box-input">
                                            <input type="text" id="primerNombre" name="primerNombre" class="required">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Segundo Nombre</label>
                                        <div class="box-input">
                                            <input type="text" id="segundoNombre" name="segundoNombre" class="required">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha de Nacimiento</label>
                                        <div class="box-input">
                                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="required">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-field-container">
                                    <div class="form-group">
                                        <label>Género</label>
                                        <div class="box-input">
                                            <select id="genero" name="genero" class="required">
                                                <option value="" disabled selected hidden>Seleccionar Género</option>
                                                <option value="F">Femenino</option>
                                                <option value="M">Masculino</option>
                                            </select>
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>País</label>
                                        <div class="box-input">
                                            <select id="paisRegistro" name="paisRegistro" class="required">
                                                <option value="" disabled selected hidden>Seleccionar país</option>
                                            </select>
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        <div class="box-input">
                                            <select id="provinciaRegistro" name="provinciaRegistro" class="required">
                                                <option value="" disabled selected hidden>Seleccionar provincia</option>
                                            </select>
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Ciudad</label>
                                        <div class="box-input">
                                            <select id="ciudadRegistro" name="ciudadRegistro" class="required">
                                                <option value="" disabled selected hidden>Seleccionar una ciudad</option>
                                            </select>
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="box-input">
                                            <input type="email" id="email" name="email" class="required">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <div class="box-input">
                                            <input type="tel" id="telefono" name="telefono" class="required" onkeypress="return validarNumero(event)" oninput="limitarCaracteres(this, 10)">
                                            <div class="line"></div>
                                            <div class="line-border"></div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-inside-modal btn-cancelar-registro" data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn-inside-modal btn-registrar">Registrarse</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <h2>
            <i class="icon-step fas fa-map-marker-alt fa-fw"></i>
            <span class="title-span">Ciudad</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <!-- <h1 class="title hidden-presencial">Presencial</h1> -->
            <!-- <h4 class="subtitle hidden-presencial">Elige la ciudad donde quieres agendar tu cita</h4> -->
            <h1 class="fs-title title-home"></h1>
            <h4 class="fs-subtitle ">Escoge la ciudad</h4>
            <div class="box-presencial control-group-ciudad control-group hidden-presencial d-lg-grid justify-content-lg-center"></div>
            <!-- <h1 class="title">Online</h1> -->
            <h4 class="fs-subtitle d-none tieneModalidadOnline">Online</h4>
            <div class="box-online control-group-ciudad control-group d-lg-grid justify-content-lg-center"></div>
            <div class="modal modal-convenio fade" id="modal-convenio" tabindex="-1" aria-labelledby="modal-registro-pacienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable mx-auto">
                    <div class="modal-content">
                        <div class="modal-header d-block">
                            <h1 class="title mb-1">¿Tienes seguro privado?</h1>
                            <h4 class="subtitle mb-1">Si eres paciente por primera vez y tu seguro médico no consta, por favor comunícate al 6009600.</h4>
                        </div>
                        <div class="modal-body pt-0 pb-0">
                            <div class="box-convenios">
                                <div class="form-box box-switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="tieneConvenio" checked>
                                        <label class="onoffswitch-label" for="tieneConvenio"></label>
                                    </div>
                                    <span id="switch">No/Si</span>
                                    <select class="select-convenio" id="convenios">
                                        <option>Elegir</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-inside-modal btn-continuar-convenio">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-motivo-online fade">
                <div class="header">
                    <h1 class="title">¿Cuál es el motivo de tu consulta?</h1>
                    <h4 class="subtitle">Con el fin de agilitar tu cita médica al momento de tu atención, nos gustaría conocer el motivo de tu visita.</h4>
                </div>
                <div class="content">
                    <textarea id="motivo"></textarea>
                    <p class="disclimer">*Te recordamos que esta es información es personal y confidencial que alimenta directamente nuestro sistema integral de Historia Clínica.</p>
                </div>
                <div class="footer">
                    <button class="btn-inside-modal btn-omitir">Omitir</button>
                    <button class="btn-inside-modal btn-guardar-motivo">Continuar</button>
                </div>
            </div>
        </section>
        <h2>
            <i class="icon-step fas fa-user-md fa-fw"></i>
            <span class="title-span">Especialidad</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <!-- <h1 class="title">Especialidad</h1> -->
            <!-- <h4 class="subtitle">Elige la especialidad que necesitas. Si la especialidad que buscas no está disponible, considera elegir Medicina General.</h4> -->
            <h1 class="tipo-cita fs-title text-lg-center mt-0"></h1>
            <h4 class="fs-subtitle text-lg-center mt-0 mb-2em">Escoge la especialidad</h4>
            <!-- <div class="box-search">
                <div class="form-group">
                    <label>Busca la especialidad que necesitas</label>
                    <div class="box-input box-input-fw">
                        <i class="fas fa-search fa-fw"></i>
                        <input type="text" id="buscarEspecialidad" name="buscarEspecialidad" placeholder="Busca la especialidad que necesitas">
                        <div class="line"></div>
                        <div class="line-border"></div>
                    </div>
                </div>
            </div> -->
            <div class="box-especialidades control-group-multiple control-group"></div>
            <div class="modal modal-pregunta-especialidad fade">
                <div class="modal-content">
                    <div class="header">
                        <h1 class="title">Información solicitada por tu aseguradora</h1>
                        <h4 class="subtitle">¿Esta cita es por control de <b>embarazo</b>?</h4>
                    </div>
                    <div class="content">
                        <div class="box-respuesta-pregunta-especialidad">
                            <div class="btn-continuar-especialidad" data-rel="S">SI</div>
                            <div class="btn-continuar-especialidad" data-rel="N">NO</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <h2>
            <i class="icon-step fa-solid fa-hospital fa-fw"></i>
            <span class="title-span">Central Médica</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <h1 class="tipo-cita fs-title text-lg-center mt-0"></h1>
            <h4 class="fs-subtitle text-lg-center mt-0 mb-2em">Escoge la central médica</h4>
            <div class="box-centrales control-group-multiple control-group"></div>
            <!-- <div class="advertisement">
                <i class="fa fa-info fa-fw" aria-hidden="true"></i>
                <p>HEMOS IMPLEMENTADO PARA TU COMODIDAD Y SEGURIDAD, 5 CENTRALES MÉDICAS NO COVID PARA LA ATENCIÓN DE TUS NIÑOS, CONTROL DE EMBARAZO Y ENFERMEDADES CRÓNICAS COMO HIPERTENSIÓN, DIABETES ENTRE OTRAS. EN GUAYAQUIL: MALL DEL SOL Y EL DORADO Y EN QUITO: SAN LUIS, GRANADOS Y QUICENTRO SUR.</p>
            </div> -->
        </section>
        <h2>
            <i class="icon-step fa-solid fa-calendar fa-fw"></i>
            <span class="title-span">Fecha y Hora</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <!-- <h1 class="title">Fecha Recomendada</h1> -->
            <!-- <h4 class="subtitle">Esta es la cita más próxima disponible. <b>Si la fecha no se ajusta a tus necesidades, da clic en "Cambiar fecha".</b></h4> -->
            <h1 class="tipo-cita fs-title text-lg-center mt-0"></h1>
            <h4 class="fs-subtitle text-lg-center mt-0 mb-2em">Escoge la fecha</h4>
            <div class="box-calendar">
                <div class="box-dia">17</div>
                <div class="box-mes">Enero</div>
                <div class="label-cambio-fecha">
                    CAMBIAR FECHA
                    <input id="fechaCita" name="fechaCita" type="text" placeholder="Cambiar Fecha" data-position="bottom left" data-language='es'>
                </div>
            </div>
            <h1 class="fs-subtitle">Especialistas disponibles</h1>
            <h4 class="subtitle">Ahora, selecciona el especialista y el horario que prefieres para tu cita.</h4>
            <div class="box-disponibilidad"></div>
            <div class="modal modal-validacion-fecha fade">
                <div class="modal-content">
                    <div class="header">
                        <h1 class="title" style="text-align: center;">Información de tu seguro</h1>
                        <h4 class="subtitle" style="text-align: center;"></h4>
                    </div>
                    <div class="footer">
                        <button class="btn-inside-modal btn-entendido-validacion-fecha">Entiendo</button>
                    </div>
                </div>
            </div>
        </section>
        <h2>
            <i class="icon-step fa-solid fa-calendar-check fa-fw"></i>
            <span class="title-span">Confirmación de datos</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <div class="box-infor-data" style="display: none;">
                <h1 class="tipo-cita fs-title text-lg-center mt-0"></h1>
                <div class="grid-container">
                    <!-- Revisar tus datos -->
                    <div class="grid-item">
                        
                        <h1 class="fs-title-blue">Revisa tus datos</h1>
                        <!-- <h4 class="subtitle">Revisa que los datos a continuación están correctos y genera la reserva dando clic en el botón “Reservar Cita”.</h4> -->
                        <div class="box-info-cita" style="width: 19rem;">
                            <div class="item-cita">
                                <!-- <h5>Especialidad:</h5> -->
                                <p class="txt-info txt-info-especialidad"></p>
                            </div>
                            <div class="item-cita">
                                <!-- <h5>Fecha:</h5> -->
                                <p class="txt-info txt-info-fecha "></p>
                                <p class="txt-info txt-info-hora "></p>
                            </div>
                            <div class="item-cita">
                                <!-- <h5>Hora:</h5> -->
                                <!-- <p class="txt-info txt-info-hora "></p> -->
                            </div>
                            <div class="item-cita">
                                <!-- <h5>Central Médica:</h5> -->
                                <p class="txt-info txt-info-central"></p>
                            </div>
                            <div class="item-cita">
                                <!-- <h5>Profesional Médico:</h5> -->
                                <p class="txt-info txt-info-doctor "></p>
                            </div>
                            <div class="item-cita">
                                <!-- <h5>Convenio:</h5> -->
                                <p class="txt-info txt-info-convenio"></p>
                            </div>
                            <!-- <div class="item-cita">
                                <h5>Ciudad:</h5>
                                <p class="txt-info txt-info-ciudad "></p>
                            </div> -->
                        </div>
                        
                    </div>
                    
                    <!-- Precio -->
                    <div class="grid-item">
                        <h1 class="fs-title-blue">Precio</h1>
                        <!-- <h3 class="subtitle descuento box-descuento-virtual" style="max-width: unset;margin-left: unset;">Realiza el pago de tu servicio por este medio y recibe el <span id="descuento"></span>% de descuento.</h3> -->
                        <!-- <h4 class="subtitle">¡Ojo! Recuerda que tu cita no está completa hasta que no des clic en “Reservar Cita”.</h4> -->
                        <div class="card-price" style="width: 19rem;">
                            <div class="discount-rate">
                                <p class="discount txt_descuento"><!-- 30% --></p>
                                <p class="text-discount"><!-- por el horario que elegiste --></p>
                            </div>
                            <div class="total-price">
                                <p class="text-subtotal txt_sub">Precio normal <del class="precio-subtotal"></del></p>
                                <div class="box-precio txt_price">
                                    <!-- <i class='fa fa-usd fa-fw' aria-hidden='true'></i> -->
                                </div>
                            </div>
                        </div>
                        <div class="box-msj-info msg-info-valorizar msg-reagendar">
                            <div class="d-flex align-items-center ">
                                <i class="fas fa-info-circle fs-24 me-4"></i>
                                <p class="text-info">Puedes <strong>reagendar</strong> tu cita las veces que necesites.</p>
                            </div>
                            <!-- <div class="msg_dscto">¡Esta cita tiene un descuento por el horario que seleccionaste!</div> -->
                        </div>
                        <div class="msg-info-valorizar msg-no-cambio">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fs-24 me-4"></i>
                                <p class="text-info">Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.</p>
                            </div>
                        </div>
                        <div class="msg-info-valorizar msg-aviso-conexion">
                            <div class="d-flex align-items-center ">
                                <i class="fas fa-info-circle fs-24 me-4"></i>
                                <p class="text-info">Recuerda que para poder conectarte a tu cita <strong>debes pagarla en los próximos 30 minutos.</strong></p>
                            </div>
                        </div>
                        <div class="msg-info-valorizar msg-aviso-no-permite-pago">
                            <div class="d-flex align-items-center ">
                                <i class="fas fa-info-circle fs-24 me-4"></i>
                                <p class="text-info"><strong>Recuerda</strong> llegar <strong>20 minutos antes</strong> de la cita y acercarte a caja para realizar el pago.</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="grid-item">
                        <div class="msg-info-valorizar msg-no-cambio">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fs-24 me-4"></i>
                                <p class="text-info">Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.</p>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="grid-item">
                        <div class="msg-info-valorizar msg-aviso-conexion">
                            <div class="d-flex align-items-center ">
                                <i class="fas fa-info-circle fs-24 me-4"></i>
                                <p class="text-info">Recuerda que para poder conectarte a tu cita <strong>debes pagarla en los próximos 30 minutos.</strong></p>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="msg-info-valorizar text-info-llegada"><p class="text-info">Recuerda llegar <strong>15 minutos</strong> antes y acercarte a <strong>caja</strong> para activar tu cita.</p></div>
            </div>

            <div class="modal modal-precio-confirmacion-datos">
                <div class="modal-content">
                    <div class="header">
                        <h1 class="title" style="text-align: center;">Información de tu seguro</h1>
                        <h4 class="subtitle" style="text-align: center;"></h4>
                    </div>
                    <div class="footer">
                        <button class="btn-inside-modal btn-precio-confirmacion-datos">Entiendo</button>
                    </div>
                </div>
            </div>

            <div class="modal modal-validacion-condiciones-seguro fade">
                <div class="modal-content">
                    <div class="header">
                        <h1 class="title" style="text-align: center;">Información de tu seguro</h1>
                        <h4 class="subtitle" style="text-align: center;"></h4>
                    </div>
                    <div class="footer">
                        <button class="btn-inside-modal btn-validacion-servicio" onclick="reloadPage()">Volver a Inicio</button>
                    </div>
                </div>
            </div>

            <div class="box-info-vue" style="display: none;">
                <h2 class="text-start text-vivid m-0">Urgencias ambulatorias</h2>
                <h4 class="text-start mt-0 mb-4">Cuando lo que tienes no puede esperar.</h4>
                <div class="box-symptom">
                    <img src="https://www.veris.com.ec/wp-content/themes/xstore/embudoMedpay/images/gynecology-consultation-pana.svg" alt="">
                    <div class="wrapper">
                        <div class="carousel owl-carousel owl-symptom" id="owl-symptom">
                            <div class="item" style="width:100px"><p class="symptom-0"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-1"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-2"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-3"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-4"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-5"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-6"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-7"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-8"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-9"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-10"></p></div>
                            <div class="item" style="width:100px"><p class="symptom-11"></p></div>
                        </div>
                    </div>
                    <div class="col-12 box-check">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="nombreTipoObjetoCheck" id="nombreTipoObjetoCheck" required>
                            <label class="form-check-label" for="invalidCheck">
                                Confirmo que tengo un caso de atención inmediata
                            </label>
                            <div class="invalid-feedback">
                                Confirma tu caso de atención inmediata.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <h2>
            <!--i class="icon-step fas fa-money-check-alt fa-fw"></i-->
            <i class="icon-step fa fa-credit-card fa-fw"></i>
            <span class="title-span">Pago</span>
            <i class="icon-status far fa-circle fa-fw"></i>
            <!--i class="far fa-check-circle fa-fw fa-3x"></i-->
        </h2>
        <section>
            <h3 class="title title-confirmacion titulo-pasarela" style="text-align: center;">Cita agendada</h3>
            <h5 class="msg-after-excento"></h5>
            <div class="box-finalizar-flow" style="text-align: center;">
                <a href="https://www.veris.com.ec/" class="" style="background: #0071CE !important;border-radius: 4px !important;color: #fff !important;padding: 8px 16px;text-align: center;margin: 0 auto !important;">Finalizar</a>
            </div>
            <div class="box-finalizar-Vue" style="text-align: center;">
                <a href="https://goo.gl/maps/zNm85ntveZi4DZNd8" target="_blank" class="" style="background: #0071CE !important;border-radius: 4px !important;color: #fff !important;padding: 8px 16px;text-align: center;margin: 0 auto !important; text-decoration: none;">Cómo llegar</a>
            </div>
            <div class="" id="box-pasarela-embudo">
                <div class="grid-container">
                    <div class="grid-item w-sm-17 w-lg-25">
                        <!-- Detalle del servicio -->
                        <div class="col-12 mb-4">
                            <details class="shadow-bg border-radius-8">   <!-- open -->
                                <summary class="py-3 px-4">
                                    <div class="titulo-content d-flex">
                                        <span class="bola mr-3">1</span>
                                        <div class="texto-titulo">Detalle del servicio</div>
                                    </div>
                                </summary>
                                <div class="border-button-8">
                                    <table class="table bg-fondo-1 w-100 table-datos-facturacion">
                                        <tbody>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-1"><p class="fs-14">Paciente</p></td>
                                                <td class="px-4 py-1 bg-fondo-1" ><p id="nombreDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-2"><p class="fs-14">Consulta</p></td>
                                                <td class="px-4 py-1 bg-fondo-2" ><p id="consultaDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-2"><p class="fs-14">Profesional</p></td>
                                                <td class="px-4 py-1 bg-fondo-2" ><p id="medicoDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-2"><p class="fs-14">Centra Médica</p></td>
                                                <td class="px-4 py-1 bg-fondo-2" ><p id="centralDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-2"><p class="fs-14">Fecha/Hora</p></td>
                                                <td class="px-4 py-1 bg-fondo-2" ><p id="fechaDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-2"><p class="fs-14">Valor</p></td>
                                                <td class="px-4 py-1 bg-fondo-2" ><p id="valorDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-1 bg-fondo-1"><p class="fs-14">Valor final</p></td>
                                                <td class="px-4 py-1 bg-fondo-1" ><p id="valorTotalDeta" class="fs-12 m-0"></p></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </details>
                        </div>
                        <div class="col-12 mb-4 box-facturacion-validation">
                            <!-- Datos de facturación -->
                            <details open class="shadow-bg border-radius-8">
                                <summary class="py-3 px-4">
                                    <div class="titulo-content d-flex">
                                        <span class="bola mr-3">2</span>
                                        <div class="texto-titulo">Datos de facturación</div>
                                    </div>
                                </summary>
                                <div class="card-body px-4 py-2 bg-fondo-2 border-button-8">
                                    <div class="row ">
                                        <input form="kushki-pay-form" type="hidden" name="idPreTransaccion" id="idPreTransaccion">
                                        <div class="col-12 mb-3">
                                            <label for="tipoIdentificacionFact" class="form-label"><small>Tipo de identificaci&oacute;n <span class="text-danger">*</span></small></label>
                                            <select name="tipoIdentificacionFact" id="tipoIdentificacionFact" class="form-select form-select-sm animated-input" form="kushki-pay-form">
                                                <option value="2">C&eacute;dula</option>
                                                <option value="1">Ruc</option>
                                            </select>
                                            <!-- <div class="invalid-feedback msg-error-tipoIdentificacionFact">Número incorrecto</div> -->
                                        </div>
                                        <!-- Numero Identificacion -->
                                        <div class="col-12 numeroIdentificacionFact mb-3">
                                            <label for="numeroIdentificacionFact" class="form-label"><small>Identificaci&oacute;n <span class="text-danger">*</span></small></label>
                                            <input type="text" class="form-control form-control-sm animated-input" name="numeroIdentificacionFact" id="numeroIdentificacionFact" form="kushki-pay-form"/>
                                            <div class="invalid-feedback msg-error-numeroIdentificacionFact">Número incorrecto</div>
                                        </div>
                                        <!-- Nombres -->
                                        <div class="col-12 mb-3">
                                            <label for="primerNombreFact" class="form-label name-label text-blue-dark fw-bold"><small>Nombres <span class="text-danger">*</span></small></label>
                                            <input type="text" class="form-control form-control-sm animated-input" name="primerNombreFact" id="primerNombreFact" form="kushki-pay-form"/>
                                            <div class="invalid-feedback msg-error-primerNombreFact">Campo requerido</div>
                                        </div>
                                        <!-- P. Apellido -->
                                        <div class="col-12 elem-no-ruc mb-3">
                                            <label for="primerApellidoFact" class="form-label"><small>Primer Apellido <span class="text-danger">*</span></small></label>
                                            <input type="text" class="form-control form-control-sm animated-input" name="primerApellidoFact" id="primerApellidoFact" form="kushki-pay-form"/>
                                            <div class="invalid-feedback msg-error-primerApellidoFact">Campo requerido</div>
                                        </div>
                                        <!-- S. Apellido -->
                                        <div class="col-12 elem-no-ruc mb-3">
                                            <label for="segundoApellidoFact" class="form-label"><small>Segundo Apellido <span class="text-danger">*</span></small></label>
                                            <input type="text" class="form-control form-control-sm animated-input" name="segundoApellidoFact" id="segundoApellidoFact" form="kushki-pay-form"/>
                                            <div class="invalid-feedback msg-error-segundoApellidoFact">Campo requerido</div>
                                        </div>
                                        <!-- Direccion -->
                                        <div class="col-12 mb-3">
                                            <label for="direccionFact" class="form-label"><small>Direcci&oacute;n Cliente <span class="text-danger">*</span></small></label>
                                            <input type="text" class="form-control form-control-sm animated-input" name="direccionFact" id="direccionFact" form="kushki-pay-form"/>
                                            <div class="invalid-feedback msg-error-direccionFact">Campo requerido</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="mailFact" class="form-label"><small>Email <span class="text-danger">*</span></small></label>
                                            <input type="email" class="form-control form-control-sm animated-input" name="mailFact" id="mailFact" form="kushki-pay-form"/>
                                            <div class="invalid-feedback msg-error-mailFact">Campo requerido</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="telefonoFact" class="form-label"><small>Tel&eacute;fono <span class="text-danger">*</span></small></label>
                                            <input type="text" class="form-control form-control-sm animated-input" name="telefonoFact" id="telefonoFact" form="kushki-pay-form" />
                                            <div class="invalid-feedback msg-error-telefonoFact">Campo requerido</div>
                                        </div>
                                    </div>
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Agendamiento y pago -->
                    <div class="grid-item w-sm-17 w-lg-25">
                        <div class="col-md-12 mb-6">
                            <details open class="shadow-bg border-radius-8">
                                <summary class="py-3 px-4">
                                    <div class="titulo-content d-flex">
                                        <span class="bola mr-3">3</span>
                                        <div class="texto-titulo">Agendamiento y pago</div>
                                    </div>
                                </summary>
                                <!-- <div class=""> -->
                                    <div class="px-4 py-2 bg-fondo-2 border-button-8">
                                        <div class="box-nuvei">
                                            <div>
                                                <img src="https://www.veris.com.ec/wp-content/themes/xstore/embudoMedpay/images/svg/all-cards.svg" style="width: 100%;margin-bottom: 15px;margin-top: 10px;">
                                            </div>
                                            <div class="info-pago-nuvei">
                                                Total a pagar: <span class="total-pago-nuvei"></span>
                                            </div>
                                            <button id="btnNuvei">Pagar</button>
                                        </div>
                                        <div class="box-no-nuvei">
                                            <p class="mt-0 mb-2 fs-12 title-formaPago">Si deseas pagar con <strong>Diners Club</strong> o <strong>Discover</strong></p>
                                            <button class="text-bg-blue fs-14 btn-cambiar-ptp" type="button">Click aquí</button>
                                            <button class="text-bg-blue fs-14 btn-cambiar-kushki" type="button">Click aquí</button>
                                            <!-- Pago Kushki & PTP -->
                                            <div class="box-Pago my-3">

                                                <!-- Kushki -->
                                                <div class="box-kushki">
                                                    <input type="hidden" class="form-control form-control-sm animated-input" name="codigoReserva" id="codigoReserva" form="kushki-pay-form"/>
                                                    <form class="kushki-pay-form" id="kushki-pay-form" action="/external/payment/kushki/procesar/{{ $tokenCita }}" method="POST">
                                                        @csrf
                                                    </form>
                                                    <input type="hidden" name="tokenCita" id="tokenCita" form="kushki-pay-form">
                                                    <input type="hidden" name="dataCita" id="dataCita" form="kushki-pay-form">
                                                </div>

                                                <!-- PTP -->
                                                <div class="box-PTP">
                                                    <form class="" id="p2p-pay-form" action="" method="POST">
                                                        <div class="img-placetopay text-center mb-4">
                                                        </div>
                                                        <div class="total-pay">
                                                            <h5 class="text-center my-4">Total: <b class="amountPTPTotal" id="amountPTPTotal"></b></h5>
                                                        </div>
                                                        <div class="text-center mb-4 px-5">
                                                            <button type="button" onclick="pagarPtp();" class="btn-pago-online w-100" disabled>Pagar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>  
                                        <!-- Terminos y condiciones -->
                                        <div class="form-check my-4">
                                            <input class="form-check-input mx-auto" type="checkbox" id="terminos" checked style="display: inline-block;vertical-align: top;">
                                            <label class="form-check-label f-xs text-blue" for="terminos" style="display: inline-block;width: 90%;vertical-align: middle;margin-left: 5px;">
                                                Acepto <a href="/terminos-y-condiciones" target="_blank" class="text-decoration-none text-blue fw-bold">T&eacute;rminos y condiciones</a> <span id="ppd" style="font-weight: normal;"></span>
                                            </label>
                                            <div class="invalid-feedback msg-error-terminos">Debe aceptar términos y condiciones</div>
                                            <input form="kushki-pay-form" type="hidden" name="ajustarPPD" id="ajustarPPD" value="N">
                                            <input form="kushki-pay-form" type="hidden" name="versionPPD" id="versionPPD">
                                            <input form="kushki-pay-form" type="hidden" name="numeroIdentificacionPPD" id="numeroIdentificacionPPD">
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </details>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>

    <link href="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.paymentez.com/ccapi/sdk/payment_checkout_stable.min.js" charset="UTF-8"></script>
    {{-- <script>var path_embudo = "<?php echo getUrlSite() ?>/wp-content/themes/xstore/embudoMedpay/"; </script> --}}
    <script src="{{ asset('assets/external/embudo_agendamiento/js/index.js?v=1.0.0')}}"></script>

    <style>
            .box-no-nuvei{
                display: none;
            }
            .btnConfirmar-dis {
                pointer-events: none;
                filter: grayscale(0.8);
            }

            .box-terminos-exc {
                width: 235px;
                font-size: 12px;
                position: absolute;
                bottom: 100px;
                left: 0;
                right: 0;
                margin: auto;
            }
            #box-pasarela-embudo{
                display: none;
            }
            .citapresencial{
                display: block;
                margin: 0 auto;
            }
            .titulo-pasarela img{
                display: block;
                margin: 0 auto;
            }
            .msg-info-valorizar{    
                display: none;
            }
            .btn-finalizar-flow{
                text-decoration: none;
            }
            .box-finalizar-flow{
                display: none;
                margin: 50px;
            }
            .btn-finalizar-flow {
                background: #0071ce;
                border: 0;
                color: #fff;
                padding: 8px 16px;
                border-radius: 4px;
                width: 100px;
                /* display: none; */
                margin: 20px auto 0;
            }
            /*.img-excento {
              display: none;
            }*/
            .msg-after-excento{
                margin: 20px auto;
                text-align: center;
                font-size: 14px;
                line-height: 16px;
                font-weight: 300;
            }
            .title.title-confirmacion.titulo-pasarela{
                text-transform: lowercase;
            }
            .title.title-confirmacion.titulo-pasarela::first-letter{
                text-transform: capitalize;
            }
            /* .text-info */
            .txt-info-doctor {
                text-transform: capitalize;
            }
            .txt-info-doctor span {
                text-transform: initial;
                color: inherit !important;
                font-weight: inherit !important;
            }
            .loader-input-center {
                color: var(--bg-blue);
                position: absolute;
                clear: both;
                left: 0;
                right: 0;
                top: 100px;
                margin: auto;
                width: 40px;
                height: 40px;
            }
            .warning_input{
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                outline: none;
                border: 1px solid #e83442;
                border-radius: 3px;
                /* z-index: 999; */
                position: relative;
                background-color: #efd0ce;
            }
            .invalid-feedback{
                display: none;
            }
            .box-PTP{
                display:none;
            }
            .is-invalid-form{
                pointer-events: none;
                opacity: 0.5;
            }
        </style>
        <script>
       
        jQuery(document).ready(function() {

            jQuery('body').on('keypress','#numeroIdentificacionFact',function (evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            });

            /*Captura el cambio de tipo de identificación*/
            jQuery('body').on('change', '#tipoIdentificacionFact', function() { 
                console.log('test');
                jQuery('.nuiRuc_invalid').remove();
                if (jQuery(this).val() == "1") {
                    jQuery('.elem-no-ruc input').attr("required", false);
                    jQuery(".elem-no-ruc").hide();
                    jQuery('.name-label').html('<small>Razón Social <span class="text-danger">*</span></small>');
                } else {
                    jQuery('.elem-no-ruc input').attr("required", true);
                    jQuery('.name-label').html('<small>Nombres <span class="text-danger">*</span></small>');
                    jQuery(".elem-no-ruc").show();    
                }    
            });

            jQuery('body').on('change','input, select',function(){
                isCompleteBill();
            });

            jQuery('body').on('click','.btn-pago-online, select',function(){
                jQuery('.btn-pago-online').addClass('disabled');
            });

            jQuery('body').on('click', '.btn-cambiar-ptp', function () {
               jQuery('.box-kushki').hide();
               jQuery('.box-PTP').show();
               jQuery('.title-formaPago').html('Si deseas regresar');
               jQuery('.btn-cambiar-kushki').show();
               jQuery('.btn-cambiar-ptp').hide();
            });

            jQuery('body').on('click', '.box-kushki', function () {
                console.log(9);
                isCompleteBill();
            });

            jQuery('body').on('click', '.btn-cambiar-kushki', function () {
               jQuery('.box-kushki').show();
               jQuery('.box-PTP').hide();
               jQuery('.btn-cambiar-kushki').hide();
               jQuery('.title-formaPago').html('Si deseas pagar con <strong>Diners Club</strong> o <strong>Discover</strong>');
               jQuery('.btn-cambiar-ptp').show();
            });

            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms, 2 seconds for example

            //on keyup, start the countdown
            jQuery('body').on('keyup','input',function(){
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            //on keydown, clear the countdown 
            jQuery('body').on('keydown','input',function(){
                clearTimeout(typingTimer);
            });

            //user is "finished typing," do something
            function doneTyping () {
                isCompleteBill();
            }

            document.addEventListener("keydown", KeyCheck);  //or however you are calling your method
            function KeyCheck(event){
                var KeyID = event.keyCode;
                switch(KeyID)
                {
                    case 8:
                    // alert("backspace");
                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                      document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');
                    document.querySelector('#btnNuvei').classList.add('is-invalid-form');
                    break; 
                    case 46:
                    // alert("delete");
                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                      document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');
                    document.querySelector('#btnNuvei').classList.add('is-invalid-form');
                    break;
                    default:
                    break;
                }
            }

            $('#owl-symptom').owlCarousel({
                /* margin:10, */
                loop:true,
                autoWidth:true,
                autoplay: true,
                autoplayTimeout: 5000, /* 5000 ms = 5s */
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true   // nav:true
                    },
                    600:{
                        items:3,
                        nav:true   // nav:true
                    },
                    1000:{
                        items:4,
                        nav:true, // nav:true
                    }
                }
            });
                        
        });

        function isCompleteBill(){
            var active_form = true;
            var elemIsValid = true;
            jQuery.each(jQuery('.box-facturacion-validation input, .box-facturacion-validation select'), function(){
                var idElem = jQuery(this).attr('id');
                if(jQuery("#"+idElem).is(":visible")){
                    switch(idElem){
                        case 'terminos':
                            if(!jQuery("#"+idElem).is(':checked')){
                                active_form = false;
                                elemIsValid = false;
                                jQuery("#"+idElem).addClass('warning_input');
                            }else{
                                jQuery("#"+idElem).removeClass('warning_input');
                            }
                        break;
                        case 'tipoIdentificacionFact':
                            if(jQuery("#"+idElem+" option:selected").val() == ''){
                                active_form = false;
                                elemIsValid = false;
                                jQuery("#"+idElem).addClass('warning_input');
                            }else{
                                jQuery("#"+idElem).removeClass('warning_input');
                            }
                        break;
                        case 'numeroIdentificacionFact':
                            console.log(active_form);
                            var tipoIdentificacionFact = jQuery('#tipoIdentificacionFact').val();
                            if(tipoIdentificacionFact == 1){
                                console.log(1);
                                active_form = validarRuc(jQuery("#"+idElem).val());
                            }else{
                                console.log(2);
                                active_form = validarCedula(jQuery("#"+idElem).val());
                            }
                            if(active_form){
                                jQuery("#"+idElem).removeClass('warning_input');
                            }else{
                                elemIsValid = false;
                                jQuery("#"+idElem).addClass('warning_input');
                            }
                            console.log(active_form);
                        break;
                        case "mailFact":
                            active_form = validarEmail(jQuery("#"+idElem).val());
                            if(active_form){
                                jQuery("#"+idElem).removeClass('warning_input');
                            }else{
                                elemIsValid = false;
                                jQuery("#"+idElem).addClass('warning_input');
                            }
                        break;
                        default:
                            if( jQuery("#"+idElem).val() == "" || jQuery("#"+idElem).val().trim() == "" ) {
                                active_form = false;
                                elemIsValid = false;
                                jQuery("#"+idElem).addClass('warning_input');
                                // jQuery('.msg-error-'+idElem).show();
                            }else{
                                jQuery("#"+idElem).removeClass('warning_input');
                                jQuery('.msg-field-'+idElem).hide();
                                jQuery('.msg-error-'+idElem).hide();
                                jQuery('.msg-error-'+idElem).empty();
                                jQuery('.msg-error-terminos').empty();
                                jQuery('.msg-error-mailFact').empty();
                            }
                        break;
                    }
                    if(elemIsValid){
                        console.log('VALIDO');
                        jQuery(".msg-error-"+idElem).hide();
                        document.querySelector('#kushki-pay-form').classList.remove('is-invalid-form');
                        document.querySelector('#btnNuvei').classList.remove('is-invalid-form');
                        
                    }else{
                      jQuery(".msg-error-"+idElem).show();
                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                      document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');
                      document.querySelector('#btnNuvei').classList.add('is-invalid-form');
                    }
                }
            });

            if(elemIsValid){
                //window.onbeforeunload = null;
                //AQUI MIGUEL: Activas el boton de pagar ptp (le quitas el disabled)
                $('.btn-pago-online').attr('disabled', false);
                document.querySelector('#kushki-pay-form').classList.remove('is-invalid-form');
                document.querySelector('#btnNuvei').classList.remove('is-invalid-form');
            }else{
                //AQUI MIGUEL: Desactivas el boton de pagar ptp (le agregas el disabled)
                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                    document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                      document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');

                document.querySelector('#kushki-pay-form').classList.add('is-invalid-form');
                document.querySelector('#btnNuvei').classList.add('is-invalid-form');
                $('.btn-pago-online').attr('disabled', true);
                //  window.onbeforeunload = function() {
                //  console.log(9);
                //  return 'Recuerda que para agendar tu cita debes pagarla. Si abandonas esta sección no se agendará.';
                // }
            }
        }
        
        /* Ejecuta la validacion de Ruc & Cedula
        *  Segun el caso
        */
        /*jQuery("body").on("click",".btn-pago-online", function() {
            jQuery('.btn-pago-online').addClass('btn-pago-online');
            let tipoIdentificacionFact = jQuery("#tipoIdentificacionFact").val();
            let numeroIdentificacionFact = jQuery('#numeroIdentificacionFact').val();
            
            switch(tipoIdentificacionFact){
                case '2'://CEDULA
                    var esCorrecta = validarCedula(numeroIdentificacionFact);
                    if(esCorrecta){
                        jQuery('.nuiRuc_invalid').remove();
                    }else{
                        jQuery('.nuiRuc_invalid').remove();
                        jQuery('.numeroIdentificacionFact').append('<div class="nuiRuc_invalid"> Cédula inválida. </div>');
                    }
                    return esCorrecta;
                break;
                case '1'://RUC
                    var esCorrecta = validarRuc(numeroIdentificacionFact);
                    if(esCorrecta){
                        jQuery('.nuiRuc_invalid').remove();
                    }else{
                        jQuery('.nuiRuc_invalid').remove();
                        jQuery('.numeroIdentificacionFact').append('<div class="nuiRuc_invalid"> RUC inválido. </div>');
                    }
                    return esCorrecta;
                break;
                default:
                    return true;
                break;
            }
        });*/

        /* Validar Ruc */
        function validarRuc(ruc) {
            var last3 = ruc.substr(ruc.length - 3);
            if (ruc.length == 13 && last3 == "001") {
                return true;
            } else {
                return false;
            }
        }

        /* Validar Cedula */
        function validarCedula(cedula) {
            var cad = cedula.trim();
            var total = 0;
            var longitud = cad.length;
            var longcheck = longitud - 1;

            if (cad !== "" && longitud === 10) {
                for (i = 0; i < longcheck; i++) {
                    if (i % 2 === 0) {
                        var aux = cad.charAt(i) * 2;
                        if (aux > 9) aux -= 9;
                        total += aux;
                    } else {
                        total += parseInt(cad.charAt(i)); // parseInt o concatenarÃ¡ en lugar de sumar
                    }
                }

                total = total % 10 ? 10 - total % 10 : 0;

                if (cad.charAt(longitud - 1) == total) {
                    //document.getElementById("salida").innerHTML = ("Cedula VÃ¡lida");
                    return true;
                } else {
                    //document.getElementById("salida").innerHTML = ("Cedula InvÃ¡lida");
                    return false;
                }
            }

            return false;
        }

        // Validation Email
        function validarEmail(email) {
            var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return EmailRegex.test(email);
        }

        let politics = [];
        function getPolitics(){
            var settings = {
                "url": url_services_phantomx+"/politicas/usuarios/"+$('#numeroIdentificacion').val()+"?codigoEmpresa=1&plataforma=WEB&version=7.0.1",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Accept-Language": "es_EC"
                },
            };

            $.ajax(settings).done(function (response) {
                politics = response;
                console.log(response);
                if(response.code == 200){
                    if( response.data.estadoPoliticas == "N" || response.data.estadoPoliticas == null ){
                        console.log(response.data);
                        $('#ajustarPPD').val("S");
                        $('#versionPPD').val(response.data.ultimaVersionPoliticas);
                        $('#numeroIdentificacionPPD').val($('#numeroIdentificacion').val());
                        $('#ppd').html(`y <a href="${response.data.linkPoliticaPrivacidad}" target="_blank" class="text-decoration-none text-blue fw-bold">${response.data.leyendaPoliticas}</a>`);
                        $('#terminos').css("vertical-align","middle");
                    }else{
                        $('#ajustarPPD').val("N");
                        $('#versionPPD').val("");
                        $('#ppd').html('');
                        $('#numeroIdentificacionPPD').val("");
                        $('#terminos').css("vertical-align","top");
                    }
                }
            });
        }

        function updatePolitics(){
            var settings = {
            "url": url_services_phantomx+"/politicas/usuarios/"+$('#numeroIdentificacion').val(),
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
              },
            "data": JSON.stringify({
                "numeroIdentificacion": $('#numeroIdentificacion').val(),
                    "aceptaPoliticas": $('#terminos').prop('checked'),
                    "versionPoliticas": politics.data.ultimaVersionPoliticas,
                    "codigoEmpresa": 1,
                    "plataforma": "WEB",
                    "versionPlataforma": "7.0.1",
                    "canalOrigen": "VER_CMV",
                    "tipoEvento": "CR" //Opcional
                })
            };

            $.ajax(settings).done(function (response) {
                //let response = JSON.parse(res);
                console.log(response);
            });
    }
    </script>
    <style>
        .disabled-input{
          opacity: 0.5;
          pointer-events: none;
        }
        .btn-nuvei{
            background: #1068b1;
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: navajowhite;
            color: #fff;
        }
        .btn-nuvei:hover{
            opacity: 0.8;
        }
        .box-nuvei {
            font-size: 0px;
            width: 100%;
            /*background: #fff;*/
            border-radius: 7px;
        }

        .box-nuvei > div {
            display: inline-block;
            vertical-align: top;
            width: 100%;
/*          margin: 3%;*/
        }

        .box-nuvei > div > img {
            width: 46%;
            margin-right: 4%;
        }

        .box-nuvei > button {
            display: inline-block;
            font-size: 15px;
            color: #fff;
            background: #0071CE;
            border: none;
            padding: 5%;
            border-radius: 6px;
            font-weight: 700;
            width: 100%;
            margin-bottom: 20px;
        }
        .box-nuvei button:hover {
            opacity: 0.8;
        }
        .info-pago-nuvei {
            display: block !important;
            width: 94% !important;
            color: #0071CE !important;
            background: #fff;
            padding: 3%;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);
            -webkit-box-shadow: 0px 0px 5px 0px rgb(0 0 0 / 10%);
            -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);
            margin: 0px !important;
            margin-bottom: 10px !important;
        }

        .info-pago-nuvei span {
            float: right;
            display: block;
        }

        /*Modal pregunta*/
        .box-respuesta-pregunta-especialidad div {
            width: calc( 40% - 10px );
            max-width: 150px;
            min-width: 100px;
            border: 2px solid #0071CE;
            border-radius: 10px;
            margin: 15px 5px;
            padding: 10px 15px;
            font-size: 25px;
            text-align: center;
            display: inline-block;
            cursor: pointer;
        }

        .box-respuesta-pregunta-especialidad {
            text-align: center;
            font-size: 0px;
        }

        .box-respuesta-pregunta-especialidad div:hover {
            background: #0071CE;
            color: #fff;
        }

        .modal-pregunta-especialidad .title {
            color: var(--bg-blue-dark);
            font-size: 24px;
            -webkit-text-fill-color: inherit;
        }

        .modal-pregunta-especialidad {
            max-width: 350px;
            text-align: center
        }

        .modal-pregunta-especialidad .subtitle {
            font-size: 16px !important;
        }
        .respuesta-seleccionada{
            background: #0071CE;
            color: #fff;
        }
        .modal-validacion-fecha, .modal-precio-confirmacion-datos, .modal-validacion-condiciones-seguro {
            max-width: 400px;
        }

        .btn-entendido-validacion-fecha, .btn-precio-confirmacion-datos, .btn-validacion-servicio {
            color: #fff;
            width: 100%;
            background: var(--bg-blue);
            margin: 0;
            font-size: 18px;
            padding: 10px;
        }

        .text-veris {
            color: var(--bg-blue);
        }
    </style>
@endsection