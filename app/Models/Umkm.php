<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';
    protected $primaryKey = 'umkm_id';

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

    protected $casts = [
        'umkm_id' => 'integer'
    ];
}
