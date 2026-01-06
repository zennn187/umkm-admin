@extends('layouts.app')

@section('title', 'Dashboard')
@section('body-class', '')
@section('icon', 'fa-tachometer-alt')

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="profile-card p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted mb-0">
                        <i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-user-tag me-2"></i>Role:
                        <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                    </p>
                    @if(Auth::user()->role === 'mitra' && Auth::user()->nama_usaha)
                        <p class="text-muted">
                            <i class="fas fa-store me-2"></i>Usaha: {{ Auth::user()->nama_usaha }}
                        </p>
                    @endif
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex flex-column align-items-md-end">
                        <div class="mb-3">
                            @if(Auth::user()->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Status: Aktif
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>Status: Nonaktif
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
@if(isset($stats) && !empty($stats))
<div class="stats-grid mb-4">
    @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')
        <!-- Stats untuk Admin -->
        <div class="stat-card total-umkm">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-value" id="totalUmkm">{{ $stats['total_umkm'] ?? 0 }}</div>
            <div class="stat-label">Total UMKM</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Terdaftar
            </div>
        </div>

        <div class="stat-card total-produk">
            <div class="stat-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-value" id="totalProduk">{{ $stats['total_produk'] ?? 0 }}</div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Aktif
            </div>
        </div>

        <div class="stat-card pesanan-baru">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value" id="pesananBaru">{{ $stats['pesanan_baru'] ?? 0 }}</div>
            <div class="stat-label">Pesanan Baru</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Menunggu
            </div>
        </div>

        <div class="stat-card penjualan-bulanan">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($stats['penjualan_bulan_ini'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Penjualan Bulan Ini</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Sukses
            </div>
        </div>

        @if(Auth::user()->role === 'super_admin')
            <div class="stat-card user-aktif">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value" id="userAktif">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stat-label">Total User</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> Terdaftar
                </div>
            </div>

            <div class="stat-card rating">
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-value">{{ $stats['total_mitra'] ?? 0 }}</div>
                <div class="stat-label">Total Mitra</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> Aktif
                </div>
            </div>
        @endif

    @elseif(Auth::user()->role === 'mitra')
        <!-- Stats untuk Mitra -->
        <div class="stat-card total-umkm">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-value">{{ $stats['total_umkm'] ?? 0 }}</div>
            <div class="stat-label">UMKM Anda</div>
            <div class="stat-change positive">
                <i class="fas fa-store"></i> Terdaftar
            </div>
        </div>

        <div class="stat-card total-produk">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-value">{{ $stats['total_produk'] ?? 0 }}</div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-change positive">
                <i class="fas fa-box"></i> Tersedia
            </div>
        </div>

        <div class="stat-card pesanan-baru">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value">{{ $stats['pesanan_baru'] ?? 0 }}</div>
            <div class="stat-label">Pesanan Baru</div>
            <div class="stat-change positive">
                <i class="fas fa-clock"></i> Menunggu
            </div>
        </div>

        <div class="stat-card penjualan-bulanan">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($stats['penjualan_bulan_ini'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Penjualan Bulan Ini</div>
            <div class="stat-change positive">
                <i class="fas fa-chart-line"></i> Sukses
            </div>
        </div>

        <div class="stat-card user-aktif">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $stats['pesanan_selesai'] ?? 0 }}</div>
            <div class="stat-label">Pesanan Selesai</div>
            <div class="stat-change positive">
                <i class="fas fa-check"></i> Sukses
            </div>
        </div>

        <div class="stat-card rating">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-value">{{ $stats['rating'] ?? 0 }}/5</div>
            <div class="stat-label">Rating Rata-rata</div>
            <div class="stat-change positive">
                <i class="fas fa-star"></i> Baik
            </div>
        </div>

    @else
        <!-- Stats untuk User Biasa -->

    @endif
</div>
@endif

<!-- Content berdasarkan role -->
<div class="row">
    @if(Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')
        <!-- Admin Dashboard -->
        <div class="col-md-8">
            <!-- Quick Actions -->
            <div class="profile-card p-4 mb-4">
                <h5 class="mb-4"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('umkm.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-building me-2"></i>Kelola UMKM
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('produk.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-box me-2"></i>Kelola Produk
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('pesanan.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan
                        </a>
                    </div>
                </div>
                @if(Auth::user()->role === 'super_admin')
                <div class="row mt-2">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('users.index') }}" class="btn btn-danger w-100">
                            <i class="fas fa-users-cog me-2"></i>Manajemen User
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('laporan.penjualan') }}" class="btn btn-info w-100">
                            <i class="fas fa-chart-line me-2"></i>Laporan
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-users me-2"></i>Data Warga
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="profile-card p-4">
                <h5 class="mb-4"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>5 menit lalu</td>
                                <td>User baru terdaftar</td>
                                <td>John Doe</td>
                                <td><span class="badge bg-success">Sukses</span></td>
                            </tr>
                            <tr>
                                <td>1 jam lalu</td>
                                <td>Produk baru ditambahkan</td>
                                <td>Warung Sate Ayu</td>
                                <td><span class="badge bg-info">Baru</span></td>
                            </tr>
                            <tr>
                                <td>3 jam lalu</td>
                                <td>Pesanan baru</td>
                                <td>#ORD-00123</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>5 jam lalu</td>
                                <td>UMKM baru terdaftar</td>
                                <td>Dawet Ibu Sari</td>
                                <td><span class="badge bg-primary">Aktif</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Summary -->
            <div class="profile-card p-4 mb-4">
                <h5 class="mb-4"><i class="fas fa-chart-pie me-2"></i>Ringkasan</h5>
                <div class="mb-3">
                    <h6>Status Pesanan</h6>
                    <div class="progress mb-2" style="height: 20px;">
                        <div class="progress-bar bg-success" style="width: 60%">Selesai 60%</div>
                        <div class="progress-bar bg-warning" style="width: 25%">Pending 25%</div>
                        <div class="progress-bar bg-danger" style="width: 15%">Batal 15%</div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Status UMKM</h6>
                    <div class="d-flex justify-content-between">
                        <span>Aktif: {{ $stats['total_umkm'] ?? 0 }}</span>
                        <span>Pending: 3</span>
                        <span>Nonaktif: 2</span>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="profile-card p-4">
                <h5 class="mb-4"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h5>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                        <span>Versi Aplikasi</span>
                        <span class="badge bg-primary">v1.0.0</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                        <span>Tanggal Hari Ini</span>
                        <span>{{ date('d/m/Y') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                        <span>Waktu Server</span>
                        <span>{{ date('H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>

    @elseif(Auth::user()->role === 'mitra')
        <!-- Mitra Dashboard -->
        <div class="col-md-8">
            <!-- Business Overview -->
            <div class="profile-card p-4 mb-4">
                <h5 class="mb-4"><i class="fas fa-store me-2"></i>Ringkasan Bisnis</h5>

                @if($stats['total_umkm'] == 0)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda belum memiliki UMKM terdaftar.
                        <a href="{{ route('umkm.create') }}" class="alert-link">Daftarkan UMKM Anda sekarang!</a>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Total Produk</h6>
                                            <h3 class="mt-2 mb-0">{{ $stats['total_produk'] ?? 0 }}</h3>
                                        </div>
                                        <div class="text-primary">
                                            <i class="fas fa-box fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Pesanan Baru</h6>
                                            <h3 class="mt-2 mb-0">{{ $stats['pesanan_baru'] ?? 0 }}</h3>
                                        </div>
                                        <div class="text-warning">
                                            <i class="fas fa-shopping-cart fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">Pesanan Selesai</h6>
                                            <h3 class="mt-2 mb-0">{{ $stats['pesanan_selesai'] ?? 0 }}</h3>
                                        </div>
                                        <div class="text-success">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">UMKM Anda</h6>
                                            <h3 class="mt-2 mb-0">{{ $stats['total_umkm'] ?? 0 }}</h3>
                                        </div>
                                        <div class="text-info">
                                            <i class="fas fa-building fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Recent Orders -->
            <div class="profile-card p-4">
                <h5 class="mb-4"><i class="fas fa-clock me-2"></i>Pesanan Terbaru</h5>
                @if($stats['pesanan_baru'] > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-001</td>
                                <td>Nasi Goreng Spesial</td>
                                <td>Rp 25.000</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-002</td>
                                <td>Soto Ayam</td>
                                <td>Rp 30.000</td>
                                <td><span class="badge bg-info">Diproses</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada pesanan baru</p>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="profile-card p-4 mb-4">
                <h5 class="mb-4"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('produk.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Produk
                    </a>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-success">
                        <i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan
                    </a>
                    <a href="{{ route('laporan') }}" class="btn btn-info">
                        <i class="fas fa-chart-line me-2"></i>Lihat Laporan
                    </a>
                    @if($stats['total_umkm'] == 0)
                        <a href="{{ route('umkm.create') }}" class="btn btn-warning">
                            <i class="fas fa-store me-2"></i>Daftarkan UMKM
                        </a>
                    @else
                        <a href="{{ route('umkm.index') }}" class="btn btn-warning">
                            <i class="fas fa-store me-2"></i>Kelola UMKM
                        </a>
                    @endif
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="profile-card p-4">
                <h5 class="mb-4"><i class="fas fa-star me-2"></i>Ulasan Terbaru</h5>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <span class="fw-bold">4.5/5</span>
                    </div>
                    <small class="text-muted">Berdasarkan 120 ulasan</small>
                </div>
                <div class="list-group">
                    <div class="list-group-item border-0">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>Budi Santoso</strong>
                            <small class="text-warning">★★★★★</small>
                        </div>
                        <small>"Produk sangat enak dan pengiriman cepat!"</small>
                    </div>
                    <div class="list-group-item border-0">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>Sari Dewi</strong>
                            <small class="text-warning">★★★★☆</small>
                        </div>
                        <small>"Rasanya autentik, harga terjangkau"</small>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- User Biasa Dashboard -->
        <div class="col-md-8">
            <!-- Orders Overview -->
            <div class="profile-card p-4">
                <h5 class="mb-4"><i class="fas fa-shopping-bag me-2"></i>Pesanan Anda</h5>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-primary text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Pesanan Aktif</h6>
                                        <h3 class="mt-2 mb-0">{{ $stats['pesanan_aktif'] ?? 0 }}</h3>
                                    </div>
                                    <div>
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-success text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Pesanan Selesai</h6>
                                        <h3 class="mt-2 mb-0">{{ $stats['pesanan_selesai'] ?? 0 }}</h3>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <h6 class="mb-3">Pesanan Terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Produk</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-001</td>
                                <td>Nasi Goreng Spesial</td>
                                <td>12 Jan 2024</td>
                                <td>Rp 25.000</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-002</td>
                                <td>Soto Ayam</td>
                                <td>10 Jan 2024</td>
                                <td>Rp 30.000</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-list me-2"></i>Lihat Semua Pesanan
                    </a>
                    <a href="{{ route('produk.index') }}" class="btn btn-primary">
                        <i class="fas fa-utensils me-2"></i>Belanja Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Recommendations -->
            <div class="profile-card p-4 mb-4">
                <h5 class="mb-4"><i class="fas fa-star me-2"></i>Rekomendasi Untuk Anda</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action border-0">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Nasi Goreng Spesial</h6>
                            <small>⭐ 4.8</small>
                        </div>
                        <small class="text-muted">Warung Sate Ayu • Rp 25.000</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Soto Ayam Lamongan</h6>
                            <small>⭐ 4.7</small>
                        </div>
                        <small class="text-muted">Soto Lamongan Pak Min • Rp 30.000</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Es Cendol Dawet</h6>
                            <small>⭐ 4.9</small>
                        </div>
                        <small class="text-muted">Dawet Ibu Sari • Rp 15.000</small>
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="profile-card p-4">
                <h5 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Keranjang Anda</h5>
                <div class="text-center py-3">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Keranjang Anda masih kosong</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats counter
        function animateCounter(element, start, end, duration) {
            if (!element) return;

            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);

                if (element.textContent.includes('Rp')) {
                    element.textContent = 'Rp ' + value.toLocaleString('id-ID');
                } else {
                    element.textContent = value;
                }

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Animate all stat values
        setTimeout(() => {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                const valueElement = card.querySelector('.stat-value');
                if (valueElement) {
                    const currentValue = valueElement.textContent.trim();

                    // Check if it's a currency value
                    if (currentValue.includes('Rp')) {
                        const numericValue = parseInt(currentValue.replace(/[^0-9]/g, ''));
                        if (!isNaN(numericValue)) {
                            animateCounter(valueElement, 0, numericValue, 2000);
                        }
                    } else {
                        // Regular number
                        const numericValue = parseInt(currentValue);
                        if (!isNaN(numericValue)) {
                            animateCounter(valueElement, 0, numericValue, 1500);
                        }
                    }
                }
            });
        }, 500);
    });
</script>
@endpush
