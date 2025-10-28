@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="login-container">
                <div class="row g-0">
                    <!-- Left Side - Login Form -->
                    <div class="col-lg-6">
                        <div class="login-left">
                            <!-- Brand Logo -->
                            <div class="brand-logo">
                                <div class="logo-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="logo-text">UMKM Makanan</div>
                                <div class="logo-tagline">Sistem Management Usaha Kuliner</div>
                            </div>

                            <!-- Login Header -->
                            <div class="auth-header">
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
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus
                                           placeholder="Enter your Email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           placeholder="Enter your password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="remember-forgot">
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

                                <button type="submit" class="btn btn-auth mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </form>

                            <!-- Register Link -->
                            <div class="register-link">
                                <p>Belum punya akun?
                                    <a href="{{ route('register') }}" class="auth-link">Daftar di sini</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - UMKM Image & Stats -->
                    <div class="col-lg-6">
                        <div class="login-right">
                            <div class="login-image">
                                <h3 class="side-title">Login Sekarang!</h3>

                                <!-- Rating -->
                                <div class="rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="rating-text">The product is good!</div>
                                </div>

                                <!-- Stats Container -->
                                <div class="stats-container">
                                    <div class="stat-percentage">89%</div>
                                    <div class="stat-title">Hi rate this year</div>

                                    <div class="stat-item">
                                        <div class="stat-number">10,219</div>
                                        <div class="stat-label">Buyers this year</div>
                                    </div>

                                    <div class="stat-item">
                                        <div class="stat-number">1 box</div>
                                        <div class="stat-label">Average order</div>
                                    </div>

                                    <div class="stat-item">
                                        <div class="stat-number">3.300 × 0.05</div>
                                        <div class="stat-label">Monthly growth</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
