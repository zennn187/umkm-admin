<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil pesanan terbaru dengan pagination
        $pesanans = Pesanan::orderBy('created_at', 'desc')->paginate(10);

        return view('pages.pesanan.index', compact('pesanans'));
    }

    /**
     * Display pesanan baru
     */
   public function baru()
{
    $pesanans = Pesanan::where('status', 'Baru')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

    return view('pages.pesanan.baru', compact('pesanans'));
}

public function diproses()
{
    $pesanans = Pesanan::where('status', 'Diproses')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

    return view('pages.pesanan.diproses', compact('pesanans'));
}

public function selesai()
{
    $pesanans = Pesanan::where('status', 'Selesai')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

    return view('pages.pesanan.selesai', compact('pesanans'));
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data pesanan dari database
        $pesanan = Pesanan::findOrFail($id);

        return view('pesanan.show', compact('pesanan'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Baru,Diproses,Dikirim,Selesai,Dibatalkan'
        ]);

        try {
            // Update status pesanan
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->update([
                'status' => $request->status
            ]);

            return redirect()->route('pesanan.show', $id)
                            ->with('success', 'Status pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Display data pembayaran
     */
    public function pembayaran()
    {
        $pembayarans = [
            [
                'id' => 1,
                'nomor_pesanan' => 'ORD-0012',
                'customer' => 'Ahmad Rizki',
                'jumlah' => 125000,
                'status' => 'Menunggu Konfirmasi',
                'metode' => 'Transfer Bank',
                'tanggal' => '2024-01-20 14:35:00'
            ],
            [
                'id' => 2,
                'nomor_pesanan' => 'ORD-0011',
                'customer' => 'Sari Dewi',
                'jumlah' => 75000,
                'status' => 'Lunas',
                'metode' => 'COD',
                'tanggal' => '2024-01-19 10:15:00'
            ]
        ];

        return view('pembayaran.index', compact('pembayarans'));
    }
}
