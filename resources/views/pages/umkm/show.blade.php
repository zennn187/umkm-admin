@extends('layouts.app')

@section('title', 'Detail UMKM')
@section('icon', 'fa-building')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Detail UMKM</h5>
        <div>
            <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('umkm.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Nama Usaha</th>
                        <td>{{ $umkm->nama_usaha }}</td>
                    </tr>
                    <tr>
                        <th>Pemilik</th>
                        <td>{{ $umkm->pemilik }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $umkm->alamat }}</td>
                    </tr>
                    <tr>
                        <th>RT/RW</th>
                        <td>RT {{ $umkm->rt }}/RW {{ $umkm->rw }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Kategori</th>
                        <td>{{ $umkm->kategori }}</td>
                    </tr>
                    <tr>
                        <th>Kontak</th>
                        <td>{{ $umkm->kontak }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $umkm->status == 'Aktif' ? 'success' : 'danger' }}">
                                {{ $umkm->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Bergabung</th>
                        <td>{{ $umkm->created_at->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <h6>Deskripsi Usaha</h6>
                <div class="border p-3 rounded">
                    {{ $umkm->deskripsi }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
