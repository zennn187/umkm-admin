@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle p-3 me-3">
                <i class="fas fa-file-invoice-dollar text-white fa-2x"></i>
            </div>
            <div>
                <h3 class="mb-1 fw-bold text-primary">Detail Pesanan</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pesanan.edit', $pesanan->pesanan_id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- STATUS BANNER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background: rgba(13, 110, 253, 0.1);">
                            <i class="fas fa-receipt fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $pesanan->nomor_pesanan }}</h4>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $pesanan->created_at->translatedFormat('l, d F Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    @php
                        $statusConfig = [
                            'Baru' => ['bg' => 'bg-primary', 'icon' => 'fas fa-clock', 'color' => 'text-primary'],
                            'Diproses' => ['bg' => 'bg-warning', 'icon' => 'fas fa-cogs', 'color' => 'text-warning'],
                            'Dikirim' => ['bg' => 'bg-info', 'icon' => 'fas fa-shipping-fast', 'color' => 'text-info'],
                            'Selesai' => ['bg' => 'bg-success', 'icon' => 'fas fa-check-circle', 'color' => 'text-success'],
                            'Dibatalkan' => ['bg' => 'bg-danger', 'icon' => 'fas fa-times-circle', 'color' => 'text-danger']
                        ];
                        $config = $statusConfig[$pesanan->status] ?? ['bg' => 'bg-secondary', 'icon' => 'fas fa-question', 'color' => 'text-secondary'];
                    @endphp
                    <div class="d-inline-block p-3 rounded-3 {{ $config['bg'] }} bg-opacity-10 border {{ $config['color'] }}">
                        <div class="d-flex align-items-center">
                            <i class="{{ $config['icon'] }} fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0 fw-bold {{ $config['color'] }}">{{ $pesanan->status }}</h5>
                                <small class="text-muted">Status Pesanan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- INFORMASI PESANAN --}}
        <div class="col-md-8">
            {{-- INFORMASI PELANGGAN --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Pelanggan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%"><i class="fas fa-user-circle me-2"></i>Nama</th>
                                    <td>: {{ $pesanan->warga->nama ?? 'Tidak Diketahui' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-phone me-2"></i>Telepon</th>
                                    <td>: {{ $pesanan->warga->telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-envelope me-2"></i>Email</th>
                                    <td>: {{ $pesanan->warga->email ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%"><i class="fas fa-map-marker-alt me-2"></i>Alamat</th>
                                    <td>: {{ $pesanan->alamat_kirim }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-map-pin me-2"></i>RT/RW</th>
                                    <td>: {{ $pesanan->rt }}/{{ $pesanan->rw }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-wallet me-2"></i>Pembayaran</th>
                                    <td>:
                                        <span class="badge bg-info">
                                            {{ $pesanan->metode_bayar }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL PRODUK --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i>Detail Produk
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Produk</th>
                                    <th class="text-center">Harga Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @if(isset($pesanan->detail) && $pesanan->detail->count() > 0)
                                    @foreach($pesanan->detail as $index => $detail)
                                    @php
                                        $subtotal = $detail->harga * $detail->quantity;
                                        $total += $subtotal;
                                    @endphp
                                    <tr class="border-bottom">
                                        <td class="ps-4">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</div>
                                            <small class="text-muted">{{ $detail->produk->deskripsi ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">
                                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary py-2 px-3">
                                                {{ $detail->quantity }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 fw-bold text-success">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada detail produk</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold ps-4">Total Pesanan:</td>
                                    <td class="text-end pe-4">
                                        <h5 class="fw-bold text-success mb-0">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR INFORMASI --}}
        <div class="col-md-4">
            {{-- INFORMASI UMKM --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-store me-2"></i>Informasi UMKM
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($pesanan->umkm->logo ?? false)
                            <img src="{{ asset('storage/' . $pesanan->umkm->logo) }}"
                                 alt="Logo UMKM"
                                 class="img-fluid rounded-circle mb-3"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-store fa-2x text-muted"></i>
                            </div>
                        @endif
                        <h5 class="fw-bold mb-1">{{ $pesanan->umkm->nama_umkm ?? '-' }}</h5>
                        <p class="text-muted mb-2">{{ $pesanan->umkm->pemilik ?? '-' }}</p>
                        <span class="badge bg-primary">{{ $pesanan->umkm->kategori ?? 'UMKM' }}</span>
                    </div>
                    <hr>
                    <div>
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle me-2"></i>Kontak UMKM
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                {{ $pesanan->umkm->telepon ?? '-' }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                {{ $pesanan->umkm->email ?? '-' }}
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                {{ $pesanan->umkm->alamat ?? '-' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- BUKTI PEMBAYARAN --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Bukti Pembayaran
                    </h5>
                </div>
                <div class="card-body text-center">
                    @if($pesanan->bukti_bayar)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}"
                                 alt="Bukti Bayar"
                                 class="img-fluid rounded border"
                                 style="max-height: 200px;">
                        </div>
                        <a href="{{ asset('storage/' . $pesanan->bukti_bayar) }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-expand me-1"></i> Lihat Full Size
                        </a>
                    @else
                        <div class="py-4">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TIMELINE PESANAN --}}
            @if(isset($pesanan->statusHistories) && $pesanan->statusHistories->count() > 0)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($pesanan->statusHistories->sortBy('created_at') as $history)
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $history->status }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $history->created_at->format('d/m/Y H:i') }}
                                </small>
                                @if($history->catatan)
                                <p class="mt-1 mb-0 small text-muted">{{ $history->catatan }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body text-center">
            <div class="btn-group" role="group">
                @if($pesanan->status == 'Baru')
                <form action="{{ route('pesanan.update.status', $pesanan->pesanan_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Diproses">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-play me-1"></i> Proses Pesanan
                    </button>
                </form>
                @endif

                @if($pesanan->status == 'Diproses')
                <form action="{{ route('pesanan.update.status', $pesanan->pesanan_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Dikirim">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-shipping-fast me-1"></i> Kirim Pesanan
                    </button>
                </form>
                @endif

                @if($pesanan->status == 'Dikirim')
                <form action="{{ route('pesanan.update.status', $pesanan->pesanan_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Selesai">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Selesaikan Pesanan
                    </button>
                </form>
                @endif

                @if(in_array($pesanan->status, ['Baru', 'Diproses']))
                <form action="{{ route('pesanan.update.status', $pesanan->pesanan_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Dibatalkan">
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                        <i class="fas fa-times-circle me-1"></i> Batalkan Pesanan
                    </button>
                </form>
                @endif

                <form action="{{ route('pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                        <i class="fas fa-trash me-1"></i> Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
.timeline {
    position: relative;
    padding-left: 20px;
}
.timeline-item {
    position: relative;
}
.timeline-marker {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.timeline-content {
    padding-left: 10px;
}
.card {
    border-radius: 12px;
}
.table th {
    font-weight: 600;
}
.badge {
    border-radius: 8px;
}
</style>
@endsection
