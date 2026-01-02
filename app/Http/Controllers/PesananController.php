<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Umkm;
use App\Models\Warga;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Query dasar dengan relasi
    $pesanans = Pesanan::with(['umkm', 'warga']);

    // Fitur Search
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $pesanans->where(function($query) use ($search) {
            $query->where('nomor_pesanan', 'like', "%{$search}%")
                  ->orWhere('alamat_kirim', 'like', "%{$search}%")
                  ->orWhereHas('umkm', function($q) use ($search) {
                      $q->where('nama_umkm', 'like', "%{$search}%");
                  })
                  ->orWhereHas('warga', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
        });
    }

    // Fitur Filter Status
    if ($request->has('status') && $request->status != '') {
        $pesanans->where('status', $request->status);
    }

    // Filter berdasarkan user role
    if (auth()->user()->role === 'mitra') {
        // Mitra hanya lihat pesanan untuk UMKM miliknya
        $pesanans->whereHas('umkm', function($query) {
            $query->where('user_id', auth()->id());
        });
    } elseif (auth()->user()->role === 'user') {
        // User biasa hanya lihat pesanan sendiri (berdasarkan warga_id)
        $pesanans->where('warga_id', auth()->id());
    }

    // Ambil pesanan terbaru dengan pagination
    $pesanans = $pesanans->orderBy('created_at', 'desc')->paginate(10);

    // Tambahkan parameter request ke pagination
    $pesanans->appends($request->all());

    return view('pages.pesanan.index', compact('pesanans'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data untuk dropdown
        $wargas = Warga::where('status', 'active')->get();
        $umkms = Umkm::where('status', 'active')->get();

        return view('pages.pesanan.create', compact('wargas', 'umkms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'umkm_id' => 'required|exists:umkm,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Baru,Diproses,Dikirim,Selesai,Dibatalkan',
            'alamat_kirim' => 'required|string',
            'detail_pesanan' => 'nullable|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'metode_bayar' => 'required|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate nomor pesanan
        $validated['nomor_pesanan'] = Pesanan::generateNomorPesanan();

        // Handle upload bukti bayar
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti_bayar', $fileName, 'public');
            $validated['bukti_bayar'] = $fileName;
        }

        // Simpan pesanan
        Pesanan::create($validated);

        return redirect()->route('pesanan.index')
                        ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['umkm', 'warga'])->findOrFail($id);
        return view('pages.pesanan.show', compact('pesanan'));
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
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->update(['status' => $request->status]);

            return redirect()->route('pesanan.show', $id)
                            ->with('success', 'Status pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Upload bukti bayar
     */
    public function uploadBuktiBayar(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $pesanan = Pesanan::findOrFail($id);

            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('bukti_bayar', $fileName, 'public');

                $pesanan->update([
                    'bukti_bayar' => $fileName,
                    'status' => 'Diproses' // Otomatis ubah status setelah upload bukti
                ]);
            }

            return redirect()->route('pesanan.show', $id)
                            ->with('success', 'Bukti bayar berhasil diupload!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal upload bukti bayar: ' . $e->getMessage());
        }
    }

    // Method lainnya tetap sama...
    public function baru(Request $request)
    {
        $pesanans = Pesanan::with(['umkm', 'warga'])->where('status', 'Baru');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $pesanans->where(function($query) use ($search) {
                $query->where('nomor_pesanan', 'like', "%{$search}%")
                      ->orWhereHas('warga', function($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%");
                      });
            });
        }

        $pesanans = $pesanans->orderBy('created_at', 'desc')->paginate(5);
        $pesanans->appends($request->all());

        return view('pages.pesanan.baru', compact('pesanans'));
    }

    public function diproses(Request $request)
    {
        $pesanans = Pesanan::with(['umkm', 'warga'])->where('status', 'Diproses');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $pesanans->where(function($query) use ($search) {
                $query->where('nomor_pesanan', 'like', "%{$search}%")
                      ->orWhereHas('warga', function($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%");
                      });
            });
        }

        $pesanans = $pesanans->orderBy('created_at', 'desc')->paginate(5);
        $pesanans->appends($request->all());

        return view('pages.pesanan.diproses', compact('pesanans'));
    }

    public function selesai(Request $request)
    {
        $pesanans = Pesanan::with(['umkm', 'warga'])->where('status', 'Selesai');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $pesanans->where(function($query) use ($search) {
                $query->where('nomor_pesanan', 'like', "%{$search}%")
                      ->orWhereHas('warga', function($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%");
                      });
            });
        }

        $pesanans = $pesanans->orderBy('created_at', 'desc')->paginate(5);
        $pesanans->appends($request->all());

        return view('pages.pesanan.selesai', compact('pesanans'));
    }
}
