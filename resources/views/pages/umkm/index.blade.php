@extends('layouts.app')

@section('title', 'Data UMKM')
@section('icon', 'fa-building')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Data UMKM</h4>
    <a href="{{ route('umkm.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Tambah UMKM
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- FILTER DAN SEARCH --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('umkm.index') }}" method="GET">
            <div class="row g-3">
                {{-- Search Input --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Pencarian</label>
                    <input type="text" class="form-control" id="search" name="search"
                           placeholder="Cari nama usaha, pemilik, alamat..."
                           value="{{ request('search') }}">
                </div>

                {{-- Filter Kategori --}}
                <div class="col-md-2">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategories as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter RT --}}
                <div class="col-md-1">
                    <label for="rt" class="form-label">RT</label>
                    <input type="text" class="form-control" id="rt" name="rt"
                           placeholder="RT" value="{{ request('rt') }}" maxlength="3">
                </div>

                {{-- Filter RW --}}
                <div class="col-md-1">
                    <label for="rw" class="form-label">RW</label>
                    <input type="text" class="form-control" id="rw" name="rw"
                           placeholder="RW" value="{{ request('rw') }}" maxlength="3">
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Terapkan
                        </button>
                        <a href="{{ route('umkm.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- Info Filter Aktif --}}
        @if(request()->hasAny(['search', 'kategori', 'rt', 'rw']))
        <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
            <div>
                <i class="fas fa-info-circle"></i>
                Menampilkan hasil filter:
                @if(request('search')) <span class="badge bg-primary">Pencarian: "{{ request('search') }}"</span> @endif
                @if(request('kategori')) <span class="badge bg-warning">Kategori: {{ request('kategori') }}</span> @endif
                @if(request('rt')) <span class="badge bg-info">RT: {{ request('rt') }}</span> @endif
                @if(request('rw')) <span class="badge bg-info">RW: {{ request('rw') }}</span> @endif
            </div>
            <a href="{{ route('umkm.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-times"></i> Hapus Filter
            </a>
        </div>
        @endif

        @if($umkms->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto/File</th>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Alamat</th>
                        <th>Kategori</th>
                        <th>Kontak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($umkms as $umkm)
                    <tr>
                        <td>{{ $loop->iteration + ($umkms->currentPage()-1) * $umkms->perPage() }}</td>
                        <td>
                            @if($umkm->media->count() > 0)
                                @php
                                    $firstMedia = $umkm->media->first();
                                    $isImage = strpos($firstMedia->mime_type, 'image') !== false;
                                    $fileUrl = asset('storage/' . $firstMedia->file_path);
                                @endphp

                                @if($isImage)
                                    <img src="{{ $fileUrl }}"
                                         class="rounded-circle mt-1"
                                         style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #28a745;"
                                         alt="{{ $umkm->nama_usaha }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="avatar-sm bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center mt-1"
                                         style="width: 45px; height: 45px; display: none;">
                                        <i class="fas fa-store fa-sm"></i>
                                    </div>
                                @else
                                    <div class="avatar-sm bg-info rounded-circle text-white d-flex align-items-center justify-content-center mt-1"
                                         style="width: 45px; height: 45px;">
                                        <i class="fas fa-file fa-sm"></i>
                                    </div>
                                @endif
                            @else
                                <div class="avatar-sm bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center mt-1"
                                     style="width: 45px; height: 45px;">
                                    <i class="fas fa-store fa-sm"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <strong>{{ $umkm->nama_usaha }}</strong>
                                    @if($umkm->media->count() > 0)
                                        <br><small class="text-muted">{{ $umkm->media->count() }} file</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $umkm->pemilik->name ?? 'Tidak diketahui' }}</td>
                        <td>
                            {{ Str::limit($umkm->alamat, 30) }},
                            <br><small class="text-muted">RT {{ $umkm->rt }}/RW {{ $umkm->rw }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $umkm->kategori }}</span>
                        </td>
                        <td>{{ $umkm->kontak }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('umkm.show', $umkm->umkm_id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('umkm.destroy', $umkm->umkm_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="mt-3">
                {{ $umkms->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-building fa-3x text-muted mb-3"></i>
            @if(request()->hasAny(['search', 'kategori', 'rt', 'rw']))
                <h5>Tidak ada UMKM yang sesuai dengan filter</h5>
                <p class="text-muted">Coba ubah kriteria pencarian atau filter Anda.</p>
                <a href="{{ route('umkm.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-2"></i>Tampilkan Semua UMKM
                </a>
            @else
                <h5>Belum ada data UMKM</h5>
                <p class="text-muted">Silakan tambah data UMKM pertama Anda.</p>
                <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah UMKM Pertama
                </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
