@extends('layouts.app')

@section('title', 'Edit UMKM')
@section('icon', 'fa-building')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Edit UMKM: {{ $umkm->nama_usaha }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('umkm.update', $umkm->umkm_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Data UMKM -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Informasi UMKM</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nama_usaha" class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror"
                                                           id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required>
                                                    @error('nama_usaha')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('pemilik') is-invalid @enderror"
                                                           id="pemilik" name="pemilik" value="{{ old('pemilik', $umkm->pemilik) }}" required>
                                                    @error('pemilik')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                                        <option value="">Pilih Kategori</option>
                                                        <option value="Makanan & Minuman" {{ old('kategori', $umkm->kategori) == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                                                        <option value="Fashion" {{ old('kategori', $umkm->kategori) == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                                                        <option value="Kerajinan" {{ old('kategori', $umkm->kategori) == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                                                        <option value="Jasa" {{ old('kategori', $umkm->kategori) == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                                        <option value="Pertanian" {{ old('kategori', $umkm->kategori) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                                        <option value="Lainnya" {{ old('kategori', $umkm->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                    </select>
                                                    @error('kategori')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="kontak" class="form-label">Kontak <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                                           id="kontak" name="kontak" value="{{ old('kontak', $umkm->kontak) }}" required>
                                                    @error('kontak')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('rt') is-invalid @enderror"
                                                           id="rt" name="rt" value="{{ old('rt', $umkm->rt) }}" maxlength="3" required>
                                                    @error('rt')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('rw') is-invalid @enderror"
                                                           id="rw" name="rw" value="{{ old('rw', $umkm->rw) }}" maxlength="3" required>
                                                    @error('rw')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="Aktif" {{ old('status', $umkm->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Nonaktif" {{ old('status', $umkm->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $umkm->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi Usaha <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                                      id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Photos Management -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">Foto UMKM</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Existing Photos -->
                                        @if($umkm->photos->count() > 0)
                                            <div class="mb-3">
                                                <label class="form-label">Foto Saat Ini</label>
                                                <div id="existing-photos" class="mb-3">
                                                    @foreach($umkm->photos as $photo)
                                                        <div class="photo-item mb-2 p-2 border rounded">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('storage/umkm-photos/' . $photo->photo_path) }}"
                                                                     class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                                <div class="flex-grow-1">
                                                                    <small class="d-block">{{ $photo->photo_name }}</small>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="primary_photo"
                                                                               value="{{ $photo->photo_id }}" id="primary_{{ $photo->photo_id }}"
                                                                               {{ $photo->is_primary ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="primary_{{ $photo->photo_id }}">
                                                                            Jadikan Foto Utama
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <input type="checkbox" name="delete_photos[]" value="{{ $photo->photo_id }}"
                                                                           class="form-check-input" id="delete_{{ $photo->photo_id }}">
                                                                    <label class="form-check-label text-danger" for="delete_{{ $photo->photo_id }}">
                                                                        Hapus
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Upload New Photos -->
                                        <div class="mb-3">
                                            <label for="photos" class="form-label">Tambah Foto Baru</label>
                                            <input type="file" class="form-control @error('photos.*') is-invalid @enderror"
                                                   id="photos" name="photos[]" multiple accept="image/*">
                                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 5MB per foto.</small>
                                            @error('photos.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview New Photos -->
                                        <div id="photo-preview" class="mt-3">
                                            @if($umkm->photos->count() == 0)
                                                <p class="text-muted">Belum ada foto</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('umkm.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update UMKM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.photo-preview-item {
    position: relative;
    display: inline-block;
    margin: 5px;
}
.photo-preview {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    border: 2px solid #e9ecef;
}
.remove-photo {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    cursor: pointer;
}
.photo-item {
    background: #f8f9fa;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photos');
    const photoPreview = document.getElementById('photo-preview');

    photoInput.addEventListener('change', function(e) {
        if (this.files && this.files.length > 0) {
            photoPreview.innerHTML = '';

            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'photo-preview-item';

                    previewItem.innerHTML = `
                        <img src="${e.target.result}" class="photo-preview" alt="Preview">
                        <button type="button" class="remove-photo" data-index="${i}">&times;</button>
                    `;

                    photoPreview.appendChild(previewItem);
                }

                reader.readAsDataURL(file);
            }
        }
    });

    // Remove photo preview
    photoPreview.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-photo')) {
            const index = e.target.getAttribute('data-index');
            e.target.parentElement.remove();

            // Create new DataTransfer to remove file from input
            const dt = new DataTransfer();
            const files = photoInput.files;

            for (let i = 0; i < files.length; i++) {
                if (i != index) {
                    dt.items.add(files[i]);
                }
            }

            photoInput.files = dt.files;
        }
    });
});
</script>
@endsection
