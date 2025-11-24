<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Umkm;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data dari database dengan relasi UMKM + pagination
        $produks = Produk::with('umkm')->paginate(10); // ⬅ PAGINATION

        return view('pages.produk.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data UMKM untuk dropdown
        $umkms = Umkm::where('status', 'Aktif')->get();

        return view('pages.produk.create', compact('umkms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:Tersedia,Habis,Preorder'
        ]);

        try {
            Produk::create([
                'nama_produk' => $request->nama_produk,
                'umkm_id' => $request->umkm_id,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'status' => $request->status
            ]);

            return redirect()->route('produk.index')
                            ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menyimpan produk: ' . $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = Produk::with('umkm')->findOrFail($id);

        return view('pages.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $umkms = Umkm::where('status', 'Aktif')->get();

        return view('pages.produk.edit', compact('produk', 'umkms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:Tersedia,Habis,Preorder'
        ]);

        try {
            $produk = Produk::findOrFail($id);
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'umkm_id' => $request->umkm_id,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'status' => $request->status
            ]);

            // BUG FIX: route sebelumnya salah
            return redirect()->route('produk.index')
                            ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $produk->delete();

            return redirect()->route('produk.index')
                            ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Display kategori produk
     */
    public function kategori()
    {
        $kategories = [
            ['id' => 1, 'nama' => 'Makanan & Minuman', 'jumlah_produk' => 45],
            ['id' => 2, 'nama' => 'Kerajinan Tangan', 'jumlah_produk' => 23],
            ['id' => 3, 'nama' => 'Fashion', 'jumlah_produk' => 18],
            ['id' => 4, 'nama' => 'Kesehatan & Kecantikan', 'jumlah_produk' => 12]
        ];

        return view('pages.produk.kategori', compact('kategories'));
    }
}
