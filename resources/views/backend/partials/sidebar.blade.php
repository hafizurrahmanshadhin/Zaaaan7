<nav class="navbar navbar-vertical navbar-expand-lg" style="display:none;">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.home.*') ? 'active' : '' }}"
                        href="{{ route('admin.home.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 12C12 11.4477 12.4477 11 13 11H19C19.5523 11 20 11.4477 20 12V19C20 19.5523 19.5523 20 19 20H13C12.4477 20 12 19.5523 12 19V12Z"
                                        stroke="{{ request()->routeIs('admin.home.*') ? '#3874ff' : '#525b75' }}"
                                        stroke-width="2" stroke-linecap="round"></path>
                                    <path
                                        d="M4 5C4 4.44772 4.44772 4 5 4H8C8.55228 4 9 4.44772 9 5V19C9 19.5523 8.55228 20 8 20H5C4.44772 20 4 19.5523 4 19V5Z"
                                        stroke="{{ request()->routeIs('admin.home.*') ? '#3874ff' : '#525b75' }}"
                                        stroke-width="2" stroke-linecap="round"></path>
                                    <path
                                        d="M12 5C12 4.44772 12.4477 4 13 4H19C19.5523 4 20 4.44772 20 5V7C20 7.55228 19.5523 8 19 8H13C12.4477 8 12 7.55228 12 7V5Z"
                                        stroke="{{ request()->routeIs('admin.home.*') ? '#3874ff' : '#525b75' }}"
                                        stroke-width="2" stroke-linecap="round"></path>
                                </svg>
                            </span>
                            <span class="nav-link-text">Home</span>
                            {{-- @if (request()->routeIs('admin.home.*'))
                                <span class="fa-solid fa-circle text-info ms-1 new-page-indicator"
                                    style="font-size: 6px"></span>
                            @endif --}}
                        </div>
                    </a>
                </li>
                {{-- User --}}
                <li class="nav-item">
                    <!-- label-->
                    <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-e-commerce"
                            role="button" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="nv-e-commerce">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        stroke="#525b75">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g id="User / Users_Group">
                                                <path id="Vector"
                                                    d="M17 20C17 18.3431 14.7614 17 12 17C9.23858 17 7 18.3431 7 20M21 17.0004C21 15.7702 19.7659 14.7129 18 14.25M3 17.0004C3 15.7702 4.2341 14.7129 6 14.25M18 10.2361C18.6137 9.68679 19 8.8885 19 8C19 6.34315 17.6569 5 16 5C15.2316 5 14.5308 5.28885 14 5.76389M6 10.2361C5.38625 9.68679 5 8.8885 5 8C5 6.34315 6.34315 5 8 5C8.76835 5 9.46924 5.28885 10 5.76389M12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11C15 12.6569 13.6569 14 12 14Z"
                                                    stroke="#525b75" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                                <span class="nav-link-text">Users</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-e-commerce">
                                <li class="collapsed-nav-item-title d-none">Users</li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#nv-admin" data-bs-toggle="collapse" aria-expanded="true"
                                        aria-controls="nv-admin">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Admin</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#nv-admin" data-bs-toggle="collapse" aria-expanded="true"
                                        aria-controls="nv-admin">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Clients</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#nv-admin" data-bs-toggle="collapse" aria-expanded="true"
                                        aria-controls="nv-admin">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Helpers</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                {{-- category --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}"
                        href="{{ route('admin.category.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <svg fill="{{ request()->routeIs('admin.category.*') ? '#3874ff' : '#525b75' }}"
                                    viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <defs>
                                            <style>
                                                .cls-1 {
                                                    fill: none;
                                                }
                                            </style>
                                        </defs>
                                        <title>category--new-each</title>
                                        <path
                                            d="M29,10H24v2h5v6H22v2h3v2.142a4,4,0,1,0,2,0V20h2a2.0027,2.0027,0,0,0,2-2V12A2.0023,2.0023,0,0,0,29,10ZM28,26a2,2,0,1,1-2-2A2.0027,2.0027,0,0,1,28,26Z">
                                        </path>
                                        <path
                                            d="M19,6H14V8h5v6H12v2h3v6.142a4,4,0,1,0,2,0V16h2a2.0023,2.0023,0,0,0,2-2V8A2.0023,2.0023,0,0,0,19,6ZM18,26a2,2,0,1,1-2-2A2.0027,2.0027,0,0,1,18,26Z">
                                        </path>
                                        <path
                                            d="M9,2H3A2.002,2.002,0,0,0,1,4v6a2.002,2.002,0,0,0,2,2H5V22.142a4,4,0,1,0,2,0V12H9a2.002,2.002,0,0,0,2-2V4A2.002,2.002,0,0,0,9,2ZM8,26a2,2,0,1,1-2-2A2.0023,2.0023,0,0,1,8,26ZM3,10V4H9l.0015,6Z">
                                        </path>
                                        <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>"
                                            class="cls-1" width="24" height="32"></rect>
                                    </g>
                                </svg>
                            </span>
                            <span class="nav-link-text">Category</span>
                        </div>
                    </a>
                </li>
                {{-- transection --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.transection.*') ? 'active' : '' }}"
                        href="{{ route('admin.transection.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <svg fill="{{ request()->routeIs('admin.transection.*') ? '#3874ff' : '#525b75' }}" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M31,7H1A1,1,0,0,0,0,8V24a1,1,0,0,0,1,1H31a1,1,0,0,0,1-1V8A1,1,0,0,0,31,7ZM25.09,23H6.91A6,6,0,0,0,2,18.09V13.91A6,6,0,0,0,6.91,9H25.09A6,6,0,0,0,30,13.91v4.18A6,6,0,0,0,25.09,23ZM30,11.86A4,4,0,0,1,27.14,9H30ZM4.86,9A4,4,0,0,1,2,11.86V9ZM2,20.14A4,4,0,0,1,4.86,23H2ZM27.14,23A4,4,0,0,1,30,20.14V23Z">
                                        </path>
                                        <path
                                            d="M7.51.71a1,1,0,0,0-.76-.1,1,1,0,0,0-.61.46l-2,3.43a1,1,0,0,0,1.74,1L7.38,2.94l5.07,2.93a1,1,0,0,0,1-1.74Z">
                                        </path>
                                        <path
                                            d="M24.49,31.29a1,1,0,0,0,.5.14.78.78,0,0,0,.26,0,1,1,0,0,0,.61-.46l2-3.43a1,1,0,1,0-1.74-1l-1.48,2.56-5.07-2.93a1,1,0,0,0-1,1.74Z">
                                        </path>
                                        <path
                                            d="M16,10a6,6,0,1,0,6,6A6,6,0,0,0,16,10Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,16,20Z">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                            <span class="nav-link-text">Transection</span>
                        </div>
                    </a>
                </li>

                {{-- example --}}
                {{-- <li class="nav-item">
                    <!-- label-->
                    <p class="navbar-vertical-label"></p>
                    <hr class="navbar-vertical-line" /><!-- parent pages-->
                    <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-e-commerce"
                            role="button" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="nv-e-commerce">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper"><span
                                        class="fas fa-caret-right dropdown-indicator-icon"></span></div><span
                                    class="nav-link-icon"><span data-feather="shopping-cart"></span></span><span
                                    class="nav-link-text">E commerce</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-e-commerce">
                                <li class="collapsed-nav-item-title d-none">E commerce</li>
                                <li class="nav-item"><a class="nav-link dropdown-indicator" href="#nv-admin"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-admin">
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown-indicator-icon-wrapper"><span
                                                    class="fas fa-caret-right dropdown-indicator-icon"></span></div>
                                            <span class="nav-link-text">Admin</span>
                                        </div>
                                    </a><!-- more inner pages-->
                                    <div class="parent-wrapper">
                                        <ul class="nav collapse parent show" data-bs-parent="#e-commerce"
                                            id="nv-admin">
                                            <li class="nav-item"><a class="nav-link"
                                                    href="apps/e-commerce/admin/add-product.html">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text">Add product</span></div>
                                                </a><!-- more inner pages-->
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li> --}}

                {{-- settings --}}
                <li class="nav-item">
                    <!-- label-->
                    <p class="navbar-vertical-label"></p>
                    <hr class="navbar-vertical-line" /><!-- parent pages-->
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}"
                            href="#nv-settings" role="button" data-bs-toggle="collapse" aria-expanded="false"
                            aria-controls="nv-settings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon">
                                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                fill="{{ request()->routeIs('admin.setting.*') ? '#3874ff' : '#525b75' }}"
                                                d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36-116.224-25.088-65.28 113.152 79.68 88.192-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136-79.808 88.192 65.344 113.152 116.224-25.024 22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152 24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296 116.288 25.024 65.28-113.152-79.744-88.192 1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136 79.808-88.128-65.344-113.152-116.288 24.96-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384 192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256 128 128 0 0 0 0-256z">
                                            </path>
                                        </g>
                                    </svg>
                                </span>
                                <span class="nav-link-text">Setting</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse"
                                id="nv-settings">
                                <li class="collapsed-nav-item-title d-none">Setting</li>
                                {{-- general settings --}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}"
                                        href="wizard.html">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">General</span>
                                        </div>
                                    </a>
                                </li> --}}
                                {{-- MAIL SMTP --}}
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('admin.setting.mail.index') ? 'active' : '' }}"
                                        href="{{ route('admin.setting.mail.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Mail SMTP</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- parent pages-->
                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
            <svg fill="#525b75" height="16px" width="16px" version="1.1" id="Layer_1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 512.04 512.04" xml:space="preserve" stroke="#525b75">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <g>
                            <path
                                d="M508.933,248.353L402.267,141.687c-4.267-4.053-10.987-3.947-15.04,0.213c-3.947,4.16-3.947,10.667,0,14.827 l88.427,88.427H36.4l88.427-88.427c4.053-4.267,3.947-10.987-0.213-15.04c-4.16-3.947-10.667-3.947-14.827,0L3.12,248.353 c-4.16,4.16-4.16,10.88,0,15.04L109.787,370.06c4.267,4.053,10.987,3.947,15.04-0.213c3.947-4.16,3.947-10.667,0-14.827 L36.4,266.593h439.147L387.12,355.02c-4.267,4.053-4.373,10.88-0.213,15.04c4.053,4.267,10.88,4.373,15.04,0.213 c0.107-0.107,0.213-0.213,0.213-0.213l106.667-106.667C513.093,259.34,513.093,252.513,508.933,248.353z">
                            </path>
                        </g>
                    </g>
                </g>
            </svg>
            <span class="navbar-vertical-footer-text ms-2">Collapsed View</span>
        </button>
    </div>
</nav>
