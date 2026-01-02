<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $primaryKey = 'media_id';
    public $timestamps = true;

    protected $fillable = [
        'ref_table', // TIDAK ADA 'file_path' di sini
        'ref_id',
        'file_name',
        'caption',
        'mime_type',
        'sort_order'
        // TIDAK ADA: file_path, file_size, original_name, is_featured
    ];

    protected $appends = [
        'file_url',
        'is_image'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    /**
     * Relasi polymorphic
     */
    public function mediaable()
    {
        return $this->morphTo(__FUNCTION__, 'ref_table', 'ref_id');
    }

    /**
     * Accessor untuk URL file
     * ASUSMSI: File disimpan dengan nama file di storage/app/public/uploads/
     */
    public function getFileUrlAttribute()
    {
        // Contoh: file disimpan di 'uploads/namafile.jpg'
        $filePath = 'uploads/' . $this->file_name;

        if (Storage::disk('public')->exists($filePath)) {
            return asset('storage/' . $filePath);
        }

        return asset('images/default-placeholder.png');
    }

    /**
     * Cek jika file adalah gambar
     */
    public function getIsImageAttribute()
    {
        return strpos($this->mime_type, 'image') !== false;
    }

    /**
     * Mendapatkan ekstensi file
     */
    public function getExtensionAttribute()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    /**
     * Scope untuk model tertentu
     */
    public function scopeForModel($query, $model, $id = null)
    {
        $query->where('ref_table', $model);

        if ($id) {
            $query->where('ref_id', $id);
        }

        return $query;
    }

    /**
     * Scope untuk urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Tidak ada featured image karena tidak ada kolom is_featured
     * Gunakan sort_order=0 atau logic lain untuk menentukan gambar utama
     */
    public function isFeatured()
    {
        return $this->sort_order === 0;
    }
}
