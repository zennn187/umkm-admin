@extends('layouts.app')

@section('title', 'Detail Ulasan Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Ulasan Produk</h1>
        <div class="btn-group">
            <a href="{{ route('ulasan-produk.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('ulasan-produk.edit', $ulasan->ulasan_id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('ulasan-produk.destroy', $ulasan->ulasan_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus ulasan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Ulasan</h6>
                    <span class="badge badge-light">{{ $ulasan->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Produk</h6>
                            <div class="border p-3 rounded">
                                @if($ulasan->produk)
                                    <h5>{{ $ulasan->produk->nama_produk }}</h5>
                                    <p class="mb-1">
                                        <strong>UMKM:</strong> {{ $ulasan->produk->umkm->nama_usaha ?? '-' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Harga:</strong> Rp {{ number_format($ulasan->produk->harga, 0, ',', '.') }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Stok:</strong> {{ $ulasan->produk->stok }}
                                    </p>
                                @else
                                    <span class="text-danger">Produk tidak ditemukan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Warga</h6>
                            <div class="border p-3 rounded">
                                @if($ulasan->warga)
                                    <h5>{{ $ulasan->warga->name }}</h5>
                                    <p class="mb-1">
                                        <strong>NIK:</strong> {{ $ulasan->warga->nik ?? 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>No. HP:</strong> {{ $ulasan->warga->telp ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Alamat:</strong> {{ $ulasan->warga->alamat ?? 'N/A' }}
                                    </p>
                                @else
                                    <span class="text-danger">Data warga tidak ditemukan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h6>Rating</h6>
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $ulasan->rating)
                                        <i class="fas fa-star fa-2x text-warning"></i>
                                    @else
                                        <i class="far fa-star fa-2x text-muted"></i>
                                    @endif
                                @endfor
                                <span class="ml-3 badge badge-primary" style="font-size: 1.2rem;">
                                    {{ $ulasan->rating }}/5
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6>Komentar</h6>
                            <div class="border p-4 rounded">
                                <p class="mb-0" style="white-space: pre-line;">{{ $ulasan->komentar }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Product Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                </div>
                <div class="card-body">
                    @if($ulasan->produk)
                        <div class="text-center mb-3">
                            @if($ulasan->produk->media && $ulasan->produk->media->first())
                                <img src="{{ asset('storage/' . $ulasan->produk->media->first()->file_path) }}"
                                     alt="{{ $ulasan->produk->nama_produk }}"
                                     class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                    <p class="mt-2">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>

                        <h5 class="text-center">{{ $ulasan->produk->nama_produk }}</h5>

                        <div class="mt-3">
                            <p><strong>Deskripsi:</strong></p>
                            <p class="text-justify">{{ Str::limit($ulasan->produk->deskripsi, 200) }}</p>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="text-center p-2 border rounded">
                                        <div class="font-weight-bold text-primary">Harga</div>
                                        <div>Rp {{ number_format($ulasan->produk->harga, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 border rounded">
                                        <div class="font-weight-bold text-primary">Stok</div>
                                        <div>{{ $ulasan->produk->stok }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('produk.show', $ulasan->produk->produk_id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt"></i> Lihat Detail Produk
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Produk tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Metadata</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID Ulasan</strong></td>
                            <td>{{ $ulasan->ulasan_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>{{ $ulasan->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate</strong></td>
                            <td>{{ $ulasan->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @if($ulasan->produk)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Produk Dihapus</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating-display i {
    margin-right: 5px;
}
</style>
@endsection
