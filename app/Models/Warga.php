<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    // ⚠️ TAMBAHKAN: Definisikan primary key
    protected $primaryKey = 'warga_id';

    // ⚠️ TAMBAHKAN: Tentukan tipe key (karena bukan auto-increment integer default)
    public $incrementing = true; // biasanya true untuk ID
    public $timestamps = true; // sesuaikan dengan tabel

    protected $fillable = [
        'warga_id', // biasanya ini tidak perlu di fillable karena auto-increment
        'no_ktp',
        'name',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
        'alamat',
        'tanggal_lahir',
    ];

    // Jika ada timestamps di tabel
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
