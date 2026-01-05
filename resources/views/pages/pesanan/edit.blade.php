@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-warning rounded-circle p-3 me-3">
                <i class="fas fa-edit text-white fa-2x"></i>
            </div>
            <div>
                <h3 class="mb-1 fw-bold text-warning">Edit Pesanan</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('pesanan.index') }}">Pesanan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pesanan.show', $pesanan->pesanan_id) }}">Detail</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
        <a href="{{ route('pesanan.show', $pesanan->pesanan_id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail
        </a>
    </div>

    <form action="{{ route('pesanan.update', $pesanan->pesanan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- INFO PESANAN --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nomor_pesanan" class="form-label fw-semibold">Nomor Pesanan</label>
                        <input type="text" class="form-control" id="nomor_pesanan"
                               value="{{ $pesanan->nomor_pesanan }}" readonly>
                        <small class="text-muted">Nomor pesanan tidak dapat diubah</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Baru" {{ $pesanan->status == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ $pesanan->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="metode_bayar" class="form-label fw-semibold">Metode Bayar</label>
                        <select class="form-select" id="metode_bayar" name="metode_bayar" required>
                            <option value="Transfer Bank" {{ $pesanan->metode_bayar == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="Cash" {{ $pesanan->metode_bayar == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="E-Wallet" {{ $pesanan->metode_bayar == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                            <option value="COD" {{ $pesanan->metode_bayar == 'COD' ? 'selected' : '' }}>COD (Cash on Delivery)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFORMASI PELANGGAN --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-info text-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="warga_id" class="form-label fw-semibold">
                            <i class="fas fa-user-circle me-1"></i>Customer
                        </label>
                        <select class="form-select" id="warga_id" name="warga_id" required>
                            <option value="">Pilih Customer</option>
                            @foreach($wargas as $warga)
                                <option value="{{ $warga->warga_id }}"
                                    {{ $pesanan->warga_id == $warga->warga_id ? 'selected' : '' }}>
                                    {{ $warga->nama }} - {{ $warga->telepon }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="umkm_id" class="form-label fw-semibold">
                            <i class="fas fa-store me-1"></i>UMKM
                        </label>
                        <select class="form-select" id="umkm_id" name="umkm_id" required>
                            <option value="">Pilih UMKM</option>
                            @foreach($umkms as $umkm)
                                <option value="{{ $umkm->umkm_id }}"
                                    {{ $pesanan->umkm_id == $umkm->umkm_id ? 'selected' : '' }}>
                                    {{ $umkm->nama_umkm }} - {{ $umkm->pemilik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="rt" class="form-label fw-semibold">
                            <i class="fas fa-map-marker-alt me-1"></i>RT
                        </label>
                        <input type="text" class="form-control" id="rt" name="rt"
                               value="{{ $pesanan->rt }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="rw" class="form-label fw-semibold">
                            <i class="fas fa-map-marker-alt me-1"></i>RW
                        </label>
                        <input type="text" class="form-control" id="rw" name="rw"
                               value="{{ $pesanan->rw }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telepon" class="form-label fw-semibold">
                            <i class="fas fa-phone me-1"></i>Telepon Customer
                        </label>
                        <input type="text" class="form-control" id="telepon"
                               value="{{ $pesanan->warga->telepon ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat_kirim" class="form-label fw-semibold">
                        <i class="fas fa-map-marked-alt me-1"></i>Alamat Pengiriman
                    </label>
                    <textarea class="form-control" id="alamat_kirim" name="alamat_kirim"
                              rows="3" required>{{ $pesanan->alamat_kirim }}</textarea>
                </div>
            </div>
        </div>

        {{-- DETAIL PRODUK --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-boxes me-2"></i>Detail Produk
                    </h5>
                    <button type="button" id="tambah-produk" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Produk
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="produk-container">
                    @php
                        $totalPesanan = 0;
                        $detailPesanan = $pesanan->detail ?? [];
                    @endphp

                    @if($detailPesanan->count() > 0)
                        @foreach($detailPesanan as $index => $detail)
                        @php
                            $subtotal = $detail->harga * $detail->quantity;
                            $totalPesanan += $subtotal;
                        @endphp
                        <div class="row produk-item mb-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Produk</label>
                                <select class="form-select produk-select" name="produk_id[]" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->produk_id }}"
                                                data-harga="{{ $produk->harga }}"
                                                {{ $detail->produk_id == $produk->produk_id ? 'selected' : '' }}>
                                            {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Harga</label>
                                <input type="text" class="form-control harga-input"
                                       value="Rp {{ number_format($detail->harga, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control quantity-input"
                                       name="quantity[]" min="1" value="{{ $detail->quantity }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Subtotal</label>
                                <input type="text" class="form-control subtotal-input"
                                       value="Rp {{ number_format($subtotal, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-produk"
                                        {{ $detailPesanan->count() == 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="row produk-item mb-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Produk</label>
                                <select class="form-select produk-select" name="produk_id[]" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->produk_id }}"
                                                data-harga="{{ $produk->harga }}">
                                            {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Harga</label>
                                <input type="text" class="form-control harga-input" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control quantity-input"
                                       name="quantity[]" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Subtotal</label>
                                <input type="text" class="form-control subtotal-input" readonly>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-produk" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded">
                                <h5 class="mb-0 d-flex justify-content-between">
                                    <span>Total Pesanan:</span>
                                    <span id="total-pesanan" class="text-success fw-bold">
                                        Rp {{ number_format($totalPesanan, 0, ',', '.') }}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BUKTI BAYAR --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0">
                    <i class="fas fa-receipt me-2"></i>Bukti Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($pesanan->bukti_bayar)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bukti Bayar Saat Ini</label>
                            <div class="border rounded p-3 text-center">
                                <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}"
                                     alt="Bukti Bayar"
                                     class="img-fluid mb-2"
                                     style="max-height: 150px;">
                                <br>
                                <a href="{{ asset('storage/' . $pesanan->bukti_bayar) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-expand me-1"></i> Lihat
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bukti_bayar" class="form-label fw-semibold">
                                {{ $pesanan->bukti_bayar ? 'Ganti Bukti Bayar' : 'Upload Bukti Bayar' }}
                            </label>
                            <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                        </div>
                        @if($pesanan->bukti_bayar)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hapus_bukti" name="hapus_bukti">
                            <label class="form-check-label text-danger" for="hapus_bukti">
                                <i class="fas fa-trash me-1"></i> Hapus bukti bayar saat ini
                            </label>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- CATATAN TAMBAHAN --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-secondary text-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="catatan" class="form-label fw-semibold">
                        <i class="fas fa-edit me-1"></i>Catatan (Opsional)
                    </label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3"
                              placeholder="Tambahkan catatan untuk pesanan ini...">{{ old('catatan', $pesanan->catatan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('pesanan.show', $pesanan->pesanan_id) }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-info px-4"
                                onclick="window.location.reload()">
                            <i class="fas fa-refresh me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hitung total
    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(input => {
            let subtotal = parseInt(input.value.replace(/\D/g, '') || 0);
            total += subtotal;
        });
        document.getElementById('total-pesanan').textContent = 'Rp ' + total.toLocaleString('id-ID');
        return total;
    }

    // Update subtotal untuk satu baris
    function updateSubtotal(row) {
        let produkSelect = row.querySelector('.produk-select');
        let hargaInput = row.querySelector('.harga-input');
        let quantityInput = row.querySelector('.quantity-input');
        let subtotalInput = row.querySelector('.subtotal-input');

        let harga = parseInt(produkSelect.options[produkSelect.selectedIndex]?.dataset.harga || 0);
        let quantity = parseInt(quantityInput.value || 0);
        let subtotal = harga * quantity;

        hargaInput.value = 'Rp ' + harga.toLocaleString('id-ID');
        subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID');
        hitungTotal();
    }

    // Tambah produk baru
    document.getElementById('tambah-produk').addEventListener('click', function() {
        let container = document.getElementById('produk-container');
        let firstRow = container.querySelector('.produk-item');
        let newRow = firstRow.cloneNode(true);

        // Reset nilai
        newRow.querySelector('.produk-select').selectedIndex = 0;
        newRow.querySelector('.harga-input').value = '';
        newRow.querySelector('.quantity-input').value = 1;
        newRow.querySelector('.subtotal-input').value = 'Rp 0';
        newRow.querySelector('.remove-produk').disabled = false;

        // Tambah event listener
        newRow.querySelector('.produk-select').addEventListener('change', function() {
            updateSubtotal(newRow);
        });

        newRow.querySelector('.quantity-input').addEventListener('input', function() {
            updateSubtotal(newRow);
        });

        newRow.querySelector('.remove-produk').addEventListener('click', function() {
            if (document.querySelectorAll('.produk-item').length > 1) {
                newRow.remove();
                hitungTotal();
            }
        });

        container.appendChild(newRow);
    });

    // Inisialisasi event listener untuk semua baris
    document.querySelectorAll('.produk-item').forEach(row => {
        row.querySelector('.produk-select').addEventListener('change', function() {
            updateSubtotal(row);
        });

        row.querySelector('.quantity-input').addEventListener('input', function() {
            updateSubtotal(row);
        });

        row.querySelector('.remove-produk').addEventListener('click', function() {
            if (document.querySelectorAll('.produk-item').length > 1) {
                row.remove();
                hitungTotal();
            }
        });
    });

    // Inisialisasi total pertama kali
    hitungTotal();
});
</script>

<style>
.card {
    border-radius: 12px;
}
.form-label {
    font-weight: 600;
}
.btn {
    border-radius: 8px;
}
#produk-container .row {
    padding: 15px;
    border-bottom: 1px solid #eee;
}
#produk-container .row:last-child {
    border-bottom: none;
}
</style>
@endsection
