<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem UMKM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #5e72e4;
            --secondary-color: #825ee4;
            --success-color: #2dce89;
            --danger-color: #f5365c;
            --warning-color: #fb6340;
            --info-color: #11cdef;
            --dark-color: #172b4d;
            --light-color: #f8f9fa;
        }

        /* TAMBAH: Auth page styling */
        body.auth-page {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
            margin: 0;
        }

        /* TAMBAH: Sembunyikan sidebar dan main content di auth pages */
        body.auth-page .sidebar,
        body.auth-page .main-content,
        body.auth-page .whatsapp-float {
            display: none !important;
        }

        /* DEFAULT: Styling untuk non-auth pages */
        body:not(.auth-page) {
            background-color: #f8f9fe;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            box-shadow: 0 0 45px 0 rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-item {
            margin: 5px 15px;
        }

        .sidebar-nav-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .sidebar-nav-link:hover,
        .sidebar-nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-nav-link i {
            width: 20px;
            margin-right: 10px;
            font-size: 14px;
        }

        .sidebar-nav-section {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 15px 10px;
            margin-top: 10px;
        }

        .sidebar-nav-subitem {
            margin-left: 20px;
        }

        .sidebar-nav-sublink {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            font-size: 14px;
            transition: all 0.3s;
        }

        .sidebar-nav-sublink:hover,
        .sidebar-nav-sublink.active {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .sidebar-nav-sublink i {
            font-size: 12px;
            margin-right: 8px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .navbar-main {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .content-container {
            padding: 2rem;
        }

        /* Card Styles */
        .dashboard-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .card-gradient-1 {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .card-gradient-2 {
            background: linear-gradient(135deg, var(--success-color) 0%, #1aae6f 100%);
        }

        .card-gradient-3 {
            background: linear-gradient(135deg, var(--warning-color) 0%, #fa3a0e 100%);
        }

        .card-gradient-4 {
            background: linear-gradient(135deg, var(--danger-color) 0%, #ec0c38 100%);
        }

        .stat-card {
            color: white;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stat-title {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.75rem;
            display: flex;
            align-items: center;
        }

        /* WhatsApp Floating Button Styles */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .whatsapp-float:hover {
            background-color: #128C7E;
            transform: scale(1.1);
            color: white;
            text-decoration: none;
        }

        .whatsapp-float i {
            margin-top: 2px;
        }

        /* Pulse animation for WhatsApp button */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -280px;
                width: 280px;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .whatsapp-float {
                width: 55px;
                height: 55px;
                bottom: 20px;
                right: 20px;
                font-size: 25px;
            }
        }

        @media (max-width: 480px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 15px;
                right: 15px;
                font-size: 22px;
            }
        }
    </style>
    @yield('styles')
</head>

<body class="@yield('body-class')">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <h4 class="mb-0">
                <i class="fas fa-store"></i> SISTEM UMKM
            </h4>
            <small class="opacity-75">Manajemen Usaha Mikro</small>
        </div>

        <!-- Navigation -->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-section">DASHBOARD</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <li class="sidebar-nav-section">DATA MASTER</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('umkm.index') }}"
                    class="sidebar-nav-link {{ request()->is('umkm*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Data UMKM
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('produk.index') }}"
                    class="sidebar-nav-link {{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Data Produk
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('pesanan.index') }}"
                    class="sidebar-nav-link {{ request()->is('pesanan*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Data Pesanan
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('laporan.penjualan') }}"
                    class="sidebar-nav-link {{ request()->is('laporan/penjualan') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Laporan Penjualan
                </a>
            </li>

            <li class="sidebar-nav-section">MANAJEMEN USER</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('users.index') }}"
                    class="sidebar-nav-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> Manajemen User
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar-main">
            <div class="container-fluid">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div>
                        <button class="btn btn-outline-primary d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h4 class="mb-0 d-none d-md-block">
                            <i class="fas @yield('icon', 'fa-tachometer-alt') me-2"></i>@yield('title', 'Dashboard')
                        </h4>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="me-3 d-none d-md-block">
                            <small class="text-muted">Selamat datang,</small>
                            <strong>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</strong>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @auth
                                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user"></i>
                                            Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>
                                                Logout</button>
                                        </form>
                                    </li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('login') }}"><i
                                                class="fas fa-sign-in-alt"></i> Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}"><i
                                                class="fas fa-user-plus"></i> Register</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="content-container">
            @yield('content')
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6289505647628?text=Halo,%20saya%20membutuhkan%20informasi%20tentang%20UMKM%20Anda"
        class="whatsapp-float" target="_blank" title="Hubungi Kami via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // TAMBAH: Auto-detect auth pages dan tambah class ke body
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const authPaths = ['/login', '/register', '/password/reset'];

            // Check jika current path adalah auth page
            if (authPaths.some(path => currentPath.includes(path))) {
                document.body.classList.add('auth-page');
                console.log('Auth page detected - hiding sidebar');
            }

            // Sidebar Toggle for Mobile
            document.getElementById('sidebarToggle')?.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Active submenu handling
            const currentPath2 = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar-nav-link, .sidebar-nav-sublink');

            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath2) {
                    link.classList.add('active');
                    // Expand parent if it's a sublink
                    if (link.classList.contains('sidebar-nav-sublink')) {
                        const parentLink = link.closest('.sidebar-nav-item').querySelector(
                            '.sidebar-nav-link');
                        if (parentLink) {
                            parentLink.classList.add('active');
                        }
                    }
                }
            });

            // WhatsApp button interaction
            const whatsappButton = document.querySelector('.whatsapp-float');

            if (whatsappButton) {
                // Add click animation
                whatsappButton.addEventListener('click', function() {
                    this.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1.1)';
                    }, 150);
                });
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
