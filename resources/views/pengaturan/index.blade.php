@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('icon', 'fa-cogs')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Pengaturan Sistem</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        <i class="fas fa-info-circle me-2"></i>Informasi Aplikasi
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-cog me-2"></i>Pengguna
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-database me-2"></i>Backup Data
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <h5>Informasi Aplikasi</h5>
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Nama Aplikasi</th>
                        <td>Sistem UMKM</td>
                    </tr>
                    <tr>
                        <th>Versi</th>
                        <td>1.0.0</td>
                    </tr>
                    <tr>
                        <th>Developer</th>
                        <td>Tim Pengembang</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>Desa Digital</td>
                    </tr>
                    <tr>
                        <th>Total UMKM</th>
                        <td>48</td>
                    </tr>
                    <tr>
                        <th>Total Produk</th>
                        <td>156</td>
                    </tr>
                </table>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Sistem UMKM membantu mengelola data usaha mikro, kecil, dan menengah secara terintegrasi.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
