@extends('layouts.app')

@section('title', 'Detail Data Warga')
@section('icon', 'fa-user-circle')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card glass-effect animate__animated animate__fadeInLeft">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="avatar-xxl bg-primary rounded-circle d-inline-flex align-items-center justify-content-center text-white">
                        <span style="font-size: 3rem; font-weight: bold;">
                            {{ substr($warga->name, 0, 1) }}
                        </span>
                    </div>
                </div>
                <h4 class="mb-1">{{ $warga->name }}</h4>
                <p class="text-muted mb-3">{{ $warga->no_ktp }}</p>

                <div class="d-flex justify-content-center mb-3">
                    <span class="badge bg-{{ $warga->jenis_kelamin == 'Laki-laki' ? 'primary' : 'danger' }} fs-6 px-3 py-2">
                        <i class="fas fa-{{ $warga->jenis_kelamin == 'Laki-laki' ? 'mars' : 'venus' }} me-1"></i>
                        {{ $warga->jenis_kelamin }}
                    </span>
                </div>

                <div class="mt-4">
                    <a href="tel:{{ $warga->telp }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-phone"></i> Telepon
                    </a>
                    @if($warga->email)
                    <a href="mailto:{{ $warga->email }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card glass-effect animate__animated animate__fadeInRight">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Detail Warga</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">ID Warga</th>
                                <td>: <strong>{{ $warga->warga_id }}</strong></td>
                            </tr>
                            <tr>
                                <th>No KTP/NIK</th>
                                <td>: <code>{{ $warga->no_ktp }}</code></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>: {{ $warga->name }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>:
                                    <span class="badge bg-{{ $warga->jenis_kelamin == 'Laki-laki' ? 'primary' : 'danger' }}">
                                        {{ $warga->jenis_kelamin }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>: {{ $warga->agama }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Tanggal Lahir</th>
                                <td>: {{ date('d F Y', strtotime($warga->tanggal_lahir)) }}</td>
                            </tr>
                            <tr>
                                <th>Umur</th>
                                <td>:
                                    <?php
                                        $birthDate = new DateTime($warga->tanggal_lahir);
                                        $today = new DateTime();
                                        $age = $birthDate->diff($today)->y;
                                        echo $age . ' tahun';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>: {{ $warga->pekerjaan }}</td>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <td>:
                                    <a href="tel:{{ $warga->telp }}" class="text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>{{ $warga->telp }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>:
                                    @if($warga->email)
                                        <a href="mailto:{{ $warga->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-1"></i>{{ $warga->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6><i class="fas fa-home me-2"></i>Alamat Lengkap</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-0">{{ $warga->alamat }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Data dibuat: {{ $warga->created_at->format('d/m/Y H:i') }} |
                                    Terakhir diupdate: {{ $warga->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('warga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                    <div>
                        <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-danger"
                                onclick="confirmDelete({{ $warga->warga_id }}, '{{ $warga->name }}')">
                            <i class="fas fa-trash me-1"></i> Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('styles')
<style>
.avatar-xxl {
    width: 120px;
    height: 120px;
    line-height: 120px;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus data warga "${name}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/warga/${id}`;
        form.submit();
    }
}
</script>
@endpush
@endsection
