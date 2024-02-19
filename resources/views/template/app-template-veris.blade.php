<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('../../assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    
        
    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.svg') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    @stack('css')
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script>
        const api_url = "https://api-phantomx.veris.com.ec"; 
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script> 
</head>

<body>
    <!-- Layout wrapper -->
    
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('template.sidebar2')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('template.navbar2')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('template.footer2')
                    <!-- / Footer -->

                    <div class="content-backdrop fade d-none"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target d-none"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Modal eliminar cita -->
    <div class="modal fade" id="modalEliminarCita" tabindex="-1" aria-labelledby="modalEliminarCitaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-0">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Eliminar cita</h1>
                    <p class="fs--1 fw-normal" id="mensajeError">¿Estás seguro(a) de eliminar esta cita?</p>
                    <input type="hidden" id="idCitaEliminar">
                </div>
                <div class="modal-footer pt-0 pb-3 px-3 d-flex justify-content-around align-items-center">
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center" data-bs-dismiss="modal">Cancelar</div>
                    <div class="text-primary-veris fs--1 fw-medium cursor-pointer text-center btn-confirmar-eliminar-cita">Eliminar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalError400" tabindex="-1" aria-labelledby="modalError400Label" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs--20 line-height-24 my-3">Veris</h1>
                    <p class="fs--1 fw-normal mb-0" id="mensaje_400"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <a href="/" class="btn btn-primary-veris fw-medium fs--18 m-0 mb-3 w-100 px-4 py-3">Aceptar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Permite Cambio -->
    <div class="modal fade" id="modalPermiteCambiar" tabindex="-1" aria-labelledby="modalPermiteCambiarLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center p-3">
                    <h1 class="modal-title fs-5 fw-medium mb-3">Veris</h1>
                    <p class="fs--2 fw-normal" id="mensajeNoPermiteCambiar"></p>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 mb-3 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

    <script>
        // Inicializa Swiper.js
        var swiperProximasCitas,swiperUrgenciasAmbulatorias;
        function chartProgres(elemento){
            console.log('elemento',elemento);

            var swiper = new Swiper('.swiper-acceso-rapidos', {
                // slidesPerView: 1,
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
                        slidesPerView: 2,
                        // centeredSlides: true,
                        // loop: true,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // centeredSlides: true,
                        // loop: true,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        // spaceBetween: 8,
                    },
                },
            });

            var swiperTratamiento = new Swiper('.swiper-tratamientos', {
                // slidesPerView: 1,
                spaceBetween: 8,
                navigation: {
                    nextEl: '.btn-next',
                    prevEl: '.btn-prev',
                },
                autoplay: false,
                // watchOverflow: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        // spaceBetween: 8,
                    },
                },
            });

            swiperProximasCitas = new Swiper('.swiper-proximas-citas', {
                // slidesPerView: 1,
                spaceBetween: 8,
                navigation: {
                    nextEl: '.btn-next',
                    prevEl: '.btn-prev',
                },
                autoplay: false,
                // watchOverflow: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        // spaceBetween: 8,
                    },
                }/*,on: {
                    init: function() {
                        updateNavigation();
                    },
                    resize: function() {
                        updateNavigation();
                    },
                }*/

            });

            swiperUrgenciasAmbulatorias = new Swiper('.swiper-urgencias-ambulatorias', {
                // slidesPerView: 1,
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
                    640: {
                        slidesPerView: 1,
                        // spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 2,
                        // spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        // spaceBetween: 8,
                    },
                },
            });

            /* // Inicializa apexchart
            let chartElements = document.querySelectorAll(elemento);
            // Mapea valores de atributos personalizados a colores
            let colorMapping = {
                'success': '#00c853',
                'primary': '#0071CE',
                // Agrega más mapeos aquí según tus necesidades
            };

            // Itera sobre cada elemento con la clase 'chart-progress'
            chartElements.forEach(function(chartElement) {
                // Obtiene los valores de los atributos de datos para el elemento actual
                let porcentaje = parseInt(chartElement.getAttribute('data-porcentaje'));
                let color = chartElement.getAttribute('data-color');

                // Obtén el color correspondiente del mapeo o usa el valor directamente si no está en el mapeo
                let colorSeleccionado = colorMapping[color] || color;

                // Configura los datos para ApexCharts para el elemento actual
                let options = {
                    chart: {
                        height: 110,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '40%'
                            },
                            dataLabels: {
                                showOn: 'always',
                                name: {
                                    offsetY: -4,
                                    show: true,
                                    color: colorSeleccionado,
                                    fontSize: '10px'
                                },
                                value: {
                                    offsetY: -4,
                                    color: colorSeleccionado,
                                    fontSize: '14px',
                                    formatter: function(val) {
                                        return porcentaje + '%';
                                    }
                                }
                            }
                        }
                    },
                    series: [porcentaje],
                    labels: [''],
                    stroke: {
                        lineCap: 'round'
                    },
                    colors: [colorSeleccionado],
                };

                // Crea una nueva instancia de ApexCharts para el elemento actual
                let chart = new ApexCharts(chartElement, options);
                chart.render();
            }); */
        }
    </script>

    <!-- Funciones de ayuda -->
    <script>
        // capializar la primera letra de cada palabra
        function capitalizarElemento(elemento) {
            try {
                
                if (!elemento) return "";
                const texto = elemento.trim().toLowerCase();
                
                const palabras = texto.split(/\s+/);

                for (let i = 0; i < palabras.length; i++) {
                    const palabra = palabras[i];
                    const primeraLetraMayuscula = palabra.charAt(0).toUpperCase();
                    palabras[i] = primeraLetraMayuscula + palabra.substring(1);
                    
                }

                const textoCapitalizado = palabras.join(" ");
                return textoCapitalizado;
            } catch (error) {
                console.error("Error en capitalizarElemento:", error); // Log de errores
                return elemento;
            }
        }

        function updateNavigation() {
            var totalSlides = swiperProximasCitas.slides.length - 2 * swiperProximasCitas.params.slidesPerView; // Eliminar duplicados en el bucle infinito
            if (totalSlides <= swiperProximasCitas.params.slidesPerView) {
                $('.swiper-button-prev').hide();
                $('.swiper-button-next').hide();
            } else {
                $('.swiper-button-prev').show();
                $('.swiper-button-next').show();
            }
        }

        // funcion quitar comillas a la url
        function quitarComillas(url){
            console.log('imagen',url);
            if (url == null) return "";
            let urlSinComillas = url.replace(/['"]+/g, '');
            return urlSinComillas;
        }

        //determinar valores null
        function determinarValorNull(valor){
            if (valor == null) return "";
            return valor;
        }

        function determinarValoresNull(valor){
            if (valor == null) return 0;
            return valor;
        }


        function inicializarDatePickers() {
            // Esta variable se declara aquí para poder ser accesible dentro del onChange de fechaDesdePicker
            let fechaHastaPicker;

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

            fechaHastaPicker = flatpickr("#fechaHasta", {
                maxDate: new Date().fp_incr(0),
                minDate: new Date(),
                onChange: function(selectedDates, dateStr, instance) {
                    // Aquí puedes agregar lógica adicional si es necesario
                }
            });

            // Inicialmente, deshabilitar el segundo datepicker
            document.getElementById('fechaHasta').disabled = true;

            // Quitar el atributo readonly de los campos
            $("#fechaDesde").removeAttr("readonly");
            $("#fechaHasta").removeAttr("readonly");

            // Deshabilitar el autocompletado para estos campos
            $("#fechaDesde").attr("autocomplete", "off");
            $("#fechaHasta").attr("autocomplete", "off");
        }



        

    </script>

    
    @stack('scripts')
</body>

</html>