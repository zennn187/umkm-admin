@extends('layouts.app')

@section('title', 'Edit Produk')
@section('icon', 'fa-edit')

@section('content')
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Produk</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->produk_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                id="nama_produk" name="nama_produk"
                                value="{{ old('nama_produk', $produk->nama_produk) }}" maxlength="100" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="umkm_id" class="form-label">UMKM <span class="text-danger">*</span></label>
                            <select class="form-control @error('umkm_id') is-invalid @enderror" id="umkm_id" name="umkm_id" required>
                                <option value="">Pilih UMKM</option>
                                @foreach($umkms as $umkm)
                                    <option value="{{ $umkm->umkm_id }}"
                                        {{ old('umkm_id', $produk->umkm_id) == $umkm->umkm_id ? 'selected' : '' }}>
                                        {{ $umkm->nama_usaha }}
                                    </option>
                                @endforeach
                            </select>
                            @error('umkm_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_produk" class="form-label">Jenis Produk</label>
                            <input type="text" class="form-control @error('jenis_produk') is-invalid @enderror"
                                id="jenis_produk" name="jenis_produk"
                                value="{{ old('jenis_produk', $produk->jenis_produk) }}" maxlength="100">
                            @error('jenis_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif" {{ old('status', $produk->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ old('status', $produk->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                        name="deskripsi" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                id="harga" name="harga"
                                value="{{ old('harga', $produk->harga) }}" min="0" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                id="stok" name="stok"
                                value="{{ old('stok', $produk->stok) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Perbarui Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
