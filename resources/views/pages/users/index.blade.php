@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Manajemen User
                    </h4>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah User
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($user->photo)
                                            <img src="{{ asset('storage/photos/' . $user->photo) }}"
                                                 alt="Foto Profil {{ $user->name }}"
                                                 class="rounded-circle"
                                                 style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #e9ecef;">
                                        @else
                                            <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center"
                                                 style="width: 45px; height: 45px; font-size: 16px; font-weight: bold;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->id === auth()->id())
                                                    <span class="badge bg-info ms-1">Anda</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                            <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-{{ $user->is_active ? 'warning' : 'success' }}" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-users fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada user terdaftar.</p>
                                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah User Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
