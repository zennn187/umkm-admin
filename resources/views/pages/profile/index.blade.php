@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="glass-effect rounded p-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-decoration-none text-primary">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-user"></i> Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="avatar-circle mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 48px; color: white;">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="mb-2">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $user->email }}</p>

                        @php
                            $badgeClass = 'bg-primary';
                            $roleIcon = 'fa-user';
                            $roleName = 'User';

                            if ($user->role === 'super_admin') {
                                $badgeClass = 'bg-danger';
                                $roleIcon = 'fa-crown';
                                $roleName = 'Super Admin';
                            } elseif ($user->role === 'admin') {
                                $badgeClass = 'bg-warning';
                                $roleIcon = 'fa-user-shield';
                                $roleName = 'Admin';
                            } elseif ($user->role === 'mitra') {
                                $badgeClass = 'bg-success';
                                $roleIcon = 'fa-store';
                                $roleName = 'Mitra';
                            }
                        @endphp

                        <span class="badge {{ $badgeClass }} p-2">
                            <i class="fas {{ $roleIcon }} me-1"></i> {{ $roleName }}
                        </span>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </a>

                    <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-lock me-1"></i> Ubah Password
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4"><i class="fas fa-info-circle me-2"></i> Informasi Profile</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                            <p class="mb-0">{{ $user->name }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Email</label>
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>

                        @if($user->phone)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Nomor Telepon</label>
                            <p class="mb-0">{{ $user->phone }}</p>
                        </div>
                        @endif

                        @if($user->gender)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Jenis Kelamin</label>
                            <p class="mb-0">{{ $user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        @endif

                        @if($user->birth_date)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Tanggal Lahir</label>
                            <p class="mb-0">{{ date('d/m/Y', strtotime($user->birth_date)) }}</p>
                        </div>
                        @endif

                        @if($user->address)
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small mb-1">Alamat</label>
                            <p class="mb-0">{{ $user->address }}</p>
                        </div>
                        @endif

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Bergabung Sejak</label>
                            <p class="mb-0">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-lock me-2"></i> Ubah Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password"
                               name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password"
                               name="password" required minlength="8">
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthText = document.getElementById('passwordStrength');

                let strength = 0;
                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                if (strengthText) {
                    if (strength < 50) {
                        strengthText.textContent = 'Lemah';
                        strengthText.className = 'text-danger';
                    } else if (strength < 75) {
                        strengthText.textContent = 'Sedang';
                        strengthText.className = 'text-warning';
                    } else {
                        strengthText.textContent = 'Kuat';
                        strengthText.className = 'text-success';
                    }
                }
            });
        }
    });
</script>
@endsection
