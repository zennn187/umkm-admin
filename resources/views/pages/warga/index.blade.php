@extends('layouts.app')

@section('title', 'Data Warga')
@section('icon', 'fa-users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="animate__animated animate__fadeInDown">
        <i class="fas fa-users me-2"></i>Data Warga
    </h2>
    <a href="{{ route('warga.create') }}" class="btn btn-primary btn-lg animate__animated animate__fadeInRight">
        <i class="fas fa-user-plus"></i> Tambah Warga
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show glass-effect animate__animated animate__fadeIn">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card glass-effect animate__animated animate__fadeInUp">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Warga</h5>
    </div>
    <div class="card-body">
        @if($wargas->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data warga</h5>
                <p class="text-muted">Silakan tambah data warga terlebih dahulu</p>
                <a href="{{ route('warga.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-user-plus"></i> Tambah Warga Pertama
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>No KTP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Telepon</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wargas as $index => $warga)
                        <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.05 }}s">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $warga->no_ktp }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2">
                                        {{ substr($warga->name, 0, 1) }}
                                    </div>
                                    {{ $warga->name }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $warga->jenis_kelamin == 'Laki-laki' ? 'primary' : 'danger' }}">
                                    {{ $warga->jenis_kelamin }}
                                </span>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($warga->tanggal_lahir)) }}</td>
                            <td>
                                <a href="tel:{{ $warga->telp }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $warga->telp }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('warga.show', $warga->warga_id) }}"
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('warga.edit', $warga->warga_id) }}"
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            title="Hapus"
                                            onclick="confirmDelete({{ $warga->warga_id }}, '{{ $warga->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @if($wargas->isNotEmpty())
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $wargas->count() }} data warga
            </div>
            <div>
                <!-- Pagination jika ada -->
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus data warga "${name}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/warga/${id}`;
        form.submit();
    }
}

// Inisialisasi tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection
