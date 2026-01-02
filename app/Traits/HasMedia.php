<?php

namespace App\Traits;

use App\Models\Media;

trait HasMedia
{
    /**
     * Relasi ke media
     */
    public function media()
    {
        $modelClass = class_basename($this);
        $tableName = strtolower($modelClass) . 's'; // contoh: Umkm -> 'umkms'

        return $this->morphMany(Media::class, 'mediaable', 'ref_table', 'ref_id')
                    ->where('ref_table', $tableName)
                    ->orderBy('order')
                    ->orderBy('created_at');
    }

    /**
     * Relasi ke featured media
     */
    public function featuredMedia()
    {
        return $this->media()->where('is_featured', true);
    }

    /**
     * Relasi ke image media
     */
    public function images()
    {
        return $this->media()->where('mime_type', 'like', 'image/%');
    }

    /**
     * Tambah media baru
     */
    public function addMedia($file, $data = [])
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        // Generate nama file unik
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $path = 'uploads/' . $this->getTable() . '/' . date('Y/m/d');

        // Simpan file
        $filePath = $file->storeAs($path, $fileName, 'public');

        // Simpan ke database
        return $this->media()->create(array_merge([
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_path' => $filePath,
            'mime_type' => $mimeType,
            'file_size' => $size,
            'ref_table' => $this->getTable(),
            'ref_id' => $this->getKey(),
        ], $data));
    }

    /**
     * Hapus semua media
     */
    public function clearMedia()
    {
        foreach ($this->media as $media) {
            $media->delete();
        }
    }

    /**
     * Set featured image
     */
    public function setFeaturedMedia($mediaId)
    {
        // Reset semua featured
        $this->media()->update(['is_featured' => false]);

        // Set featured baru
        return $this->media()->where('media_id', $mediaId)->update(['is_featured' => true]);
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageAttribute()
    {
        $featured = $this->featuredMedia()->first();

        if ($featured) {
            return $featured->file_url;
        }

        // Coba ambil gambar pertama
        $firstImage = $this->images()->first();

        return $firstImage ? $firstImage->file_url : asset('images/default-placeholder.png');
    }
}
