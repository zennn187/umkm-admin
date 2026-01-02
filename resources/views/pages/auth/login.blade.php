@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container-fluid auth-container">
    <div class="row min-vh-100">
        <!-- Left Side - Background Image dengan Overlay -->
        <div class="col-lg-6 login-side-image">
            <div class="image-overlay">
                <div class="overlay-content">
                    <div class="logo-side">
                        <div class="logo-circle-side">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h1 class="side-logo-text">UMKM Makanan</h1>
                    </div>

                    <h3 class="side-title">Login ke UMKM Makanan</h3>
                    <p class="side-subtitle">Kelola bisnis kuliner Anda dengan mudah dan efisien</p>

                    <!-- Features List dengan efek mewah -->
                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon-wrapper">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="feature-text">
                                <h6>Pantau perkembangan bisnis</h6>
                                <p>Dashboard analitik real-time</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon-wrapper">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="feature-text">
                                <h6>Kelola produk dan stok</h6>
                                <p>Sistem inventori terintegrasi</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon-wrapper">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="feature-text">
                                <h6>Jangkau lebih banyak pelanggan</h6>
                                <p>Marketplace digital yang luas</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon-wrapper">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="feature-text">
                                <h6>Fitur manajemen lengkap</h6>
                                <p>Tools bisnis profesional</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats dengan efek glassmorphism -->
                    <div class="side-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">UMKM Terdaftar</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">10000+</div>
                                <div class="stat-label">Produk Aktif</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-smile"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">95%</div>
                                <div class="stat-label">Kepuasan Pengguna</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Auth Forms (Login & Register) -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
            <div class="auth-forms-container">
                <!-- Auth Forms Wrapper -->
                <div class="auth-forms-wrapper">
                    <!-- Login Form -->
                    <div class="auth-form active" id="login-form">
                        <!-- Brand Logo -->
                        <div class="brand-logo text-center mb-4">
                            <div class="logo-wrapper">
                                <div class="logo-circle">
                                    <div class="logo-inner">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="logo-text">UMKM Makanan</h1>
                            <p class="logo-tagline">Sistem Management Usaha Kuliner</p>
                        </div>

                        <!-- Login Header -->
                        <div class="auth-header text-center mb-4">
                            <h2 class="auth-title">Hai, Selamat Datang</h2>
                            <p class="auth-subtitle">Silakan login ke akun Anda</p>
                        </div>

                        <!-- Alerts -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 ps-3 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="auth-form-content">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Email <span class="text-danger">*</span>
                                </label>
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
                                           placeholder="Masukkan email">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key me-2"></i>
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           placeholder="Masukkan password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat Saya
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Login
                                </button>
                            </div>
                        </form>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="mb-0">
                                Belum punya akun?
                                <a href="#" id="showRegister" class="text-decoration-none fw-bold">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <div class="auth-form d-none" id="register-form">
                        <!-- Brand Logo -->
                        <div class="brand-logo text-center mb-4">
                            <div class="logo-wrapper">
                                <div class="logo-circle">
                                    <div class="logo-inner">
                                        <i class="fas fa-utensils"></i>
                                    </div>
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

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('register') }}" class="auth-form-content">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           placeholder="Masukkan nama lengkap">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="register_email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Alamat Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email"
                                           class="form-control"
                                           id="register_email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           placeholder="Masukkan email">
                                </div>
                            </div>

                            <!-- Role Selection -->
                            <div class="mb-3">
    <label class="form-label">
        <i class="fas fa-user-tag me-2"></i>
        Daftar Sebagai <span class="text-danger">*</span>
    </label>
    <div class="row">
        <div class="col-md-4 mb-2">
            <div class="form-check card p-3 h-100">
                <input class="form-check-input" type="radio" name="role" id="role_user" value="user" checked>
                <label class="form-check-label" for="role_user">
                    <div class="text-center">
                        <i class="fas fa-user fa-2x text-primary mb-2"></i>
                        <h6>Pelanggan/User</h6>
                        <small class="text-muted">Membeli produk UMKM makanan</small>
                    </div>
                </label>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="form-check card p-3 h-100">
                <input class="form-check-input" type="radio" name="role" id="role_mitra" value="mitra">
                <label class="form-check-label" for="role_mitra">
                    <div class="text-center">
                        <i class="fas fa-store fa-2x text-success mb-2"></i>
                        <h6>Mitra UMKM</h6>
                        <small class="text-muted">Menjual produk makanan Anda</small>
                    </div>
                </label>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="form-check card p-3 h-100">
                <input class="form-check-input" type="radio" name="role" id="role_super_admin" value="super_admin">
                <label class="form-check-label" for="role_super_admin">
                    <div class="text-center">
                        <i class="fas fa-crown fa-2x text-warning mb-2"></i>
                        <h6>Super Admin</h6>
                        <small class="text-muted">Akses penuh sistem (pilih ini untuk membuat akun admin pertama)</small>
                    </div>
                </label>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="form-check card p-3 h-100">
                <input class="form-check-input" type="radio" name="role" id="role_admin" value="admin" disabled>
                <label class="form-check-label" for="role_admin">
                    <div class="text-center">
                        <i class="fas fa-user-shield fa-2x text-danger mb-2"></i>
                        <h6>Admin</h6>
                        <small class="text-muted">Hanya bisa dibuat oleh Super Admin</small>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <small class="text-muted">
        <i class="fas fa-info-circle"></i>
        • Role "Admin" hanya bisa dibuat oleh Super Admin melalui menu Manajemen User<br>
        • Untuk mengelola sistem, pilih role "Super Admin" saat registrasi pertama kali
    </small>
</div>

                            <!-- Password Fields -->
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <label for="register_password" class="form-label">
                                        <i class="fas fa-key me-2"></i>
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control"
                                               id="register_password"
                                               name="password"
                                               required
                                               placeholder="Masukkan password">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-key me-2"></i>
                                        Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               required
                                               placeholder="Konfirmasi password">
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Saya menyetujui <a href="#" class="text-decoration-none">Syarat & Ketentuan</a> dan
                                        <a href="#" class="text-decoration-none">Kebijakan Privasi</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="mb-0">
                                Sudah punya akun?
                                <a href="#" id="showLogin" class="text-decoration-none fw-bold">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
  --primary-color: #5e72e4;
  --primary-dark: #4a56d8;
  --primary-light: #7a85eb;
  --secondary-color: #2dce89;
  --accent-color: #fb6340;
  --warning-color: #f5365c;
  --info-color: #11cdef;
  --dark-color: #32325d;
  --light-color: #f8f9fe;
  --text-dark: #32325d;
  --text-medium: #8898aa;
  --text-light: #adb5bd;
  --border-light: #e9ecef;
  --shadow-sm: 0 2px 10px rgba(0,0,0,0.05);
  --shadow-md: 0 5px 20px rgba(0,0,0,0.1);
  --shadow-lg: 0 15px 35px rgba(0,0,0,0.15);
  --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  --gradient-success: linear-gradient(135deg, var(--secondary-color), #2dcecc);
}

body {
  background: var(--light-color);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  overflow-x: hidden;
}

.auth-container {
  position: relative;
}

.min-vh-100 {
  min-height: 100vh;
}

/* Left Side Styles */
.login-side-image {
  background-image: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1080&q=80');
  background-size: cover;
  background-position: center;
  position: relative;
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(94, 114, 228, 0.9), rgba(74, 86, 216, 0.8));
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

.overlay-content {
  max-width: 600px;
  color: white;
}

.logo-circle-side {
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
  font-size: 2rem;
  border: 2px solid rgba(255, 255, 255, 0.3);
}

.side-logo-text {
  font-size: 2.2rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 1rem;
}

.side-title {
  font-size: 2rem;
  font-weight: 600;
  text-align: center;
  margin-bottom: 1rem;
}

.side-subtitle {
  font-size: 1.1rem;
  text-align: center;
  margin-bottom: 2rem;
  opacity: 0.9;
}

/* Features List */
.features-list {
  margin-bottom: 3rem;
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
  padding: 1rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  transition: transform 0.3s ease;
}

.feature-item:hover {
  transform: translateX(5px);
  background: rgba(255, 255, 255, 0.15);
}

.feature-icon-wrapper {
  width: 50px;
  height: 50px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  flex-shrink: 0;
}

.feature-text h6 {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.feature-text p {
  font-size: 0.85rem;
  opacity: 0.8;
  margin-bottom: 0;
}

/* Stats */
.side-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
}

.stat-item {
  text-align: center;
  padding: 1rem;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.stat-icon {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.stat-number {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.8rem;
  opacity: 0.9;
}

/* Right Side Styles */
.auth-forms-container {
  max-width: 500px;
  width: 100%;
  padding: 2rem;
}

.logo-wrapper {
  width: 80px;
  height: 80px;
  margin: 0 auto 1rem;
}

.logo-circle {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-inner {
  color: white;
  font-size: 2rem;
}

.logo-text {
  color: var(--text-dark);
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.logo-tagline {
  color: var(--text-medium);
  font-size: 0.95rem;
  margin-bottom: 1.5rem;
}

.auth-title {
  color: var(--text-dark);
  font-weight: 600;
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
}

.auth-subtitle {
  color: var(--text-medium);
  font-size: 0.95rem;
  margin-bottom: 1.5rem;
}

/* Form Styles */
.form-label {
  font-weight: 500;
  color: var(--text-dark);
  margin-bottom: 0.5rem;
}

.input-group-text {
  background-color: #f8f9fe;
  border-color: #e9ecef;
}

.form-control {
  border-color: #e9ecef;
  padding: 0.75rem 1rem;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
}

.btn {
  padding: 0.75rem 1.5rem;
  font-weight: 500;
}

.btn-primary {
  background: var(--gradient-primary);
  border: none;
}

.btn-success {
  background: var(--gradient-success);
  border: none;
}

.btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Role Cards */
.form-check .card {
  border: 2px solid var(--border-light);
  cursor: pointer;
  transition: all 0.3s ease;
}

.form-check-input:checked + .form-check-label .card {
  border-color: var(--primary-color);
  background-color: rgba(94, 114, 228, 0.05);
}

/* Auth Forms */
.auth-form {
  transition: opacity 0.3s ease;
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

@media (max-width: 767.98px) {
  .auth-forms-container {
    padding: 1.5rem;
  }

  .logo-text {
    font-size: 1.8rem;
  }

  .auth-title {
    font-size: 1.6rem;
  }

  .side-stats {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 575.98px) {
  .auth-forms-container {
    padding: 1rem;
  }

  .row .col-md-6 {
    width: 100%;
  }

  .logo-wrapper {
    width: 70px;
    height: 70px;
  }

  .logo-inner {
    font-size: 1.8rem;
  }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
    const password = document.getElementById('password');
    const registerPassword = document.getElementById('register_password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    if (toggleRegisterPassword && registerPassword) {
        toggleRegisterPassword.addEventListener('click', function() {
            const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    // Switch between login and register forms
    const showRegister = document.getElementById('showRegister');
    const showLogin = document.getElementById('showLogin');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    if (showRegister && loginForm && registerForm) {
        showRegister.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.classList.remove('active');
            loginForm.classList.add('d-none');
            registerForm.classList.remove('d-none');
            registerForm.classList.add('active');

            // Scroll to top
            window.scrollTo(0, 0);
        });
    }

    if (showLogin && loginForm && registerForm) {
        showLogin.addEventListener('click', function(e) {
            e.preventDefault();
            registerForm.classList.remove('active');
            registerForm.classList.add('d-none');
            loginForm.classList.remove('d-none');
            loginForm.classList.add('active');

            // Scroll to top
            window.scrollTo(0, 0);
        });
    }

    // Form validation and effects
    const forms = document.querySelectorAll('.auth-form-content');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            }
        });
    });

    // Add animation to feature items
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Role selection effect
    const roleCards = document.querySelectorAll('.form-check .card');
    roleCards.forEach(card => {
        card.addEventListener('click', function() {
            const radio = this.closest('.form-check').querySelector('input[type="radio"]');
            if (!radio.disabled) {
                roleCards.forEach(c => c.style.transform = 'scale(1)');
                this.style.transform = 'scale(1.02)';
            }
        });
    });

    // Check if there are errors in registration form
    @if($errors->any() && old('name'))
    if (showRegister && loginForm && registerForm) {
        showRegister.click();
    }
    @endif
});
</script>
@endpush
@endsection
