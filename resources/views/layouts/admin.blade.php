    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Anemoia - Admin Panel</title>

        <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

        <style>
            /* Scrollbar Hiding */
            /* Chrome, Safari and Opera */
            ::-webkit-scrollbar {
                display: none;
            }
            /* IE and Edge */
            -ms-overflow-style: none;
            /* Firefox */
            scrollbar-width: none;

            :root {
                --bs-primary: #64a19d;
                --bs-primary-rgb: 100, 161, 157;
                --bs-link-color: #64a19d;
                --bs-link-hover-color: #51827e;
            }
            .btn-primary {
                --bs-btn-bg: #64a19d;
                --bs-btn-border-color: #64a19d;
                --bs-btn-hover-bg: #51827e;
                --bs-btn-hover-border-color: #51827e;
                --bs-btn-active-bg: #51827e;
                --bs-btn-active-border-color: #51827e;
                --bs-btn-disabled-bg: #64a19d;
                --bs-btn-disabled-border-color: #64a19d;
            }
            .btn-secondary {
                --bs-btn-color: #fff;
                --bs-btn-bg: #212529;
                --bs-btn-border-color: #212529;
                --bs-btn-hover-color: #fff;
                --bs-btn-hover-bg: #424649;
                --bs-btn-hover-border-color: #373b3e;
            }
            .btn-info {
                --bs-btn-color: #000;
                --bs-btn-bg: #adb5bd;
                --bs-btn-border-color: #adb5bd;
                --bs-btn-hover-bg: #ced4da;
                --bs-btn-hover-border-color: #ced4da;
            }
            #accordionSidebar {
                background-image: none;
                background-color: #212529 !important; /* Lighter charcoal */
            }
            .sidebar-brand {
                color: #fff !important;
            }
            .sidebar .nav-link {
                color: rgba(255, 255, 255, 0.5);
            }
            .sidebar .nav-link:hover {
                color: rgba(255, 255, 255, 0.75);
            }
            .sidebar .nav-item.active .nav-link {
                color: #fff;
                background-color: rgba(255, 255, 255, 0.1);
            }
            .sidebar .sidebar-heading {
                color: rgba(255, 255, 255, 0.3);
            }
            .sidebar-divider {
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Improved Mobile Spacing */
            @media (max-width: 768px) {
                .container-fluid {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
                .card-header {
                    padding: 0.75rem 1rem;
                }
                .btn-sm {
                   padding: 0.375rem 0.75rem; /* Larger touch target */
                }
            }
        </style>
    </head>
    <body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}" target="_blank">
                <div class="sidebar-brand-text mx-3">Anem[o]ia</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Content</div>
            <li class="nav-item {{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.photos.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.galleries.index') }}">
                    <i class="fas fa-fw fa-images"></i>
                    <span>Galleries</span></a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.posts.index') }}">
                    <i class="fas fa-fw fa-pen-square"></i>
                    <span>Blog</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                                <span class="nav-link text-gray-600 small">
                                    {{ Auth::user()->name }}
                                </span>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user fa-sm fa-fw me-3 text-gray-400"></i>
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw me-3 text-gray-400"></i>
                                Settings
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.activity_log.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.activity_log.index') }}">
                                <i class="fas fa-fw fa-list"></i>
                                <span>Activity Log</span></a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-3 text-gray-400"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
    </body>
    </html>
