<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'pesanan_id';

    protected $fillable = [
        'nomor_pesanan',
        'warga_id',
        'umkm_id',
        'total',
        'status',
        'alamat_kirim',
        'rt',
        'rw',
        'metode_bayar',
        'bukti_bayar',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }

    // Relasi ke DetailPesanan (nama relasi: 'detail' untuk kompatibilitas dengan controller)
    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id', 'pesanan_id');
    }

    // Alias untuk kompatibilitas dengan controller yang menggunakan 'detailPesanan'
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id', 'pesanan_id');
    }

    // Relasi ke produk melalui detail (jika diperlukan)
    public function produk()
    {
        return $this->hasManyThrough(
            Produk::class,
            DetailPesanan::class,
            'pesanan_id', // Foreign key pada DetailPesanan
            'produk_id',  // Foreign key pada Produk
            'pesanan_id', // Local key pada Pesanan
            'produk_id'   // Local key pada DetailPesanan
        );
    }

    // Method untuk generate nomor pesanan
    public static function generateNomorPesanan()
    {
        $date = date('Ymd');
        $lastOrder = self::where('nomor_pesanan', 'like', "PES-{$date}-%")
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->nomor_pesanan, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "PES-{$date}-{$newNumber}";
    }

    // Accessor untuk nama customer - PERBAIKI: warga->name bukan warga->nama
    public function getCustomerNameAttribute()
    {
        return $this->warga ? $this->warga->nama : 'Tidak Diketahui'; // Diubah dari 'name' ke 'nama'
    }

    // Accessor untuk nama UMKM
    public function getNamaUmkmAttribute()
    {
        return $this->umkm ? $this->umkm->nama_umkm : '-'; // Diubah dari 'nama_usaha' ke 'nama_umkm'
    }

    // Accessor untuk format total
    public function getTotalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    // Accessor untuk status dengan warna
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Baru' => 'primary',
            'Diproses' => 'warning',
            'Dikirim' => 'info',
            'Selesai' => 'success',
            'Dibatalkan' => 'danger',
            default => 'secondary'
        };
    }

    // Method untuk hitung total otomatis
    public function calculateTotal()
    {
        return $this->detail()->sum('subtotal');
    }

    // Method untuk update total dari detail
    public function updateTotal()
    {
        $total = $this->detail()->sum('subtotal');
        $this->update(['total' => $total]);
        return $total;
    }

    // Scope untuk status tertentu
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        if (!$search) return $query;

        return $query->where('nomor_pesanan', 'like', '%' . $search . '%')
            ->orWhere('alamat_kirim', 'like', '%' . $search . '%')
            ->orWhereHas('warga', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%'); // Diubah dari 'name' ke 'nama'
            })
            ->orWhereHas('umkm', function ($q) use ($search) {
                $q->where('nama_umkm', 'like', '%' . $search . '%'); // Diubah dari 'nama_usaha' ke 'nama_umkm'
            });
    }

    // Scope untuk filter RT
    public function scopeRt($query, $rt)
    {
        if ($rt) {
            return $query->where('rt', $rt);
        }
        return $query;
    }

    // Scope untuk filter RW
    public function scopeRw($query, $rw)
    {
        if ($rw) {
            return $query->where('rw', $rw);
        }
        return $query;
    }

    // Scope untuk pesanan milik user tertentu
    public function scopeOwnedByUser($query, $userId)
    {
        return $query->whereHas('warga', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // Scope untuk pesanan milik mitra tertentu
    public function scopeOwnedByMitra($query, $userId)
    {
        return $query->whereHas('umkm', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        // Event untuk menghitung total otomatis saat detail berubah
        static::saved(function ($pesanan) {
            $pesanan->updateTotal();
        });
    }
}
