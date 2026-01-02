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

{{-- FILTER DAN SEARCH --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('produk.index') }}" method="GET">
            <div class="row g-3">
                {{-- Search Input --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Pencarian</label>
                    <input type="text" class="form-control" id="search" name="search"
                           placeholder="Cari nama produk, jenis, deskripsi..."
                           value="{{ request('search') }}">
                </div>

                {{-- Filter Jenis Produk --}}
                <div class="col-md-2">
                    <label for="jenis_produk" class="form-label">Jenis Produk</label>
                    <select class="form-select" id="jenis_produk" name="jenis_produk">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisProduk as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_produk') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Filter UMKM --}}
                <div class="col-md-2">
                    <label for="umkm_id" class="form-label">UMKM</label>
                    <select class="form-select" id="umkm_id" name="umkm_id">
                        <option value="">Semua UMKM</option>
                        @foreach($umkms as $umkm)
                            <option value="{{ $umkm->umkm_id }}" {{ request('umkm_id') == $umkm->umkm_id ? 'selected' : '' }}>
                                {{ $umkm->nama_usaha }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Terapkan
                        </button>
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- Info Filter Aktif --}}
        @if(request()->hasAny(['search', 'status', 'umkm_id', 'stok_filter']))
        <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
            <div>
                <i class="fas fa-info-circle"></i>
                Menampilkan hasil filter:
                @if(request('search')) <span class="badge bg-primary">Pencarian: "{{ request('search') }}"</span> @endif
                @if(request('status')) <span class="badge bg-success">Status: {{ request('status') }}</span> @endif
                @if(request('umkm_id'))
                    @php
                        $selectedUmkm = $umkms->where('umkm_id', request('umkm_id'))->first();
                    @endphp
                    @if($selectedUmkm)
                        <span class="badge bg-warning">UMKM: {{ $selectedUmkm->nama_usaha }}</span>
                    @endif
                @endif
                @if(request('stok_filter') == 'tersedia') <span class="badge bg-info">Stok Tersedia</span> @endif
                @if(request('stok_filter') == 'habis') <span class="badge bg-danger">Stok Habis</span> @endif
            </div>
            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-times"></i> Hapus Filter
            </a>
        </div>
        @endif

        @if($produks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
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
                        <td>{{ $loop->iteration + ($produks->currentPage()-1) * $produks->perPage() }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->umkm->nama_usaha }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($produk->stok > 0)
                                <span class="badge bg-success">{{ $produk->stok }}</span>
                            @else
                                <span class="badge bg-danger">{{ $produk->stok }}</span>
                            @endif
                        </td>
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
                                <a href="{{ route('produk.show', $produk->produk_id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="mt-3">
                {{ $produks->links('pagination::bootstrap-5') }}
            </div>

        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-box fa-3x text-muted mb-3"></i>
            @if(request()->hasAny(['search', 'status', 'umkm_id', 'stok_filter']))
                <h5>Tidak ada produk yang sesuai dengan filter</h5>
                <p class="text-muted">Coba ubah kriteria pencarian atau filter Anda.</p>
                <a href="{{ route('produk.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-2"></i>Tampilkan Semua Produk
                </a>
            @else
                <h5>Belum ada data Produk</h5>
                <p class="text-muted">Silakan tambah data produk pertama Anda.</p>
                <a href="{{ route('produk.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk Pertama
                </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
