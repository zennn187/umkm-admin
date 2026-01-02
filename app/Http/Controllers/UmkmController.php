<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
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
        $query = Umkm::with(['pemilik', 'media'])
                    ->withCount('media');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhereHas('pemilik', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $umkms = $query->paginate($request->get('per_page', 10))
                      ->withQueryString();

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
        $users = \App\Models\User::where('role', 'mitra')
                                ->orWhere('role', 'warga')
                                ->orderBy('name')
                                ->get();

        $kategories = config('umkm.kategori', [
            'Makanan & Minuman',
            'Fashion',
            'Kerajinan',
            'Jasa',
            'Pertanian',
            'Perdagangan',
            'Lainnya'
        ]);

return view('pages.umkm.create', compact('users', 'kategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_warga_id' => 'required|integer|exists:users,id',
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'nullable|in:aktif,nonaktif,pending',
            'files.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx',
            'captions.*' => 'nullable|string|max:255',
            'featured_image' => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {
            // Create UMKM
            $umkm = Umkm::create(array_merge($validated, [
                'status' => $validated['status'] ?? 'aktif',
            ]));

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
        $umkm->load(['pemilik', 'media' => function($query) {
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('order')
                  ->orderBy('created_at', 'desc');
        }]);

        // Increment view count
        $umkm->increment('views');

return view('pages.umkm.show', compact('umkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Umkm $umkm)
    {
        $umkm->load(['media' => function($query) {
            $query->orderBy('order')->orderBy('created_at');
        }]);

        $users = \App\Models\User::where('role', 'mitra')
                                ->orWhere('role', 'warga')
                                ->orderBy('name')
                                ->get();

        $kategories = config('umkm.kategori', [
            'Makanan & Minuman',
            'Fashion',
            'Kerajinan',
            'Jasa',
            'Pertanian',
            'Perdagangan',
            'Lainnya'
        ]);

return view('pages.umkm.edit', compact('umkm', 'users', 'kategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_warga_id' => 'required|integer|exists:users,id',
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'nullable|in:aktif,nonaktif,pending',
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
                        'is_featured' => false, // Default not featured
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
     * Toggle UMKM status
     */
    public function toggleStatus(Umkm $umkm)
    {
        $umkm->update([
            'status' => $umkm->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return back()->with('success', 'Status UMKM berhasil diubah.');
    }

    /**
     * Get UMKM data for API/JSON
     */
    public function apiIndex(Request $request)
    {
        $query = Umkm::with(['pemilik', 'media'])
                    ->where('status', 'aktif');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_usaha', 'like', "%{$request->search}%");
        }

        $umkms = $query->orderBy('nama_usaha')->get();

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
        $umkms = Umkm::with(['pemilik', 'media'])->get();

        // You can implement Excel export here using Laravel Excel package
        // For now, return JSON
        if ($request->wantsJson()) {
            return response()->json($umkms);
        }

        // CSV Export
        $fileName = 'umkm-export-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($umkms) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'ID', 'Nama Usaha', 'Pemilik', 'Alamat', 'RT', 'RW',
                'Kategori', 'Kontak', 'Status', 'Dibuat'
            ]);

            // Data
            foreach ($umkms as $umkm) {
                fputcsv($file, [
                    $umkm->umkm_id,
                    $umkm->nama_usaha,
                    $umkm->pemilik->name ?? '-',
                    $umkm->alamat,
                    $umkm->rt,
                    $umkm->rw,
                    $umkm->kategori,
                    $umkm->kontak,
                    $umkm->status,
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
        $umkms = Umkm::where('status', 'aktif')
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->with('pemilik')
                    ->get();

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
