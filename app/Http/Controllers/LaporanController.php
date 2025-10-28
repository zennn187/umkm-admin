<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display laporan penjualan
     */
    public function penjualan()
    {
        $data = [
            'total_penjualan' => 12500000,
            'total_pesanan' => 45,
            'rata_rata_transaksi' => 277778,
            'periode' => 'Januari 2024'
        ];

        return view('laporan.penjualan', compact('data'));
    }

    /**
     * Display laporan produk
     */
    public function produk()
    {
        $produkTerlaris = [
            ['nama' => 'Kue Lapis Lazuli', 'terjual' => 45, 'pendapatan' => 2250000],
            ['nama' => 'Marlong', 'terjual' => 38, 'pendapatan' => 570000],
            ['nama' => 'Minyak Urut', 'terjual' => 32, 'pendapatan' => 1920000],
            ['nama' => 'Sabun Bolong', 'terjual' => 28, 'pendapatan' => 840000]
        ];

        return view('laporan.produk', compact('produkTerlaris'));
    }

    /**
     * Display laporan UMKM
     */
    public function umkm()
    {
        $umkmStats = [
            ['nama' => 'Kantin PCR', 'produk' => 15, 'penjualan' => 4500000, 'rating' => 4.8],
            ['nama' => 'UMKM PCR', 'produk' => 8, 'penjualan' => 1200000, 'rating' => 4.6],
            ['nama' => 'Toko Budet', 'produk' => 6, 'penjualan' => 2800000, 'rating' => 4.7],
            ['nama' => 'UMKM UNILAK', 'produk' => 5, 'penjualan' => 950000, 'rating' => 4.2]
        ];

        return view('laporan.umkm', compact('umkmStats'));
    }
}
