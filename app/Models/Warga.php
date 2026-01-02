<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga'; // jika nama tabel tidak plural

    protected $fillable = [
        'warga_id',
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
}
