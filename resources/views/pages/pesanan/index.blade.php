@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Daftar Pesanan</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($pesanans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nomor Pesanan</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pesanans as $index => $item)
                        <tr>
                            <td>{{ $pesanans->firstItem() + $index }}</td>
                            <td>{{ $item->nomor_pesanan }}</td>
                            <td>{{ $item->customer }}</td>
                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-info">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->alamat_kirim }}</td>
                            <td>
                                <a href="{{ route('pesanan.show', $item->pesanan_id) }}"
                                   class="btn btn-sm btn-primary">
                                    Detail
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
                <p class="text-center text-muted">Belum ada pesanan.</p>
            @endif

        </div>
    </div>

</div>
@endsection
