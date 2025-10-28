<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Display pengaturan sistem
     */
    public function index()
    {
        return view('pengaturan.index');
    }
}
