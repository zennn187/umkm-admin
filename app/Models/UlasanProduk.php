<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanProduk extends Model
{
    use HasFactory;

    protected $table = 'ulasan_produk';
    protected $primaryKey = 'ulasan_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'produk_id',
        'warga_id',
        'rating',
        'komentar',
        'is_verified',
        'is_visible',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'is_visible' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELASI KE PRODUK
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    // RELASI KE WARGA
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // SCOPES
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByProduk($query, $produkId)
    {
        return $query->where('produk_id', $produkId);
    }

    public function scopeByWarga($query, $wargaId)
    {
        return $query->where('warga_id', $wargaId);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeHighestRating($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    // ACCESSORS
    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }

    public function getShortKomentarAttribute()
    {
        return strlen($this->komentar) > 100
            ? substr($this->komentar, 0, 100) . '...'
            : $this->komentar;
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }
}
