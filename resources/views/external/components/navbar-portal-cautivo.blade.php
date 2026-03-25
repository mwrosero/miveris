<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme-veris pe-3" id="layout-navbar">
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Logo veris -->
        <div class="navbar-brand mx-auto">
            <img src="{{ asset('assets/img/'.config('app.subdomain').'/logo-'.config('app.subdomain').'.svg') }}" class="ml-lg-12" alt="veris" width="84">
        </div>        
        @if(isset($showUser) && $showUser)
        <ul class="navbar-nav flex-row align-items-center">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar-sm avatar-online">
                        <img src="{{ asset('assets/img/avatars/avatar.svg') }}" alt class="h-auto rounded-circle" />
                    </div>
                    <span class="fs--1 ms-2 d-none d-lg-block">{{ Session::get('userDataExternal')->codigoUsuario }}</span>
                    <i class="fa-solid fa-angle-down d-none d-lg-block ms-2"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end rounded-3 mt-2 py-1">
                    <li>
                        <a class="dropdown-item fs--1 d-flex align-items-center mb-0 cursor-pointer" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa-solid fa-arrow-right-to-bracket text-primary-veris me-2 ti-sm"></i>
                            <span class="align-middle">Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
        @endif
    </div>
</nav>
@if(isset($showUser) && $showUser)
<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body p-3 text-center">
                <h5 class="fs-24 line-height-28 my-3">Cerrar sesión</h5>
                <p class="fs--16 line-height-20 text-veris mb-0">¿Estás seguro que deseas cerrar sesión?.</p>
                <div class="d-flex">
                    <button type="button" class="btn btn-lg btn-outline-primary-veris fs--18 col me-1 mt-3 m-0 px-4 py-3" data-bs-dismiss="modal">No</button>
                    <a class="btn btn-lg btn-primary-veris fs--18 col ms-1 mt-3 m-0 px-4 py-3" id="logout">Si, cerrar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#logout').click(function(){
        // localStorage.clear();
        for (let i = 0; i < localStorage.length; i++) {
            let key = localStorage.key(i);
            if (key.startsWith('cita-')) {
                localStorage.removeItem(key);
                i--; // Ajustar el índice después de eliminar un elemento
            }
        }
        window.location.href = "{{ route('logout-qr') }}";
    });
</script>
@endif