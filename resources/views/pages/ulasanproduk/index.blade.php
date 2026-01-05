@extends('layouts.app')

@section('title', 'Ulasan Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ulasan Produk</h1>
        <div class="btn-group">
            <a href="{{ route('ulasan-produk.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Ulasan
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ulasan-produk.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label>Produk</label>
                        <select name="produk_id" class="form-control">
                            <option value="">Semua Produk</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->produk_id }}" {{ request('produk_id') == $produk->produk_id ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Rating</label>
                        <select name="rating" class="form-control">
                            <option value="">Semua Rating</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>★★★★★ (5)</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>★★★★ (4)</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>★★★ (3)</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>★★ (2)</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>★ (1)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari komentar..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('ulasan-produk.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Ulasan Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Warga</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ulasans as $index => $ulasan)
                        <tr>
                            <td>{{ ($ulasans->currentPage() - 1) * $ulasans->perPage() + $index + 1 }}</td>
                            <td>
                                @if($ulasan->produk)
                                    <strong>{{ $ulasan->produk->nama_produk }}</strong><br>
                                    <small class="text-muted">{{ $ulasan->produk->umkm->nama_usaha ?? '-' }}</small>
                                @else
                                    <span class="text-danger">Produk tidak ditemukan</span>
                                @endif
                            </td>
                            <td>{{ $ulasan->warga->name ?? 'Tidak diketahui' }}</td>
                            <td>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $ulasan->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="badge badge-primary ml-2">{{ $ulasan->rating }}/5</span>
                                </div>
                            </td>
                            <td>
                                @if(strlen($ulasan->komentar) > 100)
                                    {{ substr($ulasan->komentar, 0, 100) }}...
                                @else
                                    {{ $ulasan->komentar }}
                                @endif
                            </td>
                            <td>{{ $ulasan->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('ulasan-produk.show', $ulasan->ulasan_id) }}" class="btn btn-info" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('ulasan-produk.edit', $ulasan->ulasan_id) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('ulasan-produk.destroy', $ulasan->ulasan_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus ulasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data ulasan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $ulasans->withQueryString()->links() }}
            </div>

            <!-- Summary -->
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Ulasan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUlasan }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Rata-rata Rating</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($avgRating, 1) }}/5</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-star fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating {
    font-size: 14px;
}
</style>
@endsection
