<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $primaryKey = 'umkm_id';
    protected $table = 'umkm';

    protected $fillable = [
        'nama_usaha',
        'pemilik_warga_id',
        'pemilik',
        'alamat',
        'rt',
        'rw',
        'kategori',
        'kontak',
        'deskripsi',
        'status'
    ];

    /**
     * Relasi ke photos
     */
    public function photos()
    {
        return $this->hasMany(UmkmPhoto::class, 'umkm_id', 'umkm_id')->ordered();
    }

    /**
     * Relasi ke photo utama
     */
    public function primaryPhoto()
    {
        return $this->hasOne(UmkmPhoto::class, 'umkm_id', 'umkm_id')->primary();
    }

    /**
     * Accessor untuk foto utama
     */
    public function getPrimaryPhotoUrlAttribute()
    {
        $primaryPhoto = $this->primaryPhoto;
        if ($primaryPhoto) {
            return asset('storage/umkm-photos/' . $primaryPhoto->photo_path);
        }

        $firstPhoto = $this->photos->first();
        return $firstPhoto ? $firstPhoto->photo_url : asset('images/default-umkm.jpg');
    }

    /**
     * Mutator untuk kategori
     */
    public function setKategoriAttribute($value)
    {
        $this->attributes['kategori'] = ucfirst($value);
    }
}
