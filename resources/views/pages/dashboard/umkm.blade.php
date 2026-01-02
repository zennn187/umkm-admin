@extends('layouts.app')

@section('title', 'Data UMKM')
@section('body-class', '')
@section('icon', 'fa-building')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-building me-2"></i>Data UMKM</h3>
            @if(Auth::user()->role === 'mitra' || Auth::user()->role === 'admin')
            <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah UMKM
            </a>
            @endif
        </div>
    </div>
</div>

<div class="profile-card p-4">
    @if($umkms->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama UMKM</th>
                    <th>Pemilik</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($umkms as $umkm)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-2">
                                <i class="fas fa-store"></i>
                            </div>
                            <div>
                                <strong>{{ $umkm->nama_umkm }}</strong><br>
                                <small class="text-muted">{{ $umkm->alamat }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $umkm->user->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-info">{{ $umkm->kategori ?? 'Makanan' }}</span>
                    </td>
                    <td>
                        @if($umkm->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                        @elseif($umkm->status === 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $umkm->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('umkm.show', $umkm->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('umkm.edit', $umkm->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(Auth::user()->role === 'super_admin' || (Auth::user()->role === 'mitra' && $umkm->user_id === Auth::id()))
                            <form action="{{ route('umkm.destroy', $umkm->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($umkms->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $umkms->links() }}
    </div>
    @endif

    @else
    <div class="text-center py-5">
        <i class="fas fa-store fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">Belum ada data UMKM</h5>
        @if(Auth::user()->role === 'mitra')
        <p class="text-muted">Mulai daftarkan UMKM Anda untuk menjual produk</p>
        <a href="{{ route('umkm.create') }}" class="btn btn-primary mt-3">
            <i class="fas fa-plus me-2"></i>Daftarkan UMKM
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
