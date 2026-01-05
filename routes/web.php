<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

// ==================== ROUTE PUBLIC ====================
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ==================== PROTECTED ROUTES (BUTUH LOGIN) ====================
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

// Media routes
    Route::prefix('media')->group(function () {
        Route::post('/upload', [MediaController::class, 'upload'])->name('media.upload');
        Route::delete('/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
        Route::put('/{id}/caption', [MediaController::class, 'updateCaption'])->name('media.update-caption');
        Route::put('/update-order', [MediaController::class, 'updateOrder'])->name('media.update-order');
    });

    // ========== ROUTES UNTUK SEMUA USER YANG LOGIN ==========

    // UMKM Routes (bisa diakses semua user yang login)
    Route::resource('umkm', UmkmController::class);

    // Produk Routes (bisa diakses semua user yang login)
    Route::resource('produk', ProdukController::class);

    // Route untuk pesanan
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        // Resource routes
        Route::get('/', [PesananController::class, 'index'])->name('index');
        Route::get('/create', [PesananController::class, 'create'])->name('create');
        Route::post('/', [PesananController::class, 'store'])->name('store');
        Route::get('/{pesanan}', [PesananController::class, 'show'])->name('show');
        Route::get('/{pesanan}/edit', [PesananController::class, 'edit'])->name('edit');
        Route::put('/{pesanan}', [PesananController::class, 'update'])->name('update');
        Route::delete('/{pesanan}', [PesananController::class, 'destroy'])->name('destroy');

        // Route khusus untuk update status
        Route::patch('/pesanan/{pesanan}/update-status', [PesananController::class, 'updateStatus'])
            ->name('pesanan.update.status');

// Route khusus untuk upload bukti bayar
        Route::post('/pesanan/{pesanan}/upload-bukti', [PesananController::class, 'uploadBuktiBayar'])
            ->name('pesanan.upload.bukti');

// Route untuk filter status
        Route::get('/pesanan/status/baru', [PesananController::class, 'baru'])->name('pesanan.baru');
        Route::get('/pesanan/status/diproses', [PesananController::class, 'diproses'])->name('pesanan.diproses');
        Route::get('/pesanan/status/selesai', [PesananController::class, 'selesai'])->name('pesanan.selesai');
        Route::get('/pesanan/{pesanan}/delete', [PesananController::class, 'delete'])
    ->name('pesanan.delete');
    });
        // ========== ROUTES BERDASARKAN ROLE ==========

        // Routes untuk Super Admin SAJA
        Route::middleware(['checkrole:super_admin'])->group(function () {
            // User Management (hanya Super Admin)
            Route::resource('users', UserController::class);
            Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

            // System Logs (hanya Super Admin)
            Route::get('/system/logs', function () {
                return view('pages.system.logs');
            })->name('system.logs');

            // Warga (hanya Super Admin)
            Route::resource('warga', WargaController::class);
        });

        // Routes untuk Super Admin dan Admin
        Route::middleware(['checkrole:super_admin,admin'])->group(function () {
            // Laporan Routes
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
                Route::get('/produk', [LaporanController::class, 'produk'])->name('produk');
                Route::get('/umkm', [LaporanController::class, 'umkm'])->name('umkm');
            });

            // Pengaturan (Super Admin & Admin)
            Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');

            // Pembayaran (Super Admin & Admin)
            Route::get('/pembayaran', [PesananController::class, 'pembayaran'])->name('pembayaran.index');
        });

        // Routes untuk Mitra saja
        Route::middleware(['checkrole:mitra'])->group(function () {
            Route::get('/mitra/dashboard', [DashboardController::class, 'mitraDashboard'])->name('mitra.dashboard');
        });
    });

// ==================== HELPER FUNCTIONS ====================
    if (! function_exists('formatBytes')) {
        function formatBytes($bytes, $decimals = 2)
        {
            $size   = ['B', 'KB', 'MB', 'GB', 'TB'];
            $factor = floor((strlen($bytes) - 1) / 3);

            if ($bytes == 0) {
                return '0 B';
            }

            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
        }
    }

// ==================== FALLBACK ROUTE ====================
    Route::fallback(function () {
        return redirect()->route('dashboard');
    });
