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
        <link href="{{ asset('admin_assets/css/custom.css') }}" rel="stylesheet">

        <style>
            /* Specific fix for scrollbar hiding (browser specific) can stay here or move to custom.css if preferred.
               Keeping here for clarity as it's a specific utility. */
            ::-webkit-scrollbar { display: none; }
            -ms-overflow-style: none;
            scrollbar-width: none;
            
            /* Clean up: Removed inline overrides for colors/buttons as they are now in custom.css */
        </style>
    </head>
    <body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}" target="_blank">
                <div class="sidebar-brand-text mx-3">Anem[o]ia</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                @if(auth()->user()->is_admin)
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Admin Dashboard</span></a>
                @else
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Home Dashboard</span></a>
                @endif
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
            <hr class="sidebar-divider">
            <div class="sidebar-heading">System</div>
            <li class="nav-item {{ request()->routeIs('admin.activity_log.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.activity_log.index') }}">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Activity Log</span></a>
            </li>

            <!-- Nav Item - User Management -->
            <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span></a>
            </li>

            <hr class="sidebar-divider">
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-fw fa-external-link-alt"></i>
                    <span>View Website</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Theme Toggler (New) -->
            <div class="theme-switch-wrapper text-center">
                 <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="themeSwitch">
                    <label class="custom-control-label" for="themeSwitch">
                        <span id="themeLabel">Light Mode</span>
                    </label>
                </div>
            </div>

             <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-3">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- ... Content ... -->
            <div id="content">
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                    
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ms-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>

    {{-- Theme Switcher Logic --}}
    <script>
        const toggleSwitch = document.querySelector('#themeSwitch');
        const themeLabel = document.querySelector('#themeLabel');
        const currentTheme = localStorage.getItem('theme');

        // Function to Apply Theme
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                toggleSwitch.checked = true;
                themeLabel.textContent = 'Dark Mode';
            } else {
                toggleSwitch.checked = false;
                themeLabel.textContent = 'Light Mode';
            }
        }

        if (currentTheme) {
            applyTheme(currentTheme);
        } else {
            // Default to LIGHT MODE (Original) if no preference
            applyTheme('light');
        }

        function switchTheme(e) {
            if (e.target.checked) {
                localStorage.setItem('theme', 'dark');
                applyTheme('dark');
            } else {
                localStorage.setItem('theme', 'light');
                applyTheme('light');
            }    
        }

        toggleSwitch.addEventListener('change', switchTheme, false);
    </script>
    </body>
    </html>
