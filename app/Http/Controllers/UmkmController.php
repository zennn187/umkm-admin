<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\UmkmPhoto;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query dasar dengan photos
        $umkms = Umkm::with(['photos' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('order');
        }]);

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
            'deskripsi' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB max
        ]);

        try {
            // Simpan data UMKM ke database
            $umkm = Umkm::create([
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

            // Handle upload multiple photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $photoName = time() . '_' . $umkm->umkm_id . '_' . $index . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/umkm-photos', $photoName);

                    UmkmPhoto::create([
                        'umkm_id' => $umkm->umkm_id,
                        'photo_path' => $photoName,
                        'photo_name' => $photo->getClientOriginalName(),
                        'order' => $index,
                        'is_primary' => $index === 0 // Jadikan foto pertama sebagai primary
                    ]);
                }
            }

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
        // Ambil data dari database dengan photos
        $umkm = Umkm::with('photos')->findOrFail($id);

        return view('pages.umkm.show', compact('umkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data dari database dengan photos
        $umkm = Umkm::with('photos')->findOrFail($id);

        return view('pages.umkm.edit', compact('umkm'));
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
            'deskripsi' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'delete_photos' => 'nullable|array'
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

            // Handle delete photos
            if ($request->has('delete_photos')) {
                foreach ($request->delete_photos as $photoId) {
                    $photo = UmkmPhoto::find($photoId);
                    if ($photo) {
                        // Hapus file dari storage
                        if (Storage::exists('public/umkm-photos/' . $photo->photo_path)) {
                            Storage::delete('public/umkm-photos/' . $photo->photo_path);
                        }
                        // Hapus dari database
                        $photo->delete();
                    }
                }
            }

            // Handle upload new photos
            if ($request->hasFile('photos')) {
                $existingPhotosCount = $umkm->photos()->count();

                foreach ($request->file('photos') as $index => $photo) {
                    $photoName = time() . '_' . $umkm->umkm_id . '_' . ($existingPhotosCount + $index) . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/umkm-photos', $photoName);

                    UmkmPhoto::create([
                        'umkm_id' => $umkm->umkm_id,
                        'photo_path' => $photoName,
                        'photo_name' => $photo->getClientOriginalName(),
                        'order' => $existingPhotosCount + $index,
                        'is_primary' => $existingPhotosCount === 0 && $index === 0 // Jadikan primary jika belum ada foto
                    ]);
                }
            }

            // Handle set primary photo
            if ($request->has('primary_photo')) {
                // Reset semua primary
                UmkmPhoto::where('umkm_id', $umkm->umkm_id)->update(['is_primary' => false]);

                // Set primary baru
                $primaryPhoto = UmkmPhoto::find($request->primary_photo);
                if ($primaryPhoto) {
                    $primaryPhoto->update(['is_primary' => true]);
                }
            }

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
            $umkm = Umkm::with('photos')->findOrFail($id);

            // Hapus semua photos
            foreach ($umkm->photos as $photo) {
                if (Storage::exists('public/umkm-photos/' . $photo->photo_path)) {
                    Storage::delete('public/umkm-photos/' . $photo->photo_path);
                }
            }

            $umkm->delete();

            return redirect()->route('umkm.index')
                            ->with('success', 'Data UMKM berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * API untuk menghapus photo
     */
    public function deletePhoto($photoId)
    {
        try {
            $photo = UmkmPhoto::findOrFail($photoId);

            // Hapus file dari storage
            if (Storage::exists('public/umkm-photos/' . $photo->photo_path)) {
                Storage::delete('public/umkm-photos/' . $photo->photo_path);
            }

            $photo->delete();

            return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus foto'], 500);
        }
    }
}
