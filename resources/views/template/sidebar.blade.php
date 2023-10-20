<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="row">
        <div class="col-12">
            <a id="pin-menu" href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                {{-- <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i> --}}
                <i id="ico-collapse" class="fa-solid fa-caret-left d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
        <div class="col-12 mt-4 text-center">
            <img class="logo-sidebar" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris/icono-ism-large.svg">
            <img class="logo-sidebar-iso" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris/isotipo.svg" alt="">
        </div>
    </div>
    <!-- <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img class="logo-sidebar" src="../../assets/img/veris/isotipo.svg">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Veris</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div> -->

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3">
        @foreach (Session::get('menu') as $value)
        <li class="menu-item @if($loop->first) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <!-- <i class="menu-icon tf-icons ti square-dot"></i> -->
                {{-- <i class="fa-solid fa-angle-right me-2"></i> --}}
                {{-- <i class="menu-icon fa-solid fa-clipboard-list me-2"></i> --}}
                <i class="menu-icon tf-icons ti ti-layout-navbar"></i>
                <div data-i18n="{{ $value->nombreModulo }}">{{ $value->nombreModulo }}</div>
                <!-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> -->
            </a>
            @foreach ($value->opciones as $v)
            <ul class="menu-sub">
                <li test-rel="{{request()->route()->getName()}} --- {{ $v->vista }}" class="menu-item {{ Str::startsWith(request()->route()->getName(), $v->vista) ? 'menu-item-active' : '' }}">
                    <a href="/{{ $value->vista }}/{{ $v->vista }}" class="menu-link">
                        <div class="fs-14" data-i18n="{{ $v->detalleOpcion }}">{{ $v->detalleOpcion }}</div>
                    </a>
                </li>
            </ul>
            @endforeach
        </li>
        @endforeach
    </ul>
</aside>