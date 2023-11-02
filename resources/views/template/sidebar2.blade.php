<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme-veris">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link text-white">
            <span class="app-brand-text demo menu-text fw-bold">Menú</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-none">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item active open d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
                <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item active">
                    <a href="index.html" class="menu-link">
                    <div data-i18n="Analytics">Analytics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="dashboards-crm.html" class="menu-link">
                    <div data-i18n="CRM">CRM</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="dashboards-ecommerce.html" class="menu-link">
                    <div data-i18n="eCommerce">eCommerce</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Layouts -->
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
            <div data-i18n="Layouts">Layouts</div>
            </a>

            <ul class="menu-sub">
            <li class="menu-item">
                <a href="layouts-collapsed-menu.html" class="menu-link">
                <div data-i18n="Collapsed menu">Collapsed menu</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-content-navbar.html" class="menu-link">
                <div data-i18n="Content navbar">Content navbar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-content-navbar-with-sidebar.html" class="menu-link">
                <div data-i18n="Content nav + Sidebar">Content nav + Sidebar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../horizontal-menu-template" class="menu-link" target="_blank">
                <div data-i18n="Horizontal">Horizontal</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-without-menu.html" class="menu-link">
                <div data-i18n="Without menu">Without menu</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-without-navbar.html" class="menu-link">
                <div data-i18n="Without navbar">Without navbar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-fluid.html" class="menu-link">
                <div data-i18n="Fluid">Fluid</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-container.html" class="menu-link">
                <div data-i18n="Container">Container</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="layouts-blank.html" class="menu-link">
                <div data-i18n="Blank">Blank</div>
                </a>
            </li>
            </ul>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase d-none">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>
        <li class="menu-item active">
            <a href="{{route('home')}}" class="menu-link fs--1 text-white">
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Inicio">Inicio</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('citas')}}" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.75 10.8125C2.75 9.95312 3.41406 9.25 4.3125 9.25H7.4375C8.29688 9.25 9 9.95312 9 10.8125V13.9375C9 14.8359 8.29688 15.5 7.4375 15.5H4.3125C3.41406 15.5 2.75 14.8359 2.75 13.9375V10.8125ZM4 10.8125V13.9375C4 14.1328 4.11719 14.25 4.3125 14.25H7.4375C7.59375 14.25 7.75 14.1328 7.75 13.9375V10.8125C7.75 10.6562 7.59375 10.5 7.4375 10.5H4.3125C4.11719 10.5 4 10.6562 4 10.8125ZM5.25 3H12.75V1.125C12.75 0.8125 13.0234 0.5 13.375 0.5C13.6875 0.5 14 0.8125 14 1.125V3H15.25C16.6172 3 17.75 4.13281 17.75 5.5V18C17.75 19.4062 16.6172 20.5 15.25 20.5H2.75C1.34375 20.5 0.25 19.4062 0.25 18V5.5C0.25 4.13281 1.34375 3 2.75 3H4V1.125C4 0.8125 4.27344 0.5 4.625 0.5C4.9375 0.5 5.25 0.8125 5.25 1.125V3ZM1.5 18C1.5 18.7031 2.04688 19.25 2.75 19.25H15.25C15.9141 19.25 16.5 18.7031 16.5 18V8H1.5V18ZM1.5 5.5V6.75H16.5V5.5C16.5 4.83594 15.9141 4.25 15.25 4.25H2.75C2.04688 4.25 1.5 4.83594 1.5 5.5Z" fill="white"/>
                </svg>
                <div data-i18n="Citas">Citas</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="16" height="21" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.375 13.625C12.6875 13.625 13 13.9375 13 14.25C13 14.6016 12.6875 14.875 12.375 14.875H7.375C7.02344 14.875 6.75 14.6016 6.75 14.25C6.75 13.9375 7.02344 13.625 7.375 13.625H12.375ZM12.375 9.875C12.6875 9.875 13 10.1875 13 10.5C13 10.8516 12.6875 11.125 12.375 11.125H8.625C8.27344 11.125 8 10.8516 8 10.5C8 10.1875 8.27344 9.875 8.625 9.875H12.375ZM4.25 13.3125C4.75781 13.3125 5.1875 13.7422 5.1875 14.25C5.1875 14.7969 4.75781 15.1875 4.25 15.1875C3.70312 15.1875 3.3125 14.7969 3.3125 14.25C3.3125 13.7422 3.70312 13.3125 4.25 13.3125ZM13 3C14.3672 3 15.5 4.13281 15.5 5.5V18C15.5 19.4062 14.3672 20.5 13 20.5H3C1.59375 20.5 0.5 19.4062 0.5 18V5.5C0.5 4.13281 1.59375 3 3 3C3.3125 3 3.625 3.3125 3.625 3.625C3.625 3.97656 3.3125 4.25 3 4.25C2.29688 4.25 1.75 4.83594 1.75 5.5V18C1.75 18.7031 2.29688 19.25 3 19.25H13C13.6641 19.25 14.25 18.7031 14.25 18V5.5C14.25 4.83594 13.6641 4.25 13 4.25C12.6484 4.25 12.375 3.97656 12.375 3.625C12.375 3.3125 12.6484 3 13 3ZM4.875 5.5C4.52344 5.5 4.25 5.22656 4.25 4.875C4.25 4.5625 4.52344 4.25 4.875 4.25H5.8125C5.61719 3.89844 5.5 3.46875 5.5 3C5.5 1.63281 6.59375 0.5 8 0.5C9.36719 0.5 10.5 1.63281 10.5 3C10.5 3.46875 10.3438 3.89844 10.1484 4.25H11.125C11.4375 4.25 11.75 4.5625 11.75 4.875C11.75 5.22656 11.4375 5.5 11.125 5.5H4.875ZM8 1.75C7.29688 1.75 6.75 2.33594 6.75 3C6.75 3.70312 7.29688 4.25 8 4.25C8.66406 4.25 9.25 3.70312 9.25 3C9.25 2.33594 8.66406 1.75 8 1.75ZM3.15625 9.48438C3.39062 9.21094 3.78125 9.21094 4.01562 9.44531L4.91406 10.2656L6.90625 8.19531C7.14062 7.96094 7.53125 7.96094 7.80469 8.19531C8.03906 8.42969 8.03906 8.82031 7.80469 9.09375L5.42188 11.5938C5.30469 11.7109 5.10938 11.75 4.95312 11.75C4.79688 11.75 4.64062 11.7109 4.52344 11.5938L3.19531 10.3438C2.92188 10.1094 2.92188 9.71875 3.15625 9.48438Z" fill="white"/>
                </svg>
                <div data-i18n="Tratamientos">Tratamientos</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="16" height="21" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.7578 5.42188C15.2266 5.89062 15.5 6.51562 15.5 7.17969V18C15.5 19.4062 14.3672 20.5 13 20.5H3C1.59375 20.5 0.5 19.4062 0.5 18V3C0.5 1.63281 1.59375 0.5 3 0.5H8.82031C9.48438 0.5 10.1094 0.773438 10.5781 1.24219L14.7578 5.42188ZM9.25 1.86719V6.125C9.25 6.47656 9.52344 6.75 9.875 6.75H14.1328C14.0938 6.59375 14.0156 6.4375 13.8594 6.28125L9.71875 2.14062C9.5625 1.98438 9.40625 1.90625 9.25 1.86719ZM14.25 18V8H9.875C8.82031 8 8 7.17969 8 6.125V1.75H3C2.29688 1.75 1.75 2.33594 1.75 3V18C1.75 18.7031 2.29688 19.25 3 19.25H13C13.6641 19.25 14.25 18.7031 14.25 18ZM4.25 11.125C4.25 10.8125 4.52344 10.5 4.875 10.5H11.125C11.4375 10.5 11.75 10.8125 11.75 11.125C11.75 11.4766 11.4375 11.75 11.125 11.75H4.875C4.52344 11.75 4.25 11.4766 4.25 11.125ZM11.125 13C11.4375 13 11.75 13.3125 11.75 13.625C11.75 13.9766 11.4375 14.25 11.125 14.25H4.875C4.52344 14.25 4.25 13.9766 4.25 13.625C4.25 13.3125 4.52344 13 4.875 13H11.125ZM11.125 15.5C11.4375 15.5 11.75 15.8125 11.75 16.125C11.75 16.4766 11.4375 16.75 11.125 16.75H4.875C4.52344 16.75 4.25 16.4766 4.25 16.125C4.25 15.8125 4.52344 15.5 4.875 15.5H11.125Z" fill="white"/>
                </svg>
                <div data-i18n="Resultados">Resultados</div>
            </a>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-file-dollar"></i>
            <div data-i18n="Invoice">Invoice</div>
            <div class="badge bg-label-danger rounded-pill ms-auto">4</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="app-invoice-list.html" class="menu-link">
                <div data-i18n="List">List</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-invoice-preview.html" class="menu-link">
                <div data-i18n="Preview">Preview</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-invoice-edit.html" class="menu-link">
                <div data-i18n="Edit">Edit</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-invoice-add.html" class="menu-link">
                <div data-i18n="Add">Add</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-users"></i>
            <div data-i18n="Users">Users</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="app-user-list.html" class="menu-link">
                <div data-i18n="List">List</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="View">View</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="app-user-view-account.html" class="menu-link">
                    <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-user-view-security.html" class="menu-link">
                    <div data-i18n="Security">Security</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-user-view-billing.html" class="menu-link">
                    <div data-i18n="Billing & Plans">Billing & Plans</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-user-view-notifications.html" class="menu-link">
                    <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-user-view-connections.html" class="menu-link">
                    <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
                </ul>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div data-i18n="Roles & Permissions">Roles & Permissions</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="app-access-roles.html" class="menu-link">
                <div data-i18n="Roles">Roles</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-access-permission.html" class="menu-link">
                <div data-i18n="Permission">Permission</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-file"></i>
            <div data-i18n="Pages">Pages</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="User Profile">User Profile</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-profile-user.html" class="menu-link">
                    <div data-i18n="Profile">Profile</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-profile-teams.html" class="menu-link">
                    <div data-i18n="Teams">Teams</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-profile-projects.html" class="menu-link">
                    <div data-i18n="Projects">Projects</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-profile-connections.html" class="menu-link">
                    <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Account Settings">Account Settings</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-account-settings-account.html" class="menu-link">
                    <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-security.html" class="menu-link">
                    <div data-i18n="Security">Security</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-billing.html" class="menu-link">
                    <div data-i18n="Billing & Plans">Billing & Plans</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                    <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="pages-faq.html" class="menu-link">
                <div data-i18n="FAQ">FAQ</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Help Center">Help Center</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-help-center-landing.html" class="menu-link">
                    <div data-i18n="Landing">Landing</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-help-center-categories.html" class="menu-link">
                    <div data-i18n="Categories">Categories</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-help-center-article.html" class="menu-link">
                    <div data-i18n="Article">Article</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="pages-pricing.html" class="menu-link">
                <div data-i18n="Pricing">Pricing</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Misc">Misc</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="pages-misc-error.html" class="menu-link" target="_blank">
                    <div data-i18n="Error">Error</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-misc-under-maintenance.html" class="menu-link" target="_blank">
                    <div data-i18n="Under Maintenance">Under Maintenance</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-misc-comingsoon.html" class="menu-link" target="_blank">
                    <div data-i18n="Coming Soon">Coming Soon</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="pages-misc-not-authorized.html" class="menu-link" target="_blank">
                    <div data-i18n="Not Authorized">Not Authorized</div>
                    </a>
                </li>
                </ul>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-lock"></i>
            <div data-i18n="Authentications">Authentications</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Login">Login</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="auth-login-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-login-cover.html" class="menu-link" target="_blank">
                    <div data-i18n="Cover">Cover</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Register">Register</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="auth-register-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-register-cover.html" class="menu-link" target="_blank">
                    <div data-i18n="Cover">Cover</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-register-multisteps.html" class="menu-link" target="_blank">
                    <div data-i18n="Multi-steps">Multi-steps</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Verify Email">Verify Email</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="auth-verify-email-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-verify-email-cover.html" class="menu-link" target="_blank">
                    <div data-i18n="Cover">Cover</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Reset Password">Reset Password</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="auth-reset-password-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-reset-password-cover.html" class="menu-link" target="_blank">
                    <div data-i18n="Cover">Cover</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Forgot Password">Forgot Password</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-forgot-password-cover.html" class="menu-link" target="_blank">
                    <div data-i18n="Cover">Cover</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Two Steps">Two Steps</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="auth-two-steps-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="auth-two-steps-cover.html" class="menu-link" target="_blank">
                    <div data-i18n="Cover">Cover</div>
                    </a>
                </li>
                </ul>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-forms"></i>
            <div data-i18n="Wizard Examples">Wizard Examples</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="wizard-ex-checkout.html" class="menu-link">
                <div data-i18n="Checkout">Checkout</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="wizard-ex-property-listing.html" class="menu-link">
                <div data-i18n="Property Listing">Property Listing</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="wizard-ex-create-deal.html" class="menu-link">
                <div data-i18n="Create Deal">Create Deal</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="25" height="19" viewBox="0 0 25 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.625 1.375C13.625 1.0625 13.8984 0.75 14.25 0.75H15.8125C16.6328 0.75 17.3359 1.29688 17.6094 2.03906L17.8047 2.66406L20.0312 1.53125C20.2266 1.45312 20.4609 1.375 20.6953 1.375C21.2422 1.375 21.75 1.88281 21.75 2.42969V5.35938C21.75 5.90625 21.2422 6.375 20.6953 6.375C20.4609 6.375 20.2266 6.33594 20.0312 6.21875L18.7812 5.63281L19.7969 8.60156C20.0312 8.60156 20.2656 8.5625 20.5 8.5625C22.1016 8.5625 23.5859 9.22656 24.6406 10.2812C24.875 10.5156 24.875 10.9062 24.6406 11.1797C24.4062 11.4141 24.0156 11.4141 23.7812 11.1797C22.9219 10.3594 21.75 9.8125 20.5 9.8125C18.2734 9.8125 16.4375 11.375 15.9297 13.4062C15.8516 13.7578 15.8125 14.1484 15.8125 14.5H10.5C10.5 16.5703 8.82031 18.25 6.75 18.25C4.64062 18.25 3 16.5703 3 14.5H1.75C1.04688 14.5 0.5 13.9531 0.5 13.25V12C0.5 9.26562 2.72656 7 5.5 7H9.25C9.91406 7 10.5 7.58594 10.5 8.25V12C10.5 12.7031 11.0469 13.25 11.75 13.25H14.6797C14.6797 13.2109 14.6797 13.1719 14.7188 13.1328C15.1875 11.1406 16.6719 9.53906 18.5859 8.875L16.4375 2.42969C16.3203 2.19531 16.0859 2 15.8125 2H14.25C13.8984 2 13.625 1.72656 13.625 1.375ZM18.2344 3.95312C18.2344 3.95312 18.2344 3.95312 18.2734 3.95312L20.5 5.08594V2.70312L18.2734 3.83594C18.2344 3.83594 18.2344 3.83594 18.1953 3.83594L18.2344 3.95312ZM9.25 8.25H5.5C3.39062 8.25 1.75 9.92969 1.75 12V13.25H9.5625C9.36719 12.8984 9.25 12.4688 9.25 12V8.25ZM9.25 14.5H4.25C4.25 15.9062 5.34375 17 6.75 17C8.11719 17 9.25 15.9062 9.25 14.5ZM9.875 4.5C10.1875 4.5 10.5 4.8125 10.5 5.125C10.5 5.47656 10.1875 5.75 9.875 5.75H4.875C4.52344 5.75 4.25 5.47656 4.25 5.125C4.25 4.8125 4.52344 4.5 4.875 4.5H9.875ZM16.75 14.5C16.75 12.4297 18.3906 10.75 20.5 10.75C22.5703 10.75 24.25 12.4297 24.25 14.5C24.25 16.5703 22.5703 18.25 20.5 18.25C18.3906 18.25 16.75 16.5703 16.75 14.5ZM20.5 17C21.8672 17 23 15.9062 23 14.5C23 13.1328 21.8672 12 20.5 12C19.0938 12 18 13.1328 18 14.5C18 15.9062 19.0938 17 20.5 17Z" fill="white"/>
                </svg>
                <div data-i18n="Domicilio">Domicilio</div>
            </a>
        </li>

        <!-- Components -->
        <li class="menu-header small text-uppercase d-none">
            <span class="menu-header-text">Components</span>
        </li>
        <!-- Cards -->
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-id"></i>
            <div data-i18n="Cards">Cards</div>
            <div class="badge bg-label-primary rounded-pill ms-auto">6</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="cards-basic.html" class="menu-link">
                <div data-i18n="Basic">Basic</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="cards-advance.html" class="menu-link">
                <div data-i18n="Advance">Advance</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="cards-statistics.html" class="menu-link">
                <div data-i18n="Statistics">Statistics</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="cards-analytics.html" class="menu-link">
                <div data-i18n="Analytics">Analytics</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="cards-actions.html" class="menu-link">
                <div data-i18n="Actions">Actions</div>
                </a>
            </li>
            </ul>
        </li>
        <!-- User interface -->
        <li class="menu-item d-none">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-color-swatch"></i>
            <div data-i18n="User interface">User interface</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="ui-accordion.html" class="menu-link">
                <div data-i18n="Accordion">Accordion</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-alerts.html" class="menu-link">
                <div data-i18n="Alerts">Alerts</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-badges.html" class="menu-link">
                <div data-i18n="Badges">Badges</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-buttons.html" class="menu-link">
                <div data-i18n="Buttons">Buttons</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-carousel.html" class="menu-link">
                <div data-i18n="Carousel">Carousel</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-collapse.html" class="menu-link">
                <div data-i18n="Collapse">Collapse</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-dropdowns.html" class="menu-link">
                <div data-i18n="Dropdowns">Dropdowns</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-footer.html" class="menu-link">
                <div data-i18n="Footer">Footer</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-list-groups.html" class="menu-link">
                <div data-i18n="List Groups">List groups</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-modals.html" class="menu-link">
                <div data-i18n="Modals">Modals</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-navbar.html" class="menu-link">
                <div data-i18n="Navbar">Navbar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-offcanvas.html" class="menu-link">
                <div data-i18n="Offcanvas">Offcanvas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-pagination-breadcrumbs.html" class="menu-link">
                <div data-i18n="Pagination & Breadcrumbs">Pagination &amp; Breadcrumbs</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-progress.html" class="menu-link">
                <div data-i18n="Progress">Progress</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-spinners.html" class="menu-link">
                <div data-i18n="Spinners">Spinners</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-tabs-pills.html" class="menu-link">
                <div data-i18n="Tabs & Pills">Tabs &amp; Pills</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-toasts.html" class="menu-link">
                <div data-i18n="Toasts">Toasts</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-tooltips-popovers.html" class="menu-link">
                <div data-i18n="Tooltips & Popovers">Tooltips &amp; popovers</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="ui-typography.html" class="menu-link">
                <div data-i18n="Typography">Typography</div>
                </a>
            </li>
            </ul>
        </li>

        <!-- Extended components -->
        <li class="menu-item d-none">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-components"></i>
            <div data-i18n="Extended UI">Extended UI</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="extended-ui-avatar.html" class="menu-link">
                <div data-i18n="Avatar">Avatar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-blockui.html" class="menu-link">
                <div data-i18n="BlockUI">BlockUI</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-drag-and-drop.html" class="menu-link">
                <div data-i18n="Drag & Drop">Drag &amp; Drop</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-media-player.html" class="menu-link">
                <div data-i18n="Media Player">Media Player</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-star-ratings.html" class="menu-link">
                <div data-i18n="Star Ratings">Star Ratings</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-sweetalert2.html" class="menu-link">
                <div data-i18n="SweetAlert2">SweetAlert2</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-text-divider.html" class="menu-link">
                <div data-i18n="Text Divider">Text Divider</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div data-i18n="Timeline">Timeline</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="extended-ui-timeline-basic.html" class="menu-link">
                    <div data-i18n="Basic">Basic</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="extended-ui-timeline-fullscreen.html" class="menu-link">
                    <div data-i18n="Fullscreen">Fullscreen</div>
                    </a>
                </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="extended-ui-tour.html" class="menu-link">
                <div data-i18n="Tour">Tour</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-treeview.html" class="menu-link">
                <div data-i18n="Treeview">Treeview</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-misc.html" class="menu-link">
                <div data-i18n="Miscellaneous">Miscellaneous</div>
                </a>
            </li>
            </ul>
        </li>

        <!-- Icons -->
        <li class="menu-item d-none">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-brand-tabler"></i>
            <div data-i18n="Icons">Icons</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="icons-tabler.html" class="menu-link">
                <div data-i18n="Tabler">Tabler</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="icons-font-awesome.html" class="menu-link">
                <div data-i18n="Fontawesome">Fontawesome</div>
                </a>
            </li>
            </ul>
        </li>

        <!-- Forms & Tables -->
        <li class="menu-header small text-uppercase d-none">
            <span class="menu-header-text">Forms &amp; Tables</span>
        </li>
        <!-- Forms -->
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-toggle-left"></i>
            <div data-i18n="Form Elements">Form Elements</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="forms-basic-inputs.html" class="menu-link">
                <div data-i18n="Basic Inputs">Basic Inputs</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-input-groups.html" class="menu-link">
                <div data-i18n="Input groups">Input groups</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-custom-options.html" class="menu-link">
                <div data-i18n="Custom Options">Custom Options</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-editors.html" class="menu-link">
                <div data-i18n="Editors">Editors</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-file-upload.html" class="menu-link">
                <div data-i18n="File Upload">File Upload</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-pickers.html" class="menu-link">
                <div data-i18n="Pickers">Pickers</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-selects.html" class="menu-link">
                <div data-i18n="Select & Tags">Select &amp; Tags</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-sliders.html" class="menu-link">
                <div data-i18n="Sliders">Sliders</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-switches.html" class="menu-link">
                <div data-i18n="Switches">Switches</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="forms-extras.html" class="menu-link">
                <div data-i18n="Extras">Extras</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-layout-navbar"></i>
            <div data-i18n="Form Layouts">Form Layouts</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="form-layouts-vertical.html" class="menu-link">
                <div data-i18n="Vertical Form">Vertical Form</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="form-layouts-horizontal.html" class="menu-link">
                <div data-i18n="Horizontal Form">Horizontal Form</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="form-layouts-sticky.html" class="menu-link">
                <div data-i18n="Sticky Actions">Sticky Actions</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-text-wrap-disabled"></i>
            <div data-i18n="Form Wizard">Form Wizard</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="form-wizard-numbered.html" class="menu-link">
                <div data-i18n="Numbered">Numbered</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="form-wizard-icons.html" class="menu-link">
                <div data-i18n="Icons">Icons</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="26" height="21" viewBox="0 0 26 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.8203 13.7031C24.7578 13.7031 25.5 14.4453 25.5 15.3438V16.9062C25.5 17.8438 24.7578 18.5469 23.7812 18.5469H23.4688V18.8594C23.4688 19.7969 22.7656 20.5 21.8672 20.5H20.3047C19.3672 20.5 18.6641 19.7969 18.6641 18.8594V18.5469H18.3516C17.4531 18.5469 16.75 17.8438 16.75 16.9062V15.3438C16.75 14.4453 17.4531 13.7031 18.3906 13.7031H18.7031V13.3906C18.7031 12.4922 19.4062 11.75 20.3438 11.75H21.9062C22.8047 11.75 23.5078 12.4922 23.5078 13.3906V13.7031H23.8203ZM24.25 16.9062V15.3438C24.25 15.1484 24.0547 14.9531 23.7812 14.9531H22.2188V13.3906C22.2188 13.1953 22.0625 13 21.8672 13H20.3047C20.0703 13 19.9141 13.1953 19.9141 13.3906V14.9531H18.3516C18.1562 14.9531 18 15.1484 18 15.3438V16.9062C18 17.1406 18.1562 17.2969 18.3906 17.2969H19.9531V18.8594C19.9531 19.0938 20.1484 19.25 20.3438 19.25H21.9062C22.1016 19.25 22.2969 19.0938 22.2969 18.8594V17.2969H23.8594C24.0547 17.2969 24.25 17.1406 24.25 16.9062ZM19.875 8H22.4141C23.5078 8 24.4844 8.625 25.0312 9.5625C25.2656 9.99219 24.9922 10.5 24.4844 10.5C24.25 10.5 24.0547 10.3828 23.9375 10.1875C23.625 9.64062 23.0391 9.25 22.4141 9.25H19.875C19.6016 9.25 19.3672 9.32812 19.1328 9.44531C18.7812 9.60156 18.3906 9.44531 18.2734 9.09375C18.1562 8.78125 18.3125 8.42969 18.625 8.27344C19.0156 8.11719 19.4453 8 19.875 8ZM20.5 6.75C18.7422 6.75 17.375 5.38281 17.375 3.625C17.375 1.90625 18.7422 0.5 20.5 0.5C22.2188 0.5 23.625 1.90625 23.625 3.625C23.625 5.38281 22.2188 6.75 20.5 6.75ZM20.5 1.75C19.4453 1.75 18.625 2.60938 18.625 3.625C18.625 4.67969 19.4453 5.5 20.5 5.5C21.5156 5.5 22.375 4.67969 22.375 3.625C22.375 2.60938 21.5156 1.75 20.5 1.75ZM16.125 19.25C16.4375 19.25 16.75 19.5625 16.75 19.875C16.75 20.2266 16.4375 20.5 16.125 20.5H6.59375C5.96875 20.5 5.5 20.0703 5.5 19.4844C5.5 16.5938 7.96094 14.25 11.0469 14.25H14.875C15.1875 14.25 15.5 14.5625 15.5 14.875C15.5 15.2266 15.1875 15.5 14.875 15.5H11.0078C8.74219 15.5 6.86719 17.1797 6.75 19.25H16.125ZM6.82812 9.44531C6.59375 9.32812 6.35938 9.25 6.125 9.25H3.54688C2.57031 9.25 1.75 10.1484 1.75 11.2422V11.75C1.75 12.1016 1.4375 12.375 1.125 12.375C0.773438 12.375 0.5 12.1016 0.5 11.75V11.2422C0.5 9.48438 1.86719 8 3.54688 8H6.125C6.55469 8 6.98438 8.11719 7.375 8.3125C7.6875 8.46875 7.80469 8.82031 7.6875 9.13281C7.53125 9.44531 7.14062 9.60156 6.82812 9.44531ZM5.5 6.75C3.74219 6.75 2.375 5.38281 2.375 3.625C2.375 1.90625 3.74219 0.5 5.5 0.5C7.21875 0.5 8.625 1.90625 8.625 3.625C8.625 5.38281 7.21875 6.75 5.5 6.75ZM5.5 1.75C4.44531 1.75 3.625 2.60938 3.625 3.625C3.625 4.67969 4.44531 5.5 5.5 5.5C6.51562 5.5 7.375 4.67969 7.375 3.625C7.375 2.60938 6.51562 1.75 5.5 1.75ZM12.9609 13C10.7344 13 8.89844 11.2031 8.9375 8.9375C8.9375 6.71094 10.7344 4.875 12.9609 4.875C15.1875 4.875 17.0234 6.71094 17.0234 8.9375C17.0234 11.2031 15.2266 13 12.9609 13ZM12.9609 6.125C11.4375 6.125 10.1484 7.41406 10.1484 8.9375C10.1484 10.5 11.4375 11.75 12.9609 11.75C14.5234 11.75 15.7734 10.5 15.7734 8.9375C15.7734 7.41406 14.5234 6.125 12.9609 6.125Z" fill="white"/>
                </svg>
                <div data-i18n="Familia y amigos">Familia y amigos</div>
            </a>
        </li>
        <!-- Tables -->
        <li class="menu-item">
            <a href="#" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.0469 2.96094C21.5078 5.07031 21.625 8.82031 19.4375 11.0859L11.8594 18.8984C11.625 19.1328 11.3125 19.25 10.9609 19.25C10.6484 19.25 10.3359 19.1328 10.1016 18.8984L2.52344 11.0859C0.335938 8.82031 0.453125 5.07031 2.91406 2.96094C5.41406 0.851562 8.61719 1.82812 10.2188 3.46875L11 4.28906L11.7422 3.46875C13.7344 1.4375 16.8984 1.16406 19.0469 2.96094ZM18.5391 10.2266C20.0234 8.66406 20.3359 5.73438 18.2266 3.9375C16.0781 2.10156 13.5391 3.42969 12.6406 4.36719L11 6.08594L9.32031 4.36719C8.38281 3.42969 5.88281 2.10156 3.73438 3.9375C1.625 5.73438 1.9375 8.66406 3.42188 10.2266L11 18.0391L18.5391 10.2266Z" fill="white"/>
                </svg>

                <div data-i18n="Doctores favoritos">Doctores favoritos</div>
            </a>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-layout-grid"></i>
            <div data-i18n="Datatables">Datatables</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="tables-datatables-basic.html" class="menu-link">
                <div data-i18n="Basic">Basic</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="tables-datatables-advanced.html" class="menu-link">
                <div data-i18n="Advanced">Advanced</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="tables-datatables-extensions.html" class="menu-link">
                <div data-i18n="Extensions">Extensions</div>
                </a>
            </li>
            </ul>
        </li>

        <!-- Charts & Maps -->
        <li class="menu-header small text-uppercase d-none">
            <span class="menu-header-text">Charts &amp; Maps</span>
        </li>
        <li class="menu-item d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-chart-pie"></i>
            <div data-i18n="Charts">Charts</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="charts-apex.html" class="menu-link">
                <div data-i18n="Apex Charts">Apex Charts</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="charts-chartjs.html" class="menu-link">
                <div data-i18n="ChartJS">ChartJS</div>
                </a>
            </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="16" height="21" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.7578 5.42188C15.2266 5.89062 15.5 6.51562 15.5 7.17969V18C15.5 19.4062 14.3672 20.5 13 20.5H3C1.59375 20.5 0.5 19.4062 0.5 18V3C0.5 1.63281 1.59375 0.5 3 0.5H8.82031C9.48438 0.5 10.1094 0.773438 10.5781 1.24219L14.7578 5.42188ZM9.25 1.86719V6.125C9.25 6.47656 9.52344 6.75 9.875 6.75H14.1328C14.0938 6.59375 14.0156 6.4375 13.8594 6.28125L9.71875 2.14062C9.5625 1.98438 9.40625 1.90625 9.25 1.86719ZM14.25 18V8H9.875C8.82031 8 8 7.17969 8 6.125V1.75H3C2.29688 1.75 1.75 2.33594 1.75 3V18C1.75 18.7031 2.29688 19.25 3 19.25H13C13.6641 19.25 14.25 18.7031 14.25 18ZM9.25 9.875V11.75H11.125C11.4375 11.75 11.75 12.0625 11.75 12.375V13.7031C11.75 14.0156 11.4375 14.2891 11.125 14.2891H9.25V16.125C9.25 16.4766 8.9375 16.75 8.625 16.75H7.375C7.02344 16.75 6.75 16.4766 6.75 16.0859V14.25H4.875C4.52344 14.25 4.25 13.9766 4.25 13.625V12.375C4.25 12.0625 4.52344 11.75 4.875 11.75H6.75V9.875C6.75 9.5625 7.02344 9.25 7.375 9.25H8.625C8.9375 9.25 9.25 9.5625 9.25 9.875Z" fill="white"/>
                </svg>
                <div data-i18n="Solicitar hitoria clínica">Solicitar hitoria clínica</div>
            </a>
        </li>

        <!-- Misc -->
        <li class="menu-header small text-uppercase d-none">
            <span class="menu-header-text">Misc</span>
        </li>
        <li class="menu-item d-none">
            <a href="https://pixinvent.ticksy.com/" target="_blank" class="menu-link">
            <i class="menu-icon tf-icons ti ti-lifebuoy"></i>
            <div data-i18n="Support">Support</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" target="_blank" class="menu-link fs--1 text-white">
                <svg class="menu-icon" width="26" height="21" viewBox="0 0 26 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.75 7.375C16.75 11.2031 13.0781 14.25 8.625 14.25C7.80469 14.25 7.0625 14.1719 6.32031 13.9766C5.22656 14.7188 3.50781 15.5 1.39844 15.5C1.04688 15.5 0.695312 15.3047 0.539062 14.9531C0.421875 14.6016 0.460938 14.2109 0.734375 13.9375C0.734375 13.9375 1.67188 12.9219 2.25781 11.6719C1.16406 10.5 0.5 9.01562 0.5 7.375C0.5 3.58594 4.13281 0.5 8.625 0.5C13.0781 0.5 16.75 3.58594 16.75 7.375ZM8.625 13C12.4141 13 15.5 10.5 15.5 7.375C15.5 4.28906 12.4141 1.75 8.625 1.75C4.79688 1.75 1.75 4.28906 1.75 7.375C1.75 8.625 2.21875 9.83594 3.15625 10.8125L3.74219 11.4375L3.39062 12.2188C3 13.0391 2.49219 13.7422 2.14062 14.25C3.625 14.0938 4.83594 13.4688 5.65625 12.9609L6.08594 12.6484L6.63281 12.7656C7.25781 12.9219 7.96094 13 8.625 13ZM24.1719 17.5312C24.6797 18.3516 25.2266 18.9375 25.2266 18.9766C25.4609 19.2109 25.5391 19.6016 25.4219 19.9531C25.2656 20.3047 24.9141 20.5 24.5625 20.5C23.2734 20.5 22.1797 20.2266 21.2422 19.8359C20.2266 20.2656 19.1328 20.5 18 20.5C14.4453 20.5 11.5156 18.3125 10.6953 15.3047C11.125 15.2266 11.5547 15.1094 11.9453 14.9922C12.6094 17.4531 15.0312 19.25 18 19.25C18.9375 19.25 19.8359 19.0547 20.7344 18.7031L21.2031 18.4688L21.7109 18.6641C22.4141 18.9766 23.1172 19.1719 23.8203 19.25C23.625 18.9766 23.3516 18.5859 23.1172 18.1953L22.6484 17.4531L23.1562 16.7891C23.8594 15.8516 24.25 14.7578 24.25 13.625C24.25 10.5391 21.4375 8 18 8C17.9609 8 17.9609 8.03906 17.9609 8.03906C17.9609 7.80469 18 7.60938 18 7.375C18 7.17969 17.9609 6.98438 17.9609 6.78906C17.9609 6.78906 17.9609 6.75 18 6.75C22.1406 6.75 25.5 9.83594 25.5 13.625C25.5 15.0703 24.9922 16.4375 24.1719 17.5312Z" fill="white"/>
                </svg>

                <div data-i18n="Cuentanos tu experiencia">Cuentanos tu experiencia</div>
            </a>
        </li>
    </ul>
</aside>