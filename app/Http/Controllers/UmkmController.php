<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query dasar
        $umkms = Umkm::query();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $umkms->where(function($query) use ($search) {
                $query->where('nama_usaha', 'like', "%{$search}%")
                      ->orWhere('pemilik', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%")
                      ->orWhere('kategori', 'like', "%{$search}%")
                      ->orWhere('kontak', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Status
        if ($request->has('status') && $request->status != '') {
            $umkms->where('status', $request->status);
        }

        // Fitur Filter Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $umkms->where('kategori', $request->kategori);
        }

        // Fitur Filter RT
        if ($request->has('rt') && $request->rt != '') {
            $umkms->where('rt', $request->rt);
        }

        // Fitur Filter RW
        if ($request->has('rw') && $request->rw != '') {
            $umkms->where('rw', $request->rw);
        }

        // Ambil data dengan pagination
        $umkms = $umkms->orderBy('created_at', 'desc')->paginate(10);

        // Tambahkan parameter request ke pagination
        $umkms->appends($request->all());

        // Ambil daftar kategori unik untuk dropdown
        $kategories = Umkm::select('kategori')->distinct()->pluck('kategori');

        return view('pages.umkm.index', compact('umkms', 'kategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.umkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'deskripsi' => 'required|string'
        ]);

        try {
            // Simpan data ke database
            Umkm::create([
                'nama_usaha' => $request->nama_usaha,
                'pemilik' => $request->pemilik,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kategori' => $request->kategori,
                'kontak' => $request->kontak,
                'deskripsi' => $request->deskripsi,
                'status' => 'Aktif'
            ]);

            return redirect()->route('umkm.index')
                            ->with('success', 'Data UMKM berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data dari database
        $umkm = Umkm::findOrFail($id);

        return view('umkm.show', compact('umkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data dari database
        $umkm = Umkm::findOrFail($id);

        return view('umkm.edit', compact('umkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'deskripsi' => 'required|string'
        ]);

        try {
            // Update data di database
            $umkm = Umkm::findOrFail($id);
            $umkm->update([
                'nama_usaha' => $request->nama_usaha,
                'pemilik' => $request->pemilik,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kategori' => $request->kategori,
                'kontak' => $request->kontak,
                'deskripsi' => $request->deskripsi
            ]);

            return redirect()->route('umkm.index')
                            ->with('success', 'Data UMKM berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Hapus data dari database
            $umkm = Umkm::findOrFail($id);
            $umkm->delete();

            return redirect()->route('umkm.index')
                            ->with('success', 'Data UMKM berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
