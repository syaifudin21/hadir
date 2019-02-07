<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuratIzinController extends Controller
{
    public function store()
    {
        $izin = new SuratIzin();
        $izin->fill($request->all());
        $izin->save();
        return back()->with('success', 'Berhasil Menambahkan Gagal Absen');
    }
}
