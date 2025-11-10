<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
      public function index()
    {

        // Data pegawai
        $pegawai = [
            'name' => 'Oza Okta Gistrada',
            'birth_date' => '2005-10-24',
            'hobbies' => ['Badminton', 'Futsak', 'Travelling', 'Denger Lagu', 'Nonton film'],
            'tgl_harus_wisuda' => '2028-06-01',
            'current_semester' => 3,
            'future_goal' => 'Menjadi seorang Full Stack Developer'
        ];

        $ulangtahun = Carbon::parse($pegawai['birth_date']);
        $umur = $ulangtahun->age;

        $tanggalKelulusan = Carbon::parse($pegawai['tgl_harus_wisuda']);
        $selisihHari = $tanggalKelulusan->diffInDays(Carbon::now());

        $Pesan = $pegawai['current_semester'] < 3
        ? 'Masih Awal, Kejar TAK!'
        : 'Jangan main-main, kurang-kurangi main game!';

        $data = [
            'name' => $pegawai['name'],
            'my_age' => $umur,
            'hobbies' => $pegawai['hobbies'],
            'tgl_harus_wisuda' => $pegawai['tgl_harus_wisuda'],
            'time_to_study_left' => $tanggalKelulusan,
            'current_semester' => $pegawai['current_semester'],
            'Pesan' => $Pesan,
            'future_goal' => $pegawai['future_goal'],
        ];


        return view('pegawai', compact('pegawai','data'));
        }
}
