@extends('layouts.app')

@section('title', 'Edit Ulasan Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Ulasan Produk</h1>
        <a href="{{ route('ulasan-produk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Ulasan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('ulasan-produk.update', $ulasan->ulasan_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Produk</h6>
                            </div>
                            <div class="card-body">
                                @if($ulasan->produk)
                                    <h5>{{ $ulasan->produk->nama_produk }}</h5>
                                    <p class="text-muted">
                                        {{ $ulasan->produk->umkm->nama_usaha ?? 'UMKM tidak ditemukan' }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Status:</strong>
                                        @if($ulasan->produk->status == 'Aktif')
                                            <span class="badge badge-success">{{ $ulasan->produk->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $ulasan->produk->status }}</span>
                                        @endif
                                    </p>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Produk tidak ditemukan
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Informasi Warga</h6>
                            </div>
                            <div class="card-body">
                                @if($ulasan->warga)
                                    <h5>{{ $ulasan->warga->name }}</h5>
                                    <p class="text-muted">
                                        {{ $ulasan->warga->nik ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Kontak:</strong> {{ $ulasan->warga->telp ?? 'N/A' }}
                                    </p>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Data warga tidak ditemukan
                                    </div>
                                @endif
                            </div>
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
                                           {{ old('rating', $ulasan->rating) == $i ? 'checked' : '' }} required>
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
                              placeholder="Tulis ulasan Anda tentang produk ini..." required>{{ old('komentar', $ulasan->komentar) }}</textarea>
                    @error('komentar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <span id="charCount">0</span>/2000 karakter
                    </small>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_verified" name="is_verified" value="1"
                               {{ old('is_verified', optional($ulasan)->is_verified) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_verified">
                            Verifikasi ulasan (tampilkan sebagai ulasan terverifikasi)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <a href="{{ route('ulasan-produk.show', $ulasan->ulasan_id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Card -->
    <div class="card shadow border-left-danger">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Area Berbahaya</h6>
        </div>
        <div class="card-body">
            <p class="text-danger">
                <i class="fas fa-exclamation-triangle"></i>
                Hapus ulasan ini secara permanen. Aksi ini tidak dapat dibatalkan.
            </p>
            <form action="{{ route('ulasan-produk.destroy', $ulasan->ulasan_id) }}" method="POST"
                  onsubmit="return confirm('Hapus ulasan ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus Ulasan
                </button>
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
    // Character counter
    const komentarTextarea = document.getElementById('komentar');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const length = komentarTextarea.value.length;
        charCount.textContent = length;

        if (length > 2000) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    }

    komentarTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial count

    // Auto-resize textarea
    komentarTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const rating = document.querySelector('input[name="rating"]:checked');
        const komentar = komentarTextarea.value.trim();

        if (!rating) {
            e.preventDefault();
            alert('Silakan pilih rating');
            return false;
        }

        if (komentar.length < 10) {
            e.preventDefault();
            alert('Komentar minimal 10 karakter');
            return false;
        }

        if (komentar.length > 2000) {
            e.preventDefault();
            alert('Komentar maksimal 2000 karakter');
            return false;
        }
    });
});
</script>
@endsection
