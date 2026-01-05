<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';
    protected $primaryKey = 'umkm_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_usaha',
        'pemilik_warga_id', // HARUSNYA relasi ke Warga, bukan User
        'alamat',
        'rt',
        'rw',
        'kategori',
        'kontak',
        'deskripsi',
    ];

    // ⚠️ PERBAIKI: Relasi ke Warga (bukan User)
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'pemilik_warga_id', 'warga_id');
    }

    // Relasi ke Media
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'umkm_id')
                    ->where('ref_table', 'umkm');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->hasMany(Produk::class, 'umkm_id', 'umkm_id');
    }

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'umkm_id', 'umkm_id');
    }

    // Accessor untuk nama pemilik
    public function getNamaPemilikAttribute()
    {
        return $this->warga ? $this->warga->name : 'Tidak diketahui'; // warga->name bukan pemilik->name
    }

    // Accessor untuk nomor telepon pemilik
    public function getTelpPemilikAttribute()
    {
        return $this->warga ? $this->warga->telp : '-';
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_usaha', 'like', '%'.$search.'%')
                    ->orWhere('alamat', 'like', '%'.$search.'%')
                    ->orWhere('kategori', 'like', '%'.$search.'%')
                    ->orWhere('kontak', 'like', '%'.$search.'%')
                    ->orWhereHas('warga', function($q) use ($search) { // PERBAIKI: warga bukan pemilik
                        $q->where('name', 'like', '%'.$search.'%');
                    });
    }
}
