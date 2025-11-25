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
                                                <p class="form-control-plaintext">{{ $umkm->pemilik }}</p>
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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <p>
                                                    <span class="badge bg-{{ $umkm->status == 'Aktif' ? 'success' : 'danger' }}">
                                                        {{ $umkm->status }}
                                                    </span>
                                                </p>
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
                        </div>

                        <div class="col-md-4">
                            <!-- Gallery Photos -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Gallery Foto</h5>
                                </div>
                                <div class="card-body">
                                    @if($umkm->photos->count() > 0)
                                        <div class="row g-2">
                                            @foreach($umkm->photos as $photo)
                                                <div class="col-6">
                                                    <div class="photo-gallery-item position-relative">
                                                        <img src="{{ asset('storage/umkm-photos/' . $photo->photo_path) }}"
                                                             class="img-fluid rounded"
                                                             style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;"
                                                             data-bs-toggle="modal" data-bs-target="#photoModal"
                                                             data-photo-src="{{ asset('storage/umkm-photos/' . $photo->photo_path) }}"
                                                             data-photo-name="{{ $photo->photo_name }}"
                                                             alt="{{ $photo->photo_name }}"
                                                             onerror="this.src='{{ asset('images/default-umkm.jpg') }}'">
                                                        @if($photo->is_primary)
                                                            <span class="position-absolute top-0 start-0 badge bg-primary m-1">
                                                                Utama
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-images fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada foto</p>
                                        </div>
                                    @endif
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

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Detail Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid" style="max-height: 70vh;" alt="Modal Photo">
                <p id="modalPhotoName" class="mt-2 text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.photo-gallery-item:hover img {
    transform: scale(1.05);
    transition: transform 0.2s;
}
.photo-gallery-item {
    margin-bottom: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoModal = document.getElementById('photoModal');
    const modalPhoto = document.getElementById('modalPhoto');
    const modalPhotoName = document.getElementById('modalPhotoName');

    if (photoModal) {
        photoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const photoSrc = button.getAttribute('data-photo-src');
            const photoName = button.getAttribute('data-photo-name');

            if (modalPhoto) {
                modalPhoto.src = photoSrc;
            }
            if (modalPhotoName) {
                modalPhotoName.textContent = photoName;
            }
        });
    }
});
</script>
@endsection
