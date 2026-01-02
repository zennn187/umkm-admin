<?php
namespace App\Http\Controllers;

class LaporanController extends Controller
{
    /**
     * Display laporan penjualan
     */
    public function penjualan()
    {
        $data = [
            'total_penjualan'     => 12500000,
            'total_pesanan'       => 45,
            'rata_rata_transaksi' => 277778,
            'periode'             => 'Januari 2024',
        ];

        return view('pages.laporan.penjualan', compact('data'));
    }

    /**
     * Display laporan produk
     */
    public function produk()
    {

        $user  = Auth::user();
        $query = Produk::withCount(['pesanan as total_terjual' => function ($q) {
            $q->where('status', 'completed');
        }]);

        if ($user->role === 'mitra') {
            $query->where('user_id', $user->id);
        }

        $produk = $query->orderBy('total_terjual', 'desc')->get();

        $produkTerlaris = [
            ['nama' => 'Kue Lapis Lazuli', 'terjual' => 45, 'pendapatan' => 2250000],
            ['nama' => 'Marlong', 'terjual' => 38, 'pendapatan' => 570000],
            ['nama' => 'Minyak Urut', 'terjual' => 32, 'pendapatan' => 1920000],
            ['nama' => 'Sabun Bolong', 'terjual' => 28, 'pendapatan' => 840000],
        ];

        return view('pages.laporan.penjualan', compact('penjualan', 'startDate', 'endDate', 'produkTerlaris'));
    }

    /**
     * Display laporan UMKM
     */
    public function umkm()
    {

        $user = Auth::user();

        if ($user->role !== 'super_admin' && $user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses laporan UMKM.');
        }

        $umkm = Umkm::with(['user', 'produk'])
            ->withCount(['produk', 'pesanan'])
            ->get();

        $umkmStats = [
            ['nama' => 'Kantin PCR', 'produk' => 15, 'penjualan' => 4500000, 'rating' => 4.8],
            ['nama' => 'UMKM PCR', 'produk' => 8, 'penjualan' => 1200000, 'rating' => 4.6],
            ['nama' => 'Toko Budet', 'produk' => 6, 'penjualan' => 2800000, 'rating' => 4.7],
            ['nama' => 'UMKM UNILAK', 'produk' => 5, 'penjualan' => 950000, 'rating' => 4.2],
        ];

        return view('pages.laporan.umkm', compact('umkm', 'umkmStats'));
    }
}
