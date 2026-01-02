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
        'pemilik_warga_id',
        'alamat',
        'rt',
        'rw',
        'kategori',
        'kontak',
        'deskripsi',
    ];

    // Relasi ke User (pemilik)
    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_warga_id', 'id');
    }

    // Relasi ke Media
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'umkm_id')
                    ->where('ref_table', 'umkm');
    }

    // Accessor untuk nama pemilik
    public function getNamaPemilikAttribute()
    {
        return $this->pemilik ? $this->pemilik->name : 'Tidak diketahui';
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_usaha', 'like', '%'.$search.'%')
                    ->orWhere('alamat', 'like', '%'.$search.'%')
                    ->orWhere('kategori', 'like', '%'.$search.'%')
                    ->orWhere('kontak', 'like', '%'.$search.'%')
                    ->orWhereHas('pemilik', function($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
    }
}
