@extends('layouts.app')

@section('title', 'Tambah Data Warga')
@section('icon', 'fa-user-plus')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card glass-effect animate__animated animate__fadeIn">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Data Warga Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('warga.store') }}" method="POST" id="wargaForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_ktp" class="form-label">
                                <i class="fas fa-id-card me-1"></i>No KTP <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                                   id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}"
                                   maxlength="16" required placeholder="Masukkan 16 digit NIK">
                            @error('no_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Contoh: 3271010101010001</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}"
                                   required placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                <i class="fas fa-venus-mars me-1"></i>Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="agama" class="form-label">
                                <i class="fas fa-pray me-1"></i>Agama <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('agama') is-invalid @enderror"
                                    id="agama" name="agama" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                   required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pekerjaan" class="form-label">
                                <i class="fas fa-briefcase me-1"></i>Pekerjaan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                   id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                   required placeholder="Masukkan pekerjaan">
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telp" class="form-label">
                                <i class="fas fa-phone me-1"></i>No Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                   id="telp" name="telp" value="{{ old('telp') }}"
                                   required placeholder="Contoh: 081234567890">
                            @error('telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}"
                                   placeholder="nama@contoh.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">
                            <i class="fas fa-home me-1"></i>Alamat Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                  id="alamat" name="alamat" rows="4"
                                  required placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Validasi NIK harus 16 digit
document.getElementById('no_ktp').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 16);
});

// Validasi telepon hanya angka
document.getElementById('telp').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});

// Set max date untuk tanggal lahir (hari ini)
document.getElementById('tanggal_lahir').max = new Date().toISOString().split("T")[0];
</script>
@endpush
@endsection
