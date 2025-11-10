@extends('layouts.app')

@section('title', 'Pesanan Selesai')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-check-circle text-success me-2"></i>Pesanan Selesai
                    </h4>
                </div>
                <div class="card-body">
                    @if($pesanans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pesanan</th>
                                        <th>Nama Customer</th>
                                        <th>Total</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanans as $pesanan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $pesanan->kode_pesanan }}</strong>
                                        </td>
                                        <td>{{ $pesanan->nama_customer }}</td>
                                        <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $pesanan->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('pesanan.show', $pesanan->id) }}"
                                               class="btn btn-sm btn-info"
                                               title="Detail Pesanan">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5>Belum ada pesanan yang selesai</h5>
                            <p class="text-muted">Semua pesanan yang sudah selesai akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
