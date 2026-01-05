@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- HEADER WITH ICON --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary rounded-circle p-3 me-3">
            <i class="fas fa-shopping-cart text-white fa-2x"></i>
        </div>
        <div>
            <h3 class="mb-1 fw-bold text-primary">Daftar Pesanan</h3>
            <p class="text-muted mb-0">Kelola semua pesanan dari pelanggan</p>
        </div>
    </div>

    {{-- FILTER DAN SEARCH --}}
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filter & Pencarian
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pesanan.index') }}" method="GET">
                <div class="row g-3">
                    {{-- Search Input --}}
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">
                            <i class="fas fa-search me-1"></i>Pencarian
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="search" name="search"
                                   placeholder="Cari nomor pesanan, customer, atau alamat..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-2">
                        <label for="status" class="form-label fw-semibold">
                            <i class="fas fa-tag me-1"></i>Status
                        </label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Filter RT --}}
                    <div class="col-md-2">
                        <label for="rt" class="form-label fw-semibold">
                            <i class="fas fa-map-marker-alt me-1"></i>RT
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">RT</span>
                            <input type="text" class="form-control" id="rt" name="rt"
                                   placeholder="000" value="{{ request('rt') }}">
                        </div>
                    </div>

                    {{-- Filter RW --}}
                    <div class="col-md-2">
                        <label for="rw" class="form-label fw-semibold">
                            <i class="fas fa-map-marker-alt me-1"></i>RW
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">RW</span>
                            <input type="text" class="form-control" id="rw" name="rw"
                                   placeholder="000" value="{{ request('rw') }}">
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-search me-1"></i> Terapkan
                            </button>
                            <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-refresh me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT CARD --}}
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2"></i>Data Pesanan
                </h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-dark me-2 py-2 px-3">
                        <i class="fas fa-database me-1"></i> Total: {{ $pesanans->total() }}
                    </span>
                    <a href="{{ route('pesanan.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Pesanan
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($pesanans->count() > 0)
                {{-- Info Filter Aktif --}}
                @if(request()->hasAny(['search', 'status', 'rt', 'rw']))
                <div class="alert alert-info alert-dismissible fade show m-3 rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg me-3"></i>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-1">Filter Aktif</h6>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @if(request('search'))
                                    <span class="badge bg-primary py-2 px-3">
                                        <i class="fas fa-search me-1"></i> "{{ request('search') }}"
                                    </span>
                                @endif
                                @if(request('status'))
                                    <span class="badge bg-success py-2 px-3">
                                        <i class="fas fa-tag me-1"></i> {{ request('status') }}
                                    </span>
                                @endif
                                @if(request('rt'))
                                    <span class="badge bg-warning text-dark py-2 px-3">
                                        <i class="fas fa-map-marker-alt me-1"></i> RT: {{ request('rt') }}
                                    </span>
                                @endif
                                @if(request('rw'))
                                    <span class="badge bg-warning text-dark py-2 px-3">
                                        <i class="fas fa-map-marker-alt me-1"></i> RW: {{ request('rw') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-sm btn-outline-primary mt-3">
                        <i class="fas fa-times me-1"></i> Hapus Semua Filter
                    </a>
                </div>
                @endif

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nomor Pesanan</th>
                                <th>Customer</th>
                                <th>UMKM</th>
                                <th class="text-end">Total</th>
                                <th>Status</th>
                                <th>Alamat</th>
                                <th>RT/RW</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pesanans as $index => $item)
                            <tr class="align-middle border-bottom border-light">
                                <td class="ps-4 fw-semibold text-muted">{{ $pesanans->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $item->nomor_pesanan }}</div>
                                    <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $item->warga->nama ?? 'Tidak Diketahui' }}</div>
                                    <small class="text-muted">{{ $item->metode_bayar ?? '-' }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $item->umkm->nama_umkm ?? '-' }}</div>
                                    <small class="badge bg-light text-dark">{{ $item->umkm->kategori ?? '-' }}</small>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'Baru' => ['bg' => 'bg-primary', 'icon' => 'fas fa-clock'],
                                            'Diproses' => ['bg' => 'bg-warning', 'icon' => 'fas fa-cogs'],
                                            'Dikirim' => ['bg' => 'bg-info', 'icon' => 'fas fa-shipping-fast'],
                                            'Selesai' => ['bg' => 'bg-success', 'icon' => 'fas fa-check-circle'],
                                            'Dibatalkan' => ['bg' => 'bg-danger', 'icon' => 'fas fa-times-circle']
                                        ];
                                        $config = $statusConfig[$item->status] ?? ['bg' => 'bg-secondary', 'icon' => 'fas fa-question'];
                                    @endphp
                                    <span class="badge {{ $config['bg'] }} py-2 px-3">
                                        <i class="{{ $config['icon'] }} me-1"></i>
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;"
                                         title="{{ $item->alamat_kirim }}">
                                        {{ $item->alamat_kirim }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border py-2 px-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $item->rt }}/{{ $item->rw }}
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pesanan.show', $item->pesanan_id) }}"
                                           class="btn btn-outline-primary btn-sm rounded-start px-3"
                                           title="Detail Pesanan"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pesanan.edit', $item->pesanan_id) }}"
                                           class="btn btn-outline-warning btn-sm"
                                           title="Edit Pesanan"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pesanan.destroy', $item->pesanan_id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-end"
                                                    title="Hapus Pesanan"
                                                    data-bs-toggle="tooltip">
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

                {{-- PAGINATION --}}
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $pesanans->firstItem() }} - {{ $pesanans->lastItem() }}
                            dari {{ $pesanans->total() }} pesanan
                        </div>
                        <nav aria-label="Page navigation">
                            {{ $pesanans->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>

            @else
                {{-- EMPTY STATE --}}
                <div class="text-center py-5 my-4">
                    <div class="mb-4">
                        <i class="fas fa-inbox fa-4x text-muted opacity-25"></i>
                    </div>
                    <h5 class="text-muted mb-3">Belum ada pesanan</h5>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'status', 'rt', 'rw']))
                            Tidak ditemukan pesanan dengan filter yang Anda terapkan.
                        @else
                            Mulai tambahkan pesanan pertama Anda.
                        @endif
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        @if(request()->hasAny(['search', 'status', 'rt', 'rw']))
                            <a href="{{ route('pesanan.index') }}" class="btn btn-primary px-4">
                                <i class="fas fa-refresh me-2"></i> Tampilkan Semua Pesanan
                            </a>
                        @endif
                        <a href="{{ route('pesanan.create') }}" class="btn btn-success px-4">
                            <i class="fas fa-plus me-2"></i> Buat Pesanan Baru
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<style>
.card {
    border-radius: 15px;
}
.card-header {
    border-radius: 15px 15px 0 0 !important;
}
.badge {
    border-radius: 8px;
}
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e9ecef;
}
.table tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.02);
    transition: background-color 0.2s ease;
}
.input-group-text {
    border-radius: 8px 0 0 8px;
}
.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
}
.btn {
    border-radius: 8px;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<script>
// Inisialisasi tooltip Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection
