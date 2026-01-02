@extends('layouts.app')

@section('title', 'Detail UMKM')
@section('icon', 'fa-building')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Detail UMKM: {{ $umkm->nama_usaha }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Informasi UMKM -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Informasi UMKM</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama Usaha</label>
                                                <p class="form-control-plaintext">{{ $umkm->nama_usaha }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama Pemilik</label>
                                                <p class="form-control-plaintext">{{ $umkm->pemilik->name ?? 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kategori</label>
                                                <p>
                                                    <span class="badge bg-secondary">{{ $umkm->kategori }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kontak</label>
                                                <p class="form-control-plaintext">{{ $umkm->kontak }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">RT</label>
                                                <p class="form-control-plaintext">{{ $umkm->rt }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">RW</label>
                                                <p class="form-control-plaintext">{{ $umkm->rw }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alamat Lengkap</label>
                                        <p class="form-control-plaintext">{{ $umkm->alamat }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Deskripsi Usaha</label>
                                        <p class="form-control-plaintext">{{ $umkm->deskripsi }}</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tanggal Dibuat</label>
                                                <p class="form-control-plaintext">{{ $umkm->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Terakhir Diupdate</label>
                                                <p class="form-control-plaintext">{{ $umkm->updated_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Pendukung -->
                            @if($umkm->media->count() > 0)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">File Pendukung</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($umkm->media as $media)
                                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                                <div class="card h-100 border">
                                                    @if(strpos($media->mime_type, 'image') !== false)
                                                        <img src="{{ asset('storage/' . $media->file_path) }}"
                                                             class="card-img-top"
                                                             style="height: 150px; object-fit: cover; cursor: pointer;"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#mediaModal"
                                                             data-media-src="{{ asset('storage/' . $media->file_path) }}"
                                                             data-media-name="{{ $media->original_name }}"
                                                             data-media-caption="{{ $media->caption }}"
                                                             data-media-type="image"
                                                             alt="{{ $media->caption ?? 'File UMKM' }}"
                                                             onerror="this.onerror=null; this.src='{{ asset('images/default-image.jpg') }}';">
                                                    @else
                                                        <div class="card-body text-center" style="height: 150px; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#mediaModal"
                                                             data-media-src="{{ asset('storage/' . $media->file_path) }}"
                                                             data-media-name="{{ $media->original_name }}"
                                                             data-media-caption="{{ $media->caption }}"
                                                             data-media-type="{{ $media->mime_type }}">
                                                            @if(strpos($media->mime_type, 'pdf') !== false)
                                                                <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                            @elseif(strpos($media->mime_type, 'word') !== false)
                                                                <i class="fas fa-file-word fa-3x text-primary mb-2"></i>
                                                            @elseif(strpos($media->mime_type, 'excel') !== false || strpos($media->mime_type, 'spreadsheet') !== false)
                                                                <i class="fas fa-file-excel fa-3x text-success mb-2"></i>
                                                            @else
                                                                <i class="fas fa-file fa-3x text-secondary mb-2"></i>
                                                            @endif
                                                            <p class="card-text small text-truncate">{{ $media->original_name }}</p>
                                                        </div>
                                                    @endif
                                                    @if($media->caption)
                                                        <div class="card-footer small bg-light">
                                                            <div class="text-truncate" title="{{ $media->caption }}">
                                                                {{ $media->caption }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Statistik -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Statistik</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Jumlah File</span>
                                            <span class="badge bg-primary rounded-pill">{{ $umkm->media->count() }}</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Kategori</span>
                                            <span class="badge bg-secondary">{{ $umkm->kategori }}</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Lokasi</span>
                                            <span>RT {{ $umkm->rt }}/RW {{ $umkm->rw }}</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Dibuat</span>
                                            <span>{{ $umkm->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Aksi Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>Edit UMKM
                                        </a>
                                        <form action="{{ route('umkm.destroy', $umkm->umkm_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?')">
                                                <i class="fas fa-trash me-2"></i>Hapus UMKM
                                            </button>
                                        </form>
                                        <a href="{{ route('umkm.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Detail File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="mediaContent"></div>
                <p id="modalMediaName" class="mt-2 text-muted"></p>
                <p id="modalMediaCaption" class="mt-1 text-muted"></p>
            </div>
            <div class="modal-footer">
                <a id="downloadMedia" href="#" class="btn btn-primary" download>
                    <i class="fas fa-download me-2"></i>Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaModal = document.getElementById('mediaModal');
    const mediaContent = document.getElementById('mediaContent');
    const modalMediaName = document.getElementById('modalMediaName');
    const modalMediaCaption = document.getElementById('modalMediaCaption');
    const downloadMedia = document.getElementById('downloadMedia');

    if (mediaModal) {
        mediaModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mediaSrc = button.getAttribute('data-media-src');
            const mediaName = button.getAttribute('data-media-name');
            const mediaCaption = button.getAttribute('data-media-caption');
            const mediaType = button.getAttribute('data-media-type');

            downloadMedia.href = mediaSrc;

            if (modalMediaName) {
                modalMediaName.textContent = mediaName;
            }
            if (modalMediaCaption) {
                modalMediaCaption.textContent = mediaCaption || '(Tidak ada caption)';
            }

            if (mediaContent) {
                if (mediaType.includes('image')) {
                    mediaContent.innerHTML = `
                        <img src="${mediaSrc}" class="img-fluid" style="max-height: 70vh;" alt="${mediaName}">
                    `;
                } else if (mediaType.includes('pdf')) {
                    mediaContent.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-file-pdf fa-3x mb-3"></i>
                            <p>File PDF: ${mediaName}</p>
                            <p class="small">Silakan download untuk melihat isi file</p>
                        </div>
                    `;
                } else {
                    mediaContent.innerHTML = `
                        <div class="alert alert-secondary">
                            <i class="fas fa-file fa-3x mb-3"></i>
                            <p>File: ${mediaName}</p>
                            <p class="small">Tipe: ${mediaType}</p>
                            <p class="small">Silakan download untuk melihat isi file</p>
                        </div>
                    `;
                }
            }
        });
    }
});
</script>
@endpush
