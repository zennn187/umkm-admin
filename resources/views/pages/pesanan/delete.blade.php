@extends('layouts.app')

@section('title', 'Hapus Pesanan')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-danger rounded-circle p-3 me-3">
                <i class="fas fa-trash-alt text-white fa-2x"></i>
            </div>
            <div>
                <h3 class="mb-1 fw-bold text-danger">Hapus Pesanan</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pesanan.show', $pesanan->pesanan_id) }}">Detail</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hapus</li>
                    </ol>
                </nav>
            </div>
        </div>
        <a href="{{ route('pesanan.show', $pesanan->pesanan_id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- CONFIRMATION CARD --}}
    <div class="card border-0 shadow-lg border-danger">
        <div class="card-header bg-danger text-white py-4">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">Konfirmasi Penghapusan</h4>
                    <p class="mb-0 opacity-75">Hapus pesanan secara permanen</p>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- WARNING ALERT --}}
            <div class="alert alert-danger border-danger border-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-2">Perhatian!</h5>
                        <p class="mb-2">Anda akan menghapus pesanan berikut beserta semua data terkait. Tindakan ini <strong>TIDAK DAPAT DIBATALKAN</strong>.</p>
                        <ul class="mb-0">
                            <li>Detail pesanan akan dihapus</li>
                            <li>Data transaksi akan hilang</li>
                            <li>Bukti bayar akan dihapus dari sistem</li>
                            <li>Riwayat status akan terhapus</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- PESANAN DETAILS --}}
            <div class="card border border-danger mb-4">
                <div class="card-header bg-danger bg-opacity-10 border-bottom border-danger py-3">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-info-circle me-2"></i>Detail Pesanan yang akan Dihapus
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%" class="text-muted">Nomor Pesanan</th>
                                    <td>
                                        <span class="fw-bold text-danger">{{ $pesanan->nomor_pesanan }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tanggal Pesanan</th>
                                    <td>{{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status</th>
                                    <td>
                                        <span class="badge
                                            @if($pesanan->status == 'Baru') bg-primary
                                            @elseif($pesanan->status == 'Diproses') bg-warning
                                            @elseif($pesanan->status == 'Dikirim') bg-info
                                            @elseif($pesanan->status == 'Selesai') bg-success
                                            @elseif($pesanan->status == 'Dibatalkan') bg-danger
                                            @endif p-2">
                                            {{ $pesanan->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Customer</th>
                                    <td>{{ $pesanan->warga->nama ?? 'Tidak Diketahui' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%" class="text-muted">UMKM</th>
                                    <td>{{ $pesanan->umkm->nama_umkm ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Total Pesanan</th>
                                    <td class="fw-bold text-success">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Metode Bayar</th>
                                    <td>{{ $pesanan->metode_bayar }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">RT/RW</th>
                                    <td>{{ $pesanan->rt }}/{{ $pesanan->rw }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- DETAIL PRODUK --}}
                    @if($pesanan->detail && $pesanan->detail->count() > 0)
                    <div class="mt-4">
                        <h6 class="fw-bold text-danger mb-3">
                            <i class="fas fa-box me-2"></i>Produk dalam Pesanan ini:
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan->detail as $index => $detail)
                                    <tr class="border-bottom">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $detail->quantity }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td colspan="3" class="text-end">Total:</td>
                                        <td class="text-end text-success">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- IMPACT WARNING --}}
            <div class="alert alert-warning border-warning">
                <div class="d-flex align-items-start">
                    <i class="fas fa-chart-line fa-lg me-3 mt-1 text-warning"></i>
                    <div>
                        <h6 class="fw-bold mb-2">Dampak Penghapusan:</h6>
                        <ul class="mb-0 ps-3">
                            <li>Data akan hilang dari laporan penjualan</li>
                            <li>Stok produk tidak akan dikembalikan secara otomatis</li>
                            <li>Riwayat transaksi pelanggan akan terpengaruh</li>
                            <li>Laporan keuangan UMKM perlu disesuaikan</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- CONFIRMATION FORM --}}
            <div class="card border-warning">
                <div class="card-body text-center py-4">
                    <h5 class="fw-bold text-danger mb-3">Apakah Anda yakin ingin menghapus pesanan ini?</h5>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form action="{{ route('pesanan.destroy', $pesanan->pesanan_id) }}" method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')

                                <div class="mb-4">
                                    <label for="confirmation_text" class="form-label fw-semibold">
                                        Ketik "<span class="text-danger fw-bold">HAPUS PESANAN {{ $pesanan->nomor_pesanan }}</span>" untuk konfirmasi:
                                    </label>
                                    <input type="text" class="form-control form-control-lg text-center"
                                           id="confirmation_text"
                                           placeholder="HAPUS PESANAN {{ $pesanan->nomor_pesanan }}"
                                           required>
                                    <div class="form-text text-muted">Harap ketik persis seperti yang diminta</div>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('pesanan.show', $pesanan->pesanan_id) }}"
                                       class="btn btn-lg btn-outline-secondary px-5">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </a>

                                    <button type="submit"
                                            class="btn btn-lg btn-danger px-5"
                                            id="deleteButton"
                                            disabled>
                                        <i class="fas fa-trash-alt me-2"></i> Ya, Hapus Permanen
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- SAFETY MESSAGE --}}
                    <div class="mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0">
                            <i class="fas fa-shield-alt me-1"></i>
                            Untuk keamanan, kami memerlukan konfirmasi teks sebelum menghapus data penting.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALTERNATIVE ACTIONS --}}
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-lightbulb me-2 text-warning"></i>Alternatif yang Lebih Aman
            </h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border h-100">
                        <div class="card-body text-center">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                <i class="fas fa-flag text-info fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Tandai sebagai Dibatalkan</h6>
                            <p class="text-muted small mb-3">Pesanan tetap tercatat tapi status berubah</p>
                            <form action="{{ route('pesanan.update.status', $pesanan->pesanan_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Dibatalkan">
                                <button type="submit" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-ban me-1"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border h-100">
                        <div class="card-body text-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                <i class="fas fa-archive text-warning fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Arsipkan</h6>
                            <p class="text-muted small mb-3">Sembunyikan dari tampilan utama</p>
                            <button type="button" class="btn btn-outline-warning btn-sm" disabled>
                                <i class="fas fa-box-archive me-1"></i> (Fitur belum tersedia)
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border h-100">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 mb-3 d-inline-block">
                                <i class="fas fa-edit text-primary fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Edit Pesanan</h6>
                            <p class="text-muted small mb-3">Perbaiki data yang salah</p>
                            <a href="{{ route('pesanan.edit', $pesanan->pesanan_id) }}"
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmationText = document.getElementById('confirmation_text');
    const deleteButton = document.getElementById('deleteButton');
    const requiredText = `HAPUS PESANAN {{ $pesanan->nomor_pesanan }}`;

    // Validasi input konfirmasi
    confirmationText.addEventListener('input', function() {
        const inputText = this.value.trim();

        if (inputText === requiredText) {
            deleteButton.disabled = false;
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            deleteButton.disabled = true;
            this.classList.remove('is-valid');
            if (inputText !== '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        }
    });

    // Konfirmasi tambahan saat submit
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        if (!confirm('Anda yakin 100%? Tindakan ini TIDAK DAPAT DIBATALKAN!')) {
            e.preventDefault();
            return false;
        }

        // Tampilkan loading state
        deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menghapus...';
        deleteButton.disabled = true;
    });
});
</script>

<style>
.card {
    border-radius: 12px;
}
.badge {
    border-radius: 8px;
}
.form-control.is-valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
}
.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
}
.alert {
    border-radius: 10px;
}
</style>
@endsection
