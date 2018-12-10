<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GagalAbsen;

class GagalAbsenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$gagals = GagalAbsen::all();
    	return view('admin.gagalabsen', compact('gagals'));
    }
    public function validasi(Request $request)
    {
      $this->validate($request, [
        'dimensi_waktu' => 'required',
      ]);
    }
    public function store(Request $request)
    {
        $this->validasi($request);
        $kategori = new GagalAbsen();
        $kategori->fill($request->all());
        $kategori->save();
        return back()->with('success', 'Berhasil Menambahkan Gagal Absen');
    }

    public function update(Request $request)
    {
        $this->validasi($request);
        $gagal = GagalAbsen::find($request->id);
        $gagal->fill($request->all());
        $gagal->save();
        return back()->with('success', 'Berhasil Mengupdate Gagal Absen');
    }
    public function delete($id)
    {
        $gagal = GagalAbsen::find($id);
        $gagal->delete();
        return redirect('admin/gagalabsen')->with('success', 'Berhasil Menghapus Gagal Absen');
    }
}
