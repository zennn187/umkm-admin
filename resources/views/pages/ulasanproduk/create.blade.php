@extends('layouts.app')

@section('title', 'Tambah Ulasan Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Ulasan Produk</h1>
        <a href="{{ route('ulasan-produk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Ulasan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('ulasan-produk.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="produk_id">Produk <span class="text-danger">*</span></label>
                            <select name="produk_id" id="produk_id" class="form-control @error('produk_id') is-invalid @enderror" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->produk_id }}" {{ old('produk_id') == $produk->produk_id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} ({{ $produk->umkm->nama_usaha ?? 'UMKM tidak ditemukan' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warga_id">Warga <span class="text-danger">*</span></label>
                            <select name="warga_id" id="warga_id" class="form-control @error('warga_id') is-invalid @enderror" required>
                                <option value="">Pilih Warga</option>
                                @foreach($wargas as $warga)
                                    <option value="{{ $warga->warga_id }}" {{ old('warga_id') == $warga->warga_id ? 'selected' : '' }}>
                                        {{ $warga->name }} ({{ $warga->nik ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rating">Rating <span class="text-danger">*</span></label>
                    <div class="rating-input">
                        <div class="d-flex align-items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="mr-2">
                                    <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}"
                                           {{ old('rating') == $i ? 'checked' : '' }} required>
                                    <label for="rating{{ $i }}" class="star-label">
                                        <i class="far fa-star fa-2x"></i>
                                        <span class="ml-1">{{ $i }}</span>
                                    </label>
                                </div>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="komentar">Komentar <span class="text-danger">*</span></label>
                    <textarea name="komentar" id="komentar" rows="5" class="form-control @error('komentar') is-invalid @enderror"
                              placeholder="Tulis ulasan Anda tentang produk ini..." required>{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Minimal 10 karakter, maksimal 2000 karakter.</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.rating-input input[type="radio"] {
    display: none;
}

.rating-input .star-label {
    cursor: pointer;
    color: #ddd;
    transition: color 0.2s;
}

.rating-input input[type="radio"]:checked ~ .star-label,
.rating-input .star-label:hover,
.rating-input .star-label:hover ~ .star-label {
    color: #ffc107;
}

.rating-input input[type="radio"]:checked ~ .star-label {
    color: #ffc107;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const textarea = document.getElementById('komentar');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Product selection enhancement
    const produkSelect = document.getElementById('produk_id');
    if (produkSelect) {
        new Choices(produkSelect, {
            searchEnabled: true,
            placeholder: true,
            shouldSort: false,
        });
    }

    // Warga selection enhancement
    const wargaSelect = document.getElementById('warga_id');
    if (wargaSelect) {
        new Choices(wargaSelect, {
            searchEnabled: true,
            placeholder: true,
            shouldSort: false,
        });
    }
});
</script>
@endsection
