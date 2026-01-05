<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Sesuai dengan struktur tabel
    protected $table = 'produk';
    protected $primaryKey = 'produk_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'umkm_id',
        'nama_produk',
        'jenis_produk', // TAMBAHKAN
        'deskripsi',
        'harga',
        'stok',
        'status' // Ganti dari is_active ke status
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'status' => 'string'
    ];

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }

    // Scope untuk produk aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    // Accessor untuk format harga
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Method untuk cek stok
    public function isStokTersedia()
    {
        return $this->stok > 0;
    }

    public function detailPesanan()
{
    return $this->hasMany(DetailPesanan::class, 'produk_id', 'produk_id');
}
}
