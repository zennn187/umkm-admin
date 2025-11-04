@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Side - Background Image dengan Overlay -->
        <div class="col-lg-6 login-side-image">
            <div class="image-overlay">
                <div class="overlay-content">
                    <h3 class="side-title">Login ke UMKM Makanan</h3>
                    <p class="side-subtitle">Kelola bisnis kuliner Anda dengan mudah dan efisien</p>

                    <!-- Features List -->
                    <div class="features-list">
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Pantau perkembangan bisnis</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-box"></i>
                            <span>Kelola produk dan stok</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-users"></i>
                            <span>Jangkau lebih banyak pelanggan</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-cog"></i>
                            <span>Fitur manajemen lengkap</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="side-stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">UMKM Terdaftar</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Produk Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Kepuasan Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
            <div class="login-form-container">
                <!-- Brand Logo -->
                <div class="brand-logo text-center mb-5">
                    <div class="logo-icon mb-3">
                        <div class="logo-circle">
                            <i class="fas fa-store"></i>
                        </div>
                    </div>
                    <h1 class="logo-text">UMKM Makanan</h1>
                    <p class="logo-tagline">Sistem Management Usaha Kuliner</p>
                </div>

                <!-- Login Header -->
                <div class="auth-header text-center mb-4">
                    <h2 class="auth-title">Hi, Welcome Back</h2>
                    <p class="auth-subtitle">Please sign in with your account</p>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
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
                                   autofocus
                                   placeholder="Enter your Email">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
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
                                   placeholder="Enter your password">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="remember-forgot d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-auth w-100 mb-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </form>

                <!-- Register Link -->
                <div class="register-link text-center">
                    <p class="mb-0">Belum punya akun?
                        <a href="{{ route('register') }}" class="auth-link">Daftar di sini</a>
                    </p>
                </div>
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

/* Login Form Styles */
.login-form-container {
    max-width: 400px;
    width: 100%;
    padding: 2rem;
}

.brand-logo .logo-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
}

.logo-text {
    color: var(--text-dark);
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.logo-tagline {
    color: var(--text-medium);
    font-size: 0.9rem;
}

.auth-title {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
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
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.1);
}

.form-control::placeholder {
    color: var(--text-light);
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
}

.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(94, 114, 228, 0.3);
    color: white;
}

/* Links */
.forgot-password {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s ease;
}

.forgot-password:hover {
    color: var(--primary-dark);
}

.auth-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.auth-link:hover {
    color: var(--primary-dark);
}

/* Left Side Image dengan Opacity Tulisan Rendah */
.login-side-image {
    background-image: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80');
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
    font-size: 2.5rem;
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
    font-size: 1.1rem;
    opacity: 0.7; /* Opacity rendah */
}

.feature-item i {
    margin-right: 1rem;
    font-size: 1.2rem;
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
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    opacity: 0.7; /* Opacity rendah */
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.6; /* Opacity lebih rendah */
}

/* Alert Styles */
.alert {
    border: none;
    border-radius: 0.5rem;
    padding: 1rem;
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
    color: var(--text-medium);
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 991.98px) {
    .login-side-image {
        display: none;
    }

    .col-lg-6 {
        width: 100%;
    }
}

@media (max-width: 575.98px) {
    .login-form-container {
        padding: 1.5rem;
    }

    .remember-forgot {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .side-title {
        font-size: 2rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }
}
</style>
@endsection
