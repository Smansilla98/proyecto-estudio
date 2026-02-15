<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Escuela de Tambores') }} - @yield('title', 'Dashboard')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Nunito:wght@300;400;600;700&family=Open+Sans:wght@300;400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <i class="fas fa-drum"></i>
                <span>Escuela Tambores</span>
            </a>
            <button class="sidebar-toggle d-md-none" id="sidebarToggle">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav class="sidebar-menu">
            <div class="sidebar-menu-item">
                <a href="{{ route('dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="sidebar-menu-item">
                <a href="{{ route('ritmos.index') }}" class="sidebar-menu-link {{ request()->routeIs('ritmos.*') ? 'active' : '' }}">
                    <i class="fas fa-music"></i>
                    <span>Ritmos</span>
                </a>
            </div>
            
            @can('viewAny', App\Models\Video::class)
            <div class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="fas fa-video"></i>
                    <span>Videos</span>
                </a>
            </div>
            @endcan
            
            @can('viewAny', App\Models\Partitura::class)
            <div class="sidebar-menu-item">
                <a href="#" class="sidebar-menu-link">
                    <i class="fas fa-file-alt"></i>
                    <span>Partituras</span>
                </a>
            </div>
            @endcan
            
            @auth
            <div class="sidebar-menu-item" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="#" class="sidebar-menu-link">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </div>
            @endauth
        </nav>
    </aside>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="sidebar-toggle d-md-none" id="mobileSidebarToggle" style="background: none; border: none; font-size: 20px; color: #495057; cursor: pointer;">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="header-search">
                <input type="text" placeholder="Buscar...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        
        <div class="header-right">
            <div class="header-notification">
                <i class="far fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
            
            @auth
            <div class="header-profile dropdown">
                <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" id="profileDropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff&size=40" alt="{{ Auth::user()->name }}" style="width: 40px; height: 40px; border-radius: 50%;">
                    <div style="text-align: left;">
                        <div style="font-weight: 600; font-size: 14px; color: #1e293b;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 12px; color: #6c757d;">
                            @php
                                $userRoles = Auth::user()->getRoleNames();
                            @endphp
                            @if($userRoles->count() > 0)
                                @foreach($userRoles as $role)
                                    {{ ucfirst($role) }}
                                @endforeach
                            @else
                                Usuario
                            @endif
                        </div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 12px; color: #6c757d;"></i>
                </div>
                
                <div class="dropdown-menu" id="profileMenu" style="display: none; position: absolute; top: 100%; right: 0; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 8px; padding: 10px 0; margin-top: 10px; min-width: 200px; z-index: 1000;">
                    <a href="#" class="dropdown-item" style="display: block; padding: 10px 20px; color: #495057; text-decoration: none; transition: background 0.3s;">
                        <i class="fas fa-user" style="margin-right: 10px;"></i> Perfil
                    </a>
                    <a href="#" class="dropdown-item" style="display: block; padding: 10px 20px; color: #495057; text-decoration: none; transition: background 0.3s;">
                        <i class="fas fa-cog" style="margin-right: 10px;"></i> Configuración
                    </a>
                    <div style="border-top: 1px solid #e0e0e0; margin: 5px 0;"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 20px; color: #ef4444; cursor: pointer; font-size: 14px;">
                            <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Sidebar Toggle
        document.getElementById('mobileSidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('active');
        });
        
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
        });

        // Profile Dropdown
        document.getElementById('profileDropdown')?.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = document.getElementById('profileMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.header-profile')) {
                document.getElementById('profileMenu').style.display = 'none';
            }
        });

        // Dropdown item hover
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.background = '#f8fafc';
            });
            item.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
            });
        });
    </script>
</body>
</html>
