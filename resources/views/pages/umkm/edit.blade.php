@extends('layouts.app')

@section('title', 'Edit UMKM')
@section('icon', 'fa-building')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data UMKM</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('umkm.update', $umkm['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_usaha" class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_usaha" name="nama_usaha"
                               value="{{ $umkm['nama_usaha'] }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pemilik" name="pemilik"
                               value="{{ $umkm['pemilik'] }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $umkm['alamat'] }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rt" name="rt"
                               value="{{ $umkm['rt'] }}" required maxlength="3">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rw" name="rw"
                               value="{{ $umkm['rw'] }}" required maxlength="3">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Usaha <span class="text-danger">*</span></label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="Makanan & Minuman" {{ $umkm['kategori'] == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                            <option value="Kerajinan Tangan" {{ $umkm['kategori'] == 'Kerajinan Tangan' ? 'selected' : '' }}>Kerajinan Tangan</option>
                            <option value="Fashion" {{ $umkm['kategori'] == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                            <option value="Kesehatan & Kecantikan" {{ $umkm['kategori'] == 'Kesehatan & Kecantikan' ? 'selected' : '' }}>Kesehatan & Kecantikan</option>
                            <option value="Jasa" {{ $umkm['kategori'] == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            <option value="Lainnya" {{ $umkm['kategori'] == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak/No. HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kontak" name="kontak"
                               value="{{ $umkm['kontak'] }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Usaha <span class="text-danger">*</span></label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $umkm['deskripsi'] }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('umkm.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
