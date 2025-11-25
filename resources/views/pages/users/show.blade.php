@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Detail User: {{ $user->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($user->photo)
                                <img src="{{ asset('storage/photos/' . $user->photo) }}"
                                     alt="Foto Profil {{ $user->name }}"
                                     class="img-thumbnail rounded-circle mb-3"
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <div class="avatar-lg bg-primary rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                     style="width: 200px; height: 200px; font-size: 60px; font-weight: bold;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <h4>{{ $user->name }}</h4>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }} mb-2">
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} mb-2">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Telepon</label>
                                        <p class="form-control-plaintext">{{ $user->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <p class="form-control-plaintext">{{ $user->alamat ?? '-' }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Dibuat</label>
                                        <p class="form-control-plaintext">{{ $user->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Terakhir Diupdate</label>
                                        <p class="form-control-plaintext">{{ $user->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                        <div class="btn-group">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit User
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }} me-2"></i>
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
