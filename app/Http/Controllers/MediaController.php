<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Upload file ke server
     */
    public function upload(Request $request)
    {
        // Validasi
        $request->validate([
            'file' => 'required|file|max:5120', // Maksimal 5MB
            'ref_table' => 'required|string',
            'ref_id' => 'required|integer',
        ]);

        try {
            $file = $request->file('file');

            // Generate nama file unik
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;

            // Simpan file ke storage
            $path = $file->storeAs('uploads', $filename, 'public');

            // Hitung sort_order (jumlah media untuk ref_table + ref_id ini + 1)
            $sortOrder = Media::where('ref_table', $request->ref_table)
                            ->where('ref_id', $request->ref_id)
                            ->count();

            // Simpan ke database (SESUAI STRUKTUR DATABASE TEMAN)
            $media = Media::create([
                'ref_table' => $request->ref_table, // contoh: 'umkm', 'produk', 'artikel'
                'ref_id' => $request->ref_id, // contoh: 1, 2, 3
                'file_name' => $filename, // HANYA nama file, tanpa path
                'caption' => $request->caption ?? '',
                'mime_type' => $file->getMimeType(),
                'sort_order' => $sortOrder,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload',
                'data' => [
                    'media_id' => $media->media_id,
                    'file_name' => $media->file_name,
                    'caption' => $media->caption,
                    'mime_type' => $media->mime_type,
                    'sort_order' => $media->sort_order,
                    'file_url' => $media->file_url, // dari accessor
                    'extension' => $media->extension, // dari accessor
                    'is_image' => $media->is_image, // dari accessor
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus media
     */
    public function destroy($id)
    {
        try {
            $media = Media::findOrFail($id);

            // Hapus file dari storage
            Storage::disk('public')->delete('uploads/' . $media->file_name);

            // Hapus dari database
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Media berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update caption media
     */
    public function updateCaption(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255'
        ]);

        try {
            $media = Media::findOrFail($id);
            $media->update([
                'caption' => $request->caption
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Caption berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui caption: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update sort_order (untuk mengatur urutan/featured)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'media_ids' => 'required|array',
            'media_ids.*' => 'integer|exists:media,media_id',
            'featured_id' => 'nullable|integer|exists:media,media_id'
        ]);

        try {
            // Update sort_order untuk semua media
            foreach ($request->media_ids as $index => $mediaId) {
                Media::where('media_id', $mediaId)->update([
                    'sort_order' => $index
                ]);
            }

            // Jika ada featured image, set sort_order ke 0
            if ($request->has('featured_id')) {
                Media::where('media_id', $request->featured_id)->update([
                    'sort_order' => 0
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan media berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()
            ], 500);
        }
    }
}
