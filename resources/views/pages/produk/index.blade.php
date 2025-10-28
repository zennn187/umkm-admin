@extends('layouts.app')

@section('title', 'Data Produk')
@section('icon', 'fa-box')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Data Produk</h4>
    <a href="{{ route('produk.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah Produk
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
        @if($produks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>UMKM</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->umkm->nama_usaha }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>
                            @if($produk->status == 'Tersedia')
                                <span class="badge bg-success">{{ $produk->status }}</span>
                            @elseif($produk->status == 'Habis')
                                <span class="badge bg-danger">{{ $produk->status }}</span>
                            @else
                                <span class="badge bg-warning">{{ $produk->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('produk.show', $produk->produk_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
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
            <i class="fas fa-box fa-3x text-muted mb-3"></i>
            <h5>Belum ada data Produk</h5>
            <p class="text-muted">Silakan tambah data produk pertama Anda.</p>
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Tambah Produk Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
