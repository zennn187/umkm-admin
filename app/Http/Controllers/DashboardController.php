<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Umkm;
use App\Models\Produk;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    /**
     * Show dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik berdasarkan role
        $stats = $this->getDashboardStats($user);

        return view('pages.dashboard.index', compact('user', 'stats'));
    }

    /**
     * Get dashboard statistics based on user role
     */
    private function getDashboardStats($user)
{
    $stats = [];

    switch ($user->role) {
        case 'super_admin':
        case 'admin':
            $stats = [
                'total_umkm' => Umkm::count(),
                'total_produk' => Produk::count(),
                'pesanan_baru' => Pesanan::where('status', 'Baru')->count(),
                'total_pesanan' => Pesanan::count(),
                'total_users' => User::count(),
                'user_aktif' => User::where('is_active', true)->count(),
                'penjualan_bulan_ini' => Pesanan::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->where('status', 'Selesai')
                    ->sum('total'),
                'total_mitra' => User::where('role', 'mitra')->count(),
            ];
            break;

        case 'mitra':
            $stats = [
                'total_umkm' => Umkm::where('user_id', $user->id)->count(),
                'total_produk' => Produk::where('user_id', $user->id)->count(),
                'pesanan_baru' => Pesanan::whereHas('umkm', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->where('status', 'Baru')->count(),
                'total_pesanan' => Pesanan::whereHas('umkm', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->count(),
                'pesanan_selesai' => Pesanan::whereHas('umkm', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->where('status', 'Selesai')->count(),
                'penjualan_bulan_ini' => Pesanan::whereHas('umkm', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year)
                      ->where('status', 'Selesai')
                      ->sum('total'),
                'rating' => 4.5,
            ];
            break;

        default: // user
            // PERBAIKAN: User biasa lihat pesanan berdasarkan warga_id
            $stats = [
                'pesanan_aktif' => Pesanan::where('warga_id', $user->id)
                    ->whereIn('status', ['Baru', 'Diproses', 'Dikirim'])
                    ->count(),
                'pesanan_selesai' => Pesanan::where('warga_id', $user->id)
                    ->where('status', 'Selesai')
                    ->count(),
                'total_pesanan' => Pesanan::where('warga_id', $user->id)->count(),
                'total_favorit' => 0,
                'total_keranjang' => 0,
            ];
            break;
    }

    return $stats;
}

    /**
     * Show user management page (only for admin)
     */
    public function userManagement()
    {
        // Middleware akan menangani otorisasi
        $users = User::with('umkms')->latest()->paginate(10);

        return view('pages.dashboard.users', compact('users'));
    }

    /**
     * Show UMKM management page
     */
    public function umkmManagement()
    {
        $user = Auth::user();

        if ($user->role === 'super_admin' || $user->role === 'admin') {
            // Admin bisa lihat semua UMKM
            $umkms = Umkm::with('user')->latest()->paginate(10);
        } elseif ($user->role === 'mitra') {
            // Mitra hanya bisa lihat UMKM miliknya
            $umkms = Umkm::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            // User biasa tidak punya UMKM
            $umkms = collect();
        }

        return view('pages.dashboard.umkm', compact('umkms'));
    }

    /**
     * Show produk management page
     */
    public function produkManagement()
    {
        $user = Auth::user();

        if ($user->role === 'super_admin' || $user->role === 'admin') {
            // Admin bisa lihat semua produk
            $produks = Produk::with(['umkm', 'user'])->latest()->paginate(10);
        } elseif ($user->role === 'mitra') {
            // Mitra hanya bisa lihat produk miliknya
            $produks = Produk::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            // User biasa
            $produks = Produk::where('status', 'active')->latest()->paginate(10);
        }

        return view('pages.dashboard.produk', compact('produks'));
    }

    /**
     * Show pesanan management page
     */
    public function pesananManagement()
    {
        $user = Auth::user();

        if ($user->role === 'super_admin' || $user->role === 'admin') {
            // Admin bisa lihat semua pesanan
            $pesanans = Pesanan::with(['user', 'produk'])->latest()->paginate(10);
        } elseif ($user->role === 'mitra') {
            // Mitra hanya bisa lihat pesanan untuk produknya
            $pesanans = Pesanan::whereHas('produk', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['user', 'produk'])->latest()->paginate(10);
        } else {
            // PERBAIKAN DI SINI: gunakan 'umkm_id' bukan 'user_id'
            // User biasa hanya bisa lihat pesanannya sendiri
            $pesanans = Pesanan::where('umkm_id', $user->id)->with('produk')->latest()->paginate(10);
        }

        return view('pages.dashboard.pesanan', compact('pesanans'));
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        $user = Auth::user();

        return view('pages.profile.index', compact('user'));
    }

    /**
     * Show laporan page
     */
    public function laporan()
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Data untuk laporan
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        if ($user->role === 'mitra') {
            $penjualanData = Pesanan::whereHas('produk', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereMonth('created_at', $bulanIni)
              ->whereYear('created_at', $tahunIni)
              ->where('status', 'completed')
              ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah, SUM(total_harga) as total')
              ->groupBy('tanggal')
              ->get();
        } else {
            $penjualanData = Pesanan::whereMonth('created_at', $bulanIni)
              ->whereYear('created_at', $tahunIni)
              ->where('status', 'completed')
              ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah, SUM(total_harga) as total')
              ->groupBy('tanggal')
              ->get();
        }

        return view('pages.dashboard.laporan', compact('penjualanData'));
    }
}
