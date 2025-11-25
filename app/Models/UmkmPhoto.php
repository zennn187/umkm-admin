<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmPhoto extends Model
{
    use HasFactory;

    protected $primaryKey = 'photo_id';
    protected $table = 'umkm_photos';

    protected $fillable = [
        'umkm_id',
        'photo_path',
        'photo_name',
        'order',
        'is_primary'
    ];

    /**
     * Relasi ke model UMKM
     */
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }

    /**
     * Accessor untuk URL foto
     */
    public function getPhotoUrlAttribute()
    {
        return asset('storage/umkm-photos/' . $this->photo_path);
    }

    /**
     * Scope untuk foto utama
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope untuk mengurutkan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }
}
