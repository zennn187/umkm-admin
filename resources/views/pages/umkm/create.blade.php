@extends('layouts.app')

@section('title', 'Tambah UMKM')
@section('icon', 'fa-building')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Tambah UMKM Baru
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data" id="umkmForm">
                            @csrf

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
                                                        <label for="nama_usaha" class="form-label">Nama Usaha <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('nama_usaha') is-invalid @enderror"
                                                            id="nama_usaha" name="nama_usaha"
                                                            value="{{ old('nama_usaha') }}" required>
                                                        @error('nama_usaha')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="pemilik_warga_id" class="form-label">Pemilik <span class="text-danger">*</span></label>
                                                        <select
                                                            class="form-select @error('pemilik_warga_id') is-invalid @enderror"
                                                            id="pemilik_warga_id" name="pemilik_warga_id" required>
                                                            <option value="">Pilih Pemilik</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ old('pemilik_warga_id') == $user->id ? 'selected' : '' }}>
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
                                                        <label for="kategori" class="form-label">Kategori <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select @error('kategori') is-invalid @enderror"
                                                            id="kategori" name="kategori" required>
                                                            <option value="">Pilih Kategori</option>
                                                            @foreach($kategories as $kategori)
                                                                <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
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
                                                        <label for="kontak" class="form-label">Kontak <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('kontak') is-invalid @enderror"
                                                            id="kontak" name="kontak" value="{{ old('kontak') }}"
                                                            required>
                                                        @error('kontak')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="rt" class="form-label">RT <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('rt') is-invalid @enderror"
                                                            id="rt" name="rt" value="{{ old('rt') }}"
                                                            maxlength="3" required>
                                                        @error('rt')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="rw" class="form-label">RW <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('rw') is-invalid @enderror"
                                                            id="rw" name="rw" value="{{ old('rw') }}"
                                                            maxlength="3" required>
                                                        @error('rw')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat Lengkap <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                                    required>{{ old('alamat') }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi Usaha</label>
                                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                                    rows="4">{{ old('deskripsi') }}</textarea>
                                                @error('deskripsi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Upload Files -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">File Pendukung</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="files" class="form-label">Upload File</label>
                                                <input type="file"
                                                    class="form-control @error('files.*') is-invalid @enderror"
                                                    id="files" name="files[]" multiple
                                                    accept=".jpeg,.jpg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">
                                                <small class="text-muted">
                                                    Format: JPEG, PNG, JPG, GIF, PDF, DOC, XLS.
                                                    Maksimal 5MB per file.
                                                </small>
                                                @error('files.*')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div id="caption-container"></div>

                                            <div id="file-preview" class="mt-3">
                                                <p class="text-muted">Preview file akan muncul di sini</p>
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
                                    <i class="fas fa-save me-2"></i>Simpan UMKM
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
        background: white;
        transition: all 0.3s;
    }
    .file-preview-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .file-preview-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
    .file-preview-icon {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        font-size: 40px;
    }
    .remove-file {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }
    .remove-file:hover {
        background: #c82333;
    }
    .caption-input {
        margin-top: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('files');
        const filePreview = document.getElementById('file-preview');
        const captionContainer = document.getElementById('caption-container');

        function updateFilePreview() {
            filePreview.innerHTML = '';
            captionContainer.innerHTML = '<h6 class="mt-3 mb-2">Caption untuk File:</h6>';

            if (fileInput.files && fileInput.files.length > 0) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    const file = fileInput.files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'file-preview-item';
                        previewItem.id = `preview-${i}`;

                        let previewContent = '';
                        if (file.type.startsWith('image/')) {
                            previewContent = `
                                <img src="${e.target.result}"
                                     class="file-preview-img"
                                     alt="Preview">
                            `;
                        } else {
                            const iconClass = getFileIcon(file);
                            previewContent = `
                                <div class="file-preview-icon text-primary">
                                    <i class="${iconClass}"></i>
                                </div>
                            `;
                        }

                        previewItem.innerHTML = `
                            ${previewContent}
                            <div class="mt-2 small">
                                <div class="text-truncate" style="max-width: 100px;" title="${file.name}">
                                    ${file.name}
                                </div>
                                <small class="text-muted">${formatBytes(file.size)}</small>
                            </div>
                            <button type="button" class="remove-file" data-index="${i}" title="Hapus file">
                                &times;
                            </button>
                        `;

                        filePreview.appendChild(previewItem);

                        // Tambah input caption
                        const captionInput = document.createElement('div');
                        captionInput.className = 'caption-input';
                        captionInput.innerHTML = `
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" style="font-size: 12px;">
                                    <i class="fas fa-quote-left"></i>
                                </span>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       name="captions[]"
                                       placeholder="Caption untuk '${file.name}' (opsional)"
                                       aria-label="Caption untuk ${file.name}">
                            </div>
                        `;
                        captionContainer.appendChild(captionInput);
                    };

                    reader.readAsDataURL(file);
                }
            } else {
                filePreview.innerHTML = `
                    <div class="text-center py-4 border rounded bg-light">
                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada file dipilih</p>
                    </div>
                `;
                captionContainer.innerHTML = '';
            }
        }

        fileInput.addEventListener('change', updateFilePreview);

        filePreview.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-file')) {
                const index = parseInt(e.target.getAttribute('data-index'));
                const previewItem = document.getElementById(`preview-${index}`);
                if (previewItem) previewItem.remove();

                const captionInputs = captionContainer.querySelectorAll('.caption-input');
                if (captionInputs[index]) captionInputs[index].remove();

                const dt = new DataTransfer();
                const files = fileInput.files;

                for (let i = 0; i < files.length; i++) {
                    if (i !== index) {
                        dt.items.add(files[i]);
                    }
                }

                fileInput.files = dt.files;
                if (dt.files.length === 0) {
                    fileInput.value = '';
                }
            }
        });

        function getFileIcon(file) {
            if (file.type.includes('pdf')) return 'fas fa-file-pdf text-danger';
            if (file.type.includes('word') || file.type.includes('document')) return 'fas fa-file-word text-primary';
            if (file.type.includes('excel') || file.type.includes('spreadsheet')) return 'fas fa-file-excel text-success';
            if (file.type.includes('image')) return 'fas fa-file-image text-info';
            return 'fas fa-file text-secondary';
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        const umkmForm = document.getElementById('umkmForm');
        umkmForm.addEventListener('submit', function(e) {
            const hasMedia = fileInput.files.length > 0;

            if (!hasMedia) {
                if (!confirm('Anda belum mengupload file pendukung. Lanjutkan tanpa file?')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>
@endpush
