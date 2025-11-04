@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Background Image dengan Overlay -->
        <div class="col-lg-6 register-side-image">
            <div class="image-overlay">
                <div class="overlay-content">
                    <h3 class="side-title">Bergabung dengan UMKM Makanan</h3>
                    <p class="side-subtitle">Mulai perjalanan bisnis kuliner Anda bersama kami</p>

                    <!-- Features List -->
                    <div class="features-list">
                        <div class="feature-item">
                            <i class="fas fa-rocket"></i>
                            <span>Mulai bisnis dengan mudah</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Pantau perkembangan real-time</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-users"></i>
                            <span>Jangkau pelanggan lebih luas</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Keamanan data terjamin</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="side-stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">UMKM Terdaftar</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Kepuasan Pengguna</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
            <div class="register-form-container">
                <!-- Brand Logo -->
                <div class="brand-logo text-center mb-4">
                    <div class="logo-icon mb-3">
                        <div class="logo-circle">
                            <i class="fas fa-store"></i>
                        </div>
                    </div>
                    <h1 class="logo-text">UMKM Makanan</h1>
                    <p class="logo-tagline">Daftar Akun Baru</p>
                </div>

                <!-- Register Header -->
                <div class="auth-header text-center mb-4">
                    <h2 class="auth-title">Bergabung Bersama Kami</h2>
                    <p class="auth-subtitle">Buat akun untuk mulai mengelola bisnis Anda</p>
                </div>

                <!-- Alerts -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 ps-3 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autofocus
                                           placeholder="Masukkan nama lengkap Anda">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   placeholder="Masukkan alamat email Anda">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           placeholder="Minimal 6 karakter">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required
                                           placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya menyetujui <a href="#" class="terms-link">Syarat & Ketentuan</a> dan <a href="#" class="terms-link">Kebijakan Privasi</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth w-100 mb-4">
                        <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                    </button>

                    <!-- Login Link -->
                    <div class="login-link text-center">
                        <p class="mb-0">Sudah punya akun?
                            <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
:root {
  --primary-color: #5e72e4;      /* Ungu biru utama */
  --primary-dark: #4a56d8;       /* Ungu biru lebih tua */
  --primary-light: #7a85eb;      /* Ungu biru lebih terang */
  --secondary-color: #2dce89;    /* Hijau */
  --accent-color: #fb6340;       /* Oranye */
  --warning-color: #f5365c;      /* Merah pink */
  --bg-light: #f8f9fe;          /* Background terang */
  --text-dark: #32325d;         /* Text gelap */
  --text-medium: #8898aa;       /* Text medium */
  --text-light: #adb5bd;        /* Text terang */
  --border-light: #e9ecef;      /* Border terang */
}

/* Register Form Styles */
.register-form-container {
    max-width: 450px;
    width: 100%;
    padding: 2rem;
}

.brand-logo .logo-circle {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 1.8rem;
}

.logo-text {
    color: var(--text-dark);
    font-weight: 700;
    font-size: 1.6rem;
    margin-bottom: 0.25rem;
}

.logo-tagline {
    color: var(--text-medium);
    font-size: 0.9rem;
    margin-bottom: 0;
}

.auth-title {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
}

.auth-subtitle {
    color: var(--text-medium);
    font-size: 0.95rem;
}

/* Form Styles */
.form-label {
    color: var(--text-dark);
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.input-group-text {
    background-color: var(--bg-light);
    border: 1px solid var(--border-light);
    border-right: none;
    color: var(--text-medium);
}

.form-control {
    border: 1px solid var(--border-light);
    padding: 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.1);
}

.form-control::placeholder {
    color: var(--text-light);
    font-size: 0.85rem;
}

/* Button Styles */
.btn-auth {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    color: white;
    padding: 0.75rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(94, 114, 228, 0.3);
    color: white;
}

/* Links */
.auth-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.auth-link:hover {
    color: var(--primary-dark);
}

.terms-link {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.2s ease;
}

.terms-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* Right Side Image dengan Opacity Tulisan Rendah */
.register-side-image {
    background-image: url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(94, 114, 228, 0.85), rgba(74, 86, 216, 0.75));
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
}

.overlay-content {
    color: white;
    text-align: center;
    max-width: 500px;
}

/* Opacity rendah untuk tulisan di gambar */
.side-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    opacity: 0.7; /* Opacity rendah */
}

.side-subtitle {
    font-size: 1.1rem;
    margin-bottom: 2.5rem;
    opacity: 0.6; /* Opacity lebih rendah */
}

/* Features List dengan opacity rendah */
.features-list {
    text-align: left;
    margin-bottom: 3rem;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1rem;
    opacity: 0.7; /* Opacity rendah */
}

.feature-item i {
    margin-right: 1rem;
    font-size: 1.1rem;
    width: 20px;
    opacity: 0.8;
}

/* Stats dengan opacity rendah */
.side-stats {
    display: flex;
    justify-content: space-around;
    text-align: center;
}

.stat-item {
    padding: 0 1rem;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    opacity: 0.7; /* Opacity rendah */
}

.stat-label {
    font-size: 0.85rem;
    opacity: 0.6; /* Opacity lebih rendah */
}

/* Alert Styles */
.alert {
    border: none;
    border-radius: 0.5rem;
    padding: 1rem;
    font-size: 0.9rem;
}

.alert-success {
    background-color: rgba(45, 206, 137, 0.1);
    color: var(--secondary-color);
    border-left: 4px solid var(--secondary-color);
}

.alert-danger {
    background-color: rgba(245, 54, 92, 0.1);
    color: var(--warning-color);
    border-left: 4px solid var(--warning-color);
}

.alert-danger ul {
    margin-bottom: 0;
}

/* Form Check */
.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
}

.form-check-label {
    font-size: 0.85rem;
    color: var(--text-medium);
}

/* Responsive */
@media (max-width: 991.98px) {
    .register-side-image {
        display: none;
    }

    .col-lg-6 {
        width: 100%;
    }

    .register-form-container {
        padding: 1.5rem;
    }
}

@media (max-width: 575.98px) {
    .row .col-md-6 {
        width: 100%;
    }

    .side-title {
        font-size: 1.8rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }
}
</style>
@endsection
