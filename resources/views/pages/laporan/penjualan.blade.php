@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('icon', 'fa-chart-line')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Laporan Penjualan</h4>
    <button class="btn btn-primary">
        <i class="fas fa-download me-2"></i>Export PDF
    </button>
</div>

<!-- Stat Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card card-gradient-1 stat-card">
            <div class="card-body">
                <div class="stat-title">TOTAL PENJUALAN</div>
                <div class="stat-number">Rp {{ number_format($data['total_penjualan'], 0, ',', '.') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-calendar me-1"></i> Periode: {{ $data['periode'] }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card card-gradient-2 stat-card">
            <div class="card-body">
                <div class="stat-title">TOTAL PESANAN</div>
                <div class="stat-number">{{ $data['total_pesanan'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-shopping-cart me-1"></i> Transaksi
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="dashboard-card card-gradient-3 stat-card">
            <div class="card-body">
                <div class="stat-title">RATA-RATA TRANSAKSI</div>
                <div class="stat-number">Rp {{ number_format($data['rata_rata_transaksi'], 0, ',', '.') }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-chart-bar me-1"></i> Per Transaksi
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Grafik Penjualan</h5>
        <div class="chart-placeholder" style="height: 300px;">
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                <h6>Visualisasi Grafik Penjualan</h6>
                <small class="text-muted">Data penjualan periode {{ $data['periode'] }}</small>
            </div>
        </div>
    </div>
</div>
@endsection
