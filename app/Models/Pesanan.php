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
        'customer',
        'total',
        'status',
        'alamat_kirim',
        'rt',
        'rw',
        'metode_bayar'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

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
}
