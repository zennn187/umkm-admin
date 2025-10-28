<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Support\Facades\Route;

// Route Public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route yang membutuhkan authentication - SISTEM UMKM
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Data Master - UMKM
    Route::prefix('umkm')->group(function () {
        Route::get('/', [UmkmController::class, 'index'])->name('umkm.index');
        Route::get('/create', [UmkmController::class, 'create'])->name('umkm.create');
        Route::post('/', [UmkmController::class, 'store'])->name('umkm.store');
        Route::get('/{id}', [UmkmController::class, 'show'])->name('umkm.show');
        Route::get('/{id}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
        Route::put('/{id}', [UmkmController::class, 'update'])->name('umkm.update');
        Route::delete('/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');
    });

    // Data Master - Produk
    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/{id}', [ProdukController::class, 'show'])->name('produk.show');
        Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    });

    // Kategori Produk
    Route::get('/kategori', [ProdukController::class, 'kategori'])->name('kategori.index');

    // Transaksi - Pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/baru', [PesananController::class, 'baru'])->name('pesanan.baru');
        Route::get('/diproses', [PesananController::class, 'diproses'])->name('pesanan.diproses');
        Route::get('/selesai', [PesananController::class, 'selesai'])->name('pesanan.selesai');
        Route::get('/{id}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::put('/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    });

    // Pembayaran
    Route::get('/pembayaran', [PesananController::class, 'pembayaran'])->name('pembayaran.index');

    // Laporan
    Route::prefix('laporan')->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
        Route::get('/produk', [LaporanController::class, 'produk'])->name('laporan.produk');
        Route::get('/umkm', [LaporanController::class, 'umkm'])->name('laporan.umkm');
    });

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Fallback route
Route::fallback(function () {
    return redirect()->route('home');
});
