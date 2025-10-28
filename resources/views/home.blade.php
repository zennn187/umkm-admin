@extends('layouts.app')

@section('title', 'Home')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 100px 0;
        text-align: center;
    }

    .feature-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        margin-bottom: 30px;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Selamat Datang di UMKM dan Lapak</h1>
        <p class="lead mb-4">Platform terbaik untuk mengelola kebutuhan Anda dengan mudah dan efisien</p>

        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-4 me-2">
                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 me-2">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        @endauth
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2>Fitur Unggulan</h2>
                <p class="lead">Temukan semua yang Anda butuhkan dalam satu platform</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Keamanan Terjamin</h5>
                        <p>Data Anda dilindungi dengan sistem keamanan terbaik</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h5>Cepat & Responsif</h5>
                        <p>Pengalaman pengguna yang cepat dan responsif</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h5>Mobile Friendly</h5>
                        <p>Akses dari perangkat apapun, kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
