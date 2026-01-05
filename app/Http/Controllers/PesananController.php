<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Warga;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Http\Controllers\Controller;

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

        // Filter RT
        if ($request->has('rt') && $request->rt != '') {
            $pesanans->where('rt', $request->rt);
        }

        // Filter RW
        if ($request->has('rw') && $request->rw != '') {
            $pesanans->where('rw', $request->rw);
        }

        // Filter berdasarkan user role
        if (auth()->check()) {
            if (auth()->user()->role === 'mitra') {
                // Mitra hanya lihat pesanan untuk UMKM miliknya
                $pesanans->whereHas('umkm', function($query) {
                    $query->where('user_id', auth()->id());
                });
            } elseif (auth()->user()->role === 'user') {
                // User biasa hanya lihat pesanan sendiri (berdasarkan warga_id)
                $pesanans->where('warga_id', auth()->id());
            }
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
        $produks = Produk::where('status', 'active')->get();

        return view('pages.pesanan.create', compact('wargas', 'umkms', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'status' => 'required|in:Baru,Diproses,Dikirim,Selesai,Dibatalkan',
            'alamat_kirim' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'metode_bayar' => 'required|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Tambahkan validasi untuk detail pesanan
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produk,produk_id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
        ]);

        try {
            // Generate nomor pesanan
            $nomorPesanan = 'PES-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            // Simpan pesanan utama
            $pesanan = Pesanan::create([
                'nomor_pesanan' => $nomorPesanan,
                'warga_id' => $validated['warga_id'],
                'umkm_id' => $validated['umkm_id'],
                'status' => $validated['status'],
                'alamat_kirim' => $validated['alamat_kirim'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'metode_bayar' => $validated['metode_bayar'],
                'bukti_bayar' => null, // akan diisi jika ada upload
                'total' => 0, // sementara 0, akan dihitung dari detail
            ]);

            // Simpan detail pesanan dan hitung total
            $totalPesanan = 0;

            foreach ($validated['produk_id'] as $index => $produkId) {
                $produk = Produk::find($produkId);
                $quantity = $validated['quantity'][$index];
                $hargaSatuan = $produk->harga;
                $subtotal = $quantity * $hargaSatuan;

                // Simpan detail pesanan
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'produk_id' => $produkId,
                    'quantity' => $quantity,
                    'harga' => $hargaSatuan,
                    'subtotal' => $subtotal
                ]);

                $totalPesanan += $subtotal;

                // Kurangi stok produk
                $produk->decrement('stok', $quantity);
            }

            // Update total pesanan
            $pesanan->update(['total' => $totalPesanan]);

            // Handle upload bukti bayar
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('bukti_bayar', $fileName, 'public');
                $pesanan->update(['bukti_bayar' => 'bukti_bayar/' . $fileName]);
            }

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['umkm', 'warga', 'detail.produk'])->findOrFail($id);
        return view('pages.pesanan.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pesanan = Pesanan::with(['detail'])->findOrFail($id);
        $wargas = Warga::where('status', 'active')->get();
        $umkms = Umkm::where('status', 'active')->get();
        $produks = Produk::where('status', 'active')->get();

        return view('pages.pesanan.edit', compact('pesanan', 'wargas', 'umkms', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'status' => 'required|in:Baru,Diproses,Dikirim,Selesai,Dibatalkan',
            'alamat_kirim' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'metode_bayar' => 'required|string',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hapus_bukti' => 'nullable|boolean',
            'catatan' => 'nullable|string',
        ]);

        try {
            // Update data pesanan
            $pesanan->update([
                'warga_id' => $validated['warga_id'],
                'umkm_id' => $validated['umkm_id'],
                'status' => $validated['status'],
                'alamat_kirim' => $validated['alamat_kirim'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'metode_bayar' => $validated['metode_bayar'],
                'catatan' => $validated['catatan'] ?? $pesanan->catatan,
            ]);

            // Handle bukti bayar
            if ($request->has('hapus_bukti') && $request->hapus_bukti) {
                // Hapus file bukti bayar lama jika ada
                if ($pesanan->bukti_bayar && file_exists(storage_path('app/public/' . $pesanan->bukti_bayar))) {
                    unlink(storage_path('app/public/' . $pesanan->bukti_bayar));
                }
                $pesanan->update(['bukti_bayar' => null]);
            }

            // Upload bukti bayar baru
            if ($request->hasFile('bukti_bayar')) {
                // Hapus file lama jika ada
                if ($pesanan->bukti_bayar && file_exists(storage_path('app/public/' . $pesanan->bukti_bayar))) {
                    unlink(storage_path('app/public/' . $pesanan->bukti_bayar));
                }

                $file = $request->file('bukti_bayar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('bukti_bayar', $fileName, 'public');
                $pesanan->update(['bukti_bayar' => 'bukti_bayar/' . $fileName]);
            }

            // Update detail pesanan jika ada
            if ($request->has('produk_id')) {
                // Hapus detail lama
                DetailPesanan::where('pesanan_id', $pesanan->pesanan_id)->delete();

                // Hitung total baru
                $totalPesanan = 0;

                foreach ($request->produk_id as $index => $produkId) {
                    $produk = Produk::find($produkId);
                    $quantity = $request->quantity[$index];
                    $hargaSatuan = $produk->harga;
                    $subtotal = $quantity * $hargaSatuan;

                    // Simpan detail pesanan baru
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->pesanan_id,
                        'produk_id' => $produkId,
                        'quantity' => $quantity,
                        'harga' => $hargaSatuan,
                        'subtotal' => $subtotal
                    ]);

                    $totalPesanan += $subtotal;
                }

                // Update total pesanan
                $pesanan->update(['total' => $totalPesanan]);
            }

            return redirect()->route('pesanan.show', $pesanan->pesanan_id)
                ->with('success', 'Pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage())
                ->withInput();
        }
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

            return redirect()->route('pesanan.show', $pesanan->pesanan_id)
                ->with('success', 'Status pesanan berhasil diubah menjadi ' . $request->status);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }
public function delete($id)
{
    $pesanan = Pesanan::with(['umkm', 'warga', 'detail.produk'])->findOrFail($id);

    // Tambahkan pengecekan hak akses jika diperlukan
    if (auth()->check()) {
        if (auth()->user()->role === 'mitra') {
            // Mitra hanya bisa hapus pesanan UMKM miliknya
            if ($pesanan->umkm->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus pesanan ini.');
            }
        } elseif (auth()->user()->role === 'user') {
            // User hanya bisa hapus pesanan sendiri
            if ($pesanan->warga_id !== auth()->id()) {
                abort(403, 'Anda hanya bisa menghapus pesanan Anda sendiri.');
            }
        }
    }

    return view('pages.pesanan.delete', compact('pesanan'));
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pesanan = Pesanan::findOrFail($id);

            // Hapus bukti bayar jika ada
            if ($pesanan->bukti_bayar && file_exists(storage_path('app/public/' . $pesanan->bukti_bayar))) {
                unlink(storage_path('app/public/' . $pesanan->bukti_bayar));
            }

            // Hapus detail pesanan
            DetailPesanan::where('pesanan_id', $pesanan->pesanan_id)->delete();

            // Hapus pesanan
            $pesanan->delete();

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
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
                // Hapus file lama jika ada
                if ($pesanan->bukti_bayar && file_exists(storage_path('app/public/' . $pesanan->bukti_bayar))) {
                    unlink(storage_path('app/public/' . $pesanan->bukti_bayar));
                }

                $file = $request->file('bukti_bayar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('bukti_bayar', $fileName, 'public');

                $pesanan->update([
                    'bukti_bayar' => 'bukti_bayar/' . $fileName,
                    'status' => 'Diproses' // Otomatis ubah status setelah upload bukti
                ]);
            }

            return redirect()->route('pesanan.show', $pesanan->pesanan_id)
                ->with('success', 'Bukti bayar berhasil diupload!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal upload bukti bayar: ' . $e->getMessage());
        }
    }

    // Method untuk filter status
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
