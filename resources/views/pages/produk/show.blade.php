@extends('layouts.app')

@section('title', 'Detail Produk')
@section('icon', 'fa-eye')

@section('content')
    <div class="card">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Detail Produk</h5>
                <div class="btn-group">
                    <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <h4 class="text-primary">{{ $produk->nama_produk }}</h4>
                        <p class="text-muted">{{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted">Informasi Produk</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <strong><i class="fas fa-tag me-2"></i>Jenis Produk:</strong>
                                        <span class="float-end">{{ $produk->jenis_produk ?? '-' }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong><i class="fas fa-store me-2"></i>UMKM:</strong>
                                        <span class="float-end">{{ $produk->umkm->nama_usaha }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong><i class="fas fa-money-bill-wave me-2"></i>Harga:</strong>
                                        <span class="float-end">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted">Status & Stok</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <strong><i class="fas fa-boxes me-2"></i>Stok:</strong>
                                        <span class="float-end">
                                            @if($produk->stok > 0)
                                                <span class="badge bg-success">{{ $produk->stok }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $produk->stok }}</span>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <strong><i class="fas fa-info-circle me-2"></i>Status:</strong>
                                        <span class="float-end">
                                            @if($produk->status == 'Aktif')
                                                <span class="badge bg-success">{{ $produk->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $produk->status }}</span>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <strong><i class="fas fa-calendar-alt me-2"></i>Dibuat:</strong>
                                        <span class="float-end">{{ $produk->created_at->format('d/m/Y H:i') }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong><i class="fas fa-calendar-check me-2"></i>Diperbarui:</strong>
                                        <span class="float-end">{{ $produk->updated_at->format('d/m/Y H:i') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi UMKM</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="text-primary">{{ $produk->umkm->nama_usaha }}</h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user me-1"></i>
                                {{ $produk->umkm->nama_pemilik }}
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-phone me-1"></i>
                                {{ $produk->umkm->no_telepon }}
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $produk->umkm->alamat_usaha }}
                            </p>
                            <p class="text-muted small">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $produk->umkm->email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
                <div class="btn-group">
                    <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Produk
                    </a>
                    <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ms-2"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
