@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Daftar Pesanan</h3>

    {{-- FILTER DAN SEARCH --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('pesanan.index') }}" method="GET">
                <div class="row g-3">
                    {{-- Search Input --}}
                    <div class="col-md-4">
                        <label for="search" class="form-label">Pencarian</label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Cari nomor pesanan, customer, atau alamat..."
                               value="{{ request('search') }}">
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Filter RT --}}
                    <div class="col-md-2">
                        <label for="rt" class="form-label">RT</label>
                        <input type="text" class="form-control" id="rt" name="rt"
                               placeholder="RT" value="{{ request('rt') }}">
                    </div>

                    {{-- Filter RW --}}
                    <div class="col-md-2">
                        <label for="rw" class="form-label">RW</label>
                        <input type="text" class="form-control" id="rw" name="rw"
                               placeholder="RW" value="{{ request('rw') }}">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Terapkan
                            </button>
                            <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($pesanans->count() > 0)
            {{-- Info Filter Aktif --}}
            @if(request()->hasAny(['search', 'status', 'rt', 'rw']))
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle"></i>
                    Menampilkan hasil filter:
                    @if(request('search')) <span class="badge bg-primary">Pencarian: "{{ request('search') }}"</span> @endif
                    @if(request('status')) <span class="badge bg-success">Status: {{ request('status') }}</span> @endif
                    @if(request('rt')) <span class="badge bg-warning">RT: {{ request('rt') }}</span> @endif
                    @if(request('rw')) <span class="badge bg-warning">RW: {{ request('rw') }}</span> @endif
                </div>
                <a href="{{ route('pesanan.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-times"></i> Hapus Filter
                </a>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table">
                        <tr>
                            <th>No</th>
                            <th>Nomor Pesanan</th>
                            <th>Customer</th>
                            <th>UMKM</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>RT/RW</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pesanans as $index => $item)
                        <tr>
                            <td>{{ $pesanans->firstItem() + $index }}</td>
                            <td>{{ $item->nomor_pesanan }}</td>
                            <td>{{ $item->warga->nama ?? 'Tidak Diketahui' }}</td>
                            <td>{{ $item->umkm->nama_umkm ?? '-' }}</td>
                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge
                                    @if($item->status == 'Baru') bg-primary
                                    @elseif($item->status == 'Diproses') bg-warning
                                    @elseif($item->status == 'Dikirim') bg-info
                                    @elseif($item->status == 'Selesai') bg-success
                                    @elseif($item->status == 'Dibatalkan') bg-danger
                                    @endif">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ Str::limit($item->alamat_kirim, 50) }}</td>
                            <td>{{ $item->rt }}/{{ $item->rw }}</td>
                            <td>
                                <a href="{{ route('pesanan.show', $item->pesanan_id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $pesanans->links('pagination::bootstrap-5') }}
            </div>

            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada pesanan.</p>
                    @if(request()->hasAny(['search', 'status', 'rt', 'rw']))
                        <a href="{{ route('pesanan.index') }}" class="btn btn-primary">
                            <i class="fas fa-refresh"></i> Tampilkan Semua Pesanan
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
