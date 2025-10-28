@extends('layouts.app')

@section('title', 'Semua Pesanan')
@section('icon', 'fa-shopping-cart')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Semua Pesanan</h4>
    <div class="btn-group">
        <a href="{{ route('pesanan.baru') }}" class="btn btn-outline-primary">Pesanan Baru</a>
        <a href="{{ route('pesanan.diproses') }}" class="btn btn-outline-warning">Sedang Diproses</a>
        <a href="{{ route('pesanan.selesai') }}" class="btn btn-outline-success">Selesai</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Metode Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanans as $pesanan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $pesanan['nomor_pesanan'] }}</strong>
                        </td>
                        <td>{{ $pesanan['customer'] }}</td>
                        <td>Rp {{ number_format($pesanan['total'], 0, ',', '.') }}</td>
                        <td>
                            @if($pesanan['status'] == 'Baru')
                                <span class="badge bg-warning">{{ $pesanan['status'] }}</span>
                            @elseif($pesanan['status'] == 'Diproses')
                                <span class="badge bg-primary">{{ $pesanan['status'] }}</span>
                            @elseif($pesanan['status'] == 'Selesai')
                                <span class="badge bg-success">{{ $pesanan['status'] }}</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($pesanan['tanggal'])->format('d M Y H:i') }}</td>
                        <td>{{ $pesanan['metode_bayar'] }}</td>
                        <td>
                            <a href="{{ route('pesanan.show', $pesanan['id']) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
