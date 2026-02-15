<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Escuela de Tambores') - {{ config('app.name', 'Sistema de Aprendizaje') }}</title>
    
    <!-- SB Admin Pro CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('styles')
    
    <style>
        :root {
            --sb-admin-primary: #1e8081;
            --sb-admin-secondary: #22565e;
            --sb-admin-accent: #c94a2d;
            --sb-admin-sidebar-width: 250px;
            --sb-admin-topbar-height: 56px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }

        /* Sidebar SB Admin Pro Style */
        #sidebarToggle {
            cursor: pointer;
        }

        #sidebarToggleTop {
            display: none;
        }

        @media (max-width: 768px) {
            #sidebarToggleTop {
                display: block;
            }
        }

        #wrapper {
            display: flex;
            width: 100%;
            overflow-x: hidden;
        }

        #content-wrapper {
            background-color: #f8f9fc;
            width: 100%;
            overflow-x: hidden;
        }

        #content-wrapper #content {
            flex: 1 0 auto;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sb-admin-sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #224abe 0%, #1e8081 100%);
            flex-shrink: 0;
        }

        .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .sidebar-brand-icon {
            font-size: 2rem;
        }

        .sidebar-brand-text {
            font-size: 0.85rem;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem 1rem;
        }

        .sidebar-heading {
            text-align: left;
            padding: 0 1rem;
            font-weight: 800;
            font-size: 0.65rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
        }

        .sidebar .nav-item {
            position: relative;
        }

        .sidebar .nav-item:last-child {
            margin-bottom: 1rem;
        }

        .sidebar .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.8);
            text-align: left;
            padding: 1rem;
            width: var(--sb-admin-sidebar-width);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.15s;
        }

        .sidebar .nav-item .nav-link i {
            font-size: 0.85rem;
            width: 1.5rem;
            text-align: center;
        }

        .sidebar .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar .nav-item .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-weight: 700;
        }

        .sidebar .nav-item .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #fff;
        }

        /* Topbar */
        .topbar {
            height: var(--sb-admin-topbar-height);
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
        }

        .topbar .navbar-search {
            width: 100%;
        }

        .topbar .topbar-divider {
            width: 0;
            border-right: 1px solid #e3e6f0;
            height: calc(4.375rem - 2rem);
            margin: auto 1rem;
        }

        .topbar .nav-item .nav-link {
            height: 4.375rem;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
        }

        .topbar .nav-item .nav-link:focus {
            outline: none;
        }

        .topbar .dropdown-list {
            padding: 0;
            border: none;
            overflow: hidden;
        }

        .topbar .dropdown-header {
            background-color: var(--sb-admin-primary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 1rem 1.35rem;
        }

        /* Cards */
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
            border: none;
            border-radius: 0.35rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
            padding: 0.75rem 1.35rem;
            margin-bottom: 0;
        }

        .card-body {
            padding: 1.35rem;
        }

        /* Buttons */
        .btn {
            border-radius: 0.35rem;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--sb-admin-primary);
            border-color: var(--sb-admin-primary);
        }

        .btn-primary:hover {
            background-color: #1a6d6e;
            border-color: #1a6d6e;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }

        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }

        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
        }

        .btn-info:hover {
            background-color: #2c9faf;
            border-color: #2c9faf;
        }

        .btn-warning {
            background-color: #f6c23e;
            border-color: #f6c23e;
        }

        .btn-warning:hover {
            background-color: #dda20a;
            border-color: #dda20a;
        }

        /* Forms */
        .form-control,
        .form-select {
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--sb-admin-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 128, 129, 0.25);
        }

        /* Tables */
        .table {
            color: #858796;
        }

        .table thead th {
            background-color: #f8f9fc;
            border-bottom: 2px solid #e3e6f0;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.1rem;
        }

        .table tbody tr:hover {
            background-color: #f8f9fc;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 0.35rem 0.65rem;
        }

        /* Alerts */
        .alert {
            border-radius: 0.35rem;
            border: none;
        }

        /* Main Content */
        .container-fluid {
            padding: 1.5rem;
        }

        /* User Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1040;
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.toggled {
                transform: translateX(0);
            }

            #content-wrapper {
                margin-left: 0 !important;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-drum"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Escuela Tambores</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Contenido
            </div>

            <!-- Nav Item - Tambores -->
            <li class="nav-item {{ request()->routeIs('tambores.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tambores.index') }}">
                    <i class="fas fa-fw fa-drum"></i>
                    <span>Tambores</span>
                </a>
            </li>

            <!-- Nav Item - Ritmos -->
            <li class="nav-item {{ request()->routeIs('ritmos.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ritmos.index') }}">
                    <i class="fas fa-fw fa-music"></i>
                    <span>Ritmos</span>
                </a>
            </li>

            @can('viewAny', App\Models\Video::class)
            <!-- Nav Item - Videos -->
            <li class="nav-item {{ request()->routeIs('videos.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('videos.index') }}">
                    <i class="fas fa-fw fa-video"></i>
                    <span>Videos</span>
                </a>
            </li>
            @endcan

            @can('viewAny', App\Models\Partitura::class)
            <!-- Nav Item - Partituras -->
            <li class="nav-item {{ request()->routeIs('partituras.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('partituras.index') }}">
                    <i class="fas fa-fw fa-file-pdf"></i>
                    <span>Partituras</span>
                </a>
            </li>
            @endcan

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <i class="fas fa-user-circle fa-fw"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuración
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Errores de validación:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ config('app.name') }} {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SB Admin Pro JS -->
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });

        document.getElementById('sidebarToggleTop')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('toggled');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggleTop');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('toggled')) {
                    sidebar.classList.remove('toggled');
                }
            }
        });

        // Scroll to top button
        window.addEventListener('scroll', function() {
            const scrollBtn = document.querySelector('.scroll-to-top');
            if (window.pageYOffset > 100) {
                scrollBtn.style.display = 'block';
            } else {
                scrollBtn.style.display = 'none';
            }
        });

        document.querySelector('.scroll-to-top')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // SweetAlert2 for flash messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
