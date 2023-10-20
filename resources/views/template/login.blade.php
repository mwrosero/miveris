<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../../../../assets/"
    data-template="vertical-menu-template-starter" >
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://code.jquery.com/jquery-3.6.0.min.js">
        
        <title>@yield('title')</title>
        <meta name="description" content="" />


        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.svg">
        <link rel="icon" type="image/png" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.png">

        <!-- <link rel="manifest" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/manifest.json"> -->
        <meta name="msapplication-TileColor" content="#0071CE">
        <meta name="theme-color" content="#0071CE">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="../../../assets/vendor/fonts/fontawesome.css" />
        <link rel="stylesheet" href="../../../assets/vendor/fonts/tabler-icons.css" />
        <link rel="stylesheet" href="../../../assets/vendor/fonts/flag-icons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="../../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="../../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="../../../assets/vendor/css/pages/page-auth.css" />
        <link rel="stylesheet" href="../../../assets/css/demo.css" />
        <link rel="stylesheet" href="../../../assets/css/style.css" />

        <!-- Vendors CSS -->
        
        <link rel="stylesheet" href="../../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />

        <!-- Page CSS -->
        <script src="../../../assets/vendor/js/helpers.js"></script>
        <!-- Helpers -->

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        {{-- <script src="../../../assets/vendor/js/template-customizer.js"></script> --}}
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="../../../assets/js/config.js"></script>
    </head>

    <body class="bg-fondo">
        
        <!-- Content -->
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y ">
                <div class="authentication-inner py-4">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <img class="logo-login" src="../../assets/img/veris/icono.svg">
                            </div>
                            <!-- /Logo -->
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->

      <script src="../../../assets/vendor/libs/jquery/jquery.js"></script>
      <script src="../../../assets/vendor/libs/popper/popper.js"></script>
      <script src="../../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="../../../assets/vendor/libs/node-waves/node-waves.js"></script>

      <script src="../../../assets/vendor/libs/hammer/hammer.js"></script>
      <script src="../../../assets/vendor/libs/i18n/i18n.js"></script>
      <script src="../../../assets/vendor/libs/typeahead-js/typeahead.js"></script>

      <script src="../../../assets/vendor/js/menu.js"></script>
      <!-- endbuild -->

      <!-- Vendors JS -->
      <script src="../../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
      <script src="../../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
      <!--<script src="../../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>-->

      <!-- Main JS -->
      {{-- <script src="../../../assets/js/main.js"></script> --}}

      <!-- Page JS -->
      {{-- <script src="../../../assets/js/pages-auth.js"></script> --}}
      <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/ism-helper.js"></script>
</body>
</html>