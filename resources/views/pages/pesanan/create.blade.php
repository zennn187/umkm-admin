{{-- resources/views/pages/pesanan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Pesanan Baru</h3>

    <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="warga_id" class="form-label">Customer</label>
                            <select class="form-control" id="warga_id" name="warga_id" required>
                                <option value="">Pilih Customer</option>
                                @foreach($wargas as $warga)
                                    <option value="{{ $warga->warga_id }}">{{ $warga->nama }} - {{ $warga->alamat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="umkm_id" class="form-label">UMKM</label>
                            <select class="form-control" id="umkm_id" name="umkm_id" required>
                                <option value="">Pilih UMKM</option>
                                @foreach($umkms as $umkm)
                                    <option value="{{ $umkm->umkm_id }}">{{ $umkm->nama_usaha }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="metode_bayar" class="form-label">Metode Bayar</label>
                            <select class="form-control" id="metode_bayar" name="metode_bayar" required>
                                <option value="">Pilih Metode</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Cash">Cash</option>
                                <option value="E-Wallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat_kirim" class="form-label">Alamat Pengiriman</label>
                    <textarea class="form-control" id="alamat_kirim" name="alamat_kirim" rows="3" required></textarea>
                </div>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Detail Produk</h5>
            </div>
            <div class="card-body">
                <div id="produk-container">
                    <div class="row produk-item mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Produk</label>
                            <select class="form-control produk-select" name="produk_id[]" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->produk_id }}" data-harga="{{ $produk->harga }}">
                                        {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control quantity-input" name="quantity[]" min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control subtotal-input" readonly value="Rp 0">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-produk" disabled>
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" id="tambah-produk" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>

                <div class="mt-3">
                    <h5>Total Pesanan: <span id="total-pesanan">Rp 0</span></h5>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Upload Bukti Bayar</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="bukti_bayar" class="form-label">Bukti Bayar (opsional)</label>
                    <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" accept="image/*">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Pesanan
            </button>
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
    }

    // Update subtotal
    function updateSubtotal(row) {
        let produkSelect = row.querySelector('.produk-select');
        let quantityInput = row.querySelector('.quantity-input');
        let subtotalInput = row.querySelector('.subtotal-input');

        let harga = parseInt(produkSelect.options[produkSelect.selectedIndex]?.dataset.harga || 0);
        let quantity = parseInt(quantityInput.value || 0);
        let subtotal = harga * quantity;

        subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID');
        hitungTotal();
    }

    // Tambah produk
    document.getElementById('tambah-produk').addEventListener('click', function() {
        let container = document.getElementById('produk-container');
        let newRow = container.children[0].cloneNode(true);

        // Reset nilai
        newRow.querySelector('.produk-select').selectedIndex = 0;
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
            newRow.remove();
            hitungTotal();
        });

        container.appendChild(newRow);
    });

    // Event listener untuk baris pertama
    let firstRow = document.querySelector('.produk-item');
    firstRow.querySelector('.produk-select').addEventListener('change', function() {
        updateSubtotal(firstRow);
    });

    firstRow.querySelector('.quantity-input').addEventListener('input', function() {
        updateSubtotal(firstRow);
    });

    // Remove produk
    document.querySelectorAll('.remove-produk').forEach(btn => {
        btn.addEventListener('click', function() {
            if (document.querySelectorAll('.produk-item').length > 1) {
                this.closest('.produk-item').remove();
                hitungTotal();
            }
        });
    });
});
</script>
@endsection
