@extends('layouts.app')

@section('title', 'Data UMKM')
@section('icon', 'fa-building')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Data UMKM</h4>
    <a href="{{ route('umkm.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah UMKM
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($umkms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Alamat</th>
                        <th>Kategori</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($umkms as $umkm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $umkm->nama_usaha }}</td>
                        <td>{{ $umkm->pemilik }}</td>
                        <td>{{ $umkm->alamat }}, RT {{ $umkm->rt }}/RW {{ $umkm->rw }}</td>
                        <td>{{ $umkm->kategori }}</td>
                        <td>{{ $umkm->kontak }}</td>
                        <td>
                            <span class="badge bg-{{ $umkm->status == 'Aktif' ? 'success' : 'danger' }}">
                                {{ $umkm->status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('umkm.show', $umkm->umkm_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('umkm.destroy', $umkm->umkm_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-building fa-3x text-muted mb-3"></i>
            <h5>Belum ada data UMKM</h5>
            <p class="text-muted">Silakan tambah data UMKM pertama Anda.</p>
            <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Tambah UMKM Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
