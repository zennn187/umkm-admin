<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Umkm::with('media')
                    ->withCount('media');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhereExists(function ($subQuery) use ($search) {
                      $subQuery->select(DB::raw(1))
                              ->from('warga')
                              ->whereColumn('warga.warga_id', 'umkm.pemilik_warga_id')
                              ->where('warga.name', 'like', "%{$search}%");
                  });
            });
        }

        // Filters
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }

        if ($request->filled('rw')) {
            $query->where('rw', $request->rw);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $umkms = $query->paginate($request->get('per_page', 10))
                      ->withQueryString();

        // Ambil data warga untuk semua umkm di halaman ini
        $wargaIds = $umkms->pluck('pemilik_warga_id')->unique()->toArray();
        $wargas = Warga::whereIn('warga_id', $wargaIds)->get()->keyBy('warga_id');

        // Tambahkan data warga ke setiap umkm
        $umkms->each(function ($umkm) use ($wargas) {
            $umkm->warga_data = $wargas[$umkm->pemilik_warga_id] ?? null;
        });

        $kategories = Umkm::select('kategori')
                         ->whereNotNull('kategori')
                         ->distinct()
                         ->pluck('kategori')
                         ->sort();

        $rtList = Umkm::select('rt')
                      ->whereNotNull('rt')
                      ->distinct()
                      ->pluck('rt')
                      ->sort();

        $rwList = Umkm::select('rw')
                      ->whereNotNull('rw')
                      ->distinct()
                      ->pluck('rw')
                      ->sort();

        return view('pages.umkm.index', compact('umkms', 'kategories', 'rtList', 'rwList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wargas = Warga::orderBy('name')->get();

        $kategories = config('umkm.kategori', [
            'Makanan & Minuman',
            'Fashion',
            'Kerajinan',
            'Jasa',
            'Pertanian',
            'Perdagangan',
            'Lainnya'
        ]);

        return view('pages.umkm.create', compact('wargas', 'kategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'files.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx',
            'captions.*' => 'nullable|string|max:255',
            'featured_image' => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {
            // Create UMKM
            $umkm = Umkm::create($validated);

            // Handle file uploads
            if ($request->hasFile('files')) {
                $featuredIndex = $request->featured_image ?? 0;

                foreach ($request->file('files') as $index => $file) {
                    // Generate unique filename
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME))
                                . '_' . time() . '_' . Str::random(6)
                                . '.' . $extension;

                    // Store file
                    $path = $file->storeAs('media/umkm/' . date('Y/m'), $filename, 'public');

                    // Create media record
                    $media = $umkm->media()->create([
                        'file_name' => $filename,
                        'original_name' => $originalName,
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'caption' => $request->captions[$index] ?? null,
                        'extension' => $extension,
                        'order' => $index,
                        'is_featured' => ($index == $featuredIndex),
                        'disk' => 'public',
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('umkm.index')
                ->with('success', 'UMKM berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded files if transaction fails
            if (isset($umkm) && $umkm->media) {
                foreach ($umkm->media as $media) {
                    Storage::disk('public')->delete($media->file_path);
                }
            }

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Umkm $umkm)
    {
        $umkm->load(['media' => function($query) {
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('order')
                  ->orderBy('created_at', 'desc');
        }]);

        // Ambil data warga terkait
        $warga = Warga::find($umkm->pemilik_warga_id);

        // Increment view count
        $umkm->increment('views');

        return view('pages.umkm.show', compact('umkm', 'warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Umkm $umkm)
    {
        $umkm->load(['media' => function($query) {
            $query->orderBy('order')->orderBy('created_at');
        }]);

        $wargas = Warga::orderBy('name')->get();

        $kategories = config('umkm.kategori', [
            'Makanan & Minuman',
            'Fashion',
            'Kerajinan',
            'Jasa',
            'Pertanian',
            'Perdagangan',
            'Lainnya'
        ]);

        return view('pages.umkm.edit', compact('umkm', 'wargas', 'kategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'files.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx',
            'captions' => 'nullable|array',
            'new_captions.*' => 'nullable|string|max:255',
            'delete_media' => 'nullable|array',
            'reorder_media' => 'nullable|array',
            'featured_image' => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {
            // Update UMKM
            $umkm->update($validated);

            // Handle media deletion
            if ($request->has('delete_media')) {
                foreach ($request->delete_media as $mediaId) {
                    $media = Media::where('media_id', $mediaId)
                                 ->where('ref_table', 'umkm')
                                 ->where('ref_id', $umkm->umkm_id)
                                 ->first();

                    if ($media) {
                        // Delete physical file
                        Storage::disk($media->disk)->delete($media->file_path);
                        // Delete record
                        $media->delete();
                    }
                }
            }

            // Update captions for existing media
            if ($request->has('captions')) {
                foreach ($request->captions as $mediaId => $caption) {
                    Media::where('media_id', $mediaId)
                         ->where('ref_table', 'umkm')
                         ->where('ref_id', $umkm->umkm_id)
                         ->update(['caption' => $caption]);
                }
            }

            // Update featured image
            if ($request->has('featured_image')) {
                // Reset all featured
                $umkm->media()->update(['is_featured' => false]);

                // Set new featured
                Media::where('media_id', $request->featured_image)
                     ->where('ref_table', 'umkm')
                     ->where('ref_id', $umkm->umkm_id)
                     ->update(['is_featured' => true]);
            }

            // Reorder media
            if ($request->has('reorder_media')) {
                foreach ($request->reorder_media as $order => $mediaId) {
                    Media::where('media_id', $mediaId)
                         ->where('ref_table', 'umkm')
                         ->where('ref_id', $umkm->umkm_id)
                         ->update(['order' => $order]);
                }
            }

            // Add new files
            if ($request->hasFile('files')) {
                $currentMediaCount = $umkm->media()->count();

                foreach ($request->file('files') as $index => $file) {
                    // Generate unique filename
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME))
                                . '_' . time() . '_' . Str::random(6)
                                . '.' . $extension;

                    // Store file
                    $path = $file->storeAs('media/umkm/' . date('Y/m'), $filename, 'public');

                    // Create media record
                    $media = $umkm->media()->create([
                        'file_name' => $filename,
                        'original_name' => $originalName,
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'caption' => $request->new_captions[$index] ?? null,
                        'extension' => $extension,
                        'order' => $currentMediaCount + $index,
                        'is_featured' => false,
                        'disk' => 'public',
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('umkm.index')
                ->with('success', 'UMKM berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Umkm $umkm)
    {
        DB::beginTransaction();

        try {
            // Delete all media files
            foreach ($umkm->media as $media) {
                Storage::disk($media->disk)->delete($media->file_path);
            }

            // Delete UMKM record
            $umkm->delete();

            DB::commit();

            return redirect()
                ->route('umkm.index')
                ->with('success', 'UMKM berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal menghapus UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Get UMKM data for API/JSON
     */
    public function apiIndex(Request $request)
    {
        $query = Umkm::with('media');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_usaha', 'like', "%{$request->search}%");
        }

        $umkms = $query->orderBy('nama_usaha')->get();

        // Ambil data warga untuk semua umkm
        $wargaIds = $umkms->pluck('pemilik_warga_id')->unique()->toArray();
        $wargas = Warga::whereIn('warga_id', $wargaIds)->get()->keyBy('warga_id');

        // Tambahkan data warga ke setiap umkm
        $umkms->each(function ($umkm) use ($wargas) {
            $umkm->warga_data = $wargas[$umkm->pemilik_warga_id] ?? null;
        });

        return response()->json([
            'success' => true,
            'data' => $umkms,
            'count' => $umkms->count()
        ]);
    }

    /**
     * Export UMKM data
     */
    public function export(Request $request)
    {
        $umkms = Umkm::with('media')->get();

        // Ambil data warga untuk semua umkm sekaligus
        $wargaIds = $umkms->pluck('pemilik_warga_id')->unique()->toArray();
        $wargas = Warga::whereIn('warga_id', $wargaIds)->get()->keyBy('warga_id');

        if ($request->wantsJson()) {
            $umkms->each(function ($umkm) use ($wargas) {
                $umkm->warga_data = $wargas[$umkm->pemilik_warga_id] ?? null;
            });
            return response()->json($umkms);
        }

        // CSV Export
        $fileName = 'umkm-export-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($umkms, $wargas) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'ID', 'Nama Usaha', 'Pemilik', 'Alamat', 'RT', 'RW',
                'Kategori', 'Kontak', 'Deskripsi', 'Dibuat'
            ]);

            // Data
            foreach ($umkms as $umkm) {
                $warga = $wargas[$umkm->pemilik_warga_id] ?? null;

                fputcsv($file, [
                    $umkm->umkm_id,
                    $umkm->nama_usaha,
                    $warga->name ?? '-',
                    $umkm->alamat,
                    $umkm->rt,
                    $umkm->rw,
                    $umkm->kategori,
                    $umkm->kontak,
                    $umkm->deskripsi,
                    $umkm->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show UMKM map view
     */
    public function map(Request $request)
    {
        $umkms = Umkm::whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->get();

        // Ambil data warga terkait
        $wargaIds = $umkms->pluck('pemilik_warga_id')->unique()->toArray();
        $wargas = Warga::whereIn('warga_id', $wargaIds)->get()->keyBy('warga_id');

        // Tambahkan data warga ke setiap umkm
        $umkms->each(function ($umkm) use ($wargas) {
            $umkm->warga_data = $wargas[$umkm->pemilik_warga_id] ?? null;
        });

        return view('pages.umkm.map', compact('umkms'));
    }

    /**
     * Delete a single media
     */
    public function deleteMedia(Umkm $umkm, $mediaId)
    {
        $media = Media::where('media_id', $mediaId)
                     ->where('ref_table', 'umkm')
                     ->where('ref_id', $umkm->umkm_id)
                     ->firstOrFail();

        Storage::disk($media->disk)->delete($media->file_path);
        $media->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
