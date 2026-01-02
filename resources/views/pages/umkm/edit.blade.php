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
                                                    <label for="pemilik_warga_id" class="form-label">Pemilik <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('pemilik_warga_id') is-invalid @enderror"
                                                            id="pemilik_warga_id" name="pemilik_warga_id" required>
                                                        <option value="">Pilih Pemilik</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ old('pemilik_warga_id', $umkm->pemilik_warga_id) == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }} - {{ ucfirst($user->role) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('pemilik_warga_id')
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
                                                        @foreach($kategories as $kategori)
                                                            <option value="{{ $kategori }}" {{ old('kategori', $umkm->kategori) == $kategori ? 'selected' : '' }}>
                                                                {{ $kategori }}
                                                            </option>
                                                        @endforeach
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
                                            <label for="deskripsi" class="form-label">Deskripsi Usaha</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                                      id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- File Management -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">File Pendukung</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Existing Files -->
                                        @if($umkm->media->count() > 0)
                                            <div class="mb-3">
                                                <label class="form-label">File Saat Ini</label>
                                                <div id="existing-media" class="mb-3">
                                                    @foreach($umkm->media as $media)
                                                        <div class="media-item mb-2 p-2 border rounded">
                                                            <div class="d-flex align-items-center">
                                                                @if(strpos($media->mime_type, 'image') !== false)
                                                                    <img src="{{ asset('storage/' . $media->file_path) }}"
                                                                         class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                                @else
                                                                    <div class="me-2 bg-light p-2 rounded">
                                                                        <i class="fas fa-file text-primary fa-lg"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="flex-grow-1">
                                                                    <small class="d-block text-truncate" style="max-width: 150px;">
                                                                        {{ $media->original_name }}
                                                                    </small>
                                                                    <div class="input-group input-group-sm mt-1">
                                                                        <input type="text" class="form-control form-control-sm"
                                                                               name="captions[{{ $media->media_id }}]"
                                                                               value="{{ $media->caption }}"
                                                                               placeholder="Caption (opsional)">
                                                                    </div>
                                                                </div>
                                                                <div class="ms-2">
                                                                    <input type="checkbox" name="delete_media[]" value="{{ $media->media_id }}"
                                                                           class="form-check-input" id="delete_{{ $media->media_id }}">
                                                                    <label class="form-check-label text-danger" for="delete_{{ $media->media_id }}">
                                                                        Hapus
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Upload New Files -->
                                        <div class="mb-3">
                                            <label for="files" class="form-label">Tambah File Baru</label>
                                            <input type="file" class="form-control @error('files.*') is-invalid @enderror"
                                                   id="files" name="files[]" multiple>
                                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF, PDF, DOC, XLS. Maksimal 5MB per file.</small>
                                            @error('files.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Caption Inputs untuk file baru -->
                                        <div id="new-caption-container"></div>

                                        <!-- Preview New Files -->
                                        <div id="file-preview" class="mt-3">
                                            @if($umkm->media->count() == 0)
                                                <p class="text-muted">Belum ada file</p>
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
@endsection

@push('styles')
<style>
.file-preview-item {
    position: relative;
    display: inline-block;
    margin: 5px;
    border: 1px solid #e9ecef;
    padding: 10px;
    border-radius: 5px;
}
.file-preview-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
}
.file-preview-icon {
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 5px;
    font-size: 40px;
}
.remove-file {
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
.media-item {
    background: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('files');
    const filePreview = document.getElementById('file-preview');
    const captionContainer = document.getElementById('new-caption-container');

    fileInput.addEventListener('change', function(e) {
        filePreview.innerHTML = '';
        captionContainer.innerHTML = '<h6 class="mt-3">Caption untuk File Baru:</h6>';

        if (this.files && this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'file-preview-item';
                    previewItem.id = `preview-${i}`;

                    let previewContent = '';
                    if (file.type.startsWith('image/')) {
                        previewContent = `<img src="${e.target.result}" class="file-preview-img" alt="Preview">`;
                    } else {
                        const iconClass = getFileIcon(file);
                        previewContent = `<div class="file-preview-icon text-primary"><i class="${iconClass}"></i></div>`;
                    }

                    previewItem.innerHTML = `
                        ${previewContent}
                        <div class="mt-2 small">
                            <div class="text-truncate" style="max-width: 100px;">${file.name}</div>
                            <small class="text-muted">${formatBytes(file.size)}</small>
                        </div>
                        <button type="button" class="remove-file" data-index="${i}">&times;</button>
                    `;

                    filePreview.appendChild(previewItem);

                    // Tambah input caption untuk file baru
                    const captionInput = document.createElement('div');
                    captionInput.className = 'mb-2';
                    captionInput.innerHTML = `
                        <label class="form-label small">Caption untuk "${file.name}"</label>
                        <input type="text" class="form-control form-control-sm"
                               name="new_captions[]" placeholder="Masukkan caption (opsional)">
                    `;
                    captionContainer.appendChild(captionInput);
                }

                reader.readAsDataURL(file);
            }
        }
    });

    // Remove file preview
    filePreview.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-file')) {
            const index = e.target.getAttribute('data-index');
            const previewItem = document.getElementById(`preview-${index}`);
            if (previewItem) previewItem.remove();

            const captionInputs = captionContainer.querySelectorAll('.mb-2');
            if (captionInputs[index]) captionInputs[index].remove();

            const dt = new DataTransfer();
            const files = fileInput.files;

            for (let i = 0; i < files.length; i++) {
                if (i != index) {
                    dt.items.add(files[i]);
                }
            }

            fileInput.files = dt.files;
        }
    });

    function getFileIcon(file) {
        if (file.type.includes('pdf')) return 'fas fa-file-pdf';
        if (file.type.includes('word') || file.type.includes('document')) return 'fas fa-file-word';
        if (file.type.includes('excel') || file.type.includes('spreadsheet')) return 'fas fa-file-excel';
        if (file.type.includes('image')) return 'fas fa-file-image';
        return 'fas fa-file';
    }

    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
});
</script>
@endpush
