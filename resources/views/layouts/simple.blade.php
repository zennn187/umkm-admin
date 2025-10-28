@extends('layouts.simple')

@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="auth-card">
            <div class="auth-header">
                <h3 class="mb-0">Login</h3>
                <p class="mb-0">Masuk ke akun Anda</p>
            </div>
            <div class="auth-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                               class="form-control"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="email@example.com">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               required
                               placeholder="Minimal 3 karakter">
                    </div>

                    <button type="submit" class="btn btn-custom w-100 py-2 mb-3">Login</button>

                    <div class="text-center">
                        <p class="mb-0">Belum punya akun?
                            <a href="{{ route('register') }}" class="text-decoration-none">Daftar di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
