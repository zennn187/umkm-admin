<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem UMKM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
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
            --purple-gradient: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            --blue-gradient: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            --green-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%);
            --orange-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            --red-gradient: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            --pink-gradient: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
        }

        /* TAMBAH: Auth page styling */
        body.auth-page {
            background: var(--purple-gradient) !important;
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
            overflow-x: hidden;
            background-image: url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
        }

        body:not(.auth-page)::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(248, 249, 254, 0.95);
            z-index: -1;
        }

        /* Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15) !important;
        }

        /* Sidebar Styles dengan animasi masuk */
        .sidebar {
            background: var(--purple-gradient);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            box-shadow: 0 0 45px 0 rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s;
            animation: slideInLeft 0.8s ease-out;
            transform-origin: left center;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInDown 0.8s ease-out;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-item {
            margin: 5px 15px;
            animation: fadeInLeft 0.6s ease-out;
            animation-fill-mode: both;
        }

        /* Animasi bertahap untuk menu item */
        .sidebar-nav-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .sidebar-nav-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .sidebar-nav-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .sidebar-nav-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .sidebar-nav-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        .sidebar-nav-item:nth-child(6) {
            animation-delay: 0.6s;
        }

        .sidebar-nav-item:nth-child(7) {
            animation-delay: 0.7s;
        }

        .sidebar-nav-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-nav-link:hover::before {
            left: 100%;
        }

        .sidebar-nav-link:hover,
        .sidebar-nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(8px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav-link i {
            width: 20px;
            margin-right: 10px;
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .sidebar-nav-link:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .sidebar-nav-section {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 15px 10px;
            margin-top: 10px;
            animation: fadeIn 0.8s ease-out;
        }

        /* Main Content dengan animasi masuk - PERBAIKAN: overflow visible */
        .main-content {
            margin-left: 280px;
            min-height: calc(100vh - 200px);
            /* KURANGI TINGGI UNTUK RUANG FOOTER */
            transition: all 0.3s;
            animation: fadeInUp 0.8s ease-out 0.3s both;
            position: relative;
            z-index: 1;
        }

        .navbar-main {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            animation: slideDown 0.5s ease-out;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1050;
            /* PERBAIKAN: z-index untuk navbar */
        }

        .content-container {
            padding: 2rem;
            animation: fadeIn 0.8s ease-out 0.5s both;
            min-height: calc(100vh - 250px);
            /* SESUAIKAN DENGAN FOOTER */
        }

        /* User Dropdown Styles - PERBAIKAN UTAMA */
        .user-info {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            background: rgba(94, 114, 228, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--purple-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .user-details {
            margin-left: 10px;
            text-align: left;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* PERBAIKAN PENTING: Dropdown styling */
        .user-dropdown {
            position: static !important;
            /* PERUBAHAN PENTING */
        }

        .user-dropdown .dropdown-toggle {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
        }

        .user-dropdown .dropdown-toggle:focus {
            box-shadow: none !important;
        }

        .user-dropdown .dropdown-menu {
            border: none !important;
            border-radius: 15px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
            padding: 0.5rem 0 !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            min-width: 220px !important;
            position: absolute !important;
            z-index: 9999 !important;
            /* PERBAIKAN: z-index tinggi */
            transform: translate3d(0px, 45px, 0px) !important;
        }

        /* PERBAIKAN: Dropdown item styling */
        .user-dropdown .dropdown-item {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.9rem !important;
            transition: all 0.3s ease !important;
            border-radius: 8px !important;
            margin: 2px 8px !important;
            color: var(--dark-color) !important;
            display: flex !important;
            align-items: center !important;
            cursor: pointer !important;
        }

        .user-dropdown .dropdown-item:hover {
            background: var(--purple-gradient) !important;
            color: white !important;
            transform: translateX(5px) !important;
        }

        .user-dropdown .dropdown-item i {
            width: 20px !important;
            margin-right: 10px !important;
            font-size: 14px !important;
        }

        .user-dropdown .dropdown-divider {
            margin: 0.5rem 0 !important;
            opacity: 0.2 !important;
        }

        .user-dropdown .dropdown-item.logout-item {
            color: #ef4444 !important;
        }

        .user-dropdown .dropdown-item.logout-item:hover {
            background: var(--red-gradient) !important;
            color: white !important;
        }

        /* Dropdown header */
        .user-dropdown .dropdown-header {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.85rem !important;
            color: var(--dark-color) !important;
            white-space: normal !important;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            border-radius: 15px;
            padding: 1.5rem;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            filter: blur(8px);
            opacity: 0.7;
            z-index: 1;
        }

        .stat-card>* {
            position: relative;
            z-index: 2;
        }

        .stat-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
            background: rgba(255, 255, 255, 0.3);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            animation: countUp 1s ease-out;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
            opacity: 0.9;
        }

        .stat-change.positive {
            color: rgba(255, 255, 255, 0.9);
        }

        .stat-change.negative {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Warna untuk stat cards */
        .stat-card.total-umkm {
            background: var(--blue-gradient);
        }

        .stat-card.total-produk {
            background: var(--green-gradient);
        }

        .stat-card.pesanan-baru {
            background: var(--orange-gradient);
        }

        .stat-card.penjualan-bulanan {
            background: var(--red-gradient);
        }

        .stat-card.user-aktif {
            background: var(--pink-gradient);
        }

        .stat-card.rating {
            background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
        }

        /* Profile Card */
        .profile-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--purple-gradient);
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background: linear-gradient(135deg, #25d366, #128C7E);
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 0 20px rgba(37, 211, 102, 0.5);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: pulse 2s infinite, float 3s ease-in-out infinite;
            transform-origin: center;
            border: 2px solid white;
        }

        .whatsapp-float:hover {
            transform: scale(1.15) rotate(10deg);
            color: white;
            text-decoration: none;
            box-shadow: 0 0 30px rgba(37, 211, 102, 0.8);
        }

        /* Badge colors */
        .badge.bg-danger {
            background: var(--red-gradient) !important;
        }

        .badge.bg-warning {
            background: var(--orange-gradient) !important;
        }

        .badge.bg-success {
            background: var(--green-gradient) !important;
        }

        .badge.bg-info {
            background: var(--blue-gradient) !important;
        }

        .badge.bg-primary {
            background: var(--purple-gradient) !important;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes countUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInLeft {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(37, 211, 102, 0);
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
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 24px;
            }

            .user-details {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            /* PERBAIKAN: Dropdown di mobile */
            .user-dropdown .dropdown-menu {
                position: fixed !important;
                right: 10px !important;
                left: auto !important;
                width: 200px !important;
                z-index: 9999 !important;
            }
        }

        /* ========== FOOTER DENGAN PURPLE GRADIENT SAJA ========== */
        .footer {
            background: var(--purple-gradient) !important;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            width: 100%;
            transition: all 0.3s ease;
            z-index: 100;
            margin-left: 280px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer a:hover {
            color: white;
            transform: translateY(-2px);
        }

        /* Efek hover untuk footer */
        .footer-icon .icon-wrapper {
            transition: all 0.3s ease;
        }

        .footer-icon:hover .icon-wrapper {
            transform: rotate(5deg) scale(1.05);
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .badge-umkm .badge {
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .badge-umkm:hover .badge {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .feature-item {
            transition: all 0.3s ease;
            cursor: default;
        }

        .feature-item:hover {
            transform: translateY(-2px);
        }

        .feature-item:hover i {
            transform: scale(1.2);
        }

        /* Responsive untuk footer */
        @media (max-width: 768px) {
            .footer {
                margin-left: 0 !important;
                padding: 1.5rem 0 !important;
            }

            .footer .row {
                flex-direction: column;
                text-align: center;
            }

            .footer .text-md-start,
            .footer .text-md-end {
                text-align: center !important;
            }
        }

        @media (max-width: 480px) {
            .footer {
                padding: 1.25rem 0 !important;
            }
        }

        .content-container {
            padding: 1rem;
        }

        .user-dropdown .dropdown-menu {
            width: 180px !important;
            right: 5px !important;
        }

        /* PERBAIKAN TAMBAHAN: Pastikan dropdown bisa keluar dari container */
        .navbar-main {
            overflow: visible !important;
        }

        .dropdown-menu {
            z-index: 9999 !important;
        }
    </style>
    @yield('styles')
</head>

<body class="@yield('body-class')">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4 class="mb-0">
                <i class="fas fa-store"></i> UMKM
            </h4>
            <small class="opacity-75">Sistem Manajemen Usaha</small>
        </div>

        <ul class="sidebar-nav">
            @auth
                <li class="sidebar-nav-section">DASHBOARD</li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                @if (auth()->user()->role === 'mitra')
                    <li class="sidebar-nav-item">
                        <a href="{{ route('mitra.dashboard') }}" class="sidebar-nav-link">
                            <i class="fas fa-store"></i> Dashboard Mitra
                        </a>
                    </li>
                @endif
                <li class="sidebar-nav-section">DATA MASTER</li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('umkm.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('umkm.*') ? 'active' : '' }}">
                        <i class="fas fa-building"></i> Data UMKM
                    </a>
                </li>

                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                    <li class="sidebar-nav-item">
                        <a href="{{ route('produk.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i> Data Produk
                        </a>
                    </li>

                    <li class="sidebar-nav-item">
                        <a href="{{ route('pesanan.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i> Data Pesanan
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
                    <li class="sidebar-nav-section">Pengaturan</li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('users.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i> Manajemen User
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('warga.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Data Warga
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('identitas') }}"
                            class="sidebar-nav-link {{ request()->routeIs('identitas') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Identitas
                        </a>
                    </li>
                @endif



            @endauth
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
                        <!-- PERBAIKAN: Dropdown yang lebih sederhana -->
                        <div class="dropdown user-dropdown">
                            <button class="btn btn-link p-0 dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ substr(Auth::check() ? Auth::user()->name : 'G', 0, 1) }}
                                    </div>
                                    <div class="user-details d-none d-md-block">
                                        <div class="user-name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                                        <div class="user-role">
                                            @auth
                                                {{ ucfirst(auth()->user()->role) }}
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @auth
                                    <li>
                                        <div class="dropdown-header">
                                            <strong>{{ Auth::user()->name }}</strong><br>
                                            <small class="text-muted">{{ Auth::user()->email }}</small>
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-circle me-2"></i> Profile Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-edit me-2"></i> Edit Profile
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                            @csrf
                                            <a class="dropdown-item logout-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </a>
                                        </form>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('register') }}">
                                            <i class="fas fa-user-plus me-2"></i> Register
                                        </a>
                                    </li>
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
    </div> <!-- TUTUP .main-content -->

    <!-- Footer dengan Purple Gradient -->
<footer class="footer py-3 text-white">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <!-- Bagian Kiri - sekarang center -->
            <div class="col-md-6 text-center mb-3 mb-md-0">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="footer-icon me-3">
                        <div class="icon-wrapper bg-white bg-opacity-10 p-2 rounded-circle">
                            <i class="fas fa-store fa-lg text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 fs-6">Sistem UMKM Digital</h5> <!-- Tambah fs-6 -->
                        <small class="opacity-75 fs-6">Ekosistem UMKM Modern</small> <!-- Tambah fs-7 -->
                    </div>
                </div>
                <!-- Garis Pemisah -->
                <hr class="my-3 opacity-25">
                <p class="mb-0 opacity-75 small fs-7"> <!-- Tambah fs-7 -->
                    Platform terintegrasi untuk pengelolaan Usaha Mikro, Kecil dan Menengah
                </p>
            </div>

            <!-- Bagian Kanan - sekarang center juga -->
            <div class="col-md-6 text-center">
                <div class="d-flex flex-column align-items-center gap-2">
                    <!-- Copyright -->
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-copyright me-2 opacity-75 fs-6"></i> <!-- Tambah fs-7 -->
                        <span class="opacity-75 fs-7">{{ date('Y') }} - Hak Cipta Dilindungi</span> <!-- Tambah fs-7 -->
                    </div>

                    <!-- Badge -->
                    <div class="badge-umkm">
                        <span class="badge px-3 py-2 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-25 fs-6"> <!-- Tambah fs-7 -->
                            <i class="fas fa-heart text-pink me-1"></i>
                            Dibuat dengan Citra UMKM
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fitur Sistem -->
    </div>
</footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6289505647628?text=Halo,%20saya%20membutuhkan%20informasi%20tentang%20UMKM%20Anda"
        class="whatsapp-float" target="_blank" title="Hubungi Kami via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Deteksi auth pages
            const currentPath = window.location.pathname;
            const authPaths = ['/login', '/register', '/password/reset', '/forgot-password'];

            if (authPaths.some(path => currentPath.includes(path))) {
                document.body.classList.add('auth-page');
            }

            // Sidebar Toggle
            document.getElementById('sidebarToggle')?.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('active');
            });

            // PERBAIKAN SEDERHANA: Inisialisasi dropdown Bootstrap
            const userDropdown = new bootstrap.Dropdown(document.getElementById('userDropdown'));

            // Ensure dropdown is properly initialized
            document.getElementById('userDropdown')?.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent event bubbling
            });

            // Fix untuk memastikan dropdown bisa diklik
            document.querySelectorAll('.user-dropdown .dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Jika ada form logout, biarkan event propagation
                    if (this.classList.contains('logout-item')) {
                        e.preventDefault();
                        if (confirm('Apakah Anda yakin ingin logout?')) {
                            document.getElementById('logoutForm').submit();
                        }
                    }
                });
            });

            // Close dropdown when clicking outside - PERBAIKAN
            document.addEventListener('click', function(e) {
                const dropdown = document.querySelector('.user-dropdown');
                const dropdownMenu = document.querySelector('.user-dropdown .dropdown-menu');

                if (!dropdown.contains(e.target) && dropdownMenu.classList.contains('show')) {
                    const dropdownInstance = bootstrap.Dropdown.getInstance(document.getElementById(
                        'userDropdown'));
                    if (dropdownInstance) {
                        dropdownInstance.hide();
                    }
                }
            });

            // Auto-hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // WhatsApp button effect
            const whatsappButton = document.querySelector('.whatsapp-float');
            if (whatsappButton) {
                whatsappButton.addEventListener('click', function(e) {
                    this.style.animation = 'none';
                    setTimeout(() => {
                        this.style.animation = 'pulse 2s infinite, float 3s ease-in-out infinite';
                    }, 300);
                });
            }

            // Toastr notifications
            @if (session('success'))
                toastr.success('{{ session('success') }}', 'Sukses', {
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    closeButton: true,
                    progressBar: true,
                    newestOnTop: true
                });
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}', 'Error', {
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    closeButton: true,
                    progressBar: true,
                    newestOnTop: true
                });
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}', 'Validation Error', {
                        positionClass: 'toast-top-right',
                        timeOut: 5000,
                        closeButton: true,
                        progressBar: true,
                        newestOnTop: true
                    });
                @endforeach
            @endif

            // User avatar hover effect
            const userAvatar = document.querySelector('.user-avatar');
            if (userAvatar) {
                userAvatar.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1) rotate(5deg)';
                });

                userAvatar.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) rotate(0deg)';
                });
            }

            // Animated counter for stats cards
            function animateCounter(element, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const value = Math.floor(progress * (end - start) + start);

                    // Format angka dengan titik pemisah ribuan
                    element.textContent = value.toLocaleString('id-ID');

                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Initialize stats counters jika di dashboard
            if (window.location.pathname === '/dashboard') {
                // Contoh data - di production ini akan datang dari API
                const statsData = {
                    totalUmkm: 128,
                    totalProduk: 542,
                    pesananBaru: 24,
                    penjualanBulanan: 12500000,
                    userAktif: 48,
                    rating: 4.7
                };

                // Animate counters
                setTimeout(() => {
                    if (document.getElementById('totalUmkm')) {
                        animateCounter(document.getElementById('totalUmkm'), 0, statsData.totalUmkm, 2000);
                    }
                    if (document.getElementById('totalProduk')) {
                        animateCounter(document.getElementById('totalProduk'), 0, statsData.totalProduk,
                            2000);
                    }
                    if (document.getElementById('pesananBaru')) {
                        animateCounter(document.getElementById('pesananBaru'), 0, statsData.pesananBaru,
                            1500);
                    }
                    if (document.getElementById('penjualanBulanan')) {
                        animateCounter(document.getElementById('penjualanBulanan'), 0, statsData
                            .penjualanBulanan, 2500);
                    }
                    if (document.getElementById('userAktif')) {
                        animateCounter(document.getElementById('userAktif'), 0, statsData.userAktif, 2000);
                    }
                    if (document.getElementById('rating')) {
                        // Untuk rating, kita gunakan animasi yang berbeda
                        let ratingElement = document.getElementById('rating');
                        let currentRating = 0;
                        const increment = statsData.rating / 50;
                        const ratingInterval = setInterval(() => {
                            currentRating += increment;
                            ratingElement.textContent = currentRating.toFixed(1);
                            if (currentRating >= statsData.rating) {
                                ratingElement.textContent = statsData.rating.toFixed(1);
                                clearInterval(ratingInterval);
                            }
                        }, 30);
                    }
                }, 500);
            }

            // Hover effect for stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Stat cards click effect
            statCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'translateY(-2px) scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-5px) scale(1.02)';
                    }, 150);
                });
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
