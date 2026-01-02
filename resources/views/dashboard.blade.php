@extends('layouts.app')

@section('title', 'Dashboard UMKM')
@section('icon', 'fa-store')

@section('styles')
    <style>
        .quick-action-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
            height: 100%;
            text-align: center;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }

        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px 0 rgba(0, 0, 0, 0.15);
        }

        .quick-action-card .icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .recent-activity {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .activity-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1rem;
        }

        .activity-icon.success {
            background-color: rgba(45, 206, 137, 0.1);
            color: var(--success-color);
        }

        .activity-icon.warning {
            background-color: rgba(251, 99, 64, 0.1);
            color: var(--warning-color);
        }

        .activity-icon.info {
            background-color: rgba(17, 205, 239, 0.1);
            color: var(--info-color);
        }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .stat-change.positive {
            color: rgba(255, 255, 255, 0.9);
        }
    </style>
@endsection

@section('content')
    <!-- Welcome Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->



    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3">Aksi Cepat</h5>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <a href="{{ route('umkm.create') }}" class="text-decoration-none">
                <div class="quick-action-card">
                    <div class="icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h6>Tambah UMKM</h6>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <a href="{{ route('produk.create') }}" class="text-decoration-none">
                <div class="quick-action-card">
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h6>Tambah Produk</h6>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <a href="{{ route('pesanan.index') }}" class="text-decoration-none">
                <div class="quick-action-card">
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h6>Pesanan Baru</h6>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <a href="{{ route('laporan.penjualan') }}" class="text-decoration-none">
                <div class="quick-action-card">
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h6>Laporan</h6>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <a href="{{ route('pengaturan') }}" class="text-decoration-none">
                <div class="quick-action-card">
                    <div class="icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h6>Pengaturan</h6>
                </div>
            </a>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="row">
        <div class="col-12">
            <div class="chart-container">
                <h5 class="mb-4">Performa Penjualan</h5>
                <div class="chart-placeholder">
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-3x text-primary mb-3"></i>
                        <h6>Grafik Performa Penjualan</h6>
                        <small class="text-muted">Data penjualan 7 hari terakhir</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="chart-container">
                <h5 class="mb-4">Produk Terlaris</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>UMKM</th>
                                <th>Terjual</th>
                                <th>Pendapatan</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kue Lapis Legit</td>
                                <td>Toko Roti Segar</td>
                                <td>45</td>
                                <td>Rp 2.250.000</td>
                                <td><span class="badge bg-success">4.8</span></td>
                            </tr>
                            <tr>
                                <td>Keripik Singkong</td>
                                <td>UMKM Sumber Rejeki</td>
                                <td>38</td>
                                <td>Rp 1.140.000</td>
                                <td><span class="badge bg-success">4.6</span></td>
                            </tr>
                            <tr>
                                <td>Minyak Goreng Kelapa</td>
                                <td>Toko Sehat Alami</td>
                                <td>32</td>
                                <td>Rp 1.920.000</td>
                                <td><span class="badge bg-success">4.7</span></td>
                            </tr>
                            <tr>
                                <td>Sabun Herbal</td>
                                <td>UMKM Mandiri Sehat</td>
                                <td>28</td>
                                <td>Rp 840.000</td>
                                <td><span class="badge bg-warning">4.2</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
