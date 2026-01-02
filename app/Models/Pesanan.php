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
        'umkm_id',        // sudah benar ada
        'total',
        'status',
        'alamat_kirim',
        'rt',
        'rw',
        'metode_bayar',
        'bukti_bayar'     // sudah ada (perbaiki typo jika perlu)
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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

    // Method untuk generate nomor pesanan
    public static function generateNomorPesanan()
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $lastOrder = self::where('nomor_pesanan', 'like', $prefix . $date . '%')->latest()->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->nomor_pesanan, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }

    // Accessor untuk nama customer
    public function getCustomerNameAttribute()
    {
        return $this->warga ? $this->warga->nama : 'Tidak Diketahui';
    }
}
